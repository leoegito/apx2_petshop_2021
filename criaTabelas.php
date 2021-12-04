<?php

$conn = new PDO('mysql:dbname=db_apx2;host=localhost','root','');
createTable($conn);

function createTable($conn){

	$stmt = $conn->prepare("
			CREATE TABLE IF NOT EXISTS `db_apx2`.`Vacina` (
				id INT auto_increment PRIMARY KEY,
			    Nome varchar(45) NOT NULL
			);

			CREATE TABLE IF NOT EXISTS `db_apx2`.`Pet` (
				id INT auto_increment PRIMARY KEY,
			    Nome varchar(45) NOT NULL
			);

			CREATE TABLE IF NOT EXISTS `db_apx2`.`Veterinário` (
				id INT auto_increment PRIMARY KEY,
			    Nome varchar(45) NOT NULL
			);

			CREATE TABLE IF NOT EXISTS `db_apx2`.`Responsável` (
				id INT auto_increment PRIMARY KEY,
			    Nome varchar(45) NOT NULL
			);

			CREATE TABLE IF NOT EXISTS `db_apx2`.`Responsável_Pet` (
				`Pet_id` INT NOT NULL,
			    `Responsável_id` INT NOT NULL,
			    PRIMARY KEY(`Pet_id`, `Responsável_id`),
					FOREIGN KEY (`Pet_id`)
					REFERENCES `db_apx2`.`Pet` (`id`)
			        ON DELETE NO ACTION
			        ON UPDATE NO ACTION,
					FOREIGN KEY (`Responsável_id`)
					REFERENCES `db_apx2`.`Responsável` (`id`)
			        ON DELETE NO ACTION
			        ON UPDATE CASCADE
			);

			CREATE TABLE IF NOT EXISTS `db_apx2`.`Vacinação` (
				id INT auto_increment,
			    Data_aplicação DATE NOT NULL,
			    Pet_id INT NOT NULL,
			    Veterinário_id INT NOT NULL,
			    Vacina_id INT NOT NULL,
			    PRIMARY KEY(id, Pet_id, Veterinário_id, Vacina_id),
					FOREIGN KEY (`Pet_id`)
					REFERENCES `db_apx2`.`Pet` (`id`)
			        ON DELETE NO ACTION
			        ON UPDATE NO ACTION,
					FOREIGN KEY (`Veterinário_id`)
					REFERENCES `db_apx2`.`Veterinário` (`id`)
			        ON DELETE NO ACTION
			        ON UPDATE NO ACTION, 
					FOREIGN KEY (`Vacina_id`)
					REFERENCES `db_apx2`.`Vacina` (`id`)
			        ON DELETE NO ACTION
			        ON UPDATE NO ACTION
			);"
		);

		if(!$stmt->execute()){
			print_r($stmt->errorInfo());
		} else {
			echo 'Schema e tabelas criadas com sucesso.';
		}
		

}

?>