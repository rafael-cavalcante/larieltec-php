<?php

session_start();

include './conexao.php';

$produto = filter_input_array(INPUT_GET, FILTER_DEFAULT);

if (!isset($produto['nome']) || !isset($produto['foto']) || empty($_SESSION['usuarioLogado'])) {
    header('Location: index.php');
    exit();
}

$query = "DELETE FROM Produto WHERE nome ='{$produto["nome"]}';";

unlink($produto['foto']);

if($conexao->exec($query)){
    header("Location: index.php?msgSucesso=Produto removido com sucesso");
}else {
    header("Location: index.php?msgErro=Não foi possível remover produto");
}
exit();