<?php include("includes/header.php"); 
      if(!$session->is_signed_in()) {redirect("login.php");}

    $users = User::find_all();

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
                            USERS
                        </h1>
                        <p class="bg-success">
                            <?php echo $message; ?>
                        </p>
                        <a href="add_user.php" class="btn btn-primary">Add User</a>
                        
                        <div class="col-md-12">
                            
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Photo</th>
                                        <th>Username</th>
                                        <th>First name</th>
                                        <th>Last name</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    <?php foreach ($users as $user) : ?>
                                        <tr>

                                            <td><?php echo $user->id; ?></td>
                                            <td><img  class="admin-user-thumbnail user-image" src="<?php echo $user->image_path_and_placeholder(); ?>" alt="PHOTO"></td>
                                            <td>
                                                <?php echo $user->username; ?>
                                                <div class="action_links">
                                                    <a href="delete_user.php?id=<?php echo $user->id; ?>">Delete</a>
                                                    <a href="edit_user.php?id=<?php echo $user->id; ?>">Edit</a>
                                                    <a href="#">View</a>
                                                </div>
                                            </td>
                                            
                                            
                                            <td><?php echo $user->first_name; ?></td>
                                            <td><?php echo $user->last_name; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->


        </div>
        <!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>