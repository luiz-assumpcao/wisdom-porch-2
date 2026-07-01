<?php
session_start();

if (isset($_SESSION['login'])) {
    header('Location: painel.php');
    exit();
}

$mensagemErro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'bd/bd.php';

    $login = $conexao->real_escape_string($_POST['login'] ?? '');
    $senha = $conexao->real_escape_string($_POST['senha'] ?? '');

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
    <link rel="stylesheet" href="css/style.css" />
    <link rel="icon" type="image/x-icon" href="img/favicon.png.png" />
    <title>Admin Login</title>
</head>

<body class="pagina-auth">
    <main>
        <section id="secao-auth">
            <h1>Wisdom Porch</h1>
            <p class="subtitulo">Administrator Access</p>

            <?php if ($mensagemErro !== ''): ?>
                <p class="mensagem-erro"><?php echo $mensagemErro; ?></p>
            <?php endif; ?>

            <form action="login.php" method="post">
                <div class="campo-formulario">
                    <label for="campo-login">Login</label>
                    <input type="text" name="login" id="campo-login" required />
                </div>
                <div class="campo-formulario">
                    <label for="campo-senha">Password</label>
                    <input type="password" name="senha" id="campo-senha" required />
                </div>
                <button type="submit" class="botao-formulario">Sign In</button>
            </form>

            <p class="rodape-auth">
                No account yet? <a href="cadastro.php">Create one</a>
            </p>
        </section>
    </main>
</body>

</html>