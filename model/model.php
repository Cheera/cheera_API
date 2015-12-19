<?php
/**
 * Model base class
 */
class Model {
    
    protected static $tableName = '';
    protected static $primaryKey = '';
    protected $columns;
    
 function __construct() {
  $this->columns = array();
  
  require_once 'config/DB.php';
  // opening db connection
  
  /* $db = new DbConnect();
  $this->conn = $db->connect(); */
 }
    
    function setColumnValue($column,$value){
        $this->columns[$column] = $value;
    }
    
    function getColumnValue($column){
        return $this->columns[$column];
    }
    /**
     * Save or update the item data in database
     */
    function save(){
        $class = get_called_class();
        
         $query =  "INSERT INTO " . static::$tableName . " (" . implode(",", array_keys($this->columns)) . ") VALUES(";
        $keys = array();
        $values = array();
        foreach ($this->columns as $key => $value) {
          //  $keys[":".$key] = $value;
            $values["'".$value."'"] = $value; 
            
        }
       
        $query .= implode(",", array_keys($values)).")";
        
	
		
        $db = DB::getInstance();
        $s = $db->prepare($query);
        $result=$s->execute();
        
        if ($result) {
        	
        	if($db->lastInsertId() >0)
        	{
        		return $db->lastInsertId() ;
        	}
        	else {
        		
        		return 0;
        	}
        	
        	//return $db->lastInsertId() ;
        	 
        } else {
        	// Failed to insert record
        	 
        	return -1;
        	
        }
        
       /*  if( ! $stmt = $this->conn->prepare($query) ) {
            	echo 'Error: ' . $this->conn->error;
            	return false; // throw exception, die(), exit, whatever...
            } else {
	         
	            $result = $stmt->execute();
	            $stmt->close();
            }
            
            if ($result) {
            	//echo '1';
            	 return mysqli_insert_id($this->conn);  
            	
            } else {
            	// Failed to insert record
            	
            	//echo '2';
            	return -1;
            	// return 'USER_CREATE_FAILED';
            } */
        
        
        
    }
    
    /**
     * Delete this item data from database
     */
    function delete(){
        $class = get_called_class();
        $query = "DELETE FROM " . static::$tableName . " WHERE ".static::$primaryKey."=:id LIMIT 1";
        $db = Database::getInstance();
        $s = $db->getPreparedStatment($query);
        $s->execute(array(':id'=>$this->columns[static::$primaryKey]));
    }
    
    /**
     * Create an instance of this Model from the database row
     */
    function createFromDb($column){
    	
    	if (is_array($column) || is_object($column))
    	{
        foreach ($column as $key => $value) {
            $this->columns[$key] = $value;
            
        }
    	}
    }
    
    /**
     * Get all items
     * Conditions are combined by logical AND
     * @example getAll(array(name=>'Bond',job=>'artist'),'age DESC',0,25) converts to SELECT * FROM TABLE WHERE name='Bond' AND job='artist' ORDER BY age DESC LIMIT 0,25
     */
    static function getAll($condition=array(),$order=NULL,$startIndex=NULL,$count=NULL){
        $query = "SELECT * FROM " . static::$tableName;
        if(!empty($condition)){
            $query .= " WHERE ";
            foreach ($condition as $key => $value) {
                $query .= $key . "=:".$key." AND ";
            }
        }
        $query = rtrim($query,' AND ');
        if($order){
            $query .= " ORDER BY " . $order;
        }
        if($startIndex !== NULL){
            $query .= " LIMIT " . $startIndex;
            if($count){
                $query .= "," . $count;
            }
        }
        return self::get($query,$condition);
    }
    
    /**
     * Pass a custom query and condition
     * @example get('SELECT * FROM TABLE WHERE name=:user OR age<:age',array(name=>'Bond',age=>25))
     */
    static function get($query,$condition=array()){
        $db = Database::getInstance();
        $s = $db->getPreparedStatment($query);
        foreach ($condition as $key => $value) {
            $condition[':'.$key] = $value;
            unset($condition[$key]);
        }
        $s->execute($condition);
        $result = $s->fetchAll(PDO::FETCH_ASSOC);
        $collection = array();
        $className = get_called_class();
        foreach($result as $row){
            $item = new $className();
            $item->createFromDb($row);
            array_push($collection,$item);
        }
        return $collection;
    }
    
