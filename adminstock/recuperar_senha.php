<?php
// Adiciona o arquivo class.phpmailer.php - você deve especificar corretamente o caminho da pasta com o este arquivo.
require_once("autenvio/PHPMailerAutoload.php");
require_once("connect.php");

$email = $_POST['email'];

$select = $mysqli->query("SELECT login, pri_nome, ult_nome, email, pass_recovery FROM Usuario WHERE email ='$email'");
$result = $select->fetch_assoc();

if($result == "")
{ 	
		echo "<script>
		alert('Seu email n\u00e3o est\u00e1 cadastrado na base de dados!');
		window.location.href='forgot-password.html';
		</script>";
}
else{

	// Inicia a classe PHPMailer
	$mail = new PHPMailer();

	// DEFINIÇÃO DOS DADOS DE AUTENTICAÇÃO - Você deve auterar conforme o seu domínio!
	$mail->IsSMTP(); // Define que a mensagem será SMTP
	$mail->Host = "smtp.adminstock.kinghost.net"; // Seu endereço de host SMTP
	$mail->SMTPAuth = true; // Define que será utilizada a autenticação -  Mantenha o valor "true"
	$mail->Port = 587; // Porta de comunicação SMTP - Mantenha o valor "587"
	$mail->SMTPSecure = false; // Define se é utilizado SSL/TLS - Mantenha o valor "false"
	$mail->SMTPAutoTLS = false; // Define se, por padrão, será utilizado TLS - Mantenha o valor "false"
	$mail->Username = 'recuperar.senha@adminstock.kinghost.net'; // Conta de email existente e ativa em seu domínio
	$mail->Password = 'projetopi2019'; // Senha da sua conta de email

	// DADOS DO REMETENTE
	$mail->Sender = 'recuperar.senha@adminstock.kinghost.net'; // Conta de email existente e ativa em seu domínio
	$mail->From = 'recuperar.senha@adminstock.kinghost.net'; // Sua conta de email que será remetente da mensagem
	$mail->FromName = "AdminStock"; // Nome da conta de email

	// DADOS DO DESTINATÁRIO
	$mail->AddAddress($email); // Define qual conta de email receberá a mensagem
	//$mail->AddAddress('recebe2@dominio.com.br'); // Define qual conta de email receberá a mensagem
	//$mail->AddCC('copia@dominio.net'); // Define qual conta de email receberá uma cópia
	//$mail->AddBCC('copiaoculta@dominio.info'); // Define qual conta de email receberá uma cópia oculta

	// Definição de HTML/codificação
	$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
	$mail->CharSet = 'utf-8'; // Charset da mensagem (opcional)

	// DEFINIÇÃO DA MENSAGEM
	$mail->Subject  = "Troca de Senha"; // Assunto da mensagem
	$mail->Body .= " Olá ".$result['pri_nome']." ".$result['ult_nome']."<br><br>"; // Texto da mensagem
	$mail->Body .= "Seu login é: ".$result['login']." <br> Acesse o link abaixo para realizar a troca da senha <br>"; // Texto da mensagem
	$mail->Body .= "<a href='http://adminstock.kinghost.net/adminstock/definir_senha.php?recuperar=".$result['pass_recovery']."'>Clique Aqui!</a>"; // Texto da mensagem

	// ENVIO DO EMAIL
	$enviado = $mail->Send();
	// Limpa os destinatários e os anexos
	$mail->ClearAllRecipients();

	// Exibe uma mensagem de resultado do envio (sucesso/erro)
	if ($enviado) {
		echo "<script>
		alert('E-mail enviado com sucesso!');
		window.location.href='../index.html';
		</script>";
	} else {
		echo "<script>
		alert('Não foi possível enviar o e-mail, tente novamente!');
		window.location.href='forgot-password.html';
		</script>";
	    //echo "<b>Detalhes do erro:</b> " . $mail->ErrorInfo; // DEBUG
	}
}