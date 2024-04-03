<?php 
    include('sidebar.php');
?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>Add Sport News</h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input type="text" name="title" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Type</label>
                                        <select class="form-select" name="type">
                                            <option value="sport">SPORT</option>
                                            <option value="social">SOCIAL</option>
                                            <option value="entertanment">ENTERTAINMENT</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Category</label>
                                        <select class="form-select" name="category">
                                            <option value="national">National</option>
                                            <option value="international">International</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Banner <font color="red">(size 730 x 415)</font> </label>
                                        <input type="file" name="banner" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Thumbnail <font color="red">(size 350 x 200)</font></label>
                                        <input type="file" name="thumbnail" class="form-control">
                                    </div>
                                    <div class="form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" name="description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <a href="view-news.php" class="btn btn-danger">Danger</a>
                                        <button type="submit" name="btn-submit-news" class="btn btn-primary">Submit</button>
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