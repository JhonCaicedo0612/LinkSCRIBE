<?php
    session_start();
    require '../php/conexion_be.php';
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

?>
<!DOCTYPE html>
<html>
<head>
    <title>Enviar solicitud a la API</title>
    <link rel="stylesheet" href="../assests/CSS/estilospag.css">
</head>
<body>
<div class="contenedor">
            
            <div class="barra">
                <a href="../php/cerrar.php">
                    <button>logout</button>
                </a>
                <a href="bienvenida.php">
                    <button>Inicio</button>
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
            <h1>Enviar solicitud a la API</h1>

            <form method="post" action="">
                <label for="texto">URL :</label>
                <input type="text" id="texto" name="texto">
                <input type="submit" name="API" value="Enviar">
                <input type="submit" name="Almacenar" value="Almacenar">
            </form>

            <div class="resultados">

                <?php

                    
                    
                        
                    if ( isset($_POST['API']) && $_POST["texto"] != "") {
                        // Obtén el texto ingresado por el usuario
                        $texto = $_POST["texto"];
                        
                        $_SESSION['texto'] = $texto;
                        

                        // Datos JSON que deseas enviar a la API
                        $data = array(
                            "linkresi" => $texto
                        );

                        // Convierte los datos a formato JSON
                        $jsonData = json_encode($data);

                        // URL de la API
                        $miVariable = getenv("API_ENDPOINT");
                        if ($miVariable !== false) {
                            $url = $miVariable;
                        }
                        else{
                        $url = "http://localhost:8080/predit"; // Reemplaza con la URL de tu API
                        }

                        // Configura la solicitud CURL
                        $curl = curl_init($url);
                        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                        curl_setopt($curl, CURLOPT_POSTFIELDS, $jsonData);
                        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
                            'Content-Type: application/json',
                            'Content-Length: ' . strlen($jsonData)
                        ));

                        // Ejecuta la solicitud y obtén la respuesta
                        $response = curl_exec($curl);
                        

                        // Cierra la conexión CURL
                        curl_close($curl);

                        // Procesa la respuesta de la API (puede variar según la API)
                        if ($response) {
                            $_SESSION['utlresp']= $response;
                            $responseData = json_decode($response, true);
                            if ($responseData) {
                                // Procesa la respuesta JSON de la API
                               
                                echo "<table border='1'>";
                                echo "<tr><th>URL</th><th>Título</th><th>Descripción</th><th>Categoría</th><th>Imagen</th></tr>";
                                echo "<tr>";
                                echo "<td>" . $responseData["URL"] . "</td>";
                                echo "<td>" . $responseData["Titulo"] . "</td>";
                                echo "<td>" . $responseData["Descripcion"] . "</td>";
                                echo "<td>" . $responseData["Categoria"] . "</td>";
                                echo "<td><img src='" . $responseData["imagen"] . "' alt='Imagen' width='50'></td>";
                                echo "</tr>";
                                echo "</table>";
                            } else {
                                echo "Error al decodificar la respuesta JSON.";
                            }
                        } else {
                            echo "Error al realizar la solicitud a la API.";
                        }
                    }
                    if ($_SESSION['texto'] !=""){
                        $re = $_SESSION['utlresp'];
                        if (isset($_POST['Almacenar']) && $re != ""){

                            $responseData = json_decode($_SESSION['utlresp'], true);
                            $url = $responseData["URL"];
                            $Titulo = $responseData["Titulo"];
                            $Descripcion = $responseData["Descripcion"];
                            $Categoria = $responseData["Categoria"];
                            $img = $responseData["imagen"];

                            $usuario = $_SESSION['usuario'];
                            date_default_timezone_set('america/bogota');

                            $fechaActual = date("Y-m-d h:i:s");

                            $query = "INSERT INTO listaurls(usuario,URL, Titulo, Descripcion, Categoria, Imagen,Fecha)
                                    VALUES ('$usuario','$url','$Titulo','$Descripcion','$Categoria','$img','$fechaActual')";

                            
                            $verificar_url = mysqli_query($conexion,"SELECT * FROM listaurls WHERE usuario ='$usuario' AND URL = '$url' ");

                            if(mysqli_num_rows($verificar_url) > 0){
                                echo '
                                    <script>
                                        alert("La url ya se encuentra almacenada");
                                        window.location ="";
                                    </script>
                                    ';
                                
                                mysqli_close($conexion);
                            }else{
                            $ejecutar = mysqli_query($conexion, $query);

                            if($ejecutar){
                                echo '
                                    <script>
                                        alert("La url se almaceno con exito");
                                        window.location ="";
                                    </script>
                                    ';
                            }else{
                                echo '
                                    <script>
                                        alert("La url no se pudo almacenar");
                                        window.location ="";
                                    </script>
                                    ';
                        
                            }
                            mysqli_close($conexion);
                            }

                            

                        }
                    }
                ?>
            </div>
        </div>
    </div>
</body>
</html>