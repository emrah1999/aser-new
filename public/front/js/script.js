$(document).ready(function(){

    //youtube iframe
    $("[data-media]").on("touchstart click", function(e) {
        e.preventDefault();
        var $this = $(this);
        var videoUrl = $this.attr("data-media");
        var popup = $this.attr("href");
        var $popupIframe = $(popup).find("iframe");
        $popupIframe.attr("src", videoUrl);
        $this.closest(".video-link").addClass("show-popup");
    });
    $(".popup").on("touchstart click", function(e) {
        e.preventDefault();
        e.stopPropagation();
        $(".video-link").removeClass("show-popup");
        setTimeout(function(){
            $(".popup").find("iframe").attr("src", "")
        }, 100);
    });

    //remove meta tag
    var mediaQuery = window.matchMedia("(max-width:767px)");
    if(mediaQuery.matches) {
        $("meta").attr("content", "initial-scale=1.0, user-scalable=no");
    }

    Date.prototype.extractHours= function(h){
        this.setHours(this.getHours()-h);
        return this;
    };

    var time = new Date().extractHours(8);
    var h = time.getHours();
    var m = time.getMinutes();
    var d = new Date();


    h = (h < 10) ? ("0" + h) : h ;

    var m = d.getMinutes();
    m = (m < 10) ? ("0" + m) : m ;


    setInterval(function(){
        var datetext =  h + ":" + m;
        $(".currency-block time").text(datetext);
    }, 1000);




    $(document).on('click','.country-active',function(){
        var t = $(this)

        if(t.hasClass('active')) {
            $('.country-list').hide();
            t.removeClass('active')
        } else {
            $('.country-list').show();
            t.addClass('active')
        }
    })

    $(document).on('click','.country-list.no-reload a',function(){

        var t = $(this);

        $('.country-active').html($(this).html())
        $('.country-list').hide();
        $('.country-active').removeClass('active')

        if(t.parents('.special-order-country').length)
        {
            t.parents('.special-order-country').find('.special-order-btn').attr('href',t.attr('href'));
        }

        return false;

    })

    $(document).on("click", function(e){
        target = $(e.target);
        if(!target.is('.country-active') && !target.is('.country-list') && !target.parents().is(".country-list")) {
            $('.country-list').hide();
            $('.country-active').removeClass('active')
        }
    })

    $(document).on('click','.country-list.list-tab a',function(){
        var t = $(this)

        if(!t.hasClass('active'))
        {
            $('.cn-box').hide();
            $('#'+t.attr('data-id')).fadeIn();
            $('.country-list a').removeClass('active')
            t.addClass('active')
        }

        return false;
    })

    $(document).on('change','.order-status-select select',function(){
        window.top.location = $(this).val();
    })


    //label border animation
    $(".def-label input").on("focus", function(){
        $(this).parent(".def-label").addClass("lab-border");
    });
    $(".def-label input").on("blur", function(){
        $(this).parent(".def-label").removeClass("lab-border");
    });

    //faq content slide
    $(".faq-slide-ul li a").on("click", function(e){
        e.preventDefault();
        $(this).next().slideToggle(200);
        $(this).parent("li").toggleClass("open-slide");
    });

    //faq left menu slide
    $(".faq-menu-ul li a").on("click", function(e){
        e.preventDefault();
        var dataId , thiss;
        thiss = $(this);
        thiss.parent().siblings().find("a").removeClass("active");
        thiss.addClass("active");
        dataId = thiss.attr("data-id");
        $("html, body").animate({
            scrollTop:$('.faq-block[data-id="'+ dataId +'"]').offset().top-50
        }, 300, 'swing')
    })

    //google map
    function googleMap(id) {
        if($('#'+id).length > 0) {
            var marker;
            var coordinate = $('#'+id).attr('data-coordinate').split(',')
            function initMap() {
            var map = new google.maps.Map(document.getElementById(id), {
                zoom: 13,
                center: {lat: parseFloat(coordinate[0]), lng: parseFloat(coordinate[1])}
            });
            marker = new google.maps.Marker({
                map: map,
                draggable: true,
                animation: google.maps.Animation.DROP,
                position: {lat: parseFloat(coordinate[0]), lng: parseFloat(coordinate[1])},
                icon: {
                    url: '/css/image/icon/map-marker-big.png',
                    scaledSize: new google.maps.Size(41,50),
                    origin: new google.maps.Point(0,0),
                    anchor: new google.maps.Point(0,0)
                },
            });
            marker.addListener('click', toggleBounce);
            }
            function toggleBounce() {
                if (marker.getAnimation() !== null) {
                marker.setAnimation(null);
                } else {
                marker.setAnimation(google.maps.Animation.BOUNCE);
                }
            }
            google.maps.event.addDomListener(window, 'load', initMap);
        }
    }
    googleMap('contact-map');

    //colorbox
    $(".colorbox-button").on("click", function(){
        dataWidth = $(this).attr("data-width");
        var x = window.matchMedia("(max-width: 767px)")
        if (x.matches) {
            dataWidth = 100;
        }
        $(".colorbox-button").colorbox({
            inline:true,
            width:dataWidth + "%",
            escKey:true,
            close:false
        });
    });
    $(".colorbox-exit").on("click", function(){
        $.colorbox.close();
    });


    //search form
    $(".search-button").on("click", function(e){
        var element = $(".main-search-block");

        if(element.css('top') !== '0px') {
            $(".main-search-block").stop().animate({
                top:0
            }, 100,'swing')
        }
        if(element.css('top') == '0px') {
            $(".main-search-block").stop().animate({
                top:'-60px'
            }, 100, 'swing')
        }

    });
    // $("*").on("click", function(e){
    //     target = $(e.target);
    //     if(target.is('.search-form') || target.parents().is(".static-search")) {
    //         $(".main-search-form").slideDown(200);
    //     }else if(target.is(".search-button") || target.parents().is(".search-button")) {
    //         return;
    //     }else {
    //         $(".main-search-form").slideUp(200);
    //     }
    // })

    //banner slider
    $(".bxslider").bxSlider({
        auto:true,
        pager:false,
        controls:true,
        autoControls:true,
        mode:'fade',
        speed:500,
        easing:'swing'
    });



    // /***** animation slider *****/
    // function animation_slider(className, timer) {
    //     var slider , slider_li, slider_length, slider_index;
    //     slider = $(".animate-slider");
    //     slider_li = slider.find("li");
    //     slider_length = slider_li.length;
    //     activeIndex = slider_li.siblings("li.active").index();
    //     slider.attr('data-slider', activeIndex);
    //     slider_index = slider.attr('data-slider');

    //     $.slide = function(){
    //         if(slider_index < slider_length - 1 ) {
    //             slider_index++;
    //             slider.attr("data-slider", slider_index );
    //         }else {
    //             slider_index = 0;
    //             slider.attr("data-slider", slider_index );
    //         }
    //         slider.find("li").removeClass(className);
    //         slider.find("li").removeClass("index");
    //         slider_li.eq(slider_index).addClass(className);
    //         timer2 =timer - 500;
    //         setTimeout(function(){
    //             slider_li.eq(slider_index).addClass('index');
    //         }, timer2);
    //             var $div =slider.find("li." + className + " p").clone().html('');
    //         slider.find("li." + className + " p").contents().each(function(){
    //             $textArray = $(this).text().split('');
    //             for (var i = 0; i < $textArray.length; i++) {
    //                 $('<span style="animation-delay:' + i * 0.03 +'s"> ').text($textArray[i]).appendTo($div);
    //             }
    //         });

    //         if(slider.find("li.active").index() == 0 ) {
    //             if(slider.find("li:last p span").length > 0) {
    //                 getLastText = slider.find("li:last p span").text();
    //                 slider.find("li:last p").html(getLastText);
    //             }
    //         }else {
    //             getPrevText = slider.find("li." + className).prev().find("p span").text();
    //             slider.find("li." + className).prev().find("p").html(getPrevText);
    //         }

    //         slider.find("li." + className + " p").replaceWith($div);
    //     }
    //     setInterval(" $.slide()", timer);

    //     slider.find("li." + className + " p").each(function (index) {

    //         var characters = $(this).text().split("");
    //         timer2 =timer- 500;
    //         $this = $(this);
    //         $this.empty();
    //         $.each(characters, function (i, el) {
    //         $this.append("<span style='animation-delay:" + i * 0.03 +"s'>" + el + "</span");
    //         });

    //         setTimeout(function(){
    //         slider.find("li." + className).addClass("index");
    //         }, timer2 )

    //     });

    // }
    // animation_slider('active', 5000);

    /***** animation slider *****/
    function animation_slider(className, timer) {
        var slider , slider_li, slider_length, slider_index;
        slider = $(".animate-slider");
        slider_li = slider.find("li");
        slider_length = slider_li.length;
        activeIndex = slider_li.siblings("li.active").index();
        slider.attr('data-slider', activeIndex);
        slider_index = slider.attr('data-slider');

        $.slide = function(){
            if(slider_index < slider_length - 1 ) {
                slider_index++;
                slider.attr("data-slider", slider_index );
            }else {
                slider_index = 0;
                slider.attr("data-slider", slider_index );
            }
            slider.find("li").removeClass(className);
            slider.find("li").removeClass("index");
            slider_li.eq(slider_index).addClass(className);
            timer2 =timer - 500;
            setTimeout(function(){
                slider_li.eq(slider_index).addClass('index');
            }, timer2);
                var $div =slider.find("li." + className + " p").clone().html('');
            slider.find("li." + className + " p").contents().each(function(){
                $textArray = $(this).text().split('');
                for (var i = 0; i < $textArray.length; i++) {
                    if($textArray[i] == ' ') {
                        $textArray[i] = " <div class='word-break'></div>";
                    }
                    $('<span style="animation-delay:' + i * 0.03 +'s"> ').html($textArray[i]).appendTo($div);
                }
            });

            if(slider.find("li.active").index() == 0 ) {
                if(slider.find("li:last p span").length > 0) {
                    getLastText = slider.find("li:last p span").text();
                    slider.find("li:last p").html(getLastText);
                }
            }else {
                getPrevText = slider.find("li." + className).prev().find("p span").text();
                slider.find("li." + className).prev().find("p").html(getPrevText);
            }

            slider.find("li." + className + " p").replaceWith($div);
        }
        setInterval(" $.slide()", timer);

        slider.find("li." + className + " p").each(function (index) {

            var characters = $(this).text().split("");
            timer2 =timer- 500;
            $this = $(this);
            $this.empty();
            $.each(characters, function (i, el) {
            if(characters[i] == ' ') {
               characters[i] = " <div class='word-break'></div>"
            }
            $this.append("<span style='animation-delay:" + i * 0.03 +"s'>" +  characters[i]  + "</span");
            });

            setTimeout(function(){
            slider.find("li." + className).addClass("index");
            }, timer2 )

        });

    }
    animation_slider('active', 5000);


    // Lightbox
    if($('.example-img').length)
	{
		$('.example-img').simpleLightbox();
	}

})
