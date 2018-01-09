<?php

@session_start();

$pRoot = $_SESSION['pRoot'];
$userId = $_POST['userId'];

require_once $pRoot . '/MlBackups/Models/FileManagement/MConsultUsers.php';

$user = MConsultUsers::getEeudatos($userId);
$dirsCount = 0;

?>
<table class="bordered">
    <?php
    foreach ($user as $row) {
        ?>
        <tr>
            <th>
                Responsable:&nbsp;
            </th>
            <td>
                <?php echo $row[3]; ?>
            </td>
        </tr>
        <tr>
            <th>
                Cuenta:&nbsp;
            </th>
            <td>
                <?php echo $row[2]; ?>
            </td>
        </tr>
        <tr>
            <th>
                IP:&nbsp;
            </th>
            <td>
                <?php echo $row[4]; ?>
            </td>
        </tr>
        <tr>
            <th>
                Último Registro:&nbsp;
            </th>
            <td>
                <?php echo $row[5]; ?>
            </td>
        </tr>
        <tr>
            <th>
                Última IP:&nbsp;
            </th>
            <td>
                <?php echo $row[6]; ?>
            </td>
        </tr>
        <?php
        $dirsCount = $row[7];
    }
    ?>
</table>
<br>
<?php
if ($dirsCount == 0) {
    ?>
    <h5>No se encontraron directorios registrados.</h5>
    <?php
} else {
    ?>
    <a class="waves-effect waves-light btn" style="background: #3991FE;" onclick="openDirectories('<?php echo $userId; ?>');">
        <i class="material-icons left">folder</i>
        Directorios
    </a>
    <?php
}

?>

