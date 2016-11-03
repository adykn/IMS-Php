<!DOCTYPE html>
<html>
<head>
<title>Commander</title>
</head>
<?php
ob_start();
include_once "Functions.php"; 
$dt=date('M j\, Y \[ g\:i a\]');
$m1='Oh watch out!:alert alert-warning alert-dismissible fade in'; 
$m2='Oh snap!:alert alert-danger alert-dismissible fade in '; 
$m3='Heads up!:alert alert-info alert-dismissible fade in'; 
$m4='Well done!:alert alert-success alert-dismissible fade in'; 

if(isset($_GET['Msg'])){
	$arr=explode(":",$m4);	
	$msg=$_GET['Msg'];$msgStyle=$arr[1];$preMsg=$arr[0];
	echo "<div Class='".@$msgStyle."' style='position:absolute;width:50%;margin-top:10px;margin-left:25%;' id='msg1' role='alert'>
	<Button type='button' Class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='True'>&times;</span></button>
	<strong>".@$preMsg."</strong> ".@$msg."</div>";

}
if (!isset($area)){
	$step = (isset($_GET['s']) && $_GET['s'] != '') ? $_GET['s'] : '1';

	switch($step){
	 case '1':
	  login();
	  break;
	 case '2':
	  signout();
	  break;
	 case '3':
	  PCC();
	  break;
	 case '4':
	   dirlnk();
	   break;	  
	  
	  default:
	  login();
	}
}else{
	if ($area=='Check'){ 	
		CheckSession($PageInfo); 
	}
	else if ($area=='Msg'){ 	msgbox(); }
	else{ die();}
}

 ?>
<?php function CheckSession($PageInfo){
	ob_start();
	session_start();
	if (isset($PageInfo)){

		if(!mysql_query("DESCRIBE `a_pageinfo`")) {
		 $query = "CREATE TABLE a_pageinfo (id int(11) AUTO_INCREMENT,pageid varchar(255) NOT NULL,urlname varchar(255) NOT NULL,chmod varchar(10) DEFAULT '0000000000' NOT NULL, addtomenu INT(1) NULL DEFAULT 1,submenuid INT NOT NULL DEFAULT 0,PRIMARY KEY (id))";
         $result = mysql_query($query);
		}
		if(!mysql_query("DESCRIBE `a_accesslist`")) {
		 $query = "CREATE TABLE a_accesslist (id int(11) AUTO_INCREMENT,pagefid int DEFAULT 0 NOT NULL, empfid int DEFAULT 0 NOT NULL ,chmod varchar(10) DEFAULT '0000000000' NOT NULL,defultpage varchar(3) DEFAULT 'no' NOT NULL,PRIMARY KEY (id))";
		 $result = mysql_query($query);
		 	Insert("a_accesslist", "pagefid,empfid,chmod", "1,1,'1111111111'");
		}
			
		}
		$chmod="";
			foreach($PageInfo as $x=>$x_value){if($x != "id"&&$x!="PName"){$chmod=$chmod . $x_value;}}
			for ($i=0;$i<13-strlen($chmod);$i++){$chmod=$chmod . "0";} //0000000000
		//print_r($PageInfo);die();	
		if (record_count("a_pageinfo", "pageid", "'".$PageInfo['id']."'")==0){
			h1:
			Insert("a_pageinfo", "pageid,urlname,chmod,addtomenu", "'".$PageInfo['id']."','".$PageInfo['PName']."','".$chmod."',1");
		}elseif (record_count("a_pageinfo", "pageid", "'".$PageInfo['id']."'")>1){
			Delete("a_pageinfo","pageid='".$PageInfo['id']."'");	
			goto h1;
		}
	
	if($_SESSION['email']=="" && $_SESSION['password']=="" && $_SESSION['level']=="" && $_SESSION['eid']=="" )
		{header("Location:Commander.php?Msg=please login");}
	
	
	$empid=$_SESSION['eid'];

	if (isset($PageInfo)){
			$result=$_SESSION['accesslist'];
			//print_r($result);
			$pid=getVal("a_pageinfo", "id", "pageid='".$PageInfo['id']."'"); 
			$rs=search($result, '1', $pid);
			if (sizeof($rs)==0){
			//check if there is a default page 
				
					$rs=search($result, '4', "yes");
					
					if (sizeof($rs)!=0){
						$urlname=getVal("a_pageinfo", "urlname", "id='".$rs[0][1]."'"); 
						header("Location:".$urlname."");	
					}else{
						$rs=search($result, '2', $empid);
						if(sizeof($rs)!=0){
							$urlname=getVal("a_pageinfo", "urlname", "id='".$rs[0][1]."'"); 
							header("Location:".$urlname."");		
						}else{
							header("Location:Commander.php?Msg=Account Blocked");		
						}
						
					}
			}
			$_SESSION["Access"]=$rs[0][3];
			//print_r($rs);
			//echo $rs[0][3];
			//die();
	}
}


