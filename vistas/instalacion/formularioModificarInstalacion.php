<?php

$instalacion = $data['instalacion'];

echo "<h1>Modificar Instalacion</h1>";
echo "<form action = 'index.php'method = 'POST' enctype='multipart/form-data'>
        <input type='hidden' name='id' value='$instalacion->id'>
        Nombre:<input type='text' name='nombre' value='$instalacion->nombre'><br>
        Descripcion:<input type='text' name='descripcion' value='$instalacion->descripcion'><br>
        Precio:<input type='text' name='precio' value='$instalacion->precio'>€ por hora<br>
        Imagen:<input type='file' name='imagen' value='$instalacion->imagen'><br>";
    echo "<input type='hidden' name='action' value='modificarInstalacion'>
          <input type='submit'>
    </form>";
echo "<p><a href='index.php?action=mostrarInstalaciones'>Volver</a></p>";
?>