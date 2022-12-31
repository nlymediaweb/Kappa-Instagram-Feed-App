<?php 
header('Access-Control-Allow-Origin: *'); 
header("Cache-Control: no-cache"); 
?>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->

<script src="https://kway-app.brklyn.io/kway-insta/js/custom.js"></script>

<link type="text/css" rel="stylesheet" href="https://kway-app.brklyn.io/kway-insta/css/widget.css" />

<?php 

require_once("config.php");

$media_array = array();

$sqlc = "SELECT * FROM $account_table WHERE `shopify_url` = '$shopify_url'";

$result = mysqli_query($conn, $sqlc);



if(mysqli_num_rows($result) > 0) {



    $row = mysqli_fetch_assoc($result);

    $profile_id = $row['insta_id'];

    $profile_user = $row['insta_user'];



    $sqlc = "SELECT * FROM $media_table WHERE `insta_id` = '$profile_id' ORDER BY display_order ASC LIMIT 7";

    $media_result = mysqli_query($conn, $sqlc);



    if($media_item = mysqli_num_rows($media_result) > 0) {

        

?>

<div class="social-widget-wrapper" data-widget-id="18140" style="display: block;">

  <div class="sw-instagram-container" style="--sw-layout-margin-left:auto; --sw-layout-margin-top:auto; --sw-layout-margin-right:auto; --sw-layout-margin-bottom:auto; --sw-layout-padding-left:0px; --sw-layout-padding-top:0px; --sw-layout-padding-right:0px; --sw-layout-padding-bottom:0px; --sw-layout-max-width:100%; --sw-layout-background-color:#FFFFFF; --sw-layout-background-size:cover; --sw-layout-background-repeat:no; --sw-layout-background-position-x:center; --sw-layout-background-position-y:center; --sw-load-more-btn-font-size:18px; --sw-load-more-btn-background-color:#FFFFFF; --sw-load-more-btn-align:center; --sw-load-more-btn-font-weight:normal; --sw-load-more-btn-color:#000000; --sw-heading-title-font-size:18px; --sw-heading-title-text-align:center; --sw-heading-title-font-weight:normal; --sw-heading-title-color:#000000; --sw-heading-description-font-size:14px; --sw-heading-description-text-align:center; --sw-heading-description-font-weight:normal; --sw-heading-description-color:#000000; --sw-hover-background-color:#252627; --sw-hover-opacity:0.6; --sw-hover-color:#ffffff; --sw-hover-text-align:center; --sw-hover-font-size:15px; --sw-hover-font-weight:normal; --sw-item-border-radius:3px; --sw-item-gutter:2px; --sw-popup-follow-btn-background-color:#252627; --sw-popup-follow-btn-color:#000000; --sw-popup-follow-btn-text-align:center; --sw-popup-follow-btn-font-size:15px; --sw-popup-follow-btn-font-weight:normal;">

    <div class="sw-instagram sw-instagram-box">

        <!-- <div class="sw-instagram-header">

            <div class="sw-instagram-header-title">

            <p style="text-align: center">

                <span style="font-size: 18px">Follow Us on Instagram</span>

            </p>

            </div>

            <div class="sw-instagram-header-description">

            <p style="text-align: center">

                <span style="font-size: 14px">Follow us so you'll never miss an update</span>

            </p>

            </div>

        </div> -->

        <div class="sw-instagram-body">

            <div class="sw-instagram-row sw-instagram-collage sw-instagram-collage-style-highlight">

<?php 

            while ($media = mysqli_fetch_assoc($media_result)) {

                $timestamp = explode("T", $media['timestamp']);

                $date = $timestamp[0];

                $time = explode("+", $timestamp[1])[0];

                $timestamp = strtotime($date . " " . $time);

                $formatted_date = date("F j, Y", $timestamp); 

                $media_type = $media['media_type'];



                if($media_type == "CAROUSEL_ALBUM") {

                  $media_array[] = $media;

                  $media_id = $media['media_id'];

                  $sqlc = "SELECT * FROM $album_table WHERE `parent_id` = '$media_id'";

                  $album_result = mysqli_query($conn, $sqlc);

                  while ($album_media = mysqli_fetch_assoc($album_result)) {

                     $media_array[sizeof($media_array) - 1]["album"][] = $album_media;

                  }

                } else {

                  $media_array[] = $media;

                }

?>

                <div class="sw-instagram-col">

                    <a class="sw-instagram-item sw-instagram-default" data-id="<?=$media['media_id']?>">

                        <div class="sw-instagram-item-img">

                            <?php if($media['media_type'] != "VIDEO") { ?>

                                <img src="<?=$media['media_url']?>">

                            <?php } else { ?>

                                <img src="<?=$media['thumbnail_url']?>">

                            <?php } ?>

                        </div>

                        <div class="sw-instagram-item-overlay">

                            <div class="sw-instagram-item-overlay-content">

                            <div class="sw-instagram-item-overlay-row sw-instagram-item-overlay-caption"><?=$media['caption']?></div>

                            <div class="sw-instagram-item-overlay-row sw-instagram-item-overlay-date"><?=$formatted_date?></div>

                            </div>

                        </div>

                    </a>

                </div>

<?php 

            }

?>

            </div>

        </div>

    </div>

  </div>

</div>





<script type="application/json" id="media">

   <?=json_encode($media_array)?>

</script>



<div class="sw-instagram-modal" style="--sw-layout-margin-left:auto; --sw-layout-margin-top:auto; --sw-layout-margin-right:auto; --sw-layout-margin-bottom:auto; --sw-layout-padding-left:0px; --sw-layout-padding-top:0px; --sw-layout-padding-right:0px; --sw-layout-padding-bottom:0px; --sw-layout-max-width:100%; --sw-layout-background-color:#FFFFFF; --sw-layout-background-size:cover; --sw-layout-background-repeat:no; --sw-layout-background-position-x:center; --sw-layout-background-position-y:center; --sw-load-more-btn-font-size:18px; --sw-load-more-btn-background-color:#FFFFFF; --sw-load-more-btn-align:center; --sw-load-more-btn-font-weight:normal; --sw-load-more-btn-color:#000000; --sw-heading-title-font-size:18px; --sw-heading-title-text-align:center; --sw-heading-title-font-weight:normal; --sw-heading-title-color:#000000; --sw-heading-description-font-size:14px; --sw-heading-description-text-align:center; --sw-heading-description-font-weight:normal; --sw-heading-description-color:#000000; --sw-hover-background-color:#252627; --sw-hover-opacity:0.6; --sw-hover-color:#ffffff; --sw-hover-text-align:center; --sw-hover-font-size:15px; --sw-hover-font-weight:normal; --sw-item-border-radius:3px; --sw-item-gutter:2px; --sw-popup-follow-btn-background-color:#252627; --sw-popup-follow-btn-color:#000000; --sw-popup-follow-btn-text-align:center; --sw-popup-follow-btn-font-size:15px; --sw-popup-follow-btn-font-weight:normal;">

   <div class="sw-instagram-modal-close"></div>

   <div class="sw-instagram-modal-container">

      <div class="sw-instagram-modal-nav sw-instagram-modal-nav-prev">

         <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">

            <path d="M10.8281 21.2188L11.7656 20.3281C11.9531 20.0938 11.9531 19.7188 11.7656 19.5312L3.28125 11L11.7656 2.51562C11.9531 2.32812 11.9531 1.95312 11.7656 1.71875L10.8281 0.828125C10.5938 0.59375 10.2656 0.59375 10.0312 0.828125L0.1875 10.625C0 10.8594 0 11.1875 0.1875 11.4219L10.0312 21.2188C10.2656 21.4531 10.5938 21.4531 10.8281 21.2188Z" fill="#F3F3F3"></path>

         </svg>

      </div>

      <div class="sw-instagram-modal-nav sw-instagram-modal-nav-next">

         <svg width="12" height="22" viewBox="0 0 12 22" fill="none" xmlns="http://www.w3.org/2000/svg">

            <path d="M1.125 0.828125L0.1875 1.71875C0 1.95312 0 2.32812 0.1875 2.51562L8.67188 11L0.1875 19.5312C0 19.7188 0 20.0938 0.1875 20.3281L1.125 21.2188C1.35938 21.4531 1.6875 21.4531 1.92188 21.2188L11.7656 11.4219C11.9531 11.1875 11.9531 10.8594 11.7656 10.625L1.92188 0.828125C1.6875 0.59375 1.35938 0.59375 1.125 0.828125Z" fill="#F3F3F3"></path>

         </svg>

      </div>

      <div class="sw-instagram-modal-wrap">

         <div class="sw-instagram-modal-body">

            <div class="sw-instagram-modal-col sw-instagram-modal-col-left">

               <div class="sw-instagram-modal-image sw-instagram-modal-single-image"><img class="sw-instagram-single-image" src="https://scontent-sin6-3.cdninstagram.com/v/t51.29350-15/234891215_130896002574924_984277017748150123_n.jpg?_nc_cat=106&amp;ccb=1-7&amp;_nc_sid=8ae9d6&amp;_nc_ohc=ONSUfSiicLwAX_aEt5F&amp;_nc_ht=scontent-sin6-3.cdninstagram.com&amp;edm=ANo9K5cEAAAA&amp;oh=00_AT-9ZZqBF4rOch6g9dQsqDO_5SBig45rSlL8b3-MmQTvpQ&amp;oe=62ED8AA7"></div>

            </div>

            <div class="sw-instagram-modal-col sw-instagram-modal-col-right">

               <div class="sw-instagram-modal-col-wrap sw-instagram-modal-cart-wrap">

                  <div class="sw-instagram-modal-col-content sw-instagram-modal-info-wrapper">

                     <div class="sw-instagram-modal-info has-small-footer">

                        <div class="sw-instagram-modal-info-header">

                           <a class="sw-popup-info-account" href="https://www.instagram.com/<?=$profile_user?>" target="_self">

                              <div class="sw-popup-info-account-avatar">

                                 <div class="sw-popup-info-account-avatar-icon">

                                    <svg width="26" height="26" viewBox="0 0 26 26" fill="none" xmlns="http://www.w3.org/2000/svg">

                                       <path d="M21.75 6.125C21.75 7.16053 20.9105 8 19.875 8C18.8395 8 18 7.16053 18 6.125C18 5.08947 18.8395 4.25 19.875 4.25C20.9105 4.25 21.75 5.08947 21.75 6.125Z" fill="white"></path>

                                       <path fill-rule="evenodd" clip-rule="evenodd" d="M13 19.25C16.4518 19.25 19.25 16.4518 19.25 13C19.25 9.54822 16.4518 6.75 13 6.75C9.54822 6.75 6.75 9.54822 6.75 13C6.75 16.4518 9.54822 19.25 13 19.25ZM13 16.75C15.0711 16.75 16.75 15.0711 16.75 13C16.75 10.9289 15.0711 9.25 13 9.25C10.9289 9.25 9.25 10.9289 9.25 13C9.25 15.0711 10.9289 16.75 13 16.75Z" fill="white"></path>

                                       <path fill-rule="evenodd" clip-rule="evenodd" d="M0.5 12.5C0.5 8.29961 0.5 6.19941 1.31745 4.59507C2.0365 3.18386 3.18386 2.0365 4.59507 1.31745C6.19941 0.5 8.29961 0.5 12.5 0.5H13.5C17.7004 0.5 19.8006 0.5 21.4049 1.31745C22.8161 2.0365 23.9635 3.18386 24.6825 4.59507C25.5 6.19941 25.5 8.29961 25.5 12.5V13.5C25.5 17.7004 25.5 19.8006 24.6825 21.4049C23.9635 22.8161 22.8161 23.9635 21.4049 24.6825C19.8006 25.5 17.7004 25.5 13.5 25.5H12.5C8.29961 25.5 6.19941 25.5 4.59507 24.6825C3.18386 23.9635 2.0365 22.8161 1.31745 21.4049C0.5 19.8006 0.5 17.7004 0.5 13.5V12.5ZM12.5 3H13.5C15.6414 3 17.0972 3.00194 18.2224 3.09388C19.3184 3.18343 19.879 3.34574 20.27 3.54497C21.2108 4.02433 21.9757 4.78924 22.455 5.73005C22.6543 6.12105 22.8166 6.68156 22.9061 7.77759C22.9981 8.90282 23 10.3586 23 12.5V13.5C23 15.6414 22.9981 17.0972 22.9061 18.2224C22.8166 19.3184 22.6543 19.879 22.455 20.27C21.9757 21.2108 21.2108 21.9757 20.27 22.455C19.879 22.6543 19.3184 22.8166 18.2224 22.9061C17.0972 22.9981 15.6414 23 13.5 23H12.5C10.3586 23 8.90282 22.9981 7.77759 22.9061C6.68156 22.8166 6.12105 22.6543 5.73005 22.455C4.78924 21.9757 4.02433 21.2108 3.54497 20.27C3.34574 19.879 3.18343 19.3184 3.09388 18.2224C3.00194 17.0972 3 15.6414 3 13.5V12.5C3 10.3586 3.00194 8.90282 3.09388 7.77759C3.18343 6.68156 3.34574 6.12105 3.54497 5.73005C4.02433 4.78924 4.78924 4.02433 5.73005 3.54497C6.12105 3.34574 6.68156 3.18343 7.77759 3.09388C8.90282 3.00194 10.3586 3 12.5 3Z" fill="white"></path>

                                    </svg>

                                 </div>

                              </div>

                              <div class="sw-popup-info-account-title" title="<?=$profile_user?>"><?=$profile_user?></div>

                           </a>

                           <div class="sw-spacer"></div>

                           <div class="sw-popup-info-action">

                              <a class="sw-popup-info-follow" href="https://www.instagram.com/<?=$profile_user?>" target="_blank">

                                 <div style="background: #5B86E5; border-radius: 3px; min-height: 32px; padding: 0 16px;border: none; display: inline-flex; align-items: center"><strong><span style="color:#FFFFFF">Follow</span></strong></div>

                              </a>

                           </div>

                        </div>

                        <div class="sw-instagram-modal-info-body">

                           <div class="sw-popup-info-caption">Hey ! Let play game with me</div>

                           <div class="sw-popup-info-products"></div>

                        </div>

                        <div class="sw-instagram-modal-info-footer">

                           <div class="sw-instagram-modal-info-footer-content">

                              <div class="sw-popup-info-row">

                                 <div class="sw-popup-info-date">August 10, 2021</div>

                                 <div class="sw-popup-info-view"></div>

                              </div>

                              <div class="sw-popup-info-row">

                                 <div class="sw-popup-info-like"></div>

                                 <div class="sw-popup-info-comment"></div>

                              </div>

                           </div>

                           <div class="sw-instagram-modal-info-footer-watermark"></div>

                        </div>

                     </div>

                  </div>

               </div>

            </div>

         </div>

      </div>

   </div>

</div>





<?php

    }

}





