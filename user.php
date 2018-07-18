<?php 
include('class.token.php'); 
require 'inc/head.php';
global $re;
if ($das!=1) {
  dh("index.php");
}
?>
                <div class="row">
                    <div class="col-md-12">
                     <h2> بەکارهێنەران</h2>   
                        <h5>دەستکاریکردنی زانیاری بەکارهێنەر و ڕێکخستنیان</h5>
                        <?php if (!isset($_GET['add']) ) { ?>
                        <a href="user.php?add" style="float: left;" class="btn btn-success"><i class="fa fa-user"></i> زیادکردنی بەکارهێنەر </a>
                        <?php }elseif (isset($_GET['add'])) { ?>
                        <a href="user.php" style="float: left;margin-right: 5px;" class="btn btn-info"><i class="fa fa-user"></i> گەڕانەوە </a>
                        <a href="user.php?multi" style="float: left;" class="btn btn-success"><i class="fa fa-users"></i> زیادکردن بەکۆمەڵ </a>
                        <?php } ?>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                <div class="row">
                <div class="col-md-12">
                <?php if (isset($_GET['add']) AND !isset($_GET['multi']) AND !isset($_GET['edit'])) { ?>
                             
                                  <!-- ADD One User<div class="col-xs-12"> -->
                                      <div class="panel panel-default">
                                        <div class="panel-heading">زیادکردنی هەژمار</div>
                                        <div class="panel-body">
                                        <?php
                                            if (isset($_POST['sub2'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                              $fname=@output($_POST['fname']);
                                              $user=@output($_POST['user']);
                                              $pass=@output($_POST['np']);
                                              $p=password_hash($pass, PASSWORD_BCRYPT);
                                              $rnp=@output($_POST['rnp']);
                                              $r=@output($_POST['r']);
                                              if (preg_match('/^[A-Za-z0-9_-]*$/', $user)){
                                              if(user($user)==0){
                                              if(!empty($user) && !empty($pass) && !empty($rnp) ){
                                              if ($pass==$rnp) {
                                              
                                              $stm = $db->prepare("INSERT INTO account (id, user, pass,r,fname) VALUES (NULL, :user, :pass,1 ,:fname );");
                                              $stm->bindParam(":fname", $fname, PDO::PARAM_STR);
                                              $stm->bindParam(":user", $user, PDO::PARAM_STR);
                                              $stm->bindParam(":pass", $p, PDO::PARAM_STR);

                                              $stm->execute();
                                              AddtoHistory("زیادکردنی بەڕێوبەر",home);
                                              re("success"," سوپاس "," هەژماری خوێندکار خوێندکار بەسەرکەوتویی زیادکرا. ");
                                              direct("./user.php");
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
                                            <center>
                                                  <a href="student.php?add" class="btn btn-primary btn-lg"><i class="fa icon-student"></i> زیادکردنی هەژمار بۆ خوێندکار</a>
                                                  <i class="fa"></i>
                                                  <a href="teacher.php?add" class="btn btn-success btn-lg"><i class="fa icon-teacher"></i> زیادکردنی هەژمار بۆ مامۆستا</a>
                                            </center>
                                            <p class="help-block">* ئاگاداربە لێرە هەژمار زیاد دەکەیت بە پلەی بەڕێوبەر گە دەتەوێت خوێندکار یان مامۆستا زیادبکەیت سود لە پەڕەکانی سەرەوە وەربگرە.</p>
                                            </div>
                                            <hr>
                                            <div id="demo" class="form-group">
                                                  <label class="req">ناوی تەواوەتی </label>
                                                  <input  name="fname" class="form-control">
                                            </div>
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

                                             <input type="hidden" name="token" value="<?php echo Token::create(); ?>">
                                            <button type="submit" name="sub2" class="btn btn-default">زیادکردن</button>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- END ADD One User-->
                                    <!-- START EDIT User-->
                        <?php }elseif(isset($_GET['edit'])) { ?>
                                       <div class="panel panel-default">
                                        <div class="panel-heading">دەستکاریکردنی زانیاریەکانی هەژمار</div>
                                        <div class="panel-body">
                                          <?php
                                              $id=output(@$_GET['user']);
                                              $cp=output(@$_POST['cp']);
                                              $np=output(@$_POST['np']);
                                              $rnp=output(@$_POST['rnp']);
                                              $fn=output(@$_POST['fname']);
                                              $check=output(@$_POST['check']);

                                              // Select Data

                                                $stm = $db->prepare("SELECT * FROM account WHERE user=:user");
                                                $stm->bindParam(":user", $id, PDO::PARAM_STR);
                                                $stm->execute();
                                                $fetch = $stm->fetch(PDO::FETCH_OBJ);
                                                $rowCount = $stm->rowCount();

                                              if (isset($_POST['sub2'])) {
                                                //  Only Change  Full Name
                                                if (!$check) {
                                                if(!empty($fn)){
                                                $stm = $db->prepare("UPDATE account SET fname=:fname WHERE user=:id");
                                                $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                                $stm->bindParam(":fname",$fn, PDO::PARAM_STR);
                                                $stm->execute();

                                                $rowCount = $stm->rowCount();

                                               if ($rowCount > 0) {
                                                AddtoHistory("دەستکاریکردنی زانیاریەکان",home);
                                                  re("success"," سوپاس ","زانیاریەکانت بەسەرکەوتویی نوێکرانەوە.");
                                                  direct("user.php");
                                                }else {
                                                  re("info"," ئاگادارکردنەوە ","هیچ گۆڕانکاریەک ئەنجام نەدرا.");
                                                }

                                                }else {
                                                  re("danger"," هەڵە! "," تکایە خانەکان بە دروستی پڕبکەوە. ");
                                                }
                                                }else {

                                                  // Update if want change password
                                                $stm = $db->prepare("SELECT * FROM account WHERE user=:user");
                                                $stm->bindParam(":user", $id, PDO::PARAM_STR);
                                                $stm->execute();
                                                $fetch = $stm->fetch(PDO::FETCH_OBJ);
                                                $rowCount = $stm->rowCount();
                                                $p = ph($cp);
                                                if(!empty($cp) && !empty($np) && !empty($rnp)){
                                                if($rnp==$np){
                                                if (checkp($cp,$fetch->pass)) {
                                                $np = ph($np);
                                                $stm = $db->prepare("UPDATE account SET pass=:pass,fname=:fname WHERE user=:id");
                                                $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                                $stm->bindParam(":pass",$np, PDO::PARAM_STR);
                                                $stm->bindParam(":fname",$fn, PDO::PARAM_STR);
                                                $stm->execute();
                                                AddtoHistory("گۆڕینی وشەی نهێنی",home);
                                                $rowCount = $stm->rowCount();

                                               if ($rowCount > 0) {
                                                  re("success"," سوپاس ","زانیاریەکانت بەسەرکەوتویی نوێکرانەوە.");
                                                  direct("user.php");
                                                }else {
                                                  re("info"," ئاگادارکردنەوە ","هیچ گۆڕانکاریەک ئەنجام نەدرا.");
                                                }

                                                }else {
                                                  re("danger"," هەڵە! "," وشەی نهێنی ئێستات دروست نییە. ");
                                                }

                                                }else {
                                                  re("info"," تکایە "," پێویستە وشەی نهێنیەکانت هاوشێوەبن. ");
                                                }
                                                }else {
                                                  re("danger"," هەڵە! "," تکایە خانەکان بە دروستی پڕبکەوە. ");
                                                }
                                              }
                                            }

                                               
                                            ?>
                                            <form action="" method="post">

                                            <div class="form-group">
                                                  <label>ناوی بەکارهێنەر</label>
                                                  <input disabled="" value="<?php echo $id; ?>"  class="form-control">
                                            </div>
<!--                                             <div class="form-group">
                                                  <label>پلە</label>
                                                    <select id="r" name="r" class="form-control">
                                                      <option <?php bl("3","r"); ?>  value="3">خوێندکار</option>
                                                      <option <?php bl("2","r"); ?>  value="2">مامۆستا</option>
                                                      <option <?php bl("1","r"); ?>  value="1">بەڕێوبەر</option>
                                                    </select>
                                            </div> -->
                                            <div id="demo" class="form-group">
                                                  <label  class="req">ناوی تەواوەتی </label>
                                                  <input value="<?php echo $fetch->fname; ?>" name="fname" class="form-control">
                                            </div>                                           
                                            <label class="req">وشەی نهێنی ئێستا</label>
                                            <div class="form-group input-group">

                                              <span class="input-group-addon">
                                                <input name="check" id="check" type="checkbox">
                                              </span>
                                                  <input required="" id="input" type="password" name="cp" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                  <label class="req">وشەی نهێنی نوێ</label>
                                                  <input type="password" name="np" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                  <label class="req">دووبارە وشەی نهێنی نوێ</label>
                                                  <input type="password" name="rnp" class="form-control">
                                            </div>
                                            <input type="hidden" name="token2" value="<?php $_POST['token']; ?>">
                                            <button type="submit" name="sub2" class="btn btn-default">پاشەکەوتکردن</button>
                                            </form>
                                        </div>
                                    </div>
                        <?php }elseif(isset($_GET['multi'])) { ?>
                                      <!-- ADD Multi User-->
                                      <div class="panel panel-default">
                                        <div class="panel-heading">زیادکردنی هەژمار بەکۆمەڵ</div>
                                        <div class="panel-body">
                                        <?php
                                            if (isset($_POST['sub2'])) {
                                              AddtoHistory("زیادکردنی هەژماری بەکۆمەڵ",home);
$r=@output($_POST['r']);
$newname=$error="";
if((!empty($_FILES["uploaded_file"])) && ($_FILES['uploaded_file']['error'] == 0)) {
  $filename = basename($_FILES['uploaded_file']['name']);
  $ext = substr($filename, strrpos($filename, '.') + 1);
  $mimes = array('application/vnd.ms-excel','text/plain','text/csv','text/tsv');

  if (($ext == "csv") && in_array($_FILES['uploaded_file']['type'],$mimes) && 
    ($_FILES["uploaded_file"]["size"] < 10000)) {
      $newname = dirname(__FILE__).'/csv/'.date("Y-m-d(H-i-s)-").$filename;
      if (!file_exists($newname)) {
        if ((move_uploaded_file($_FILES['uploaded_file']['tmp_name'],$newname))) {
           // echo "It's done! The file has been saved as: ".$newname;
           $error=1;
        } else {
          $error=2;
           // echo "Error: A problem occurred during file upload!";
        }
      } else {
        $error=3;
         // echo "Error: File ".$_FILES["uploaded_file"]["name"]." already exists";
      }
  } else {
    $error=4;
     // echo "Error: Only .jpg images under 350Kb are accepted for upload";
  }
} else {
  $error=5;
 // echo "Error: No file uploaded";
}




function csvtoarray($filename='', $delimiter){
    if(!file_exists($filename) || !is_readable($filename)) return FALSE;
    $header = NULL;
    $data = array();
    if (($handle = fopen($filename, 'r')) !== FALSE ) {
        while (($row = fgetcsv($handle, 1000, $delimiter)) !== FALSE)
        {   
            if(!$header){
                $header = $row;
            }else{
                $data[] = array_combine($header, $row);
            }
        }
        fclose($handle);
    }
    if(file_exists($filename)) @unlink($filename);
    return $data;
}




                                            $re=array();

                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                              
                                              $users=@output($_POST['users']);
                                              $r=@output($_POST['r']);
if($error==1){
if ($r==3) {
  $data = csvtoarray($newname, ',');
  $n=0;
  $r2="";
  foreach ($data as $va) {
    $pass="";
    $user=@$va['user'];
    $fname=@$va['fullname'];
    $gen=@$va['gender'];
    $relig=@$va['relig'];
    $num=@$va['number'];
    $birth=@$va['birth'];
    $bl=@$va['blood'];
    $email=@$va['email'];
    $cl=@$va['class'];
    $sd=@$va['startdate'];
    $gr=@$va['group'];
    $addr=@$va['address'];
    $password="";
      if (isset($pass) AND $pass!="") {
        $pass=$va['password'];
      }else {
        $pass=rn(8);
      }
    $password=$pass;
    $pass=password_hash($pass, PASSWORD_BCRYPT);
    checkInput();
    if(!empty($fname) && !empty($user) && !empty($gen) && (!empty($relig)  OR $feilds["stu_relig"]=="") && !empty($birth) && (!empty($bl)  OR $feilds["stu_bl"]=="") && !empty($email) && !empty($cl) && !empty($sd) && (!empty($num)  OR $feilds["stu_num"]=="") && (!empty($addr)  OR $feilds["stu_loc"]=="")){
    if (preg_match('/^[A-Za-z0-9._-]*$/', $user)){
    if(user($user)==0){
    $stm = $db->prepare("INSERT INTO account (id, user, pass,r) VALUES (NULL, :user, :pass,3);");
    $stm->bindParam(":user", $user, PDO::PARAM_STR);
    $stm->bindParam(":pass", $pass, PDO::PARAM_STR);
    $stm->execute();
     // $res= "Success";
     $res= "User Added";
     // add student
    if ($stm->rowCount() > 0) {
        $s1 = $db->prepare("INSERT INTO stu (id,user , fname, gen, relig, num, birth, blood, email, addr, class, sdate,gr) VALUES (NULL, :user,:fn, :g, :re, :n, :b, :bl, :e, :ad, :cl, :sd, :gr);");
        $s1->bindParam(":fn", $fname, PDO::PARAM_STR);
        $s1->bindParam(":g", $gen, PDO::PARAM_STR);
        $s1->bindParam(":re", $relig, PDO::PARAM_STR);
        $s1->bindParam(":n", $num, PDO::PARAM_STR);
        $s1->bindParam(":b", $birth, PDO::PARAM_STR);
        $s1->bindParam(":bl", $bl, PDO::PARAM_STR);
        $s1->bindParam(":e", $email, PDO::PARAM_STR);
        $s1->bindParam(":ad", $addr, PDO::PARAM_STR);
        $s1->bindParam(":cl", $cl, PDO::PARAM_STR);
        $s1->bindParam(":sd", $sd, PDO::PARAM_STR);
        $s1->bindParam(":user", $user, PDO::PARAM_STR);
        $s1->bindParam(":gr", $gr, PDO::PARAM_STR);
        $s1->execute();
        if ($s1->rowCount() > 0) {
          $res = $res." (Student Added).";
        }else {
          $res = $res." (Student ERROR).";
        }
    }else {
      $res= "User ERROR";
      $password="";
    }
     }else {
      $res="Username Already Exist";
      $password="";
    }
  }else {
      $res="Must Be String, Space not Allowed";
      $password="";
}
}else {
      $res="Write all required filed!";
      $password="";
}
    $r2 = $r2.'<tr><td>'.$user."</td><td>".$password."</td><td>".$res.'</td></tr>';
    $ar[$n][0]=$user;
    $ar[$n][1]=$password;
    $ar[$n][2]= $res;
    $n++;
  }
mul($r2);
}elseif ($r==2) {
  $data = csvtoarray($newname, ',');
  $n=0;
  $r2="";
  foreach ($data as $va) {
    $pass="";
    $user=@$va['user'];
    $fname=@$va['fullname'];
    $gen=@$va['gender'];
    $relig=@$va['relig'];
    $num=@$va['number'];
    $birth=@$va['birth'];
    $desig=@$va['desig'];
    $email=@$va['email'];
    $sd=@$va['startdate'];
    $addr=@$va['address'];
    $password="";
      if (isset($pass) AND $pass!="") {
        $pass=$va['password'];
      }else {
        $pass=rn(8);
      }
    $password=$pass;
    $pass=password_hash($pass, PASSWORD_BCRYPT);
    checkInput();
    if(!empty($fname) && !empty($user) && !empty($gen) && (!empty($desig)  OR $feilds["tea_desig"]=="") && !empty($birth) && !empty($email) && !empty($sd) && (!empty($num)  OR $feilds["tea_num"]=="") &&  (!empty($addr)  OR $feilds["tea_loc"]=="")){
    if (preg_match('/^[A-Za-z0-9._-]*$/', $user)){
    if(user($user)==0){
    $stm = $db->prepare("INSERT INTO account (id, user, pass,r) VALUES (NULL, :user, :pass,2);");
    $stm->bindParam(":user", $user, PDO::PARAM_STR);
    $stm->bindParam(":pass", $pass, PDO::PARAM_STR);
    $stm->execute();
     // $res= "Success";
     $res= "User Added";
     // add student
    if ($stm->rowCount() > 0) {
        $s1 = $db->prepare("INSERT INTO tea (id,user , fname, gen, relig, num, birth, desig, email, addr, sdate) VALUES (NULL, :user,:fn, :g, :re, :n, :b, :desig, :e, :ad, :sd);");
        $s1->bindParam(":fn", $fname, PDO::PARAM_STR);
        $s1->bindParam(":g", $gen, PDO::PARAM_STR);
        $s1->bindParam(":re", $relig, PDO::PARAM_STR);
        $s1->bindParam(":n", $num, PDO::PARAM_STR);
        $s1->bindParam(":b", $birth, PDO::PARAM_STR);
        $s1->bindParam(":desig", $desig, PDO::PARAM_STR);
        $s1->bindParam(":e", $email, PDO::PARAM_STR);
        $s1->bindParam(":ad", $addr, PDO::PARAM_STR);
        $s1->bindParam(":sd", $sd, PDO::PARAM_STR);
        $s1->bindParam(":user", $user, PDO::PARAM_STR);
        $s1->execute();
        if ($s1->rowCount() > 0) {
          $res = $res." (Teacher Added).";
        }else {
          $res = $res." (Teacher ERROR).";
        }
    }else {
      $res= "User ERROR";
      $password="";
    }
     }else {
      $res="Username Already Exist";
      $password="";
    }
  }else {
      $res="Must Be String, Space not Allowed";
      $password="";
}
}else {
      $res="Write all required filed!";
      $password="";
}
    $r2 = $r2.'<tr><td>'.$user."</td><td>".$password."</td><td>".$res.'</td></tr>';
    $ar[$n][0]=$user;
    $ar[$n][1]=$password;
    $ar[$n][2]= $res;
    $n++;
  }
mul($r2);

}
}else {
  if ($error==2 OR $error==3) {
    re("danger","کێشە!","کێشەیەک ڕویدا لەکاتی بارکردنی پەڕگەدا");
  }elseif ( $error==4) {
        re("info","ئاگاداربە!","تەنیا فایل لەجۆری csv ڕێگەپێدراوە بۆ بارکردن");
      }elseif ($error==5) {
        re("danger","کێشە!","تکایە فایلێک هەڵبژێرە بۆ بارکردن");
      }
  }
  echo '<hr width="100%">';
}else {
    re("danger"," کێشە! "," کێشەیەک ڕویدا تکایە دووبارە هەوڵ بدەوە.");
  }
              
}
                                          ?>
                                            <form action="" method="post" enctype="multipart/form-data">
                                            <div class="form-group">
                                                  <label class="req">پلە</label>
                                                    <select  class="selectpicker" data-width="100%" name="r" class="form-control">
                                                      <option value="3">خوێندکار</option>
                                                      <option value="2">مامۆستا</option>
                                                    </select>
                                            </div>                                            
                                            <div class="form-group">
                                                  <label class="req">فایل لە جۆری (CSV)</label><br>
                                                    <input type="file" name="uploaded_file" accept=".csv" data-label="دیاریکردن" class="filepicker form-control">
                                            </div>

                                            <div class="form-group">
                                                  <p class="help-block">* بۆ مامۆستا پێویستە فایلەکەت بەم شێوەیە بێت (<a download="csv/teacher.csv" href="csv/teacher.csv">داگرتنی نموونە</a>).<br>
                                                  * بۆ خوێندکار پێویستە فایلەکەت بەم شێوەیە بێت (<a download="csv/student.csv" href="csv/student.csv">داگرتنی نموونە</a>).<br>
                                                    * پێویستە پیتی ئینگلیزی بەکار ببەیت.
                                                  </p>
                                            </div>
                                        <button type="submit" name="sub2" class="btn btn-default">زیادکردن</button>


                                             <input type="hidden" name="token" value="<?php echo Token::create(); ?>">
                                            </form>

                                        </div>
                                    </div>
                                    <!-- ADD Multi User-->

                                  <!-- PART -->


                                </div>
                        <?php
                        }else{ 
                            $del = output(@$_GET['del']);
                            if (isset($del) && $del!="") {
                              $stm = $db->prepare("DELETE FROM account WHERE user=:id");
                              $stm->bindParam(":id", $del, PDO::PARAM_STR);
                              $stm->execute();
                              AddtoHistory("سڕینەوەی خوێندکار",home);
                              re("danger","  خوێندکار ","بەسەرکەوتویی سڕایەوە.");
                              direct("user.php");
                            }
                              // Active
                               $ac = output(@$_GET['active']);
                              if (isset($ac) && $ac!="") {
                               $stm = $db->prepare("UPDATE account SET status = 1 WHERE user=:ac");
                               $stm->bindParam(":ac", $ac, PDO::PARAM_STR);
                               $stm->execute();
                               $rowCount = $stm->rowCount();
                                if($rowCount > 0){
                                  AddtoHistory("چالاککردنی هەژمار",home);
                                  dh("user.php");
                                }
                              }
                            
                              // DeActive
                               $dac = output(@$_GET['deactive']);
                              if (isset($dac) && $dac!="") {
                               $stm = $db->prepare("UPDATE account SET status = 0 WHERE user=:ac");
                               $stm->bindParam(":ac", $dac, PDO::PARAM_STR);
                               $stm->execute();
                               $rowCount = $stm->rowCount();
                                if($rowCount > 0){
                                  AddtoHistory("ناچالاککردنی هەژمار",home);
                                  dh("user.php");
                                }
                              }
                          ?>
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             لیستی خوێندکاران
                        </div>
                        <div class="panel-body">
                        <?php

                        $stm = $db->prepare("SELECT * FROM account");
                        $stm->execute();
                        $rowCount = $stm->rowCount();
                        if($rowCount > 0){
                        ?>
                            <div class="table-responsive">
                                <table id="advance" class="table table-striped table-bordered table-hover" data-id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th width="50px">#</th>
                                            <th>ناوی تەواوەتی</th>
                                            <th>ناوی بەکارهێنەر</th>
                                            <th width="100px">پلە</th>
                                            <th width="100px">کردار</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $nu = 0;
                                    while($row = $stm->fetch(PDO::FETCH_ASSOC)) { 
                                      ?>
                                        <tr class="<?php if($nu % 2==0){echo 'odd';}else{echo 'even';} ?>">
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php getNid($row['user'],$row['r']); ?></td>
                                            <td><?php echo $row['user']; ?></td>
                                            <td><?php echo r($row['r']); ?></td>
                                            <td>
                                               <?php if ($row['status']=="1") { ?>
                                                <a href="user.php?deactive=<?=$row['user'];?>"  class="btn btn-success btn-xs mrg" title="ناچالاک" ><i class="fa fa-check-circle"></i></a><i></i>
                                              <?php }else { ?>
                                                <a href="user.php?active=<?=$row['user'];?>" class="btn btn-danger btn-xs mrg" title="چالاک" ><i class="fa fa-times-circle"></i></a><i></i>
                                              <?php }
                                              ?>
                                              <a href="

                                              <?php

                                              $das2=$row['r'];
                                              if($das2==1){
                                                echo "user.php?edit&user=".$row['user'];
                                              }else{
                                                echo "profile.php?user=".$row['user']."&r=".$row['r'];
                                              }
                                              ?>

                                              " data-toggle="tooltip" data-placement="top" class="btn btn-warning btn-xs mrg" title="دەستکاری"><i class="fa fa-edit"></i></a>

                                              <a href="user.php?del=<?php echo $row['user']; ?>" value="#go" id="btn-confirm" data-toggle="tooltip" data-placement="top" class="btn btn-danger btn-xs mrg confirmation" title="سڕینەوە"><i class="fa fa-trash-o"></i></a>

                                              </td>

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

<div class="alert" role="alert" id="result"></div>

<?php
 include 'inc/foot.php'; ?>