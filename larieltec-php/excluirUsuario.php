<?php

session_start();

include './conexao.php';

$usuario = filter_input_array(INPUT_GET, FILTER_DEFAULT);

if (!isset($usuario['email']) || empty($_SESSION['usuarioLogado'])) {
    header('Location: index.php');
    exit();
}

$query = "DELETE FROM Usuario WHERE email='{$usuario["email"]}';";

if($conexao->exec($query)){
    if($_SESSION['usuarioLogado']['email'] == $usuario['email']){
        header("Location: logoutUsuario.php");
        exit();
    }
    header("Location: index.php?msgSucesso=Usuário removido com sucesso");
}else {
    header("Location: index.php?msgErro=Não foi possível remover usuário");
}
exit();