function loadData() {

    // Define qual função será chamada
    const formData = new FormData();
    formData.append('funcao', 'exibirPanfleto');

    // Gera a requisição para ao servidor para captar os dados dos panfletos
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../../php/funcoes.php", true);
    xhr.onreadystatechange = function () {

        if (xhr.readyState == 4 && xhr.status == 200) {

            // Recebe os dados dos produtos para gerar os panfletos
            let dadosProduto = JSON.parse(xhr.responseText);

            // Cria uma variável para manipular a div 'dados' no arquivo HTML
            let lista = document.getElementById("dados");

            for (let i = 0; i < dadosProduto.length; i++) {

                let divPanfleto = criarDiv('panfleto', null);

                divPanfleto.appendChild(adicionarDescricao(dadosProduto[i].cod_produto, dadosProduto[i].desc_produto));

                if (dadosProduto[i].tipo_venda == 1) {

                    divPanfleto.appendChild(adicionarValorUnitario(dadosProduto[i].valor));

                }

                if (dadosProduto[i].tipo_venda == 2) {

                    let dados = [];
                    let codigo = dadosProduto[i].cod_produto;
                    let trava = codigo;
                    while (codigo == trava) {

                        if (dadosProduto[i]) {

                            codigo = dadosProduto[i].cod_produto;

                            if (codigo == trava) {

                                dados.push(dadosProduto[i]);
                                i++;

                            } else {

                                trava = null;
                                i--;

                            }
                        } else {
                            trava = null;
                        }

                    }
                    divPanfleto.appendChild(adicionarValorQuantidade(dados));
                }
                lista.appendChild(divPanfleto);
            }
        }
    };
    xhr.send(formData);

    // Gerando o panfleto
    function adicionarDescricao(codProduto, descProduto) {

        let divDescricaoPanfleto = criarDiv('descricaoPanfleto', "Cod: " + codProduto + " - " + descProduto);

        return divDescricaoPanfleto;
    }

    function adicionarValorUnitario(valor) {

        // desc
        let divQuadroPanfleto = criarDiv('quadroPanfleto', null);

        // desc
        let divValorUnitario = criarDiv('valorUnitario', null);

        // desc
        let divTextoRs = criarDiv('textoRs', "R$");

        // desc
        divValorUnitario.appendChild(divTextoRs);

        // desc
        let valorOferta = parseFloat(valor).toFixed(2).split('.');

        // desc
        let divValorInteiro = criarDiv('valorInt', formatarNumero(valorOferta[0]));

        // desc
        divValorUnitario.appendChild(divValorInteiro);

        // desc
        let divCentavoAvista = criarDiv('centAvista', null);

        // desc
        let divCentavo = criarDiv('centavo', "," + valorOferta[1]);

        // desc
        divCentavoAvista.appendChild(divCentavo);

        // desc
        let divAvista = criarDiv('avista', "À vista");

        // desc
        divCentavoAvista.appendChild(divAvista);

        // desc
        divValorUnitario.appendChild(divCentavoAvista);

        // desc
        divQuadroPanfleto.appendChild(divValorUnitario);

        // desc
        let divParcela = criarDiv('parcela', null);

        // desc
        let divParcelaGrupo = criarDiv('parcela_grupo', null);


        // Calcula os valores para 3 parcelas
        let valorParcela1 = (valor * 1.04);

        let valorParcela3x = tirarMediaParcela(valorParcela1 / 3.0);

        let valorParcela3xParcela = (formatarNumeroComDecimais(valorParcela3x));

        let valorParcela3xTotal = (formatarNumeroComDecimais(valorParcela3x * 3));


        // Calcula os valores para 6 parcelas
        let valorParcela2 = ((valor * 1.04) * 1.03);

        let valorParcela6x = tirarMediaParcela(valorParcela2 / 6.0);

        let valorParcela6xParcela = (formatarNumeroComDecimais(valorParcela6x));

        let valorParcela6xTotal = (formatarNumeroComDecimais(valorParcela6x * 6));


        // parcelas linha 1: ou 3x R$ XX,XX
        let divLinhaParcela1 = criarDiv('parcela_linha', null);

        let divLinhaParcelaOu1 = criarDiv('parcela_ou', "OU");
        let divLinhaParcelaVezes1 = criarDiv('parcela_vezes', "3X");
        let divLinhaParcelaRs1 = criarDiv('parcela_rs', " R$");
        let divLinhaParcelaPreco1 = criarDiv('parcela_preco', valorParcela3xParcela.valorInteiro + "," + valorParcela3xParcela.centavo);

        divLinhaParcela1.appendChild(divLinhaParcelaOu1);
        divLinhaParcela1.appendChild(divLinhaParcelaVezes1);
        divLinhaParcela1.appendChild(divLinhaParcelaRs1);
        divLinhaParcela1.appendChild(divLinhaParcelaPreco1);

        divParcelaGrupo.appendChild(divLinhaParcela1);
        divParcela.appendChild(divParcelaGrupo);
        divQuadroPanfleto.appendChild(divParcela);


        // parcelas linha 2: total: R$ XX,XX
        let divLinhaParcela2 = criarDiv('parcela_linha', null);

        let divLinhaParcelaTotal1 = criarDiv('parcela_total', "Total: R$ " + valorParcela3xTotal.valorInteiro + "," + valorParcela3xTotal.centavo);

        divLinhaParcela2.appendChild(divLinhaParcelaTotal1);

        divParcelaGrupo.appendChild(divLinhaParcela2);
        divParcela.appendChild(divParcelaGrupo);
        divQuadroPanfleto.appendChild(divParcela);


        // parcelas linha 3: ou 6x R$ XX,XX
        let divLinhaParcela3 = criarDiv('parcela_linha', null);

        let divLinhaParcelaOu2 = criarDiv('parcela_ou', "OU");
        let divLinhaParcelaVezes2 = criarDiv('parcela_vezes', "6X");
        let divLinhaParcelaRs2 = criarDiv('parcela_rs', " R$");
        let divLinhaParcelaPreco2 = criarDiv('parcela_preco', valorParcela6xParcela.valorInteiro + "," + valorParcela6xParcela.centavo);

        divLinhaParcela3.appendChild(divLinhaParcelaOu2);
        divLinhaParcela3.appendChild(divLinhaParcelaVezes2);
        divLinhaParcela3.appendChild(divLinhaParcelaRs2);
        divLinhaParcela3.appendChild(divLinhaParcelaPreco2);

        divParcelaGrupo.appendChild(divLinhaParcela3);
        divParcela.appendChild(divParcelaGrupo);
        divQuadroPanfleto.appendChild(divParcela);


        // parcelas linha 4: total: R$ XX,XX
        let divLinhaParcela4 = criarDiv('parcela_linha', null);

        let divLinhaParcelaTotal2 = document.createElement('div');
        divLinhaParcelaTotal2.className = 'parcela_total';

        divLinhaParcelaTotal2.innerHTML = "Total: R$ " + valorParcela6xTotal.valorInteiro + "," + valorParcela6xTotal.centavo;

        divLinhaParcela4.appendChild(divLinhaParcelaTotal2);

        divParcelaGrupo.appendChild(divLinhaParcela4);
        divParcela.appendChild(divParcelaGrupo);
        divQuadroPanfleto.appendChild(divParcela);

        return divQuadroPanfleto;
    }
    function adicionarValorQuantidade(dadosProdutoQuantidade) {
        // valor primeira quantidade
        dadosProdutoQuantidade[0].tipo_produto = converteCodTipo(dadosProdutoQuantidade[0].tipo_produto);
        dadosProdutoQuantidade[0].valor = formatarNumeroComDecimais(dadosProdutoQuantidade[0].valor);
        dadosProdutoQuantidade[1].tipo_produto = converteCodTipo(dadosProdutoQuantidade[1].tipo_produto);
        dadosProdutoQuantidade[1].valor = formatarNumeroComDecimais(dadosProdutoQuantidade[1].valor);
        dadosProdutoQuantidade[2].tipo_produto = converteCodTipo(dadosProdutoQuantidade[2].tipo_produto);
        dadosProdutoQuantidade[2].valor = formatarNumeroComDecimais(dadosProdutoQuantidade[2].valor);

        console.log(dadosProdutoQuantidade);

        // div do panfleto
        let panfletoQuantidade = document.createElement('div');

        // Area para o primeiro preço
        let panfletoQuantidadeDiv1 = document.createElement('div');
        // Area sobre a area para o primeiro preço
        let panfletoQuantidadeDiv11 = document.createElement('div');
        // Texto para "preço para XX" primeiro preço
        let panfletoQuantidadeDiv111 = document.createElement('div');
        // Area do valor do primeiro preço
        let panfletoQuantidadeDiv112 = document.createElement('div');
        // Simbolo "R$" do primeiro preço
        let panfletoQuantidadeDiv1121 = document.createElement('div');
        // Preço inteiro para o primeiro preço
        let panfletoQuantidadeDiv1122 = document.createElement('div');
        // Area para os centavos e o texto "XX \n À vista" primeiro preço
        let panfletoQuantidadeDiv1123 = document.createElement('div');
        // Centavos do primeiro produto
        let panfletoQuantidadeDiv11231 = document.createElement('div');
        // Texto "XX \n À vista" primeiro produto 
        let panfletoQuantidadeDiv11232 = document.createElement('div');

        // Area para o segundo e terceiro preço
        let panfletoQuantidadeDiv2 = document.createElement('div');

        // Area para o segundo preço
        let panfletoQuantidadeDiv21 = document.createElement('div');
        // Area sobre area para o segundo preço
        let panfletoQuantidadeDiv211 = document.createElement('div');
        // Texto para "preço para XX" segundo preço
        let panfletoQuantidadeDiv2111 = document.createElement('div');
        // Area do valor do segundo preço
        let panfletoQuantidadeDiv2112 = document.createElement('div');
        // Simbolo "R$" do segundo preço
        let panfletoQuantidadeDiv21121 = document.createElement('div');
        // Preço inteiro para o segundo preço
        let panfletoQuantidadeDiv21122 = document.createElement('div');
        // Area para os centavos e o texto "XX \n À vista" segundo preço
        let panfletoQuantidadeDiv21123 = document.createElement('div');
        // Centavos do segundo produto
        let panfletoQuantidadeDiv211231 = document.createElement('div');
        // Texto "XX \n À vista" segundo produto
        let panfletoQuantidadeDiv211232 = document.createElement('div');

        // Area para o terceiro preço
        let panfletoQuantidadeDiv22 = document.createElement('div');
        // Area para area para o terceiro preço
        let panfletoQuantidadeDiv221 = document.createElement('div');
        // Texto para "preço para XX" terceiro preço
        let panfletoQuantidadeDiv2211 = document.createElement('div');
        // Area do valor do terceiro preço
        let panfletoQuantidadeDiv2212 = document.createElement('div');
        // Simbolo "R$" do terceiro preço
        let panfletoQuantidadeDiv22121 = document.createElement('div');
        // Preço inteiro para o terceiro preço
        let panfletoQuantidadeDiv22122 = document.createElement('div');
        // Area para os centavos e o texto "XX \n À vista" terceiro preço
        let panfletoQuantidadeDiv22123 = document.createElement('div');
        // Centavos do terceiro produto
        let panfletoQuantidadeDiv221231 = document.createElement('div');
        // Texto "XX \n À vista" terceiro produto
        let panfletoQuantidadeDiv221232 = document.createElement('div');

        // Adicionando as classes as divs
        panfletoQuantidade.className = 'panfletoQuantidade';
        panfletoQuantidadeDiv1.className = 'panfletoQuantidadeDiv1';
        panfletoQuantidadeDiv11.className = 'panfletoQuantidadeDiv11';
        panfletoQuantidadeDiv111.className = 'panfletoQuantidadeDiv111';
        panfletoQuantidadeDiv112.className = 'panfletoQuantidadeDiv112';
        panfletoQuantidadeDiv1121.className = 'panfletoQuantidadeDiv1121';
        panfletoQuantidadeDiv1122.className = 'panfletoQuantidadeDiv1122';
        panfletoQuantidadeDiv1123.className = 'panfletoQuantidadeDiv1123';
        panfletoQuantidadeDiv11231.className = 'panfletoQuantidadeDiv11231';
        panfletoQuantidadeDiv11232.className = 'panfletoQuantidadeDiv11232';
        // Adicionando as classes as divs
        panfletoQuantidadeDiv2.className = 'panfletoQuantidadeDiv2';

        panfletoQuantidadeDiv21.className = 'panfletoQuantidadeDiv21';
        panfletoQuantidadeDiv211.className = 'panfletoQuantidadeDiv211';
        panfletoQuantidadeDiv2111.className = 'panfletoQuantidadeDiv2111';
        panfletoQuantidadeDiv2112.className = 'panfletoQuantidadeDiv2112';
        panfletoQuantidadeDiv21121.className = 'panfletoQuantidadeDiv21121';
        panfletoQuantidadeDiv21122.className = 'panfletoQuantidadeDiv21122';
        panfletoQuantidadeDiv21123.className = 'panfletoQuantidadeDiv21123';
        panfletoQuantidadeDiv211231.className = 'panfletoQuantidadeDiv211231';
        panfletoQuantidadeDiv211232.className = 'panfletoQuantidadeDiv211232';
        // Adicionando as classes as divs
        panfletoQuantidadeDiv22.className = 'panfletoQuantidadeDiv22';
        panfletoQuantidadeDiv221.className = 'panfletoQuantidadeDiv221';
        panfletoQuantidadeDiv2211.className = 'panfletoQuantidadeDiv2211';
        panfletoQuantidadeDiv2212.className = 'panfletoQuantidadeDiv2212';
        panfletoQuantidadeDiv22121.className = 'panfletoQuantidadeDiv22121';
        panfletoQuantidadeDiv22122.className = 'panfletoQuantidadeDiv22122';
        panfletoQuantidadeDiv22123.className = 'panfletoQuantidadeDiv22123';
        panfletoQuantidadeDiv221231.className = 'panfletoQuantidadeDiv221231';
        panfletoQuantidadeDiv221232.className = 'panfletoQuantidadeDiv221232';

        // Atribuindo valor as divs primeiro preço
        panfletoQuantidadeDiv111.innerHTML = "Preço p/ " + dadosProdutoQuantidade[0].tipo_produto.singular;
        panfletoQuantidadeDiv1121.innerHTML = "R$";
        panfletoQuantidadeDiv1122.innerHTML = dadosProdutoQuantidade[0].valor.valorInteiro;
        panfletoQuantidadeDiv11231.innerHTML = "," + dadosProdutoQuantidade[0].valor.centavo;
        panfletoQuantidadeDiv11232.innerHTML = "Cada<br>À vista";
        // Atribuindo valor as divs segundo preço
        panfletoQuantidadeDiv2111.innerHTML = "Preço p/ " + dadosProdutoQuantidade[1].quantidade + " " + dadosProdutoQuantidade[1].tipo_produto.plural;
        panfletoQuantidadeDiv21121.innerHTML = "R$";
        panfletoQuantidadeDiv21122.innerHTML = dadosProdutoQuantidade[1].valor.valorInteiro;
        panfletoQuantidadeDiv211231.innerHTML = "," + dadosProdutoQuantidade[1].valor.centavo;;
        panfletoQuantidadeDiv211232.innerHTML = "Cada<br>À vista";
        // Atribuindo valor as divs terceiro preço
        panfletoQuantidadeDiv2211.innerHTML = "Preço p/ " + dadosProdutoQuantidade[2].quantidade + " " + dadosProdutoQuantidade[2].tipo_produto.plural;
        panfletoQuantidadeDiv22121.innerHTML = "R$";
        panfletoQuantidadeDiv22122.innerHTML = dadosProdutoQuantidade[2].valor.valorInteiro;
        panfletoQuantidadeDiv221231.innerHTML = "," + dadosProdutoQuantidade[2].valor.centavo;
        panfletoQuantidadeDiv221232.innerHTML = "Cada<br>À vista";

        // Gerando div do primeiro preço
        panfletoQuantidadeDiv1123.appendChild(panfletoQuantidadeDiv11231);
        panfletoQuantidadeDiv1123.appendChild(panfletoQuantidadeDiv11232);
        panfletoQuantidadeDiv112.appendChild(panfletoQuantidadeDiv1121);
        panfletoQuantidadeDiv112.appendChild(panfletoQuantidadeDiv1122);
        panfletoQuantidadeDiv112.appendChild(panfletoQuantidadeDiv1123);
        panfletoQuantidadeDiv11.appendChild(panfletoQuantidadeDiv111);
        panfletoQuantidadeDiv11.appendChild(panfletoQuantidadeDiv112);
        panfletoQuantidadeDiv1.appendChild(panfletoQuantidadeDiv11);
        panfletoQuantidade.appendChild(panfletoQuantidadeDiv1);
        // Gerando div do segundo preço
        panfletoQuantidadeDiv21123.appendChild(panfletoQuantidadeDiv211231);
        panfletoQuantidadeDiv21123.appendChild(panfletoQuantidadeDiv211232);
        panfletoQuantidadeDiv2112.appendChild(panfletoQuantidadeDiv21121);
        panfletoQuantidadeDiv2112.appendChild(panfletoQuantidadeDiv21122);
        panfletoQuantidadeDiv2112.appendChild(panfletoQuantidadeDiv21123);
        panfletoQuantidadeDiv211.appendChild(panfletoQuantidadeDiv2111);
        panfletoQuantidadeDiv211.appendChild(panfletoQuantidadeDiv2112);
        panfletoQuantidadeDiv21.appendChild(panfletoQuantidadeDiv211);
        panfletoQuantidadeDiv2.appendChild(panfletoQuantidadeDiv21);
        // Gerando div do terceiro preço
        panfletoQuantidadeDiv22123.appendChild(panfletoQuantidadeDiv221231);
        panfletoQuantidadeDiv22123.appendChild(panfletoQuantidadeDiv221232);
        panfletoQuantidadeDiv2212.appendChild(panfletoQuantidadeDiv22121);
        panfletoQuantidadeDiv2212.appendChild(panfletoQuantidadeDiv22122);
        panfletoQuantidadeDiv2212.appendChild(panfletoQuantidadeDiv22123);
        panfletoQuantidadeDiv221.appendChild(panfletoQuantidadeDiv2211);
        panfletoQuantidadeDiv221.appendChild(panfletoQuantidadeDiv2212);
        panfletoQuantidadeDiv22.appendChild(panfletoQuantidadeDiv221);
        panfletoQuantidadeDiv2.appendChild(panfletoQuantidadeDiv22);

        panfletoQuantidade.appendChild(panfletoQuantidadeDiv2);

        return panfletoQuantidade;
    }

    // Ferramentas
    function formatarNumero(numero) {
        // Verifica se o número é válido
        if (isNaN(numero)) {
            return "Número inválido";
        }

        // Converte o número para uma string e remove quaisquer caracteres não numéricos
        let numeroStr = numero.toString().replace(/\D/g, '');

        // Adiciona os pontos a cada 3 dígitos
        numeroStr = numeroStr.replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        return numeroStr;
    }
    function formatarNumeroComDecimais(numero) {
        // Verifica se o número é válido
        if (isNaN(numero)) {
            return "Número inválido";
        }

        // Converte o número para uma string com duas casas decimais e substitui o ponto por vírgula
        numero = parseFloat(numero).toFixed(2).toString().replace('.', ',');
        // Separa a parte inteira da parte decimal usando split(',')
        numero = numero.split(',');

        // Adiciona os pontos a cada 3 dígitos na parte inteira
        numero[0] = numero[0].replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        let numeroSeparado = {
            valorInteiro: numero[0],
            centavo: numero[1]
        };

        // Recombina a parte inteira e a parte decimal
        return numeroSeparado;
    }
    function converteCodTipo(numero) {
        let tipo = { singular: "", plural: "" };

        switch (+numero) {
            case 1:
                tipo.singular = "unidade";
                tipo.plural = "unidades";
                break;
            case 2:
                tipo.singular = "quilo";
                tipo.plural = "quilos";
                break;
            case 3:
                tipo.singular = "metro";
                tipo.plural = "metros";
                break;
            case 4:
                tipo.singular = "rolo";
                tipo.plural = "rolos";
                break;
            case 5:
                tipo.singular = "par";
                tipo.plural = "pares";
                break;
            case 6:
                tipo.singular = "caixa";
                tipo.plural = "caixas";
                break;
            case 7:
                tipo.singular = "cento";
                tipo.plural = "centos";
                break;
            case 8:
                tipo.singular = "milheiro";
                tipo.plural = "milheiros";
                break;
            default:
                tipo.singular = "desconhecido";
                tipo.plural = "desconhecidos";
                break;
        }

        return tipo;
    }
    function criarDiv(classeDiv, conteudoDiv) {
        let div = document.createElement('div');
        div.className = classeDiv;
        if (conteudoDiv != null) {
            div.innerHTML = conteudoDiv;
        }
        return div;
    }
    function tirarMediaParcela(numero) {
        if ((numero - Math.floor(numero)) >= 0.25 && (numero - Math.floor(numero)) <= 0.75) {
            numero = Math.floor(numero) + 0.5;
        } else if ((numero - Math.floor(numero)) > 0.75) {
            numero = Math.floor(numero) + 1;
        } else {
            numero = Math.floor(numero);
        }

        return numero;
    }
}

loadData();