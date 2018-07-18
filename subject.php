<?php 
include('class.token.php'); 
require 'inc/head.php';
global $re; 
?>
                <div class="row">
                    <div class="col-md-12">
                     <h2> وانەکان</h2>
                       <?php  if($das==1 OR $das==2){ ?>
                        <h5>دەستکاریکردنی وانەکان و ڕێکخستنیان</h5>
                        <?php if (!isset($_GET['id'])) { ?>
                        <a href="subject.php?id" style="float: left;" class="btn btn-success"><i class="fa icon-subject"></i> زیادکردنی وانە </a>
                        <?php }elseif(isset($_GET['id']) && !isset($_GET['edit'])) { ?>
                        <a href="subject.php" style="float: left;" class="btn btn-info"><i class="fa icon-subject"></i> گەڕانەوە </a>
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
                                        <div class="panel-heading">زیادکردنی وانە</div>
                                        <div class="panel-body">
                                        <?php
                                              $cl=@output($_POST['cl']);
                                              $sn=@output($_POST['sn']);
                                              $sa=@output($_POST['sa']);
                                              $tea=@output($_POST['tea']);
                                              $ab=@output($_POST['ab']);
                                              $atte=@output($_POST['atte']);
                                              
                                            if (isset($_POST['sub2'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                              upload();
                                              pdf();
                                              checkInput();
                                              if(!empty($cl) && !empty($sn) && !empty($atte) && !empty($sa) && !empty($tea) && (!isset($ab) OR $feilds['book_ab']=="") AND ($pdfOk==1 OR $feilds['book_pdf']=="") ){

                                              // $stm = $db->prepare("SELECT * FROM sub WHERE cl=:cl AND tea=:tea");
                                              // $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
                                              // $stm->bindParam(":tea", $tea, PDO::PARAM_STR);
                                              // $stm->execute();
                                              // $rowCount = $stm->rowCount();
                                              // if($rowCount == 0){
                                                  $stm = $db->prepare("INSERT INTO sub (id, cl, sn,atte, sa, tea, ab,img,pdf) VALUES (NULL, :cl, :sn,:atte, :sa, :tea, :ab,:img,:pdf);");
                                                  $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
                                                  $stm->bindParam(":sn", $sn, PDO::PARAM_STR);
                                                  $stm->bindParam(":atte", $atte, PDO::PARAM_STR);
                                                  $stm->bindParam(":sa", $sa, PDO::PARAM_STR);
                                                  $stm->bindParam(":tea", $tea, PDO::PARAM_STR);
                                                  $stm->bindParam(":ab", $ab, PDO::PARAM_STR);
                                                  $stm->bindParam(":img", $img, PDO::PARAM_STR);
                                                  $stm->bindParam(":pdf", $pdf, PDO::PARAM_STR);
                                                  $stm->execute();
                                                  AddtoHistory("زیادکردنی بابەت",home);
                                                  re("success"," سوپاس "," وانە بەسەرکەوتویی زیادکرا. ");
                                                  $db = null;
                                                  direct("./subject.php");
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
                                            <form action="" method="post" enctype="multipart/form-data">
                                              <div class="form-group">
                                                    <label class="req">ناوی کتاب</label>
                                                    <input type="text" name="sn" value="<?=@$sn;?>" placeholder="" class="form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label class="req">ناوی نوسەری کتاب</label>
                                                    <input type="text" name="sa" value="<?=@$sa;?>" placeholder="" class="form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label <?php echo $feilds["book_pdf"] != "" ? ' class="req"' : ''; ?>>PDF</label>
                                                    <input type="file" accept="application/pdf" name="uploadpdf" data-label="دیاریکردن" class="filepicker form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label>وێنەی کتاب</label>
                                                    <input type="file" accept="image/png, image/jpeg, image/gif, image/jpg"  name="fileToUpload" data-label="دیاریکردن" class="filepicker form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label  class="req">ناوی وانەبێژ</label>
                                                    <select class="selectpicker" data-width="100%"  name="tea" class="form-control">
                                                      <?php tea_f(0); ?>
                                                    </select>
                                                </div>
                                              <div class="form-group">
                                                    <label  class="req">قۆناغ</label>
                                                    <select class="selectpicker" data-width="100%"  name="cl" class="form-control">
                                                      <option value="1">1</option>
                                                      <option value="2">2</option>
                                                      <option value="3">3</option>
                                                      <option value="4">4</option>
                                                    </select>
                                                </div> 
                                                <div class="form-group">
                                                      <label class="req">ڕێژەی کۆتا سەعاتی ئامادەنەبوون</label>
                                                      <input type="number" name="atte" value="<?=@$atte;?>" placeholder="" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label <?php echo $feilds["book_ab"] != "" ? ' class="req"' : ''; ?>>کوردەیەک دەربارەی کتاب</label>
                                                    <textarea rows="6" type="text" name="ab" class="form-control"><?=@$ab;?></textarea>
                                                </div>
                                             <input type="hidden" name="token" value="<?php echo Token::create(); ?>">
                                            <button type="submit" name="sub2" class="btn btn-default">زیادکردن</button>
                                            </form>
                                        </div>
                                    </div>

                        <?php
                        }elseif(isset($_GET['edit'])){
                          $id=@output($_GET['edit']);
                          if(ndb("sub,tea","sub.tea=tea.id AND tea.user='$un' AND sub.id=$id")!=1){
                            if($das==1){

                            }else{
                              dh("index.php");
                              exit;
                            }
                          }

                          ?>


                                      <div class="panel panel-default">
                                        <div class="panel-heading">دەستکاریکردنی وانە</div>
                                        <div class="panel-body">
                                        <?php
                                              $cl=@output($_POST['cl']);
                                              $sn=@output($_POST['sn']);
                                              $sa=@output($_POST['sa']);
                                              $tea=@output($_POST['tea']);
                                              $ab=@output($_POST['ab']);
                                              $atte=@output($_POST['atte']);
                                            if (isset($_POST['sub2'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                              upload();
                                              pdf();
                                              checkInput();
                                              if(!empty($cl) && !empty($sn) &&  !empty($atte) && !empty($sa) && !empty($tea) && (!isset($ab) OR $feilds['book_ab']=="") AND ($pdfOk==1 OR $feilds['book_pdf']=="") ){
                                                  $stm = $db->prepare("UPDATE sub SET cl=:cl,atte=:atte,sn=:sn,sa=:sa,tea=:tea,ab=:ab WHERE id=:id");
                                                  if ($uploadOk==1 AND $pdf!=1) {
                                                  $stm = $db->prepare("UPDATE sub SET cl=:cl,atte=:atte,sn=:sn,sa=:sa,tea=:tea,ab=:ab,img=:img WHERE id=:id");
                                                  $stm->bindParam(":img", $img, PDO::PARAM_STR);
                                                  }
                                                  if ($uploadOk!=1 AND $pdfOk==1) {
                                                  $stm = $db->prepare("UPDATE sub SET cl=:cl,atte=:atte,sn=:sn,sa=:sa,tea=:tea,ab=:ab,pdf=:pdf WHERE id=:id");
                                                  $stm->bindParam(":pdf", $pdf, PDO::PARAM_STR);
                                                  }
                                                  if ($uploadOk==1 AND $pdfOk==1) {
                                                    $stm = $db->prepare("UPDATE sub SET cl=:cl,atte=:atte,sn=:sn,sa=:sa,tea=:tea,ab=:ab,pdf=:pdf,img=:img WHERE id=:id");
                                                  $stm->bindParam(":pdf", $pdf, PDO::PARAM_STR);
                                                  $stm->bindParam(":img", $img, PDO::PARAM_STR);
                                                  }
                                                  $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
                                                  $stm->bindParam(":sn", $sn, PDO::PARAM_STR);
                                                  $stm->bindParam(":sa", $sa, PDO::PARAM_STR);
                                                  $stm->bindParam(":tea", $tea, PDO::PARAM_STR);
                                                  $stm->bindParam(":ab", $ab, PDO::PARAM_STR);
                                                  $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                                  $stm->bindParam(":atte", $atte, PDO::PARAM_STR);
                                                  $stm->execute();
                                                  AddtoHistory("دەستکاریکردنی بابەت",home);
                                                  re("success"," سوپاس "," وانە بەسەرکەوتویی نوێکرایەوە. ");
                                                  //$db = null;
                                                  direct("");
                                                }else {
                                              re("danger"," کێشە! "," تکایە خانەکان بە دروستی پڕبکەوە، وێنەی دروست هەڵبژێرە.");
                                            }
                                              
                                            }else {
                                              re("danger"," کێشە! "," کێشەیەک ڕویدا تکایە دووبارە هەوڵ بدەوە.");
                                            }
                                          }
                                          // Select data
                                            $stm = $db->prepare("SELECT * FROM sub WHERE id=:id");
                                            $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                            $stm->execute();
                                            $fetch = $stm->fetch(PDO::FETCH_OBJ);
                                            $rowCount = $stm->rowCount();
                                            if($rowCount > 0){ ?>
                                            <form action="" method="post" enctype="multipart/form-data">
                                             <div class="col-md-8">
                                              <div class="form-group">
                                                    <label class="req">ناوی کتاب</label>
                                                    <input type="text" name="sn" value="<?php echo $fetch->sn; ?>" placeholder="" class="form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label class="req">ناوی نوسەری کتاب</label>
                                                    <input type="text" name="sa" value="<?php echo $fetch->sa; ?>" placeholder="" class="form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label  <?php echo $feilds["book_pdf"] != "" ? ' class="req"' : ''; ?>>PDF</label>
                                                    <input type="file" accept="application/pdf" name="uploadpdf" data-label="دیاریکردن" class="filepicker form-control">
                                              </div> 
                                              <div class="form-group">
                                                    <label>وێنە</label>
                                                    <input type="file" accept="image/png, image/jpeg, image/gif, image/jpg"  name="fileToUpload" data-label="دیاریکردن" class="filepicker form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label  class="req">ناوی وانەبێژ</label>
                                                    <select class="selectpicker" data-width="100%"  name="tea" class="form-control">
                                                      <?php tea_f(1); ?>
                                                    </select>
                                                </div> 
                                              <div class="form-group">
                                                    <label  class="req">قۆناغ</label>
                                                    <select class="selectpicker" data-width="100%"  name="cl" class="form-control">
                                                      <option <?php bl("1","cl"); ?> value="1">1</option>
                                                      <option <?php bl("2","cl"); ?> value="2">2</option>
                                                      <option <?php bl("3","cl"); ?> value="3">3</option>
                                                      <option <?php bl("4","cl"); ?> value="4">4</option>
                                                    </select>
                                                </div> 
                                                <div class="form-group">
                                                      <label class="req">ڕێژەی کۆتا سەعاتی ئامادەنەبوون</label>
                                                      <input type="number" name="atte" value="<?php echo $fetch->atte; ?>" placeholder="" class="form-control">
                                                </div>
                                                <div class="form-group">
                                                    <label  <?php echo $feilds["book_ab"] != "" ? ' class="req"' : ''; ?>>کورتەیەک دەربارەی کتاب</label>
                                                    <textarea rows="6" type="text" name="ab" class="form-control"><?php echo $fetch->ab; ?></textarea>
                                                </div>
                                                </div>
                                                <div class="col-md-4">
                                                  <img style=" max-height: 525px; width: 100%; height: 100%; " src="uploads/<?php echo $fetch->img; ?>" alt="">
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
                              if(ndb("sub,tea","sub.tea=tea.id AND tea.user='$un' AND sub.id=$del")!=1 AND $das!=1){
                                dh("index.php");
                                exit;
                              }
                              $stm = $db->prepare("DELETE FROM sub WHERE id=:id");
                              $stm->bindParam(":id", $del, PDO::PARAM_STR);
                              $stm->execute();
                              AddtoHistory("سڕینەوەی بابەت",home);
                              re("danger","  بابەت ","بەسەرکەوتویی سڕایەوە.");
                              direct("subject.php");
                            }
                          ?>
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             لیستی وانەکان
                        </div>
                        <div class="panel-body">
                        <?php

                        $stm = $db->prepare("SELECT * FROM sub ORDER BY cl ASC");
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
                                            <th>ناوی کتاب</th>
                                            <th>نوسەری کتاب</th>
                                            <th>وانەبێژ</th>
                                            <th width="50px">قۆناغ</th>
                                            <th width="120px">کردار</th>
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
                                            <td><?php echo $row['sn']; ?></td>
                                            <td><?php echo $row['sa']; ?></td>
                                            <td><?php echo tea($row['tea']); ?></td>
                                            <td><?php echo $row['cl']; ?></td>
                                            <td>
                                            <span data-toggle="modal" data-target="#about<?php echo $row['id']; ?>">
                                              <a data-toggle="tooltip" data-placement="top" class="btn btn-success btn-xs mrg" title="کورتەیەک لەبارەی کتابەکە"><i class="fa fa-info-circle"></i></a>
                                              </span>
                                                <div class="modal fade" id="about<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            <h4 class="modal-title" id="myModalLabel">کورتەیەک دەربارەی <?php echo $row['sn']; ?></h4>
                                                        </div>
                                                        <div class="modal-body">
                                                          <img src="uploads/<?php echo $row['img']; ?>" alt="">
                                                           <?php echo $row['ab']; ?>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-default" data-dismiss="modal">داخستن</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <a href="uploads/pdf/<?php echo $row['pdf']; ?>" data-toggle="tooltip" data-placement="top" class="btn btn-primary btn-xs mrg" title="داگرتن بە PDF"><i class="glyphicon glyphicon-download"></i></a>
                                              <?php if($das==1 OR $das==2){ ?>
                                              <?php if($das==2 OR $das==1){$idd=$row['id'];
                                                if(ndb("sub,tea","sub.tea=tea.id AND tea.user='$un' AND sub.id=$idd")==1 OR $das==1){
                                              ?>
                                              <a href="subject.php?edit=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" class="btn btn-info btn-xs mrg" title="دەستکاری"><i class="fa fa-edit"></i></a>
                                              <a href="subject.php?del=<?php echo $row['id']; ?>" value="#go" id="btn-confirm" data-toggle="tooltip" data-placement="top" class="btn btn-danger btn-xs mrg confirmation" title="سڕینەوە"><i class="fa fa-trash-o"></i></a>
                                              <?php }}} ?>

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