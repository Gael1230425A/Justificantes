<?php
require_once("ClasePadre.php");
class Orientador extends ClasePadre{
    public function insertStudentsandParents(string $queryStudents,string $queryParents){
        //Sentencia para obtener el número de registros
        $query="SELECT COUNT(*) AS total FROM tutor";
        $result=$this->dbConnection->query($query);

        $row=$result->fetch_assoc();

        if($row["total"]==0){
            if($this->dbConnection->multi_query($queryParents.$queryStudents)){
                $this->setError("Base de datos actualizada correctamente");
            }
            else{
                $this->setError("Error al actualizar la base de datos");
            }
        }
        else if($row["total"]>0){
            $this->setError("No se actualizó la Base de datos, porque ya hay registros");
        }
    }
    public function ActDB (){
        $tablesAndColumns=$this->prepareQuery("SELECT TABLE_NAME, COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = ? AND TABLE_NAME NOT IN ('orientador');", "s",["justificantes"]);
        while ($reg = $tablesAndColumns->fetch_assoc()) {
            $this->setTableandColumn($reg["TABLE_NAME"], $reg["COLUMN_NAME"]);
        }
    }
}
?>
<form class="form-eliminacion" id="form-eliminacion1" name="form-eliminacion" method="post" action="../php/EditarBasedeDatos.php">
    <fieldset id="f1">
        <legend>Edición de la Base de Datos</legend>
            <table border="1">
                <thead>
                    <th></th>
                    <th>Tabla</th>
                    <th>Columna</th>
                    <th colspan="3">Acción</th>
                    <th>Filas</th>
                </thead>
                <?php
                $orientador=new Orientador("localhost","root","","justificantes");
                $actDB=$orientador->ActDB();
                $columnasPorTabla=$orientador->getTableandColumn();
                
                foreach ($columnasPorTabla as $tabla => $columnas) {
                    echo"<tbody>";
                    echo "<td><input type='checkbox' name='' id=''></td>";
                    echo "<td>$tabla</td>";
                    echo"<td><select name='' id=''>";
                    foreach ($columnas as $columna) {
                        echo "<option value='$columna'> $columna</option>";
                    }
                    echo"</select></td>";
                    echo"<td><a href=''>Buscar</a></td>";
                    echo"<td><a href=''>Insertar</a></td>";
                    echo"<td><a href=''>Vaciar</a></td>";
                }?>
                <input type="search" name="" id="">
            </table>
    </fieldset>
</form>

