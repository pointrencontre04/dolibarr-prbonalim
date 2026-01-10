<?php
/* Copyright (C) 2010-2013	Regis Houssin		<regis.houssin@inodbox.com>
 * Copyright (C) 2010-2011	Laurent Destailleur	<eldy@users.sourceforge.net>
 * Copyright (C) 2012-2013	Christophe Battarel	<christophe.battarel@altairis.fr>
 * Copyright (C) 2012       Cédric Salvador     <csalvador@gpcsolutions.fr>
 * Copyright (C) 2012-2014  Raphaël Doursenaud  <rdoursenaud@gpcsolutions.fr>
 * Copyright (C) 2013		Florian Henry		<florian.henry@open-concept.pro>
 * Copyright (C) 2017		Juanjo Menent		<jmenent@2byte.es>
 * Copyright (C) 2022		OpenDSI				<support@open-dsi.fr>
 * Copyright (C) 2024		MDW					<mdeweerd@users.noreply.github.com>
 * Copyright (C) 2024       Alexandre Spangaro  <alexandre@inovea-conseil.com>
 * Copyright (C) 2024       Frédéric France		  <frederic.france@free.fr>
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
 * Need to have the following variables defined:
 * $object (invoice, order, ...)
 * $conf
 * $langs
 * $dateSelector
 * $forceall (0 by default, 1 for supplier invoices/orders)
 * $element     (used to test $user->rights->$element->creer)
 * $permtoedit  (used to replace test $user->rights->$element->creer)
 * $senderissupplier (0 by default, 1 for supplier invoices/orders)
 * $inputalsopricewithtax (0 by default, 1 to also show column with unit price including tax)
 * $outputalsopricetotalwithtax
 * $usemargins (0 to disable all margins columns, 1 to show according to margin setup)
 * $disableedit, $disablemove, $disableremove
 *
 * $text, $description, $line
 */
/**
 * @var CommonObject $object
 * @var CommonObject $this
 * @var CommonObjectLine $line
 * @var Conf $conf
 * @var Form $form
 * @var HookManager $hookmanager
 * @var ?Product $product_static
 * @var Societe $mysoc
 * @var Translate $langs
 * @var User $user
 *
 * @var string $action
 * @var int $i
 * @var 0|1 $forceall
 * @var int $num
 * @var 0|1 $senderissupplier
 * @var string $text
 * @var string $description
 */
// Protection to avoid direct call of template
if (empty($object) || !is_object($object)) {
	print "Error, template page can't be called as URL";
	exit(1);
}

'
@phan-var-force PropaleLigne|ContratLigne|CommonObjectLine|CommonInvoiceLine|CommonOrderLine|ExpeditionLigne|DeliveryLine|FactureFournisseurLigneRec|SupplierInvoiceLine|SupplierProposalLine $line
@phan-var-force CommonObject $this
@phan-var-force Propal|Contrat|Commande|Facture|Expedition|Delivery|FactureFournisseur|FactureFournisseur|SupplierProposal $object
@phan-var-force 0|1 $forceall
@phan-var-force int $num
@phan-var-force ?Product $product_static
@phan-var-force string $text
@phan-var-force string $description
';

global $mysoc;
global $forceall, $senderissupplier, $inputalsopricewithtax, $outputalsopricetotalwithtax;

$usemargins = 0;
if (isModEnabled('margin') && !empty($object->element) && in_array($object->element, array('facture', 'facturerec', 'propal', 'commande'))) {
	$usemargins = 1;
}

if (empty($dateSelector)) {
	$dateSelector = 0;
}
if (empty($forceall)) {
	$forceall = 0;
}
if (empty($senderissupplier)) {
	$senderissupplier = 0;
}
if (empty($inputalsopricewithtax)) {
	$inputalsopricewithtax = 0;
}
if (empty($outputalsopricetotalwithtax)) {
	$outputalsopricetotalwithtax = 0;
}

// add html5 elements

$coldisplay = 0;
?>
<!-- BEGIN PHP TEMPLATE objectline_view.tpl.php -->
<tr id="row-<?php print $line->id?>" class="drag drop oddeven">

<?php if (getDolGlobalString('MAIN_VIEW_LINE_NUMBER')) { ?>
	<td class="linecolnum center"><span class="opacitymedium"><?php $coldisplay++; ?><?php print($i + 1); ?></span></td>
<?php } ?>

<td class="linecolref"><?php $coldisplay++; ?><?php print $line->ref; ?></td>

<td class="linecoldate"><?php $coldisplay++; ?><?php print dol_print_date($line->date_creation, '%d/%m/%Y'); ?></td>

<?php
global $db;
$invoice = new Facture($db);
$invoice->fetch($line->fk_invoice);
?>
<td class="linecolinvoice"><?php $coldisplay++; ?><?php print $invoice->getNomUrl(); ?></td>

<td class="linecolttc nowrap right"><?php $coldisplay++; ?><?php print price($line->amount); ?></td>

</tr>

<!-- END PHP TEMPLATE objectline_view.tpl.php -->
