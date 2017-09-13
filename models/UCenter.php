<?php
/**
 * Created by PhpStorm.
 * User: guoxiaosong
 * Date: 2017/9/12
 * Time: 17:26
 */

namespace mztest\ucenter\models;

use yii\base\InvalidConfigException;
use yii\base\Object;
use yii\helpers\ArrayHelper;
use yii\web\BadRequestHttpException;

require_once __DIR__ .'/../uc_client/client.php';

class UCenter extends Object
{
    const API_RETURN_SUCCEED = 1;

    public $code;

    protected $get = [];
    protected $post = [];

    public function init()
    {
        parent::init();

        if ($this->code === null) {
            throw new InvalidConfigException('"Code" property must be specified.');
        }

        parse_str(uc_authcode($this->code, 'DECODE', UC_KEY), $this->get);
        $this->post = uc_unserialize(file_get_contents('php://input'));
    }

    public function validate()
    {
        if (empty($this->get)
            || !($action = $this->getAction())
            || !($time = ArrayHelper::getValue($this->get, 'time'))
        ) {
            throw new BadRequestHttpException();
        }

        if(time() - $time > 3600) {
            throw new BadRequestHttpException('Authorisation has expired');
        }
    }

    public function process()
    {
        $action = $this->getAction();

        $method = 'process'. ucfirst($action);

        return $this->{$method}();
    }

    public function processTest()
    {
        return self::API_RETURN_SUCCEED;
    }

    public function getAction()
    {
        return ArrayHelper::getValue($this->get, 'action');
    }
}