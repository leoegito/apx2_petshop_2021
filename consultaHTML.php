<?php
//Q5

$conn = new PDO('mysql:dbname=db_apx2;host=localhost','root','');

function listAllResponsavel($conn){

	$stmt = $conn->prepare(
		"SELECT id, Nome FROM `responsável`;"
	);

	$stmt->execute();

	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	return $results;

}

function getResponsavelName($conn, $idResp){

	$stmt = $conn->prepare(
		"SELECT Nome FROM `responsável` WHERE id = :idResp;"
	);

	$stmt->execute([
		':idResp'=>$idResp
	]);

	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	return $results[0]['Nome'];

}

function getPetName($conn, $idPet){

	$stmt = $conn->prepare(
		"SELECT Nome FROM `pet` WHERE id = :idPet;"
	);

	$stmt->execute([
		':idPet'=>$idPet
	]);

	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	return $results[0]['Nome'];

}

function listAllPetResponsavel($conn, $Responsavel_id){

	$stmt = $conn->prepare(
		"SELECT a.Pet_id, b.Nome FROM responsável_pet as a JOIN pet as b WHERE a.Pet_id = b.id AND a.Responsável_id = :Responsavel_id;"
	);

	$stmt->execute([
		':Responsavel_id'=>$Responsavel_id
	]);

	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	return $results;

}

function getVacinacao($conn, $Pet_id){

	$stmt = $conn->prepare(
		"SELECT DATE_FORMAT(a.Data_aplicação, '%d/%m/%Y') as Data_aplicação, b.Nome as Nome FROM vacinação as a JOIN vacina as b WHERE a.Pet_id = :Pet_id AND a.Vacina_id = b.id ORDER BY Data_aplicação DESC;"
	);

	$stmt->execute([
		':Pet_id'=>$Pet_id
	]);

	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	return $results;

}

?>

<html lang="pt-BR">
<head>
	<meta charset="utf-8">
	<title>Q5 APX2 2021.2 - PAW</title>
	<style>
		table, th, td {
			border: 1px solid black;
			border-collapse: collapse;
			padding: 3px;
		}

		p{
			padding: 5px;
		}

	</style>
</head>
<body>

	<form action="<?php $_SERVER['PHP_SELF']?>" method="POST">

		<?php 

			$conn = new PDO('mysql:dbname=db_apx2;host=localhost','root','');

			$responsaveis = listAllResponsavel($conn);


			if(isset($_POST['responsavel'])){

				echo "<label for='responsavel'>1.</label>";
				echo "<select id='responsavel' name='responsavel'>";
					$option = "<option value='";
					$option .= $_POST['responsavel'] ."'>";
					$nomeEscolhido = getResponsavelName($conn, $_POST['responsavel']);
					$option .= $nomeEscolhido;
					$option .= "</option>";
					echo $option;
				
				echo "</select></br>";

				echo '</br>';


				$pets = listAllPetResponsavel($conn, (int) $_POST['responsavel']);

				echo "<label for='pet'>2.</label>";
				echo "<select id='pet' name='pet' default=' '>";
				if(sizeof($pets) > 0){
					echo '<option value="" selected disabled hidden>Selecione o Pet</option>';
					for($i = 0; $i<sizeof($pets); $i++){
						$option = "<option value='";
						$option .= $pets[$i]['Pet_id'] ."'>";
						$option .= $pets[$i]['Nome'];
						$option .= "</option>";
						echo $option;
					}

				} else {
					echo "<option value='' selected='true' disabled='disabled'>Não possui</option>";
				}


				echo "</select></br>";

			} else {
				
				echo "<label for='responsavel'>1.</label>";
				echo "<select id='responsavel' name='responsavel'>";
				for($i = 0; $i<sizeof($responsaveis); $i++){
					$option = "<option default='' value='";
					$option .= $responsaveis[$i]['id'] ."'>";
					$option .= $responsaveis[$i]['Nome'];
					$option .= "</option>";
					echo $option;
				}
				
				echo "</select></br>";

			}

				echo "<p><button type='submit' value='Enviar'>Enviar</button>";
				// echo '<input type="button" onclick="history.back();" value="Voltar">';
				echo "</p></form>";

			if(isset($_POST['pet'])){

				echo "<p>Nome do pet: ";

				$petEscolhido = getPetName($conn, $_POST['pet']);
				echo "<strong>" .$petEscolhido ."</strong></p>";

				$vacinas = getVacinacao($conn, (int) $_POST['pet']);

				echo "<table style='padding: 5px; border: 3px solid black;'>";

					echo "<tr>";;
						echo "<th>Data da Aplicação</th>";
						echo "<th>Nome da Vacina</th>";
					echo "</tr>";
					foreach($vacinas as $row => $value){
						echo "<tr>";
						foreach($vacinas[$row] as $col){
							echo "<td>" .$col ."</td>";
						}
						echo "</tr>";
					}

				echo "</table";
			}

		?>
		
</body>
</html>