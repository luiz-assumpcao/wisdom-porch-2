const iconeOlhoAberto = `
    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" />
        <circle cx="12" cy="12" r="3" />
    </svg>`;

const iconeOlhoFechado = `
    <svg viewBox="0 0 24 24" width="22" height="22" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
        <path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" />
        <circle cx="12" cy="12" r="3" />
        <line x1="2" y1="2" x2="22" y2="22" />
    </svg>`;

function alternarVisibilidadeSenha(iconeClicado) {
    const idsCampos = iconeClicado.dataset.campos.split(',');
    const primeiroCampo = document.getElementById(idsCampos[0]);
    const estaVisivel = primeiroCampo.type === 'text';
    const novoTipo = estaVisivel ? 'password' : 'text';

    idsCampos.forEach(function (id) {
        document.getElementById(id).type = novoTipo;
    });

    document.querySelectorAll('.icone-olho').forEach(function (icone) {
        if (icone.dataset.campos === iconeClicado.dataset.campos) {
            icone.innerHTML = estaVisivel ? iconeOlhoFechado : iconeOlhoAberto;
        }
    });
}

function validarSenhaForte(senha) {
    const regexSenhaForte = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z0-9]).{6,}$/;
    return regexSenhaForte.test(senha);
}

function validarSenhasIguais(formulario) {
    formulario.addEventListener('submit', function (evento) {
        const senha = document.getElementById('campo-senha').value;
        const confirmarSenha = document.getElementById('campo-confirmar-senha').value;
        const mensagem = document.getElementById('mensagem-senha');

        if (!validarSenhaForte(senha)) {
            evento.preventDefault();
            mensagem.className = 'mensagem-erro';
            mensagem.textContent = 'Password must have 6+ characters, including uppercase, lowercase, a number, and a symbol.';
            return;
        }

        if (senha !== confirmarSenha) {
            evento.preventDefault();
            mensagem.className = 'mensagem-erro';
            mensagem.textContent = 'Passwords do not match.';
        }
    });
}

function bloquearEspaco(campo) {
    campo.addEventListener('keydown', function (evento) {
        if (evento.key === ' ') {
            evento.preventDefault();
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.campo-sem-espaco').forEach(bloquearEspaco);

    const formularioCadastro = document.getElementById('form-cadastro');
    if (formularioCadastro) {
        validarSenhasIguais(formularioCadastro);
    }
});