?>
<?php function login(){  ?> 
<link rel='stylesheet' href='assets/css/bootstrap.min.css'>
<script src='assets/js/jquery.min.js' ></script>
<script src ='assets/js/bootstrap.min.js'></script>
<?php 

session_start();
$dt=date('M j\, Y \[ g\:i a\]');
$m1='Oh watch out!:alert alert-warning alert-dismissible fade in'; 
$m2='Oh snap!:alert alert-danger alert-dismissible fade in '; 
$m3='Heads up!:alert alert-info alert-dismissible fade in'; 
$m4='Well done!:alert alert-success alert-dismissible fade in';

if(isset($_POST['SignIn']) && $_POST['SignIn'] == "Sign In")
{

$Id=trim($_POST['email']);
$Pwd=trim($_POST['password']);

	if($Id==""||$Pwd=="")
	{
	$arr=explode(":",$m2);	
	$msg='Feild can not be empty.';$msgStyle=$arr[1];$preMsg=$arr[0];
		goto h1;
	}
if(!mysql_query("DESCRIBE `a_siteaccess`")) {
		 $query = "CREATE TABLE a_siteaccess (
		 		id int(11) AUTO_INCREMENT,
		 		email varchar(255) NOT NULL,
		 		password varchar(255) NOT NULL,
		 		enc int(11) DEFAULT 0 ,
		 		`level` varchar(255) NOT NULL,`department` varchar(100) DEFAULT 'IT' NOT NULL,PRIMARY KEY (id))";
         $result = mysql_query($query);
         Insert("a_siteaccess", "`email`, `password`, `enc`, `level`","'4d.kh4n@gmail.com', 'paop', 4, 'Admin'");
		}
$sql=mysql_query("SELECT * FROM `a_siteaccess` WHERE `email`='".$Id."'") or die("query failed");
$rowcount=mysql_num_rows($sql);
	if($rowcount==0){
		$arr=explode(":",$m3);
		$msgStyle=$arr[1];$preMsg=$arr[0];
		$msg='Login Failed.';
		Insert('logs','timestamp,ref,msg',"CURRENT_TIMESTAMP,'".$Id."','Login:Failed|Reason:Bad email'");
		goto h1;
	}	
$rs=mysql_fetch_assoc($sql);
$eid=$rs['id'];
$Enc=$rs['enc'];
$Pwddb=$rs['password'];
$Level=$rs['level'];
$department=$rs['department'];

	if(isset($Enc) && $Enc!=="")
	{
		$EncPwd=Encrypt($Pwd,$Enc);
	}else{
		$arr=explode(":",$m3);	
		$msgStyle=$arr[1];$preMsg=$arr[0];
		$msg='Login Failed.';
		Insert('logs','id,timestamp,ref,msg',"null,CURRENT_TIMESTAMP,'".$Id."','Login:Failed|Reason:Bad Password'");
		goto h1;
	}

	if($EncPwd!==$Pwddb)
	{
		$arr=explode(":",$m3);	
		$msgStyle=$arr[1];$preMsg=$arr[0];
		$msg='Login Failed.';
		Insert('logs','id,timestamp,ref,msg',"null,CURRENT_TIMESTAMP,'".$Id."','Login:Failed|Reason:Bad Password'");
		goto h1;
	}else if ($EncPwd==$Pwddb)	{
		session_start();
		
		$_SESSION['eid']=$eid;
		$_SESSION['email']=$Id;
		$_SESSION['password']=$EncPwd;
		$_SESSION['level']=$Level;
		$_SESSION['enc']=$Enc;
		$_SESSION['department']=$department;
		
		$result = array();
		$res = mysql_query("Select * from a_accesslist where empfid='".$eid."'");
		while($row = mysql_fetch_array($res, MYSQL_NUM)){$result[]=$row;}
		$_SESSION['accesslist'] = $result;
		//var_dump($_SESSION['accesslist']);die();
		
		Insert('logs','id,timestamp,ref,msg',"null,CURRENT_TIMESTAMP,'".$Id."','Login:Successully'");
		$arr=explode(":",$m4);	
		$msgStyle=$arr[1];$preMsg=$arr[0];
		$msg='Login Successully.';
		header("Location:index.php");
		die();
	}
}
h1:
?>
<?php if(isset($msg)){?><center>
<div Class='<?php echo @$msgStyle; ?>' style="position:absolute;width:50%;margin-top:10px;margin-left:25%;" id='msg1' role="alert">
<Button type = "button" Class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="True">&times;</span></button>
<strong><?php echo @$preMsg; ?></strong> <?php echo @$msg?>
</div></center><?php } ?>
<div class="container">
   
