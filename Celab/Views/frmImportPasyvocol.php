<?php
@session_start();

$pRootC = $_SESSION['pRootC'];
$pRootHtmlC = $_SESSION['pRootHtmlC'];

require_once $pRootC . '/Config/SysConfig.php';
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Importar Pasyvocol</title>
        <?php include_once $pRootC . '/Admin/Views/header.php'; ?>
        <link rel="stylesheet" type="text/css" href="<?php echo MLIBSERVERPATH . 'Styles/MLnxStyles.css'; ?>">

        <script type="text/javascript" src="js/forms/frmImportPasyvocol.js"></script>
    </head>
    <body onload="onLoadBody();">
        <?php include $pRootC . '/Admin/Views/menu.php'; ?>     
        
        <div id="waitModal" class="modal modal-fixed-footer waitModal">
            <div class="modal-content"> 
                <div class="row center-align">
                    <p>Importando, por favor espere...</p>
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
            </div>
        </div>
        
        <article>
            <section>
                <div class="row">                    
                    <div class="col s12 m12 l12 center-align">
                        <h1 class="titles">Importador de datos - Pasyvocol</h1>
                    </div>                    
                </div>
                <div class="row">
                    <div class="col s1 m2 l2">
                    </div>

                    <div class="input-field col s10 m8 l8">
                        <div class="file-field input-field">
                            <div class="btn right light-blue">
                                <span>Archivo CSV</span>
                                <input id="fileCSV" type="file" onchange="readFile(this);">
                            </div>
                            <div class="file-path-wrapper">
                                <input class="file-path validate" type="text">
                            </div>
                        </div>
                    </div>

                    <div class="col s1 m2 l2">
                    </div>                    
                </div>

                <div class="row">

                    <div class="col s5 m5 l5">
                    </div>

                    <div class="col s2 m2 l2">
                        <button class="btn waves-effect waves-light light-blue blueb" onclick="sendData();">Importar
                            <i class="material-icons right">send</i>
                        </button>
                    </div>

                    <div class="col s5 m5 l5">
                    </div>

                </div>

            </section>
        </article>        
    </body>

</html>