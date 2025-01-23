// $(document).on('click','.sp-product-control',function(){
//     var t = $(this);
//
//     if(t.hasClass('btn-add'))
//     {
//         var product = t.parents('.sp-product-block').clone();
//         product.find('input').val('');
//         product.find('.n-product-info').removeClass('active')
//         t.parents('.sp-product-list').append(product);
//     } else {
//
//         if($('.sp-product-list .sp-product-block').length > 1)
//         {
//             t.parents('.sp-product-block').remove();
//
//             calculateTotalAmount();
//         }
//     }
//
//     $('.sp-product-block').each(function(){
//
//         var t = $(this)
//
//         if(!t.is('.sp-product-block:last'))
//         {
//             var btn = t.find('.btn');
//             btn.removeClass('btn-success btn-add').addClass('btn-danger btn-remove').html(btn.attr('data-title'));
//         }
//
//     })
// })


// Calculator

$(document).on('click','.calculate-button',function(){
    calculateWeight();
})

$(document).on('change','select#country',function(){
    calculateWeight();
})


function calculateWeight()
{
    var country_el = $('.country-select select :selected');

    var tariff_list = $.parseJSON(country_el.attr('data-price'));
    var currency_icon = country_el.attr('data-currency');

    var weight_el = $('#weight').val();
    var weight_num = $('#weight-input').val();
    // alert(weight_el)
    var net_kq = weight_el == 'kq' ? parseFloat(weight_num) : parseInt(weight_num)/1000;
    var price = 0;

    var options = {
      useEasing: false,
      useGrouping: true,
      separator: '',
      decimal: '.',
    };

    $('.currency-el').html(currency_icon)

    if(currency_icon == '<i class="fas fa-dollar-sign"></i>') {
        $('.currency-el').insertBefore('#count-el')
    } else {
        $('.currency-el').insertAfter('#count-el')
    }

    tariff_list.forEach(function(tariff){

        if(net_kq !=0 && net_kq >= tariff.from_weight && net_kq <= tariff.to_weight)
        {
            var countUp = new CountUp('count-el', 0, tariff.price, 2, 0.5, options);
            countUp.start();
            return false;

        } else if(net_kq !=0 && net_kq >= tariff.from_weight && tariff.to_weight == '') {

            var w_price = net_kq*tariff.price;

            var countUp = new CountUp('count-el', 0, w_price, 2, 0.5, options);
            countUp.start();
            return false;
        }

    })
}

//  $(document).on('change','.n-order-form-turkey .field-specialorder-product_count input,.n-order-form-turkey .field-specialorder-product_price input, .n-order-form-turkey .field-specialorder-product_link input',function()
//  {
//
//     var t = $(this);
//
//     if(t.parents('.field-specialorder-order_note').length || t.parents('.field-specialorder-product_count').length)
//     {
//         calculateTotalAmount();
//         return false;
//     }
//
//     $('body').addClass('body-loading ajax-loading')
//
//     $.ajax({
//         url: '/account/fetch-url',
//         type: 'post',
//         data: t.parents('form').serialize(),
//         dataType: 'json',
//         success: function(data) {
//
//             if(data.success)
//             {
//                 $('body').removeClass('body-loading ajax-loading ')
//
//                 $('.n-order-form-turkey').html(data.response);
//             }
//
//             // if(!data)
//             // {
//             //     p.find('.n-product-info').removeClass('spinner active');
//             // } else {
//             //     p.find('.n-product-info').removeClass('spinner');
//
//             //     p.find('.n-product-img img').attr('src',data.img).fadeIn();
//             //     p.find('.n-product-title a').html(data.title);
//             //     p.find('.n-product-title a').attr('href',t.val());
//
//             //     p.find('.field-specialorder-product_count input').val(1)
//             //     p.find('.field-specialorder-product_price input').val(data.price).trigger('change')
//             // }
//         }
//     });
//
// });


// function calculateTotalAmount()
// {
//     var price = 0;
//
//     $('.sp-product-block').each(function(i)
//     {
//         var t = $(this);
//         var product_price = t.find('.field-specialorder-product_price input').val();
//         var product_count = t.find('.field-specialorder-product_count input').val();
//
//         if(product_price !='' && product_count !='')
//         {
//             product_price = parseFloat(product_price);
//             product_count = parseInt(product_count);
//
//             var item_price = product_price*product_count;
//             item_price = (item_price + item_price*5/100);
//             t.find('.n-tax-info span').html(item_price.toFixed(2) + ' TL')
//             price += item_price;
//         }
//     })
//
//     // Calculate 5% tax
//
//     var full_price = price.toFixed(2);
//
//     $('.total-price-span').html(full_price)
//
// }

