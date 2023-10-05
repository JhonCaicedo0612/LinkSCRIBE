<?php
    require '../php/conexion_be.php';
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
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Consultas</title>
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
                <a href="soliApi.php">
                    <button>url extractor</button>
                </a>

                <button> <?php
                echo 'USUARIO '.$_SESSION['usuario'];
                ?>
                </button>   
            </div>
            <div class="consulta">
                <h1>Consulta tus listas</h1>
                <form method="post" action="">
                    <label for="texto">Categoria</label>
                    <select name="categoria" >
                    <option value=""></option>
                    <option value="Adult">Adult</option>
                    <option value="Business/Corporate">Business/Corporate</option>
                    <option value="Computers and Technology">Computers and Technology</option>
                    <option value="E-Commerce">E-Commerce</option>
                    <option value="Education">Education</option>
                    <option value="Food">Food</option>
                    <option value="Forums">Forums</option>
                    <option value="Games">Games</option>
                    <option value="Health and Fitness">Health and Fitness</option>
                    <option value="Law and Government">Law and Government</option>
                    <option value="News">News</option>
                    <option value="Photography">Photography</option>
                    <option value="Social Networking and Messaging">Social Networking and Messaging</option>
                    <option value="Sports">Sports</option>
                    <option value="Streaming Services">Streaming Services</option>
                    <option value="Travel">Travel</option>
                    </select>
                    <label for="texto">Fecha Inicial</label>
                    <input type="date" name="inicial" value=""/>
                    <label for="texto">Fecha Final</label>
                    <input type="date" name="final" value=""/>
                    <input type="submit" name="Consultar" value="Consultar">
                </form>
                <table border="1">
                    <tr>
                        <th>URL</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th>Categoría</th>
                        <th>Imagen</th>
                        <th>Fecha</th>
                    </tr>
                    <?php
                        if (isset($_POST['Consultar'] )){
                            $texto = $_POST["categoria"];
                            $usuario = $_SESSION['usuario'];
                            $inicial = $_POST['inicial'];
                            $final = $_POST['final'];
                            if ($inicial != "" && $final!=""){
                                if ($inicial > $final){
                                    echo "La fecha inicial no puede ser menor que la final";
                                    exit();
                                }}
                            // Consulta SQL para obtener los datos
                            $query = "SELECT URL, Titulo, Descripcion, Categoria, Imagen, Fecha FROM listaurls WHERE usuario = '$usuario'";
                            if ($texto !=""){
                                $query.="AND categoria = '$texto'";
                            }

                            if ($inicial != ""){
                                $query.="AND Fecha >= '$inicial 00:00:00'";

                            }
                            if ($final != ""){
                                $query.="AND Fecha <= '$final 23:59:59'";
                            }
                            $result = mysqli_query($conexion, $query);

                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["URL"] . "</td>";
                                    echo "<td>" . $row["Titulo"] . "</td>";
                                    echo "<td>" . $row["Descripcion"] . "</td>";
                                    echo "<td>" . $row["Categoria"] . "</td>";
                                    echo "<td><img src='" . $row["Imagen"] . "' alt='Imagen'width='50'></td>";
                                    echo "<td>". $row["Fecha"]. "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "No se encontraron resultados.";
                            }
                        }
                    ?>
                </table>
            </div>
        </div>
    </body>
</html>