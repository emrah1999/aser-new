// function show_package_items(id, track, url) {
//     // Yükleniyor mesajı göstermek için SweetAlert
//     swal({
//         title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
//         text: 'Loading, please wait...',
//         showConfirmButton: false
//     });

//     // CSRF token'ını meta etiketinden alıyoruz
//     let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

//     $.ajax({
//         type: "GET",
//         url: url,
//         data: {
//             'id': id,
//             '_token': CSRF_TOKEN,
//         },
//         success: function (response) {
//             // Yükleniyor mesajını kapatıyoruz
//             swal.close();

//             // Eğer response'da case 'success' ise işlemleri gerçekleştiriyoruz
//             if (response.case === 'success') {
//                 // Takip numarasını HTML'e ekliyoruz
//                 $("#item_track_number").html(track);

//                 // Gelen öğeleri alıyoruz
//                 let items = response.items;

//                 // Eğer items dizisi boşsa kullanıcıyı uyarıyoruz
//                 if (items.length === 0) {
//                     swal('Oops', 'No items!', 'warning');
//                     return false;
//                 }

//                 let item;
//                 let tr;
//                 let body = '';

//                 // Her bir öğe için bir satır oluşturuyoruz
//                 for (let i = 0; i < items.length; i++) {
//                     item = items[i];
//                     tr = '<tr>';
//                     tr += '<td>' + item['seller_name'] + '</td>';  // seller_name doğru kullanıldı
//                     tr += '<td>' + item['category'] + '</td>';
//                     tr += '<td>' + item['price'] + ' ' + item['currency'] + '</td>';
//                     tr += '</tr>';

//                     body += tr;
//                 }

//                 // SweetAlert ile tablonun görünmesini sağlıyoruz
//                 swal({
//                     title: 'Package Items',
//                     html: `
//                         <table style="width: 100%; border-collapse: collapse; border: 1px solid #ddd;">
//                             <thead>
//                                 <tr>
//                                     <th style="padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;">Seller</th>
//                                     <th style="padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;">Category</th>
//                                     <th style="padding: 8px; border: 1px solid #ddd; background-color: #f2f2f2;">Price</th>
//                                 </tr>
//                             </thead>
//                             <tbody>
//                                 ${body} <!-- Dinamik satırlar burada ekleniyor -->
//                             </tbody>
//                         </table>
//                     `,
//                     button: 'Close',
//                     className: "swal-custom-modal"
//                 });
//             } else {
//                 // Eğer response case 'success' değilse, uyarı mesajı gösteriyoruz
//                 swal(response.title, response.content, response.case);
//             }

//         },
//         error: function (xhr, status, error) {
//             // AJAX hatası durumunda konsola yazdırma ve uyarı gösterme
//             console.log("AJAX error:", error);
//             swal('Error', 'An error occurred while processing your request.', 'error');
//         }
//     });
// }




// $(document).ready(function () {
//     $('#special_order_form').ajaxForm({
//         beforeSubmit: function () {
//             //loading
//             swal({
//                 title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
//                 text: 'Loading, please wait...',
//                 showConfirmButton: false
//             });
//         },
//         success: function (response) {
//             if (response.case === 'success') {
//                 let token = response['token'];
//                 location.href = "https://www.paytr.com/odeme/guvenli/" + token;
//             } else {
//                 form_submit_message(response, false, false);
//             }
//         }
//     });
// });

// function delete_special_order(e, url) {
//     let confirm_message = $(e).attr("data-confirm");

//     swal({
//         title: confirm_message,
//         type: 'warning',
//         showCancelButton: true,
//         cancelButtonText: 'Xeyr',
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Bəli!'
//     }).then(function (result) {
//         if (result.value) {
//             swal({
//                 title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
//                 text: 'Loading, please wait...',
//                 showConfirmButton: false
//             });
//             let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
//             $.ajax({
//                 type: "delete",
//                 url: url,
//                 data: {
//                     '_token': CSRF_TOKEN,
//                 },
//                 success: function (response) {
//                     swal.close();
//                     if (response.case === 'success') {
//                         $('.order_' + response.id).remove();
//                         swal({
//                             position: 'top-end',
//                             type: response.case,
//                             title: response.title,
//                             showConfirmButton: false,
//                             timer: 1500
//                         });
//                     } else {
//                         swal(
//                             response.title,
//                             response.content,
//                             response.case
//                         );
//                     }
//                 }
//             });
//         } else {
//             return false;
//         }
//     });
// }

// $(document).ready(function () {
//     $('#special_order_update_form').ajaxForm({
//         beforeSubmit: function () {
//             //loading
//             swal({
//                 title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
//                 text: 'Loading, please wait...',
//                 showConfirmButton: false
//             });
//         },
//         success: function (response) {
//             form_submit_message(response, false, false);
//         }
//     });
// });

