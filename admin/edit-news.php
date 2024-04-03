<?php 
    include('sidebar.php');
    $id = $_GET['id'];
    $sql = "SELECT * FROM `news` WHERE `id` = $id";
    $res = $cn->query($sql);
    $row = $res->fetch_assoc();
?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>Edit Sport News</h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" name="title" value="<?php echo $row['title'] ?>" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-select" name="type">
                                            <option value="sport" <?php echo ($row['news_type'] === 'sport') ? 'selected' : '' ?> >SPORT</option>
                                            <option value="social" <?php echo ($row['news_type'] === 'social') ? 'selected' : '' ?> >SOCIAL</option>
                                            <option value="entertanment" <?php echo ($row['news_type'] === 'entertanment') ? 'selected' : '' ?> >ENTERTAINMENT</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-select" name="category">
                                            <option value="national" <?php echo ($row['categories'] === 'national') ? 'selected' : '' ?> >National</option>
                                            <option value="international" <?php echo ($row['categories'] === 'international') ? 'selected' : '' ?> >International</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Banner <font color="red">(size 730 x 415)</font> </label>
                                        <input type="file" name="banner" class="form-control mb-2">
                                        <img width="120" src="assets/image/<?php echo $row['banner'] ?>" alt="">
                                        <input type="hidden" name="old_banner" value="<?php echo $row['banner'] ?>" id="">
                                    </div>
                                    <div class="form-group">
                                        <label>Thumbnail <font color="red">(size 350 x 200)</font></label>
                                        <input type="file" name="thumbnail" class="form-control mb-2">
                                        <img width="120" src="assets/image/<?php echo $row['thumbnail'] ?>" alt="">
                                        <input type="hidden" name="old_thumbnail" value="<?php echo $row['thumbnail'] ?>" id="">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description"><?php echo $row['description'] ?></textarea>
                                    </div>
                                    <div class="form-group">
                                        <a href="view-news.php" class="btn btn-danger">Danger</a>
                                        <button type="submit" name="btn-edit-news" class="btn btn-primary">Submit</button>
                                    </div>
                                </form>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>