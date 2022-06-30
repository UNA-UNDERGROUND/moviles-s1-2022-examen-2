
function initializerEventListener(){
    document.getElementById("btn-cancel-subcategory-product").addEventListener("click", function(){
        $("#modalNewSubcategoryProduct").modal("hide");
        document.getElementById("formNewSubcategory").reset();
    });
    document.getElementById("btn-new-subcategory").addEventListener("click", function(){
        if (document.getElementById("idCategorySelected").value == ""){
            swal("¡No has seleccionado una categoría!","","error",{button: "ok"});
        }else{
            document.getElementById("btn-save-changes-subcategory-product").classList.add("d-none");
            document.getElementById("btn-new-subcategory-product").classList.remove("d-none");
            $("#modalNewSubcategoryProduct").modal("show");
        }
    });
    $('#modalNewSubcategoryProduct').modal({backdrop: 'static', keyboard: false});
    var inputSearchCategory = document.getElementById("categoryFilter");
    inputSearchCategory.addEventListener('keyup', searchCategory);
    inputSearchCategory.addEventListener('search', function(event){
        $("#show-list-categories").html('');
    });
    document.addEventListener('click', function(event){
        var insideClick = document.getElementById("show-list-categories").contains(event.target);
        if (!insideClick){
            $("#show-list-categories").html('');
        }
    });
}

function validateSubmit(isUpdate){
    var name = document.getElementById("subCategoryName").value;
    if (name == "" ){
        swal("¡Por favor complete el nombre de la subcategoría!","","error",{button: "ok"});
    }else{
        submitData(isUpdate)
    }
}

function deleteSubcategoryProduct(id){
    swal("¿Seguro deseas eliminar?","","warning",{buttons: ["No", "Sí"]}).then((answ)=>{
        if (answ){
            const data = new FormData();
            data.append("delete", "delete");
            data.append("idSubcategoryProduct", id);
            data.append("idCategory", document.getElementById("idCategorySelected").value);
            var http = new XMLHttpRequest();
            http.open('POST', '../business/subcategoryProductAction.php', true);
            http.send(data);
            http.onreadystatechange = function () {
                if (http.readyState === 4) {
                    console.log(http.responseText);
                    var info = JSON.parse(http.responseText);
                    if (info[0].success == 1){
                        swal("¡" + info[0].message + "!","","success",{button: "ok"}).then(()=>{
                            loadSubcategories();
                        });
                    }else{
                        swal("¡" + info[0].message + "!","","error",{button: "ok"});
                    }
                }
            };
        }
    });
}

function submitData(isUpdate){
    const data = new FormData();
    if (isUpdate){
        data.append("update", "update");
        data.append("idSubcategoryProduct", document.getElementById("idSubcategory").value);
    }else{
        data.append("create", "create");
    }
    data.append("idCategory", document.getElementById("idCategorySelected").value);
    data.append("name", document.getElementById("subCategoryName").value);
    data.append("description", document.getElementById("descriptionSubcategory").value);
    var http = new XMLHttpRequest();
    http.open('POST', '../business/subcategoryProductAction.php', true);
    http.send(data);
    http.onreadystatechange = function () {
        if (http.readyState === 4) {
            console.log(http.responseText);
            var info = JSON.parse(http.responseText);
            if (info[0].success == 1){
                swal("¡" + info[0].message + "!","","success",{button: "ok"}).then(()=>{
                    $("#modalNewSubcategoryProduct").modal("hide");
                    document.getElementById("formNewSubcategory").reset();
                    loadSubcategories();
                });
            }else{
                swal("¡" + info[0].message + "!","","error",{button: "ok"});
            }
        }
    };
}

function updateSubcategoryProduct(id, name, description){
    document.getElementById("idSubcategory").value = id;
    document.getElementById("subCategoryName").value = name;
    document.getElementById("descriptionSubcategory").value = description;
    document.getElementById("btn-save-changes-subcategory-product").classList.remove("d-none");
    document.getElementById("btn-new-subcategory-product").classList.add("d-none");
    $("#modalNewSubcategoryProduct").modal("show");
}

