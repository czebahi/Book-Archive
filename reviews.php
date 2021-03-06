<?php 

    include("header.php");

    $whereCondition = NULL;
    $search = NULL;

    # If where condition has been passed from previous page, grab it
    if(isset($_SESSION['whereCondition'])){
        $whereCondition = $_SESSION['whereCondition'];
        # Unset the value in the session array
        unset($_SESSION['whereCondition']);
    }

    /* 
        If the search keywords have been passed from previous page in SESSION array,
        Grab the information
    */

    if(isset($_SESSION['search'])){
        $search = $_SESSION['search'];
        # Unset the value in the session array
        unset($_SESSION['search']);
    }

    # Get all the book reviews
    $books = Book::getAll($whereCondition);

    /*
        Get all the genres (for side nav bar)
        And sort them passing the where clause as the optional parameter
    */
    $genres = Genre::getAll(" ORDER BY name");
?>

<!-- Page Content -->
<div class="container p-4 mt-2 mb-4 mr-auto">

    <div class="row">

        <!-- entire left column -->
        <div class="col-md-8">

            <div class="row">
                <div class="col-md-5">
                    <h4>Reviews</h4>
                </div>
                <div class="col-md-7">
                    <!-- If the user is logged in, make post button visible -->
                
                    <!-- post button OR message to log in for posting -->
                    <?php if(isset($user)&&$user->is_logged()) { ?>
                        <p class="text-right"><a href="post.php" class="btn btn-dark text-light">Post</a></p>
                    <?php }else{ ?>
                    <p class=" h6 text-right text-muted mt-2">Please Sign In to Post!</p>
                    <?php } ?>

                <!-- post button -->
                </div>
            </div>
            <?php if($search!==null){
                    echo '<p>You searched for <strong>'.$search.'</strong></p>';
                }?>

            <!-- Book Reviews -->
            <?php foreach($books as $book): ?>

            <!-- card for 1 book review -->
            <div class="card mb-4 bg-light">
                <div class="row">
                    <div class="col-md-3 text-center p-3 mt-2">
                        <img width="100" height="100" src="
                            <?php if(!empty($book->image_path)){echo $imagePath.$book->image_path;}
                                else{echo "shared/img/post.png";}?>" 
                            alt="<?php echo $book->title; ?>">
                    </div>
                    <div class="col-md-9">
                        <div class="card-body">
                            <h4 class="card-title"><?php echo $book->title; ?></h4>
                            <p class="card-text"><?php echo $book->review; ?></p>
                            <a href="review_detail.php?id=<?php echo $book->id; ?>" class="btn btn-outline-dark">Read More</a>
                        </div>
                    </div>
                </div>
            </div>

            <?php endforeach; ?>


            <!-- Pagination (NOT finished)-->
            <ul class="pagination justify-content-center mb-4">
                <li class="page-item">
                    <a class="page-link" href="#">&larr; Older</a>
                </li>
                <li class="page-item disabled">
                    <a class="page-link" href="#">Newer &rarr;</a>
                </li>
            </ul>
            <!-- ./Pagination -->

        </div>
        <!-- entire left column -->

        <!-- Sidebar Widgets Column -->
        <div class="col-md-4">

            <div class="container text-center mt-4">
                <img class="img-fluid img-responsive" src="shared/img/search.png" 
                    width="150" height="150"/>
            </div>

            <!-- Search Widget -->
            <div class="card my-4">
                <h5 class="card-header">Search</h5>
                <div class="card-body">
                    <div class="input-group">
                        <form class="form-inline" action="Controller/search_controller.php" method="POST">
                            <input type="hidden" name="action" value="title_search"/>
                            <input type="text" class="form-control" name="search" placeholder="Search for...">
                            <input class="btn btn-secondary" type="submit" value="Search"/>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Categories Widget -->
            <div class="card my-4">
                <h5 class="card-header">Genres</h5>
                <div class="card-body">
                    <div class="row">
                        <div>
                            <form action="Controller/search_controller.php" method="POST">
                                <input type="hidden" value="genre_search" name="action"/>
                                <ul>
                                <!-- Loop through all the genres -->
                                <?php foreach($genres as $genre):?>
                                    <li>
                                        <input type="submit" name="search" class="btn btn-link" value="<?php echo $genre->name;?>"/>
                                    </li>
                                    <?php endforeach; ?>
                                </ul>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- container -->

<?php include("footer.php"); ?>