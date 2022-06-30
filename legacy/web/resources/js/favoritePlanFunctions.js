function getFavoritePlanNutrition(iduser){

    const table = document.querySelector("#table_list_complemet");
    const data = new FormData();
    data.append("getAllFavoritePlanNutrition", iduser);
    var http = new XMLHttpRequest();
    http.open('POST', '../business/nutritionPlanAction.php', true);
    http.send(data);

    http.onreadystatechange = function () {
        if (http.readyState === 4) {
            var info = JSON.parse(http.responseText);
            dataPlanFavorite = info[0].allDataPlanFavorite;
            table.innerHTML = '';
            dataPlanFavorite.forEach(element => {

                const data = new FormData();
                data.append("getAllDataPlanNutrition", element.idfavoriteplan);
                var http = new XMLHttpRequest();
                http.open('POST', '../business/nutritionPlanAction.php', true);
                http.send(data);

                http.onreadystatechange = function () {

                    if (http.readyState === 4) {

                        var info2 = JSON.parse(http.responseText);

                        table.innerHTML += 
                        `<tr>
                            <td>${info2[0].name}</td>
                            <td><img src="${info2[0].codeqr}" height="100"></td>
                            <td><a href="../view/detailFavoritePlanNutrition.php?idNutritionPlan=${info2[0].idplan}" class="btn btn-primary">Ver mas</a></td>
                            <td><button onclick="deleteFavoritePlanNutrition('${element.idfavoriteplan}', ${iduser})" id="btn-delete-favorite" class="btn btn-danger">Quitar</button></td>
                        </tr>`
                    }                    
                }
            });
        }
    };
}

function getFavoritePlanTraining(iduser){

    const table = document.querySelector("#table_list_training_complemet");
    const data = new FormData();
    data.append("getAllFavoritePlanTraining", iduser);
    var http = new XMLHttpRequest();
    http.open('POST', '../business/trainingPlanActionWS.php', true);
    http.send(data);

    http.onreadystatechange = function () {
        if (http.readyState === 4) {
            var info = JSON.parse(http.responseText);
            dataPlanFavorite = info[0].allDataPlanFavorite;
            table.innerHTML = '';
            dataPlanFavorite.forEach(element => {

                const data = new FormData();
                data.append("getAllDataPlanTraining", element.idfavoriteplan);
                var http = new XMLHttpRequest();
                http.open('POST', '../business/trainingPlanActionWS.php', true);
                http.send(data);

                http.onreadystatechange = function () {

                    if (http.readyState === 4) {

                        var info2 = JSON.parse(http.responseText);

                        table.innerHTML += 
                        `<tr>
                            <td>${info2[0].name}</td>
                            <td><img src="../resources/trainingPlansQr/${info2[0].codeqr}.png?nocache=<?php echo time(); ?>" height="100"></td>
                            <td><a href="../view/detailFavoritePlanTraining.php?idTrainingPlan=${info2[0].idplan}" class="btn btn-primary">Ver mas</a></td>
                            <td><button onclick="deleteFavoritePlanTraining('${element.idfavoriteplan}', ${iduser})" id="btn-delete-favorite" class="btn btn-danger">Quitar</button></td>
                        </tr>`
                    }                    
                }
            });
        }
    };
}

function deleteFavoritePlanNutrition(idfavoriteplan, iduser){

    swal("¿Seguro que deseas quitar de sus favoritos?","","warning",{buttons:["No", "Sí"]}).then((answer)=>{
        if(answer){
            const data = new FormData();
            data.append("deleteFavoritePlanNutrition", idfavoriteplan);

            var http = new XMLHttpRequest();
            http.open('POST', '../business/nutritionPlanAction.php', true);
            http.send(data);

            http.onreadystatechange = function () {
                if (http.readyState === 4) {
                    console.log(http.responseText);
                    var info = JSON.parse(http.responseText);
                    if (info[0].success == 1){
                        swal("¡" + info[0].message + "!","","success",{button: "ok"}).then(()=>{
                            getFavoritePlanNutrition(iduser);
                        });
                    }else{
                        swal("¡" + info[0].message + "!","","error",{button: "ok"});
                    }
                }
            };
        }else{
            swal("¡Se canceló el proceso!","","error",{button:"Ok"});
        }
    });
}

