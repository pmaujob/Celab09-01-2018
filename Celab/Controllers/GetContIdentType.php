<?php

@session_start();
$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Celab/Models/MGetContIdentType.php';

$op = $_POST['op'];
switch ($op) {

    case 1:
        echo json_encode(GetContIdentType::getTipoIdent()->fetchAll(PDO::FETCH_OBJ));
        break;
    
    case 2:
        echo json_encode(GetContIdentType::getTipoCont()->fetchAll(PDO::FETCH_OBJ));
        break;

    default:
        echo "0";
        break;
}
?>
