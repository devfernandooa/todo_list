<?php
// processa_editar_tarefa.php
session_start();
require_once '../models/tarefas.php';

// Verifica se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
    $id_tarefa = $_POST['id_tarefa'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $data_conclusao = $_POST['data_conclusao'];
    $id_usuario = $_SESSION['id_usuario'];

    // Trata o upload da nova imagem (se houver)
    $imagem = null;
    if (
        atualizarTarefa(
            $id_tarefa,
            $id_usuario,
            $titulo,
            $descricao,
            $data_conclusao,
            $imagem
        )
    ) {
        header('Location: ../views/lista_tarefas.php?sucesso=Tarefa atualizada com sucesso!');
        exit();
    } else {
        header('Location: ../views/editar_tarefa.php?id=' . $id_tarefa . '&erro=Erro ao atualizar tarefa.');
        exit();
    }
    exit();

} else {
    header('Location: ../views/lista_tarefas.php');
    exit();
}
?>