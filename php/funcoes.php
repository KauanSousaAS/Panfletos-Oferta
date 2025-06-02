<?php

require_once 'conexao.php';

// Funções para para/com o servidor
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $funcao = $_POST['funcao'];
    switch ($funcao) {
        case 'exibirPanfleto':
            exibirPanfleto();
            break;
        case 'cadastrarProduto':
            cadastrarProduto();
            break;
        case 'listarProdutoFilial':
            listarProdutoFilial();
            break;
        case 'pesquisarProdutoFilial':
            pesquisarProdutoFilial();
            break;
        case 'vincularFilialProduto':
            vincularFilialProduto();
            break;
        case 'desvincularFilialProduto':
            desvincularFilialProduto();
            break;
        case 'selecaoFilial':
            selecaoFilial();
            break;
        case 'seletorFilial':
            seletorFilial();
            break;
        case 'atualizarPreco':
            atualizarPreco();
            break;
        case 'acoesExecutar':
            acoesExecutar();
            break;
        case 'concluirAssociacaoProdutoFilial':
            concluirAssociacaoProdutoFilial();
            break;
        default:
            break;
    }
}

function cadastrarProduto()
{
    global $conexao;

    // Adiciona as informações descritivas do produto
    $statusProduto = 0;
    if (isset($_POST['statusProduto']) && $_POST['statusProduto'] == "on") {
        $statusProduto = 1;
    }
    $codigoProduto = $_POST['codigoProduto'];
    $descricaoProduto = $_POST['descricaoProduto'];
    $tipoProduto = $_POST['tipoProduto'];

    $sql = "INSERT INTO `tb_produto` (
                `status`,
                `cod_produto`,
                `desc_produto`,
                `tipo_produto`
                )VALUES(
                ?,
                ?,
                ?,
                ?
                );";

    $statement = $conexao->prepare($sql);

    if (!$statement) {
        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
    }

    $statement->bind_param("issi", $statusProduto, $codigoProduto, $descricaoProduto, $tipoProduto);

    if (!$statement->execute()) {
        throw new Exception("Erro na execução da consulta: " . $conexao->error);
    }

    // Captura o id do produto adicionado
    $idProduto = $conexao->insert_id;

    // Adiciona o valor do produto caso seja vendido unitário
    if ($_POST['tipoVenda'] == 1) {
        if (isset($_POST['valorUnitarioPr'])) {
            $valor = str_replace(",", ".", $_POST['valorUnitarioPr']);

            $sql = "INSERT INTO `tb_preco`(
                        `tipo_venda`,
                        `valor`,
                        `quantidade`,
                        `uf`,
                        `fk_produto`
                        )VALUES(
                        '1',
                        ?,
                        '1',
                        'PR',
                        ?
                        );";

            $statement = $conexao->prepare($sql);

            if (!$statement) {
                throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            }

            $statement->bind_param("di", $valor, $idProduto);

            if (!$statement->execute()) {
                throw new Exception("Erro na execução da consulta: " . $conexao->error);
            }
        }
        if (isset($_POST['valorUnitarioMs'])) {
            $valor = $_POST['valorUnitarioMs'];

            $sql = "INSERT INTO `tb_preco`(
                        `tipo_venda`,
                        `valor`,
                        `quantidade`,
                        `uf`,
                        `fk_produto`
                        )VALUES(
                        '1',
                        ?,
                        '1',
                        'MS',
                        ?
                        );";

            $statement = $conexao->prepare($sql);

            if (!$statement) {
                throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            }

            $statement->bind_param("di", $valor, $idProduto);

            if (!$statement->execute()) {
                throw new Exception("Erro na execução da consulta: " . $conexao->error);
            }
        }
    }

    // Adiciona o valor do produto caso seja vendido em quantidade
    if ($_POST['tipoVenda'] == 2) {
        if (isset($_POST['valorProduto1pr'])) {
            $valor = str_replace(",", ".", $_POST['valorProduto1pr']);
            $quantidade = $_POST['quantidadeProduto1'];

            $sql = "INSERT INTO `tb_preco`(
                        `tipo_venda`,
                        `valor`,
                        `quantidade`,
                        `uf`,
                        `fk_produto`
                        )VALUES(
                        '2',
                        ?,
                        ?,
                        'PR',
                        ?
                        );";

            $statement = $conexao->prepare($sql);

            if (!$statement) {
                throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            }

            $statement->bind_param("dii", $valor, $quantidade, $idProduto);

            if (!$statement->execute()) {
                throw new Exception("Erro na execução da consulta: " . $conexao->error);
            }
        }
        if (isset($_POST['valorProduto1ms'])) {
            $valor = str_replace(",", ".", $_POST['valorProduto1ms']);
            $quantidade = $_POST['quantidadeProduto1'];

            $sql = "INSERT INTO `tb_preco`(
                        `tipo_venda`,
                        `valor`,
                        `quantidade`,
                        `uf`,
                        `fk_produto`
                        )VALUES(
                        '2',
                        ?,
                        ?,
                        'MS',
                        ?
                        );";

            $statement = $conexao->prepare($sql);

            if (!$statement) {
                throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            }

            $statement->bind_param("dii", $valor, $quantidade, $idProduto);

            if (!$statement->execute()) {
                throw new Exception("Erro na execução da consulta: " . $conexao->error);
            }
        }
        if (isset($_POST['valorProduto2pr'])) {
            $valor = str_replace(",", ".", $_POST['valorProduto2pr']);
            $quantidade = $_POST['quantidadeProduto2'];

            $sql = "INSERT INTO `tb_preco`(
                        `tipo_venda`,
                        `valor`,
                        `quantidade`,
                        `uf`,
                        `fk_produto`
                        )VALUES(
                        '2',
                        ?,
                        ?,
                        'PR',
                        ?
                        );";

            $statement = $conexao->prepare($sql);

            if (!$statement) {
                throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            }

            $statement->bind_param("dii", $valor, $quantidade, $idProduto);

            if (!$statement->execute()) {
                throw new Exception("Erro na execução da consulta: " . $conexao->error);
            }
        }
        if (isset($_POST['valorProduto2ms'])) {
            $valor = str_replace(",", ".", $_POST['valorProduto2ms']);
            $quantidade = $_POST['quantidadeProduto2'];

            $sql = "INSERT INTO `tb_preco`(
                        `tipo_venda`,
                        `valor`,
                        `quantidade`,
                        `uf`,
                        `fk_produto`
                        )VALUES(
                        '2',
                        ?,
                        ?,
                        'MS',
                        ?
                        );";

            $statement = $conexao->prepare($sql);

            if (!$statement) {
                throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            }

            $statement->bind_param("dii", $valor, $quantidade, $idProduto);

            if (!$statement->execute()) {
                throw new Exception("Erro na execução da consulta: " . $conexao->error);
            }
        }
        if (isset($_POST['valorProduto3pr'])) {
            $valor = str_replace(",", ".", $_POST['valorProduto3pr']);
            $quantidade = $_POST['quantidadeProduto3'];

            $sql = "INSERT INTO `tb_preco`(
                        `tipo_venda`,
                        `valor`,
                        `quantidade`,
                        `uf`,
                        `fk_produto`
                        )VALUES(
                        '2',
                        ?,
                        ?,
                        'PR',
                        ?
                        );";

            $statement = $conexao->prepare($sql);

            if (!$statement) {
                throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            }

            $statement->bind_param("dii", $valor, $quantidade, $idProduto);

            if (!$statement->execute()) {
                throw new Exception("Erro na execução da consulta: " . $conexao->error);
            }
        }
        if (isset($_POST['valorProduto3ms'])) {
            $valor = str_replace(",", ".", $_POST['valorProduto3ms']);
            $quantidade = $_POST['quantidadeProduto3'];

            $sql = "INSERT INTO `tb_preco`(
                        `tipo_venda`,
                        `valor`,
                        `quantidade`,
                        `uf`,
                        `fk_produto`
                        )VALUES(
                        '2',
                        ?,
                        ?,
                        'MS',
                        ?
                        );";

            $statement = $conexao->prepare($sql);

            if (!$statement) {
                throw new Exception("Erro na preparação da consulta: " . $conexao->error);
            }

            $statement->bind_param("dii", $valor, $quantidade, $idProduto);

            if (!$statement->execute()) {
                throw new Exception("Erro na execução da consulta: " . $conexao->error);
            }
        }
    }

    header("Location: ../pages/cadastrar.html");
}

