<?php
//Q3
$conn = new PDO('mysql:dbname=db_apx2;host=localhost','root','');
$mes = 12;
conta_aplicacoes_por_vacina($conn, $mes);


function conta_aplicacoes_por_vacina($conn, $mes){

	$ano = date("Y");

	$dataInicio = $ano .'-' .$mes . '-' .'01';

	//Verifica se o mês tem 30 ou 31 dias ou é fevereiro
	if(($mes % 2) == 0){
		//Fevereiro
		if($mes == 2){
			//Verifica se o ano é bissexto
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

		SELECT b.Nome, count(a.Data_aplicação) as Quantidade FROM vacinação as a JOIN vacina as b WHERE a.Data_aplicação > :dataInicio AND a.Data_aplicação <= :dataFim AND a.Vacina_id = b.id GROUP BY b.id;
 

	");

	$stmt->execute([
		':dataInicio'=>$dataInicio,
		':dataFim'=>$dataFim
	]);

	$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

	print("<pre>" .print_r($results, true) ."</pre>");

}

?>