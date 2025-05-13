let has_agreement          = false
let special_orders_percent = 5

function agreement_control () {
  if (has_agreement === false) {
    has_agreement = true
    $('#register_button')
      .attr('disabled', false)
  } else {
    has_agreement = false
    $('#register_button')
      .attr('disabled', true)
  }
}

function country_select_for_special_order (e) {
  let url        = $(e)
    .attr('href')
  let basket_url = url + '?paid=no'

  $('#special_order_button')
    .attr('href', url)
  $('#basket_special_order_button')
    .attr('href', basket_url)
}

function change_price_for_special_product (number) {
  let price = parseFloat($('#price_' + number)
    .val())
  if (isNaN(price)) {
    price = 0
  }

  let qty = parseFloat($('#quantity_' + number)
    .val())
  if (isNaN(qty)) {
    qty = 0
  }

  let total

  let multi_price = price * qty
  total           = multi_price + (multi_price * special_orders_percent) / 100
  //total = qty * total;

  if (isNaN(total)) {
    total = 0
  }

  total = total.toFixed(2)
  var currency_name=$("#currency_name").val();
  $('#total_price_' + number)
    .html(' ' + total +' '+ currency_name)
    .attr('price', total)

  let total_price = 0
  let current_price
  jQuery('.total_price')
    .each(function () {
      current_price = parseFloat($(this)
        .attr('price'))
      if (isNaN(current_price)) {
        current_price = 0
      }
      total_price += current_price
    })

  total_price = total_price.toFixed(2)

  $('#total_price_span')
    .html(total_price + ' ')
    .attr('price', total_price)
}

function close_modal (modal_id = 'item-modal') {
  $('#' + modal_id)
    .css({ 'display': 'none', 'opacity': '0' })
}

function show_modal (modal_id = 'item-modal') {
  $('#' + modal_id)
    .css({ 'display': 'block', 'opacity': '1' })
}

function show_modal_for_tracking_search (modal_id = 'tracking-search-modal') {
  $('#' + modal_id)
    .css({ 'display': 'block', 'opacity': '1' })
  $('.navbar-inside')
    .animate({ 'left': '-95%' }, 200)
  $('body')
    .removeClass('overlay')

  $('#tracking_search_panel')
    .css('display', 'block')
  $('#tracking_search_list')
    .css('display', 'none')
  $('#track_no_for_search')
    .val('')
  $('#tracking_search_status_list')
    .html('')
  $('#tracking_search_track')
    .html('')
}

function new_special_product (e, number) {
  let new_number = number + 1

  let new_btn_title = $(e)
    .attr('data-title')
  // let new_btn_text = $(e).attr('data-title-add');
  // console.log(new_btn_text);
  // console.log(new_btn_title);
  let new_button = '<div class="sp-product-control btn btn-danger btn-remove" onclick="remove_special_product(' + number + ');">'
  new_button += new_btn_title
  new_button += '</div>'

  let url_label           = $('#url_lable')
    .text()
  let size_label          = $('#size_label')
    .text()
  let color_label         = $('#color_label')
    .text()
  let quantity_label      = $('#quantity_label')
    .text()
  let price_label         = $('#price_label')
    .text()
  let description_label   = $('#description_label')
    .text()
  let new_order_button    = $('#new_order_button')
    .attr('new_order_button_text')
  let remove_order_button = $('#new_order_button')
    .attr('remove_order_button_text')

  $('#product_button_' + number)
    .html(new_button)
  let currency_name = $('#total_price_span')
    .attr('currency_name')

  let new_order = '<div class="sp-product-block"  id="product_block_' + new_number + '">'
  new_order += '<div class="row n-form-element clearfix">'
  new_order += '<div class="seperate_block col-12 row">'
  new_order += '<div class="col-md-12 col-xs-12 n-margin">'
  new_order += '<div class="input_custom input-effect">'
  new_order += '<input class="effect-20" type="text" placeholder="" name="url[]">'
  new_order += '<label>' + url_label + '</label>'
  new_order += '<span class="focus-border"><i></i></span>'
  new_order += '</div>'
  new_order += '</div>'
  new_order += '</div>'
  new_order += '<div class="seperate_block col-12 row">'
  new_order += '<div class="col-md-6 col-xs-12 col-lg-1 n-margin">'
  new_order += '<div class="input_custom input-effect">'
  new_order += '<input class="effect-20" type="text" placeholder="" name="size[]">'
  new_order += '<label>' + size_label + '</label>'
  new_order += '<span class="focus-border"><i></i></span>'
  new_order += '</div>'
  new_order += '</div>'
  new_order += '<div class="col-md-6 col-xs-12 col-lg-3 n-margin">'
  new_order += '<div class="input_custom input-effect">'
  new_order += '<input class="effect-20" type="text" placeholder="" name="color[]">'
  new_order += '<label>' + color_label + '</label>'
  new_order += '</div>'
  new_order += '</div>'
  new_order += '<div class="col-md-6 col-xs-12 col-lg-1 n-margin">'
  new_order += '<div class="input_custom input-effect">'
  new_order += '<input class="effect-20" type="number" placeholder="" name="quantity[]" id="quantity_' + new_number + '" min="1">'
  new_order += '<label>' + quantity_label + '</label>'
  new_order += '<span class="focus-border"><i></i></span>'
  new_order += '</div>'
  new_order += '</div>'


  new_order += '</div>'
  new_order += '<div class="col-md-6 col-xs-12 col-lg-5 n-margin">'
  new_order += '<div class="n-price-input">'
  new_order += '<div class="input_custom col-md-6  input-effect">'
  new_order += '<input class="effect-20" type="number" step="0.01" placeholder="" name="price[]" id="price_' + new_number + '" oninput="change_price_for_special_product(' + new_number + ');" min="0.01">'
  new_order += '<label>' + price_label + '</label>'
  new_order += '<div class="n-tax-info">+' + special_orders_percent + '% = <span class="total_price" price="0" id="total_price_' + new_number + '"> 0 ' + currency_name + ' </span></div>'
  new_order += '</div>'
  new_order += '<span class="focus-border"><i></i></span>'
  new_order += '</div>'
  new_order += '</div>'
  new_order += '<div class="seperate_block col-12 row">'
  new_order += '<div class="col-12">'
  new_order += '<div class="input_custom input-effect">'
  new_order += '<input class="effect-20" type="text" placeholder="" name="description[]">'
  new_order += '<label>' + description_label + '</label>'
  new_order += '<span class="focus-border"><i></i></span>'
  new_order += '</div>'
  new_order += '</div>'
  new_order += '</div>'
  new_order += '</div>'
  new_order += '<div class="row" id="product_button_' + new_number + '">'
  new_order += '<div class="sp-product-control btn btn-add btn-success" onclick="new_special_product(this, ' + new_number + ');" data-title="Məhsulu sil <i class=&quot;fa fa-minus&quot;></i>">'
  new_order += +new_order_button + ' <i class="fa fa-plus"></i>'
  new_order += '</div>'
  new_order += '</div>'
  new_order += '</div>'

  $('#product_list')
    .append(new_order)
}