function listarProdutoFilial()
{
    global $conexao;

    if (!isset($_SESSION)) {
        session_start();
    }

    $sessao = $_SESSION['id_filial'];

    $sql = "SELECT p.id_produto, p.cod_produto, p.desc_produto, pf.status
            FROM tb_filial f
            JOIN filial_produto pf ON f.id_filial = pf.fk_filial
            JOIN tb_produto p ON p.id_produto = pf.fk_produto
            WHERE f.id_filial = ?
            AND p.status = 1
            AND (pf.status = 1 OR pf.status = 2)
            ORDER BY p.desc_produto ASC;";

    $statement = $conexao->prepare($sql);

    if (!$statement) {
        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
    }

    $statement->bind_param("i", $sessao);

    if (!$statement->execute()) {
        throw new Exception("Erro na execução da consulta: " . $conexao->error);
    }

    $result = $statement->get_result();

    if (!$result) {
        throw new Exception("Erro ao obter os resultados da consulta: " . $conexao->error);
    }

    $dados = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($dados);
}

function pesquisarProdutoFilial()
{
    global $conexao;

    if (!isset($_SESSION)) {
        session_start();
    }

    $sessao = $_SESSION['id_filial'];

    $busca = "%" . $_POST['busca'] . "%";
    $sql = "SELECT p.id_produto, p.cod_produto, p.desc_produto
                FROM tb_produto p
                WHERE NOT EXISTS
                (
                SELECT 1 
                FROM filial_produto pf 
                WHERE pf.fk_produto = p.id_produto 
                AND pf.fk_filial = ?
                )
                AND (p.cod_produto LIKE ? OR p.desc_produto LIKE ?)
                AND p.status = 1;";

    $statement = $conexao->prepare($sql);

    if (!$statement) {
        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
    }

    $statement->bind_param("iss", $sessao, $busca, $busca);

    if (!$statement->execute()) {
        throw new Exception("Erro na execução da consulta: " . $conexao->error);
    }

    $result = $statement->get_result();

    if (!$result) {
        throw new Exception("Erro ao obter os resultados da consulta: " . $conexao->error);
    }

    $dados = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($dados);
}

