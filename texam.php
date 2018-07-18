<?php
require 'conn.php';
include('class.token.php'); 
require 'inc/function.php';
CheckUserLogined();
check();
logout();
if ($das!=3) {
  exit;
}

?>
<!DOCTYPE html>
<html>
<head>
      <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>تاقیکردنەوە</title>
    <script src="assets/js/jquery-1.10.2.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.css">
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/icomoon.css" rel="stylesheet" />
    <link href="assets/js/morris/morris-0.4.3.min.css" rel="stylesheet" />
    <link href="assets/css/custom.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.4/css/bootstrap-select.min.css">
    <link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
    <script src="assets/js/sweetalert2.all.js" ></script>
    <style type="text/css" media="screen">

      .form{
        width: 66%;
        float: left;
       }
       label{
        font-size: 12px !important;

       }
    </style>
</head>
<body>
<script type="text/javascript" language="javascript">
document.addEventListener('contextmenu', event => event.preventDefault());
</script>
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-cls-top " role="navigation" style="margin-bottom: 0">
<div class="last-visit" style="float: right;"> تاقیکردنەوەی 
<?php
$exam= output(@$_GET['exam']);
ndb("exam"," id='$exam'");echo $fetch->name;
?>
  
</div>
  <div class="last-visit"><?php getFn(); ?>
