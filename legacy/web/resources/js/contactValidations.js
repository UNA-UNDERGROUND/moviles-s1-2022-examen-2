const contactExpression = {
	email: /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,4})+$/, 
    phone: /^\d{8}$/, 
    justLetters: /^[a-zA-ZÀ-ÿ0-9]$/
}

function addDinamycMask(actualPhone, input){
    var newPhone = "";
    if (actualPhone.length === 5){
        for (var i = 0; i < actualPhone.length; i++){
            if (i === 3 && input.key !== 'Backspace'){
                newPhone += actualPhone.charAt(i) + "-";
            }else{
                newPhone += actualPhone.charAt(i);
            }
        }
    }else{
        newPhone = actualPhone;
    }
    return newPhone;
}

function validatePhoneInput(expression, input, inputName, e, feedbackMessage){
    var warningMessage = document.createElement('div');
    warningMessage.setAttribute('class', 'invalid-feedback');
    warningMessage.setAttribute('name', 'warningMessage');
    removeWarningDivs(inputName);
    if (input.value === ""){
        document.getElementById('div-' + inputName).appendChild(warningMessage);
        document.getElementById(inputName).classList.remove('is-invalid');
    }else{

        if (input.value.length > 16){
            input.value = input.value.substring(0, 16);
        }else{
            if (input.value.length < 16){
                input.value = addDinamycMask(input.value, e);
                var valueOfInput = input.value.replaceAll('-','');
                valueOfInput = valueOfInput.replaceAll('+(506) ','');
                if (valueOfInput.charAt(0) != 0){
                    if(expression.test(valueOfInput)){
                        document.getElementById(inputName).classList.remove('is-invalid');
                        warningMessage.innerHTML = '';
                        if (!document.getElementById(inputName).value.includes('+(506) ')){
                            document.getElementById(inputName).value = '+(506) ' + document.getElementById(inputName).value;
                        }
                    } else {
                        if (document.getElementById(inputName).value.includes('+(506) ')){
                            document.getElementById(inputName).value = document.getElementById(inputName).value.replaceAll('+(506) ','');
                        }
                        warningMessage.innerHTML = feedbackMessage;
                        addInvalidClassAndMessage(inputName, warningMessage);
                    }
                }else{
                    warningMessage.innerHTML = 'No se permiten n&uacute;meros de tel&eacute;fono que inicien con 0';
                    addInvalidClassAndMessage(inputName, warningMessage);
                } 
            }
        } 
    }
}

function countAtSign(email){
    var count = 0;
    var flag = false;
    for (var i = 0; i < email.length; i++){
        if (email.charAt(i) === "@"){
            count++;
        }
    }
    if (count > 1 || count === 0){
        flag = true;
    }
    return flag;
}

function validateEmail(expression,emailValidation,input, inputName, feedbackMessage){
    var warningMessage = document.createElement('div');
    warningMessage.setAttribute('class', 'invalid-feedback');
    warningMessage.setAttribute('name', 'warningMessage');
    removeWarningDivs(inputName);
    if (input.value === ""){
        document.getElementById('div-' + inputName).appendChild(warningMessage);
        document.getElementById(inputName).classList.remove('is-invalid');
    }else{
        if (!countAtSign(input.value)){
            if (expression.test(input.value.charAt(0))){
                if(emailValidation.test(input.value) && input.value.length <= 80){
                    document.getElementById(inputName).classList.remove('is-invalid');
                    warningMessage.innerHTML = '';
                } else {
                    warningMessage.innerHTML = feedbackMessage;
                    addInvalidClassAndMessage(inputName, warningMessage);
                }
            }else{
                warningMessage.innerHTML = 'Solo se puede iniciar con una letra o n&uacute;mero';
                addInvalidClassAndMessage(inputName, warningMessage);
            } 
        }else{
            warningMessage.innerHTML = 'El correo debe de contener un solo "@"';
            addInvalidClassAndMessage(inputName, warningMessage);
        }  
    }

}