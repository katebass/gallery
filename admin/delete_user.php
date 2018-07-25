<?php include("includes/header.php"); 
      if(!$session->is_signed_in()) {redirect("login.php");}

    if(empty($_GET['id'])) {
        redirect("users.php");
    }

    $user = User::find_by_id($_GET['id']);

    if($user) {
        if($user->image) {
            $target_path = SITE_ROOT.DS.'admin'.DS.'images'.DS. $user->image;
            unlink($target_path);
        }
        
        $session->message("The user {$user->username} has been deleted");
        $user->delete();
        redirect("users.php");
    } else {
        redirect("users.php");
    }
 ?>