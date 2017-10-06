<?php
/* Copyright (C) 2007-2017 Laurent Destailleur  <eldy@users.sourceforge.net>
 * Copyright (C) ---Put here your own copyright and developer email---
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
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
 *   	\file       llx_bbc_ballons_card.php
 *		\ingroup    hello
 *		\brief      Page to create/edit/view llx_bbc_ballons
 */

//if (! defined('NOREQUIREUSER'))          define('NOREQUIREUSER','1');
//if (! defined('NOREQUIREDB'))            define('NOREQUIREDB','1');
//if (! defined('NOREQUIRESOC'))           define('NOREQUIRESOC','1');
//if (! defined('NOREQUIRETRAN'))          define('NOREQUIRETRAN','1');
//if (! defined('NOSCANGETFORINJECTION'))  define('NOSCANGETFORINJECTION','1');			// Do not check anti CSRF attack test
//if (! defined('NOSCANPOSTFORINJECTION')) define('NOSCANPOSTFORINJECTION','1');			// Do not check anti CSRF attack test
//if (! defined('NOCSRFCHECK'))            define('NOCSRFCHECK','1');			// Do not check anti CSRF attack test
//if (! defined('NOSTYLECHECK'))           define('NOSTYLECHECK','1');			// Do not check style html tag into posted data
//if (! defined('NOTOKENRENEWAL'))         define('NOTOKENRENEWAL','1');		// Do not check anti POST attack test
//if (! defined('NOREQUIREMENU'))          define('NOREQUIREMENU','1');			// If there is no need to load and show top and left menu
//if (! defined('NOREQUIREHTML'))          define('NOREQUIREHTML','1');			// If we don't need to load the html.form.class.php
//if (! defined('NOREQUIREAJAX'))          define('NOREQUIREAJAX','1');         // Do not load ajax.lib.php library
//if (! defined("NOLOGIN"))                define("NOLOGIN",'1');				// If this page is public (can be called outside logged session)

