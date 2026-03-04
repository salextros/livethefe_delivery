<?php
include("admin/bd.php");

$sentencia = $conexion->prepare("SELECT * FROM tbl_banners ORDER BY id DESC limit 1 ");
$sentencia->execute();
$lista_banners = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$sentencia = $conexion->prepare("SELECT * FROM tbl_colaboradores ORDER BY id DESC limit 3 ");
$sentencia->execute();
$lista_colaboradores = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$sentencia = $conexion->prepare("SELECT * FROM tbl_testimonios ORDER BY id DESC limit 2 ");
$sentencia->execute();
$lista_testimonios = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$sentencia = $conexion->prepare("SELECT * FROM tbl_menu ORDER BY id DESC limit 4 ");
$sentencia->execute();
$lista_menu = $sentencia->fetchAll(PDO::FETCH_ASSOC);

if($_POST){
     

        $nombre=strip_tags($_POST["nombre"]);
        $correo=filter_var($_POST["correo"], FILTER_SANITIZE_EMAIL);
        $mensaje=strip_tags($_POST["mensaje"]);

        if($nombre && $correo && $mensaje){
            
            $sql="INSERT INTO 
            tbl_comentarios (nombre, correo, mensaje) 
            VALUES(:nombre, :correo, :mensaje)";

            $resultados=$conexion->prepare($sql);
            $resultados->bindParam(":nombre", $nombre, PDO::PARAM_STR);
            $resultados->bindParam(":correo", $correo, PDO::PARAM_STR);
            $resultados->bindParam(":mensaje", $mensaje, PDO::PARAM_STR);
            $resultados->execute();
}
header("Location:index.php");
        }

?>

<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        crossorigin="anonymous"
        referrerpolicy="no-referrer" />

<!-- Fuente (Google Fonts) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;800&display=swap" rel="stylesheet">

<!-- Estilos del proyecto -->
<link rel="stylesheet" href="style.css">

</head>

<body>

  <!-- SECCION DE MENÚ NAVEGACIÓN -->

    <nav id="inicio" class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
        <a class="navbar-brand" href="#"> <i class="fas fa-seedling"></i> LivetheFe </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="nav navbar-nav ms-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="#inicio">Inicio</a>
                    </li>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#menu">Productos Destacados</a>
                    </li>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#chefs">Nuestro equipo</a>
                    </li>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimonio">Testimonios de Nuestros Clientes</a>
                    </li>

                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contacto">Contacto</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="#horario">Horarios</a>
                    </li>
                  <li class="nav-item ms-2">
  <a class="btn btn-outline-light btn-sm" href="admin/login.php">
    <i class="fas fa-user-shield"></i> Admin
  </a>
