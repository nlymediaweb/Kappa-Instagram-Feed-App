<?php 
    header("Cache-Control: no-cache"); 
    header('Access-Control-Allow-Origin: *');
?>

<?php 
require __DIR__ . '/src/InstagramBasicDisplay.php';
require_once("config.php");
require(__DIR__ . "/vendor/autoload.php");
use EspressoDev\InstagramBasicDisplay\InstagramBasicDisplay;


// header( "Location: install.php" );

// exit();
// $shop = mysqli_fetch_assoc($shop);
// $accessToken = "shpua_271b7a4838e9a42385e3132b2d18a919";

// $config = array(
//     'ShopUrl' => "https://k-way-it.myshopify.com",
//     'AccessToken' => $accessToken,
// );

// PHPShopify\ShopifySDK::config($config);

// $shopify = new PHPShopify\ShopifySDK;



$instagram = new InstagramBasicDisplay([
    'appId' => '3144429085811072',
    'appSecret' => 'd9303ae289b4d970f45196cc2ec482fd',
    'redirectUri' => 'https://kway-app.brklyn.io/kway-insta'
]);

if(isset($_GET['code']) && !empty($_GET['code'])) {
    // Get the OAuth callback code
    $code = $_GET['code'];

    // Get the short lived access token (valid for 1 hour)
    $token = $instagram->getOAuthToken($code, true);

    // Exchange this token for a long lived token (valid for 60 days)
    $token = $instagram->getLongLivedToken($token, true);

    // echo 'Your token is: ' . $token;


    // Set user access token
    $instagram->setAccessToken($token);

    // Get the users profile
    $profile = $instagram->getUserProfile();

    // echo '<pre>';
    // print_r($profile);
    // echo '<pre>';

    $insta_id = $profile->id;
    $insta_user = $profile->username;

    $sqlc = "SELECT * FROM $account_table WHERE `shopify_url` = '$shopify_url'";
    $result = mysqli_query($conn, $sqlc);
    $expiry_date = strtotime(date('Y-m-d', time() + 86400 * 60));

    if(mysqli_num_rows($result) <= 0) {
        $sqlc = "INSERT INTO $account_table (`id`, `shopify_url`, `insta_user`, `insta_id`, `token`, `expiry_date`) VALUES (NULL, '$shopify_url', '$insta_user', '$insta_id', '$token', '$expiry_date')";
    } else {
        $sqlc = "UPDATE $account_table SET `insta_user` = '$insta_user', `insta_id` = '$insta_id', `token` = '$token'  WHERE `shopify_url` = '$shopify_url'";
    }
    
    if(!$result = mysqli_query($conn, $sqlc)){

        die('There was an error running the query [' . mysqli_error($conn) . ']');

    }
    ?>

    <script>
        window.opener.location.reload(true);
        window.close();
    </script>
    <?php
    // header("Location: templates/sync.php");
    
    return;
} else {
    
    $sqlc = "SELECT * FROM $account_table WHERE `shopify_url` = '$shopify_url'";
    $result = mysqli_query($conn, $sqlc);

    if(mysqli_num_rows($result) <= 0) {
        require(__DIR__ . "/templates/login.php");
    } else {
        $row = mysqli_fetch_assoc($result);
        $today = strtotime(date("Y-m-d"));
        $expiry = (int)($row['expiry_date'] - (86400 * 2));
        $token = $row["token"];
        
        if($today > $expiry) {
            $new_token = $instagram->refreshToken($token, true);
            // Exchange this token for a long lived token (valid for 60 days)
            // Set user access token
            $instagram->setAccessToken($new_token);

            $expiry_date = strtotime(date('Y-m-d', time() + 86400 * 60));

            $sqlc = "UPDATE $account_table SET `token` = '$new_token', `expiry_date` = '$expiry_date'  WHERE `token` = '$token'";

            if(!$result = mysqli_query($conn, $sqlc)){

                die('There was an error running the query [' . mysqli_error($conn) . ']');
        
            }
        }

        require(__DIR__ . "/templates/sync.php");
    }
    
}