// Load Dolibarr environment
$res = 0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (!$res && !empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) $res = @include($_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php");
// Try main.inc.php into web root detected using web root caluclated from SCRIPT_FILENAME
$tmp = empty($_SERVER['SCRIPT_FILENAME']) ? '' : $_SERVER['SCRIPT_FILENAME']; $tmp2 = realpath(__FILE__); $i = strlen($tmp) - 1; $j = strlen($tmp2) - 1;
while ($i>0 && $j>0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i] == $tmp2[$j]) { $i--; $j--; }
if (!$res && $i>0 && file_exists(substr($tmp, 0, ($i + 1))."/main.inc.php")) $res = @include(substr($tmp, 0, ($i + 1))."/main.inc.php");
if (!$res && $i>0 && file_exists(dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php")) $res = @include(dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php");
// Try main.inc.php using relative path
if (!$res && file_exists("../main.inc.php")) $res = @include("../main.inc.php");
if (!$res && file_exists("../../main.inc.php")) $res = @include("../../main.inc.php");
if (!$res && file_exists("../../../main.inc.php")) $res = @include("../../../main.inc.php");
if (!$res) die("Include of main fails");

include_once(DOL_DOCUMENT_ROOT.'/core/class/html.formcompany.class.php');
dol_include_once('/flightballoon/class/bbc_ballons.class.php');
dol_include_once('/flightballoon/lib/card.lib.php');

global $user, $langs, $db;

// Load traductions files requiredby by page
$langs->loadLangs(array("mymodule@flightballoon","other"));

// Get parameters
$id			= GETPOST('id', 'int');
$action		= GETPOST('action', 'alpha');
$cancel     = GETPOST('cancel', 'aZ09');
$backtopage = GETPOST('backtopage', 'alpha');

// Initialize technical objects
$object=new Bbc_ballons($db);
$extrafields = new ExtraFields($db);
$hookmanager->initHooks(array('llx_bbc_ballonscard'));     // Note that conf->hooks_modules contains array
// Fetch optionals attributes and labels
$extralabels = $extrafields->fetch_name_optionals_label('llx_bbc_ballons');
$search_array_options=$extrafields->getOptionalsFromPost($extralabels,'','search_');

// Initialize array of search criterias
$search_all=trim(GETPOST("search_all",'alpha'));
$search=array();
foreach($object->fields as $key => $val)
{
	if (GETPOST('search_'.$key,'alpha')) $search[$key]=GETPOST('search_'.$key,'alpha');
}

if (empty($action) && empty($id) && empty($ref)) $action='view';

// Protection if external user
if ($user->societe_id > 0)
{
	//accessforbidden();
}

// fetch optionals attributes and labels
$extralabels = $extrafields->fetch_name_optionals_label($object->getTableName());

// Load object
include DOL_DOCUMENT_ROOT.'/core/actions_fetchobject.inc.php'; // Must be include, not include_once  // Must be include, not include_once. Include fetch and fetch_thirdparty but not fetch_optionals


/*
 * ACTIONS
 *
 * Put here all code to do according to value of "action" parameter
 */

$parameters=array();
$reshook=$hookmanager->executeHooks('doActions',$parameters,$object,$action);    // Note that $action and $object may have been modified by some hooks
if ($reshook < 0) {
	setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');
}

if (empty($reshook))
{
	$error=0;

	if ($cancel)
	{
		if ($action != 'addlink')
		{
			$urltogo=$backtopage?$backtopage:dol_buildpath('/flightbaloon/list.php',1);
			header("Location: ".$urltogo);
			exit;
		}
		if ($id > 0 || ! empty($ref)) {
			$ret = $object->fetch($id);
		}
		$action='';
	}

	// Action to add record
	if ($action == 'add' && ! empty($user->rights->bal->add))
	{
		foreach ($object->fields as $key => $val)
		{
			if (in_array($key, array('rowid', 'entity', 'date_creation', 'tms', 'import_key'))) continue;	// Ignore special fields

			$object->$key=GETPOST($key,'alpha');
			if ($val['notnull'] && $object->$key == '')
			{
				$error++;
				setEventMessages($langs->trans("ErrorFieldRequired",$langs->transnoentitiesnoconv($val['label'])), null, 'errors');
			}
		}

		if (! $error)
		{
			$result=$object->create($user);
			if ($result > 0)
			{
				// Creation OK
				$urltogo=$backtopage?$backtopage:dol_buildpath('/flightballoon/list.php',1);
				header("Location: ".$urltogo);
				exit;
			} else
			{
				// Creation KO
				if (! empty($object->errors)) {
					setEventMessages(null, $object->errors, 'errors');
				} else {
					setEventMessages($object->error, null, 'errors');
				}
				$action='create';
			}
		} else
		{
			$action='create';
		}
	}

	// Action to update record
	if ($action == 'update' && ! empty($user->rights->hello->create))
	{
		foreach ($object->fields as $key => $val)
		{
			$object->$key=GETPOST($key,'alpha');
			if (in_array($key, array('rowid', 'entity', 'date_creation', 'tms', 'import_key'))) continue;
			if ($val['notnull'] && $object->$key == '')
			{
				$error++;
				setEventMessages($langs->trans("ErrorFieldRequired",$langs->transnoentitiesnoconv($val['label'])), null, 'errors');
			}
		}

		if (! $error)
		{
			$result=$object->update($user);
			if ($result > 0)
			{
				$action='view';
			} else
			{
				// Creation KO
				if (! empty($object->errors)) {
					setEventMessages(null, $object->errors, 'errors');
				} else {
					setEventMessages($object->error, null, 'errors');
				}
				$action='edit';
			}
		} else
		{
			$action='edit';
		}
	}

	// Action to delete
	if ($action == 'confirm_delete' && ! empty($user->rights->hello->delete))
	{
		$result=$object->delete($user);
		if ($result > 0)
		{
			// Delete OK
			setEventMessages("RecordDeleted", null, 'mesgs');
			header("Location: ".dol_buildpath('/hello/llx_bbc_ballons_list.php',1));
			exit;
		} else
		{
			if (! empty($object->errors)) {
				setEventMessages(null, $object->errors, 'errors');
			} else {
				setEventMessages($object->error, null, 'errors');
			}
		}
	}
}




/*
 * VIEW
 *
 * Put here all code to build page
 */

$form = new Form($db);

llxHeader('', sprintf('Ballon - %s', $object->getImmatriculation()), '');


// Part to create
if ($action == 'create')
{
	print load_fiche_titre($langs->trans("Balloon", $langs->transnoentitiesnoconv("llx_bbc_ballons")));

	print '<form method="POST" action="'.$_SERVER["PHP_SELF"].'">';
	print '<input type="hidden" name="token" value="'.$_SESSION['newtoken'].'">';
	print '<input type="hidden" name="action" value="add">';
	print '<input type="hidden" name="backtopage" value="'.$backtopage.'">';

	dol_fiche_head(array(), '');

	print '<table class="border centpercent">'."\n";
	foreach($object->fields as $key => $val)
	{
		if (in_array($key, array('rowid', 'entity', 'date_creation', 'tms', 'import_key'))) continue;
		print '<tr><td';
		print ' class="titlefieldcreate';
		if ($val['notnull']) print ' fieldrequired';
		print '"';
		print '>'.$langs->trans($val['label']).'</td><td><input class="flat" type="text" name="'.$key.'" value="'.(GETPOST($key,'alpha')?GETPOST($key,'alpha'):'').'"></td></tr>';
	}
	print '</table>'."\n";

	dol_fiche_end();

	print '<div class="center"><input type="submit" class="button" name="add" value="'.dol_escape_htmltag($langs->trans("Create")).'"> &nbsp; <input type="submit" class="button" name="cancel" value="'.dol_escape_htmltag($langs->trans("Cancel")).'"></div>';

	print '</form>';
}



// Part to edit record
if (($id || $ref) && $action == 'edit')
{
	print load_fiche_titre($langs->trans("hello"));

	print '<form method="POST" action="'.$_SERVER["PHP_SELF"].'">';
	print '<input type="hidden" name="action" value="update">';
	print '<input type="hidden" name="backtopage" value="'.$backtopage.'">';
	print '<input type="hidden" name="id" value="'.$object->id.'">';

	dol_fiche_head();

	print '<table class="border centpercent">'."\n";
	// print '<tr><td class="fieldrequired">'.$langs->trans("Label").'</td><td><input class="flat" type="text" size="36" name="label" value="'.$label.'"></td></tr>';
	// LIST_OF_TD_LABEL_FIELDS_EDIT
	print '</table>';

	dol_fiche_end();

	print '<div class="center"><input type="submit" class="button" name="save" value="'.$langs->trans("Save").'">';
	print ' &nbsp; <input type="submit" class="button" name="cancel" value="'.$langs->trans("Cancel").'">';
	print '</div>';

	print '</form>';
}



// Part to show record
if ($object->id>0 && (empty($action) || ($action != 'edit' && $action != 'create')))
{
	$res = $object->fetch_optionals($object->id, $extralabels);

	$head = balloonPrepareHead($object);
	dol_fiche_head($head, 'order', $langs->trans("CustomerOrder"), -1, 'order');

	$formconfirm = '';

	// Confirmation to delete
	if ($action == 'delete') {
		$formconfirm = $form->formconfirm($_SERVER["PHP_SELF"] . '?id=' . $object->id, $langs->trans('DeleteOrder'), $langs->trans('ConfirmDeleteOrder'), 'confirm_delete', '', 0, 1);
	}

	// Confirmation of action xxxx
	if ($action == 'xxx')
	{
		$formquestion=array();
		/*
	        $formquestion = array(
	            // 'text' => $langs->trans("ConfirmClone"),
	            // array('type' => 'checkbox', 'name' => 'clone_content', 'label' => $langs->trans("CloneMainAttributes"), 'value' => 1),
	            // array('type' => 'checkbox', 'name' => 'update_prices', 'label' => $langs->trans("PuttingPricesUpToDate"), 'value' => 1),
	            // array('type' => 'other',    'name' => 'idwarehouse',   'label' => $langs->trans("SelectWarehouseForStockDecrease"), 'value' => $formproduct->selectWarehouses(GETPOST('idwarehouse')?GETPOST('idwarehouse'):'ifone', 'idwarehouse', '', 1)));
	    }*/
		$formconfirm = $form->formconfirm($_SERVER["PHP_SELF"] . '?id=' . $object->id, $langs->trans('XXX'), $text, 'confirm_xxx', $formquestion, 0, 1, 220);
	}

	if (! $formconfirm) {
		$parameters = array('lineid' => $lineid);
		$reshook = $hookmanager->executeHooks('formConfirm', $parameters, $object, $action); // Note that $action and $object may have been modified by hook
		if (empty($reshook)) $formconfirm.=$hookmanager->resPrint;
		elseif ($reshook > 0) $formconfirm=$hookmanager->resPrint;
	}

	// Print form confirm
	print $formconfirm;



	// Object card
	// ------------------------------------------------------------

	$linkback = '<a href="'.DOL_URL_ROOT.'/flightballoon/list.php">'.$langs->trans("BackToList").'</a>';


	$morehtmlref = '<div class="refidno">';
	$morehtmlref .= '</div>';


	dol_banner_tab($object, 'ref', $linkback, 1, 'ref', 'ref', $morehtmlref);


	print '<div class="fichecenter">';
	print '<div class="fichehalfleft">';
	print '<div class="underbanner clearboth"></div>';
	print '<table class="border centpercent">'."\n";
	// print '<tr><td class="fieldrequired">'.$langs->trans("Label").'</td><td>'.$object->label.'</td></tr>';
	// LIST_OF_TD_LABEL_FIELDS_VIEW


	// Other attributes
	include DOL_DOCUMENT_ROOT.'/core/tpl/extrafields_view.tpl.php';

	print '</table>';
	print '</div>';
	print '<div class="fichehalfright">';
	print '<div class="ficheaddleft">';
	print '<div class="underbanner clearboth"></div>';
	print '<table class="border centpercent">';
	print '</table>';
	print '</div>';
	print '</div>';
	print '</div>';

	print '<div class="clearboth"></div><br>';

	dol_fiche_end();


	// Buttons for actions
	if ($action != 'presend' && $action != 'editline') {
		print '<div class="tabsAction">'."\n";
		$parameters=array();
		$reshook=$hookmanager->executeHooks('addMoreActionsButtons',$parameters,$object,$action);    // Note that $action and $object may have been modified by hook
		if ($reshook < 0) setEventMessages($hookmanager->error, $hookmanager->errors, 'errors');

		if (empty($reshook))
		{
			// Send
			print '<div class="inline-block divButAction"><a class="butAction" href="' . $_SERVER["PHP_SELF"] . '?id=' . $object->id . '&action=presend&mode=init#formmailbeforetitle">' . $langs->trans('SendByMail') . '</a></div>'."\n";

			if ($user->rights->hello->write)
			{
				print '<div class="inline-block divButAction"><a class="butAction" href="'.$_SERVER["PHP_SELF"].'?id='.$object->id.'&amp;action=edit">'.$langs->trans("Modify").'</a></div>'."\n";
			}

			if ($user->rights->hello->delete)
			{
				print '<div class="inline-block divButAction"><a class="butActionDelete" href="'.$_SERVER["PHP_SELF"].'?id='.$object->id.'&amp;action=delete">'.$langs->trans('Delete').'</a></div>'."\n";
			}
		}
		print '</div>'."\n";
	}


	// Select mail models is same action as presend
	if (GETPOST('modelselected')) {
		$action = 'presend';
	}

	if ($action != 'presend')
	{
		print '<div class="fichecenter"><div class="fichehalfleft">';
		print '<a name="builddoc"></a>'; // ancre
		// Documents
		$comref = dol_sanitizeFileName($object->ref);
		$relativepath = $comref . '/' . $comref . '.pdf';
		$filedir = $conf->hello->dir_output . '/' . $comref;
		$urlsource = $_SERVER["PHP_SELF"] . "?id=" . $object->id;
		$genallowed = $user->rights->hello->creer;
		$delallowed = $user->rights->hello->supprimer;
		print $formfile->showdocuments('hello', $comref, $filedir, $urlsource, $genallowed, $delallowed, $object->modelpdf, 1, 0, 0, 28, 0, '', '', '', $soc->default_lang);


		// Show links to link elements
		$linktoelem = $form->showLinkToObjectBlock($object, null, array('order'));
		$somethingshown = $form->showLinkedObjectBlock($object, $linktoelem);


		print '</div><div class="fichehalfright"><div class="ficheaddleft">';

		// List of actions on element
		include_once DOL_DOCUMENT_ROOT . '/core/class/html.formactions.class.php';
		$formactions = new FormActions($db);
		$somethingshown = $formactions->showactions($object, 'order', $socid);

		print '</div></div></div>';
	}
}


// End of page
llxFooter();
$db->close();
