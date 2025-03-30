<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="estilo.css">
</head>

<body>

    <?php
    include("database.php");
    //pegar todos os dados e botar em option
    function botarDadosEmOption()
    {
        include("database.php");
        $sqlCodigo = "SELECT * FROM etiquetas";

        if (mysqli_query($conexao, $sqlCodigo)) {
            $dados = mysqli_query($conexao, $sqlCodigo);
            while ($linha = mysqli_fetch_assoc($dados)) {
                echo "<option value='$linha[nome]'>$linha[nome]</option>";
            }
        }
    }
    ?>

    <header>
        <h1 class="titulo">CRUD para gestão de etiquetas</h1>
    </header>

    <main class="container">
        <div class="cadastro">
            <h2>Cadastro de produto</h2>

            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
                <div>
                    <div class="caixa">
                        <label for="nomeCadastrar">Nome:</label>
                        <input required type="text" name="nomeCadastrar">
                    </div>
                    <div class="caixa">
                        <label for="precoCadastrar">Preço:</label>
                        <input required step="0.01" type="number" name="precoCadastrar">
                    </div>
                </div>
                <?php
                //validar se os dados a cadastrar existem
                if (!empty($_GET["nomeCadastrar"]) && !empty($_GET["precoCadastrar"])) {

                    $nomeCadastrar = $_GET["nomeCadastrar"];
                    $precoCadastrar = $_GET["precoCadastrar"];

                    $sqlCodigo = "INSERT INTO etiquetas (preco, nome)
                    VALUES ($precoCadastrar, '$nomeCadastrar');";

                    $sqlCodigo_completo = "SELECT * FROM etiquetas WHERE nome = '$nomeCadastrar';";

                    //inserir os dados na tabela
                    if (mysqli_query($conexao, $sqlCodigo_completo)) {
                        $dados = mysqli_query($conexao, $sqlCodigo_completo);
                        if (mysqli_fetch_assoc($dados)) {
                            $linha = mysqli_fetch_assoc($dados);
                            echo "<p>Produto $nomeCadastrar ja exite</p>";
                        } else {
                            if (mysqli_query($conexao, $sqlCodigo)) {
                                echo "<p>Produto $nomeCadastrar registrado com sucesso</p>";
                            }
                        }
                    }
                }
                ?>
                <input class="enviar" type="submit">
            </form>

        </div>
        <div class="leitura">

            <h2>Leitura de produto</h2>

            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
                <select class="caixa" name="produtoLer">
                    <option selected>Selecione</option>
                    <?php
                    botarDadosEmOption()
                    ?>
                </select>
                <?php
                //ver se o dados a ler existem
                if (!empty($_GET["produtoLer"])) {
                    $produtoLer = $_GET["produtoLer"];
                    $sqlCodigo = "SELECT * FROM etiquetas WHERE nome = '$produtoLer'";

                    //pegar somente o dado selecionado para leitura
                    if (mysqli_query($conexao, $sqlCodigo)) {
                        $dados = mysqli_query($conexao, $sqlCodigo);
                        $linha = mysqli_fetch_assoc($dados);
                        if (isset($linha)) {
                            echo "<p>ID: $linha[produtoID] - Nome: $linha[nome] - Preco: R$$linha[preco]</p>";
                        }
                    }
                }

                ?>
                <input class="enviar" type="submit">
            </form>

        </div>
        <div class="atualizacao">

            <h2>Atualização de produto</h2>

            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
                <div>
                    <select class="caixa" name="nomeAtualizar">
                        <option selected>Selecione</option>
                        <?php
                        botarDadosEmOption()
                        ?>
                    </select>
                    <div class="caixa">
                        <label for="precoAtualizar">Preço:</label>
                        <input required step="0.01" type="number" name="precoAtualizar">
                    </div>

                </div>
                <?php

                //validar se os dados a atualizar existem
                if (!empty($_GET["precoAtualizar"]) && !empty($_GET["nomeAtualizar"]) && $_GET["nomeAtualizar"] !== "Selecione") {

                    $precoAtualizar = $_GET["precoAtualizar"];
                    $nomeAtualizar = $_GET["nomeAtualizar"];


                    $sqlCodigo = "UPDATE etiquetas SET preco = '$precoAtualizar' WHERE nome = '$nomeAtualizar'";

                    //atualizar os dados na tabela
                    if (mysqli_query($conexao, $sqlCodigo)) {
                        echo "<p>Produto $nomeAtualizar atualizado com sucesso</p>";
                    }
                }

                ?>
                <input class="enviar" type="submit">
            </form>

        </div>
        <div class="deletar">

            <h2>Deletar produto</h2>

            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
                <select class="caixa" name="nomeExcluir">
                    <option selected>Selecione</option>

                    <?php
                    botarDadosEmOption()
                    ?>

                </select>
                <?php

                //validar se os dados a excluir existem
                if (!empty($_GET["nomeExcluir"]) && $_GET["nomeExcluir"] !== "Selecione") {
                    $produtoExcluir = $_GET["nomeExcluir"];

                    $sqlCodigo = "DELETE FROM etiquetas WHERE nome = '$produtoExcluir'";

                    //excluir os dados da tabela
                    if (mysqli_query($conexao, $sqlCodigo)) {
                        echo "<p>Produto: $produtoExcluir excluido com sucesso</p>";
                    }
                }
                ?>
                <input class="enviar" type="submit">
            </form>
        </div>
    </main>

</body>

</html>