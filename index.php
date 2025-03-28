<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD</title>
    <link rel="stylesheet" href="estilo.css">
</head>

<body>

    <header>
        <h1 class="titulo">CRUD para gestão de etiquetas</h1>
    </header>

    <main class="container">
        <div class="cadastro">
            <h2>Cadastro de produto</h2>

            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
                <div>
                    <div class="caixa">
                        <label for="nome_cadastro">Nome:</label>
                        <input type="text" name="nome_cadastro">
                    </div>
                    <div class="caixa">
                        <label for="preco_cadastro">Preço:</label>
                        <input step="0.01" type="number" name="preco_cadastro">
                    </div>
                </div>
                <?php
                include("database.php");

                if (!empty($_GET["nome_cadastro"]) && !empty($_GET["preco_cadastro"])) {

                    $nome = $_GET["nome_cadastro"];
                    $preco = $_GET["preco_cadastro"];

                    $sql_code = "INSERT INTO etiquetas (preco, nome)
                VALUES ($preco, '$nome');";

                    $sql_code_completo = "SELECT * FROM etiquetas WHERE nome = '$nome';";

                    if (mysqli_query($conexao, $sql_code_completo)) {
                        $dados = mysqli_query($conexao, $sql_code_completo);
                        if (mysqli_fetch_assoc($dados)) {
                            $linha = mysqli_fetch_assoc($dados);
                            echo "<p>Produto $nome ja exite</p>";
                        }else {
                            if (mysqli_query($conexao, $sql_code)) {
                                echo "<p>Produto $nome registrado com sucesso</p>";
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
                <select class="caixa" name="produto_leitura">
                    <option selected>Selecione</option>
                    <?php
                    include("database.php");

                    $sql_code = "SELECT * FROM etiquetas";

                    if (mysqli_query($conexao, $sql_code)) {
                        $dados = mysqli_query($conexao, $sql_code);
                        while ($linha = mysqli_fetch_assoc($dados)) {
                            echo "<option value='$linha[nome]'>$linha[nome]</option>";
                        }
                    }

                    ?>
                </select>
                <?php

                if (isset($_GET["produto_leitura"])) {
                    $produtoEscolhido = $_GET["produto_leitura"];
                    $sql_code = "SELECT * FROM etiquetas WHERE nome = '$produtoEscolhido'";

                    if (mysqli_query($conexao, $sql_code)) {
                        $dados = mysqli_query($conexao, $sql_code);
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
                    <select class="caixa" name="nome_atualizacao">
                        <option selected>Selecione</option>
                        <?php

                        $sql_code = "SELECT * FROM etiquetas";

                        if (mysqli_query($conexao, $sql_code)) {
                            $dados = mysqli_query($conexao, $sql_code);
                            while ($linha = mysqli_fetch_assoc($dados)) {
                                echo "<option value='$linha[nome]'>$linha[nome]</option>";
                            }
                        }

                        ?>
                    </select>
                    <div class="caixa">
                        <label for="preco_atualizado">Preço:</label>
                        <input step="0.01" type="number" name="preco_atualizado">
                    </div>

                </div>
                <?php
                if (!empty($_GET["preco_atualizado"]) && isset($_GET["nome_atualizacao"]) && $_GET["nome_atualizacao"] !== "Selecione") {

                    $preco_atualizado = $_GET["preco_atualizado"];
                    $nome_atualizacao = $_GET["nome_atualizacao"];


                    $sql_code = "UPDATE etiquetas SET preco = '$preco_atualizado' WHERE nome = '$nome_atualizacao'";

                    if (mysqli_query($conexao, $sql_code)) {
                        echo "<p>Produto $nome_atualizacao atualizado com sucesso</p>";
                    }
                }

                ?>
                <input class="enviar" type="submit">
            </form>

        </div>
        <div class="deletar">

            <h2>Deletar produto</h2>

            <form action="<?= $_SERVER['PHP_SELF']; ?>" method="get">
                <select class="caixa" name="nome_excluir">
                    <option selected>Selecione</option>

                    <?php
                    $sql_code = "SELECT * FROM etiquetas";

                    if (mysqli_query($conexao, $sql_code)) {
                        $dados = mysqli_query($conexao, $sql_code);
                        while ($linha = mysqli_fetch_assoc($dados)) {
                            echo "<option value='$linha[nome]'>$linha[nome]</option>";
                        }
                    }
                    ?>

                </select>
                <?php
                if (isset($_GET["nome_excluir"]) && $_GET["nome_excluir"] !== "Selecione") {
                    $produto_excluir = $_GET["nome_excluir"];
                    $sql_code = "DELETE FROM etiquetas WHERE nome = '$produto_excluir'";

                    if (mysqli_query($conexao, $sql_code)) {
                        echo "<p>Produto: $produto_excluir excluido com sucesso</p>";
                    }
                }
                ?>
                <input class="enviar" type="submit">
            </form>

        </div>

    </main>

</body>

</html>