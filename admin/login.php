<?php
session_start();

// Verifica se o usuário está logado, caso esteja redireciona para a página de painel.
if (isset($_SESSION['login'])) {
    header('Location: painel.php');
    exit();
}

$mensagemErro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require '../bd/bd.php';

    $login = $conexao->real_escape_string(trim($_POST['login'] ?? ''));
    $senha = $conexao->real_escape_string(trim($_POST['senha'] ?? ''));

    $sql = "SELECT id, login FROM administrador WHERE login = '$login' AND senha = md5('$senha')";
    $resultado = $conexao->query($sql);

    if ($resultado && $resultado->num_rows === 1) {
        $linha = $resultado->fetch_assoc();
        $_SESSION['login'] = $linha['login'];
        $_SESSION['id_admin'] = $linha['id'];
        header('Location: painel.php');
        exit();
    } else {
        $mensagemErro = 'Invalid login or password.';
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
    <title>Admin Login</title>
</head>

<body class="pagina-auth pagina-admin">
    <main>
        <section id="secao-auth">
            <h1><a href="../index.php">Wisdom Porch</a></h1>
            <p class="subtitulo">Administrator Access</p>

            <?php if ($mensagemErro !== ''): ?>
                <p class="mensagem-erro"><?php echo $mensagemErro; ?></p>
            <?php endif; ?>

            <form action="login.php" method="post">
                <div class="campo-formulario">
                    <label for="campo-login">Login</label>
                    <input type="text" name="login" id="campo-login" class="campo-sem-espaco" required />
                </div>
                <div class="campo-formulario">
                    <label for="campo-senha">Password</label>
                    <div class="input-com-icone">
                        <input type="password" name="senha" id="campo-senha" class="campo-sem-espaco" required />
                        <span class="icone-olho" data-campos="campo-senha" onclick="alternarVisibilidadeSenha(this)">
                            <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" />
                                <circle cx="12" cy="12" r="3" />
                                <line x1="2" y1="2" x2="22" y2="22" />
                            </svg>
                        </span>
                    </div>
                </div>
                <button type="submit" class="botao-formulario">Sign In</button>
            </form>

            <p class="rodape-auth">
                No account yet? <a href="cadastro.php">Create one</a>
            </p>
        </section>
    </main>
    <footer>
        <p>© 2026 Wisdom Porch</p>
    </footer>
    <script src="../script/auth.js"></script>
</body>

</html>