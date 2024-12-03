<?php
#Seguridad
session_start();
$sesion = $_SESSION['admin'];
if($sesion == null || $sesion==""){
    header("location:SinAcceso.html");
    die();
}
?>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <meta name="generator" content={Astro.generator} />
    <link rel="stylesheet" href="/styles/styles.css">
    <title>Mostrar Estadisticas de los Alumnos</title>
</head>

<body class="bg-amber-100">

    <div class="container">
        <header class="header">
            <img class="header-logo" src="../images/CBTIS86logo.png" alt="Encabezado de la Página" />
        </header>
        <nav class="menu">
            <ul class="menu-list">
                <li><a href="PagPrincipal.php" class="menu-link">Documentación del Programa</a></li>
                <li><a href="NuevoJustificante.php" class="menu-link">Nuevo Justificante</a></li>
                <li><a href="Estadisticas.php" class="menu-link">Estadísticas</a></li>
                <li><a href="MovAdministrativos.php" class="menu-link">Movimientos Administrativos</a></li>
                <li><a href="ActDB.php" class="menu-link">Actualizar Bases de Datos</a></li>
        <li><a href="Cambio.php">USUARIO</a></li>
        <li><a href="CerrarSesion.php">CERRAR SESION</a></li>
            </ul>
        </nav>
        <!--Ejemplo de Estructura -->
        <form action="">
            <fieldset class="border  border-black p-5">
                <legend>
                    Seleccionar Mes:
                    <select name="" id="">
                        <option value="">Enero</option>
                    </select>
                    <button class="border  border-black p-5">Mostrar</button>
                </legend>

                <section class="border  border-black p-5">
                    <fieldset class="border  border-black p-5">
                        <legend>Estadisticas del Mes de Octubre (Turno Matutino)</legend>
                        <canvas class="border  border-black "></canvas>
                    </fieldset>

                    <fieldset class="border  border-black p-5">
                        <legend>Estadisticas del Mes de Octubre (Turno Vespertino)</legend>
                        <canvas class="border  border-black "></canvas>
                    </fieldset>
                </section>
            </fieldset>
        </form>
    </div>

</body>

</html>
<style>
  html {
    font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
    line-height: 1.5;
    -webkit-text-size-adjust: 100%;
    -moz-tab-size: 4;
    tab-size: 4;
    scroll-behavior: smooth;
  }

  body {
    margin: 0;
    font-family: inherit;
    line-height: inherit;
    background-color: white;
    color: black;
  }

  a {
    color: inherit;
    text-decoration: inherit;
  }

  img {
    display: block;
    max-width: 100%;
    height: auto;
  }

  /* Layout and styling */
  .container {
    width: 100%;
  }

  .header {
    background-color: #991b1b;
    /* bg-red-800 */
    padding: 20px;
    /* p-5 */
    width: 100%;
    /* w-screen */
  }

  .header-logo {
    width: auto;
    /* w-auto */
    height: 80px;
    /* h-20 */
  }

  .welcome-text {
    font-size: 1.875rem;
    /* text-3xl */
    color: #047857;
    /* text-green-700 */
    font-weight: 700;
    /* font-bold */
    text-align: center;
    /* text-center */
    margin-top: 16px;
  }

  .login-form {
    background-color: #94a3b8;
    /* bg-slate-400 */
    box-shadow: 0px 10px 15px -3px rgba(0, 0, 0, 0.1),
      0px 4px 6px -2px rgba(0, 0, 0, 0.05);
    /* shadow-lg */
    border-radius: 10px;
    /* rounded-lg */
    padding: 40px;
    /* p-10 */
    display: grid;
    /* grid */
    gap: 16px;
    /* gap-4 */
    place-items: center;
    /* place-items-center */
    height: 50%;
    /* h-4/6 */
    width: 25%;
    /* w-1/4 */
    position: absolute;
    /* absolute */
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);

    background-color: #ffffff;
    padding: 20px 30px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border-radius: 10px;
    width: 100%;
    max-width: 400px;
    text-align: center;
  }

  .login-form h1 {
    margin-bottom: 20px;
    font-size: 24px;
    color: #333333;
  }

  .login-form input[type="text"],
  .login-form input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
  }

  .login-form button {
    width: 100%;
    padding: 10px;
    background-color: #991b1b;
    border: none;
    color: #ffffff;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
  }

  .login-form button:hover {
    background-color: #7c1616;
  }

  .login-form p {
    margin-top: 15px;
    font-size: 14px;
    color: #666;
  }

  .bad {
    color: #d9534f;
    /* Rojo para indicar error */
    background-color: #f8d7da;
    /* Fondo rojo claro */
    border: 2px solid #f5c6cb;
    /* Borde que combina con el fondo */
    padding: 15px;
    border-radius: 8px;
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    /* Sombras para resaltar */
  }

  .form-title {
    font-size: 1.25rem;
    /* text-1xl */
    text-align: center;
    /* text-center */
    margin-bottom: 24px;
    /* mb-6 */
  }

  .form-label {
    display: block;
    padding: 10px;
  }

  .input-field {
    width: 100%;
    padding: 8px;
    border: 1px solid #d1d5db;
    /* Default border color */
    border-radius: 4px;
  }

  .next-page-link {
    text-decoration: none;
    color: #1d4ed8;
    /* Blue link color */
  }

  /* Menu Styles */
  .menu {
    width: 100%;
    /* w-screen */
  }

  .menu-list {
    display: grid;
    /* grid */
    grid-template-columns: repeat(5, 1fr);
    /* grid-cols-5 */
    background-color: #2d3748;
    /* bg-gray-800 */
    padding: 16px;
    /* p-4 */
    list-style: none;
    gap: 16px;
    /* gap-4 */
    text-align: center;
    /* text-center */
    font-weight: bold;
    /* font-bold */
    color: white;
    /* text-white */
  }

  .menu-link {
    text-decoration: none;
    color: inherit;
    transition: color 0.3s ease, background-color 0.3s ease;
    padding: 8px;
    border-radius: 4px;
  }

  .menu-link:hover {
    color: #edf2f7;
    /* Lighter white on hover */
    background-color: #4a5568;
    /* Slightly lighter gray on hover */
  }
</style>