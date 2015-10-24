<?php
require('./controllers/header.php');


//Controleert of je wel bent ingelogd.
if(LoginCheck($pdo))
{
	
	//init fields
	$bedrijfsnaam = $beschrijving = $bezoekadres = $postcode = $plaats = $provincie = $telefoonnummer = $mobielnummer = $email = $website = $branche_id = $openingstijden = $o_maandag = $o_dinsdag = $o_woensdag = $o_donderdag = $o_vrijdag = $o_zaterdag = $o_zondag = $d_maandag = $d_dinsdag = $d_woensdag = $d_donderdag = $d_vrijdag = $d_zaterdag = $d_zondag = NULL;

	//init error fields
	$NameErr = $ZipErr = $CityErr = $TelErr = $MailErr = $OpeningsErr = NULL;

	$Specialiteiten = specialiteitenlijst($pdo);

	
	//controleert of de knop aanpassen of verwijderen is ingedurkt.
	if(isset($_GET['action']))
	{
		//haalt gegevens uit de link via Get om tekijken of het wijzigen of verwijderen is en om welk bedrijf het gaat.
		$action = $_GET['action'];
		$bedrijfs_id = $_GET['bedrijfs_id'];
		
		//Kijkt of het wijzigen of verwijderen is.
		switch($action)
		{
			case'edit':
					
					$parameters = array(':bedrijfs_id'=>$bedrijfs_id);
					$sth = $pdo->prepare('SELECT *
					FROM
					bedrijfgegevens_specialiteiten
					INNER JOIN
					specialiteiten on bedrijfgegevens_specialiteiten.specialiteiten_id = specialiteiten.id
					INNER JOIN
					bedrijfgegevens on bedrijfgegevens_specialiteiten.bedrijfgegevens_id = bedrijfgegevens.id
					INNER JOIN
					plaatsen on bedrijfgegevens.plaats_id = plaatsen.id
					WHERE
					bedrijfgegevens_id = '.$bedrijfs_id);
					$sth->execute($parameters);
					while ($row = $sth->fetch())
					{
						
					//Gegevens uit de database halen
					$bedrijfsnaam = $row['bedrijfsnaam'];
					$beschrijving = $row['beschrijving'];
					$bezoekadres = $row['bezoekadres'];
					$postcode = $row['postcode'];
					$plaats = $row['plaats'];
					$provincie = $row['provincie'];
					$website = $row['website'];
					$telefoonnummer = $row['telefoonnummer'];
					$mobielnummer = $row['mobielnummer'];
					$email = $row['email'];
					$logo = $row['logo'];
					$banner = $row['banner'];
					$_SESSION['logo'] = $row['logo'];
					$_SESSION['banner'] = $row['banner'];
					$premium = $row['premium'];
					
					$facebook = $row['facebook'];
					$twitter = $row['twitter'];
					$googleplus = $row['googleplus'];
					$linkedin = $row['linkedin'];
					$youtube = $row['youtube'];
					$pinterest = $row['pinterest'];
					
					$naam[] = $row['naam'];
					
					}
					/*
					$sth = $pdo->prepare('select * from openingstijden where bedrijfs_id = :bedrijfs_id');
					$sth->execute($parameters);
					$row = $sth->fetch();
					
					$o_maandag = $row['o_maandag'];
					$o_dinsdag = $row['o_dinsdag'];
					$o_woensdag = $row['o_woensdag'];
					$o_donderdag = $row['o_donderdag'];
					$o_vrijdag = $row['o_vrijdag'];
					$o_zaterdag = $row['o_zaterdag'];
					$o_zondag = $row['o_zondag'];
					$d_maandag = $row['d_maandag'];
					$d_dinsdag = $row['d_dinsdag'];
					$d_woensdag = $row['d_woensdag'];
					$d_donderdag = $row['d_donderdag'];
					$d_vrijdag = $row['d_vrijdag'];
					$d_zaterdag = $row['d_zaterdag'];
					$d_zondag = $row['d_zondag'];
					*/
				
					
					//controleert of de submit knop wijzigenbedrijf in het formulier is ingedurkt.
					if(isset($_POST['Del_Image']))
					{
					$image = $_POST['Del_Image'];
					$leeg = '';
					$parameter = array(':leeg'=>$leeg, ':bedrijfs_id'=>$bedrijfs_id);
					$sth = $pdo->prepare('UPDATE bedrijfgegevens SET '.$image.'=:leeg WHERE id = :bedrijfs_id');
					$sth->execute($parameter);
					
					unset($_SESSION[$image]);
					unlink('images/bedrijf_images/'.$bedrijfs_id .'/'. $row[$image]);
					
					}
					
					if(isset($_POST['Wijzigenbedrijf']))
					{
					$CheckOnErrors = false;
					
					//Gegevens uit het formulier halen
					$special = NULL;
					$specialZ = "'";
					$specialname = NULL;
					
					$bedrijfsnaam = $_POST['bedrijfsnaam'];
					$beschrijving = $_POST['beschrijving'];
					$bezoekadres = $_POST["bezoekadres"];
					$postcode = $_POST["postcode"];
					$plaats = $_POST['plaats'];
					$provincie = $_POST['provincie'];
					$website = $_POST['website'];
					$telefoonnummer = $_POST['telefoonnummer'];
					$mobielnummer = $_POST['mobielnummer'];
					$email = $_POST['email'];
					$premium = $_POST['premium'];
					
					$facebook = $_POST['facebook'];
					$twitter = $_POST['twitter'];
					$googleplus = $_POST['googleplus'];
					$linkedin = $_POST['linkedin'];
					$youtube = $_POST['youtube'];
					$pinterest = $_POST['pinterest'];
				
					$o_maandag = $_POST['o_maandag'];
					$o_dinsdag = $_POST['o_dinsdag'];
					$o_woensdag = $_POST['o_woensdag'];
					$o_donderdag = $_POST['o_donderdag'];
					$o_vrijdag = $_POST['o_vrijdag'];
					$o_zaterdag = $_POST['o_zaterdag'];
					$o_zondag = $_POST['o_zondag'];
					$d_maandag = $_POST['d_maandag'];
					$d_dinsdag = $_POST['d_dinsdag'];
					$d_woensdag = $_POST['d_woensdag'];
					$d_donderdag = $_POST['d_donderdag'];
					$d_vrijdag = $_POST['d_vrijdag'];
					$d_zaterdag = $_POST['d_zaterdag'];
					$d_zondag = $_POST['d_zondag'];
					
					
					/*if (basename($_FILES["foto"]["name"]) == null)
								{
								$foto = $_SESSION['foto'];
								}
								else
								{
								$foto = basename($_FILES["foto"]["name"]);
								}*/
					if (basename($_FILES["banner"]["name"]) == null)
								{
								$banner = $_SESSION['banner'];
								}
								else
								{
								$banner = basename($_FILES["banner"]["name"]);
								}
					if (basename($_FILES["logo"]["name"]) == null)
								{
								$logo = $_SESSION['logo'];
								}
								else
								{
								$logo = basename($_FILES["logo"]["name"]);
								}
					
					
					
					
					
					
					//begin controlles
					/*
					//Controleert bedrijs naam
					if(!isset($bedrijfs_naam))
					{
						$NameErr = 'U moet een naam van uw bedrijf invullen';
						$CheckOnErrors = true;
					}
					//controleert bedrijfs E-mail
					if(isset($bedrijfs_email))
					{
						if(!is_email($bedrijfs_email))
						{
							$CheckOnErrors = true;
							$MailErr = 'Dit is geen geldig E-mail adres.';
						}
					}
					//Controleert postcode
					if(!isset($postcode))
					{
						$CheckOnErrors = true;
						$ZipErr = 'U moet een postcode invullen';
					}
					elseif(!is_NL_PostalCode($postcode))
					{
						$CheckOnErrors = true;
						$ZipErr = 'Dit is geen geldig postcode.';
					}
					//Controleert telefoon nummer
					if(isset($telefoon))
					{
						if(!is_minlength($telefoon, 10))
						{
							$CheckOnErrors = true;
							$TelErr = 'Dit is geen geldig telefoon nummer.';
						}
					}
					//Controleert plaats
					if(!isset($plaats))
					{
						$CheckOnErrors = true;
						$CityErr = 'U moet een dorp/stad invullen.';
					}
					*/
					//als er fouten zijn dan wordt je terug gestuurd naar het formulier met wat er verbeterd moet worden.
					if($CheckOnErrors == true) 
					{
					require('./views/WijzigenBedrijfForm.php');
					}
					else
					{
						if (!file_exists('images/bedrijf_images/'.$bedrijfs_id)) {
						mkdir('images/bedrijf_images/'.$bedrijfs_id, 0777, true);
						}
						$target_dir = "images/bedrijf_images/".$bedrijfs_id."/";
						$target_file = $target_dir . basename($_FILES["foto"]["name"]);
						if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)){} 
						chmod($target_file, 777);
						$target_file = $target_dir . basename($_FILES["banner"]["name"]);
						if (move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file)){}
						chmod($target_file, 777);
						$target_file = $target_dir . basename($_FILES["logo"]["name"]);
						if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)){}
						chmod($target_file, 777);
						//De gegevens die uit het formulier komen en die correct zijn worden in de array parameters gezet
						$beschrijving = 'test';
						$parameters = array(
						':bedrijfs_id'=>$bedrijfs_id,
						':bedrijfsnaam'=>$bedrijfsnaam,
						':beschrijving'=>$beschrijving,
						':bezoekadres'=>$bezoekadres,
						':postcode'=>$postcode,
						':website'=>$website,
						':telefoonnummer'=>$telefoonnummer,
						':mobielnummer'=>$mobielnummer,
						':email'=>$email,
						':premium'=>$premium,
						':facebook'=>$facebook,
						':twitter'=>$twitter,
						':googleplus'=>$googleplus,
						':linkedIn'=>$linkedin,
						':youtube'=>$youtube,
						':pinterest'=>$pinterest,
						':logo'=>$logo,
						':banner'=>$banner
						);
	
						
						$sth = $pdo->prepare('UPDATE bedrijfgegevens SET 
						bedrijfsnaam=:bedrijfsnaam,
						beschrijving=:beschrijving,
						bezoekadres=:bezoekadres, 
						postcode=:postcode, 
						website=:website, 
						telefoonnummer=:telefoonnummer,  
						mobielnummer=:mobielnummer, 
						email=:email, 
						premium=:premium, 
						facebook=:facebook, 
						twitter=:twitter, 
						googleplus=:googleplus, 
						linkedIn=:linkedIn, 
						youtube=:youtube, 
						pinterest=:pinterest,
						logo=:logo,
						banner=:banner
						WHERE id = :bedrijfs_id');
	
						$sth->execute($parameters);
						
						
					/*
						
						$parameters = array(
						':bedrijfs_id'=>$bedrijfs_id,
						':o_maandag'=>$o_maandag,
						':o_dinsdag'=>$o_dinsdag,
						':o_woensdag'=>$o_woensdag,
						':o_donderdag'=>$o_donderdag,
						':o_vrijdag'=>$o_vrijdag,
						':o_zaterdag'=>$o_zaterdag,
						':o_zondag'=>$o_zondag,
						':d_maandag'=>$d_maandag,
						':d_dinsdag'=>$d_dinsdag,
						':d_woensdag'=>$d_woensdag,
						':d_donderdag'=>$d_donderdag,
						':d_vrijdag'=>$d_vrijdag,
						':d_zaterdag'=>$d_zaterdag,
						':d_zondag'=>$d_zondag);
						
						$sth = $pdo->prepare('UPDATE bedrijfs_specialiteiten SET
						bedrijfs_id=:bedrijfs_id, o_maandag=:o_maandag, o_dinsdag=:o_dinsdag, o_woensdag=:o_woensdag,o_donderdag=:o_donderdag, o_vrijdag=:o_vrijdag ,o_zaterdag=:o_zaterdag, o_zondag=:o_zondag, 
						d_maandag=:d_maandag, d_dinsdag=:d_dinsdag, d_woensdag=:d_woensdag,d_donderdag=:d_donderdag, d_vrijdag=:d_vrijdag ,d_zaterdag=:d_zaterdag, d_zondag=:d_zondag');
						$sth->execute($parameters);
						*/
				
						echo'De gegvens van '. $bedrijfsnaam.' zijn bijgewerkt.<br />';
						echo '<META http-equiv="refresh" content="5;URL=wijzigen.php?action=edit&bedrijfs_id='.$bedrijfs_id.'">';
					}
				}
				else
				{
					
					//laat het formulier WijzigenBedrijfForm zien als de knop wijzigenbedrijf nog niet is ingedurkt.
					require('./views/WijzigenBedrijfForm.php');
				}
				break;
			case'del':
					
					//SQL query om de gegevens van het juiste bedrijf uit de database halen
					$parameters = array(':bedrijfs_id'=>$bedrijfs_id);
					$sth = $pdo->prepare('select * from bedrijfgegevens where bedrijfs_id = :bedrijfs_id');
					$sth->execute($parameters);
					$row = $sth->fetch();
					$bedrijfsnaam = $row['bedrijfsnaam'];
					
					if(isset($_POST['verwijderen']))
					{
						$parameters = array(':bedrijfs_id'=>$bedrijfs_id);
						$sth = $pdo->prepare('delete from bedrijfgegevens where bedrijfs_id = :bedrijfs_id');
						$sth->execute($parameters);
						echo $bedrijfsnaam.' is verwijderd';
						RedirectNaarPagina(4);
					}
					elseif(isset($_POST['annuleren']))
					{
						header("Refresh: ;URL=index.php?paginanr=4");
					}
					else
					{
					echo'<form action="" method="post">';
					echo'<label>Weet u het zeker of u '.$row['bedrijfsnaam'].' wilt verwijderen</label><br />';
					echo'<button type="submit" class="btn btn-default" name="verwijderen">Verwijderen</button>';
					echo'<button type="submit" class="btn btn-default" name="annuleren">Annuleren</button>';
					echo'</form>';
					}
				break;
		}
	}
	else
	{
	require('./views/AanpassenTabel.php');
	}

}
else
{
	echo'U moet ingelogd zijn om deze pagina te kunnen gebruiken.';
}

require('./controllers/footer.php');
?>