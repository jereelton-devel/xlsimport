USE db_smg_os;
SHOW TABLES;
CREATE TABLE IF NOT EXISTS tb_os(
	os INT(11) NOT NULL,
    statusOs VARCHAR(50) NOT NULL,
    nomeCliente VARCHAR(255) NOT NULL,
    bairro VARCHAR(255) NOT NULL,
    cidade VARCHAR(100) NOT NULL,
    uf VARCHAR(2) NOT NULL,
    linha VARCHAR(20) NOT NULL,
    modelo VARCHAR(50) NOT NULL,   
    produto VARCHAR(100) NOT NULL,
    valorProduto VARCHAR(10) NOT NULL,
    cobertura VARCHAR(20) NOT NULL,
    dataAbertura DATETIME NOT NULL,
    mesOS VARCHAR(15) NOT NULL,
    PRIMARY KEY (os)
);
SELECT * FROM tb_os;
INSERT INTO tb_os VALUES('123456','Status Teste','Cliente Teste','Bairro Teste','Cidade Teste','TT','Linha Teste','Modelo Test','Produto Test','1500.00','Cobertura Teste', now(), 'janeiro');
DROP TABLE tb_os;
DELETE FROM tb_os;
#--------------------------------------------------------------------------------
#OS/MES
#SELECT * FROM tb_os WHERE dataAbertura LIKE '%-06-%';
SELECT 
	mesOs,
    COUNT(os) AS qtd
FROM
	tb_os
GROUP BY
	mesOS
ORDER BY
	qtd DESC;

#-------------------------------------------------------------------------------
#OS/STATUS
SELECT 
	statusOs,
    COUNT(os) AS qtd
FROM
	tb_os
GROUP BY
	statusOs
ORDER BY
	qtd DESC;

#-------------------------------------------------------------------------------
#RANKING
SELECT
	produto,
    modelo,
    COUNT(os) AS qtd
FROM
	tb_os
GROUP BY
	modelo, produto
ORDER BY
	qtd DESC;
    
#-------------------------------------------------------------------------------
#OS/CIDADE/ESTADO
SELECT
	cidade,
    uf,
    COUNT(os) AS qtd
FROM
	tb_os
GROUP BY
	cidade, uf
ORDER BY
	qtd DESC;