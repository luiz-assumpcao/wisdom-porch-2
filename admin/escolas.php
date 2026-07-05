<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}

require '../bd/bd.php';

$acao = $_GET['acao'] ?? 'listar';
$idSelecionado = $_GET['id'] ?? null;
$mensagemErro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operacao = $_POST['operacao'] ?? '';

    if ($operacao === 'criar' || $operacao === 'editar') {
        $nomeEscola = trim($_POST['nome_escola'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $idRegistro = $_POST['id'] ?? null;

        if ($nomeEscola === '') {
            $mensagemErro = 'Please fill in the school name.';
            $acao = $operacao;
            $idSelecionado = $idRegistro;
        } else {
            $nomeEscapado = $conexao->real_escape_string($nomeEscola);

            $sqlDuplicado = "SELECT id FROM escola WHERE nome_escola = '$nomeEscapado'";
            if ($operacao === 'editar' && $idRegistro) {
                $idRegistroEscapado = $conexao->real_escape_string($idRegistro);
                $sqlDuplicado .= " AND id != '$idRegistroEscapado'";
            }
            $resultadoDuplicado = $conexao->query($sqlDuplicado);

            if ($resultadoDuplicado && $resultadoDuplicado->num_rows > 0) {
                $mensagemErro = 'A school with this name already exists.';
                $acao = $operacao;
                $idSelecionado = $idRegistro;
            } else {
                $descricaoEscapada = $conexao->real_escape_string($descricao);

                if ($operacao === 'criar') {
                    $sql = "INSERT INTO escola (nome_escola, descricao) VALUES ('$nomeEscapado', '$descricaoEscapada')";
                } else {
                    $idRegistroEscapado = $conexao->real_escape_string($idRegistro);
                    $sql = "UPDATE escola SET nome_escola='$nomeEscapado', descricao='$descricaoEscapada' WHERE id='$idRegistroEscapado'";
                }
                $conexao->query($sql);
                header('Location: escolas.php');
                exit();
            }
        }
    } elseif ($operacao === 'excluir') {
        $idEscapado = $conexao->real_escape_string($_POST['id'] ?? '');
        $conexao->query("DELETE FROM escola WHERE id='$idEscapado'");
        header('Location: escolas.php');
        exit();
    }
}

$registro = null;
if (($acao === 'editar' || $acao === 'excluir') && $idSelecionado) {
    $idEscapado = $conexao->real_escape_string($idSelecionado);
    $sqlRegistro = "SELECT * FROM escola WHERE id = '$idEscapado'";
    $resultadoRegistro = $conexao->query($sqlRegistro);
    $registro = $resultadoRegistro ? $resultadoRegistro->fetch_assoc() : null;
}

if ($acao === 'listar') {
    $sql = "SELECT id, nome_escola, descricao FROM escola ORDER BY id";
    $resultado = $conexao->query($sql);
}
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

<body class="pagina-admin">
    <a href="painel.php" id="link-voltar" aria-label="Back to panel">
        <svg viewBox="0 0 24 24" width="32" height="32" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
            <path d="M9 14 4 9l5-5" />
            <path d="M4 9h10.5a5.5 5.5 0 0 1 0 11H11" />
        </svg>
    </a>
    <header class="cabecalho-listagem">
        <h1><a href="../index.php">Wisdom Porch</a></h1>
        <p class="subtitulo-admin"><a href="painel.php">Administrator Panel</a></p>
    </header>
    <main>
        <div class="layout-listagem">
            <aside class="secao-estatisticas"></aside>
            <section class="secao-listagem">
                <div class="cabecalho-tabela">
                    <h2>
                        <?php
                        if ($acao === 'criar') {
                            echo 'Add School';
                        } elseif ($acao === 'editar') {
                            echo 'Edit School';
                        } elseif ($acao === 'excluir') {
                            echo 'Delete School';
                        } else {
                            echo 'Schools of Thought';
                        }
                        ?>
                    </h2>
                    <?php if ($acao === 'listar'): ?>
                        <a href="?acao=criar" class="botao-formulario botao-adicionar">Add School</a>
                    <?php endif; ?>
                </div>
                <div class="container-tabela">
                    <?php if ($acao === 'criar' || $acao === 'editar'): ?>
                        <div class="formulario-crud">
                            <a href="assinantes.php" class="link-voltar-formulario" aria-label="Back to list">
                                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 14 4 9l5-5" />
                                    <path d="M4 9h10.5a5.5 5.5 0 0 1 0 11H11" />
                                </svg>
                            </a>
                            <?php if ($mensagemErro !== ''): ?>
                                <p class="mensagem-erro"><?php echo htmlspecialchars($mensagemErro); ?></p>
                            <?php endif; ?>
                            <form method="post" id="form-escola">
                                <input type="hidden" name="operacao" value="<?php echo $acao; ?>" />
                                <?php if ($acao === 'editar'): ?>
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($registro['id']); ?>" />
                                <?php endif; ?>
                                <div class="campo-formulario">
                                    <label>Name</label>
                                    <input type="text" name="nome_escola" value="<?php echo htmlspecialchars($registro['nome_escola'] ?? ''); ?>" required />
                                </div>
                                <div class="campo-formulario">
                                    <label>Description</label>
                                    <input type="text" name="descricao" value="<?php echo htmlspecialchars($registro['descricao'] ?? ''); ?>" />
                                </div>
                                <div class="acoes-formulario">
                                    <a href="escolas.php" class="botao-formulario">Cancel</a>
                                    <?php if ($acao === 'criar'): ?>
                                        <button type="submit" class="botao-formulario">Save</button>
                                    <?php else: ?>
                                        <button type="button" class="botao-formulario"
                                            onclick="confirmarEnvio(this.form, 'Are you sure you want to save these changes? This action is irreversible.')">
                                            Confirm Edit
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </form>
                        </div>
                    <?php elseif ($acao === 'excluir' && $registro): ?>
                        <div class="formulario-crud">
                            <a href="assinantes.php" class="link-voltar-formulario" aria-label="Back to list">
                                <svg viewBox="0 0 24 24" width="24" height="24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M9 14 4 9l5-5" />
                                    <path d="M4 9h10.5a5.5 5.5 0 0 1 0 11H11" />
                                </svg>
                            </a>
                            <div class="campo-formulario">
                                <label>Name</label>
                                <p class="valor-exclusao"><?php echo htmlspecialchars($registro['nome_escola']); ?></p>
                            </div>
                            <div class="campo-formulario">
                                <label>Description</label>
                                <p class="valor-exclusao"><?php echo htmlspecialchars($registro['descricao'] ?? ''); ?></p>
                            </div>
                            <form method="post" id="form-excluir-escola">
                                <input type="hidden" name="operacao" value="excluir" />
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($registro['id']); ?>" />
                                <div class="acoes-formulario">
                                    <a href="escolas.php" class="botao-formulario">Cancel</a>
                                    <button type="button" class="botao-formulario botao-excluir-confirmar"
                                        onclick="confirmarEnvio(this.form, 'Are you sure you want to delete this school? This action is irreversible.')">
                                        Confirm Delete
                                    </button>
                                </div>
                            </form>
                        </div>
                    <?php else: ?>
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
                                        <td colspan="4">No schools registered yet.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php while ($linha = $resultado->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $linha['id']; ?></td>
                                            <td><?php echo htmlspecialchars($linha['nome_escola']); ?></td>
                                            <td><?php echo htmlspecialchars($linha['descricao'] ?? ''); ?></td>
                                            <td class="celula-acoes">
                                                <a href="?acao=editar&id=<?php echo $linha['id']; ?>" class="icone-acao icone-editar" title="Edit">
                                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M12 20h9" />
                                                        <path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z" />
                                                    </svg>
                                                </a>
                                                <a href="?acao=excluir&id=<?php echo $linha['id']; ?>" class="icone-acao icone-excluir" title="Delete">
                                                    <svg viewBox="0 0 24 24" width="18" height="18" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M3 6h18" />
                                                        <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2" />
                                                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                                                        <line x1="10" y1="11" x2="10" y2="17" />
                                                        <line x1="14" y1="11" x2="14" y2="17" />
                                                    </svg>
                                                </a>
                                            </td>
                                        </tr>
                                    <?php } ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
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