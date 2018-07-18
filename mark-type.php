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
                     <h2> نمرەکان</h2>
                        <h5>دەستکاریکردنی نمرەکان و ڕێکخستنیان</h5>
                        <?php if (!isset($_GET['id'])) { ?>
                        <a href="mark-type.php?id" style="float: left;" class="btn btn-success"><i class="fa icon-markmain"></i> زیادکردنی شێوازی دابەشکردنی نمرە </a>
                        <?php }elseif(isset($_GET['id']) && !isset($_GET['edit'])) { ?>
                        <a href="mark-type.php" style="float: left;" class="btn btn-info"><i class="fa icon-markmain"></i> گەڕانەوە </a>
                        <?php } ?>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                              <div class="row">
                                 <div class="col-xs-12">
                                 <?php 
                                 if (isset($_GET['id'])) {
                                  ?>
                                      <div class="panel panel-default">
                                        <div class="panel-heading">زیادکردنی شێوازی نمرەکان</div>
                                        <div class="panel-body">
                                        <?php
                                              $type=@output($_POST['type']);
                                              $mark=@output($_POST['mark']);
                                              
                                            if (isset($_POST['sub2'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                              
                                              if(!empty($type) && !empty($mark) ){

                                              // $stm = $db->prepare("SELECT * FROM sub WHERE cl=:cl AND tea=:tea");
                                              // $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
                                              // $stm->bindParam(":tea", $tea, PDO::PARAM_STR);
                                              // $stm->execute();
                                              // $rowCount = $stm->rowCount();
                                              // if($rowCount == 0){
                                                  $stm = $db->prepare("INSERT INTO mark (mark_id, mark,type) VALUES (NULL,:mark,:type);");
                                                  $stm->bindParam(":type", $type, PDO::PARAM_STR);
                                                  $stm->bindParam(":mark", $mark, PDO::PARAM_STR);

                                                  $stm->execute();
                                                  AddtoHistory("زیادکردنی شێوازی نمرەکان",home);
                                                  re("success"," سوپاس "," بەسەرکەوتویی زیادکرا. ");
                                                  $db = null;
                                                  direct("./mark-type.php");
                                              // }else {
                                              //   re("info"," ببورە "," هەمان مامۆستا بەهمان بابەت پێشتر زیاد کراوە.");
                                              // }
                                            }else {
                                              re("danger"," کێشە! "," تکایە خانەکان بە دروستی پڕبکەوە، وێنەی دروست هەڵبژێرە.");
                                            }
                                            }else {
                                              re("danger"," کێشە! "," کێشەیەک ڕویدا تکایە دووبارە هەوڵ بدەوە.");
                                            }
                                          }
                                          ?>
                                            <form action="" method="post">
                                              <div class="form-group">
                                                    <label>جۆر</label>
                                                    <select class="selectpicker" data-width="100%"  name="type" class="form-control">
                                                      <option value="1">ڕۆژانە</option>
                                                      <option value="2">تاقیکردنەوەی مانگی دووەم</option>
                                                      <option value="3">تاقیکردنەوەی مانگی یەکەم</option>
                                                      <option value="4">تاقیکردنەوەی کۆتایی</option>
                                                    </select>
                                              </div>
                                              <div class="form-group">
                                                    <label>ڕێژەی نمرە بە (٪)</label>
                                                    <input type="text" name="mark"  placeholder="" class="form-control">
                                              </div>

                                             <input type="hidden" name="token" value="<?php echo Token::create(); ?>">
                                            <button type="submit" name="sub2" class="btn btn-default">زیادکردن</button>
                                            </form>
                                        </div>
                                    </div>

                        <?php
                        }elseif(isset($_GET['edit'])){
                          $id=@output($_GET['edit']);
                          // if(ndb("sub,tea","sub.tea=tea.id AND tea.user='$un' AND sub.id=$id")!=1){
                          //   if($das==1){

                          //   }else{
                          //     dh("index.php");
                          //     exit;
                          //   }
                          // }

                          ?>


                                      <div class="panel panel-default">
                                        <div class="panel-heading">دەستکاریکردنی شێوازی نمرەکان</div>
                                        <div class="panel-body">
                                        <?php
                                              $type=@output($_POST['type']);
                                              $mark=@output($_POST['mark']);
                                            if (isset($_POST['sub2'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                              if(!empty($type) && !empty($mark) ){
                                                  $stm = $db->prepare("UPDATE mark SET type=:type,mark=:mark WHERE mark_id=:id");
                                                  $stm->bindParam(":type", $type, PDO::PARAM_STR);
                                                  $stm->bindParam(":mark", $mark, PDO::PARAM_STR);
                                                  $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                                  $stm->execute();
                                                  AddtoHistory("دەستکاریکردنی شێوازی نمرەکان",home);
                                                  re("success"," سوپاس "," وانە بەسەرکەوتویی نوێکرایەوە. ");
                                                  direct("mark-type.php");
                                                // }else{
                                                //   re("info"," ببورە "," ئەم وانەیە بەهەمان مامۆستاوە بونی هەیە. ");
                                                // }
                                              
                                            }else {
                                              re("danger"," هەڵە"," تکایە زانیاریەکان بەدروستی پڕبکەوە.");
                                            }                                              
                                            }else {
                                              re("danger"," کێشە! "," کێشەیەک ڕویدا تکایە دووبارە هەوڵ بدەوە.");
                                            }
                                          }
                                          // Select data
                                            $stm = $db->prepare("SELECT * FROM mark WHERE mark_id=:id");
                                            $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                            $stm->execute();
                                            $fetch = $stm->fetch(PDO::FETCH_OBJ);
                                            $rowCount = $stm->rowCount();
                                            if($rowCount > 0){ ?>
                                            <form action="" method="post" >
                                              <div class="form-group">
                                                    <label>جۆر</label>
                                                    <select class="selectpicker" data-width="100%"  name="type" class="form-control">
                                                      <option <?php va($fetch->type,"1"); ?> value="1">تاقیکردنەوەی کۆتایی</option>
                                                      <option <?php va($fetch->type,"2"); ?> value="2">تاقیکردنەوەی مانگی یەکەم</option>
                                                      <option <?php va($fetch->type,"3"); ?> value="3">تاقیکردنەوەی مانگی دووەم</option>
                                                      <option <?php va($fetch->type,"4"); ?> value="4">ڕۆژانە</option>
                                                    </select>
                                              </div>
                                              <div class="form-group">
                                                    <label>ڕێژەی نمرە بە (٪)</label>
                                                    <input type="text" name="mark"  value="<?php echo $fetch->mark; ?>" class="form-control">
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
                              // if(ndb("sub,tea","sub.tea=tea.id AND tea.user='$un' AND sub.id=$del")!=1 OR $das!=1){
                              //   dh("index.php");
                              //   exit;
                              // }
                              $stm = $db->prepare("DELETE FROM mark WHERE id=:id");
                              $stm->bindParam(":id", $del, PDO::PARAM_STR);
                              $stm->execute();
                              AddtoHistory("سڕینەوەی شێوازی نمرەکان.",home);
                              re("danger","  بابەت ","بەسەرکەوتویی سڕایەوە.");
                              direct("subject.php");
                            }
                          ?>
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             لیستی شێوازی دابەشکردنی نمرەکان
                        </div>
                        <div class="panel-body">
                        <?php

                        $stm = $db->prepare("SELECT * FROM mark");
                        $stm->execute();
                        $rowCount = $stm->rowCount();
                        if($rowCount > 0){
                        ?>
                            <div class="table-responsive">
                                <table id="advance" class="table table-striped table-bordered table-hover" data-id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th width="50px">#</th>
                                            <th>جۆر</th>
                                            <th>نمرە بە ڕێژەی (٪)</th>
                                            <th width="120px">کردار</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $nu = 0;
                                    while($row = $stm->fetch(PDO::FETCH_ASSOC)) { 
                                      ?>
                                        <tr class="<?php if($nu % 2==0){echo 'odd';}else{echo 'even';} ?>">
                                            <td><?php echo $row['mark_id']; ?></td>
                                            <td><?php echo typeMark($row['type']); ?></td>
                                            <td><?php echo $row['mark']; ?></td>
                                            <td>
                                            
                                              <a href="mark-type.php?edit=<?php echo $row['mark_id']; ?>" data-toggle="tooltip" data-placement="top" class="btn btn-info btn-xs mrg" title="دەستکاری"><i class="fa fa-edit"></i></a>
                                              <a href="mark-type.php?del=<?php echo $row['mark_id']; ?>" value="#go" id="btn-confirm" data-toggle="tooltip" data-placement="top" class="btn btn-danger btn-xs mrg confirmation" title="سڕینەوە"><i class="fa fa-trash-o"></i></a>
                                              <?php } ?>

                                              </td>

                                        </tr>
                                        <?php
                                              $nu++;
                                            }
                                            $db = null;
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                    
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