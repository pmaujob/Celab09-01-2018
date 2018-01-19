<?php
@session_start();

$pRootC = $_SESSION['pRootC'];
$pRootHtmlC = $_SESSION['pRootHtmlC'];

require_once $pRootC . '/Admin/Models/MGetMenu.php';
require_once $pRootC . '/Config/SysConfig.php';
require_once MLIBPATH . 'Access/SessionVars.php';

$modules = MGetMenu::getMenu(2, 1);

$sess = new SessionVars();
?>

<div class="row">
    <div class="head-usuario col s12 m12 l12">
        <div class="col s6 m1 l1">
            <a href="#" data-activates="slide-out" class="button-collapse">
                <i class="icon-menu small material-icons">menu</i>
            </a>
        </div>
        <div class="col m10 l10">

        </div>
        <div class="col s6 m1 l1 right-align">
            <a id="btnUserMenu" href="#" class="dropdown-button" data-activates='dropdown1'>
                <i class="material-icons medium">person_pin</i>
            </a>
            <ul class='dropdown-content' id="dropdown1">
                <li><a href="#!" style="color: #03A9F4;"><i class="material-icons">vpn_key</i>Cambiar Contraseña</a></li>
                <li><a href="<?php echo $pRootHtmlC . '/Admin/Controllers/CLogout.php' ?>"><i class="material-icons">exit_to_app</i>Cerrar Sesión</a></li>
            </ul>
        </div>
    </div>
</div>

<div class="row">

    <ul id="slide-out" class="side-nav">
        <li>
            <div class="user-view">
                <div class="background">
                    <img src="<?php echo $pRootHtmlC . '/Publics/images/background-user.jpg'; ?>">
                </div>
                <a href="#!user"><img class="circle" src="<?php echo $pRootHtmlC . '/Publics/images/logoUser.png'; ?>"></a>
                <a href="#!name"><span class="name white-text"><?php echo $sess->getValue('user'); ?></span></a>
                <a href="#!email"><span class="email white-text"><?php echo $sess->getValue('email'); ?></span></a>
            </div>
        </li>
        <?php
        if (count($modules) > 0) {
            foreach ($modules as $row) {

                if ($row[2] === '1') {
                    $functions = MGetMenu::getMenu(1, 1, $row[0])->fetch(PDO::FETCH_OBJ);
                    $link = $functions->url;
                    $nameFunction = $functions->mod;
                    ?>
                    <li><a href="<?php echo $link; ?>"><?php echo $nameFunction; ?></a></li>
                    <?php
                } else {
                    ?>

                    <li class="no-padding">
                        <ul class="collapsible collapsible-accordion">
                            <li>
                                <a class="collapsible-header"><?php echo $row[1]; ?><i class="material-icons right">arrow_drop_down</i></a>
                                <div class="collapsible-body">
                                    <ul>
                                        <?php
                                        $functions = MGetMenu::getMenu(1, 1, $row[0]);
                                        foreach ($functions as $row2) {
                                            ?>
                                            <li><a onclick="location.href = '<?php echo 'http://' . $_SERVER['SERVER_NAME'] . $row2[3]; ?>'" href="<?php echo 'http://' . $_SERVER['SERVER_NAME'] . $row2[3]; ?>"><?php echo $row2[2]; ?></a></li>
                                            <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    </li>

                    <?php
                }
            }
        } else {

            echo "Este usuario no tiene acceso a ningun modulo";
        }
        ?>
    </ul>
</div>

<script>
    $(".button-collapse").sideNav();
</script>


