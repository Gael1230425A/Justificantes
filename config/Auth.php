<?php
require_once("Database.php");
class Auth extends Database{
    private $homePage='../../views/doc/PagPrincipal.php';
    public function validateLogin(string $admin, string $password) {
        $res = $this->selectOri($admin);

        if (!$res) {
            $this->setError("Error interno, intenta más tarde.");
            return false;
        }

        if ($res->num_rows > 0) {
            $usuario = $res->fetch_assoc();
            $password_hash = $usuario['Contrasena']; // Contraseña cifrada en la base de datos

            if (password_verify($password, $password_hash)) {
                // Protege la sesión contra ataques de fijación y secuestro
                session_start();
                session_regenerate_id(true); // Evita session fixation

                $_SESSION['user_id'] = $usuario['idOri'];
                $_SESSION['admin'] = htmlspecialchars($usuario['Nombre'], ENT_QUOTES, 'UTF-8'); // Evita XSS

                $this->redirectTo($this->homePage);
                return true;
            } else {
                $this->setError("Credenciales inválidas, intenta nuevamente.");
                return false;
            }
        } else {
            $this->setError("Credenciales inválidas, intenta nuevamente.");
            return false;
        }
    }
    public function verifySession(string $location1, string $location2){
        session_start();
        $sesion = $_SESSION['admin'];
        if($sesion == null || $sesion==""){
            $this->redirectTo($location1);
            return true;
        }

        else{
            $this->redirectTo($location2);
            return false;
        }
    }

}
?>