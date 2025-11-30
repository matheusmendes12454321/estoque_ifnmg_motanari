<?php
// Configurações Iniciais
include "../Back-End/conexao.php";
session_start();

if (isset($_POST["sair"])) {
    $_SESSION["id"] = "";
    header("Location: ../Paginas/entrada.php?mensagem='Sessão Encerrada'");
    mysqli_close($conexao);
    exit;
}
// Busca por Usuario
if(!isset($_SESSION["id"]) || $_SESSION["id"] == "") {
    header("Location: ../Paginas/entrada.php?mensagem='Usuário Não Encontrado'");
    mysqli_close($conexao);
    exit;
}

$id = $_SESSION["id"];
$busca = mysqli_query($conexao, "SELECT * FROM usuarios WHERE id = '$id'");

if(mysqli_num_rows($busca) == 0) {
    header("Location: ../Paginas/entrada.php?mensagem='Usuário Não Encontrado'");
    mysqli_close($conexao);
    exit;
}       

// Buscar Produtos e Informações
$busca_produtos = mysqli_query($conexao, "SELECT * FROM produtos WHERE usuario_id = '$id'");

$baixo_estoque = mysqli_query($conexao, "SELECT COUNT(*) FROM produtos WHERE quantidade < estoque_minimo AND quantidade != 0");
$sem_estoque = mysqli_query($conexao, "SELECT COUNT(*) FROM produtos WHERE quantidade = 0 ");

$informacoes = mysqli_fetch_assoc($busca);
$nome_empresa = $informacoes["nome"];

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Flow</title>
    <link rel="stylesheet" href="../Css/teste.css">
