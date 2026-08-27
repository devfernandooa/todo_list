<?php

require_once 'actions/processar_login.php';

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão De Tarefas</title>
    <link rel="stylesheet" href="/assets/css/login_style.css">

</head>

<body>
    <div class="landing-page">
        <!-- Conteúdo da Landing Page -->
        <div class="landing-content">
            <h1>To Do List</h1>
            <p>
                Bem-vindo ao sistema de Gestão de Tarefas! Aqui você pode gerenciar suas tarfeas e muito
                mais.
                Faça login para acessar todas as funcionalidades.
            </p>
        </div>

        <!-- Container de Login -->
        <div class="login-container">
            <div class="card-login">
                <div class="card-title">
                    <h1>Login</h1>
                </div>
                <div class="card-body">
                    <form method="POST" action="">
                        <label for="email">E-Mail:</label>
                        <input type="email" name="email" id="email" required>

                        <label for="senha">Senha:</label>
                        <input type="password" name="senha" id="senha" required>

                        <button type="submit">Entrar</button>
                    </form>
                </div>
                <div class="card-footer">
                    <p>Não tem uma conta? <a href="/views/cadastro_usuario.php">Cadastre-se</a></p>
                </div>
                <div class="card-footer">
                    <p> <a href="#">Esqueceu a senha?</a></p>
                </div>
                <div class="card-footer">
                    <p> <a href="index.php">Inicio</a></p>
                </div>
            </div>

            <!-- <?php if (isset($erro)): ?>
                <div class="erro">
                    <?php echo htmlspecialchars($erro); ?>
                </div>
            <?php endif; ?> -->
        </div>
    </div>
</body>

</html>