function removeWarningDivs(inputName){
    var divsWarnings = document.querySelectorAll("#div-" + inputName + " div");
    divsWarnings.forEach((div) => {
        if (div.getAttribute('name') === 'warningMessage'){
            document.getElementById('div-' + inputName).removeChild(div);
        }
    });
}

function addInvalidClassAndMessage(inputName, warningMessage){
    document.getElementById('div-' + inputName).appendChild(warningMessage);
    document.getElementById(inputName).classList.add('is-invalid');
}

function validateEmptySpaces(empty, inputName){
    var warningMessage = document.createElement('div');
    warningMessage.setAttribute('class', 'invalid-feedback');
    warningMessage.setAttribute('name', 'warningMessage');
    removeWarningDivs(inputName);
    if (empty === true){
        warningMessage.innerHTML = 'Complete este campo';
        addInvalidClassAndMessage(inputName, warningMessage);
    }
}

function validate(expression, beginJustLetter,input, inputName, feedbackMessage){
    var warningMessage = document.createElement('div');
    warningMessage.setAttribute('class', 'invalid-feedback');
    warningMessage.setAttribute('name', 'warningMessage');
    removeWarningDivs(inputName);
    if (input.value === ""){
        validateEmptySpaces(true, inputName);
    }else{
        if (beginJustLetter.test(input.value.charAt(0))){
            if(expression.test(input.value)){
                document.getElementById(inputName).classList.remove('is-invalid');
                warningMessage.innerHTML = '';
            } else {
                warningMessage.innerHTML = feedbackMessage;
                addInvalidClassAndMessage(inputName, warningMessage);
            }
        }else{
            warningMessage.innerHTML = 'Solo se puede iniciar con una letra';
            addInvalidClassAndMessage(inputName, warningMessage);
        }   
    }

}

function validateInputNotRequired(expression, beginJustLetter,input, inputName, feedbackMessage){
    var warningMessage = document.createElement('div');
    warningMessage.setAttribute('class', 'invalid-feedback');
    warningMessage.setAttribute('name', 'warningMessage');
    removeWarningDivs(inputName);
    if (input.value === ""){
        document.getElementById('div-' + inputName).appendChild(warningMessage);
        document.getElementById(inputName).classList.remove('is-invalid');
    }else{
        if (beginJustLetter.test(input.value.charAt(0))){
            if(expression.test(input.value)){
                document.getElementById(inputName).classList.remove('is-invalid');
                warningMessage.innerHTML = '';
            } else {
                warningMessage.innerHTML = feedbackMessage;
                addInvalidClassAndMessage(inputName, warningMessage);
            }
        }else{
            warningMessage.innerHTML = 'Solo se puede iniciar con una letra';
            addInvalidClassAndMessage(inputName, warningMessage);
        }   
    }
}