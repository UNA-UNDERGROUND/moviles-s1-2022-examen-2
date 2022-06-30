<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script type="text/javascript" src="../resources/js/jquery.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
        <script type="text/javascript" src="../resources/js/trainingPlanFunctions.js"></script>
        <title>Plan de entrenamiento</title>
    </head>
    <body onload="initializerEventListener();">
        <?php
            include ("./navBarCoach.php");
        ?>
        <br>
        <div class="container">
            <div class="card">
                <div class="card-header">
                    <h4>Planes de tratamiento</h4>
                </div>
                <div class="card-body">
                    <div class="row justify-content-end">
                        <div class="col-2">
                            <button type="button" id="btn-new-trainingPlan" name="btn-new-trainingPlan" class="btn btn-success">Nuevo Plan</button>
                        </div>
                    </div>
                    <div class="container">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Nombre del Plan</th>
                                    <th>C&oacute;digo QR</th>
                                    <th>Acci&oacute;n</th>
                                    <th>Acci&oacute;n</th>
                                </tr>
                            </thead>
                            <tbody id="tbody-training-plans"></tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer">
                </div>
            </div>
        </div>
        
        <!--Modal diagnostico parte de cuadritos (agregar, modificar y eliminar)-->
        <div class="modal fade" id="modalNewTrainingPlan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="">Nuevo Plan de Entrenamiento</h5>
                </div>
                <div class="modal-body">
                    <form id="formNewTrainingPlan" action="">
                        <input type="hidden" id="idTrainingPlan">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                    <div class="row">
                                        <div class="col">
                                            <div id="div-trainingPlanName" class="form-group">
                                                <label>Nombre del plan</label>
                                                <input type="text" id="trainingPlanName" name="trainingPlanName" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <div class="form-group" id="div-day">
                                                <label>Dia</label>
                                                <select name="day" class="form-control" id="day">
                                                    <option value="none">Ninguno</option>
                                                    <option value="1">LUNES</option>
                                                    <option value="2">MARTES</option>
                                                    <option value="3">MI&Eacute;RCOLES</option>
                                                    <option value="4">JUEVES</option>
                                                    <option value="5">VIERNES</option>
                                                    <option value="6">S&Aacute;BADO</option>
                                                    <option value="7">Domingo</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <br>
                                            <button type="button" onclick="saveDay();" class="btn btn-success" id="addDay" name="addDay">Agregar</button>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <th>D&iacute;a</th>
                                                <th>Actividades</th>
                                                <th>Acci&oacute;n</th>
                                                <th>Acci&oacute;n</th>
                                            </thead>
                                            <tbody id="trainingPlanInfo">
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div id="div-form-activity" class="col d-none">
                                    <h5>Actividad</h5>
                                    <hr>
                                    <form id="formActivity" action="">
                                        <input type="hidden" id="daySelected"/>
                                        <div class="row">
                                            <div class="col">
                                                <div class="form-group" id="div-activityName">
                                                    <label>Nombre</label>
                                                    <input type="text" id="activityName" name="activityName" class="form-control" required/>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <div class="form-group" id="div-sections">
                                                    <label>Secciones</label>
                                                    <select name="sections" class="form-control" id="sections">
                                                        <option value="none" selected="selected">Ninguno</option>
                                                        <option value="1">Repeticiones</option>
                                                        <option value="2">Descansos</option>
                                                        <option value="3">Series</option>
                                                        <option value="4">Cadencia</option>
                                                        <option value="5">Peso</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <br>
                                                <button type="button" onclick="addSection();" class="btn btn-success" id="btn-add-activity-section" name="btn-add-activity-section">Agregar Secci&oacute;n</button>
                                            </div>
                                        </div>
                                        <hr>
                                        <div id="sectionsActivity" class="row"></div>
                                        <hr>
                                        <div class="row">
                                            <button type="button" id="btn-add-activity" name="btn-add-activity" onclick="saveActivity();" class="btn btn-success">Guardar Actividad</button>
                                            <button type="button" id="btn-update-activity" name="btn-update-activity" onclick="saveChangesActivity();" class="btn btn-primary d-none">Guardar Cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <br/>
                <div class="modal-footer">
                    <button type="button" id="btn-new-training-plan" onclick="submitData(true);" class="btn btn-success">Guardar</button>
                    <button type="button" id="btn-save-changes-training-plan" onclick="submitData(false);" class="btn btn-primary d-none">Guardar Cambios</button>
                    <button type="button" id="btn-cancel-training-plan" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
                </div>
            </div>
        </div>
    </body>
</html>