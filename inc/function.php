<?php
ob_start();
// error_reporting(0);
date_default_timezone_set('Asia/Baghdad'); 

/*
-----------------------------------
	CREATE EXCEL File
-----------------------------------
*/



/*
-----------------------------------
	END CREATE EXCEL File
-----------------------------------
*/


/*
-----------------------------------
	CSV
-----------------------------------
*/





/*
-----------------------------------
	END CSV
-----------------------------------
*/





/*
-----------------------------------
	General
-----------------------------------
*/

$ur =  explode('/', $_SERVER['REQUEST_URI']) ;
$url = end($ur);
define('home', $url);
define('link', "http://".$_SERVER["HTTP_HOST"].$_SERVER["REQUEST_URI"]);


$flatcolor = ["#f39c12","#d35400","#c0392b","#e74c3c","#e67e22","#f1c40f","#16a085","#27ae60","#2980b9","#8e44ad","#2c3e50","#34495e","#9b59b6","#3498db","#2ecc71","#1abc9c","#bdc3c7","#7f8c8d","#95a5a6","#ecf0f1"];


function gen($data){
	if($data==1){
		$data="نێر";
	}else{
		$data="مێ";
	}
	return $data;
}

// Classess
function classwithString($data){
	if($data==1){
		$data="یەکەم";
	}elseif($data==2){
		$data="دووەم";
	}elseif($data==3){
		$data="سێیەم";
	}elseif($data==4){
		$data="چوارەم";
	}elseif($data==5){
		$data="تەخەروج";
	}

	return $data;
}
function r($data){
	if($data==3){
		$data="خوێندکار";
	}elseif($data==2){
		$data="مامۆستا";
	}else{
		$data="بەڕێوبەر";
	}
	return $data;
}

//Type mark

function typeMark($data){
	if($data==1){
		$data="ڕۆژانە";
	}elseif($data==2){
		$data="تاقیکردنەوەی مانگی یەکەم";
	}elseif($data==3){
		$data="تاقیکردنەوەی مانگی دووەم";
	}elseif($data==4){
		$data="تاقیکردنەوەی کۆتایی";
	}
	return $data;
}


function ph($d){
	return password_hash($d, PASSWORD_BCRYPT);
}

function rn($d1) {
    if($d1==""){$d1=8;}
    $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $d1; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}

function clean($string) {
return trim(preg_replace('/\s+/', ' ', $string));
}

function dateDiff($time1, $time2, $precision = 6) {
$to_time = strtotime($time1);
$from_time = strtotime($time2);
return round(abs($to_time - $from_time) / 60,2);
}

function day($d){
	switch ($d) {
		case $d==1:
			$d="شەممە";
			break;
		case $d==2:
			$d="یەک شەممە";
			break;
		case $d==3:
			$d="دوو شەممە";
			break;
		case $d==4:
			$d="سێ شەممە";
			break;
		case $d==5:
			$d="چوار شەممە";
			break;

	}
	return $d;
}

function Astakan($data){
      if ($data < 50) {
        $data = '<font color="red">دەرنەچووە</font>';
      }elseif ($data >= 50 AND $data < 60){
        $data = 'پەسەند';
      }elseif ($data >= 60 AND $data < 70){
        $data = 'ناوەند';
      }elseif ($data >= 70 AND $data < 80){
        $data = 'باشە';
      }elseif ($data >= 80 AND $data < 90){
        $data = 'زۆرباشە';
      }elseif ($data >= 90 AND $data <= 100){
        $data = 'نایاب';
      }else{
        $data='';
      }

  return $data;
}

function stop(){ ?>
<div style="display: block;width: 100%;margin-top: 200px">
	<center>
		<h1>سیستەم <font color="red">ناچالاکە</font> تکایە کاتێکی تر سەردانمان بکەوە!</h1>
	</center>
</div>
</body>
</html>
<?php }

/*
-----------------------------------
	END General
-----------------------------------
*/