// $(document).ready(function () {
//     let redirect_url = $("#preliminary_declaration_form").attr("redirect_url");
//     $('#preliminary_declaration_form').ajaxForm({
//         beforeSubmit: function () {
//             //loading
//             swal({
//                 title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
//                 text: 'Loading, please wait...',
//                 showConfirmButton: false
//             });
//         },
//         success: function (response) {
//             if (response.case === 'success') {
//                 location.href = redirect_url;
//             } else {
//                 form_submit_message(response, false, false);
//             }
//         }
//     });
// });

// function delete_order(e, url) {
//     let confirm_message = $(e).attr("data-confirm");

//     swal({
//         title: confirm_message,
//         type: 'warning',
//         showCancelButton: true,
//         cancelButtonText: 'Xeyr',
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Bəli!'
//     }).then(function (result) {
//         if (result.value) {
//             swal({
//                 title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
//                 text: 'Loading, please wait...',
//                 showConfirmButton: false
//             });
//             let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
//             $.ajax({
//                 type: "delete",
//                 url: url,
//                 data: {
//                     '_token': CSRF_TOKEN,
//                 },
//                 success: function (response) {
//                     swal.close();
//                     if (response.case === 'success') {
//                         $('.order_package_' + response.id).remove();
//                         swal({
//                             position: 'top-end',
//                             type: response.case,
//                             title: response.title,
//                             showConfirmButton: false,
//                             timer: 1500
//                         });
//                     } else {
//                         swal(
//                             response.title,
//                             response.content,
//                             response.case
//                         );
//                     }
//                 }
//             });
//         } else {
//             return false;
//         }
//     });
// }

// function pay_special_order(url, e) {
//     swal({
//         title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
//         text: 'Loading, please wait...',
//         showConfirmButton: false
//     });
//     let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
//     $.ajax({
//         type: "post",
//         url: url,
//         data: {
//             '_token': CSRF_TOKEN,
//         },
//         success: function (response) {
//             if (response.case === 'success') {
//                 let token = response['token'];
//                 location.href = "https://www.paytr.com/odeme/guvenli/" + token;
//                 // $(e).attr("disabled", true).removeAttr("onclick").text("Ödənilib");
//                 // swal({
//                 //     position: 'top-end',
//                 //     type: response.case,
//                 //     title: response.title,
//                 //     showConfirmButton: false,
//                 //     timer: 1500
//                 // });
//             } else {
//                 swal.close();
//                 swal(
//                     response.title,
//                     response.content,
//                     response.case
//                 );
//             }
//         }
//     });
// }

// function calculate_amount(url) {
//     let country = $("#country").val();
//     let type = $("#type").val();
//     let unit = $("#unit").val();
//     let weight = $("#weight").val();
//     let width = $("#width").val();
//     let length = $("#length").val();
//     let height = $("#height").val();
//     console.log(0)
//     if (+country!==10){
//         console.log(1)
//         console.warn(+weight)
//         console.warn(+height)
//         console.warn(+length)
//         if(+width<100 && +height<100 && length<100){
//             console.log(2)
//             width=0;
//             length=0;
//             height=0;
//         }
//     }
//     swal({
//         title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
//         text: 'Loading, please wait...',
//         showConfirmButton: false
//     });
//     let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
//     $.ajax({
//         type: "post",
//         url: url,
//         data: {
//             '_token': CSRF_TOKEN,
//             'country': country,
//             'type': type,
//             'unit': unit,
//             'weight': weight,
//             'width': width,
//             'length': length,
//             'height': height
//         },
//         success: function (response) {
//             swal.close();
//             if (response.case === 'success') {
//                 $("#amount").text(response.amount);
//             } else {
//                 form_submit_message(response, false, false);
//             }
//         }
//     });
// }

// function paid_package_new(e, locale, url) {
//     console.log('here');
//     let confirm_message = $(e).attr("data-confirm");
//     let balance = $(e).attr("data-balance");
//     let balance_message = $(e).attr("data-balance-message");
//     let has_courier = $(e).attr("data-has-courier");
//     let has_courier_message = $(e).attr("data-has-courier-message");
//     let amount = $(e).attr("data-amount");
//     balance = parseFloat(balance);
//     amount = parseFloat(amount);


//     swal({
//         title: 'Ödəniş üsulunu seçin',
//         text: '',
//         type: 'warning',
//         showCancelButton: true,
//         cancelButtonText: 'Kartla ödə',
//         confirmButtonText: 'Balansdan ödə',
//         cancelButtonColor: '#d33',
//         confirmButtonColor: '#3085d6'
//     }).then(function (result) {
//         if (result.dismiss === swal.DismissReason.cancel) {
//             window.location.href = url;
//         } else if (result.value) {
//             if (has_courier == 1) {
//                 swal(
//                     'Oops!',
//                     has_courier_message,
//                     'warning'
//                 );
//                 return false;
//             }

