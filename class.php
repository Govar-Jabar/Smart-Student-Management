<?php 
include('class.token.php'); 
require 'inc/head.php';
global $re; 
?>
                <div class="row">
                    <div class="col-md-12">
                     <h2> قۆناغەکان</h2>   
                        <h5>بینینی قۆناغە جیاوازەکان و ڕێکخستنیان</h5>
                        <?php if (!isset($_GET['edit']) AND !isset($_GET['id'])) { ?>
                        <a href="class.php?id" style="float: left;" class="btn btn-success"><i class="fa fa-sitemap"></i> زیادکردنی قۆناغ </a>
                        <?php }else{ ?>
                        <a href="class.php" style="float: left;" class="btn btn-info"><i class="fa fa-sitemap"></i> گەڕانەوە </a>
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
                                        <div class="panel-heading">زیادکردنی قۆناغ</div>
                                        <div class="panel-body">
                                        <?php
                                              $cl=@output($_POST['cl']);
                                              $gr=@output($_POST['gr']);
                                              $note=@output($_POST['note']);
                                              
                                            if (isset($_POST['sub2'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                              $stm = $db->prepare("SELECT * FROM class WHERE cl=:cl AND gr=:gr");
                                              $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
                                              $stm->bindParam(":gr", $gr, PDO::PARAM_STR);
                                              $stm->execute();
                                              $rowCount = $stm->rowCount();
                                              if($rowCount == 0){
                                                  $stm = $db->prepare("INSERT INTO class (id, cl, gr,note) VALUES (NULL, :cl, :gr, :note);");
                                                  $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
                                                  $stm->bindParam(":gr", $gr, PDO::PARAM_STR);
                                                  $stm->bindParam(":note", $note, PDO::PARAM_STR);

                                                  $stm->execute();
                                                  re("success"," سوپاس "," قۆناغ بەسەرکەوتویی زیادکرا. ");
                                                  $db = null;
                                                  direct("./class.php");
                                              }else {
                                                re("info"," ببورە "," ئەم قۆناغ و گروپە پێشتر زیادکراوە.");
                                              }
                                            }else {
                                              re("danger"," کێشە! "," کێشەیەک ڕویدا تکایە دووبارە هەوڵ بدەوە.");
                                            }
                                          }
                                          ?>
                                            <form action="" method="post">
                                              <div class="form-group">
                                                    <label>قۆناغ</label>
                                                    <select class="selectpicker" data-width="100%"  name="cl" class="form-control">
                                                      <option value="1">1</option>
                                                      <option value="2">2</option>
                                                      <option value="3">3</option>
                                                      <option value="4">4</option>
                                                    </select>
                                                </div> 
                                                <div class="form-group">
                                                    <label>گروپ</label>
                                                    <select class="selectpicker" data-width="100%"  name="gr" class="form-control">
                                                      <option value="1">A</option>
                                                      <option value="2">B</option>
                                                      <option value="3">C</option>
                                                      <option value="4">D</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>تێبینی</label>
                                                    <textarea rows="6" type="text" name="note" class="form-control"></textarea>
                                                </div>
                                             <input type="hidden" name="token" value="<?php echo Token::create(); ?>">
                                            <button type="submit" name="sub2" class="btn btn-default">زیادکردن</button>
                                            </form>
                                        </div>
                                    </div>

                        <?php
                        }elseif(isset($_GET['edit'])){ ?>


                                      <div class="panel panel-default">
                                        <div class="panel-heading">دەستکاریکردنی قۆناغ</div>
                                        <div class="panel-body">
                                        <?php
                                              $cl=@output($_POST['cl']);
                                              $gr=@output($_POST['gr']);
                                              $note=@output($_POST['note']);
                                              $id=@output($_GET['edit']);
                                            if (isset($_POST['sub2'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                                $stm = $db->prepare("SELECT * FROM class WHERE cl=:cl AND gr=:gr AND id!=:id");
                                                $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
                                                $stm->bindParam(":gr", $gr, PDO::PARAM_STR);
                                                $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                                $stm->execute();
                                                $rowCount = $stm->rowCount();
                                                if ($rowCount==0) {
                                                  $stm = $db->prepare("UPDATE class SET cl=:cl,gr=:gr,note=:note WHERE id=:id");
                                                  $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
                                                  $stm->bindParam(":gr", $gr, PDO::PARAM_STR);
                                                  $stm->bindParam(":note", $note, PDO::PARAM_STR);
                                                  $stm->bindParam(":id", $id, PDO::PARAM_STR);

                                                  $stm->execute();
                                                  re("success"," سوپاس "," قۆناغ بەسەرکەوتویی بوێکرایەوە. ");
                                                  //$db = null;
                                                  direct("");
                                                }else{
                                                  re("info"," ببورە "," ئەم قۆناغ و گروپە بونی هەیە. ");
                                                }
                                              
                                            }else {
                                              re("danger"," کێشە! "," کێشەیەک ڕویدا تکایە دووبارە هەوڵ بدەوە.");
                                            }
                                          }
                                          // Select data
                                            $stm = $db->prepare("SELECT * FROM class WHERE id=:id");
                                            $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                            $stm->execute();
                                            $fetch = $stm->fetch(PDO::FETCH_OBJ);
                                            $rowCount = $stm->rowCount();
                                            if($rowCount > 0){ ?>
                                            <form action="" method="post">
                                              <div class="form-group">
                                                    <label>قۆناغ</label>
                                                    <select class="selectpicker" data-width="100%"  name="cl" class="form-control">
                                                      <option <?php bl("1","cl"); ?>  value="1">1</option>
                                                      <option <?php bl("2","cl"); ?>  value="2">2</option>
                                                      <option <?php bl("3","cl"); ?>  value="3">3</option>
                                                      <option <?php bl("4","cl"); ?>  value="4">4</option>
                                                    </select>
                                                </div> 
                                                <div class="form-group">
                                                    <label>گروپ</label>
                                                    <select class="selectpicker" data-width="100%"  name="gr" class="form-control">
                                                      <option <?php bl("1","gr"); ?>  value="1">A</option>
                                                      <option <?php bl("2","gr"); ?>  value="2">B</option>
                                                      <option <?php bl("3","gr"); ?>  value="3">C</option>
                                                      <option <?php bl("4","gr"); ?>  value="4">D</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label>تێبینی</label>
                                                    <textarea rows="6" type="text" name="note" class="form-control"><?php echo $fetch->note; ?></textarea>
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
                              $stm = $db->prepare("DELETE FROM class WHERE id=:id");
                              $stm->bindParam(":id", $del, PDO::PARAM_STR);
                              $stm->execute();
                              re("danger","  قۆناغ ","بەسەرکەوتویی سڕایەوە.");
                              direct("class.php");
                            }
                          ?>
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             لیستی قۆناغەکان
                        </div>
                        <div class="panel-body">
                        <?php

                        $stm = $db->prepare("SELECT * FROM class");
                        $stm->execute();
                        $rowCount = $stm->rowCount();
                        if($rowCount > 0){
                        ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" data-id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th width="50px">#</th>
                                            <th>قۆناغ</th>
                                            <th>گروپ</th>
                                            <th>تێبینی</th>
                                            <th width="80px">کردار</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $nu = 0;
                                    while($row = $stm->fetch(PDO::FETCH_ASSOC)) { 
                                      ?>
                                        <tr class="<?php if($nu % 2==0){echo 'odd';}else{echo 'even';} ?>">
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['cl']; ?></td>
                                            <td><?php cl($row['gr']); ?></td>
                                            <td><?php echo $row['note']; ?></td>
                                            <td>
                                              <a href="class.php?edit=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" class="btn btn-warning btn-xs mrg" title="دەستکاری"><i class="fa fa-edit"></i></a>

                                              <a href="class.php?del=<?php echo $row['id']; ?>" value="#go" id="btn-confirm" data-toggle="tooltip" data-placement="top" class="btn btn-danger btn-xs mrg confirmation" title="سڕینەوە"><i class="fa fa-trash-o"></i></a>
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

<?php include 'inc/foot.php'; ?>