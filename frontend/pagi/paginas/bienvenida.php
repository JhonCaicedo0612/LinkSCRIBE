<?php

    session_start();

    if(!isset($_SESSION['usuario'])){
        echo '
            <script>
                alert("Debe iniciar sesion primero");
                window.location = "../index.php";
            </script>
        ';

        session_destroy();
        die();
    }
    $_SESSION['texto'] = "";
    
    
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>bienvenida</title>
        <link rel="stylesheet" href="../assests/CSS/estilospag.css">
    </head>
    <body>
        <div class="contenedor">
            
            <div class="barra">
                <a href="../php/cerrar.php">
                    <button>logout</button>
                </a>
                <a href="soliApi.php">
                    <button>url extractor</button>
                </a>
                <a href="consultas.php">
                    <button>Consultas</button>
                </a>

                <button> <?php
                echo 'USUARIO '.$_SESSION['usuario'];
                ?>
                </button>   
            </div>

            <div class="direccionador">
                <h1>Bienvenido a linkscribe</h1>
               <p>LinkScribe es una aplicación web utiliza NLP para permitir a los usuarios crear y organizar listas de
                 enlaces de forma fácil y eficiente Con LinkScribe, los
                    simplemente copiando y pegar un enlace web, y la aplicación lo procesará
                    automáticamente, extrayendo información sobre el contenido de la página y clasificándolos de
                    acuerdo a la información obtenida. 
                </p>
                <p>
                    Tendras la opcion de poder guardar el enlace en tu lista personal o simplemete buscar otro, tambien puedes consultar los enlaces que has guardado con anterioridad

                   
                    

               </p>
            </div>
        </div>
        
    </body>
</html>