
function initializerEventListener(){
    localStorage.clear();
    document.getElementById("btn-cancel-training-plan").addEventListener("click", function(){
        localStorage.clear();
        $("#modalNewTrainingPlan").modal("hide");
        document.getElementById("formNewTrainingPlan").reset();
        document.getElementById("trainingPlanInfo").innerHTML = "";
        resetAllFormActivity(false);
    });
    document.getElementById("btn-new-trainingPlan").addEventListener("click", function(){
        $("#modalNewTrainingPlan").modal("show");
    });
    $('#modalNewTrainingPlan').modal({backdrop: 'static', keyboard: false})
    getTrainingPlans();
}

function submitData(isNewPlan){
   
    var trainingPlanName = document.getElementById('trainingPlanName');
    var jsonInfo = [];
    if (localStorage.getItem("schedule") != null){
        jsonInfo = JSON.parse(localStorage.getItem("schedule"));
        if (trainingPlanName.value != '' && jsonInfo.length > 0){
            const data = new FormData();
            if (isNewPlan){
                data.append("create", "create");
            }else{
                data.append("update", "update");
                data.append("idTrainingPlan", document.getElementById("idTrainingPlan").value);
            }
            data.append("trainingPlanName", trainingPlanName.value);
            data.append("dataTrainingPlan", JSON.stringify(jsonInfo));
            var http = new XMLHttpRequest();
            http.open('POST', '../business/trainingPlanAction.php', true);
            http.send(data);
            http.onreadystatechange = function () {
                if (http.readyState === 4) {
                    console.log(http.responseText);
                    var info = JSON.parse(http.responseText);
                    if (info[0].success == 1){
                        swal("¡" + info[0].message + "!","","success",{button: "ok"}).then(()=>{
                            window.location.reload();
                            localStorage.clear();
                        });
                    }else{
                        swal("¡" + info[0].message + "!","","error",{button: "ok"});
                    }
                }
            };
        }else{
            swal("¡Debe agregar al menos un día y un nombre al plan de entrenamiento!","","warning",{button: "ok"});
        }
    }else{
        swal("¡No hay días que guardar en el plan!","","warning",{button: "ok"});
    }
}

function updateTrainingPlan(id, name){
    const data = new FormData();
    document.getElementById("idTrainingPlan").value = id;
    var trainingPlanName = document.getElementById("trainingPlanName");
    data.append("getSpecificTrainingPlan", "getSpecificTrainingPlan");
    data.append("idTrainingPlan", id);
    var http = new XMLHttpRequest();
    http.open('POST', '../business/trainingPlanAction.php', true);
    http.send(data);
    http.onreadystatechange = function () {
        if (http.readyState === 4) {
            console.log(http.responseText);
            localStorage.setItem("schedule", http.responseText);
            showInfoSchedule();
            trainingPlanName.value = name;
            trainingPlanName.disabled = true;
            document.getElementById("btn-new-training-plan").classList.add("d-none");
            document.getElementById("btn-save-changes-training-plan").classList.remove("d-none");
            $("#modalNewTrainingPlan").modal("show");
        }
    };
}

function deleteTrainingPlan(id){
    const data = new FormData();
    data.append("delete", "delete");
    data.append("idTrainingPlan", id);
    var http = new XMLHttpRequest();
    http.open('POST', '../business/trainingPlanAction.php', true);
    http.send(data);
    http.onreadystatechange = function () {
        if (http.readyState === 4) {
            console.log(http.responseText);
            var info = JSON.parse(http.responseText);
            if (info[0].success == 1){
                swal("¡" + info[0].message + "!","","success",{button: "ok"}).then(()=>{
                    window.location.reload();
                    localStorage.clear();
                });
            }else{
                swal("¡" + info[0].message + "!","","error",{button: "ok"});
            }
        }
    };
}

function getTrainingPlans(){
    const data = new FormData();
    data.append("getTrainingPlans", "getTrainingPlans");
    var http = new XMLHttpRequest();
    http.open('POST', '../business/trainingPlanAction.php', true);
    http.send(data);
    http.onreadystatechange = function () {
        if (http.readyState === 4) {
            var info = JSON.parse(http.responseText);
            var tbodyTrainingPlans = document.getElementById("tbody-training-plans");
            var stringTableBody = '';
            for (var i = 0; i < info.length; i++){
                stringTableBody += '<tr>';
                stringTableBody += '<td>' + info[i].id + '</td>';
                stringTableBody += '<td>' + info[i].name + '</td>';
                stringTableBody += '<td><img width="200" height="200" src="../resources/trainingPlansQr/'+ info[i].qrCode + '.png?nocache=<?php echo time(); ?>"/></td>';
                stringTableBody += "<td><button class=\"btn btn-primary\" type=\"button\" onclick='return updateTrainingPlan(\"" + info[i].id + "\",\"" + info[i].name + "\");'>Modificar</button></td>";
                stringTableBody += "<td><button class=\"btn btn-danger\" type=\"button\" onclick='return deleteTrainingPlan(\"" + info[i].id + "\");'>Eliminar</button></td>";
                stringTableBody += '</tr>';
            }
            tbodyTrainingPlans.innerHTML = stringTableBody;
        }
    };
}

