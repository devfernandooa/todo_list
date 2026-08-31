<?php
require_once '../includes/conexao.php';
//require_once '../actions/adicionar_tarefa.php';

function adicionarTarefa($titulo, $descricao, $data_conclusao, $imagem, $id_usuario)
{
    global $pdo;
    // Prepara a query SQL
    $sql = "INSERT INTO tarefas (titulo, descricao, data_conclusao, imagem, id_usuario)
    VALUES (:titulo, :descricao, :data_conclusao, :imagem, :id_usuario)";

    try {
        $stmt = $pdo->prepare($sql);

        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':data_conclusao', $data_conclusao);
        $stmt->bindParam(':imagem', $imagem);
        $stmt->bindParam(':id_usuario', $id_usuario);

        $stmt->execute();
        return true;
    } catch (PDOException $e) {
        // Em caso de erro, exibe uma mensagem de erro
        die("Erro ao adicionar tarefa: " . $e->getMessage());

    }
}


function tratarUploadImagem($id_usuario)
{
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] === UPLOAD_ERR_OK) {
        $diretorio = '../uploads/usuario_' . $id_usuario . '/';
        if (!is_dir($diretorio)) {
            mkdir($diretorio, 0777, true); // Cria o diretório se não existir
        }
        $caminho_imagem = $diretorio . basename($_FILES['imagem']['name']);
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $caminho_imagem)) {
            // Salva o caminho da imagem no banco de dados
        } else {
            $erro = "Erro ao fazer upload da imagem.";
        }
    } else {
        $caminho_imagem = null; // Nenhuma imagem foi enviada
    }
}

// Função para listar tarefas do usuário
function listarTarefas($id_usuario)
{
    global $pdo;

    $sql = "SELECT * FROM tarefas WHERE id_usuario = :id_usuario ORDER BY data_criacao DESC";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_usuario' => $id_usuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Retorna todas as tarefas como um array associativo
    } catch (PDOException $e) {
        error_log("Erro ao listar tarefas: " . $e->getMessage());
        return []; // Retorna um array vazio em caso de erro
    }
}


// Função para buscar uma tarefa pelo ID
function buscarTarefaPorId($id_tarefa)
{
    global $pdo;

    $sql = "SELECT * FROM tarefas WHERE id_tarefa = :id_tarefa";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_tarefa' => $id_tarefa]);
        return $stmt->fetch(PDO::FETCH_ASSOC); // Retorna a tarefa como um array associativo
    } catch (PDOException $e) {
        error_log("Erro ao buscar tarefa: " . $e->getMessage());
        return null; // Retorna null em caso de erro
    }
}
function atualizarTarefa(
    $id_tarefa,
    $id_usuario,
    $titulo,
    $descricao,
    $data_conclusao,
    $imagem
) {
    global $pdo;

    $sql = "UPDATE tarefas
            SET titulo = :titulo,
                descricao = :descricao,
                data_conclusao = :data_conclusao,
                imagem = :imagem
            WHERE id_tarefa = :id_tarefa
            AND id_usuario = :id_usuario";

    try {

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ':titulo' => $titulo,
            ':descricao' => $descricao,
            ':data_conclusao' => $data_conclusao,
            ':imagem' => $imagem,
            ':id_tarefa' => $id_tarefa,
            ':id_usuario' => $id_usuario
        ]);

        return true;

    } catch (PDOException $e) {

        error_log("Erro ao atualizar tarefa: " . $e->getMessage());

        return false;
    }
}

function salvarImagemTarefa($id_tarefa, $caminho_imagem)
{
    global $pdo;

    $sql = "INSERT INTO imagens_tarefas (id_tarefa, caminho_imagem) VALUES (:id_tarefa, :caminho_imagem)";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_tarefa' => $id_tarefa,
            ':caminho_imagem' => $caminho_imagem
        ]);
        return true;
    } catch (PDOException $e) {
        error_log("Erro ao salvar imagem: " . $e->getMessage());
        return false;
    }
}

// Busca as imagens da tarefa
function buscarImagensTarefa($id_tarefa)
{
    global $pdo;

    $sql = "SELECT caminho_imagem FROM imagens_tarefas WHERE id_tarefa = :id_tarefa";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_tarefa' => $id_tarefa]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Erro ao buscar imagens: " . $e->getMessage());
        return [];
    }
}

function excluirTarefa($id_tarefa, $id_usuario)
{
    global $pdo;

    $sql = "DELETE FROM tarefas WHERE id_tarefa = :id_tarefa AND id_usuario = :id_usuario";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_tarefa' => $id_tarefa,
            ':id_usuario' => $id_usuario
        ]);
        return true; // Tarefa excluída com sucesso
    } catch (PDOException $e) {
        error_log("Erro ao excluir tarefa: " . $e->getMessage());
        return false; // Falha ao excluir tarefa
    }
}

function atualizarStatusTarefa($id_tarefa, $concluida)
{
    global $pdo;

    $sql = "UPDATE tarefas SET concluida = :concluida WHERE id_tarefa = :id_tarefa";
    try {
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':concluida' => $concluida,
            ':id_tarefa' => $id_tarefa
        ]);
        return true; // Status atualizado com sucesso
    } catch (PDOException $e) {
        error_log("Erro ao atualizar status da tarefa: " . $e->getMessage());
        return false; // Falha ao atualizar status
    }
}