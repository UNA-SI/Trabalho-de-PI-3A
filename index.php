﻿<?php
require_once("adminstock/connect.php");
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>AdminStock - Login</title>

  <!-- Custom fonts for this template-->
  <link href="adminstock/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="adminstock/css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form method="POST" action="adminstock/valida.php">
          <div class="form-group">
            <div class="form-label-group">
			   <input type="text" id="login" class="form-control" placeholder="Login" required="required" autofocus="autofocus">
              <label id="login" for="inputLogin">Login</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" id="inputPassword" class="form-control" placeholder="Password" required="required" minlength="4">
              <label id="senha" for="inputPassword">Senha</label>
            </div>
          </div>
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" value="remember-me">
                Lembrar Senha
              </label>
            </div>
          </div>
          <input type="submit" class="btn btn-primary btn-block" href="index.html" value="Entrar">
        </form>
        <div class="text-center">
			<a class="d-block small mt-3" href="adminstock/register.html">Cadastre-se</a> 
			<a class="d-block small" href="adminstock/forgot-password.html">Esqueceu a Senha?</a>			  
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="adminstock/vendor/jquery/jquery.min.js"></script>
  <script src="adminstock/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="adminstock/vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
