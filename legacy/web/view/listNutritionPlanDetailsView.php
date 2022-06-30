<?php

    require_once '../business/nutritionPlanBusiness.php';

    $idNutritionPlan = ''; // Almacena el numero id del plan de nutricion
    $dataNutritionPlanDetails = ''; // Almacena todos los detalles de ese unico plan

    if(isset($_GET['idNutritionPlan'])){

        $idNutritionPlan = $_GET['idNutritionPlan'];

        $nutritionPlanBusiness = new NutritionPlanBusiness();

        // Se busca la informacion de los detalles del plan de nutricion
        $dataNutritionPlanDetails = $nutritionPlanBusiness->getAllDetailsNutritionPlan($idNutritionPlan);


    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <title>Detalles del plan de nutrici&oacute;n</title>
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
                    Lista de detalles del plan de nutrici&oacute;n
                </div>
                <div class="card-body">
                    <?php

                        echo '<form method="post" enctype="multipart/form-data" action="../business/#">';

                            // Campos visibles
                        
                            echo '<table class="table">';

                                echo '<thead>';
                                    echo '<tr>';
                                        echo '<th>Día</th>';
                                        echo '<th>Tiempo de comida</th>';
                                        echo '<th>Descripción</th>';
                                        echo '<th>Acci&oacute;n</th>';
                                        echo '<th>Acci&oacute;n</th>';
                                    echo '</tr>';
                                echo '</thead>';

                                echo '<tbody>';

                                    foreach ($dataNutritionPlanDetails as $current){

                                        echo '<tr>';
                                            echo '<td>'.$current->getFoodDay().'</td>';
                                            echo '<td>'.$current->getFoodTime().'</td>';
                                            echo '<td>'.$current->getDescription().'</td>';
                                            echo '<td>';
                                                echo '<div class="btn-group" role="group" aria-label="">';
                                                    echo '<a href="./editNutricionalPlanDetailsView.php?idNutritionPlanDetails='.$current->getIdNutritionPlanDetails().'" type="submit"  class="btn btn-primary">Editar</a>';
                                                echo '</div>';
                                            echo '</td>';
                                            echo '<td>';
                                                echo '<div class="btn-group" role="group" aria-label="">';
                                                    echo '<button type="submit" onclick="return eliminar('.$current->getIdNutritionPlanDetails().');" class="btn btn-danger">Eliminar</button>';
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
    function eliminar(idDelete){
        swal("¿Seguro que quieres eliminar el registro?","","warning",{buttons: ["No","Sí"]}).then((answer)=>{
            
            if (answer){
                swal("Eliminado correctamente","","success",{button:"ok"}).then(()=>{
                    
                   window.location.href="../business/nutritionPlanAction.php?idDetailNutritionPlan="+idDelete+"&delete=Eliminar";
                });
            }
        });
        return false;
    }
</script>