//             if (balance == 0 || balance < amount) {
//                 swal(
//                     'Oops!',
//                     balance_message,
//                     'warning'
//                 );
//                 return false;
//             }

//             swal({
//                 title: confirm_message,
//                 type: 'warning',
//                 showCancelButton: true,
//                 cancelButtonText: 'Xeyr',
//                 confirmButtonColor: '#3085d6',
//                 cancelButtonColor: '#d33',
//                 confirmButtonText: 'Bəli!'
//             }).then(function (result) {
//                 if (result.value) {
//                     swal({
//                         title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
//                         text: 'Loading, please wait...',
//                         showConfirmButton: false
//                     });

//                     let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');

//                     $.ajax({
//                         type: "post",
//                         url: url,
//                         data: {
//                             '_token': CSRF_TOKEN,
//                         },
//                         success: function (response) {
//                             swal.close();
//                             if (response.case === 'success') {
//                                 let title;
//                                 if (response.residue === 0) {
//                                     title = response.title;
//                                 } else {
//                                     title = response.title + "(Qalıq borcunuz: " + response.residue + ")";
//                                 }
//                                 swal({
//                                     position: 'top-end',
//                                     type: response.case,
//                                     title: title,
//                                     showConfirmButton: false,
//                                     timer: 1500
//                                 });
//                                 location.reload();
//                             } else {
//                                 swal(
//                                     response.title,
//                                     response.content,
//                                     response.case
//                                 );
//                             }
//                         }
//                     });
//                 } else {
//                     return false;
//                 }
//             });
//         }
//     });
// }


// function login_to_sub_account(e, url, referal_id) {
//     let confirm_message = $(e).attr("data-confirm");

//     swal({
//         title: confirm_message,
//         type: 'warning',
//         showCancelButton: true,
//         cancelButtonText: 'Xeyr',
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Bəli!'
//     }).then(function (result) {
//         if (result.value) {
//             swal({
//                 title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
//                 text: 'Loading, please wait...',
//                 showConfirmButton: false
//             });
//             let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
//             $.ajax({
//                 type: "post",
//                 url: url,
//                 data: {
//                     'referal_id': referal_id,
//                     '_token': CSRF_TOKEN
//                 },
//                 success: function (response) {
//                     if (response.case === 'success') {
//                         swal({
//                             position: 'top-end',
//                             type: response.case,
//                             title: response.content,
//                             showConfirmButton: false,
//                             timer: 1500
//                         });
//                         location.href = response.redirect_url;
//                     } else {
//                         swal.close();
//                         swal(
//                             response.title,
//                             response.content,
//                             response.case
//                         );
//                     }
//                 }
//             });
//         } else {
//             return false;
//         }
//     });
// }

// $(document).ready(function () {
//     $('#referal_balance_form').ajaxForm({
//         beforeSubmit: function () {
//             //loading
//             swal({
//                 title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
//                 text: 'Loading, please wait...',
//                 showConfirmButton: false
//             });
//         },
//         success: function (response) {
//             if (response.case === 'success') {
//                 if (response.payment_type === 'from_cart') {
//                     //from cart
//                     let request_url = response.content;
//                     location.href = request_url;

//                 } else {
//                     //from my balance
//                     form_submit_message(response, true, true);
//                 }
//             } else {
//                 form_submit_message(response, false, false);
//             }
//         }
//     });
// });

// function show_items_for_special_orders(group_id, url) {
//     swal({
//         title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
//         text: 'Loading, please wait...',
//         showConfirmButton: false
//     });
//     let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
//     $.ajax({
//         type: "get",
//         url: url,
//         data: {
//             'group_id': group_id,
//             '_token': CSRF_TOKEN,
//         },
//         success: function (response) {
//             swal.close();
//             if (response.case === 'success') {
//                 let items = response.orders;

//                 if (items.length === 0) {
//                     swal(
//                         'Oops',
//                         'No items!',
//                         'warning'
//                     );
//                     return false;
//                 }

//                 let item;
//                 let tr;
//                 let body = '';
//                 let description;
//                 let no;
//                 let url;

//                 for (let i = 0; i < items.length; i++) {
//                     no = i + 1;
//                     item = items[i];
//                     if (item['description'] === null) {
//                         description = '---';
//                     } else {
//                         description = item['description'];
//                     }
//                     url = item['url'];
//                     if (url.length > 20) {
//                         url = url.substr(0, 20);
//                     }
//                     tr = '<tr>';
//                     tr += '<td>' + no + '</td>';
//                     tr += '<td><a href="' + item['url'] + '" target="_blank">' + url + '</a></td>';
//                     tr += '<td>' + item['price'] + '</td>';
//                     tr += '<td>' + item['quantity'] + '</td>';
//                     tr += '<td>' + description + '</td>';
//                     tr += '<td>' + item['status'] + '</td>';
//                     tr += '</tr>';