/*
-----------------------------------
	Checking 
-----------------------------------
*/

function check(){
	$co = output($_COOKIE[sha1('code')]);
	if( !isset($co) OR $co =="" ){ header('Location: login.php'); exit; }
}

function user($data){
	global $db;
	$user= output($data);
	$stm = $db->prepare("SELECT * FROM account WHERE user=:user");
	$stm->bindParam(":user", $user, PDO::PARAM_STR);
	$stm->execute();
	$fetch = $stm->fetch(PDO::FETCH_OBJ);
	$rowCount = $stm->rowCount();
	return $rowCount;
}


function checkp($d1,$d2){
	$p = false;
	if(password_verify($d1, $d2)){
		$p = true;
	}
	return $p;
}

function CheckUserLogined(){
	global $db,$das,$un,$photo,$class;
      $code = @$_COOKIE[sha1('code')];
      $stm = $db->prepare("SELECT fname,token,r,user FROM account WHERE token=:code");
      $stm->bindParam(":code", $code, PDO::PARAM_STR);
      $stm->execute();
      $fetch = $stm->fetch(PDO::FETCH_OBJ);
      $rowCount = $stm->rowCount();
      if($rowCount > 0){
      	 $das=$fetch->r;
      	 $un=$fetch->user;
      	 $photo="";
      	 if ($das==3) {
      	 	$stm = $db->prepare("SELECT img,user FROM stu WHERE user='$un'");
			$stm->execute();
			$fetch = $stm->fetch(PDO::FETCH_OBJ);
			$photo =$fetch->img;
      	 }      	 
      	 if ($das==2) {
      	 	$stm = $db->prepare("SELECT img,user FROM tea WHERE user='$un'");
			$stm->execute();
			$fetch = $stm->fetch(PDO::FETCH_OBJ);
			$photo =$fetch->img;
      	 }
      }else {
      	global $db;
	    //Reset user code
	    $code= output($_COOKIE[sha1('code')]);
	    $stm = $db->prepare("UPDATE account SET token='' WHERE token=:code");
	    $stm->bindParam(":code", $code, PDO::PARAM_STR);
	    $stm->execute();
	    unset($_COOKIE[sha1('code')]);
	    setcookie(sha1('code'), null, time() - (86400 * 30 * 1), '/');
	    header("Location: login.php");
	    exit;
      }

// Check Rank User

}

function checkInput(){
	global $db,$array,$feilds;
		$feilds=$array=array();
        for ($i = 1; $i <= 2 ; $i++) {
          if ($i==1) {
            $stm1 = $db->prepare("SELECT * FROM setting WHERE id=1");
            $stm1->execute();
            $fetch = $stm1->fetch(PDO::FETCH_OBJ);
            $array = unserialize(stripslashes($fetch->slug));
          }else{
            $stm1 = $db->prepare("SELECT * FROM setting WHERE id=2");
            $stm1->execute();
            $fetch = $stm1->fetch(PDO::FETCH_OBJ);
            $feilds = unserialize(stripslashes($fetch->slug));
          }
      }
}

function checkRank(){
	global $das;
	$url=home;
	$check=0;
	if ($url=="") {
		$url="index.php";
	}

	if($das==3) {
		$link = array("mark.php?view","index.php","teacher.php","profile.php","index.php?log=out","subject.php","library.php","library.php?id","exam.php","view-attendance.php");
		foreach ($link as $value) {
			if ($url==$value OR preg_match("/texam.php/",$url) OR preg_match("/conversation.php/",$url) OR preg_match("/timetable.php/",$url)){
				$check=1;
			}
		}
		if ($check!=1) {
			dh("index.php");
			exit;
		}

	}
}

/*
-----------------------------------
	END Checking 
-----------------------------------
*/


