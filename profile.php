<?php 
include('class.token.php');
require 'inc/head.php';
 ?>
                <div class="row">
                    <div class="col-md-12">
                     <h2>زانیاریەکانم</h2>   
                        <h5>دەستکاریکردنی زانیاریەکانت و ڕێکخستنیان</h5>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />

                 <!-- /. ROW  -->
                      <div class="panel panel-default">
                        <div class="panel-heading">
                            زانیاریەکانم
                        </div>
                        <div class="panel-body">
                            <ul class="nav nav-tabs nav1">
                                <li class="active"><a href="#home" data-toggle="tab">زانیاریەکانم</a>
                                </li>
                                <li class=""><a href="#edit" data-toggle="tab">دەستکاریکردن</a>
                                </li>
                                <li class=""><a href="#social" data-toggle="tab">تۆڕە کۆمەڵایەتیەکان</a>
                                </li>

                            </ul>

                            <div class="tab-content">
                            <?php

                                $user= output(@$_GET['user']);
                                if (!isset($_GET['user']) OR $_GET['user']=="") {
                                  $user=$un;
                                }
                                 $stm = $db->prepare("SELECT * FROM stu WHERE user=:user");
                                if ($das==2) {
                                  $stm = $db->prepare("SELECT * FROM tea WHERE user=:user");
                                }

                                 
                                if ($das==1) {
                                    $stm = $db->prepare("SELECT * FROM stu WHERE user=:user");
                                  if (@$_GET['r']==2) {
                                  $stm = $db->prepare("SELECT * FROM tea WHERE user=:user");
                                  }
                                }

                                $stm->bindParam(":user", $user, PDO::PARAM_STR);
                                $stm->execute();
                                $fetch = $stm->fetch(PDO::FETCH_OBJ);
                                $rowCount = $stm->rowCount();
                            ?>
                                <div class="tab-pane fade active in" id="home">
                                <?php if($rowCount > 0){ ?>
                                    <h4>زانیاری کەسی</h4><br>
                                    <div class="col-xs-6" style="float: right;">
                                      <div class="form-group">
                                        <h4>ناو: <?php echo $fetch->fname; ?></h4>
                                      </div>
                                      <div class="form-group">
                                        <h4>ڕەگەز : <?php echo gen($fetch->gen); ?></h4>
                                      </div>
                                      <div class="form-group">
                                        <h4>بیرو باوەڕ (دین) : <?php echo $fetch->relig; ?></h4>
                                      </div>
                                      <div class="form-group">
                                        <h4>ناونیشان : <?php echo $fetch->addr; ?></h4>
                                      </div>
                                    </div>
                                    <div class="col-xs-6" style="float: right;">
                                      <div class="form-group">
                                        <h4>بەرواری لەدایکبوون: <?php echo $fetch->birth; ?></h4>
                                      </div>
                                      <?php if($das==3){ ?>
                                      <div class="form-group">
                                        <h4>قۆناغ : <?php echo $fetch->class; ?></h4>
                                      </div>                                        
                                      <div class="form-group">
                                        <h4>گروپ : <?php cl($fetch->gr); ?></h4>
                                      </div>                                      
                                      <div class="form-group">
                                        <h4>گروپی خوێن : <?php echo $fetch->blood; ?></h4>
                                      </div>
                                      <?php }elseif($das==2) { ?>
                                      <div class="form-group">
                                        <h4>پسپۆڕی : <?php echo $fetch->desig; ?></h4>
                                      </div>                      
                                      <?php } ?>
                                      <div class="form-group">
                                        <h4>ئیمەیڵ : <?php echo $fetch->email; ?></h4>
                                      </div>
                                    </div>
                                    
                                    <?php }else {
                                      e4();
                                    } ?>
                                  </div>                                  
                                <div class="tab-pane fade" id="edit">
                              <br>
                              <div class="row">
                                    <?php if($rowCount > 0){ ?>
                                    <?php if($fetch->gen==1){$g1 = 'selected=""';}else{$g2 = 'selected=""';} ?>
                                <div class="col-xs-12">
                                  <div class="col-xs-6" style="float: right;">
                                      <div class="panel panel-default">
                                        <div class="panel-heading">زانیاریەکانم</div>
                                        <div class="panel-body">
                                        <?php                                              
                                        $user=output(@$_GET['user']);
                                        if ($das==1) {
                                          $das2=$das;
                                          if (@$_GET['r']==2) {
                                            $das2=2;
                                          }elseif (@$_GET['r']==3) {
                                            $das2=3;
                                          }
                                        }

                                          if (!isset($_GET['user']) OR $_GET['user']=="") {
                                            $user=$un;
                                          }
                                        if(@$das2==3 OR @$das2==1){
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
                                              $gr=output(@$_POST['gr']);
                                                upload();
                                              checkInput();
                                              if(!empty($fname) && !empty($gen) && (!empty($relig)  OR $feilds["stu_relig"]=="") && !empty($birth) && (!empty($blood)  OR $feilds["stu_bl"]=="") && !empty($email) && !empty($cl) && (!empty($num)  OR $feilds["stu_num"]=="") && ($uploadOk==1 OR $feilds["stu_img"]=="") && (!empty($addr)  OR $feilds["stu_loc"]=="")){
                                                $stm = $db->prepare("UPDATE stu SET fname=:fn,gen=:g,relig=:re,num=:n,birth=:b,blood=:bl,email=:e,addr=:ad WHERE user=:id");
                                                if ($uploadOk==1 AND $_FILES['fileToUpload']['size'] != 0 ) {
                                                  $stm = $db->prepare("UPDATE stu SET fname=:fn,gen=:g,relig=:re,num=:n,birth=:b,blood=:bl,email=:e,addr=:ad,img=:img WHERE user=:id");
                                                  $stm->bindParam(":img", $img, PDO::PARAM_STR);
                                                }

                                              $stm->bindParam(":id", $user, PDO::PARAM_STR);
                                              $stm->bindParam(":fn", $fname, PDO::PARAM_STR);
                                              $stm->bindParam(":g", $gen, PDO::PARAM_STR);
                                              $stm->bindParam(":re", $relig, PDO::PARAM_STR);
                                              $stm->bindParam(":n", $num, PDO::PARAM_STR);
                                              $stm->bindParam(":b", $birth, PDO::PARAM_STR);
                                              $stm->bindParam(":bl", $blood, PDO::PARAM_STR);
                                              $stm->bindParam(":e", $email, PDO::PARAM_STR);
                                              $stm->bindParam(":ad", $addr, PDO::PARAM_STR);
                                              // $stm->bindParam(":c", $cl, PDO::PARAM_STR);
                                              // $stm->bindParam(":gr", $gr, PDO::PARAM_STR);
                                              $stm->execute();
                                              $rowCount = $stm->rowCount();
                                              if ($rowCount > 0) {
                                                AddtoHistory("دەستکاریکردنی زانیاریەکان",home);
                                                re("success"," سوپاس ","زانیاریەکانت بەسەرکەوتویی نوێکرانەوە.");
                                              }else {
                                                re("info"," ئاگادارکردنەوە ","هیچ گۆڕانکاریەک ئەنجام نەدرا.");
                                              }

                                              direct(home.'#edit');
                                            }else {
                                              re("danger"," کێشە! "," تکایە خانەکان بە دروستی پڕبکەوە. ");
                                            }
                                          }else {
                                              re("danger"," کێشە! "," کێشەیەک ڕویدا تکایە دووبارە هەوڵ بدەوە.");
                                            }
                                            }
                                          }
                                          // Teacher Teacher Teacher Teacher Teacher Teacher
                                          elseif(@$das2==2) {
                                            if (isset($_POST['sub'])) {
                                              if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                              $fname=output(@$_POST['fname']);
                                              $gen=output(@$_POST['gen']);
                                              $relig=output(@$_POST['relig']);
                                              $num=output(@$_POST['num']);
                                              $birth=output(@$_POST['birth']);
                                              $email=output(@$_POST['email']);
                                              $addr=output(@$_POST['addr']);
                                              $desig=output(@$_POST['desig']);
                                              // if(!empty($fname) && !empty($gen) && !empty($relig) && !empty($num) && !empty($birth) && !empty($email) && !empty($addr) && !empty($desig)){
                                                upload();
                                                $stm = $db->prepare("UPDATE tea SET fname=:fn,gen=:g,relig=:re,num=:n,birth=:b,desig=:desig,email=:e,addr=:ad WHERE user=:id");
                                                if ($uploadOk==1 AND $_FILES['fileToUpload']['size'] != 0 ) {
                                                  $stm = $db->prepare("UPDATE tea SET fname=:fn,gen=:g,relig=:re,num=:n,birth=:b,desig=:desig,email=:e,addr=:ad,img=:img WHERE user=:id");
                                                  $stm->bindParam(":img", $img, PDO::PARAM_STR);
                                                }

                                              $stm->bindParam(":id", $user, PDO::PARAM_STR);
                                              $stm->bindParam(":fn", $fname, PDO::PARAM_STR);
                                              $stm->bindParam(":g", $gen, PDO::PARAM_STR);
                                              $stm->bindParam(":re", $relig, PDO::PARAM_STR);
                                              $stm->bindParam(":n", $num, PDO::PARAM_STR);
                                              $stm->bindParam(":b", $birth, PDO::PARAM_STR);
                                              $stm->bindParam(":desig", $desig, PDO::PARAM_STR);
                                              $stm->bindParam(":e", $email, PDO::PARAM_STR);
                                              $stm->bindParam(":ad", $addr, PDO::PARAM_STR);
                                              $stm->execute();
                                              $rowCount = $stm->rowCount();
                                              if ($rowCount > 0) {
                                                re("success"," سوپاس ","زانیاریەکانت بەسەرکەوتویی نوێکرانەوە.");
                                                AddtoHistory("دەستکاریکردنی زانیاریەکان",home);
                                              }else {
                                                re("info"," ئاگادارکردنەوە ","هیچ گۆڕانکاریەک ئەنجام نەدرا.");
                                              }

                                              direct(home.'#edit');
                                            // }else {
                                            //   re("danger"," کێشە! "," تکایە خانەکان بە دروستی پڕبکەوە. ");
                                            // }
                                          }else {
                                              re("danger"," کێشە! "," کێشەیەک ڕویدا تکایە دووبارە هەوڵ بدەوە.");
                                            }
                                            }
                                          }