//                     body += tr;
//                 }

//                 $("#items_list").html(body);

//                 $("#item-modal").css({"display": "block", "opacity": "1"});
//             } else {
//                 swal(
//                     response.title,
//                     response.content,
//                     response.case
//                 );
//             }
//         }
//     });
// }

// function local_tracking_search(url) {
//     let track = $("#track_no_for_search").val();
//     $("#tracking_search_status_list").html("");
//     $("#tracking_search_track").html("");
//     $("#track_no_for_search").val("");
//     swal({
//         title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
//         text: 'Loading, please wait...',
//         showConfirmButton: false
//     });
//     let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
//     $.ajax({
//         type: "get",
//         url: url,
//         data: {
//             '_token': CSRF_TOKEN,
//             'track': track
//         },
//         success: function (response) {
//             swal.close();
//             if (response.case === 'success') {
//                 let events = response.events;
//                 let i;
//                 let table = '';
//                 let event;
//                 let tr;
//                 let no;

//                 for (i = 0; i < events.length; i++) {
//                     no = i + 1;

//                     event = events[i];
//                     tr = '<tr>';
//                     tr += '<td>' + no + '</td>';
//                     tr += '<td>' + event['status'] + '</td>';
//                     tr += '<td>' + event['date'] + '</td>';
//                     tr += '</tr>';

//                     table += tr;
//                 }

//                 $("#tracking_search_status_list").html(table);
//                 $("#tracking_search_track").html(track);

//                 $("#tracking_search_panel").css('display', 'none');
//                 $("#tracking_search_list").css('display', 'block');
//             } else {
//                 swal(
//                     response.title,
//                     response.content,
//                     response.case
//                 )
//             }
//         }
//     });
// }

// $(document).ready(function () {
//     $('#update_user_details_form').ajaxForm({
//         beforeSubmit: function () {
//             //loading
//             swal({
//                 title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
//                 text: 'Loading, please wait...',
//                 showConfirmButton: false
//             });
//         },
//         success: function (response) {
//             form_submit_message(response, true, false);
//         }
//     });
// });

// function change_profile_image(e, url) {
//     swal({
//         title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
//         text: 'Loading, please wait...',
//         showConfirmButton: false
//     });

//     let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');

//     let formData = new FormData();

//     formData.append('image', $(e)[0].files[0]);

//     let settings = {headers: {'content-type': 'multipart/form-data',processData: false}};

//     $.ajax({
//         type: "post",
//         url: url,
//         headers: {
//             'X-CSRF-TOKEN': CSRF_TOKEN
//         },
//         processData: false,
//         contentType: false,
//         data: formData,
//         success: function (response) {
//             form_submit_message(response, true, false);
//         }
//     });
// }

// function pay_all_referral_debt(e, url) {
//     let my_balance = parseFloat($("#my_balance_for_pay_debt").val());
//     let total_debt = parseFloat($("#total_debt_for_pay_debt").val());

//     let message = $(e).attr('data-message');

//     if (total_debt > my_balance) {
//         swal(
//             'Oops!',
//             message,
//             'error'
//         )
//     }

//     swal({
//         title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
//         text: 'Loading, please wait...',
//         showConfirmButton: false
//     });
//     let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
//     $.ajax({
//         type: "post",
//         url: url,
//         data: {
//             '_token': CSRF_TOKEN
//         },
//         success: function (response) {
//             form_submit_message(response, true, false);
//         }
//     });
// }


// function uploadInvoice(event, url) {
//     swal({
//         title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
//         text: 'Loading, please wait...',
//         showConfirmButton: false
//     });

//     let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');

//     let formData = new FormData();

//     formData.append('image', event.target.files[0]);

//     let settings = {headers: {'content-type': 'multipart/form-data',processData: false}};

//     $.ajax({
//         type: "post",
//         url: url,
//         headers: {
//             'X-CSRF-TOKEN': CSRF_TOKEN
//         },
//         processData: false,
//         contentType: false,
//         data: formData,
//         success: function (response) {
//             form_submit_message(response, true, false);
//         }
//     });
// }

// function bulk_paid_package_new(e, url) {
//     let packageIdsInputHidden = document.getElementById('package_ids');
//     let packageIds = JSON.parse(packageIdsInputHidden.value);
//     let confirm_message = $(e).attr("data-confirm");

