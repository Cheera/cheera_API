<?php
require_once 'config/dbHandler.php';
require_once 'config/passwordHash.php';
require_once 'config/utils.php';
require_once 'model/profile_master.php';
require_once 'model/profile_personal_dtls.php';
require_once 'model/profile_career_dtls.php';
require_once 'model/profile_family_dtls.php';
require_once 'model/profile_religion_dtls.php';
require_once 'Slim/Slim.php';

\Slim\Slim::registerAutoloader ();

$app = new \Slim\Slim ();

//https://en.wikipedia.org/wiki/List_of_HTTP_status_codes

// $app->post('/login', 'loginOpn');

$app->post ( '/signUp', 'authenticate',function () use($app) {
	
	// check for required params
	verifyRequiredParams ( array (
			'firstName',
			'surName',
			'mobileNumber',
			'emailId',
			'userName',
			'Password',
			'gender' 
	) );
	$response = array ();	
	// reading post params
	$firstName = $app->request->post ( 'firstName' );
	$surName = $app->request->post ( 'surName' );
	$mobileNumber = $app->request->post ( 'mobileNumber' );
	$emailId = $app->request->post ( 'emailId' );
	$userName = $app->request->post ( 'userName' );
	$password = $app->request->post ( 'password' );
	$gender = $app->request->post ( 'gender' );
	
	$password_hash = passwordHash::hash ( $password );
	
	echo $password_hash;
	
	// validating email address
	// validateEmail($email);
	$db = new DbHandler ();
	
	$profileMaster = new profile_master ();
	
	$profileMaster->setFirstName ( $firstName );
	$profileMaster->setLastName ( $surName );
	$profileMaster->setMobileNumber ( $mobileNumber );
	$profileMaster->setEmailId ( $emailId );
	$profileMaster->setUserName ( $userName );
	$profileMaster->setPassword ( $password_hash );
	$profileMaster->setStatus ( '00' );
	$profileMaster->setGender ( $gender );
	$profileMaster->setLastOpuser ( 'admin' );
	
	if (! $db->isUserExists ( $emailId )) {
		
		$profile_id = $profileMaster->save ();
		
		$response ["profileId"] = $profile_id;
		
		if ($profile_id > - 1) {
			
			$response ["status"] = "00";
			$response ["message"] = "PROFILE_CREATED_SUCCESSFULLY";
		} else {
			$response ["status"] = "99";
			$response ["message"] = "PROFILE_CREATE_FAILED";
		}
		// return $response;
	} 

	else {
		// User with same email already existed in the db
		$response ["status"] = "55";
		$response ["message"] = "PROFILE_ALREADY_EXISTED";
		// return $response;
	}
	
	jsonResponse ( 200, $response );
} );

