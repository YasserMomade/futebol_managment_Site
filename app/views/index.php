<?php
session_start();
$isAdmin = isset($_SESSION['admin']) && $_SESSION['admin'] === true;
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <title>Campeonato</title>
  <link rel="stylesheet" href="assets/style.css">
  <style>
    * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
    body {
      background-color: #f4f9ff;
      display: flex; justify-content: center; align-items: center;
      min-height: 100vh; padding: 20px;
    }
    .container {
      background: #fff; max-width: 600px; width: 100%;
      padding: 30px; border-radius: 15px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
      text-align: center;
    }
    h1 { font-size: 2rem; color: #1e3a8a; margin-bottom: 25px; }
    nav ul {
      list-style: none; display: grid; grid-template-columns: 1fr;
      gap: 15px;
    }
    nav ul li {
      background: #1e40af; border-radius: 12px;
      transition: transform 0.2s, box-shadow 0.2s;
    }
    nav ul li:hover {
      transform: translateY(-3px); box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }
    nav ul li a {
      display: block; padding: 15px; color: #fff;
      font-weight: bold; text-decoration: none; font-size: 1rem;
    }
    @media (min-width: 600px) { nav ul { grid-template-columns: 1fr 1fr; } }
  </style>
</head>
<body>
  <div class="container">
    <h1>🏆 Sistema de Campeonato</h1>
    <nav>
      <ul>
        <?php if ($isAdmin): ?>
          <li><a href="times.php">Gerenciar Times</a></li>
          <li><a href="partidas.php">Gerenciar Partidas</a></li>
          <li><a href="resultado.php">Lançar Resultados</a></li>
        <?php endif; ?>
        <li><a href="jogos.php">Jogos</a></li>
        <li><a href="tabela.php">Tabela de Classificação</a></li>
        
        <?php if (!$isAdmin): ?>
          <li><a href="login.php">Área do Administrador</a></li>
        <?php else: ?>
          <li><a href="logout.php">Sair</a></li>
        <?php endif; ?>
      </ul>
    </nav>
  </div>
</body>
</html>