//     swal({
//         title: 'Ödəniş üsulunu seçin',
//         type: 'warning',
//         showCancelButton: true,
//         cancelButtonText: 'Kartla ödə',
//         confirmButtonText: 'Balansdan ödə',
//         cancelButtonColor: '#d33',
//         confirmButtonColor: '#3085d6'
//     }).then(function (result) {
//         if (result.dismiss === swal.DismissReason.cancel) {
//             window.location.href = url;
//         } else if (result.value) {
//             swal({
//                 title: confirm_message,
//                 type: 'warning',
//                 showCancelButton: true,
//                 cancelButtonText: 'No',
//                 confirmButtonColor: '#3085d6',
//                 cancelButtonColor: '#d33',
//                 confirmButtonText: 'Bəli!'
//             }).then(function (result) {
//                 if (result.value) {
//                     swal({
//                         title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
//                         text: 'Loading, please wait...',
//                         showConfirmButton: false
//                     });

//                     let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
//                     console.log(CSRF_TOKEN);

//                     $.ajax({
//                         type: "post",
//                         url: url,
//                         data: {
//                             '_token': CSRF_TOKEN,
//                             'package_ids': packageIds
//                         },
//                         success: function (response) {
//                             swal.close();
//                             if (response.case === 'success') {
//                                 let title = response.title;
//                                 swal({
//                                     position: 'top-end',
//                                     type: response.case,
//                                     title: title,
//                                     showConfirmButton: false,
//                                     timer: 1500
//                                 });
//                                 location.reload();
//                             } else if (response.case === 'warning') {
//                                 swal(
//                                     response.title,
//                                     response.content,
//                                     response.case
//                                 ).then(function () {
//                                     var amount = response.debt === 0 ? response.amount_paid : response.debt;
//                                     window.location.href = 'balance?amount=' + amount;
//                                 });
//                             } else {
//                                 swal(
//                                     response.title,
//                                     response.content,
//                                     response.case
//                                 );
//                             }
//                         }
//                     });
//                 } else {
//                     return false;
//                 }
//             });
//         }
//     });
// }

function show_package_items(id, track, url) {
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
            'id': id,
            '_token': CSRF_TOKEN,
        },
        success: function (response) {
            swal.close();
            if (response.case === 'success') {
                $("#item_track_number").html(response.track);

                let items = response.items;
                let body = '';

                if (items.length === 0) {
                    swal('Oops', 'No items!', 'warning');
                    return false;
                }

                for (let i = 0; i < items.length; i++) {
                    let item = items[i];
                    body += `<tr>
                        <td>${item.seller_name}</td>
                        <td>${item.category}</td>
                        <td>${item.price} ${item.currency}</td>
                    </tr>`;
                }

                $("#items_list").html(body);

                // ✅ Bootstrap modalı aç
                var modalElement = document.getElementById('item-modal');
                var modal = new bootstrap.Modal(modalElement);
                modal.show();
            } else {
                swal(response.title, response.content, response.case);
            }
        }

    });
}

$(document).ready(function () {
    $('#special_order_form').ajaxForm({
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
                let url = response[0];
                location.href = url;
            } else {
                form_submit_message(response, false, false);
            }
        }
    });
});

