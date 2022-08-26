<?php

include './conexao.php';

$usuario = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!isset($usuario['nome']) || !isset($usuario['email']) || !isset($usuario['senha'])) {
    header("Location: index.php");
    exit();
} else if (strlen($usuario['senha']) < 6) {
    header("Location: index.php?msgErro=Senha muito curta");
    exit();
}

$query = "INSERT INTO Usuario (nome, email, senha) VALUES ('{$usuario["nome"]}', '{$usuario["email"]}', '{$usuario["senha"]}');";

if($conexao->exec($query) ){
    header("Location: index.php?msgSucesso=Usuário cadastrado com sucesso");
}else{
    header("Location: index.php?msgErro=Não foi possível realizar registro");
}
exit();