<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>Mantenimiento de categoria de productos</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='../resources/css/main.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src='../resources/js/categoriaproductos.js'></script>
</head>

<body>
    <?php
        include ("./navBarGym.php");
    ?>
    <header>
        <div>
            <h1>Mantenimiento de categoria de productos</h1>
        </div>
    </header>
    <main>
        <div class="formulario">
            <div class="barraConsulta">
                <!--se puede llevar el registro, edicion eliminacion y consulta de categorías de productos-->
                <!--campos de texto-->
                <div class="camposConsulta">
                    <!--id-->
                    <span>
                        <label for="txtId">Id</label>
                        <input type="text" id="txtId" />
                    </span>
                    <!--nombre-->
                    <span>
                        <label for="txtNombre">Nombre</label>
                        <input type="text" id="txtNombre" />
                    </span>
                    <!--descripción-->
                    <span>
                        <label for="txtDescripcion">Descripción</label>
                        <input type="text" id="txtDescripcion" />
                    </span>
                </div>
                <!--botones-->
                <div class="botonesConsulta">
                    <button id="btnRegistrar" onclick="crearCategoriaProducto()">Crear</button>
                    <button id="btnConsultar" onclick="recuperarCategoriaProducto(txtId.value)">Consultar</button>
                    <button id="btnRefrescar" onclick="recuperarCategorias()">Refrescar</button>
                    <button id="btnActualizar" onclick="actualizarCategoriaProducto()">Actualizar</button>
                    <button id="btnEliminar" onclick="eliminarCategoriaProducto()">Eliminar</button>
                    <button id="btnLimpiar" onclick="borrarCampos()">Limpiar</button>
                </div>
            </div>
            <div class="contenido">
                <table id="tablaCategorias">
                    <thead>
                        <tr>
                            <th style="width: 10%;">Id</th>
                            <th style="width: 20%;">Nombre</th>
                            <th style="width: 30%">Descripción</th>
                            <!--alineado a la derecha-->
                            <th style="width: 10%;">Modificar</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </main>
    <footer>
        <a>UNA 2022</a>
    </footer>
</body>

</html>