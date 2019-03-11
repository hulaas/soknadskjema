<?php
include_once 'DBConfig.php';
class DBController
{
    /*private $database = DATABASE;
    private $host = HOST;*/
    private $dsn = "mysql:charset=utf8;dbname=" . DATABASE . ";host=" . HOST;
    private $user = USER;
    private $password = PASSWORD;

    private $pdo;


    function __construct()
    {
        $this->pdo = $this->connectDB();
    }

    function connectDB()
    {
        try{
            $pdo = new PDO($this->dsn, $this->user, $this->password);
            return $pdo;
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
            return null;
        }
        /*$conn = new mysqli($this->host, $this->user, $this->password, $this->database);*/

    }

    function runBaseQuery($query) {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(!empty($result))
            return $result;
    }

    function bindQueryParams($params, $stmt) {
        foreach ($params as $key => &$val) {
            $stmt->bindParam($key, $val);
        }
    }

    function runQuery($query, $param_value_array){
        $stmt = $this->pdo->prepare($query);
        $this->bindQueryParams($param_value_array, $stmt);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


        if(!empty($result)) {
            return $result;
        }
    }

    function insert($query, $param_value_array) {
        $stmt = $this->pdo->prepare($query);
        $this->bindQueryParams($param_value_array, $stmt);
        $stmt->execute();
    }

    function update($query, $param_value_array) {
        $stmt = $this->pdo->prepare($query);
        $this->bindQueryParams($param_value_array, $stmt);
        $stmt->execute();
    }












}
