<?php
session_start();

if (isset($_SESSION['login'])) {
    header('Location: painel.php');
    exit();
}

$mensagemErro = '';
$mensagemSucesso = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require 'bd/bd.php';

    $login = $conexao->real_escape_string(trim($_POST['login'] ?? ''));
    $senha = $conexao->real_escape_string($_POST['senha'] ?? '');

    if ($login === '' || $senha === '') {
        $mensagemErro = 'Please fill in all fields.';
    } else {
        $sqlVerifica = "SELECT id FROM administrador WHERE login = '$login'";
        $resultadoVerifica = $conexao->query($sqlVerifica);

        if ($resultadoVerifica && $resultadoVerifica->num_rows > 0) {
            $mensagemErro = 'This login is already taken.';
        } else {
            $sqlInsere = "INSERT INTO administrador (login, senha) VALUES ('$login', md5('$senha'))";

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
    <link rel="stylesheet" href="css/style.css" />
    <link rel="icon" type="image/x-icon" href="img/favicon.png.png" />
    <title>Admin Registration</title>
</head>

<body class="pagina-auth">
    <main>
        <section id="secao-auth">
            <h1>Wisdom Porch</h1>
            <p class="subtitulo">Create Administrator Account</p>

            <?php if ($mensagemErro !== ''): ?>
                <p class="mensagem-erro"><?php echo $mensagemErro; ?></p>
            <?php endif; ?>

            <?php if ($mensagemSucesso !== ''): ?>
                <p class="mensagem-sucesso"><?php echo $mensagemSucesso; ?></p>
            <?php endif; ?>

            <form action="cadastro.php" method="post">
                <div class="campo-formulario">
                    <label for="campo-login">Login</label>
                    <input type="text" name="login" id="campo-login" required />
                </div>
                <div class="campo-formulario">
                    <label for="campo-senha">Password</label>
                    <input type="password" name="senha" id="campo-senha" required />
                </div>
                <button type="submit" class="botao-formulario">Create Account</button>
            </form>

            <p class="rodape-auth">
                Already have an account? <a href="login.php">Sign in</a>
            </p>
        </section>
    </main>
</body>

</html>