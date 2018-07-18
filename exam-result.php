<?php 
include('class.token.php'); 
require 'inc/head.php';
$cl=output(@$_GET['cl']);
$sub=output(@$_GET['sub']);
$exam=output(@$_GET['exam']);

?>
                <div class="row">
                    <div class="col-md-12">
                     <h2> هەژمارکردنی تاقیکردنەوە</h2>
                        <h5>لێرەوە دەتوانیت نمرەی تاقیکردنەوەکان هەژمار بکەیت.</h5>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                <div class="row">
                    <div class="col-md-12">
                      <form action="" method="get">
                        <div class="col-md-3">
                              <div class="form-group">
                                    <label>قۆناغ</label>
                                    <select onchange="showSubject(this.value+'&sub&exam','cl','subject')"  class="selectpicker" data-width="100%" name="cl"  id="cl" class="form-control">
                                      <option>دیاری بکە</option>
                                      <option <?php va("1",$cl); ?>  value="1">1</option>
                                      <option <?php va("2",$cl); ?>  value="2">2</option>
                                      <option <?php va("3",$cl); ?>  value="3">3</option>
                                      <option <?php va("4",$cl); ?>  value="4">4</option>
                                    </select>
                              </div>  
                        </div>
                        <div class="col-md-3">
                              <div class="form-group" id="subject">
                                        <?php if (isset($sub) AND isset($cl) AND $sub!="" AND $cl!="") { ?>
                                            <?php getSubjectWhereIDClassAjax($sub,$cl); ?>
                                        <?php } else { ?>
                                    <label>بابەت</label>
                                    <select class="selectpicker" data-width="100%" name="sub" class="form-control">
                                            <option>قۆناغێک دیاری بکە</option>
                                    </select>
                                        <?php } ?>
                              </div>  
                        </div>  
                        <div class="col-md-4">
                              <div class="form-group" id="exam">
                                    <label>تاقیکردنەوە</label>
                                    <select class="selectpicker" data-width="100%" name="exam" class="form-control">
                                        <?php if (isset($sub) AND isset($cl)  AND isset($exam) AND $sub!=""  AND $exam!="" AND $cl!="") { ?>
                                            <?php getExamNamewithExamID($exam); ?>
                                        <?php } else { ?>
                                            <option>بابەتێک دیاری بکە</option>
                                        <?php } ?>
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
                      <?php if (isset($sub) AND isset($cl)  AND isset($exam) AND $sub!=""  AND $exam!="" AND $cl!="") { ?>
                        <hr width="100%">
                        <?php
                            $qg=0; 
                             $stm = $db->prepare("SELECT * FROM exam WHERE id=:id");
                             $stm->bindParam(":id", $exam, PDO::PARAM_STR);
                             $stm->execute();
                             $data = $stm->fetch(PDO::FETCH_OBJ);
                             $rowCount = $stm->rowCount();
                                if($rowCount > 0){
                                    echo '<center><h4>تاقیکردنەوەی '.$data->name.'</h4></center><br>';
                                    $qg=$data->qg;
                        }
                    
                            $stu=0;

                            $start=0;
                            $end=1;
                             $stm = $db->prepare("SELECT * FROM stu WHERE class=:cl");
                             $stm->bindParam(":cl",$cl , PDO::PARAM_STR);
                             $stm->execute();
                             $data = $stm->fetch(PDO::FETCH_OBJ);
                             $rowCount = $stm->rowCount();
                             $stuarray= array();
                             $getstudent = $db->prepare("SELECT * FROM er WHERE exam=:exam AND ck=0");
                             $getstudent->bindParam(":exam",$exam , PDO::PARAM_STR);
                             $getstudent->execute();
                             $i=0;
                             while ($row2= $getstudent->fetch(PDO::FETCH_ASSOC)) {
                                 $stuarray[$i] = $row2['user'];
                                 $i++;
                             }

                             $s1 = $db->prepare("SELECT * FROM er WHERE user=:user AND exam=:exam AND ck=0");
                             $s1->bindParam(":user",$stuarray[0] , PDO::PARAM_STR);
                             $s1->bindParam(":exam",$exam , PDO::PARAM_STR);
                             $s1->execute();
                             $n=1;
                             if ($s1->rowCount() > 0) { 
                        ?>
                     <div class="panel panel-default">
                        <div style="text-align: center;" class="panel-heading">
                            
                            <?php GetFullNamewithUser($stuarray[0]);?>
                        </div>
                        <div class="panel-body">
                        <form action="" method="post">                        
                        <?php while ($row= $s1->fetch(PDO::FETCH_ASSOC)) {$stu=$row['user']; ?>
                         <div class="panel panel-default">
                            <div class="panel-heading">
                                پرسیاری <?=$n;?> <span style="float: left;"><?php ndb("qb"," id=".$row['qid']);echo $fetch->mark;?> نمرە</span>
                            </div>
                            <div class="panel-body">
                                <div class="col-md-12">
                                <p><b>پرسیار</b> :<br>
                                <?php ndb("qb"," id=".$row['qid']);echo $fetch->qu;?>
                                </p>
                                <hr width="100%">
                                <p><b>وەڵام</b> :<br>
                                
                                <?php if ($fetch->tr!= 0  AND $fetch->a2!="" AND $fetch->a3!="" AND $fetch->a4!="") { ?>
                                    <?php
                                        if ($fetch->tr==$row['anser']) {
                                            $mark=$fetch->mark;
                                        }else {
                                            $mark=0;
                                        }
                                    
                                    switch ($row['anser']) {
                                        case 1:
                                            echo $fetch->a1;
                                            break;
                                        case 2:
                                            echo $fetch->a2;
                                            break;
                                        case 3:
                                            echo $fetch->a3;
                                            break;
                                        case 4:
                                            echo $fetch->a4;
                                            break;

                                        default:
                                            // code...
                                            break;
                                    }

                                    ?>
                                </p>
                                <hr width="100%">
                                <p>نمرە :<br>

                                <input type="number" data-toggle="tooltip" data-placement="top" data-original-title="دەستکاریکردنی نمرە بۆیە ناچالاکە چونکە ئەم پرسیارە هەڵبژاردنە و پێشتر وەڵامی دروست هەڵبژێردراوە" readonly="" name="mark[<?=@$row['qid'];?>]" value="<?=@$mark;?>" class="form-control">
                                <input type="hidden" name="qid[<?=@$row['qid'];?>]" value="<?=@$row['qid'];?>">

                                </p>
                                </div> 
                                <?php }else { ?>
                                <?=@$row['anser'];?>
                                </p>
                                <hr width="100%">
                                <p>نمرە :<br>

                                <input type="number" name="mark[<?=@$row['qid'];?>]" min="0" max="<?php if(isset($fetch->mark)){echo $fetch->mark;}else{echo '0';}?>" value="0" class="form-control">
                                <input type="hidden" name="qid[<?=@$row['qid'];?>]" value="<?=@$row['qid'];?>">

                                </p>
                                </div> 
                                <?php } ?>

                                
                            </div>
                        </div>
                        <?php $n++;} ?>
                        <center>
                            <button type="submit" name="save" class="btn btn-success btn-md">تەواوکردن</button>
                        </center>

                            <?php 
                            $total=0;
                            if (isset($_POST['save'])) {
                                foreach ($_POST['mark'] as $key=>$mark) {
                                    $total =$total + $mark;
                                    HideExamResult(@$_POST['qid'][$key]);
                                }
                                AddExamtoMarkData(GetStudentIdwithUser($stu),$sub,$total);
                                dh(home);
                            }

                             ?>
                        </form>
                    </div>
                    </div>
                </div>
<?php
}else {
    echo 'ببورە هیچ ئەنجامێک نەدۆزرایەوە';
}
} 
$db = null;
include 'inc/foot.php'; ?>