<?php
require_once '../database/database.php';
session_start();

if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'ADMIN') {
    header("Location: ../index.php");
    exit();
}


$user_id = $_SESSION['id'];

$sql = "SELECT  nombre, apellido, correo_electronico, contrasena, direccion, fecha_nacimiento FROM usuarios WHERE user_id = '$user_id'";


$result = mysqli_query($conexion, $sql);


if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}


$row = mysqli_fetch_assoc($result);


if ($row) {


    $nombre = $row['nombre'];
    $apellido = $row['apellido'];
    $correo = $row['correo_electronico'];
    $contrasena = $row['contrasena'];
    $direccion = $row['direccion'];
    $fecha = $row['fecha_nacimiento'];
} else {
    echo "No se encontraron datos para el usuario con el ID proporcionado.";
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $idUsuario = $_SESSION['id'];
    $nuevoEmail = $_POST['email'];
    $nuevoNombre = $_POST['nombre'];
    $nuevoApellido = $_POST['apellido'];
    $nuevaContrasena = $_POST['contrasena'];
    $nuevaDireccion = $_POST['direccion'];
    $nuevaFechaNacimiento = $_POST['fecha_nacimiento'];

    $sql = "UPDATE usuarios SET correo_electronico='$nuevoEmail', nombre='$nuevoNombre', apellido='$nuevoApellido', contrasena='$nuevaContrasena', direccion='$nuevaDireccion', fecha_nacimiento='$nuevaFechaNacimiento' WHERE user_id='$idUsuario'";

    if (mysqli_query($conexion, $sql)) {
        header("Location: admin_profile.php");
    } else {
        echo "Error al actualizar los datos: " . mysqli_error($conexion);
    }


    mysqli_close($conexion);
}


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@48,400,1,0" />
    <link rel="icon" href="../assets/logo.jpg">
    <link rel="stylesheet" href="../styles.css">
    <title>Universidad | Admin Edit Profile</title>
</head>

