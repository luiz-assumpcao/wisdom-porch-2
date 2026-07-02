<?php
session_start();
require 'bd/bd.php';

$nome = $_SESSION['nome'] ?? '';
$email = $_SESSION['email'] ?? '';
$dataNascimento = $_SESSION['dataNascimento'] ?? '';
$idEscolaFavorita = $_SESSION['escolaFavorita'] ?? '';

$nomeEscola = '';

if ($idEscolaFavorita !== '') {
    $idEscolaEscapado = $conexao->real_escape_string($idEscolaFavorita);
    $sqlEscola = "SELECT nome_escola FROM escola WHERE id = '$idEscolaEscapado'";
    $resultadoEscola = $conexao->query($sqlEscola);

    if ($resultadoEscola && $resultadoEscola->num_rows === 1) {
        $linhaEscola = $resultadoEscola->fetch_assoc();
        $nomeEscola = $linhaEscola['nome_escola'];
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
    <title>Form Action</title>
</head>

<body>
    <nav>
        <h1>Wisdom Porch</h1>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="form.php">Newsletter</a></li>
            <li><a href="about.php">About Us</a></li>
        </ul>
    </nav>
    <main>
        <section id="secao-dados">
            <h2>Subscription Confirmed</h2>
            <div class="dado-recebido">
                <span class="dado-label">Name</span>
                <span><?php echo $nome; ?></span>
            </div>
            <div class="dado-recebido">
                <span class="dado-label">Email</span>
                <span><?php echo $email; ?></span>
            </div>
            <div class="dado-recebido">
                <span class="dado-label">Birthdate</span>
                <span><?php echo $dataNascimento; ?></span>
            </div>
            <div class="dado-recebido">
                <span class="dado-label">Favorite School</span>
                <span><?php echo htmlspecialchars($nomeEscola); ?></span>
            </div>
        </section>
    </main>
    <footer>
        <a id="link-admin" href="login.php">Admin</a>
        <p>© 2026 Wisdom Porch</p>
        <a href="formAction.php">Form Data</a>
    </footer>
</body>

</html>