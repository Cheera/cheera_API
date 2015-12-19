<?php

require_once 'model/model.php';
/**
 * User Model
*/
class profile_login_auth extends model {

	protected static $tableName = 'CH_LOGIN_AUTH';
	protected static $primaryKey = 'PROFILE_ID';

	function setUserName($value){
		$this->setColumnValue('USER_NAME', $value);
	}
	function getUserName(){
		return $this->getColumnValue('USER_NAME');
	}

	function setProfileId($value){
		$this->setColumnValue('PROFILE_ID', $value);
	}
	function getProfileId(){
		return $this->getColumnValue('PROFILE_ID');
	}

	function setLoginTime($value){
		$this->setColumnValue('LOGIN_TIME', $value);
	}
	function getLoginTime(){
		return $this->getColumnValue('LOGIN_TIME');
	}

	function setLoginClientIp($value){
		$this->setColumnValue('LOGIN_CLIENT_IP', $value);
	}
	function getLoginClientIp(){
		return $this->getColumnValue('LOGIN_CLIENT_IP');
	}

	function setLoginAuthToken($value){
		$this->setColumnValue('LOGIN_AUTH_TOKEN', $value);
	}
	function getLoginAuthToken(){
		return $this->getColumnValue('LOGIN_AUTH_TOKEN');
	}
	function setLoginSecretKey($value){
		$this->setColumnValue('LOGIN_AUTH_SECRET_KEY', $value);
	}
	function getLoginSecretKey(){
		return $this->getColumnValue('LOGIN_AUTH_SECRET_KEY');
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