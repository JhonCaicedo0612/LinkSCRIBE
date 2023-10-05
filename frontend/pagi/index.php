
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UFT-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Y Registro</title>
        <link rel="stylesheet" href="assests\CSS\estilos.css">
    </head>
    <body>

        <main>

            <div class="contenedor__todo">
                <div class="caja__trasera">
                    <div class="caja__trasera-login">
                        <h3>¿Ya tienes una cuenta?</h3>
                        <p>Inicia sesion para entrar en la pagina</p>
                        <button id="btn__iniciar-sesion">Iniciar Sesion</button>
                    </div>
                    <div class="caja__trasera-Register">
                        <h3>¿Aun no tienes una cuenta?</h3>
                        <p>Registrate para que puedas iniciar sesion</p>
                        <button id="btn__registrarse">Registrarse</button>
                    </div>
                </div>
                <!--Formulario de Login y Registro-->
                <div class="contenedor__login-register">
                    <!--Formulario de Login-->
                    <form action="php/login_usuario_be.php" class="formulario__login" method="POST">

                        <h2>Iniciar Sesion</h2>
                        <input type="text" placeholder="Usuario" name="usuario">
                        <input type="password" placeholder="password" name="password">
                        <button>Entrar</button>

                    </form>

                    <form action="php/registro_usuario_be.php" method="POST" class="formulario__register" >
                        <h2>registrarse</h2>
                        <input type="text" placeholder="Nombre" name="nombre">
                        <input type="text" placeholder="Usuario" name="usuario">
                        <input type="text" placeholder="Correo" name="correo">
                        <input type="password" placeholder="Contraseña" name="password">
                        <button>Registrarse</button>
                    </form>

                </div>
            </div>

        </main>
        <script src="assests\js\script.js"></script>

    </body>
</html>