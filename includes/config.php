<?php

return  array(
    "PROD" => array(
        'host' => 'help-center-prod.apigateway.co:443',
        'scope' => 'https://help-center-prod.apigateway.co',
        'url' => 'https://help-center-prod.apigateway.co',
        'secure' => true,
    ),
    "DEMO" => array(
        'host' => 'help-center-demo.apigateway.co:443',
        'scope' => 'https://help-center-demo.apigateway.co',
        'url' => 'https://help-center-demo.apigateway.co',
        'secure' => true,
    ),
    "LOCAL" => array(
        'host' => 'http://help-center-api.vendasta-local.com',
        'scope' => 'http://help-center-api.vendasta-local.com',
        'url' => 'http://help-center-api.vendasta-local.com',
        'secure' => false,
    )
);