$app->post ( '/profPersonalDetails', 'authenticate', function () use($app) {
	
	// check for required params
	verifyRequiredParams ( array (
			'profileId',
			'prfCreatedBy',
			'physicStatus',
			'dateOfBirth',
			'age',
			'heightInCm',
			'complexion',
			'motherTounge',
			'aboutMySelf' 
	) );
	$response = array ();
	// reading post params
	$profileId = $app->request->post ( 'profileId' );
	$prfCreatedBy = $app->request->post ( 'prfCreatedBy' );
	$physicStatus = $app->request->post ( 'physicStatus' );
	$dateOfBirth = $app->request->post ( 'dateOfBirth' );
	$age = $app->request->post ( 'age' );
	$heightInCm = $app->request->post ( 'heightInCm' );
	$complexion = $app->request->post ( 'complexion' );
	$motherTounge = $app->request->post ( 'motherTounge' );
	$aboutMySelf = $app->request->post ( 'aboutMySelf' );
	
	// validating email address
	// validateEmail($email);
	// $db = new DbHandler ();
	
	$profilePersonalDtls = new profile_personal_dtls ();
	
	$profileMaster = new profile_master ();
	
	$profilePersonalDtls->setProfileId ( $profileId );
	$profilePersonalDtls->setProfileCreatedBy ( $prfCreatedBy );
	$profilePersonalDtls->setPhysicalStatus ( $physicStatus );
	$profilePersonalDtls->setDateOfBIrth ( $dateOfBirth );
	$profilePersonalDtls->setAge ( $age );
	$profilePersonalDtls->setHeightInCm ( $heightInCm );
	$profilePersonalDtls->setComplexion ( $complexion );
	$profilePersonalDtls->setMotherTounge ( $motherTounge );
	$profilePersonalDtls->setAboutMyself ( $aboutMySelf );
	$profilePersonalDtls->setLastOpuser ( 'admin' );
	
	if (NULL != $profileMaster->getByPrimaryKey ( $profileId )) {
		
		if (NULL == $profilePersonalDtls->getByPrimaryKey ( $profileId )) {
			
			$inserted = $profilePersonalDtls->save ();
			
			$response ["profileId"] = $profileId;
			
			if ($inserted > - 1) {
				$response ["status"] = "00";
				$response ["message"] = "PERSONAL_DETAILS_UPDATED_SUCCESSFULLY";
			} else {
				$response ["status"] = "99";
				$response ["message"] = "PERSONAL_DETAILS_UPDATE_FAILED";
			}
			// return $response;
		} 

		else {
			// User with same email already existed in the db
			$response ["status"] = "55";
			$response ["message"] = "PERSONAL_DETAILS_EXIST";
			// return $response;
		}
	} 

	else {
		// User with same email already existed in the db
		$response ["status"] = "-11";
		$response ["message"] = "PROFILE_NOT_EXIST";
		// return $response;
	}
	
	jsonResponse ( 200, $response );
} );

$app->post ( '/profCareerDetails', 'authenticate', function () use($app) {
	
	// check for required params
	verifyRequiredParams ( array (
			'profileId',
			'education',
			'specialization',
			'employedIn',
			'nameOfEmployer',
			'annualIncome',
			'jobNamePosition' 
	) );
	$response = array ();
	// reading post params
	$profileId = $app->request->post ( 'profileId' );
	$education = $app->request->post ( 'education' );
	$specialization = $app->request->post ( 'specialization' );
	$employedIn = $app->request->post ( 'employedIn' );
	$nameOfEmployer = $app->request->post ( 'nameOfEmployer' );
	$annualIncome = $app->request->post ( 'annualIncome' );
	$jobNamePosition = $app->request->post ( 'jobNamePosition' );
	
	$profileCareerDtls = new profile_career_dtls ();
	
	$profileMaster = new profile_master ();
	
	$profileCareerDtls->setProfileId ( $profileId );
	$profileCareerDtls->setEducation ( $education );
	$profileCareerDtls->setSpecialization ( $specialization );
	$profileCareerDtls->setEmployedIn ( $employedIn );
	$profileCareerDtls->setNameOfEmployer ( $nameOfEmployer );
	$profileCareerDtls->setAnnualIncome ( $annualIncome );
	$profileCareerDtls->setJobNamePosition ( $jobNamePosition );
	$profileCareerDtls->setLastOpuser ( 'admin' );
	
	if (NULL != $profileMaster->getByPrimaryKey ( $profileId )) {
		
		if (NULL == $profileCareerDtls->getByPrimaryKey ( $profileId )) {
			
			$inserted = $profileCareerDtls->save ();
			
			$response ["profileId"] = $profileId;
			
			if ($inserted > - 1) {
				$response ["status"] = "00";
				$response ["message"] = "CAREER_DETAILS_UPDATED_SUCCESSFULLY";
			} else {
				$response ["status"] = "99";
				$response ["message"] = "CAREER_DETAILS_UPDATE_FAILED";
			}
			// return $response;
		} 

		else {
			// User with same email already existed in the db
			$response ["status"] = "55";
			$response ["message"] = "CAREER_DETAILS_EXIST";
			// return $response;
		}
	} 

	else {
		// User with same email already existed in the db
		$response ["status"] = "-11";
		$response ["message"] = "PROFILE_NOT_EXIST";
		// return $response;
	}
	
	jsonResponse ( 200, $response );
} );

