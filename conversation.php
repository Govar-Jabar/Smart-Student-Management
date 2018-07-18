<?php 
include('class.token.php'); 
require 'inc/head.php';
?>
                <div class="row">
                    <div class="col-md-12">
                     <h2> گفتوگۆ</h2>   
                        <h5>لێرەوە دەتوانیت گفتوگۆ(چات) بکەیت وپەیامەکانت ئاڵوگۆڕ بکەیت</h5>
                    </div>
                </div>              
                  <hr />
        <div class="row">
          <div class="col-md-3">
            <a style="margin-bottom: 15px" data-toggle="modal" data-target="#myModal0" class="btn btn-info btn-block">گفتوگۆیەکی نوێ</a>

            <form action="" method="post">
            <div id="myModal0" class="modal fade in" role="dialog" aria-hidden="false">
              <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                  <div class="modal-header modal-lg"> 
                  <button type="button" class="close" data-dismiss="modal">×</button>
                  <h4 class="modal-title">گفتوگۆیەکی نوێ</h4>
                  </div>
                  <div class="modal-body">
                        <div class="form-group">
                        <label class="req">پلە</label>
                        <select onchange="showSubject(this.value,'conversation','user')" class="selectpicker"  data-width="100%">
                           <option>دیاری بکە</option>
                           <option value="1">بەڕێوبەران</option>
                           <option value="2">مامۆستایان</option>
                           <option value="3">خوێندکاران</option>
                        </select>
                        </div>                        
                        <div class="form-group" id="user">

                        </div>

                        <div class="form-group">
                        <label class="req">ناوەڕۆکی پەیام</label>
                        <textarea name="chat" class="form-control"></textarea>
                        </div>
                  </div>
                  <div class="modal-footer">
                    <?php 
                    checkInput();
                    if (isset($_POST['send'])) {
                      if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                          $user2=output(@$_POST['user']);
                          $chat=output(@$_POST['chat']);
                          $time=date("H:i:s");
                          $date=date("Y-m-d");
                          $ftime=date("Y-m-d H:i:s");
                          if (!empty($user2) AND !empty($chat)) {
                          if ((ndb("conversation"," date='$date' AND user='$un'") <= $array['stu_chat'] AND $das==3) OR ($das==2 OR $das==1)) {
                          $stm = $db->prepare("INSERT INTO conversation (user,chat,user2,time,date,ftime) VALUES (:user,:chat,:user2,:time,:date,:ftime);");
                          $stm->bindParam(":user",$un , PDO::PARAM_STR);
                          $stm->bindParam(":user2",$user2 , PDO::PARAM_STR);
                          $stm->bindParam(":chat",$chat , PDO::PARAM_STR);
                          $stm->bindParam(":time",$time , PDO::PARAM_STR);
                          $stm->bindParam(":date",$date , PDO::PARAM_STR);
                          $stm->bindParam(":ftime",$ftime , PDO::PARAM_STR);
                           $stm->execute();
                          $rowCount = $stm->rowCount();
                            if($rowCount > 0){
                              re("success"," سوپاس "," پەیامەکەت بەسەرکەوتویی نێردرا. ");
                            }
                            }else {
                              re("info","ئاگاداری!","خوێندکاری خۆشەویست ڕۆژانە ناتوانی زیاتر لە ".$array['stu_chat']." پەیام بنێریت.");
                            }
                          }else{
                            re("danger"," هەڵە! "," تکایە خانەکان بەدروستی پڕبکەوە. ");
                      }
                      }else{
                        re("danger"," ببورە "," هەڵەیەک ڕویدا تکایە دووبارە هەوڵ بدەوە. ");
                      }
                    }
                    ?>
                    <input type="hidden" name="token" value="<?php echo Token::create(); ?>">
                    <button style="float: left" type="button" class="btn btn-default" data-dismiss="modal">داخستن</button>
                    <button style="float: left" disabled="" id="chatbtn" type="submit" name="send" class="btn btn-success">ناردن</button>
                  </div>
                 </div>
               </div>
             </div>
            </form>

            <div class="box box-solid">
              <div class="box-header with-border">
                <h3 class="box-title">بەشەکان</h3>
              </div>

              <div class="box-body no-padding">
                <ul class="nav nav-pills nav-stacked conversation">

                  <li class=""><a href="conversation.php"><i class="fa fa-inbox"></i> گفتوگۆکان <span class="label label-info pull-right" id="inbox"></span></a></li>
                 <li class=""><a href="conversation.php?user=<?=$un;?>"><i class="fa fa-floppy-o"></i> پەیامەکانم <span class="label label-info pull-right" id="inbox"></span></a></li> 
                  <!-- <li><a href="sent"><i class="fa fa-envelope-o"></i> نێردراو <span class="label label-info pull-right" id="sent"></span></a></li> -->
                  <!-- <li><a href="conversation.php?del"><i class="fa fa-trash-o"></i> تەنەکەی خۆڵ</a></li> -->
                </ul>
              </div><!-- /.box-body -->
            </div><!-- /. box -->
          </div><!-- /.col -->            
          <?php 
          $user=@$_GET['user'];
          if (!isset($_GET['user']) AND @$_GET['user']=="") {
           ?>
          <div class="col-md-9">
            <?php if ($das==3) {
              echo '<div class="alert alert-info">ئاگاداری : خوێندکاری خۆشەویست ڕۆژانە دەتوانی تا '.$array['stu_chat'].' پەیام بنێریت.</div>';
            } ?>
              <div class="box box-primary">
                <div class="box-header with-border">
                  <h3 class="box-title">گفتوگۆکان</h3>
                </div><!-- /.box-header -->
                <div class="box-body">
<!--                     <div class="margin-bottom">
                        <div class="btn-group">
                            <button id="all" class="btn btn-info btn-sm" data-original-title="دیاریکردنی هەموو پەیامەکان" data-toggle="tooltip" data-placement="top" onclick="toggle(this)">
                                <i class="fa fa-square-o"></i>
                            </button>
                            <button class="btn btn-danger btn-sm" id="delete_submit" data-original-title="سڕینەوە" data-toggle="tooltip" data-placement="top">
                                <i class="fa fa-trash-o"></i>
                            </button>
                            <button class="btn btn-primary btn-sm" id="refresh" data-original-title="نوێکردنەوە" data-toggle="tooltip" data-placement="top"> <i class="fa fa-refresh"></i> </button>
                        </div>
                    </div> -->
                             <?php 
                              $stm = $db->prepare("SELECT distinct user,user2 FROM conversation WHERE user=:un OR user2=:un ORDER BY id DESC");
                              $stm->bindParam(":un",$un , PDO::PARAM_STR);
                               $stm->execute();
                              $rowCount = $stm->rowCount();
                                if($rowCount > 0){
                                  ?>
                        <table id="" class="table table-hover " role="grid">
                            <thead>
                                <tr role="row">
                                  <th>ناو</th>
                                  <th>دواین پەیام</th>
                                  <th style="width: 50px;">ڕێژە</th>
                                  <th width="150px">کات</th>
                                  <th width="50px">کردار</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $a=array();
                                $b=array();
                                $i=0;
                                while($row = $stm->fetch(PDO::FETCH_ASSOC)) {

                                  $a[$i]= $row['user'];
                                  $i++;
                                  $a[$i]= $row['user2'];
                                  $i++;
                                }
                                $a =array_unique($a);
                                $b=0;
                                $c="";
                                error_reporting(0);
                                foreach($a as $key) {
                                  if ($un!=$key) {
                                    $c[$b]= $key;
                                   $b++;
                                  }
                                }
                                foreach($c as $user) {
                                ?> 
                                   <tr <?php if(ndb("conversation"," user2='$un' AND user='$user' AND type=0")!=0){ ?> style=" background-color: #efefef; " <?php } ?> >
                                        <input type="hidden" name="username[]" value="<?=$user?>">
                                      
                                      <td><a href="conversation.php?user=<?=$user;?>">
                                      <?=GetFullNamewithUser($user);?></a></td>
                                      <td><a href="conversation.php?user=<?=$user;?>">
                                        <?=GetDataConvesation(" user='$un' AND user2='$user' OR user2='$un' AND user='$user' ","chat") ?>
                                      </a></td>
                                      <td><span class="label label-info"><?=GetChatLengthByUser($un,$user);?></span>
                                      <td style="direction: ltr"><?=GetDataConvesation(" user='$un' AND user2='$user' OR user2='$un' AND user='$user' ","time") ?></td>
                                        </td>
                                      <td><a class="btn btn-danger btn-xs" href="?del=<?=$user;?>" data-original-title="سڕینەوە" data-toggle="tooltip" data-placement="top"><i class="fa fa-trash-o"></i></a></td>
                                    </tr>
                                  <?php 
                                        }  

                                    if (isset($_GET['del']) AND ($_GET['del']!="")) {
                                        $un2=output($_GET['del']);
                                         $stm = $db->prepare("DELETE FROM conversation WHERE user=:un AND user2=:un2 OR user2=:un AND user=:un2");
                                         $stm->bindParam(":un", $un, PDO::PARAM_STR);
                                         $stm->bindParam(":un2", $un2, PDO::PARAM_STR);
                                         $stm->execute();
                                         $rowCount = $stm->rowCount();
                                          if($rowCount > 0){
                                            re("success","سەرکەوتوبوو","بەسەرکەوتویی توانرا بسڕێتەوە.");
                                            direct("conversation.php");
                                          }else {
                                            re("danger","کێشە","نەتوانرا بسڕێتەوە!");
                                          }
                                    }
                                   ?>
                              </tbody>
                        </table>
                        <?php 
                      }else {
                        echo 'هیچ گفتوگۆیەکت ئەنجام نەداوە <a style="color:#fff" data-toggle="modal" data-target="#myModal0" class="btn btn-info btn-sm">گفتوگۆیەکی نوێ</a> ئەنجام بدە';
                      }
                         ?>
                    </div><!-- /.mail-box-conversations -->
                </div><!-- /.box-body -->
              </div><!-- /. box -->
<?php }else{ ?>
<div class="col-md-9">
            <?php
               $stm = $db->prepare("UPDATE conversation SET type=1 WHERE user2=:un AND user=:user");
               $stm->bindParam(":un", $un, PDO::PARAM_STR);
               $stm->bindParam(":user", $user, PDO::PARAM_STR);
               $stm->execute();

               if ($das==3) {
                  echo '<div class="alert alert-info">ئاگاداری : خوێندکاری خۆشەویست ڕۆژانە دەتوانی تا '.$array['stu_chat'].' پەیام بنێریت.</div>';
                } ?>
                <!-- Chat box -->
                <div class="box box-success">
                    <div class="box-header">
                      <h3 class="box-title"><?=GetFullNamewithUser($user); ?></h3>
                    </div>
                    <div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 250px;"><div class="box-body chat" id="chat-box" style="overflow: auto; width: auto; height: 250px;">
                      <!-- chat item -->
                        <?php 
                          $stm = $db->prepare("SELECT * FROM conversation WHERE user=:un AND user2=:user OR user=:user AND user2=:un ORDER BY id DESC");
                          $stm->bindParam(":un",$un , PDO::PARAM_STR);
                          $stm->bindParam(":user",$user , PDO::PARAM_STR);
                           $stm->execute();
                          $rowCount = $stm->rowCount();
                            if($rowCount > 0){
                              while($row = $stm->fetch(PDO::FETCH_ASSOC)) { ?> 
                         <div class="item">
                            <img src="assets/img/defualt.png" alt="user image" class="online">
                            <p class="message">
                              <a class="name">
                                <small class="text-muted pull-right"><i class="fa fa-clock-o"></i> <?=$row['time']; ?></small>
                                <?=GetFullNamewithUser($row['user']); ?></a>
                                <?=$row['chat']; ?>
                              </p>
                          </div><!-- /.item -->
                          <?php }} ?>
                                            <!-- chat item -->
                    </div><div class="slimScrollBar" style="background: rgb(0, 0, 0); width: 7px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 250px;"></div><div class="slimScrollRail" style="width: 7px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div></div><!-- /.chat -->
                    <div class="box-footer">
                    <?php 
                    checkInput();
                      if(isset($_POST['save'])){
                          $time=date("H:i:s");
                          $date=date("Y-m-d");
                          $ftime=date("Y-m-d H:i:s");
                          $reply= output(@$_POST['reply']);
                          $chat= output(@$_POST['chat']);
                          $chat2= output($_POST['chat2']);
                        if (!empty($reply) AND !empty($chat2)) {
                          if ((ndb("conversation"," date='$date' AND user='$un'") <= $array['stu_chat'] AND $das==3) OR ($das==2 OR $das==1)) {
                          $stm = $db->prepare("INSERT INTO conversation (user,user2,chat,time,date,ftime,type) VALUES (:chat,:chat2,:reply,:time,:date,:ftime,0);");
                           $stm->bindParam(":chat",$chat , PDO::PARAM_STR);
                           $stm->bindParam(":chat2",$chat2 , PDO::PARAM_STR);
                           $stm->bindParam(":reply",$reply , PDO::PARAM_STR);
                           $stm->bindParam(":time",$time , PDO::PARAM_STR);
                           $stm->bindParam(":date",$date , PDO::PARAM_STR);
                           $stm->bindParam(":ftime",$ftime , PDO::PARAM_STR);
                           $stm->execute();
                          $rowCount = $stm->rowCount();
                            if($rowCount > 0){
                                  dh(home);
                              }else {
                                  re("danger","هەڵەیەک ڕویدا!","نەتواندرا پەیام بنێردرێت");
                              }
                      }else {
                        re("info","ئاگاداری!","خوێندکاری خۆشەویست ڕۆژانە ناتوانی زیاتر لە ".$array['stu_chat']." پەیام بنێریت.");
                      }
                      }else{
                            re("danger"," هەڵە! "," تکایە خانەکان بەدروستی پڕبکەوە. ");
                      }
                      }

                      ?>
                    <form class="form-horizontal" action="" method="post" >
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input class="form-control" autofocus id="reply" name="reply" placeholder="پەیامێک بنووسە...">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <input type="hidden" name="chat" value="<?=@$un;?>">
                                <input type="hidden" name="chat2" value="<?=@$user;?>">
                                <input id="send" type="submit" value="ناردن" name="save" class="btn btn-success">
                                <!-- <input type="submit" value="زەخیرەکردن" name="draft" class="btn btn-info" style="float: left;"> -->
                            </div>
                        </div>
                    </form>
                    </div>
                </div><!-- /.box (chat box) -->
            </div>
<?php } ?>
            </div><!-- /.col -->
        </div>
                 <!-- /. ROW  -->
<div class="alert" role="alert" id="result"></div>
<?php 
$db = null;
include 'inc/foot.php'; ?>