</li>

                </ul>
            </div>
        </div>
        </nav>

  <!-- SECCION DEL BANNER -->

    <section  class="container-fluid p-0">
        <div class="banner-img" style="position:relative; background:url('images/cannabis.jpg') center/cover no-repeat; height: 700px;">

            <div class="banner-text" style="position: absolute; top:50%; left:50%; transform: translate(-50%, -50%); color:#fff;text-align:center; font-family: 'Poppins', sans-serif;">

            <?php foreach($lista_banners as $banner) {
            ?>    

                <h1><?php echo $banner["titulo"];?></h1>
                <p><?php echo $banner["descripcion"];?></p>
                <a href="<?php echo $banner["link"];?>" class="btn btn-primary">Ver Menú</a>
            <?php } ?>
                
            </div>
        </div>
    </section>

    <section id="id" class="container mt-4 text-center">

        <div class="jumbotron bg-dark text-white">

            <br />
            <h2>¡Bienvenid@ a LiveTheFe!</h2>
            <p>Prototipo educativo para control y trazabilidad</p>
             <p>(lotes, etapas y bitácora con evidencias)</p>
            <br />
        </div>
    </section>

    <!-- SECCION DE CHEFST -->

    <section id="chefs" class="container mt-4 text-center">
        <h2>Nuestro Equipo</h2>
        <div class="row">


        <!-- ==================================================================================================================================== -->
            <?php foreach($lista_colaboradores as $colaborador) { ?>

            <div class="col-md-4"><!-- INICIO_1 -->
                <div class="card">
                    <img src="images/colaboradores/<?php echo $colaborador["foto"];?>"
                        class="card-img-top"
                        alt="Chef 1" />

                    <div class="card-body">
                        <h5 class="card-title"><?php echo $colaborador["titulo"];?></h5>
                        <p class="card-text"><?php echo $colaborador["descripcion"];?></p>
                        <div class="social-icons mt-3">
                            <a href="<?php echo $colaborador["linkfacebook"];?>" class="text-dark m-2"><i class="fab fa-facebook"></i></a>
                            <a href="<?php echo $colaborador["linkinstagram"];?>" class="text-dark m-2"><i class="fab fa-instagram"></i></a>
                            <a href="<?php echo $colaborador["linklinkedin"];?>" class="text-dark m-2"><i class="fab fa-linkedin"></i></a>
                        </div>
                    </div>
                </div>
            </div><!-- FINAL_1 -->

            <?php } ?>
        <!-- ==================================================================================================================================== -->
        </div>
    </section>

    <!-- SECCION DE TESTIMONIO -->

    <section id="testimonio" class="bg-light py-5">
        <div class="container">
            <h2 class="tex-center mb-4"> Testimonios de Nuestros Clientes </h2>

            <div class="row">
               
                <?php foreach($lista_testimonios as $testimonio) { ?>
                
                <div class="col-md-6 d-flex">
                    <div class="card mb-4 w-100">
                        <div class="card-body">
                            <p class="card-text"> <?php echo $testimonio["opinion"];?> </p>
                        </div>
                        <div class="card-footer text-muted">
                            <?php echo $testimonio["nombre"];?> 
                        </div>
                    </div>
                </div>

                <?php } ?>

            </div>
        </div>
    </section>

    <!-- SECCION DEL MENU COMIDA -->

    <section id="menu" class="container mt-4">
        <h2 class="text-center"> Productos Destacados </h2>
        <br />
        <div class="row row-cols-1 row-cols-md-4 g-4">

        <?php foreach($lista_menu as $registro) { ?>
            <div class="col d-flex">
                <div class="card">
                    <img src="images/menu/<?php echo $registro["foto"];?>" alt="Tortillas de maiz con carne y frijoles negros" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title"> <?php echo $registro["nombre"];?> </h5>
                        <p class="card-text small"><strong><?php echo $registro["ingredientes"];?></strong></p>
                        <p class="card-text"><strong> Precio: </strong><?php echo $registro["precio"];?> </p>
                    </div>
                </div>
            </div>
        <?php } ?>
                 
        </div>
    </section>
    <br />
    <br />

    <!-- SECCION DE CONTACTO -->

    <section id="contacto" class="container mt-4">
    
    <h2>Contacto</h2>
    <p>Si tienes alguna pregunta o deseas hacer una reserva, no dudes en contactarnos.</p>

    <form action="?" method="post">

    <div class="mb-3">
        <label for="name">Nombre:</label><br>
        <input type="text" class="form-control" name="nombre" placeholder="Escribe tu nombre..." required><br />
    </div>

    <div class="mb-3">
      <label for="email">Correo Electrónico:</label><br />
      <input type="email" class="form-control" name="correo" placeholder="Escribe tu correo..." required><br />
    </div>  

    <div class="mb-3">
      <label for="message">Mensaje:</label><br />
      <textarea id="message" class="form-control"  name="mensaje" rows="6"  cols="50"></textarea><br />
    </div>
      <input type="submit" class="btn btn-primary" value="Enviar mensaje">

    </form>

    </section>
    <br /><br />

    <!-- SECCION DE HORARIO -->
    <div id="horario" class="text-center bg-light p-4">
        <h3 class="mb-4">Horario de atención</h3>

        <div>
            <p> <strong> Lunes a Viernes</strong> </p>
            <p> <strong> 11:00 a.m - 10:00 p.m. </strong></p>
        </div>

           <div>
            <p> <strong> Sábado</strong> </p>
            <p> <strong> 12:00 p.m - 5:00 p.m. </strong></p>
        </div>

        <div>
            <p> <strong>Domingo</strong> </p>
            <p> <strong> 7:00 a.m - 2:00 p.m. </strong></p>
        </div>

    </div>


    <footer class="bg-dark text-white text-center py-3">
        <!-- place footer here -->

        <p> &copy; 2026 LivetheFe, todos los derechos reservados.</p>

    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>