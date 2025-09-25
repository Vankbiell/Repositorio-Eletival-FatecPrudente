<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Sistema</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .cadastro-container {
            max-width: 500px;
            width: 100%;
            margin: 0 auto;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            text-align: center;
            padding: 2rem;
        }
        .btn-success {
            background: linear-gradient(135deg, #56ab2f 0%, #a8e6cf 100%);
            border: none;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .progress {
            height: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="cadastro-container">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Criar Nova Conta</h3>
                    <p class="mb-0">Preencha os dados abaixo</p>
                </div>
                <div class="card-body p-4">
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: 100%" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    
                    <form id="cadastroForm">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nome" class="form-label">Nome</label>
                                <input type="text" class="form-control" id="nome" placeholder="Seu nome" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="sobrenome" class="form-label">Sobrenome</label>
                                <input type="text" class="form-control" id="sobrenome" placeholder="Seu sobrenome" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="emailCadastro" class="form-label">E-mail</label>
                            <input type="email" class="form-control" id="emailCadastro" placeholder="seu@email.com" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="telefone" class="form-label">Telefone</label>
                            <input type="tel" class="form-control" id="telefone" placeholder="(11) 99999-9999">
                        </div>
                        
                        <div class="mb-3">
                            <label for="senhaCadastro" class="form-label">Senha</label>
                            <input type="password" class="form-control" id="senhaCadastro" placeholder="Crie uma senha forte" required>
                            <div class="form-text">A senha deve conter pelo menos 8 caracteres, incluindo letras maiúsculas, minúsculas e números.</div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirmarSenha" class="form-label">Confirmar Senha</label>
                            <input type="password" class="form-control" id="confirmarSenha" placeholder="Digite a senha novamente" required>
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input" id="termos" required>
                            <label class="form-check-label" for="termos">
                                Aceito os <a href="#" class="text-decoration-none">termos de uso</a> e <a href="#" class="text-decoration-none">política de privacidade</a>
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-success w-100 py-2">Criar Conta</button>
                    </form>
                    
                    <div class="text-center mt-3">
                        <a href="index.php" class="text-decoration-none">Já tem uma conta? Faça login</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.getElementById('cadastroForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const senha = document.getElementById('senhaCadastro').value;
            const confirmarSenha = document.getElementById('confirmarSenha').value;
            
            if (senha !== confirmarSenha) {
                alert('As senhas não coincidem!');
                return;
            }
            
            if (senha.length < 8) {
                alert('A senha deve ter pelo menos 8 caracteres!');
                return;
            }
            
            // Aqui você pode adicionar a lógica de cadastro
            alert('Cadastro realizado com sucesso!');
        });

        // Máscara para telefone
        document.getElementById('telefone').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 11) value = value.slice(0, 11);
            
            if (value.length > 10) {
                value = value.replace(/(\d{2})(\d{5})(\d{4})/, '($1) $2-$3');
            } else if (value.length > 6) {
                value = value.replace(/(\d{2})(\d{4})(\d{0,4})/, '($1) $2-$3');
            } else if (value.length > 2) {
                value = value.replace(/(\d{2})(\d{0,5})/, '($1) $2');
            } else if (value.length > 0) {
                value = value.replace(/(\d{0,2})/, '($1');
            }
            
            e.target.value = value;
        });
    </script>
</body>
</html>