<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<?php 
     $cn = new mysqli('localhost','root','','php_11_12_pro_cms','3306');
     date_default_timezone_set('Asia/Phnom_Penh');
     session_start();
     function uploadFile($type){
          $filename = $_FILES[$type]['name'];
          $tmp_name = $_FILES[$type]['tmp_name'];
          $image = time().'-'.$filename;
          $path = 'assets/image/'.$image;
          move_uploaded_file($tmp_name,$path);
          return $image;
     }
     function register(){
          global $cn;
          if(isset($_POST['btn_register'])){
               $username = $_POST['username'];
               $email = $_POST['email'];
               $password = $_POST['password'];
               $filename = $_FILES['profile'];
               $image = uploadFile('profile');
               $date = date('d/M/Y');
               if(!empty($username) && !empty($email) && !empty($password) && !empty($filename)){
                    $passwordHash = md5($password);
                    $sql = "INSERT INTO `users`(`username`, `email`, `password`, `profile`, `date`) 
                            VALUES ('$username','$email','$passwordHash','$image','$date')";
                    $rs = $cn->query($sql);
                    if($rs){
                         $sql = "SELECT `id` FROM `users` ORDER BY `id` DESC LIMIT 1";
                         $rs = $cn->query($sql);
                         $row = $rs->fetch_assoc();
                         $_SESSION['user'] = $row['id'];
                         header('location: index.php');
                    }
               }
          }
     }
     register();

     function login(){
          global $cn;
          if(isset($_POST['btn_login'])){
               $name_email = $_POST['name_email'];
               $password = $_POST['password'];
               if(!empty($name_email) && !empty($password)){
                    $passwordHash = md5($password);
                    $sql = "SELECT `id` FROM `users` 
                            WHERE (`username` = '$name_email' || `email` = '$name_email')
                            AND `password` = '$passwordHash'";
                    $rs = $cn->query($sql);
                    if($rs){
                         $row = $rs->fetch_assoc();
                         $_SESSION['user'] = $row['id'];
                         header('location: index.php');
                    }
               }
          }
     }
     login();

     function add_logo(){
          global $cn;
          if(isset($_POST['btn-add-logo'])){
               $status = $_POST['status'];
               $filename = $_FILES['image'];
               if(!empty($status) && !empty($filename)){
                    $image = uploadFile('image');
                    $sql = "INSERT INTO `logos`(`image`, `status`) 
                            VALUES ('$image','$status')";
                    $rs  = $cn->query($sql);
                    if($rs){
                         header('location: view-logo.php');
                    }
               }
          }
     }
     add_logo();

     function view_logo(){
          global $cn;
          $sql = "SELECT * FROM `logos` ORDER BY `id` DESC";
          $rs  = $cn->query($sql);
          if($rs){
               while($row = $rs->fetch_assoc()){
                    echo '<tr>                     
                              <td>'.$row['status'].'</td>
                              <td><img width="100" src="assets/image/'.$row['image'].'"/></td>
                              <td width="150px">
                              <a href="edit-logo.php?id='.$row['id'].'" class="btn btn-primary">Update</a>
                              <button type="button" remove-id="'.$row['id'].'" class="btn btn-danger btn-remove" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                   Remove
                              </button>
                              </td>
                         </tr>';
               }
          }
     }

     function edit_logo(){
          global $cn;
          if(isset($_POST['btn-edit-logo'])){
               $id = $_GET['id'];
               $status = $_POST['status'];
               $filename = $_FILES['image']['name'];

               $image = '';
               if(empty($filename)){
                    $image = $_POST['old_logo'];
               }else{
                    $image = uploadFile('image');
               }

               if(!empty($status) && !empty($image)){
                    $sql = "UPDATE `logos` 
                            SET `image`='$image',`status`='$status' 
                            WHERE `id`='$id'";
                    $res = $cn->query($sql);
                    if($res){
                         header('location: view-logo.php');
                    }
               }
          }
     }
     edit_logo();

     function delete_logo(){
          global $cn;
          if(isset($_POST['btn-remove-logo'])){
               $remove_id = $_POST['remove_id'];
               $sql = "DELETE FROM `logos` WHERE `id` = $remove_id";
               $res = $cn->query($sql);
               if($res){
                    echo '<script>
                              jQuery(document).ready(function(){
                                   swal({
                                        title: "Remove data successfully",
                                        text: "You clicked the button!",
                                        icon: "success",
                                   });
                              })
                         </script>';
               }
          }
     }
     delete_logo();

     function add_news(){
          global $cn;
          if(isset($_POST['btn-submit-news'])){
               $user_id = $_SESSION['user'];
               $date = date('d/M/Y');

               $title = $_POST['title'];
               $type = $_POST['type'];
               $category = $_POST['category'];
               $fileBanner = $_FILES['banner']['name'];
               $fileThumbnail = $_FILES['thumbnail']['name'];
               $description = $_POST['description'];

               $banner = '';
               $thumbnail = '';
               if(!empty($fileBanner)){
                    $banner = uploadFile('banner');
               }
               if(!empty($fileThumbnail)){
                    $thumbnail = uploadFile('thumbnail');
               }

               if(!empty($title) && !empty($type) && !empty($category) && !empty($banner) && !empty($thumbnail) && !empty($description))
               {
                    $sql = "INSERT INTO `news`(`user_id`, `title`, `date`, `description`, `banner`, `thumbnail`, `news_type`, `categories`) 
                            VALUES ('$user_id','$title','$date','$description','$banner','$thumbnail','$type','$category')";
                    $rs = $cn->query($sql);
                    if($rs){
                         echo '<script>
                              jQuery(document).ready(function(){
                                   swal({
                                        text: "You clicked the button!",
                                        icon: "success",
                                   });
                              })
                         </script>';
                    }
               }else{
                    echo '<script>
                              jQuery(document).ready(function(){
                                   swal({
                                        text: "You clicked the button!",
                                        icon: "error",
                                   });
                              })
                         </script>';
               }
          }
     }
     add_news();

     function getPagination($tb,$limit){
          global $cn;
          $sql = "SELECT COUNT(`id`) AS total_id FROM `$tb`";
          $res = $cn->query($sql);
          $row = $res->fetch_assoc();
          $page = ceil($row['total_id']/$limit);
          for($i=1;$i<=$page;$i++){
               echo '<li class="mx-2">
                         <a href="?page='.$i.'">'.$i.'</a>
                    </li>';
          }
     }
     function view_news($page,$limit){
          global $cn;
          $start = ($page-1)*$limit;
          $sql = "SELECT `t_new`.*,`t_user`.`username` 
                  FROM `news` AS `t_new` JOIN `users` AS `t_user` ON `t_new`.`user_id` = `t_user`.`id`
                  ORDER BY `id` DESC LIMIT $start,$limit";
          $rs = $cn->query($sql);
          while($row=$rs->fetch_assoc()){
               echo '<tr>
                         <td>'.$row['title'].'</td>
                         <td>'.$row['news_type'].'</td>
                         <td>'.$row['categories'].'</td>
                         <td>'.$row['date'].'</td>
                         <td>'.$row['username'].'</td>
                         <td>'.$row['viewers'].'</td>
                         <td><img width="80" src="assets/image/'.$row['thumbnail'].'"/></td>
                         <td width="150px">
                         <a href="edit-news.php?id='.$row['id'].'" class="btn btn-primary">Update</a>
                         <button type="button" remove-id="'.$row['id'].'" class="btn btn-danger btn-remove" data-bs-toggle="modal" data-bs-target="#exampleModal">
                              Remove
                         </button>
                         </td>
                    </tr>';
          }
     }

     function edit_news(){
          global $cn;
          if(isset($_POST['btn-edit-news'])){
               $id = $_GET['id'];
               $title = $_POST['title'];
               $type = $_POST['type'];
               $category = $_POST['category'];
               $fileBanner = $_FILES['banner']['name'];
               $fileThumbnail = $_FILES['thumbnail']['name'];
               $description = $_POST['description'];

               $banner = '';
               $thumbnail = '';
               if(empty($fileBanner)){
                    $banner = $_POST['old_banner'];
               }else{
                    $banner = uploadFile('banner');
               }
               if(empty($fileThumbnail)){
                    $thumbnail = $_POST['old_thumbnail'];
               }else{
                    $thumbnail = uploadFile('thumbnail');
               }
               if(!empty($title) && !empty($type) && !empty($category) && !empty($banner) && !empty($thumbnail) && !empty($description))
               {
                    $sql = "UPDATE `news` 
                            SET `title`='$title',`description`='$description',`banner`='$banner',`thumbnail`='$thumbnail',`news_type`='$type',`categories`='$category'
                            WHERE `id`='$id'";
                    $rs = $cn->query($sql);
                    if($rs){
                         header('location: view-news.php');
                    }
               }else{
                    echo '<script>
                              jQuery(document).ready(function(){
                                   swal({
                                        text: "You clicked the button!",
                                        icon: "error",
                                   });
                              })
                         </script>';
               }
          }
     }
     edit_news();

     function delete_news(){
          global $cn;
          if(isset($_POST['btn-delete-news'])){
               $remove_id = $_POST['remove_id'];
               $sql = "DELETE FROM `news` WHERE `id` = $remove_id";
               $res = $cn->query($sql);
               if($res){
                    echo '<script>
                              jQuery(document).ready(function(){
                                   swal({
                                        title: "Remove data successfully",
                                        text: "You clicked the button!",
                                        icon: "success",
                                   });
                              })
                         </script>';
               }
          }
     }
     delete_news();
?>