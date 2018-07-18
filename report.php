<?php require 'inc/head.php';

if ($das!=1) {
  dh("index.php");
}

$student=output(@$_GET['student']);
$class=output(@$_GET['class']);
$gender=output(@$_GET['gender']);
$loc=output(@$_GET['loc']);
$gen=output(@$_GET['gen']);
$bl=output(@$_GET['bl']);
$cl=output(@$_GET['cl']);
$gr=output(@$_GET['gr']);


///// Start Report Students
if (isset($_GET['student'])) {
?>
                <div class="row">
                    <div class="col-md-12">
                     <h2>ڕاپۆرتی خوێندکاران</h2>   
                        <h5>لێرەوە دەتوانیت ڕاپۆرتی خوێندکاران وەربگریت.</h5>
                    </div>
                </div>
                <hr>
                <div class="row report">
                    <div class="col-md-12">
                      <form action="" method="get">
                        <div class="col-md-5">
                              <div class="form-group">
                                    <label>ڕاپۆرت بەگوێرەی</label>
                                    <select class="selectpicker" data-width="100%" id="report_student"  name="student" class="form-control">
                                      <option>جۆرێک دیاری بکە</option>
                                      <option <?php va("location",@$student); ?>  value="location">ناونیشان</option>
                                      <option <?php va("gender",@$student); ?>  value="gender">ڕەگەز</option>
                                      <option <?php va("bl",@$student); ?>  value="bl">گروپی خوێن</option>
                                    </select>
                              </div>  
                        </div>
                        <div id="gender" style="<?= $student != "gender" ? 'display: none' : ''; ?>" class="col-md-5">
                              <div class="form-group">
                                    <label>ڕەگەز</label>
                                    <select class="selectpicker" data-width="100%"   name="gen" class="form-control">
                                      <option <?php va("1",@$gen); ?> value="1">نێر</option>
                                      <option <?php va("2",@$gen); ?>  value="2">مێ</option>
                                    </select>
                              </div>  
                        </div>
                        <div id="location" style="<?= $student != "location" ? 'display: none' : ''; ?>" class="col-md-5">
                                    <div class="form-group">
                                    <label>شوێنێک دیاری بکە</label>
                                              <div class="typeahead__container">
                                                <div class="typeahead__field">
                                                    <span class="typeahead__query">
                                                        <input type="text" value="<?=@$loc;?>" name="loc" type="search" autocomplete="off" class="form-control" id="loc">
                                                    </span>
                                                </div>
                                            </div>
                                    </div>
                        </div>
                        <div id="bl" style="<?= $student != "bl" ? 'display: none' : ''; ?>" class="col-md-5">
                          <div class="form-group">
                                <label>گروپی خوێن</label>
                                <select  class="selectpicker" data-width="100%"  name="bl" class="form-control">
                                  <option <?php va("A+",@$bl); ?> value="A+">A+</option>
                                  <option <?php va("A-",@$bl); ?> value="A-">A-</option>
                                  <option <?php va("B+",@$bl); ?> value="B+">B+</option>
                                  <option <?php va("B-",@$bl); ?> value="B-">B-</option>
                                  <option <?php va("O+",@$bl); ?> value="O+">O+</option>
                                  <option <?php va("O-",@$bl); ?> value="O-">O-</option>
                                  <option <?php va("AB+",@$bl); ?> value="AB+">AB+</option>
                                  <option <?php va("AB-",@$bl); ?> value="AB-">AB-</option>
                                </select>
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
<?php if ($student=="bl" AND $bl!="") {
 ?>

<!-- Advanced Tables -->
<div class="panel panel-default" id="print">
    <div class="panel-heading">
         ڕاپۆرتی خوێندکاران بەگوێرەی گروپی خوێنی (<?=$bl;?>) 
    </div>
    <div class="panel-body">
    <?php
    $stm = $db->prepare("SELECT * FROM stu WHERE blood=:bl");
    $stm->bindParam(":bl",$bl, PDO::PARAM_STR);
    $stm->execute();
    $rowCount = $stm->rowCount();
    if($rowCount > 0){
    ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover"  id="advance">
                <thead>
                    <tr>
                        <th width="50px">#</th>
                        <th width="50px">وێنە</th>
                        <th>ناوی تەواوەتی</th>
                        <th width="50px">ڕەگەز</th>
                        <th width="50px">قۆناغ</th>
                        <th width="50px">گروپ</th>
                        <?php if($das==1){ ?>
                        <th width="110px">کردار</th>
                        <?php } ?>

                    </tr>
                </thead>
                <tbody>
                <?php
                $nu = 0;
                while($row = $stm->fetch(PDO::FETCH_ASSOC)) { 
                  ?>
                    <tr class="<?php if($nu % 2==0){echo 'odd';}else{echo 'even';} ?>">
                        <td><?php echo $row['id']; ?></td>
                        <td><img class="atach" src="uploads/<?php echo $row['img']; ?>" alt=""></td>
                        <td><?php echo $row['fname']; ?></td>
                        <td class="center"><?php echo gen($row['gen']); ?></td>
                        <td class="center"><?php echo $row['class']; ?></td>
                        <td class="center"><?php echo $row['gr']; ?></td>
                        <?php if($das==1){ ?>
                        <td>
                          <a href="profile.php?user=<?php echo $row['user'];if($das==1){echo "&r=3";} ?>" class="btn btn-success btn-xs mrg" data-toggle="tooltip" data-placement="top" title="بینین"><i class="fa fa-check-square-o"></i></a>

                          <a href="profile.php?user=<?php echo $row['user'];if($das==1){echo "&r=3";} ?>#edit" data-toggle="tooltip" data-placement="top" class="btn btn-warning btn-xs mrg" title="دەستکاری"><i class="fa fa-edit"></i></a>
                          </td>
                          <?php } ?>

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
<!--End Advanced Tables -->

<?php
 }
?>

<?php if ($student=="location" AND $loc!="") {
 ?>


<!-- Advanced Tables -->
<div class="panel panel-default" id="print">
    <div class="panel-heading">
         ڕاپۆرتی خوێندکاران بەگوێرەی شوێنی (<?=$loc;?>) 
    </div>
    <div class="panel-body">
    <?php
    $loc= '%'.$loc.'%';
    $stm = $db->prepare("SELECT * FROM stu WHERE addr LIKE :loc");
    $stm->bindParam(":loc",$loc, PDO::PARAM_STR);
    $stm->execute();
    $rowCount = $stm->rowCount();
    if($rowCount > 0){
    ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover"  id="advance">
                <thead>
                    <tr>
                        <th width="50px">#</th>
                        <th width="50px">وێنە</th>
                        <th>ناوی تەواوەتی</th>
                        <th>شوێن</th>
                        <th width="50px">قۆناغ</th>
                        <th width="50px">گروپ</th>
                        <?php if($das==1){ ?>
                        <th width="110px">کردار</th>
                        <?php } ?>

                    </tr>
                </thead>
                <tbody>
                <?php
                $nu = 0;
                while($row = $stm->fetch(PDO::FETCH_ASSOC)) { 
                  ?>
                    <tr class="<?php if($nu % 2==0){echo 'odd';}else{echo 'even';} ?>">
                        <td><?php echo $row['id']; ?></td>
                        <td><img class="atach" src="uploads/<?php echo $row['img']; ?>" alt=""></td>
                        <td><?php echo $row['fname']; ?></td>
                        <td><?php echo $row['addr']; ?></td>
                        <td class="center"><?php echo $row['class']; ?></td>
                        <td class="center"><?php echo $row['gr']; ?></td>
                        <?php if($das==1){ ?>
                        <td>
                          <a href="profile.php?user=<?php echo $row['user'];if($das==1){echo "&r=3";} ?>" class="btn btn-success btn-xs mrg" data-toggle="tooltip" data-placement="top" title="بینین"><i class="fa fa-check-square-o"></i></a>

                          <a href="profile.php?user=<?php echo $row['user'];if($das==1){echo "&r=3";} ?>#edit" data-toggle="tooltip" data-placement="top" class="btn btn-warning btn-xs mrg" title="دەستکاری"><i class="fa fa-edit"></i></a>
                          </td>
                          <?php } ?>

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
<!--End Advanced Tables -->

<?php
 }
?>

<?php if ($student=="gender" AND $gen!="") {
 ?>

<!-- Advanced Tables -->
<div class="panel panel-default" id="print">
    <div class="panel-heading">
         ڕاپۆرتی خوێندکاران بەگوێرەی ڕەگەزی (<?=gen($gen);?>) 
    </div>
    <div class="panel-body">
    <?php
    $stm = $db->prepare("SELECT * FROM stu WHERE gen=:gen");
    $stm->bindParam(":gen",$gen, PDO::PARAM_STR);
    $stm->execute();
    $rowCount = $stm->rowCount();
    if($rowCount > 0){
    ?>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover"  id="advance">
                <thead>
                    <tr>
                        <th width="50px">#</th>
                        <th width="50px">وێنە</th>
                        <th>ناوی تەواوەتی</th>
                        <th width="50px">ڕەگەز</th>
                        <th width="50px">قۆناغ</th>
                        <th width="50px">گروپ</th>
                        <?php if($das==1){ ?>
                        <th width="110px">کردار</th>
                        <?php } ?>

                    </tr>
                </thead>
                <tbody>
                <?php
                $nu = 0;
                while($row = $stm->fetch(PDO::FETCH_ASSOC)) { 
                  ?>
                    <tr class="<?php if($nu % 2==0){echo 'odd';}else{echo 'even';} ?>">
                        <td><?php echo $row['id']; ?></td>
                        <td><img class="atach" src="uploads/<?php echo $row['img']; ?>" alt=""></td>
                        <td><?php echo $row['fname']; ?></td>
                        <td class="center"><?php echo gen($row['gen']); ?></td>
                        <td class="center"><?php echo $row['class']; ?></td>
                        <td class="center"><?php echo $row['gr']; ?></td>
                        <?php if($das==1){ ?>
                        <td>
                          <a href="profile.php?user=<?php echo $row['user'];if($das==1){echo "&r=3";} ?>" class="btn btn-success btn-xs mrg" data-toggle="tooltip" data-placement="top" title="بینین"><i class="fa fa-check-square-o"></i></a>

                          <a href="profile.php?user=<?php echo $row['user'];if($das==1){echo "&r=3";} ?>#edit" data-toggle="tooltip" data-placement="top" class="btn btn-warning btn-xs mrg" title="دەستکاری"><i class="fa fa-edit"></i></a>
                          </td>
                          <?php } ?>

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
<!--End Advanced Tables -->

<?php
 }

 } 

///// End Report Students




///// Start Report Class


if (isset($_GET['class'])) {
?>
                <div class="row">
                    <div class="col-md-12">
                     <h2>ڕاپۆرتی قۆناغەکان</h2>   
                        <h5>لێرەوە دەتوانیت ڕاپۆرتی قۆناغەکان وەربگریت.</h5>
                    </div>
                </div>
                <hr>
                <div class="row report">
                    <div class="col-md-12">
                      <form action="" method="get">
                        <div class="col-md-6">
                              <div class="form-group">
                                    <label>قۆناغ</label>
                                    <select class="selectpicker" data-width="100%" name="class" class="form-control">
                                      <option <?php va("1",$class); ?>  value="1">1</option>
                                      <option <?php va("2",$class); ?>  value="2">2</option>
                                      <option <?php va("3",$class); ?>  value="3">3</option>
                                      <option <?php va("4",$class); ?>  value="4">4</option>
                                    </select>
                              </div>  
                        </div>
                        <div class="col-md-5">
                              <div class="form-group">
                                    <label>گروپ</label>
                                    <select class="selectpicker" data-width="100%" name="gr" class="form-control">
                                      <option <?php va("0",$gr); ?>  value="0">هەموو گروپەکان</option>
                                      <option <?php va("A",$gr); ?>  value="A">A</option>
                                      <option <?php va("B",$gr); ?>  value="B">B</option>
                                      <option <?php va("C",$gr); ?>  value="C">C</option>
                                      <option <?php va("D",$gr); ?>  value="D">D</option>
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
<?php if ($class!="") {
 ?>

<!-- Information -->
<div class="panel panel-default">
    <div class="panel-heading">
         ڕاپۆرتی خوێندکاران بەگوێرەی قۆناغی <?=classwithString($class);?> (<?php if($gr!=0){ ?> گروپی <?php } echo cl($gr);?>) 
    </div>
    <div class="panel-body">

      <div class="col-md-12">
      <div class="panel panel-default">
          <div style="text-align: center;" class="panel-heading">
               <i class="fa fa-info"></i>  زانیاریەکان : کۆی خوێندکاران (
<?php
  if($gr=="0"){
    echo ndb("stu","class='$class'");
  }else{
    echo ndb("stu","class='$class' AND gr='$gr'");
  }
?>
               )
          </div>
          <div class="panel-body">
              <!-- Start Gender -->
              <script src="assets/js/Chart.js"></script>
              <script src="assets/js/Chart.PieceLabel.js"></script>
        <div class="col-md-6">
                <canvas id="chartGender" width="300" height="300"></canvas>
              <script>
                jQuery(document).ready(function() {
            var chartDiv = $("#chartGender");
            var myChart = new Chart(chartDiv, {
                type: 'pie',
                data: {
                    labels: ["نێر", "مێ"],
                    datasets: [
                    {
                        data: [
                        <?php
                        if($gr=="0"){
                          echo ndb("stu","gen=1 AND class='$class'");
                      }else {
                          echo ndb("stu","gen=1 AND class='$class' AND gr='$gr'");

                      }
                        ?>,
                      <?php
                        if($gr=="0"){
                          echo ndb("stu","gen=2 AND class='$class'");
                      }else {
                          echo ndb("stu","gen=2 AND class='$class' AND gr='$gr'");
                      }
                        ?>],
                        backgroundColor: ["#FF6384","#4BC0C0",]
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'ڕاپۆرت بەپێی ڕەگەز',
                        fontFamily: "'Droid Arabic Naskh'"
                    },

                responsive: true,
            maintainAspectRatio: false,        
            pieceLabel: {
                render: 'percentage',
                fontColor: ['white','white'],
                precision: 2
              }
                },
            });
                });
              </script>
          </div>
    <!-- End Gender -->
    <!-- Start Location -->
        <div class="col-md-6">
                <canvas id="chartLoc" width="300" height="300"></canvas>
              <script>
                jQuery(document).ready(function() {
            var chartDiv = $("#chartLoc");
            var myChart = new Chart(chartDiv, {
                type: 'pie',
                fontFamily: "'Droid Arabic Naskh'",
                data: {
                    labels: [<?php
      $stm = $db->prepare("SELECT *, COUNT(*) FROM stu WHERE class=:class GROUP BY addr HAVING COUNT(*) > 1 LIMIT 10");
    if ($gr!="0") {
      $stm = $db->prepare("SELECT *, COUNT(*) FROM stu WHERE class=:class AND gr=:gr GROUP BY addr HAVING COUNT(*) > 1 LIMIT 10");
      $stm->bindParam(":gr",$gr, PDO::PARAM_STR);
    }
    $stm->bindParam(":class",$class, PDO::PARAM_STR);
    $stm->execute();
    $total= $stm->rowCount();
 while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
  echo '"'.$row['addr'].'",';
 }
  ?>],
                    datasets: [
                    {
                        data: [<?php
      $stm = $db->prepare("SELECT *, COUNT(*) FROM stu WHERE class=:class GROUP BY addr HAVING COUNT(*) > 1 LIMIT 10");
    if ($gr!="0") {
      $stm = $db->prepare("SELECT *, COUNT(*) FROM stu WHERE class=:class AND gr=:gr GROUP BY addr HAVING COUNT(*) > 1 LIMIT 10");
      $stm->bindParam(":gr",$gr, PDO::PARAM_STR);
    }
    $stm->bindParam(":class",$class, PDO::PARAM_STR);
    $stm->execute();
    $total= $stm->rowCount();
 while($row = $stm->fetch(PDO::FETCH_ASSOC)) {
  echo '"'.$row['COUNT(*)'].'",';
 }
  ?>],
                        backgroundColor: [
<?php
for ($i = 0; $i < $total; $i++) {
  echo '"'.$flatcolor[$i].'",';
}
?>
                        ]
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: 'ڕاپۆرت بەپێی شوێن',
                        fontFamily: "'Droid Arabic Naskh'"
                    },

                responsive: true,
            maintainAspectRatio: false,
            pieceLabel: {
                render: 'percentage',
                fontColor: [
<?php
for ($i = 0; $i < $total; $i++) {
  echo '"white",';
}
?>
],
                precision: 0
              }
                }
            });
                });
              </script>
        </div>
    <!-- End Location -->
      </div>
    </div>
    </div>

<!-- Subjects -->

      <div class="col-md-12">
        <div class="panel panel-default">
          <div style="text-align: center;" class="panel-heading">
               <i class="fa fa-book"></i> وانەکانیان
          </div>
          <div class="panel-body">
                        <?php
                        $stm = $db->prepare("SELECT * FROM sub WHERE cl=:class");
                        $stm->bindParam(":class",$class, PDO::PARAM_STR);
                        $stm->execute();
                        $rowCount = $stm->rowCount();
                        if($rowCount > 0){
                        ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" data-id="dataTables-example">
                                    <thead>
                                        <tr>
                                            <th width="50px">#</th>
                                            <th>ناوی وانە</th>
                                            <th>وانەبێژ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $nu = 0;
                                    while($row = $stm->fetch(PDO::FETCH_ASSOC)) { 
                                      ?>
                                        <tr class="<?php if($nu % 2==0){echo 'odd';}else{echo 'even';} ?>">
                                            <td><?php echo $row['id']; ?></td>
                                            <td><?php echo $row['sn']; ?></td>
                                            <td><?php echo tea($row['tea']); ?></td>
                                            

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
      </div>


<!-- END Subjects -->




</div>
<!--END Information -->


<?php
 }

 } 

///// End Report Class


$db = null;
 ?>
<?php require 'inc/foot.php'; ?>