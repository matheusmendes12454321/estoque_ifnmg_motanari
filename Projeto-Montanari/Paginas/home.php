<?php
include "../Back-End/conexao.php";
session_start();

if (isset($_POST["sair"])) {
    $_SESSION["id"] = "";
    header("Location: ../Paginas/entrada.php?mensagem='Sessão Encerrada'");
    mysqli_close($conexao);
    exit;
}

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

$informacoes = mysqli_fetch_assoc($busca);
$nome_empresa = $informacoes["nome"];

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Flow</title>
    <link rel="stylesheet" href="/Projeto-Montanari/Css/home.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>📦 Stock Flow</h1>
            <form action="" method="POST">
                <input type="submit" name="sair" class="btn-logout" value="sair">
            </form>
        </div>
    </header>

    <div id="alertContainer" style="position: fixed; top: 20px; right: 20px; z-index: 1000; max-width: 400px;"></div>

    <div class="container">
        <!-- Navegação -->
        <nav>
            <div class="nav-tabs">
                <button class="nav-tab active" data-section="secao-dashboard">📊 Dashboard</button>
                <button class="nav-tab" data-section="secao-produtos">📦 Produtos</button>
            </div>
        </nav>

        <!-- Dashboard -->
        <section id="secao-dashboard" class="section active">
            <div class="stats-grid">
                <div class="stat-card">
                    <h3>Total de Produtos</h3>
                    <div class="stat-value" id="statTotalProdutos">0</div>
                </div>
                <div class="stat-card" style="border-left-color: var(--warning);">
                    <h3>Estoque Baixo</h3>
                    <div class="stat-value" id="statBaixoEstoque" style="color: var(--warning);">0</div>
                </div>
                <div class="stat-card" style="border-left-color: var(--danger);">
                    <h3>Sem Estoque</h3>
                    <div class="stat-value" id="statSemEstoque" style="color: var(--danger);">0</div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2>📋 Visão Geral</h2>
                </div>
                <p style="color: var(--text-light); line-height: 1.6;">
                    Bem-vindo ao Sistema de Gestão de Estoque! Aqui você pode gerenciar suas empresas e produtos de forma eficiente. 
                    Use a navegação acima para acessar as diferentes seções do sistema.
                </p>
            </div>
        </section>

            <div class="card">
                <div class="card-header">
                    <h2>📋 Lista de Empresas</h2>
                </div>
                
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Nome</th>
                                <th>CNPJ</th>
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
        </section>

        <!-- Produtos -->
        <section id="secao-produtos" class="section">
            <div class="card">
                <div class="card-header">
                    <h2>📦 Cadastro de Produto</h2>
                    <button class="btn btn-primary" id="btnNovoProduto">+ Novo Produto</button>
                </div>
                
                <form id="formProduto">
                    <input type="hidden" id="produtoId">
                    
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="empresaProduto">Empresa *</label>
                            <select id="empresaProduto" required>
                                <option value="">Selecione uma empresa</option>
                            </select>
                        </div>
                        
                        <div class="form-group">
                            <label for="codigoProduto">Código *</label>
                            <input type="text" id="codigoProduto" required placeholder="Ex: PROD001">
                        </div>
                        
                        <div class="form-group">
                            <label for="nomeProduto">Nome do Produto *</label>
                            <input type="text" id="nomeProduto" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="categoriaProduto">Categoria</label>
                            <input type="text" id="categoriaProduto" placeholder="Ex: Eletrônicos">
                        </div>
                        
                        <div class="form-group">
                            <label for="quantidadeProduto">Quantidade *</label>
                            <input type="number" id="quantidadeProduto" required min="0" value="0">
                        </div>
                        
                        <div class="form-group">
                            <label for="estoqueMinimo">Estoque Mínimo *</label>
                            <input type="number" id="estoqueMinimo" required min="0" value="0">
                        </div>
                        
                        <div class="form-group">
                            <label for="precoCusto">Preço de Custo</label>
                            <input type="number" id="precoCusto" step="0.01" min="0" value="0" placeholder="0.00">
                        </div>
                        
                        <div class="form-group">
                            <label for="precoVenda">Preço de Venda *</label>
                            <input type="number" id="precoVenda" step="0.01" min="0" required value="0" placeholder="0.00">
                        </div>
                        
                        <div class="form-group" style="grid-column: 1 / -1;">
                            <label for="descricaoProduto">Descrição</label>
                            <textarea id="descricaoProduto" placeholder="Descrição detalhada do produto"></textarea>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-success">💾 Salvar Produto</button>
                </form>
            </div>

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
                                <th>Empresa</th>
                                <th>Categoria</th>
                                <th>Quantidade</th>
                                <th>Preço Venda</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody id="listaProdutos">
                            <tr>
                                <td colspan="8" style="text-align: center; padding: 40px;">
                                    Nenhum produto cadastrado
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <script src="/Projeto-Montanari/Back-End/home.js"></script>
</body>
</html>