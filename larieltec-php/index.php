<?php

session_start();

$gets = filter_input_array(INPUT_GET, FILTER_DEFAULT);

include './conexao.php';

?>

<!DOCTYPE html>

<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>LarielTec</title>
        <link rel="icon" href="src/icon.png" type="image/png" sizes="16x16">
        <link rel="stylesheet" href="css/estilo.css">
        <script type="text/javascript" src="js/script.js"></script>
    </head>
    <?php if (isset($gets['nome']) && !empty($_SESSION['usuarioLogado'])) { ?>
    <body onload="exibirAlterarProduto()">
    <?php } else if (isset($gets['email']) && !empty($_SESSION['usuarioLogado'])) { ?>
    <body onload="exibirAlterarUsuario()">
    <?php } else { ?>
    <body>
    <?php } ?>
        <header>
            <?php if (isset($gets['msgErro'])) { ?>
            <p class='msgErro'><?= $gets['msgErro']; ?><img src="src/alerta.png" width="15" height="15"></p>
            <?php } else if (isset($gets['msgSucesso'])) { ?>
            <p class='msgSucesso'><?= $gets['msgSucesso']; ?><img src="src/ok.png" width="15" height="15"></p>
            <?php } ?>
            <nav>
                <ul>
                    <li><a class="active" href="index.php"><div><img src="src/home.png"></div> HOME</a></li>
                    <?php if (!empty($_SESSION['usuarioLogado'])) { ?>
                    <li><a onclick="document.getElementById('id01').style.display = 'block'"><div><img src="src/usuario.png"></div> REGISTRAR-USUÁRIO</a></li>
                    <li><a onclick="document.getElementById('id04').style.display = 'block'"><div><img src="src/editar.png"></div> Alterar-Usuário</a></li>
                    <li><a onclick="document.getElementById('id03').style.display = 'block'"><div><img src="src/produto.png"></div> Registrar-Produto</a></li>
                    <li><a href="logoutUsuario.php"><div><img src="src/logout.png"></div> Logout <?= $_SESSION['usuarioLogado']['nome']; ?></a></li>
                    <?php } else { ?>
                    <li><a onclick="document.getElementById('id01').style.display = 'block'"><div><img src="src/usuario.png"></div> REGISTRAR-SE</a></li>
                    <li><a onclick="document.getElementById('id02').style.display = 'block'"><div><img src="src/login.png"></div> Login</a></li>
                    <?php } ?>
                </ul>
            </nav>
            <figure>
                <img src="src/papelDeParede.jpg" alt="Papel de Parede">
                <figcaption>LarielTec</figcaption>
            </figure>
        </header>
        <main>
            <section id="listProdutos">
                <ul>
                    <?php 
                    $result = $conexao->query("SELECT nome, valor, quantidade, emailUsuario, foto FROM Produto;");
                        
                    $produtos = $result->fetchAll(PDO::FETCH_ASSOC);
                    
                    foreach ($produtos as $produto) { 
                    ?>
                    <li>
                        <?php if (!empty($_SESSION['usuarioLogado'])) { ?>
                        <a href="index.php?nome=<?= $produto['nome']; ?>&foto=<?= $produto['foto']; ?>"><img src="src/editar.png" width="30" height="30"></a>
                        <a onclick="exibirConfirmacaoExcluirProduto('<?= $produto['nome']; ?>','<?= $produto['foto']; ?>')"><img src="src/excluir.png" width="30" height="30"></a>
                        <?php } ?>
                        <h2><?= $produto['nome']; ?></h2>
                        <img src="<?= $produto['foto']; ?>" width="200" height="200">
                        <h3><?= $produto['valor']; ?>$</h3>
                        <h3><?= $produto['quantidade']; ?> unidades</h3>
                        <h3><?= $produto['emailUsuario']; ?></h3>
                    </li>
                    <?php } ?>
                </ul>
            </section>
            <section id="id01" class="modal">
                <form class="modal-content animate" action="registrarUsuario.php" method="post">
                    <div class="imgcontainer">
                        <span onclick="document.getElementById('id01').style.display = 'none'" class="close" title="Fechar">&times;</span>
                    </div>
                    <h1>Realizar Registro</h1>
                    <div class="container">
                        <label for="nome"><b>Nome</b></label>
                        <input type="text" placeholder="Seu nome" name="nome" required>

                        <label for="email"><b>E-mail</b></label>
                        <input type="email" placeholder="Seu e-mail" name="email" required>

                        <label for="senha"><b>Password</b></label>
                        <input type="password" placeholder="Sua senha" name="senha" required>

                        <button type="submit">Registrar</button>
                    </div>
                </form>    
            </section>
            <section id="id02" class="modal">
                <form class="modal-content animate" action="loginUsuario.php" method="post">
                    <div class="imgcontainer">
                        <span onclick="document.getElementById('id02').style.display = 'none'" class="close" title="Fechar">&times;</span>
                    </div>
                    <h1>Realizar Login</h1>
                    <div class="container">
                        <label for="email"><b>E-mail</b></label>
                        <input type="email" placeholder="Seu e-mail" name="email" required>

                        <label for="senha"><b>Password</b></label>
                        <input type="password" placeholder="Sua senha" name="senha" required>

                        <button type="submit">Login</button>
                    </div>
                </form>
            </section>
            <section id="id03" class="modal"> 
                <form class="modal-content animate" action="registrarProduto.php" enctype="multipart/form-data" method="post">
                    <div class="imgcontainer">
                        <span onclick="document.getElementById('id03').style.display = 'none'" class="close" title="Fechar">&times;</span>
                    </div>
                    <h1>Registrar Produto</h1>
                    <div class="container">
                        <label for="nome"><b>Nome</b></label>
                        <input type="text" placeholder="Nome produto" name="nome" required>

                        <label for="valor"><b>Valor</b></label>
                        <input type="number" placeholder="Valor produto" name="valor" min="1"required>

                        <label for="quantidade"><b>Quantidade</b></label>
                        <input type="number" placeholder="Quantidade produto" name="quantidade" min="1" required>

                        <label for="foto"><b>Foto</b></label>
                        <input type="file" placeholder="Foto produto" name="userfile" accept=".jpg, .png, .jpeg" required>

                        <button type="submit">Registrar</button>
                    </div>
                </form>
            </section>
            <section id="id04" class="modal"> 
                <div id="listAlterarUsuarios">
                    <ul>
                        <?php 
                        $result2 = $conexao->query("SELECT nome, email, senha FROM Usuario;");

                        $usuarios = $result2->fetchAll(PDO::FETCH_ASSOC);
                    
                        foreach ($usuarios as $usuario) { 
                        ?>
                        <li>
                            <a href="index.php?email=<?= $usuario['email']; ?>"><img src="src/editar.png" width="30" height="30"></a>
                            <a onclick="exibirConfirmacaoExcluirUsuario('<?= $usuario['email']; ?>')"><img src="src/excluir.png" width="30" height="30"></a>
                            <h2><?= $usuario['nome']; ?></h2>
                            <h3><?= $usuario['email']; ?></h3>
                            <h3><?= $usuario['senha']; ?></h3>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                
                <form class="modal-content animate" action="alterarUsuario.php" method="post">
                    <div class="imgcontainer">
                        <span onclick="document.getElementById('id04').style.display = 'none'" class="close" title="Fechar">&times;</span>
                    </div>
                    <h1>Alterar Usuário</h1>
                    <div class="container">
                        <label for="nome"><b>Nome</b></label>
                        <input type="text" placeholder="Seu nome" name="nome" required>

                        <label for="email"><b>E-mail</b></label>
                        <?php if (isset($gets['email'])) { ?>
                            <input type="email" placeholder="Seu e-mail" name="email" value="<?= $gets['email']; ?>" readonly>
                        <?php } else { ?>
                            <input type="email" placeholder="Seu e-mail" name="email" readonly>
                        <?php } ?>

                        <label for="senha"><b>Password</b></label>
                        <input type="password" placeholder="Sua senha" name="senha" required>

                        <button type="submit">Alterar</button>
                    </div>
                </form> 
            </section>
            <section id="id05" class="modal">
                <form class="modal-content animate" action="alterarProduto.php" enctype="multipart/form-data" method="post">
                    <div class="imgcontainer">
                        <span onclick="document.getElementById('id05').style.display = 'none'" class="close" title="Fechar">&times;</span>
                    </div>
                    <h1>Alterar Produto</h1>
                    <div class="container">
                        <label for="nome"><b>Nome</b></label>
                        <?php if (isset($gets['nome'])) { ?>
                            <input type="text" name="nome" value="<?= $gets['nome']; ?>" readonly="">
                        <?php } ?>

                        <label for="valor"><b>Valor</b></label>
                        <input type="number" placeholder="Valor produto" name="valor" min="1"required>

                        <label for="quantidade"><b>Quantidade</b></label>
                        <input type="number" placeholder="Quantidade produto" name="quantidade" min="1" required>

                        <label for="foto"><b>Foto</b></label>
                        <input type="file" placeholder="Foto produto" name="userfile" accept=".jpg, .png, .jpeg" required>
                        
                        <label for="fotoAntiga"><b>Foto Antiga</b></label>
                        <?php if (isset($gets['foto'])) { ?>
                            <input type="text" name="fotoAntiga" value="<?= $gets['foto']; ?>" readonly="">
                        <?php } ?>

                        <button type="submit">Alterar</button>
                    </div>
                </form> 
            </section>
        </main>
        <footer>
            <p>Desenvolvido por Isabel Campêlo, Lívia Cristina e Rafael Cavalcante</p>
            <p>Todos os direitos reservados © aos desenvolvedores</p>
        </footer>
    </body>
</html>