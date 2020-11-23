<script>
        function comprobarPasswd(){

                psswd1 = document.getElementbyId("psswd1").value;
                psswd2 = document.getElementbyId("psswd2").value;
                if(psswd1 != psswd2){
                        document.getElementById('mensajeUsuario').innerHTML = "Las contraseñas deben de ser iguales";
                        break;
                }
        }
</script>

<?php

$usuario = $data['usuario'];

echo "<h1>Modificar Usuario</h1>";
echo "<form action = 'index.php' method = 'get'>
        <input type='hidden' name='id' value='$usuario->id'>
        E-mail:<input type='email' name='email' value='$usuario->email'><br>
        Contraseña:<input type='password' name='password' id='psswd1''><br>
        Comprobar Contraseña:<input type='password' name='password' id='psswd2''><span id='mensajeUsuario'></span><br>
        Nombre:<input type='text' name='nombre' value='$usuario->nombre'><br>
        Primer Apellido:<input type='text' name='apellido1' value='$usuario->apellido1'><br>
        Segundo Apellido:<input type='text' name='apellido2' value='$usuario->apellido2'><br>
        DNI:<input type='text' name='dni' value='$usuario->dni'><br>
        Imagen:<input type='file' name='imagen' value='$usuario->imagen'><br>
        Tipo:"; if ($usuario->tipo ==  'admin'){
                echo "<select name='tipo'>
                        <option value='admin' selected >admin</option>
                        <option value='user'>user</option>
                </select><br><br>";
                }else{
                echo "<select name='tipo'>
                        <option value='admin'>admin</option>
                        <option value='user' selected >user</option>
                </select><br><br>";
                }
    echo "<input type='hidden' name='action' value='modificarUsuario' onclick='comprobarPasswd()'>
          <input type='submit'>
    </form>";
echo "<p><a href='index.php?action=mostrarUsuarios'>Volver</a></p>";
?>