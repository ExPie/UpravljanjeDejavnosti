<?php
	function izris($conn, $kljuc=NULL)
	{
		// Če ni podan ključ za iskanje izpišemo vse
		if($kljuc==NULL)
		{
			$sql = "SELECT * FROM dejavnost;";
			$result = $conn -> query($sql);
			$result = $result -> fetch_all(MYSQLI_ASSOC);
		}
		// V nasprotnem primeru primerjamo podatke v spodaj navedenih stolpcih z ključem
		else
		{
			$sql = "SELECT * FROM dejavnost WHERE (
				naslovD LIKE '%".$kljuc."%' OR
				MentorjiD LIKE '%".$kljuc."%' OR
				OrgOblikaD LIKE '%".$kljuc."%' OR
				NadarjenostD LIKE '%".$kljuc."%' OR
				OpombeD LIKE '%".$kljuc."%'
			);";
			$result = $conn -> query($sql);
			$result = $result -> fetch_all(MYSQLI_ASSOC);
		}
		// Če poizvedba ne vrne niti enega rezultata izpišemo sporočilo
		if(!$result)
			echo'<table><tr><td>Ni  zadetkov.</tr></td></table>';
		// Rezultate izpišemo v tabelo
		else
		{
			echo'<table>';
			echo'<tr><td>Ime dejavnosti</td><td>Oblika</td><td>Namenjeno</td></tr>';
			foreach($result as $el)
			{
				echo'<tr><td>'.$el["naslovD"].'</td><td>'.$el["OrgOblikaD"].'</td><td>'.$el["PrimernostD"].'</td></td>';
			}
			echo'</table>';
		}
	}
	
	echo'
	<style>
		table, th, td
		{
			border: 1px solid black;
			border-collapse: collapse;
			background-color: white;
			padding: 5px;
		}
	</style>
	<form method="POST" action="pogled.php">
	<input type="text" name="search">
	<input type="submit" value="Iskanje">
	</form>';
	$conn = mysqli_connect('localhost', 'root', '', 'dejavnosti');
	// Če baza ni dosegljiva izpišemo sporočilo
	if (!$conn)
	{
		$returnString="Podatkovna baza je nedosegljiva: " . mysqli_connect_error();
		echo $returnString.'<br/>';
	}
	else
	{
		echo'<h1>Dejavnosti:<h1>';
		// Klic osnovne funkcije za izris
		if(count($_POST)==0)
			izris($conn);
		else
		// Če je bil v POST podan ključ ga podamo kot argument izrisu
			izris($conn, $_POST["search"]);
	}
?>