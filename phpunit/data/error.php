<?php
return [

    // Error data for testing exceptions

    'sms' => [
        'Nexmo'         =>  [
            'from'      => '',
            'api_key'   => '',
            'api_secret'=> '',
            'type'      => '',
            'request_method' => 'GET'
        ],
        'BulkSMS'   =>  [
            'username'  => 'SWEB',
            'password'  => '11111111',
        ],
        'Clickatell'    => [
            'api_id'    => '11111111',
            'user'      => '11111111',
            'password'  => '11111111',
            'from'      => 'TEST',
            'request_method' => 'GET'
        ],
        'MessageBird'   => [
            'originator'   => '223',
            'access_key'   => '23232323',
            'request_method' => 'GET'
        ],
        'SmsAero' => [
            'from'          => 'Test',
            'user'          => 'SWEB',
            'password'      => '11111111',
        ],
        'SMSC'       =>  [
            'login'     => '11111111',
            'psw'       => '11111111',
            'charset'   => '11111111',
            'sender'    => '11111111',
            'translit'  => '11111111',
        ],
        'SmsUkraine'       =>  [
            'from'          => 'Stanislav',
            'login'         => '11111111',
            'password'      => '11111111',
            'version'       => 'http',
        ],
        'SMSRu' => [
            'api_id'    => '11111111'
        ]
    ]
];