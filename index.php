<?php require_once("includes/header.php"); 
    
    $page = !empty($_GET['page']) ? (int)$_GET['page'] : 1;
    $items_per_page = 4;
    $items_total_count = Photo::count_all();

    $paginate = new Paginate($page, $items_per_page, $items_total_count);

    $sql = "select * from photos ";
    $sql .= "limit {$items_per_page} ";
    $sql .= "offset {$paginate->offset()}";

    $photos = Photo::find_by_query($sql);

?>

    <div class="row">
        
        <!-- Blog Entries Column -->
        <div class="col-md-12">
            
            <div class="thumbnails row">
                <?php foreach ($photos as $photo): ?>
                    
                        <div class="col-xs-6 col-md-3">
                            <a href="photo.php?id=<?php echo $photo->id ?>" class="thumbnail">
                                <img class="img-responcive home-page-picture" src="admin/<?php echo $photo->picture_path(); ?>" alt="">
                            </a>
                        </div>

                <?php endforeach ?>
            </div>

            <div class="row">
                <ul class="pager">
                    <?php if ($paginate->page_total() > 1): ?>
                        <?php 
                            if($paginate->has_next()) {
                                echo "<li class='next'><a href='index.php?page={$paginate->next()}'>NEXT</a></li>";
                            }
                        ?>
                        
                        <?php 
                            for ($i=1; $i <= $paginate->page_total(); $i++) { 
                                if ($i == $paginate->current_page) {
                                    echo "<li class='active'><a href='index.php?page={$i}'>{$i}</a></li>";
                                } else {
                                    echo "<li><a href='index.php?page={$i}'>{$i}</a></li>";
                                }
                            }
                         ?>

                        

                        <?php 
                            if($paginate->has_previous()) {
                                echo "<li class='previous'><a href='index.php?page={$paginate->previous()}'>PREVIOUS</a></li>";
                            }
                        ?>

                    <?php endif ?>
 
                </ul>
            </div>

        </div>

        <!-- Blog Sidebar Widgets Column -->
<!--         <div class="col-md-4">

            <?php //include("includes/sidebar.php"); ?>

        </div> -->

        <?php include("includes/footer.php"); ?>

    </div>