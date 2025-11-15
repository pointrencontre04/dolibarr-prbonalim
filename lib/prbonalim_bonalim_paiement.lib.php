<?php
/* Copyright (C) 2025		SuperAdmin
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 */

/**
 * \file    lib/prbonalim_bonalim_paiement.lib.php
 * \ingroup prbonalim
 * \brief   Library files with common functions for BonAlim_Paiement
 */

/**
 * Prepare array of tabs for BonAlim_Paiement
 *
 * @param	BonAlim_Paiement	$object					BonAlim_Paiement
 * @return 	array<array{string,string,string}>	Array of tabs
 */
function bonalim_paiementPrepareHead($object)
{
	global $db, $langs, $conf;

	$langs->load("prbonalim@prbonalim");

	$showtabofpagenote = 1;
	$showtabofpagedocument = 1;
	$showtabofpageagenda = 1;

	$h = 0;
	$head = array();

	$head[$h][0] = dol_buildpath("/prbonalim/bonalim_paiement_card.php", 1).'?id='.$object->id;
	$head[$h][1] = $langs->trans("BonAlim_Paiement");
	$head[$h][2] = 'card';
	$h++;

	if ($showtabofpagenote) {
		if (isset($object->fields['note_public']) || isset($object->fields['note_private'])) {
			$nbNote = 0;
			if (!empty($object->note_private)) {
				$nbNote++;
			}
			if (!empty($object->note_public)) {
				$nbNote++;
			}
			$head[$h][0] = dol_buildpath('/prbonalim/bonalim_paiement_note.php', 1).'?id='.$object->id;
			$head[$h][1] = $langs->trans('Notes');
			if ($nbNote > 0) {
				$head[$h][1] .= (!getDolGlobalInt('MAIN_OPTIMIZEFORTEXTBROWSER') ? '<span class="badge marginleftonlyshort">'.$nbNote.'</span>' : '');
			}
			$head[$h][2] = 'note';
			$h++;
		}
	}

	if ($showtabofpagedocument) {
		require_once DOL_DOCUMENT_ROOT.'/core/lib/files.lib.php';
		require_once DOL_DOCUMENT_ROOT.'/core/class/link.class.php';
		$upload_dir = $conf->prbonalim->dir_output."/bonalim_paiement/".dol_sanitizeFileName($object->ref);
		$nbFiles = count(dol_dir_list($upload_dir, 'files', 0, '', '(\.meta|_preview.*\.png)$'));
		$nbLinks = Link::count($db, $object->element, $object->id);
		$head[$h][0] = dol_buildpath("/prbonalim/bonalim_paiement_document.php", 1).'?id='.$object->id;
		$head[$h][1] = $langs->trans('Documents');
		if (($nbFiles + $nbLinks) > 0) {
			$head[$h][1] .= '<span class="badge marginleftonlyshort">'.($nbFiles + $nbLinks).'</span>';
		}
		$head[$h][2] = 'document';
		$h++;
	}

	if ($showtabofpageagenda) {
		$head[$h][0] = dol_buildpath("/prbonalim/bonalim_paiement_agenda.php", 1).'?id='.$object->id;
		$head[$h][1] = $langs->trans("Events");
		$head[$h][2] = 'agenda';
		$h++;
	}

	// Show more tabs from modules
	// Entries must be declared in modules descriptor with line
	//$this->tabs = array(
	//	'entity:+tabname:Title:@prbonalim:/prbonalim/mypage.php?id=__ID__'
	//); // to add new tab
	//$this->tabs = array(
	//	'entity:-tabname:Title:@prbonalim:/prbonalim/mypage.php?id=__ID__'
	//); // to remove a tab
	complete_head_from_modules($conf, $langs, $object, $head, $h, 'bonalim_paiement@prbonalim');

	complete_head_from_modules($conf, $langs, $object, $head, $h, 'bonalim_paiement@prbonalim', 'remove');

	return $head;
}