$dstr='stu';
if($das==2){
$dstr='tea';
}

                                            ?>
                                          <form action="#edit" method="post"  enctype="multipart/form-data">
                                              <div class="form-group">
                                                    <label  class="req">ناوی تەواوەتی</label>
                                                    <input  value="<?php echo $fetch->fname; ?>" name="fname" class="form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label>وێنە</label>
                                                    <input type="file" accept="image/png, image/jpeg, image/gif, image/jpg"  name="fileToUpload" data-label="دیاریکردن" class="filepicker form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label  class="req">ڕەگەز</label>
                                                    <select class="selectpicker" data-width="100%"   name="gen" class="form-control">
                                                      <option <?php echo @$g1; ?> value="1">نێر</option>
                                                      <option <?php echo @$g2; ?> value="2">مێ</option>
                                                    </select>
                                              </div>
                                              <div class="form-group">
                                                    <label <?php echo $feilds["stu_relig"] != "" ? ' class="req"' : ''; ?>>بیرو باوەڕ (دین)</label>
                                                    <input  value="<?php echo $fetch->relig; ?>" name="relig" class="form-control">
                                              </div>                              
                                              <div class="form-group">
                                                    <label <?php echo $feilds[$dstr."_num"] != "" ? ' class="req"' : ''; ?>>ژمارە مۆبایل</label>
                                                    <input  value="<?php echo $fetch->num; ?>" name="num" class="form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label <?php echo $feilds[$dstr."_loc"] != "" ? ' class="req"' : ''; ?>>ناونیشان</label>
                                                        <div class="typeahead__container">
                                                          <div class="typeahead__field">
                                                              <span class="typeahead__query">
                                                                  <input type="text" value="<?php echo $fetch->addr; ?>" name="addr" type="search" autocomplete="off" class="form-control" id="loc">
                                                              </span>
                                                          </div>
                                                      </div>
                                              </div><br>
                                              <div class="form-group">
                                                    <label class="req">بەرواری لەدایک بوون</label>
                                                    <input type="text" id="date"  autocomplete="off"  value="<?php echo $fetch->birth; ?>" name="birth" class="form-control">
                                              </div>
                                              <?php if($das==3 OR $das==1){ ?>
<!--                                               <div class="col-md-6">
                                              <div class="form-group">
                                                    <label class="req">قۆناغ</label>
                                                    <select  class="selectpicker" data-width="100%"  name="cl" class="form-control">
                                                      <option <?php bl("1","class"); ?>  value="1">1</option>
                                                      <option <?php bl("2","class"); ?>  value="2">2</option>
                                                      <option <?php bl("3","class"); ?>  value="3">3</option>
                                                      <option <?php bl("4","class"); ?>  value="4">4</option>
                                                    </select>
                                              </div>                                              
                                              </div>                                              
                                              <div class="col-md-6">
                                              <div class="form-group">
                                                    <label class="req">گروپ</label>
                                                    <select  class="selectpicker" data-width="100%"  name="gr" class="form-control">
                                                      <option <?php bl("A","gr"); ?>  value="A">A</option>
                                                      <option <?php bl("B","gr"); ?>  value="B">B</option>
                                                      <option <?php bl("C","gr"); ?>  value="C">C</option>
                                                      <option <?php bl("D","gr"); ?>  value="D">D</option>
                                                    </select>
                                              </div>                                              
                                              </div> -->
                                              <div class="form-group">
                                                    <label <?php echo $feilds["stu_bl"] != "" ? ' class="req"' : ''; ?>>گروپی خوێن</label>

                                                    <select  class="selectpicker" data-width="100%"  name="blood" class="form-control">
                                                      <option <?php bl("A+","blood"); ?>  value="A+">A+</option>
                                                      <option <?php bl("A-","blood"); ?> value="A-">A-</option>
                                                      <option <?php bl("B+","blood"); ?> value="B+">B+</option>
                                                      <option <?php bl("B-","blood"); ?> value="B-">B-</option>
                                                      <option <?php bl("O+","blood"); ?> value="O+">O+</option>
                                                      <option <?php bl("O-","blood"); ?> value="O-">O-</option>
                                                      <option <?php bl("AB+","blood"); ?> value="AB+">AB+</option>
                                                      <option <?php bl("AB-","blood"); ?> value="AB-">AB-</option>
                                                    </select>

                                              </div>
                                              <?php }elseif($das==2) { ?>
                                              <div class="form-group">
                                                    <label <?php echo $feilds["tea_desig"] != "" ? ' class="req"' : ''; ?>>پسپۆڕی</label>
                                                    <input  value="<?php echo $fetch->desig; ?>" name="desig" class="form-control">
                                              </div>
                                              <?php } ?>
                                              <div class="form-group">
                                                    <label class="req">ئیمەیڵ</label>
                                                    <input  value="<?php echo $fetch->email; ?>" name="email" class="form-control">
                                              </div>
                                              <input type="hidden" name="token" value="<?php echo Token::create(); ?>">
                                              <button type="submit" name="sub" class="btn btn-default">پاشەکەوتکردن</button>
                                            </form>
                                        </div>
                                    </div>
                                  </div>
                                  <!-- PART -->
                                  <div class="col-xs-6" style="float: right;">
                                      <div class="panel panel-default">
                                        <div class="panel-heading">زانیاریەکانی چونەژورەوە</div>
                                        <div class="panel-body">
                                          <?php
                                          if (isset($_POST['sub2'])) {
                                              $id=output(@$_GET['user']);
                                              $cp=output(@$_POST['cp']);
                                              $np=output(@$_POST['np']);
                                              $rnp=output(@$_POST['rnp']);
                                              if((!empty($cp) OR $das==1) && !empty($np) && !empty($rnp)){

                                            ///// Select Old Password To Chek
                                                $stm = $db->prepare("SELECT * FROM account WHERE user=:user");
                                                $stm->bindParam(":user", $id, PDO::PARAM_STR);
                                                $stm->execute();
                                                $fetch = $stm->fetch(PDO::FETCH_OBJ);
                                            if (checkp($cp,$fetch->pass) OR $das==1) {
                                            if ($np==$rnp) {
                                            /// Change User Password
                                              $np = ph($_POST['np']);
                                              $stm = $db->prepare("UPDATE account SET pass=:pass WHERE user=:id");
                                              $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                              $stm->bindParam(":pass",$np, PDO::PARAM_STR);
                                              $stm->execute();
                                              AddtoHistory("گۆڕینی وشەی نهێنی",home);
                                              $rowCount = $stm->rowCount();

                                             if ($rowCount > 0) {
                                                re("success"," سوپاس ","زانیاریەکانت بەسەرکەوتویی نوێکرانەوە.");
                                              }else {
                                                re("info"," ئاگادارکردنەوە ","هیچ گۆڕانکاریەک ئەنجام نەدرا.");
                                              }
                                              }else {
                                                re("danger"," هەڵە "," وشەی نهێنی نوێ هاوشێوە نین.");
                                            }
                                            }else {
                                                re("danger"," هەڵە "," تکایە وشەی نهێنی پێشوو بەدروستی بنووسە.");
                                            }
                                            }else {
                                              re("danger"," کێشە! "," تکایە خانەکان بە دروستی پڕبکەوە. ");
                                            }
                                            
                                            }
                                            ?>
                                            <form action="#edit" method="post">
                                            <div class="form-group">
                                                  <label>ناوی بەکارهێنەر</label>
                                                  <input value="<?php echo $fetch->user; ?>" disabled="" class="form-control">
                                            </div>
                                            <?php if ($das!=1) { ?>
                                            <div class="form-group">
                                                  <label class="req">وشەی نهێنی ئێستا</label>
                                                  <input type="password"  name="cp" class="form-control">
                                            </div>
                                            <?php } ?>
                                            <div class="form-group">
                                                  <label class="req">وشەی نهێنی نوێ</label>
                                                  <input type="password"  name="np" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                  <label class="req">دووبارە وشەی نهێنی نوێ</label>
                                                  <input type="password"  name="rnp" class="form-control">
                                            </div>
                                            <button type="submit" name="sub2" class="btn btn-default">پاشەکەوتکردن</button>
                                            </form>
                                        </div>
                                    </div>
                                  </div>

                                </div>
                                <?php }else {
                                      e4();
                                    } ?>
                                </div>
                                </div>
                                <div class="tab-pane fade" id="social">
                                  <?php e4(); ?>
                                </div>

                            </div>
                        </div>
                    </div>
<?php
$db = null;
 include 'inc/foot.php'; ?>