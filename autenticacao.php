<?php
session_start();
?>
 
 <!doctype html>
<html lang="pt-br">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sala HUB - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">
    <link rel="stylesheet" href="css/login.css">
</head>
<body>
<a href="index.php?menuop=home"><img src="img/logo-ceub.png" class="logo"></a>
<div class="card" id="login">
  <div class="card-body">  
        <form action="login.php" method="POST">
        <div class="mb-3">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-A3rJD856KowSb7dwlZdYEkO39Gagi7vIsF0jrRAoQmDKKtQBHUuLZ9AsSv4jD4Xa" crossorigin="anonymous"></script>
            <?php
                if(isset($_SESSION['nao_autenticado'])):
            ?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Erro:</strong> Usuário ou senha inválidos. Tente novamente.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php
                endif;
                unset($_SESSION['nao_autenticado']);
            ?>
            <label>Usuário</label>
            <input name="usuario" type="text" class="form-control" id="">
        </div>
        <div class="mb-3">
            <label>Senha</label>
            <input name="senha" type="password" class="form-control" id="">
        </div>
        <button type="submit" class="btn btn-primary">Entrar</button>
        </form>
  </div>
</div>
</body>
 
</html>