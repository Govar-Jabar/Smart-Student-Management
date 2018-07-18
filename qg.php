<?php 
include('class.token.php'); 
require 'inc/head.php';
global $re; 
?>
                <div class="row">
                    <div class="col-md-12">
                     <h2> لیستی پرسیارەکان</h2>   
                        <h5>لێرە دەتوانیت گروپی پرسیارەکان زیادبکەیت بۆ قۆناغە جیاوازەکان.</h5>
                        <?php if (!isset($_GET['id'])) { ?>
                        <a href="qg.php?id" style="float: left;" class="btn btn-success"><i class="fa fa-question-circle"></i> زیادکردنی گروپی پرسیارەکان </a>
                        <?php }elseif(isset($_GET['id']) && !isset($_GET['edit'])) { ?>
                        <a href="qg.php" style="float: left;" class="btn btn-info"><i class="fa fa-question-circle"></i> گەڕانەوە </a>
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
                                        <div class="panel-heading">زیادکردنی گروپی پرسیارەکان</div>
                                        <div class="panel-body">
                                        <?php
                                              $name=@output($_POST['name']);
                                              $cl=@output($_POST['cl']);
                                              
                                            if (isset($_POST['sub2'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                              if(!empty($name)){
                                                  $stm = $db->prepare("INSERT INTO qg (id, name,user) VALUES (NULL, :name,:un);");
                                                  $stm->bindParam(":name", $name, PDO::PARAM_STR);
                                                  $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
                                                  $stm->bindParam(":un", $un, PDO::PARAM_STR);
                                                  $stm->execute();
                                                  AddtoHistory("زیادکردنی گروپی پرسیار",home);
                                                  re("success"," سوپاس "," وانە بەسەرکەوتویی زیادکرا. ");
                                                  
                                                  direct("qg.php");
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
                                                    <label class="req">ناوی گروپی پرسیار</label>
                                                    
                                                        <div class="typeahead__container">
                                                          <div class="typeahead__field">
                                                              <span class="typeahead__query">
                                                                  <input required="" type="text" value="<?=@$_POST['name'];?>" name="name" type="search" autocomplete="off" class="form-control qg">
                                                              </span>
                                                          </div>
                                                      </div>
                                              </div><br>
                                             <input type="hidden" name="token" value="<?php echo Token::create(); ?>">
                                            <button type="submit" name="sub2" class="btn btn-default">زیادکردن</button>
                                            </form>
                                        </div>
                                    </div>

                        <?php
                        }elseif(isset($_GET['edit'])){ ?>


                                      <div class="panel panel-default">
                                        <div class="panel-heading">دەستکاریکردنی گروپی پرسیارەکان</div>
                                        <div class="panel-body">
                                        <?php
                                              $name=@output($_POST['name']);
                                              $cl=@output($_POST['cl']);
                                              $id=@output($_GET['edit']);
                                            if (isset($_POST['sub2'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                                
                                                  $stm = $db->prepare("UPDATE qg SET name=:name WHERE id=:id");

                                                  $stm->bindParam(":name", $name, PDO::PARAM_STR);
                                                  $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
                                                  $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                                  $stm->execute();
                                                  AddtoHistory("دەستکاریکردنی گروپی پرسیار",home);
                                                  re("success"," سوپاس "," وانە بەسەرکەوتویی نوێکرایەوە. ");
                                                  //$db = null;
                                                  //direct("");
                                              
                                            }else {
                                              re("danger"," کێشە! "," کێشەیەک ڕویدا تکایە دووبارە هەوڵ بدەوە.");
                                            }
                                          }
                                          // Select data
                                            $stm = $db->prepare("SELECT * FROM qg WHERE id=:id");
                                            $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                            $stm->execute();
                                            $fetch = $stm->fetch(PDO::FETCH_OBJ);
                                            $rowCount = $stm->rowCount();
                                            if ($das==2 AND $fetch->user!=$un) {
                                              dh("index.php");
                                            }
                                            if($rowCount > 0){ ?>
                                            <form action="" method="post">
                                             <div class="col-md-12">
                                              <div class="form-group">
                                                    <label class="req">ناونیشان</label>
                                                    <input type="text" name="name" value="<?php echo $fetch->name; ?>" placeholder="" class="form-control">
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
                              $stm = $db->prepare("DELETE FROM qg WHERE id=:id");
                              if ($das==2) {
                                 $stm = $db->prepare("DELETE FROM qg WHERE id=:id AND user=:un");
                                 $stm->bindParam(":un", $un, PDO::PARAM_STR);
                              }
                              $stm->bindParam(":id", $del, PDO::PARAM_STR);
                              $stm->execute();
                              AddtoHistory("سڕینەوەی گروپی پرسیار",home);
                              re("danger","  بابەت ","بەسەرکەوتویی سڕایەوە.");
                              //direct("subject.php");
                            }
                          ?>
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                             گروپی پرسیارەکان
                        </div>
                        <div class="panel-body">
                        <?php
                        $stm = $db->prepare("SELECT * FROM qg");
                        if ($das==2) {
                            $stm = $db->prepare("SELECT * FROM qg WHERE user=:un");
                        }
                        $stm->bindParam(":un", $un, PDO::PARAM_STR);
                        $stm->execute();
                        $rowCount = $stm->rowCount();
                        if($rowCount > 0){
                        ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50px">#</th>
                                            <th>سەردێڕ</th>
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
                                            <td><?php echo $row['name']; ?></td>
                                            <td>
                                            <?php if($das==1 OR $das==2){ 
                                              // if(ndb("sub,qg,exam,tea","tea.user='$un' AND qg.cl = sub.cl AND exam.sub=sub.id AND tea.id=sub.tea")==1 OR $das==1){
                                              ?>
                                              <a href="qg.php?edit=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" class="btn btn-info btn-xs mrg" title="دەستکاری"><i class="fa fa-edit"></i></a>

                                              <a href="qg.php?del=<?php echo $row['id']; ?>" value="#go" id="btn-confirm" data-toggle="tooltip" data-placement="top" class="btn btn-danger btn-xs mrg confirmation" title="سڕینەوە"><i class="fa fa-trash-o"></i></a>
                                              <?php }//} ?>
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