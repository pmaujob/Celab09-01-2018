<?php
@session_start();

$pRootC = $_SESSION['pRootC'];
$pRootHtmlC = $_SESSION['pRootHtmlC'];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Registrar Contrato</title>
        <?php include_once $pRootC . '/Admin/Views/header.php'; ?>
        <script type="text/javascript" src="js/forms/frmRegistContract.js"></script>      

    </head>

    <body onload="onLoadRegistContract();">
        <?php include $pRootC . '/Admin/Views/menu.php'; ?>
        <div id="infoModal" class="modal modal-fixed-footer dlgModal">
            <div class="modal-content">                
                <h1 class="titles">Información</h1>                        
                <p>¿Está seguro que desea buscar otro contratista? Perderá todos los cambios.</p>
            </div>                    
            <div class="modal-footer">                                                      
                <a id="infoModalAgree" href="#!" class="modal-action waves-effect waves-green btn-flat " onclick="acceptNewContractor();">Aceptar</a>
                <a id="infoModalCancel" href="#!" class="modal-action waves-effect waves-green btn-flat " onclick="">Cancelar</a>
            </div>
        </div>

        <section>
            <div class="row">                    
                <div class="col s12 m12 l12 center-align">
                    <h1 class="titles">Registrar Contrato</h1>
                </div>                    
            </div> 
            <div class="row">
                <div class="col s1 m2 l2">
                </div>

                <div class="input-field col s10 m8 l8">
                    <div class="opcionesbtn">
                        <div class="file-field input-field">
                            <div class="btn right waves-effect waves-light light-blue blueb" onclick="searchContractor();">
                                <span>Buscar Contratista</span>
                            </div>
                            <div class="file-path-wrapper">
                                <input id="inputContractor" class="file-path validate" type="text" placeholder="Realice la búsqueda por nombre o número de cédula..." onkeyup="searchContractor(event);">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col s1 m2 l2">
                </div>                    
            </div>

            <div id="divPreloader" class="row hideControl">
                <div class="col s4 m4 l4">
                </div>

                <div class="col s4 m4 l4 center-align">
                    <div class="preloader-wrapper big active">
                        <div class="spinner-layer spinner-blue-only">
                            <div class="circle-clipper left">
                                <div class="circle"></div>
                            </div><div class="gap-patch">
                                <div class="circle"></div>
                            </div><div class="circle-clipper right">
                                <div class="circle"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col s4 m4 l4">
                </div>
            </div>

            <div class="row">
                <div class="col s1 m2 l2">
                </div>
                <div id="tblContractor" class="col s10 m8 l8">

                </div>
                <div class="col s1 m2 l2">
                </div>
            </div>

            <div id="tblContractorInfo" class="row hideControl">
                <div class="col m3 l4"></div>
                <div class="frm-login col s12 m6 l4 center-align">
                    <form>
                        <div class="row">
                            <div class="color-user col s12">
                                <i class="material-icons medium">person_pin</i>
                            </div>
                            <div class="col s12">
                                <span id="tdName">Usuario</span>
                            </div>
                            <div class="col s12">
                                <span id="tdDoc">Documento</span>
                            </div>
                            <div class="col s12">
                                <span id="tdEmail">Email</span>
                            </div>
                            <div id="divEmail" class="input-field col s12">
                                <input id="emailId" type="email" class="validate">
                                <label for="emailId">Correo Electrónico</label>
                            </div>
                            <div class="col s12 center-align">
                                <a href="#!" onclick="openModal();">
                                    <img id="iconContract" src="<?php echo "../../Publics/images/ic_document.png"; ?>" class="icon-contract">
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col m3 l4"></div>
            </div>

            <div id="divContracts" class="row hideControl">
                <div class="col s1 m2 l2">
                </div>

                <div class="col s10 m8 l8">
                    <table>
                        <thead>
                            <tr>
                                <th style="width: 10%;">No.</th>
                                <th style="width: 50%;">Tipo Contrato</th>
                                <th style="width: 20%;">No. Contrato</th>
                                <th style="width: 10%;">Modificar</th>
                                <th style="width: 10%;">Eliminar</th>
                            </tr>
                        </thead>
                        <tbody id="tableContracts">
                        </tbody>
                    </table>
                </div>

                <div class="col s1 m2 l2">
                </div>
            </div>

            <div id="divButtonRegist" class="row hideControl">
                <div class="col s3 m5 l5">
                </div>

                <div class="col s6 m2 l2">
                    <button class="btn waves-effect waves-light light-blue blueb" onclick="saveContractInfo();">Registrar
                        <i class="material-icons right">send</i>
                    </button>
                </div>

                <div class="col s3 m5 l5">
                </div>
            </div>
            <div id="contractModal" class="modal modal-fixed-footer formModal">
                <div class="modal-content">
                    <h1 class="titles">Datos del Contrato</h1>                        
                    <p>Ingrese los datos del contrato.</p>

                    <div class="row">
                        <div class="col s1 m2 l2">
                        </div>

                        <div class="col s10 m8 l8">
                            <select id="listContrato">
                                <option value="0" disabled selected>Tipo de Contrato</option>
                            </select>
                        </div>

                        <div class="col s1 m2 l2">
                        </div>
                    </div>

                    <div class="row">
                        <div class="col s1 m2 l2">
                        </div>
                        <div class="input-field col s10 m8 l8">
                            <input id="contId" type="text" class="validate" autocomplete="off">
                            <label for="contId">No. de Contrato</label>
                        </div>
                        <div class="col s1 m2 l2">
                        </div>
                    </div>                    

                    <div class="row">
                        <div class="col s1 m2 l2">
                        </div>

                        <div class="col s5 m4 l4">
                            <label>Fecha de Suscripción</label>
                            <input id="idDateSus" type="text" class="datepicker">
                        </div>  

                        <div class=" col s5 m4 l4">                            
                            <label>Fecha de Terminación</label>
                            <input id="idDateFin" type="text" class="datepicker">
                        </div> 

                        <div class="col s1 m2 l2">
                        </div>
                    </div>     

                    <div class="row">
                        <div class="col s1 m2 l2">
                        </div>

                        <div class="input-field col s10 m8 l8">
                            <input id="valueId" type="text" class="onlyNumbers validate" autocomplete="off">
                            <label for="valueId">Valor</label>
                        </div>

                        <div class="col s1 m2 l2">
                        </div>
                    </div>   

                    <div class="row">
                        <div class="col s1 m2 l2">
                        </div>

                        <div class="input-field col s10 m8 l8">
                            <input id="objectId" type="text" class="validate" autocomplete="off">
                            <label for="objectId">Objeto</label>
                        </div>

                        <div class="col s1 m2 l2">
                        </div>
                    </div>

                    <h1 class="titles center-align">Adiciones</h1> 

                    <div class="row">
                        <div class="col s1 m2 l2">
                        </div>

                        <div class="col s10 m8 l8">
                            <table>
                                <thead>
                                    <tr>
                                        <th class="center-align" style="width: 10%;">
                                            No.
                                        </th>
                                        <th style="width: 25%;">
                                            Fecha de Suscripción
                                        </th>
                                        <th style="width: 25%;">
                                            Fecha de Terminación
                                        </th>
                                        <th class="center-align" style="width: 30%;">
                                            Valor
                                        </th>                                        
                                        <th class="center-align" style="width: 10%;">
                                        </th>
                                    </tr>
                                </thead>
                                <tbody id="tAddition">
                                    <tr>
                                        <td class="center-align">
                                        </td>
                                        <td>
                                            <input id="idAdDateSus" type="text" placeholder="1 Enero, 2000" class="datepicker">
                                        </td>
                                        <td>
                                            <input id="idAdDateFin" type="text" placeholder="31 Diciembre, 2000" class="datepicker">
                                        </td>
                                        <td>
                                            <input id="idAdValue" type="text" placeholder="0,00" class="onlyNumbers validate" autocomplete="off">
                                        </td>                                        
                                        <td class="center-align">
                                            <a href="#!" onclick="addAddition();">
                                                <img id="iconContract" src="<?php echo "../../Publics/images/ic_document.png"; ?>" class="icon-addition">
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col s1 m2 l2">
                        </div>
                    </div>

                </div>                    
                <div class="modal-footer">                                                      
                    <a id="modale" href="#!" class="modal-action waves-effect waves-green btn-flat " onclick="validateContractData();">Agregar Contrato</a>
                    <a id="modalg" href="#!" class="modal-action waves-effect waves-green btn-flat " onclick="closeModal();">Cerrar</a>
                </div>
            </div>

        </section>
    </article>
</body>    
</html>