<?php 
include('class.token.php'); 
require 'inc/head.php';
global $re; 
?>
                <div class="row">
                    <div class="col-md-12">
                     <h2> مامۆستایان</h2>   
                        <?php if($das==1){ ?>
                        <h5>دەستکاریکردنی زانیاری مامۆستایان و ڕێکخستنیان</h5>
                        <?php if (!isset($_GET['add'])) { ?>
                        <a href="user.php?multi" style="float: left;margin-right: 5px;" class="btn btn-info"><i class="fa fa-users"></i> زیادکردن بەکۆمەڵ </a>
                        <a href="teacher.php?add" style="float: left;" class="btn btn-success"><i class="fa icon-teacher"></i> زیادکردنی مامۆستا </a>
                        <?php }elseif(isset($_GET['add']) && !isset($_GET['id'])) { ?>
                        <a href="teacher.php" style="float: left;" class="btn btn-info"><i class="fa icon-teacher"></i> گەڕانەوە </a>
                        <?php }} ?>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                <div class="row">
                <div class="col-md-12">
                <?php if (isset($_GET['add'])) { ?>
                                 <div class="col-xs-12">
                                 <?php 
                                 if (!isset($_GET['id'])) { 
                                  ?>
                                      <div class="panel panel-default">
                                        <div class="panel-heading">زیادکردنی هەژمار بۆ مامۆستا</div>
                                        <div class="panel-body">
                                        <?php
                                            if (isset($_POST['sub2'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                              $user=@output($_POST['user']);
                                              $pass=@output($_POST['np']);
                                              $p=password_hash($pass, PASSWORD_BCRYPT);
                                              $rnp=@output($_POST['rnp']);
                                              if (preg_match('/^[A-Za-z0-9_-]*$/', $user)){
                                              if(user($user)==0){
                                              if(!empty($user) && !empty($pass) && !empty($rnp) ){
                                              if ($pass==$rnp) {
                                              
                                              $stm = $db->prepare("INSERT INTO account (id, user, pass,r) VALUES (NULL, :user, :pass,2);");
                                              $stm->bindParam(":user", $user, PDO::PARAM_STR);
                                              $stm->bindParam(":pass", $p, PDO::PARAM_STR);

                                              $stm->execute();
                                              AddtoHistory("زیادکردنی هەژمار بۆ مامۆستا",home);
                                              re("success"," سوپاس "," هەژماری مامۆستا بەسەرکەوتویی زیادکرا. ");
                                              direct("./teacher.php?add&id&u=$user");
                                              
                                                }else{
                                                  re("danger"," هەڵە! "," پێویستە وشە نهێنیەکانت وەکو یەکبن.");
                                                }
                                                }else {
                                                  re("danger"," کێشە! "," تکایە خانەکان بە دروستی پڕبکەوە.");
                                                }

                                              }else {
                                                re("info","ناوی بەکارهێنەر "," پێشتر بەکاربراوە لەلایەن کەسێکی تر.");
                                              }
                                            }else {
                                                re("info","پێویستە "," ناوی بەکارهێنەر تەنها  زمانی ئینگلیزی بەکار بهێنیت.");
                                            }
                                            }else {
                                              re("danger"," کێشە! "," کێشەیەک ڕویدا تکایە دووبارە هەوڵ بدەوە.");
                                            }
                                          }
                                          ?>
                                            <form action="" method="post">
                                            <div class="form-group">
                                              <label class="req">ناوی بەکارهێنەر</label>
                                              <input type="text"  name="user" id="user"  class="form-control user" autocomplete="off">
                                              <small style="display: none" class="help-block">ناوی بەکارهێنەر پێشتر بەکارهێنراوە!</small>
                                            </div>
                                            <div class="form-group">
                                                  <label class="req">وشەی نهێنی </label>
                                                  <input  type="password"  name="np" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                  <label class="req">دووبارە وشەی نهێنی </label>
                                                  <input  type="password" name="rnp" class="form-control">
                                            </div>
                                             <input type="hidden" name="token" value="<?php echo Token::create(); ?>">
                                            <button type="submit" name="sub2" class="btn btn-default">زیادکردن</button>
                                            </form>
                                        </div>
                                    </div>
                                    <?php }else{ ?>
                                      <div class="panel panel-default">
                                        <div class="panel-heading">زانیاریەکانی مامۆستا</div>
                                        <div class="panel-body">
                                            <?php
                                            global $user;
                                            $u= output(@$_GET['u']);
                                            if (isset($_POST['sub'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                              $fname=output(@$_POST['fname']);
                                              $gen=output(@$_POST['gen']);
                                              $relig=output(@$_POST['relig']);
                                              $num=output(@$_POST['num']);
                                              $birth=output(@$_POST['birth']);
                                              $desig=output(@$_POST['desig']);
                                              $email=output(@$_POST['email']);
                                              $addr=output(@$_POST['addr']);
                                              $sd=output(@$_POST['sd']);
                                              upload();
                                              checkInput();
                                              if(!empty($fname) && !empty($gen) && (!empty($desig)  OR $feilds["tea_desig"]=="") && !empty($birth) && !empty($email) && !empty($sd) && (!empty($num)  OR $feilds["tea_num"]=="") &&  (!empty($addr)  OR $feilds["tea_loc"]=="")){
                                              $stm = $db->prepare("INSERT INTO tea (id,user , fname, gen, relig, num, birth, desig, email, addr, img, sdate) VALUES (NULL, :user,:fn, :g, :re, :n, :b, :desig, :e, :ad, :img, :sd);");
                                              $stm->bindParam(":fn", $fname, PDO::PARAM_STR);
                                              $stm->bindParam(":g", $gen, PDO::PARAM_STR);
                                              $stm->bindParam(":re", $relig, PDO::PARAM_STR);
                                              $stm->bindParam(":n", $num, PDO::PARAM_STR);
                                              $stm->bindParam(":b", $birth, PDO::PARAM_STR);
                                              $stm->bindParam(":desig", $desig, PDO::PARAM_STR);
                                              $stm->bindParam(":e", $email, PDO::PARAM_STR);
                                              $stm->bindParam(":ad", $addr, PDO::PARAM_STR);
                                              $stm->bindParam(":img", $img, PDO::PARAM_STR);
                                              $stm->bindParam(":sd", $sd, PDO::PARAM_STR);
                                              $stm->bindParam(":user", $u, PDO::PARAM_STR);
                                              $stm->execute();
                                              AddtoHistory("زیادکردنی مامۆستا",home);
                                              re("success"," سوپاس "," زانیاری مامۆستا بەسەرکەوتویی زیادکرا. ");
                                              direct("./teacher.php");
                                              $db = null;

                                            }else {
                                              re("danger"," کێشە! "," تکایە خانەکان بە دروستی پڕبکەوە، وێنەی دروست هەڵبژێرە.");
                                            }
                                          }else {
                                              re("danger"," کێشە! "," کێشەیەک ڕویدا تکایە دووبارە هەوڵ بدەوە.");
                                            }
                                          }                                            
?>
                                          <form action="" method="post" enctype="multipart/form-data">
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                    <label>ناوی بەکارهێنەر</label>
                                                    <input disabled="" value="<?php echo $u; ?>" name="user" class="form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label>وێنە</label>
                                                    <input type="file" accept="image/png, image/jpeg, image/gif, image/jpg"  name="fileToUpload" data-label="دیاریکردن" class="filepicker form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label class="req">ناوی تەواوەتی</label>
                                                    <input  value="<?=@$fname;?>" name="fname" class="form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label class="req">ڕەگەز</label>
                                                    <select  class="selectpicker" data-width="100%"  name="gen" class="form-control">
                                                      <option value="1">نێر</option>
                                                      <option value="2">مێ</option>
                                                    </select>
                                              </div>
                                              <div class="form-group">
                                                    <label <?php echo $feilds["tea_relig"] != "" ? ' class="req"' : ''; ?>>بیرو باوەڕ (دین)</label>
                                                    <input  value="<?=@$relig;?>" name="relig" class="form-control">
                                              </div>                              
                                              <div class="form-group">
                                                    <label <?php echo $feilds["tea_num"] != "" ? ' class="req"' : ''; ?>>ژمارە مۆبایل</label>
                                                    <input value="<?=@$num;?>"  name="num" class="form-control">
                                              </div>
                                              </div>
                                            <div class="col-md-6">
                                              <div class="form-group">
                                                    <label <?php echo $feilds["stu_loc"] != "" ? ' class="req"' : ''; ?>>ناونیشان</label>
                                                        <div class="typeahead__container">
                                                          <div class="typeahead__field">
                                                              <span class="typeahead__query">
                                                                  <input type="text" value="<?=@$addr;?>" name="addr" type="search" autocomplete="off" class="form-control" id="loc">
                                                              </span>
                                                          </div>
                                                      </div>
                                              </div><br>
                                              <div class="form-group">
                                                    <label class="req">بەرواری لەدایک بوون</label>
                                                    <input value="<?=@$birth;?>" type="text" id="date" autocomplete="off" value="01/01/1985" name="birth" class="form-control">
                                              </div>
           
                                              <div class="form-group">
                                                    <label <?php echo $feilds["tea_desig"] != "" ? ' class="req"' : ''; ?>>پسپۆڕی</label>
                                                    <input value="<?=@$desig;?>" type="text" name="desig" class="form-control" autocomplete="off">
                                              </div>
                                              <div class="form-group">
                                                    <label class="req">ئیمەیڵ</label>
                                                    <input  name="email" value="<?=@$email;?>" class="form-control">
                                              </div>                                              
                                              <div class="form-group">
                                                    <label class="req">بەرواری دەستپێکردن</label>
                                                    <input type="text" value="<?=@$sd;?>" id="date1" autocomplete="off" name="sd" class="form-control">
                                              </div>
                                              <br><br><br><br>

                                              </div>
                                              <input type="hidden" name="token" value="<?php echo Token::create(); ?>">
                                              <button type="submit" name="sub" class="btn btn-default">زیادکردن</button>
                                            </form>
                                        </div>
                                    </div>
                                    <?php } ?>
                                  </div>
                                  <!-- PART -->

                                </div>
                        <?php
                        }else{ 
                            $del = output(@$_GET['del']);
                            if (isset($del) && $del!="") {
                              $stm = $db->prepare("DELETE FROM tea WHERE user=:id");
                              $stm->bindParam(":id", $del, PDO::PARAM_STR);
                              $stm->execute();
                              AddtoHistory("سڕئنەوەی مامۆستا",home);
                              re("danger","  مامۆستا ","بەسەرکەوتویی سڕایەوە.");
                              //direct("teacher.php");
                            }
                          ?>
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             لیستی مامۆستایان
                        </div>
                        <div class="panel-body">
                        <?php

                        $stm = $db->prepare("SELECT * FROM tea");
                        $stm->execute();
                        $rowCount = $stm->rowCount();
                        if($rowCount > 0){
                        ?>

                            <div class="table-responsive">
                                <table id="advance" class="table table-striped table-bordered table-hover" data-id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th width="50px">#</th>
                                            <th width="50px">وێنە</th>
                                            <th>ناوی تەواوەتی</th>
                                            <th>وانەکان</th>
                                            <?php if($das==1){ ?>
                                            <th width="110px">کردار</th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $nu = 0;
                                    while($row = $stm->fetch(PDO::FETCH_ASSOC)) { 
                                      ?>
                                        <tr class="<?php if($nu % 2==0){echo 'odd';}else{echo 'even';} ?>">
                                            <td><?php echo $row['id']; ?></td>
                                            <td><img class="atach" src="uploads/<?php echo $row['img']; ?>" alt=""></td>
                                            <td><?php echo $row['fname']; ?></td>
                                            <td><?php 
                                                  $n=$r=$i="";
                                                  $stm1 = $db->prepare("SELECT * FROM sub WHERE tea=:id");
                                                  $stm1->bindParam(":id", $row['id'], PDO::PARAM_STR);
                                                  $stm1->execute();
                                                  $rowCount1 = $stm1->rowCount();
                                                  if ($rowCount1>0) {
                                                    
                                                    while($row1 = $stm1->fetch(PDO::FETCH_ASSOC)) {
                                                      if($rowCount1!=1 AND $i!=0){$n=" , ";}
                                                      $r = $r.$n.$row1['sn'];
                                                      $i++;
                                                    }
                                                    echo $r;
                                                  }
                                             ?></td>
                                             <?php if($das==1){ ?>
                                            <td>
                                              <a href="profile.php?user=<?php echo $row['user']; if($das==1){echo "&r=2";} ?>" class="btn btn-success btn-xs mrg" data-toggle="tooltip" data-placement="top" title="بینین"><i class="fa fa-check-square-o"></i></a>

                                              <a href="profile.php?user=<?php echo $row['user']; if($das==1){echo "&r=2";} ?>#edit" data-toggle="tooltip" data-placement="top" class="btn btn-warning btn-xs mrg" title="دەستکاری"><i class="fa fa-edit"></i></a>

                                              <a href="teacher.php?del=<?php echo $row['user']; ?>" value="#go" id="btn-confirm" data-toggle="tooltip" data-placement="top" class="btn btn-danger btn-xs mrg confirmation" title="سڕینەوە"><i class="fa fa-trash-o"></i></a>
                                              </td>
                                              <?php } ?>

                                        </tr>
                                        <?php
                                              $nu++;
                                            }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                            <?php 

                            } else {
                                echo 'هیچ ئەنجامێك نەدۆزراوە!';
                              }
                           ?>
                        </div>
                    </div>
                    <!--End Advanced Tables -->
                    <?php } ?>
                </div>
            </div>
                <!-- /. ROW  -->

			           </div>
                 <!-- /. ROW  -->



<div class="alert" role="alert" id="result"></div>

<?php
$db = null;
 include 'inc/foot.php'; ?>