$app->post ( '/profFamilyDetails', 'authenticate', function () use($app) {
	
	// check for required params
	verifyRequiredParams ( array (
			'profileId',
			'familyType',
			'familyStatus',
			'aboutMyFamily' 
	) );
	$response = array ();
	// reading post params
	$profileId = $app->request->post ( 'profileId' );
	$familyType = $app->request->post ( 'familyType' );
	$familyStatus = $app->request->post ( 'familyStatus' );
	$aboutMyFamily = $app->request->post ( 'aboutMyFamily' );
	
	$profileFamilyDtls = new profile_family_dtls ();
	
	$profileMaster = new profile_master ();
	
	$profileFamilyDtls->setProfileId ( $profileId );
	$profileFamilyDtls->setFamilyType ( $familyType );
	$profileFamilyDtls->setFamilyStatus ( $familyStatus );
	$profileFamilyDtls->setAboutMyFamily ( $aboutMyFamily );
	$profileFamilyDtls->setLastOpuser ( 'admin' );
	
	if (NULL != $profileMaster->getByPrimaryKey ( $profileId )) {
		
		if (NULL == $profileFamilyDtls->getByPrimaryKey ( $profileId )) {
			
			$inserted = $profileFamilyDtls->save ();
			
			$response ["profileId"] = $profileId;
			
			if ($inserted > - 1) {
				$response ["status"] = "00";
				$response ["message"] = "FAMILY_DETAILS_UPDATED_SUCCESSFULLY";
			} else {
				$response ["status"] = "99";
				$response ["message"] = "FAMILY_DETAILS_UPDATE_FAILED";
			}
			// return $response;
		} 

		else {
			// User with same email already existed in the db
			$response ["status"] = "55";
			$response ["message"] = "FAMILY_DETAILS_EXIST";
			// return $response;
		}
	} 

	else {
		// User with same email already existed in the db
		$response ["status"] = "-11";
		$response ["message"] = "PROFILE_NOT_EXIST";
		// return $response;
	}
	
	jsonResponse ( 200, $response );
} );
	$app->post ( '/profReligionDetails',  'authenticate', function () use($app) {
	
		// check for required params
		verifyRequiredParams ( array (
				'profileId',
				'religion',
				'cast',
				'star',
				'dhosamInHoroscope'
		) );
		$response = array ();
		// reading post params
		$profileId = $app->request->post ( 'profileId' );
		$religion = $app->request->post ( 'religion' );
		$cast = $app->request->post ( 'cast' );
		$star = $app->request->post ( 'star' );
		$dhosamInHoroscope = $app->request->post ( 'dhosamInHoroscope' );
		
		$profileReligionDtls = new profile_religion_dtls ();
	
		$profileMaster = new profile_master ();
	
		$profileReligionDtls->setProfileId ( $profileId );
		$profileReligionDtls->setReligion( $religion );
		$profileReligionDtls->setCast( $cast );
		$profileReligionDtls->setStar( $star );
		$profileReligionDtls->setDhosamInHoroscope( $dhosamInHoroscope );
		$profileReligionDtls->setLastOpuser ( 'admin' );
	
		if (NULL != $profileMaster->getByPrimaryKey ( $profileId )) {
	
			if (NULL == $profileReligionDtls->getByPrimaryKey ( $profileId )) {
					
				$inserted = $profileReligionDtls->save ();
					
				$response ["profileId"] = $profileId;
					
				if ($inserted > - 1) {
					$response ["status"] = "00";
					$response ["message"] = "RELIGION_DETAILS_UPDATED_SUCCESSFULLY";
				} else {
					$response ["status"] = "99";
					$response ["message"] = "RELIGION_DETAILS_UPDATE_FAILED";
				}
				// return $response;
			}
	
			else {
				// User with same email already existed in the db
				$response ["status"] = "55";
				$response ["message"] = "RELIGION_DETAILS_EXIST";
				// return $response;
			}
		}
	
		else {
			// User with same email already existed in the db
			$response ["status"] = "-11";
			$response ["message"] = "PROFILE_NOT_EXIST";
			// return $response;
		}
	
		jsonResponse ( 200, $response );
	} );
	
