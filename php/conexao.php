<?php





$conexao = mysqli_connect("127.0.0.1", "root", "", "db_oferta");

if (isset($_GET['funcao'])) {
    switch ($_GET['funcao']) {
        case 'exibirPanfleto':
            $db = mysqli_query($conexao, "  SELECT p.cod_produto, p.desc_produto, p.tipo_produto, pr.tipo_venda, pr.valor, pr.quantidade
                                            FROM tb_filial f
                                            JOIN filial_produto pf ON f.id_filial = pf.fk_filial
                                            JOIN tb_produto p ON p.id_produto = pf.fk_produto
                                            JOIN tb_preco pr ON p.id_produto = pr.fk_produto
                                            WHERE f.filial = 'CP'
                                            AND f.uf = 'PR'
                                            AND pr.uf = f.uf
                                            AND p.status = 1
                                            AND pr.status = 1
                                            AND pf.status = 1
                                            ;");

            while ($l = $db->fetch_assoc()) {
                $dados[] = $l;
            }

            echo json_encode($dados);
            break;
        case 'cadastrarProduto':
            echo '<pre>';
            var_dump($_POST);
            echo '</pre>';

            $codigoProduto = $_POST['codigoProduto'];
            $descricaoProduto = $_POST['descricaoProduto'];
            $tipoProduto = $_POST['tipoProduto'];

            $sql = "INSERT INTO `tb_produto` (
            `cod_produto`,
            `desc_produto`,
            `tipo_produto`
            )VALUES(
            '$codigoProduto',
            '$descricaoProduto',
            '$tipoProduto'
            );";

            try {
                mysqli_query($conexao, $sql);
            } catch (Exception $e) {
                echo "Erro: " . $e->getMessage();
            }

            $idProduto = mysqli_insert_id($conexao);

            if ($_POST['tipoVenda'] == 1) {
                if (isset($_POST['valorUnitarioPr'])) {
                    $valor = $_POST['valorUnitarioPr'];

                    $sql = "INSERT INTO `tb_preco`(
                    `tipo_venda`,
                    `valor`,
                    `quantidade`,
                    `uf`,
                    `fk_produto`
                    )VALUES(
                    '1',
                    '$valor',
                    '1',
                    'PR',
                    '$idProduto'
                    );";

                    try {
                        mysqli_query($conexao, $sql);
                    } catch (Exception $e) {
                        echo "Erro: " . $e->getMessage();
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
                    '$valor',
                    '1',
                    'MS',
                    '$idProduto'
                    );";

                    try {
                        mysqli_query($conexao, $sql);
                    } catch (Exception $e) {
                        echo "Erro: " . $e->getMessage();
                    }
                }
            }

            if ($_POST['tipoVenda'] == 2) {
                if (isset($_POST['valorProduto1pr'])) {
                    $valor = $_POST['valorProduto1pr'];
                    $quantidade = $_POST['quantidadeProduto1'];

                    $sql = "INSERT INTO `tb_preco`(
                    `tipo_venda`,
                    `valor`,
                    `quantidade`,
                    `uf`,
                    `fk_produto`
                    )VALUES(
                    '2',
                    '$valor',
                    '$quantidade',
                    'PR',
                    '$idProduto'
                    );";

                    try {
                        mysqli_query($conexao, $sql);
                    } catch (Exception $e) {
                        echo "Erro: " . $e->getMessage();
                    }
                }
                if (isset($_POST['valorProduto1ms'])) {
                    $valor = $_POST['valorProduto1ms'];
                    $quantidade = $_POST['quantidadeProduto1'];

                    $sql = "INSERT INTO `tb_preco`(
                    `tipo_venda`,
                    `valor`,
                    `quantidade`,
                    `uf`,
                    `fk_produto`
                    )VALUES(
                    '2',
                    '$valor',
                    '$quantidade',
                    'MS',
                    '$idProduto'
                    );";

                    try {
                        mysqli_query($conexao, $sql);
                    } catch (Exception $e) {
                        echo "Erro: " . $e->getMessage();
                    }
                }

                if (isset($_POST['valorProduto2pr'])) {
                    $valor = $_POST['valorProduto2pr'];
                    $quantidade = $_POST['quantidadeProduto2'];

                    $sql = "INSERT INTO `tb_preco`(
                    `tipo_venda`,
                    `valor`,
                    `quantidade`,
                    `uf`,
                    `fk_produto`
                    )VALUES(
                    '2',
                    '$valor',
                    '$quantidade',
                    'PR',
                    '$idProduto'
                    );";

                    try {
                        mysqli_query($conexao, $sql);
                    } catch (Exception $e) {
                        echo "Erro: " . $e->getMessage();
                    }
                }
                if (isset($_POST['valorProduto2ms'])) {
                    $valor = $_POST['valorProduto2ms'];
                    $quantidade = $_POST['quantidadeProduto2'];

                    $sql = "INSERT INTO `tb_preco`(
                    `tipo_venda`,
                    `valor`,
                    `quantidade`,
                    `uf`,
                    `fk_produto`
                    )VALUES(
                    '2',
                    '$valor',
                    '$quantidade',
                    'MS',
                    '$idProduto'
                    );";

                    try {
                        mysqli_query($conexao, $sql);
                    } catch (Exception $e) {
                        echo "Erro: " . $e->getMessage();
                    }
                }

                if (isset($_POST['valorProduto3pr'])) {
                    $valor = $_POST['valorProduto3pr'];
                    $quantidade = $_POST['quantidadeProduto3'];

                    $sql = "INSERT INTO `tb_preco`(
                    `tipo_venda`,
                    `valor`,
                    `quantidade`,
                    `uf`,
                    `fk_produto`
                    )VALUES(
                    '2',
                    '$valor',
                    '$quantidade',
                    'PR',
                    '$idProduto'
                    );";

                    try {
                        mysqli_query($conexao, $sql);
                    } catch (Exception $e) {
                        echo "Erro: " . $e->getMessage();
                    }
                }
                if (isset($_POST['valorProduto3ms'])) {
                    $valor = $_POST['valorProduto3ms'];
                    $quantidade = $_POST['quantidadeProduto3'];

                    $sql = "INSERT INTO `tb_preco`(
                    `tipo_venda`,
                    `valor`,
                    `quantidade`,
                    `uf`,
                    `fk_produto`
                    )VALUES(
                    '2',
                    '$valor',
                    '$quantidade',
                    'MS',
                    '$idProduto'
                    );";

                    try {
                        mysqli_query($conexao, $sql);
                    } catch (Exception $e) {
                        echo "Erro: " . $e->getMessage();
                    }
                }
            }
            break;
        case 'listarProdutoFilial':
            $db = mysqli_query($conexao, "  SELECT p.cod_produto, p.desc_produto
                                            FROM tb_filial f
                                            JOIN filial_produto pf ON f.id_filial = pf.fk_filial
                                            JOIN tb_produto p ON p.id_produto = pf.fk_produto
                                            WHERE f.filial = 'CP'
                                            AND f.uf = 'PR'
                                            AND p.status = 1
                                            AND pf.status = 1
                                            ;");

            while ($l = $db->fetch_assoc()) {
                $dados[] = $l;
            }

            echo json_encode($dados);
            break;
        case 'pesquisarProdutoFilial':
            $busca = $_GET['busca'];
            $db = mysqli_query($conexao, "  SELECT p.id_produto, p.cod_produto, p.desc_produto
                                            FROM tb_produto p
                                            WHERE NOT EXISTS (
                                                SELECT 1 
                                                FROM filial_produto pf 
                                                WHERE pf.fk_produto = p.id_produto 
                                                AND pf.fk_filial = 1
                                                )
                                            AND (p.cod_produto LIKE '%$busca%' OR p.desc_produto LIKE '%$busca%')
                                            ;");

            while ($l = $db->fetch_assoc()) {
                $dados[] = $l;
            }

            echo json_encode($dados);
            break;
        case 'vincularFilialProduto':
            $idProduto;
            $idFilial;
            if(isset($_GET['vincularIdProduto'])){
                $idProduto = $_GET['vincularIdProduto'];
            }
            if(isset($_GET['vincularIdFilial'])){
                $idFilial = $_GET['vincularIdFilial'];
            }
            $sql = "INSERT INTO `filial_produto` (`fk_produto`, `fk_filial`) VALUES ($idProduto, $idFilial);";
                
            mysqli_query($conexao, $sql);
            break;
        default:
            break;
    }
}
