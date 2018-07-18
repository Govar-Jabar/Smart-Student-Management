<?php
if (isset($_POST['title'])) {
require 'conn.php';
require 'inc/function.php';
// global $das;
// if ($das!=1) {
//    header('HTTP/1.0 403 Forbidden');
//    exit; 
// }
                $title=@output($_POST['title']);
                $status=@output($_POST['status']);
                $loading=@output($_POST['loading']);
                $phone=@output($_POST['phone']);
                $email=@output($_POST['email']);
                $loc=@output($_POST['loc']);
                $himg=@output($array['i']);
                $ex_user=@output($_POST['ex_user']);
                $ex_att=@output($_POST['ex_att']);

                //student feilds
                $stu_img=@output($_POST['stu_img']);
                $stu_num=@output($_POST['stu_num']);
                $stu_bl=@output($_POST['stu_bl']);
                $stu_relig=@output($_POST['stu_relig']);
                $stu_loc=@output($_POST['stu_loc']);
                $stu_chat=@output($_POST['stu_chat']);
                //teacher feilds
                $tea_img=@output($_POST['tea_img']);
                $tea_num=@output($_POST['tea_num']);
                $tea_desig=@output($_POST['tea_desig']);
                $tea_relig=@output($_POST['tea_relig']);
                $tea_loc=@output($_POST['tea_loc']);
                //book feilds
                $book_img=@output($_POST['book_img']);
                $book_pdf=@output($_POST['book_pdf']);
                $book_ab=@output($_POST['book_ab']);


                $array=array();
                $feilds=array();
                if (isset($_POST)) {
                    upload();
                //General Settings
                $array["stu_chat"]=$stu_chat;
                $array["t"]=$title;
                $array["s"]=$status;
                $array["loading"]=$loading;
                $array["p"]=$phone;
                $array["e"]=$email;
                $array["i"]=$himg;
                $array["ex_att"]=$ex_att;
                $array["ex_user"]=$ex_user;
                if($uploadOk==1){
                  $array["i"]=$img;
                }
                $array["l"]=$loc;
                $array = serialize($array);

                //Feild Settings Student
                $feilds["stu_loc"]=$stu_loc;
                $feilds["stu_relig"]=$stu_relig;
                $feilds["stu_bl"]=$stu_bl;
                $feilds["stu_num"]=$stu_num;
                $feilds["stu_img"]=$stu_img;

                //Feild Settings Teacher
                $feilds["tea_loc"]=$tea_loc;
                $feilds["tea_relig"]=$tea_relig;
                $feilds["tea_desig"]=$tea_desig;
                $feilds["tea_num"]=$tea_num;
                $feilds["tea_img"]=$tea_img;                

                //Feild Settings Teacher
                $feilds["book_ab"]=$book_ab;
                $feilds["book_pdf"]=$book_pdf;
                $feilds["book_img"]=$book_img;
                $feilds = serialize($feilds);

                    for ($i = 1; $i <= 2 ; $i++) {
                      if ($i==1) {
                        
                          $stm = $db->prepare("UPDATE setting SET slug='$array' WHERE id=1;");

                        $stm->bindParam(":feilds", $feilds, PDO::PARAM_STR);
                        $stm->execute();
                      }else {
                        $stm = $db->prepare("UPDATE setting SET slug='$feilds' WHERE id=2;");
                        $stm->bindParam(":feilds", $feilds, PDO::PARAM_STR);
                        $stm->execute();
                      }
                      
                    }
                    modal("سوپاس","ڕێکخستنەکان بەسەرکەوتویی نوێکرانەوە.");
                    //direct(home);
                  }
                  
$db = null;
}