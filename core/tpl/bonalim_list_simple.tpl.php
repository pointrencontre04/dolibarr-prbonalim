<?php
/* Copyright (C) 2024		Frédéric France			<frederic.france@free.fr>
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
 *
 */

/**
 * @var Conf $conf
 * @var CommonObject[] $objects_list
 * @var Array $arrayfields
 */


// Protection to avoid direct call of template
if (empty($conf) || !is_object($conf)) {
	print "Error, template page can't be called as URL";
	exit(1);
}

print '<div class="">'; // You can use div-table-responsive or div-table-responsive-no-min if you don't need reserved height for your table
print '<table class="tagtable nobottomiftotal noborder liste">'."\n";

// Fields title label
// --------------------------------------------------------------------
print '<tr class="liste_titre">';
foreach ($arrayfields as $key => $val) {
    $cssforfield = (empty($val['csslist']) ? (empty($val['css']) ? '' : $val['css']) : $val['csslist']);
    if ($key == 'status') {
        $cssforfield .= ($cssforfield ? ' ' : '').'center';
    } elseif (in_array($val['type'], array('date', 'datetime', 'timestamp'))) {
        $cssforfield .= ($cssforfield ? ' ' : '').'center';
    } elseif (in_array($val['type'], array('timestamp'))) {
        $cssforfield .= ($cssforfield ? ' ' : '').'nowrap';
    } elseif (in_array($val['type'], array('double(24,8)', 'double(6,3)', 'integer', 'real', 'price')) && !in_array($key, array('id', 'rowid', 'ref', 'status')) && $val['label'] != 'TechnicalID' && empty($val['arrayofkeyval'])) {
        $cssforfield .= ($cssforfield ? ' ' : '').'right';
    }
    $cssforfield = preg_replace('/small\s*/', '', $cssforfield);	// the 'small' css must not be used for the title label
    print getTitleFieldOfList($val['label'], 0, '', '', '', '', ($cssforfield ? 'class="'.$cssforfield.'"' : ''), '', '', ($cssforfield ? $cssforfield.' ' : ''), 1, (empty($val['helplist']) ? '' : $val['helplist']))."\n";
}
// Extra fields
//include DOL_DOCUMENT_ROOT.'/core/tpl/extrafields_list_search_title.tpl.php';
/*
// Hook fields
$parameters = array('arrayfields' => $arrayfields, 'param' => $param, 'sortfield' => $sortfield, 'sortorder' => $sortorder, 'totalarray' => &$totalarray);
$reshook = $hookmanager->executeHooks('printFieldListTitle', $parameters, $object, $action); // Note that $action and $object may have been modified by hook
print $hookmanager->resPrint;
*/

print '<tr data-rowid="'.$object->id.'" class="oddeven">';

// Loop on record
// --------------------------------------------------------------------
foreach ($objects_list as $object) {

    foreach ($arrayfields as $arrayfields_key => $arrayfields_val) {
        $key = $arrayfields_key;
        $val = $object->fields[$arrayfields_key];

        if ($arrayfields_val['enabled']) {

            $cssforfield = (empty($val['csslist']) ? (empty($val['css']) ? '' : $val['css']) : $val['csslist']);
            if (in_array($val['type'], array('date', 'datetime', 'timestamp'))) {
                $cssforfield .= ($cssforfield ? ' ' : '').'center';
            } elseif ($key == 'status') {
                $cssforfield .= ($cssforfield ? ' ' : '').'center';
            }

            if (in_array($val['type'], array('timestamp'))) {
                $cssforfield .= ($cssforfield ? ' ' : '').'nowraponall';
            } elseif ($key == 'ref') {
                $cssforfield .= ($cssforfield ? ' ' : '').'nowraponall';
            }

            if (in_array($val['type'], array('double(24,8)', 'double(6,3)', 'integer', 'real', 'price')) && !in_array($key, array('id', 'rowid', 'ref', 'status')) && empty($val['arrayofkeyval'])) {
                $cssforfield .= ($cssforfield ? ' ' : '').'right';
            }
            //if (in_array($key, array('fk_soc', 'fk_user', 'fk_warehouse'))) $cssforfield = 'tdoverflowmax100';

            print '<td'.($cssforfield ? ' class="'.$cssforfield.((preg_match('/tdoverflow/', $cssforfield) && !in_array($val['type'], array('ip', 'url')) && !is_numeric($object->$key)) ? ' classfortooltip' : '').'"' : '');
            if (preg_match('/tdoverflow/', $cssforfield) && !in_array($val['type'], array('ip', 'url')) && !is_numeric($object->$key) && !in_array($key, array('ref'))) {
                print ' title="'.dol_escape_htmltag($object->$key).'"';
            }
            print '>';
            if ($key == 'status') {
                print $object->getLibStatut(5);
            } elseif ($key == 'rowid') {
                print $object->showOutputField($val, $key, $object->id, '');
            } else {
                print $object->showOutputField($val, $key, $object->$key, '');
            }
            print '</td>';
        }
    }
    // Extra fields
    //include DOL_DOCUMENT_ROOT.'/core/tpl/extrafields_list_print_fields.tpl.php';
    /*
    // Fields from hook
    $parameters = array('arrayfields' => $arrayfields, 'object' => $object, 'obj' => $obj, 'i' => $i, 'totalarray' => &$totalarray);
    $reshook = $hookmanager->executeHooks('printFieldListValue', $parameters, $object, $action); // Note that $action and $object may have been modified by hook
    print $hookmanager->resPrint;
    */

    print '</tr>';
}
print '</table>';
print '</div>';
