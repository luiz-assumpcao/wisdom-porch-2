<?php
session_start();

$mensagem = '';
$classeMensagem = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $dataNascimento = trim($_POST['data-nascimento'] ?? '');
    $idEscola = trim($_POST['escola-favorita'] ?? '');

    if ($nome !== '' && $email !== '' && $dataNascimento !== '' && $idEscola !== '') {
        require_once 'bd/bd.php';

        $nomeEscapado = $conexao->real_escape_string($nome);
        $emailEscapado = $conexao->real_escape_string($email);
        $dataEscapada = $conexao->real_escape_string($dataNascimento);
        $idEscolaEscapado = $conexao->real_escape_string($idEscola);

        $sqlInsere = "INSERT INTO assinante (nome, email, data_nascimento, id_escola)
                      VALUES ('$nomeEscapado', '$emailEscapado', '$dataEscapada', '$idEscolaEscapado')";

        if ($conexao->query($sqlInsere) === TRUE) {
            $_SESSION['nome'] = htmlspecialchars($nome);
            $_SESSION['email'] = htmlspecialchars($email);
            $_SESSION['dataNascimento'] = htmlspecialchars($dataNascimento);
            $_SESSION['escolaFavorita'] = $idEscolaEscapado;

            $mensagem = 'Your subscription has been confirmed!';
            $classeMensagem = 'mensagem-sucesso';
        } else {
            $mensagem = 'Something went wrong, please try again.';
            $classeMensagem = 'mensagem-erro';
        }
    } else {
        $mensagem = 'Please fill in all fields correctly.';
        $classeMensagem = 'mensagem-erro';
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
    <title>Newsletter</title>
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
        <section id="secao-formulario">
            <h2>Join the Newsletter</h2>
            <p>Receive weekly reflections on philosophy, wisdom, and the examined life.</p>
            <form id="form-newsletter" action="form.php" method="post">
                <div class="campo-formulario">
                    <label for="form-nome">Name</label>
                    <input type="text" name="nome" id="form-nome" placeholder="First name" maxlength="30" required />
                </div>
                <div class="campo-formulario">
                    <label for="form-email">Email</label>
                    <input type="email" name="email" id="form-email" placeholder="youremail@gmail.com" maxlength="40" required />
                </div>
                <div class="campo-formulario">
                    <label for="form-data-nascimento">Date of Birth</label>
                    <input type="date" name="data-nascimento" id="form-data-nascimento" required />
                </div>
                <div class="campo-formulario">
                    <label for="form-escola-favorita">Favorite School of Thought</label>
                    <select name="escola-favorita" id="form-escola-favorita">
                        <?php
                        require 'bd/bd.php';
                        $sqlEscolas = "SELECT id, nome_escola FROM escola ORDER BY id";
                        $resultadoEscolas = $conexao->query($sqlEscolas);
                        while ($linhaEscola = $resultadoEscolas->fetch_assoc()) {
                        ?>
                            <option value="<?php echo $linhaEscola['id']; ?>">
                                <?php echo htmlspecialchars($linhaEscola['nome_escola']); ?>
                            </option>
                        <?php
                        }
                        ?>
                    </select>
                </div>
                <button id="botao-subscribe" type="submit">Subscribe</button>
                <p id="mensagem-confirmacao" class="<?php echo $classeMensagem; ?>"><?php echo $mensagem; ?></p>
            </form>
        </section>
    </main>
    <footer>
        <a id="link-admin" href="login.php">Admin</a>
        <p>© 2026 Wisdom Porch</p>
        <a href="formAction.php">Form Data</a>
    </footer>
    <script src="script/form.js"></script>
</body>

</html>