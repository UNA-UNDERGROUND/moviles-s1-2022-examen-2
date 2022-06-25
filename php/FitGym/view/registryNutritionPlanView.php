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

        <title>Registro plan de nuctrici&oacute;n</title>
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
                    Registro plan de nutrici&oacute;n
                </div>
                <div class="card-body">
                    <form id="nutritionPlan" class="needs-validation" novalidate method="POST" enctype="multipart/form-data" onsubmit="return validateSubmit();" action="../business/nutritionPlanAction.php">
                    
                        <div class="row">
                            <div class="col-md-2 position-relative">
                                <!-- Id de plan de nuctricion -->
                                <div class="form-group" id="div-idNutrition">
                                    <label><h6>Ingrese ID de nutrici&oacute;n:</h6></label><br/>
                                    <input type="number" name="idNutrition" id="idNutrition" class="form-control" value="" required="" min="0"/>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-4">
                                <!-- Dia de nutricion -->
                                <div class="form-group" id="div-selectDay">
                                    <label><h6>Seleccione un d&iacute;a:</h6></label><br/>
                                    <select name="selectDay" id="selectDay" class="form-control"><br>
                                        <option value="Ninguno">Ninguno</option>
                                        <option value="Lunes">Lunes</option>
                                        <option value="Martes">Martes</option>
                                        <option value="Miercoles">Mi&eacute;rcoles</option>
                                        <option value="Jueves">Jueves</option>
                                        <option value="Viernes">Viernes</option>
                                        <option value="Sabado">S&aacute;bado</option>
                                        <option value="Domingo">Domingo</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <!-- Tiempo de comida -->
                                <div class="form-group" id="div-foodTime">
                                    <label><h6>Seleccione un tiempo de comida:</h6></label><br/>
                                    <select name="foodTime" id="foodTime" class="form-control"><br>
                                        <option value="Ninguno">Ninguno</option>
                                        <option value="Desayuno">Desayuno</option>
                                        <option value="Merienda">Merienda</option>
                                        <option value="Almuerzo">Almuerzo</option>
                                        <option value="Cena">Cena</option>
                                    </select>
                                </div>
                            </div>                    
                        </div>
                        <br>
                        <div class="col-md-8">
                            <!-- Descripcion de nutricion -->
                            <label><h5>Descripci&oacute;n:</h5></label><br/>
                            <div class="form-group" id="div-nutritionDescription">
                                <textarea rows="7" cols="70" name="nutritionDescription" id="nutritionDescription" class="form-control" required=""></textarea><br><br>
                            </div>
                        </div>
                        <br/>
                        <div class="btn-group" role="group" aria-label="">
                            <button type="submit" name="create" value="Crear" id="create" class="btn btn-primary">Guardar</button>
                            <a href="./principalNutritionView.php" class="btn btn-danger">Cancelar</a>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-muted">
                </div>
            </div>
        </div>
    </body>
</html>