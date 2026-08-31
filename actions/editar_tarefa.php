<?php

session_start();

require_once '../models/tarefas.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id_tarefa = $_POST['id_tarefa'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $data_conclusao = $_POST['data_conclusao'];
    $id_usuario = $_SESSION['id_usuario'];

    // Verifica se a tarefa pertence ao usuário logado
    $tarefa = buscarTarefaPorId($id_tarefa);

    if (!$tarefa || $tarefa['id_usuario'] != $id_usuario) {
        header('Location: ../views/lista_tarefas.php?erro=Você não tem permissão para editar esta tarefa.');
        exit();
    }

    // Mantém a imagem atual por padrão
    $imagem = $tarefa['imagem'];

    // Trata o upload da nova imagem, se houver
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {

        $diretorio = '../uploads/usuario_' . $id_usuario . '/';

        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true);
        }

        $caminho_imagem = $diretorio . basename($_FILES['imagem']['name']);

        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_imagem)) {
            $imagem = $caminho_imagem;
        }
    }

    // Atualiza a tarefa
    if (atualizarTarefa(
        $id_tarefa,
        $id_usuario,
        $titulo,
        $descricao,
        $data_conclusao,
        $imagem
    )) {

        header('Location: ../views/lista_tarefas.php?sucesso=Tarefa atualizada com sucesso!');
        exit();

    } else {

        header('Location: ../views/editar_tarefa.php?id=' . $id_tarefa . '&erro=Erro ao atualizar tarefa.');
        exit();
    }

} else {

    header('Location: ../views/lista_tarefas.php');
    exit();
}