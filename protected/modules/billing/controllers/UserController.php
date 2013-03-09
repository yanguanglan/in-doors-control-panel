<?php

class UserController extends Controller
{
  
  public $defaultAction = 'list';
  
	public function filters()
	{
		return array(
			'accessControl'
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('list', 'info', 'payments', 'error'),
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

  public function actionPayments($id)
  {
    $user = $this->_loadUserModel($id);

    // Полубение информации об архивных таблицах
    $table_names = Yii::app()->dbUTM5->createCommand('SELECT * FROM `archives` WHERE `table_type` = 7 ORDER BY `end_date` DESC')->queryAll();

    $main_sql = '
SELECT
  `t`.`id` AS id,
  `m`.`name` AS method,
  `t`.`payment_absolute` AS pay,
  `t`.`payment_incurrency` AS pay_curr,
  `c`.`currency_brief_name` AS curr,
  `t`.`actual_date` AS actual_date,
  `t`.`payment_enter_date` AS enter_date,
  `t`.`comments_for_user` AS user_comment,
  `t`.`comments_for_admins` AS admin_comment,
  `u`.`login` AS who_receive,
  `t`.`burn_time` AS burn_time,
  `t`.`is_canceled` AS canceled
FROM
  `payment_transactions` `t`
  INNER JOIN `accounts` `a` ON `t`.`account_id` = `a`.`id`
  LEFT JOIN `payment_methods` `m` ON `t`.`method` = `m`.`id`
  LEFT JOIN `currency_list` `c` ON `t`.`currency_id` = `c`.`id`
  LEFT JOIN (SELECT `id`, `login` FROM `system_accounts`
             UNION
             SELECT `id`, `login` FROM `users`) `u` ON `t`.`who_receive` = `u`.`id`
WHERE
  `t`.`account_id` = ' . $user->basic_account . '
';
    $sqls = array();
    $sqls[] = $main_sql;
    foreach ($table_names as $table_name) {
      $sqls[] = str_replace('`payment_transactions`', $table_name['table_name'], $main_sql);
    }
    $union = '
UNION
';
    $sql = implode($union, $sqls);
    
    if (Yii::app()->user->name !== "admin") {
      $sql .= ' LIMIT 1';
    }
    //Yii::trace(CVarDumper::dumpAsString($sql));
    $dataProvider = new CSqlDataProvider($sql, array('pagination'=>false,));
    $dataProvider->db = Yii::app()->dbUTM5;

    $this->render('payments', array(
      'dataProvider' => $dataProvider,
    ));

/**
 * Этот кусок кода не годится, т.к. исходная таблица содержит данные только
 * за последний месяц. Данные за предыдущие месяцы хранятся в другой БД.
    $criteria = new CDbCriteria();
    $criteria->compare('account_id', $user->basic_account);
    $criteria->with = array('paymentMethod', 'currency');

    $dataProvider = new CActiveDataProvider('UTM5PaymentTransactions', array(
      'criteria'   => $criteria,
      'pagination' => array(
        'pageSize' => 20,
      ),
    ));
*/
  }

  public function actionInfo($id)
  {
    $model = $this->_loadUserModel($id);
    Yii::log(
      sprintf(
        "Просматривает пользователя\n id: %s\n login: %s\n name: %s",
        $model->id,
        $model->login,
        $model->full_name
      ),
      'info',
      'volgocom.billing.user.info'
    );
    $this->render('info', array(
      'data' => $model,
    ));
  }

  public function actionList()
  {

    $session = new CHttpSession;
    $session->open();

    // Получение и проверка введённых пользователем данных
    $searchUserFormModel = new SearchUserForm;
    if (isset($_POST['SearchUserForm'])) {
      $searchUserFormModel->attributes = $_POST['SearchUserForm'];
      if ($searchUserFormModel->validate()) {
        // Обновление данных в сессии
        if (!empty($searchUserFormModel['login'])) {
          $session->add('login', $searchUserFormModel['login']);
        }
        else {
          $session->remove('login');
        }
        if (!empty($searchUserFormModel['full_name'])) {
          $session->add('full_name', $searchUserFormModel['full_name']);
        }
        else {
          $session->remove('full_name');
        }
        if (!empty($searchUserFormModel['actual_address'])) {
          $session->add('actual_address', $searchUserFormModel['actual_address']);
        }
        else {
          $session->remove('actual_address');
        }
        if (!empty($searchUserFormModel['ip'])) {
          $session->add('ip', $searchUserFormModel['ip']);
        }
        else {
          $session->remove('ip');
        }
      }
    }

    // Присвоение элементам формы сохранённых в сессии значений предыдущего запроса
    $searchUserFormModel->login = $session->get('login', '');
    $searchUserFormModel->full_name = $session->get('full_name', '');
    $searchUserFormModel->actual_address = $session->get('actual_address', '');
    $searchUserFormModel->ip = $session->get('ip', '');

    // Наложение условий на выборку данных
    $criteria = new CDbCriteria();
    $criteria->order = 'create_date DESC'; // недавно созданные пользователи в начале списка
    $criteria->addSearchCondition('login', $session->get('login', ''));
    $criteria->addSearchCondition('full_name', $session->get('full_name', ''));
    $criteria->addSearchCondition('actual_address', $session->get('actual_address', ''));
    // Обработка поиска по IP
    $session_ip = $session->get('ip', '');
    if (!empty($session_ip)) {
      // Поиск введённого IP
      $ipGroups = UTM5IPGroups::model()->findByIP($session_ip);
      //  Yii::trace(CVarDumper::dumpAsString($ipGroup));
      // Если найдена IP группа
      if ($ipGroups) {
        // Определяем пользователя, за которым закреплена данная IP группа
        $user_id = $ipGroups->iptrafficServiceLink->serviceLink->user->id;
        // Добавляем условие точного совпадения по идентификатору пользователя
        $criteria->compare('id', $user_id);
      }
      else {
        // Условие по несуществующему идентификатору пользователя,
        // что-бы показать пустой результат поиска
        $criteria->compare('id', 0);
      }
    }

    $session->close();

    $dataProvider = new CActiveDataProvider('UTM5Users', array(
      'criteria'   => $criteria,
      'pagination' => array(
        'pageSize' => 50,
      ),
    ));

    $this->render('list', array(
      'dataProvider' => $dataProvider,
      'formModel'    => $searchUserFormModel,
    ));

  }

	public function actionError()
	{
    $error = Yii::app()->errorHandler->error;
		if($error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('application.views.site.error', $error);
		}
	}

  private function _loadUserModel($id)
  {
    $model = UTM5Users::model()->findByPk($id);
    if($model === null) {
      throw new CHttpException(404, 'The requested page does not exist.');
    }
    return $model;
  }

}