<?php
//Q3
$conn = new PDO('mysql:dbname=db_apx2;host=localhost','root','');
$mes = 12;
conta_aplicacoes_por_vacina($conn, $mes);


function conta_aplicacoes_por_vacina($conn, $mes){

	$ano = date("Y");
	// $ano = format("Y");
	//var_dump($ano);
	$dataInicio = $ano .'-' .$mes . '-' .'01';
	//var_dump($dataInicio);
	if(($mes % 2) == 0){
		if($mes == 2){
			if($ano % 4 == 0){
				if($ano % 100 != 0){
					$dataFim = $ano .'-' .$mes . '-' .'29';
				}
				else{
					if($ano % 400 == 0){
						$dataFim = $ano .'-' .$mes . '-' .'29';
					} else {
						$dataFim = $ano .'-' .$mes . '-' .'28';
					}
				}
			} else {
				$dataFim = $ano .'-' .$mes . '-' .'28';
			}
			
		} else{
			$dataFim = $ano .'-' .$mes . '-' .'31';
		}
	} else{
		$dataFim = $ano .'-' .$mes . '-' .'31';
	}

	$stmt = $conn->prepare("

		SELECT b.nome, count(a.Data_aplicação) as Quantidade FROM vacinação as a JOIN vacina as b WHERE a.Data_aplicação > :dataInicio AND a.Data_aplicação <= :dataFim AND a.Vacina_id = b.id;
 

	");

	$stmt->execute([
		':dataInicio'=>$dataInicio,
		':dataFim'=>$dataFim
	]);

	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	//$json = json_encode($results, JSON_PRETTY_PRINT);
	//header('Content-type: application/json; charset=utf-8'); -> apenas no chrome
	print_r($results);

}

?>