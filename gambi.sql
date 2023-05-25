CREATE DATABASE exemplo_procedure;
USE exemplo_procedure;

CREATE TABLE usuario(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(100),
data_nascto DATE
);

CREATE TABLE classe(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
nome VARCHAR(45)
)

CREATE TABLE inscricao_classe(
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
id_usuario INT,
id_classe INT,
CONSTRAINT `fk_inscricao_classe`
    FOREIGN KEY (`id_classe`)
    REFERENCES `exemplo_procedure`.`classe` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION,
CONSTRAINT `fk_inscricao_usuario`
    FOREIGN KEY (`id_usuario`)
    REFERENCES `exemplo_procedure`.`usuario` (`id`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION)
)

INSERT INTO usuario(nome,data_nascto) VALUES('joao','2001-07-26');
