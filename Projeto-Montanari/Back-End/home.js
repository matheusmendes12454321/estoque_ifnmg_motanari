// Variáveis
let empresas = [];
let produtos = [];
let editandoEmpresa = null;
let editandoProduto = null;

// Espera a pagina carregar
document.addEventListener('DOMContentLoaded', () => {
    navegacao();
    if(document.getElementById('mensagem').textContent != ""){
        mostrarAlerta(document.getElementById('mensagem').textContent, document.getElementById('tipo').textContent);
    }
});

// Navegação entre seções
function navegacao() {
    const tabs = document.querySelectorAll('.nav-tab');
    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.section;
            mudar_secao(target);
        });
    });
}

function mudar_secao(sectionId) {
    document.querySelectorAll('.section').forEach(section => {
        section.classList.remove('active');
    });
    document.querySelectorAll('.nav-tab').forEach(tab => {
        tab.classList.remove('active');
    });
    
    document.getElementById(sectionId).classList.add('active');
    document.querySelector(`[data-section="${sectionId}"]`).classList.add('active');
}


function editarProduto(id) {
    document.getElementById("atualizar_produto").style.display = 'block';
    let a = String(id)
    console.log(a)
    let dados = String(document.getElementById(`${id}`).textContent)
    let frase = dados.split('-')

    document.getElementById("old_codigo").value = frase[0];
    document.getElementById("novo_codigo").value = frase[0];
    document.getElementById("novo_nome").value = frase[1];
    document.getElementById("novo_categoria").value = frase[2];
    document.getElementById("novo_quantidade").value = frase[3];
    document.getElementById("novo_minimo").value = frase[4];
    document.getElementById("novo_preco").value = frase[5];
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
        window.location.href = 'home.php';
    }, 5000);
}
