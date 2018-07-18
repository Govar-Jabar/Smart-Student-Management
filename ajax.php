<?php
require 'conn.php';
require 'inc/function.php';
CheckUserLogined();

if(isset($_GET['sub']) AND $_GET['sub']!=""){
	$id= output($_GET['sub']);
	$stm = $db->prepare("SELECT * FROM sub WHERE cl=:id");
	$stm->bindParam(":id", $id, PDO::PARAM_STR);
	$stm->execute();
	$rowCount = $stm->rowCount();
	if ($rowCount>0) { 
	    echo '<label>بابەت</label><label id="req">*</label>';
	    echo '<select required="" class="selectpicker" data-width="100%"  name="subject" class="form-control" id="subjects">';
		while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
			echo '<option value="'.$row['id'].'">'.$row['sn'].'</option>';
		}
		echo '</select>';
	}else{
		echo 'هیچ وانەیەک نییە بۆ ئەم قۆناغە، تکایە <a href="subject.php">کلیک لێرە بکە</a> بۆ زیاکردنی وانە.';
	}
}
if(isset($_GET['cl']) AND $_GET['cl']!="" AND !isset($_GET['sub']) AND !isset($_GET['subb']) ){
    global $das;
    CheckUserLogined();
	$cl= output($_GET['cl']);
	$stm = $db->prepare("SELECT * FROM qg WHERE cl=:cl");
        if ($das==2) {
            $stm = $db->prepare("SELECT * FROM qg WHERE cl=:cl AND user=:un");
            $stm->bindParam(":un", $un, PDO::PARAM_STR);
        }
	$stm->bindParam(":cl", $cl, PDO::PARAM_STR);
	$stm->execute();
	$rowCount = $stm->rowCount();
	if ($rowCount>0) { 
	    echo '<label>گروپی پرسیار</label>';
	    echo '<select  onchange=showSubject(this.value,"qg","bod");loa();  class="selectpicker" data-width="100%"  name="qg" class="form-control" id="subjects">';
			echo '<option>گروپێك هەڵبژێرە</option>';
		while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
			echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
		}
		echo '</select>';
	}else{ 
		echo '<label>گروپی پرسیار</label><select disabled="" onchange="showSubject(this.value)" class="selectpicker" data-width="100%"  id="subjects" class="form-control"><option>هیچ گروپێکی پرسیار بۆ ئەم قۆناغە بونی نییە</option></select>';
	}
}

