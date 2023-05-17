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
      $mail->Username = 'd6b80ab5135925';
      $mail->Password = '47490098bd5dff';
      $mail->Port = 2525;

      // Configurações do servidor SMTP
      $mail->setFrom('group.test@dev.br');
      //$mail->addAddress('Teste');
      $mail->addAddress($emailInserido);
    
      $mail->isHTML(true);
      $mail->Subject = 'Teste de email via gmail Canal TI';
      $mail->Body = 'Sua senha de acesso é <strong>'.$codigoAutenticador.'</strong>';
      $mail->AltBody = 'Chegou o email teste para 2 fatores';
    
      if($mail->send()) {
        echo 'Email enviado com sucesso';

        // metodo de encaminhamento de página por código PHP+HTML
        echo '<meta http-equiv="refresh" content="0;URL=\'validar.php\'" />';
        exit();
        
        // header('Location: validar.php');
        // exit();

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
  <link rel="stylesheet" href="assets/styleHome.css">
</head>
<body>
  <section class="geral">
  <h1>Acesso Laranjão 🍊</h1>
  <h2>Digite sua senha e seu login para ter acesso a plataforma Laranjão.</h2><br>
  <form method="POST" action="">
    <label for="email"> <br>
    <input type="email" id="email" name="email" class="inputForm" placeholder="E-mail" required>
    </label><br>
    <label for="login">
      <input type="text" name="login" id="login" class="inputForm" placeholder="Login">
    </label><br>
    <label for="senha">
    <input type="password" id="senha" name="senha" class="inputForm" placeholder="Senha"required>
    </label><br>

    <input type="submit" value="Entrar">
  </form>
  </section>
  <section class="sessaoDados">
  Login Correto: <strong>UserTest</strong>
  <br>
  Senha Correta: <strong>senha123</strong>
  </section>
</body>
</html>

