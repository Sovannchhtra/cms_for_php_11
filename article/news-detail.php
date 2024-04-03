<?php include('header.php');
    $id = $_GET['id'];
?>
<main class="news-detail">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-8">
                    <?php getDetail($id) ?>  
                </div>
                <div class="col-4">
                    <div class="relate-news">
                        <h3 class="main-title">Related News</h3>
                        <?php getRelated($id) ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
<?php include('footer.php'); ?>