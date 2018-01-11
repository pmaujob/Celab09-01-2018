<?php
@session_start();

$_SESSION['pRootC'] = dirname(__FILE__);
$_SESSION['pRootHtmlC'] = 'http://' . $_SERVER['SERVER_NAME'] . '/Celab';
$pRootC = $_SESSION['pRootC'];
$pRootHtmlC = $_SESSION['pRootHtmlC'];

require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'SessionVars.php';

$sess = new SessionVars();

if (!$sess->varExist('user')) {
    ?>

    <!DOCTYPE html>
    <html>
        <head>
            <meta charset="UTF-8">
            <title>Celab</title>
            <?php include_once $pRootC . '/Admin/Views/header.php'; ?>
            <script type="text/javascript" src="Admin/Views/js/login.js"></script>
            <link rel="stylesheet" type="text/css" href="Publics/css/stylesLogin.css">
        </head>
        <body onload="onLoad();" onkeyup = "if (event.keyCode == 13)
                        login();">
            <div id="loading" class="loading">
                <div class="logo-load">
                    <div class="preloader-wrapper big active valign-wrapper">
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
            <div class="row">
                <div class="col m3 l4"></div>
                <div class="frm-login col s12 m6 l4 center-align">
                    <div class="row">
                        <form>
                            <div class="row">
                                <div class="col s12">
                                    <div class="img">
                                        <img src="Publics/images/logoUser.png">
                                    </div>
                                    <h3 class="name-aplication">Celab</h3>
                                </div>
                                <div class="input-field col s12">
                                    <input id="in_user" type="text" class="validate">
                                    <label for="in_user">Usuario</label>
                                </div>
                                <div class="input-field col s12">
                                    <input id="in_pass" type="password" class="validate">
                                    <label for="in_pass">Contraseña</label>
                                </div>
                                <div class="col s12">
                                    <a class="waves-effect waves-light btn light-blue blueb" onclick="login();">Iniciar Sesión</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col m3 l4"></div>
                <div id="logoc" class="logo-client">
                    <img src="<?php echo $pRootHtmlC . "/Publics/images/Admin/logo-client.png"; ?>">
                </div>
            </div>
        </body>
    </html>
    <?php
} else {
    header("Location: $pRootHtmlC/Admin/Views/index.php");
}
?>