
function exibirAlterarUsuario() {
    document.getElementById('id04').style.display = 'block';
}

function exibirAlterarProduto() {
    document.getElementById('id05').style.display = 'block';
}

function exibirConfirmacaoExcluirProduto(nome, foto) {
    var resposta = confirm("Tem certeza que deseja excluir esse produto? "+nome);
    if (resposta) {
        location.href = "excluirProduto.php?nome="+nome+"&foto="+foto;
    }
}

function exibirConfirmacaoExcluirUsuario(email) {
    var resposta = confirm("Tem certeza que deseja excluir esse Usuario? "+email);
    if (resposta) {
        location.href = "excluirUsuario.php?email="+email;
    } 
}