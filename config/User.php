<?php
require_once("Database.php");
class User extends Database{
    public function createAdmin(string $currentAdmin, string $currentPassword,string $admin, string $password){
        //turno matutino: soniaturnomatutino
        //turno vespertino:ezequielturnovespertino

        $res=$this->selectOri($currentAdmin);
        $passwordhash=$res->fetch_assoc();

        $res2=$this->selectOri($admin);

        if($passwordhash&&password_verify($currentPassword,$passwordhash["Contrasena"])){
            //Si el usuario ya existe en la base de datos
            if (mysqli_num_rows($res2) > 0) {
                $this->setError("El Usuario ya existe");
            }
            //Si hay un número de 0 registros
            else if(mysqli_num_rows($res2) === 0){
            // Cifrar la contraseña
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Insertar el nuevo orientador
            $resultado = $this->dbConnection->query("INSERT INTO orientador (Nombre, Contrasena) VALUES ('$admin', '$password_hash')");
            if ($resultado) {
                $this->setError("Orientador registrado correctamente");
                $this->redirectTo('../../../views/doc/PagPrincipal.php');
                return true;;
            }
            else {
                echo("<h1>eres pendejo</h1>");
                $this->setError("Error al registrar el orientador");
                return false;
            }
            }
        }
        else{
            $this->setError("Contraseña Incorrecta");
        }
    }
    public function changeAdmin(string $currentUser,string $newUser, string $password){
        //Consultas a la base de datos
        $res=$this->selectOri($currentUser);
        $orientador=$res->fetch_assoc();
        $password_hash=$orientador["Contrasena"];

        //Verifica si obtuvo resultados de la consulta y si la contraseña ingresada coincide con el hash de la base de datos
        if($orientador&&password_verify($password,$password_hash)){
            //Compara el nuevo nombre de usuario y en dado caso de ser iguales, muestra un mensaje de "error"
            switch ($newUser) {
                case $currentUser:
                   $this->setError("Ingresa un usuario diferente, inténtalo de nuevo");
                    break;
                
                default:
                //Actualiza el usuario en la base de datos
                $actualizar = "UPDATE orientador SET Nombre='$newUser' WHERE Nombre='$currentUser'";
                $resultado = $this->dbConnection->query($actualizar);

                //comprueba que se haya hecho correctamente la consulta, en dado caso de algún error, muestra un
                if ($resultado) {
                    $this->setError("Usuario actualizado correctamente");
                    $this->redirectTo("../../auth/index.php"); // Redirigir al inicio de sesión
                    $this->logout();
                } else {
                    $this->setError("Error al actualizar los datos");
                }
                    break;
            }
            return true;
        }
        else{
            $this->setError("Contraseña incorrecta");
            return false;
        }
    }
    public function changePassword(string $currentUser, string $currentPassword, string $newPassword1, string $newPassword2){

        // Validar si el usuario y la contraseña actuales son correctos
        $res=$this->selectOri($currentUser);
        $usuario = $res->fetch_assoc();

        if ($usuario && password_verify($currentPassword, $usuario['Contrasena'])) {
            if($newPassword1 === $newPassword2){
                switch ($currentPassword) {
                    case $newPassword1:
                        $this->setError("Ingresa una contraseña diferente, es igual a la antigua");
                        break;
                    
                    default:
                    // Si la nueva contraseña es diferente, actualizamos
                    $nueva_contraseña_hash = password_hash($newPassword1, PASSWORD_DEFAULT);
                    $actualizar = "UPDATE orientador SET Contrasena='$nueva_contraseña_hash' WHERE Nombre='$currentUser'";
                    $resultado = $this->dbConnection->query($actualizar);

                    if ($resultado) {
                        $this->setError("Contraseña actualizada correctamente");
                        $this->redirectTo("../../auth/index.php"); // Redirigir al inicio de sesión
                        $this->__destruct();
                        $this->logout();
                    } else {
                        $this->setError("Error al actualizar los datos");
                    }
                        break;
                }
            }
            else{
                $this->setError("Reingresa correctamente tu contraseña");
            }
            return true;
        } 
        else {
            $this->setError("Contraseña incorrecta");
            return false;
        }
    }
}
?>