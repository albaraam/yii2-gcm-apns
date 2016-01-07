# albaraam/yii2-gcm-apns

Yii2 component as wrapper of the ["albaraam/php-gcm-apns"](https://github.com/albaraam/php-gcm-apns) library to handle mobile push notifications.


Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```json
composer require albaraam/yii2-gcm-apns "~1.0.0"
```

or add

```json
"albaraam/yii2-gcm-apns": "~1.0.0"
```

to the `require` section of your composer.json.


Usage
------------
Add & configure the component in your config file:

```php
'components' => [
    'gcmApns' => [
        'class' => 'albaraam\yii2_gcm_apns\GcmApns',
        'google_api_key'=>'your_google_api_key',
        'environment'=>\albaraam\yii2_gcm_apns\GcmApns::ENVIRONMENT_SANDBOX,
        'pem_file'=>'path/to/pem/file'
    ],
]
```

Access it anywhere in your application like the following:

```php
// Message creation through the message builder.
$message = Yii::$app()->gcmApns->messageBuilder("Title","Body");

// Common attributes for both ios and android
$message
	->setTitle("Title")
	->setBody("Body")
	->setSound("sound.mp3")
	->setData(['foo'=>'bar']);

// Android specific attributes
$message->android
	->setTo("ids")
	->setIcon("icon")
	->setCollapseKey("collapse_key")
	->setColor("#333");

// IOS specific attributes
$message->ios
	->setTo("ids")
	->setSound("sound_ios.mp3") // custom sound for ios
	->setBadge(3);

// Send message
Yii::$app->gcmApns->send($message);

```
