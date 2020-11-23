<?php

$instalacion = $data['instalacion'];

echo "<h1>Modificar Instalacion</h1>";
echo "<form action = 'index.php' method = 'get'>
        <input type='hidden' name='id' value='$instalacion->id'>
        Nombre:<input type='text' name='nombre' value='$instalacion->nombre'><br>
        Descripcion:<input type='text' name='descripcion' value='$instalacion->apellido1'><br>
        Precio:<input type='text' name='precio' value='$instalacion->dni'><br>
        Imagen:<input type='file' name='imagen' value='$instalacion->imagen'><br>";
    echo "<input type='hidden' name='action' value='modificarInstalacion'>
          <input type='submit'>
    </form>";
echo "<p><a href='index.php?action=mostrarInstalacion'>Volver</a></p>";
?>