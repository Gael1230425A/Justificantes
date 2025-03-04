<?php
require_once("ClasePadre.php");
class Justificantes extends ClasePadre{ 
    public function searchStudent(int $noCont){
        //Hace toda la lógica de buscar al estudiante, su tutor y el número de justificantes en una sola consulta
        $sqlExecute=
            "SELECT * FROM estudiantes 
            INNER JOIN tutor ON estudiantes.numTutor=tutor.numTutor 
            LEFT JOIN justificante ON estudiantes.NoControl=justificante.Estudiante 
            WHERE NoControl=?";
        //Ejecuta la consulta
        $dataStudent=$this->prepareQuery($sqlExecute, "i",[$noCont]);
        //si obtiene resultados de la consulta
        if($dataStudent->num_rows>0){
            //obtiene los registros de la consulta
            $rows= $dataStudent->fetch_assoc();
            //establece un contador de filas con datos
            $noNulls=0;
            foreach ($rows as $valor) {
                if (!is_null($valor)) {
                    $noNulls++;
                }
            }
            //establece el número si se ha tramitado algún justificante
            $numJusti=$dataStudent->num_rows;
            //guarda los datos obtenidos en el arreglo para su impresión
            $this->setStudent(["NoControl" => $rows["NoControl"],"Nombre" => $rows["Nombre"],"Semestre y Grupo" => $rows["Semestre"].$rows["Grupo"],"Turno" => $rows["Turno"],"Tutor" => $rows["nombreTutor"]]);
            //si tiene 7 campos llenos, significa que no se llenó ningún justificante
            if($noNulls===7){
                $this->setError("No se ha tramitado ningún justificante");
                $this->setButtons("Nuevo Justificante");  
            }
            //si tiene más de 7 campos llenos, significa que ya se tramitaron justificantes
            else if($noNulls>7){
                $this->setJusti(["Folio" => $rows["Folio"], "Situacion"=> $rows["MotivoIna"], "Fecha Solicitud"=>$rows["FechaExp"], "Fecha Falta"=> "$rows[FechaIna] A $rows[FechaFin]"]);
                while($rows=$dataStudent->fetch_assoc()){
                $this->setJusti(["Folio" => $rows["Folio"], "Situacion"=> $rows["MotivoIna"], "Fecha Solicitud"=>$rows["FechaExp"], "Fecha Falta"=> "$rows[FechaIna] A $rows[FechaFin]"]);
                }
                if($numJusti>3){
                    $this->setButtons("No puedes tramitar más justificantes");
                }
                elseif($numJusti<4){
                    $this->setButtons("Nuevo Justificante");  
                }
            }
        }
        elseif($dataStudent->num_rows===0){
            $this->setError("El número de control $noCont, no existe");
        }
    }
    public function insertStudent(int $noCont, string $applicationDate, string $reasonIna,string $dateIna, string $dateEnd, int $orientador ){
        //Buscar el estudiante
        $command=$this->select("NoControl","estudiantes","NoControl",$noCont);
        //Verificar si existe el estudiante nomas por si acaso xddd
        $student=$command->num_rows;
        if($student>0){
            $this->insert(
                "justificante",
                "Estudiante, FechaExp, MotivoIna, FechaIna, FechaFin, Orientador",
                "?,?,?,?,?,?",
                "issssi",
                [$noCont,"$applicationDate","$reasonIna","$dateIna","$dateEnd",$orientador]
            );
            //Mensaje de éxito
            $this->setError("Justificante agregado correctamente.");

            //Redirecciona a la página después de 3 segundos :v
            header("Refresh: 3; url=TramiteJusti.php?Nocont=$noCont");
        }
        else{
            //Mensaje de error
            $this->setError("El justificante no fue agregado, intentelo de nuevo.");
            //Redirecciona a la página después de 3 segundos :v
            header("Refresh: 3; url=TramiteJusti.php?Nocont=$noCont");
        }
    }
    public function printJusti(int $folio){
        //Selecciona el justificante de acuerdo al folio
        $justificante=$this->prepareQuery("SELECT * FROM justificante INNER JOIN estudiantes ON justificante.Estudiante=estudiantes.NoControl WHERE justificante.Folio= ?","i",[$folio]);

        if($justificante->num_rows>0){
            $reg=$justificante->fetch_assoc(); //Recupera los datos y los asigna a  siguientes variables
            
            $fechade=new DateTime($reg["FechaIna"]);
            $fechaa=new DateTime($reg["FechaFin"]);
            $dias=$fechade->diff($fechaa)->format('%d ');
            $fechaexp=new DateTime($reg["FechaIna"]);
            $fecha1=$fechaexp->format('d-m-y');
            $fecha2=$fechade->format('d-m-y');
            $fecha3=$fechaa->format('d-m-y');


            //Asigna los valores recuperados
            $this->setJusti([ $reg["MotivoIna"], $fecha1,$fecha2, $fecha3, $dias]);

            $this->setStudent([$reg["Nombre"],$reg["Grupo"],$reg["Semestre"]]);
        }
        else{
            $this->setError("Error, el Justificante no existe");
        }
    }
    public function statistics(array $months, string $sem, string $group){
        //Selecciona todos los justificantes de la base de datos
        $justificantes=$this->select("Estudiante, FechaExp","justificante","1","1");

        if(empty($sem) && empty($group)){
        //Establece las estadisticas que actualmente se están mostrando
        $this->setError("Estadísticas de Todos los Semestres y Grupos");       
            if($justificantes->num_rows>0)
            {
                while($reg=$justificantes->fetch_assoc())
                {
                    $soli=$reg["FechaExp"];
                    $parts=date_parse($soli);
                    $mes=$parts['month'];
                    $months["$mes"] += 1;
                }
            }             
        }
        
        else if(!empty($sem) && !empty($group)){
            //Mensaje que muestra las estadisticas de acuerdo a lo solicitado por el usuario
            $this->setError("Estadísticas de $sem$group");

            //Obtiene los datos de cada justificante
            if($justificantes->num_rows>0)
            {
                while($registroJusti=$justificantes->fetch_assoc())
                {
                    //obtiene el num de control y la fecha de expedicion del justificante
                    $Nocont=$registroJusti["Estudiante"];
                    $soli=$registroJusti["FechaExp"];
                    $semestreGrupo=$this->select("Semestre, Grupo","estudiantes","NoControl",$Nocont);
                    $regSemestreGrupo=$semestreGrupo->fetch_assoc(); //Recupara los datos y los asigna a las siguientes variables
                    $semestre=$regSemestreGrupo["Semestre"];
                    $grupo=$regSemestreGrupo["Grupo"];
                    if($semestre==$sem)
                    {
                        if($grupo==$group){
                            $parts=date_parse($soli);
                            $mes=$parts['month'];
                            $months["$mes"] += 1;
                        }
                    }
                }    
            }
        }

        else if(empty($sem)){
            $this->setError("Estadísticas del Grupo $group (Todos los Semestres)");
            if($justificantes->num_rows>0)
            {
                while($registroJusti=$justificantes->fetch_assoc())
                {
                    //Toma el número de control y la fecha de expedición de cada justificante
                    $noCont=$registroJusti["Estudiante"];
                    $fsolicitud=$registroJusti["FechaExp"];
                    //Selecciona el grupo de cada estudiante
                    $grupo=$this->select("Grupo","estudiantes","NoControl",$noCont);
                    
                    //obtiene el grupo del estudiante
                    $registroStuGru=$grupo->fetch_assoc();
                    $gru=$registroStuGru["Grupo"];

                    //si el grupo recuperado es igual al solicitado
                    if($gru==$group)
                    {
                        //sepera la fecha en año-mes-dia
                        $parts=date_parse($fsolicitud);
                        $mes=$parts['month'];
                        $months["$mes"] += 1;
                    }
                }
            }
        }

        else if(empty($groups)){
            //Mensaje que muestra la opción que eligió el usuario
            $this->setError("Estadísticas de $sem Semestre (Todos los Grupos)");

            //Obtiene cada justificante
            if($justificantes->num_rows>0)
            {
                while($registroJusti=$justificantes->fetch_assoc())
                {
                    //obtiene los registros de los justificantes
                    $noCont=$registroJusti["Estudiante"];
                    $soli=$registroJusti["FechaExp"];

                    //Selecciona el semestre de cada estudiante
                    $semestre=$this->select("Semestre","estudiantes","NoControl",$noCont);
                    
                    //Recupera los datos y los asigna a las siguientes variables
                    $registroStu=$semestre->fetch_assoc(); 
                    $semestreStu=$registroStu["Semestre"];
                    if($semestreStu==$sem)
                    {
                        //Separa la fecha en año-mes-dia y obtiene solo el mes para graficar
                        $parts=date_parse($soli);
                        $mes=$parts['month'];
                        $months["$mes"] += 1;
                    }
                }
            }
        }

        return $months;
    }
}
?>
