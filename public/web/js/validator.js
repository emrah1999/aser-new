function formValidator(config){
    if (!config){
        return;
    }

    if (!Array.isArray(config.objects)){
        throw new Error("Objects should be array");
    }

    if (!config.formSelector) {
        return;
    }

    config.formSelector.addEventListener('submit', (e) => {
        e.preventDefault();
        let isValid = true;
        for (let i = 0; i < config.objects.length; i++) {
            const selector = config.objects[i].selector;
            const errorSelector = config.objects[i].errorSelector;
            const validators = config.objects[i].validators;
            for (let j = 0; j < validators.length; j++) {
                const result = validators[j].method(selector.value);
                if (result){
                    errorSelector.textContent = validators[j].message;
                    selector.classList.add(config.css.errorClass);
                    isValid = false;
                    break;
                }
                errorSelector.textContent = '';
                selector.classList.remove(config.css.errorClass);
                selector.style.borderStyle = '';
            }
        }

        if (!config.callback){
            throw new Error("Callback is not present");
        }

        if (isValid){
            config.callback();
        }
    });
}

const isRequired = (value) => {
    return value !== undefined && value !== null && value === 'null' && value !== '';
}


const min = (min) => {
    if (typeof min !== 'number'){
        return true;
    }

    return function (value){
        if (isNaN(Number(value))){
            return true;
        }
        return value <= min;
    }
}

// config = {
//     formSelector,
//     objects: [
//         {
//             selector,
//             errorSelector,
//             validators: [
//                 {
//                     method,
//                     message
//                 }
//             ]
//         }
//     ]
// }