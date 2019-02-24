<!DOCTYPE html>
<html lang="pt-br">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>AdminStock - Recuperar Senha</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">Recuperar Senha</div>
      <div class="card-body">
        
		<!-- FORM -->
		<form method="POST" action="trocar_senha.php" >
          
		  <!-- SENHA -->
          <div class="form-group">
            <div class="form-row">
              <div class="col-md-6">
                <div class="form-label-group">
                  <input name="senha" type="password" id="inputPassword" class="form-control" placeholder="Password" required="required" minlength="6" maxlength="100">
                  <label for="inputPassword">Nova Senha</label>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-label-group">
                  <input name="conf_senha" type="password" id="confirmPassword" class="form-control" placeholder="Confirm password" required="required" minlength="6" maxlength="100">
                  <label for="confirmPassword">Confirme a Nova Senha</label>
                </div>
              </div>
            </div>
          </div>
		  <input type="hidden" name="pass_recovery" value="<?php echo $_GET['recuperar']; ?>"/>
		  <input type="submit" class="btn btn-primary btn-block" value="Trocar Senha">
		  
        </form>
      </div>
    </div>
  </div>

  <!-- VALIDAÇÃO DE CONFIRMAÇÃO DE SENHA -->
  <script>
		var password = document.getElementById("inputPassword")
		  , confirm_password = document.getElementById("confirmPassword");

		function validatePassword(){
		  if(password.value != confirm_password.value) {
			confirm_password.setCustomValidity("As senhas estão diferentes!");
		  } else {
			confirm_password.setCustomValidity('');
		  }
		}

		password.onchange = validatePassword;
		confirm_password.onkeyup = validatePassword;
  </script>
	
  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

</body>

</html>
