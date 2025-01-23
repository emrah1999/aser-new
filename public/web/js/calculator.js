const config = {
    formSelector: document.getElementById('formCalculator'),
    objects: [
        {
            selector: document.getElementById('calcCountry'),
            errorSelector: document.getElementById('calcCountryErrorMessage'),
            validators: [
                {
                    method: isRequired,
                    message: 'Bu sahə boş ola bilməz'
                },
                {
                    method: min(1),
                    message: 'This field must be more than 1'
                }
            ]
        },
        {
            selector: document.getElementById('calcWeght'),
            errorSelector: document.getElementById('calcWeghtErrorMessage'),
            validators: [
                {
                    method: isRequired,
                    message: 'This field is required'
                },
                {
                    method: min(0),
                    message: 'This field must be more than 0'
                }
            ]
        }
    ],
    css: {
      errorClass: 'error-input'
    },
    callback: () => {
        calculateRequest();
    }
}

const calculateRequest = async () => {
    const country = document.getElementById("calcCountry").value;
    const type = document.getElementById("calcTransferType").value;
    const unit = document.getElementById("calc_weight_type").value;
    const weight = document.getElementById("calcWeght").value;
    let width = document.getElementById("calcWidth").value;
    let length = document.getElementById("calcWide").value;
    let height = document.getElementById("calcHeight").value;

    if (+country === 10){
        return;
    }

    if(+width<100 && +height<100 && length<100){
        width = 0;
        length = 0;
        height = 0;
    }

    swal({
        title: '<i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i><span class="sr-only">Please wait...</span>',
        text: 'Loading, please wait...',
        showConfirmButton: false
    });
    let CSRF_TOKEN = $('meta[name="csrf-token"]').attr('secret');

    try {
        const formData = new FormData();
        formData.append('_token', CSRF_TOKEN);
        formData.append('country', country);
        formData.append('type', type);
        formData.append('unit', unit);
        formData.append('weight', weight);
        formData.append('width', width);
        formData.append('length', length);
        formData.append('height', length);
        const res = await fetch('/api/calculate-amount', {
            method: 'POST',
            body: JSON.stringify({
                '_token': CSRF_TOKEN,
                country,
                type,
                unit,
                weight,
                width,
                length,
                height
            }),
            headers: {
                'Content-Type': 'application/json; charset=UTF-8'
            }
        });
        const body = await res.json();
        if (body.case === 'success') {
            document.getElementById("amount").textContent = body.amount;
        }
    } catch (err){
        console.log(err);
    }
}
formValidator(config);