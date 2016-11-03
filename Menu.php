<?php 
$pageTitle="Menu";$currentFile = $_SERVER["PHP_SELF"];$parts = Explode('/', $currentFile);$PageName=$parts[sizeof($parts) - 1];
$PageInfo=array("id"=>$pageTitle,"PName"=>$PageName,"C"=>"0","R"=>"1","U"=>"0","D"=>"0","G"=>"0");
$area='Check'; include_once "Commander.php";$Access= str_split($_SESSION["Access"]);include_once "_menu.php";
//var_dump($d);
?>
<link rel='stylesheet' href='assets/css/bootstrap.min.css'>
<script src='assets/js/jquery.min.js' ></script>
<script src ='assets/js/bootstrap.min.js'></script>
 

 <div id="copyright" style='position: fixed;  bottom: 45px; right: 20px;  margin: auto;  font-size: 8pt;  color: #c0c0c0;  opacity: 0.5;'>            
            Copyright 2016 <a href="#">Adykn</a>. This is Open Source. For license details and to get the code 
 </div>