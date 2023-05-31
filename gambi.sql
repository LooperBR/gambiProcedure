CREATE DATABASE exemplo_procedure;
USE exemplo_procedure;

CREATE TABLE usuario(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(100),
email VARCHAR(200),
data_nascto DATE,
peso DECIMAL(10,2),
altura DECIMAL(10,2),
sexo CHAR(1)
);

CREATE TABLE historico(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
data_consulta DATETIME,
idade INT,
peso DECIMAL(10,2),
altura DECIMAL(10,2),
sexo CHAR(1),
imc DECIMAL(10,2),
tmb DECIMAL(10,2),
usuario_id INT,
FOREIGN KEY (usuario_id) REFERENCES usuario(id)
);

DELIMITER $$

CREATE FUNCTION calcula_imc(p_peso DECIMAL(10,2),p_altura DECIMAL(10,2))
RETURNS DECIMAL(10,2)
DETERMINISTIC
BEGIN
	RETURN (p_peso/(p_altura*p_altura));
END $$

CREATE FUNCTION calcula_tmb(p_peso DECIMAL(10,2),p_altura DECIMAL(10,2),p_idade INT,p_sexo CHAR(1))
RETURNS DECIMAL(10,2)
DETERMINISTIC
BEGIN
	DECLARE v_tmb DECIMAL(10,2) default 0;
	DECLARE v_altura INT DEFAULT 0;
	SET v_altura = p_altura * 100;
	if p_sexo = 'M' then
	
		set v_tmb = 66 + ((13.7 * p_peso) + ( 5 * v_altura) - (6.8 * p_idade));
	
	END if;
	
	if p_sexo = 'F' then
	
		set v_tmb = 655 + ((9.6 * p_peso) + ( 1.8 * v_altura) - (4.7 * p_idade));
	
	END if;
	

	RETURN v_tmb;
END $$

CREATE PROCEDURE calculo_usuario(IN p_usuario_id INT,IN p_peso DECIMAL(10,2),in p_altura DECIMAL(10,2),in p_idade INT,in p_sexo CHAR(1))
BEGIN
	DECLARE v_tmb DECIMAL(10,2) default 0;
	DECLARE v_imc DECIMAL(10,2) default 0;
	
	UPDATE usuario SET peso = p_peso, altura = p_altura, sexo = p_sexo WHERE id = p_usuario_id;
	
	SET v_imc = calcula_imc(p_peso,p_altura);
	SET v_tmb = calcula_tmb(p_peso,p_altura,p_idade,p_sexo);
	
	INSERT INTO historico(data_consulta,idade,peso,altura,sexo,imc,tmb,usuario_id)
	SELECT NOW(),p_idade,p_peso,p_altura,p_sexo,v_imc,v_tmb,p_usuario_id;
	
END $$
DELIMITER ;

INSERT INTO usuario(nome,email,data_nascto,peso,altura,sexo) VALUES ('joao','joao@gmail.com','2001-07-26',80.5,1.73,'M');

SELECT * FROM usuario;
SELECT * FROM historico;

CALL calculo_usuario(1,80,1.73,21,'M');