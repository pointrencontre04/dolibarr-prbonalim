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
 *  \file       htdocs/prbonalim/class/actions_prbonalim.class.php
 *  \ingroup    prbonalim
 *  \brief      Hook overload for module PRBonAlim
 */

/**
 *	Class ActionsPRBonAlim
 */
class ActionsPRBonAlim
{
	/**
	 * @var DoliDB Database handler.
	 */
	public $db;

	/**
	 * @var string Error code (or message)
	 */
	public $error = '';

	/**
	 * @var string[] Errors
	 */
	public $errors = array();

	/**
	 * @var mixed[] Hook results. Propagated to $hookmanager->resArray for later reuse
	 */
	public $results = array();

	/**
	 * @var string String displayed by executeHook() immediately after return
	 */
	public $resprints;

	/**
	 * Constructor
	 *
	 *  @param	DoliDB	$db	Database handler
	 */
	public function __construct($db)
	{
		$this->db = $db;
	}

	/**
	 * Move BonAlim links (issuer, beneficiary) from the merged thirdparty to the kept one.
	 * Called by Societe::mergeCompany() inside its transaction, before the origin thirdparty is deleted.
	 *
	 * @param	array<string,mixed>	$parameters	Hook parameters (soc_origin, soc_dest)
	 * @param	CommonObject		$object		Thirdparty kept
	 * @param	string				$action		Current action
	 * @param	HookManager			$hookmanager	Hook manager
	 * @return	int								0 if OK, <0 if KO
	 */
	public function replaceThirdparty($parameters, &$object, &$action, $hookmanager)
	{
		$origin_id = (int) $parameters['soc_origin'];
		$dest_id = (int) $parameters['soc_dest'];

		if ($origin_id <= 0 || $dest_id <= 0) {
			return 0;
		}

		foreach (array('issuer', 'beneficiary') as $field) {
			$sql = "UPDATE ".$this->db->prefix()."prbonalim_bonalim";
			$sql .= " SET ".$field." = ".$dest_id;
			$sql .= " WHERE ".$field." = ".$origin_id;

			if (!$this->db->query($sql)) {
				$this->error = $this->db->lasterror();
				$this->errors[] = $this->error;
				return -1;
			}
		}

		return 0;
	}
}
