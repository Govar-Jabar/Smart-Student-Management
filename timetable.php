<?php 
include('class.token.php'); 
require 'inc/head.php';
global $re; 
?>
                <?php if($das==1){ ?>
                <div class="row">
                    <div class="col-md-12">
                     <h2> خشتەی هەفتانە</h2>   
                        <h5>ڕێکخستنی وانەکان بەپێی کاتەکانیان.</h5>
                        <?php if (!isset($_GET['id'])) { ?>
                        <a href="timetable.php?id" style="float: left;" class="btn btn-success"><i class="fa fa-plus"></i> زیادکردن </a>
                        <?php }elseif(isset($_GET['id']) && !isset($_GET['edit'])) { ?>
                        <a href="timetable.php" style="float: left;" class="btn btn-info"><i class="fa fa-table"></i> گەڕانەوە </a>
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
                                  //dh("index.php");

                                  ?>
                                      <div class="panel panel-default">
                                        <div class="panel-heading">زیادکردنی وانە</div>
                                        <div class="panel-body">
                                        <?php
                                              $cl=@output($_POST['cl']);
                                              $sub=@output($_POST['subject']);
                                              $gr=@output($_POST['gr']);
                                              $error=false;
                                              
                                            if (isset($_POST['sub2'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                              if(!empty($cl) AND !empty($sub)){
                                              foreach($_POST['day'] as $key=>$value) {
                                                $day=@output($value);
                                                $st=@output($_POST['st'][$key]);
                                                $et=@output($_POST['et'][$key]);
                                                $location=@output($_POST['location'][$key]);
                                                if(!empty($day) AND !empty($st) AND !empty($et)  AND !empty($location) AND !empty($gr)){
                                                  if (CheckTimetable($day,$sub,$cl,$st,$et,$gr,$location)==0) {
                                                    $stm = $db->prepare("INSERT INTO tt (id, sub,cl,day,st,et,gr,location ) VALUES (NULL, :sub,:cl,:day,:st,:et,:gr,:location);");
                                                    $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
                                                    $stm->bindParam(":sub", $sub, PDO::PARAM_STR);
                                                    $stm->bindParam(":day", $day, PDO::PARAM_STR);
                                                    $stm->bindParam(":st", $st, PDO::PARAM_STR);
                                                    $stm->bindParam(":et", $et, PDO::PARAM_STR);
                                                    $stm->bindParam(":gr", $gr, PDO::PARAM_STR);
                                                    $stm->bindParam(":location", $location, PDO::PARAM_STR);
                                                    $stm->execute();
                                                  }else {
                                                    $error=3;
                                                  }
                                                  }else {
                                                    $error=true;
                                                  }
                                                }
                                                if($error==3) {
                                                  re("info"," ببورە "," بەشێک لە زانیاریەکان داخڵ نەکران، چونکە پێشتر داخڵکراوە.");
                                                }else {
                                                  AddtoHistory("زیادکردنی خشتەی هەفتانە",home);
                                                  re("success"," سوپاس ","  بەسەرکەوتویی زیادکرا. ");
                                                  direct("timetable.php");
                                                }
                                              }else {
                                                $error=true;
                                              }
                                            }else {
                                              re("danger"," کێشە! "," کێشەیەک ڕویدا تکایە دووبارە هەوڵ بدەوە.");
                                            }
                                          }     
       
                                          if($error===TRUE) {
                                            re("danger"," کێشە! "," بەشێک لە زانیاریەکان داخڵنەکران.");
                                          }

                                          ?>
                                            <form action="" method="post">
                                              <div class="form-group">
                                                    <label class="req">قۆناغ</label>
                                                    <select onchange="showSubject(this.value,'sub','subject')" class="selectpicker" data-width="100%"  name="cl" class="form-control">
                                                      <option>قۆناغێك دیاری بکە</option>
                                                      <option value="1">1</option>
                                                      <option value="2">2</option>
                                                      <option value="3">3</option>
                                                      <option value="4">4</option>
                                                    </select>
                                              </div> 
                                              <div class="form-group" id="subject">

                                              </div>
                                              <div class="form-group">
                                                  <label class="req">گروپ</label>
                                                  <select  class="selectpicker" data-width="100%"  name="gr" class="form-control">
                                                    <option value="A">A</option>
                                                    <option value="B">B</option>
                                                    <option value="C">C</option>
                                                    <option value="D">D</option>
                                                  </select>
                                              </div>
                                              <div id="timetable">
                                                <div id="timetb" class="panel panel-default timetable">
                                                  <div class="panel-heading">کاتەکان</div>
                                                  <div class="panel-body">
                                                  <div class="col-md-6">
                                                    <div class="form-group">
                                                          <label>ڕۆژ</label>
                                                          <select class="selectpicker" data-width="100%"  name="day[]" id="stime" class="form-control">
                                                          <?php for ($i = 1; $i < 6; $i++) {
                                                            echo '<option value="'.$i.'">'.day($i).'</option>';
                                                          } ?>
                                                            

                                                          </select>
                                                    </div>
                                                  </div>                                               
                                                  <div class="col-md-6">
                                                    <div class="form-group">
                                                          <label>هۆڵی وانە</label>
                                                          <select data-live-search="true" class="selectpicker" data-width="100%"  name="location[]" id="stime" class="form-control">
                                                          <?php for ($i = 1; $i < 13; $i++) {
                                                            echo '<option value="A'.$i.'">'.'A'.$i.'</option>';
                                                          } ?>
                                                          <?php for ($i = 1; $i < 13; $i++) {
                                                            echo '<option value="B'.$i.'">'.'B'.$i.'</option>';
                                                          } ?>
                                                          <?php for ($i = 1; $i < 13; $i++) {
                                                            echo '<option value="C'.$i.'">'.'C'.$i.'</option>';
                                                          } ?>
                                                          </select>
                                                    </div>
                                                  </div>
                                                  <div class="col-md-6">
                                                    <div class="form-group">
                                                          <label>کاتی دەستپیکردن</label>
                                                          <select class="selectpicker" data-width="100%" id="stime"  name="st[]" class="form-control">
                                                            <option value="08:30AM">08:30</option>
                                                            <option value="09:30AM">09:30</option>
                                                            <option value="10:30AM">10:30</option>
                                                            <option value="11:30AM">11:30</option>
                                                            <option value="12:30PM">12:30</option>
                                                            <option value="01:30PM">01:30</option>
                                                            <option value="02:30PM">02:30</option>
                                                            <option value="03:30PM">03:30</option>
                                                            <option value="04:30PM">04:30</option>
                                                            <option value="05:30PM">05:30</option>
                                                          </select>
                                                    </div>                                              
                                                  </div>
                                                    <div class="col-md-6">
                                                      <div class="form-group">
                                                            <label>کاتی تەواوبوون</label>
                                                            <select class="selectpicker" data-width="100%"  id="stime" name="et[]" class="form-control">
                                                              <option value="09:30AM">09:30</option>
                                                              <option value="10:30AM">10:30</option>
                                                              <option value="11:30AM">11:30</option>
                                                              <option value="12:30PM">12:30</option>
                                                              <option value="01:30PM">01:30</option>
                                                              <option value="02:30PM">02:30</option>
                                                              <option value="03:30PM">03:30</option>
                                                              <option value="04:30PM">04:30</option>
                                                              <option value="05:30PM">05:30</option>
                                                            </select>
                                                      </div>
                                                    </div>
                                                </div>
                                              </div>
                                              </div>
                                             <input type="hidden" name="token" value="<?php echo Token::create(); ?>">
                                            <button type="submit" name="sub2" class="btn btn-default">زیادکردن</button>
                                            <a id="addtm" style="float: left;" class="btn btn-success"><i class="fa fa-plus fa-x3"></i></a>

                                            </form>
                                        </div>
                                    </div>

                        <?php
                        }elseif(isset($_GET['edit'])){//dh("index.php"); ?>
                        

                                      <div class="panel panel-default">
                                        <div class="panel-heading">دەستکاریکردنی خشتەی وانەکان</div>
                                        <div class="panel-body">
                                        <?php

                                              $id=@output($_GET['edit']);
                                              $cl=@output($_POST['cl']);
                                              $sub=@output($_POST['subject']);
                                              $day=@output($_POST['day']);
                                              $st=@output($_POST['st']);
                                              $et=@output($_POST['et']);
                                              $gr=@output($_POST['gr']);
                                              $location=@output($_POST['location']);

                                            if (isset($_POST['sub2'])) {
                                            if(Token::check($_POST['token']) AND !empty($_POST['token'])){
                                                if(!empty($cl) AND !empty($sub) AND !empty($day) AND !empty($st) AND !empty($et)){

                                                  $stm = $db->prepare("UPDATE tt SET location=:location,gr=:gr,cl=:cl,sub=:sub,day=:day,st=:st,et=:et WHERE id=:id");

                                                  $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
                                                  $stm->bindParam(":sub", $sub, PDO::PARAM_STR);
                                                  $stm->bindParam(":day", $day, PDO::PARAM_STR);
                                                  $stm->bindParam(":st", $st, PDO::PARAM_STR);
                                                  $stm->bindParam(":et", $et, PDO::PARAM_STR);
                                                  $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                                  $stm->bindParam(":location", $location, PDO::PARAM_STR);
                                                  $stm->bindParam(":gr", $gr, PDO::PARAM_STR);
                                                  $stm->execute();
                                                  AddtoHistory("دەستکاریکردنی خشتەی هەفتانە",home);
                                                  re("success"," سوپاس "," وانە بەسەرکەوتویی نوێکرایەوە. ");
                                                  //$db = null;
                                                  direct("timetable.php?cl=$cl");

                                            }else {
                                              re("danger"," کێشە! "," تکایە خانەکان بە دروستی پڕبکەوە.");
                                            }
                                            }else {
                                              re("danger"," کێشە! "," کێشەیەک ڕویدا تکایە دووبارە هەوڵ بدەوە.");
                                            }
                                          }
                                          // Select data
                                            $stm = $db->prepare("SELECT * FROM tt WHERE id=:id");
                                            $stm->bindParam(":id", $id, PDO::PARAM_STR);
                                            $stm->execute();
                                            $fetch = $stm->fetch(PDO::FETCH_OBJ);
                                            $rowCount = $stm->rowCount();
                                            if($rowCount > 0){ ?>
                                            <form action="" method="post">
                                              <div class="form-group">
                                                    <label>قۆناغ</label>
                                                    <select onchange="showSubject(this.value,'sub','subject')" onclick="showSubject(this.value,'sub','subject')" class="selectpicker" data-width="100%" id="cl" name="cl" class="form-control">
                                                      <option <?=va(1,$fetch->cl); ?> value="1">1</option>
                                                      <option <?=va(2,$fetch->cl); ?> value="2">2</option>
                                                      <option <?=va(3,$fetch->cl); ?> value="3">3</option>
                                                      <option <?=va(4,$fetch->cl); ?> value="4">4</option>
                                                    </select>
                                              </div>
                                              <div class="form-group">
                                                  <label class="req">گروپ</label>
                                                  <select  class="selectpicker" data-width="100%"  name="gr" class="form-control">
                                                    <option <?=va("A",$fetch->gr);?> value="A">A</option>
                                                    <option <?=va("B",$fetch->gr);?> value="B">B</option>
                                                    <option <?=va("C",$fetch->gr);?> value="C">C</option>
                                                    <option <?=va("D",$fetch->gr);?> value="D">D</option>
                                                  </select>
                                              </div>
                                              <div class="form-group">
                                                    <label>هۆڵی وانە</label>
                                                    <select data-live-search="true" class="selectpicker" data-width="100%"  name="location" id="stime" class="form-control">
                                                    <?php for ($i = 1; $i < 13; $i++) {
                                                      echo '<option';
                                                      va("A".$i,$fetch->location);
                                                      echo ' value="A'.$i.'">'.'A'.$i.'</option>';
                                                    } ?>
                                                    <?php for ($i = 1; $i < 13; $i++) {
                                                      echo '<option';
                                                      va("B".$i,$fetch->location);
                                                      echo ' value="B'.$i.'">'.'B'.$i.'</option>';
                                                    } ?>
                                                    <?php for ($i = 1; $i < 13; $i++) {
                                                      echo '<option';
                                                      va("C".$i,$fetch->location);
                                                      echo ' value="C'.$i.'">'.'C'.$i.'</option>';
                                                      } ?>
                                                    </select>
                                              </div>
                                              <div class="form-group" id="subject">
                                                <label>بابەت</label>
                                                  <select required="" class="selectpicker" data-width="100%"  id="subjects" class="form-control" name="subject">
                                                    <?php getSubjectWhereIDClass($fetch->sub,$fetch->cl); ?>
                                                  </select>
                                              </div>
                                              <div class="form-group">
                                                    <label>ڕۆژ</label>
                                                    <select class="selectpicker" data-width="100%"  name="day" class="form-control">
                                                    <?php for ($i = 1; $i < 6; $i++) {
                                                      echo '<option ';
                                                      va($i,$fetch->day);
                                                      echo ' value="'.$i.'">'.day($i).'</option>';
                                                    } ?>
                                                      

                                                    </select>
                                              </div>
                                              <div class="form-group">
                                                    <label>کاتی دەستپیکردن</label>
                                                    <select class="selectpicker" data-width="100%"  name="st" class="form-control">
                                                      <option <?php va("08:30AM",$fetch->st); ?> value="08:30AM">08:30</option>
                                                      <option <?php va("09:30AM",$fetch->st); ?> value="09:30AM">09:30</option>
                                                      <option <?php va("10:30AM",$fetch->st); ?> value="10:30AM">10:30</option>
                                                      <option <?php va("11:30AM",$fetch->st); ?> value="11:30AM">11:30</option>
                                                      <option <?php va("12:30PM",$fetch->st); ?> value="12:30">12:30</option>
                                                      <option <?php va("01:30PM",$fetch->st); ?> value="01:30">01:30</option>
                                                      <option <?php va("02:30PM",$fetch->st); ?> value="02:30">02:30</option>
                                                      <option <?php va("03:30PM",$fetch->st); ?> value="03:30">03:30</option>
                                                      <option <?php va("04:30PM",$fetch->st); ?> value="04:30">04:30</option>
                                                      <option <?php va("05:30PM",$fetch->st); ?> value="05:30">05:30</option>
                                                    </select>
                                              </div>                                              
                                              <div class="form-group">
                                                    <label>کاتی تەواوبوون</label>
                                                    <select class="selectpicker" data-width="100%"  name="et" class="form-control">
                                                      <option <?php va("09:30AM",$fetch->et); ?> value="09:30AM">09:30</option>
                                                      <option <?php va("10:30AM",$fetch->et); ?> value="10:30AM">10:30</option>
                                                      <option <?php va("11:30AM",$fetch->et); ?> value="11:30AM">11:30</option>
                                                      <option <?php va("12:30PM",$fetch->et); ?> value="12:30PM">12:30</option>
                                                      <option <?php va("01:30PM",$fetch->et); ?> value="01:30PM">01:30</option>
                                                      <option <?php va("02:30PM",$fetch->et); ?> value="02:30PM">02:30</option>
                                                      <option <?php va("03:30PM",$fetch->et); ?> value="03:30PM">03:30</option>
                                                      <option <?php va("04:30PM",$fetch->et); ?> value="04:30PM">04:30</option>
                                                      <option <?php va("05:30PM",$fetch->et); ?> value="05:30PM">05:30</option>
                                                    </select> 
                                              </div>

                                             <input type="hidden" name="token" value="<?php echo Token::create(); ?>">
                                            <button type="submit" name="sub2" class="btn btn-default">دەستکاریکردن</button>
                                            </form>
                                            <?php }else {
                                              e4();
                                            } ?>
                                        </div>
                                    </div>

                         <?php }else{ 
                            $del = output(@$_GET['del']);
                            if (isset($del) && $del!="") {
                              $stm = $db->prepare("DELETE FROM tt WHERE id=:id");
                              $stm->bindParam(":id", $del, PDO::PARAM_STR);
                              $stm->execute();
                              AddtoHistory("سڕینەوەی خشتەی هەفتانە",home);
                            }
                            $cl=output(@$_GET['cl']);
                            $gr=output(@$_GET['gr']);
                          ?>
                    <div class="row timetable">
                        <form action="" method="get">
                        <div class="col-md-6">
                              <div class="form-group">
                                    <label>قۆناغ</label>
                                    <select class="selectpicker" data-width="100%" name="cl" class="form-control">
                                      <option <?=va("1",$cl);?> value="1">1</option>
                                      <option <?=va("2",$cl);?> value="2">2</option>
                                      <option <?=va("3",$cl);?> value="3">3</option>
                                      <option <?=va("4",$cl);?> value="4">4</option>
                                    </select>
                              </div>  
                        </div>
                        <div class="col-md-5">
                              <div class="form-group">
                                    <label>گروپ</label>
                                    <select class="selectpicker" data-width="100%" name="gr" class="form-control">
                                      <option <?=va("A",$gr);?> value="A">A</option>
                                      <option <?=va("B",$gr);?> value="B">B</option>
                                      <option <?=va("C",$gr);?> value="C">C</option>
                                      <option <?=va("D",$gr);?> value="D">D</option>
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
                    <!-- Advanced Tables -->

                    <div class="panel panel-default">
                        <div class="panel-heading">
                             وانەکان و کاتەکانیان
                        </div>
                        <div class="panel-body">
                        <?php
                        
                        $stm = $db->prepare("SELECT * FROM tt WHERE cl=:cl AND gr=:gr");
                        if ($cl=="" OR $gr=="" ) {
                          $stm = $db->prepare("SELECT * FROM tt WHERE cl=1 AND gr='A'");
                        }
                          $stm->bindParam(":gr", $gr, PDO::PARAM_STR);
                        $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
                        $stm->execute();
                        $rowCount = $stm->rowCount();
                        if($rowCount > 0){
                        ?>
                            <div class="table-responsive">
                                <table id="advance" class="table table-striped table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th width="50px">#</th>
                                            <th>وانە</th>
                                            <th width="70px">قۆناغ</th>
                                            <th width="70px">گروپ</th>
                                            <th width="100px">دەستپێکردن</th>
                                            <th width="100px">کۆتایی وانە</th>
                                            <th width="110px">ڕۆژ</th>
                                            <th width="70px">کردار</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while($row = $stm->fetch(PDO::FETCH_ASSOC)) { 
                                      ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php ndb("tt,sub","tt.sub=sub.id AND tt.sub=".$row['sub']);echo $fetch->sn; ?></td>
                                            <td><?php echo $row['cl']; ?></td>
                                            <td><?php echo $row['gr']; ?></td>
                                            <td><?php echo $row['st']; ?></td>
                                            <td><?php echo $row['et']; ?></td>
                                            <td><?php echo day($row['day']); ?></td>
                                            <td>
                                            
                                              <a href="timetable.php?edit=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" class="btn btn-info btn-xs mrg" title="دەستکاری"><i class="fa fa-edit"></i></a>

                                              <a href="timetable.php?del=<?php echo $row['id']; ?>" value="#go" id="btn-confirm" data-toggle="tooltip" data-placement="top" class="btn btn-danger btn-xs mrg confirmation" title="سڕینەوە"><i class="fa fa-trash-o"></i></a>


                                              </td>

                                        </tr>
                                        <?php
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

      <?php } ?>
      <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
        <div class="panel-heading">
          خشتەی وانەکانی قۆناغە جیاوازەکان
        </div>
          <div class="panel-body">
              <ul class="nav nav-tabs">
                  <li class="<?php if($cl=="" OR $cl=="1"){echo 'active';} ?>"><a href="#c1" data-toggle="tab">قۆناغی یەك</a>
                  </li>
                  <li class="<?php if($cl!="" AND $cl=="2"){echo 'active';} ?>"><a href="#c2" data-toggle="tab">قۆناغی دوو</a>
                  </li>
                  <li class="<?php if($cl!="" AND $cl=="3"){echo 'active';} ?>"><a href="#c3" data-toggle="tab">قۆناغی سێ</a>
                  </li>
                  <li class="<?php if($cl!="" AND $cl=="4"){echo 'active';} ?>"><a href="#c4" data-toggle="tab">قۆناغی چوار</a>
                  </li>
              </ul>

            <div class="tab-content">
              <div class="tab-pane fade <?php if($cl=="" OR $cl=="1"){echo 'active in';} ?>" id="c1">

<ul class="nav nav-tabs">
    <li class="active"><a href="#a" data-toggle="tab">A</a></li>
</ul>
<div class="tab-content">
      <div class="tab-pane fade active in" id="a">
        <?php timetable(1,"A");?>
      </div>
</div>

              
              </div>
              <div class="tab-pane fade <?php if($cl=="2"){echo 'active in';} ?>" id="c2">

<ul class="nav nav-tabs">
    <li class="<?php if($gr=="" OR $gr=="A" OR $cl!="2"){echo 'active';} ?>"><a href="#2a" data-toggle="tab">A</a></li>
    <li class="<?php if($gr!="" AND $gr=="B" AND $cl=="2"){echo 'active';} ?>"><a href="#2b" data-toggle="tab">B</a></li>
</ul>
<div class="tab-content">
      <div class="tab-pane fade <?php if($gr=="" OR $gr=="A" OR $cl!="2"){echo 'active in';} ?>" id="2a">
        <?php timetable(2,"A");?>
      </div>
      <div class="tab-pane fade <?php if($gr!="" AND $gr=="B" AND $cl=="2"){echo 'active in';} ?>" id="2b">
        <?php timetable(2,"B");?>
      </div>
</div>

              </div>
              <div class="tab-pane fade <?php if($cl=="3"){echo 'active in';} ?>" id="c3">

<ul class="nav nav-tabs">
    <li class="<?php if($gr=="" OR $gr=="A" OR  $cl!="3"){echo 'active';} ?>"><a href="#3a" data-toggle="tab">A</a></li>
    <li class="<?php if($gr!="" AND $gr=="B" AND $cl=="3"){echo 'active';} ?>"><a href="#3b" data-toggle="tab">B</a></li>
</ul>
<div class="tab-content">
      <div class="tab-pane fade <?php if($gr=="" OR $gr=="A" OR $cl!="3"){echo 'active in';} ?>" id="3a">
        <?php timetable(3,"A");?>
      </div>
      <div class="tab-pane fade <?php if($gr!="" AND $gr=="B" AND $cl=="3"){echo 'active in';} ?>" id="3b">
        <?php timetable(3,"B");?>
      </div>
</div>

              </div>
              <div class="tab-pane fade <?php if($cl=="4"){echo 'active in';} ?>" id="c4">

<ul class="nav nav-tabs">
    <li class="<?php if($gr=="" OR $gr=="A" OR  $cl!="4"){echo 'active';} ?>"><a href="#4a" data-toggle="tab">A</a></li>
    <li class="<?php if($gr!="" AND $gr=="B" AND $cl=="4"){echo 'active';} ?>"><a href="#4b" data-toggle="tab">B</a></li>
</ul>
<div class="tab-content">
      <div class="tab-pane fade <?php if($gr=="" OR $gr=="A" OR $cl!="4"){echo 'active in';} ?>" id="4a">
        <?php timetable(4,"A");?>
      </div>
      <div class="tab-pane fade <?php if($gr!="" AND $gr=="B" AND $cl=="4"){echo 'active in';} ?>" id="4b">
        <?php timetable(4,"B");?>
      </div>
</div>

              </div>

            </div>
          </div>
        </div>

<div class="alert" role="alert" id="result"></div>

<?php
$db = null;
 include 'inc/foot.php'; ?>