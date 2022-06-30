const expression = {
    justLetters: /^[a-zA-ZÀ-ÿ0-9]$/,
    description : /^[a-zA-ZÀ-ÿ0-9\s,.]{1,299}$/,
    allNumbers: /^[0-9]{1,6}$/,
}

function validateForm(e){
    switch (e.target.name) {

        case "idNutrition":
            validate (expression.allNumbers, expression.allNumbers,e.target,e.target.id, 'Este campo solo se permite n&uacute;meros menores de 1 000 000');
        break;

        case "nutritionDescription":
            validate (expression.description, expression.justLetters,e.target,e.target.id, 'Este campo solo se permiten letras, n&uacute;meros y "," (comas), y una longitud de 300 caracteres como m&aacute;ximo');
        break;
	}
}

function submitData(){
    
    var formNutritionPlan = document.getElementById('nutritionPlan');
    const data = new FormData(formNutritionPlan);
    data.append("create", "Crear");
    var arrayInputs = formNutritionPlan.getElementsByTagName('input');
    for (var i = 0; i < arrayInputs.length; i++){
        if (arrayInputs[i].type === "text"){
            data.append(arrayInputs[i].name, arrayInputs[i].value);
        }
    }
    var http = new XMLHttpRequest();
    http.open('POST', '../business/nutritionPlanAction.php', true);
    http.send(data);
    http.onreadystatechange = function () {
        if (http.readyState === 4) {
            console.log(http.responseText);
            var info = JSON.parse(http.responseText);
            if (info[0].success == 1){
                swal("¡" + info[0].message + "!","","success",{button: "ok"}).then(()=>{
                    window.location.reload();
                });
            }else{
                swal("¡" + info[0].message + "!","","error",{button: "ok"});
            }
        }
    };
}

function submitDataUpdate(){
    
    var formNutritionPlan = document.getElementById('nutritionPlan');
    const data = new FormData(formNutritionPlan);
    data.append("update", "Actualizar");
    var arrayInputs = formNutritionPlan.getElementsByTagName('input');
    for (var i = 0; i < arrayInputs.length; i++){
        if (arrayInputs[i].type === "text"){
            data.append(arrayInputs[i].name, arrayInputs[i].value);
        }
    }
    var http = new XMLHttpRequest();
    http.open('POST', '../business/nutritionPlanAction.php', true);
    http.send(data);
    http.onreadystatechange = function () {
        if (http.readyState === 4) {
            console.log(http.responseText);
            var info = JSON.parse(http.responseText);
            if (info[0].success == 1){
                swal("¡" + info[0].message + "!","","success",{button: "ok"}).then(()=>{
                    window.location.reload();
                });
            }else{
                swal("¡" + info[0].message + "!","","error",{button: "ok"});
            }
        }
    };
}

function validateSubmitUpdate(){

    var formNutritionPlan = document.getElementById('nutritionPlan');

    var flag = true;
    var arrayFormGroups = formNutritionPlan.querySelectorAll('input');

    for (var i = 0; i < arrayFormGroups.length; i++){

        if (arrayFormGroups[i].className.includes('is-invalid')){
            flag = false;
        }
        if (arrayFormGroups[i].value === "" && arrayFormGroups[i].required === true){
            validateEmptySpaces(true, arrayFormGroups[i].id);
            flag = false;
        }
    }

    if (flag === false){
        swal("¡Ciertos campos no están correctamente!","","warning",{button: "ok"});
    }else{
        submitDataUpdate();
    }
    return false;
}

function validateSubmit(){

    var formNutritionPlan = document.getElementById('nutritionPlan');

    var flag = true;
    var arrayFormGroups = formNutritionPlan.querySelectorAll('input');

    for (var i = 0; i < arrayFormGroups.length; i++){

        if (arrayFormGroups[i].className.includes('is-invalid')){
            flag = false;
        }
        if (arrayFormGroups[i].value === "" && arrayFormGroups[i].required === true){
            validateEmptySpaces(true, arrayFormGroups[i].id);
            flag = false;
        }
    }

    if (flag === false){
        swal("¡Ciertos campos no están correctamente!","","warning",{button: "ok"});
    }else{
        submitData();
    }
    return false;
}

function initializerEventListener(){
    var inputs = document.querySelectorAll("#nutritionPlan input");
    inputs.forEach((input) => {
        if (input.type === "text"){
            input.addEventListener('keyup', validateForm);
            input.addEventListener('blur', validateForm);
        }
    });
    // Tener ojo en esta parte por los textArea
    document.getElementById('nutritionDescription').addEventListener('keyup', validateForm);
    document.getElementById('nutritionDescription').addEventListener('blur', validateForm);

    document.getElementById('idNutrition').addEventListener('keyup', validateForm);
    document.getElementById('idNutrition').addEventListener('blur', validateForm);
}