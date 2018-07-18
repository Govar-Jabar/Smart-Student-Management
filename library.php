<?php 
include('class.token.php'); 
require 'inc/head.php';
global $re; 
?>
                <div class="row">
                    <div class="col-md-12">
                     <h2> کتێبخانە</h2>   
                        <h5>دەستکاریکردنی کتابەکان و خوێندنەوەیان</h5>
                        <?php if (!isset($_GET['id'])) { ?>
                        <a href="library.php?id" style="float: left;" class="btn btn-primary"><i class="fa icon-library"></i> زیادکردنی کتێب </a>
                        <?php }elseif(isset($_GET['id']) && !isset($_GET['edit'])) { ?>
                        <a href="library.php" style="float: left;" class="btn btn-info"><i class="fa icon-library"></i> گەڕانەوە </a>
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
                                        <div class="panel-heading">زیادکردنی کتێب</div>
                                        <div class="panel-body">
                                        <?php
                                              $type=@output($_POST['type']);
                                              $bn=@output($_POST['bn']);
                                              $ba=@output($_POST['ba']);
                                              $ab=@output($_POST['ab']);
                                              $type=@output($_POST['type']);
                                              
                                            if (isset($_POST['sub2'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                              upload();
                                              pdf();
                                              checkInput();
                                              if($pdfOk==1 AND (!isset($ab) OR $feilds['book_ab']=="") AND !empty($type) AND !empty($bn) AND !empty($ba)){
                                              // $stm = $db->prepare("SELECT * FROM sub WHERE cl=:cl AND tea=:tea");
                                              // $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
                                              // $stm->bindParam(":tea", $tea, PDO::PARAM_STR);
                                              // $stm->execute();
                                              // $rowCount = $stm->rowCount();
                                              // if($rowCount == 0){
                                                  $stm = $db->prepare("INSERT INTO lib (id, pdf, bn, ba, type, ab,img) VALUES (NULL, :pdf, :bn, :ba, :type, :ab,:img);");
                                                  $stm->bindParam(":bn", $bn, PDO::PARAM_STR);
                                                  $stm->bindParam(":ba", $ba, PDO::PARAM_STR);
                                                  $stm->bindParam(":pdf", $pdf, PDO::PARAM_STR);
                                                  $stm->bindParam(":ab", $ab, PDO::PARAM_STR);
                                                  $stm->bindParam(":type", $type, PDO::PARAM_STR);
                                                  $stm->bindParam(":img", $img, PDO::PARAM_STR);
                                                  $stm->execute();
                                                  AddtoHistory("زیادکردنی کتێب",home);
                                                  re("success"," سوپاس "," وانە بەسەرکەوتویی زیادکرا. ");
                                                  $db = null;
                                                  direct("./library.php");
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
                                                    <label  class="req">ناوی کتاب</label>
                                                    <input type="text" name="bn" value="<?=@$bn;?>" placeholder="" class="form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label class="req">ناوی نوسەری کتاب</label>
                                                    <input type="text" name="ba" value="<?=@$ba;?>" placeholder="" class="form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label class="req">PDF</label>
                                                    <input data-label="دیاریکردن" class="filepicker form-control" type="file" accept="application/pdf" name="uploadpdf" >
                                              </div>                                              
                                              <div class="form-group">
                                                    <label>وێنە</label>
                                                    <input type="file" accept="image/png, image/jpeg, image/gif, image/jpg"  name="fileToUpload"  data-label="دیاریکردن" class="filepicker form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label class="req">هاوپۆل</label>
                                                    <input value="<?=@$type;?>" type="text" name="type" class="form-control">
                                                    
                                              </div>

                                                <div class="form-group">
                                                    <label  <?php echo $feilds["book_ab"] != "" ? ' class="req"' : ''; ?>>کورتەیەک دەربارەی کتاب</label>
                                                    <textarea rows="6" type="text" name="ab" class="form-control"><?=@$ab;?></textarea>
                                                </div>
                                             <input type="hidden" name="token" value="<?php echo Token::create(); ?>">
                                            <button type="submit" name="sub2" class="btn btn-default">زیادکردن</button>
                                            </form>
                                        </div>
                                    </div>

                        <?php
                        }elseif(isset($_GET['edit'])){ ?>


                                      <div class="panel panel-default">
                                        <div class="panel-heading">دەستکاریکردنی وانە</div>
                                        <div class="panel-body">
                                        <?php
                                              $type=@output($_POST['type']);
                                              $bn=@output($_POST['bn']);
                                              $ba=@output($_POST['ba']);
                                              $pdf=@output($_POST['pdf']);
                                              $ab=@output($_POST['ab']);
                                              $id=@output($_GET['edit']);
                                            if (isset($_POST['sub2'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                                  upload();
                                                  pdf();
                                                  checkInput();
                                              if($pdfOk==1 AND (!empty($ab) OR $feilds['book_ab']=="") AND !empty($type) AND !empty($bn) AND !empty($ba)){

                                                // $stm = $db->prepare("SELECT * FROM sub WHERE cl=:cl AND tea=:tea AND id!=:id");
                                                // $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
                                                // $stm->bindParam(":tea", $tea, PDO::PARAM_STR);
                                                // $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                                // $stm->execute();
                                                // $rowCount = $stm->rowCount();
                                                // if ($rowCount==0) {
                                                  $stm = $db->prepare("UPDATE lib SET bn=:bn,ba=:ba,ab=:ab,type=:type WHERE id=:id");
                                                  if ($uploadOk==1 AND $pdfOk!=1) {
                                                  $stm = $db->prepare("UPDATE lib SET bn=:bn,ba=:ba,ab=:ab,type=:type,img=:img WHERE id=:id");
                                                  $stm->bindParam(":img", $img, PDO::PARAM_STR);
                                                  }
                                                  if ($uploadOk!=1 AND $pdfOk==1) {
                                                  $stm = $db->prepare("UPDATE lib SET bn=:bn,ba=:ba,ab=:ab,type=:type,pdf=:pdf WHERE id=:id");
                                                  $stm->bindParam(":pdf", $pdf, PDO::PARAM_STR);
                                                  }
                                                  if ($uploadOk==1 AND $pdfOk==1) {
                                                  $stm = $db->prepare("UPDATE lib SET pdf=:pdf,bn=:bn,ba=:ba,ab=:ab,type=:type,img=:img WHERE id=:id");
                                                  $stm->bindParam(":img", $img, PDO::PARAM_STR);
                                                  $stm->bindParam(":pdf", $pdf, PDO::PARAM_STR);
                                                  }

                                                  $stm->bindParam(":bn", $bn, PDO::PARAM_STR);
                                                  $stm->bindParam(":ba", $ba, PDO::PARAM_STR);
                                                  $stm->bindParam(":ab", $ab, PDO::PARAM_STR);
                                                  $stm->bindParam(":type", $type, PDO::PARAM_STR);
                                                  $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                                  $stm->execute();
                                                  AddtoHistory("دەستکاریکردنی کتێب",home);
                                                  re("success"," سوپاس "," وانە بەسەرکەوتویی نوێکرایەوە. ");
                                                  //$db = null;
                                                  direct("");
                                                // }else{
                                                //   re("info"," ببورە "," ئەم وانەیە بەهەمان مامۆستاوە بونی هەیە. ");
                                                // }
                                              }else {
                                              re("danger"," کێشە! "," تکایە خانەکان بە دروستی پڕبکەوە، وێنەی دروست هەڵبژێرە.");
                                            }
                                            }else {
                                              re("danger"," کێشە! "," کێشەیەک ڕویدا تکایە دووبارە هەوڵ بدەوە.");
                                            }
                                          }
                                          // Select data
                                            $stm = $db->prepare("SELECT * FROM lib WHERE id=:id");
                                            $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                            $stm->execute();
                                            $fetch = $stm->fetch(PDO::FETCH_OBJ);
                                            $rowCount = $stm->rowCount();
                                            if($rowCount > 0){ 
                                              if ($fetch->user!=$un) {
                                                dh("library.php");
                                              }
                                              ?>
                                            <form action="" method="post" enctype="multipart/form-data">
                                             <div class="col-md-8">
                                              <div class="form-group">
                                                    <label  class="req">ناوی کتاب</label>
                                                    <input type="text" name="bn" value="<?php echo $fetch->bn; ?>" placeholder="" class="form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label class="req">ناوی نوسەری کتاب</label>
                                                    <input type="text" name="ba" value="<?php echo $fetch->ba; ?>" placeholder="" class="form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label class="req">PDF</label>
                                                    <input type="file" accept="application/pdf" name="uploadpdf" data-label="دیاریکردن" class="filepicker form-control">
                                              </div> 
                                              <div class="form-group">
                                                    <label>وێنە</label>
                                                    <input type="file" accept="image/png, image/jpeg, image/gif, image/jpg"  name="fileToUpload" data-label="دیاریکردن" class="filepicker form-control">
                                              </div>
                                              <div class="form-group">
                                                    <label class="req">هاوپۆل</label>
                                                    <input value="<?php echo $fetch->ba; ?>" type="text" name="type" class="form-group">
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
                              // Check User
                              $stm = $db->prepare("SELECT * FROM lib WHERE id=:id");
                              $stm->bindParam(":id", $del, PDO::PARAM_STR);
                              $stm->execute();
                              $fetch = $stm->fetch(PDO::FETCH_OBJ);
                              //
                              if ($un==$fetch->user) {
                                $stm = $db->prepare("DELETE FROM lib WHERE id=:id");
                                $stm->bindParam(":id", $del, PDO::PARAM_STR);
                                $stm->execute();
                                AddtoHistory("سڕینەوەی کتێب",home);
                                re("danger","  کتاب ","بەسەرکەوتویی سڕایەوە.");

                                //direct("library.php");
                              }
                            }
                          ?>
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             کتێبخانە
                        </div>
                        <div class="panel-body">
                        <?php

                        $stm = $db->prepare("SELECT * FROM lib");
                        $stm->execute();
                        $rowCount = $stm->rowCount();
                        if($rowCount > 0){
                        ?>
                            <div class="table-responsive">
                                <table id="advance" class="table table-striped table-bordered table-hover" data-id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th width="50px">#</th>
                                            <th width="70px">وێنە</th>
                                            <th>ناوی کتاب</th>
                                            <th>نوسەری کتاب</th>
                                            <th>هاوپۆل</th>
                                            <th width="130px">کردار</th>

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
                                            <td><?php echo $row['bn']; ?></td>
                                            <td><?php echo $row['ba']; ?></td>
                                            <td><?php echo $row['type']; ?></td>
                                            <td>
                                            <span data-toggle="modal" data-target="#about<?php echo $row['id']; ?>">
                                              <a data-toggle="tooltip" data-placement="top" class="btn btn-success btn-xs mrg" title="کورتەیەک لەبارەی کتابەکە"><i class="fa fa-info-circle"></i></a>
                                              </span>
                                                <div class="modal fade" id="about<?php echo $row['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            <h4 class="modal-title" id="myModalLabel">کورتەیەک دەربارەی <?php echo $row['bn']; ?></h4>
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
                                              <?php if($das==1 OR ($row['user']==$un AND $das==2)){ ?>
                                              <a href="library.php?edit=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" class="btn btn-info btn-xs mrg" title="دەستکاری"><i class="fa fa-edit"></i></a>

                                              <a href="library.php?del=<?php echo $row['id']; ?>" value="#go" id="btn-confirm" data-toggle="tooltip" data-placement="top" class="btn btn-danger btn-xs mrg confirmation" title="سڕینەوە"><i class="fa fa-trash-o"></i></a>
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