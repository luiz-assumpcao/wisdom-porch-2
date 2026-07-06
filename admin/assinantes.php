<?php
session_start();

// Verifica se o usuário está logado, caso contrário redireciona para a página de login.
if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}

require '../bd/bd.php';

function calcularIdade($dataNascimento)
{
    $nascimento = new DateTime($dataNascimento);
    $hoje = new DateTime();
    return $hoje->diff($nascimento)->y;
}

function formatarTelefone($digitos)
{
    $codigoPais = substr($digitos, 0, 2);
    $ddd = substr($digitos, 2, 2);
    $numero = substr($digitos, 4);
    return '+' . $codigoPais . ' ' . $ddd . ' ' . $numero;
}

$acao = $_GET['acao'] ?? 'listar';
$idSelecionado = $_GET['id'] ?? null;
$mensagemErro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $operacao = $_POST['operacao'] ?? '';

    if ($operacao === 'criar' || $operacao === 'editar') {
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telefoneInput = trim($_POST['telefone'] ?? '');
        $dataNascimento = trim($_POST['data-nascimento'] ?? '');
        $idEscola = trim($_POST['escola'] ?? '');
        $idRegistro = $_POST['id'] ?? null;
        $telefoneDigitos = preg_replace('/\D/', '', $telefoneInput);
        $primeiroNome = preg_split('/\s+/', $nome)[0] ?? '';

        if ($nome === '' || $email === '' || $telefoneDigitos === '' || $dataNascimento === '' || $idEscola === '') {
            $mensagemErro = 'Please fill in all fields correctly.';
            $acao = $operacao;
            $idSelecionado = $idRegistro;
        } else {
            $emailEscapado = $conexao->real_escape_string($email);
            $telefoneEscapado = $conexao->real_escape_string($telefoneDigitos);

            $sqlDuplicado = "SELECT id FROM assinante WHERE (email = '$emailEscapado' OR telefone = '$telefoneEscapado')";
            if ($operacao === 'editar' && $idRegistro) {
                $idRegistroEscapado = $conexao->real_escape_string($idRegistro);
                $sqlDuplicado .= " AND id != '$idRegistroEscapado'";
            }
            $resultadoDuplicado = $conexao->query($sqlDuplicado);

            if ($resultadoDuplicado && $resultadoDuplicado->num_rows > 0) {
                $mensagemErro = 'A subscriber with this email or phone number already exists.';
                $acao = $operacao;
                $idSelecionado = $idRegistro;
            } else {
                $nomeEscapado = $conexao->real_escape_string($primeiroNome);
                $dataEscapada = $conexao->real_escape_string($dataNascimento);
                $idEscolaEscapado = $conexao->real_escape_string($idEscola);

                if ($operacao === 'criar') {
                    // INSERT: cadastra um novo assinante no banco de dados.
                    $sql = "INSERT INTO assinante (primeiro_nome, email, telefone, data_nascimento, id_escola)
                            VALUES ('$nomeEscapado', '$emailEscapado', '$telefoneEscapado', '$dataEscapada', '$idEscolaEscapado')";
                } else {
                    $idRegistroEscapado = $conexao->real_escape_string($idRegistro);
                    // UPDATE: atualiza os dados de um assinante já existente.
                    $sql = "UPDATE assinante SET primeiro_nome='$nomeEscapado', email='$emailEscapado',
                            telefone='$telefoneEscapado', data_nascimento='$dataEscapada', id_escola='$idEscolaEscapado'
                            WHERE id='$idRegistroEscapado'";
                }
                $conexao->query($sql);
                header('Location: assinantes.php');
                exit();
            }
        }
    } elseif ($operacao === 'excluir') {
        // DELETE: remove um assinante do banco de dados.
        $idEscapado = $conexao->real_escape_string($_POST['id'] ?? '');
        $conexao->query("DELETE FROM assinante WHERE id='$idEscapado'");
        header('Location: assinantes.php');
        exit();
    }
}

$registro = null;
if (($acao === 'editar' || $acao === 'excluir') && $idSelecionado) {
    $idEscapado = $conexao->real_escape_string($idSelecionado);
    $sqlRegistro = "SELECT assinante.*, nome_escola FROM assinante
                    INNER JOIN escola ON assinante.id_escola = escola.id
                    WHERE assinante.id = '$idEscapado'";
    $resultadoRegistro = $conexao->query($sqlRegistro);
    $registro = $resultadoRegistro ? $resultadoRegistro->fetch_assoc() : null;
}

$escolasDisponiveis = [];
if ($acao === 'criar' || $acao === 'editar') {
    $resultadoEscolas = $conexao->query("SELECT id, nome_escola FROM escola ORDER BY (nome_escola = 'Other') ASC, nome_escola ASC");
    while ($linha = $resultadoEscolas->fetch_assoc()) {
        $escolasDisponiveis[] = $linha;
    }
}

