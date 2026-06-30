<?php
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/style.css" />
    <link rel="icon" type="image/x-icon" href="img/favicon.png.png" />
    <title>Wisdom Porch</title>
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
        <section id="secao-abas">
            <div id="cabecalho-aba">
                <h2 id="titulo-aba">What is Philosophy?</h2>
            </div>
            <div id="conteudo-aba">
                <p id="texto-aba">
                    Philosophy is the pursuit of knowledge that seeks to unify the sciences and critically examine the foundations of our beliefs
                    and convictions. Unlike other disciplines, it does not offer definitive answers, but its value lies precisely in that
                    uncertainty. It broadens our thinking, frees us from the tyranny of habit and dogmatic arrogance, and keeps alive our
                    speculative interest in the universe. By contemplating the grandest questions about existence, consciousness, and the nature
                    of good and evil, philosophy enlarges the mind and liberates it from the narrow prison of instinct and personal interest. In
                    doing so, it makes us citizens of the universe rather than of a single walled city at war with everything else.
                </p>
            </div>
            <div id="opcoes-aba">
                <h3 class="opcao-aba" data-indice="1">What is the Origin of Philosophy?</h3>
                <h3 class="opcao-aba" data-indice="2">Why Should One Study Philosophy?</h3>
                <h3 class="opcao-aba" data-indice="3">The Value of Philosophy</h3>
            </div>
        </section>
        <section id="secao-filosofos">
            <div class="cartao-filosofo ativo" data-filosofo="0">
                <img src="img/socrates.png" alt="Socrates" class="retrato-filosofo" />
                <h3 class="nome-filosofo">Socrates</h3>
            </div>
            <div class="cartao-filosofo" data-filosofo="1">
                <img src="img/plato.png" alt="Plato" class="retrato-filosofo" />
                <h3 class="nome-filosofo">Plato</h3>
            </div>
            <div class="cartao-filosofo" data-filosofo="2">
                <img src="img/aristotle.png" alt="Aristotle" class="retrato-filosofo" />
                <h3 class="nome-filosofo">Aristotle</h3>
            </div>
        </section>
        <section id="secao-descricao-filosofo">
            <p id="texto-filosofo">
                Socrates was an ancient Greek philosopher born in Athens around 470 BCE, widely regarded as one of the founding figures of Western
                philosophy. He lived during a period of great intellectual and cultural flourishing in Athens, dedicating his life entirely to
                philosophical inquiry. Unlike other thinkers of his time, he left no written works, and everything we know about him comes
                primarily through the dialogues of his student Plato. <br /><br />Socrates believed that the pursuit of wisdom and self-knowledge
                was the highest calling of a human being. His famous declaration, "I know that I know nothing," reflected his conviction that true
                wisdom begins with the recognition of one's own ignorance. He developed what became known as the Socratic method, a technique of
                asking probing questions to expose contradictions in people's beliefs and lead them toward deeper understanding. He also believed
                that virtue is a form of knowledge, and that no one does wrong willingly. <br /><br />The importance of Socrates for philosophy
                can hardly be overstated. His method of dialogue and critical inquiry became the foundation of philosophical practice in the
                Western tradition. He was condemned to death by the Athenian authorities in 399 BCE, accused of corrupting the youth and impiety,
                but his ideas lived on through Plato and countless thinkers after him. Socrates remains, to this day, a symbol of intellectual
                courage and the unrelenting search for truth.
            </p>
        </section>
    </main>
    <footer>
        <a id="link-admin" href="login.php">Admin</a>
        <p>© 2026 Wisdom Porch</p>
        <a href="formAction.php">Form Data</a>
    </footer>
    <script src="script/index.js"></script>
</body>

</html>