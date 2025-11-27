// Variáveis
let empresas = [];
let produtos = [];
let editandoEmpresa = null;
let editandoProduto = null;

// Inicialização
document.addEventListener('DOMContentLoaded', () => {
    initNavigation();
    //carregarEmpresas();
    //  carregarProdutos();
    //initEventListeners();
    if(document.getElementById('mensagem').textContent != ""){
        mostrarAlerta(document.getElementById('mensagem').textContent, document.getElementById('tipo').textContent);
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


function editarProduto(old_codigo, old_nome, old_categoria, old_quantidade, old_minimo, old_preco) {
    document.getElementById("atualizar_produto").style.display = 'block';

    /*
    let novo_codigo = document.getElementById("novo_codigo").value;
    let novo_nome = document.getElementById("novo_nome").value;
    let novo_categoria = document.getElementById("novo_categoria").value;
    let novo_quantidade = document.getElementById("novo_quantidade").value;
    let novo_minimo = document.getElementById("novo_minimo").value;
    let novo_preco = document.getElementById("novo_preco").value;
    */

    document.getElementById("novo_codigo").value = old_codigo
    document.getElementById("novo_nome").value = old_nome
    document.getElementById("novo_categoria").value = old_categoria
    document.getElementById("novo_quantidade").value = old_quantidade
    document.getElementById("novo_minimo").value = old_minimo
    document.getElementById("novo_preco").value = old_preco
}

async function deletarProduto(id) {
    if (!confirm('Tem certeza que deseja deletar este produto?')) {
        return;
    }
}


// ========== UTILIDADES ==========

function mostrarAlerta(mensagem, tipo) {
    const alertContainer = document.getElementById('alertContainer');
    const alert = document.createElement('div');
    alert.className = `alert alert-${tipo == 'success' ? 'success' : 'error'}`;
    alert.innerHTML = `
        <span>${tipo == 'success' ? '✅' : '❌'}</span>
        <span>${mensagem}</span>
    `;
    alertContainer.appendChild(alert);
    console.log(tipo)
    setTimeout(() => {
        alert.remove();
    }, 5000);
}

function formatarData(dataString) {
    const data = new Date(dataString);
    return data.toLocaleDateString('pt-BR') + ' ' + data.toLocaleTimeString('pt-BR');
}