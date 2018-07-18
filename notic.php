<?php 
include('class.token.php'); 
require 'inc/head.php';
global $re; 
?>
                <div class="row">
                    <div class="col-md-12">
                     <h2> ئاگادارکردنەوەکان</h2>   
                        <h5>زیادکردنی ئاگادارکردنەوەکان و ڕێکخستنیان.</h5>
                        <?php if (!isset($_GET['id'])) { ?>
                        <a href="notic.php?id" style="float: left;" class="btn btn-success"><i class="fa icon-noticemain"></i> زیادکردنی ئاگادارکرنەوە </a>
                        <?php }elseif(isset($_GET['id']) && !isset($_GET['edit'])) { ?>
                        <a href="notic.php" style="float: left;" class="btn btn-info"><i class="fa icon-noticemain"></i> گەڕانەوە </a>
                        <?php } ?>
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
                                        <div class="panel-heading">زیادکردنی ئاگادرکردنەوە</div>
                                        <div class="panel-body">
                                        <?php
                                              $title=@output($_POST['title']);
                                              $cl=@output($_POST['cl']);
                                              $dt=@output($_POST['dt']);
                                              $dtt=@output($_POST['dtt']);
                                              $r=@output($_POST['r']);
                                              $notic=@output($_POST['notic']);
                                              
                                            if (isset($_POST['sub2'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                              if(!empty($title) AND (!empty($cl) OR $cl==0) AND !empty($dt) AND !empty($dtt) AND !empty($r) AND !empty($notic)){
                                                  $stm = $db->prepare("INSERT INTO notic (id, title,notic,dt,dtt,cl,r) VALUES (NULL, :title, :notic, :dt, :dtt, :cl, :r);");
                                                  $stm->bindParam(":title", $title, PDO::PARAM_STR);
                                                  $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
                                                  $stm->bindParam(":dt", $dt, PDO::PARAM_STR);
                                                  $stm->bindParam(":dtt", $dtt, PDO::PARAM_STR);
                                                  $stm->bindParam(":notic", $notic, PDO::PARAM_STR);
                                                  $stm->bindParam(":r", $r, PDO::PARAM_STR);
                                                  $stm->execute();
                                                  AddtoHistory("زیادکردنی ئاگادارکردنەوە",home);
                                                  re("success"," سوپاس "," ئاگادارکردنەوە بەسەرکەوتویی زیادکرا. ");
                                                  
                                                  direct("notic.php");
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
                                                    <label class="req">ناونیشانی ئاگادارکردنەوە </label>
                                                    <input type="text" name="title" value="<?=@$title;?>" placeholder="" class="form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label class="req">ئاگاداری بۆ</label>
                                                    <select onchange="notic1(this.value);" class="selectpicker" data-width="100%"  name="r" class="form-control">
                                                      <option value="3">خوێندکار</option>
                                                      <option value="2">مامۆستا</option>
                                                    </select>
                                              </div>                                              
                                              <div id="class" class="form-group">
                                                    <label class="req">قۆناغ</label>
                                                    <select class="selectpicker" data-width="100%"  name="cl" class="form-control">
                                                      <option value="0">هەموو قۆناغەکان</option>
                                                      <option value="1">1</option>
                                                      <option value="2">2</option>
                                                      <option value="3">3</option>
                                                      <option value="4">4</option>
                                                    </select>
                                              </div>
                                              <div class="form-group">
                                                    <label class="req">ناوەڕۆك</label>
                                                    <textarea class="form-control" name="notic"><?=@$notic;?></textarea>
                                              </div>
                                              <div class="col-md-6">
                                              <div class="form-group">
                                                    <label class="req">بەروار</label>
                                                    <input name="dt" type="text" class="form-control" autocomplete="off" id="snotic" value="<?php if($dt==""){echo date("Y-m-d");}else{ echo $dt;};?>">
                                              </div>                                            
                                              </div> 
                                              <div class="col-md-6">                                             
                                              <div class="form-group">
                                                    <label class="req">تا</label>
                                                    <input name="dtt" type="text" class="form-control" autocomplete="off" id="enotic" value="<?php if($dtt==""){echo date("Y-m-d");}else{ echo $dtt;};?>">
                                              </div>
                                              </div>
                                             <input type="hidden" name="token" value="<?php echo Token::create(); ?>">
                                            <button type="submit" name="sub2" class="btn btn-default">زیادکردن</button>
                                            </form>
                                        </div>
                                    </div>

                        <?php
                        }elseif(isset($_GET['edit'])){ ?>


                                      <div class="panel panel-default">
                                        <div class="panel-heading">دەستکاریکردنی ئاگادرکردنەوەکان</div>
                                        <div class="panel-body">
                                        <?php
                                              $title=@output($_POST['title']);
                                              $cl=@output($_POST['cl']);
                                              $dt=@output($_POST['dt']);
                                              $dtt=@output($_POST['dtt']);
                                              $r=@output($_POST['r']);
                                              $notic=@output($_POST['notic']);
                                              $id=@output($_GET['edit']);
                                            if (isset($_POST['sub2'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                                
                                                  $stm = $db->prepare("UPDATE notic SET title=:title,cl=:cl,dt=:dt,dtt=:dtt,notic=:notic,r=:r WHERE id=:id");
                                                  $stm->bindParam(":title", $title, PDO::PARAM_STR);
                                                  $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
                                                  $stm->bindParam(":dt", $dt, PDO::PARAM_STR);
                                                  $stm->bindParam(":dtt", $dtt, PDO::PARAM_STR);
                                                  $stm->bindParam(":notic", $notic, PDO::PARAM_STR);
                                                  $stm->bindParam(":r", $r, PDO::PARAM_STR);
                                                  $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                                  $stm->execute();
                                                  AddtoHistory("دەستکاریکردنی ئاگادارکردنەوە",home);
                                                  re("success"," سوپاس "," ئاگادارکردنەوە بەسەرکەوتویی نوێکرایەوە. ");
                                                  //$db = null;

                                                  direct("notic.php");
                                              
                                            }else {
                                              re("danger"," کێشە! "," کێشەیەک ڕویدا تکایە دووبارە هەوڵ بدەوە.");
                                            }
                                          }
                                          // Select data
                                            $stm = $db->prepare("SELECT * FROM notic WHERE id=:id");
                                            $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                            $stm->execute();
                                            $fetch = $stm->fetch(PDO::FETCH_OBJ);
                                            $rowCount = $stm->rowCount();
                                            if($rowCount > 0){ ?>
                                            <form action="" method="post">
                                              <div class="form-group">
                                                    <label>ناونیشانی ئاگادارکردنەوە</label>
                                                    <input type="text" name="title" value="<?=$fetch->title;?>" placeholder="" class="form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label>ئاگاداری بۆ</label>
                                                    <select onchange="notic1(this.value);" class="selectpicker" data-width="100%"  name="r" class="form-control">
                                                      <option <?php bl(3,"r"); ?> value="3">خوێندکار</option>
                                                      <option <?php bl(2,"r"); ?> value="2">مامۆستا</option>
                                                    </select>
                                              </div>                                           
                                              <div id="class"  <?php if($fetch->r==2){echo 'style="display: none;"';} ?> class="form-group">
                                                    <label>قۆناغ</label>
                                                    <select onchange="" class="selectpicker" data-width="100%"  name="cl" class="form-control">
                                                      <option <?php bl(0,"cl"); ?> value="0">هەموو قۆناغەکان</option>
                                                      <option  <?php bl(1,"cl"); ?> value="1">1</option>
                                                      <option <?php bl(2,"cl"); ?>  value="2">2</option>
                                                      <option <?php bl(3,"cl"); ?>  value="3">3</option>
                                                      <option <?php bl(4,"cl"); ?>  value="4">4</option>
                                                    </select>
                                              </div>
                                              <div class="form-group">
                                                    <label>ناوەڕۆك</label>
                                                    <textarea class="form-control" name="notic"><?=$fetch->notic;?></textarea>
                                              </div>
                                              <div class="col-md-6">
                                              <div class="form-group">
                                                    <label>بەروار</label>
                                                    <input name="dt" type="text" class="form-control" autocomplete="off" id="date" value="<?=$fetch->dt;?>">
                                              </div>                                            
                                              </div> 
                                              <div class="col-md-6">                                             
                                              <div class="form-group">
                                                    <label>تا</label>
                                                    <input name="dtt" type="text" class="form-control" autocomplete="off" id="date3" value="<?=$fetch->dtt;?>">
                                              </div>
                                              </div>
                                             <input type="hidden" name="token" value="<?php echo Token::create(); ?>">
                                            <button type="submit" name="sub2" class="btn btn-default">دەستکاری</button>
                                            </form>
                                            <?php }else {
                                              e4();
                                            } ?>
                                        </div>
                                    </div>

                         <?php }else{ 
                            $del = output(@$_GET['del']);
                            if (isset($del) && $del!="") {
                              $stm = $db->prepare("DELETE FROM notic WHERE id=:id");
                              $stm->bindParam(":id", $del, PDO::PARAM_STR);
                              $stm->execute();
                              AddtoHistory("سڕینەوەی ئاگادارکردنەوە",home);
                              re("danger","  بابەت ","بەسەرکەوتویی سڕایەوە.");
                              dh("notic.php");
                            }
                          ?>
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             ئاگادرکردنەوەکان
                        </div>
                        <div class="panel-body">
                        <?php

                        $stm = $db->prepare("SELECT * FROM notic ORDER BY id DESC");
                        $stm->execute();
                        $rowCount = $stm->rowCount();
                        if($rowCount > 0){
                        ?>

                            <div class="table-responsive">
                                <table id="advance" class="table table-striped table-bordered table-hover" data-id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th width="50px">#</th>
                                            <th>سەردێڕ</th>
                                            <th>ناوەڕۆک</th>
                                            <th>ئاگاداری بۆ</th>
                                            <th width="70px">کردار</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $nu = 0;
                                    while($row = $stm->fetch(PDO::FETCH_ASSOC)) { 
                                      ?>
                                        <tr class="<?php if($nu % 2==0){echo 'odd';}else{echo 'even';} ?>">
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['title']; ?></td>
                                            <td><?php echo $row['notic']; ?></td>
                                            <td><?php echo r($row['r']); ?></td>
                                            <td>
                                            <?php  if($das==1 OR ($das==2 AND $un==$row['user'])){ ?>
                                              <a href="notic.php?edit=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" class="btn btn-info btn-xs mrg" title="دەستکاری"><i class="fa fa-edit"></i></a>

                                              <a href="notic.php?del=<?php echo $row['id']; ?>" value="#go" id="btn-confirm" data-toggle="tooltip" data-placement="top" class="btn btn-danger btn-xs mrg confirmation" title="سڕینەوە"><i class="fa fa-trash-o"></i></a>
                                              <?php } ?>
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