function resetAllFormActivity(update){
    var activityName = document.getElementById("activityName");
    var btnUpdateActivity = document.getElementById("btn-update-activity");
    var btnAddActivity = document.getElementById("btn-add-activity");
    var sectionsActivity = document.getElementById("sectionsActivity");
    var btnNewTrainingPlan = document.getElementById("btn-new-training-plan");
    var btnSaveChanges = document.getElementById("btn-save-changes-training-plan");
    var trainingPlanName = document.getElementById("trainingPlanName");
    document.getElementById("sections").selectedIndex = 0;
    if (update){
        btnUpdateActivity.classList.remove("d-none");
        btnAddActivity.classList.add("d-none");
        sectionsActivity.innerHTML = "";
        activityName.disabled = true;
        btnNewTrainingPlan.classList.add("d-none");
        btnSaveChanges.classList.remove("d-none");
        trainingPlanName.disabled = true;
    }else{
        btnUpdateActivity.classList.add("d-none");
        btnAddActivity.classList.remove("d-none");
        sectionsActivity.innerHTML = "";
        activityName.value = "";
        activityName.disabled = false;
        btnNewTrainingPlan.classList.remove("d-none");
        btnSaveChanges.classList.add("d-none");
        trainingPlanName.disabled = false;
    }
    document.getElementById("div-form-activity").classList.add('d-none');
}

function deleteDay(day){// se elemina un dia del horario que se lleva hasta el momento
    if (localStorage.getItem("schedule") != null){
        var stringJSON = localStorage.getItem("schedule");
        console.log(stringJSON);
        var info = JSON.parse(stringJSON);
        for (var i = 0; i < info.length; i++){
            if (info[i].idDay == day){
                info.splice(i, 1);
            }
        }
        localStorage.setItem("schedule", JSON.stringify(info));
        showInfoSchedule();
        if (info.length == 0){
            localStorage.clear();
        }
        if (document.getElementById('btn-new-training-plan').classList.contains('d-none')){
            resetAllFormActivity(true);
        }else{
            resetAllFormActivity(false);
        }
    }
}

function addActivity(id){
    document.getElementById("btn-update-activity").classList.add("d-none");
    document.getElementById("btn-add-activity").classList.remove("d-none");
    sectionsActivity.innerHTML = "";
    activityName.value = "";
    activityName.disabled = false;
    $("#daySelected").val(id);
    $("#div-form-activity").toggleClass("d-none");
}

function saveChangesActivity(){
    deleteActivity(document.getElementById("daySelected").value, document.getElementById("activityName").value);
    document.getElementById("btn-update-activity").classList.add("d-none");
    document.getElementById("btn-add-activity").classList.remove("d-none");
    saveActivity();
}

function updateActivity(idDay, nameActivity){
    if (localStorage.getItem("schedule") !== null){
        document.getElementById("daySelected").value = idDay;
        var stringJSON = localStorage.getItem("schedule");
        var info = JSON.parse(stringJSON);
        var activityName = document.getElementById("activityName");
        activityName.value = nameActivity;
        activityName.disabled = true;
        var jsonActivities = [];
        var section = '';
        for (var i = 0; i < info.length; i++){
            if (info[i].activities != '' && info[i].idDay == idDay){
                jsonActivities = JSON.parse(info[i].activities);
                jsonActivities.forEach(function(activity) {
                Object.keys(activity).forEach(function(key) {
                    if (activity['activity'] == nameActivity){
                        if (key != 'activity' && activity[key] != ''){
                            section = '<div id="div-' + key + '" class="row"><div class="col"><div class="form-group"><label>' + key + '</label>';
                            section += '<textarea rows="5" cols="5" id="' + key + '" class="form-control">' + activity[key] + '</textarea>';
                            section += "</div></div><div class=\"col\"><br><button class=\"btn btn-danger\" type=\"button\" onclick='return deleteSection(\"" + key + "\");'>Eliminar</button></div></div>";
                            document.getElementById("sectionsActivity").insertAdjacentHTML("beforeEnd", section);
                        }
                    }
                    console.log(key + ': ' +activity[key]);
                })
                console.log('--------------');
                });
            }
        }
        document.getElementById("div-form-activity").classList.remove("d-none");
        document.getElementById("btn-update-activity").classList.remove("d-none");
        document.getElementById("btn-add-activity").classList.add("d-none");
    }
}

