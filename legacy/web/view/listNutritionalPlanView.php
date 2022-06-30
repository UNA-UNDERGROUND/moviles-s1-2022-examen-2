<?php
require_once '../business/nutritionPlanBusiness.php';
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <title>Listado plan de nutrici&oacute;n</title>
</head>

<body>
    <header>
        <?php
        include '../view/principalNutritionView.php';
        ?>
    </header>
    <br>
    <div id="principalContainer" class="container"></div>

    <div class="container h-100">
        <div class="card">
            <div class="card-header">
                Lista de planes de nutrici&oacute;n
            </div>
            <div class="card-body">
                <?php

                $nutritionPlanBusiness = new NutritionPlanBusiness();

                // Se buscan los planes de nutricion agregados
                $listNutritionPlan = $nutritionPlanBusiness->getNutritionPlans();

                echo '<form method="post" enctype="multipart/form-data" action="../business/nadie.php">';

                // Campos visibles

                echo '<table class="table">';

                echo '<thead>';
                echo '<tr>';
                echo '<th>Código plan nutricional</th>';
                echo '<th>Nombre</th>';
                echo '<th>Código QR</th>';
                echo '<th>Acci&oacute;n</th>';
                echo '<th>Acci&oacute;n</th>';
                echo '</tr>';
                echo '</thead>';

                echo '<tbody>';

                foreach ($listNutritionPlan as $current) {

                    echo '<tr>';
                    echo '<td>' . $current->getIdNutritionPlan() . '</td>';
                    echo '<td>' . $current->getName() . '</td>';
                    echo '<td><img src=' . $current->getImagecodeqr() . ' height="100"></td>';
                    echo '<td>';
                    echo '<div class="btn-group" role="group" aria-label="">';
                    echo '<a href="./listNutritionPlanDetailsView.php?idNutritionPlan=' . $current->getIdNutritionPlan() . '" type="submit"  class="btn btn-primary">Ver más</a>';
                    echo '</div>';
                    echo '</td>';
                    echo '<td>';
                    echo '<div class="btn-group" role="group" aria-label="">';
                    echo '<button type="submit" onclick="return eliminar(' . $current->getIdNutritionPlan() . ');" class="btn btn-danger">Eliminar</button>';
                    echo '</div>';
                    echo '</td>';
                    echo '</tr>';
                }
                echo '</tbody>';
                echo '</table>';
                echo '</form>';
                ?>
            </div>
        </div>
    </div>
</body>

</html>

<script>
    function eliminar(idDelete) {
        swal("¿Seguro que quieres eliminar todo el plan nutricional?", "Borrará además los días junto a los tiempos de comida", "warning", {
            buttons: ["No", "Sí"]
        }).then((answer) => {

            if (answer) {
                // do a get request to delete the plan
                var url = "../business/nutritionPlanAction.php?idNutritionPlan=" + idDelete + "&deleteFullNutrition=Eliminar";
                fetch(url)
                    .then(function(response) {
                        return response.json();
                    })
                    .then(function(data) {
                        if (data.success) {
                            swal("Eliminado", "El plan nutricional ha sido eliminado", "success");
                            location.reload();
                        } else {
                            swal("Error", "No se ha podido eliminar el plan nutricional", "error");
                        }
                    });
            }
        });
        return false;
    }
</script>