<div class="row" style="margin-top:20%">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">
    	<form role="form" action="?" method="POST">
			<fieldset>
				<h2>Please Sign In</h2>
				<hr class="colorgraph">
				<div class="form-group">
                    <input type="email" name="email" id="email" class="form-control input-lg" placeholder="Email Address">
				</div>
				<div class="form-group">
                    <input type="password" name="password" id="password" class="form-control input-lg" placeholder="Password">
				</div>
				<span class="button-checkbox">
					<button type="button" class="btn" data-color="info">Remember Me</button>
                    <input type="checkbox" name="remember_me" id="remember_me" checked="checked" class="hidden">
					<a href="#" class="btn btn-link pull-right" data-target="#pwdModal" data-toggle="modal">Forgot my password</a>
				</span>
				<hr class="colorgraph">
				<div class="row">
					<div class="col-xs-6 col-sm-6 col-md-6">
                        <input type="submit" name="SignIn" class="btn btn-lg btn-success btn-block" value="Sign In">
					</div>
					<div class="col-xs-6 col-sm-6 col-md-6">
						<a href="" class="btn btn-lg btn-primary btn-block disabled">Register</a>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
</div>
</div>  
<?php forgotpassword();?>
<script>
$(document).ready(function() {
$('#msg1').alert();
$('#msg1').fadeTo(2000, 500).slideUp(500, function(){
$('#msg1').slideUp(500);  });
});
</script>
<?php }?>
<?php function forgotpassword(){?>
<!--modal-->
<div id="pwdModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
  <div class="modal-content">
      <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h1 class="text-center">What's My Password?</h1>
      </div>
      <div class="modal-body">
          <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
                          
                          <p>If you have forgotten your password you can reset it here.</p>
                            <div class="panel-body">
                                <fieldset>
                                    <div class="form-group">
                                        <input class="form-control input-lg" placeholder="E-mail Address" name="email" type="email">
                                    </div>
                                    <input class="btn btn-lg btn-primary btn-block" value="Send My Password" type="submit">
                                </fieldset>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
      </div>
      <div class="modal-footer">
          <div class="col-md-12">
          <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
		  </div>	
      </div>
  </div>
  </div>
</div>
<?php }?>
<?php function signout(){
ob_start();
session_start();
session_destroy();
$_SESSION['email']="";
$_SESSION['password']="";
$_SESSION['level']="";
$_SESSION['accesslist']="";
header("Location:Commander.php?Msg=Log+Out+Successully");
}?>

