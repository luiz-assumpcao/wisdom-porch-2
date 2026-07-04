<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}

require '../bd/bd.php';

$sql = "SELECT id, nome_escola, descricao FROM escola ORDER BY id";
$resultado = $conexao->query($sql);
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="icon" type="image/x-icon" href="../img/favicon.png.png" />
    <title>Schools of Thought</title>
</head>

<body>
    <a href="painel.php" id="link-voltar" aria-label="Back to panel">
        <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 14 4 9l5-5" />
            <path d="M4 9h10.5a5.5 5.5 0 0 1 0 11H11" />
        </svg>
    </a>
    <header class="cabecalho-listagem">
        <h1><a href="../index.php">Wisdom Porch</a></h1>
        <p class="subtitulo-admin">Administrator Panel</p>
    </header>
    <main>
        <div class="layout-listagem">
            <aside class="secao-estatisticas">
                <!-- Reservado para estatísticas -->
            </aside>
            <section class="secao-listagem">
                <div class="cabecalho-tabela">
                    <h2>Schools of Thought</h2>
                    <a href="#" class="botao-formulario botao-adicionar">Add School</a>
                </div>
                <div class="container-tabela">
                    <table class="tabela-admin">
                        <thead>
                            <tr>
                                <th data-tipo="numero">ID</th>
                                <th data-tipo="texto">Name</th>
                                <th data-tipo="texto">Description</th>
                                <th class="th-acoes">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if ($resultado->num_rows === 0): ?>
                                <tr>
                                    <td colspan="3">No schools registered yet.</td>
                                </tr>
                            <?php else: ?>
                                <?php while ($linha = $resultado->fetch_assoc()) { ?>
                                    <tr>
                                        <td><?php echo $linha['id']; ?></td>
                                        <td><?php echo htmlspecialchars($linha['nome_escola']); ?></td>
                                        <td><?php echo htmlspecialchars($linha['descricao'] ?? ''); ?></td>
                                        <td class="celula-acoes">
                                            <span class="icone-acao icone-editar" title="Edit">
                                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M12 20h9" />
                                                    <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                                </svg>
                                            </span>
                                            <span class="icone-acao icone-excluir" title="Delete">
                                                <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M3 6h18" />
                                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                                    <line x1="10" y1="11" x2="10" y2="17" />
                                                    <line x1="14" y1="11" x2="14" y2="17" />
                                                </svg>
                                            </span>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
    <footer>
        <p>© 2026 Wisdom Porch</p>
    </footer>
    <script src="../script/admin.js"></script>
</body>

</html>