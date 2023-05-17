<?php

session_start();

echo "Código gerado: " . $_SESSION['codigoAcesso'];

// Verificar se o código foi enviado pelo formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Obter o código inserido pelo usuário
  $codigoInserido = $_POST['codigoInserido'];

  // Obter o código aleatório armazenado na variável de sessão
  $codigoAutenticador = $_SESSION['codigoAcesso'];

  // Verificar se o código inserido é igual ao código aleatório
  if ($codigoInserido == $codigoAutenticador) {
    echo "Código válido!"; // Código inserido está correto
    echo '<meta http-equiv="refresh" content="0;URL=\'codigo-valido.html\'" />';
    exit();

    
    // header("Location: iupiii.html");
    //     exit();

} else {
  echo '<script type="text/javascript">
      window.onload = function () { alert("CÓDIGO INVÁLIDO!"); } 
      </script>'; // Código inserido está incorreto
  }
}
?>
<!DOCTYPE html>
<html>
<head>
  <title>Validar Código</title>
  <link rel="stylesheet" href="assets/styleValidar.css">
</head>
<body>
<section class="geral">
  <h1>Validação do Acesso</h1>
  <h2>Insira o código para validar o acesso à plataforma Laranjão</h2>
<!-- Formulário para inserir o código -->


<form action="validar.php" method="post">
  <label for="codigoInserido">Insira o código:</label>
  <input type="text" name="codigoInserido" id="codigoInserido" class="inputForm" placeholder="Insira o código:" required><br>
  <button type="submit">Verificar Código</button>
</section>
</form>
</body>
</html>