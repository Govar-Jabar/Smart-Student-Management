<?php 
include('class.token.php'); 
require 'inc/head.php';
global $re; 
?>
                <div class="row">
                    <div class="col-md-12">
                     <h2> تاقیکردنەوەکان</h2>
                     <?php if($das==1 OR $das== 2){ ?> 
                        <h5>دەستکاریکردنی تاقیکردنەوەکان و ڕێکخستنیان</h5>
                        <?php if (!isset($_GET['id'])) { ?>
                        <a href="exam.php?id" style="float: left;" class="btn btn-success"><i class="fa icon-markpercentage"></i> زیادکردنی تاقیکردنەوە </a>
                        <?php }elseif(isset($_GET['id']) && !isset($_GET['edit'])) { ?>
                        <a href="exam.php" style="float: left;" class="btn btn-info"><i class="fa icon-markpercentage"></i> گەڕانەوە </a>
                        <?php }} ?>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                <div class="row">
                <div class="col-md-12">
                                 <div class="col-xs-12">
                                 <?php 
                                 if (isset($_GET['id'])) {
                                  ?>
                                      <div class="panel panel-default">
                                        <div class="panel-heading">زیادکردنی تاقیکردنەوە</div>
                                        <div class="panel-body">
                                        <?php
                                              $name=@output($_POST['name']);
                                              $subject=@output($_POST['subject']);
                                              $qg=@output($_POST['qg']);
                                              $dt=@output($_POST['dt']);
                                              $dtt=@output($_POST['dtt']);
                                              $cl=@output($_POST['cl']);
                                              $sdt=date("m/d/Y h:i A");
                                              
                                            if (isset($_POST['sub2'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                              if(!empty($name) && !empty($subject) && !empty($qg) && !empty($dt) && !empty($dtt)){
                                              $stm = $db->prepare("SELECT * FROM exam WHERE qg=:qg AND sub=:subject");
                                              $stm->bindParam(":qg", $qg, PDO::PARAM_STR);
                                              $stm->bindParam(":subject", $subject, PDO::PARAM_STR);
                                              $stm->execute();
                                              $rowCount = $stm->rowCount();
                                              if($rowCount == 0){
                                                  $stm = $db->prepare("INSERT INTO exam (id, name, sub, dt,dtt, sdt, qg,cl) VALUES (NULL, :name, :subject, :dt,:dtt, :sdt, :qg,:cl);");
                                                  $stm->bindParam(":name", $name, PDO::PARAM_STR);
                                                  $stm->bindParam(":subject", $subject, PDO::PARAM_STR);
                                                  $stm->bindParam(":dt", $dt, PDO::PARAM_STR);
                                                  $stm->bindParam(":dtt", $dtt, PDO::PARAM_STR);
                                                  $stm->bindParam(":sdt", $sdt, PDO::PARAM_STR);
                                                  $stm->bindParam(":qg", $qg, PDO::PARAM_STR);
                                                  $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
                                                  $stm->execute();
                                                  AddtoHistory("زیادکردنی تاقیکردنەوە",home);
                                                  re("success"," سوپاس "," تاقیکردنەوە بەسەرکەوتویی زیادکرا. ");
                                                  $db = null;
                                                  direct("./exam.php");
                                              }else {
                                                re("info"," ببورە "," هەمان تاقیکردنەوە بەهمان بابەت پێشتر زیاد کراوە.");
                                              }
                                            }else {
                                              re("danger"," کێشە! "," تکایە خانەکان بە دروستی پڕبکەوە.");
                                            }
                                            }else {
                                              re("danger"," کێشە! "," کێشەیەک ڕویدا تکایە دووبارە هەوڵ بدەوە.");
                                            }
                                          }
                                          ?>
                                            <form action="" method="post">
                                              <div class="form-group">
                                                    <label class="req">ناوی تاقیکرنەوە</label>
                                                    <input type="text" name="name" value="<?=@$name;?>" placeholder="" class="form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label class="req">قۆناغ</label>
                                                    <select onchange="showSubject(this.value,'sub','subject')" class="selectpicker" data-width="100%"  name="cl" class="form-control">
                                                      <option>قۆناغێك دیاری بکە</option>
                                                      <option value="1">1</option>
                                                      <option value="2">2</option>
                                                      <option value="3">3</option>
                                                      <option value="4">4</option>
                                                    </select>
                                              </div> 
                                              <div class="form-group" id="subject">

                                              </div>
                                              <div class="form-group">
                                                    <label class="req">گروپی پرسیار</label>
                                                    <select class="selectpicker" data-width="100%"  name="qg" class="form-control">
                                                      <?php qg_f(); ?>
                                                    </select>
                                              </div> 
                                              <label class="req">کات</label>
                                              <div class="form-group">
                                                <input  class="form-control" type="text" autocomplete="off" name="dt" value="<?php if($dt==""){echo date("Y/m/d H:i:s");}else{echo $dt;} ?>" placeholder="" id="time">
                                              </div>                                              
                                              <label class="req">تا</label>
                                              <div class="form-group">
                                                <input  class="form-control" type="text" autocomplete="off" name="dtt" value="<?php if($dtt==""){echo date("Y/m/d H:i:s");}else{echo $dtt;} ?>" placeholder="" id="t2">
                                              </div>
                                             <input type="hidden" name="token" value="<?php echo Token::create(); ?>">
                                            <button type="submit" name="sub2" class="btn btn-default">زیادکردن</button>
                                            </form>
                                        </div>
                                    </div>

                        <?php
                        }elseif(isset($_GET['edit'])){ 
                          $id=@output($_GET['edit']);
                          if (($das==2 AND ndb("sub,exam,tea","tea.user='$un' AND exam.id='$id' AND tea.id=sub.tea AND sub.id=exam.sub")==1) OR $das==1) {

                          }else {
                            dh("index.php");
                          }
                          ?>

                                      <div class="panel panel-default">
                                        <div class="panel-heading">دەستکاریکردنی تاقیکردنەوە</div>
                                        <div class="panel-body">
                                        <?php
                                              $qg=@output($_POST['qg']);
                                              $name=@output($_POST['name']);
                                              $sub=@output($_POST['sub']);
                                              $dt=@output($_POST['dt']);
                                              $dtt=@output($_POST['dtt']);
                                              $cl=@output($_POST['cl']);
                                            if (isset($_POST['sub2'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                             
                                                  $stm = $db->prepare("UPDATE exam SET qg=:qg,name=:name,cl=:cl,sub=:sub,dt=:dt,dtt=:dtt WHERE id=:id");

                                                  $stm->bindParam(":qg", $qg, PDO::PARAM_STR);
                                                  $stm->bindParam(":name", $name, PDO::PARAM_STR);
                                                  $stm->bindParam(":sub", $sub, PDO::PARAM_STR);
                                                  $stm->bindParam(":dt", $dt, PDO::PARAM_STR);
                                                  $stm->bindParam(":dtt", $dtt, PDO::PARAM_STR);
                                                  $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                                  $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
                                                  $stm->execute();
                                                  AddtoHistory("دەستکاریکردنی تاقیکردنەوە",home);
                                                  re("success"," سوپاس "," تاقیکردنەوە بەسەرکەوتویی نوێکرایەوە. ");
                                                  //$db = null;
                                                  direct("");
                                                
                                            }else {
                                              re("danger"," کێشە! "," کێشەیەک ڕویدا تکایە دووبارە هەوڵ بدەوە.");
                                            }
                                          }
                                          // Select data
                                            $stm = $db->prepare("SELECT * FROM exam WHERE id=:id");
                                            $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                            $stm->execute();
                                            $fetch = $stm->fetch(PDO::FETCH_OBJ);
                                            $rowCount = $stm->rowCount();
                                            if($rowCount > 0){ ?>
                                            <form action="" method="post">
                                             <div class="col-md-12">
                                              <div class="form-group">
                                                    <label>ناوی تاقیکرنەوە</label>
                                                    <input type="text" name="name" value="<?=$fetch->name;?>" placeholder="" class="form-control">
                                              </div>
                                                <div class="form-group">
                                                    <label class="req">قۆناغ</label>
                                                    <select onchange="showSubject(this.value,'sub','subject')" class="selectpicker" data-width="100%"  name="cl" class="form-control">
                                                      <option <?php va("1",$fetch->cl) ?> value="1">1</option>
                                                      <option <?php va("2",$fetch->cl) ?> value="2">2</option>
                                                      <option <?php va("3",$fetch->cl) ?> value="3">3</option>
                                                      <option <?php va("4",$fetch->cl) ?> value="4">4</option>
                                                    </select>
                                              </div> 
                                              <div class="form-group" id="subject">
                                                    <label class="req">بابەت</label>
                                                    <select  class="selectpicker" data-width="100%"  name="sub" class="form-control">
                                                      <option>وانەیەک دیاری بکە</option>
                                                      <?php selectsub($fetch->sub); ?>
                                                    </select>
                                              </div> 
                                              <div class="form-group">
                                                    <label>گروپی پرسیار</label>
                                                    <select class="selectpicker" data-width="100%"  name="qg" class="form-control">
                                                      <?php qg_f1(); ?>
                                                    </select>
                                              </div> 
                                              <label>کات</label>
                                              <div class="form-group">
                                                <input  class="form-control" type="text" autocomplete="off" name="dt" value="<?=$fetch->dt;?>" placeholder="" id="time">
                                              </div>                                              
                                              <label>تا</label>
                                              <div class="form-group">
                                                <input  class="form-control date" autocomplete="off" type="text" name="dtt" value="<?=$fetch->dtt;?>" placeholder="" id="t2">
                                              </div>
                                             <input type="hidden" name="token" value="<?php echo Token::create(); ?>">
                                            <button type="submit" name="sub2" class="btn btn-default">دەستکاری</button>
                                            </form>
                                            </div>
                                            <?php }else {
                                              e4();
                                            } ?>
                                        </div>
                                    </div>

                         <?php }else{ 
                            $del = output(@$_GET['del']);
                            if (isset($del) && $del!="") {
                              if (($das==2 AND ndb("exam,qg","qg.user='$un' AND exam.id='$del' AND exam.qg=qg.id")==1) OR $das==1) {
                              $stm = $db->prepare("DELETE FROM exam WHERE id=:id");
                              $stm->bindParam(":id", $del, PDO::PARAM_STR);
                              $stm->execute();
                              AddtoHistory("سڕینەوەی تاقیکردنەوە",home);
                              re("danger","  بابەت ","بەسەرکەوتویی سڕایەوە.");
                              direct("exam.php");
                            }
                          }
                          ?>
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             تاقیکردنەوەکان
                        </div>
                        <div class="panel-body">
                        <?php

                        $stm = $db->prepare("SELECT * FROM exam");
                        if($das==3){
                          $cl= gClass($un);
                          $stm = $db->prepare("SELECT * FROM exam WHERE cl=:cl AND (NOW() BETWEEN dt AND dtt)");
                          $stm->bindParam(":cl",$cl, PDO::PARAM_STR);
                        }
                        $stm->execute();
                        $rowCount = $stm->rowCount();
                        if($rowCount > 0){
                        ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" data-id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th width="50px">#</th>
                                            <th>ناو</th>
                                            <th>بابەت</th>
                                            <th width="50px">قۆناغ</th>
                                            <th width="120px">گروپی پرسیار</th>
                                            <th width="160px">کات</th>
                                            <th width="160px">تا</th>
                                            <th width="">کردار</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $nu = 0;
                                    while($row = $stm->fetch(PDO::FETCH_ASSOC)) { 
                                      ?>
                                        <tr class="<?php if($nu % 2==0){echo 'odd';}else{echo 'even';} ?>">
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['name']; ?></td>
                                            <td><?php echo sub($row['sub']); ?></td>
                                            <td><?php echo $row['cl']; ?></td>
                                            <td><?php echo qg($row['qg']); ?></td>
                                            <td id="date"><?php echo $row['dt']; ?></td>
                                            <td id="date"><?php echo $row['dtt']; ?></td>
                                            <td>
                                          <?php
                                            $exam = $row['id'];
                                            $cl=gClass($un);
                                            $stm2 = $db->prepare("SELECT * FROM exam WHERE cl=:cl AND NOW() BETWEEN dt AND dtt AND id =:exam");
                                            $stm2->bindParam(":cl", $cl, PDO::PARAM_STR);
                                            $stm2->bindParam(":exam", $exam, PDO::PARAM_STR);
                                            $stm2->execute();
                                            $fe = $stm2->fetch(PDO::FETCH_OBJ);
                                            $rowc = $stm2->rowCount();
                                            $dtb=0;
                                            if ($rowc>0 AND $das==3) { ?>
                                              <button class="btn btn-primary btn-sm" onclick="newPopup('texam.php?exam=<?php echo $row['id']; ?>')">دەست بکە بە تاقیکردنەوە</button>
                                              <?php }else{ if(NumExam($row['id'],$un)!=0 AND $das==3){?>
                                              <button class="btn btn-info btn-sm" onclick="newPopup('texam.php?exam=<?php echo $row['id']; ?>&result')">ئەنجامی تاقیکردنەوە</button>
                                              <?php }}
                                                
                                              if($das==1 OR $das==2){
                                                $eid=$row['id'];
                                                if (($das==2 AND ndb("exam,qg","qg.user='$un' AND exam.id='$eid' AND exam.qg=qg.id")==1) OR $das==1) {
                                                
                                              ?>
                                              <a href="exam.php?edit=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" class="btn btn-success btn-xs mrg" title="دەستکاری"><i class="fa fa-edit"></i></a>

                                              <a href="exam.php?del=<?php echo $row['id']; ?>" value="#go" id="btn-confirm" data-toggle="tooltip" data-placement="top" class="btn btn-danger btn-xs mrg confirmation" title="سڕینەوە"><i class="fa fa-trash-o"></i></a>

                                              
                                              <?php }} ?>
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
            </div>
                <!-- /. ROW  -->
          </div>
                 <!-- /. ROW  -->

<div class="alert" role="alert" id="result"></div>

<?php 
$db = null;
include 'inc/foot.php'; ?>