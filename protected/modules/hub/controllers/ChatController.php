<?php

class ChatController extends Controller
{
  public $defaultAction = 'history';

	public function actionHistory()
	{
		$model = new Hub('search');
		$model->unsetAttributes();
		if(isset($_GET['Hub']))
			$model->attributes = $_GET['Hub'];

		$this->render('history',array(
			'model'=>$model,
		));
	}

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
				'actions'=>array('history', 'error'),
				'users'=>array('@'),
			),
			array('allow',
				'actions'=>array('update', 'delete'),
				'users'=>array('admin'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

    $model->ip = long2ip($model->ip);
    $model->date = Yii::app()->dateFormatter->format("yyyy-MM-dd&nb's'p;HH:mm:ss", $model->date);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Hub']))
		{
			$model->msg = $_POST['Hub']['msg'];
			if($model->save(true, array('msg'))) {
  		  $this->redirect(array('index'));
      }
		}

		$this->render('update', array(
			'model'=>$model,
		));
	}

  public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}

	public function loadModel($id)
	{
		$model=Hub::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404, 'Запрашиваемая страница не существует.');
		return $model;
	}

}