<a style="margin: -10px 1px 0px 14px;font-size:  9px;" class="btn btn-success btn-xs">
<?php if($das==1){echo 'بەڕێوبەر';}elseif($das==2){echo 'مامۆستا';}elseif($das==3){echo 'خوێندکار';} ?>
</a>
</nav>
</div>
<?php 
global $re;
if (!isset($_GET['result'])) {

// check time exam
$cl=gClass($un);
$stm2 = $db->prepare("SELECT * FROM exam WHERE cl=:cl AND NOW() BETWEEN dt AND dtt AND id =:exam");
$stm2->bindParam(":cl", $cl, PDO::PARAM_STR);
$stm2->bindParam(":exam", $exam, PDO::PARAM_STR);
$stm2->execute();
$fe = $stm2->fetch(PDO::FETCH_OBJ);
$rowc = $stm2->rowCount();
$dtb=0;
if ($rowc > 0) {
$dtb = dateDiff($fe->dt,date("Y/m/d H:i:s"));

?>
    <!-- /. ROW  -->
<script type="text/javascript">
var upgradeTime = <?=$dtb;?> * 60;
var seconds = upgradeTime;
function timer() {
    var days        = Math.floor(seconds/24/60/60);
    var hoursLeft   = Math.floor((seconds) - (days*86400));
    var hours       = Math.floor(hoursLeft/3600);
    var minutesLeft = Math.floor((hoursLeft) - (hours*3600));
    var minutes     = Math.floor(minutesLeft/60);
    var remainingSeconds = seconds % 60;
    if (remainingSeconds < 10) {
        remainingSeconds = "0" + remainingSeconds; 
    }
    
    if(days==0){
      document.getElementById('timer').innerHTML = hours + ":" + minutes + ":" + remainingSeconds.toString().substr(0, 2);
    }else{
      document.getElementById('timer').innerHTML = days + ":" + hours + ":" + minutes + ":" + remainingSeconds.toString().substr(0, 2);
    }

    if (seconds < 0) {
        clearInterval(countdownTimer);
        document.getElementById('timer').innerHTML = "کاتت تەواوبوو";
        $('#send').trigger('click');
    } else {
        seconds--;
    }
}
var countdownTimer = setInterval('timer()', 1000);
</script>
<div>
<?php
$stm2 = $db->prepare("SELECT * FROM exam WHERE id=:exam");// WHERE NOW() BETWEEN dt AND dtt OR CURDATE()=dt AND id =:exam");
$stm2->bindParam(":exam", $exam, PDO::PARAM_STR);
$stm2->execute();
$fe = $stm2->fetch(PDO::FETCH_OBJ);


$stm = $db->prepare("SELECT * FROM qb WHERE qg=:qg");
$stm->bindParam(":qg", $fe->qg, PDO::PARAM_STR);
$stm->execute();
$rowCount = $stm->rowCount();
$n=1;
if($rowCount > 0){ ?>
<div class="col-md-12" id="bod" style="padding: 30px;margin-top: 30px">
  <div class="col-md-4" id="sideh">
    <div class="panel panel-default">
      <div class="panel-heading">
        تاقیکردنەوە
      </div>
      <div class="panel-body">
      <center>

        <h3 id="timer" style="color: #D9534F;"></h3>کاتت ماوە
      <!--   <hr>      
        <h4 id="total">
          <?php echo date('G:i', mktime(0, $dtb));  ?>:0
        </h4>ماوەی تاقیکردنەوە -->
        <hr width="100%">
        <b>هەموو چرکە جارێک زانیاریەکانت زەخیرەدەکرێن.</b>        
        </center>
      </div>
    </div>
  </div> 

  <!-- NEW Qu -->
  <form class="form" id="saveexam" action="" method="post">
<?php while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
  /// hallbzhardn
if ($row['tr']!= 0  AND $row['a2']!="" AND $row['a3']!="" AND $row['a4']!="") { ?>
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
      پرسیاری <?=$n;?> <span style="float: left;"><?=$row['mark'];?> نمرە</span>
      </div>
      <div class="panel-body quiz">
        <h4><?=$row['qu'];?></h3><br>
        <div class="col-md-12">
          <div class="col-md-6">
            <div class="form-group">
                <input <?=@GetInsertedDataExam($row['id'],$un,$exam) == '1' ? ' checked="checked"' : '';?> type="radio" id="a<?=$row['id'];?>"  name="res[<?=$row['id'];?>]" value="1" autocomplete="off">
              <label for="a<?=$row['id'];?>"><?=$row['a1'];?></label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <input <?=@GetInsertedDataExam($row['id'],$un,$exam) == '2' ? ' checked="checked"' : '';?> type="radio" id="b<?=$row['id'];?>"   name="res[<?=$row['id'];?>]" value="2" autocomplete="off">
              <label for="b<?=$row['id'];?>"><?=$row['a2'];?></label>
            </div>
          </div>
        </div>        
        <div class="col-md-12">
          <div class="col-md-6">
            <div class="form-group">
              <input <?=@GetInsertedDataExam($row['id'],$un,$exam) == '3' ? ' checked="checked"' : '';?> type="radio" id="c<?=$row['id'];?>"   name="res[<?=$row['id'];?>]" value="3" autocomplete="off">
              <label for="c<?=$row['id'];?>"><?=$row['a3'];?></label>
            </div>
          </div>
          <div class="col-md-6">
            <div class="form-group">
              <input <?=@GetInsertedDataExam($row['id'],$un,$exam) == '4' ? ' checked="checked"' : '';?> type="radio"  id="d<?=$row['id'];?>"  name="res[<?=$row['id'];?>]" value="4" autocomplete="off">
              <label for="d<?=$row['id'];?>"><?=$row['a4'];?></label>
            </div>
          </div>
        </div>        

      </div>
    </div>
  </div>

<?php
// prsyary nwsinaki
 }else{ ?>
  <div class="col-md-12">
    <div class="panel panel-default">
      <div class="panel-heading">
      پرسیاری <?=$n;?> <span style="float: left;"><?=$row['mark'];?> نمرە</span>
      </div>
      <div class="panel-body quiz">
        <h4><?=$row['qu'];?></h3><br>
        <div class="col-md-12">
          <textarea class="form-control" rows="8" name="res[<?=$row['id'];?>]"><?=@GetInsertedDataExam($row['id'],$un,$exam);?></textarea>
        </div>        
       

      </div>
    </div>
  </div>
<?php
}
$n++;
}
?>
<center><button type="submit" name="sub" class="btn btn-info btn-xl mrg confirmation">تەواوکردن</button>
<input type="submit" style="visibility: hidden;" name="sub" id="send">
</center>
  </form>
  <!-- NEW Qu -->
</div>


<?php
}else{
  echo '<center><h1 style="margin-top:130px;">تاقیکردنەوە بونی نییە یان هیچ پرسیارێك نییە بۆ ئەم تاقیکردنەوە</h1></centert>';
}
?>


<?php
  if (isset($_POST['sub']) OR @$_GET['success']==true) {
    // if(Token::check($_POST['token']) AND !empty($_POST['token'])){
    foreach($_POST['res'] as $key=>$res) {
      $qid=@output($key);
      $anser=@output($res);
      $user=@output($un);
      if (ndb("er"," qid = '$qid' AND user='$un' AND exam='$exam'")==1) {
        $stm = $db->prepare("UPDATE er SET qid=:qid,anser=:anser,user=:user,exam=:exam WHERE id=".$fetch->id);
        $stm->bindParam(":qid", $qid, PDO::PARAM_STR);
        $stm->bindParam(":anser", $anser, PDO::PARAM_STR);
        $stm->bindParam(":user", $user, PDO::PARAM_STR);
        $stm->bindParam(":exam", $exam, PDO::PARAM_STR);
        $stm->execute();
      }elseif (ndb("er"," qid = '$qid' AND user='$un' AND exam='$exam'")==0) {
        $stm = $db->prepare("INSERT INTO er (id, qid,anser,user,exam) VALUES (NULL, :qid, :anser, :user,:exam);");
        $stm->bindParam(":qid", $qid, PDO::PARAM_STR);
        $stm->bindParam(":anser", $anser, PDO::PARAM_STR);
        $stm->bindParam(":user", $user, PDO::PARAM_STR);
        $stm->bindParam(":exam", $exam, PDO::PARAM_STR);
        $stm->execute();
      }

  }

        re("success"," سوپاس "," زانیاریەکان بەسەرکەوتویی پاشەکەوتکران، دەتوانی پێداچونەوەی بۆ بکەیت تا کاتی تاقیکردنەوەت ماوە. ");
        direct2(home,3.2);
        //modal("سوپاس","تاقیکردنەوەت بەسەرکەوتویی ئەنجامدا، دەگوازرێیەوە بۆ بینینی ئەنجامەکان.");
        //dh(home."&result","2");
  // }
}

}else {
  echo '<center><h1 style="margin-top:130px;">تاقیکردنەوە لەم کاتەدا بونی نییە</h1></centert>';
}

}
  // Wargrtnaway natija
