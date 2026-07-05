function limparEstadoOutrasColunas(tabela, thAtivo) {
    tabela.querySelectorAll('th[data-tipo]').forEach(function (th) {
        if (th !== thAtivo) {
            th.dataset.direcao = '';
            const seta = th.querySelector('.seta-ordenacao');
            if (seta) seta.textContent = '';
        }
    });
}

function restaurarOrdemOriginal(tbody) {
    const linhas = Array.from(tbody.querySelectorAll('tr'));
    linhas.sort(function (linhaA, linhaB) {
        return Number(linhaA.dataset.ordemOriginal) - Number(linhaB.dataset.ordemOriginal);
    });
    linhas.forEach(function (linha) {
        tbody.appendChild(linha);
    });
}

function ordenarTabela(th) {
    const tabela = th.closest('table');
    const tbody = tabela.querySelector('tbody');
    const indiceColuna = Array.from(th.parentElement.children).indexOf(th);
    const tipo = th.dataset.tipo;

    const estadoAtual = th.dataset.direcao || '';
    const proximoEstado = estadoAtual === '' ? 'asc' : estadoAtual === 'asc' ? 'desc' : '';

    limparEstadoOutrasColunas(tabela, th);
    th.dataset.direcao = proximoEstado;
    const seta = th.querySelector('.seta-ordenacao');

    if (proximoEstado === '') {
        restaurarOrdemOriginal(tbody);
        if (seta) seta.textContent = '';
        return;
    }

    const crescente = proximoEstado === 'asc';
    const linhas = Array.from(tbody.querySelectorAll('tr'));

    linhas.sort(function (linhaA, linhaB) {
        const celulaA = linhaA.children[indiceColuna];
        const celulaB = linhaB.children[indiceColuna];
        const valorA = celulaA.dataset.valor ?? celulaA.textContent.trim();
        const valorB = celulaB.dataset.valor ?? celulaB.textContent.trim();

        if (tipo === 'numero') {
            return crescente ? parseFloat(valorA) - parseFloat(valorB) : parseFloat(valorB) - parseFloat(valorA);
        }

        const textoA = valorA.toLowerCase();
        const textoB = valorB.toLowerCase();
        return crescente ? textoA.localeCompare(textoB) : textoB.localeCompare(textoA);
    });

    linhas.forEach(function (linha) {
        tbody.appendChild(linha);
    });

    if (seta) {
        seta.textContent = crescente ? '▼' : '▲';
    }
}

function confirmarEnvio(formulario, mensagem) {
    if (confirm(mensagem)) {
        formulario.submit();
    }
}

function aplicarMascaraTelefoneAdmin(campo) {
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

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('table').forEach(function (tabela) {
        const tbody = tabela.querySelector('tbody');
        Array.from(tbody.querySelectorAll('tr')).forEach(function (linha, indice) {
            linha.dataset.ordemOriginal = indice;
        });
    });

    document.querySelectorAll('th[data-tipo]').forEach(function (th) {
        th.insertAdjacentHTML('beforeend', ' <span class="seta-ordenacao"></span>');
        th.addEventListener('click', function () {
            ordenarTabela(th);
        });
    });

    const campoTelefoneCrud = document.getElementById('campo-telefone-crud');
    if (campoTelefoneCrud) {
        aplicarMascaraTelefoneAdmin(campoTelefoneCrud);
        campoTelefoneCrud.addEventListener('input', function () {
            aplicarMascaraTelefoneAdmin(campoTelefoneCrud);
        });
    }
});
