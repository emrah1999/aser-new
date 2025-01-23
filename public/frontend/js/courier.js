let courier_area = 0;
let courier_payment_type = 0;
let delivery_payment_type = 0;
let checked_tariff = 0;
let delivery_price = 0;
let external_debt = 0;
let internal_debt = 0;
let urgent_order = false;
let default_urgent_amount = 0;

function courier_change_area(e, url) {
    let area_id = $(e).val();
    // $("#checked_packages").val('');
    $('.courier-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
    courier_payment_type = 0;
    $("#courier_payment_type_id").val('');
    $('.delivery-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
    delivery_payment_type = 0;
    $("#delivery_payment_type_id").val('');
    // $("#packages_list_body").html('');
    // $("#packages_list_table").css('display', 'none');

    if (area_id === 0 || area_id === '' || area_id === null || area_id === undefined) {
        courier_payment_type = 0;
        // $("#choose_packages_button").css('border-color', '#e6e6e6').attr("disabled", true);
        $("#courier_payment_type_id").val('');
        $("#delivery_payment_type_id").val('');
        $('.courier-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
        $('.delivery-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
        $("#courier_price").html('');
        // $("#delivery_price").html('');
        $("#summary_price").html('');
        return false;
    }

    courier_area = area_id;

    swal({
        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
        text: 'Loading, please wait...',
        showConfirmButton: false
    });
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
    $.ajax({
        type: "get",
        url: url,
        data: {
            'area_id': area_id,
            '_token': CSRF_TOKEN,
        },
        success: function (response) {
            swal.close();
            if (response.case === 'success') {
                let payment_types = response.payment_types;
                let payment_type_id;

                for (let i = 0; i < payment_types.length; i++) {
                    payment_type_id = payment_types[i]['id'];
                    $('#courier_pay_button_' + payment_type_id).attr('disabled', false).css('background-color', 'transparent').css('opacity', '1').css('cursor', 'pointer');
                }

                let total_price = 0;
                let courier_price = 0;
                checked_tariff = parseFloat(response.tariff).toFixed(2);
                if (urgent_order === true) {
                    courier_price = parseFloat(checked_tariff) + parseFloat(default_urgent_amount);
                } else {
                    courier_price = parseFloat(checked_tariff);
                }
                $("#courier_price").html(courier_price + ' AZN');
                total_price = parseFloat(delivery_price) + parseFloat(external_debt) + parseFloat(internal_debt) + parseFloat(courier_price);
                total_price = parseFloat(total_price).toFixed(2);
                $("#summary_price").html(total_price + ' AZN');
            } else {
                swal(
                    response.title,
                    response.content,
                    response.case
                );
            }
        }
    });
}

function courier_choose_packages_modal(url) {
    $("#checked_packages").val('');
    $("#packages_list_body").html('');
    $("#packages_list_table").css('display', 'none');

    show_modal('packages-modal');
}

function check_packages() {
    let packages = '';
    let tracks = '';
    let delivery_amount = 0;
    let external_debt_amount = 0;
    let internal_debt_amount = 0;
    let checked_packages_table = '';

    $('.checks').each(function () {
        if (this.checked) {
            let package_id = $(this).val();
            let track = $(this).attr('track');
            let amount = parseFloat($(this).attr('amount'));
            let external_amount = parseFloat($(this).attr('external_w_debt'));
            let internal_amount = parseFloat($(this).attr('internal_w_debt'));
            //console.log(external_debt_amount);
            packages += package_id + ',';
            tracks += track + ', ';
            delivery_amount = parseFloat(delivery_amount) + parseFloat(amount);
            delivery_amount = parseFloat(delivery_amount).toFixed(2);
            external_debt_amount = parseFloat(external_debt_amount)+ parseFloat(external_amount);
            external_debt_amount = parseFloat(external_debt_amount).toFixed(2);
            internal_debt_amount = parseFloat(internal_debt_amount)+ parseFloat(internal_amount);
            internal_debt_amount = parseFloat(internal_debt_amount).toFixed(2);

            checked_packages_table += '<tr class="row100 body">';
            checked_packages_table += '<td class="cell100">' + track + '</td>';
            checked_packages_table += '<td class="cell100">' + amount + ' AZN</td>';
            checked_packages_table += '<td class="cell100">' + external_amount + ' AZN</td>';
            checked_packages_table += '<td class="cell100">' + internal_amount + ' AZN</td>';
            checked_packages_table += '</tr>';


            $("#packages_list_body").html(checked_packages_table);
            $("#packages_list_table").css('display', 'block');
        }
    });

    if (packages.length > 0) {
        packages = packages.substr(0, packages.length - 1);
        tracks = tracks.trim();
        tracks = tracks.substr(0, tracks.length - 1);
    }


    $("#checked_packages").val(packages);
    let delivery_amount_sum = parseFloat(delivery_amount) + parseFloat(external_debt_amount) + parseFloat(internal_debt_amount);

    $("#delivery_price").html(delivery_amount_sum + ' AZN');
    let total_amount = 0;
    total_amount = parseFloat(delivery_amount_sum) + parseFloat(checked_tariff);
    if (urgent_order === true) {
        total_amount = parseFloat(total_amount) + parseFloat(default_urgent_amount);
    }
    $("#summary_price").html(total_amount + ' AZN');

    delivery_price = delivery_amount;
    external_debt = external_debt_amount;
    internal_debt = internal_debt_amount;

    $('#packages-modal').css({'display': 'none', 'opacity': '0'});
}

$("#checkAll").click(function () {
    $('.checks').not(this).prop('checked', this.checked);
});

$(document).ready(function () {
    // $('#courier_form').click(() => {
    //     console.log("MEOW");
    // });
    
    
    $('#courier_form').ajaxForm({
        beforeSubmit: function () {
            //loading
            swal({
                title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
                text: 'Loading, please wait...',
                showConfirmButton: false
            });
        },
        success: function (response) {
            if (response.case === 'success') {
                swal({
                    position: 'top-end',
                    type: response.case,
                    title: response.title,
                    showConfirmButton: false,
                    timer: 1500
                });
                if (response.pay === true) {
                    location.href = response.content;
                } else {
                    location.reload();
                }
            } else {
                swal(
                    response.title,
                    response.content,
                    response.case
                );
            }
        }
    });
});

function courier_show_packages(order_id, url, e) {
    if (order_id === 0 || order_id === '' || order_id === null || order_id === undefined) {
        swal(
            'Oops!',
            $(e).attr('data-message'),
            'warning'
        );
        return false;
    }

    swal({
        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
        text: 'Loading, please wait...',
        showConfirmButton: false
    });
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
    $.ajax({
        type: "get",
        url: url,
        data: {
            'order_id': order_id,
            '_token': CSRF_TOKEN,
        },
        success: function (response) {
            swal.close();
            if (response.case === 'success') {
                let packages = response.packages;
                let package;
                let i;
                let tr;
                let table = '';
                let track;
                let count;

                for (i = 0; i < packages.length; i++) {
                    package = packages[i];
                    count = i + 1;

                    track = package['number'];

                    if (track.length > 7) {
                        track = track.slice(-7);
                    }

                    tr = '<tr>';

                    tr += '<td>' + count + '</td>';
                    tr += '<td>' + track + '</td>';
                    tr += '<td>' + package['gross_weight'] + ' kg</td>';
                    tr += '<td>' + package['amount'] + ' AZN</td>';
                    tr += '<td>' + package['payment_type'] + '</td>';
                    tr += '<td>' + package['client_name'] + ' ' + package['client_surname'] + '</td>';
                    tr += '<td>' + package['status'] + '</td>';

                    tr += '</tr>';

                    table += tr;

                    $("#show_packages_list").html(table);

                    show_modal('show-packages-modal')
                }
            } else {
                swal(
                    response.title,
                    response.content,
                    response.case
                );
            }
        }
    });
}

function courier_show_status_history(order_id, url, e) {
    if (order_id === 0 || order_id === '' || order_id === null || order_id === undefined) {
        swal(
            'Oops!',
            $(e).attr('data-message'),
            'warning'
        );
        return false;
    }

    swal({
        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
        text: 'Loading, please wait...',
        showConfirmButton: false
    });
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
    $.ajax({
        type: "get",
        url: url,
        data: {
            'order_id': order_id,
            '_token': CSRF_TOKEN,
        },
        success: function (response) {
            swal.close();
            if (response.case === 'success') {
                let statuses = response.statuses;
                let status;
                let i;
                let tr;
                let table = '';
                let count;

                for (i = 0; i < statuses.length; i++) {
                    status = statuses[i];
                    count = i + 1;

                    tr = '<tr>';

                    tr = '<td>' + count + '</td>';
                    tr += '<td>' + status['status'] + '</td>';
                    tr += '<td>' + status['date'] + '</td>';

                    tr += '</tr>';

                    table += tr;

                    $("#show_statuses_list").html(table);

                    show_modal('show-statuses-modal')
                }
            } else {
                swal(
                    response.title,
                    response.content,
                    response.case
                );
            }
        }
    });
}

function choose_courier_payment_type(e, pay_type, url) {
    courier_payment_type = pay_type;

    $('.delivery-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
    delivery_payment_type = 0;
    $("#delivery_payment_type_id").val('');

    if (courier_payment_type === 0 || courier_payment_type === '' || courier_payment_type === null || courier_payment_type === undefined) {
        courier_payment_type = 0;
        // $("#choose_packages_button").css('border-color', '#e6e6e6').attr("disabled", true);
        $("#courier_payment_type_id").val('');
        $("#delivery_payment_type_id").val('');
        $('.courier-pay-buttons').css('background-color', 'transparent').css('opacity', '1').attr('disabled', false).css('cursor', 'pointer');
        $('.delivery-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
        // $("#delivery_price").html('');
        $("#summary_price").html(checked_tariff);
        return false;
    }

    if (courier_area === 0 || courier_area === '' || courier_area === null || courier_area === undefined) {
        courier_payment_type = 0;
        // $("#choose_packages_button").css('border-color', '#e6e6e6').attr("disabled", true);
        $("#courier_payment_type_id").val('');
        $("#delivery_payment_type_id").val('');
        $('.courier-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
        $('.delivery-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
        $("#courier_price").html('');
        // $("#delivery_price").html('');
        $("#summary_price").html('');
        return false;
    }

    // $("#packages_list_body").html('');
    // $("#packages_list_table").css('display', 'none');
    // $("#checked_packages").val('');
    // $("#choose_packages_button").css('border-color', 'greenyellow').attr("disabled", false);

    $('.courier-pay-buttons').css('background-color', 'transparent');
    $(e).css('background-color', 'darkseagreen');

    $("#courier_payment_type_id").val(pay_type);

    swal({
        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
        text: 'Loading, please wait...',
        showConfirmButton: false
    });
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
    $.ajax({
        type: "get",
        url: url,
        data: {
            'area_id': courier_area,
            'courier_payment_type': courier_payment_type,
            '_token': CSRF_TOKEN,
        },
        success: function (response) {
            swal.close();
            if (response.case === 'success') {
                let payment_types = response.payment_types;
                let payment_type_id;

                for (let i = 0; i < payment_types.length; i++) {
                    payment_type_id = payment_types[i]['id'];
                    $('#delivery_pay_button_' + payment_type_id).attr('disabled', false).css('background-color', 'transparent').css('opacity', '1').css('cursor', 'pointer');
                }
            } else {
                swal(
                    response.title,
                    response.content,
                    response.case
                );
            }
        }
    });
}

function choose_delivery_payment_type(e, pay_type) {
    delivery_payment_type = pay_type;

    if (delivery_payment_type === 0 || delivery_payment_type === '' || delivery_payment_type === null || delivery_payment_type === undefined) {
        delivery_payment_type = 0;
        // $("#choose_packages_button").css('border-color', '#e6e6e6').attr("disabled", true);
        $("#courier_payment_type_id").val('');
        $("#delivery_payment_type_id").val('');
        $('.delivery-pay-buttons').css('background-color', 'transparent').css('opacity', '1').attr('disabled', false).css('cursor', 'pointer');
        // $("#delivery_price").html('');
        $("#summary_price").html(checked_tariff);
        return false;
    }

    if (courier_payment_type === 0 || courier_payment_type === '' || courier_payment_type === null || courier_payment_type === undefined) {
        courier_payment_type = 0;
        // $("#choose_packages_button").css('border-color', '#e6e6e6').attr("disabled", true);
        $("#courier_payment_type_id").val('');
        $("#delivery_payment_type_id").val('');
        $('.courier-pay-buttons').css('background-color', 'transparent').css('opacity', '1').attr('disabled', false).css('cursor', 'pointer');
        $('.delivery-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
        // $("#delivery_price").html('');
        $("#summary_price").html(checked_tariff);
        return false;
    }

    if (courier_area === 0 || courier_area === '' || courier_area === null || courier_area === undefined) {
        courier_payment_type = 0;
        // $("#choose_packages_button").css('border-color', '#e6e6e6').attr("disabled", true);
        $("#courier_payment_type_id").val('');
        $("#delivery_payment_type_id").val('');
        $('.courier-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
        $('.delivery-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
        $("#courier_price").html('');
        // $("#delivery_price").html('');
        $("#summary_price").html('');
        return false;
    }

    // $("#packages_list_body").html('');
    // $("#packages_list_table").css('display', 'none');
    // $("#checked_packages").val('');
    // $("#choose_packages_button").css('border-color', 'greenyellow').attr("disabled", false);

    $('.delivery-pay-buttons').css('background-color', 'transparent');
    $(e).css('background-color', 'darkseagreen');

    $("#delivery_payment_type_id").val(pay_type);
}

function set_urgent_order(e, amount_for_urgent) {
    if (urgent_order === false) {
        urgent_order = true;
    } else {
        urgent_order = false;
    }

    let total_courier_price;
    let external_amount;
    let internal_amount ;
    let total_price;

    if (urgent_order === true) {
        total_courier_price = parseFloat(checked_tariff) + parseFloat(amount_for_urgent);
        total_courier_price = parseFloat(total_courier_price);
        $("#courier_price").html(total_courier_price + ' AZN');
        delivery_price = parseFloat(delivery_price);
        external_debt = parseFloat(external_debt);
        internal_debt = parseFloat(internal_debt);
        total_price = parseFloat(total_courier_price + delivery_price + external_debt + internal_debt).toFixed(2);
        //console.log(total_price, delivery_price , internal_debt);
        $("#urgent_order_input").val(1);
        $("#summary_price").html(total_price + ' AZN');
    } else {
        total_courier_price = parseFloat(checked_tariff);
        total_courier_price = parseFloat(total_courier_price);
        $("#courier_price").html(total_courier_price + ' AZN');
        delivery_price = parseFloat(delivery_price);
        external_debt = parseFloat(external_debt);
        internal_debt = parseFloat(internal_debt);
        total_price = parseFloat(total_courier_price + delivery_price + external_debt + internal_debt).toFixed(2);
        $("#summary_price").html(total_price + ' AZN');
        $("#urgent_order_input").val(0);
    }
}

function delet(id, url) {

    swal({
        title: 'Do you approve the deletion?',
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: 'No',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes!'
    }).then(function (result) {
        if (result.value) {
            swal({
                title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
                text: 'Loading, please wait...',
                showConfirmButton: false
            });
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
            $.ajax({
                type: "delete",
                url: url,
                data: {
                    'id': id,
                    '_token': CSRF_TOKEN,
                },
                success: function (response) {
                    swal.close();
                    if (response.case === 'success') {
                        $('.order_' + response.id).remove();
                        swal({
                            position: 'top-end',
                            type: response.case,
                            title: response.title,
                            showConfirmButton: false,
                            timer: 1500
                        });
                    } else {
                        swal(
                            response.title,
                            response.content,
                            response.case
                        );
                    }
                }
            });
        } else {
            return false;
        }
    });
}

function courier_change_area_region(e, url) {
    let area_id = $(e).val();
    // $("#checked_packages").val('');
    $('.courier-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
    courier_payment_type = 0;
    $("#courier_payment_type_id").val('');
    $('.delivery-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
    delivery_payment_type = 0;
    $("#delivery_payment_type_id").val('');
    // $("#packages_list_body").html('');
    // $("#packages_list_table").css('display', 'none');

    if (area_id === 0 || area_id === '' || area_id === null || area_id === undefined) {
        courier_payment_type = 0;
        // $("#choose_packages_button").css('border-color', '#e6e6e6').attr("disabled", true);
        $("#courier_payment_type_id").val('');
        $("#delivery_payment_type_id").val('');
        $('.courier-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
        $('.delivery-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
        $("#courier_price_region").html('');
        // $("#delivery_price").html('');
        $("#summary_price_region").html('');
        return false;
    }

    courier_area = area_id;

    swal({
        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
        text: 'Loading, please wait...',
        showConfirmButton: false
    });
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
    $.ajax({
        type: "get",
        url: url,
        data: {
            'area_id': area_id,
            '_token': CSRF_TOKEN,
        },
        success: function (response) {
            swal.close();
            if (response.case === 'success') {
                let payment_types = response.payment_types;
                let payment_type_id;

                for (let i = 0; i < payment_types.length; i++) {
                    payment_type_id = payment_types[i]['id'];
                    $('#courier_pay_button_' + payment_type_id).attr('disabled', false).css('background-color', 'transparent').css('opacity', '1').css('cursor', 'pointer');
                }
                
                let total_price = 0;
                let courier_price = 0;
                checked_tariff = parseFloat(response.tariff).toFixed(2);
                if (urgent_order === true) {
                    courier_price = parseFloat(checked_tariff) + parseFloat(default_urgent_amount);
                } else {
                    courier_price = parseFloat(checked_tariff);
                }
                $("#courier_price_region").html(courier_price + ' AZN');
                total_price = parseFloat(delivery_price) + parseFloat(courier_price);
                total_price = parseFloat(total_price).toFixed(2);
                $("#summary_price_region").html(total_price + ' AZN');
            } else {
                swal(
                    response.title,
                    response.content,
                    response.case
                );
            }
        }
    });
}


function courier_choose_packages_modal_region(url) {
    $("#checked_packages_region").val('');
    $("#packages_list_body_region").html('');
    $("#packages_list_table_region").css('display', 'none');
    
    show_modal('packages-modal_region');
}

function check_packages_region() {
    let packages = '';
    let tracks = '';
    let delivery_amount = 0;
    let checked_packages_table = '';
    let total_weight = 0;
    let static_price = 0;
    let dynamic_price = 0;
    let external_debt_amount = 0;
    let internal_debt_amount = 0;

    $('.checks_region').each(function () {
        if (this.checked) {
            let package_id = $(this).val();
            let track = $(this).attr('track');
            let amount = parseFloat($(this).attr('amount'));
            let weight = parseFloat($(this).attr('weight'));
            let external_amount = parseFloat($(this).attr('external_w_debt'));
            let internal_amount = parseFloat($(this).attr('internal_w_debt'));
            packages += package_id + ',';
            tracks += track + ', ';
            
            total_weight = parseFloat(total_weight) + parseFloat(weight);
            delivery_amount = parseFloat(delivery_amount) + parseFloat(amount);
            delivery_amount = parseFloat(delivery_amount).toFixed(2);
            external_debt_amount = parseFloat(external_debt_amount)+ parseFloat(external_amount);
            external_debt_amount = parseFloat(external_debt_amount).toFixed(2);
            internal_debt_amount = parseFloat(internal_debt_amount)+ parseFloat(internal_amount);
            internal_debt_amount = parseFloat(internal_debt_amount).toFixed(2);

       

            checked_packages_table += '<tr class="row100 body">';
            checked_packages_table += '<td class="cell100">' + track + '</td>';
            checked_packages_table += '<td class="cell100">' + amount + ' AZN</td>';
            checked_packages_table += '<td class="cell100">' + external_amount + ' AZN</td>';
            checked_packages_table += '<td class="cell100">' + internal_amount + ' AZN</td>';
            checked_packages_table += '</tr>';


            $("#packages_list_body_region").html(checked_packages_table);
            $("#packages_list_table_region").css('display', 'block');
        }
    });

    total_weight = Math.ceil(total_weight);

    swal({
        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
        text: 'Loading, please wait...',
        showConfirmButton: false
    });
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
    $.ajax({
        type: "get",
        url: "/account/courier/get-courier-payment-types-regions",
        data: {
            '_token': CSRF_TOKEN,
        },
        success: function (response) {
            swal.close();
            if (response.case === 'success') {
                let tariff = response.tariff;
                total_weight = total_weight * 1000;

                const courier_tariffs = tariff.find((v) => v.from_weight <= total_weight && total_weight <= v.to_weight);

                
                total_weight = total_weight / 1000;
                static_price = courier_tariffs.static_price;
                dynamic_price = courier_tariffs.dynamic_price;
                let total_price = 0;
                let courier_price = static_price + (total_weight * dynamic_price);
                courier_price = Math.round((courier_price + Number.EPSILON) * 100) / 100;
                console.log(courier_price);
                $("#courier_price_region").html(courier_price + ' AZN');
                total_price = parseFloat(delivery_price) + parseFloat(external_debt) + parseFloat(internal_debt) + parseFloat(courier_price);
                total_price = parseFloat(total_price).toFixed(2);
                
                $("#summary_price_region").html(total_price + ' AZN');
            } else {
                swal(
                    response.title,
                    response.content,
                    response.case
                );
            }
        }
    });

    if (packages.length > 0) {
        packages = packages.substr(0, packages.length - 1);
        tracks = tracks.trim();
        tracks = tracks.substr(0, tracks.length - 1);
    }

    $("#checked_packages_region").val(packages);
    let delivery_amount_sum = parseFloat(delivery_amount) + parseFloat(external_debt_amount) + parseFloat(internal_debt_amount);
    $("#delivery_price_region").html(delivery_amount_sum + ' AZN');
    let total_amount = 0;
    total_amount = parseFloat(delivery_amount_sum) + parseFloat(checked_tariff);
   
    $("#summary_price_region").html(total_amount + ' AZN');

    delivery_price = delivery_amount;
    external_debt = external_debt_amount;
    internal_debt = internal_debt_amount;

    $('#packages-modal_region').css({'display': 'none', 'opacity': '0'});
}

function choose_courier_payment_type_region(e, pay_type, url) {
    courier_payment_type = pay_type;

    $('.delivery-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
    delivery_payment_type = 0;
    $("#delivery_payment_type_id_region").val('');

    if (courier_payment_type === 0 || courier_payment_type === '' || courier_payment_type === null || courier_payment_type === undefined) {
        courier_payment_type = 0;
        // $("#choose_packages_button").css('border-color', '#e6e6e6').attr("disabled", true);
        $("#courier_payment_type_id").val('');
        $("#delivery_payment_type_id").val('');
        $('.courier-pay-buttons').css('background-color', 'transparent').css('opacity', '1').attr('disabled', false).css('cursor', 'pointer');
        $('.delivery-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
        // $("#delivery_price").html('');
        $("#summary_price").html(checked_tariff);
        return false;
    }

    if (courier_area === 0 || courier_area === '' || courier_area === null || courier_area === undefined) {
        courier_payment_type = 0;
        // $("#choose_packages_button").css('border-color', '#e6e6e6').attr("disabled", true);
        $("#courier_payment_type_id_region").val('');
        $("#delivery_payment_type_id_region").val('');
        $('.courier-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
        $('.delivery-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
        $("#courier_price_region").html('');
        // $("#delivery_price").html('');
        $("#summary_price_region").html('');
        return false;
    }

    // $("#packages_list_body").html('');
    // $("#packages_list_table").css('display', 'none');
    // $("#checked_packages").val('');
    // $("#choose_packages_button").css('border-color', 'greenyellow').attr("disabled", false);

    $('.courier-pay-buttons').css('background-color', 'transparent');
    $(e).css('background-color', 'darkseagreen');

    $("#courier_payment_type_id_region").val(pay_type);

    swal({
        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
        text: 'Loading, please wait...',
        showConfirmButton: false
    });
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
    $.ajax({
        type: "get",
        url: url,
        data: {
            'area_id': courier_area,
            'courier_payment_type': courier_payment_type,
            '_token': CSRF_TOKEN,
        },
        success: function (response) {
            swal.close();
            if (response.case === 'success') {
                let payment_types = response.payment_types;
                let payment_type_id;

                for (let i = 0; i < payment_types.length; i++) {
                    payment_type_id = payment_types[i]['id'];
                    $('#delivery_pay_button_' + payment_type_id).attr('disabled', false).css('background-color', 'transparent').css('opacity', '1').css('cursor', 'pointer');
                }
            } else {
                swal(
                    response.title,
                    response.content,
                    response.case
                );
            }
        }
    });
}

function choose_delivery_payment_type_region(e, pay_type) {
    delivery_payment_type = pay_type;

    if (delivery_payment_type === 0 || delivery_payment_type === '' || delivery_payment_type === null || delivery_payment_type === undefined) {
        delivery_payment_type = 0;
        // $("#choose_packages_button").css('border-color', '#e6e6e6').attr("disabled", true);
        $("#courier_payment_type_id_region").val('');
        $("#delivery_payment_type_id_region").val('');
        $('.delivery-pay-buttons').css('background-color', 'transparent').css('opacity', '1').attr('disabled', false).css('cursor', 'pointer');
        // $("#delivery_price").html('');
        $("#summary_price_region").html(checked_tariff);
        return false;
    }

    if (courier_payment_type === 0 || courier_payment_type === '' || courier_payment_type === null || courier_payment_type === undefined) {
        courier_payment_type = 0;
        // $("#choose_packages_button").css('border-color', '#e6e6e6').attr("disabled", true);
        $("#courier_payment_type_id_region").val('');
        $("#delivery_payment_type_id_region").val('');
        $('.courier-pay-buttons').css('background-color', 'transparent').css('opacity', '1').attr('disabled', false).css('cursor', 'pointer');
        $('.delivery-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
        // $("#delivery_price").html('');
        $("#summary_price_region").html(checked_tariff);
        return false;
    }

    if (courier_area === 0 || courier_area === '' || courier_area === null || courier_area === undefined) {
        courier_payment_type = 0;
        // $("#choose_packages_button").css('border-color', '#e6e6e6').attr("disabled", true);
        $("#courier_payment_type_id_region").val('');
        $("#delivery_payment_type_id_region").val('');
        $('.courier-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
        $('.delivery-pay-buttons').css('background-color', 'transparent').css('opacity', '0.3').attr('disabled', true).css('cursor', 'not-allowed');
        $("#courier_price_region").html('');
        // $("#delivery_price").html('');
        $("#summary_price_region").html('');
        return false;
    }

    // $("#packages_list_body").html('');
    // $("#packages_list_table").css('display', 'none');
    // $("#checked_packages").val('');
    // $("#choose_packages_button").css('border-color', 'greenyellow').attr("disabled", false);

    $('.delivery-pay-buttons').css('background-color', 'transparent');
    $(e).css('background-color', 'darkseagreen');

    $("#delivery_payment_type_id_region").val(pay_type);
}

$("#checkAllRegion").click(function () {
    $('.checks_region').not(this).prop('checked', this.checked);
});

$(document).ready(function () {
    $('#courier_form_region').ajaxForm({
        beforeSubmit: function () {
            //loading
            swal({
                title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
                text: 'Loading, please wait...',
                showConfirmButton: false
            });
        },
        success: function (response) {
            if (response.case === 'success') {
                swal({
                    position: 'top-end',
                    type: response.case,
                    title: response.title,
                    showConfirmButton: false,
                    timer: 1500
                });
                if (response.pay === true) {
                    location.href = response.content;
                } else {
                    location.reload();
                }
            } else {
                swal(
                    response.title,
                    response.content,
                    response.case
                );
            }
        }
    });
});
