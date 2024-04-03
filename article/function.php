<!-- @import jquery & sweet alert  -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<?php 
// @Connection database
     $cn = new mysqli('localhost','root','','php_11_12_pro_cms','3306');
     date_default_timezone_set('Asia/Phnom_Penh');
     
     function getLogo($status){
          global $cn;
          $sql = "SELECT * FROM `logos` WHERE `status` = '$status' ORDER BY `id` DESC LIMIT 1";
          $rs = $cn->query($sql);
          $row = $rs->fetch_assoc();
          echo '<a href="index.php">
                    <img width="250" src="../admin/assets/image/'.$row['image'].'" alt="">
               </a>';
     }

     function getTrading(){
          global $cn;
          $sql = "SELECT * FROM `news` ORDER BY `id` DESC LIMIT 2";
          $rs = $cn->query($sql);
          while($row=$rs->fetch_assoc()){
               echo '<i class="fas fa-angle-double-right"></i>
                    <a href="news-detail.php?id='.$row['id'].'">'.$row['title'].'</a> &ensp;';
          }
     }

     function getDetail($id){
          global $cn;
          $sql = "SELECT * FROM `news` WHERE `id` = $id";
          $rs = $cn->query($sql);
          $row=$rs->fetch_assoc();
          echo '<div class="main-news">
                    <div class="thumbnail">
                    <img width="730" heigth="415" src="../admin/assets/image/'.$row['banner'].'">
                    </div>
                    <div class="detail">
                    <h3 class="title">'.$row['title'].'</h3>
                    <div class="date">'.$row['date'].'</div>
                    <div class="description">'.$row['description'].'</div>
                    </div>
               </div>';
          $cn->query("UPDATE `news` SET `viewers` = `viewers`+1 WHERE `id` = $id");
     }

     function get_type($id){
          global $cn;
          $sql = "SELECT `news_type` FROM `news` WHERE `id` = $id";
          $rs = $cn->query($sql);
          $row = $rs->fetch_assoc();
          return $row['news_type'];
     }
     function getRelated($id){
          global $cn;
          $type = get_type($id);
          $sql = "SELECT * FROM `news` WHERE `news_type` = '$type' 
                  AND `id` NOT IN($id) ORDER BY `id` DESC LIMIT 2";
          $rs = $cn->query($sql);
          while($row = $rs->fetch_assoc()){
               echo '<figure>
                         <a href="news-detail.php?id='.$row['id'].'">
                         <div class="thumbnail">
                              <img width="350" heigth="200" src="../admin/assets/image/'.$row['thumbnail'].'" alt="">
                         </div>
                         <div class="detail">
                              <h3 class="title">'.$row['title'].'</h3>
                              <div class="date">'.$row['date'].'</div>
                              <div class="description">'.$row['description'].'</div>
                         </div>
                         </a>
                    </figure>';
          }
     }

     function getViewer($type){
          global $cn;
          if($type == 'Treading'){
               $sql = "SELECT * FROM `news` ORDER BY `viewers` DESC LIMIT 1";
               $rs = $cn->query($sql);
               $row=$rs->fetch_assoc();
               echo '<figure>
                         <a href="news-detail.php">
                         <div class="thumbnail">
                              <img width="730" heigth="400" src="../admin/assets/image/'.$row['banner'].'" alt="">
                              <div class="title">
                              '.$row['title'].'
                              </div>
                         </div>
                         </a>
                    </figure>';
          }else{
              $sql = "SELECT * FROM `news` WHERE `id` != (SELECT `id` FROM `news` ORDER BY `viewers` DESC LIMIT 1) ORDER BY `viewers` DESC LIMIT 2";
              $rs = $cn->query($sql);
              while($row=$rs->fetch_assoc()){
                    echo '<figure>
                              <a href="news-detail.php?id='.$row['id'].'">
                              <div class="thumbnail">
                                   <img width="350" heigth="200" src="../admin/assets/image/'.$row['thumbnail'].'" alt="">
                              <div class="title">
                                   '.$row['title'].'
                              </div>
                              </div>
                              </a>
                         </figure>';
              } 
          }
     }

     function getListType($type){
          global $cn;
          $sql = "SELECT * FROM `news` WHERE `news_type` = '$type' ORDER BY `id` DESC LIMIT 3";
          $rs = $cn->query($sql);
          while($row=$rs->fetch_assoc()){
               echo '
               <div class="col-4">
                    <figure>
                              <a href="news-detail.php?id='.$row['id'].'">
                              <div class="thumbnail">
                                   <img width="350" heigth="200" src="../admin/assets/image/'.$row['thumbnail'].'" alt="">
                              <div class="title">
                                   '.$row['title'].'
                              </div>
                              </div>
                              </a>
                         </figure>
               </div>';
               
          }
     }