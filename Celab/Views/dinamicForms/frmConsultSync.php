<?php
@session_start();

$pRoot = $_SESSION['pRoot'];
$pRootHtml = $_SESSION['pRootHtml'];

require_once $pRoot . '/MlBackups//Models/FileManagement/MConsultUsers.php';

$searchValue = $_POST['searchValue'];

$arrayColors = array(
    "#F44336",
    "#2196F3",
    "#FFEB3B",
    "#4CAF50",
    "#FF9800",
    "#673AB7",
    "#795548");

$userData = MConsultUsers::getUsers($searchValue);
$i = 0;
foreach ($userData as $row) {
    ?>
    <li class="collection-item avatar">
        <img class="circle" style="background-color: <?php echo $arrayColors[$i]; ?>; padding: 3px;" src="<?php echo "$pRootHtml/Publics/images/inkscape/account.svg"; ?>">
        <span class="title"><?php echo $row[2]; ?></span>
        <p>
            <label><?php echo $row[3]; ?></label>
        </p>
        <a class="secondary-content ver-mas-button" href="#!" onclick="createTable('<?php echo $row[0]; ?>');">Ver más</a>
    </li>
    <?php
    $i++;
}
?>