function deleteActivity(idDay, nameActivity){
    if (localStorage.getItem("schedule") != null){
        var stringJSON = localStorage.getItem("schedule");
        var info = JSON.parse(stringJSON);
        var jsonActivities = [];
        for (var i = 0; i < info.length; i++){
            if (info[i].activities != '' && info[i].idDay == idDay){
                jsonActivities = JSON.parse(info[i].activities);
                for (var j = 0; j < jsonActivities.length; j++){
                    if (jsonActivities[j].activity == nameActivity){
                        console.log(jsonActivities[j]);
                        jsonActivities.splice(j, 1);
                        console.log(jsonActivities);
                        if (jsonActivities.length != 0){
                            info[i].activities = JSON.stringify(jsonActivities);
                        }else{
                            info[i].activities = "";
                        }
                        j = jsonActivities.length;
                        i = info.length;
                    }
                }
            }
        }

        localStorage.setItem("schedule", JSON.stringify(info));
        showInfoSchedule();
        document.getElementById("div-form-activity").classList.add("d-none");
    }
} 

function showInfoSchedule(){// muestra los dias que se van agregando segun informacion del server
    if (localStorage.getItem("schedule") != null){
        var stringJSON = localStorage.getItem("schedule");
        console.log(stringJSON);
        var info = JSON.parse(stringJSON);
        var stringHTML = "";
        var stringTable = '';
        for (var i = 0; i < info.length; i++){
            stringHTML += '<tr>';
            stringHTML += '<td>' + info[i].day + '</td>';
            stringTable = '<table class="table"><thead><th>Nombre</th><th>Acci&oacute;n</th><th>Acci&oacute;n</th></thead><tbody id="activities-' + info[i].idDay + '">';
            if (info[i].activities != ''){
                //console.log(info[i].activities);
                jsonActivities = JSON.parse(info[i].activities);
                
                jsonActivities.forEach(function(activity) {
                Object.keys(activity).forEach(function(key) {
                    if (key == 'activity'){
                        stringTable += '<tr>';
                        stringTable += '<td>' + activity[key] + '</td>';
                        stringTable += "<td><button class=\"btn btn-danger\" type=\"button\" onclick='return deleteActivity(\"" + info[i].idDay + "\",\"" + activity[key] + "\");'>Eliminar</button></td>";
                        stringTable += "<td><button class=\"btn btn-primary\" type=\"button\" onclick='return updateActivity(\"" + info[i].idDay + "\",\"" + activity[key] + "\");'>Modificar</button></td>";
                        stringTable += "</tr>";
                    }
                    console.log(key + ': ' +activity[key])
                })
                console.log('--------------')
                });
            }
            stringTable +='</tbody></table>';
            stringHTML += '<td>'+ stringTable + '</td>';
            stringHTML += "<td><button class=\"btn btn-danger\" type=\"button\" onclick='return deleteDay(\"" + info[i].idDay + "\");'>Eliminar</button></td>";
            stringHTML += "<td><button class=\"btn btn-primary\" type=\"button\" onclick='return addActivity(\"" + info[i].idDay + "\");'>Agregar Actividad</button></td>";
            stringHTML += "</tr>";
        }
        document.getElementById("trainingPlanInfo").innerHTML = stringHTML;
    }
}

function checkDay(idDay, array){
    var info = JSON.parse(array);
    var flag = false;
    for (var i = 0; i < info.length; i++){
        if (info[i].idDay == idDay){
            flag = true;
            i = info.length;
        }
    }
    return flag;
}

function saveDay(){
    var optionDay = document.getElementById("day").value;
    var scheduleText, day = '';
    if (optionDay == "none"){
        swal("¡Por favor, seleccione un día!","","warning",{button: "ok"});
    }else{

        if (localStorage.getItem("schedule") !== null){
            if (!checkDay(optionDay, localStorage.getItem('schedule'))){
                day = '{"idDay":"' + optionDay + '", "day":"' + $("#day  option:selected").text() + '", "activities":""}';
                scheduleText = localStorage.getItem("schedule");
                scheduleText = '[' + (scheduleText != ""? scheduleText.substring(1, scheduleText.length - 1) + ',':'') + day + ']'; 
                localStorage.setItem("schedule", scheduleText);
            }else{
                swal("¡Este día ya se encuentra en el plan!","","warning",{button: "ok"});
            }
        }else{
            day ='{"idDay":"' + optionDay + '", "day":"' + $("#day  option:selected").text() + '", "activities":""}';
            scheduleText = '[' + day + ']'; 
            localStorage.setItem("schedule", scheduleText);
        }
        showInfoSchedule();
        document.getElementById("day").selectedIndex = 0;
    }
}

