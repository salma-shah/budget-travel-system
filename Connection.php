<?php

class Connection 

{

// placing db parameters
private $host = 'localhost';
private $user = 'root';
private $password = '';
private $db = 'tripzly'; 

// PDO
private $pdo;
private $stmt;
private $error;

    public function __construct()
    {
        // data source name
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db . ';charset=UTF8';
        $options = [
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ];
        
        try 
        {      
            $this-> pdo = new PDO($dsn, $this-> user, $this -> password, $options);
          //  echo "Connected successfully!";
    
        }
        catch(PDOException $ex) 
        {
            die( "Connected failed due to: " .$ex -> getMessage());    
        }
    }

// query function
public function query($sql){
    $this -> stmt = $this->pdo->prepare($sql);
}

 //bind values to the prepared statement using parameters
    public function bind($param, $value, $type = null){
        if(is_null($type)){
            switch(true){
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }

// execute function
public function execute(){
    return $this->stmt->execute();
}

// return many records
public function resultSet(){
     $this -> execute();
     return $this->stmt->fetchAll(PDO::FETCH_OBJ);
}

// return a single record
public function single(){
    $this -> execute();
    return $this->stmt->fetch(PDO::FETCH_OBJ);
}

//get row count
    public function rowCount(){
        return $this->stmt->rowCount();
    }

//get last inserted id from a table
    public function lastInsertedid(){
        return $this->pdo->lastInsertId();
    }
}
?>