<?php 
    include('sidebar.php');
    $id = $_GET['id'];
    $sql = "SELECT * FROM `logos` WHERE `id` = $id";
    $res = $cn->query($sql);
    $row = $res->fetch_assoc();
?>
                <div class="col-10">
                    <div class="content-right">
                        <div class="top">
                            <h3>Edit News Logo</h3>
                        </div>
                        <div class="bottom">
                            <figure>
                                <form method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-select">
                                            <option value="header" <?php echo ($row['status'] === 'header') ? 'selected' : ''?> >Header</option>
                                            <option value="footer" <?php echo ($row['status'] === 'footer') ? 'selected' : ''?> >Footer</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Logo</label>
                                        <input type="file" name="image" class="form-control mb-3">
                                        <img width="100" src="assets/image/<?php echo $row['image'] ?>" alt="">
                                        <input type="hidden" value="<?php echo $row['image'] ?>" name="old_logo" id="">
                                    </div>
                                    <div class="form-group">
                                        <a href="view-logo.php" class="btn btn-danger">Cancel</a>
                                        <button type="submit" name="btn-edit-logo" class="btn btn-primary">Submit</button>
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