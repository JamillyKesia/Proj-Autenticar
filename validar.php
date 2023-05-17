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
    
    header("Location: iupiii.html");
    exit();
    
    //echo "Código válido!"; // Código inserido está correto


} else {
    echo "Código inválido!"; // Código inserido está incorreto
  }
}
?>

<!-- Formulário para inserir o código -->
<form action="validar.php" method="post">
  <label for="codigoInserido">Insira o código:</label>
  <input type="text" name="codigoInserido" id="codigoInserido" required><br>
  <button type="submit">Verificar Código</button>
</form>