if ($acao === 'listar') {
    // SELECT: consulta e lista todos os assinantes cadastrados.
    $sql = "SELECT assinante.id, primeiro_nome, email, telefone, data_nascimento, nome_escola
            FROM assinante
            INNER JOIN escola ON assinante.id_escola = escola.id
            ORDER BY assinante.id";
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
    <title>Subscribers</title>
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
                            echo 'Add Subscriber';
                        } elseif ($acao === 'editar') {
                            echo 'Edit Subscriber';
                        } elseif ($acao === 'excluir') {
                            echo 'Delete Subscriber';
                        } else {
                            echo 'Subscribers';
                        }
                        ?>
                    </h2>
                    <?php if ($acao === 'listar'): ?>
                        <a href="?acao=criar" class="botao-formulario botao-adicionar">Add Subscriber</a>
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
                            <form method="post" id="form-assinante">
                                <input type="hidden" name="operacao" value="<?php echo $acao; ?>" />
                                <?php if ($acao === 'editar'): ?>
                                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($registro['id']); ?>" />
                                <?php endif; ?>
                                <div class="campo-formulario">
                                    <label>Name</label>
                                    <input type="text" name="nome" value="<?php echo htmlspecialchars($registro['primeiro_nome'] ?? ''); ?>" required />
                                </div>
                                <div class="campo-formulario">
                                    <label>Email</label>
                                    <input type="email" name="email" value="<?php echo htmlspecialchars($registro['email'] ?? ''); ?>" required />
                                </div>
                                <div class="campo-formulario">
                                    <label>Phone</label>
                                    <input type="tel" name="telefone" id="campo-telefone-crud"
                                        value="<?php echo $registro ? htmlspecialchars('+' . $registro['telefone']) : ''; ?>" required />
                                </div>
                                <div class="campo-formulario">
                                    <label>Date of Birth</label>
                                    <input type="date" name="data-nascimento" value="<?php echo htmlspecialchars($registro['data_nascimento'] ?? ''); ?>" required />
                                </div>
                                <div class="campo-formulario">
                                    <label>School</label>
                                    <select name="escola" required>
                                        <?php foreach ($escolasDisponiveis as $escola): ?>
                                            <option value="<?php echo $escola['id']; ?>"
                                                <?php echo (isset($registro['id_escola']) && $registro['id_escola'] == $escola['id']) ? 'selected' : ''; ?>>
                                                <?php echo htmlspecialchars($escola['nome_escola']); ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="acoes-formulario">
                                    <a href="assinantes.php" class="botao-formulario">Cancel</a>
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
                                <p class="valor-exclusao"><?php echo htmlspecialchars($registro['primeiro_nome']); ?></p>
                            </div>
                            <div class="campo-formulario">
                                <label>Email</label>
                                <p class="valor-exclusao"><?php echo htmlspecialchars($registro['email']); ?></p>
                            </div>
                            <div class="campo-formulario">
                                <label>Phone</label>
                                <p class="valor-exclusao"><?php echo htmlspecialchars(formatarTelefone($registro['telefone'])); ?></p>
                            </div>
                            <div class="campo-formulario">
                                <label>Age</label>
                                <p class="valor-exclusao"><?php echo calcularIdade($registro['data_nascimento']); ?></p>
                            </div>
                            <div class="campo-formulario">
                                <label>School</label>
                                <p class="valor-exclusao"><?php echo htmlspecialchars($registro['nome_escola']); ?></p>
                            </div>
                            <form method="post" id="form-excluir-assinante">
                                <input type="hidden" name="operacao" value="excluir" />
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($registro['id']); ?>" />
                                <div class="acoes-formulario">
                                    <a href="assinantes.php" class="botao-formulario">Cancel</a>
                                    <button type="button" class="botao-formulario botao-excluir-confirmar"
                                        onclick="confirmarEnvio(this.form, 'Are you sure you want to delete this subscriber? This action is irreversible.')">
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
                                    <th data-tipo="texto">Email</th>
                                    <th data-tipo="numero">Phone</th>
                                    <th data-tipo="numero">Age</th>
                                    <th data-tipo="texto">School</th>
                                    <th class="th-acoes">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($resultado->num_rows === 0): ?>
                                    <tr>
                                        <td colspan="7">No subscribers yet.</td>
                                    </tr>
                                <?php else: ?>
                                    <?php while ($linha = $resultado->fetch_assoc()) { ?>
                                        <tr>
                                            <td><?php echo $linha['id']; ?></td>
                                            <td><?php echo htmlspecialchars($linha['primeiro_nome']); ?></td>
                                            <td><?php echo htmlspecialchars($linha['email']); ?></td>
                                            <td data-valor="<?php echo htmlspecialchars($linha['telefone']); ?>">
                                                <?php echo htmlspecialchars(formatarTelefone($linha['telefone'])); ?>
                                            </td>
                                            <td><?php echo calcularIdade($linha['data_nascimento']); ?></td>
                                            <td><?php echo htmlspecialchars($linha['nome_escola']); ?></td>
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