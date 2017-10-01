<?php
/* Copyright (C) 2007-2010 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) ---Put here your own copyright and developer email---
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 *   	\file       dev/skeletons/skeleton_page.php
 *		\ingroup    mymodule othermodule1 othermodule2
 *		\brief      This file is an example of a php page
 *		\version    $Id: skeleton_page.php,v 1.19 2011/07/31 22:21:57 eldy Exp $
 *		\author		Put author name here
 *		\remarks	Put here some comments
 */

//if (! defined('NOREQUIREUSER'))  define('NOREQUIREUSER','1');
//if (! defined('NOREQUIREDB'))    define('NOREQUIREDB','1');
//if (! defined('NOREQUIRESOC'))   define('NOREQUIRESOC','1');
//if (! defined('NOREQUIRETRAN'))  define('NOREQUIRETRAN','1');
//if (! defined('NOCSRFCHECK'))    define('NOCSRFCHECK','1');
//if (! defined('NOTOKENRENEWAL')) define('NOTOKENRENEWAL','1');
//if (! defined('NOREQUIREMENU'))  define('NOREQUIREMENU','1');	// If there is no menu to show
//if (! defined('NOREQUIREHTML'))  define('NOREQUIREHTML','1');	// If we don't need to load the html.form.class.php
//if (! defined('NOREQUIREAJAX'))  define('NOREQUIREAJAX','1');
//if (! defined("NOLOGIN"))        define("NOLOGIN",'1');		// If this page is public (can be called outside logged session)

// Change this following line to use the correct relative path (../, ../../, etc)
$res=0;
if (! $res && file_exists("../main.inc.php")) $res=@include("../main.inc.php");
if (! $res && file_exists("../../main.inc.php")) $res=@include("../../main.inc.php");
if (! $res && file_exists("../../../main.inc.php")) $res=@include("../../../main.inc.php");
if (! $res && file_exists("../../../dolibarr/htdocs/main.inc.php")) $res=@include("../../../dolibarr/htdocs/main.inc.php");     // Used on dev env only
if (! $res && file_exists("../../../../dolibarr/htdocs/main.inc.php")) $res=@include("../../../../dolibarr/htdocs/main.inc.php");   // Used on dev env only
if (! $res && file_exists("../../../../../dolibarr/htdocs/main.inc.php")) $res=@include("../../../../../dolibarr/htdocs/main.inc.php");   // Used on dev env only
if (! $res) die("Include of main fails");
// Change this following line to use the correct relative path from htdocs (do not remove DOL_DOCUMENT_ROOT)
require_once(DOL_DOCUMENT_ROOT."/../htdocs/flightballoon/bbc_ballons.class.php");

// Load traductions files requiredby by page
$langs->load("companies");
$langs->load("other");

// Get parameters
$myparam = isset($_GET["myparam"])?$_GET["myparam"]:'';

// Protection if external user
if ($user->societe_id  > 0)
{
	//accessforbidden();
}
if(!$user->rights->flightballoon->bal->add){
	accessforbidden();
}


/*******************************************************************
 * ACTIONS
 *
 * Put here all code to do according to value of "action" parameter
 ********************************************************************/
$msg = '';
if ($_GET["action"] == 'add' || $_POST["action"] == 'add')
{
	if (! $_POST["cancel"]){
		$dated=dol_mktime(12, 0, 0,
		$_POST["remonth"],
		$_POST["reday"],
		$_POST["reyear"]);

		$ballon=new Bbc_ballons($db);

		$ballon->date  			= $dated;
		$ballon->immat 			= trim(strtoupper($_POST['immat']));
		$ballon->marraine		= $_POST['marraine'];
		$ballon->fk_responsable	= $_POST['resp'];
		$ballon->init_heure		= $_POST['nbrHeures'];
		

		//verification des heures
		$patern = '#[0-9]{4}#';
		$error = 0;
		if(preg_match($patern,$ballon->init_heure) == 0){
			$msg = '<div class="error">Le nombre d\'heures n\'est pas correcte</div>';
			$error ++;
		}else{
			$ballon->init_heure .='00';
		}

		// verification de l'immat
		$patern = '#[A-Z]{2}-[A-Z]{3}#';
		$error = 0;
		if(preg_match($patern,$ballon->immat) == 0){
			$msg = '<div class="error">L\'immatriculation ne respecte pas le format XX-XXX '.preg_match($patern,$ballon->init_heure).'</div>';
			$error ++;
		}
		
		if($error == 0){
			$result=$ballon->create($user);
			if ($result > 0)
			{
				//creation OK
				$msg = '<div class="ok">L\'ajout du ballon : '.$ballon->immat.' est effective !</div>';
				Header("Location: balloons.php");
			}else
			{
				// Creation KO
				$msg = '<div class="error">Erreur lors de l\'ajout du ballon : '.$ballon->error.'! </div>';
				$error ++;
			}
		}
	}
}





/***************************************************
 * PAGE
 *
 * Put here all code to build page
 ****************************************************/

llxHeader('','Ajout Ballon','');

$html = new Form($db);
$datec = dol_mktime(12, 0, 0,	$_POST["remonth"],	$_POST["reday"],	$_POST["reyear"]);
if($msg){
	print $msg;
}

// Put here content of your page
print "<form name='add' action=\"add.php\" method=\"post\">\n";
print '<input type="hidden" name="action" value="add"/>';
print '<table class="border" width="100%">';
//type du vol
print "<tr>";
print '<td class="fieldrequired"> Immatriculation</td><td>';
print '<input type="text" name="immat" calss="flat"/>';
print '</td></tr>';
//Responsable
print "<tr>";
print '<td class="fieldrequired"> Responsable </td><td>';
print $html->select_users($_POST["resp"]?$_POST["resp"]:$_GET["resp"],'resp',1);
print '</td></tr>';
//type du vol
print "<tr>";
print '<td class="fieldrequired"> Marraine / Parrain</td><td>';
print '<input type="text" name="marraine" calss="flat"/>';
print '</td></tr>';
//Nombre d'heures
print "<tr>";
print '<td width="25%" class="fieldrequired">Nombre d\'heures <br/>(format autorise XXXX)</td><td>';
print '<input type="text" name="nbrHeures" calss="flat"/>';
print '</td></tr>';
//Date achats
print "<tr>";
print '<td class="fieldrequired"> Date du premier vol</td><td>';
print $html->select_date($datec?$datec:-1,'','','','','add',1,1);
print '</td></tr>';

print '</table>';

print '<br><center><input class="button" type="submit" value="'.$langs->trans("Save").'"> &nbsp; &nbsp; ';
print '<input class="button" type="submit" name="cancel" value="'.$langs->trans("Cancel").'"></center';

print '</form>';

/***************************************************
 * LINKED OBJECT BLOCK
 *
 * Put here code to view linked object
 ****************************************************/
//$somethingshown=$myobject->showLinkedObjectBlock();

// End of page
$db->close();
llxFooter('$Date: 2011/07/31 22:21:57 $ - $Revision: 1.19 $');
?>
