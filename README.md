

# Push Notification Library for php
 
Standalone PHP library for easy devices message notifications push.  
<i class="icon-flag"></i> 
**Feel free to contribute!**



Installation
-------------

    composer require sinergy84/push-notification-php-library
    composer dump-autoload -o 


This repository uses PSR-0 autoload. After installation with composer please adjust you autoloading config if needed or include vendor/autoload.php in your index.php. 

 **Requirements:**

> - PHP 5.6+
> - PHP Curl and OpenSSL modules

  > **available supports:**
 > 
> - APNS (Apple)
> - GCM (Android) and FCM (Android)

### Setting
1.  settings of your provider (Apn, Fcm) at  **.env**
(make sure you renamed the .env.example to .env and filled all the requirements)


2. path to .env file (optional):
set custom **$path** parameter in ```src/PushNotification/Setting::__construct($path = NULL)``` to the .env file if it's not in the root dir of this library


### How to use : 
```php
include_once "vendor/autoload.php";

use PushNotification\Service\PushService;
use PushNotification\Settings;

$data = array(
    'device' => array(
        'name' => '', // Android or AppleIOS
        'token' => '', // device token | user token , if you want to send to apple device you have to fill this 
        'id' => 'unique id here'),

    'message' => array(
        'action' => 'test',
        'title' => 'this is test title',
        'targets' => array(''), // if you want to use Fcm you can inclue array of targets 
        'body' => 'this is body',
        'type' => '', // AndroidMessages or IOSMessages
        'data' => array('type' => 'testType'))
);

// new Settings('path_to_env_file_if_not_library_root_dir');
new Settings();
$response  = PushService::getInstance()->send($data);

```

### Android :
```php
include_once "vendor/autoload.php";

use PushNotification\Service\PushService;

$data = array(
    'device' => array(
        'name' => 'Android',  
        'token' => '', 
        'id' => 'some id here '),

    'message' => array(
        'action' => 'test',
        'title' => 'this is test title',
        'targets' => array('token1', 'token2', 'token3'),
        'body' => 'this is body',
        'type' => 'AndroidMessages',  
        'data' => array('type' => 'testType'))
);

// new Settings('path_to_env_file_if_not_library_root_dir');
new Settings();
$response  = PushService::getInstance()->send($data);
print_r($response);

```


### IOS :
```php
include_once "vendor/autoload.php";

use PushNotification\Service\PushService;

$data = array(
    'device' => array(
        'name' => 'AppleIOS',
        'token' => 'token',
        'id' => 'BECDSx'),

    'message' => array(
        'action' => 'test',
        'title' => 'this is test title',
        'targets' => array(),
        'body' => 'this is body',
        'type' => 'IOSMessages', 
        'data' => array('type' => 'testType'))
);

// new Settings('path_to_env_file_if_not_library_root_dir');
new Settings();
$response  = PushService::getInstance()->send($data);
print_r($response);

```
