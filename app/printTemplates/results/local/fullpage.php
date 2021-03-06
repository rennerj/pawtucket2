<?php
/* ----------------------------------------------------------------------
 * app/templates/checklist.php
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2014 Whirl-i-Gig
 *
 * For more information visit http://www.CollectiveAccess.org
 *
 * This program is free software; you may redistribute it and/or modify it under
 * the terms of the provided license as published by Whirl-i-Gig
 *
 * CollectiveAccess is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTIES whatsoever, including any implied warranty of 
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  
 *
 * This source code is free and modifiable under the terms of 
 * GNU General Public License. (http://www.gnu.org/copyleft/gpl.html). See
 * the "license.txt" file for details, or visit the CollectiveAccess web site at
 * http://www.CollectiveAccess.org
 *
 * -=-=-=-=-=- CUT HERE -=-=-=-=-=-
 * Template configuration:
 *
 * @name Full page
 * @type page
 * @pageSize letter
 * @pageOrientation portrait
 * @tables ca_objects
 *
 * ----------------------------------------------------------------------
 */

	$t_display				= $this->getVar('t_display');
	$va_display_list 		= $this->getVar('display_list');
	$vo_result 				= $this->getVar('result');
	$vn_items_per_page 		= $this->getVar('current_items_per_page');
	$vs_current_sort 		= $this->getVar('current_sort');
	$vs_default_action		= $this->getVar('default_action');
	$vo_ar					= $this->getVar('access_restrictions');
	$vo_result_context 		= $this->getVar('result_context');
	$vn_num_items			= (int)$vo_result->numHits();
	
	$vn_start 				= 0;

	print $this->render("pdfStart.php");
	print $this->render("fullheader.php");
	print $this->render("../footer.php");
?>
		<div id='body fullpage'>
<?php
		$vo_result->seek(0);
		while($vo_result->nextHit()) {
?>
			<div class="representationList">
<?php		
			print $vo_result->get('ca_object_representations.media.page', array('scaleCSSWidthTo' => '400px', 'scaleCSSHeightTo' => '400px'));
?>
			</div>
			<div class='tombstone'>
<?php	
			print "<div>".$vo_result->get('ca_entities.preferred_labels', array('restrictToRelationshipTypes' => array('artist')))."</div>";
			print "<div><i>".$vo_result->get('ca_objects.preferred_labels')."</i>, ".$vo_result->get('ca_objects.creation_date')."</div>";
			print "<div>".$vo_result->get('ca_objects.medium')."</div>"; 	
			print "<div>".$vo_result->get('ca_objects.dimensions.display_dimensions')."</div>"; 				
			if ($vo_result->get('ca_objects.edition.edition_number') || $vo_result->get('ca_objects.edition.ap_number')) {
				print "<span>Edition </span>";
			}							
			if ($vo_result->get('ca_objects.edition.edition_number')) {
				print "<div style='display:inline;'>".$vo_result->get('ca_objects.edition.edition_number')." / ".$vo_result->get('ca_objects.edition.edition_total')."</div>"; 	
			}
			if ($vo_result->get('ca_objects.edition.ap_number')) {
				print "<div style='display:inline;'>".$vo_result->get('ca_objects.edition.ap_number')." / ".$vo_result->get('ca_objects.edition.ap_total')."</div>"; 	
			}	
			if ($this->request->user->hasUserRole("founder") || $this->request->user->hasUserRole("supercurator")){
				print "<div>".$vo_result->get('ca_objects.idno')."</div>";
				if ($vo_result->get('is_deaccessioned') && ($vo_result->get('deaccession_date', array('getDirectDate' => true)) <= caDateToHistoricTimestamp(_t('now')))) {
					print "<div style='font-style:italic; font-size:10px; color:red;'>"._t('Deaccessioned %1', $vo_result->get('deaccession_date'))."</div>\n";
				}	 
			}
?>	
			</div>
<?php
			if (!$vo_result->isLastHit()) {
?>
			<div class="pageBreak">&nbsp;</div>
<?php
			}
		}
?>			
		</div>
<?php
		
	print $this->render("../pdfEnd.php");
?>