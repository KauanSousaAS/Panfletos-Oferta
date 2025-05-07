
const formData = new FormData();
formData.append('funcao', 'seletorFilial');

let xhr = new XMLHttpRequest();
xhr.open("POST", "../../php/funcoes.php", true);
xhr.onreadystatechange = function () {
    if (xhr.readyState == 4 && xhr.status == 200) {
        const selecao = document.getElementById("selecaoFilial");

        dados = JSON.parse(xhr.responseText);

        dados.filiais.forEach(filial => {
            const option = document.createElement("option");
            option.value = filial.id_filial;
            option.textContent = filial.filial;

            // Se a filial for igual à da sessão, marca como selecionada
            if (filial.id_filial == dados.sessao) {
                option.selected = true;
            }

            selecao.appendChild(option);
        });
    }
}
xhr.send(formData);

function selecaoFilial() {
    const formData = new FormData();
    formData.append('funcao', 'selecaoFilial');
    formData.append('selecaoFilial', document.getElementById('selecaoFilial').value);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../../php/funcoes.php", true);
    xhr.send(formData);
}

document.getElementById("selecaoFilial").addEventListener("change", function () {
    selecaoFilial();
});