function logout(){
	$log = output(@$_GET['log']);
	if(isset($log) && $log == 'out'){
		global $db;
	    //Reset user code
	    $code= output($_COOKIE[sha1('code')]);
	    $stm = $db->prepare("UPDATE account SET token='' WHERE token=:code");
	    $stm->bindParam(":code", $code, PDO::PARAM_STR);
	    $stm->execute();
	    unset($_COOKIE[sha1('code')]);
	    setcookie(sha1('code'), null, time() - (86400 * 30 * 1), '/');
	    header("Location: login.php");
	    exit;
	}
}

/*
-----------------------------------
	Design.............. 
-----------------------------------
*/

function active($currect_page){
  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
  $url = end($url_array);
  if ($url=="") {
    	$url = "index.php";
    }  
  if (strpos($url,$currect_page)!== false OR $currect_page==$url){
      echo 'active-menu'; //class name in css 
  }

}
function activein($currect_page){
  $url_array =  explode('/', $_SERVER['REQUEST_URI']) ;
  $url = end($url_array);
  if ($url=="") {
    	$url = "index.php";
    }  
  if (preg_match("/$currect_page/",$url)){
      echo 'in'; //class name in css 
  }

}

function e4(){
	echo '<br><h4>هیچ ئەنجامێك نەدۆزرایەوە!</h4>';
}

function re($d1,$d2,$d3){
	if ($d1=="danger") {
		$d1="error";
	}
	echo "<script>setTimeout(function(){
	  swal({
	  type: '$d1',
	  title: '$d2',
	  text: '$d3',
	  confirmButtonText: 'باشە',
	  timer: 2500,
	})
	},800)</script>";

	//echo '<br><div id="alert" class="alert alert-'.$d1.' alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><a href="#" class="alert-link">'.$d2.'</a>'.$d3.'</div>';
}
function mul($d1){ ?>
		<table style="direction: ltr !important;" id="advance2" class="table table-striped table-bordered table-hover">
  <thead>
    <tr>
      <th style="text-align: left !important;" width="200px">Username</th>
      <th style="text-align: left !important;" width="200px">Password</th>
      <th style="text-align: left !important;" width="200px">Result</th>
    </tr>
  </thead>
  <tbody>
<?=$d1;?>
  </tbody>
</table>

<?php
}

function bl($data,$d2){
	global $fetch;
	echo $fetch->$d2 == $data ? ' selected="selected"' : '';
}
function va($data,$d2){
	echo $d2 == $data ? ' selected="selected"' : '';
}

function modal($data,$d2){
?>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?=$data;?></h4>
      </div>
      <div class="modal-body">
        <p><?=$d2;?></p>
      </div>
    </div>
  </div>
</div>
<?php
}

function checkatt($d){
	global $f1,$row;
  if(@$f1->user==@$row['user']){
        if(@$f1->re==$d){
          echo 'checked="checked"';
        }
}
}
function checkattl($d){
	global $f1,$row;
  if(@$f1->user==@$row['user']){
        if(@$f1->re==$d){
          echo ' active';
        }
}

}

function cl($d){
	if($d==1){
		echo 'A';
	}elseif($d==2){
		echo 'B';
	}elseif($d==3){
		echo 'C';
	}elseif($d==4){
		echo 'D';
	}elseif($d==0){
		echo 'هەموو گروپەکان';
	}
}

function checka($d,$d1){
	if(@$d==$d1){
	  echo 'checked="checked"';
	}
}
/*
-----------------------------------
	END Design.............. 
-----------------------------------
*/



/*
-----------------------------------
	Direct 
-----------------------------------
*/

function direct($data){
	echo '<meta http-equiv="refresh" content="1; url='.$data.'">';
}
function direct2($data,$d2){
	echo '<meta http-equiv="refresh" content="'.$d2.'; url='.$data.'">';
}
function dh($data){
	header('Location: '.$data);
	ob_end_flush();
	exit;
}


/*
-----------------------------------
	END Direct 
-----------------------------------
*/


/*
-----------------------------------
	Geting Data 
-----------------------------------
*/