if(isset($_GET['qg']) AND $_GET['qg']!="" AND @$_GET['del']==""){ ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                              پرسیارەکان
                        </div>
                        <div class="panel-body">
                        <?php
                         $qg=output(@$_GET['qg']);
                        $stm = $db->prepare("SELECT * FROM qb WHERE qg=:qg ");
                        $stm->bindParam(":qg", $qg, PDO::PARAM_STR);
                        $stm->execute();
                        $rowCount = $stm->rowCount();
                        if($rowCount > 0){
                        ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" data-id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th width="50px">#</th>
                                            <th>پرسیار</th>
                                            <th>گروپی پرسیار</th>
                                            <th width="70px">نمرە</th>
                                            <th width="70px">کردار</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $nu = 0;
                                    while($row = $stm->fetch(PDO::FETCH_ASSOC)) { 
                                      ?>
                                        <tr id="<?='cl'.$row['id'];?>" class="<?='cl'.$row['id'];?>">
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['qu']; ?></td>
                                            <td><?php echo qg($row['qg']); ?></td>
                                            <td><?php echo $row['mark']; ?></td>
                                            <td>
                                            
                                              <a href="qb.php?edit=<?php echo $row['id']; ?>" data-toggle="tooltip" data-placement="top" class="btn btn-info btn-xs mrg" title="دەستکاری"><i class="fa fa-edit"></i></a>

                                              <a onclick="showSubject('<?=$row['id']; ?>&qg='+document.getElementById('qgid').value,'del','del');del('<?php echo 'cl'.$row['id'];?>');" value="#go" id="btn-confirm" data-toggle="tooltip" data-placement="top" class="btn btn-danger btn-xs mrg confirmation" title="سڕینەوە"><i class="fa fa-trash-o"></i></a>

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
<?php
}

    $del = output(@$_GET['del']);
    $qg = output(@$_GET['qg']);
    if (isset($del) && $del!="") {
        if (ndb("qg,qb"," qg.id=qb.qg AND qg.id='$qg' AND qg.user='$un'") > 0) {
        $stm = $db->prepare("DELETE FROM qb WHERE id=:id");
        $stm->bindParam(":id", $del, PDO::PARAM_STR);
        $stm->execute();
        re("danger","  بابەت ","بەسەرکەوتویی سڕایەوە.");
        dh("qb.php");
        }
    }


if(isset($_GET['cl']) AND $_GET['cl']!="" AND isset($_GET['sub']) ){
    $cl= output($_GET['cl']);
    $stm = $db->prepare("SELECT * FROM sub WHERE cl=:cl");
    $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
    $stm->execute();
    $rowCount = $stm->rowCount();
    if ($rowCount>0) { 
        echo '<label>بابەت</label>';
        echo '<select required="" class="selectpicker" data-width="100%" onchange="showSubject(this.value+\'&cl=\''."+document.getElementById('cl').value".',\'subb\',\'exam\');ref();" name="sub" id="sub" class="form-control">';
        echo '<option>دیاری بکە</option>';
        while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="'.$row['id'].'">'.$row['sn'].'</option>';
        }
        echo '</select>';
    }else{
        echo 'هیچ وانەیەک نییە بۆ ئەم قۆناغە، تکایە <a href="subject.php">کلیک لێرە بکە</a> بۆ زیاکردنی وانە.';
    }
}

if(isset($_GET['cl']) AND $_GET['cl']!="" AND isset($_GET['subb']) ){
    $cl= output($_GET['cl']);
    $sub= output($_GET['subb']);
    $stm = $db->prepare("SELECT * FROM exam WHERE cl=:cl AND sub=:sub");
    $stm->bindParam(":cl", $cl, PDO::PARAM_STR);
    $stm->bindParam(":sub", $sub, PDO::PARAM_STR);
    $stm->execute();
    $rowCount = $stm->rowCount();
    if ($rowCount>0) { 
        echo '<label>تاقیکردنەوە</label>';
        echo '<select required="" class="selectpicker" data-width="100%" name="exam" id="examid" class="form-control">';
        while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
        }
        echo '</select>';
    }
}


if(isset($_GET['conversation']) AND $_GET['conversation']!=""){
    $type= output($_GET['conversation']);
    
    $stm = $db->prepare("SELECT * FROM account WHERE r=1");
    if ($type==2){
        $stm = $db->prepare("SELECT * FROM tea");
        echo '<label>مامۆستا دیاری بکە</label><label id="req">*</label>';
    }elseif ($type==3){
        $stm = $db->prepare("SELECT * FROM stu");
        echo '<label>خوێندکار دیاری بکە</label><label id="req">*</label>';
    }else{
        echo '<label>بەڕێوبەر دیاری بکە</label><label id="req">*</label>';
    }
    $stm->execute();
    $rowCount = $stm->rowCount();
    if ($rowCount>0) { 
        echo '<select data-size="10" data-live-search="true" required="" class="selectpicker chatcombo" data-width="100%"  name="user" class="form-control" id="subjects">';
        while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="'.$row['user'].'">'.$row['fname'].'</option>';
        }
        echo '</select>';
    }else{
        echo '<select data-size="10" data-live-search="true" disabled="" class="selectpicker" data-width="100%" class="form-control" id="subjects">';
        echo '<option>هیچ کەسێک نەدۆزرایەوە بەو پلەیە</option>';
        echo '</select>';

    }
}


if(isset($_GET['mark']) AND $_GET['mark']!=""){
    $id= output($_GET['mark']);
    $stm = $db->prepare("SELECT * FROM sub,tea WHERE sub.cl=:id AND sub.tea=tea.id AND tea.user='$un'");
    $stm->bindParam(":id", $id, PDO::PARAM_STR);
    $stm->execute();
    $rowCount = $stm->rowCount();
    if ($rowCount>0) { 
        echo '<label>بابەت</label><label id="req">*</label>';
        echo '<select required="" class="selectpicker" data-width="100%"  name="subject" class="form-control" id="subjects">';
        while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
                ndb("sub"," cl='$id' AND tea='".$row['id']."'");
                echo '<option value="'.$fetch->id.'">'.$row['sn'].'</option>';
        }
        echo '</select>';
    }else{
        echo '<label>بابەت</label><select disabled="" class="selectpicker" data-width="100%" id="subjects"  name="subject" class="form-control"><option value="">هیچ بابەتێک نییە</option></select>';
    }
}

$db = null;