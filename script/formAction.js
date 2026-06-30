function exibeDadosColetados() {
    const nome = localStorage.getItem('nome');
    const email = localStorage.getItem('email');
    const dataNascimento = localStorage.getItem('dataNascimento');
    const escolaFavorita = localStorage.getItem('escolaFavorita');

    document.getElementById('dado-nome').textContent = nome;
    document.getElementById('dado-email').textContent = email;
    document.getElementById('dado-data-nascimento').textContent = dataNascimento;
    document.getElementById('dado-escola-favorita').textContent = escolaFavorita;
}

function main() {
    exibeDadosColetados();
}

document.addEventListener('DOMContentLoaded', () => {
    main();
});
