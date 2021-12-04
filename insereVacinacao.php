<?php
//Q2
$conn = new PDO('mysql:dbname=db_apx2;host=localhost','root','');
$Pet_id = 1;
$Veterinário_id = 2;
$Vacina_id = 2;

insere_vacinacao($conn, $Pet_id, $Veterinário_id, $Vacina_id);

function insere_vacinacao($conn, $Pet_id, $Veterinário_id, $Vacina_id){


	$stmt = $conn->prepare("

		SELECT id FROM `vacinação` WHERE Vacina_id = :Vacina_id AND Pet_id = :Pet_id AND Data_aplicação = curdate(); 

	");

	$stmt->execute([
		':Vacina_id'=>$Vacina_id,
		':Pet_id'=>$Pet_id
	]);

	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	if(!isset($results[0]) || count($results) == 0){

		$stmt2 = $conn->prepare("

			INSERT INTO `vacinação` (id, Data_aplicação, Pet_id, Veterinário_id, Vacina_id) VALUES (null, curdate(), :Pet_id, :Veterinario_id, :Vacina_id);

		");

		$stmt2->execute([
			':Pet_id'=>$Pet_id,
			':Veterinario_id'=>$Veterinário_id,
			':Vacina_id'=>$Vacina_id
		]);

	}
	else {
		echo '<p>Vacina repetida, dados não foram inseridos no sistema.</p>';
		return null;
	}

}

?>