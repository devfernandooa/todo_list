<?php
session_start();
require_once '../models/tarefas.php';

// Verifica se o ID da tarefa foi passado
if (isset($_GET['id'])) {
    $id_tarefa = $_GET['id'];

    // Busca a tarefa pelo ID
    $tarefa = buscarTarefaPorId($id_tarefa);

    // Verifica se o usuário tem permissão para concluir a tarefa
    if ($tarefa && $tarefa['id_usuario'] == $_SESSION['id_usuario']) {
        // Alterna o status de conclusão (concluída/pendente)
        $novo_status = $tarefa['concluida'] ? 0 : 1;

        // Atualiza o status da tarefa no banco de dados
        if (atualizarStatusTarefa(
            $id_tarefa, 
            $_SESSION['id_usuario'],
            $novo_status)) {
            header('Location: ../views/lista_tarefas.php?sucesso=Tarefa atualizada com sucesso!');
            exit();
        } else {
            header('Location: ../views/lista_tarefas.php?erro=Erro ao atualizar o status da tarefa.');
            exit();
        }
    } else {
        header('Location: ../views/lista_tarefas.php?erro=Você não tem permissão para concluir esta tarefa.');
        exit();
    }
} else {
    header('Location: ../views/lista_tarefas.php?erro=ID da tarefa não informado.');
    exit();
}
?>