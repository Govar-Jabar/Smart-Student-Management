<?php require 'inc/head.php'; ?>
<style type="text/css" media="screen">
  label{
    padding: 15px 0px 0px 0px;
    margin-left: 8px;
}
</style>

                <div class="row">
                    <div class="col-md-12">
                    <img src="<?php if($array['i']==""){echo 'assets/img/logo.png';}else{echo 'uploads/'.$array["i"];}?>" style="height: 80px;float: left;">
                     <h2>ڕێکخستنەکان</h2>   
                        <h5>ڕێکخستنی بەشەکانی سیستەم ...</h5>
                    </div>
                </div>              
                 <!-- /. ROW  -->
                  <hr />
                 <!-- /. ROW  -->
      <form id="save" enctype="multipart/form-data">
      <div class="row">
      <div class="col-md-12">
          <div class="panel-body">
              <ul class="nav nav-tabs">
                  <li class="active"><a href="#gen" data-toggle="tab">ڕێکخستنە گشتیەکان</a></li>
                  <li><a href="#conversation" data-toggle="tab">گفتوگۆ</a></li>
                  <li><a href="#feilds" data-toggle="tab">خانەکان</a></li>
                  <li><a href="setting.php?backup=true" class="confirmation">زەخیرەکردنی بنکەدراو</a></li>
<?php
if (@$_GET['backup']=="true" AND $das==1) {
  require 'inc/myphp-backup.php';
}
?>
              </ul>

            <div class="tab-content">
            <br>
              <div class="tab-pane fade active in" id="gen">
               <?php 
                  checkInput();
                 ?>

                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                      <label>ناونیشانی سیستەم</label>
                                      <input type="text" name="title" value="<?=$array['t'];?>" placeholder="" class="form-control">
                                </div>
                                <div class="form-group">
                                      <label>باری سیستەم : </label>
                                      <input name="status" type="checkbox" <?php if($array['s']!=""){echo 'checked';} ?> data-toggle="toggle" data-on="چالاك" data-off="ناچالاك" data-onstyle="success" data-offstyle="danger">

                                </div>
                                <div class="form-group">
                                      <label>ژمارە مۆبایل</label>
                                      <input type="text" name="phone" value="<?=$array['p'];?>" placeholder="" autocomplete="off" class="form-control">
                                </div>
                                <div class="form-group">
                                      <label>ئیمەیڵی سیستەم</label>
                                      <input type="text" name="email" value="<?=$array['e'];?>" placeholder="" autocomplete="off" class="form-control">
                                </div>
                                <div class="form-group">
                                      <label>ناونیشان</label>
                                      <input type="text" name="loc" value="<?=$array['l'];?>" placeholder="" autocomplete="off" class="form-control">
                                </div>
                                <div class="form-group">
                                      <label>باری چاوەڕوانی : </label>
                                      <input name="loading" type="checkbox" <?php if($array['loading']!=""){echo 'checked';} ?> data-toggle="toggle" data-on="چالاك" data-off="ناچالاك" data-onstyle="success" data-offstyle="danger">

                                </div>
