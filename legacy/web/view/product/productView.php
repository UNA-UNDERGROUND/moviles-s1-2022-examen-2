<!DOCTYPE html>
<html>

<head>
    <meta charset='utf-8'>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script type="text/javascript" src="/resources/js/jquery.min.js"></script>
    <link rel='stylesheet' type='text/css' media='screen' href='/resources/css/myStyles.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script type="text/javascript" src="/resources/js/product/productos.js"></script>
    <title>Mantenimiento de Productos</title>
</head>

<body onload="initializerEventListener();">
    <?php
    include("../navBarGym.php");
    ?>
    <br>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h4>Productos</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <!--Busqueda-->
                    <div class="col-md-12">
                        <input type="search" name="subCategoryFilter" id="subCategoryFilter" class="form-control" placeholder="Búsqueda SubCategorías" aria-label="Search" />
                    </div>
                </div>
                <div class="row">
                    <div class="col">
                        <div class="list-group" id="show-list-categories">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row justify-content-end">
                    <input type="hidden" id="idSubCategorySelected" name="idSubCategorySelected">
                    <div class="col-2">
                        <label for="productSelected">SubCategoria Seleccionada</label>
                        <input type="text" class="form-control" id="subCategorySelected" name="subCategorySelected" value="" disabled />
                    </div>
                    <div class="col-2">
                        <br>
                        <button type="button" id="btn-new-product" name="btn-new-product" class="btn btn-success">Nuevo producto</button>
                    </div>
                </div>
                <div class="container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nombre</th>
                                <th>SubCategoría</th>
                                <th>descripción</th>
                                <th>precio</th>
                                <th>stock</th>
                                <th>Acción</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody id="tbody-products"></tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
            </div>
        </div>
    </div>

    <!--Modal diagnostico parte de cuadritos (agregar, modificar y eliminar)-->
    <div class="modal fade" id="modalNewProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Nuevo producto</h5>
                </div>
                <div class="modal-body">
                    <form id="formNewProducto" action="">
                        <input type="hidden" id="idProduct">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <div id="div-productName" class="form-group">
                                                <label>Nombre del producto</label>
                                                <input type="text" id="productName" name="productName" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group" id="div-descriptionProduct">
                                                <label>Descripción</label>
                                                <textarea rows="8" cols="70" name="descriptionProduct" id="descriptionProduct" class="form-control"></textarea>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group" id="div-priceProduct">
                                                <label>Precio</label>
                                                <input type="number" id="priceProduct" name="priceProduct" class="form-control">
                                            </div>
                                        </div>
                                        <!-- stock -->
                                        <div class="row">
                                            <div class="form-group" id="div-stockProduct">
                                                <label>Stock</label>
                                                <input type="number" id="stockProduct" name="stockProduct" class="form-control">
                                            </div>
                                        </div>
                                        <!-- image -->
                                        <div class="row">
                                            <div class="form-group" id="div-imageProduct">
                                                <label>Imagen</label>
                                                <input type="file" id="imageProduct" name="imageProduct" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <br />
                <div class="modal-footer">
                    <button type="button" id="btn-new-product" onclick="validateSubmit(false);" class="btn btn-success">Guardar</button>
                    <button type="button" id="btn-save-changes-product" onclick="validateSubmit(true);" class="btn btn-primary d-none">Guardar Cambios</button>
                    <button type="button" id="btn-cancel-product" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>