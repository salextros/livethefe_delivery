<?php
include ("../../bd.php");

if($_POST){
    //Recolectamos los datos del metodo POST
    $usuario = (isset($_POST["usuario"])?$_POST["usuario"]:"");
    $password = (isset($_POST["password"])?$_POST["password"]:"");
    $password = md5($password);
    $correo = (isset($_POST["correo"])?$_POST["correo"]:"");

    //Preparar la insercion de los datos
    $sentencia = $conexion->prepare("INSERT INTO `tbl_usuarios` 
    (`ID`, `usuario`, `password`, `correo`) 
    VALUES (NULL, :usuario, :password, :correo);");

    //Asignando los valores que vienen del metodo POST
    $sentencia->bindParam(":usuario",$usuario);
    $sentencia->bindParam(":password",$password);
    $sentencia->bindParam(":correo",$correo);
    $sentencia->execute();

    header("Location:index.php");
}   


include ("../../templates/header.php");
?>
<br/>

<div class="card">
    <div class="card-header">Usuarios</div>
    <div class="card-body">

    <form action="" method="post">

        <div class="mb-3">
            <label for="usuario" class="form-label">Nombre de suario:</label>
            <input type="text"
              class="form-control" name="usuario" id="usuario" placeholder="Escribe el usuario"/>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password:</label>
            <input type="password"
              class="form-control" name="password" id="password"  placeholder="Escribe el password"/>
        </div>

        <div class="mb-3">
            <label for="correo" class="form-label">Correo:</label>
            <input type="email"
              class="form-control" name="correo" id="correo" placeholder="Escribe el correo"/>
        </div>

        <button type="submit" class="btn btn-success">Agregar usuario</button>
        <a name="" id="" class="btn btn-primary" href="index.php" role="button">Cancelar</a>
    </form>

    </div>
    <div class="card-footer text-muted"></div>
</div>



<?php
include ("../../templates/footer.php"); 
?>
