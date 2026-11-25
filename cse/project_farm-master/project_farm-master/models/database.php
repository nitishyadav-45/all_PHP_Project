<?php
ob_start();
require_once("config.php");

class database
{
    protected $pdo = null;
    protected $sql = '';
    protected $sta = null;

    // FIXED CONSTRUCTOR
    public function __construct()
    {
        try {
            $this->pdo = new PDO(
                "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
                DB_USER,
                DB_PWD
            );

            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->query("SET NAMES utf8");

        } catch (PDOException $ex) {
            die("Database Connection Failed: " . $ex->getMessage());
        }
    }

    public function setQuery($sql)
    {
        $this->sql = $sql;
    }

    public function execute($options = array())
    {
        $this->sta = $this->pdo->prepare($this->sql);

        if ($options) {
            for ($i = 0; $i < count($options); $i++) {
                $this->sta->bindParam($i + 1, $options[$i]);
            }
        }

        $this->sta->execute();
        return $this->sta;
    }

    public function loadAllRows($options = array())
    {
        $result = $this->execute($options);
        return $result->fetchAll(PDO::FETCH_OBJ);
    }

    public function loadRow($options = array())
    {
        $result = $this->execute($options);
        return $result->fetch(PDO::FETCH_OBJ);
    }

    public function loadRecord($options = array())
    {
        $result = $this->execute($options);
        return $result->fetchColumn();
    }

    public function getLastId()
    {
        return $this->pdo->lastInsertId();
    }

    public function disconnect()
    {
        $this->sta = null;
        $this->pdo = null;
    }
}
?>