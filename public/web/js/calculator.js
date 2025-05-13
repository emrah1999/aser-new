const messages = {
    az: {
        required: "Bu sahə boş ola bilməz",
        min_country: "Ölkə seçilməlidir (1-dən böyük olmalıdır)",
        min_weight: "Çəki 0-dan böyük olmalıdır"
    },
    en: {
        required: "This field is required",
        min_country: "This field must be more than 1",
        min_weight: "This field must be more than 0"
    },
    ru: {
        required: "Это поле не может быть пустым",
        min_country: "Это поле должно быть больше 1",
        min_weight: "Это поле должно быть больше 0"
    }
};
let currentLang = document.documentElement.lang || 'az';
const config = {
    formSelector: document.getElementById('formCalculator'),
    objects: [
        {
            selector: document.getElementById('calcCountry'),
            errorSelector: document.getElementById('calcCountryErrorMessage'),
            validators: [
                {
                    method: isRequired,
                    message: messages[currentLang].required
                },
                {
                    method: min(1),
                    message: messages[currentLang].min_country
                }
            ]
        },
        {
            selector: document.getElementById('calcWeght'),
            errorSelector: document.getElementById('calcWeghtErrorMessage'),
            validators: [
                {
                    method: isRequired,
                    message: messages[currentLang].required
                },
                {
                    method: min(0),
                    message: messages[currentLang].min_weight
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