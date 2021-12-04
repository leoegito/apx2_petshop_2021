<?php
//Q4
$conn = new PDO('mysql:dbname=db_apx2;host=localhost','root','');
$pet = 1;

conta_aplicações_por_pet($conn, $pet);


function conta_aplicações_por_pet($conn, $pet){
	
	$stmt = $conn->prepare(

		"SELECT b.Nome, count(Data_aplicação) as Doses FROM vacinação as a JOIN vacina as b WHERE a.Pet_id = :pet AND a.Vacina_id = b.id GROUP BY b.id;"

	);

	$stmt->execute([
		':pet'=>$pet
	]);

	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	print("<pre>" .print_r($results, true) ."</pre>");

}

?>