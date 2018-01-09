<?php
@session_start();

$pRootC = $_SESSION['pRootC'];
$pRootHtmlC = $_SESSION['pRootHtmlC'];

require_once $pRootC . '/Libraries/SessionVars.php';

$sess = new SessionVars();

if ($sess->exist() && $sess->varExist('user')) {
    ?>
    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>Celab</title>
            <?php include_once $pRootC . '/Admin/Views/header.php'; ?>
            <script>
                function onLoad() {
                    document.getElementById('logo_heart').style.opacity = "1";
                }
            </script>
        </head>
        <body onload="onLoad();">

            <?php include_once $pRootC . '/Admin/Views/menu.php'; ?>

            <div class="row">
                <div class="col s12 m4 l4">

                </div>
                <div id="logo_heart" class="logo-heart col s12 m4 l4 center">
                    <img src="../../Publics/images/Admin/logo-client.png">
                </div>
            </div>

        </body>
    </html>

    <?php
} else {
    header("Location: $pRootHtmlC");
}
?>