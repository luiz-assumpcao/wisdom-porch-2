// Dados de cada aba.
const abas = [
    {
        titulo: 'What is Philosophy?',
        texto: 'Philosophy is the pursuit of knowledge that seeks to unify the sciences and critically examine the foundations of our beliefs and convictions. Unlike other disciplines, it does not offer definitive answers, but its value lies precisely in that uncertainty. It broadens our thinking, frees us from the tyranny of habit and dogmatic arrogance, and keeps alive our speculative interest in the universe. By contemplating the grandest questions about existence, consciousness, and the nature of good and evil, philosophy enlarges the mind and liberates it from the narrow prison of instinct and personal interest. In doing so, it makes us citizens of the universe rather than of a single walled city at war with everything else.'
    },
    {
        titulo: 'What is the Origin of Philosophy?',
        texto: "Philosophy emerged from humanity's earliest attempts to understand the world beyond myth and tradition. As ancient thinkers began questioning the nature of reality, existence, and knowledge, they laid the groundwork for what would become a distinct discipline of rational inquiry. Over time, many fields that once belonged to philosophy, such as astronomy and psychology, gradually broke away to become independent sciences. What remained was the residue of questions too deep and too fundamental to be resolved by empirical methods alone, the enduring core of philosophical thought."
    },
    {
        titulo: 'Why Should One Study Philosophy?',
        texto: 'Studying philosophy is, at its core, an act of intellectual courage. In a world that increasingly values speed and immediate results, philosophy invites us to slow down and ask whether the assumptions we live by are truly worth holding. Beyond sharpening critical thinking, it forces us to confront questions that no career or material comfort can answer. What do I owe to others? Is the life I am living truly meaningful? These are not abstract puzzles reserved for academics, but questions every human being inevitably faces. Those who have learned to think through them carefully are far better prepared when life demands an answer.'
    },
    {
        titulo: 'The Value of Philosophy',
        texto: 'The value of philosophy does not rest on its ability to provide certain answers, but rather on the quality of the questions it raises. Those who engage with philosophy are freed from the prejudices of common sense and the blind habits of their time, gaining instead a broader and more imaginative understanding of what is possible. Philosophy cultivates intellectual humility, replacing arrogant certainty with open and curious inquiry. Above all, by turning the mind toward the grandest objects of contemplation, the universe, truth, and the nature of existence, it enlarges the soul and brings us closer to the kind of impartial, universal understanding that represents the highest good of human life.'
    }
];

