<?php
session_start();
include('db/conexao.php');
 
if(empty($_POST['usuario']) || empty($_POST['senha'])) {
	header('Location: autenticacao.php');
	exit();
}
 
$usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
$senha = mysqli_real_escape_string($conexao, $_POST['senha']);
 
$query = "SELECT usuario FROM usuario WHERE usuario = '{$usuario}' and senha = md5('{$senha}')";
 
$result = mysqli_query($conexao, $query);
 
$row = mysqli_num_rows($result);
 
if($row == 1) {
	$timeZone = mysqli_query($conexao, "SET time_zone = '-3:00'");
	$dataLogin = "UPDATE usuario SET dataLogin = NOW() WHERE usuario = '{$usuario}'";
	$resultDataLogin = mysqli_query($conexao, $dataLogin);

	$_SESSION['usuario'] = $usuario;
	// Obter o nome do usuário
	$sessionUsername = mysqli_real_escape_string($conexao, $_SESSION['usuario']);
	$queryUsername = "SELECT nome FROM usuario WHERE usuario = '$sessionUsername'";
	$resultUsername = mysqli_query($conexao, $queryUsername);
	$rowUsername = mysqli_fetch_array($resultUsername);
	$username = $rowUsername['nome'];
	$_SESSION['nome'] = $username;
	// Ober o ID do usuário
	$sessionUsuario_id = mysqli_real_escape_string($conexao, $_SESSION['usuario']);
	$queryUsuario_id = "SELECT usuario_id FROM usuario WHERE usuario = '$sessionUsuario_id'";
	$resultUsuario_id = mysqli_query($conexao, $queryUsuario_id);
	$rowUsuario_id = mysqli_fetch_array($resultUsuario_id);
	$usuario_id = $rowUsuario_id['usuario_id'];
	$_SESSION['usuario_id'] = $usuario_id;
	// Ober o perfil do Usuário
	$sessionAdministrador = mysqli_real_escape_string($conexao, $_SESSION['usuario']);
	$queryAdministrador = "SELECT administrador FROM usuario WHERE usuario = '$sessionAdministrador'";
	$resultAdministrador = mysqli_query($conexao, $queryAdministrador);
	$rowAdministrador = mysqli_fetch_array($resultAdministrador);
	$administrador = $rowAdministrador['administrador'];
	$_SESSION['administrador'] = $administrador;

	header('Location: index.php?menuop=home');
	exit();
} else {
	$_SESSION['nao_autenticado'] = true;
	header('Location: autenticacao.php');
	exit();
}