function tea($id){
	global $db;
	$id= output($id);
	$stm = $db->prepare("SELECT * FROM tea WHERE id=:id");
	$stm->bindParam(":id", $id, PDO::PARAM_STR);
	$stm->execute();
	$fetch = $stm->fetch(PDO::FETCH_OBJ);
	return $fetch->fname;
}

function att($user,$sub,$dt,$dtt){
	global $db;
	$user= output($user);
	$sub= output($sub);
	$dt= output($dt);
	$dtt= output($dtt);
	$stm = $db->prepare("SELECT * FROM att WHERE user='$user' AND sub_id='$sub' AND (dt BETWEEN '$dt' AND '$dtt');");
	$stm->execute();
	return $stm->rowCount();
}

function sub($id){
	global $db;
	$id= output($id);
	$stm = $db->prepare("SELECT * FROM sub WHERE id=:id");
	$stm->bindParam(":id", $id, PDO::PARAM_STR);
	$stm->execute();
	$fetch = $stm->fetch(PDO::FETCH_OBJ);
	return $fetch->sn;
}

function qg($id){
	global $db;
	$id= output($id);
	$stm = $db->prepare("SELECT * FROM qg WHERE id=:id");
	$stm->bindParam(":id", $id, PDO::PARAM_STR);
	$stm->execute();
	$fetch = $stm->fetch(PDO::FETCH_OBJ);
	return $fetch->name;
}

function tea_f($d){
	global $db,$fetch;
	$stm = $db->prepare("SELECT * FROM tea");
	$stm->execute();
	$rowCount = $stm->rowCount();
	if ($rowCount>0) {
		while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
			echo '<option ';
			if($d==1){bl($row['id'],"tea");}
			echo ' value="'.$row['id'].'">'.$row['fname'].'</option>';
		}
	}
	
}

function sub_f($d){
	global $db,$fetch,$sub;
	$d=output($d);
	$stm = $db->prepare("SELECT * FROM sub WHERE cl=".$d);
	$stm->execute();
	$rowCount = $stm->rowCount();
	if ($rowCount>0) {
		while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
			echo '<option ';
			va($sub,$row['id']);
			echo ' value="'.$row['id'].'">'.$row['sn'].'</option>';
		}
	}
	
}

function qg_f(){
	global $db,$fetch;
	$stm = $db->prepare("SELECT * FROM qg");//WHERE cl=1");
	$stm->execute();
	$rowCount = $stm->rowCount();
	if ($rowCount>0) {
		while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
			echo '<option ';
			echo ' value="'.$row['id'].'">'.$row['name'].'</option>';
		}
	}
	
}

function qg_f1(){
	global $db,$fetch;
	$stm = $db->prepare("SELECT * FROM qg");//WHERE cl=1");
	$stm->execute();
	$rowCount = $stm->rowCount();
	if ($rowCount>0) {
		while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
			echo '<option ';
			va($row['id'],$fetch->qg); echo ' value="'.$row['id'].'">'.$row['name'].'</option>';
		}
	}
	
}

function qb($da){
	global $db,$fetch,$das,$un;
	$stm = $db->prepare("SELECT * FROM qg");//WHERE cl=1");
	$stm->execute();
	$rowCount = $stm->rowCount();
	if ($rowCount>0) {
		while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
			if ($das==1 OR ($das==2 AND $un==$row['user'])) {
				echo '<option ';
				va($row['id'],$da); echo ' value="'.$row['id'].'">'.$row['name'].'</option>';
			}
		}
	}
	
}

function su_f1(){
	global $db;
	$stm = $db->prepare("SELECT * FROM sub");//WHERE cl=1");
	$stm->execute();
	$rowCount = $stm->rowCount();
	if ($rowCount>0) {
		while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
				$stm1 = $db->prepare("SELECT * FROM qg WHERE id=:id");
				$stm1->bindParam(":id", $row['id'], PDO::PARAM_STR);
				$stm1->execute();
                $fetch1 = $stm1->fetch(PDO::FETCH_OBJ);
                $rowCount1 = $stm1->rowCount();
				
			echo '<option ';
			if ($rowCount1>0) {
				va($row['id'],$fetch1->id);
			}
			 echo 'value="'.$row['id'].'">'.$row['sn'].' (قۆناغی '.$row['cl'].')'.'</option>';
		
	}
	}
	
}