function deleteFavoritePlanTraining(idfavoriteplan, iduser){

    swal("¿Seguro que deseas quitar de sus favoritos?","","warning",{buttons:["No", "Sí"]}).then((answer)=>{
        if(answer){
            const data = new FormData();
            data.append("deleteFavoritePlanTraining", idfavoriteplan);

            var http = new XMLHttpRequest();
            http.open('POST', '../business/trainingPlanActionWS.php', true);
            http.send(data);

            http.onreadystatechange = function () {
                if (http.readyState === 4) {
                    console.log(http.responseText);
                    var info = JSON.parse(http.responseText);
                    if (info[0].success == 1){
                        swal("¡" + info[0].message + "!","","success",{button: "ok"}).then(()=>{
                            getFavoritePlanTraining(iduser);
                        });
                    }else{
                        swal("¡" + info[0].message + "!","","error",{button: "ok"});
                    }
                }
            };
        }else{
            swal("¡Se canceló el proceso!","","error",{button:"Ok"});
        }
    });
}

function addFavoritePlanNutrition(idplan, iduser){

    const data = new FormData();
    data.append("insertFavoritePlanNutrition", "insert");
    data.append("idplan", idplan);
    data.append("iduser", iduser);
    var http = new XMLHttpRequest();
    http.open('POST', '../business/nutritionPlanAction.php', true);
    http.send(data);

    http.onreadystatechange = function () {
        if (http.readyState === 4) {
          
            var info = JSON.parse(http.responseText);
            if (info[0].success == 1){
                swal("¡" + info[0].message + "!","","success",{button: "ok"}).then(()=>{
                    getFavoritePlanNutrition(iduser);
                });
            }else{
                swal("¡" + info[0].message + "!","","error",{button: "ok"});
            }
        }
    };
}

function addFavoritePlanTraining(idplan, iduser){

    const data = new FormData();
    data.append("insertFavoritePlanTraining", "insert");
    data.append("idplan", idplan);
    data.append("iduser", iduser);
    var http = new XMLHttpRequest();
    http.open('POST', '../business/trainingPlanActionWS.php', true);
    http.send(data);

    http.onreadystatechange = function () {
        if (http.readyState === 4) {
          
            var info = JSON.parse(http.responseText);
            if (info[0].success == 1){
                swal("¡" + info[0].message + "!","","success",{button: "ok"}).then(()=>{
                    getFavoritePlanTraining(iduser);
                });
            }else{
                swal("¡" + info[0].message + "!","","error",{button: "ok"});
            }
        }
    };
}

function extractDataNutrition(iduser){

    if(document.getElementById('planName').value != ""){

        const data = new FormData();
        const table = document.querySelector("#table_filter_complemet");
        data.append("searchDataFilterPlanNutrition", document.getElementById('planName').value);
        var http = new XMLHttpRequest();
        http.open('POST', '../business/nutritionPlanAction.php', true);
        http.send(data);

        http.onreadystatechange = function () {
            if (http.readyState === 4) {
                var info = JSON.parse(http.responseText);
                dataPlan = info[0].allPlanFilter;
                table.innerHTML = '';
                dataPlan.forEach(element => {
    
                    table.innerHTML += 
                    `<tr>
                        <td>${element.name}</td>
                        <td><img src="${element.imagecodeqr}" height="100"></td>
                        <td><button onclick="addFavoritePlanNutrition('${element.idnutritionplan}', ${iduser})" id="btn-add-favorite" class="btn btn-primary">Agregar</button></td>
                    </tr>`
                });
            }
        };

    }else{
        swal("¡Llene el campo de nombre de plan!","","warning",{button: "ok"});
    }
}