function deleteSection(idDiv){
    $("#div-" + idDiv).remove();
}

function addSection(){
    var optionSection = document.getElementById("sections");
    if (optionSection.value == "none"){
        swal("¡Por favor, seleccione una sección!","","warning",{button: "ok"});
    }else{
        if (document.getElementById("div-" + $("#sections  option:selected").text()) !== null){
            swal("¡Esta sección ya se encuentra!","","warning",{button: "ok"});
        }else{
            var section = '<div id="div-' + $("#sections  option:selected").text() + '" class="row"><div class="col"><div class="form-group"><label>' + $("#sections  option:selected").text() + '</label>';
            section += '<textarea rows="5" cols="5" id="' + $("#sections  option:selected").text() + '" class="form-control"></textarea>';
            section += "</div></div><div class=\"col\"><br><button class=\"btn btn-danger\" type=\"button\" onclick='return deleteSection(\"" + $("#sections  option:selected").text() + "\");'>Eliminar</button></div></div>";
            document.getElementById("sectionsActivity").insertAdjacentHTML("beforeEnd", section);
            optionSection.selectedIndex = 0;
        }
    }
}

function checkActivities(activities, nameNewActivity){
    var flag = false;
    if (activities != ''){
        console.log("entro");
        var jsonActivities = JSON.parse(activities);
        jsonActivities.forEach(function(activity) {
            Object.keys(activity).forEach(function(key) {
                if (key == "activity" && activity[key].trim().toLowerCase() == nameNewActivity.trim().toLowerCase()){
                    flag = true;
                }
                console.log(key + ': ' +activity[key])
            })
            console.log('--------------')
        });
    }
    return flag;
}

function saveActivity(){
    var idDay = document.getElementById("daySelected").value;
    var scheduleJSON = [];
    var flag = true;
    var activityExist = false;
    var textAreas = document.getElementsByTagName('textarea');
    var stringActivity = '';
    if (document.getElementById("activityName").value == ''){
        swal("¡Algunos campos son obligatorios!","","warning",{button: "ok"});
    }else{
        if (localStorage.getItem("schedule") !== null){
            stringActivity = '{"activity":"' + document.getElementById("activityName").value.trim() + '",';
            if (textAreas != null){
                for (var i = 0; i < textAreas.length; i++){
                    if (textAreas[i].value == ''){
                        flag = false;
                        i = textAreas.length;
                    }else{
                        stringActivity += '"' + textAreas[i].id + '":"' + textAreas[i].value + '",';
                    }
                }
                if (flag){
                    stringActivity = stringActivity.substring(0, stringActivity.length - 1) + '}';//quito la ultima coma
                    scheduleJSON = JSON.parse(localStorage.getItem("schedule"));
                    for (var i = 0; i < scheduleJSON.length; i++){
                        if (scheduleJSON[i].idDay == idDay){
                            if (!checkActivities(scheduleJSON[i].activities, document.getElementById("activityName").value)){
                                if (scheduleJSON[i].activities == ''){  
                                    scheduleJSON[i].activities = '[' + stringActivity + ']';
                                }else{
                                    scheduleJSON[i].activities = '[' + (scheduleJSON[i].activities != ""? scheduleJSON[i].activities.substring(1, scheduleJSON[i].activities.length - 1) + ',':'') + stringActivity + ']';
                                }
                            }else{
                                activityExist = true;
                            }
                            i = scheduleJSON.length;
                        }
                    }
                    if (activityExist){
                        swal("¡Nombre de actividad ya se encuentra registrado!","","warning",{button: "ok"});
                    }else{
                        localStorage.setItem("schedule", JSON.stringify(scheduleJSON));
                        showInfoSchedule();
                        if (document.getElementById('btn-new-training-plan').classList.contains('d-none')){
                            resetAllFormActivity(true);
                        }else{
                            resetAllFormActivity(false);
                        }
                    }
                }else{
                    swal("¡Las secciones deben de contener texto para ser guardadas!","","warning",{button: "ok"});
                }
            }
        }
    }

}