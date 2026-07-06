<?php
session_start();

// Verifica se o usuário está logado, caso esteja redireciona para a página de painel.
if (isset($_SESSION['login'])) {
    header('Location: painel.php');
    exit();
}

$mensagemErro = '';
$mensagemSucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../bd/bd.php';

    $login = $conexao->real_escape_string(trim($_POST['login'] ?? ''));
    $senha = trim($_POST['senha'] ?? '');
    $confirmarSenha = trim($_POST['confirmar-senha'] ?? '');

    $regexSenhaForte = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{6,}$/';

    if ($login === '' || $senha === '' || $confirmarSenha === '') {
        $mensagemErro = 'Please fill in all fields.';
    } elseif (!preg_match($regexSenhaForte, $senha)) {
        $mensagemErro = 'Password must have 6+ characters, including uppercase, lowercase, a number, and a symbol.';
    } elseif ($senha !== $confirmarSenha) {
        $mensagemErro = 'Passwords do not match.';
    } else {
        $senhaEscapada = $conexao->real_escape_string($senha);

        $sqlVerifica = "SELECT id FROM administrador WHERE login = '$login'";
        $resultadoVerifica = $conexao->query($sqlVerifica);

        if ($resultadoVerifica && $resultadoVerifica->num_rows > 0) {
            $mensagemErro = 'This login is already taken.';
        } else {
            $sqlInsere = "INSERT INTO administrador (login, senha) VALUES ('$login', md5('$senhaEscapada'))";

            if ($conexao->query($sqlInsere) === TRUE) {
                $mensagemSucesso = 'Account created successfully. You can now sign in.';
            } else {
                $mensagemErro = 'Something went wrong: ' . $conexao->error;
            }
        }
    }
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="icon" type="image/x-icon" href="../img/favicon.png.png" />
    <title>Admin Registration</title>
</head>

<body class="pagina-auth pagina-admin">
    <main>
        <section id="secao-auth">
            <h1><a href="../index.php">Wisdom Porch</a></h1>
            <p class="subtitulo">Create Administrator Account</p>

            <?php if ($mensagemErro !== ''): ?>
                <p class="mensagem-erro"><?php echo $mensagemErro; ?></p>
            <?php endif; ?>

            <?php if ($mensagemSucesso !== ''): ?>
                <p class="mensagem-sucesso"><?php echo $mensagemSucesso; ?></p>
            <?php endif; ?>

            <form id="form-cadastro" action="cadastro.php" method="post">
                <div class="campo-formulario">
                    <label for="campo-login">Login</label>
                    <input type="text" name="login" id="campo-login" class="campo-sem-espaco" required />
                </div>
                <div class="campo-formulario">
                    <label for="campo-senha">Password</label>
                    <div class="input-com-icone">
                        <input type="password" name="senha" id="campo-senha" class="campo-sem-espaco" minlength="6"
                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{6,}$"
                            title="At least 6 characters, including uppercase, lowercase, a number, and a symbol."
                            required />
                        <span class="icone-olho" data-campos="campo-senha,campo-confirmar-senha" onclick="alternarVisibilidadeSenha(this)">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" />
                                <circle cx="12" cy="12" r="3" />
                                <line x1="2" y1="2" x2="22" y2="22" />
                            </svg>
                        </span>
                    </div>
                </div>
                <div class="campo-formulario">
                    <label for="campo-confirmar-senha">Confirm Password</label>
                    <div class="input-com-icone">
                        <input type="password" name="confirmar-senha" id="campo-confirmar-senha" class="campo-sem-espaco" minlength="6" required />
                        <span class="icone-olho" data-campos="campo-senha,campo-confirmar-senha" onclick="alternarVisibilidadeSenha(this)">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" />
                                <circle cx="12" cy="12" r="3" />
                                <line x1="2" y1="2" x2="22" y2="22" />
                            </svg>
                        </span>
                    </div>
                </div>
                <p id="mensagem-senha"></p>
                <button type="submit" class="botao-formulario">Create Account</button>
            </form>

            <p class="rodape-auth">
                Already have an account? <a href="login.php">Sign in</a>
            </p>
        </section>
    </main>
    <footer>
        <p>© 2026 Wisdom Porch</p>
    </footer>
    <script src="../script/auth.js"></script>
</body>

</html>