// Inicialização
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
function toggleForms() {
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
function mostrarAlerta(mensagem, tipo) {
    const alertContainer = document.getElementById('alertContainer');
    const alert = document.createElement('div');
    
    //const icon = tipo === 'success' ? '✅' : '❌';
    
    //alert.className = `alert alert-${tipo}`;
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


// Handle Login
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
    
    if (lembrarMe) {
        localStorage.setItem('userData', JSON.stringify(userData));
    } else {
        sessionStorage.setItem('userData', JSON.stringify(userData));
    }
}

// Handle Cadastro
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

// Verificar se já está logado
function verificarSessao() {
    const userDataLocal = localStorage.getItem('userData');
    const userDataSession = sessionStorage.getItem('userData');
    
    if (userDataLocal || userDataSession) {
        // Usuário já está logado, redirecionar
        // window.location.href = 'index.html';
    }
}

// Função auxiliar para simular requisição
function simularRequisicao(tempo) {
    return new Promise(resolve => setTimeout(resolve, tempo));
}

// Máscaras de input
document.addEventListener('DOMContentLoaded', () => {
    // Máscara de telefone
    const telefoneInputs = document.querySelectorAll('input[type="tel"]');
    telefoneInputs.forEach(input => {
        input.addEventListener('input', (e) => {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length <= 11) {
                value = value.replace(/^(\d{2})(\d{5})(\d{4}).*/, '($1) $2-$3');
            }
            e.target.value = value;
        });
    });
});

// Animação de loading no botão
function adicionarLoadingButton(button) {
    const originalText = button.innerHTML;
    button.innerHTML = '<span>Processando...</span>';
    button.disabled = true;
    
    return () => {
        button.innerHTML = originalText;
        button.disabled = false;
    };
}

// Adicionar animação nos formulários
document.querySelectorAll('.form-group input').forEach(input => {
    input.addEventListener('focus', () => {
        input.parentElement.style.transform = 'scale(1.01)';
    });
    
    input.addEventListener('blur', () => {
        input.parentElement.style.transform = 'scale(1)';
    });
});