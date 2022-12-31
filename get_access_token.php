<?php 
require(__DIR__ . "/vendor/autoload.php");
$config = array(
    'ShopUrl' => "https://k-way-it.myshopify.com",
    'ApiKey' => "59f08fc28a801c4dc7294eeafef8438c",
    'SharedSecret' => "cdd97d58aae0f9a08676eea0319b0061"
);

PHPShopify\ShopifySDK::config($config);
$accessToken = \PHPShopify\AuthHelper::getAccessToken();
echo $accessToken;
die;
//shpua_271b7a4838e9a42385e3132b2d18a919


?>