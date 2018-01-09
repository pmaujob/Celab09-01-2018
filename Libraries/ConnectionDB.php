<?php

@session_start();

$pRootC = $_SESSION['pRootC'];

require_once $pRootC . '/Libraries/HostData.php';

class ConnectionDB {

    private static function connect($hostData) {

        try {
            $pdo = new PDO($hostData->getMotor()
                    . ":host=" . $hostData->getHost()
                    . ";dbname= " . $hostData->getDB() . ";", $hostData->getUser(), $hostData->getPass());
            $pdo->query("SET NAMES 'utf8'");
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            return 'Error connection: ' . $e->getMessage();
        }
    }

    public static function consult($hostData, $sql) {

        $pdo = self::connect($hostData);
        $rt = null;

        try {

            $query = $pdo->prepare($sql);
            $query->execute();
            $rt = $query;
        } catch (PDOException $e) {
            return $e->getMessage() . ", " . $sql;
        }

        self::closeConnection($pdo);

        return $rt;
    }

    public static function afect($hostData, $sql) {

        $pdo = self::connect($hostData);
        $res = 0;

        try {

            $pdo->exec($sql);
            $res = 1;
        } catch (PDOException $e) {
            return $e->getMessage();
        }

        self::closeConnection($pdo);

        return $res;
    }

    private static function closeConnection($pdo) {

        $pdo = null;
    }

}

?>