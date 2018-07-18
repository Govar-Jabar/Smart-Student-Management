<?php 
include('class.token.php'); 
require 'inc/head.php';
global $re; 
?>
                <div class="row">
                    <div class="col-md-12">
                     <h2> خوێندکاران</h2>
                        <?php if($das==1){ ?>
                        <h5>دەستکاریکردنی زانیاری خوێندکاران و ڕێکخستنیان</h5>
                        <?php if (!isset($_GET['add'])) { ?>
                        <a href="user.php?multi" style="float: left;margin-right: 5px;" class="btn btn-info"><i class="fa fa-users"></i> زیادکردن بەکۆمەڵ </a>
                        <a href="student.php?add" style="float: left;" class="btn btn-success"><i class="fa icon-student"></i> زیادکردنی خوێندکار </a>
                        <?php }elseif(isset($_GET['add']) && !isset($_GET['id'])) { ?>
                        <a href="student.php" style="float: left;" class="btn btn-info"><i class="fa icon-student"></i> گەڕانەوە </a>
                        <?php }} ?>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                <div class="row">
                <div class="col-md-12">
                <?php if (isset($_GET['add'])) { if($das!=1){dh("index.php");}?>
                                 <div class="col-xs-12">
                                 <?php 
                                 if (!isset($_GET['id'])) { 
                                  ?>
                                      <div class="panel panel-default">
                                        <div class="panel-heading">زیادکردنی هەژمار بۆ خوێندکار</div>
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
                                              
                                              $stm = $db->prepare("INSERT INTO account (id, user, pass,r) VALUES (NULL, :user, :pass,3);");
                                              $stm->bindParam(":user", $user, PDO::PARAM_STR);
                                              $stm->bindParam(":pass", $p, PDO::PARAM_STR);

                                              $stm->execute();
                                              AddtoHistory("زیادکردنی هەژمار بۆ خوێندکار",home);
                                              re("success"," سوپاس "," هەژماری خوێندکار بەسەرکەوتویی زیادکرا. ");
                                              $db = null;
                                              direct("./student.php?add&id&u=$user");
                                              // $rowCount = $stm->rowCount();
                                              // if ($rowCount > 0) {
                                              //   echo add;
                                              // }else {
                                              //   echo eadd;
                                              // }
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
                                                  <input type="text"  name="user" id="user" class="form-control user" autocomplete="off">
                                                  <small style="display: none" class="help-block">ناوی بەکارهێنەر پێشتر بەکارهێنراوە!</small>
                                            </div>

                                            <div class="form-group">
                                                  <label class="req">وشەی نهێنی </label>
                                                  <input type="password"  name="np" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                  <label class="req">دووبارە وشەی نهێنی </label>
                                                  <input type="password" name="rnp" class="form-control">
                                            </div>
                                             <input  type="hidden" name="token" value="<?php echo Token::create(); ?>">
                                            <button type="submit" name="sub2" class="btn btn-default">زیادکردن</button>
                                            </form>
                                        </div>
                                    </div>
                                    <?php }else{ ?>
                                      <div class="panel panel-default">
                                        <div class="panel-heading">زانیاریەکانی خوێندکار</div>
                                        <div class="panel-body">
                                            <?php
                                            global $user;
                                            $id= output(@$_GET['id']);
                                            $u= output(@$_GET['u']);

                                            if (isset($_POST['sub'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                              $fname=output(@$_POST['fname']);
                                              $gen=output(@$_POST['gen']);
                                              $relig=output(@$_POST['relig']);
                                              $num=output(@$_POST['num']);
                                              $birth=output(@$_POST['birth']);
                                              $blood=output(@$_POST['blood']);
                                              $email=output(@$_POST['email']);
                                              $addr=output(@$_POST['addr']);
                                              $cl=output(@$_POST['cl']);
                                              $sd=output(@$_POST['sd']);
                                              $gr=output(@$_POST['gr']);
                                              upload();
                                              checkInput();
                                              if(!empty($fname) && !empty($gen) && (!empty($relig)  OR $feilds["stu_relig"]=="") && !empty($birth) && (!empty($blood)  OR $feilds["stu_bl"]=="") && !empty($email) && !empty($cl) && !empty($sd) && (!empty($num)  OR $feilds["stu_num"]=="") && (!empty($addr)  OR $feilds["stu_loc"]=="")){
                                              $stm = $db->prepare("INSERT INTO stu (id,user , fname, gen, relig, num, birth, blood, email, addr, class, img, sdate,gr) VALUES (NULL, :user,:fn, :g, :re, :n, :b, :bl, :e, :ad, :cl, :img, :sd, :gr);");
                                              $stm->bindParam(":fn", $fname, PDO::PARAM_STR);
                                              $stm->bindParam(":g", $gen, PDO::PARAM_STR);
                                              $stm->bindParam(":re", $relig, PDO::PARAM_STR);
                                              $stm->bindParam(":n", $num, PDO::PARAM_STR);
                                              $stm->bindParam(":b", $birth, PDO::PARAM_STR);
                                              $stm->bindParam(":bl", $blood, PDO::PARAM_STR);
                                              $stm->bindParam(":e", $email, PDO::PARAM_STR);
                                              $stm->bindParam(":ad", $addr, PDO::PARAM_STR);
                                              $stm->bindParam(":img", $img, PDO::PARAM_STR);
                                              $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
                                              $stm->bindParam(":sd", $sd, PDO::PARAM_STR);
                                              $stm->bindParam(":user", $u, PDO::PARAM_STR);
                                              $stm->bindParam(":gr", $gr, PDO::PARAM_STR);
                                              $stm->execute();
                                              AddtoHistory("زیادکردنی خوێندکار",home);
                                              re("success"," سوپاس "," زانیاری خوێندکار بەسەرکەوتویی زیادکرا. ");
                                              direct("./student.php");
                                              $db = null;
                                          
                                            }else {
                                              re("danger"," کێشە! "," تکایە خانەکان بە دروستی پڕبکەوە، وێنەی دروست هەڵبژێرە.");
                                            }
                                          }else {
                                              re("danger"," کێشە! "," کێشەیەک ڕویدا تکایە دووبارە هەوڵ بدەوە.");
                                            }
                                          }
checkInput();
?>
                                          <form action="" method="post" enctype="multipart/form-data">
                                          <div class="col-md-6">
                                              <div class="form-group">
                                                    <label>ناوی بەکارهێنەر</label>
                                                    <input disabled="" value="<?php echo $u; ?>" name="user" class="form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label class="req">ناوی تەواوەتی</label>
                                                    <input  value="<?=@$fname;?>" name="fname" class="form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label>وێنە</label>
                                                    <input type="file" accept="image/png, image/jpeg, image/gif, image/jpg"  name="fileToUpload" data-label="دیاریکردن" class="filepicker form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label class="req">ڕەگەز</label>
                                                    <select  class="selectpicker" data-width="100%"  name="gen" class="form-control">
                                                      <option value="1">نێر</option>
                                                      <option value="2">مێ</option>
                                                    </select>
                                              </div>
                                              <div class="form-group">
                                                    <label <?php echo $feilds["stu_relig"] != "" ? ' class="req"' : ''; ?> >بیرو باوەڕ (دین)</label>
                                                    <input  name="relig" value="<?=@$relig;?>" class="form-control">
                                              </div>                              
                                              <div class="form-group">
                                                    <label <?php echo $feilds["stu_num"] != "" ? ' class="req"' : ''; ?> >ژمارە مۆبایل</label>
                                                    <input  name="num" value="<?=@$num;?>" class="form-control">
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
                                                    <input  type="text" value="<?=@$birth;?>" id="date" autocomplete="off" name="birth" class="form-control">
                                              </div>
                                             <div class="col-md-6">
                                              <div class="form-group">
                                                    <label class="req">قۆناغ</label>
                                                    <select  class="selectpicker" data-width="100%" name="cl" class="form-control">
                                                      <option value="1">1</option>
                                                      <option value="2">2</option>
                                                      <option value="3">3</option>
                                                      <option value="4">4</option>
                                                    </select>
                                                </div>    
                                              </div>    
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="req">گروپ</label>
                                                    <select  class="selectpicker" data-width="100%"  name="gr" class="form-control">
                                                      <option value="A">A</option>
                                                      <option value="B">B</option>
                                                      <option value="C">C</option>
                                                      <option value="D">D</option>
                                                    </select>
                                                </div>
                                              </div><br>                                             
                                              <div class="form-group">
                                                    <label  <?php echo $feilds["stu_bl"] != "" ? ' class="req"' : ''; ?> >گروپی خوێن</label>
                                                    <select  class="selectpicker" data-width="100%"  name="blood" class="form-control">
                                                      <option value="A+">A+</option>
                                                      <option value="A-">A-</option>
                                                      <option value="B+">B+</option>
                                                      <option value="B-">B-</option>
                                                      <option value="O+">O+</option>
                                                      <option value="O-">O-</option>
                                                      <option value="AB+">AB+</option>
                                                      <option value="AB-">AB-</option>
                                                    </select>
                                              </div>
                                              <div class="form-group">
                                                    <label class="req">ئیمەیڵ</label>
                                                    <input  name="email" value="<?=@$email;?>" class="form-control">
                                              </div>                                              
                                              <div class="form-group">
                                                    <label class="req">بەرواری دەستپێکردن</label>
                                                    <input type="text" value="<?=@$sd;?>" id="date1" autocomplete="off" name="sd" class="form-control">
                                              </div>
                                              </div>
                                              <input type="hidden" name="token" value="<?php echo Token::create(); ?>">
                                              <div class="row roww">
                                                <button type="submit" name="sub" class="btn btn-default">زیادکردن</button>
                                              </div>
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
                              if($das!=1){dh("index.php");}
                              $stm = $db->prepare("DELETE FROM stu WHERE user=:id");
                              $stm->bindParam(":id", $del, PDO::PARAM_STR);
                              $stm->execute();
                              AddtoHistory("سڕئنەوەی خوێندکار",home);
                              re("danger","  خوێندکار ","بەسەرکەوتویی سڕایەوە.");
                              direct("student.php");
                            }
                          ?>
              <?php
                  $cl=output(@$_GET['cl']);
                  $gr=output(@$_GET['gr']);

              ?>
              <!-- /. ROW  -->
                <div class="row student">
                    <div class="col-md-12">
                      <form action="" method="get">
                        <div class="col-md-6">
                              <div class="form-group">
                                    <label>قۆناغ</label>
                                    <select class="selectpicker" data-width="100%" name="cl" class="form-control">
                                      <option <?php va("1",$cl); ?>  value="1">1</option>
                                      <option <?php va("2",$cl); ?>  value="2">2</option>
                                      <option <?php va("3",$cl); ?>  value="3">3</option>
                                      <option <?php va("4",$cl); ?>  value="4">4</option>
                                    </select>
                              </div>  
                        </div>
                        <div class="col-md-5">
                              <div class="form-group">
                                    <label>گروپ</label>
                                    <select class="selectpicker" data-width="100%" name="gr" class="form-control">
                                      <option <?php va("0",$gr); ?>  value="0">هەموو گروپەکان</option>
                                      <option <?php va("A",$gr); ?>  value="A">A</option>
                                      <option <?php va("B",$gr); ?>  value="B">B</option>
                                      <option <?php va("C",$gr); ?>  value="C">C</option>
                                      <option <?php va("D",$gr); ?>  value="D">D</option>
                                    </select>
                              </div>  
                        </div>                        
                     
                        <div class="col-md-1">
                              <div class="form-group">
                                    <label style="color: #fff;">_</label>
                                    <button  data-toggle="tooltip" data-placement="top" title="" data-original-title="گەڕان" type="submit" style="float: right;" class="btn btn-info"><i class="fa fa-search"></i> گەڕان</button>

                            </div>
                        </div>

                      </form>
                    </div>
                </div>
                <hr>
                 <!-- /. ROW  -->
                    <!-- Advanced Tables -->
                    <div class="panel panel-default" id="print">
                        <div class="panel-heading">
                             لیستی خوێندکاران 
                        </div>
                        <div class="panel-body">
                        <?php
                        $stm = $db->prepare("SELECT * FROM stu WHERE class=1");
                        if(isset($_GET['cl']) AND isset($_GET['gr']) AND $_GET['cl']!=""  AND $_GET['gr']!="0"){ 
                          $stm = $db->prepare("SELECT * FROM stu WHERE class=:cl AND gr=:gr");
                                                  $stm->bindParam(":gr",$gr, PDO::PARAM_STR);

                        }else {
                          if (@$_GET['gr']=="0") {
                              $stm = $db->prepare("SELECT * FROM stu WHERE class=:cl");
                          }
                        }

                        $stm->bindParam(":cl",$cl, PDO::PARAM_STR);
                        $stm->execute();
                        $rowCount = $stm->rowCount();
                        if($rowCount > 0){
                        ?>
                            <div class="table-responsive stu_tbl">
                                <table class="table table-striped table-bordered table-hover table-responsive"  id="advance2">
                                    <thead>
                                        <tr>

                                            <?php if ($das!=2) { ?>
                                            <th width="50px">#</th>
                                            <?php } ?>
                                            <th width="50px">وێنە</th>
                                            <th>ناوی تەواوەتی</th>
                                            <th width="50px">ڕەگەز</th>
                                            <th>ئیمەیڵ</th>
                                            <th width="50px">قۆناغ</th>
                                            <th width="50px">گروپ</th>
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
                                            <?php if ($das!=2) { ?>
                                            <td><?php echo $row['id']; ?></td>
                                            <?php } ?>
                                            <td><img class="atach" src="uploads/<?php echo $row['img']; ?>" alt=""></td>
                                            <td><?php echo $row['fname']; ?></td>
                                            <td class="center"><?php echo gen($row['gen']); ?></td>
                                            <td><?php echo $row['email']; ?></td>
                                            <td class="center"><?php echo $row['class']; ?></td>
                                            <td class="center"><?php echo $row['gr']; ?></td>
                                            <?php if($das==1){ ?>
                                            <td>
                                              <a href="profile.php?user=<?php echo $row['user'];if($das==1){echo "&r=3";} ?>" class="btn btn-success btn-xs mrg" data-toggle="tooltip" data-placement="top" title="بینین"><i class="fa fa-check-square-o"></i></a>

                                              <a href="profile.php?user=<?php echo $row['user'];if($das==1){echo "&r=3";} ?>#edit" data-toggle="tooltip" data-placement="top" class="btn btn-warning btn-xs mrg" title="دەستکاری"><i class="fa fa-edit"></i></a>

                                              <a href="student.php?del=<?php echo $row['user']; ?>" value="#go" id="btn-confirm" data-toggle="tooltip" data-placement="top" class="btn btn-danger btn-xs mrg confirmation" title="سڕینەوە"><i class="fa fa-trash-o"></i></a>
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

<?php include 'inc/foot.php'; ?>