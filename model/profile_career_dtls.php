<?php

require_once 'model/model.php';
/**
 * User Model
*/
class profile_career_dtls extends model {

	protected static $tableName = 'CH_REGISTER_PROFILE_CAREER_DTLS';
	protected static $primaryKey = 'PROFILE_ID';

	function setProfileId($value){
		$this->setColumnValue('PROFILE_ID', $value);
	}
	function getProfileId(){
		return $this->getColumnValue('PROFILE_ID');
	}
	
	function setEducation($value){
		$this->setColumnValue('EDUCATION', $value);
	}
	function getEducation(){
		return $this->getColumnValue('EDUCATION');
	}

	function setSpecialization($value){
		$this->setColumnValue('SPECIALISATION', $value);
	}
	function getSpecialization(){
		return $this->getColumnValue('SPECIALISATION');
	}
	

	function setEmployedIn($value){
		$this->setColumnValue('EMPLOYED_IN', $value);
	}
	function getEmployedIn(){
		return $this->getColumnValue('EMPLOYED_IN');
	}
	

	function setNameOfEmployer($value){
		$this->setColumnValue('NAME_OF_EMPLOYER', $value);
	}
	function getNameOfEmployer(){
		return $this->getColumnValue('NAME_OF_EMPLOYER');
	}

	function setAnnualIncome($value){
		$this->setColumnValue('ANNUAL_INCOME', $value);
	}
	function getAnnualIncome(){
		return $this->getColumnValue('ANNUAL_INCOME');
	}

	function setJobNamePosition($value){
		$this->setColumnValue('JOB_NAME_POSITION', $value);
	}
	function getJobNamePosition(){
		return $this->getColumnValue('JOB_NAME_POSITION');
	}
	function setLastOpuser($value){
		$this->setColumnValue('LAST_OP_USER_NAME', $value);
	}
	function getLastOpUser(){
		return $this->getColumnValue('LAST_OP_USER_NAME');
	}
}

?>