$app->post('/login', 'authenticate', function() use ($app) {
  verifyRequiredParams(array('userName', 'password'));
  // reading post params
  $userName = $app->request()->post('userName');
  $password = $app->request()->post('password');
  $response = array();
  $db = new DbHandler();
  // check for correct email and password
  if ($db->checkLogin($userName, $password)) {
  	// get the user by email
  	$profileMaster = new profile_master();
  	
  	$profileMaster = $profileMaster->getOneByAny(array(user_name=>$userName,email_id=>$userName,mobile_number=>$userName),NULL,NULL);
  	
  	if ($profileMaster != NULL) {
  	 		
  		$rndmString = generateRandomString();
  		
  		$tokenString = encodeAuthToken($profileMaster->getProfileId(),$rndmString);
  		
  		$profileLoginAuth = new profile_login_auth();
  		
  		$profileLoginAuth->setUserName($profileMaster->getUserName());
  		$profileLoginAuth->setProfileId($profileMaster->getProfileId());
  		$profileLoginAuth->setLoginTime(time());
  		$profileLoginAuth->setLoginClientIp(get_client_ip());
  		$profileLoginAuth->setLoginSecretKey($rndmString);
  		$profileLoginAuth->setLoginAuthToken($tokenString);
  		$profileLoginAuth->setLastOpuser('admin');
  		
  		$profileLoginAuth->save();
  		
  		
  		/* if (!isset($_SESSION)) {
  			session_start();
  		}
  		$_SESSION['profileId'] = $profileMaster->getProfileId();
  		$_SESSION['email'] = $email;
  		$_SESSION['name'] = $user['name'];
  		
  		$app->add(new Slim\Middleware\SessionCookie()); */
  		
  		$response ["status"] = "00";
  		$response ["message"] = "PROFILE_Exists";
  		$response ["profileMaster"] = $profileMaster;
  		$response ["authToken"] = $profileMaster;
  		
  	} else {
  		// unknown error occurred
  		$response['error'] = true;
  		$response['message'] = "An error occurred. Please try again";
  	}
  	
  } else {
      // user credentials are wrong
      $response['error'] = true;
      $response['message'] = 'Login failed. Incorrect credentials';
  }
  //echoResponse(200, $response);
  jsonResponse ( 200, $response );
  
});

$app->get ( '/getSomething/:input', function ($input) {
	
	$response = array ();
	
	// add your business logic here
	
	$response ["error"] = false;
	$response ["message"] = "Response from Slim RESTful Webservice - " . $input;
	jsonResponse ( 200, $response );
} );

$app->post ( '/postSomething', function () use($app) {
	
	$response = array ();
	$input = $app->request->post ( 'input' ); // reading post params
	                                          // add your business logic here
	
	$response ["error"] = false;
	$response ["message"] = "Response from Slim RESTful Webservice - " . $input;
	jsonResponse ( 200, $response );
} );

$app->put ( '/putSomething', function () use($app) {
	
	$response = array ();
	$input = $app->request->put ( 'input' ); // reading post params
	                                         
	// add your business logic here
	$result = true;
	if ($result) {
		// Updated successfully
		$response ["error"] = false;
		$response ["message"] = "Updated successfully";
	} else {
		// Failed to update
		$response ["error"] = true;
		$response ["message"] = "Failed to update. Please try again!";
	}
	jsonResponse ( 200, $response );
} );

$app->delete ( '/deleteSomething', function () use($app) {
	
	$response = array ();
	$input = $app->request->put ( 'input' ); // reading post params
	                                         
	// add your business logic here
	$result = true;
	if ($result) {
		// deleted successfully
		$response ["error"] = false;
		$response ["message"] = "Deleted succesfully";
	} else {
		// failed to delete
		$response ["error"] = true;
		$response ["message"] = "Failed to delete. Please try again!";
	}
	jsonResponse ( 200, $response );
} );
function jsonResponse($status_code, $response) {
	$app = \Slim\Slim::getInstance ();
	$app->status ( $status_code );
	$app->contentType ( 'application/json' );
	
	echo json_encode ( $response );
}
function getConnection() {
	$db_username = "root";
	$db_password = "";
	$conn = new PDO ( 'mysql:host=localhost;dbname=test', $db_username, $db_password );
	$conn->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	
	return $conn;
}

$app->run ();

?>
