<?php

class Db_object {

	public static function find_all() {
		/*global $database;
		$result_set = $database->query("select * from users");
		return $result_set; */

		return static::find_by_query("select * from " .static::$db_table);
	}

	public static function find_by_id($id) {
		global $database;

		$the_result_array = static::find_by_query("select * from " .static::$db_table ." where id=$id");

		return empty($the_result_array) ? false : array_shift($the_result_array);
	}

	/*
	1. The method makes the query 
    2. Fetches the the data from database table using a while loop and it returns it in $row
    3. Passes the results ($row) to the Instantiation (instantantion - weird name I know) method
    4. Returns the object in the $the_object_array variable that it gets from the  instantantion method.
    5. And that will be the result that find_all() returns when we   use User::find_all() 
    */
	public static function find_by_query($sql) {
		global $database;
		$result_set = $database->query($sql);
		$the_object_array = array();

		while($row = mysqli_fetch_array($result_set)) {
			$the_object_array[] = static::instantation($row);
		}
		return $the_object_array;
	}

	/*
	1. Gets the calling class name.
	2. Creates an instance of the class
	3. It loops through the $the_record variable that has all the records
	4. It checks to see if the properties exist on that object with the other method has_the_property() 
	5. If the keys from the record which basically are the columns from db table are found or equal the object properties then it assigns    the values to them.
	6. Finally it returns the object!
	*/
	public static function instantation($record) {
        $calling_class = get_called_class();
        $obj = new $calling_class;
        // $obj->id = $found_user['id'];
        // $obj->username = $found_user['username'];
        // $obj->password = $found_user['password'];
        // $obj->first_name = $found_user['first_name'];
        // $obj->last_name = $found_user['last_name'];

        foreach ($record as $attribute => $value) {
        	if($obj->has_the_attribute($attribute)) {
        		$obj->$attribute = $value;
        	}
        }

        return $obj;
	}

	private function has_the_attribute($attribute) {
		$object_properties = get_object_vars($this);

		return array_key_exists($attribute, $object_properties);
	}

	protected function properties() {
		//return get_object_vars($this);

		$properties = array();
		foreach (static::$db_table_fields as $db_field) {
			if(property_exists($this, $db_field)) {
				$properties[$db_field] = $this->$db_field;
			}
		}

		return $properties;
	}

	protected function clean_properties() {
		global $database;

		$clean_properties = array();

		foreach ($this->properties() as $key => $value) {
			$clean_properties[$key] = $database->escape_string($value);
		}

		return $clean_properties;
	}

	public function save() {
		return isset($this->id) ? $this->update() : $this->create();
	}

	public function create() {
		global $database;
		$properties = $this->clean_properties();

		$sql = "insert into " .static::$db_table ." (" . implode(",", array_keys($properties)) . ")";
		$sql .= " values ('". implode("', '", array_values($properties))  ."')";
		// $sql .= $database->escape_string($this->username)."', '";
		// $sql .= $database->escape_string($this->password)."', '";
		// $sql .= $database->escape_string($this->first_name)."', '";
		// $sql .= $database->escape_string($this->last_name)."');";

		if($database->query($sql)) {
			$this->id = $database->the_insert_id();
			return true;
		} else {
			return false;
		}

	}

	public function update() {
		global $database;
		$properties = $this->clean_properties();
		$properties_pairs = array();

		foreach ($properties as $key => $value) {
			$properties_pairs[] = "{$key}='{$value}' "; 
		}

		$sql = "update " .static::$db_table ." set ";
		$sql .= implode(", ", $properties_pairs);
		// $sql .= "username = '" . $database->escape_string($this->username)."', ";
		// $sql .= "password = '" . $database->escape_string($this->password)."', ";
		// $sql .= "first_name = '" . $database->escape_string($this->first_name)."', ";
		// $sql .= "last_name = '" . $database->escape_string($this->last_name)."' ";
		$sql .= " where id = '" . $database->escape_string($this->id)."' ";

		$database->query($sql);

		return (mysqli_affected_rows($database->connection) == 1) ? true : false;
	}

	public function delete() {
		global $database;

		$sql = "delete from " .static::$db_table;
		$sql .= " where id=" . $database->escape_string($this->id);
		$sql .= " limit 1";

		$database->query($sql);

		return (mysqli_affected_rows($database->connection) == 1) ? true : false;
	}

	public static function count_all() {
		global $database;

		$sql ="select count(*) from ". static::$db_table;
		$result_set = $database->query($sql);
		$row = mysqli_fetch_array($result_set);
		
		return array_shift($row);
	}

	public function set_file($file) {

		if(empty($file) || !$file || !is_array($file)) {
			$this->errors[] = "There was no file uploaded here";
			return false;
		} elseif($file['error'] != 0) {
			$this->errors[] = $this->upload_errors_array[$file['error']];
			return false;
		} else {
			$this->image = basename($file['name']);
			$this->tmp_path = $file['tmp_name'];
			$this->type = $file['type'];
			$this->size = $file['size'];
		}

	} 


}