function loadSubcategories(){
    const data = new FormData();
    data.append("getSubcategories", "getSubcategories");
    data.append("idCategory", document.getElementById("idCategorySelected").value);
    var http = new XMLHttpRequest();
    http.open('POST', '../business/subcategoryProductAction.php', true);
    http.send(data);
    http.onreadystatechange = function () {
        if (http.readyState === 4) {
            console.log(http.responseText);
            var info = JSON.parse(http.responseText);
            console.log(info);
            var categorySelected = document.getElementById("categorySelected").value;
            var tbodySubcategories = document.getElementById("tbody-subcategory-products");
            var stringTableBody = '';
            if (info.length > 0){
                for (var i = 0; i < info.length; i++){
                    stringTableBody += '<tr>';
                    stringTableBody += '<td>' + info[i].id + '</td>';
                    stringTableBody += '<td>' + info[i].name + '</td>';
                    stringTableBody += '<td>' + categorySelected + '</td>';
                    stringTableBody += "<td><button class=\"btn btn-primary\" type=\"button\" onclick='return updateSubcategoryProduct(\"" + info[i].id + "\",\"" + info[i].name + "\",\"" + info[i].description + "\");'>Modificar</button></td>";
                    stringTableBody += "<td><button class=\"btn btn-danger\" type=\"button\" onclick='return deleteSubcategoryProduct(\"" + info[i].id + "\");'>Eliminar</button></td>";
                    stringTableBody += '</tr>';
                }
            }else{
                stringTableBody = "<tr>No hay subcategor&iacute;as relacionadas a esta categor&iacute;a</tr>"
            }
            tbodySubcategories.innerHTML = stringTableBody;
        }
    };
}

function searchCategory(){
    let searchText = document.getElementById("categoryFilter").value;
    searchText = searchText.trim().toLowerCase();
    if (searchText != ''){
        $.ajax({
            url: "../business/productCategoryAction.php",//se puede cambiar, solo para probar
            method: "post",
            data: "getAllProductCategories",
            success:function(response){
                if (response[0].success){
                    console.log(response);
                    var categories = response[0].productCategories;
                    console.log(categories);
                    var html = '';
                    var name = "", description = "", id = "";
                    for (let category of categories){
                        name = category.name.trim().toLowerCase();
                        description = category.description.trim().toLowerCase();
                        id = category.id.trim();
                        if (name.indexOf(searchText) != -1 || description.indexOf(searchText) != -1){
                            
                            name = name.replace(new RegExp(`(${searchText})`,"i"), "<strong>$1</strong>");
                            description = description.replace(new RegExp(`(${searchText})`,"i"), "<strong>$1</strong>");
    
                            html += '<li id="' + category.name + '" value="' + id + '" class="list-group-item list-group-item-action border-1"><h6>'
                            + name + '</h6><p class="mb-1"><b>descripción:</b>'+ description + '</p></li>';
                        }
                    }
                    if (html == ''){
                        html = '<li id="-1" class="list-group-item list-group-item-action border-1"><h6><strong>No se encontraron coincidencias...</strong></h6>';
                    }
                    $("#show-list-categories").html(html);
                    var items = document.querySelectorAll("#show-list-categories li");
                    for (itemList of items){
                        if (itemList.id != -1){
                            itemList.onclick = function (){
                                //se cargan los datos
                                $("#idCategorySelected").val(this.value);
                                $("#show-list-categories").html('');
                                $("#categoryFilter").val(this.id);
                                $("#categorySelected").val(this.id);
                                loadSubcategories();
                            };
                        }
                    }
                }else{
                    swal("¡" + response[0].message + "!","","error",{button: "ok"});
                }
            }
        });
    }else{
        $("#show-list-categories").html('');
        //$("#codeDoctor").val('');
        //updateCalendarAppointments();
    }
}