function selectsub($d){
	global $db;
	$stm = $db->prepare("SELECT * FROM sub");//WHERE cl=1");
	$stm->execute();
	$rowCount = $stm->rowCount();
	if ($rowCount>0) {
		while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
			echo '<option ';
				 if($d==$row['id'])echo 'selected ';;
			 echo 'value="'.$row['id'].'">'.$row['sn'].'</option>';
		
	}
	}
}

function getSubjectWhereIDClass($d,$cl){
	global $db;
	$stm = $db->prepare("SELECT * FROM sub WHERE cl=:cl");
	$stm->bindParam(":cl", $cl, PDO::PARAM_STR);
	$stm->execute();
	$rowCount = $stm->rowCount();
	if ($rowCount>0) {
		while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
			echo '<option ';
				 if($d==$row['id'])echo 'selected ';;
			 echo 'value="'.$row['id'].'">'.$row['sn'].'</option>';
		
	}
	}
}

function getSubjectWhereIDClassForMark($d,$cl){
	global $db,$un,$fetch;
	$cl = output($cl);
	$stm = $db->prepare("SELECT * FROM sub,tea WHERE sub.cl=:cl AND sub.tea=tea.id AND tea.user='$un'");
	$stm->bindParam(":cl", $cl, PDO::PARAM_STR);
	$stm->execute();
	$rowCount = $stm->rowCount();
	if ($rowCount>0) {
		while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
			 ndb("sub"," cl='$cl' AND tea='".$row['id']."'");
			echo '<option ';
				 if($d==$fetch->id)echo 'selected ';;
			 echo 'value="'.$fetch->id.'">'.$row['sn'].'</option>';
	}
	}
}

function getSubjectWhereIDClassAjax($d,$cl){
	global $db;
	$stm = $db->prepare("SELECT * FROM sub WHERE cl=:cl");
	$stm->bindParam(":cl", $cl, PDO::PARAM_STR);
	$stm->execute();
	$rowCount = $stm->rowCount();
    if ($rowCount>0) { 
        echo '<label>بابەت</label>';
        echo '<select required="" class="selectpicker" data-width="100%"';
        echo " onchange=showSubject(this.value+'&cl=$cl','subb','exam');";
        echo " name=sub id=sub class=form-control>";
        while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
            echo '<option ';
            va($d,$row['id']);
            echo ' value="'.$row['id'].'">'.$row['sn'].'</option>';
        }
        echo '</select>';
    }else{
        echo 'هیچ وانەیەک نییە بۆ ئەم قۆناغە، تکایە <a href="subject.php">کلیک لێرە بکە</a> بۆ زیاکردنی وانە.';
    }
}


function getExamNamewithExamID($id){
	global $db;
    $id= output($id);
    $stm = $db->prepare("SELECT * FROM exam WHERE id=:id");
    $stm->bindParam(":id", $id, PDO::PARAM_STR);
    $stm->execute();
    $rowCount = $stm->rowCount();
    if ($rowCount>0) { 
        while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
    }
}

function getFn(){
		global $db,$das,$un;
			$stm = $db->prepare("SELECT fname,user FROM stu WHERE user=:user");
		if ($das==1) {
			$stm = $db->prepare("SELECT fname,user FROM account WHERE user=:user");
		}elseif ($das==2) {
			$stm = $db->prepare("SELECT fname,user FROM tea WHERE user=:user");
		}
		$stm->bindParam(":user", $un, PDO::PARAM_STR);
		$stm->execute();
		$fetch = $stm->fetch(PDO::FETCH_OBJ);
		$rowCount = $stm->rowCount();
		if($rowCount > 0){
			echo $fetch->fname;
		}
}
function getNid($un,$das){
		global $db;
			$stm = $db->prepare("SELECT fname,user FROM stu WHERE user=:user");
		if ($das==1) {
			$stm = $db->prepare("SELECT fname,user FROM account WHERE user=:user");
		}elseif ($das==2) {
			$stm = $db->prepare("SELECT fname,user FROM tea WHERE user=:user");
		}
		$stm->bindParam(":user", $un, PDO::PARAM_STR);
		$stm->execute();
		$fetch = $stm->fetch(PDO::FETCH_OBJ);
		$rowCount = $stm->rowCount();
		if($rowCount > 0){
			echo $fetch->fname;
		}
}

