<?php
require_once "../database/database.php";
session_start();


if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'ADMIN') {

    header("Location: ../index.php");
    exit();
}

$user_id = $_SESSION['id'];

$sql = "SELECT  nombre, apellido FROM usuarios WHERE user_id = '$user_id'";


$result = mysqli_query($conexion, $sql);


if (!$result) {
    die("Error en la consulta: " . mysqli_error($conexion));
}


$row = mysqli_fetch_assoc($result);


if ($row) {


    $nombre = $row['nombre'];
    $apellido = $row['apellido'];
} else {
    echo "No se encontraron datos para el usuario con el ID proporcionado.";
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
    <title>Universidad | Admin Clases</title>

    <style>
        .custom-table {
            border-collapse: collapse;
            width: 100%;

        }

        .scrollable-container {

            overflow: auto;
            max-height: 800px;
        }
    </style>
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
                    <h1 class="font-bold text-zinc-700 text-xl ">Lista de Clases</h1>
                    <p class="font-semibold text-sm text-zinc-700"><span class="text-myblue">Home</span> / Clases
                    </p>
                </div>

                <div class="w-full flex items-center justify-between mb-3 pr-3">
                    <span class="font-semibold text-zinc-700">Información de Clases</span>
                    <a href="create_clases.php"><button class="text-white font-semibold p-2 px-3 bg-blue-500 rounded-md self-end">
                            Agregar Clase
                        </button></a>


                </div>

                <div class="scrollable-container">
                    <table class="custom-table w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    #
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Clase
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Maestro
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Alumnos Inscritos
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Acciones
                                </th>
                            </tr>
                        </thead>
                        <tbody>


                            <?php


                            $consulta = "SELECT m.nombre, m.id_materia, CONCAT(u.nombre, ' ', u.apellido) AS profesor, COUNT(mi.id_alumno) AS num_alumnos FROM materias m
                            LEFT JOIN usuarios u ON m.id_materia = u.materia_asignada AND u.rol = 'MAESTRO'
                            LEFT JOIN materias_inscritas mi ON m.id_materia = mi.id_materia
                            GROUP BY m.nombre, u.nombre";
                            $resultado = $conexion->query($consulta);


                            if ($resultado->num_rows > 0) {


                                $contador = 1;
                                while ($row = $resultado->fetch_assoc()) {

                                    echo '<tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
        <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">' . $contador . '</td>
        <td class="px-6 py-4">' . $row['nombre'] . '</td>
        <td class="px-6 py-4">' . $row['profesor'] . '</td>
        <td class="px-6 py-4">' . $row['num_alumnos'] . '</td>
        <td class="px-6 py-4 flex gap-5 items-center">
            <a href="edit_clases.php?id=' . $row['id_materia'] . '" class="font-medium text-blue-600 dark:text-blue-500 ">
                <span class="material-symbols-outlined">
                    edit_square
                </span>
            </a>
            <a href="delete_clases.php?id=' . $row['id_materia'] . '" class="font-medium" class="font-medium">
                <span class="material-symbols-outlined" style="color: #Dc2f19;">
                    delete
                </span>
            </a>
        </td>
      </tr>';
                                    $contador++;
                                }
                            } else {
                                echo "No hay materias disponibles.";
                            }


                            $conexion->close();
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

    <script src="../index.js"></script>
</body>

</html>