<?php function msgbox(){
	
	echo "<div Class='".@$msgStyle."' style='position:absolute;width:50%;margin-top:10px;margin-left:25%;' id='msg1' role='alert'>
	<Button type='button' Class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='True'>&times;</span></button>
	<strong>".@$preMsg."</strong> ".@$msg."</div>";
	exit();
}?>
<?php function PCC(){
$pageTitle="Password Change Control";$currentFile = $_SERVER["PHP_SELF"];$parts = Explode('/', $currentFile);$PageName=$parts[sizeof($parts) - 1];
$PageInfo=array("id"=>$pageTitle,"PName"=>$PageName,"C"=>"0","R"=>"1","U"=>"0","D"=>"0","G"=>"0");
CheckSession($PageInfo); @$Access= str_split($_SESSION["Access"]);@include_once "_menu.php";
//var_dump($d);

$m1='Oh watch out!:alert alert-warning alert-dismissible fade in'; 
$m2='Oh snap!:alert alert-danger alert-dismissible fade in '; 
$m3='Heads up!:alert alert-info alert-dismissible fade in'; 
$m4='Well done!:alert alert-success alert-dismissible fade in';

	?>
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
<script src='assets/js/jquery.min.js' ></script>
<script src ='assets/js/bootstrap.min.js'></script>
<?php

if($_SESSION['email']!=""){$email=$_SESSION['email'];}
if($_SESSION['enc']!=""){$enc=$_SESSION['enc'];}
$x=1;
$min=pow(10,$x);
$max=pow(10,$x+1)-1;
$rnd=rand($min, $max);

/*
//$_SESSION['email']=$Id;
//$_SESSION['password']=$EncPwd;
//$_SESSION['level']=$Level;
//$_SESSION['enc']=$Enc;
*/


if (isset($_POST['submit']) && $_POST['submit'] == "Change Password")
{
	if($_POST['password2']==$_POST['password1']){
	$WhereCondition="`email`='".$email."' AND `password`='".Encrypt($_POST['password0'],$enc)."' ";
	$result=mysql_query("SELECT * FROM `a_siteaccess` Where ".$WhereCondition."") or die ("query failed here");
	$num_rows = mysql_num_rows($result);
	
		if ($num_rows!=0 || $num_rows>1)
		{
		$sql="Update `a_siteaccess` set `password`='".Encrypt($_POST['password2'],$_POST['enc'])."',`enc`='".$_POST['enc']."' WHERE ".$WhereCondition."";
		
		$query=mysql_query($sql);
		if($query)
			{
			$_SESSION['email']="";
			$_SESSION['password']="";
			$_SESSION['level']="";
			$_SESSION['enc']="";
			}
			else{
				$arr=explode(":",$m2)	;
				$msgStyle=$arr[1];$preMsg=$arr[0];
				$msg="error: SQL";}
		}else{
				$arr=explode(":",$m2)	;
				$msgStyle=$arr[1];$preMsg=$arr[0];
				$msg="error: Invalid Data";
			}
	}else{
			$arr=explode(":",$m2)	;
			$msgStyle=$arr[1];$preMsg=$arr[0];
			$msg="error: Password Not Verified";}
}
?>
<?php if(isset($msg)){?><center>
<div Class='<?php echo @$msgStyle; ?>' style="position:absolute;width:50%;margin-top:10px;margin-left:25%;" id='msg1' role="alert">
<Button type = "button" Class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="True">&times;</span></button>
<strong><?php echo @$preMsg; ?></strong> <?php echo @$msg?>
</div></center><?php } ?>
<div class="container">

<div class="row" style="margin-top:15%">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-offset-2 col-md-offset-3">

<form method="post" id="passwordForm" action="?s=3" method="POST">
<fieldset>
				<h2>Change Password</h2>
				<hr class="colorgraph">
				<p class="text-center">Use the form below to change your password. Your password cannot be the same as your username.</p>
<input type="password" class="input-lg form-control" name="password0" id="password0" placeholder="Old Password" autocomplete="off">

<div class="col-sm-6">
<input type="hidden" name="oenc" value="<?php echo @$enc;?>">
<input type="hidden" name="enc" value="<?php echo @$rnd;?>">
<br>
</div>

<input type="password" class="input-lg form-control" name="password1" id="password1" placeholder="New Password" autocomplete="off">
<div class="row">
<div class="col-sm-6">
<span id="5char" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> 5 Characters Long<br>
<span id="ucase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One Uppercase Letter
</div>
<div class="col-sm-6">
<span id="lcase" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One Lowercase Letter<br>
<span id="num" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> One Number
</div>
</div>
<input type="password" class="input-lg form-control" name="password2" id="password2" placeholder="Repeat Password" autocomplete="off">
<div class="row">
<div class="col-sm-12">
<span id="pwmatch" class="glyphicon glyphicon-remove" style="color:#FF0004;"></span> Passwords Match
</div>
</div>
<input type="submit" class="col-xs-12 btn btn-primary btn-load btn-lg" data-loading-text="Changing Password..." name="submit" value="Change Password">
</fieldset>
</form>
</div><!--/col-sm-6-->
</div><!--/row-->
</div>
<div class="footer navbar-fixed-bottom " style="padding:10px;background:#f7f7f7;text-align:right;">
<a href="menu.php"  style="margin-right:25px;margin-left:25px;">Menu</a> 
<a href="Commander.php?s=2" style="margin-right:25px;margin-left:25px;" >Sign Out</a>
</div>
<script>
$("input[type=password]").keyup(function(){
    var ucase = new RegExp("[A-Z]+");
	var lcase = new RegExp("[a-z]+");
	var num = new RegExp("[0-9]+");
	
	if($("#password1").val().length >= 5){
		$("#5char").removeClass("glyphicon-remove");
		$("#5char").addClass("glyphicon-ok");
		$("#5char").css("color","#00A41E");
	}else{
		$("#5char").removeClass("glyphicon-ok");
		$("#5char").addClass("glyphicon-remove");
		$("#5char").css("color","#FF0004");
	}
	
	if(ucase.test($("#password1").val())){
		$("#ucase").removeClass("glyphicon-remove");
		$("#ucase").addClass("glyphicon-ok");
		$("#ucase").css("color","#00A41E");
	}else{
		$("#ucase").removeClass("glyphicon-ok");
		$("#ucase").addClass("glyphicon-remove");
		$("#ucase").css("color","#FF0004");
	}
	
	if(lcase.test($("#password1").val())){
		$("#lcase").removeClass("glyphicon-remove");
		$("#lcase").addClass("glyphicon-ok");
		$("#lcase").css("color","#00A41E");
	}else{
		$("#lcase").removeClass("glyphicon-ok");
		$("#lcase").addClass("glyphicon-remove");
		$("#lcase").css("color","#FF0004");
	}
	
	if(num.test($("#password1").val())){
		$("#num").removeClass("glyphicon-remove");
		$("#num").addClass("glyphicon-ok");
		$("#num").css("color","#00A41E");
	}else{
		$("#num").removeClass("glyphicon-ok");
		$("#num").addClass("glyphicon-remove");
		$("#num").css("color","#FF0004");
	}
	
	if($("#password1").val() == $("#password2").val()){
		$("#pwmatch").removeClass("glyphicon-remove");
		$("#pwmatch").addClass("glyphicon-ok");
		$("#pwmatch").css("color","#00A41E");
	}else{
		$("#pwmatch").removeClass("glyphicon-ok");
		$("#pwmatch").addClass("glyphicon-remove");
		$("#pwmatch").css("color","#FF0004");
	}
});

$(document).ready(function() {
$('#msg1').alert();
$('#msg1').fadeTo(2000, 500).slideUp(500, function(){
$('#msg1').slideUp(500);  });
});

</script>
<?php }?>
<?php function dirlnk(){
if ($handle = opendir('.')) {
echo "<ul>";
    while (false !== ($entry = readdir($handle))) {

        if ($entry != "." && $entry != "..") {

            echo "<li><a href='$entry'>$entry</a></li>";
        }
    }
echo "</ul>";
    closedir($handle);
}
	}?>