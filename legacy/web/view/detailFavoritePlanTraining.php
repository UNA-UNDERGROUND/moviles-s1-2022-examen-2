<?php
    $idTrainingPlan = 0; if(isset($_GET['idTrainingPlan'])){ $idTrainingPlan = $_GET['idTrainingPlan']; }
?>

<!DOCTYPE html>
<html>
    <head>
        <script type="text/javascript" src="../resources/js/favoritePlanFunctions.js"></script>
        <title>Detalles del plan de entrenamiento</title>
    </head>
    <body onload="initializerShowDataTraining('<?php echo $idTrainingPlan ?>')">
        <header>
            <?php
                include '../view/listFavoritePlanView.php';
            ?>
        </header>
        <br>
        <div class="container h-100">
            <div class="card">
                <div class="card-header">
                    Lista de detalles del plan de entrenamiento
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                <th>D&iacute;a</th>
                                <th>Actividad</th>
                                <th>Repeticiones</th>
                                <th>Descansos</th>
                                <th>Series</th>
                                <th>Cadencia</th>
                                <th>Peso kg</th>
                                </tr>
                            </thead>
                            <tbody id="table_show_training"></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>