// Dados dos filósofos.
const filosofos = [
    {
        nome: 'Socrates',
        descricao: `Socrates was an ancient Greek philosopher born in Athens around 470 BCE, widely regarded as one of the founding figures of Western philosophy. He lived during a period of great intellectual and cultural flourishing in Athens, dedicating his life entirely to philosophical inquiry. Unlike other thinkers of his time, he left no written works, and everything we know about him comes primarily through the dialogues of his student Plato. <br /><br />Socrates believed that the pursuit of wisdom and self-knowledge was the highest calling of a human being. His famous declaration, "I know that I know nothing," reflected his conviction that true wisdom begins with the recognition of one's own ignorance. He developed what became known as the Socratic method, a technique of asking probing questions to expose contradictions in people's beliefs and lead them toward deeper understanding. He also believed that virtue is a form of knowledge, and that no one does wrong willingly. <br /><br />The importance of Socrates for philosophy can hardly be overstated. His method of dialogue and critical inquiry became the foundation of philosophical practice in the Western tradition. He was condemned to death by the Athenian authorities in 399 BCE, accused of corrupting the youth and impiety, but his ideas lived on through Plato and countless thinkers after him. Socrates remains, to this day, a symbol of intellectual courage and the unrelenting search for truth.`
    },
    {
        nome: 'Plato',
        descricao: `Plato was an ancient Greek philosopher born in Athens around 428 BCE, and one of the most influential thinkers in the history of Western philosophy. He was a student of Socrates and later became the teacher of Aristotle, forming with them a trio that shaped the foundations of philosophical thought. He founded the Academy in Athens, one of the earliest institutions of higher learning in the Western world. <br /><br />Plato believed that the material world we perceive through our senses is not the true reality, but merely a shadow of a higher realm of perfect, eternal forms. In his theory of Forms, he argued that abstract concepts such as beauty, justice, and truth exist independently of the physical world, as ideal and unchanging entities. He also believed that the soul is immortal and that knowledge is not learned, but rather recalled from a previous existence. His political philosophy, expressed in his famous work "The Republic," envisioned an ideal society governed by philosopher kings. <br /><br />Plato's importance for philosophy is immeasurable. His dialogues remain among the most read and studied texts in the philosophical tradition, covering topics from ethics and politics to metaphysics and epistemology. The philosopher Alfred North Whitehead once remarked that all of Western philosophy is but a series of footnotes to Plato, a testament to the extraordinary depth and reach of his thought.`
    },
    {
        nome: 'Aristotle',
        descricao: `Aristotle was an ancient Greek philosopher born in Stagira around 384 BCE, and a student of Plato at the Academy in Athens. After Plato's death, he went on to tutor the young Alexander the Great, before returning to Athens to found his own school, the Lyceum. He is considered one of the greatest intellectuals in human history, having made foundational contributions to an extraordinary range of fields. <br /><br />Unlike his teacher Plato, Aristotle believed that knowledge comes primarily from observation and experience of the physical world, rather than from abstract reasoning about ideal forms. He developed a comprehensive system of logic that remained the dominant framework for rational inquiry for centuries. In ethics, he argued that the highest human good is happiness, achieved through the cultivation of virtue and the exercise of reason in accordance with one's nature. He also made lasting contributions to biology, physics, politics, rhetoric, and poetics, approaching each field with remarkable rigor and curiosity. <br /><br />Aristotle's influence on Western thought is perhaps unparalleled. His works were preserved and studied throughout the Middle Ages, deeply shaping Christian theology through thinkers such as Thomas Aquinas. His method of careful observation and systematic classification laid important groundwork for the development of modern science. Even today, his ideas on ethics, logic, and politics continue to be studied, debated, and applied across countless disciplines.`
    }
];

// Índice da aba ativa no momento.
let indiceAtivo = 0;

// Função que atualiza a interface conforme a aba clicada.
function trocarAba(indiceSelecionado) {
    // Atualiza título e texto principal
    document.getElementById('titulo-aba').textContent = abas[indiceSelecionado].titulo;
    document.getElementById('texto-aba').textContent = abas[indiceSelecionado].texto;

    // Atualiza as opções visíveis (os outros dois índices)
    const opcoes = document.querySelectorAll('.opcao-aba');
    const outrosIndices = [0, 1, 2, 3].filter((i) => i !== indiceSelecionado);

    opcoes.forEach((opcao, i) => {
        opcao.textContent = abas[outrosIndices[i]].titulo;
        opcao.dataset.indice = outrosIndices[i];
    });

    indiceAtivo = indiceSelecionado;
}

// Função que atualiza o filósofo selecionado.
function selecionarFilosofo(indiceSelecionado) {
    // Atualiza texto da descrição
    document.getElementById('texto-filosofo').innerHTML = filosofos[indiceSelecionado].descricao;

    document.querySelectorAll('.cartao-filosofo').forEach((cartao, i) => {
        cartao.classList.toggle('ativo', i === indiceSelecionado);
    });
}

// Adiciona evento de clique em cada opção.
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.opcao-aba').forEach((opcao) => {
        opcao.addEventListener('click', function () {
            trocarAba(parseInt(this.dataset.indice));
        });
    });

    document.querySelectorAll('.cartao-filosofo').forEach((cartao) => {
        cartao.addEventListener('click', function () {
            selecionarFilosofo(parseInt(this.dataset.filosofo));
        });
    });
});