// $(document).on('change','.field-specialorder-product_count input, .field-specialorder-product_price input',function()
// {
    // var price = 0;

    // $('.sp-product-block').each(function(i)
    // {
    //     var t = $(this);
    //     var product_price = t.find('.field-specialorder-product_price input').val();
    //     var product_count = t.find('.field-specialorder-product_count input').val();

    //     if(product_price !='' && product_count !='')
    //     {
    //         product_price = parseFloat(product_price);
    //         product_count = parseInt(product_count);

    //         var item_price = product_price*product_count;
    //         price += item_price;
    //     }
    // })

    // // Calculate 5% tax

    // var full_price = (price + (price*5/100)).toFixed(2);

    // $('.total-price-span').html(full_price)

// })


// $(document).on('beforeSubmit','#special-order-form', function(event, jqXHR, settings) {
//     var form = $(this);
//
//     if(form.find('.required-field').length>0)
//     {
//         form.find('.required-field').each(function(i){
//             var field =$(this);
//
//             if(field.val() =='')
//             {
//                 field.parent().find('.help-block').html(field.attr('data-error')).fadeIn();
//                 field.parent().addClass('has-error');
//             } else {
//                 field.parent().removeClass('has-error');
//             }
//
//         })
//     }
//
//     if (form.find('.has-error').length > 0)
//         return false;
//
//
//
//     var spinner = form.parents('.orange-spinner');
//     spinner.addClass('active')
//
//     setTimeout(function(){
//         $.ajax({
//             url: form.attr('action'),
//             type: 'post',
//             data: form.serialize(),
//             dataType: 'json',
//             success: function(data) {
//
//
//                 spinner.removeClass('active')
//             }
//         });
//     },500)
//
//     return false;
// });

// STORE FILTER BLOCK

$(document).on('change','.filter-block select',function(){
    $(this).parents('form').submit();
})



// $(document).on('change', '.image_upload_file', function() {
//     var progressBar = $('.progressBar'),
//         bar = $('.progressBar .bar'),
//         percent = $('.progressBar .percent');
//
//     $('#image_upload_form').ajaxForm({
//         beforeSend: function() {
//
//             progressBar.fadeIn();
//             var percentVal = '0%';
//             bar.width(percentVal)
//             percent.html(percentVal);
//         },
//         uploadProgress: function(event, position, total, percentComplete) {
//             var percentVal = percentComplete + '%';
//             bar.width(percentVal)
//             percent.html(percentVal);
//         },
//         success: function(html, statusText, xhr, $form) {
//             obj = $.parseJSON(html);
//             if (obj.status) {
//                 var percentVal = '100%';
//                 bar.width(percentVal)
//                 percent.html(percentVal);
//                 $("#imgArea").prop('src', obj.image_medium);
//             } else {
//                 alert(obj.error);
//             }
//         },
//         complete: function(xhr) {
//             progressBar.fadeOut();
//         }
//     }).submit();
//
// });


// $(document).on('click','.add-more',function(){
//     var t = $(this)
//     var clone = $('.list-item:last').clone();
//     $('.list-item').find('.remove-item');
//     clone.find('input,select').val('')
//     $('.order-product-list').append(clone)
//     $('.remove-item').addClass('show-button')
//     return false;
// })

// $(document).on('click','.remove-item',function(){
//     var t = $(this);
//     if($('.list-item').length>1)
//     {
//         t.parents('.list-item').remove();
//     }
//
//     if($('.list-item').length <2){
//         $('.remove-item').removeClass('show-button')
//     }
//     return false;
// })

