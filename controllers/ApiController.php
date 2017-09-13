<?php
/**
 * Created by PhpStorm.
 * User: guoxiaosong
 * Date: 2017/9/12
 * Time: 14:38
 */

namespace mztest\ucenter\controllers;

use Yii;
use yii\web\Controller;
use mztest\ucenter\models\UCenter;

class ApiController extends Controller
{
    public $enableCsrfValidation = false;

    /* @var $uCenter UCenter */
    protected $uCenter;

    public function init()
    {
        parent::init();

        $this->uCenter = new UCenter([
            'code' => Yii::$app->request->get('code')
        ]);
        $this->uCenter->validate();
    }

    public function actionIndex()
    {
        return $this->uCenter->run();
    }

}