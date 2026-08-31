<?php
session_start();
require_once '../models/tarefas.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtém os dados do formulário
    $id_tarefa = $_POST['id_tarefa'];
    $titulo = $_POST['titulo'];
    $descricao = $_POST['descricao'];
    $data_conclusao = $_POST['data_conclusao'];
    $id_usuario = $_SESSION['id_usuario'];
    $remover_imagem = isset($_POST['remover_imagem']) ? true : false;

    // Busca a tarefa atual para obter a imagem existente
    $tarefa = buscarTarefaPorId($id_tarefa);
    $imagem = $tarefa['imagem'];

    // Remove a imagem atual se a caixa de seleção estiver marcada
    if ($remover_imagem && $imagem) {
        if (file_exists($imagem)) {
            unlink($imagem); // Remove o arquivo de imagem do servidor
        }
        $imagem = null; // Define a imagem como null no banco de dados
    }

    // Trata o upload de uma nova imagem (se houver)
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $diretorio = '../uploads/usuario_' . $id_usuario . '/';
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true); // Cria o diretório se não existir
        }
        $caminho_imagem = $diretorio . basename($_FILES['imagem']['name']);
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_imagem)) {
            // Remove a imagem anterior (se existir)
            if ($imagem && file_exists($imagem)) {
                unlink($imagem);
            }
            $imagem = $caminho_imagem; // Atualiza o caminho da nova imagem
        } else {
            $erro = "Erro ao fazer upload da imagem.";
        }
    }

    // Atualiza a tarefa no banco de dados
    if (atualizarTarefa($id_tarefa,$id_usuario, $titulo, $descricao, $data_conclusao, $imagem)) {
        header('Location: ../views/lista_tarefas.php?sucesso=Tarefa atualizada com sucesso!');
        exit();
    } else {
        header('Location: editar_tarefa.php?id=' . $id_tarefa . '&erro=Erro ao atualizar tarefa.');
        exit();
    }
} else {
    header('Location: ../views/lista_tarefas.php');
    exit();
}
?>