function remove_special_product (number) {
  let price       = $('#total_price_' + number)
    .attr('price')
  let total_price = $('#total_price_span')
    .attr('price')

  $('#product_block_' + number)
    .remove()

  if (isNaN(total_price)) {
    total_price = 0
  }
  if (isNaN(price)) {
    price = 0
  }

  let new_price = total_price - price
  new_price     = new_price.toFixed(2)
  $('#total_price_span')
    .html(new_price + ' ')
    .attr('price', new_price)
}

function form_submit_message (response, reload = true, modal = true) {
  if (response.case === 'success') {
    if (modal) {
      $('#add-modal')
        .modal('hide')
    }
    swal({
      position         : 'top-end',
      type             : response.case,
      title            : response.title,
      showConfirmButton: false,
      timer            : 1500
    })
    if (reload) {
      location.reload()
    }
  } else {
    if (response.type === 'validation') {
      let content            = response.content
      let validation_message = ''
      $.each(content, function (index, value) {
        if (value.length !== 0) {
          for (let i = 0; i < value.length; i++) {
            validation_message += value[i] + '\n'
          }
        }
      })
      swal(
        'Validation error!',
        validation_message,
        'warning'
      )
    } else {
      swal(
        response.title,
        response.content,
        response.case
      )
    }
  }
}

function show_special_order_details (title = '-', price = '-', quantity = '-', description = '-', status = '-') {
  if (title.length === 0) {
    title = '-'
  }

  $('#item_title')
    .html(title)
  $('#item_price')
    .html(price)
  $('#item_quantity')
    .html(quantity)
  $('#item_description')
    .html(description)
  $('#item_status')
    .html(status)

  $('#item-modal')
    .css({ 'display': 'block', 'opacity': '1' })
}

function change_currency_by_country (e) {
  let country  = $(e)
    .val()
  let currency = $('#country_option_' + country)
    .attr('country_currency')
  $('#currency')
    .html(currency)
}

$('.only-number')
  .keypress(function (event) {
    if ((event.which != 46 || $(this)
      .val()
      .indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
      event.preventDefault()
    }
  })

function show_other_seller_input (e) {
  let seller_id = $(e)
    .val()
  if (seller_id == 0) {
    $('#other_seller_area')
      .css('display', 'block')
    $('#seller_id')
      .css('display', 'block')
      .attr('required', false)
    $('#other_seller')
      .val('')
      .attr('required', true)
  } else {
    $('#other_seller_area')
      .css('display', 'none')
    $('#other_seller')
      .val('')
      .attr('required', false)
    $('#seller_id')
      .css('display', 'block')
      .attr('required', true)
  }
}

function add_referal_balance (referal_id) {
  $('#referal_id')
    .val(referal_id)
  $('#amount')
    .val(0)

  show_modal('referal-balance-modal')
}

function select_referal_balance_type (e) {
  let type = $(e)
    .val()

  if (type == 1) {
    $('#my_balance')
      .css('display', 'inline-block')
  } else {
    $('#my_balance')
      .css('display', 'none')
  }
}

/*-------------    Niko      ----------------*/

// JavaScript for label effects only

/*
$('.input-effect input').focusout(function () {
    if ($(this).val() !== '') {
        $(this).addClass('has-content')
    } else {
        $(this).removeClass('has-content')
    }
});
*/

$(window)
  .on('load', function () {
    $(document)
      .on('focusout', '.input-effect input,.input-effect textarea', function () {
        if ($(this)
          .val() !== '') {
          $(this)
            .addClass('has-content')
        } else {
          $(this)
            .removeClass('has-content')
        }
      })
  })

// courier orders
function show_referral_packages (e, packages_count, has_referrals) {
  if (has_referrals !== 'yes') {
    swal(
      'Oops!',
      $(e)
        .attr('data-message-referrals'),
      'warning'
    )
    return false
  }

  if (packages_count == 0) {
    swal(
      'Oops!',
      $(e)
        .attr('data-message-packages'),
      'warning'
    )
    return false
  }

  $('.referrals_packages_class')
    .css('display', 'table-row')
  $('#show_referral_packages_button')
    .html('<button type="button" class="orange-button">---</button>')
}

function global_tracking_search () {
  let track = $('#track_no_for_search')
    .val()

  window.open('http://parcelsapp.com/az/tracking/' + track)
}
