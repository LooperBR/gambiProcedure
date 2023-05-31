CREATE DATABASE exemplo_procedure;
USE exemplo_procedure;

CREATE TABLE usuario(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(100),
data_nascto DATE,
peso DECIMAL(10,2),
altura DECIMAL(10,2),
sexo CHAR(1)
);

CREATE TABLE historico(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
data_consulta DATETIME,
peso DECIMAL(10,2),
altura DECIMAL(10,2),
sexo CHAR(1),
imc DECIMAL(10,2),
tmb DECIMAL(10,2),
usuario_id INT,
FOREIGN KEY (usuario_id) REFERENCES usuario(id)
)

DELIMITER $$

CREATE FUNCTION calcula_imc(p_peso DECIMAL(10,2),p_altura DECIMAL(10,2))
RETURNS DECIMAL(10,2)
DETERMINISTIC
BEGIN
	RETURN p_peso/(p_altura*p_altura);
END $$

CREATE FUNCTION calcula_tmb(p_peso DECIMAL(10,2),p_altura DECIMAL(10,2),p_idade INT,p_sexo CHAR(1))
RETURNS DECIMAL(10,2)
DETERMINISTIC
BEGIN
	DECLARE v_tmb DECIMAL(10,2) default 0;
	if p_sexo = 'H' then
	
		set v_tmb = 66 + ((13.7 * p_peso) + ( 5 * p_altura) - (6.8 * p_idade));
	
	END if;
	
	if p_sexo = 'M' then
	
		set v_tmb = 655 + ((9.6 * p_peso) + ( 1.8 * p_altura) - (4.7 * p_idade));
	
	END if;
	

	RETURN v_tmb;
END $$

DELIMITER ;