<?php
session_start();
if (isset($_SESSION["id"])){
    header("Location: ./inicio.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StockFlow - Sistema de Gestão de Estoque</title>
    <link rel="stylesheet" href="/Projeto-Montanari/Css/index.css">
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="logo-nav">
                <span class="logo-icon">📦</span>
                <span class="logo-text">StockFlow</span>
            </div>
            <div class="nav-links">
                <a href="#recursos">Recursos</a>
                <a href="#sobre">Sobre</a>
                <a href="#contato">Contato</a>
                <a href="login.html" class="btn-login">Entrar</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-background">
            <div class="circle circle-1"></div>
            <div class="circle circle-2"></div>
            <div class="circle circle-3"></div>
        </div>
        
        <div class="hero-content">
            <div class="hero-badge">
                <span>✨ Sistema Completo de Gestão</span>
            </div>
            
            <h1 class="hero-title">
                Gerencie seu estoque com
                <span class="gradient-text">inteligência</span>
            </h1>
            
            <p class="hero-subtitle">
                Controle total do seu inventário em uma plataforma moderna, 
                intuitiva e poderosa. Aumente sua eficiência e reduza custos.
            </p>
            
            <div class="hero-buttons">
                <a href="/Projeto-Montanari/Paginas/entrada.php" class="btn btn-primary">
                    Comece Já
                    <span class="btn-icon">→</span>
                </a>
            </div>
            
            <div class="hero-stats">
                <div class="stat-item">
                    <div class="stat-number">500+</div>
                    <div class="stat-label">Empresas</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">50k+</div>
                    <div class="stat-label">Produtos</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">99.9%</div>
                    <div class="stat-label">Uptime</div>
                </div>
            </div>
        </div>
        
        <div class="hero-image">
            <div class="dashboard-preview">
                <div class="preview-header">
                    <div class="preview-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>
                <div class="preview-content">
                    <div class="preview-card">
                        <div class="card-icon">📊</div>
                        <div class="card-text">Dashboard em tempo real</div>
                    </div>
                    <div class="preview-card">
                        <div class="card-icon">📦</div>
                        <div class="card-text">Controle de estoque</div>
                    </div>
                    <div class="preview-card">
                        <div class="card-icon">✅</div>
                        <div class="card-text">Entrada Gratuita</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recursos Section -->
    <section id="recursos" class="recursos">
        <div class="section-container">
            <div class="section-header">
                <span class="section-badge">Recursos</span>
                <h2>Tudo que você precisa em um só lugar</h2>
                <p>Ferramentas poderosas para gerenciar seu negócio com eficiência</p>
            </div>
            
            <div class="recursos-grid">
                <div class="recurso-card">
                    <div class="recurso-icon">🏢</div>
                    <h3>Gestão de Empresas</h3>
                    <p>Cadastre e gerencie suas empresas em uma única plataforma</p>
                </div>
                
                <div class="recurso-card">
                    <div class="recurso-icon">📦</div>
                    <h3>Controle de Estoque</h3>
                    <p>Acompanhe seus produtos em tempo real com alertas inteligentes</p>
                </div>
                
                <div class="recurso-card">
                    <div class="recurso-icon">📊</div>
                    <h3>Dashboard Intuitivo</h3>
                    <p>Visualize todas as informações importantes de forma clara</p>
                </div>
                
                <div class="recurso-card">
                    <div class="recurso-icon">🔔</div>
                    <h3>Alertas Automáticos</h3>
                    <p>Receba notificações quando o estoque estiver baixo</p>
                </div>
                
                <div class="recurso-card">
                    <div class="recurso-icon">📈</div>
                    <h3>Relatórios Completos</h3>
                    <p>Gere relatórios detalhados para análise de desempenho</p>
                </div>
                
                <div class="recurso-card">
                    <div class="recurso-icon">🔒</div>
                    <h3>Segurança Total</h3>
                    <p>Seus dados protegidos com criptografia de ponta</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta">
        <div class="cta-container">
            <div class="cta-content">
                <h2>Pronto para revolucionar seu estoque?</h2>
                <p>Junte-se a centenas de empresas que já confiam no StockFlow</p>
                <a href="login.html" class="btn btn-primary btn-large">
                    Começar Agora Gratuitamente
                    <span class="btn-icon">→</span>
                </a>
                <p class="cta-note">✓ Sem cartão de crédito • ✓ Configuração rápida • ✓ Suporte 24/7</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo">
                        <span class="logo-icon">📦</span>
                        <span class="logo-text">StockFlow</span>
                    </div>
                    <p>Sistema completo de gestão de estoque para empresas modernas.</p>
                </div>
                
                <div class="footer-section">
                    <h4>Produto</h4>
                    <a href="#recursos">Recursos</a>
                    <a href="#sobre">Sobre</a>
                    <a href="#">Preços</a>
                    <a href="#">Blog</a>
                </div>
                
                <div class="footer-section">
                    <h4>Suporte</h4>
                    <a href="#">Central de Ajuda</a>
                    <a href="#contato">Contato</a>
                    <a href="#">Documentação</a>
                    <a href="#">Status</a>
                </div>
                
                <div class="footer-section">
                    <h4>Legal</h4>
                    <a href="#">Termos de Uso</a>
                    <a href="#">Privacidade</a>
                    <a href="#">Cookies</a>
                    <a href="#">Segurança</a>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2024 StockFlow. Todos os direitos reservados.</p>
                <div class="social-links">
                    <a href="#">Twitter</a>
                    <a href="#">LinkedIn</a>
                    <a href="#">Instagram</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="/Projeto-Montanari/Back-End/index.js"></script>
</body>
</html>