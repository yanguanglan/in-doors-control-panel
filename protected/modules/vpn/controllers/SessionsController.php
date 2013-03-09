<?php

class SessionsController extends Controller
{

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
				'actions'=>array('index', 'kill', 'error'),
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionIndex()
	{
    $model = new VPNSession();
    $dataProvider = new CArrayDataProvider($model->getSessionList(), array(
      'id' => 'sessions',
      'keyField' => 'ifname',
      'pagination' => false,
    ));
		$this->render('index', array(
      'dataProvider' => $dataProvider,
    ));
	}
  
  public function actionKill($ifname)
  {
		if(Yii::app()->request->isPostRequest)
		{
			$model = new VPNSession();
      if ($model->validate()) {
        $model->kill($ifname);
      }

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax'])) {
				$this->redirect(array('index'));
      }
		}
		else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }
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

}