<?php 
include('class.token.php'); 
require 'inc/head.php';
global $re; 
?>
                <div class="row">
                    <div class="col-md-12">
                     <h2> مێژوی کردارەکان</h2>
                        <h5>لێرەوە دەتوانیت هەموو ئەو چالاکیانە ببینیت کە لە سیستەم ئەنجام دراوە.</h5>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                <div class="row">
                <div class="col-md-12">
              <?php
                  $type=output(@$_GET['type']);

              ?>
              <!-- /. ROW  -->
                <div class="row student">
                    <div class="col-md-12">
                      <form action="" method="get">
                        <div class="col-md-10">
                              <div class="form-group">
                                    <label>پلە</label>
                                    <select class="selectpicker" data-width="100%" name="type" class="form-control">
                                      <option <?php va("1",$type); ?>  value="1">بەڕێوبەران</option>
                                      <option <?php va("2",$type); ?>  value="2">مامۆستایان</option>
                                      <option <?php va("3",$type); ?>  value="3">خوێندکاران</option>
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
                    <div class="panel panel-default" id="print">
                        <div class="panel-heading">
                             کردارەکان 
                        </div>
                        <div class="panel-body">
                        <?php
                        $stm = $db->prepare("SELECT * FROM history ORDER BY time DESC");
                        if (isset($_GET['type']) AND $_GET['type']==3) {
                          $stm = $db->prepare("SELECT * FROM history,account WHERE account.user=history.user AND account.r=3 ORDER BY time DESC");
                        }elseif (isset($_GET['type']) AND $_GET['type']==2) {
                          $stm = $db->prepare("SELECT * FROM history,account WHERE account.user=history.user AND account.r=2 ORDER BY time DESC");
                        }elseif (isset($_GET['type']) AND $_GET['type']==1) {
                          $stm = $db->prepare("SELECT * FROM history,account WHERE account.user=history.user AND account.r=1 ORDER BY time DESC");
                        }
                        $stm->execute();
                        $rowCount = $stm->rowCount();
                        if($rowCount > 0){
                        ?>
                            <div class="table-responsive stu_tbl">
                                <table class="table table-striped table-bordered table-hover table-responsive"  id="advance2">
                                    <thead>
                                        <tr>
                                            <th width="50px">#</th>
                                            <th width="50px">چالاکی</th>
                                            <th>ناوی بەکارهێنەر</th>
                                            <th>پەڕە</th>
                                            <th>کات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    while($row = $stm->fetch(PDO::FETCH_ASSOC)) { 
                                      ?>
                                        <tr>
                                            <td><?php echo $row['id']; ?></td>
                                            <td width="400px"><?php echo $row['action']; ?></td>
                                            <td><?php echo $row['user']; ?></td>
                                            <td style="font-size: 10px;direction: ltr"><?php echo $row['page']; ?></td>
                                            <td style="direction: ltr"><?php echo date("Y-m-d h:i:s A",strtotime($row['time'])) ?></td>
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
                </div>
            </div>
            </div>
<div class="alert" role="alert" id="result"></div>

<?php include 'inc/foot.php'; ?>