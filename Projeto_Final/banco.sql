-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS mydb DEFAULT CHARACTER SET utf8;
USE mydb;

-------------------------------------------
-- Tabela: Usuário
-------------------------------------------
CREATE TABLE IF NOT EXISTS usuario (
    id_usuario INT NOT NULL AUTO_INCREMENT,
    nome_usuario VARCHAR(255) NOT NULL,
    email_usuario VARCHAR(255) NOT NULL,
    senha_usuario TEXT NOT NULL,
    PRIMARY KEY (id_usuario)
) ENGINE = InnoDB;

-------------------------------------------
-- Tabela: Fornecedor
-------------------------------------------
CREATE TABLE IF NOT EXISTS fornecedor (
    id_fornecedor INT NOT NULL AUTO_INCREMENT,
    nome_fornecedor VARCHAR(255) NOT NULL,
    PRIMARY KEY (id_fornecedor)
) ENGINE = InnoDB;

-------------------------------------------
-- Tabela: fornecedor_has_produto
-- (Associação entre fornecedor e produtos)
-------------------------------------------
CREATE TABLE IF NOT EXISTS fornecedor_has_produto (
    id_prod_forn INT NOT NULL,
    fornecedor_id_fornecedor INT NOT NULL,
    PRIMARY KEY (id_prod_forn, fornecedor_id_fornecedor),
    FOREIGN KEY (fornecedor_id_fornecedor)
        REFERENCES fornecedor(id_fornecedor)
) ENGINE = InnoDB;

-------------------------------------------
-- Tabela: Produto
-------------------------------------------
CREATE TABLE IF NOT EXISTS produto (
    id_produto INT NOT NULL AUTO_INCREMENT,
    descricao_produto VARCHAR(255) NOT NULL,
    valor_produto DECIMAL(8,2) NOT NULL,
    quantidade_produto INT NOT NULL,
    
    -- Chaves da associação fornecedor_has_produto
    fornecedor_has_produto_id_prod_forn INT NOT NULL,
    fornecedor_has_produto_id_fornecedor INT NOT NULL,

    PRIMARY KEY (
        id_produto,
        fornecedor_has_produto_id_prod_forn,
        fornecedor_has_produto_id_fornecedor
    ),

    FOREIGN KEY (fornecedor_has_produto_id_prod_forn, fornecedor_has_produto_id_fornecedor)
        REFERENCES fornecedor_has_produto(id_prod_forn, fornecedor_id_fornecedor)
) ENGINE = InnoDB;

-------------------------------------------
-- Tabela: Vendas
-------------------------------------------
CREATE TABLE IF NOT EXISTS vendas (
    idvendas INT NOT NULL,
    total_venda DECIMAL(10,2) NOT NULL,
    usuario_id_usuario INT NOT NULL,

    PRIMARY KEY (idvendas, usuario_id_usuario),

    FOREIGN KEY (usuario_id_usuario)
        REFERENCES usuario(id_usuario)
) ENGINE = InnoDB;

-------------------------------------------
-- Tabela: vendas_has_produto
-- (Itens da venda)
-------------------------------------------
CREATE TABLE IF NOT EXISTS vendas_has_produto (
    vendas_idvendas INT NOT NULL,
    produto_id_produto INT NOT NULL,

    PRIMARY KEY (vendas_idvendas, produto_id_produto),

    FOREIGN KEY (vendas_idvendas)
        REFERENCES vendas(idvendas),

    FOREIGN KEY (produto_id_produto)
        REFERENCES produto(id_produto)
) ENGINE = InnoDB;