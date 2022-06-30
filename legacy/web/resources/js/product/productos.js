
function initializerEventListener() {
    document.getElementById("btn-cancel-product").addEventListener("click", function () {
        $("#modalNewProduct").modal("hide");
        document.getElementById("formNewProducto").reset();
    });
    document.getElementById("btn-new-product").addEventListener("click", function () {
        if (document.getElementById("idSubCategorySelected").value == "") {
            swal("¡No has seleccionado una sub categoría!", "", "error", { button: "ok" });
        } else {
            document.getElementById("btn-save-changes-product").classList.add("d-none");
            document.getElementById("btn-new-product").classList.remove("d-none");
            $("#modalNewProduct").modal("show");
        }
    });
    $('#modalNewProduct').modal({ backdrop: 'static', keyboard: false });
    var inputSearchSubCategory = document.getElementById("subCategoryFilter");
    inputSearchSubCategory.addEventListener('keyup', searchSubCategory);
    inputSearchSubCategory.addEventListener('search', function (event) {
        $("#show-list-categories").html('');
    });
    document.addEventListener('click', function (event) {
        var insideClick = document.getElementById("show-list-categories").contains(event.target);
        if (!insideClick) {
            $("#show-list-categories").html('');
        }
    });
}

function validateSubmit(isUpdate) {
    var name = document.getElementById("productName").value;
    var description = document.getElementById("descriptionProduct").value;
    var price = document.getElementById("priceProduct").value;
    var stock = document.getElementById("stockProduct").value;
    if (
        name == ""
        || description == ""
        || price == ""
        || stock == ""
    ) {
        swal("¡Por favor complete el nombre del producto", "", "error", { button: "ok" });
    } else {
        submitData(isUpdate)
    }
}

function deleteProduct(id) {
    swal("¿Seguro deseas eliminar?", "", "warning", { buttons: ["No", "Sí"] }).then((answ) => {
        if (answ) {
            const data = new FormData();
            data.append("delete", "delete");
            data.append("idProduct", id);
            data.append("idSubCategory", document.getElementById("idSubCategorySelected").value);
            var http = new XMLHttpRequest();
            http.open('POST', '/business/product/productAction.php', true);
            http.send(data);
            http.onreadystatechange = function () {
                if (http.readyState === 4) {
                    //console.log(http.responseText);
                    var info = JSON.parse(http.responseText);
                    if (info[0].success == 1) {
                        swal("¡" + info[0].message + "!", "", "success", { button: "ok" }).then(() => {
                            loadProducts();
                        });
                    } else {
                        swal("¡" + info[0].message + "!", "", "error", { button: "ok" });
                    }
                }
            };
        }
    });
}

function submitData(isUpdate) {
    const data = new FormData();
    if (isUpdate) {
        data.append("update", "update");
        data.append("idProduct", document.getElementById("idProduct").value);
    } else {
        data.append("create", "create");
    }
    data.append("idSubCategory", document.getElementById("idSubCategorySelected").value);
    data.append("name", document.getElementById("productName").value);
    data.append("description", document.getElementById("descriptionProduct").value);
    data.append("price", document.getElementById("priceProduct").value);
    data.append("stock", document.getElementById("stockProduct").value);
    data.append("image", document.getElementById("imageProduct").files[0]);
    var http = new XMLHttpRequest();
    http.open('POST', '/business/product/productAction.php', true);
    http.send(data);
    http.onreadystatechange = function () {
        if (http.readyState === 4) {
            //console.log(http.responseText);
            var info = JSON.parse(http.responseText);
            if (info[0].success == 1) {
                swal("¡" + info[0].message + "!", "", "success", { button: "ok" }).then(() => {
                    $("#modalNewProduct").modal("hide");
                    document.getElementById("formNewProducto").reset();
                    loadProducts();
                });
            } else {
                swal("¡" + info[0].message + "!", "", "error", { button: "ok" });
            }
        }
    };
}

function updateProduct(id, name, description, price, stock) {
    document.getElementById("idProduct").value = id;
    document.getElementById("productName").value = name;
    document.getElementById("descriptionProduct").value = description;
    document.getElementById("priceProduct").value = price;
    document.getElementById("stockProduct").value = stock;
    document.getElementById("btn-save-changes-product").classList.remove("d-none");
    document.getElementById("btn-new-product").classList.add("d-none");
    $("#modalNewProduct").modal("show");
}

