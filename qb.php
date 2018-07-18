<?php 
include('class.token.php'); 
require 'inc/head.php';
global $re; 
?>
                <div class="row">
                    <div class="col-md-12">
                     <h2> بانکی پرسیارەکان</h2>   
                        <h5>لێرە دەتوانیت پرسیارەکان زیادبکەیت بۆ قۆناغە جیاوازەکان.</h5>
                        <?php if (!isset($_GET['id'])) { ?>
                        <a href="qb.php?id" style="float: left;" class="btn btn-success"><i class="fa fa-question-circle"></i> زیادکردنی  پرسیار</a>
                        <?php }elseif(isset($_GET['id']) && !isset($_GET['edit'])) { ?>
                        <a href="qb.php" style="float: left;" class="btn btn-info"><i class="fa fa-question-circle"></i> گەڕانەوە </a>
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
                                    $id=@output($_GET['qg']);
                                  ?>
                                      <div class="panel panel-default">
                                        <div class="panel-heading">
                                        زیادکردنی پرسیار
                                        <?php
                                        $stm1 = $db->prepare("SELECT * FROM qb WHERE qg=:qg");
                                        $stm1->bindParam(":qg", $id, PDO::PARAM_STR);
                                        $stm1->execute();
                                        $rowCount1 = $stm1->rowCount();
                                        ?>
                                        <?php if (isset($id) AND $id!="") { ?>
                                        <a style="float: left;">پرسیارەکانی ئەم گروپە : <?=$rowCount1;?></a>
                                        <?php } ?>
                                        </div>
                                        <div class="panel-body">
                                        <?php
                                              $dt=date("m/d/Y h:i A");
                                              $qg=@output($_POST['qg']);
                                              $qu=@output($_POST['qu']);
                                              $anser=@output($_POST['anser']);
                                              $a1=@output($_POST['a1']);
                                              $a2=@output($_POST['a2']);
                                              $a3=@output($_POST['a3']);
                                              $a4=@output($_POST['a4']);
                                              $mark=@output($_POST['mark']);
                                              
                                            if (isset($_POST['sub2'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                              if(!empty($qg)){
                                                 foreach($_POST['qu'] as $key=>$value) {
                                                  $qu=@output($value);
                                                  $anser=@output($_POST['anser'][$key]);
                                                  $a1=@output($_POST['a1'][$key]);
                                                  $a2=@output($_POST['a2'][$key]);
                                                  $a3=@output($_POST['a3'][$key]);
                                                  $a4=@output($_POST['a4'][$key]);
                                                  $mark=@output($_POST['mark'][$key]);

                                                  $stm = $db->prepare("INSERT INTO qb (id, qg, qu, tr, a1,a2,a3,a4,mark) VALUES (NULL, :qg, :qu, :anser, :a1 ,:a2,:a3,:a4,:mark);");
                                                  $stm->bindParam(":qg", $qg, PDO::PARAM_STR);
                                                  $stm->bindParam(":qu", $qu, PDO::PARAM_STR);
                                                  $stm->bindParam(":anser", $anser, PDO::PARAM_STR);
                                                  $stm->bindParam(":a1", $a1, PDO::PARAM_STR);
                                                  $stm->bindParam(":a2", $a2, PDO::PARAM_STR);
                                                  $stm->bindParam(":a3", $a3, PDO::PARAM_STR);
                                                  $stm->bindParam(":a4", $a4, PDO::PARAM_STR);
                                                  $stm->bindParam(":mark", $mark, PDO::PARAM_STR);
                                                  $stm->execute();
                                                }
                                                AddtoHistory("زیادکردنی پرسیار",home);
                                                  re("success"," سوپاس "," پرسیار بەسەرکەوتویی زیادکرا، دەتوانی پرسیاری زیاتر زیاد بکەیت. ");
                                                  direct2("qb.php",3.2);
                                            }else {
                                              re("danger"," کێشە! "," تکایە خانەکان بە دروستی پڕبکەوە.");
                                            }
                                            }else {
                                              re("danger"," کێشە! "," کێشەیەک ڕویدا تکایە دووبارە هەوڵ بدەوە.");
                                            }
                                          }
                                          ?>
                                            <form action="" method="post">
                                              <div class="col-md-12">
                                              <div class="form-group" id="subject">
                                                  <label class="req">گروپی پرسیار</label>
                                                  <select  class="selectpicker" data-width="100%"  name="qg" id="qg" class="form-control">
                                                    <option>گروپێکی پرسیار دیاری بکە</option>}
                                                    <?php qb(""); ?>
                                                  </select>
                                                  
                                                </div>
                                              </div>
                                                <hr>
                                        <div id="question">
<!--                                               <div class="form-group">
                                                  <label>پرسیار</label>
                                                  <textarea required="" rows="6" class="form-control" name="qu[]"></textarea>
                                              </div>                                               
                                              <div class="form-group">
                                                  <label>نمرە</label>
                                                    <input required="" name="mark[]" type="number" class="form-control">
                                              </div>
                                              <div id="ans">                                          
                                              <div class="col-md-6">
                                                <div class="form-group input-group">
                                                  <span class="input-group-addon">
                                                    <input checked value="1" name="anser[]" class="an" type="radio">
                                                  </span>
                                                  <input required="" name="a1[]" placeholder="وەڵامی یەکەم" type="text" class="form-control">
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group input-group">
                                                  <span class="input-group-addon">
                                                    <input value="2" name="anser[]" class="an" type="radio">
                                                  </span>
                                                  <input required="" name="a2[]" placeholder="وەڵامی دووەم" type="text" class="form-control">
                                                </div>
                                              </div>
                                                                                            
                                              <div class="col-md-6">
                                                <div class="form-group input-group">
                                                  <span class="input-group-addon">
                                                    <input value="3" name="anser[]" class="an" type="radio">
                                                  </span>
                                                  <input required="" name="a3[]" placeholder="وەڵامی سێیەم" type="text" class="form-control">
                                                </div>
                                              </div>
                                              <div class="col-md-6">
                                                <div class="form-group input-group">
                                                  <span class="input-group-addon">
                                                    <input value="4" name="anser[]" class="an" type="radio">
                                                  </span>
                                                  <input required="" name="a4[]" placeholder="وەڵامی چوارەم" type="text" class="form-control">
                                                </div>
                                              </div>
                                              </div> --> 
                                            </div>
                                            <hr width="100%">
                                             <input type="hidden" name="token" value="<?php echo Token::create(); ?>">
                                            <button type="submit" name="sub2" class="btn btn-default">زیادکردن</button>
                                            <a id="addquestion" style="float: left;margin-right: 10px" class="btn btn-success"><i class="fa fa-plus fa-x3"></i> هەڵبژاردن</a>
                                            <a id="addquestion2" style="float: left;" class="btn btn-info"><i class="fa fa-plus fa-x3"></i> نوسین</a>
                                            </form>
                                        </div>
                                    </div>

                        <?php
                        }elseif(isset($_GET['edit'])){ ?>


                                      <div class="panel panel-default">
                                        <div class="panel-heading">دەستکاریکردنی پرسیارەکان</div>
                                        <div class="panel-body">
                                        <?php
                                              $tr=@output($_POST['anser']);
                                              $mark=@output($_POST['mark']);
                                              $a1=@output($_POST['a1']);
                                              $a2=@output($_POST['a2']);
                                              $a3=@output($_POST['a3']);
                                              $a4=@output($_POST['a4']);
                                              $qu=@output($_POST['qu']);
                                              $qg=@output($_POST['qg']);
                                              $id=@output($_GET['edit']);
                                            if (isset($_POST['sub2'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                                
                                                  $stm = $db->prepare("UPDATE qb SET qu=:qu,tr=:tr,a1=:a1,a2=:a2,a3=:a3,a4=:a4,qg=:qg,mark=:mark WHERE id=:id");

                                                  $stm->bindParam(":tr", $tr, PDO::PARAM_STR);
                                                  $stm->bindParam(":a1", $a1, PDO::PARAM_STR);
                                                  $stm->bindParam(":a2", $a2, PDO::PARAM_STR);
                                                  $stm->bindParam(":a3", $a3, PDO::PARAM_STR);
                                                  $stm->bindParam(":a4", $a4, PDO::PARAM_STR);
                                                  $stm->bindParam(":qg", $qg, PDO::PARAM_STR);
                                                  $stm->bindParam(":mark", $mark, PDO::PARAM_STR);
                                                  $stm->bindParam(":qu", $qu, PDO::PARAM_STR);
                                                  $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                                  $stm->execute();
                                                  AddtoHistory("دەستکاریکردنی پرسیا",home);
                                                  re("success"," سوپاس "," پرسیار بەسەرکەوتویی نوێکرایەوە. ");
                                                  //$db = null;
                                                  //direct("");
                                              
                                            }else {
                                              re("danger"," کێشە! "," کێشەیەک ڕویدا تکایە دووبارە هەوڵ بدەوە.");
                                            }
                                          }
                                          // Select data
                                            $stm = $db->prepare("SELECT * FROM qb WHERE id=:id");
                                            $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                            $stm->execute();
                                            $fetch = $stm->fetch(PDO::FETCH_OBJ);
                                            $rowCount = $stm->rowCount();
                                            // Check User
                                            $qg=$fetch->qg;
                                            $stm1 = $db->prepare("SELECT * FROM qg WHERE id='$qg'");
                                            $stm1->execute();
                                            $fetch1 = $stm1->fetch(PDO::FETCH_OBJ);
                                            if ($das==2 AND $un!=$fetch1->user) {
                                              dh("index.php");
                                            }
                                            if($rowCount > 0){ ?>
                                            <form action="" method="post">
                                              <div class="form-group">
                                                    <label>گروپی پرسیار</label>
                                                    <select class="selectpicker" data-width="100%"  name="qg" class="form-control">
                                                      <option>گروپێك دیاری بکە</option>
                                                      <?php qg_f1(); ?>
                                                    </select>
                                                </div>
                                                <hr>
                                              
                                                <div class="form-group">
                                                    <label>پرسیار</label>
                                                    <textarea rows="6" class="form-control" name="qu"><?php echo $fetch->qu; ?></textarea>
                                                </div>                                               
                                                <div class="form-group">
                                                    <label>نمرە</label>
                                                      <input value="<?php echo $fetch->mark; ?>" name="mark" type="number" class="form-control">
                                                </div>                                              
                                                <div class="col-md-6">
                                                  <div class="form-group input-group">
                                                    <span class="input-group-addon">
                                                      <input <?php checka($fetch->tr,"1"); ?> value="1" name="anser" type="radio">
                                                    </span>
                                                    <input value="<?php echo $fetch->a1; ?>" name="a1" placeholder="وەڵامی یەکەم" type="text" class="form-control">
                                                  </div>
                                                </div>
                                                <div class="col-md-6">
                                                  <div class="form-group input-group">
                                                    <span class="input-group-addon">
                                                      <input <?php checka($fetch->tr,"2"); ?> value="2" name="anser" type="radio">
                                                    </span>
                                                    <input value="<?php echo $fetch->a2; ?>" name="a2" placeholder="وەڵامی دووەم" type="text" class="form-control">
                                                  </div>
                                                </div>
                                                                                              
                                                <div class="col-md-6">
                                                  <div class="form-group input-group">
                                                    <span class="input-group-addon">
                                                      <input <?php checka($fetch->tr,"3"); ?> value="3" name="anser" type="radio">
                                                    </span>
                                                    <input value="<?php echo $fetch->a3; ?>" name="a3" placeholder="وەڵامی سێیەم" type="text" class="form-control">
                                                  </div>
                                                </div>
                                                <div class="col-md-6">
                                                  <div class="form-group input-group">
                                                    <span class="input-group-addon">
                                                      <input <?php checka($fetch->tr,"4"); ?> value="4" name="anser" type="radio">
                                                    </span>
                                                    <input value="<?php echo $fetch->a4; ?>" name="a4" placeholder="وەڵامی چوارەم" type="text" class="form-control">
                                                  </div>
                                                </div>
                                              
                                              
                                             <input type="hidden" name="token" value="<?php echo Token::create(); ?>">
                                            <button type="submit" name="sub2" class="btn btn-default">نوێکردنەوە</button>
                                            </i></a>
                                            </form>
                                            <?php }else {
                                              e4();
                                            } ?>
                                        </div>
                                    </div>

                         <?php }else{ 
                        
                          ?>
<?php
  $cl=output(@$_GET['cl']);
  $qg=output(@$_GET['qg']);
?>
                        <div class="row">
                        <form action="" method="get">
                          <div class="col-md-12">
                            <div class="form-group" id="subject">
                                <label>گروپی پرسیار</label>
                                <select onchange='showSubject(this.value,"qg","bod");loa();' class="selectpicker" data-width="100%"  name="qg" id="qgid" class="form-control">
                                  <option>گروپی پرسیار</option>
                                  <?php qb(""); ?>
                                </select>
                            </div>
                          </div>
<!--                         <div class="col-md-1">
                          <div class="form-group">
                                <label style="color: #fff;">_</label>
                                <button  data-toggle="tooltip" data-placement="top" title="" data-original-title="گەڕان" type="submit" style="float: right;" class="btn btn-info" name="sub"><i class="fa fa-search"></i> گەڕان</button>

                          </div>
                        </div> -->
                        </form>
                      </div>
                        <hr>
                    <!-- Advanced Tables -->
                    <div id="bod" >
                      
                    </div>
                    <!--End Advanced Tables -->
                    <?php }

                    ?>
                </div>
            </div>
                <!-- /. ROW  -->

                 </div>
                 <!-- /. ROW  -->



<div class="alert" role="alert" id="result"></div>

<?php
$db = null;
 include 'inc/foot.php'; ?>