function vincularFilialProduto()
{
    global $conexao;

    if (!isset($_SESSION)) {
        session_start();
    }

    $idProduto = $_POST['vincularIdProduto'];
    $sessao = $_SESSION['id_filial'];


    $sql = "INSERT INTO filial_produto (
            fk_produto,
            fk_filial,
            status
            )VALUES(
            ?,
            ?,
            2
            );";

    $statement = $conexao->prepare($sql);

    if (!$statement) {
        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
    }

    $statement->bind_param("ss", $idProduto, $sessao);

    if (!$statement->execute()) {
        throw new Exception("Erro na execução da consulta: " . $conexao->error);
    }
}

function selecaoFilial()
{
    if (!isset($_SESSION)) {
        session_start();
    }

    $_SESSION['id_filial'] = $_POST['selecaoFilial'];
}

function seletorFilial()
{
    global $conexao;
    if (!isset($_SESSION)) {
        session_start();
    }

    $sessao = null;

    if (isset($_SESSION['id_filial'])) {
        $sessao = $_SESSION['id_filial'];
    }

    $sql = "SELECT f.id_filial, f.filial
    FROM tb_filial f
    WHERE f.status = 1;";

    $statement = $conexao->prepare($sql);

    if (!$statement) {
        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
    }

    if (!$statement->execute()) {
        throw new Exception("Erro na execução da consulta: " . $conexao->error);
    }

    $result = $statement->get_result();

    if (!$result) {
        throw new Exception("Erro ao obter os resultados da consulta: " . $conexao->error);
    }

    $dados = [
        'sessao' => $sessao,
        'filiais' => $result->fetch_all(MYSQLI_ASSOC)
    ];

    echo json_encode($dados);
}