function loadProducts() {
    const data = new FormData();
    data.append("getProductsBySubcategory", "getProductsBySubcategory");
    data.append("idSubCategoryProduct", document.getElementById("idSubCategorySelected").value);
    fetch('/business/product/productAction.php', {
        method: 'POST',
        body: data
    }).then(response => response.json())
        .then(info => {
            //console.log(info);
            var categorySelected = document.getElementById("subCategorySelected").value;
            var tbodySubcategories = document.getElementById("tbody-products");
            var stringTableBody = '';
            if (info.length > 0) {
                for (var i = 0; i < info.length; i++) {
                    stringTableBody += '<tr>';
                    stringTableBody += '<td>' + info[i].idProduct + '</td>';
                    stringTableBody += '<td>' + info[i].name + '</td>';
                    stringTableBody += '<td>' + categorySelected + '</td>';
                    stringTableBody += '<td>' + info[i].description + '</td>';
                    stringTableBody += '<td>' + info[i].price + '</td>';
                    stringTableBody += '<td>' + info[i].stock + '</td>';
                    // the image is rendered in the table
                    stringTableBody += '<td><img src="' + "/" + info[i].image + '" class="img-fluid" style="width: 100px;"></td>';
                    stringTableBody += "<td><button class=\"btn btn-primary\" type=\"button\" onclick='return updateProduct(\"" +
                        info[i].idProduct + "\",\"" +
                        info[i].name + "\",\"" +
                        info[i].description + "\",\"" +
                        info[i].price + "\",\"" +
                        info[i].stock +
                        "\");'>Modificar</button></td>";
                    stringTableBody += "<td><button class=\"btn btn-danger\" type=\"button\" onclick='return deleteProduct(\"" + info[i].idProduct + "\");'>Eliminar</button></td>";
                    stringTableBody += '</tr>';
                }
            } else {
                stringTableBody = "<tr>No hay productos relacionados a esta sub-categoría</tr>"
            }
            tbodySubcategories.innerHTML = stringTableBody;
        });

}

function searchSubCategory() {
    let searchText = document.getElementById("subCategoryFilter").value;
    searchText = searchText.trim().toLowerCase();
    if (searchText != '') {
        // TODO: hay que usar un localstorage para determinar el gymnasio, por el momento
        // se usa el id del gimnasio 1
        $.ajax({
            url: "/business/subCategoryProductAction.php",//se puede cambiar, solo para probar
            method: "post",
            data: "getAllSubCategories",
            success: function (response) {
                if (response.success) {
                    //console.log(response);
                    var categories = response.data;
                    //console.log(categories);
                    var html = '';
                    var name = "", description = "", id = "";
                    for (let category of categories) {
                        name = category.name.trim().toLowerCase();
                        description = category.description.trim().toLowerCase();
                        id = category.id.trim();
                        if (name.indexOf(searchText) != -1 || description.indexOf(searchText) != -1) {

                            name = name.replace(new RegExp(`(${searchText})`, "i"), "<strong>$1</strong>");
                            description = description.replace(new RegExp(`(${searchText})`, "i"), "<strong>$1</strong>");

                            html += '<li id="' + category.name + '" value="' + id + '" class="list-group-item list-group-item-action border-1"><h6>'
                                + name + '</h6><p class="mb-1"><b>descripción:</b>' + description + '</p></li>';
                        }
                    }
                    if (html == '') {
                        html = '<li id="-1" class="list-group-item list-group-item-action border-1"><h6><strong>No se encontraron coincidencias...</strong></h6>';
                    }
                    $("#show-list-categories").html(html);
                    var items = document.querySelectorAll("#show-list-categories li");
                    for (itemList of items) {
                        if (itemList.id != -1) {
                            itemList.onclick = function () {
                                //se cargan los datos
                                $("#idSubCategorySelected").val(this.value);
                                $("#show-list-categories").html('');
                                $("#subCategoryFilter").val(this.id);
                                $("#subCategorySelected").val(this.id);
                                loadProducts();
                            };
                        }
                    }
                } else {
                    swal("¡" + response[0].message + "!", "", "error", { button: "ok" });
                }
            }
        });
    } else {
        $("#show-list-categories").html('');
        //$("#codeDoctor").val('');
        //updateCalendarAppointments();
    }
}