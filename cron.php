<?php 
    header("Cache-Control: no-cache"); 
    header('Access-Control-Allow-Origin: *');
    // echo getcwd();
?>

<?php 
require __DIR__ . '/src/InstagramBasicDisplay.php';
require_once("config.php");
require(__DIR__ . "/vendor/autoload.php");
use EspressoDev\InstagramBasicDisplay\InstagramBasicDisplay;

$instagram = new InstagramBasicDisplay([
    'appId' => '3144429085811072',
    'appSecret' => 'd9303ae289b4d970f45196cc2ec482fd',
    'redirectUri' => 'https://kway-app.brklyn.io/kway-insta'
]);

$sqlc = "SELECT * FROM $account_table WHERE `shopify_url` = '$shopify_url'";
$result = mysqli_query($conn, $sqlc);
// $sqlc = "UPDATE $account_table SET `token` = '$shopify_url' WHERE `shopify_url` = '$shopify_url'";
// $result = mysqli_query($conn, $sqlc);
if(mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $token = $row["token"];
    
    if($token != "") {
        $new_token = $instagram->refreshToken($token, true);

        $sqlc = "UPDATE $account_table SET `token` = '$new_token' WHERE `shopify_url` = '$shopify_url'";
    
        if(!$result = mysqli_query($conn, $sqlc)) {
            die('There was an error running the query [' . mysqli_error($conn) . ']');
        }
    }
}