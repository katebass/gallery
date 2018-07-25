<?php include("includes/header.php");
      include("includes/photo_library_modal.php"); 
      if(!$session->is_signed_in()) {redirect("login.php");}


    if(empty($_GET['id'])) {
        redirect("users.php");
    }

    $user = User::find_by_id($_GET['id']);
    $message = "";

    if(isset($_POST['update'])) {
        if($user) {
            $user->username = $_POST['username'];
            $user->first_name  = $_POST['first_name'];
            $user->last_name  = $_POST['last_name'];
            if($_POST['password']){
            $user->password  = $_POST['password'];
            }

            if(empty($_FILES['image']['name'])) {
                $user->save();
                redirect("users.php");
                $session->message("The user has been updated");

            } else {
                if($user->image) {
                    $target_path = SITE_ROOT.DS.'admin'.DS.'images'.DS. $user->image;
                    unlink($target_path);
                }
                $user->set_file($_FILES['image']);

                $user->image = $_FILES['image']['name'];
                $user->upload_photo();
                $user->save();
                $session->message("The user has been updated");
            }
        } 

        //redirect("edit_user.php?id={$user->id}");
        redirect("users.php");
    } 

?>


<!-- Navigation -->
<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">


    <?php include("includes/top_nav.php")?>
    
    <?php include("includes/side_nav.php") ?>

    <!-- /.navbar-collapse -->
</nav>

<div id="page-wrapper">

    <div class="container-fluid">
        
        <!-- Page Heading -->
        <div class="row" >
            <div class="col-lg-12">
                <h1 class="page-header">
                    users
                    <small></small>
                </h1>
                
                <div class="col-md-6 user_image_box">
                    <a href="#" data-toggle="modal" data-target="#photo-library">
                        <img class="img-responsive" src="<?php echo $user->image_path_and_placeholder(); ?>" alt="">
                    </a>
                </div>

                <form action="" method="post" enctype="multipart/form-data">
                    
                    <div class="col-md-6">

                        <?php echo $message; ?>
                        
                        <div class="form-group">
                            <label for="image">Avatar</label>
                            <input type="file" name="image">
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" class="form-control" value="<?php echo $user->username; ?>">
                        </div>

                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" name="first_name" class="form-control" value="<?php echo $user->first_name; ?>">
                        </div>

                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" name="last_name" class="form-control" value="<?php echo $user->last_name; ?>">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="form-group">
                            <input type="submit" name="update" class="btn btn-primary pull-right" value="Update">
                        </div>

                        <a id="user-id" class="btn btn-danger" href="delete_user.php?id=<?php echo $user->id; ?>">Delete</a>

                    </div>

                </form>

            </div>
        </div>
        <!-- /.row -->

    </div>
    <!-- /.container-fluid -->


</div>
<!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>