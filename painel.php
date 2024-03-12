<?php
    include('verifica_login.php');
?>

<h2>usuario_id: <?php echo $_SESSION['usuario_id'] ?></h2>
<h2>usuario: <?php echo $_SESSION['usuario'] ?></h2>
<h2>nome: <?php echo $_SESSION['nome'] ?></h2>
<h2>administrador: <?php echo $_SESSION['administrador'] ?></h2>
<h2><a href="logout.php">Sair</a></h2>