function atualizarPreco()
{
    global $conexao;

    $dadosJson = $_POST['dados'];
    $dados = json_decode($dadosJson, true); // true para array associativo

    usort($dados, function ($a, $b) {
        if ($a['codigo'] != $b['codigo']) {
            return $a['codigo'] - $b['codigo']; // Ordena primeiro por código
        }
        return $a['quantidade'] - $b['quantidade']; // Depois por quantidade
    });

    for ($i = 0; $i < count($dados); $i++) {
        $dadosUpdate = [];

        while (true) {
            if (isset($dados[$i + 1]) && $dados[$i]['codigo'] == $dados[$i + 1]['codigo']) {
                $dadosUpdate[] = $dados[$i];
                $i++;
            } else {
                $dadosUpdate[] = $dados[$i];
                break;
            }
        }

        if (count($dadosUpdate) == 1) {

            $vaiAlterarProduto = false;

            foreach ($dadosUpdate as $produtoConferir) {
                $diferencaPorcentagem = floatval(str_replace(",", ".", $produtoConferir['porc']));
                echo "$diferencaPorcentagem\n";
                echo ($diferencaPorcentagem != 0.0), "\n";
                if ($diferencaPorcentagem != 0.0) {
                    $vaiAlterarProduto = true;
                }
            }

            if ($vaiAlterarProduto == true) {
                $sql = "SELECT p.id_produto 
                    FROM tb_produto p 
                    WHERE p.cod_produto = ?;";

                $statement = $conexao->prepare($sql);

                if (!$statement) {
                    throw new Exception("Erro na preparação da consulta: " . $conexao->error);
                }

                $statement->bind_param("i", $dadosUpdate[0]['codigo']);

                if (!$statement->execute()) {
                    throw new Exception("Erro na execução da consulta: " . $conexao->error);
                }

                $result = $statement->get_result();

                if (!$result) {
                    throw new Exception("Erro ao obter os resultados da consulta: " . $conexao->error);
                }

                $dadosProcura = $result->fetch_assoc();

                if (isset($dadosProcura['id_produto'])) {

                    // Captura os novos preços
                    $id = $dadosProcura['id_produto'];
                    $preco = str_replace(",", ".", $dadosUpdate[0]['preco']);
                    $quantidade = $dadosUpdate[0]['quantidade'];
                    $tipoVenda = 1;
                    $uf = $_POST['ufAtualizarPreco'];

                    // Deleta os preços atuais
                    $sql = "DELETE 
                        FROM tb_preco
                        WHERE fk_produto = ?
                        AND uf = ?;";

                    $statement = $conexao->prepare($sql);

                    if (!$statement) {
                        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
                    }

                    $statement->bind_param("is", $id, $uf);

                    if (!$statement->execute()) {
                        throw new Exception("Erro na execução da consulta: " . $conexao->error);
                    }

                    // Adiciona os novos preços
                    $sql = "INSERT INTO tb_preco(
                        fk_produto,
                        valor, 
                        quantidade, 
                        tipo_venda, 
                        uf
                        ) VALUES (
                        ?, 
                        ?, 
                        ?, 
                        ?, 
                        ?
                        );";

                    $statement = $conexao->prepare($sql);

                    if (!$statement) {
                        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
                    }

                    $statement->bind_param("idiis", $id, $preco, $quantidade, $tipoVenda, $uf);

                    if (!$statement->execute()) {
                        throw new Exception("Erro na execução da consulta: " . $conexao->error);
                    }

                    // Alterar status do vinculo de filial_produto para "PENDENTE - int:(2)"

                    // =================================================================================
                    // Codigo precisa ser corrigido para caso seja adicionado mais filiais, ainda é
                    // limitada trazendo suporte somente as filiais "CP", "RD", "MX", "NV" e "NA".
                    // =================================================================================
                    if ($uf == "PR") {
                        $sql = "UPDATE filial_produto 
                        SET status = 2 
                        WHERE fk_produto = ?
                        AND
                        (fk_filial = 1 OR fk_filial = 2 OR fk_filial = 3);";
                    } else {
                        $sql = "UPDATE filial_produto 
                        SET status = 2 
                        WHERE fk_produto = ?
                        AND
                        (fk_filial = 4 OR fk_filial = 5);";
                    }

                    $statement = $conexao->prepare($sql);

                    if (!$statement) {
                        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
                    }

                    $statement->bind_param("i", $id);

                    if (!$statement->execute()) {
                        throw new Exception("Erro na execução da consulta: " . $conexao->error);
                    }else{
                        echo "Atualizado";
                    }
                }
            }
        } else {

            $vaiAlterarProduto = false;

            foreach ($dadosUpdate as $produtoConferir) {
                $diferencaPorcentagem = floatval(str_replace(",", ".", $produtoConferir['porc']));
                echo "$diferencaPorcentagem\n";
                echo ($diferencaPorcentagem != 0.0), "\n";
                if ($diferencaPorcentagem != 0.0) {
                    $vaiAlterarProduto = true;
                }
            }

            if ($vaiAlterarProduto == true) {
                $sql = "SELECT p.id_produto 
                    FROM tb_produto p 
                    WHERE p.cod_produto = ?;";

                $statement = $conexao->prepare($sql);

                if (!$statement) {
                    throw new Exception("Erro na preparação da consulta: " . $conexao->error);
                }

                $statement->bind_param("i", $dadosUpdate[0]['codigo']);

                if (!$statement->execute()) {
                    throw new Exception("Erro na execução da consulta: " . $conexao->error);
                }

                $result = $statement->get_result();

                if (!$result) {
                    throw new Exception("Erro ao obter os resultados da consulta: " . $conexao->error);
                }

                $dadosProcura = $result->fetch_assoc();

                if (isset($dadosProcura['id_produto'])) {

                    $id = $dadosProcura['id_produto'];
                    $uf = $_POST['ufAtualizarPreco'];

                    // Deleta os preços atuais
                    $sql = "DELETE 
                        FROM tb_preco
                        WHERE fk_produto = ?
                        AND uf = ?;";

                    $statement = $conexao->prepare($sql);

                    if (!$statement) {
                        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
                    }

                    $statement->bind_param("is", $id, $uf);

                    if (!$statement->execute()) {
                        throw new Exception("Erro na execução da consulta: " . $conexao->error);
                    }

                    foreach ($dadosUpdate as $produto) {

                        // // Captura os novos preços
                        $preco = str_replace(",", ".", $produto['preco']);
                        $quantidade = $produto['quantidade'];
                        $tipoVenda = 2;

                        // Adiciona os novos preços
                        $sql = "INSERT INTO tb_preco
                            (fk_produto, valor, quantidade, tipo_venda, uf) 
                            VALUES 
                            (?, ?, ?, ?, ?);";

                        $statement = $conexao->prepare($sql);

                        if (!$statement) {
                            throw new Exception("Erro na preparação da consulta: " . $conexao->error);
                        }

                        $statement->bind_param("idiis", $id, $preco, $quantidade, $tipoVenda, $uf);

                        if (!$statement->execute()) {
                            throw new Exception("Erro na execução da consulta: " . $conexao->error);
                        }
                    }

                    // Alterar status do vinculo de filial_produto para "PENDENTE - int:(2)"

                    // =================================================================================
                    // Codigo precisa ser corrigido para caso seja adicionado mais filiais, ainda é
                    // limitada trazendo suporte somente as filiais "CP", "RD", "MX", "NV" e "NA".
                    // =================================================================================
                    if ($uf == "PR") {
                        $sql = "UPDATE filial_produto 
                        SET status = 2 
                        WHERE fk_produto = ?
                        AND
                        (fk_filial = 1 OR fk_filial = 2 OR fk_filial = 3);";
                    } else {
                        $sql = "UPDATE filial_produto 
                        SET status = 2 
                        WHERE fk_produto = ?
                        AND
                        (fk_filial = 4 OR fk_filial = 5);";
                    }


                    $statement = $conexao->prepare($sql);

                    if (!$statement) {
                        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
                    }

                    $statement->bind_param("i", $id);

                    if (!$statement->execute()) {
                        throw new Exception("Erro na execução da consulta: " . $conexao->error);
                    }else{
                        echo "Atualizado";
                    }
                }
            }
        }
    }
}

