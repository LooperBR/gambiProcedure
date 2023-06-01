<?php
class Connection{
    // Propriedades
    private ?PDO $conn;

    // Construct
    public function __construct(?PDO $conn=NULL){
        $this->conn = $conn;
    }

    public function Connect(string $host=NULL, string $db=NULL, string $user=NULL, string $pass=NULL): bool{
        try{
            $dsn = 'mysql:host='.$host.';dbname='.$db.';port=3306;charset=UTF8';
            $options = [
                PDO::ATTR_PERSISTENT => true,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"
            ];
            $this->conn = new PDO($dsn, $user, $pass);
        }catch(Exception $e){
            $this->conn = NULL;
        }

        return !is_null($this->conn);
    }

    public function SQL(string $sql): PDOStatement{
        return $this->conn->prepare($sql);
    }

    public function Bind(PDOStatement &$stmt,  int $paramIndex, mixed $value, mixed $PDOParam=NULL): void{
        if(is_null($PDOParam)){
            switch(gettype($value)){
                case 'boolean': $PDOParam = PDO::PARAM_BOOL; break;
                case 'integer': $PDOParam = PDO::PARAM_INT; break;
                case 'double': $PDOParam = PDO::PARAM_STR; break;
                case 'string': $PDOParam = PDO::PARAM_STR; break;
                case 'NULL': $PDOParam = PDO::PARAM_NULL; break;
                default: $PDOParam = PDO::PARAM_STR; break;
            }
        }

        try{
            $stmt->bindValue(':'.strval($paramIndex), $value, $PDOParam);
        }catch(Exception $e){}
    }
}

// Cria uma instância de Conexão com o banco de dados
$connection = new Connection();
$connection->Connect('localhost', 'exemplo_procedure', 'root', '123456');