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
use mztest\ucenter\UCenter;

class ApiController extends Controller
{
    /* @var $uCenter UCenter */
    protected $uCenter;

    public function init()
    {
        parent::init();

        $this->uCenter = new UCenter(Yii::$app->request->get('code'));
        $this->uCenter->validate();
    }

    public function actionIndex()
    {
        return $this->uCenter->process();
    }

}