<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): JoForce.com
 *************************************************************************************/

class Potentials_ConvertPotential_View extends Head_Index_View {

	function checkPermission(Head_Request $request) {
		$moduleName = $request->getModule();
		$moduleModel = Head_Module_Model::getInstance($moduleName);
		$projectModuleModel = Head_Module_Model::getInstance('Project');

		$currentUserModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		if(!$currentUserModel->hasModuleActionPermission($projectModuleModel->getId(), 'CreateView')) {
			throw new AppException(vtranslate('LBL_PERMISSION_DENIED', $moduleName));
		}
	}

	function process(Head_Request $request) {
		$currentUserPriviligeModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();

		$viewer = $this->getViewer($request);
		$recordId = $request->get('record');
		$moduleName = $request->getModule();

		$recordModel = Head_Record_Model::getInstanceById($recordId);
		$moduleModel = $recordModel->getModule();

		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
		$viewer->assign('CURRENT_USER_PRIVILEGE', $currentUserPriviligeModel);
		$viewer->assign('RECORD', $recordModel);
		$viewer->assign('CONVERT_POTENTIAL_FIELDS', $recordModel->getConvertPotentialFields());

		$assignedToFieldModel = $moduleModel->getField('assigned_user_id');
		$assignedToFieldModel->set('fieldvalue', $recordModel->get('assigned_user_id'));
		$viewer->assign('ASSIGN_TO', $assignedToFieldModel);

		$viewer->view('ConvertPotential.tpl', $moduleName);
	}
}