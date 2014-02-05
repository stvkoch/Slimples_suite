<?php
return array(
    'slim'=>array(),
    'template-path'=> __APPLICATION__ . '/View',
    'template-cache'=> '/tmp/Cache/Frontend', //or any where do you like ... maybe /tmp/cache/frontend ?
    'facebook'=>array(
        'appId' => $_ENV['FACEBOOK_APP_ID'],
        'secret' => $_ENV['FACEBOOK_SECRET'],
        'fileUpload' => false,
        'allowSignedRequest' => false,
    ),
    'session-cookie'=>false,
    // this is not good choise for mobile first application, this increase playload of your request
    // 'session-cookie' => array(
    //     'expires' => '168 hours',
    //     'path' => '/',
    //     'domain' => null,
    //     'secure' => false,
    //     'httponly' => false,
    //     'name' => 'fsu',
    //     'secret' => 'DmFF6KSJJlsnFvp0BIk3XtMuVQZgWo63EJKrEosLfpRyXN6XeX4tLtwsLV5HT6Y',
    //     'cipher' => MCRYPT_RIJNDAEL_256,
    //     'cipher_mode' => MCRYPT_MODE_CBC
    // )
);
