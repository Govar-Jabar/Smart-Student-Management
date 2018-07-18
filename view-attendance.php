<?php require 'inc/head.php'; ?>
                <div class="row">
                    <div class="col-md-12">
                     <h2>ئاماری ئامادەبوونم</h2>   
                        <h5>بینینی ئاماری ئامادەبونت</h5>

                    </div>
                </div>
                <hr>
                    <table class="table table-bordered table-hover">
                        <thead>
                            <tr>
                              <th width="200px">وانەکان</th>
                              <th>ڕێژەی ئامادەنەبوون</th>
                              <th width="150px">زانیاری زیاتر</th>
                            </tr>
                        </thead>
                        <tbody>
                            
                              <?php
                                  $stm = $db->prepare("SELECT * FROM stu,sub WHERE stu.class=sub.cl AND stu.user=:un");
                                  $stm->bindParam(":un", $un, PDO::PARAM_STR);
                                   $stm->execute();
                                  $rowCount = $stm->rowCount();
                                    if($rowCount > 0){
                                                                                      $ii=0;

                                      while($row = $stm->fetch(PDO::FETCH_ASSOC)) { 
                                        $total=0;
                                        
                                        $data="";
                                        $more = array();
                                        ?>
                                        <tr>
                                          <td><?=$row['sn'];?></td>
                                          <td>
                                            <?php
                                               $sub=$row['id'];
                                               $s = $db->prepare("SELECT * FROM att WHERE user=:user AND sub_id=:sub AND re=3");
                                               $s->bindParam(":user", $un, PDO::PARAM_STR);
                                               $s->bindParam(":sub", $sub, PDO::PARAM_STR);
                                               $s->execute();
                                               $r = $s->rowCount();
                                                if($r > 0){
                                                  $i=0;
                                                  while($ro = $s->fetch(PDO::FETCH_ASSOC)) {
                                                @$total=$total+$ro['etm']-$ro['tm'];
                                                $more[$i]['tm']=  $ro['tm'];
                                                $more[$i]['etm']=  $ro['etm'];
                                                $more[$i]['dt']=  $ro['dt'];
                                                $i++;
                                              }
                                                 echo $total.' کاتژمێر';
                                              }
                                            ?>
                                             
                                          </td>
                                          <td>
<?php 
foreach ($more as $value) {
$tot=0;                                         
@$tot = $tot+$value['etm']-$value['tm'];
$data = $data."<tr><td>".$tot." کاتژمێر</td>".'<td>'.@$value['tm']."</td><td>".@$value['etm']."</td><td>".@$value['dt']."</td></tr> ";
$tot=0;
}
                                           ?>
                                            <a data-toggle="modal" data-target="#myModal<?=$ii;?>" class="btn btn-info">زانیاری زیاتر</a>
<div id="myModal<?=$ii;?>" class="modal fade" role="dialog"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header modal-lg"> <button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">زانیاری زیاتر لەبارەی ئامادەبوونم لە وانەی <?=$row['sn'];?></h4></div><div class="modal-body">
  <table class="table table-bordered table-hover">
<thead>
    <tr>
      <th width="200px">ئامادەنەبوون</th>
      <th width="200px">کات</th>
      <th width="200px">تا</th>
      <th>بەروار</th>
    </tr>
</thead>
<tbody>
<?=$data;?>
</tbody>
</table>
</div><div class="modal-footer"> <button style="float: left" type="button" class="btn btn-default" data-dismiss="modal">داخستن</button></div></div></div></div>
                                          </td>
                                        </tr>
                                        <?php
                                        $ii++;
                                      }
                                    }
                              ?>
                        </tbody>
                    </table>



<div id="modal-mark"></div>
<?php require 'inc/foot.php'; ?>