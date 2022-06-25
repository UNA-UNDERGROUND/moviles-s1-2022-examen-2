// solicita al backend una accion en especifico con la lista de parametros
// error callback puede ser omitido
function solicitarAPI(accion, parametros, callback, errorCallback) {
    var myHeaders = new Headers();
    myHeaders.append("Cache-Control", "no-cache");
    myHeaders.append("Accept", "*/*");
    myHeaders.append("Accept-Encoding", "gzip, deflate");
    myHeaders.append("Connection", "keep-alive");

    var urlencoded = new URLSearchParams();
    urlencoded.append(accion, accion);
    for (const [nombre, valor] of Object.entries(parametros)) {
        urlencoded.append(nombre, valor);
    }

    var requestOptions = {
        method: 'POST',
        headers: myHeaders,
        body: urlencoded,
        redirect: 'follow'
    };

    fetch("../business/productCategoryAction.php", requestOptions)
        .then(response => response.text())
        .then(result => callback(JSON.parse(result)[0]))
        // hay que verificar si el errorCallback es omitido
        .catch(error => errorCallback(error));
}

// agrega una categoria a la tabla
function agregarCategoriaTabla(categoria) {
    var tbody = document.getElementById("tablaCategorias").getElementsByTagName("tbody")[0];
    var tr = document.createElement("tr");
    var tdId = document.createElement("td");
    var tdName = document.createElement("td");
    var tdDescription = document.createElement("td");
    var tdBtnModificar = document.createElement("td");

    tr.appendChild(tdId);
    tr.appendChild(tdName);
    tr.appendChild(tdDescription);
    tr.appendChild(tdBtnModificar);
    tdId.innerHTML = categoria.id;
    tdName.innerHTML = categoria.name;
    tdDescription.innerHTML = categoria.description;
    tdBtnModificar.innerHTML = "<button type='button' onclick='recuperarCategoriaProducto(" + categoria.id + ")'>Modificar</button>";
    // lo agrega a la tabla
    tbody.appendChild(tr);
}


// crea una nueva categoria en el backend
function crearCategoriaProducto() {
    var parametros = {
        name: document.getElementById("txtNombre").value,
        description: document.getElementById("txtDescripcion").value
    };
    solicitarAPI("create", parametros, function (resultado) {
        if (resultado.status == "ok") {
            alert("Categoria creada");
            // refrescamos la lista de categorias
            recuperarCategorias();
        } else {
            alert("Error al crear categoria");
        }
    });
}

// muestra una lista de categorias de productos en la tabla "tablaCategorias"
function mostrarCategorias(listaCategoria) {
    var tablaCategorias = document.getElementById("tablaCategorias");
    var tbody = tablaCategorias.getElementsByTagName("tbody")[0];
    tbody.innerHTML = "";
    listaCategoria.forEach(agregarCategoriaTabla);
}

// crea una nueva categoria en el backend
function crearCategoriaProducto() {
    var nombre = document.getElementById("txtNombre").value;
    var descripcion = document.getElementById("txtDescripcion").value;
    var parametros = {
        name: nombre,
        description: descripcion
    };
    solicitarAPI("create", parametros, function (result) {
        var respuesta = result;
        if (respuesta.success === true) {
            alert("Categoria creada con exito");
            recuperarCategorias();
        } else {
            alert("Error al crear la categoria: " + respuesta.message);
        }
    });
}


// recupera una categoria del backend
function recuperarCategoriaProducto(id) {
    var parametros = {
        id: id
    };
    solicitarAPI("getProductCategory", parametros, function (result) {
        var respuesta = result;
        if (respuesta.success === true) {
            document.getElementById("txtId").value = respuesta.productCategory.id;
            document.getElementById("txtNombre").value = respuesta.productCategory.name;
            document.getElementById("txtDescripcion").value = respuesta.productCategory.description;
        } else {
            alert("Error al recuperar la categoria: " + respuesta.message);
        }
    },
        function (error) {
            alert("Error al recuperar la categoria: " + error);
        }
    );
}

// recupera toda la lista de categorias de productos del backend
function recuperarCategorias() {
    solicitarAPI("getAllProductCategories", {}, function (result) {
        var respuesta = result;
        if (respuesta.success === true) {
            mostrarCategorias(respuesta.productCategories);
        } else {
            console.log(respuesta.message);
            alert("Error al recuperar las categorias: " + respuesta.message);
        }
    },
        function (error) {
            alert("Error al recuperar las categorias: " + error);
            console.log(error);
        }
    );
}

// modifica una categoria de producto en el backend
function modificarCategoriaProducto() {
    var id = document.getElementById("txtId").value;
    var nombre = document.getElementById("txtNombre").value;
    var descripcion = document.getElementById("txtDescripcion").value;
    var parametros = {
        id: id,
        name: nombre,
        description: descripcion
    };
    solicitarAPI("update", parametros, function (result) {
        var respuesta = result;
        if (respuesta.success === true) {
            alert("Categoria modificada con exito");
            recuperarCategorias();
        } else {
            alert("Error al modificar la categoria: " + respuesta.message);
        }
    });
}

// elimina una categoria de producto en el backend
function eliminarCategoriaProducto() {
    var id = document.getElementById("txtId").value;
    var parametros = {
        id: id
    };
    solicitarAPI("delete", parametros, function (result) {
        var respuesta = result;
        if (respuesta.success === true) {
            alert("Categoria eliminada con exito");
            recuperarCategorias();
        } else {
            alert("Error al eliminar la categoria: " + respuesta.message);
        }
    });
}

// actualiza una categoria de producto en el backend
function actualizarCategoriaProducto() {
    var id = document.getElementById("txtId").value;
    var nombre = document.getElementById("txtNombre").value;
    var descripcion = document.getElementById("txtDescripcion").value;
    var parametros = {
        id: id,
        name: nombre,
        description: descripcion
    };
    solicitarAPI("update", parametros, function (result) {
        var respuesta = result;
        if (respuesta.success === true) {
            alert("Categoria actualizada con exito");
            recuperarCategorias();
        } else {
            alert("Error al actualizar la categoria: " + respuesta.message);
        }
    });
}

function borrarCampos() {
    document.getElementById("txtId").value = "";
    document.getElementById("txtNombre").value = "";
    document.getElementById("txtDescripcion").value = "";
}

// cuando se carga la pagina, se recuperan las categorias de productos
window.onload = function () {
    recuperarCategorias();
};


