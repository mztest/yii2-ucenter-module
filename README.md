# yii2-ucenter-module
Yii2 module for integration ucenter

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist mztest/yii2-ucenter-module "*"
```

or add

```
"mztest/yii2-ucenter-module": "*"
```

to the require section of your `composer.json` file.

Usage
-----
Step 1:

Goto UCenter admin system, create a new application.

应用的主 URL: http://your site doamin/ucenter
应用接口文件名称: index
 
 
Step 2: 

Save the config into your yii2 application. Example: @app/config/ucenter.php 
Here is the example.
```php
define('UC_CONNECT', 'mysql');
define('UC_DBHOST', 'localhost');
define('UC_DBUSER', '');
define('UC_DBPW', '');
define('UC_DBNAME', '');
define('UC_DBCHARSET', 'utf8');
define('UC_DBTABLEPRE', '`ultrax`.pre_ucenter_');
define('UC_DBCONNECT', '0');
define('UC_KEY', '');
define('UC_API', 'http://youdomain/discuz/uc_server');
define('UC_CHARSET', 'utf-8');
define('UC_IP', '');
define('UC_APPID', '2');
define('UC_PPP', '20');

// For auto creating discuz member
define('UC_DISCUZ_MEMBER', true);
define('UC_DISCUZTABLEPRE', '`ultrax`.pre_');
```

Step 2:

Config @app/config/main.php
```php
return [
    '...',
    'modules' => [
        'ucenter' => [
            'class' => 'mztest\ucenter\Module',
            'configFile' => '@app/config/ucenter.php' // default '@app/config/ucenter.php'
        ],
    ],
    '...'
];
```
Step 3:

About method, [PSR-1](http://www.php-fig.org/psr/psr-1/#43-methods) Use <code>camelCase()</code>

Example:

uc_user_register to ucUserRegister
uc_get_user to ucGetUser

Enjoy it.

Example
------

Synlogin after user login.

Sometimes we build main site first, then merge the ucenter later, so a little check was added here.
```php
// synchronize register and login
try {
    $uCenterClient = Yii::$app->getModule('ucenter')->getUCenterClient();
    if ($uCenterUser = $uCenterClient->ucGetUser($model->email)) {
        list($uCenterUid,,) = $uCenterUser;
    } else {
        $uCenterUid = $uCenterClient->ucUserRegister($model->email, $model->password, $model->email);
        if ($uCenterUid < 0) {
            $uCenterUid = false;
        }
    }
    if ($uCenterUid && ($syncScript = $uCenterClient->ucUserSynlogin($uCenterUid))) {
        Yii::$app->session->setFlash('success', $syncScript);
    }
}  catch (\Exception $e) {
    //
}
```