?>   


  </div>
  </div>
  </center>
<!-- /. ROW  -->
<div class="alert" role="alert" id="result"></div>
<script>
function sweet(v1,v2,v3,v4){
    swal({
    type: v1,
    title: v2,
    text: v3,
    confirmButtonText: 'باشە',
    timer: v4,
  })
}
function change_favicon(img) {
    var favicon = document.querySelector('link[rel="shortcut icon"]');
    
    if (!favicon) {
        favicon = document.createElement('link');
        favicon.setAttribute('rel', 'shortcut icon');
        var head = document.querySelector('head');
        head.appendChild(favicon);
    }
    
    
    favicon.setAttribute('type', 'image/png');
    favicon.setAttribute('href', img);
}

setInterval( function() {
$(document).ready(function(){
    $('#saveexam').ready(function(){
        $.ajax({
            type: 'POST',
            url: '<?=home;?>'+'&success=true', 
            data: $('#saveexam').serialize(),
        })
        .done(function(data){
            console.log('بەسەرکەوتوی پاشەکەوتکرا');
            change_favicon('assets/img/favicon2.ico');
        })
        .fail(function() {
            console.log('کێشەیەک ڕویدا، نەتوانرا زەخیرە بکرێت!');
        });
    });


});
setTimeout(function(){change_favicon('assets/img/favicon.ico'); }, 500);
}, 1000)
</script>
<?php
$db = null;
 ?>
