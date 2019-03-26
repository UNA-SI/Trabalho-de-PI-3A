<?php
require_once("../../requires/connect.php");   // Conexao com o banco de dados
require_once("../../requires/bcrypt.php");    // Classe Responsavel pela criptografia
require_once("../../requires/functions.php"); // Funcoes

// criptografa a senha digitada
$hash_pass = Bcrypt::hash($_POST['senha']);
$update = "UPDATE usuario SET senha = '$hash_pass' WHERE recuperar_senha = '{$_POST['recuperar_senha']}'";
$mysqli->query($update);
if (mysqli_affected_rows($mysqli) == 0) { // Caso falhe, informa o usuario e pede para tentar novamente
	Functions::alertaRedirect("Token expirado, solicite a troca de senha novamente!", "../definir_senha.php??zeqe0eZoda28goklt3W0={$_POST['recuperar_senha']}");
}
// Gera novo hash para recuperar senha
$novo_pass_rec = Bcrypt::generateRandomHash();
// Salva o novo hash de recuperacao de senha no bd
$update = "UPDATE usuario SET recuperar_senha = '$novo_pass_rec' WHERE recuperar_senha = '{$_POST['recuperar_senha']}'";
$mysqli->query($update);
if (mysqli_affected_rows($mysqli) == 0) { // Caso falhe, informa o usuario e pede para tentar novamente
	Functions::alertaRedirect("Token expirado, solicite a troca de senha novamente!", "../definir_senha.php??zeqe0eZoda28goklt3W0={$_POST['recuperar_senha']}");
}
Functions::alertaRedirect("Troca Realizada com sucesso!", "../../../index.html"); // Informa o usuario que a troca foi bem sucedida.
?>
	