<?php

class passwordHash {

    // blowfish
    private static $algo = '$2a';
    // cost parameter
    private static $cost = '$10';

    // mainly for internal use
    public static function unique_salt() {
        return substr(sha1(mt_rand()), 0, 22);
    }

    // this will be used to generate a hash
    public static function hash($password) {

        return crypt($password, self::$algo .
                self::$cost .
                '$' . self::unique_salt());
    }

    public static function check_password($hash, $password) {
    	/* echo '----';
    	echo $hash; */
    	$full_salt = substr($hash, 0, 29);
    	/* echo '----';
    	echo $full_salt; */
    	$new_hash = crypt($password, $full_salt);
    	$final_salt = substr($new_hash, 0, 29);
    	/* echo '----';
    	echo $final_salt; */
    	return ($full_salt == $final_salt);
    }
    /* // this will be used to compare a password against a hash
    public static function check_password($hash, $password) {
    	
    	//echo '2';
        $full_salt = substr($hash, 0, 29);
        // echo $full_salt;
        //$new_hash = crypt($password, $full_salt);
    	echo $full_salt; 
    	return ($hash == $full_salt);
        
    	/*  $full_salt = substr($hash, 0, 29);
    	 $new_hash = crypt($password, $full_salt);
    	 return ($hash == $new_hash); */
    	/* $tempHash = crypt($password, self::$algo .
    			self::$cost .
    			'$' . self::unique_salt());
    	echo $tempHash;
    	return ($hash == $tempHash); */
    //} */

}

?>
