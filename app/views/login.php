<?php
session_start();

// login fixo só como exemplo
$adminEmail = "admin@teste.com";
$adminSenha = "12345";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if ($email === $adminEmail && $senha === $adminSenha) {
        $_SESSION['admin'] = true;
        header("Location: index.php");
        exit;
    } else {
        $erro = "Email ou senha inválidos!";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Login Administrador</title>
  <style>
    body { display:flex; justify-content:center; align-items:center; height:100vh; background:#f4f9ff; font-family:Arial; }
    .login-box { background:#fff; padding:30px; border-radius:12px; box-shadow:0 4px 12px rgba(0,0,0,0.1); width:300px; }
    h2 { margin-bottom:20px; text-align:center; color:#1e3a8a; }
    input { width:100%; padding:10px; margin:10px 0; border:1px solid #ccc; border-radius:8px; }
    button { width:100%; padding:10px; background:#1e40af; color:#fff; border:none; border-radius:8px; font-weight:bold; cursor:pointer; }
    button:hover { background:#1e3a8a; }
    p { color:red; text-align:center; }
  </style>
</head>
<body>
  <div class="login-box">
    <h2>Login Admin</h2>
    <?php if (!empty($erro)) echo "<p>$erro</p>"; ?>
    <form method="POST">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="senha" placeholder="Senha" required>
      <button type="submit">Entrar</button>
    </form>
  </div>
</body>
</html>
