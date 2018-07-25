<?php include("includes/header.php"); 
    if(!$session->is_signed_in()) {redirect("login.php");}


    $message = "";
    if(isset($_FILES['file'])) {
        $photo = new Photo();
        $photo->user_id = $_SESSION['user_id'];
        $photo->title = $_POST['title'];
        $photo->description = $_POST['description'];
        $photo->set_file($_FILES['file']);

        if($photo->save()) {
            $message = "Photo uploaded Successfully";
        } else {
            $message = join("<br>", $photo->errors);
        }
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
                            UPLOAD
                            <small></small>
                        </h1>
                        
                        <div class="row">
                            <div class="col-md-6">
                                
                                <?php echo $message; ?>
                                <form action="upload.php" method="post" enctype="multipart/form-data">
                                     
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" name="title" class="form-controll">
                                        </div>
                                        <div class="form-group">
                                            <label for="description">Description</label>
                                            <input type="text" name="description" class="form-controll">
                                        </div>

                                        <div class="form-group">
                                            <input type="file" name="file" id="file_upload" class="form-controll">
                                        </div>

                                    <input type="submit" name="submit" value="submit">

                                </form>

                            </div>
                        </div>

                        <div class="row">
                            
                            <div class="col-lg-12">
                                
                                <form action="upload.php" class="dropzone"></form>

                            </div>

                        </div>


                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->


        </div>
        <!-- /#page-wrapper -->

<?php include("includes/footer.php"); ?>