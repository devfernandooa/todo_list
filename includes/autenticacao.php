<?php

function fazerLogin($email, $senha)
{
    // Verifica as credenciais usando a função verificarCredenciais
    global $pdo; // Usa a conexão PDO definida em conexao.php

    // Prepara a consulta SQL
    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();

    // Obtém o usuário no banco de dados
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
    //var_dump($usuario);
    // Verifica se o usuário existe e se a senha está correta
    if ($usuario && password_verify($senha, $usuario['senha'])) {
        $_SESSION['id_usuario'] = $usuario['id_usuario'];
        $_SESSION['nome'] = $usuario['nome']; // Opcional: armazenar o nome do usuário
        $_SESSION['email'] = $usuario['email'];

        header('Location: views/lista_tarefas.php');
    } else {
         echo "Usuário ou senha incorretos!";
    }
}