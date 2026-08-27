<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Todo List</title>
    <link rel="stylesheet" href="/assets/css/login_style.css">
</head>

<body>
    <div class="landing-page">
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
                    <h1>Cadastro</h1>
                </div>
            </div>
            <div class="card-body">
                <form action="../actions/cadastrar_action.php" method="POST">
                    <label for="nome">Nome:</label>
                    <input type="text" id="nome" name="nome" required>

                    <label for="email">E-mail:</label>
                    <input type="email" id="email" name="email" required>

                    <label for="senha">Senha:</label>
                    <input type="password" id="senha" name="senha" required>

                    <label for="confirmar_senha">Confirme a Senha:</label>
                    <input type="password" id="confirmar_senha" name="confirmar_senha" required>

                    <button type="submit">Cadastrar</button>
                </form>
                <p>Já tem uma conta? <a href="/index.php">Faça login</a></p>
            </div>
        </div>
    </div>

    <script src="/assets/js/scripts.js"></script>
</body>

</html>