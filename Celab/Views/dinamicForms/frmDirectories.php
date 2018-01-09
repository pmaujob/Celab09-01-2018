<?php
@session_start();

$pRoot = $_SESSION['pRoot'];
$pRootHtml = $_SESSION['pRootHtml'];

$userId = $_POST['userId'];

require_once $pRoot . '/MlBackups/Models/FileManagement/MConsultUsers.php';

$dirs = MConsultUsers::getDirectorios($userId);
foreach ($dirs as $dir) {
    ?>
    <li class="collection-item avatar">
        <img class="circle" style="background-color: #2196F3; padding: 5px;" src="<?php echo "$pRootHtml/Publics/images/inkscape/folder-open.svg"; ?>">
        <span class="title"><?php echo $dir[1]; ?></span>
    </li>
    <?php
}
?>