<?php

class User extends Db_object{
	
	protected static $db_table = "users";	
	protected static $db_table_fields = array('username', 'password', 'first_name', 'last_name', 'image');
	public $id;
	public $username;
	public $password;
	public $first_name;
	public $last_name;
	public $image;
	public $upload_directory = "images";
	public $image_placeholder = "http://placehold.it/400x400&text=image";

	public $errors = array();
	public $upload_errors_array = array(
		UPLOAD_ERR_OK => "There is no error, the file uploaded with success. ",
		UPLOAD_ERR_INI_SIZE => "The uploaded file exceeds the upload_max_filesize directive in php.ini.",
		UPLOAD_ERR_FORM_SIZE => "The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.",
		UPLOAD_ERR_NO_TMP_DIR => "Missing a temporary folder.",
		UPLOAD_ERR_CANT_WRITE => "Failed to write file to disk.",
		UPLOAD_ERR_EXTENSION => "A PHP extension stopped the file upload.",
		UPLOAD_ERR_PARTIAL => "The uploaded file was only partially uploaded. ",
		UPLOAD_ERR_NO_FILE => "No file was uploaded. ",
	);

	public function image_path_and_placeholder() {

		return empty($this->image) ? $this->image_placeholder : $this->upload_directory.DS.$this->image;

	}

	public static function verify_user($username, $password) {
		global $database;
		$username = $database->escape_string($username);
		$password = $database->escape_string($password);

		$sql = "Select * from " .self::$db_table ." where ";
		$sql .= "username = '{$username}' ";
		$sql .= "and password = '{$password}' ";
		$sql .= "limit 1";

		$the_result_array = self::find_by_query($sql);

		return empty($the_result_array) ? false : array_shift($the_result_array);
	}

	public function ajax_save_user_image($user_image, $user_id){
		global $database;

		$user_image = $database->escape_string($user_image);
		$user_id = (int)$database->escape_string($user_id);

		$this->image = $user_image;
		$this->id = $user_id;

		$sql = "update ". static::$db_table ." set image = '{$this->image}' ";
		$sql .= " where id = {$this->id} ";

		$update_image = $database->query($sql);
		
		echo $this->image_path_and_placeholder();
	}

	public function upload_photo() {

		if(!empty($this->errors)) {
			return false;
		}

		if(empty($this->image) || empty($this->tmp_path)) {
			$this->errors[] = "There was no file uploaded here";
			return false;
		}

		$target_path = SITE_ROOT.DS.'admin'.DS.$this->upload_directory.DS.$this->image;

		if(file_exists($target_path)) {
			$this->errors[] = "The file {$this->image} already exists";
			return false;
		}

		if(move_uploaded_file($this->tmp_path, $target_path)) {
				unset($this->tmp_path);
				return true;
		} else {
			$this->errors[] = "the file directory probably doesn't have permission";
			return false;
		}
	}

	public function photos() {
		return Photo::find_by_query("Select * from photos where user_id = " . $this->id);
	}

}