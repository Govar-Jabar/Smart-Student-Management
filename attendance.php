<?php require 'inc/head.php';
$cl=output(@$_GET['cl']);
$gr=output(@$_GET['gr']);
$dt=output(@$_GET['dt']);
$sub=output(@$_GET['subject']);
$tm=output(@$_GET['tm']);
$etm=output(@$_GET['etm']);
$dtt=output(@$_GET['dtt']);
 ?>
  <div class="row">
      <div class="col-md-12">
       <h2>خوێندکارانی ئامادەبوو</h2>   
          <h5>ڕێکخستنی ئامادەبووان و هەژمارکردنیان</h5>
          <?php if(isset($_GET['date'])){ ?>
          <a href="attendance.php" style="float: left;margin-right: 5px;" class="btn btn-info"><i class="fa fa-calendar" aria-hidden="true"></i> گەڕانەوە </a>
          <?php }else{ ?>
          <a href="attendance.php?date" style="float: left;margin-right: 5px;" class="btn btn-primary"><i class="fa fa-calendar" aria-hidden="true"></i> ڕاپۆرتی ئامادەبوان بەبەروار </a>
          <?php } ?>
      </div>
  </div>
  <hr>
 <?php if(!isset($_GET['date'])){ ?>
                 <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                      <form action="" method="get">
                        <div class="col-md-4">
                              <div class="form-group">
                                    <label>قۆناغ</label>
                                    <select onchange="showSubject(this.value,'sub','subject')" class="selectpicker" data-width="100%"  name="cl" class="form-control">
                                      <option >قۆناغێک دیاری بکە</option>
                                      <option <?php va("1",$cl); ?>  value="1">1</option>
                                      <option <?php va("2",$cl); ?>  value="2">2</option>
                                      <option <?php va("3",$cl); ?>  value="3">3</option>
                                      <option <?php va("4",$cl); ?>  value="4">4</option>
                                    </select>
                              </div>  
                        </div>
                        <div class="col-md-4">
                              <div class="form-group" id="subject">
                                    <label>بابەت</label>
                                    <?php if (isset($_GET['subject'])) { ?>
                                         <select class="selectpicker" data-width="100%"  name="subject" class="form-control">
                                          <?php sub_f($cl); ?>
                                         </select>
                                     <?php }else{ ?>
                                    <select disabled="" class="selectpicker" data-width="100%"  name="subject" class="form-control">
                                      <option value="">قۆناغێک دیاری بکە</option>
                                    </select>
                                    <?php } ?>
                              </div>  
                        </div>
                        <div class="col-md-4">
                              <div class="form-group">
                                    <label>گروپ</label>
                                    <select class="selectpicker" data-width="100%"  name="gr" class="form-control">
                                      <option <?php va("A",$gr); ?>  value="A">A</option>
                                      <option <?php va("B",$gr); ?>  value="B">B</option>
                                      <option <?php va("C",$gr); ?>  value="C">C</option>
                                      <option <?php va("D",$gr); ?>  value="D">D</option>
                                    </select>
                              </div>  
                        </div>

                        <div class="col-md-4">
                              <div class="form-group">
                                   <label>بەروار</label>
                                    <input  class="form-control" type="text" name="dt" value="<?php if($dt==""){echo date("Y-m-d");}else{echo $dt;} ?>" placeholder="" autocomplete="off" id="date">

                            </div>
                        </div>
                        <div class="col-md-4">
                              <div class="form-group">
                                    <label>کاتی دەستپێکردن</label>
                                    <select onchange="mul(this.selectedIndex);" class="selectpicker" data-width="100%"  name="tm" class="form-control">
                                      <option <?php va($tm,"08:30");?> value="08:30">08:30</option>
                                      <option <?php va($tm,"09:30");?> value="09:30">09:30</option>
                                      <option <?php va($tm,"10:30");?> value="10:30">10:30</option>
                                      <option <?php va($tm,"11:30");?> value="11:30">11:30</option>
                                      <option <?php va($tm,"12:30");?> value="12:30">12:30</option>
                                      <option <?php va($tm,"01:30");?> value="01:30">01:30</option>
                                      <option <?php va($tm,"02:30");?> value="02:30">02:30</option>
                                    </select>
                              </div>  
                        </div>
                        <div class="col-md-4">
                              <div class="form-group">
                                    <label>کاتی تەواوبوون</label>
                                    <select id="etm" class="selectpicker etm" data-width="100%"  name="etm" class="form-control">
                                      <option <?php va($etm,"09:30");?> value="09:30">09:30</option>
                                      <option <?php va($etm,"10:30");?> value="10:30">10:30</option>
                                      <option <?php va($etm,"11:30");?> value="11:30">11:30</option>
                                      <option <?php va($etm,"12:30");?> value="12:30">12:30</option>
                                      <option <?php va($etm,"01:30");?> value="01:30">01:30</option>
                                      <option <?php va($etm,"02:30");?> value="02:30">02:30</option>
                                      <option <?php va($etm,"03:30");?> value="03:30">03:30</option>
                                    </select>
                              </div>  
                        </div>
                      <center><button  data-toggle="tooltip" data-placement="top" title="" data-original-title="گەڕان" type="submit"  class="btn btn-info"><i class="fa fa-search"></i> گەڕان</button></center>
                      </form>
                    </div>
                </div>
                <hr>
                 <!-- /. ROW  -->
                <div class="row">
                    <div class="col-md-12">
                   <?php
                   if ($cl!="" AND $gr!="") {
                        if (strtotime($tm) >= strtotime($etm)) { // check StartTime And EndTime write OR wrong...
                          echo 'تکایە کاتی دروست بنووسە!';
                        }else{
                    $stm = $db->prepare("SELECT * FROM stu WHERE class=:c AND gr=:gr ");
                    $stm->bindParam(":c", $cl, PDO::PARAM_STR);
                    $stm->bindParam(":gr", $gr, PDO::PARAM_STR);
                    $stm->execute();
                    $rowCount = $stm->rowCount();
                    if($rowCount > 0){
                   ?>
                  </div>
                  <form action="" method="post">
<!--                         <div class="form-group">
                        <center>
                              <button type="submit" data-toggle="tooltip" data-placement="top"  data-original-title="هەژمارکردنی هەموان بە مۆڵەت پێدراو" name="sub3" class="btn btn-info confirmation"><i class="fa fa-check-square-o"></i>  هەژمارکردنی هەموان بە مۆڵەت پێدراو </button>
                              <i class="fa"></i>
                              <button  type="submit" data-toggle="tooltip" data-placement="top" data-original-title="هەژمارکردنی هەموان بە نەهاتوو" name="sub4" class="btn btn-danger confirmation"><i class="fa fa-times" aria-hidden="true"></i> هەژمارکردنی هەموان بە نەهاتوو</button>
                        </center>
                        
                        </div> -->
                  <div class="col-md-8" style="float: none;margin: 50px auto;">
                  <center>
                    <table id="advance" class="table table-bordered">
                      <thead>
                        <tr style="background-color: #fcfcfc;">
                          <th width="50px">#</th>
                          <th>ناو</th>
                          <th width="230px">کردار</th>
                        </tr>
                      </thead>
                      <tbody>
                      <?php
                        $nu = 0;
                        
                        while($row = $stm->fetch(PDO::FETCH_ASSOC)) { 
                          $stm1 = $db->prepare("SELECT * FROM att WHERE user=:user AND sub_id=:sub AND tm>=:tm and etm<=:etm AND dt=:dt;");
                          $stm1->bindParam(":user", $row['user'], PDO::PARAM_STR);
                          $stm1->bindParam(":sub", $sub, PDO::PARAM_STR);
                          $stm1->bindParam(":tm", $tm, PDO::PARAM_STR);
                          $stm1->bindParam(":etm", $etm, PDO::PARAM_STR);
                          $stm1->bindParam(":dt", $dt, PDO::PARAM_STR);
                          $stm1->execute();
                          $f1 = $stm1->fetch(PDO::FETCH_OBJ);
                          $r1 = $stm1->rowCount();
                      ?>
                        <tr class="<?php if($nu % 2==0){echo 'odd';}else{echo 'even';} ?>">
                          <td><?php echo $row['id'];?></td>
                          <td><?php echo $row['fname'];?></td>                          
                          <td>
                            <!-- <a href="" class="btn btn-success btn-xs mrg" data-toggle="tooltip" data-placement="top" title="" data-original-title="ئامادەیە"><i class="fa fa-check"></i></a> -->
                            <!-- <input type="checkbox" checked data-toggle="toggle" data-on="ئامادەیە" data-off="نەهاتووە" data-onstyle="success" data-offstyle="danger"  name="checkbox[]" value="<?php echo $row['user']; ?>" > -->
                            <div class="btn-group colors" data-toggle="buttons">
                              <label class="btn btn-success<?php if($f1==""){echo ' active';} ?>">
                                <input type="radio" <?php if($f1==""){echo ' checked=""';} ?> name="res[<?php echo $row['user'];?>]" value="1" autocomplete="off"> ئامادە
                              </label>
                              <label class="btn btn-info<?php checkattl('2'); ?>">
                                <input type="radio" <?php checkatt('2'); ?> name="res[<?php echo $row['user'];?>]" value="2" autocomplete="off"

                                > مۆڵەت
                              </label>
                              <label class="btn btn-danger<?php checkattl('3'); ?>">
                                <input type="radio" <?php checkatt('3'); ?>  name="res[<?php echo $row['user'];?>]" value="3" autocomplete="off"> نەهاتوو
                              </label>
                            </div>
                          </td>
                        </tr>
                        <?php
                        }
                        ?>
                      </tbody>
                    </table>
                    <button name="sub2" type="submit" data-toggle="tooltip" data-placement="top" title="" data-original-title="چەسپاندن" class="btn btn-success"><i class="fa fa-check"></i> چەسپاندن</button><br>
</form>
<?php
  } else {
                echo '<center>هیچ ئەنجامێك نەدۆزرایەوە!</center>';
             }
           }

    // One By one
    if(isset($_POST["sub2"])){
      $dtt= date("h:i:s A");
        foreach($_POST['res'] as $key=>$res) {
              // aga habw update bkat agar nabw insert
              $stm1 = $db->prepare("SELECT * FROM att WHERE user=:user AND sub_id=:sub AND tm>=:tm and etm<=:etm AND dt=:dt;");
              $stm1->bindParam(":user", $key, PDO::PARAM_STR);
              $stm1->bindParam(":sub", $sub, PDO::PARAM_STR);
              $stm1->bindParam(":tm", $tm, PDO::PARAM_STR);
              $stm1->bindParam(":etm", $etm, PDO::PARAM_STR);
              $stm1->bindParam(":dt", $dt, PDO::PARAM_STR);
              $stm1->execute();
              $f1 = $stm1->fetch(PDO::FETCH_OBJ);
              $r1 = $stm1->rowCount();
              if($res==1){
                  $s = $db->prepare("DELETE FROM att WHERE id = :id");
                  $s->bindParam(":id", $f1->id, PDO::PARAM_STR);
                  $s->execute();
              }elseif ($r1>0) {
                  $s = $db->prepare("UPDATE att SET re = :res WHERE id = :id AND user = :user");
                  $s->bindParam(":id", $f1->id, PDO::PARAM_STR);
                  $s->bindParam(":user", $key, PDO::PARAM_STR);
                  $s->bindParam(":res", $res, PDO::PARAM_STR);
                  $s->execute();
              }else{
            // Insert to DB.
                  $s = $db->prepare("INSERT INTO att (id, user,re,dt,tm,etm,sub_id) VALUES (NULL, :user, :re, :dt, :tm,:etm,:sub);");
                  $s->bindParam(":sub", $sub, PDO::PARAM_STR);
                  $s->bindParam(":user", $key, PDO::PARAM_STR);
                  $s->bindParam(":tm", $tm, PDO::PARAM_STR);
                  $s->bindParam(":etm", $etm, PDO::PARAM_STR);
                  $s->bindParam(":dt", $dt, PDO::PARAM_STR);
                  $s->bindParam(":re", $res, PDO::PARAM_STR);
                  $s->execute();  
            }
          }
       AddtoHistory("هەژمارکردنی ئامادەبوان",home);
       modal("سوپاس","هەژمارکردنی ئامادەبوان سەرکەوتو بوو.");
       direct("");
      }
      }
?>
             </center>
                  </div>
                </div>
<?php }elseif (isset($_GET['date'])) { ?>
                 <!-- /. ROW  -->
                <div class="row atte">
                    <div class="col-md-12">
                      <form action="attendance.php?date&" method="get">
                        <div class="col-md-4">
                              <div class="form-group">
                                    <label>قۆناغ</label>
                                    <select class="selectpicker" data-width="100%"  name="cl" class="form-control">
                                      <option <?php va("1",$cl); ?>  value="1">1</option>
                                      <option <?php va("2",$cl); ?>  value="2">2</option>
                                      <option <?php va("3",$cl); ?>  value="3">3</option>
                                      <option <?php va("4",$cl); ?>  value="4">4</option>
                                    </select>
                              </div>  
                        </div>
                        <div class="col-md-3">
                              <div class="form-group input-group" style="margin-top: 26px;">
                                    <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    <input  class="form-control" type="text" name="dt" value="<?php if($dt==""){echo date("Y-m-d");}else{echo $dt;} ?>" placeholder="" autocomplete="off" id="date">
                            </div>
                        </div>
                        <div style="width: 35px;" class="col-sm-1">
                        <div class="form-group input-group" style="margin-top: 30px;font-size: 15px;">
                          تا
                        </div>
                        </div>
                        <div class="col-md-3">
                              <div class="form-group input-group" style="margin-top: 26px;">
                                    <span class="input-group-addon"><i class="fa fa-calendar" aria-hidden="true"></i></span>
                                    <input  class="form-control" type="text" name="dtt" value="<?php if($dtt==""){echo date("Y-m-d");}else{echo $dtt;} ?>" placeholder="" autocomplete="off" id="date2">
                            </div>
                        </div>

                        <div class="col-md-1">
                              <div class="form-group">
                                    <input type="hidden" name="date" value="">
                                    <label style="color: #fff;">_</label>
                                    <button  data-toggle="tooltip" data-placement="top" title="" data-original-title="گەڕان" type="submit" style="float: right;" class="btn btn-info" name="sub"><i class="fa fa-search"></i> گەڕان</button>

                            </div>
                        </div>

                      </form>
                    </div>
                </div>
                <hr>
                 <!-- /. ROW  -->
                  <?php $stm = $db->prepare("SELECT * FROM stu WHERE class=:c");
                    $stm->bindParam(":c", $cl, PDO::PARAM_STR);
                    $stm->execute();
                    $rowCount = $stm->rowCount();
                    if($rowCount > 0){
                   ?>

                  <form action="" method="post">
                  <div class="col-md-12 table_atte" style="float: none;margin: 50px auto;">
                  <center>
                    <table id="advance" class="table table-bordered">
                      <thead>
                        <tr><th colspan="30" style="text-align: center;padding: 15px">ئاماری خوێندکارانی قۆناغی <?php if($cl==1)echo 'یەك';if($cl==2)echo 'دوو';if($cl==3)echo 'سێ';if($cl==4)echo 'چوار'; ?></th></tr>
                        <tr style="background-color: #fcfcfc;">
                          <th width="50px">#</th>
                          <th >ناو</th>
                          <?php
                            $su = $db->prepare("SELECT * FROM sub WHERE cl=:c");
                            $su->bindParam(":c", $cl, PDO::PARAM_STR);
                            $su->execute();
                            while($sur = $su->fetch(PDO::FETCH_ASSOC)) { 
                              echo '<th width="50px" style="font-size:10px;">'.$sur['sn'].'</th>';
                            } ?>
                        </tr>
                      </thead>
                      <tbody>
                      <?php $i=0;$array=array();
                        while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
                      ?>
                        <tr>
                          <td><?php echo $row['id'];?></td>
                          <td><?php echo $row['fname'];?></td>                          
                          <?php
                            $su = $db->prepare("SELECT * FROM sub WHERE cl=:c");
                            $su->bindParam(":c", $cl, PDO::PARAM_STR);
                            $su->execute();
                            while($sur = $su->fetch(PDO::FETCH_ASSOC)) {
                                echo '<td>'.att($row['user'],$sur['id'],$dt,$dtt);
                              }
                             ?>                        
                        </tr>
                        <?php
                        $i++;}
                        ?>
                      </tbody>
                    </table>
                    <br>
</form>
<?php
      } 
    }
$db = null;
 ?>
<?php require 'inc/foot.php'; ?>