<?php

require_once 'model/model.php';
/**
 * User Model
*/
class profile_master extends model {

	protected static $tableName = 'CH_REGISTER_PROFILE_MASTER';
	protected static $primaryKey = 'PROFILE_ID';

	function setFirstName($value){
		$this->setColumnValue('FIRST_NAME', $value);
	}
	function getFirstName(){
		return $this->getColumnValue('FIRST_NAME');
	}

	function setLastName($value){
		$this->setColumnValue('LAST_NAME', $value);
	}
	function getLastName(){
		return $this->getColumnValue('LAST_NAME');
	}

	function setMobileNumber($value){
		$this->setColumnValue('MOBILE_NUMBER', $value);
	}
	function getMobileNumber(){
		return $this->getColumnValue('MOBILE_NUMBER');
	}

	function setEmailId($value){
		$this->setColumnValue('EMAIL_ID', $value);
	}
	function getEmailId(){
		return $this->getColumnValue('EMAIL_ID');
	}

	function setUserName($value){
		$this->setColumnValue('USER_NAME', $value);
	}
	function getUserName(){
		return $this->getColumnValue('USER_NAME');
	}
	function setPassword($value){
		$this->setColumnValue('PASSWORD', $value);
	}
	function getPassword(){
		return $this->getColumnValue('PASSWORD');
	}
	function setGender($value){
		$this->setColumnValue('GENDER', $value);
	}
	function getGender(){
		return $this->getColumnValue('GENDER');
	}
	function setStatus($value){
		$this->setColumnValue('STATUS', $value);
	}
	function getStatus(){
		return $this->getColumnValue('STATUS');
	}
	function setLastOpuser($value){
		$this->setColumnValue('LAST_OP_USER_NAME', $value);
	}
	function getLastOpUser(){
		return $this->getColumnValue('LAST_OP_USER_NAME');
	}
	
	function getProfileId(){
		return $this->getColumnValue('PROFILE_ID');
	}
	
}

/* function __autoload($className){
	$paths = array(
			ROOT."/lib/",
			ROOT."/site/controller/",
			ROOT."/admin/controller/",
			ROOT."/common/",
			ROOT."/common/model/"
	);
	foreach($paths as $path){
		if(file_exists($path.$className.".class.php")){
			require_once($path.$className.".class.php");
			break;
		}
	}
} */

?>