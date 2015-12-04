<?php

require_once 'model/model.php';
/**
 * User Model
*/
class profile_family_dtls extends model {

	protected static $tableName = 'CH_REGISTER_PROFILE_FAMILY_DTLS';
	protected static $primaryKey = 'PROFILE_ID';

	function setProfileId($value){
		$this->setColumnValue('PROFILE_ID', $value);
	}
	function getProfileId(){
		return $this->getColumnValue('PROFILE_ID');
	}
	
	function setFamilyType($value){
		$this->setColumnValue('FAMILY_TYPE', $value);
	}
	function getFamilyType(){
		return $this->getColumnValue('FAMILY_TYPE');
	}

	function setFamilyStatus($value){
		$this->setColumnValue('FAMILY_STATUS', $value);
	}
	function getFamilyStatus(){
		return $this->getColumnValue('FAMILY_STATUS');
	}
	
	function setAboutMyFamily($value){
		$this->setColumnValue('ABOUT_MY_FAMILY', $value);
	}
	function getAboutMyFamily(){
		return $this->getColumnValue('ABOUT_MY_FAMILY');
	}
	
	function setLastOpuser($value){
		$this->setColumnValue('LAST_OP_USER_NAME', $value);
	}
	function getLastOpUser(){
		return $this->getColumnValue('LAST_OP_USER_NAME');
	}
}

?>