<?php
@session_start();

$pRootC = $_SESSION['pRootC'];
$pRootHtmlC = $_SESSION['pRootHtmlC'];
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Registrar Contratista</title>
        <?php include_once $pRootC . '/Admin/Views/header.php'; ?>

        <script type="text/javascript" src="js/forms/frmRegistContractor.js"></script>        
    </head>

    <body onload="onLoadRegistContractor();">
        <?php include $pRootC . '/Admin/Views/menu.php'; ?>
        <article>
            <section>
                <div class="row">                    
                    <div class="col s12 m12 l12 center-align">
                        <h1 class="titles">Datos del Contratista</h1>
                    </div>                    
                </div> 
                <div class="row">
                    <div class="col s2 m4 l4">
                    </div>
                    <div class="input-field col s4 m2 l2">
                        <input id="funFirstName" type="text" class="validate">
                        <label for="funFirstName">Nombre Funcionario</label>
                    </div>
                    <div class="input-field col s4 m2 l2">
                        <input id="funLastName" type="text" class="validate">
                        <label for="funLastName">Apellido Funcionario</label>
                    </div>
                    <div class="col s2 m4 l4">
                    </div>                        
                </div>                     
                <div class="row">
                    <div class="col s1 m4 l4">
                    </div>

                    <div class="input-field col s4 m2 l2">
                        <select id="listTipo" onchange="validateDV(this);">
                            <option value="0" disabled selected>Tipo de Identificación</option>
                        </select>
                    </div>  

                    <div class="input-field col s4 m2 l2">
                        <input id="funId" type="text" class="validate">
                        <label for="funId">No. Identificación</label>
                    </div> 

                    <div id="divDv" class="input-field col s1 m2 l2" style="display: none;">
                        <input id="dv" type="text" class="validate">
                        <label for="dv">Dígito Verificación</label>
                    </div>

                    <div class="col s1 m2 l2">
                    </div>
                </div>

                <div class="row">
                    <div class="col s2 m4 l4">
                    </div>
                    <div class="input-field col s8 m4 l4">
                        <input id="emailId" type="email" class="validate">
                        <label for="emailId">Correo Electrónico</label>
                    </div>     
                    <div class="col s2 m4 l4">
                    </div>                        
                </div>

                <div class="row">
                    <div class="col s3 m5 l5">
                    </div>

                    <div class="col s6 m2 l2">
                        <button class="btn waves-effect waves-light light-blue blueb" onclick="saveInfo();">Registrar
                            <i class="material-icons right">send</i>
                        </button>
                    </div>

                    <div class="col s3 m5 l5">
                    </div>
                </div>

            </section>
        </article>
    </body>    

</html>