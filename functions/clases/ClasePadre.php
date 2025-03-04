<?php
class ClasePadre{
    public $dbConnection;
    private $errors=[];
    private $students=[];
    private $justis=[];
    private $buttons=[];
    private $tables=[];
    private $columns=[];
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
    public function setStudent(array $student) {
        if (!isset($this->students)) {
            $this->students = []; // Asegurar que sea un array
        }
        $this->students[] = $student; // Agregar el estudiante al array
    }
    public function getStudents(): array {
        if (!is_array($this->students)) {
            return []; // Si no es un array, devuelve un array vacío
        }
        return $this->students;
    }
    public function setJusti(array $justi) {
        if (!is_array($this->justis)) {
            $this->justis = []; // Asegurar que sea un array
        }
        $this->justis[] = $justi; // Agregar el mensaje al array
    }
    public function getJusti(): array {
        if (!is_array($this->justis)) {
            return []; // Si no es un array, devuelve un array vacío
        }
        return $this->justis;
    }
    public function setTableandColumn($table, $column) {
        if (!isset($this->columns[$table])) {
            $this->columns[$table] = []; // Si la tabla no existe, la inicializamos
        }
        $this->columns[$table][] = $column; // Agregar la columna a la tabla
    }
    public function getTableandColumn(): array {
        return $this->columns ?? []; // Retorna el array o vacío si no está definido
    }
    public function setButtons($message) {
        if (!is_array($this->buttons)) {
            $this->buttons = []; // Asegurar que sea un array
        }
        $this->buttons[] = $message; // Agregar el mensaje al array
    }
    public function getButtons(): array {
        if (!is_array($this->buttons)) {
            return []; // Si no es un array, devuelve un array vacío
        }
        return $this->buttons;
    }
    public function select(string $select,string $table, string $conditional, string $condition){
        // Consulta preparada para evitar inyecciones SQL
        $stmt = $this->dbConnection->prepare(query: "SELECT $select FROM $table WHERE $conditional = ?");
        $stmt->bind_param("s", $condition);
        $stmt->execute();
        $res = $stmt->get_result();  
        return $res;

        if ($stmt === false) {
            throw new Exception("Error en la preparación de la consulta: " . $this->dbConnection->error);
        }
    }
    public function prepareQuery(string $sql, string $types, array $params = []) {
        $stmt = $this->dbConnection->prepare($sql);
        
        if ($stmt === false) {
            throw new Exception("Error en la preparación de la consulta: " . $this->dbConnection->error);
        }
    
        if (!empty($params)) {
            $stmt->bind_param($types, ...$params);
        }
    
        $stmt->execute();
    
        if (stripos($sql, "SELECT") === 0) {
            return $stmt->get_result(); // Retorna el resultado en caso de SELECT
        }
    }
    public function insert(string $table, string $fields, string $numValues, string $typeValues, array $values){
        // Consulta preparada para evitar inyecciones SQL
        $stmt = $this->dbConnection->prepare("INSERT INTO $table($fields) VALUES($numValues)");
        $stmt->bind_param($typeValues,...$values);
        $stmt->execute();

        if ($stmt === false) {
            throw new Exception("Error en la preparación de la consulta: " . $this->dbConnection->error);
        }
    }
    public function __destruct(){
        if($this->dbConnection){
            $this->dbConnection->close();
        }
    }
}
?>