function acoesExecutar()
{
    $dadosJson = $_POST['ids'];
    $dados = json_decode($dadosJson, true); // true para array associativo
    $acao = $_POST['acao'];

    switch ($acao) {
        case "exibir":
            exibirPanfleto($dados);
            break;
        case "concluir":
            echo "Função concluir com os dados:\n";
            var_dump($dados);
            break;
        case "excluir":
            echo "Função excluir com os dados:\n";
            var_dump($dados);
            break;
    }
}

function exibirPanfleto()
{
    global $conexao;

    if (!isset($_SESSION)) {
        session_start();
    }

    $sessao = $_SESSION['id_filial'];
    $ids = json_decode($_POST['ids'], true);
    $idsArray =  $ids['ids'];

    // Cria os placeholders (?, ?, ?) conforme o número de produtos
    $placeholders = implode(',', array_fill(0, count($idsArray), '?'));
    $tipos = str_repeat('i', count($idsArray) + 1); // 'i' para id_filial + cada id_produto


    $sql = "SELECT p.cod_produto, p.desc_produto, p.tipo_produto, pr.tipo_venda, pr.valor, pr.quantidade
                FROM tb_filial f
                JOIN filial_produto pf ON f.id_filial = pf.fk_filial
                JOIN tb_produto p ON p.id_produto = pf.fk_produto
                JOIN tb_preco pr ON p.id_produto = pr.fk_produto
                WHERE f.id_filial = ?
                AND pr.uf = f.uf
                AND p.status = 1
                AND pr.status = 1
                AND p.id_produto IN ($placeholders)
                ORDER BY p.desc_produto ASC, pr.quantidade ASC
                ;";

    $statement = $conexao->prepare($sql);

    if (!$statement) {
        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
    }

    // Junta id da filial com os IDs dos produtos
    $params = array_merge([$sessao], $idsArray);

    // Usa bind_param com argumentos variáveis
    $statement->bind_param($tipos, ...$params);

    if (!$statement->execute()) {
        throw new Exception("Erro na execução da consulta: " . $conexao->error);
    }

    $result = $statement->get_result();

    if (!$result) {
        throw new Exception("Erro ao obter os resultados da consulta: " . $conexao->error);
    }

    $dados = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode($dados);
}

