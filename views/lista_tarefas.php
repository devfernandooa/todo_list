<?php
require_once '../models/tarefas.php';
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header('Location: login.php');
    exit();
}
$id_usuario = $_SESSION['id_usuario'];
$tarefas = listarTarefas($id_usuario);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Todo List</title>
    <link rel="stylesheet" href="../assets/css/home_style.css">
    <link rel="stylesheet" href="../assets/css/modal.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
    <div class="app-layout">
        <!-- Sidebar: Dados do Usuário e Menu de Navegação -->
        <aside class="sidebar">
            <div class="user-profile">
                <div class="avatar">
                    <i class="fas fa-user-circle"></i>
                </div>
                <div class="user-info">
                    <h3><?= htmlspecialchars($_SESSION['nome']); ?></h3>
                    <p><i class="fas fa-envelope"></i> <?= htmlspecialchars($_SESSION['email']); ?></p>
                </div>
            </div>

            <nav class="sidebar-menu">
                <ul>
                    <li class="active">
                        <a href="#"><i class="fas fa-list-check"></i> Minhas Tarefas</a>
                    </li>
                    <li>
                        <a href="#form-tarefa-section"><i class="fas fa-plus-circle"></i> Nova Tarefa</a>
                    </li>
                </ul>
            </nav>

            <div class="sidebar-footer">
                <div class="current-time">
                    <i class="far fa-clock"></i>
                    <p id="current-time"></p>
                </div>
                <a href="../actions/logout.php" class="btn-logout"><i class="fas fa-sign-out-alt"></i> Sair</a>
            </div>
        </aside>

        <!-- Conteúdo Principal (Main) -->
        <main class="main-content">
            <!-- Formulário de Adição de Tarefas -->
            <section id="form-tarefa-section" class="card-section">
                <h2><i class="fas fa-plus-circle"></i> Adicionar Nova Tarefa</h2>
                <form action="../actions/adicionar_tarefa.php" method="POST" enctype="multipart/form-data" class="form-tarefa">
                    <div class="form-group">
                        <input type="text" name="titulo" placeholder="Título da tarefa" required>
                    </div>
                    <div class="form-group">
                        <textarea name="descricao" placeholder="Descrição (opcional)"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="data_conclusao_add">Data Limite:</label>
                            <input type="date" id="data_conclusao_add" name="data_conclusao">
                        </div>
                        <div class="form-group">
                            <label for="imagem_add">Anexo/Imagem:</label>
                            <input type="file" id="imagem_add" name="imagem" accept="image/*">
                        </div>
                    </div>
                    <button type="submit" class="btn-submit"><i class="fas fa-plus"></i> Criar Tarefa</button>
                </form>
            </section>

            <!-- Mensagens de Erro ou Sucesso -->
            <?php if (isset($_GET['sucesso'])): ?>
                <div class="mensagem sucesso">
                    <i class="fas fa-check-circle"></i> <?= htmlspecialchars($_GET['sucesso']); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['erro'])): ?>
                <div class="mensagem erro">
                    <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($_GET['erro']); ?>
                </div>
            <?php endif; ?>

            <!-- Lista de Tarefas em Acordeão -->
            <section class="card-section">
                <h2><i class="fas fa-tasks"></i> Suas Tarefas</h2>
                <div class="accordion-container">
                    <?php if (empty($tarefas)): ?>
                        <div class="empty-state">
                            <i class="fas fa-clipboard-list"></i>
                            <p>Nenhuma tarefa cadastrada. Adicione uma nova no formulário acima!</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($tarefas as $tarefa): ?>
                            <div class="accordion-item <?= $tarefa['concluida'] ? 'tarefa-concluida' : ''; ?>">
                                <button type="button" class="accordion-header" onclick="toggleAccordion(this)">
                                    <div class="accordion-title">
                                        <i class="fas fa-chevron-right chevron-icon"></i>
                                        <span><?= htmlspecialchars($tarefa['titulo']); ?></span>
                                    </div>
                                    <span class="status-badge <?= $tarefa['concluida'] ? 'status-concluida' : 'status-pendente'; ?>">
                                        <?= $tarefa['concluida'] ? 'Concluída' : 'Pendente'; ?>
                                    </span>
                                </button>

                                <div class="accordion-body">
                                    <div class="accordion-content-inner">
                                        <?php if (!empty($tarefa['descricao'])): ?>
                                            <p class="descricao"><strong>Descrição:</strong> <?= htmlspecialchars($tarefa['descricao']); ?></p>
                                        <?php else: ?>
                                            <p class="descricao text-muted"><em>Sem descrição informada.</em></p>
                                        <?php endif; ?>

                                        <?php if (!empty($tarefa['imagem'])): ?>
                                            <div class="imagem-container">
                                                <img src="<?= htmlspecialchars($tarefa['imagem']); ?>" alt="Imagem da Tarefa" class="imagem-tarefa">
                                            </div>
                                        <?php endif; ?>

                                        <div class="datas-info">
                                            <p><i class="far fa-calendar-alt"></i> <strong>Data de Conclusão:</strong>
                                                <?= !empty($tarefa['data_conclusao']) ? htmlspecialchars($tarefa['data_conclusao']) : 'Não definida'; ?>
                                            </p>
                                        </div>

                                        <div class="acoes">
                                            <button type="button" class="btn-editar"
                                                onclick="abrirModalEditar(
                                                    '<?= $tarefa['id_tarefa']; ?>',
                                                    '<?= htmlspecialchars($tarefa['titulo']); ?>',
                                                    '<?= htmlspecialchars($tarefa['descricao']); ?>',
                                                    '<?= htmlspecialchars($tarefa['data_conclusao']); ?>',
                                                    '<?= !empty($tarefa['imagem']) ? htmlspecialchars($tarefa['imagem']) : ''; ?>')">
                                                <i class="fas fa-edit"></i> Editar
                                            </button>

                                            <form action="../actions/concluir_tarefa.php" method="POST" class="form-inline">
                                                <input type="hidden" name="id_tarefa" value="<?= $tarefa['id_tarefa']; ?>">
                                                <button type="submit" class="btn-concluir">
                                                    <i class="far <?= $tarefa['concluida'] ? 'fa-undo' : 'fa-check-circle'; ?>"></i>
                                                    <?= $tarefa['concluida'] ? 'Desmarcar' : 'Concluir'; ?>
                                                </button>
                                            </form>

                                            <button type="button" class="btn-excluir" onclick="abrirModalExcluir(<?= $tarefa['id_tarefa']; ?>)">
                                                <i class="fas fa-trash"></i> Excluir
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </section>

            <!-- Modal Editar Tarefa -->
            <div id="modal-editar" class="modal">
                <div class="modal-conteudo">
                    <p class="fechar-modal" onclick="fecharModalEditar()">X</p>
                    <h2><i class="fas fa-edit"></i> Editar Tarefa</h2>
                    <p class="tarefa-id-info"><strong>ID:</strong> <span id="id-tarefa-editar"></span></p>

                    <form id="form-editar-tarefa" action="../actions/processa_editar_tarefa.php" method="POST" enctype="multipart/form-data" class="form-editar">
                        <input type="hidden" id="id_tarefa" name="id_tarefa">

                        <div class="form-group">
                            <label for="titulo">Título:</label>
                            <input type="text" id="titulo" name="titulo" required placeholder="Digite o título">
                        </div>

                        <div class="form-group">
                            <label for="descricao">Descrição:</label>
                            <textarea id="descricao" name="descricao" rows="3" placeholder="Digite a descrição"></textarea>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="data_conclusao">Data de Conclusão:</label>
                                <input type="date" id="data_conclusao" name="data_conclusao">
                            </div>

                            <div class="form-group">
                                <label for="imagem">Imagem/Anexo:</label>
                                <input type="file" id="imagem" class="btn-imagem-modal" name="imagem" accept="image/*">
                            </div>
                        </div>

                        <div id="imagem-atual-container" class="imagem-atual-box">
                            <p>Imagem atual: <a id="imagem-atual-link" target="_blank">Ver imagem</a></p>
                            <label class="checkbox-label">
                                <input type="checkbox" id="remover_imagem" name="remover_imagem"> Remover imagem atual
                            </label>
                        </div>

                        <div class="modal-botoes">
                            <button type="button" class="btn-descartar" onclick="fecharModalEditar()">
                                <i class="fas fa-times"></i> Descartar
                            </button>
                            <button type="submit" class="btn-submit">
                                <i class="fas fa-save"></i> Salvar Alterações
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Excluir Tarefa -->
            <div id="modal-excluir" class="modal">
                <div class="modal-conteudo">
                    <span class="fechar-modal" onclick="fecharModalExcluir()">&times;</span>
                    <h2>Confirmar Exclusão</h2>
                    <p>Tem certeza de que deseja excluir esta tarefa?</p>
                    <form id="form-excluir-tarefa" method="POST" action="../actions/excluir_tarefa.php">
                        <input type="hidden" id="id_tarefa_excluir" name="id_tarefa">
                        <div class="modal-botoes">
                            <button type="button" class="btn-descartar" onclick="fecharModalExcluir()">Cancelar</button>
                            <button type="submit" class="btn-excluir">Sim, Excluir</button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script src="../assets/js/modal.js"></script>
    <script src="../assets/js/scripts.js"></script>
    <script>
        function toggleAccordion(button) {
            const item = button.parentElement;
            item.classList.toggle('active');
        }

        function updateTime() {
            const now = new Date();
            const timeString = now.toLocaleString('pt-BR', {
                weekday: 'short',
                day: '2-digit',
                month: 'short',
                hour: '2-digit',
                minute: '2-digit'
            });
            document.getElementById('current-time').textContent = timeString;
        }
        setInterval(updateTime, 1000);
        updateTime();
    </script>
</body>

</html>