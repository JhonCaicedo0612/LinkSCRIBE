<?php

    include 'conexion_be.php';

    $nombre = $_POST['nombre'];
    $usuario = $_POST['usuario'];
    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $query = "INSERT INTO usuarios(nombre, usuario, correo, password)
                VALUES ('$nombre','$usuario','$correo','$password')";

    //Verificar que no se repita en la base de datos 

    $verificar_usuario = mysqli_query($conexion,"SELECT * FROM usuarios WHERE usuario ='$usuario'");

    if(mysqli_num_rows($verificar_usuario) > 0){
        echo '
        <script>
                alert("El usuario ya esta registrado, intenta con otro difenrente);
                window.location ="../index.php";
            </script>
        ';
        exit();
        mysqli_close($conexion);
    }

    $ejecutar = mysqli_query($conexion, $query);

    if($ejecutar){
        echo '
            <script>
                alert("Usuario registrado correctamente");
                window.location ="../index.php";
            </script>
            ';
    }else{
        echo '
            <script>
                alert("El usuario no se pudo registrar");
                window.location ="../index.php";
            </script>
            ';

    }
    mysqli_close($conexion);
?>