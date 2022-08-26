<?php

include './conexao.php';

$usuario = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!isset($usuario['nome']) || !isset($usuario['email']) || !isset($usuario['senha'])) {
    header('Location: index.php');
    exit();
} else if (empty($usuario['email'])) {
    header("Location: index.php?msgErro=Selecione um usuário primeiro");
    exit();
} else if (strlen($usuario['senha']) < 6) {
    header("Location: index.php?msgErro=Senha muito curta");
    exit();
}

$query = "UPDATE Usuario set nome='{$usuario['nome']}', senha='{$usuario['senha']}' WHERE email='{$usuario['email']}';";

if ($conexao->exec($query)) {
    if($_SESSION['usuarioLogado']['email'] == $usuario['email']){
        $_SESSION['usuarioLogado']['nome'] = $usuario['nome'];
        $_SESSION['usuarioLogado']['senha'] = $usuario['senha'];
    }
    header("Location: index.php?msgSucesso=Usuário alterado com sucesso");
} else {
    header("Location: index.php?msgErro=Não foi possível alterar usuário");
}
exit();