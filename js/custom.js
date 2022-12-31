jQuery(document).ready(function() {
    let media_json = JSON.parse(jQuery("#media").text());

    setTimeout(function(){
        window.dispatchEvent(new Event('resize'));
    }, 1000);

    jQuery(".sw-instagram-modal").on("click", function(e) {
        if(jQuery(e.target).is('.sw-instagram-modal')) {
            jQuery(this).toggleClass("is-active");
            jQuery(".sw-instagram-modal-single-image").html("");
        }
    });

    jQuery(".sw-instagram-modal-close").on("click", function(e) {
        jQuery(".sw-instagram-modal").toggleClass("is-active");
    });

    jQuery(document).on("click", ".sw-instagram-item", function() {
        let media_id = jQuery(this).attr("data-id");
        jQuery(".sw-instagram-modal").attr("data-id", media_id);
        let filtered_media = media_json.filter(media => media.media_id == media_id);
        // console.log(filtered_media[0]["media_url"]);
        if(filtered_media[0].media_type == "CAROUSEL_ALBUM") {
            let album_html = '<div class="sw-instagram-modal-image sw-instagram-modal-carousel">';
            album_html += '<div class="sw-instagram-carousel">';
               album_html += '<div class="sw-instagram-carousel-wrap sw-carousel-initialized sw-carousel-slider sw-carousel-dotted">';
                  album_html += '<div class="sw-carousel-prev sw-carousel-arrow sw-carousel-disabled" aria-disabled="true" style="">';
                     album_html += '<div class="sw-carousel-arrow-icon">';
                        album_html += '<svg width="10" height="14" viewBox="0 0 10 14" fill="none" xmlns="http://www.w3.org/2000/svg">';
                           album_html += '<path d="M1.0625 6.5C0.78125 6.78125 0.78125 7.25 1.0625 7.53125L7.125 13.625C7.4375 13.9062 7.90625 13.9062 8.1875 13.625L8.90625 12.9062C9.1875 12.625 9.1875 12.1562 8.90625 11.8438L4.09375 7L8.90625 2.1875C9.1875 1.875 9.1875 1.40625 8.90625 1.125L8.1875 0.40625C7.90625 0.125 7.4375 0.125 7.125 0.40625L1.0625 6.5Z" fill="currentColor"></path>';
                        album_html += '</svg>';
                     album_html += '</div>';
                  album_html += '</div>';
                  album_html += '<div class="sw-carousel-list">';
                     album_html += '<div class="sw-carousel-track" style="opacity: 1; width: 1800px; transform: translate3d(0px, 0px, 0px);">';
                     let index = 0;
                     for(let album_media_item of filtered_media[0].album) {
                        if(index == 0) {
                            album_html += '<div class="sw-carousel-slide sw-carousel-current sw-carousel-active" data-sw-carousel-index="'+index+'" aria-hidden="false" style="width: 600px;" role="tabpanel" id="sw-carousel-slide0'+index+'">';
                        } else {
                            album_html += '<div class="sw-carousel-slide" data-sw-carousel-index="'+index+'" aria-hidden="false" style="width: 600px;" role="tabpanel" id="sw-carousel-slide0'+index+'">';
                        }
                        
                           album_html += '<div>';
                              album_html += '<div class="sw-instagram-carousel-item" data-type="'+album_media_item["media_type"]+'" data-media-url="'+album_media_item["media_url"]+'" data-image-id="'+album_media_item["media_id"]+'" style="width: 100%; display: inline-block;">';
                                 if(album_media_item["media_type"] == "VIDEO") {
                                    album_html += '<div class="sw-instagram-carousel-item-wrap"><video controls=""><source src="'+album_media_item["media_url"]+'"></video></div>';
                                 } else {
                                    album_html += '<div class="sw-instagram-carousel-item-wrap"><img src="'+album_media_item["media_url"]+'"></div>';
                                 }
                              album_html += '</div>';
                           album_html += '</div>';
                        album_html += '</div>';
                        index++;
                    }
                     album_html += '</div>';
                  album_html += '</div>';
                  album_html += '<div class="sw-carousel-next sw-carousel-arrow" style="" aria-disabled="false">';
                     album_html += '<div class="sw-carousel-arrow-icon">';
                        album_html += '<svg width="10" height="14" viewBox="0 0 10 14" fill="none" xmlns="http://www.w3.org/2000/svg">';
                           album_html += '<path d="M8.90625 7.53125C9.1875 7.25 9.1875 6.78125 8.90625 6.5L2.84375 0.40625C2.53125 0.125 2.0625 0.125 1.78125 0.40625L1.0625 1.125C0.78125 1.40625 0.78125 1.875 1.0625 2.1875L5.875 7L1.0625 11.8438C0.78125 12.1562 0.78125 12.625 1.0625 12.9062L1.78125 13.625C2.0625 13.9062 2.53125 13.9062 2.84375 13.625L8.90625 7.53125Z" fill="currentColor"></path>';
                        album_html += '</svg>';
                     album_html += '</div>';
                  album_html += '</div>';
               album_html += '</div>';
               album_html += '<div class="sw-instagram-carousel-dots">';
                  album_html += '<ul class="sw-carousel-dots" style="" role="tablist">';
                    for(let album_media_item_index in filtered_media[0].album) {
                        if(album_media_item_index == 0) {
                            album_html += '<li class="sw-carousel-active" role="presentation" data-index="'+album_media_item_index+'">';
                                album_html += '<div></div>';
                            album_html += '</li>';
                        } else {
                            album_html += '<li role="presentation" data-index="'+album_media_item_index+'">';
                                album_html += '<div></div>';
                            album_html += '</li>';
                        }
                     
                    }
                  album_html += '</ul>';
               album_html += '</div>';
            album_html += '</div>';
         album_html += '</div>';
         jQuery(".sw-instagram-modal-single-image").html(album_html);
        } else if (filtered_media[0].media_type == "VIDEO") {
            jQuery(".sw-instagram-modal-single-image").html('<div class="sw-instagram-modal-image sw-instagram-modal-single-video"><video autoplay="true" controls=""><source src="'+filtered_media[0]["media_url"]+'"></video></div>');
        } else {
            jQuery(".sw-instagram-modal-single-image").html("<img class='sw-instagram-single-image' src='"+filtered_media[0]["media_url"]+"'>");
        }
        
        jQuery(".sw-popup-info-caption").text(filtered_media[0]["caption"]);
        jQuery(".sw-popup-info-date").text(jQuery(this).find(".sw-instagram-item-overlay-date").text());
        if(!jQuery(".sw-instagram-modal").hasClass("is-active")) {
            jQuery(".sw-instagram-modal").toggleClass("is-active");
        }

        window.dispatchEvent(new Event('resize'));
    });

    jQuery(document).on("click", ".sw-instagram-modal-nav-prev", function() {
        let media_id = jQuery(".sw-instagram-modal").attr("data-id");
        if(jQuery(".sw-instagram-item[data-id='"+media_id+"']").closest(".sw-instagram-col").prev(".sw-instagram-col").length > 0) {
            jQuery(".sw-instagram-item[data-id='"+media_id+"']").closest(".sw-instagram-col").prev(".sw-instagram-col").find(".sw-instagram-item").trigger("click");
        }
    });


    jQuery(document).on("click", ".sw-instagram-modal-nav-next", function() {
        let media_id = jQuery(".sw-instagram-modal").attr("data-id");
        if(jQuery(".sw-instagram-item[data-id='"+media_id+"']").closest(".sw-instagram-col").next(".sw-instagram-col").length > 0) {
            jQuery(".sw-instagram-item[data-id='"+media_id+"']").closest(".sw-instagram-col").next(".sw-instagram-col").find(".sw-instagram-item").trigger("click");
        }
    });

    let innerCarouselIndex = 0;

    function handleInnerCarouselArrows() {
        if(innerCarouselIndex == 0) {
            jQuery(".sw-carousel-prev").addClass("sw-carousel-disabled");
        } else {
            jQuery(".sw-carousel-prev").removeClass("sw-carousel-disabled");
        }

        let total_slides = jQuery(document).find(".sw-carousel-slide").length;
        if(innerCarouselIndex == total_slides - 1) {
            jQuery(".sw-carousel-next").addClass("sw-carousel-disabled");
        } else {
            jQuery(".sw-carousel-next").removeClass("sw-carousel-disabled");
        }
        jQuery('video').each(function(){ this.pause() });

    }

    jQuery(document).on("click", ".sw-carousel-next", function() {
        let thiss = jQuery(document).find(".sw-carousel-slide.sw-carousel-current");
        if( thiss.next(".sw-carousel-slide").length > 0 ) {        
            let sw_index = thiss.next(".sw-carousel-slide").attr("data-sw-carousel-index");
            innerCarouselIndex = sw_index;
            let total_slides = jQuery(document).find(".sw-carousel-slide").length;
            let modal_width = jQuery(".sw-instagram-modal-body").width();
            jQuery(document).find(".sw-carousel-track").attr("style", "opacity: 1; width: "+(total_slides * modal_width)+"px; transform: translate3d(-"+(modal_width * sw_index)+"px, 0px, 0px);");
            thiss.next(".sw-carousel-slide").addClass("sw-carousel-current sw-carousel-active");
            jQuery(".sw-carousel-dots li[data-index='"+sw_index+"'").addClass("sw-carousel-active");
            jQuery(".sw-carousel-dots li[data-index='"+sw_index+"'").siblings().removeClass("sw-carousel-active");
            thiss.removeClass("sw-carousel-current sw-carousel-active");
        }
        handleInnerCarouselArrows();
    });


    jQuery(document).on("click", ".sw-carousel-prev", function() {
        let thiss = jQuery(document).find(".sw-carousel-slide.sw-carousel-current");
        if( thiss.prev(".sw-carousel-slide").length > 0 ) {
            let sw_index = thiss.prev(".sw-carousel-slide").attr("data-sw-carousel-index");
            innerCarouselIndex = sw_index;
            let total_slides = jQuery(document).find(".sw-carousel-slide").length;
            let modal_width = jQuery(".sw-instagram-modal-body").width();
            jQuery(document).find(".sw-carousel-track").attr("style", "opacity: 1; width: "+(total_slides * modal_width)+"px; transform: translate3d(-"+(modal_width * sw_index)+"px, 0px, 0px);");
            thiss.prev(".sw-carousel-slide").addClass("sw-carousel-current sw-carousel-active");
            jQuery(".sw-carousel-dots li[data-index='"+sw_index+"'").addClass("sw-carousel-active");
            jQuery(".sw-carousel-dots li[data-index='"+sw_index+"'").siblings().removeClass("sw-carousel-active");
            thiss.removeClass("sw-carousel-current sw-carousel-active");
        }
        handleInnerCarouselArrows();
    });


    jQuery(document).on("click", ".sw-carousel-dots li", function(){
        jQuery(this).addClass("sw-carousel-active");
        jQuery(this).siblings().removeClass("sw-carousel-active");
        let clicked_index = jQuery(this).attr("data-index");
        innerCarouselIndex = clicked_index;
        jQuery(".sw-carousel-slide").removeClass("sw-carousel-current sw-carousel-active");
        jQuery(".sw-carousel-slide[data-sw-carousel-index='"+clicked_index+"'").addClass("sw-carousel-current sw-carousel-active");
        let total_slides = jQuery(document).find(".sw-carousel-slide").length;
        let modal_width = jQuery(".sw-instagram-modal-body").width();
        jQuery(document).find(".sw-carousel-track").attr("style", "opacity: 1; width: "+(total_slides * modal_width)+"px; transform: translate3d(-"+(modal_width * clicked_index)+"px, 0px, 0px);");
        handleInnerCarouselArrows();
    });
    

    jQuery(window).on("resize", function() {
        let modal_width = jQuery(".sw-instagram-modal-body").width();
        let total_slides = jQuery(document).find(".sw-carousel-slide").length;
        jQuery(".sw-carousel-slide").attr("style", "width: " + modal_width + "px;");
        jQuery(document).find(".sw-carousel-track").attr("style", "opacity: 1; width: "+(total_slides * modal_width)+"px; transform: translate3d(0px, 0px, 0px);");
    });
    
});


jQuery(window).load(function(){
    setTimeout(function(){
        window.dispatchEvent(new Event('resize'));
    }, 1000);
});