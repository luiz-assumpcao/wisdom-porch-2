function definirDataMaximaEMinimaDeNascimento(campoData) {
    campoData.max = new Date().toISOString().split('T')[0];
    campoData.min = new Date(new Date().setFullYear(new Date().getFullYear() - 120)).toISOString().split('T')[0];
}

function main() {
    const campoDataNascimento = document.getElementById('form-data-nascimento');
    definirDataMaximaEMinimaDeNascimento(campoDataNascimento);
}

document.addEventListener('DOMContentLoaded', () => {
    main();
});
