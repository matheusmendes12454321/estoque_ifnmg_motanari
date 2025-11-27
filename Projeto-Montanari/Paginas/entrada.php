<?php
if(isset($_GET["mensagem"])){
    $mensagem = $_GET["mensagem"];
    echo "<p hidden id='msg'>$mensagem</p>";
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistema de Estoque</title>
    <link rel="stylesheet" href="../Css/cadastro.css">
</head>
<body>
    <div class="auth-container">
        <div class="auth-card">
            <div class="auth-header">
                <div class="logo">📦</div>
                <h1>Sistema de Estoque</h1>
                <p>Gerencie seu estoque de forma eficiente</p>
            </div>

            <!-- Formulário de Login -->
            <div id="loginForm" class="form-container active">
                <h2>Bem-vindo de volta!</h2>
                <p class="subtitle">Entre com suas credenciais</p>

                <form id="formLogin" method="post" action="../Back-End/entrar.php">
                    <div class="form-group">
                        <label for="loginEmail">
                            <span class="icon">📧</span>
                            E-mail
                        </label>
                        <input type="email" id="loginEmail" placeholder="seu@email.com" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="loginSenha">
                            <span class="icon">🔒</span>
                            Senha
                        </label>
                        <input type="password" id="loginSenha" placeholder="••••••••" name="senha" required>
                    </div>

                    <div class="form-options">
                        <label class="checkbox">
                            <input type="checkbox" id="lembrarMe">
                            <span>Lembrar-me</span>
                        </label>
                        <a href="#" class="link">Esqueceu a senha?</a>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Entrar
                        <span class="btn-icon">→</span>
                    </button>
                </form>

                <div class="form-footer">
                    <p>Não tem uma conta? <a href="#" class="link" onclick="toggleForms()">Cadastre-se</a></p>
                </div>
            </div>

            <!-- Formulário de Cadastro -->
            <div id="cadastroForm" class="form-container">
                <h2>Criar nova conta</h2>
                <p class="subtitle">Preencha seus dados para começar</p>

                <form id="formCadastro" method="post" action="../Back-End/cadastro.php">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="cadastroNome">
                                <span class="icon">👤</span>
                                Nome Completo ou Nome da Empresa
                            </label>
                            <input type="text" id="cadastroNome" placeholder="Seu nome completo" name="nome" required>
                        </div>

                        <div class="form-group">
                            <label for="cadastroEmail">
                                <span class="icon">📧</span>
                                E-mail
                            </label>
                            <input type="email" id="cadastroEmail" placeholder="seu@email.com" name="email" required>
                        </div>

                        <div class="form-group">
                            <label for="cadastroSenha">
                                <span class="icon">🔒</span>
                                Senha
                            </label>
                            <input type="password" id="cadastroSenha" placeholder="••••••••" required>
                            <small>Mínimo 6 caracteres</small>
                        </div>

                        <div class="form-group">
                            <label for="cadastroConfirmarSenha">
                                <span class="icon">🔒</span>
                                Confirmar Senha
                            </label>
                            <input type="password" id="cadastroConfirmarSenha" placeholder="••••••••" name="senha" required>
                        </div>
                    </div>

                    <div class="form-options">
                        <label class="checkbox">
                            <input type="checkbox" id="aceitarTermos" required>
                            <span>Aceito os <a href="#" class="link">termos de uso</a> e <a href="#" class="link">política de privacidade</a></span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary">
                        Criar Conta
                        <span class="btn-icon">→</span>
                    </button>
                </form>

                <div class="form-footer">
                    <p>Já tem uma conta? <a href="#" class="link" onclick="toggleForms()">Faça login</a></p>
                </div>
            </div>

            <!-- Alertas -->
            <div id="alertContainer">
            </div>
        </div>

        <!-- Decoração -->
        <div class="decoration decoration-1"></div>
        <div class="decoration decoration-2"></div>
        <div class="decoration decoration-3"></div>
    </div>

    <script src="../Back-End/cadastro.js"></script>
</body>
</html>