<?php
session_start();
require_once '../models/tarefas.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém o ID da tarefa a ser excluída
    $id_tarefa = $_POST['id_tarefa'];

    // Verifica se o usuário tem permissão para excluir a tarefa 
    $tarefa = buscarTarefaPorId($id_tarefa);
    if ($tarefa && $tarefa['id_usuario'] == $_SESSION['id_usuario']) {
        // E xclui a tarefa
        if (excluirTarefa($id_tarefa, $_SESSION['id_usuario'])) {
            header('Location: ../views/lista_tarefas.php?sucesso=Tarefa excluída com sucesso!');
            exit();
        } else {
            header('Location: ../views/lista_tarefas.php?erro=Erro ao excluir tarefa.');
            exit();
        }
    } else {
        header('Location: lista_tarefas.php?erro=Você não tem permissão para excluir esta tarefa.');
        exit();
    }
} else {
    header('Location: lista_tarefas.php');
    exit();
}
//comentario
?>