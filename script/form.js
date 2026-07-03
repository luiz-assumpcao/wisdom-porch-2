function definirDataMaximaEMinimaDeNascimento(campoData) {
    campoData.max = new Date().toISOString().split('T')[0];
    campoData.min = new Date(new Date().setFullYear(new Date().getFullYear() - 120)).toISOString().split('T')[0];
}

function aplicarMascaraTelefone(campo) {
    let digitos = campo.value.replace(/\D/g, '');
    digitos = digitos.substring(0, 13);

    const codigoPais = digitos.substring(0, 2);
    const ddd = digitos.substring(2, 4);
    const numero = digitos.substring(4);

    let formatado = '';
    if (codigoPais) formatado += '+' + codigoPais;
    if (ddd) formatado += ' ' + ddd;
    if (numero) formatado += ' ' + numero;

    campo.value = formatado;
}

function validarNome(nome) {
    const regexNome = /^[A-Za-zÀ-ÖØ-öø-ÿ\s]{2,30}$/;
    return regexNome.test(nome);
}

function validarEmail(email) {
    const regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regexEmail.test(email);
}

function validarTelefone(telefone) {
    const regexTelefone = /^\+55 \d{2} \d{8,9}$/;
    return regexTelefone.test(telefone);
}

function validarDataNascimento(dataNascimento) {
    return dataNascimento !== '' && new Date(dataNascimento) < new Date();
}

function validarFormulario(formulario) {
    formulario.addEventListener('submit', function (evento) {
        const mensagem = document.getElementById('mensagem-confirmacao');

        const nome = document.getElementById('form-nome').value.trim();
        const email = document.getElementById('form-email').value.trim();
        const telefone = document.getElementById('form-telefone').value.trim();
        const dataNascimento = document.getElementById('form-data-nascimento').value;

        if (!validarNome(nome)) {
            evento.preventDefault();
            mensagem.className = 'mensagem-erro';
            mensagem.textContent = 'Please enter a valid name (letters only, 2-30 characters).';
            return;
        }

        if (!validarEmail(email)) {
            evento.preventDefault();
            mensagem.className = 'mensagem-erro';
            mensagem.textContent = 'Please enter a valid email address.';
            return;
        }

        if (!validarTelefone(telefone)) {
            evento.preventDefault();
            mensagem.className = 'mensagem-erro';
            mensagem.textContent = 'Please enter a valid phone number.';
            return;
        }

        if (!validarDataNascimento(dataNascimento)) {
            evento.preventDefault();
            mensagem.className = 'mensagem-erro';
            mensagem.textContent = 'Please enter a valid date of birth.';
            return;
        }

        // Se passou por todas as validações, o formulário segue seu envio normal (POST) para o servidor.
    });
}

function main() {
    const campoDataNascimento = document.getElementById('form-data-nascimento');
    definirDataMaximaEMinimaDeNascimento(campoDataNascimento);

    const campoTelefone = document.getElementById('form-telefone');
    campoTelefone.addEventListener('input', function () {
        aplicarMascaraTelefone(campoTelefone);
    });

    const formulario = document.getElementById('form-newsletter');
    validarFormulario(formulario);
}

document.addEventListener('DOMContentLoaded', () => {
    main();
});
