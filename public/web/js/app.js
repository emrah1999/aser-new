$(document).ready(function(){
    //BODY ANIMATION
    $("body").animate({
        opacity: 1
    }, 1000);

    //OWL CAROUSELS
    $(".owlMain").owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        nav: true,
        navText: ["<img src='/web/images/content/slider-chevron-left.png' alt='Previous'>", "<img src='/web/images/content/slider-chevron-right.png' alt='Next'>"],
        dots: true
    });

    $(".owlPartners").owlCarousel({
        items: 4,
        margin: 20,
        loop: true,
        autoplay: true,
        autoplayTimeout: 5000,
        autoplayHoverPause: true,
        nav: true,
        navText: ["<img src='/web/images/content/slider-chevron-left.png' alt='Previous'>", "<img src='/web/images/content/slider-chevron-right.png' alt='Next'>"],
        dots: false,
        responsive: {
            0: {
                items: 1
            },
            575: {
                items: 2
            },
            768: {
                items: 3
            },
            992: {
                items: 4
            }
        }
    });

    //FORMS
    $.extend($.validator.messages, {
        required: "Bu sahə boş ola bilməz",
        email: "Zəhmət olmasa düzgün e-poçt ünvanı daxil edin",
        equalTo: "Parol uyğunsuzluğu",
        maxlength: jQuery.validator.format("Zəhmət olmasa, ən çox {0} simvol daxil edin."),
        minlength: jQuery.validator.format("Zəhmət olmasa, ən azı {0} simvol daxil edin")
    });

    $.validator.addMethod("letters", function(value, element) {
        return this.optional(element) || value == value.match(/^[a-zA-Z ]*$/);
    });

    $.validator.addMethod("valueNotEquals", function(value, element, arg){
        return arg !== value;
    }, "Bu sahə boş ola bilməz");

    $("#formCalculator").validate({
        errorClass: 'form-error-text',
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#formRegistrationPhysical").validate({
        errorClass: 'form-error-text',
        rules: {
            passport_number: {
                minlength: function (){
                    if ($("#userPassportSeria").val() === "AA" ||
                    $("#userPassportSeria").val() === "AZE" ||
                    $("#userPassportSeria").val() === "DYI"){

                        return 7;
                    }
                    if ($("#userPassportSeria").val() === "AZE"){
                        return 8;
                    }
                },
                maxlength: function (){
                    if ($("#userPassportSeria").val() === "AA" ||
                        $("#userPassportSeria").val() === "MYI" ||
                        $("#userPassportSeria").val() === "DYI"){
                        return 7;
                    }
                    if ($("#userPassportSeria").val() === "AZE"){
                        return 8;
                    }
                }
            },
            passport_fin: {
                minlength: function (){
                    if ($("#userPassportSeria").val() === "AA" ||
                        $("#userPassportSeria").val() === "AZE" ||
                        $("#userPassportSeria").val() === "MYI"){

                        return 7;
                    }
                    if ($("#userPassportSeria").val() === "DYI"){
                        return 6;
                    }
                },
                maxlength: function (){
                    if ($("#userPassportSeria").val() === "AA" ||
                        $("#userPassportSeria").val() === "AZE" ||
                        $("#userPassportSeria").val() === "MYI"){

                        return 7;
                    }
                    if ($("#userPassportSeria").val() === "DYI"){
                        return 6;
                    }
                }
            },
            password: {
                required: true,
                minlength: 5
            },
            user_password2: {
                required: true,
                minlength: 5,
                equalTo: "#userPassword"
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#formRegistrationJuridical").validate({
        errorClass: 'form-error-text',
        rules: {
            passport_number: {
                minlength: function (){
                    if ($("#userPassportSeria").val() === "AA" ||
                    $("#userPassportSeria").val() === "AZE" ||
                    $("#userPassportSeria").val() === "DYI"){

                        return 7;
                    }
                    if ($("#userPassportSeria").val() === "AZE"){
                        return 8;
                    }
                },
                maxlength: function (){
                    if ($("#userPassportSeria").val() === "AA" ||
                        $("#userPassportSeria").val() === "MYI" ||
                        $("#userPassportSeria").val() === "DYI"){
                        return 7;
                    }
                    if ($("#userPassportSeria").val() === "AZE"){
                        return 8;
                    }
                }
            },
            passport_fin: {
                minlength: function (){
                    if ($("#userPassportSeria").val() === "AA" ||
                        $("#userPassportSeria").val() === "AZE" ||
                        $("#userPassportSeria").val() === "MYI"){

                        return 7;
                    }
                    if ($("#userPassportSeria").val() === "DYI"){
                        return 6;
                    }
                },
                maxlength: function (){
                    if ($("#userPassportSeria").val() === "AA" ||
                        $("#userPassportSeria").val() === "AZE" ||
                        $("#userPassportSeria").val() === "MYI"){

                        return 7;
                    }
                    if ($("#userPassportSeria").val() === "DYI"){
                        return 6;
                    }
                }
            },
            password: {
                required: true,
                minlength: 5
            },
            user_password2: {
                required: true,
                minlength: 5,
                equalTo: "#userPassword"
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#formLogin").validate({
        errorClass: 'form-error-text',
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#formCargomat").validate({
        errorClass: 'form-error-text',
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#formTrust").validate({
        errorClass: 'form-error-text',
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#formCurier").validate({
        errorClass: 'form-error-text',
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#formContact").validate({
        errorClass: 'form-error-text',
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#formTrackingSearch").validate({
        errorClass: 'form-error-text',
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#formModalProfileBalanceAdd").validate({
        errorClass: 'form-error-text',
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#formProfileBalanceConfirmation").validate({
        errorClass: 'form-error-text',
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#formModalProfilePromocodeAdd").validate({
        errorClass: 'form-error-text',
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#formProfileCurier").validate({
        errorClass: 'form-error-text',
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#formProfileAzerpoct").validate({
        errorClass: 'form-error-text',
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#formProfileInformationEdit").validate({
        errorClass: 'form-error-text',
        submitHandler: function(form) {
            form.submit();
        }
    });

    $("#formProfilePasswordEdit").validate({
        errorClass: 'form-error-text',
        rules: {
            password: {
                required: true,
                minlength: 5
            },
            user_re_new_password: {
                required: true,
                minlength: 5,
                equalTo: "#password"
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });

    $(".form-registration__btn-action--next").click(function (){
        var isAgree = $(".form-checkbox__input").is(":checked");
        if ($("form").is($("#formRegistrationPhysical"))){
            if ($("#formRegistrationPhysical").valid() && isAgree){
                $(".form-registration__content--1").addClass("d-none");
                $(".form-registration__content--2").removeClass("d-none");
                $(".form-registration__btn-actions--1").addClass("d-none");
                $(".form-registration__btn-actions--2").removeClass("d-none");
            } else {
                $(".form-checkbox__span").addClass("form-checkbox__span--error");
            }
        }
        if ($("form").is($("#formRegistrationJuridical"))){
            if ($("#formRegistrationJuridical").valid() && isAgree){
                $(".form-registration__content--1").addClass("d-none");
                $(".form-registration__content--2").removeClass("d-none");
                $(".form-registration__btn-actions--1").addClass("d-none");
                $(".form-registration__btn-actions--2").removeClass("d-none");
            } else {
                $(".form-checkbox__span").addClass("form-checkbox__span--error");
            }
        }
    });

    $(".form-registration__btn-action--prev").click(function (){
        $(".form-registration__content--1").removeClass("d-none");
        $(".form-registration__content--2").addClass("d-none");
        $(".form-registration__btn-actions--1").removeClass("d-none");
        $(".form-registration__btn-actions--2").addClass("d-none");
    });

    $(".form .form__input").focus(function (){
        $(this).addClass("form__input--active");
    });

    $(".form .form__input").blur(function (){
        var inputTextLength = $(this).val().length;
        if(inputTextLength === 0){
            $(this).removeClass("form__input--active");
        }
    });

    $(".form .form__select").focus(function (){
        $(this).addClass("form__select--active");
    });

    // $(".form .form__select").blur(function (){
    //     var inputTextLength = $(this).val().length;
    //     if(inputTextLength === 0){
    //         $(this).removeClass("form__select--active");
    //     }
    // });

    // COUNTDOWN
    var timer2 = "02:00";
    var interval = setInterval(function() {
        var timer = timer2.split(":");
        var minutes = parseInt(timer[0], 10);
        var seconds = parseInt(timer[1], 10);
        --seconds;
        minutes = (seconds < 0) ? --minutes : minutes;
        if (minutes < 0 ) clearInterval(interval);
        seconds = (seconds < 0) ? 59 : seconds;
        seconds = (seconds < 10) ? "0" + seconds : seconds;
        if (minutes>=0 && seconds>=0){
            $(".modal-otp__title-time").html(minutes + ":" + seconds);
        }
        timer2 = minutes + ":" + seconds;
    }, 1000);

    // OTP
    var otp_fields = $(".form-confirmation-otp .form__otp-field");
    var otp_value_field = $(".form-confirmation-otp .form__otp-value");
    var otpCount = 0;

    otp_fields.on("input", function (e) {
        $(this).val($(this).val().replace(/[^0-9]/g, ""));
        var opt_value = "";
        otp_fields.each(function () {
            let field_value = $(this).val();
            if (field_value != "") opt_value += field_value;
        });
        otp_value_field.val(opt_value);
    }).on("keyup", function (e) {
        var key = e.keyCode || e.charCode;
        if (key == 8 || key == 46 || key == 37 || key == 40) {
            // Backspace or Delete or Left Arrow or Down Arrow
            $(this).prev().focus();
            $(this).removeClass("form__otp-field--active");
            otpCount = --otpCount;
            if (otpCount < 4) {
                if (otpCount < 0){
                    otpCount = 0;
                }
                $(".form-confirmation-otp__btn").attr("disabled","disabled");
            }
        } else if (key == 38 || key == 39 || $(this).val() != "") {
            // Right Arrow or Top Arrow or Value not empty
            $(this).next().focus();
            $(this).addClass("form__otp-field--active");
            otpCount = ++otpCount;
            if (otpCount >= 4) {
                otpCount = 4;
                $(".form-confirmation-otp__btn").removeAttr("disabled");
            }
        }
    }).on("paste", function (e) {
        var paste_data = e.originalEvent.clipboardData.getData("text");
        var paste_data_splitted = paste_data.split("");
        $.each(paste_data_splitted, function (index, value) {
            otp_fields.eq(index).val(value);
        });
    });

    // ACTIVE MAP CHANGE
    $(".thumbnail-branches__link").click(function (e){
        e.preventDefault();
        var mapLink = $(this).attr("data-map");
        $(".media-branches__map").attr("src", mapLink);
    });

    // ACTIVE CATEGORY CHANGE
    $(".nav-tab-categories__link").click(function (){
        $(".nav-tab-categories__link").removeClass("nav-tab-categories__link--active");
        $(this).addClass("nav-tab-categories__link--active");
    });

    //MOBILE MENU
    $(".mobile-menu").click(function(){
        $(".menu-mobile-block").toggleClass("d-none");
    });

    $(".nav-languages__link").click(function (e){
        e.preventDefault();
        $(".nav-languages-2").toggleClass("d-none");
    });

    //MENU
    $(".nav-menu__link").click(function (){
        $(".nav-menu__link").not(this).removeClass("nav-menu__link--active");
        $(this).closest("li").find(".nav-menu-dropdown").toggleClass("d-none");
        $(this).toggleClass("nav-menu__link--active");
        $(this).find(".nav-menu__link-img").eq(0).toggleClass("d-none");
        $(this).find(".nav-menu__link-img").eq(1).toggleClass("d-none");
    });

    $("#userSendLocation").on("change", function(e) {
        var initialValue = $(this).val();
        if(initialValue === "0"){
            $(".internalLocation").addClass("form-profile-curier__label--no-active");
            $(".internalLocation").removeClass("form-profile-curier__label--active");
            $("input[name='user_send_internal_payment_type']").attr("disabled", "disabled");
            $("input[name='user_send_internal_payment_type']").removeAttr("checked");

            $(".externalLocation").addClass("form-profile-curier__label--no-active");
            $(".externalLocation").removeClass("form-profile-curier__label--active");
            $("input[name='user_send_external_payment_type']").attr("disabled", "disabled");
            $("input[name='user_send_external_payment_type']").removeAttr("checked");
        } else{
            $(".internalLocation").removeClass("form-profile-curier__label--no-active");
            $(".internalLocation").removeClass("form-profile-curier__label--active");
            $("input[name='user_send_internal_payment_type']").removeAttr("disabled");
            $("input[name='user_send_internal_payment_type']").removeAttr("checked", "checked");
        }
    });

    $("input[name='user_send_internal_payment_type']").click(function(e){
        e.preventDefault();
        $("input[name='user_send_internal_payment_type']").removeAttr("checked");
        $(this).attr("checked", "checked");
        $(".internalLocation").removeClass("form-profile-curier__label--active");
        $(this).parent().find(".internalLocation").addClass("form-profile-curier__label--active");
        $(".externalLocation").removeClass("form-profile-curier__label--no-active");
        $(".externalLocation").removeClass("form-profile-curier__label--active");
        $("input[name='user_send_external_payment_type']").removeAttr("disabled");
        $("input[name='user_send_external_payment_type']").removeAttr("checked");
    });

    $("input[name='user_send_external_payment_type']").click(function(e){
        e.preventDefault();
        $("input[name='user_send_external_payment_type']").removeAttr("checked");
        $(this).attr("checked", "checked");
        $(".externalLocation").removeClass("form-profile-curier__label--active");
        $(this).parent().find(".externalLocation").addClass("form-profile-curier__label--active");
    });


    $(".btnProfileCurierOrders").click(function(){
        $(".table-orders-result-preview").addClass("d-none");
        $(".table-orders-result-preview tbody tr").remove();
    });

    $(".btnProfileAzerpoctOrders").click(function(){
        $(".table-orders-result-preview").addClass("d-none");
        $(".table-orders-result-preview tbody tr").remove();
    });


    $(".btnOrderSelect").click(function(){
        $(".modal-profile-curier-orders__img-close").click();
        $(".table-orders-result-preview").removeClass("d-none");
        var orderSelectedBlockLength = 0;
        $(".orderBlock").each(function(){
            if($(this).find("input").is(":checked")){
                orderSelectedBlockLength++;
                var orderId = $(this).find(".orderId").text();
                var orderPrice = $(this).find(".orderPrice").text();
                var orderPrice2 = $(this).find(".orderPrice2").text();
                var orderPrice3 = $(this).find(".orderPrice3").text();
                $(".table-orders-result-preview tbody").append("<tr class='table-orders-result-preview__tr'><td class='table-orders-result-preview__td'>" + orderId +"</td><td class='table-orders-result-preview__td'>" + orderPrice +"</td><td class='table-orders-result-preview__td'>"+ orderPrice2 +"</td><td class='table-orders-result-preview__td'>" + orderPrice3 + "</td></tr>");
            }
        });
        if(orderSelectedBlockLength === 0){
            $(".table-orders-result-preview").addClass("d-none");
        }
    });

    var orderCheck = 0;
    $("#userSendOrders").click(function(){
        if(orderCheck === 0){
            orderCheck = 1;
            $("input[name='user_send_orders[]']:not(:checked)").not("#userSendOrders").click();
        } else{
            orderCheck = 0;
            $("input[name='user_send_orders[]']:checked").not("#userSendOrders").click();
        }
    });


    //MANUAL DATA
    var sendLocationData = [
        {
            "id": 1,
            "title": "Baki",
            "postIndexes": [
                {
                    "id": 1,
                    "title": "AZ1129"
                },
                {
                    "id": 2,
                    "title": "AZ1130"
                },
            ]
        },
        {
            "id": 2,
            "title": "Sumqayit",
            "postIndexes": [
                {
                    "id": 3,
                    "title": "AZ1131"
                }
            ]
        }
    ];

    $("#userSendLocation").change(function(){
        var sendLocation = Number($(this).val());
        $("#userSendPostIndex > option[value!=0]").remove();
        for(var i=0; i<sendLocationData.length;i++){
            if(sendLocationData[i].id === sendLocation){
                for(var j=0;j<sendLocationData[i].postIndexes.length;j++){
                    $("#userSendPostIndex").append("<option value='"+sendLocationData[i].postIndexes[j].id+"'>"+sendLocationData[i].postIndexes[j].title+"</option>");
                }
            }
        }
    });

    //MANUAL DATA
    var sendLocationData2 = [
        {
            "id": 1,
            "title": "1-2 Alatava (Yasamal rayonu)",
            "postIndexes": [
                {
                    "id": 1,
                    "title": "28 May"
                },
                {
                    "id": 2,
                    "title": "20 Yanvar"
                },
            ]
        },
        {
            "id": 2,
            "title": "1-ci Mikrorayon (Nəsimi rayonu)",
            "postIndexes": [
                {
                    "id": 3,
                    "title": "28 May"
                }
            ]
        }
    ];

    $("#userSendLocation").change(function(){
        var sendLocation2 = Number($(this).val());
        $("#userSendMetro > option[value!=0]").remove();
        for(var i=0; i<sendLocationData2.length;i++){
            if(sendLocationData2[i].id === sendLocation2){
                for(var j=0;j<sendLocationData2[i].postIndexes.length;j++){
                    $("#userSendMetro").append("<option value='"+sendLocationData2[i].postIndexes[j].id+"'>"+sendLocationData2[i].postIndexes[j].title+"</option>");
                }
            }
        }
    });
});