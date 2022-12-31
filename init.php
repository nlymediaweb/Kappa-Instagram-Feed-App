<?php 
require_once("config.php");
// sql to create table
$sql = "CREATE TABLE kway_it_insta_account (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    shopify_url VARCHAR(500) NOT NULL,
    insta_user VARCHAR(500) NOT NULL,
    insta_id VARCHAR(500) NOT NULL,
    token VARCHAR(2000) NOT NULL,
    expiry_date VARCHAR(500) NOT NULL
)";

if (mysqli_query($conn, $sql)) {
	echo "Table account created successfully";
} else {
	echo "Error creating table: " . $conn->error;
}


$sql = "CREATE TABLE kway_it_insta_media (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    insta_id VARCHAR(500) NOT NULL,
    media_id VARCHAR(500) NOT NULL,
    caption VARCHAR(1500) NOT NULL,
    media_type VARCHAR(500) NOT NULL,
    media_url VARCHAR(1000) NOT NULL,
    permalink VARCHAR(1000) NOT NULL,
    thumbnail_url VARCHAR(500) NOT NULL,
    display_order INT(6) UNSIGNED,
    `timestamp` VARCHAR(500) NOT NULL
    )";
    
    if (mysqli_query($conn, $sql)) {
        echo "Table account created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }



$sql = "CREATE TABLE kway_it_insta_media_album (
    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    insta_id VARCHAR(500) NOT NULL,
    media_id VARCHAR(500) NOT NULL,
    media_type VARCHAR(500) NOT NULL,
    media_url VARCHAR(1000) NOT NULL,
    permalink VARCHAR(1000) NOT NULL,
    thumbnail_url VARCHAR(500) NOT NULL,
    `timestamp` VARCHAR(500) NOT NULL,
    parent_id VARCHAR(500) NOT NULL
    )";
    
    if (mysqli_query($conn, $sql)) {
        echo "Table account created successfully";
    } else {
        echo "Error creating table: " . $conn->error;
    }
    


// die;