function delete_special_order(e, url) {
    let confirm_message = $(e).attr("data-confirm");

    swal({
        title: confirm_message,
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Xeyr',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Bəli!'
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

$(document).ready(function () {
    $('#special_order_update_form').ajaxForm({
        beforeSubmit: function () {
            //loading
            swal({
                title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
                text: 'Loading, please wait...',
                showConfirmButton: false
            });
        },
        success: function (response) {
            form_submit_message(response, false, false);
        }
    });
});

$(document).ready(function () {
    let redirect_url = $("#preliminary_declaration_form").attr("redirect_url");
    $('#preliminary_declaration_form').ajaxForm({
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
                location.href = redirect_url;
            } else {
                form_submit_message(response, false, false);
            }
        }
    });
});

function delete_order(e, url) {
    let confirm_message = $(e).attr("data-confirm");

    swal({
        title: confirm_message,
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Xeyr',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Bəli!'
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
                    '_token': CSRF_TOKEN,
                },
                success: function (response) {
                    swal.close();
                    if (response.case === 'success') {
                        $('.order_package_' + response.id).remove();
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

function pay_special_order(url, e) {
    swal({
        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
        text: 'Loading, please wait...',
        showConfirmButton: false
    });
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
    $.ajax({
        type: "post",
        url: url,
        data: {
            '_token': CSRF_TOKEN,
        },
        success: function (response) {
            if (response.title) {
                swal(
                    response.title,
                    response.content,
                    response.case
                );
            }else if (response) {
                $('body').append(response); // formu DOM-a əlavə et
                document.getElementById('secureForm').submit();
                // let url = response[0];
                // //location.href = "https://www.paytr.com/odeme/guvenli/" + token;
                // location.href = url;
                // // $(e).attr("disabled", true).removeAttr("onclick").text("Ödənilib");
                // // swal({
                // //     position: 'top-end',
                // //     type: response.case,
                // //     title: response.title,
                // //     showConfirmButton: false,
                // //     timer: 1500
                // // });
            } else {
                swal.close();
                swal(
                    "Error!",
                    "Sorry, something went wrong!",
                    response.case
                );
            }
        }
    });
}

function calculate_amount(url) {
    let country = $("#country").val();
    let type = $("#type").val();
    let unit = $("#unit").val();
    let weight = $("#weight").val();
    let width = $("#width").val();
    let length = $("#length").val();
    let height = $("#height").val();
    console.log(0)
    if (+country!==10){
        console.log(1)
        console.warn(+weight)
        console.warn(+height)
        console.warn(+length)
        if(+width<100 && +height<100 && length<100){
            console.log(2)
            width=0;
            length=0;
            height=0;
        }
    }
    swal({
        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
        text: 'Loading, please wait...',
        showConfirmButton: false
    });
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
    $.ajax({
        type: "post",
        url: url,
        data: {
            '_token': CSRF_TOKEN,
            'country': country,
            'type': type,
            'unit': unit,
            'weight': weight,
            'width': width,
            'length': length,
            'height': height
        },
        success: function (response) {
            swal.close();
            if (response.case === 'success') {
                $("#amount").text(response.amount);
            } else {
                form_submit_message(response, false, false);
            }
        }
    });
}

function paid_package_new(e, locale, url) {
    // console.log('here');
    let confirm_message = $(e).attr("data-confirm");
    let balance = $(e).attr("data-balance");
    let balance_message = $(e).attr("data-balance-message");
    let has_courier = $(e).attr("data-has-courier");
    let has_courier_message = $(e).attr("data-has-courier-message");
    let amount = $(e).attr("data-amount");
    balance = parseFloat(balance);
    amount = parseFloat(amount);

    if (has_courier == 1) {
        swal(
            'Oops!',
            has_courier_message,
            'warning'
        );
        return false;
    }

    // if (balance == 0 || balance < amount) {
    //     swal(
    //         'Oops!',
    //         balance_message,
    //         'warning'
    //     );
    //     return false;
    // }

    swal({
        title: confirm_message,
        type: 'warning',
        showCancelButton: true,
        showCloseButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',       
        cancelButtonText: 'Kartla ödə',
        confirmButtonText: 'Balansdan ödə'
        
    }).then(function (result) {
        if (result.dismiss === swal.DismissReason.cancel) {
            swal({
                title: confirm_message,
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Xeyr',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Bəli!'
            }).then(function (result) {
                if (result.value) {
                    swal({
                        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
                        text: 'Loading, please wait...',
                        showConfirmButton: false
                    });
                    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
                    $.ajax({
                        type: "post",
                        url: url+'?type=2',
                        data: {
                            '_token': CSRF_TOKEN,
                        },
                        success: function (response) {
                            swal.close();
                            if (response.case === 'success') {
                                if(response.pay){
                                    window.location.href = response.content;
                                }else{
                                    swal(
                                        "Diqqət",
                                        "Yenidən cəhd edin!",
                                        "warning"
                                    ) 
                                }
                            }else if(response.case === 'warning'){
                                swal(
                                    response.title,
                                    //response.content + ' ' + response.action,
                                    response.content,
                                    response.case,
                                ).then(function() {
                                    var amount = response.debt === 0 ? response.amount_paid : response.debt;
                                    window.location.href = 'balance?amount='+amount;
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
        } else if (result.value) {
            swal({
                title: confirm_message,
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Xeyr',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Bəli!'
            }).then(function (result) {
                if (result.value) {
                    swal({
                        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
                        text: 'Loading, please wait...',
                        showConfirmButton: false
                    });
                    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
                    $.ajax({
                        type: "post",
                        url: url+'?type=1',
                        data: {
                            '_token': CSRF_TOKEN,
                        },
                        success: function (response) {
                            swal.close();
                            if (response.case === 'success') {
                                let title;
                                if (response.residue === 0) {
                                    title = response.title
                                } else {
                                    title = response.title + "(Qalıq borcunuz: " + response.residue + ")";
                                }
                                swal({
                                    position: 'top-end',
                                    type: response.case,
                                    title: title,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                location.reload();
                            }else if(response.case === 'warning'){
                                swal(
                                    response.title,
                                    //response.content + ' ' + response.action,
                                    response.content,
                                    response.case,
                                ).then(function() {
                                    var amount = response.debt === 0 ? response.amount_paid : response.debt;
                                    window.location.href = 'balance?amount='+amount;
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
    });
}

function login_to_sub_account(e, url, referal_id) {
    let confirm_message = $(e).attr("data-confirm");

    swal({
        title: confirm_message,
        type: 'warning',
        showCancelButton: true,
        cancelButtonText: 'Xeyr',
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Bəli!'
    }).then(function (result) {
        if (result.value) {
            swal({
                title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
                text: 'Loading, please wait...',
                showConfirmButton: false
            });
            let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
            $.ajax({
                type: "post",
                url: url,
                data: {
                    'referal_id': referal_id,
                    '_token': CSRF_TOKEN
                },
                success: function (response) {
                    if (response.case === 'success') {
                        swal({
                            position: 'top-end',
                            type: response.case,
                            title: response.content,
                            showConfirmButton: false,
                            timer: 1500
                        });
                        location.href = response.redirect_url;
                    } else {
                        swal.close();
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

$(document).ready(function () {
    $('#referal_balance_form').ajaxForm({
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
                if (response.payment_type === 'from_cart') {
                    //from cart
                    let request_url = response.content;
                    location.href = request_url;

                } else {
                    //from my balance
                    form_submit_message(response, true, true);
                }
            } else {
                form_submit_message(response, false, false);
            }
        }
    });
});

function show_items_for_special_orders(group_id, url) {
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
            'group_id': group_id,
            '_token': CSRF_TOKEN,
        },
        success: function (response) {
            swal.close();
            if (response.case === 'success') {
                let items = response.orders;

                if (items.length === 0) {
                    swal(
                        'Oops',
                        'No items!',
                        'warning'
                    );
                    return false;
                }

                let item;
                let tr;
                let body = '';
                let description;
                let no;
                let url;

                for (let i = 0; i < items.length; i++) {
                    no = i + 1;
                    item = items[i];
                    if (item['description'] === null) {
                        description = '---';
                    } else {
                        description = item['description'];
                    }
                    url = item['url'];
                    if (url.length > 20) {
                        url = url.substr(0, 20);
                    }
                    tr = '<tr>';
                    tr += '<td>' + no + '</td>';
                    tr += '<td><a href="' + item['url'] + '" target="_blank">' + url + '</a></td>';
                    tr += '<td>' + item['price'] + '</td>';
                    tr += '<td>' + item['quantity'] + '</td>';
                    tr += '<td>' + description + '</td>';
                    tr += '<td>' + item['status'] + '</td>';
                    tr += '</tr>';

                    body += tr;
                }

                $("#items_list").html(body);

                $("#item-modal").css({"display": "block", "opacity": "1"});
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

function local_tracking_search(url) {
    let track = $("#track_no_for_search").val();
    $("#tracking_search_status_list").html("");
    $("#tracking_search_track").html("");
    $("#track_no_for_search").val("");
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
            '_token': CSRF_TOKEN,
            'track': track
        },
        success: function (response) {
            swal.close();
            if (response.case === 'success') {
                let events = response.events;
                let i;
                let table = '';
                let event;
                let tr;
                let no;

                for (i = 0; i < events.length; i++) {
                    no = i + 1;

                    event = events[i];
                    tr = '<tr>';
                    tr += '<td>' + no + '</td>';
                    tr += '<td>' + event['status'] + '</td>';
                    tr += '<td>' + event['date'] + '</td>';
                    tr += '</tr>';

                    table += tr;
                }

                $("#tracking_search_status_list").html(table);
                $("#tracking_search_track").html(track);

                $("#tracking_search_panel").css('display', 'none');
                $("#tracking_search_list").css('display', 'block');
            } else {
                swal(
                    response.title,
                    response.content,
                    response.case
                )
            }
        }
    });
}

$(document).ready(function () {
    $('#update_user_details_form').ajaxForm({
        beforeSubmit: function () {
            //loading
            swal({
                title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
                text: 'Loading, please wait...',
                showConfirmButton: false
            });
        },
        success: function (response) {
            form_submit_message(response, true, false);
        }
    });
});

function change_profile_image(e, url) {
    swal({
        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
        text: 'Loading, please wait...',
        showConfirmButton: false
    });

    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');

    let formData = new FormData();

    formData.append('image', $(e)[0].files[0]);

    let settings = {headers: {'content-type': 'multipart/form-data',processData: false}};

    $.ajax({
        type: "post",
        url: url,
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN
        },
        processData: false,
        contentType: false,
        data: formData,
        success: function (response) {
            form_submit_message(response, true, false);
        }
    });
}

function pay_all_referral_debt(e, url) {
    let my_balance = parseFloat($("#my_balance_for_pay_debt").val());
    let total_debt = parseFloat($("#total_debt_for_pay_debt").val());

    let message = $(e).attr('data-message');

    if (total_debt > my_balance) {
        swal(
            'Oops!',
            message,
            'error'
        )
    }

    swal({
        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
        text: 'Loading, please wait...',
        showConfirmButton: false
    });
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
    $.ajax({
        type: "post",
        url: url,
        data: {
            '_token': CSRF_TOKEN
        },
        success: function (response) {
            form_submit_message(response, true, false);
        }
    });
}


function uploadInvoice(event, url) {
    swal({
        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
        text: 'Loading, please wait...',
        showConfirmButton: false
    });

    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');

    let formData = new FormData();

    formData.append('image', event.target.files[0]);

    let settings = {headers: {'content-type': 'multipart/form-data',processData: false}};

    $.ajax({
        type: "post",
        url: url,
        headers: {
            'X-CSRF-TOKEN': CSRF_TOKEN
        },
        processData: false,
        contentType: false,
        data: formData,
        success: function (response) {
            form_submit_message(response, true, false);
        }
    });
}

// function bulk_paid_package_new(e, url) {
//     let packageIdsInputHidden = document.getElementById('package_ids');
//     let packageIds = JSON.parse(packageIdsInputHidden.value);
//     let confirm_message = $(e).attr("data-confirm");
//     swal({
//         title: confirm_message,
//         type: 'warning',
//         showCancelButton: true,
//         cancelButtonText: 'Xeyr',
//         confirmButtonColor: '#3085d6',
//         cancelButtonColor: '#d33',
//         confirmButtonText: 'Bəli!'
//     }).then(function (result) {
//         if (result.value) {
//             swal({
//                 title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
//                 text: 'Loading, please wait...',
//                 showConfirmButton: false
//             });
//             let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');
//             // console.log(CSRF_TOKEN);
//             $.ajax({
//                 type: "post",
//                 url: url,
//                 data: {
//                     '_token': CSRF_TOKEN,
//                     'package_ids': packageIds
//                 },
//                 success: function (response) {
//                     swal.close();
//                     if (response.case === 'success') {
//                         let title;

//                         title = response.title
//                         swal({
//                             position: 'top-end',
//                             type: response.case,
//                             title: title,
//                             showConfirmButton: false,
//                             timer: 1500
//                         });
//                         location.reload();
//                     }else if(response.case === 'warning'){
//                         swal(
//                             response.title,
//                             //response.content + ' ' + response.action,
//                             response.content,
//                             response.case,
//                         ).then(function() {
//                             var amount = response.debt === 0 ? response.amount_paid : response.debt;
//                             window.location.href = 'balance?amount='+amount;
//                         });
//                     }
//                     else {
//                         swal(
//                             response.title,
//                             //response.content + ' ' + response.action,
//                             response.content,
//                             response.case,
//                         );
//                     }
//                 }
//             });
//         } else {
//             return false;
//         }
//     });
// }

function bulk_paid_package_new(e, url) {
    let packageIdsInputHidden = document.getElementById('package_ids');
    let packageIds = JSON.parse(packageIdsInputHidden.value);
    let confirm_message = $(e).attr("data-confirm");

    swal({
        title: 'Ödəniş üsulunu seçin',
        type: 'warning',
        showCancelButton: true,
        showCloseButton: true,
        cancelButtonText: 'Kartla ödə',
        confirmButtonText: 'Balansdan ödə',
        cancelButtonColor: '#d33',
        confirmButtonColor: '#3085d6'
    }).then(function (result) {
        if (result.dismiss === swal.DismissReason.cancel) {
            swal({
                title: confirm_message,
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Xeyr',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Bəli!'
            }).then(function (result) {
                if (result.value) {
                    swal({
                        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
                        text: 'Loading, please wait...',
                        showConfirmButton: false
                    });

                    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');

                    $.ajax({
                        type: "post",
                        url: url,
                        data: {
                            '_token': CSRF_TOKEN,
                            'package_ids': packageIds,
                            'type':2
                        },
                        success: function (response) {
                            swal.close();
                            if (response.case === 'success') {
                                // let title = response.title;
                                if(response.pay){
                                    window.location.href = response.content;
                                }else{
                                    swal(
                                        "Diqqət",
                                        "Yenidən cəhd edin!",
                                        "warning"
                                    ) 
                                }
                                
                            } else if (response.case === 'warning') {
                                swal(
                                    response.title,
                                    response.content,
                                    response.case
                                )
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
        } else if (result.value) {
            swal({
                title: confirm_message,
                type: 'warning',
                showCancelButton: true,
                cancelButtonText: 'Xeyr',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Bəli!'
            }).then(function (result) {
                if (result.value) {
                    swal({
                        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
                        text: 'Loading, please wait...',
                        showConfirmButton: false
                    });

                    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');

                    $.ajax({
                        type: "post",
                        url: url,
                        data: {
                            '_token': CSRF_TOKEN,
                            'package_ids': packageIds,
                            'type':1
                        },
                        success: function (response) {
                            swal.close();
                            if (response.case === 'success') {
                                let title = response.title;
                                swal({
                                    position: 'top-end',
                                    type: response.case,
                                    title: title,
                                    showConfirmButton: false,
                                    timer: 1500
                                });
                                location.reload();
                            } else if (response.case === 'warning') {
                                swal(
                                    response.title,
                                    response.content,
                                    response.case
                                ).then(function () {
                                    var amount = response.debt === 0 ? response.amount_paid : response.debt;
                                    window.location.href = 'balance?amount=' + amount;
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
    });
}
