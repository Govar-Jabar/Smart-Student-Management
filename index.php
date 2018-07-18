<?php require 'inc/head.php';
global $pcl;
 ?>
                
 
                <?php if($das==3){ ?>                
                <div class="row">
                    <div class="col-md-12">
                     <h2>خوێندکار</h2>   
                        <h5>بەخێرهاتیت خوێندکاری خۆشەویست لێرە دەتوانیت زانیاریەکانت ڕێك بخەیت...</h5>
                    </div>
                </div> 
                <hr />
                <?php } if($das==2){ ?>                
                <div class="row">
                    <div class="col-md-12">
                     <h2>مامۆستا</h2>   
                        <h5>بەخێرهاتیت مامۆستای خۆشەویست لێرە دەتوانیت زانیاریەکانت ڕێك بخەیت...</h5>
                    </div>
                </div> 
                <hr />
                <?php } if($das==1 OR $das==2){if($das==1){ ?>                 
                <div class="row">
                    <div class="col-md-12">
                    <img src="<?php if($array['i']==""){echo 'assets/img/logo.png';}else{echo 'uploads/'.$array["i"];}?>" style="height: 80px;float: left;">
                    <img src="assets/img/raparin.png" style="height: 80px;float: left;">
                     <h2>بەڕێوبردنی خوێندکاران</h2>   
                        <h5>سیستەمێکی بەڕێوبردنی خوێندکارانی ئۆنلاینە...</h5>
                    </div>
                </div> 
                 <!-- /. ROW  -->
                  <hr />
                <?php if($das==2 OR $das==1){ ?>             
                <div class="row index">
                <div class="col-md-3 col-sm-6 col-xs-6">           
            <div class="panel panel-back noti-box">
                <span class="icon-box bg-color-red set-icon">
                    <i class="fa fa icon-student"></i>
                </span>
                <div class="text-box" >
                    <a href="student.php"><p class="main-text">خوێندکاران</p>
                    <?php if($das==1){ ?><h6 class="text-muted">خوێندکاران و ڕێکخستنیان</h6><?php } ?>
                </a></div>
             </div>
             </div>
                    <div class="col-md-3 col-sm-6 col-xs-6">           
            <div class="panel panel-back noti-box">
                <span class="icon-box bg-color-green set-icon">
                    <i class="fa fa icon-teacher"></i>
                </span>
                <div class="text-box" >
                    <a href="teacher.php"><p class="main-text">مامۆستایان</p>
                    <?php if($das==1){ ?><h6 class="text-muted">مامۆستایان و ڕێکخستنیان</h6><?php } ?>
                </a></div>
             </div>
             </div>
            <div class="col-md-3 col-sm-6 col-xs-6">           
            <div class="panel panel-back noti-box">
                <span class="icon-box bg-color-blue set-icon">
                    <i class="fa icon-subject"></i>
                </span>
                <div class="text-box" >
                    <a href="subject.php"><p class="main-text">وانەکان</p>
                    <?php if($das==1){ ?><h6 class="text-muted">وانەکان و ڕێکخستنیان</h6><?php } ?>
                </a></div>
             </div>
             </div>
            <div class="col-md-3 col-sm-6 col-xs-6">           
            <div class="panel panel-back noti-box">
                <span class="icon-box bg-color-brown set-icon">
                    <i class="fa icon-markpercentage"></i>
                </span>
                <div class="text-box" >
                    <a href="exam.php"><p class="main-text">تاقیکردنەوەکان</p>
                    <?php if($das==1){ ?><h6 class="text-muted">تاقیکردنەوەکان و ڕێکخستنیان</h6><?php } ?>
                </a></div>
             </div>
             </div>
            </div>
            <hr>
            <?php }}} ?>
                 <!-- /. ROW  -->
            <?php if ($das==2 OR $das==3) { ?>
            <div class="row">
              <div class="col-md-8">           
                <div class="panel panel-back noti-box">
                  <span class="icon-box bg-color-blue">
                  <i class="fa icon-noticemain"></i>
                  </span>
                  <div class="text-box">
                  <p class="main-text">ئاگادارکردنەوەکان</p>
                  <p class="main-text"></p>
                  
                  <?php $n=0;
                  if ($das==3) {$n=0;
                    if(ndb("att","user='$un' AND re='3'")>=2){$n++;
                    ?>

<?php
                    $stm = $db->prepare("SELECT * FROM stu WHERE user= '$un'");
                    $stm->execute();
                    $fetch = $stm->fetch(PDO::FETCH_OBJ);
                    $pcl = $fetch->class;

$subQ = $db->prepare("SELECT * FROM sub WHERE cl = '$pcl'");// OR CURDATE()=dt");
$subQ->execute();
$subRow = $subQ->rowCount();
  if($subRow > 0){
    while($Srow = $subQ->fetch(PDO::FETCH_ASSOC)) {

// Get attendance
$sub=$Srow['id'];
$atte=$Srow['atte'];
$name=$Srow['sn'];
$atteQ = $db->prepare("SELECT * FROM att WHERE user='$un' AND sub_id= '$sub' AND re=3");// OR CURDATE()=dt");
$atteQ->execute();
$subRow = $atteQ->rowCount();
$total=0;
  if($subRow > 0){
    while($Arow = $atteQ->fetch(PDO::FETCH_ASSOC)) {
      @$total=$total+($Arow['etm']-$Arow['tm']);
    }
  }

    }
  }

if ($atte <= $total) { ?>
<hr>
    <p class="text-muted" style="height: auto;overflow: auto;">
    <span class="text-muted color-bottom-txt" style="color: red;"><i class="fa icon-attendance"></i>
    <b>دوا مۆڵەتی نەهاتنت تێپەڕاند لەوانەی (<?=$name;?>) :</b>
      خوێندکاری خۆشەویست ئاگادار بە، ئامادەنەبوونت دواوادەی تێپەڕاندووە کۆی ئامادەنەبونت <?=$total;?> کاتژمێرە دوا وادەی نەهاتنت لەم وانەیە <?=$atte;?> کاتژمێرە.                        </span>
    <span style="float: left;color: #000;font-size: 10px;direction: ltr;"><i class="fa fa-clock-o"></i> <?=date("Y-m-d")?></span>
    </p>

<?php
}elseif($atte/2 <= $total){
?>

    <p class="text-muted" style="height: auto;overflow: auto;">
    <span class="text-muted color-bottom-txt" style="color: red;"><i class="fa icon-attendance"></i>
    <b>نیوەی دوا مۆڵەتی نەهاتنت تێپەڕاند لەوانەی (<?=$name;?>) :</b>
      خوێندکاری خۆشەویست ئاگادار بە، ئامادەنەبوونت زۆرە لەم وانەیە کۆی ئامادەنەبونت <?=$total;?> کاتژمێرە دوا وادەی نەهاتنت لەم وانەیە <?=$atte;?> کاتژمێرە.                        </span>
    <span style="float: left;color: #000;font-size: 10px;direction: ltr;"><i class="fa fa-clock-o"></i> <?=date("Y-m-d")?></span>
    </p>

<?php
}
?>

                        <hr style="margin: 10px 0 10px 0;">
                    <?php }

                    ///////////////
                    $stm1 = $db->prepare("SELECT * FROM notic WHERE r=3 AND NOW() BETWEEN dt AND dtt ORDER BY id DESC");// OR CURDATE()=dt");
                    $stm1->execute();
                    $rowCount = $stm1->rowCount();

                    if($rowCount > 0){
                     while($row = $stm1->fetch(PDO::FETCH_ASSOC)) {
                      if($pcl==$row['cl'] OR $row['cl']==0){ ?>
                      <p class="text-muted">
                        <span class="text-muted color-bottom-txt"><i class="fa fa-bell-o"></i>
                        <b><?=$row['title'];?> :</b>
                          <?=$row['notic'];?>
                        </span>
                        <span style="float: left;color: #000;font-size: 10px;direction: ltr;"><i class="fa fa-clock-o"></i> <?=$row['dt'];?> - <?=$row['dtt'];?></span>
                        </p>
                        <hr style="margin: 10px 0 10px 0;">
                      <?php 
                      }else {
                      
                    }
                    $n++;
                    }
                  } 
                    
                  }
                  if ($das==2) {
                    $n=0;
                    $stm1 = $db->prepare("SELECT * FROM notic WHERE NOW() BETWEEN dt AND dtt ORDER BY id ASC");// OR CURDATE()=dt");
                    $stm1->execute();
                    $rowCount = $stm1->rowCount();

                    if($rowCount > 0){
                     while($row = $stm1->fetch(PDO::FETCH_ASSOC)) { ?>
                      <p class="text-muted">
                        <span class="text-muted color-bottom-txt"><i class="fa fa-bell-o"></i>
                        <b><?=$row['title'];?> :</b>
                          <?=$row['notic'];?>
                        </span>
                        <span style="float: left;color: #000;font-size: 10px;direction: ltr;"><i class="fa fa-clock-o"></i> <?=$row['dt'];?> - <?=$row['dtt'];?></span>
                        </p>
                        <hr style="margin: 10px 0 10px 0;">
                      <?php 
                      $n++;
                      }
                    }
                    
                  }
                    ?>
                    <p class="text-muted"> ئێستا <?=$n;?> ئاگادارکردنەوەت هەیە</p>
                  </div>
                </div>
              </div>
              <?php if ($das==2) { ?>
              <div class="col-md-4">
                    <div class="panel panel-primary text-center no-boder bg-color-green">
                        <div class="panel-body">
                            <i class="fa icon-student fa-5x"></i>
                            <h3><?php echo ndb("tea,sub,stu","tea.id=sub.tea AND sub.cl=stu.class AND tea.user='$un'"); ?> خوێندکار</h3>
                        </div>
                        <div class="panel-footer back-footer-green">
                           کۆی خوێندکاران <?php echo ndb("stu","1=1");?>
                            
                        </div>
                    </div>
              </div>
              <?php } if ($das==3) { ?>
              <div class="col-md-4">
                    <div class="panel panel-primary text-center no-boder bg-color-green">
                        <div class="panel-body">
                            <i class="fa icon-teacher fa-5x"></i>
                            <h3><?php echo ndb("tea,sub,stu","tea.id=sub.tea AND sub.cl=stu.class AND stu.user='$un'"); ?> مامۆستا</h3>
                        </div>
                        <div class="panel-footer back-footer-green">
                           کۆی مامۆستای قۆناغە جیاوازەکان <?php echo ndb("tea","1=1");?>
                            
                        </div>
                    </div>
                    <div class="panel panel-primary text-center no-boder bg-color-red">
                        <div class="panel-body">
                            <i class="fa icon-attendance fa-5x"></i>
                            <h3>کۆی ئامادەنەبونت لەهەموو وانەکان <?php echo ndb("att","user='$un' AND re='3'"); ?> کاتژمێرە</h3>
                        </div>
                        <div class="panel-footer back-footer-red">
                          تکایە ئاگاداری بەشی (ئاماری ئامادەبوونم)بە بۆ ئەوەی ڕێژەی یاسایی تێنەپەڕێنیت
                        </div>
                    </div>                         
              </div>
              <?php } ?>
            </div>
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


<?php
$db = null;
 include 'inc/foot.php'; ?>