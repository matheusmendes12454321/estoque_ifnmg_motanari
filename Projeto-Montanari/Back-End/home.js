// Variáveis globais
let empresas = [];
let produtos = [];
let editandoEmpresa = null;
let editandoProduto = null;

// URL da API (ajuste conforme necessário)
const API_URL = 'php/';

// Inicialização
document.addEventListener('DOMContentLoaded', () => {
    //initNavigation();
    //carregarEmpresas();
    //  carregarProdutos();
    //initEventListeners();
    mostrarAlerta('aaa', 'error');
    if(document.getElementById('mensagem')){
        mostrarAlerta(document.getElementById('mensagem').textContent, 'error');
    }
});

// Navegação entre seções
function initNavigation() {
    const tabs = document.querySelectorAll('.nav-tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.section;
            switchSection(target);
        });
    });
}

function switchSection(sectionId) {
    document.querySelectorAll('.section').forEach(section => {
        section.classList.remove('active');
    });
    document.querySelectorAll('.nav-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    
    document.getElementById(sectionId).classList.add('active');
    document.querySelector(`[data-section="${sectionId}"]`).classList.add('active');
}

/*/ Event Listeners
function initEventListeners() {
    // Empresa
    document.getElementById('formEmpresa').addEventListener('submit', salvarEmpresa);
    document.getElementById('btnNovaEmpresa').addEventListener('click', () => {
        editandoEmpresa = null;
        document.getElementById('formEmpresa').reset();
        document.getElementById('empresaId').value = '';
    });
    
    // Produto
    document.getElementById('formProduto').addEventListener('submit', salvarProduto);
    document.getElementById('btnNovoProduto').addEventListener('click', () => {
        editandoProduto = null;
        document.getElementById('formProduto').reset();
        document.getElementById('produtoId').value = '';
    });
}
/*

function renderizarEmpresas() {
    const tbody = document.getElementById('listaEmpresas');
    tbody.innerHTML = '';
    
    empresas.forEach(empresa => {
        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td>${empresa.nome}</td>
            <td>${empresa.cnpj}</td>
            <td>${empresa.telefone || '-'}</td>
            <td>${empresa.email || '-'}</td>
            <td>${formatarData(empresa.data_cadastro)}</td>
            <td>
                <button class="btn btn-primary btn-small" onclick="editarEmpresa(${empresa.id})">
                    ✏️ Editar
                </button>
                <button class="btn btn-danger btn-small" onclick="deletarEmpresa(${empresa.id})">
                    🗑️ Deletar
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}
*/
async function salvarEmpresa(e) {
    e.preventDefault();
    
    const id = document.getElementById('empresaId').value;
    const dados = {
        id: id,
        nome: document.getElementById('nomeEmpresa').value,
        cnpj: document.getElementById('cnpjEmpresa').value,
        endereco: document.getElementById('enderecoEmpresa').value,
        telefone: document.getElementById('telefoneEmpresa').value,
        email: document.getElementById('emailEmpresa').value
    };
    
    try {
        const url = API_URL + 'empresa.php';
        const method = id ? 'PUT' : 'POST';
        
        const response = await fetch(url, {
            method: method,
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(dados)
        });
        
        const data = await response.json();
        
        if (data.success) {
            mostrarAlerta(data.message, 'success');
            document.getElementById('formEmpresa').reset();
            document.getElementById('empresaId').value = '';
            carregarEmpresas();
        } else {
            mostrarAlerta(data.message, 'error');
        }
    } catch (error) {
        console.error('Erro:', error);
        mostrarAlerta('Erro ao salvar empresa', 'error');
    }
}

function editarEmpresa(id) {
    const empresa = empresas.find(e => e.id == id);
    if (empresa) {
        document.getElementById('empresaId').value = empresa.id;
        document.getElementById('nomeEmpresa').value = empresa.nome;
        document.getElementById('cnpjEmpresa').value = empresa.cnpj;
        document.getElementById('enderecoEmpresa').value = empresa.endereco || '';
        document.getElementById('telefoneEmpresa').value = empresa.telefone || '';
        document.getElementById('emailEmpresa').value = empresa.email || '';
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

async function deletarEmpresa(id) {
    if (!confirm('Tem certeza que deseja deletar esta empresa? Todos os produtos relacionados também serão deletados.')) {
        return;
    }
    
    try {
        const response = await fetch(API_URL + 'empresa.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id })
        });
        
        const data = await response.json();
        
        if (data.success) {
            mostrarAlerta(data.message, 'success');
            carregarEmpresas();
            carregarProdutos();
        } else {
            mostrarAlerta(data.message, 'error');
        }
    } catch (error) {
        console.error('Erro:', error);
        mostrarAlerta('Erro ao deletar empresa', 'error');
    }
}

function atualizarSelectEmpresas() {
    const select = document.getElementById('empresaProduto');
    select.innerHTML = '<option value="">Selecione uma empresa</option>';
    
    empresas.forEach(empresa => {
        const option = document.createElement('option');
        option.value = empresa.id;
        option.textContent = empresa.nome;
        select.appendChild(option);
    });
}


function renderizarProdutos() {
    const tbody = document.getElementById('listaProdutos');
    tbody.innerHTML = '';
    
    produtos.forEach(produto => {
        const tr = document.createElement('tr');
        const statusEstoque = getStatusEstoque(produto);
        
        tr.innerHTML = `
            <td>${produto.codigo}</td>
            <td>${produto.nome}</td>
            <td>${produto.empresa_nome || '-'}</td>
            <td>${produto.categoria || '-'}</td>
            <td>${produto.quantidade}</td>
            <td>R$ ${parseFloat(produto.preco_venda).toFixed(2)}</td>
            <td><span class="badge ${statusEstoque.class}">${statusEstoque.texto}</span></td>
            <td>
                <button class="btn btn-primary btn-small" onclick="editarProduto(${produto.id})">
                    ✏️ Editar
                </button>
                <button class="btn btn-danger btn-small" onclick="deletarProduto(${produto.id})">
                    🗑️ Deletar
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    });
}

function getStatusEstoque(produto) {
    if (produto.quantidade === 0) {
        return { texto: 'Sem Estoque', class: 'badge-danger' };
    } else if (produto.quantidade <= produto.estoque_minimo) {
        return { texto: 'Estoque Baixo', class: 'badge-warning' };
    } else {
        return { texto: 'Em Estoque', class: 'badge-success' };
    }
}


function editarProduto(id) {
    const produto = produtos.find(p => p.id == id);
    if (produto) {
        document.getElementById('produtoId').value = produto.id;
        document.getElementById('empresaProduto').value = produto.empresa_id;
        document.getElementById('codigoProduto').value = produto.codigo;
        document.getElementById('nomeProduto').value = produto.nome;
        document.getElementById('descricaoProduto').value = produto.descricao || '';
        document.getElementById('quantidadeProduto').value = produto.quantidade;
        document.getElementById('precoCusto').value = produto.preco_custo;
        document.getElementById('precoVenda').value = produto.preco_venda;
        document.getElementById('estoqueMinimo').value = produto.estoque_minimo;
        document.getElementById('categoriaProduto').value = produto.categoria || '';
        
        switchSection('secao-produtos');
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
}

async function deletarProduto(id) {
    if (!confirm('Tem certeza que deseja deletar este produto?')) {
        return;
    }
    
    try {
        const response = await fetch(API_URL + 'produtos.php', {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id: id })
        });
        
        const data = await response.json();
        
        if (data.success) {
            mostrarAlerta(data.message, 'success');
            carregarProdutos();
        } else {
            mostrarAlerta(data.message, 'error');
        }
    } catch (error) {
        console.error('Erro:', error);
        mostrarAlerta('Erro ao deletar produto', 'error');
    }
}

// ========== ESTATÍSTICAS ==========

function atualizarEstatisticas() {
    const totalProdutos = produtos.length;
    const totalEmpresas = empresas.length;
    const produtosBaixoEstoque = produtos.filter(p => p.quantidade <= p.estoque_minimo && p.quantidade > 0).length;
    const produtosSemEstoque = produtos.filter(p => p.quantidade === 0).length;
    
    document.getElementById('statTotalProdutos').textContent = totalProdutos;
    document.getElementById('statTotalEmpresas').textContent = totalEmpresas;
    document.getElementById('statBaixoEstoque').textContent = produtosBaixoEstoque;
    document.getElementById('statSemEstoque').textContent = produtosSemEstoque;
}

// ========== UTILIDADES ==========

function mostrarAlerta(mensagem, tipo) {
    const alertContainer = document.getElementById('alertContainer');
    const alert = document.createElement('div');
    alert.className = `alert alert-${tipo === 'success' ? 'success' : 'error'}`;
    alert.innerHTML = `
        <span>${tipo === 'success' ? '✅' : '❌'}</span>
        <span>${mensagem}</span>
    `;
    
    alertContainer.appendChild(alert);
    
    setTimeout(() => {
        alert.remove();
    }, 5000);
}

function formatarData(dataString) {
    const data = new Date(dataString);
    return data.toLocaleDateString('pt-BR') + ' ' + data.toLocaleTimeString('pt-BR');
}