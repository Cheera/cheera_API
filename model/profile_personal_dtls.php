<?php

require_once 'model/model.php';
/**
 * User Model
*/
class profile_personal_dtls extends model {

	protected static $tableName = 'CH_REGISTER_PROFILE_PERSONAL_DTLS';
	protected static $primaryKey = 'PROFILE_ID';

	function setProfileId($value){
		$this->setColumnValue('PROFILE_ID', $value);
	}
	function getProfileId(){
		return $this->getColumnValue('PROFILE_ID');
	}
	
	function setProfileCreatedBy($value){
		$this->setColumnValue('PROFILE_CREATED_BY', $value);
	}
	function getProfileCreatedBy(){
		return $this->getColumnValue('PROFILE_CREATED_BY');
	}

	function setPhysicalStatus($value){
		$this->setColumnValue('PHYSICAL_STATUS', $value);
	}
	function getPhysicalStatus(){
		return $this->getColumnValue('PHYSICAL_STATUS');
	}

	function setDateOfBIrth($value){
		$this->setColumnValue('DATE_OF_BIRTH', $value);
	}
	function getDateOfBIrth(){
		return $this->getColumnValue('DATE_OF_BIRTH');
	}

	function setAge($value){
		$this->setColumnValue('AGE', $value);
	}
	function getAge(){
		return $this->getColumnValue('AGE');
	}

	function setHeightInCm($value){
		$this->setColumnValue('HEIGHT_IN_CM', $value);
	}
	function getHeightInCm(){
		return $this->getColumnValue('HEIGHT_IN_CM');
	}
	function setComplexion($value){
		$this->setColumnValue('COMPLEXION', $value);
	}
	function getComplexion(){
		return $this->getColumnValue('COMPLEXION');
	}
	function setMotherTounge($value){
		$this->setColumnValue('MOTHER_TOUNGE', $value);
	}
	function getMotherTounge(){
		return $this->getColumnValue('MOTHER_TOUNGE');
	}
	function setAboutMyself($value){
		$this->setColumnValue('ABOUT_MYSELF', $value);
	}
	function getAboutMyself(){
		return $this->getColumnValue('ABOUT_MYSELF');
	}
	function setLastOpuser($value){
		$this->setColumnValue('LAST_OP_USER_NAME', $value);
	}
	function getLastOpUser(){
		return $this->getColumnValue('LAST_OP_USER_NAME');
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