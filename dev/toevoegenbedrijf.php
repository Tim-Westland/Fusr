<?php
require('./controllers/header.php');

//Controleert of je wel bent ingelogd.
if(LoginCheck($pdo))
{
//openingstijden aan of uit.
$aan = NULL;
	//init fields
$specialiteit_1 = $specialiteit_2 = $specialiteit_3 = $specialiteit_4 = $specialiteit_5 = $specialiteit_6 = $specialiteit_7 = $specialiteit_8 = $specialiteit_9 = $specialiteit_10 = $specialiteit_11 = $specialiteit_12 = $specialiteit_13 = $specialiteit_14 = $specialiteit_15 = $specialiteit_16 = $specialiteit_17 = $specialiteit_18 = $specialiteit_19 = $specialiteit_20 = $bedrijfs_naam = $beschrijving = $adres = $postcode = $plaats = $provincie = $telefoon = $fax = $bedrijfs_email = $specialiteit = $type = $bereik = $transport_manager = $aantal = $rechtsvorm = $vergunning = $geldigtot = $website = $premium = $Picture = $openingstijden = $otmaandag = $otdinsdag = $otwoensdag = $otdonderdag = $otvrijdag = $otzaterdag = $otzondag = $Facebook = $Twitter = $Google = $LinkedIn = $Instagram = $Pinterest = NULL;

	//init error fields
	$NameErr = $ZipErr = $CityErr = $TelErr = $MailErr = $OpeningsErr = NULL;
	
	$Specialiteiten = specialiteitenlijst($pdo);
	$Branches = branchelijst($pdo);
	
	if(isset($_POST['add_spec']) AND !empty($_POST['add_specialiteit']))
	{
	$bedrijfs_naam = $_POST["Bedrijfsnaam"];
	$adres = $_POST["adres"];
	$postcode = $_POST["postcode"];
	$plaats = $_POST['plaats'];
	$provincie = $_POST['provincie'];
	$website = $_POST['website'];
	$telefoon = $_POST['telefoon'];
	$fax = $_POST['fax'];
	$specialiteit = $_POST['specialiteit'];
	$br_id = $_POST['branche'];
	$transport_manager = $_POST['transport_manager'];
	$aantal = $_POST['aantal'];
	$rechtsvorm = $_POST['rechtsvorm'];
	$vergunning = $_POST['vergunning'];
	$bedrijfs_email = $_POST['bedrijfs_email'];
	$beschrijving = $_POST['beschrijving'];
	$premium = $_POST['premium'];
	
		$Facebook = $_POST['Facebook'];
		$Twitter = $_POST['Twitter'];
		$Google = $_POST['Google'];
		$LinkedIn = $_POST['LinkedIn'];
		$Instagram = $_POST['Instagram'];
		$Pinterest = $_POST['Pinterest'];
		
	$aan = 0;	
	if($aan == 1){	
		$openingstijden = $_POST['openingstijden'];
		if($openingstijden == 'ja' && $openingstijden != 'nee' )
		{
			$otmaandag = $_POST['maandag'];
			$otdinsdag = $_POST['dinsdag'];
			$otwoensdag = $_POST['woensdag'];
			$otdonderdag = $_POST['donderdag'];
			$otvrijdag = $_POST['vrijdag']; 
			$otzaterdag = $_POST['zaterdag'];
			$otzondag = $_POST['zondag'];
		}
	}
	
	var_dump($_POST);
	$N = 0;
	$X = 1;
		foreach($specialiteit as $value) 
		{
			
			${'specialiteit_'.$X} = $value;
			$N++;
			$X++;
		}	
	$add_specialiteit = $_POST['add_specialiteit'];
	$parameters = array(':add_specialiteit'=>$add_specialiteit);
	$sth = $pdo->prepare('INSERT INTO specialiteiten (specialiteit)VALUES(:add_specialiteit)');
	$sth->execute($parameters);
	
		
	}
	
	
		if(isset($_POST['Registrerenbedrijf']))
	{
		$CheckOnErrors = false;
		
		$bedrijfs_naam = $_POST["Bedrijfsnaam"];
		$adres = $_POST["adres"];
		$postcode = $_POST["postcode"];
		$plaats = $_POST['plaats'];
		$provincie = $_POST['provincie'];
		$website = $_POST['website'];
		$telefoon = $_POST['telefoon'];
		$fax = $_POST['fax'];
		$specialiteit = $_POST['specialiteit'];
		$br_id = $_POST['branche'];
		$transport_manager = $_POST['transport_manager'];
		$aantal = $_POST['aantal'];
		$rechtsvorm = $_POST['rechtsvorm'];
		$vergunning = $_POST['vergunning'];
		$bedrijfs_email = $_POST['bedrijfs_email'];
		$beschrijving = $_POST['beschrijving'];
		$premium = $_POST['premium'];
		$foto = basename($_FILES["foto"]["name"]);
		$banner = basename($_FILES["banner"]["name"]);
		$logo = basename($_FILES["logo"]["name"]);
		
		$Facebook = $_POST['Facebook'];
		$Twitter = $_POST['Twitter'];
		$Google = $_POST['Google'];
		$LinkedIn = $_POST['LinkedIn'];
		$Instagram = $_POST['Instagram'];
		$Pinterest = $_POST['Pinterest'];
	
		if($aan == 1)
		{
			$openingstijden = $_POST['openingstijden'];
			if($openingstijden == 'ja' && $openingstijden != 'nee' )
			{
				$otmaandag = $_POST['maandag'];
				$otdinsdag = $_POST['dinsdag'];
				$otwoensdag = $_POST['woensdag'];
				$otdonderdag = $_POST['donderdag'];
				$otvrijdag = $_POST['vrijdag']; 
				$otzaterdag = $_POST['zaterdag'];
				$otzondag = $_POST['zondag'];
			}
		}
		
		$special = NULL;
		$specialZ = "'";
		$specialname = NULL;
		
		var_dump($_POST);
		$N = 0;
		$X = 1;
		foreach($specialiteit as $value) 
		{
			
			${'specialiteit_'.$X} = $value;
			$N++;
			$X++;
		}	
		
		$sth = $pdo->prepare('SELECT * FROM specialiteiten WHERE specialiteit_id REGEXP '.$specialZ);
		$sth->execute();
		while($row = $sth->fetch())
		{
			$specialname.= $row['specialiteit'].', ';
		}
		
		$specialname = substr($specialname, 0, -2);

		//begin controlles
		
		//Controleert bedrijs naam
		/*
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
		if(!isset($telefoon))
		{
			$CheckOnErrors = true;
			$TelErr = 'U moet een telefoon nummer invullen.';
		}
		elseif(!is_minlength($telefoon, 10))
		{
			$CheckOnErrors = true;
			$TelErr = 'Dit is geen geldig telefoon nummer.';
		}
		//Controlleert plaats
		if(!isset($plaats))
		{
			$CheckOnErrors = true;
			$CityErr = 'U moet een dorp/stad invullen.';
		}
		*/
		
		if (file_exists($foto) or file_exists($banner) or file_exists($logo)) {
		$CheckOnErrors = true;
		}
		
		if($CheckOnErrors == true) 
		{
		require('./views/ToevoegenBedrijfForm.php');
		}
		else
		{
			
		$sth = $pdo->prepare('SELECT auto_increment FROM INFORMATION_SCHEMA.TABLES
		WHERE table_name = bedrijfsgegevens');
		$sth->execute();
		$row = $sth->fetch();
		$bedrijfs_id = $row['auto_increment'];
			
		if (!file_exists('images/bedrijf_images/'.$bedrijfs_id)) {
			mkdir('images/bedrijf_images/'.$bedrijfs_id, 0777, true);
			}
		$target_dir = "images/bedrijf_images/".$bedrijfs_id."/";
		$target_file = $target_dir . basename($_FILES["foto"]["name"]);
		if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)){} 
		$target_file = $target_dir . basename($_FILES["banner"]["name"]);
		if (move_uploaded_file($_FILES["banner"]["tmp_name"], $target_file)){} 
		$target_file = $target_dir . basename($_FILES["logo"]["name"]);
		if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)){}
		
		if(empty($foto))
		{
			$foto = 'foto.jpg';
		}
		if(empty($banner))
		{
			$banner = 'banner.png';
		}	
		if(empty($logo))
		{
			$logo = 'logo.png';
		}			
			
			
			$parameters = array(':bedrijfsnaam'=>$bedrijfs_naam,
								':beschrijving'=>$beschrijving,
								':adres'=>$adres,
								':postcode'=>$postcode,
								':plaats'=>$plaats,
								':provincie'=>$provincie,
								':website'=>$website,
								':telefoon'=>$telefoon,
								':fax'=>$fax,
								':transport_manager'=>$transport_manager,
								':aantal'=>$aantal,
								':rechtsvorm'=>$rechtsvorm,
								':vergunning'=>$vergunning,
								':bedrijfs_email'=>$bedrijfs_email,
								':premium'=>$premium,
								':Facebook'=>$Facebook,
								':Twitter'=>$Twitter,
								':Google'=>$Google,
								':LinkedIn'=>$LinkedIn,
								':Instagram'=>$Instagram,
								':Pinterest'=>$Pinterest,
								':foto'=>$foto,
								':banner'=>$banner,
								':logo'=>$logo,
								':branche_id'=>$br_id,
								':openingstijden'=>$openingstijden);
								
			$sth = $pdo->prepare('INSERT INTO bedrijfgegevens (
								bedrijfsnaam, 
								beschrijving, 
								adres, 
								postcode, 
								plaats, 
								provincie, 
								website, 
								telefoon,
								fax,
								transport_manager, 
								aantal, 
								rechtsvorm, 
								vergunning, 
								bedrijfs_email, 
								premium,
								Facebook,
								Twitter,
								Google,
								LinkedIn,
								Instagram,
								Pinterest,
								afbeelding,
								banner,
								logo,
								branche_id,
								openingstijden) 
								VALUES(
								:bedrijfsnaam, 
								:beschrijving, 
								:adres, 
								:postcode, 
								:plaats, 
								:provincie, 
								:website, 
								:telefoon,
								:fax, 
								:transport_manager, 
								:aantal, 
								:rechtsvorm, 
								:vergunning, 
								:bedrijfs_email, 
								:premium,
								:Facebook,
								:Twitter,
								:Google,
								:LinkedIn,
								:Instagram,
								:Pinterest,
								:foto,
								:banner,
								:logo,
								:branche_id,
								:openingstijden)');
			$sth->execute($parameters);
			if($aan == 1)
			{
				if($openingstijden == 'ja' && $openingstijden != 'nee' )
				{
					$parameters = array(':bedrijfsnaam'=>$bedrijfs_naam);
					$sth = $pdo->prepare('SELECT bedrijfs_id FROM bedrijfgegevens WHERE bedrijfsnaam = :bedrijfsnaam');
					$sth->execute($parameters);
					$row = $sth->fetch();
					$otbedrijfs_id = $row['bedrijfs_id'];
					
					$parameters = array(':bedrijfs_id'=>$otbedrijfs_id,
										':maandag'=>$otmaandag,
										':dinsdag'=>$otdinsdag,
										':woensdag'=>$otwoensdag,
										':donderdag'=>$otdonderdag,
										':vrijdag'=>$otvrijdag,
										':zaterdag'=>$otzaterdag,
										':zondag'=>$otzondag);
					$sth = $pdo->prepare('INSERT INTO openingstijden (bedrijfs_id, maandag, dinsdag, woensdag, donderdag, vrijdag, zaterdag, zondag) VALUES (:bedrijfs_id, :maandag, :dinsdag, :woensdag, :donderdag, :vrijdag, :zaterdag, :zondag)');
					$sth->execute($parameters);
				}
			}			
			echo'De bedrijf gegevens zijn geregistreerd.<br />';
			//echo '<META http-equiv="refresh" content="5;URL=index.php">';
		}
	}
	else
	{
		require('./views/ToevoegenBedrijfForm.php');
	}
}
else
{
	echo'U moet ingelogd zijn om deze pagina te kunnen gebruiken.';
}


require('./controllers/footer.php');
?>