// if($('#fine-uploader-gallery').length>0)
// {
//     var imagesList = [];
//     $('#fine-uploader-gallery').fineUploader({
//         debug: false,
//         button: document.getElementsByClassName('file-div')[0],
//         autoUpload: false,
//         template: 'qq-template-gallery',
//         form: {
//             interceptSubmit: true
//         },
//         request: {
//             endpoint: '/ajax/upload',
//             customHeaders: {
//                 'X-CSRFToken': $('meta[name="csrf-token"]').attr('content')
//             },
//             params: {
//                 'upload': true,
//                 '_csrf': $('meta[name="csrf-token"]').attr('content'),
//             }
//         },
//         deleteFile: {
//             enabled: true,
//             method: 'POST',
//             endpoint: $(document).find('.seller-form').length> 0 ? '/ajax/upload-seller-file' :'/ajax/upload-gift',
//             customHeaders: {
//                 'X-CSRFToken': $('meta[name="csrf-token"]').attr('content')
//             },
//             params: {
//                 'delete': true,
//                 '_csrf': $('meta[name="csrf-token"]').attr('content')
//             }
//         },
//         editFilename: {
//             enabled: true
//         },
//         thumbnails: {
//             placeholders: {
//                 notAvailablePath: '/fine-uploader/placeholders/not_available-generic.png'
//             }
//         },
//         validation: {
//             itemLimit: 1,
//             // sizeLimit: 1024*1024*2,
//             allowedExtensions: ['pdf', 'jpg', 'png','docx','jpeg'],
//         },
//         text: {
//             defaultResponseError: 'An unknown upload error occurred.'
//         },
//         messages: {
//             typeError: $('.file-error').text(),
//             tooManyItemsError: $('.file-count').text(),
//             sizeError: $('.file-volume').text(),
//             retryFailTooManyItemsError: $('.upload-error').text(),
//             onLeave: 'If you are leave upload will be canceled',
//             noFilesError: $('.file-not-selected').text(),
//             minWidthImageError: $('.file-size-error').text(),
//             minHeightImageError: $('.file-size-error').text(),
//             emptyError: '{file} is empty, please select files again without it.'
//         },
//         callbacks: {
//             onError: function(id, name, errorReason, xhrOrXdr) {
//                 console.log([id, name, errorReason]);
//             },
//             onDelete: function(id) {
//                 // ...
//                 // alert('ok')
//             },
//             onDeleteComplete: function(id, xhr, isError) {
//                 var index = imagesList.indexOf(id);
//                 imagesList.splice(index, 1);
//             },
//             onComplete: function(id, name, responseJSON, xhr) {
//             },
//             onAllComplete: function(succeeded, failed) {
//                 imagesList = [];
//                 window.top.location = '/account/order-requested';
//             },
//             onSubmit: function(id, name) {
//
//
//             },
//             onStatusChange: function(id, oldStatus, newStatus) {
//             }
//         }
//     });
// }



$('.consolidate-icon').popover({
  trigger: 'hover'
})

$(document).on('click','.consolidate-order',function(){
    $('.consolidate-list').fadeIn(200);
})


$(document).on('change','.store-selection select',function(){
    var t = $(this);
    if(t.val() == 0)
    {
        $('.hidden-store').removeClass('hidden');
        $('#userorder-shop_typed_name').val('-')

    } else {
        $('.hidden-store').addClass('hidden');
        $('#userorder-shop_typed_name').val(t.val())
    }
})


function copyToClipboard(text) {

   var textArea = document.createElement( "textarea" );
   textArea.value = text;
   document.body.appendChild( textArea );

   textArea.select();

   try {
      var successful = document.execCommand( 'copy' );
      var msg = successful ? 'successful' : 'unsuccessful';
      console.log('Copying text command was ' + msg);
   } catch (err) {
      console.log('Oops, unable to copy');
   }

   document.body.removeChild( textArea );
}

function getOptions(categories) {
    let countryId = $("#userorder-country input:checked").val();
    let options = '';
    categories.forEach(async function(category, index) {
        if (countryId == 10) {
            if (category.country_id == countryId) {
                options += '<option class="category-option" value="' + category.id + '">' + category.name + '</option>'
            }
        } else {
	    if (category.country_id == null) {           
		options += '<option class="category-option" value="' + category.id + '">' + category.name + '</option>'
	    }
        }
    });
    $('#category_id').find('.category-option').remove();
    document.getElementById('category_id').innerHTML += options;
}

 $( '.referal-input input' ).click( function()
 {
    var t = $(this)
    clipboardText = t.val();
    copyToClipboard( clipboardText );
    alert( t.attr('copy-text') );

 });


 $(document).on('click','.control-password',function(){
    var t = $(this)
    if(t.hasClass('active'))
    {
        t.parents('.password-el').find('input').attr('type','password')
        t.find('i').removeClass('fa-eye-slash').addClass('fa-eye');
        t.removeClass('active')

    } else {
        t.parents('.password-el').find('input').attr('type','text')
        t.find('i').removeClass('fa-eye').addClass('fa-eye-slash');
        t.addClass('active')
    }
 })


$(document).on('touchstart','.nav-control',function(){
    $(".navbar-inside").animate({"left":"0%"},200);
    $('body').addClass('overlay')
})

$(document).on('touchstart','.nav-close-btn',function(){
    $(".navbar-inside").animate({"left":"-95%"},200);
    $('body').removeClass('overlay')
})


 // PAGE PRELOADER


$(window).on('load',function() {
    setTimeout(function(){
        $('body').hide();
        $('body').removeClass('body-loading')
        $('body').fadeIn(50)
    },100)
});


$(document).on('click','.account-menu-control',function(){
    var t = $(this)
    if(t.hasClass('active'))
    {
        t.next('ul').slideUp(200);
        t.removeClass('active')
    } else {
        t.next('ul').slideDown(200);
        t.addClass('active')
    }
})
