<?php

session_start();

include './conexao.php';

$usuario = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if (!isset($usuario['email']) || !isset($usuario['senha'])) {
    header('Location: index.php');
    exit();
}

$result = $conexao->query("SELECT nome, email FROM Usuario WHERE email = '{$usuario["email"]}' AND senha = '{$usuario["senha"]}';");

$rows = $result->fetchAll(PDO::FETCH_ASSOC);

if (sizeof($rows) == 1) {
    $_SESSION['usuarioLogado'] = $rows[0];
    header('Location: index.php?msgSucesso=Login efetuado com sucesso');
} else {
    header('Location: index.php?msgErro=E-mail ou senha inválidos');
}
exit();