function extractDataTraining(iduser){

    if(document.getElementById('planName').value != ""){

        const data = new FormData();
        const table = document.querySelector("#table_filter_training_complemet");
        data.append("searchDataFilterPlanTraining", document.getElementById('planName').value);
        var http = new XMLHttpRequest();
        http.open('POST', '../business/trainingPlanActionWS.php', true);
        http.send(data);

        http.onreadystatechange = function () {
            if (http.readyState === 4) {
                var info = JSON.parse(http.responseText);
                dataPlan = info[0].allPlanFilter;
                table.innerHTML = '';
                dataPlan.forEach(element => {
    
                    table.innerHTML += 
                    `<tr>
                        <td>${element.nametrainingplan}</td>
                        <td><img src="../resources/trainingPlansQr/${element.qrcodetrainingplan}.png?nocache=<?php echo time(); ?>" height="100"></td>
                        <td><button onclick="addFavoritePlanTraining('${element.idtrainingplan}', ${iduser})" id="btn-add-favorite" class="btn btn-primary">Agregar</button></td>
                    </tr>`
                });
            }
        };

    }else{
        swal("¡Llene el campo de nombre de plan!","","warning",{button: "ok"});
    }
}

function initializerEventListener(flagPlan, iduser){

    if(flagPlan){

        document.getElementById("btn-search-plan-training").addEventListener("click", function(){
            var formSearchPlan = document.getElementById('formSearchPlanTraining');
            var arrayFormGroups = formSearchPlan.querySelectorAll('input');
            for (var i = 0; i < arrayFormGroups.length; i++){
                arrayFormGroups[i].classList.remove('is-invalid');
            }
            formSearchPlan.reset();
    
            const table = document.querySelector("#table_filter_training_complemet");
            table.innerHTML = '';
            $("#modalFormSearchPlanTraining").modal("show");
        });
        document.getElementById("btn-cancel").addEventListener("click", function(){
            $("#modalFormSearchPlanTraining").modal("hide");
        });
    
        getFavoritePlanTraining(iduser);

    }else{

        document.getElementById("btn-search-plan-nutrition").addEventListener("click", function(){
            var formSearchPlan = document.getElementById('formSearchPlanNutrition');
            var arrayFormGroups = formSearchPlan.querySelectorAll('input');
            for (var i = 0; i < arrayFormGroups.length; i++){
                arrayFormGroups[i].classList.remove('is-invalid');
            }
            formSearchPlan.reset();
    
            const table = document.querySelector("#table_filter_complemet");
            table.innerHTML = '';
            $("#modalFormSearchPlanNutrition").modal("show");
        });
        document.getElementById("btn-cancel").addEventListener("click", function(){
            $("#modalFormSearchPlanNutrition").modal("hide");
        });
    
        getFavoritePlanNutrition(iduser);
    }
}

// Coloca el dia de la semana por medio del id de dia
function getNameDayById(idday){
    if(idday==1){ return 'LUNES'; }else if(idday==2){ return 'MARTES'}else if(idday==3){ return 'MIÉRCOLES'}
    else if(idday==4){ return 'JUEVES'}else if(idday==5){ return 'VIERNES'}else if(idday==6){ return 'SÁBADO'}
}

function initializerShowDataTraining(idTrainingPlan){

    const table = document.querySelector("#table_show_training");
    const data = new FormData();
    data.append("getAllDataTraining", idTrainingPlan);
    var http = new XMLHttpRequest();
    http.open('POST', '../business/trainingPlanActionWS.php', true);
    http.send(data);

    http.onreadystatechange = function () {
        if (http.readyState === 4) {
            var info = JSON.parse(http.responseText);
            dataTraining = info[0].allDataTraining;
            table.innerHTML = '';
            dataTraining.forEach(element => {

                table.innerHTML += 
                `<tr>
                    <td>${getNameDayById(element.idday)}</td>
                    <td>${element.nameactivity}</td>
                    <td>${element.repetitionsactivity}</td>
                    <td>${element.breaksactivity}</td>
                    <td>${element.seriesactivity}</td>
                    <td>${element.cadenceactivity}</td>
                    <td>${element.weightactivity}</td>
                </tr>`
            });
        }
    };
}