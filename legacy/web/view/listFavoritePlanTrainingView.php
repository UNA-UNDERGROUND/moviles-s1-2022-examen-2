<?php
    $iduser = 1; if(isset($_GET['iduser'])){ $iduser = $_GET['iduser']; } // Id de usuario
?> 

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="../resources/js/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

        <script type="text/javascript" src="../resources/js/favoritePlanFunctions.js"></script>

        <title>Listado planes compartidos</title>
    </head>
    <body onload="initializerEventListener(true, '<?php echo $iduser ?>')">
        <header>
            <?php
                include '../view/listFavoritePlanView.php';
            ?>
        </header>
        <br>
        <div class="container py-5 h-100">
            <div class="card">
                <div class="card-header">
                    <h5>Secci&oacute;n de planes entrenamiento favoritos</h5>
                </div>
                <div class="card-body">

                    <div class="row justify-content-end">
                        <div class="col-3">
                            <button type="button" id="btn-search-plan-training" name="btn-search-plan-training" class="btn btn-success">Buscar planes</button>
                        </div>
                        <br></br>
                    </div>
                    <hr class="my-4">

                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                <th>Nombre</th>
                                <th>C&oacute;digo QR</th>
                                <th>Acci&oacute;n</th>
                                <th>Acci&oacute;n</th>
                                </tr>
                            </thead>
                            <tbody id="table_list_training_complemet"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal de buscar planes-->
        <div class="modal fade" id="modalFormSearchPlanTraining" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="">B&uacute;squeda de planes entrenamiento</h5>
                    </div>
                    <div class="modal-body">
                        <form id="formSearchPlanTraining" action="">
                            <div class="row">
                                <!-- Nombre de plan -->
                                <div class="col-md-4">
                                    <div class="form-group" id="div-planName">
                                        <label>Nombre de plan:</label>
                                        <input type="text" name="planName" id="planName" class="form-control" value="" required=""/>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <br>
                                    <button type="button" id="btn-filter-plan" name="btn-filter-plan" onclick="return extractDataTraining('<?php echo $iduser ?>');" class="btn btn-warning">Filtrar</button>
                                </div>
                            </div>
                        </form>
                        <br>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                    <th>Nombre</th>
                                    <th>C&oacute;digo QR</th>
                                    <th>Acci&oacute;n</th>
                                    </tr>
                                </thead>
                                <tbody id="table_filter_training_complemet"></tbody>
                            </table>
                        </div>
                        <br/>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="btn-cancel">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>