<?php require('views/header.php'); ?>

<?php
require('views/menu.php');

if(!isset($_GET['wijzig']))
{
	unset($_SESSION['subbranche']);
	unset($_SESSION['branche']);
}
else
{
	if($_GET['wijzig'] == 1)
		{
			require('beheer_specialiteiten.php');
			unset($_SESSION['branche']);
		}
	elseif($_GET['wijzig'] == 2)
		{
			require('beheer_subbranches.php');
			unset($_SESSION['subbranche']);
			
		}
	elseif($_GET['wijzig'] == 3)
		{
			require('beheer_branches.php');
		}
	elseif($_GET['wijzig'] == 4)
		{
			require('beheer_zoektermen.php');
		}
}
?>
<?php require('views/footer.php'); ?>
