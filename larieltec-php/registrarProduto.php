<?php

session_start();

include './conexao.php';

$produto = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!isset($produto['nome']) || !isset($produto['valor']) || !isset($produto['quantidade'])) {
    header('Location: index.php');
    exit();
}

include './uploadFotoProduto.php';

$query ="INSERT INTO Produto (nome, valor, quantidade, foto, emailUsuario) VALUES ('{$produto["nome"]}', '{$produto["valor"]}', '{$produto["quantidade"]}', 'src/fotosProdutos/{$_FILES["userfile"]["name"]}', '{$_SESSION["usuarioLogado"]["email"]}');";

if($conexao->exec($query) ){
    header("Location: index.php?msgSucesso=Produto cadastrado com sucesso");
}else{
    unlink("src/fotosProdutos/".$_FILES["userfile"]["name"]);
    header("Location: index.php?msgErro=Não foi possível cadastrar produto");
}
exit();