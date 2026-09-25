<?php
session_start();
require_once __DIR__ . '/../includes/csrf.php';
require_once '../includes/conexao.php';
require_once '../models/tarefas.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(!isset($_POST['csrf_token']) || !validarTokenCSRF($_POST['csrf_token'])){
        die('Token CSRF inválido!');
    }
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $data_conclusao = $_POST['data_conclusao'];
    $id_usuario = $_SESSION['id_usuario'];

    // Trata o upload da imagem
    $imagem = null;
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $diretorio = '../public/uploads/usuario_' . $id_usuario . '/';
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }
        $caminho_imagem = $diretorio . basename($_FILES['imagem']['name']);
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_imagem)) {
            $imagem = $caminho_imagem;
        } else {
            $erro = "Erro ao fazer upload da imagem.";
        }
    }

    // Adiciona a tarefa ao banco de dados
    if (adicionarTarefa($titulo, $descricao, $data_conclusao, $imagem, $id_usuario)) {
        header('Location: ../views/lista_tarefas.php?sucesso=Tarefa adicionada com sucesso!');
        exit();
    } else {
        header('Location: ../views/lista_tarefas.php?erro=Erro ao adicionar tarefa.');
        exit();
    }
} else {
    header('Location: adicionar_tarefa.php');
    exit();
}
?>