    /**
     * Get a single item
     */
   function getOne($condition=array(),$order=NULL,$startIndex=NULL){
        $query = "SELECT * FROM " . static::$tableName;
       
        if(!empty($condition)){
            $query .= " WHERE ";
         //   echo $query;
            foreach ($condition as $key => $value) {
                $query .= $key . "=".$value." AND ";
              //  echo $query;
            }
        }
  //      echo $query;
        $query = rtrim($query,' AND ');

        if($order){
            $query .= " ORDER BY " . $order;
        }
        if($startIndex !== NULL){
            $query .= " LIMIT " . $startIndex . ",1";
        }
        $db = DB::getInstance();
        $s = $db->prepare($query);
       
        foreach ($condition as $key => $value) {
            $condition[':'.$key] = $value;
            unset($condition[$key]);
        }
       $s->execute($condition);
      
      $result = $s->fetch(PDO::FETCH_ASSOC);
      
      if (is_array($result) || is_object($result))
      {

      	$className = get_called_class();
      	$item = new $className();
      	$item->createFromDb($result);
      	
      	// print_r($item);
      	return $item;
      }
      
      else 
      {
      	return null;
      }
     
        
     /*    if( ! $stmt = $this->conn->prepare($query) ) {
        	echo 'Error: ' . $this->conn->error;
        	return false; // throw exception, die(), exit, whatever...
        } else {
        
        	/* $stmt->execute();
        	//$stmt->close();
        	
        	$result = $stmt->fetch(PDO::FETCH_ASSOC);
        	print_r($result);
        	$className = get_called_class();
        	$item = new $className();
        	$item->createFromDb($result);
        	return $item; */
        	
        	/* $stmt->execute();
        	$result = $stmt->
        	print_r($result);
        	$className = get_called_class();
        	$item = new $className();
          
        	$item->createFromDb($result);
        	return $item; */
        
         
       /*  $row = $result->fetch(PDO::FETCH_ASSOC);
        $className = get_called_class();
        $item = new $className();
        $item->createFromDb($row);
        return $item; */
        
        
    }
    
    /**
     * Get a single item by a LOGICAL OR
     */
    
    function getOneByAny($condition=array(),$order=NULL,$startIndex=NULL){
    	$query = "SELECT * FROM " . static::$tableName;
    	 
    	if(!empty($condition)){
    		$query .= " WHERE ";
    		//   echo $query;
    		foreach ($condition as $key => $value) {
    			$query .= $key . "=".$value." OR ";
    			//  echo $query;
    		}
    	}
    	//      echo $query;
    	$query = rtrim($query,' OR ');
    
    	if($order){
    		$query .= " ORDER BY " . $order;
    	}
    	if($startIndex !== NULL){
    		$query .= " LIMIT " . $startIndex . ",1";
    	}
    	$db = DB::getInstance();
    	$s = $db->prepare($query);
    	 
    	foreach ($condition as $key => $value) {
    		$condition[':'.$key] = $value;
    		unset($condition[$key]);
    	}
    	$s->execute($condition);
    
    	$result = $s->fetch(PDO::FETCH_ASSOC);
    
    	if (is_array($result) || is_object($result))
    	{
    
    		$className = get_called_class();
    		$item = new $className();
    		$item->createFromDb($result);
    		 
    		// print_r($item);
    		return $item;
    	}
    
    	else
    	{
    		return null;
    	}
    	 
    
    }
    
    /**
     * Get an item by the primarykey
     */
    function getByPrimaryKey($value){
        $condition = array();
        $condition[static::$primaryKey] = $value;
        return $this->getOne($condition);
    }
    
    /**
     * Get the number of items
     */
    static function getCount($condition=array()){
       $query = "SELECT COUNT(*) FROM " . static::$tableName;
        if(!empty($condition)){
            $query .= " WHERE ";
            foreach ($condition as $key => $value) {
                $query .= $key . "=:".$key." AND ";
            }
        }
        $query = rtrim($query,' AND ');
        $db = Database::getInstance();
        $s = $db->getPreparedStatment($query);
        foreach ($condition as $key => $value) {
            $condition[':'.$key] = $value;
            unset($condition[$key]);
        }
        $s->execute($condition);
        $countArr = $s->fetch();
        return $countArr[0];
    }
    
    function __destruct()
    {
    	 $this->db= null;
    }
}
?>