<?php

session_start();

require_once('src/PHPMailer.php');
require_once('src/SMTP.php');
require_once('src/Exception.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // Dados inseridos no formulário
  $emailInserido = $_POST["email"];
  $senhaInserida = $_POST["senha"];
  $loginInserido = $_POST["login"];

  // Email e senha já definidos
  $loginCorreto = "UserTest";
  $senhaCorreta = "senha123";

  // Verifica se o email e a senha estão corretos
  if ($loginInserido == $loginCorreto && $senhaInserida == $senhaCorreta) {
    // Gera um código randômico de 6 dígitos
    $codigoAutenticador = gerarCodigoAleatorio();

    // Armazenar o código na variável de sessão
    $_SESSION['codigoAcesso'] = $codigoAutenticador;

    // Configurações do email
    $mail = new PHPMailer(true);

    try {
      $mail->SMTPDebug = SMTP::DEBUG_SERVER;
      $mail->isSMTP();
      $mail->Host = 'sandbox.smtp.mailtrap.io';
      $mail->SMTPAuth = true;
      $mail->Username = '4e831fae00ef35';
      $mail->Password = '871aaf1ed34a5c';
      $mail->Port = 2525;

      // Configurações do servidor SMTP
      $mail->setFrom('vocelo2442@appxapi.com');
      //$mail->addAddress('Teste');
      $mail->addAddress($emailInserido);
    
      $mail->isHTML(true);
      $mail->Subject = 'Teste de email via gmail Canal TI';
      $mail->Body = 'Sua senha de acesso é <strong>'.$codigoAutenticador.'</strong>';
      $mail->AltBody = 'Chegou o email teste para 2 fatores';
    
      if($mail->send()) {
        echo 'Email enviado com sucesso';

        header("Location: validar.php");
        exit();

      } else {
        echo 'Email nao enviado';
      }
    } catch (Exception $e) {
      echo "Erro ao enviar mensagem: {$mail->ErrorInfo}";
    }

} else { echo 'Login ou Senha incorreta';}
}

// Função para gerar um código aleatório

function gerarCodigoAleatorio() {
  $codigo = rand(100000, 999999); // Gera um número aleatório de 6 dígitos
  return $codigo;
}


?>

<!DOCTYPE html>
<html>
<head>
  <title>Formulário de Acesso</title>
</head>
<body>
  <h2>Acesso</h2><br>
  <form method="POST" action="">
    <label for="email">Email:
    <input type="email" id="email" name="email" required>
    </label><br>
    <label for="login">Login:
      <input type="text" name="login" id="login">
    </label><br>
    <label for="senha">Senha:
    <input type="password" id="senha" name="senha" required>
    </label><br>

    <input type="submit" value="Entrar">
  </form><br>
  LoginCorreto: UserTest
  <br>
  SenhaCorreta: senha123
</body>
</html>