function CheckTimetable($day,$sub,$cl,$st,$et){
	global $db;
		$stm = $db->prepare("SELECT * FROM tt WHERE day='$day' AND sub='$sub' AND cl='$cl' AND et='$et' AND st='$st'");
		$stm->execute();
	return $stm->rowCount();
}

function ndb($d,$d2){
	global $db,$fetch;
		$stm = $db->prepare("SELECT * FROM $d WHERE $d2");
		$stm->execute();
		$fetch = $stm->fetch(PDO::FETCH_OBJ);
	return $stm->rowCount();
}
function NumExam($d,$d2){
	global $db;
		$stm = $db->prepare("SELECT * FROM er WHERE exam='$d' AND user='$d2'");
		$stm->execute();
	return $stm->rowCount();
}
function gCl($d){
	global $db;
		$stm = $db->prepare("SELECT * FROM stu WHERE use=:user AND class=:cl");
		$stm->bindParam(":cl", $d, PDO::PARAM_STR);
		$stm->bindParam(":user", $un, PDO::PARAM_STR);
		$stm->execute();
	return $stm->rowCount();
}
function gClass($d){
	global $db;
		$stm = $db->prepare("SELECT * FROM stu WHERE user=:user");
		$stm->bindParam(":user", $d, PDO::PARAM_STR);
		$stm->execute();
		$fetch = $stm->fetch(PDO::FETCH_OBJ);
	return $fetch->class;
}
function getS($d2){
	global $db,$fetch;
		$stm = $db->prepare("SELECT * FROM sub WHERE $d2");
		$stm->execute();
		$fetch = $stm->fetch(PDO::FETCH_OBJ);
		$stm->rowCount();
	return $fetch->sn;
}

function GetStudentIdwithUser(){
	global $db,$fetch,$un;
		$stm = $db->prepare("SELECT * FROM stu WHERE user=:user");
		$stm->bindParam(":user", $un, PDO::PARAM_STR);
		$stm->execute();
		$fetch = $stm->fetch(PDO::FETCH_OBJ);
	return $fetch->id;
}

function GetSubjectIDwithExamID($id){
	global $db,$fetch;
		$stm = $db->prepare("SELECT * FROM exam WHERE id=:id");
		$stm->bindParam(":id", $id, PDO::PARAM_STR);
		$stm->execute();
		$fetch = $stm->fetch(PDO::FETCH_OBJ);
	return $fetch->sub;
}


function GetInsertedDataExam($id,$user,$exam){
	global $db,$fetch;
		$stm = $db->prepare("SELECT * FROM er WHERE user=:user AND qid=:id AND exam=:exam");
		$stm->bindParam(":id", $id, PDO::PARAM_STR);
		$stm->bindParam(":user", $user, PDO::PARAM_STR);
		$stm->bindParam(":exam", $exam, PDO::PARAM_STR);
		$stm->execute();
		$fetch = $stm->fetch(PDO::FETCH_OBJ);
	return $fetch->anser;
}

function AddExamtoMarkData($stu,$sub,$mark){
	global $db;
		$stm = $db->prepare("INSERT INTO mark_data (type,student_id,subject_id,mark) VALUES (4,:stu,:sub,:mark);");
		$stm->bindParam(":stu", $stu, PDO::PARAM_STR);
		$stm->bindParam(":sub", $sub, PDO::PARAM_STR);
		$stm->bindParam(":mark", $mark, PDO::PARAM_STR);
		 $stm->execute();
}

