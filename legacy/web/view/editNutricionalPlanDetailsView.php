<?php

    require_once '../business/nutritionPlanBusiness.php';

    $idNutritionPlanDetails = ''; // Almacena el numero id del detalle del plan de nutricion
    $dataDetails = ''; // Almacena los datos de ese unico detalle seleccionado

    if(isset($_GET['idNutritionPlanDetails'])){

        $idNutritionPlanDetails = $_GET['idNutritionPlanDetails'];

        $nutritionPlanBusiness = new NutritionPlanBusiness();

        // Se busca la informacion del detalle del plan de nutricion
        $dataDetails = $nutritionPlanBusiness->getDetailNutrition($idNutritionPlanDetails);
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

        <script type="text/javascript" src="../resources/js/validationDomElements.js"></script>
        <script type="text/javascript" src="../resources/js/nutritionPlanFunctions.js"></script>

        <title>Actualizaci&oacute;n plan de nuctrici&oacute;n</title>
    </head>
    <body onload="initializerEventListener()">
        <header>
            <?php
                include '../view/principalNutritionView.php';
            ?>
        </header>
        <br>
        <div class="container h-100">
            <div class="card">
                <div class="card-header">
                    Actualizaci&oacute;n plan de nutrici&oacute;n
                </div>
                <div class="card-body">
                    <form id="nutritionPlan" class="needs-validation" novalidate method="POST" enctype="multipart/form-data" onsubmit="return validateSubmitUpdate();" action="../business/nutritionPlanAction.php">

                        <input type="text" name="idDetailNutritionPlan" value="<?php echo $dataDetails->getIdNutritionPlanDetails(); ?>" hidden="">

                        <div class="row">
                            <div class="col-md-4">
                                <!-- Dia de nutricion -->
                                <div class="form-group" id="div-selectDay">
                                    <label><h6>D&iacute;a:</h6></label><br/>
                                    <input type="text" class="form-control" readonly="" value="<?php echo $dataDetails->getFoodDay(); ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <!-- Tiempo de comida -->
                                <div class="form-group" id="div-foodTime">
                                    <label><h6>Tiempo de comida:</h6></label><br/>
                                    <input type="text" class="form-control" readonly="" value="<?php echo $dataDetails->getFoodTime(); ?>">
                                </div>
                            </div>                    
                        </div>
                        <br>
                        <div class="col-md-8">
                            <!-- Descripcion de nutricion -->
                            <label><h5>Descripci&oacute;n:</h5></label><br/>
                            <div class="form-group" id="div-nutritionDescription">
                                <textarea rows="7" cols="70" name="nutritionDescription" id="nutritionDescription" class="form-control" required=""><?php echo $dataDetails->getDescription(); ?></textarea><br><br>
                            </div>
                        </div>
                        <br/>
                        <div class="btn-group" role="group" aria-label="">
                            <button type="submit" name="update" value="Actualizar" id="update" class="btn btn-primary">Actualizar</button>
                            <a href="javascript: history.go(-1)" class="btn btn-danger">Cancelar</a>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-muted">
                </div>
            </div>
        </div>
    </body>
</html>