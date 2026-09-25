<?php
session_start(); // Inicia a sessão
//Adicona Token de validação aoprocessar o login do usuário
require_once __DIR__ . '/../includes/csrf.php';
//require_once 'includes/autenticacao.php';
require_once 'includes/conexao.php'; // Inclui a conexão com o banco de dados
require_once 'includes/autenticacao.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

 if(!isset($_POST['csrf_token']) || !validarTokenCSRF($_POST['csrf_token'])) {
    die('Token CSRF inválido!');
 }
    // Obtém os dados do formulário
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Validação básica dos dados (opcional)
    if (empty($email) || empty($senha)) {
        $erro = "Por favor, preencha todos os campos.";
    } else {
        fazerLogin($email, $senha);
    }
}