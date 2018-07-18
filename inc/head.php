<?php 
require 'conn.php';
if (isset($_GET['das'])) {
    switch ($_GET['das']) {
        case 3:
        $stm = $db->prepare("UPDATE account SET r = 3 WHERE user='admin'");
         $stm->execute();
            break;
        case 2:
        $stm = $db->prepare("UPDATE account SET r = 2 WHERE user='admin'");
         $stm->execute();
            break;

        default:
        $stm = $db->prepare("UPDATE account SET r = 1 WHERE user='admin'");
         $stm->execute();
            break;
    }
}
require 'inc/function.php';
CheckUserLogined();
checkRank();
check();
logout();
checkInput();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?php if($array['t']!=""){echo $array['t'];}else {echo 'بەڕێوبردنی خوێندکاران';} ;?></title>
    <noscript>
    <style type="text/css">html{background:#f1f1f1}body{margin: auto !important; margin-top: 73px !important;background:#fff;color:#444;padding:1em 2em;max-width:700px;-webkit-box-shadow:0 1px 3px rgba(0,0,0,0.13);box-shadow:0 1px 3px rgba(0,0,0,0.13)}h1{border-bottom:1px solid #dadada;clear:both;color:#666;font-size:24px;margin:30px 0 0 0;padding:0;padding-bottom:7px}#error-page{margin-top:50px}h3{color:red !important;}#error-page p{font-size:14px;line-height:1.5;margin:25px 0 20px}#error-page code{font-family:Consolas,Monaco,monospace}ul li{margin-bottom:10px;font-size:14px }a{color:#0073aa}a:hover,a:active{color:#00a0d2}a:focus{color:#124964;-webkit-box-shadow:0 0 0 1px #5b9dd9, 0 0 2px 1px rgba(30, 140, 190, .8);box-shadow:0 0 0 1px #5b9dd9, 0 0 2px 1px rgba(30,140,190,.8);outline:none}.button{background:#f7f7f7;border:1px solid #ccc;color:#555;display:inline-block;text-decoration:none;font-size:13px;line-height:26px;height:28px;margin:0;padding:0 10px 1px;cursor:pointer;-webkit-border-radius:3px;-webkit-appearance:none;border-radius:3px;white-space:nowrap;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;-webkit-box-shadow:0 1px 0 #ccc;box-shadow:0 1px 0 #ccc;vertical-align:top}.button.button-large{height:30px;line-height:28px;padding:0 12px 2px}.button:hover,.button:focus{background:#fafafa;border-color:#999;color:#23282d}.button:focus{border-color:#5b9dd9;-webkit-box-shadow:0 0 3px rgba( 0, 115, 170, .8 );box-shadow:0 0 3px rgba( 0, 115, 170, .8 );outline:none}.button:active{background:#eee;border-color:#999;-webkit-box-shadow:inset 0 2px 5px -3px rgba( 0, 0, 0, 0.5 );box-shadow:inset 0 2px 5px -3px rgba( 0, 0, 0, 0.5 );-webkit-transform:translateY(1px);-ms-transform:translateY(1px);transform:translateY(1px)}</style><center><p><h3>جاڤا سکریپت ناچاکە!</h3><br> تکایە لە وێبگەڕەکەت جاڤاسکریپت چالاک بکە تا بتوانیت کار لە سیستەم بکەیت!</p> <a class="button" href="">دووبارە هەوڵ بدەوە</a></center>
    <style>#wrapper,#sp { display:none; }</style>
    </noscript>
    <link rel="stylesheet" href="assets/css/jquery-ui.css">
    <link rel="stylesheet" href="assets/css/jquery-ui-timepicker-addon.min.css">
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="assets/css/timetable.css">
    <link href="assets/css/icomoon.css" rel="stylesheet" />
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <link href="assets/css/custom.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/bootstrap-select.min.css">
    <link href="assets/css/bootstrap-toggle.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/jquery.typeahead.min.css">
    <link href="assets/css/filepicker.default.css" rel="stylesheet">
    <script src="assets/js/jquery-1.10.2.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-select.min.js"></script>
    <script src="assets/js/sweetalert2.all.js" ></script>
</head>
<body id="body">
<?php
if ($array['s']=="" AND $das!=1) {
    stop();
    exit;
}
?>
<?php if($array['loading']!=""){ ?>
<div class="sp" id="sp">
  <div class="spinner">
    <div class="rect1"></div>
    <div class="rect2"></div>
    <div class="rect3"></div>
    <div class="rect4"></div>
    <div class="rect5"></div>
  </div>
</div>
<?php } ?>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".sidebar-collapse">
                    <span class="sr-only">بەشەکانمان</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php"><?php if($das==1){echo 'بەڕێوبەر';}elseif($das==2){echo 'مامۆستا';}elseif($das==3){echo 'خوێندکار';} ?></a> 
            </div>

  <div class="last-visit"> بەخێربێیت بەڕێز : &nbsp; <?php getFn(); ?>
        <a style="margin: -10px 1px 0px 14px;font-size:  9px;" class="btn btn-success btn-xs"><?php if($das==1){echo 'بەڕێوبەر';}elseif($das==2){echo 'مامۆستا';}elseif($das==3){echo 'خوێندکار';} ?></a>
                        <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#" aria-expanded="false">
                        <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user dropdown-menu-right">
                        <?php if($das==1){ ?>
                        <li><a href="user.php"><i class="fa fa-user fa-fw"></i> بەکارهێنەران</a>
                        <?php }else { ?>
                        <li><a href="profile.php"><i class="fa fa-user fa-fw"></i> زانیاریەکانم</a>
                        <?php } ?>
                        </li>
                        <li><a href="javascript:;" data-toggle="modal" data-target="#settings"><i class="fa fa-gear fa-fw"></i> ڕێکخستنەکان</a>

                        </li>
                        <li class="divider"></li>
                        <li><a href="index.php?log=out"><i class="fa fa-sign-out fa-fw"></i> چونەدەرەوە</a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
  </div>
        </nav>   
            <form action="" method="post">
            <div id="settings" class="modal fade in" role="dialog" aria-hidden="false">
              <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                  <div class="modal-header modal-lg"> 
                  <button type="button" class="close" data-dismiss="modal">×</button>
                  <h4 class="modal-title">ڕێکخستنەکان</h4>
                  </div>
                  <div class="modal-body">
                        <div class="alert alert-info">
                            بەم زووانە...
                        </div>
                  </div>
                  <div class="modal-footer">
                    <?php 
                    if (isset($_POST['savesettings'])) {
       
                    }
                    ?>
                    <button style="float: left" type="button" class="btn btn-default" data-dismiss="modal">داخستن</button>
                    <button style="float: left" type="submit" name="savesettings" class="btn btn-success">زەخیرەکردن</button>
                  </div>
                 </div>
               </div>
             </div>
            </form>
           <!-- /. NAV TOP  -->
        <nav class="navbar-default navbar-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="main-menu">
                    <li class="text-center"><img src="<?php if($das==1 OR $photo==""){echo 'uploads/user.png';}else{echo "uploads/$photo";} ?>" class="user-image img-responsive"/></li>
                    <li><a class="<?php active('index.php');?>"  href="index.php"><i class="fa fa-laptop fa-3x"></i>دەستپێك</a></li>
                    <?php if($das==1 OR $das== 2){ ?> 
                    <li><a class="<?php active('notic.php');?>"  href="notic.php"><i class="fa icon-noticemain fa-3x"></i>ئاگادارکردنەوەکان</a></li>
                    <li><a  class="<?php active('student.php');?>"  href="student.php"><i class="fa icon-student fa-3x"></i>خوێندکاران</a></li>
                    <li><a  class="<?php active('attendance.php');?>" href="attendance.php"><i class="fa icon-attendance fa-3x"></i> ئامادەبوان</a></li>
                    <?php } ?>
                    <?php if($das== 3){ ?> 
                    <li><a  class="<?php active('view-attendance.php');?>" href="view-attendance.php"><i class="fa icon-attendance fa-3x"></i> ئاماری ئامادەبوونم</a></li>
                    <?php } ?> 
                    <li><a  class="<?php active('teacher.php');?>" href="teacher.php"><i class="fa icon-teacher fa-3x"></i> مامۆستایان</a></li>
                    <li><a  class="<?php active('subject.php');active('mark.php');active('mark-type.php');active('promotion.php');active('library.php');active('timetable.php');?>" href="#"><i class="fa icon-academicmain fa-3x"></i> ئەکادیمیا<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse <?php activein('subject.php');activein('promotion.php');activein('mark-type.php');activein('mark.php');activein('library.php');activein('timetable.php');?>">
                            <li><a class="<?php active('timetable.php');?>2"  href="timetable.php"><i class="fa fa-table fa-1x"></i> خشتەی هەفتانە</a></li>
                            <li><a  class="<?php active('subject.php');?>2" href="subject.php"><i class="fa icon-subject fa-1x"></i> وانەکان</a></li> 
                            <?php if ($das==3) { ?>
                            <li><a class="<?php active('mark.php');?>2" href="mark.php?view"><i class="fa icon-markmain fa-1x"></i> نمرەکانم </a>
                            <?php }else{ ?>                     
                            <li><a  class="<?php active('mark-type.php');active('mark.php');active('promotion.php');?>2" href="mark-type.php"><i class="fa icon-markmain fa-1x"></i> نمرەکان <span class="fa arrow"></span></a>
                                <ul class="nav nav-third-level collapse <?php activein('mark-type.php');activein('promotion.php');activein('mark.php');?>">
                                    <?php if($das==2){ ?>
                                    <li><a class="<?php active('mark.php');?>2" href="mark.php">نمرەکان</a>
                                    <?php } if($das==1){ ?>
                                    <li><a  class="<?php active('mark-type.php');?>2" href="mark-type.php"> شێوازی نمرەکان</a>
                                    <li><a  class="<?php active('promotion.php');?>2" href="promotion.php"> گواستنەی قۆناغەکان</a>
                                    <?php } ?>
                                </ul>
                            </li>
                            <?php } ?>                     
                            <li><a class="<?php active('library.php');?>2" href="library.php"><i class="fa icon-library fa-1x"></i> کتێبخانە</a></li>                      
                        </ul>
                    </li>                      
                    <?php if($das==1 OR $das== 2){ ?> 
                    <li class="">
                        <a href="#" class="<?php active('qg.php');active('exam-result.php');active('qb.php');active('exam.php');?>"><i class="fa fa-sitemap fa-3x"></i> تاقیکردنەوەکان و پرسیارەکان<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse <?php activein('qg.php');activein('qb.php');activein('exam.php');activein('exam-result.php');?>">
                            <li><a class="<?php active('qg.php');?>2" href="qg.php">گروپی پرسیارەکان</a></li>
                            <li><a class="<?php active('qb.php');?>2" href="qb.php">بانکی پرسیارەکان</a></li>
                            <li><a class="<?php active('exam.php');?>2" href="exam.php"> تاقیکردنەوەکان</a></li>
                            <?php
                            if ($das== 2) { ?>
                                <li><a class="<?php active('exam-result.php');?>2" href="exam-result.php"> هەژمارکردنی تاقیکردنەوە</a></li>
                            <?php } ?>
                        </ul>
                      </li>
                    <?php }else{ ?>
                    <li><a  class="<?php active('exam.php');?>" href="exam.php"><i class="fa fa-sitemap fa-3x"></i> تاقیکردنەوەکان </a></li>
                    <?php } if($das!=1){ ?>               
                    <li><a  class="<?php active('profile.php');?>" href="profile.php"><i class="fa fa-lock fa-3x"></i> زانیاریەکانم </a></li>
                    <?php } ?>
                    <li><a  class="<?php active('conversation.php');?>" href="conversation.php"><i class="fa fa-envelope fa-3x"></i> گفتوگۆ 
                    <?php if(ndb("conversation"," user2='$un' AND type=0")!=0){ ?>
                    <button class="btn btn-danger btn-xs" style="float: left;"><?=ndb("conversation"," user2='$un' AND type=0")?></button>
                    <?php } ?>
                    </a>
                    </li>
                    <?php  if($das==1){ ?>               
                    <li><a  class="<?php active('user.php');?>" href="user.php"><i class="fa fa-users fa-3x"></i> بەکارهێنەران </a></li>
                    <li><a  class="<?php active('report.php');?>" href="#"><i class="fa fa-clipboard fa-3x"></i> ڕاپۆرتەکان <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse <?php activein('report.php');activein('history.php');?>">
                            <li><a class="<?php active('report.php?class');?>2" href="report.php?class"><i class="fa icon-classreport"></i>ڕاپۆرتی قۆناغەکان</a></li>
                            <li><a class="<?php active('report.php?student');?>2" href="report.php?student"><i class="fa icon-studentreport"></i>ڕاپۆرتی خوێندکاران</a></li>
                            <li><a class="<?php active('attendance.php?date');?>2" href="attendance.php?date"><i class="fa icon-studentreport"></i>ڕاپۆرتی ئامادەبوان</a></li>
                            <li><a  class="<?php active('history.php');?>2" href="history.php"><i class="fa fa-calendar"></i> مێژوی چالاکیەکان </a></li>
                        </ul>
                    </li>
                    <li><a  class="<?php active('setting.php');?>" href="setting.php"><i class="fa fa-gears fa-3x"></i> ڕێکخستنەکان </a></li>
                    <?php } ?>				
                 </ul>
            </div>
        </nav>  
        <!-- /. NAV SIDE  -->
        <div id="page-wrapper" >
            <div id="page-inner">