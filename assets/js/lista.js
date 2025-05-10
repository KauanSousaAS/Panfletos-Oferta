function loadData() {

    const formData = new FormData();
    formData.append('funcao', 'listarProdutoFilial');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../../php/funcoes.php", true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

            let dadosProduto = JSON.parse(xhr.responseText);
            let tabela = document.getElementById('tabelaProdutosFilial');
            let cabecalho = document.createElement('thead');
            let linhaHead = document.createElement('tr');
            let corpo = document.createElement('tbody');

            let idHead = document.createElement('th');
            let codigoHead = document.createElement('th');
            let descricaoHead = document.createElement('th');
            let statusHead = document.createElement('th');

            idHead.innerHTML = "";
            codigoHead.innerHTML = "Código";
            descricaoHead.innerHTML = "Descrição";
            statusHead.innerHTML = "Status";

            linhaHead.append(idHead);
            linhaHead.append(codigoHead);
            linhaHead.append(descricaoHead);
            linhaHead.append(statusHead);

            cabecalho.append(linhaHead);

            tabela.append(cabecalho);

            for (let x = 0; x < dadosProduto.length; x++) {
                let linhaBody = document.createElement('tr');

                let idBody = document.createElement('td');
                let codigoBody = document.createElement('td');
                let descricaoBody = document.createElement('td');
                let statusBody = document.createElement('td');
                
                let checkbox = document.createElement('input');
                checkbox.type = 'checkbox'; // ou 'radio'
                checkbox.id = 'produtoSelecionado';
                checkbox.name = 'produtoSelecionado';
                checkbox.value = dadosProduto[x].id_produto;
                idBody.appendChild(checkbox);

                codigoBody.innerHTML = dadosProduto[x].cod_produto;
                descricaoBody.innerHTML = dadosProduto[x].desc_produto;
                
                if (dadosProduto[x].status == 0) {
                    statusBody.innerHTML = "Desativo";
                } else if (dadosProduto[x].status == 1) {
                    statusBody.innerHTML = "Ativo";
                } else if (dadosProduto[x].status == 2) {
                    statusBody.innerHTML = "Pendênte";
                }

                linhaBody.appendChild(idBody);
                linhaBody.appendChild(codigoBody);
                linhaBody.appendChild(descricaoBody);
                linhaBody.appendChild(statusBody);

                corpo.appendChild(linhaBody);

            }
            tabela.appendChild(corpo);

            console.log(tabela);
        }
    }
    xhr.send(formData);
}

function pesquisarProduto(input) {

    let busca = input.value;
    let dropdown = document.getElementById("dropdown");

    if (busca === "") {
        dropdown.style.display = "none";
        return;
    }

    const formData = new FormData();
    formData.append('funcao', 'pesquisarProdutoFilial');
    formData.append('busca', busca);


    let xhr = new XMLHttpRequest();
    xhr.open("POST", `../../php/funcoes.php`, true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {

            console.log(xhr.responseText);

            let produtos = JSON.parse(xhr.responseText);

            dropdown.innerHTML = "";
            if (produtos.length > 0) {
                dropdown.style.display = "block";
                produtos.forEach(produto => {
                    let div = document.createElement("div");
                    div.textContent = produto.cod_produto + " - " + produto.desc_produto;
                    let botaoAdicionar = document.createElement('button');
                    botaoAdicionar.textContent = '+';
                    botaoAdicionar.type = 'button';
                    div.appendChild(botaoAdicionar);
                    dropdown.appendChild(div);
                    botaoAdicionar.onclick = function () {
                        vincularFilialProduto(produto.id_produto);
                    }
                });
            } else {
                dropdown.style.display = "none";
            }
        }
    };
    xhr.send(formData);
}

function vincularFilialProduto(idProduto) {

    const formData = new FormData();
    formData.append('funcao', 'vincularFilialProduto');
    formData.append('vincularIdProduto', idProduto);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", '../../php/funcoes.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            window.location.href = 'lista.html';
        }
    }
    xhr.send(formData);
}

function desvincularFilialProduto(idProduto) {
    const formData = new FormData();
    formData.append('funcao', 'desvincularFilialProduto');
    formData.append('desvincularIdProduto', idProduto);
    console.log(idProduto);

    let xhr = new XMLHttpRequest();
    xhr.open("POST", '../../php/funcoes.php', true);
    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            window.location.href = 'lista.html';
        }
    }
    xhr.send(formData);
}

loadData();