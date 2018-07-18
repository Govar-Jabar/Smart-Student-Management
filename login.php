<?php
// if(isset($_COOKIE['id']) AND $_COOKIE['id']!=""){ header('Location: index.php'); exit; }
// if(isset($_COOKIE['d']) AND $_COOKIE['d']!=""){ header('Location: index.php'); exit; }
require './conn.php';
include('class.token.php');

// echo password_hash("govar", PASSWORD_BCRYPT);
if( isset($_COOKIE[sha1('code')]) AND $_COOKIE[sha1('code')] !=""){ header('Location: index.php'); exit; }
if(isset($_POST['sub'])) {
  if(!empty($_POST['user']) && !empty($_POST['pass']) && !empty($_POST['token'])){
    if(Token::check($_POST['token'])){

      $user = output($_POST['user']);
      $pass = output($_POST['pass']);
      $error = "";

      $code = sha1(uniqid(rand(1,9999)));
      // $code = sha1(openssl_random_pseudo_bytes(26).uniqid(rand(1,9999)));

      $stm = $db->prepare("SELECT id,user,pass,token FROM account WHERE user=:user");
      $stm->bindParam(":user", $user, PDO::PARAM_STR);
      $stm->execute();
      $fetch = $stm->fetch(PDO::FETCH_OBJ);
      $rowCount = $stm->rowCount();
      if($rowCount > 0){
        if(password_verify($pass, $fetch->pass)){
            //Set user code
            $stm = $db->prepare("UPDATE account SET token=:code WHERE id=:id");
            $stm->bindParam(":code", $code, PDO::PARAM_STR);
            $stm->bindParam(":id", $fetch->id, PDO::PARAM_STR);
            $stm->execute();
            $stm1 = $db->prepare("UPDATE account SET last_login='".date('Y-m-d h:i:sa')."' WHERE id=:id");
            $stm1->bindParam(":id", $fetch->id, PDO::PARAM_STR);
            $stm1->execute();
            //Set Cookie
            $n = sha1("code");
            $v = $code;
            $t = time() + (86400 * 30 * 1);
            setcookie($n, $v, $t, "/",null,null,true);
            header("Location: index.php");
            exit();
        }else{
          $error = 'وشەی نهێنی هەڵەیە';
        }
      }else{
        $error = 'ناوی بەکارهێنەر هەڵەیە';
      }
    }else{
      $error = "کێشەیەك ڕویدا، تکایە دووبارە هەوڵ بدەدوە";
    }
  }else{
    $error = "هەموو خانەکان بە دروستی پڕ بکەوە";
  }
} 

$db = null;

?>
<!DOCTYPE html>
<html lang="en" >
<head>
  <meta charset="UTF-8">
  <title>چونەژورەوە</title>
      <link rel="stylesheet" href="assets/css/style.css">
      <link href="assets/css/font-awesome.css" rel="stylesheet" />
</head>

<body>
  
<div class="container">
  <div class="info">
    <h1>چونەژورەوە</h1>
  </div>
</div>
<div class="form">
  <div class="thumbnail"><img src="assets/img/login.png"/></div>
  <a onclick="document.getElementById('user').value='admin';document.getElementById('pass').value='1234';" class="btn btn-success btn-xs">بەڕێوبەر</a>
  <a onclick="document.getElementById('user').value='akam';document.getElementById('pass').value='1234';" class="btn btn-info btn-xs">مامۆستا</a>
  <a onclick="document.getElementById('user').value='akam_xalid';document.getElementById('pass').value='1234';" class="btn btn-primary btn-xs">خوێندکار</a>
  <form class="login-form" action="" method="post">
    <input name="user" id="user" type="text" placeholder="ناوی بەکارهێنەر"/>
    <input name="pass" id="pass" type="password" placeholder="وشەی نهێنی"/>
    <input type="hidden" name="token" value="<?php echo Token::create(); ?>">
    <button name="sub">چوونەژورەوە</button>
    <p class="message">
    <?=@$error;?>
    </p>
  </form>
</div>
</body>
</html>
