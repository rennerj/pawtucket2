<?php
/* ----------------------------------------------------------------------
 * app/controllers/ListController.php : 
 * ----------------------------------------------------------------------
 * CollectiveAccess
 * Open-source collections management software
 * ----------------------------------------------------------------------
 *
 * Software by Whirl-i-Gig (http://www.whirl-i-gig.com)
 * Copyright 2013 Whirl-i-Gig
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
 * ----------------------------------------------------------------------
 */
 	require_once(__CA_MODELS_DIR__."/ca_collections.php");
 	require_once(__CA_MODELS_DIR__."/ca_objects.php");
 	
 	class ListController extends ActionController {
 		# -------------------------------------------------------
 		/**
 		 *
 		 */
 		
 		# -------------------------------------------------------
 		public function __construct(&$po_request, &$po_response, $pa_view_paths=null) {
 			parent::__construct($po_request, $po_response, $pa_view_paths);
 			
 			caSetPageCSSClasses(array("list"));
 		}
 		# -------------------------------------------------------
 		
 		/**
 		 *
 		 */ 
 		public function __call($ps_function, $pa_args) {
 			$ps_function = strtolower($ps_function);
 			$ps_id = $this->request->getActionExtra(); //$this->request->getParameter('id', pString);
 			if (!($vs_class = caUrlNameToTable($ps_function))) {
 				// invalid detail type – throw error
 				die("Invalid list type");
 			}
 			
 			$qr_res = $vs_class::find(array(), array('returnAs' => 'SearchResult'));
 			$this->view->setVar('result', $qr_res);
 			
 			
 			$this->render("Lists/{$vs_class}_html.php");
 		}
 		# -------------------------------------------------------
	}
 ?>