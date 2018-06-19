<?php session_start();
	require 'admin/functions.php';
	$conexion = conect('sanluis');
	$categoria = (isset($_GET['cat']) && !is_numeric($_GET['cat'])) ? $_GET['cat'] : 'all';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>San Luis Publica</title>
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,700" rel="stylesheet"> 
	<link rel="stylesheet" type="text/css" href="styles/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="styles/styles.css">
</head>
<body>
	<header>
		<div class="mobile-menu">
			<div class="content">
				<h1>San Luis Publica</h1>
				<i class="fa fa-bars" aria-hidden="true" id='show-menu'></i>
			</div>
		</div>
		<div class="head">
			<img src="img/thumb.png">
			<div class="content">			
				<div class="nav">
					<nav id='menu'>
						<a href="#">Listado</a>
						<div class="categorias">
							<a href="#">Categorias</a>
							<i class="fa fa-sort-desc" aria-hidden="true"></i>
						</div>
						<a href="#" id='howto'>Como usar el sitio</a>
						<a href="#">Contacto</a>
					</nav>
				</div>
			</div>
			<div class="categories">
				<a href="?cat=all">Categoria1</a href="?cat=all">
				<a href="?cat=all">Categoria2</a href="?cat=all">
				<a href="?cat=all">Categoria3</a href="?cat=all">
				<a href="?cat=all">Categoria4</a href="?cat=all">
				<a href="?cat=all">Categoria5</a href="?cat=all">
				<a href="?cat=all">Categoria6</a href="?cat=all">
				<a href="?cat=all">Categoria7</a href="?cat=all">
				<a href="?cat=all">Categoria8</a href="?cat=all">
				<a href="?cat=all">Categoria9</a href="?cat=all">
				<a href="?cat=all">Categoria10</a href="?cat=all">
			</div>
		</div>
	</header>
	<section class="main">
		<div class="herramientas">
			<div class="content">
				<div class="menu">
					<h1>San Luis Publica</h1>
					<div class="menu-btns">
						<?php if(!isset($_SESSION['sl_user'])): ?>
							<div class="login" id='login'>
								<i class="fa fa-user" aria-hidden="true"></i>
								<p>Login</p>
							</div>
						<?php endif; ?>

						<?php if(isset($_SESSION['sl_user'])): ?>
							<div class="loged">
								<div class="loged-user">
									<i class="fa fa-user" aria-hidden="true"></i>
								</div>
								<div class="loged-arrow">
									<i class="fa fa-sort-desc" aria-hidden="true">	</i>
								</div>
							</div>
						<?php endif; ?>
						<div class="añadir">
							<i class="fa fa-plus" aria-hidden="true"></i>
						</div>
						<div class="buscar">
							<i class="fa fa-search" aria-hidden="true"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="search">
			<div class="content">
				<form action="">
					<input type="text" placeholder="Buscar">
					<input type="submit" value='Buscar'>
				</form>
			</div>
		</div>
		<div class="destacados">
			<div class="content">
				<div class="viewmore">
					<p>Ver más</p>
					<div class="vm-icon">
						<i class="fa fa-angle-right" aria-hidden="true"></i>
					</div>
				</div>
				<div class="titulo">
					<div class="border"></div>
					<div class="tit">Destacados</div>
					<div class="border"></div>
				</div>
				<div class="d-anuncios">

					<!-- Obteniendo anuncios desde la BD -->
						<?php if($categoria == 'all'){
							$statement = $conexion->prepare('SELECT * FROM anuncios WHERE estado = :estado');
							$statement->execute(array(':estado' => 'premium'));
							$resultados_d = $statement->fetchAll();
							}else{
								$statement = $conexion->prepare('SELECT * FROM anuncios WHERE categoria = :categoria AND estado = :estado');
								$statement->execute(array(
									':categoria' => $categoria,
									':estado' => 'premium'
								));
								$resultados_d = $statement->fetchAll();
							} 
						?>

					<!-- Mostrandolos en pantalla -->
						<?php foreach($resultados_d as $resultado): ?>

							<div class="anuncio">
								<img src="img/anuncios/<?php echo $resultado['thumb'] ?>" alt="<?php echo $resultado['titulo'] ?>" height="170" width="250">
								<div class="text">
									<p class="tit"><?php echo $resultado['titulo'] ?></p>
									<p class="info"><?php echo $resultado['descripcion'] ?></p>
								</div>
							</div>

						<?php endforeach; ?>
				</div>
			</div>
		</div>
		<div class="comunes">
			<div class="titulo">
					<div class="border"></div>
					<div class="tit">Comunes</div>
					<div class="border"></div>
			</div>
			<div class="commons">

				<!-- Obteniendo anuncios desde la BD -->
				<?php if($categoria == 'all'){
							$statement = $conexion->prepare('SELECT * FROM anuncios WHERE estado = :estado LIMIT 8');
							$statement->execute(array(':estado' => 'common'));
							$resultados_c = $statement->fetchAll();
						}else{
								$statement = $conexion->prepare('SELECT * FROM anuncios WHERE categoria = :categoria AND estado = :estado');
								$statement->execute(array(
									':categoria' => $categoria,
									':estado' => 'common'
								));
								$resultados_c = $statement->fetchAll();
							} 
				?>

				<!-- Mostrandolos en pantalla -->
				<?php foreach($resultados_c as $resultado): ?>

					<div class="common">
						<img src="img/anuncios/<?php echo $resultado['thumb'] ?>" alt="<?php echo $resultado['titulo'] ?>" width="150" height="200">
						<div class="desc">
							<div class="titulo">
								<p><?php echo $resultado['titulo'] ?></p>
						</div>
							<div class="info">
								<div class="fecha">
									<i class="fa fa-calendar" aria-hidden="true"></i>
									<p class="date"><?php echo $resultado['fecha'] ?></p>
								</div>
								<p class='if'><?php echo $resultado['descripcion'] ?></p>
								<div class="options">
									<div class="options"></div><div class="config"><i class="fa fa-cog" aria-hidden="true"></i></div>
									<div class="precio">
										<p>Precio: <span><?php echo $resultado['precio'] ?></span></p>
									</div>
								</div>
							</div>
						</div>
					</div>

				<?php endforeach; ?>
			</div>
		</div>
		<div class="comousar">
			<div class="titulo">
				<div class="border"></div>
				<div class="tit">
					<p>Ayuda</p>
				</div>
				<div class="border"></div>
			</div>
			<div class="ayuda">
				<ul>
					<li>Crear una cuenta.</li>
					<p>Dirigete a la seccion de Login en la parte superior de la pagina, una vez alli clickea en el botón "¿Aun no tienes una cuenta?" e ingresa los datos que se te pidan.</p>
					<li>Publicar un anuncio.</li>
					<p>Dirigete a la seccion superior de la pagina y haz click en el boton "+", una vez alli ingresa informacion, imagenes, etc sobre el anuncio a publicar.</p>
					<li>Destacar el anuncio. <span>(Opcional)</span></li>
					<p>La opcion de destacar el anuncio es muy util ya que permite que tu anuncio aparezca hasta arriba en el listado, dandote asi un mayor trafico en tu anuncio.</p>
				</ul>
			</div>
		</div>
	</section>
	<footer>
		<div class="sanluis">
			<p>San Luis Publica - 2018  &copy;</p>
		</div>
		<div class="king">
			<p>Desarrollado por I&F Design</p>
		</div>
	</footer>

			<!-- <i class="fa fa-cog" aria-hidden="true"></i>
				<i class="fa fa-calendar" aria-hidden="true"></i>
				<i class="fa fa-angle-left"aria-hidden="true"></i> 
			-->
	<script src="js/jquery-3.1.1.min.js"></script>
	<script type="text/javascript" src='js/efects.js'></script>
	<script type="text/javascript" src='js/app.js'></script>
</body>
</html>