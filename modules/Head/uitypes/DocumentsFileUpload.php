<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Contributor(s): JoForce.com
 *************************************************************************************/
class Head_DocumentsFileUpload_UIType extends Head_Base_UIType {
	/**
	 * Function to get the Template name for the current UI Type Object
	 * @return <String> - Template Name
	 */
	public function getTemplateName() {
		return 'uitypes/DocumentsFileUpload.tpl';
	}

	/**
	 * Function to get the Display Value, for the current field type with given DB Insert Value
	 * @param <String> $value
	 * @param <Integer> $recordId
	 * @param <Head_Record_Model>
	 * @return <String>
	 */
	public function getDisplayValue($value, $recordId=false, $recordModel=false) {
        global $site_URL;
		if($recordModel) {
			$fileLocationType = $recordModel->get('filelocationtype');
			$fileStatus = $recordModel->get('filestatus');
			if(!empty($value) && $fileStatus) {
				if($fileLocationType == 'I') {
					$db = PearDatabase::getInstance();
					$fileIdRes = $db->pquery('SELECT attachmentsid FROM jo_seattachmentsrel WHERE crmid = ?', array($recordId));
					$fileId = $db->query_result($fileIdRes, 0, 'attachmentsid');
					if($fileId){
						$value = '<a href="'.$site_URL.'Documents/DownloadFile/'.$recordId.'/'.$fileId.'"'.
									' title="'.	vtranslate('LBL_DOWNLOAD_FILE', 'Documents').'" >'.$value.'</a>';
					}
				} else {
					$value = '<a href="'.$value.'" target="_blank" title="'. vtranslate('LBL_DOWNLOAD_FILE', 'Documents').'" >'.textlength_check($value).'</a>';
				}
			} else{
                $value = textlength_check($value);
            }
		}
		return $value;
	}
}
