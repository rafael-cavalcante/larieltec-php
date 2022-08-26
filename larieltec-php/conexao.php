<?php

$bancoDados = 'sqlite:db/larieltec.db';

try {
    $conexao = new PDO($bancoDados);
} catch (PDOException $ex) {
    echo $ex->getMessage();
}