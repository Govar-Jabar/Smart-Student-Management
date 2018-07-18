<?php 
include('class.token.php'); 
require 'inc/head.php';
global $re;
if ($das==1) {
  dh('index.php');
}
$view=output(@$_GET['view']); 
$edit=output(@$_GET['edit']);

?>
                <div class="row">
                    <div class="col-md-12">
                    <?php if(!isset($_GET['view']) ) { ?>
                     <h2> نمرەکان</h2>
                        <h5>دەستکاریکردنی نمرەکان و ڕێکخستنیان</h5>
                    <?php }elseif(isset($_GET['view'])){ ?>
                      <center>
                          <h2><?php
                            if ($das==3) {
                              $view= output(@$un);
                            }
                           ndb("stu","user='$view'");;
                                    if(isset($_GET['edit'])){
                                      ndb("stu","user='$edit'");
                                      };
                                      echo @$fetch->fname; ?></h2>
                          <h5>(قۆناغی <?=@$fetch->class;?> - گروپی <?=cl(@$fetch->gr);?>)</h5>
                      </center>

                    <?php }
                    if(isset($_GET['edit']) OR isset($_GET['view'])){ ?>
                    <a href="mark.php" style="float: left;" class="btn btn-info"><i class="fa icon-markmain"></i> گەڕانەوە </a>
                    <?php }else{ ?>
                           <a href="mark.php?edit" style="float: left;" class="btn btn-success"><i class="fa icon-markmain"></i> تۆمارکردنی نمرەکان </a>
                    <?php } ?>
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

                <div class="row">
                <div class="col-md-12">

                  <div class="row">
                    <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                    <div class="panel-heading">
                    لیستی خوێندکاران
                    </div>
                    <div class="panel-body">
                    <div class="table-responsive">
                    <table id="advance2" class="table table-striped table-bordered table-hover" data-id="dataTables-example">
                      <thead>
                        <tr>
                          <th width="50px">#</th>
                          <th width="50px">وێنە</th>
                          <th>ناوی تەواوەتی</th>
                          <th>ئیمەیڵ</th>
                          <th width="50px">کردار</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php
                        $cl=output(@$_GET['cl']);
                        $gr=output(@$_GET['gr']);
                        $stm = $db->prepare("SELECT * FROM stu WHERE class=1");
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
                              while($row = $stm->fetch(PDO::FETCH_ASSOC)) { 
                                ?>
                                <tr>
                                  <td><?=$row['id'];?></td>
                                  <td><img class="atach" src="uploads/<?=$row['img']; ?>" alt=""></td>
                                  <td><?=$row['fname'];?></td>
                                  <td><?=$row['email']; ?></td>
                                  <td>
                                    <a href="mark.php?view=<?=$row['user'];?>" class="btn btn-success btn-xs mrg" data-toggle="tooltip" data-placement="top" title="بینین"><i class="fa fa-check-square-o"></i></a>
                                  </td>
                                </tr>
                                <?php
                              }
                            }
                        ?>
                      </tbody>
                    </table>


                         <?php 
                            }elseif (isset($_GET['view']) AND !isset($_GET['edit'])) {
                              $user= output(@$_GET['view']);
                              if ($das==3) {
                                $user= output(@$un);
                              }
                              $stm = $db->prepare("SELECT * FROM stu WHERE user=:user");
                              $stm->bindParam(":user",$user , PDO::PARAM_STR);
                              $stm->execute();
                              $rowCount = $stm->rowCount();
                              $row = $stm->fetch(PDO::FETCH_ASSOC);
                              $class=$row['class'];
                              $student_id=$row['id'];
                                if($rowCount > 0){
                            ?>

                               
                                <table id="advance" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                  <th rowspan="2" style="text-align:center;vertical-align: middle;background-color:#395C7F;color:#fff;">وانەکان</th>
                                  <?php
                                    $stm1 = $db->prepare("SELECT type,mark FROM mark ORDER BY type ASC");
                                    $stm1->execute();
                                    $rowCount1 = $stm1->rowCount();
                                    $type=array();
                                    $i=0;
                                    if($rowCount1 > 0){
                                      while($row1 = $stm1->fetch(PDO::FETCH_ASSOC)) { 
                                         $type[$i]=$row1['type'];
                                        echo '<th colspan="1" style="text-align:center;background-color:#395C7F;color:#fff;">'.
                                          typeMark($row1['type']).' ('.$row1['mark'].'%)'
                                        .'</th>';
                                        $i++;
                                      }
                                      echo '<th colspan="2" style="text-align:center;background-color:#395C7F;color:#fff;">ئەنجام</th>';
                                    }
                                  ?>

                                </tr>
                                <tr>
                                <?php for ($i = 0; $i < $rowCount1; $i++) {
                                  echo '<th class="bg-sky text-center ">نمرە</th>';
                                }
                                  echo '<th class="bg-sky text-center ">نمرە</th>';
                                  echo '<th class="bg-sky-light text-center" >ئاست</th>';
                                ?>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $stmSub = $db->prepare("SELECT * FROM sub WHERE cl=:cl");
                                    $stmSub->bindParam(":cl",$class , PDO::PARAM_STR);
                                    $stmSub->execute();
                                    $rowCountSub = $stmSub->rowCount();
                                    sort($type);
                                    $total_all=0;
                                    if($rowCountSub > 0){
                                      while($rowSub = $stmSub->fetch(PDO::FETCH_ASSOC)) {
                                        ?>
                                          <tr>
                                            <td class="text-black" data-title="Subject"><?=$rowSub['sn'];?></td>
                                            <?php 
                                    $stm1 = $db->prepare("SELECT type FROM mark ORDER BY type ASC");
                                    $stm1->execute();
                                    $rowCount1 = $stm1->rowCount();
                                    $total=0; 
                                    $result_all=0; 
                                    if($rowCount1 > 0){
                                    while($row1 = $stm1->fetch(PDO::FETCH_ASSOC)) {
                                             ?>
                                            <td class="text-black" data-title="Mark">
                                            <?php 
                                            $sub_id=$rowSub['id'];
                                              ndb("mark_data","type='".$row1['type']."' AND subject_id='$sub_id' AND student_id='$student_id'");echo @$fetch->mark;$total=@$total+@$fetch->mark; ?>
                                            <?php } ?>
                                            <td class="text-black" data-title="Mark"><?=@$total;?></td>
                                            <td class="text-black" data-title="Highest Mark"><?=Astakan(@$total);?></td>
                                          </tr>
                                        <?php
                                        if ($total < 50) {
                                          $result_all=1;
                                        }
                                        $total_all=$total_all+@$total;
                                      }
                                    }
                                    }
                                    ?>
                                    <caption style=" caption-side: bottom;">
                                      <h4>کۆنمرە : <?=floor($total_all / $rowCountSub * 100) / 100;?></h4> - 
                                      <h4>ئاست : <?php if($result_all!=1){echo Astakan($total_all / $rowCountSub);}else{echo Astakan(49);}?></h4>&nbsp;&nbsp;&nbsp;&nbsp;
                                    </caption>
                                  
                                </tbody>
                                </table>
                      <?php
                          }else {
                            e4();
                          }



                        }elseif(isset($_GET['edit'])){
                              $sub_id=output(@$_GET['subject']);
                              $class=output(@$_GET['edit']);
?>

                      <form action="mark.php?edit&" method="get">
                        <div class="col-md-6">
                              <div class="form-group">
                                    <label>قۆناغ</label>
                                    <select onchange="showSubject(this.value,'mark','subject')" class="selectpicker" data-width="100%"  name="edit" class="form-control">
                                      <option >قۆناغێک دیاری بکە</option>
                                      <option <?php va("1",$class); ?>  value="1">1</option>
                                      <option <?php va("2",$class); ?>  value="2">2</option>
                                      <option <?php va("3",$class); ?>  value="3">3</option>
                                      <option <?php va("4",$class); ?>  value="4">4</option>
                                    </select>
                              </div>  
                        </div>
                        <div class="col-md-5">
                              <div class="form-group" id="subject">
                                    <label>بابەت</label>
                                    <?php if (isset($_GET['subject'])) { ?>
                                         <select class="selectpicker" data-width="100%"  name="subject" class="form-control">
                                          <?php getSubjectWhereIDClassForMark($sub_id,$class); ?>
                                         </select>
                                     <?php }else{ ?>
                                    <select disabled="" class="selectpicker" data-width="100%"  name="subject" class="form-control">
                                      <option value="">قۆناغێک دیاری بکە</option>
                                    </select>
                                    <?php } ?>
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
if (isset($_GET['edit']) AND isset($_GET['subject']) AND @$_GET['edit']!="" AND @$_GET['subject']!="") {

if (ndb("sub,tea","sub.tea=tea.id AND tea.user='$un' AND sub.id='$sub_id'")!=0 OR $das==1) {
                              $stm = $db->prepare("SELECT * FROM sub WHERE cl=:cl AND id=:sub");
                              $stm->bindParam(":cl",$class , PDO::PARAM_STR);
                              $stm->bindParam(":sub",$sub_id , PDO::PARAM_STR);
                              $stm->execute();
                              $rowCount = $stm->rowCount();
                              $row = $stm->fetch(PDO::FETCH_ASSOC);
                                if($rowCount > 0){
                            ?>

                               <form action="" method="post">
                                <table class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                  <th rowspan="2" style="width:220px;text-align:center;vertical-align: middle;background-color:#395C7F;color:#fff;">خوێندکاران</th>
                                  <?php
                                    $stm1 = $db->prepare("SELECT type FROM mark ORDER BY type ASC");
                                    $stm1->execute();
                                    $rowCount1 = $stm1->rowCount();
                                    if($rowCount1 > 0){
                                      while($row1 = $stm1->fetch(PDO::FETCH_ASSOC)) { 
                                        echo '<th colspan="1" style="text-align:center;background-color:#395C7F;color:#fff;">'.
                                          typeMark($row1['type'])
                                        .'</th>';
                                      }
                                      echo '<th colspan="1" style="width:150px;text-align:center;background-color:#395C7F;color:#fff;">ئەنجام</th>';
                                    }
                                  ?>

                                </tr>
                                <tr>
                                <?php 
                                $stm1 = $db->prepare("SELECT type,mark FROM mark ORDER BY type ASC");
                                $stm1->execute();
                                $rowCount1 = $stm1->rowCount();
                                $markper=0;
                                  if($rowCount1 > 0){
                                    while($row1 = $stm1->fetch(PDO::FETCH_ASSOC))  {
                                      $markper=$row1['mark'];
                                      echo '<th colspan="1" class="bg-sky text-center ">نمرە ( '.$row1['mark'].'% )</th>';
                                    }
                                      echo '<th class="bg-sky text-center ">نمرە  ( 100% )</th>';
                                    }
                                ?>
                                </tr>
                                </thead>
                                <tbody>
                                  <?php
                                    $stu_id=0;
                                    $stmStu = $db->prepare("SELECT * FROM stu WHERE class=:cl");
                                    $stmStu->bindParam(":cl",$class , PDO::PARAM_STR);
                                    $stmStu->execute();
                                    $rowCountStu = $stmStu->rowCount();
                                    $total_all=0;
                                    if($rowCountStu > 0){
                                      while($rowStu = $stmStu->fetch(PDO::FETCH_ASSOC)) {
                                        $stu_id=$rowStu['id'];
                                        ?>
                                          <tr>
                                            <td class="text-black"><?=$rowStu['fname'];?></td>
                                            <?php 
                                    $stm1 = $db->prepare("SELECT type,mark FROM mark ORDER BY type ASC");
                                    $stm1->execute();
                                    $rowCount1 = $stm1->rowCount();
                                    $total=0; 
                                    $result_all=0; 
                                    if($rowCount1 > 0){
                                    while($row1 = $stm1->fetch(PDO::FETCH_ASSOC)) {
                                             ?>
                                            <td>
                                            <?php 
                                              ndb("mark_data","type='".$row1['type']."' AND subject_id='$sub_id' AND student_id='".$rowStu['id']."'");echo '
                                              <input type="number" min="0" max="'.$row1['mark'].'" class="form-control" style="width:100%" name="mark[]" value="'.@$fetch->mark.'">
                                              <input name="mark1[]" type="hidden" value="'.$rowStu['id'].'">
                                              <input name="type[]" type="hidden" value="'.$row1['type'].'">


                                              ';$total=@$total+@$fetch->mark; ?>
                                            <?php } ?>
                                            <td style="text-align: center;" data-title="Mark"><?=@$total;?></td>
                                          </tr>
                                        <?php
                                        if ($total < 50) {
                                          $result_all=1;
                                        }
                                        $total_all=$total_all+@$total;
                                      }
                                    }
                                    }
                                    ?>
                               
                                </tbody>
                                </table>
                                <center><button type="submit" name="save" class="btn btn-success confirmation">چەسپاندن</button></center>
                               </form>
                      <?php

    if(isset($_POST["save"])){


$a_mark=$_POST['mark'];
$a_mark1=$_POST['mark1'];
$a_type=$_POST['type'];
foreach ($a_mark as $i => $mark) {
// list($id,$type) = explode('|', $value);
$id=$a_mark1[$i];
$type=$a_type[$i];

              $stm1 = $db->prepare("SELECT * FROM mark_data WHERE type=:type AND subject_id=:sub AND student_id=:stu_id");
              $stm1->bindParam(":sub", $sub_id, PDO::PARAM_STR);
              $stm1->bindParam(":stu_id", $id, PDO::PARAM_STR);
              $stm1->bindParam(":type", $type, PDO::PARAM_STR);
              $stm1->execute();
              $f1 = $stm1->fetch(PDO::FETCH_OBJ);
              $r1 = $stm1->rowCount();
              if ($r1>0) {
                  $s = $db->prepare("UPDATE mark_data SET mark = :mark WHERE markd_id = :id");
                  $s->bindParam(":id", $f1->markd_id, PDO::PARAM_STR);
                  $s->bindParam(":mark", $mark, PDO::PARAM_STR);
                  $s->execute();
              }else{
                  $s = $db->prepare("INSERT INTO mark_data (type,subject_id,student_id,mark) VALUES (:type, :sub, :stu_id, :mark);");
                  $s->bindParam(":sub", $sub_id, PDO::PARAM_STR);
                  $s->bindParam(":stu_id", $id, PDO::PARAM_STR);
                  $s->bindParam(":type", $type, PDO::PARAM_STR);
                  $s->bindParam(":mark", $mark, PDO::PARAM_STR);
                  $s->execute();  
            }
          }
            AddtoHistory("هەژمارکردنی نمرەی خوێندکاران",home);
            re("success"," سوپاس "," زانیاریەکانت بە سەرکەوتویی نوێکرانەوە.");
            direct(link);   
          }

                          }else {
                            e4();
                          }
                        }else {
                          re("info"," ببورە "," تەنیا دەتوانیت دەستکاری نمرەی بابەتەکانی خۆت بکەیت.");
                        }
                        }                            
                          ?>


                    
                        </div>
                    <!--End Advanced Tables -->
                    <?php } ?>

                 <!-- /. ROW  -->



<div class="alert" role="alert" id="result"></div>

<?php include 'inc/foot.php'; ?>