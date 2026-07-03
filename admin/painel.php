<?php
session_start();

if (!isset($_SESSION['login'])) {
    header('Location: login.php');
    exit();
}
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/style.css" />
    <link rel="icon" type="image/x-icon" href="../img/favicon.png.png" />
    <title>Admin Panel</title>
</head>

<body>
    <header id="cabecalho-admin">
        <h1><a href="../index.php">Wisdom Porch</a></h1>
        <p class="subtitulo-admin">Administrator Panel</p>
    </header>
    <main>
        <section id="secao-painel">
            <p class="boas-vindas">Welcome, <?php echo htmlspecialchars($_SESSION['login']); ?></p>

            <div id="menu-admin">
                <a href="assinantes.php" class="cartao-admin">
                    <h2>Subscribers</h2>
                    <p>View and remove newsletter subscribers</p>
                </a>
                <a href="escolas.php" class="cartao-admin">
                    <h2>Schools of Thought</h2>
                    <p>Add, edit, or remove philosophical schools</p>
                </a>
            </div>

            <a href="logout.php" id="link-logout">Log Out</a>
        </section>
    </main>
    <footer>
        <p>© 2026 Wisdom Porch</p>
    </footer>
</body>

</html>