</head>
<body>
<?php
// Sistema de Mensagem
$mensagem = $_GET["mensagem"] ?? "";
$tipo = $_GET["tipo"] ?? "error";
echo "<p hidden id='mensagem'>$mensagem</p>";
echo "<p hidden id='tipo'>$tipo</p>";
?>

    <header>
        <!-- Cabeçario -->
        <div class="container">
            <h1>📦 Stock Flow</h1>
            <form action="" method="POST">
                <input type="submit" name="sair" class="btn-logout" value="sair">
            </form>
        </div>
    </header>

    <!-- Alertas -->
    <div id="alertContainer" style="position: fixed; top: 20px; right: 20px; z-index: 1000; max-width: 400px;"></div>

    <div class="container">
        <!-- Navegação -->
        <nav>
            <div class="nav-tabs">
                <button class="nav-tab active" data-section="secao-dashboard">📊 Dashboard</button>
                <button class="nav-tab" data-section="secao-produtos">📦 Produtos</button>
                <button class="nav-tab" data-section="secao-compra-venda">💰 Compra e Venda</button>
            </div>
        </nav>

        <!-- Dashboard -->
        <section id="secao-dashboard" class="section active">
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total de Produtos</h3>
                    <div class="stat-value" id="statTotalProdutos">
                        <?php
                        // Buscar total de produtos
                        echo mysqli_num_rows($busca_produtos);
                        ?>
                    </div>
                </div>
                <div class="stat-card" style="border-left-color: var(--warning);">
                    <h3>Estoque Baixo</h3>
                    <div class="stat-value" id="statBaixoEstoque" style="color: var(--warning);">
                        <?php
                        // Buscar produtos com pouco estoque
                        echo mysqli_fetch_row($baixo_estoque)[0];
                        ?>
                    </div>
                </div>
                <div class="stat-card" style="border-left-color: var(--danger);">
                    <h3>Sem Estoque</h3>
                    <div class="stat-value" id="statSemEstoque" style="color: var(--danger);">
                    <?php
                        // Buscar produtos sem estoque
                        echo mysqli_fetch_row($sem_estoque)[0];
                        ?>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2>📋 Visão Geral</h2>
                </div>

                <!-- Informações do usuario -->
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Nome</th>
                                <th>E-mail</th>
                                <th>Data Cadastro</th>
                                <th>Lucro</th>
                            </tr>
                        </thead>
                        <tbody id="listaEmpresas">
                            <tr>
                                <?php
                                echo "<td>" . $informacoes['id'] . "</td>";
                                echo "<td>" . $informacoes['nome'] . "</td>";
                                echo "<td>" . $informacoes['email'] . "</td>";
                                echo "<td>" . $informacoes['data_cadastro'] . "</td>";
                                ?>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- 
            <div class="card">
                <div class="card-header">
                    <h2>📋 Movimentações</h2>
                </div>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Ação</th>
                                <th>Telefone</th>
                                <th>E-mail</th>
                                <th>Data Cadastro</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="listaEmpresas">
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px;">
                                    Nenhuma empresa cadastrada
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section> -->

        <!-- Editar Produto -->
        <section id="secao-produtos" class="section">
            <div class="card" id="atualizar_produto">
                <div class="card-header">
                    <h2>✏️ Editar Produto</h2>
                </div>
                
                <form id="formProduto" method="post" action="../Back-End/editar.php">
                    
                    <div class="form-grid">
                        <input type="text" name="old_codigo" id="old_codigo" hidden>
                        
                        <div class="form-group">
                            <label for="novo_codigo">Novo Código *</label>
                            <input type="text" id="novo_codigo" placeholder="Ex: Novo Código" required name="codigo">
                        </div>
                        
                        <div class="form-group">
                            <label for="novo_nome">Nome do Produto *</label>
                            <input type="text" id="novo_nome" required name="nome_produto">
                        </div>
                        
                        <div class="form-group">
                            <label for="novo_categoria">Nova Categoria</label>
                            <input type="text" id="novo_categoria" placeholder="Nova Categoria" required name="categoria">
                        </div>
                        
                        <div class="form-group">
                            <label for="novo_quantidade">Nova Quantidade *</label>
                            <input type="number" id="novo_quantidade" min="0" placeholder="Nova Quantidade" required name="quantidade">
                        </div>
                        
                        <div class="form-group">
                            <label for="novo_minimo">Estoque Mínimo *</label>
                            <input type="number" id="novo_minimo" min="0" placeholder="Novo Estoque Minimo" required name="estoque_minimo">
                        </div>

                        <div class="form-group">
                            <label for="novo_preco">Preço</label>
                            <input type="number" id="novo_preco" step="0.01" min="0" placeholder="Novo preco" required name="preco" >
                        </div>

                    </div>
                    <button type="submit" class="btn btn-success">💾 Salvar Produto</button>
                    <button type="button" class="btn btn-danger" onclick="document.getElementById('atualizar_produto').style.display = 'none'">Cancelar</button>
                </form>
            </div>

            <!-- Listar Produtos -->
            <div class="card">
                <div class="card-header">
                    <h2>📋 Lista de Produtos</h2>
                </div>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Código</th>
                                <th>Nome</th>
                                <th>Categoria</th>
                                <th>Quantidade Minima</th>
                                <th>Quantidade</th>
                                <th>Preço</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="listaProdutos">
                            <?php
                                // Verifica se tem produtos
                                if(mysqli_num_rows($busca_produtos) > 0){
                                    $n = 0;
                                    //Percorre os produtos
                                    while($produtos = mysqli_fetch_assoc($busca_produtos)){
                                        // Pega os dados do produto
                                        $codigo = $produtos["codigo"];
                                        $nome = $produtos["nome"];
                                        $categoria = $produtos["categoria"];
                                        $quantidade_min = $produtos['estoque_minimo'];
                                        $quantidade = $produtos['quantidade'];
                                        $preco = $produtos["preco"];
                                        $status;
                                        $cor;
                                        if($quantidade == 0){
                                            $status = "SEM ESTOQUE";
                                            $cor = "#ff0000ff";
                                        }
                                        elseif($quantidade < $quantidade_min){
                                            $status = "ESTOQUE BAIXO";
                                            $cor = "#f39c12"; 
                                        }
                                        else{
                                            $status = "EM ESTOQUE";
                                            $cor = "#2ecc71"; 
                                        }

                                        // Coloca na tabela
                                        echo "<tr>";
                                        echo "<td> $codigo</td>";
                                        echo "<td> $nome</td>";
                                        echo "<td> $categoria</td>";
                                        echo "<td> $quantidade_min</td>";
                                        echo "<td> $quantidade</td>";
                                        echo "<td> $preco</td>";
                                        echo "<td style='color: $cor'> $status</td>";
                                        echo "<td>";
                                        echo "<p id='$n' hidden>$codigo-$nome-$categoria-$quantidade_min-$quantidade-$preco</p>";
                                        echo "<button style='width: 90px' class='btn btn-primary btn-small' onclick='editarProduto($n)'>✏️ Editar </button>";
                                        echo "<form method='post' action='../Back-End/deletar.php'>
                                        <input type='text' hidden name='codigo' value='$codigo'>
                                        <button style='width: 90px' class='btn btn-danger btn-small' onclick='deletarProduto()'>🗑️ Deletar</button>
                                        </form></td>";
                                        echo "</tr>";
                                        $n++;
                                    }
                                }
                                else{
                                    echo "<tr>
                                            <td colspan='7' style='text-align: center; padding: 40px;'>
                                                Nenhum produto cadastrado
                                            </td>
                                        </tr>";
                                }
                            ?>

                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Cadastrar Produto -->
            <div class="card">
                <div class="card-header">
                    <h2>📦 Cadastro de Produto</h2>
                    <button class="btn btn-primary" id="btnNovoProduto">+ Novo Produto</button>
                </div>
                
                <form id="formProduto" method="post" action="../Back-End/cadastro_produto.php">
                    <input type="hidden" id="produtoId">
                    
                    <div class="form-grid">
                        
                        <div class="form-group">
                            <label for="codigoProduto">Código *</label>
                            <input type="text" id="codigoProduto" required placeholder="Ex: PROD001" name="codigo">
                        </div>
                        
                        <div class="form-group">
                            <label for="nomeProduto">Nome do Produto *</label>
                            <input type="text" id="nomeProduto" required name="nome_produto">
                        </div>
                        
                        <div class="form-group">
                            <label for="categoriaProduto">Categoria</label>
                            <input type="text" id="categoriaProduto" placeholder="Ex: Eletrônicos" name="categoria">
                        </div>
                        
                        <div class="form-group">
                            <label for="quantidadeProduto">Quantidade *</label>
                            <input type="number" id="quantidadeProduto" required min="0" name="quantidade">
                        </div>
                        
                        <div class="form-group">
                            <label for="estoqueMinimo">Estoque Mínimo *</label>
                            <input type="number" id="estoqueMinimo" required min="0" name="estoque_minimo">
                        </div>

                        <div class="form-group">
                            <label for="precoCusto">Preço</label>
                            <input type="number" id="precoCusto" step="0.01" min="0" placeholder="0.00" name="preco">
                        </div>

                    </div>
                    
                    <button type="submit" class="btn btn-success">💾 Salvar Produto</button>
                </form>
            </div>

        </section>

        <!-- Comprar ou Vender Produto -->
        <section id="secao-compra-venda" class="section">
            <div class="card" id="comprar_vender">
                <div class="card-header">
                    <h2>💰 Compra e Venda</h2>
                </div>
                <form id="formCompra-Venda" method="post" action="../Back-End/comprar_vender.php">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="codigoProduto">Código</label>
                            <input type="text" id="codigoProduto" required placeholder="Ex: PROD001" name="codigo">
                        </div>

                         <div class="form-group">
                            <label for="quantidadeProduto">Quantidade</label>
                            <input type="number" id="quantidadeProduto" required min="0" name="quantidade">
                        </div>
                    </div>
                    <input type="submit" class="btn btn-success" name="comprar" value="💲 COMPRAR">
                    <input type="submit" class="btn btn-danger" name="vender" value="💸 VENDER">
                </form>
            </div>
        </section>
    </div>

    <script src="../Back-End/home.js"></script>
</body>
</html>