<!--                                 <div class="form-group width100">
                                      <label>لۆگۆ</label>
                                      <input type="file" accept="image/png, image/jpeg, image/gif, image/jpg"  name="fileToUpload"  data-label="دیاریکردن" class="filepicker form-control">
                                </div> -->
                              </div>
                            </div>  
                    </div>
                    <div class="tab-pane fade" id="conversation">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                                <label>خوێندکار <span class="text-muted h6">(خوێندکار بتوانیت چەند پەیام بنێرێت لە ڕۆژێکدا)</span></label>
                                <input type="number" name="stu_chat" value="<?=$array['stu_chat'];?>" placeholder="" class="form-control">

                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="tab-pane fade" id="feilds">
                    <div class="row">
                        <div class="col-md-4">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          خوێندکاران
                        </div>
                        <div class="panel-body">
                           <div class="form-group">
                              <table>
                                <thead>
                                  <tr>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td style="text-align: left;"><label>بیروباوەڕ : </label></td>
                                    <td>
                                      <input name="stu_relig" type="checkbox"  <?php if($feilds['stu_relig']!=""){echo 'checked';} ?> data-toggle="toggle" data-on="پێویستە" data-off="پێویست نییە" data-onstyle="success" data-offstyle="danger">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style="text-align: left;"><label>ژمارە مۆبایل : </label></td>
                                    <td>
                                      <input name="stu_num" type="checkbox" <?php if($feilds['stu_num']!=""){echo 'checked';} ?> data-toggle="toggle" data-on="پێویستە" data-off="پێویست نییە" data-onstyle="success" data-offstyle="danger">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style="text-align: left;"><label>ناونیشان : </label></td>
                                    <td>
                                      <input name="stu_loc" type="checkbox" <?php if($feilds['stu_loc']!=""){echo 'checked';} ?> data-toggle="toggle" data-on="پێویستە" data-off="پێویست نییە" data-onstyle="success" data-offstyle="danger">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style="text-align: left;"><label>گروپی خوێن : </label></td>
                                    <td>
                                      <input name="stu_bl" type="checkbox" <?php if($feilds['stu_bl']!=""){echo 'checked';} ?> data-toggle="toggle" data-on="پێویستە" data-off="پێویست نییە" data-onstyle="success" data-offstyle="danger">
                                    </td>
                                  </tr>
                                </tbody>
                              </table>

                                  
                            </div>
                          </div>
                        </div>
                      </div>
                        <div class="col-md-4">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          مامۆستا
                        </div>
                        <div class="panel-body">
                         <div class="form-group">
                              <table>
                                <thead>
                                  <tr>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td style="text-align: left;"><label>بیروباوەڕ : </label></td>
                                    <td>
                                      <input name="tea_relig" type="checkbox" <?php if($feilds['tea_relig']!=""){echo 'checked';} ?> data-toggle="toggle" data-on="پێویستە" data-off="پێویست نییە" data-onstyle="success" data-offstyle="danger">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style="text-align: left;"><label>ژمارە مۆبایل : </label></td>
                                    <td>
                                      <input name="tea_num" type="checkbox" <?php if($feilds['tea_num']!=""){echo 'checked';} ?> data-toggle="toggle" data-on="پێویستە" data-off="پێویست نییە" data-onstyle="success" data-offstyle="danger">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style="text-align: left;"><label>ناونیشان : </label></td>
                                    <td>
                                      <input name="tea_loc" type="checkbox" <?php if($feilds['tea_loc']!=""){echo 'checked';} ?> data-toggle="toggle" data-on="پێویستە" data-off="پێویست نییە" data-onstyle="success" data-offstyle="danger">
                                
                                    </td>
                                  </tr>
                                  <tr>
                                    <td style="text-align: left;"><label>پسپۆڕی : </label></td>
                                    <td>
                                      <input name="tea_desig" type="checkbox" <?php if($feilds['tea_desig']!=""){echo 'checked';} ?> data-toggle="toggle" data-on="پێویستە" data-off="پێویست نییە" data-onstyle="success" data-offstyle="danger">
                                    </td>
                                  </tr>
                                  </tbody>
                              </table>
                          </div>
                        </div>
                      </div>
                      </div>
                      <div class="col-md-4">
                      <div class="panel panel-default">
                        <div class="panel-heading">
                          وانەکان و کتێبخانە (PDF هەموو کاتێک پێویستە لە کتێبخانە گەر چالاکیش نەبێت)
                        </div>
                        <div class="panel-body">
                         <div class="form-group">
                              <table>
                                <thead>
                                  <tr>
                                    <td></td>
                                    <td></td>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td><label>PDF : </label></td>
                                    <td>
                                      <input name="book_pdf" type="checkbox" <?php if($feilds['book_pdf']!=""){echo 'checked';} ?> data-toggle="toggle" data-on="پێویستە" data-off="پێویست نییە" data-onstyle="success" data-offstyle="danger">
                                    </td>
                                  </tr>
                                  <tr>
                                    <td><label>کورتە لەبارەی : </label></td>
                                    <td>
                                      <input name="book_ab" type="checkbox" <?php if($feilds['book_ab']!=""){echo 'checked';} ?> data-toggle="toggle" data-on="پێویستە" data-off="پێویست نییە" data-onstyle="success" data-offstyle="danger">
                                    </td>
                                  </tr>

                                </tbody>
                              </table>
                          </div>
                        </div>
                      </div>
                      </div>
                    </div>
                    </div>

                    </div>
                    <div class="tab-pane fade" id="backup">
                    </div>
        </div>
      </div>
    </div>
    <center><input type="submit" name="sub2" class="btn btn-default" value="زەخیرەکردن"></center>
   </form>
<?php
$db = null;
 include 'inc/foot.php'; ?>