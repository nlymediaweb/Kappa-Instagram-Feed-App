<?php 
$host = "localhost";

$username = "ufbgncvvlgk5c";

$password = "Waqas123<3";

$database = 'dbtpqdkdgywjh1';


//Initializes MySQLi
$conn = mysqli_connect($host, $username, $password, $database);

//If connection failed, show the error
if (mysqli_connect_errno()) {
    die('Failed to connect to MySQL: '.mysqli_connect_error());
}

mysqli_set_charset($conn,"utf8mb4");


$shopify_url = "k-way-it.myshopify.com";

$account_table = 'kway_it_insta_account';
$media_table = 'kway_it_insta_media';
$album_table = 'kway_it_insta_media_album';