function HideExamResult($qid){
	global $db;
		$stm = $db->prepare("UPDATE er SET ck=1 WHERE qid=:qid");
		$stm->bindParam(":qid", $qid, PDO::PARAM_STR);
		 $stm->execute();
}


function GetFullNamewithUser($user){
		global $db,$un;
	$das=0;
	 $stm = $db->prepare("SELECT fname,r FROM account WHERE user=:user");
	 $stm->bindParam(":user",$user, PDO::PARAM_STR);
	 $stm->execute();
	 $data = $stm->fetch(PDO::FETCH_OBJ);
	if( $stm->rowCount() > 0){
		$das=$data->r;
	}

			$stm = $db->prepare("SELECT fname,user FROM stu WHERE user=:user");
		if ($das==1) {
			$stm = $db->prepare("SELECT fname,user FROM account WHERE user=:user");
		}elseif ($das==2) {
			$stm = $db->prepare("SELECT fname,user FROM tea WHERE user=:user");
		}
		$stm->bindParam(":user", $user, PDO::PARAM_STR);
		$stm->execute();
		$fetch = $stm->fetch(PDO::FETCH_OBJ);
		$rowCount = $stm->rowCount();
		if($rowCount > 0){
			print_r($fetch->fname);
		}
}

function GetChatLengthByUser($user,$user2){
	global $db;
	$len=0;
	 $stm = $db->prepare("SELECT id FROM conversation WHERE user=:user AND user2=:user2 OR user2=:user AND user=:user2");
	 $stm->bindParam(":user",$user, PDO::PARAM_STR);
	 $stm->bindParam(":user2",$user2, PDO::PARAM_STR);
	 $stm->execute();
	if( $stm->rowCount() > 0){
		while ($row= $stm->fetch(PDO::FETCH_ASSOC)) {
		    $len++;
		}
		
	}
	return $len;
}

function GetDataConvesation($data,$d2){
	global $db;
	 $stm = $db->prepare("SELECT * FROM conversation WHERE $data ORDER BY time DESC LIMIT 1 ");
	 //echo "SELECT * FROM conversation WHERE $data ORDER BY time LIMIT 1 ";
	 $stm->execute();
	$data = $stm->fetch(PDO::FETCH_ASSOC);
	if( $stm->rowCount() > 0){
		return $data["$d2"];
	}
}

/*
-----------------------------------
	END Geting Data 
-----------------------------------
*/



/*
-----------------------------------
	Start Insert Data 
-----------------------------------
*/

function AddtoHistory($action,$page){
	global $un,$db;
	$date=date("Y-m-d H:i:s");
	$page=output($page);
	$action=output($action);
		$stm = $db->prepare("INSERT INTO history (time,action,page,user) VALUES (:time,:action,:page,:un);");
		$stm->bindParam(":time", $time, PDO::PARAM_STR);
		$stm->bindParam(":un", $un, PDO::PARAM_STR);
		$stm->bindParam(":page", $page, PDO::PARAM_STR);
		$stm->bindParam(":action", $action, PDO::PARAM_STR);
		$stm->execute();
}

/*
-----------------------------------
	End Insert Data 
-----------------------------------
*/



/*
-----------------------------------
	Uploading 
-----------------------------------
*/

function upload(){
	global $img,$name,$error,$uploadOk;
	// upload user photo
$target_dir = "uploads/";
$dt =date("Y-m-d (H-i-s)").'_';
$name = basename(@$_FILES["fileToUpload"]["name"]);
$img=md5($name);
$target_file = $name;
$uploadOk = 0;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    $check = @getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        $uploadOk = 0;
        $error="تەنیا وێنە ڕێگە پێدراوە.";
    }

// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
	$error="تەنیا وێنە ڕێگە پێدراوە.";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    $error= "کێشەیەك ڕویدا دووبارە هەوڵ بدەوە.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir.$dt.$img.'.'.$imageFileType)) {
        //echo basename( $_FILES["fileToUpload"]["name"]);
        $uploadOk == 1;
        $img=$dt.$img.'.'.$imageFileType;
    } else {
    }
}
}

function pdf(){
	global $pdf,$pdfOk;

$targetfolder = "uploads/pdf/";
$pdf=date("Y-m-d (H-i-s)").'_'.md5(basename( $_FILES['uploadpdf']['name'])).'.pdf';
$targetfolder = $targetfolder.$pdf;
$pdfOk=0;
$file_type=$_FILES['uploadpdf']['type'];

if ($file_type=="application/pdf") {
 if(move_uploaded_file($_FILES['uploadpdf']['tmp_name'], $targetfolder)){
 $error= "The file ".$pdf . " is uploaded";
$pdfOk=1;
}
 else {
 $error= "Problem uploading file";
$pdfOk=0;
 }
}

else {
 $error= "You may only upload PDFs file.<br>";
$pdfOk=0;
}

}


/*
-----------------------------------
	END Uploading 
-----------------------------------
*/


/*
-----------------------------------
	 TimeTable 
-----------------------------------
*/

function timetable($d,$d1){global $db; ?>
                   <div class="cd-schedule loading">
                    <div class="timeline">
                      <ul>
                        <li><span>08:30</span></li>
                        <li><span>09:00</span></li>
                        <li><span>09:30</span></li>
                        <li><span>10:00</span></li>
                        <li><span>10:30</span></li>
                        <li><span>11:00</span></li>
                        <li><span>11:30</span></li>
                        <li><span>12:00</span></li>
                        <li><span>12:30</span></li>
                        <li><span>01:00</span></li>
                        <li><span>01:30</span></li>
                        <li><span>02:00</span></li>
                        <li><span>02:30</span></li>
                        <li><span>03:00</span></li>
                        <li><span>03:30</span></li>
                        <li><span>04:00</span></li>
                        <li><span>04:30</span></li>
                        <li><span>05:00</span></li>
                        <li><span>05:30</span></li>
                      </ul>
                    </div> <!-- .timeline -->

                    <div class="events">
                      <ul>
                      <?php
                      for ($i = 1; $i < 6; $i++) { ?>
                        <li class="events-group">
                          <div class="top-info"><span><?=day($i);?></span></div>

                          <ul>
                      <?php 
                        $stm = $db->prepare("SELECT * FROM tt WHERE day='$i' AND cl='$d' AND gr='$d1'");
                        $stm->execute();
                        $rowCount = $stm->rowCount();
                        if($rowCount > 0){
                            $n=rand(1,9);
                             while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
 $st= $row['st'];
 $et=$row['et'];

	$et=date("H:i", strtotime($et)); 
	$st=date("H:i", strtotime($st)); 
                              ?>

                            <li class="single-event" 

                            data-start="<?=$st;?>"

                            data-end="<?=$et;?>"  

                            data-event="event-<?=$n;?>">
                              <a href="#0">
                                <em class="event-name"><?php echo getS('id='.$row['sub']); ?></em>
                                <h5><font color="white"><b><?php echo $row['location']; ?></b></font></h5>
                              </a>
                            </li>
                            <?php
                              }
                            }
                            ?> 
                          </ul>
                        </li>
                        <?php } ?>
                          </ul>
                        </li>
                      </ul>
                    </div>

                    <div class="event-modal">
                      <header class="header">
                        <div class="content">
                          <span class="event-date"></span>
                          <h3 class="event-name"></h3>
                        </div>

                        <div class="header-bg"></div>
                      </header>

                      <div class="body">
                        <div class="event-info"></div>
                        <div class="body-bg"></div>
                      </div>

                      <a href="#0" class="close">Close</a>
                    </div>

                    <div class="cover-layer"></div>
                   </div>
<?php }

/*
-----------------------------------
	 END TimeTable 
-----------------------------------
*/



