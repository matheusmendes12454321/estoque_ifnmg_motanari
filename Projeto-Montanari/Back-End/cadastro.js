// Espera a pagina carregar
document.addEventListener('DOMContentLoaded', () => {
    iniciar();
    verificarSessao();
    if(document.getElementById("msg") != null){
        mostrarAlerta(document.getElementById("msg").textContent,"error")
    }
});

// Coloca os event listener
function iniciar() {
    // Login
    document.getElementById('formLogin').addEventListener('submit', login);
    
    // Cadastro
    document.getElementById('formCadastro').addEventListener('submit', cadastro);
    
    // Validação de senha 
    const senha = document.getElementById('cadastroSenha');
    const confirmar_senha = document.getElementById('cadastroConfirmarSenha');
    
    confirmar_senha.addEventListener('input', () => {
        if (confirmar_senha.value !== senha.value) {
            confirmar_senha.setCustomValidity('As senhas não coincidem');
        } else {
            confirmar_senha.setCustomValidity('');
        }
    });
}

// Alternar
function alternar() {
    const loginForm = document.getElementById('loginForm');
    const cadastroForm = document.getElementById('cadastroForm');
    
    if (loginForm.classList.contains('active')) {
        loginForm.classList.remove('active');
        cadastroForm.classList.add('active');
    } else {
        cadastroForm.classList.remove('active');
        loginForm.classList.add('active');
    }
}


// Mostrar alertas
function mostrarAlerta(mensagem) {
    const alertContainer = document.getElementById('alertContainer');
    const alert = document.createElement('div');

    alert.className = `alert alert-error`;
    alert.innerHTML = `
        <span class="alert-icon">❌</span>
        <span>${mensagem}</span>
    `;
    
    alertContainer.appendChild(alert);
    
    // Remover após 5 segundos
    setTimeout(() => {
        alert.style.animation = 'slideOutRight 0.4s ease';
        setTimeout(() => alert.remove(), 400);
    }, 5000);
}


// Verificar Login
async function login(e) {
    
    const email = document.getElementById('loginEmail').value;
    const senha = document.getElementById('loginSenha').value;
    const lembrarMe = document.getElementById('lembrarMe').checked;
    
    // Validação básica
    if (!email || !senha) {
        mostrarAlerta('Por favor, preencha todos os campos', 'error');
        e.preventDefault();
        return;
    }

}

// Verificar Cadastro
async function cadastro(e) {
    const nome = document.getElementById('cadastroNome').value;
    const email = document.getElementById('cadastroEmail').value;
    const senha = document.getElementById('cadastroSenha').value;
    const confirmarSenha = document.getElementById('cadastroConfirmarSenha').value;
    const aceitarTermos = document.getElementById('aceitarTermos').checked;
    
    // Validações
    if (!nome || !email || !senha || !confirmarSenha) {
        mostrarAlerta('Por favor, preencha todos os campos obrigatórios', 'error');
        e.preventDefault();
        return;
    }
    
    if (senha !== confirmarSenha) {
        mostrarAlerta('As senhas não coincidem', 'error');
        e.preventDefault();
        return;
    }
    
    if (senha.length < 6) {
        mostrarAlerta('A senha deve ter no mínimo 6 caracteres', 'error');
        e.preventDefault();
        return;
    }
    
    if (!aceitarTermos) {
        mostrarAlerta('Você deve aceitar os termos de uso', 'error');
        e.preventDefault();
        return;
    }
    
}


