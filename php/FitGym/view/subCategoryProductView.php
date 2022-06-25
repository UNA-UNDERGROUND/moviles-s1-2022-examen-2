<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="../resources/js/jquery.min.js"></script>
        <link rel='stylesheet' type='text/css' media='screen' href='../resources/css/myStyles.css'>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <script type="text/javascript" src="../resources/js/subCategoryProductFunctions.js"></script>
        <title>Mantenimiento de Subcategor&iacute;as de Productos</title>
    </head>
    <body onload="initializerEventListener();">
        <?php
            include ("./navBarGym.php");
        ?>
        <br>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h4>Subcategor&iacute;as de Productos</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <!--Busqueda-->
                        <div class="col-md-12">
                            <input type="search" name="categoryFilter" id="categoryFilter" class="form-control" placeholder="B&uacute;squeda Categor&iacute;as" aria-label="Search"/>
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
                        <input type="hidden" id="idCategorySelected" name="idCategorySelected">
                        <div class="col-2">
                            <label for="categorySelected">Categor&iacute;a Seleccionada</label>
                            <input type="text" class="form-control" id="categorySelected" name="categorySelected" value="" disabled/>
                        </div>
                        <div class="col-2">
                            <br>
                            <button type="button" id="btn-new-subcategory" name="btn-new-subcategory" class="btn btn-success">Nueva Subcategor&iacute;a</button>
                        </div>
                    </div>
                    <div class="container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>C&oacute;digo</th>
                                    <th>Nombre</th>
                                    <th>Categor&iacute;a</th>
                                    <th>Acci&oacute;n</th>
                                    <th>Acci&oacute;n</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-subcategory-products"></tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
        
        <!--Modal diagnostico parte de cuadritos (agregar, modificar y eliminar)-->
        <div class="modal fade" id="modalNewSubcategoryProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Nueva Subcategor&iacute;a</h5>
                </div>
                <div class="modal-body">
                    <form id="formNewSubcategory" action="">
                        <input type="hidden" id="idSubcategory">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <div id="div-subCategoryName" class="form-group">
                                                <label>Nombre de la subcategor&iacute;a</label>
                                                <input type="text" id="subCategoryName" name="subCategoryName" class="form-control">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group" id="div-descriptionSubcategory">
                                                <label>Descripci&oacute;n</label>
                                                <textarea rows="8" cols="70" name="descriptionSubcategory" id="descriptionSubcategory" class="form-control"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <br/>
                <div class="modal-footer">
                    <button type="button" id="btn-new-subcategory-product" onclick="validateSubmit(false);" class="btn btn-success">Guardar</button>
                    <button type="button" id="btn-save-changes-subcategory-product" onclick="validateSubmit(true);" class="btn btn-primary d-none">Guardar Cambios</button>
                    <button type="button" id="btn-cancel-subcategory-product" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
                </div>
            </div>
        </div>
    </body>
</html>