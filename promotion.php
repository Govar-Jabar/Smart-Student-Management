<?php 
include('class.token.php'); 
require 'inc/head.php';
global $re;
                        $cl=output(@$_GET['cl']);
                        $gr=output(@$_GET['gr']);
?>
                <div class="row">
                    <div class="col-md-12">
                     <h2> گواستنەوەی قۆناغەکان</h2>
                        <h5>گواستنەوەی خوێندکاران و هەژمارکردنیان بەکەوتوو یان دەرچوو</h5>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                  <div class="row mark">
                    <div class="col-md-12">
                  <?php if(!isset($_GET['view']) AND !isset($_GET['edit'])) { ?>
                      <form action="" method="get">
                        <div class="col-md-6">
                              <div class="form-group">
                                    <label>قۆناغ</label>
                                    <select class="selectpicker" data-width="100%" name="cl" class="form-control">
                                      <option <?php va(@$_GET['cl'],1); ?> value="1">1</option>
                                      <option <?php va(@$_GET['cl'],2); ?> value="2">2</option>
                                      <option <?php va(@$_GET['cl'],3); ?> value="3">3</option>
                                      <option <?php va(@$_GET['cl'],4); ?> value="4">4</option>
                                    </select>
                              </div>  
                        </div>
                        <div class="col-md-5">
                              <div class="form-group">
                                    <label>گروپ</label>
                                    <select class="selectpicker" data-width="100%" name="gr" class="form-control">
                                      <option value="">هەموو گروپەکان</option>
                                      <option <?php va(@$_GET['gr'],"A"); ?> value="A">A</option>
                                      <option <?php va(@$_GET['gr'],"B"); ?>  value="B">B</option>
                                      <option <?php va(@$_GET['gr'],"C"); ?>  value="C">C</option>
                                      <option <?php va(@$_GET['gr'],"D"); ?>  value="D">D</option>
                                    </select>
                              </div>  
                        </div>                        
                     
                        <div class="col-md-1">
                              <div class="form-group">
                                    <label style="color: #fff;">_</label>
                                    <button  data-toggle="tooltip" data-placement="top" title="" data-original-title="گەڕان" type="submit" style="float: right;" class="btn btn-info"><i class="fa fa-search"></i> گەڕان</button>

                            </div>
                        </div>

                      </form>
                    </div>
                </div>
                <hr>
                 <!-- /. ROW  -->
                    <!-- Advanced Tables -->
<?php 
if (isset($_POST['save'])) {$rowCount=0;
  foreach ($_POST['stu'] as $key=>$stu_id) {
    $res=output($_POST['res'][$key]);
    $cl=output($cl);
    if ($res==1 AND ndb("stu","id='$stu_id' AND class='$cl'")==1) {
         $stm = $db->prepare("UPDATE stu SET class = class + 1 WHERE id=:id");
         $stm->bindParam(":id",$stu_id , PDO::PARAM_STR);
         $stm->execute();
         $rowCount = $stm->rowCount();
    }

  }
  re("info","سوپاس","$rowCount خوێندکار بەسەرکەوتویی گوازرانەوە.");

}
 ?>
                    <?php if (isset($cl) AND $cl!="") { ?>
                  <div class="row">
                    <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                    <div class="panel-heading">
                    لیستی خوێندکاران
                    </div>
                    <div class="panel-body">
                      
                    <div class="table-responsive">
                    <form action="" method="post">
                    
                    <table id="" class="table table-striped table-bordered table-hover" data-id="dataTables-example">
                      <thead>
                        <tr>
                          <th width="50px">#</th>
                          <th>ناوی تەواوەتی</th>
<?php 
$stm = $db->prepare("SELECT * FROM sub WHERE cl=:cl");
$stm->bindParam(":cl",$cl , PDO::PARAM_STR);
$stm->execute();
$rowCount = $stm->rowCount();
  if($rowCount > 0){
    while ($row=$stm->fetch(PDO::FETCH_ASSOC)) {
        echo '<th style="width:50px;font-size:11px">'.$row['sn'].'</th>';
    }
  }

 ?>
                          <th width="50px">بار</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php

                        if (isset($_GET['cl']) AND $_GET['cl']!='') {
                            $stm = $db->prepare("SELECT * FROM stu WHERE class=:cl");
                          if (isset($_GET['gr']) AND $gr!='') {
                            $stm = $db->prepare("SELECT * FROM stu WHERE class=:cl AND gr=:gr");
                            $stm->bindParam(":gr",$gr, PDO::PARAM_STR);
                          }
                            $stm->bindParam(":cl",$cl, PDO::PARAM_STR);
                        }
                          $stm->execute();
                          $rowCount = $stm->rowCount();
                            if($rowCount > 0){
                              $id=0;
                              while($row = $stm->fetch(PDO::FETCH_ASSOC)) { $id++;
                                ?>
                                <tr>
                                  <td><?=$id;?></td>
                                  <td><?=$row['fname'];?></td>
                                  
<?php
$result=1;
$stmMark = $db->prepare("SELECT * FROM sub WHERE cl=:cl");
$stmMark->bindParam(":cl",$cl , PDO::PARAM_STR);
$stmMark->execute();
$rowCountMark = $stmMark->rowCount();
  if($rowCountMark > 0){
    while ($rowMark=$stmMark->fetch(PDO::FETCH_ASSOC)) {
    $stmTotal = $db->prepare("SELECT * FROM mark_data WHERE student_id=:stu AND subject_id=:sub");
    $stmTotal->bindParam(":stu", $row['id'], PDO::PARAM_STR);
    $stmTotal->bindParam(":sub", $rowMark['id'], PDO::PARAM_STR);
     $stmTotal->execute();
     $total=0;
    $rowCountTotal = $stmTotal->rowCount();
      if($rowCountTotal > 0){
        while($rowTotal = $stmTotal->fetch(PDO::FETCH_ASSOC)) { 
          $total=$total+$rowTotal['mark'];
        }
      }
    echo "<td>".$total."</td>";
    if ($total < 50) {
      $result=0;
    }
    }
  }

 ?>

                                  <td>
                                  <?php if($result==1){ ?>
                                    <a class="btn btn-success btn-xs">دەرچووە</a>
                                    <input type="hidden" name="stu[]" value="<?=$row['id'];?>" placeholder="">
                                    <input type="hidden" name="res[]" value="1">
                                    <?php }else{ ?>
                                    <a class="btn btn-danger btn-xs">کەوتووە</a>
                                    <input type="hidden" name="stu[]" value="<?=$row['id'];?>" placeholder="">
                                    <input type="hidden" name="res[]" value="0">
                                    <?php } ?>
                                  </td>
                        
                                </tr>
                                <?php
                              }
                            }
                        ?>
                      </tbody>
                    </table>

<center>
  <button type="submit" class="btn btn-success confirmation" name="save">گواستنەوەی خوێندکارە سەرکەوتووەکان لە قۆناغی <?=classwithString($cl);?> بۆ <?=classwithString($cl+1);?></button>
</center>

                         <?php 
                            } }else {
                              
                            } ?>
</form>

<div class="alert" role="alert" id="result"></div>
<?php include 'inc/foot.php'; ?>