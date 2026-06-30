function definirDataMaximaEMinimaDeNascimento(campoData) {
    campoData.max = new Date().toISOString().split('T')[0];
    campoData.min = new Date(new Date().setFullYear(new Date().getFullYear() - 120)).toISOString().split('T')[0];
}

function validarNome(nome) {
    return nome && nome.length >= 2;
}

function validarEmail(email) {
    const regexEmail = /^[^@\s]+@[^.\s]+\.[^\s]+$/;
    return regexEmail.test(email);
}

function validarDataNascimento(dataNascimento) {
    return dataNascimento && new Date(dataNascimento) < new Date() ? true : false;
}

function enviarFormulario(formulario) {
    formulario.addEventListener('submit', function (evento) {
        evento.preventDefault();
        const mensagem = document.getElementById('mensagem-confirmacao');

        const nome = document.getElementById('form-nome').value.trim();
        const email = document.getElementById('form-email').value.trim();
        const dataNascimento = document.getElementById('form-data-nascimento').value.trim();
        const escolaFavorita = document.getElementById('form-escola-favorita').value.trim();

        if (!validarNome(nome) || !validarEmail(email) || !validarDataNascimento(dataNascimento)) {
            mensagem.className = 'mensagem-erro';
            mensagem.textContent = 'Please fill in all fields correctly.';
            return;
        }

        localStorage.setItem('nome', nome);
        localStorage.setItem('email', email);
        localStorage.setItem('dataNascimento', dataNascimento);
        localStorage.setItem('escolaFavorita', escolaFavorita);

        mensagem.className = 'mensagem-sucesso';
        mensagem.textContent = 'Your subscription has been confirmed!';

        formulario.reset();

        setTimeout(function () {
            mensagem.textContent = '';
        }, 3000);
    });
}

function main() {
    const campoDataNascimento = document.getElementById('form-data-nascimento');
    definirDataMaximaEMinimaDeNascimento(campoDataNascimento);

    const formulario = document.getElementById('form-newsletter');
    enviarFormulario(formulario);
}

document.addEventListener('DOMContentLoaded', () => {
    main();
});
