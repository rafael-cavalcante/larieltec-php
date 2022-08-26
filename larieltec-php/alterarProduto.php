<?php

session_start();

include './conexao.php';

$produto = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!isset($produto['nome']) || !isset($produto['valor']) || !isset($produto['quantidade'])) {
    header('Location: index.php');
    exit();
}

include './uploadFotoProduto.php';

$query = "UPDATE Produto set valor='{$produto["valor"]}', quantidade='{$produto["quantidade"]}', emailUsuario='{$_SESSION["usuarioLogado"]["email"]}', foto='src/fotosProdutos/{$_FILES["userfile"]["name"]}' WHERE nome='{$produto["nome"]}'";


if($conexao->exec($query) ){
    unlink($produto['fotoAntiga']);
    header("Location: index.php?msgSucesso=Produto alterado com sucesso");
}else{
    unlink("src/fotosProdutos/".$_FILES["userfile"]["name"]);
    header("Location: index.php?msgErro=Não foi possível alterar produto");
}
exit();