<body>
    <div class="w-screen h-screen flex bg-lightgray">
        <aside class="w-80 h-full bg-dark">
            <div class="flex items-center gap-3 p-5">
                <img class="rounded-full" src="../assets/logo-aside.jpg" alt="university-logo" width="50px" height="60px">
                <span class="text-white font-medium">Universidad</span>
            </div>

            <div style="width: 100%; height: 1px; background-color: #4c5157; "></div>

            <div class="text-white flex flex-col p-5 gap-3">
                <span style="font-size: 20px;"><?php echo $nombre . ' ' . $apellido; ?></span>
                <span>Administrador</span>
            </div>
            <div style="width: 100%; height: 1px; background-color: #4c5157; "></div>

            <div class="text-white flex flex-col gap-5 p-5">
                <p>Menu Administración</p>

                <div>
                    <a href="admin_permisos.php" class="flex items-center gap-3 ">
                        <span class="material-symbols-outlined ">
                            folder_supervised
                        </span>
                        <span>Permisos</span>
                    </a>
                </div>

                <div>
                    <a href="admin_maestros.php" class="flex items-center gap-3 ">
                        <span class="material-symbols-outlined">
                            interactive_space
                        </span>
                        <span>Maestros</span>
                    </a>
                </div>

                <div>
                    <a href="admin_alumnos.php" class="flex items-center gap-3 ">
                        <span class="material-symbols-outlined">
                            school
                        </span>

                        <span>Alumnos</span>
                    </a>
                </div>

                <div>
                    <a href="admin_clases.php" class="flex items-center gap-3 ">
                        <span class="material-symbols-outlined">
                            tv_gen
                        </span>
                        <span>Clases</span>
                    </a>
                </div>
            </div>
        </aside>
        <div class="w-full flex flex-col">
            <header class="w-full flex items-center justify-between h-10 p-5 bg-white shadow-sm">

                <div class="flex items-center gap-5">
                    <span class="material-symbols-outlined text-zinc-800">
                        menu
                    </span>
                    <a href="admin_dashboard.php"><span class="text-zinc-800 ">
                            Home
                        </span></a>
                </div>

                <nav>
                    <li class="flex items-center gap-2 text-zinc-800 cursor-pointer" onclick="toggleLogoutMenu()">

                        <?php echo $nombre ?>
                        <ul class="flex flex-col">
                            <span class="material-symbols-outlined">
                                expand_more
                            </span>
                            <ul id="logout-menu" class="hidden absolute bg-white right-0 mt-6 py-2 px-4 rounded shadow">

                                <a href="admin_profile.php" class="flex items-center gap-2 hover:bg-zinc-200">
                                    <span class="material-symbols-outlined">
                                        account_circle
                                    </span>
                                    <li class="px-2 py-2 text-zinc-700 cursor-pointer ">Profile</li>
                                </a>

                                <a href="../logout.php" class="flex items-center gap-2 hover:bg-zinc-200" style="color: #Dc2f19;">
                                    <span class="material-symbols-outlined">
                                        logout
                                    </span>
                                    <li class="px-2 py-2 text-zinc-700 cursor-pointer " style="color: #Dc2f19;">Logout
                                    </li>

                                </a>


                            </ul>
                    </li>
                    </ul>
                </nav>
            </header>

            <div class="h-full pl-3">
                <div class="w-full flex items-center justify-between pr-3 mt-4 mb-5">
                    <h1 class="font-bold text-zinc-700 text-xl ">Admin Edit Profile</h1>
                    <p class="font-semibold text-sm text-zinc-700"><span class="text-myblue">Home</span> / Profile
                    </p>
                </div>

                <div class="w-full">
                    <a href="admin_profile.php">
                        <span class="material-symbols-outlined">
                            arrow_back
                        </span>
                    </a>
                </div>

                <div class="w-full flex flex-row justify-center  mt-20">
                    <div class="w-80 h-auto bg-white rounded-sm sm:w-96">

                        <div class="w-80 h-auto bg-white rounded-sm sm:w-96">

                            <form action="admin_edit_profile.php" method="post" class="flex flex-col p-5 gap-5 text-center relative z-20">



                                <div class="flex flex-col">
                                    <span class="font-bold text-zinc-700 self-start">Nueva Contraseña</span>
                                    <input value="<?php echo $contrasena; ?>" name="contrasena" required type="password" placeholder="Ingresa nueva contraseña" class="h-10 border border-zinc-300 bg-white rounded-sm px-3">
                                </div>

                                <div class="flex flex-col">
                                    <span class="font-bold text-zinc-700 self-start">Email</span>
                                    <input value="<?php echo $correo; ?>" name="email" required type="email" placeholder="Ingresa Email" class="h-10 border border-zinc-300 bg-white rounded-sm px-3">
                                </div>

                                <div class="flex flex-col">
                                    <span class="font-bold text-zinc-700 self-start">Nombre(s)</span>
                                    <input value="<?php echo $nombre; ?>" name="nombre" type="text" placeholder="Ingresa Nombre" class="h-10 border border-zinc-300 bg-white rounded-sm px-3">
                                </div>

                                <div class="flex flex-col">
                                    <span class="font-bold text-zinc-700 self-start">Apellido(s)</span>
                                    <input value="<?php echo $apellido; ?>" name="apellido" type="text" placeholder="Ingresa Apellido" class="h-10 border border-zinc-300 bg-white rounded-sm px-3">
                                </div>

                                <div class="flex flex-col">
                                    <span class="font-bold text-zinc-700 self-start">Dirección</span>
                                    <input value="<?php echo $direccion; ?>" name="direccion" type="text" placeholder="Ingresa Dirección" class="h-10 border border-zinc-300 bg-white rounded-sm px-3">
                                </div>

                                <div class="flex flex-col">
                                    <span class="font-bold text-zinc-700 self-start">Fec. de Nacimiento</span>
                                    <input value="<?php echo $fecha; ?>" name="fecha_nacimiento" type="date" class="h-10 border border-zinc-300 bg-white rounded-sm px-3">
                                </div>

                                <div style="height: 1px; background-color: #e5e7eb; width: 100% ; "></div>
                                <input type="submit" value="Guardar cambios" class="text-white font-semibold p-2 px-3 bg-blue-500 rounded-md self-end">
                            </form>
                        </div>
                    </div>
                </div>
            </div>


        </div>

    </div>

    <script src="../index.js"></script>
</body>

</html>