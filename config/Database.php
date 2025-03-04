<?php
class Database{
    public $dbConnection;
    private $errors=[];
    public function __construct(string $host, string $user, string $password, string $database) {
        $this->dbConnection = new mysqli($host, $user, $password, $database);

        // Verificar si la conexión es exitosa
        if ($this->dbConnection->connect_error) {
            throw new Exception("Error en la conexión a la base de datos: " . $this->dbConnection->connect_error);
        }
    }
    public function getConnection (){
        return $this->dbConnection;
    }
    public function setError($message) {
        if (!is_array($this->errors)) {
            $this->errors = []; // Asegurar que sea un array
        }
        $this->errors[] = $message; // Agregar el mensaje al array
    }
    public function getError(): array {
        if (!is_array($this->errors)) {
            return []; // Si no es un array, devuelve un array vacío
        }
        return $this->errors;
    }
    public function selectOri(string $admin){
        // Consulta preparada para evitar inyecciones SQL
        $stmt = $this->dbConnection->prepare("SELECT * FROM orientador WHERE Nombre = ?");
        $stmt->bind_param("s", $admin);
        $stmt->execute();
        $res = $stmt->get_result();  
        return $res;
    }
    public function redirectTo(string $url){
        header("Location:$url");
    }
    public function __destruct(){
        if($this->dbConnection){
            $this->dbConnection->close();
        }
    }
    public function logout(){
        session_start();
        session_unset();
        session_destroy();
    }
}
?>