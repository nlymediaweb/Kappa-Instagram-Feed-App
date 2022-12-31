<?php
require __DIR__ . '/src/InstagramBasicDisplay.php';
require_once("config.php");
use EspressoDev\InstagramBasicDisplay\InstagramBasicDisplay;

$instagram = new InstagramBasicDisplay([
    'appId' => '3144429085811072',
    'appSecret' => 'd9303ae289b4d970f45196cc2ec482fd',
    'redirectUri' => 'https://kway-app.brklyn.io/kway-insta'
]);

$shopify_url = "k-way-it.myshopify.com";

$sqlc = "SELECT * FROM $account_table WHERE `shopify_url` = '$shopify_url'";
$result = mysqli_query($conn, $sqlc);

if(mysqli_num_rows($result) > 0) {

    $row = mysqli_fetch_assoc($result);

    $token = $row['token'];

    // Set user access token
    $instagram->setAccessToken($token);

    // Get the users profile
    $profile = $instagram->getUserProfile();

    // echo '<pre>';
    // print_r($profile);
    // echo '<pre>';

    $profile_id = $profile->id;
    $username = $profile->username;
    $media = $instagram->getUserMedia($profile_id, 30);

    // echo '<pre>';
    // print_r($media);
    // echo '<pre>';
    // die;


    foreach($media->data as $index => $media_item) {
        if($media_item->media_type == "CAROUSEL_ALBUM") {
            handleMedia( $media_item, $index, $profile_id, "album" );
        } else if ($media_item->media_type == "IMAGE" || $media_item->media_type == "VIDEO") {
            handleMedia( $media_item, $index, $profile_id );
        }
    }

    echo json_encode(array("response" => "success"));
}


function handleMedia($media_item, $display_order, $profile_id, $action = "single") {
    global $conn, $shopify_url, $account_table, $media_table, $album_table;
    $media_id = $media_item->id;
    $sqlc = "SELECT * FROM $media_table WHERE `media_id` = '$media_id'";
    $result = mysqli_query($conn, $sqlc);
    

    if($action == "single") {
        $media_id = mysqli_real_escape_string($conn, $media_item->id);
        $caption = mysqli_real_escape_string($conn, $media_item->caption);
        $media_type = mysqli_real_escape_string($conn, $media_item->media_type);
        $media_url = mysqli_real_escape_string($conn, $media_item->media_url);
        $permalink = mysqli_real_escape_string($conn, $media_item->permalink);
        $thumbnail_url = mysqli_real_escape_string($conn, $media_item->thumbnail_url);
        $timestamp = mysqli_real_escape_string($conn, $media_item->timestamp);

        if(mysqli_num_rows($result) <= 0) {
            $sqlc = "INSERT INTO $media_table (`id`, `insta_id`, `media_id`, `caption`, `media_type`, `media_url`, `permalink`, `thumbnail_url`, `display_order`, `timestamp`) VALUES (NULL, '$profile_id', '$media_id', '$caption', '$media_type', '$media_url', '$permalink', '$thumbnail_url', '$display_order', '$timestamp')";
        } else {
            $sqlc = "UPDATE $media_table SET `caption` = '$caption', `media_type` = '$media_type', `media_url` = '$media_url', `permalink` = '$permalink', `thumbnail_url` = '$thumbnail_url', `display_order` = '$display_order', `timestamp` = '$timestamp'  WHERE `media_id` = '$media_id'";
        }
        

        
        if(!$result = mysqli_query($conn, $sqlc)){
            die('There was an error running the query [' . mysqli_error($conn) . ']');
        }

    } else {

        
        $parent_id = mysqli_real_escape_string($conn, $media_item->id);
        $gallery = $media_item->children->data;
        $image_type = false;

        foreach($gallery as $gallery_item) {
            $media_id = mysqli_real_escape_string($conn, $gallery_item->id);
            $media_type = mysqli_real_escape_string($conn, $gallery_item->media_type);
            $media_url = mysqli_real_escape_string($conn, $gallery_item->media_url);
            $permalink = mysqli_real_escape_string($conn, $gallery_item->permalink);
            $thumbnail_url = mysqli_real_escape_string($conn, $gallery_item->thumbnail_url);
            $timestamp = mysqli_real_escape_string($conn, $gallery_item->timestamp);

            $sqlc = "SELECT * FROM $album_table WHERE `media_id` = '$media_id'";
            $result = mysqli_query($conn, $sqlc);

            // if ($media_type == "IMAGE") {
                if(mysqli_num_rows($result) <= 0) {
                    $sqlc = "INSERT INTO $album_table (`id`, `insta_id`, `media_id`, `media_type`, `media_url`, `permalink`, `thumbnail_url`, `timestamp`, `parent_id`) VALUES (NULL, '$profile_id', '$media_id', '$media_type', '$media_url', '$permalink', '$thumbnail_url', '$timestamp', '$parent_id')";
                } else {
                    $sqlc = "UPDATE $album_table SET `media_type` = '$media_type', `media_url` = '$media_url', `permalink` = '$permalink', `thumbnail_url` = '$thumbnail_url', `timestamp` = '$timestamp'  WHERE `media_id` = '$media_id' AND `parent_id` = '$parent_id'";
                }
                
                if(!$result = mysqli_query($conn, $sqlc)){
                    die('There was an error running the query [' . mysqli_error($conn) . ']');
                }

                $image_type = true;
            // }
        }



        if($image_type == true) {
            $caption = mysqli_real_escape_string($conn, $media_item->caption);
            $media_type = mysqli_real_escape_string($conn, $media_item->media_type);
            $media_url = mysqli_real_escape_string($conn, $media_item->media_url);
            $permalink = mysqli_real_escape_string($conn, $media_item->permalink);
            $thumbnail_url = mysqli_real_escape_string($conn, $media_item->thumbnail_url);
            $timestamp = mysqli_real_escape_string($conn, $media_item->timestamp);
            $sqlc = "SELECT * FROM $media_table WHERE `media_id` = '$parent_id'";
            $result = mysqli_query($conn, $sqlc);

            if(mysqli_num_rows($result) <= 0) {
                $sqlc = "INSERT INTO $media_table (`id`, `insta_id`, `media_id`, `caption`, `media_type`, `media_url`, `permalink`, `thumbnail_url`, `display_order`, `timestamp`) VALUES (NULL, '$profile_id', '$parent_id', '$caption', '$media_type', '$media_url', '$permalink', '$thumbnail_url', '$display_order', '$timestamp')";
            } else {
                $sqlc = "UPDATE $media_table SET `caption` = '$caption', `media_type` = '$media_type', `media_url` = '$media_url', `permalink` = '$permalink', `thumbnail_url` = '$thumbnail_url', `display_order` = '$display_order', `timestamp` = '$timestamp'  WHERE `media_id` = '$parent_id'";
            }
            
            if(!$result = mysqli_query($conn, $sqlc)){
                die('There was an error running the query [' . mysqli_error($conn) . ']');
            }

        }


    }
}