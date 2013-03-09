<?php

/**
 * 
 */
class LogController extends Controller
{
  
  public $defaultAction = 'radius';

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
				'actions'=>array('radius', 'error'),
				'users'=>array('@'),
			),
			array('deny',
				'users'=>array('*'),
			),
		);
	}

	public function actionRadius($lines = RADIUSLog::DEFAULT_LINES_COUNT)
	{
    $this->layout = '//layouts/column1_fluid';

    $model = new RADIUSLog($lines);
    /*
    $dataProvider = new CArrayDataProvider($model->read(), array(
      'id' => 'radiusErrors',
      'keyField' => 'key',
      'pagination' => false,
    ));
    */
    //Yii::trace(CVarDumper::dumpAsString($data));
		$this->render('radius', array(
//      'dataProvider' => $dataProvider,
      'count' => $model->getLinesCount(),
      'data'  => $model->read(),
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

}

?>
