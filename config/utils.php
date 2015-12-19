<?php
//require '../vendor/autoload.php';
require_once 'Config.php';
require_once 'Slim/Http/Util.php';
/* if(PHP_DEBUG_MODE){
  error_reporting(-1);
  ini_set('display_errors', 'On');
} */
// authorized user id from db - global var
$user_id = NULL;
/**
* Verifying required params posted or not
*/
function verifyRequiredParams($required_fields) {
  $error = false;
  $error_fields = "";
  $request_params = array();
  $request_params = $_REQUEST;
  // handling PUT request params
  if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    $app = \Slim\Slim::getInstance();
    parse_str($app->request()->getBody(), $request_params);
  }
  foreach ($required_fields as $field) {
    if (!isset($request_params[$field]) || !is_array($request_params)) {
      $error = true;
      $error_fields .= $field . ', ';
    }
  }
  if ($error) {
    // required fields are missing or empty
    // echo error json and stop the app
    $response = array();
    $app = \Slim\Slim::getInstance();
    $response['error'] = true;
    $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
    echoResponse(400, $response);
    $app->stop();
  }
}
/**
* Valiedating email address
*/
function validateEmail($email){
  $app = \Slim\Slim::getInstance();
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['error'] = true;
    $response['message'] = 'Email is not valid';
    echoResponse(400, $response);
    $app->stop();
  }
}
/**
* Echo json response
* @param String $status_code http response code
* @param Int $response Json response
*/
function echoResponse($status_code, $response) {
  $app = \Slim\Slim::getInstance();
  // Http response code
  $app->status($status_code);
  // setting response content type to json
  $app->contentType('application/json');
  echo json_encode($response);
}
/**
*  Adding Middle Layer to authenticate every request
*  Checking if the request has valid api key in the 'Authorization' header
 */
function authenticate(\Slim\Route $route) {
  // getting request header
  $headers = apache_request_headers();
  $response = array();
  $app = \Slim\Slim::getInstance();
  // verifying authorization header
 
  if (isset($headers['Authorization'])) {
   // $db = new DbHandler();
    // get the api key
    $api_key = $headers['Authorization'];
    // validating api key
   //echo $api_key;
    if ($api_key!='123456') {
    	//echo '1';
      
      $response['error'] = true;
      $response['message'] = 'Access denied. Invalid api key';
     
      jsonResponse1( 200, $response );
     // echoResponse(401, $response);
      $app->stop();
    } else {
    	//echo '2';
    	//jsonResponse1( 200, $response );
     /*  global $user_id;
      // get user primary key id
      $user = $db->getUserId($api_key);
      if ($user != NULL) {
        $user_id = $user['id'];
      } */
    }
  } else {
    // api key is missing in header
    $response['error'] = true;
    $response['message'] = "Api key is missing";
    echoResponse(400, $response);
    $app->stop();
  }
}
/** Debugging utility */
function p($input, $exit=1) {
  echo '<pre>';
  print_r($input);
  echo '</pre>';
  if($exit) {
    exit;
  }
}
function j($input, $encode=true, $exit=1) {
  echo '<pre>';
  echo json_encode($input, JSON_PRETTY_PRINT | $encode);
  echo '</pre>';
  if($exit) {
    exit;
  }
}
function jsonResponse1($status_code, $response) {
	$app = \Slim\Slim::getInstance ();
	$app->status ( $status_code );
	$app->contentType ( 'application/json' );

	echo json_encode ( $response );
}

function generateLoginAuthToken($value, $key,$iv,$algorithm,$mode) {
	

}

function encodeAuthToken($value, $secret)
    {
        $key = hash_hmac('sha1', $secret);
        $iv = getIv($expires, $secret);
        $secureString = base64_encode(
            self::encrypt(
                $value,
                $key,
                $iv,
                array(
                    'algorithm' => MCRYPT_RIJNDAEL_256,
            		'mode' => MCRYPT_MODE_CBC
                )
            )
        );
        $verificationString = hash_hmac('sha1',$value, $key);

        return implode('|', array($secureString, $verificationString));
    }
    
function decodeAuthToken($value, $secret)
    {
    	if ($value) {
    		$value = explode('|', $value);
    		if (count($value) === 3 && ((int) $value[0] === 0 || (int) $value[0] > time())) {
    			$key = hash_hmac('sha1', $value[0], $secret);
    			$iv = self::getIv($value[0], $secret);
    			$data = self::decrypt(
    					base64_decode($value[1]),
    					$key,
    					$iv,
    					 array(
		                    'algorithm' => MCRYPT_RIJNDAEL_256,
		            		'mode' => MCRYPT_MODE_CBC
                )
    			);
    			$verificationString = hash_hmac('sha1', $value[0] . $data, $key);
    			if ($verificationString === $value[2]) {
    				return $data;
    			}
    		}
    	}
    
    	return false;
    }
    
function getIv($expires, $secret)
    {
    	$data1 = hash_hmac('sha1', 'a'.$expires.'b', $secret);
    	$data2 = hash_hmac('sha1', 'z'.$expires.'y', $secret);
    
    	return pack("h*", $data1.$data2);
    }
function generateRandomString($length = 10) {
    	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$charactersLength = strlen($characters);
    	$randomString = '';
    	for ($i = 0; $i < $length; $i++) {
    		$randomString .= $characters[rand(0, $charactersLength - 1)];
    	}
    	return $randomString;
    }
function get_client_ip() {
	$ipaddress = '';
	if (getenv('HTTP_CLIENT_IP'))
		$ipaddress = getenv('HTTP_CLIENT_IP');
	else if(getenv('HTTP_X_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
	else if(getenv('HTTP_X_FORWARDED'))
		$ipaddress = getenv('HTTP_X_FORWARDED');
	else if(getenv('HTTP_FORWARDED_FOR'))
		$ipaddress = getenv('HTTP_FORWARDED_FOR');
	else if(getenv('HTTP_FORWARDED'))
		$ipaddress = getenv('HTTP_FORWARDED');
	else if(getenv('REMOTE_ADDR'))
		$ipaddress = getenv('REMOTE_ADDR');
	else
		$ipaddress = 'UNKNOWN';
	return $ipaddress;
}
?>