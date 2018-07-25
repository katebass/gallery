<?php
ob_start();
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
define('SITE_ROOT', DS.'home'.DS.'user'.DS.'apps'.DS.'phptest'.DS.'gallery');

defined('INCLUDES_PATH') ? null : define('INCLUDES_PATH', SITE_ROOT.DS.'admin'.DS.'includes');

include_once(INCLUDES_PATH.DS."functions.php");
include_once(INCLUDES_PATH.DS."new_config.php");
include_once(INCLUDES_PATH.DS."database.php");
include_once(INCLUDES_PATH.DS."db_object.php");
include_once(INCLUDES_PATH.DS."user.php");
include_once(INCLUDES_PATH.DS."photo.php");
include_once(INCLUDES_PATH.DS."comment.php");
include_once(INCLUDES_PATH.DS."session.php");
include_once(INCLUDES_PATH.DS."paginate.php");

?>