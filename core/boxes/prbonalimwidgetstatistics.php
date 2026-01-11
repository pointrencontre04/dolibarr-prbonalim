<?php
/* Copyright (C) 2004-2017	Laurent Destailleur			<eldy@users.sourceforge.net>
 * Copyright (C) 2018-2024  Frédéric France				<frederic.france@free.fr>
 * Copyright (C) 2026		SuperAdmin
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
 * \file    prbonalim/core/boxes/prbonalimwidgetstatistics.php
 * \ingroup prbonalim
 * \brief   Widget provided by PRBonAlim
 *
 * Put detailed description here.
 */

include_once DOL_DOCUMENT_ROOT."/core/boxes/modules_boxes.php";


/**
 * Class to manage the box
 *
 * Warning: for the box to be detected correctly by dolibarr,
 * the filename should be the lowercase classname
 */
class prbonalimwidgetstatistics extends ModeleBoxes
{
	/**
	 * @var string Alphanumeric ID. Populated by the constructor.
	 */
	public $boxcode = "prbonalimbox";

	/**
	 * @var string Box icon (in configuration page)
	 * Automatically calls the icon named with the corresponding "object_" prefix
	 */
	public $boximg = "prbonalim@prbonalim";

	/**
	 * @var string Box label (in configuration page)
	 */
	public $boxlabel = 'Statistics';

	/**
	 * @var string Box language file if it needs a specific language file.
	 */
	public $lang = 'prbonalim@prbonalim';

	/**
	 * @var string[] Module dependencies
	 */
	public $depends = array('prbonalim');

	/**
	 * @var string 	Widget type ('graph' means the widget is a graph widget)
	 */
	public $widgettype = 'graph';


	/**
	 * Constructor
	 *
	 * @param DoliDB $db Database handler
	 * @param string $param More parameters
	 */
	public function __construct(DoliDB $db, $param = '')
	{
		global $user;

		parent::__construct($db, $param);

		$this->param = $param;

		// Condition when module is enabled or not
		// $this->enabled = getDolGlobalInt('MAIN_FEATURES_LEVEL') > 0;
		// Condition when module is visible by user (test on permission)
		// $this->hidden = !$user->hasRight('prbonalim', 'myobject', 'read');
	}

	/**
	 * Load data into info_box_contents array to show array later. Called by Dolibarr before displaying the box.
	 *
	 * @param	int<0,max>	$max	Maximum number of records to load
	 * @return	void
	 */
	public function loadBox($max = 5)
	{
		global $langs, $db;

		// Use configuration value for max lines count
		$this->max = $max;

		$this->info_box_head = array('text' => $langs->trans("DolibarrStateBoard"));

		dol_include_once("/prbonalim/class/bonalim.class.php");

		$bonalim = new BonAlim($db);
		$keyvals = $bonalim->fields['status']['arrayofkeyval'];

		$stats = array_fill_keys(array_keys($keyvals), 0);

		$sql = 'SELECT status, COUNT(*) as nb FROM ' . MAIN_DB_PREFIX . 'prbonalim_bonalim GROUP BY status';
		$resql = $db->query($sql);

			if ($resql) {
			while ($obj = $db->fetch_object($resql)) {
				if (isset($stats[$obj->status])) {
					$stats[$obj->status] = $obj->nb;
				}
			}
		}

		$boxstatItems = [];

		foreach ($keyvals as $code => $label) {

			$boxstatItem = '';
			$boxstatItem .= '<a href="bonalim_list.php?search_status=' . ((int)$code) . '" class="boxstatsindicator thumbstat nobold nounderline">';
			$boxstatItem .= '<div class="boxstats">';
			$boxstatItem .= '<span class="boxstatstext" title="' . dol_escape_htmltag($langs->trans($label)) . '">' . $langs->trans($label) . '</span><br>';
			$boxstatItem .= '<span class="boxstatsindicator">' . img_object("", $bonalim->picto, 'class="inline-block"') . ' ' . (!empty($stats[$code]) ? $stats[$code] : 0) . '</span>';
			$boxstatItem .= '</div>';
			$boxstatItem .= '</a>';

			$boxstatItems[] = $boxstatItem;
		}

		if (!empty($boxstatItems)) {
			$boxstats = implode('', $boxstatItems);
			$this->info_box_contents[0][0] = [
				'tr' => 'class="nohover"',
				'td' => 'class="tdwidgetstate center"',
				'textnoformat' => $boxstats,
			];
		} else {
			$this->info_box_contents = [];
		}

	}



	/**
	 *	Method to show box.  Called when the box needs to be displayed.
	 *
	 *	@param	?array<array{text?:string,sublink?:string,subtext?:string,subpicto?:?string,picto?:string,nbcol?:int,limit?:int,subclass?:string,graph?:int<0,1>,target?:string}>   $head       Array with properties of box title
	 *	@param	?array<array{tr?:string,td?:string,target?:string,text?:string,text2?:string,textnoformat?:string,tooltip?:string,logo?:string,url?:string,maxlength?:int,asis?:int<0,1>}>   $contents   Array with properties of box lines
	 *	@param	int<0,1>	$nooutput	No print, only return string
	 *	@return	string
	 */
	public function showBox($head = null, $contents = null, $nooutput = 0)
	{
		// You may make your own code here…
		// … or use the parent's class function using the provided head and contents templates
		return parent::showBox($this->info_box_head, $this->info_box_contents, $nooutput);
	}
}
