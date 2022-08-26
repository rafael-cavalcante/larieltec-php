<?php

if(!isset($_FILES['userfile']['name'])){
    header('Location: index.php');
    exit();
}

$uploaddir = 'src/fotosProdutos/';
$uploadfile = $uploaddir . basename($_FILES['userfile']['name']);

if (move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile)) {
    echo "Arquivo válido e enviado com sucesso.\n";
} else {
    header("Location: index.php?msgErro=Não foi possível realizar upload da Foto");
    exit();
}