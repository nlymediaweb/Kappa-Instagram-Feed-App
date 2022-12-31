<?php 
    require(__DIR__ . "/vendor/autoload.php");

    $config = array(
        'ShopUrl' => "https://k-way-it.myshopify.com/",
        'ApiKey' => "59f08fc28a801c4dc7294eeafef8438c",
        'SharedSecret' => "cdd97d58aae0f9a08676eea0319b0061"
    );
    
    PHPShopify\ShopifySDK::config($config);

    //your_authorize_url.php
    // $scopes = 'read_products';
    //This is also valid
    $scopes = array('read_script_tags', 'write_script_tags', 'read_themes', 'write_themes');
    $redirectUrl = 'https://kway-app.brklyn.io/kway-insta/get_access_token.php';

    \PHPShopify\AuthHelper::createAuthRequest($scopes, $redirectUrl);


?>