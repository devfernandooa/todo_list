<?php
require_once '../models/tarefas.php';
session_start();
//var_dump($_SESSION);
if (!isset($_SESSION['id_usuario'])) {
    // Redireciona para a página de login se o usuário não estiver logado
    header('Location: login.php');
    exit();
}

$id_usuario = $_SESSION['id_usuario'];
$tarefas = listarTarefas($id_usuario);
//var_dump($tarefas);



?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tarefas - Todo List</title>
    <link rel="stylesheet" href="/assets/css/home_style.css">
    <link rel="stylesheet" href="/assets/css/modal_excluir_tarefa.css">
    <link rel="stylesheet" href="/assets/css/modal_editar_tarefa.css  ">
    <link rel=" stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

</head>
</head>


<body>
    <div class="container">
        <!-- Header -->
        <header>
            <div class="header-title">
                <h2>Bem-vindo, <?= htmlspecialchars($_SESSION['nome']); ?>!</h2>
            </div>

            <div class="header-login">
                <h5><i class="fas fa-user"></i> <?= htmlspecialchars($_SESSION['email']); ?></h5>
            </div>
            <div class="header-button">
                <a href="../actions/logout.php" class="btn-logout"><i class="fas fa-door-open"></i> </i>Sair</a>
            </div>
            <div class="current-time">
                <i class="far fa-clock"></i>
                <p id="current-time"></p>

            </div>
        </header>

        <!-- Formulário de Adição de Tarefas -->
        <div class="form-tarefa">
            <form action="../actions/adicionar_tarefa.php" method="POST" enctype="multipart/form-data">
                <input type="text" name="titulo" placeholder="Título da tarefa" required>
                <textarea name="descricao" placeholder="Descrição (opcional)"></textarea>
                <input type="date" name="data_conclusao">
                <input type="file" name="imagem" accept="image/*" multiple>
                <button type="submit">Adicionar Tarefa</button>
            </form>
        </div>

        <!--Exibe mensagens de erro ou sucesso-->
        <?php
        if (isset($_GET['sucesso'])) {
            ?>
            <div class="mensagem sucesso">
                <?= htmlspecialchars($_GET['sucesso']); ?>
            </div>
            <?php
        } //Fechamento do if
        ?>
        <?php
        if (isset($_GET['erro'])) {
            ?>
            <div class="mensagem erro">
                <?= htmlspecialchars($_GET['erro']); ?>
            </div>
            <?php
        } //Fechamento do if
        ?>
        <!-- Lista de Tarefas -->
        <div class="lista-tarefas">
            <?php
            if (empty($tarefas)) { ?>
                <p>Nenhuma tarefa encontrada.
                    <?php
            } else { ?>
                    <?php foreach ($tarefas as $tarefa) { ?>

                    <h2>Suas Tarefas <?= " " . $tarefa['id_tarefa'] ?></h2>
                    <div class="tarefa">
                        <h3>Titulo: <?= htmlspecialchars($tarefa['titulo']); ?></h3>
                        <p>Descrição: <?= htmlspecialchars($tarefa['descricao']); ?></p>


                        <?php if (!empty($tarefa['imagem'])): ?>

                            <img src="<?= htmlspecialchars($tarefa['imagem']); ?>" alt="Imagem da Tarefa" class="imagem-tarefa">

                        <?php endif; ?>
                        <p><strong>Data:</strong> 10/10/2023</p>
                        <p><strong>Data de Conclusão:</strong> <?= htmlspecialchars($tarefa['data_conclusao']); ?></p>
                        <?php if (isset($_GET['sucesso'])): ?>
                            <div class="mensagem sucesso">
                                <?= htmlspecialchars($_GET['sucesso']); ?>
                            </div>
                        <?php endif; ?>

                        <?php if (isset($_GET['erro'])): ?>
                            <div class="mensagem erro">
                                <?= htmlspecialchars($_GET['erro']); ?>
                            </div>
                        <?php endif; ?>
                        <p><strong>Status:</strong> <?= $tarefa['concluida'] ? 'Concluída' : 'Pendente'; ?></p>
                        <div class="acoes">
                            <button class="btn-editar" onclick="abrirModalEditar(
                                    '<?= $tarefa['id_tarefa']; ?>',
                                    '<?= htmlspecialchars($tarefa['titulo']); ?>',
                                    '<?= htmlspecialchars($tarefa['descricao']); ?>',
                                    '<?= htmlspecialchars($tarefa['data_conclusao']); ?>',
                                    '<?= !empty($tarefa['imagem']) ? htmlspecialchars($tarefa['imagem']) : ''; ?>')"><i
                                    class="fas fa-edit"></i>Editar
                            </button>

                            <button class="btn-concluir">
                                <a href="../actions/concluir_tarefa.php?id=<?= $tarefa['id_tarefa']; ?>" class="btn-concluir">
                                    <i class="far fa-check-circle"></i></i>
                                    <?= $tarefa['concluida'] ? 'Desmarcar Conclusão' : 'Concluir'; ?>
                                </a>
                            </button>

                            <button class="btn-excluir" onclick="abrirModalExcluir(<?= $tarefa['id_tarefa']; ?>)"> <i
                                    class="fas fa-trash"></i>Excluir</button>

                            <div id="modal-editar" class="modal">
                                <div class="modal-conteudo">
                                    Desmar <span class="fechar-modal">&times;</span>
                                    <h2>Editar Tarefa</h2>
                                    <!-- Exibe o ID da tarefa -->
                                    <p><strong>ID da Tarefa:</strong> <span id="id-tarefa-editar"></span></p>
                                    <form id="form-editar-tarefa" action="../actions/processa_editar_tarefa.php" method="POST"
                                        class="form-editar" enctype="multipart/form-data">
                                        <input type="hidden" id="id_tarefa" name="id_tarefa">

                                        <label for="titulo">Título:</label>
                                        <input type="text" id="titulo" name="titulo" required>

                                        <label for="descricao">Descrição:</label>
                                        <textarea id="descricao" name="descricao"></textarea>

                                        <label for="data_conclusao">Data de Conclusão:</label>
                                        <input type="date" id="data_conclusao" name="data_conclusao">

                                        <label for="imagem">Imagem:</label>
                                        <input type="file" id="imagem" name="imagem" accept="image/*">
                                        <!-- Opção para remover a imagem atual -->
                                        <div id="imagem-atual-container">
                                            <p>Imagem atual: <a id="imagem-atual-link" target="_blank">Ver imagem</a></p>
                                            <label>
                                                <input type="checkbox" id="remover_imagem" name="remover_imagem"> Remover
                                                imagem
                                                atual
                                            </label>
                                        </div>
                                        <button type="submit" class="form-tarefa">Salvar Alterações</button>
                                    </form>
                                </div>
                            </div>
                            <!-- Modal de Confirmação para Excluir Tarefa -->
                            <div id="modal-excluir" class="modal">
                                <div class="modal-conteudo">
                                    <span class="fechar-modal">&times;</span>
                                    <h2>Confirmar Exclusão</h2>
                                    <p>Tem certeza que deseja excluir esta tarefa?</p>
                                    <form id="form-excluir-tarefa" method="POST" action="../actions/excluir_tarefa.php">
                                        <input type="hidden" id="id_tarefa_excluir" name="id_tarefa">
                                        <button type="submit" class="btn-confirmar">Sim, Excluir</button>
                                        <button type="button" class="btn-cancelar">Cancelar</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Repetir para cada tarefa -->
                <?php } ?>
                <!--fecha o foreach-->
                <?php
            }
            ?>
            <!--fecha o else-->
        </div>
    </div>

    <script src="/assets/js/modal.js">

    </script>
    <script src="/assets/js/scripts.js">

    </script>
    <script>
        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleString('pt-BR', {
                weekday: 'long',
                year: 'numeric',
                month: 'long',
                day: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit'
            });
            document.getElementById('current-time').textContent = timeString;
        }

        setInterval(updateTime, 1000); // Atualiza a cada 1 segundo
        updateTime(); // Executa imediatamente ao carregar a página
    </script>
</body>

</html>