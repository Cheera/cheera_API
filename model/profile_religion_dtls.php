<?php

require_once 'model/model.php';
/**
 * User Model
*/
class profile_religion_dtls extends model {

	protected static $tableName = 'CH_REGISTER_PROFILE_RELIGION_DTLS';
	protected static $primaryKey = 'PROFILE_ID';

	function setProfileId($value){
		$this->setColumnValue('PROFILE_ID', $value);
	}
	function getProfileId(){
		return $this->getColumnValue('PROFILE_ID');
	}
	
	function setReligion($value){
		$this->setColumnValue('RELIGION', $value);
	}
	function getReligion(){
		return $this->getColumnValue('RELIGION');
	}

	function setCast($value){
		$this->setColumnValue('CAST', $value);
	}
	function getCast(){
		return $this->getColumnValue('CAST');
	}

	function setStar($value){
		$this->setColumnValue('STAR', $value);
	}
	function getStar(){
		return $this->getColumnValue('STAR');
	}
	
	function setDhosamInHoroscope($value){
		$this->setColumnValue('DOSHAM_IN_HOROSCOPE', $value);
	}
	function getDhosamInHoroscope(){
		return $this->getColumnValue('DOSHAM_IN_HOROSCOPE');
	}

	function setLastOpuser($value){
		$this->setColumnValue('LAST_OP_USER_NAME', $value);
	}
	function getLastOpUser(){
		return $this->getColumnValue('LAST_OP_USER_NAME');
	}
}

?>