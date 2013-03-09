<?php

class SiteController extends Controller
{

	public function filters()
	{
		return array(
			'accessControl'
		);
	}

	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function accessRules()
	{
		return array(
			array('allow',
				'actions'=>array('login', 'logout', 'error', 'captcha'),
				'users'=>array('*'),
			),
			array('allow',
				'actions'=>array('index', 'page'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('contact'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		// renders the view file 'protected/views/site/index.php'
		// using the default layout 'protected/views/layouts/main.php'
		$this->render('index');
	}

	/**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
      $ip = Yii::app()->request->getUserHostAddress();
      $requestUri = Yii::app()->request->getRequestUri();
      Yii::log('Ошибка '.$error['code'].': '.$error['message']."\n IP: ".$ip."\n Запрос: ".$requestUri, 'error', 'volgocom.site.error');
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	/**
	 * Displays the login page
	 */
	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {
        $ip = Yii::app()->request->getUserHostAddress();
        Yii::log("Вошёл в систему\n IP: ".$ip, 'info', 'volgocom.site.login');
				$this->redirect(Yii::app()->user->returnUrl);
      }
      else {
        Yii::log(
          sprintf(
            "Неудавшаяся попытка входа\n username: %s\n password: %s",
            $_POST['LoginForm']['username'],
            $_POST['LoginForm']['password']
          ),
          'warning',
          'volgocom.site.login'
        );
      }
		}
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	/**
	 * Logs out the current user and redirect to homepage.
	 */
	public function actionLogout()
	{
    Yii::log('Вышел из системы', 'info', 'volgocom.site.logout');
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}