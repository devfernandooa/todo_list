<?php
session_start();
require_once __DIR__ . '/../includes/csrf.php';
require_once __DIR__ . '/../models/cadastro.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

if(
    !isset($_POST['csrf_token']) || !validarTokenCSRF($_POST['csrf_token'])    
    ) {
    die('Token CSRF inválido!');
}

    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    if (cadastrarUsuario($nome, $email, $senha)) {
        header('Location: ../index.php');
    } else {
        header('Location: ../index.php');
    }

    exit();

}