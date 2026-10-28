<?php
/* Copyright (C) 2025		SuperAdmin
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
 * along with this program. If not, see <https://www.gnu.org/licenses/>.
 */

/**
 *	\file       prbonalim/bonalim_help.php
 *	\ingroup    prbonalim
 *	\brief      User help pages of prbonalim, rendered from doc/help-page-la_LA.md
 */

// Load Dolibarr environment
$res = 0;
// Try main.inc.php into web root known defined into CONTEXT_DOCUMENT_ROOT (not always defined)
if (!$res && !empty($_SERVER["CONTEXT_DOCUMENT_ROOT"])) {
	$res = @include $_SERVER["CONTEXT_DOCUMENT_ROOT"]."/main.inc.php";
}
// Try main.inc.php into web root detected using web root calculated from SCRIPT_FILENAME
$tmp = empty($_SERVER['SCRIPT_FILENAME']) ? '' : $_SERVER['SCRIPT_FILENAME'];
$tmp2 = realpath(__FILE__);
$i = strlen($tmp) - 1;
$j = strlen($tmp2) - 1;
while ($i > 0 && $j > 0 && isset($tmp[$i]) && isset($tmp2[$j]) && $tmp[$i] == $tmp2[$j]) {
	$i--;
	$j--;
}
if (!$res && $i > 0 && file_exists(substr($tmp, 0, ($i + 1))."/main.inc.php")) {
	$res = @include substr($tmp, 0, ($i + 1))."/main.inc.php";
}
if (!$res && $i > 0 && file_exists(dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php")) {
	$res = @include dirname(substr($tmp, 0, ($i + 1)))."/main.inc.php";
}
// Try main.inc.php using relative path
if (!$res && file_exists("../main.inc.php")) {
	$res = @include "../main.inc.php";
}
if (!$res && file_exists("../../main.inc.php")) {
	$res = @include "../../main.inc.php";
}
if (!$res && file_exists("../../../main.inc.php")) {
	$res = @include "../../../main.inc.php";
}
if (!$res) {
	die("Include of main fails");
}

require_once DOL_DOCUMENT_ROOT.'/core/lib/files.lib.php';
require_once DOL_DOCUMENT_ROOT.'/core/lib/parsemd.lib.php';

/**
 * @var Conf $conf
 * @var DoliDB $db
 * @var HookManager $hookmanager
 * @var Translate $langs
 * @var User $user
 */

// Load translation files required by the page
$langs->loadLangs(array("prbonalim@prbonalim"));

// Security check
if (!isModEnabled('prbonalim')) {
	accessforbidden('Module not enabled');
}
if (!$user->hasRight('prbonalim', 'bonalim', 'read')) {
	accessforbidden();
}


/*
 * View
 */

// Only the help pages listed here can be shown (the name is used to build the file path)
$helppage = GETPOST('page', 'aZ09');
if (!in_array($helppage, array('issuer', 'bonalim', 'invoice'))) {
	$helppage = 'issuer';
}

// Same file lookup as DolibarrModules::getDescLong(): help-page-la_LA.md, then help-page-la.md, then help-page.md
$pathoffile = '';
$tmplang = explode('_', $langs->defaultlang);
foreach (array('help-'.$helppage.'-'.$langs->defaultlang.'.md', 'help-'.$helppage.'-'.$tmplang[0].'.md', 'help-'.$helppage.'.md') as $filename) {
	if (dol_is_file(dol_buildpath('/prbonalim/doc/'.$filename, 0))) {
		$pathoffile = dol_buildpath('/prbonalim/doc/'.$filename, 0);
		break;
	}
}

llxHeader("", $langs->trans("PRBonAlimHelp"), '', '', 0, 0, '', '', '', 'mod-prbonalim page-help');

print load_fiche_titre($langs->trans("PRBonAlimHelp"), '', 'prbonalim.png@prbonalim');

if ($pathoffile) {
	$content = file_get_contents($pathoffile, false, null, 0, 1024 * 1024);	// Max size loaded 1Mb
	$content = dolMd2Html(
		$content,
		'parsedown',
		array(
			'doc/' => dol_buildpath('/prbonalim/doc/', 1),
			'img/' => dol_buildpath('/prbonalim/img/', 1),
		)
	);
	print '<div class="moduledesclong">'.$content.'</div>';
} else {
	print '<span class="opacitymedium">'.$langs->trans("PRBonAlimHelpNotFound").'</span>';
}

// End of page
llxFooter();
$db->close();