function concluirAssociacaoProdutoFilial()
{
    global $conexao;

    if (!isset($_SESSION)) {
        session_start();
    }

    $sessao = $_SESSION['id_filial'];
    $ids = json_decode($_POST['ids'], true);

    // var_dump($sessao, $ids);

    // Cria os placeholders (?, ?, ?) conforme o número de produtos
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $tipos = str_repeat('i', count($ids) + 1); // 'i' para id_filial + cada id_produto


    $sql = "UPDATE filial_produto 
            SET status = 1 
            WHERE fk_filial = ?
            AND status = 2 
            AND fk_produto IN ($placeholders);";

    $statement = $conexao->prepare($sql);

    if (!$statement) {
        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
    }

    // Junta id da filial com os IDs dos produtos
    $params = array_merge([$sessao], $ids);

    // Usa bind_param com argumentos variáveis
    $statement->bind_param($tipos, ...$params);

    if (!$statement->execute()) {
        throw new Exception("Erro na execução da consulta: " . $conexao->error);
    }
}

function desvincularFilialProduto()
{
    global $conexao;

    if (!isset($_SESSION)) {
        session_start();
    }

    $sessao = $_SESSION['id_filial'];
    $ids = json_decode($_POST['ids'], true);

    // var_dump($sessao, $ids);

    // Cria os placeholders (?, ?, ?) conforme o número de produtos
    $placeholders = implode(',', array_fill(0, count($ids), '?'));
    $tipos = str_repeat('i', count($ids) + 1); // 'i' para id_filial + cada id_produto

    $sql = "DELETE FROM filial_produto
            WHERE fk_filial = ? 
            AND fk_produto IN ($placeholders);";

    $statement = $conexao->prepare($sql);

    if (!$statement) {
        throw new Exception("Erro na preparação da consulta: " . $conexao->error);
    }

    // Junta id da filial com os IDs dos produtos
    $params = array_merge([$sessao], $ids);

    // Usa bind_param com argumentos variáveis
    $statement->bind_param($tipos, ...$params);

    if (!$statement->execute()) {
        throw new Exception("Erro na execução da consulta: " . $conexao->error);
    }
}
