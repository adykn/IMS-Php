<?php 
$pageTitle="Menu";$currentFile = $_SERVER["PHP_SELF"];$parts = Explode('/', $currentFile);$PageName=$parts[sizeof($parts) - 1];
$PageInfo=array("id"=>$pageTitle,"PName"=>$PageName,"C"=>"0","R"=>"1","U"=>"0","D"=>"0","G"=>"0");
$area='Check'; include_once "Commander.php";$Access= str_split($_SESSION["Access"]);include_once "_menu.php";
//var_dump($d);
?>
<link rel='stylesheet' href='assets/css/bootstrap.min.css'>
<script src='assets/js/jquery.min.js' ></script>
<script src ='assets/js/bootstrap.min.js'></script>
<style>
#tiles{
	width: 20%;
	height: 150px;
	float: left;
	margin: 2%;
	
	text-align: center;
	border-radius: 4px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5) inset;
    border:1px solid #f7f7f7;
    box-shadow:5px 5px 10px rgba(0,0,0,0.2);
}
#tiles:hover{
box-shadow:1px 1px 2px rgba(0,0,0,0.2);	
}
 .panel-profile-img:hover { box-shadow:1px 1px 1px rgba(0,0,0,0.2);}

 .panel-profile-img {
    max-width: 70px;
    height:70px;
    margin-top: -40px;
    margin-bottom: 5px;
    border: 1px solid #f7f7f7;
    border-radius: 100%;
    box-shadow:5px 5px 10px rgba(0,0,0,0.2);
    background-color:#f7f7f7;}
</style>
<div style="width:100%;height: 50px;"> </div>
<center>
 <?php 
 			

            $queryp=@mysql_query('SELECT * FROM `a_accesslist` where empfid='.$_SESSION['eid']) or die ('query failed');
            While ($rs=mysql_fetch_assoc($queryp)){
                $cond='id='.$rs["pagefid"];
                $addtomenu=getVal('a_pageinfo','addtomenu',$cond);
            if($addtomenu==1){  
            $urlname=getVal('a_pageinfo','urlname',$cond);
            $pageid=getVal('a_pageinfo','pageid',$cond);
            echo "<a href='".$urlname."?'><div id='tiles'>
			<div class='panel-heading' style='height:50%;background-image: url(https://image.freepik.com/free-vector/modern-abstract-background_1048-1003.jpg);background-size: cover'></div>
			<img class='panel-profile-img' src='https://www.dropbox.com/s/6v7ujosgqj0xr7d/4logo.png?raw=1'><br>
            ".$pageid."</div></a>";
	        }
            }


?>


            </center>

<div style="position: absolute;bottom: 55px;right: 10px;">            

git clone http://github.com/adykn/project.git<br>
______________<br>
git status<br>
________________<br>
git pull<br>
git add fileName.html | git add -A<br>
git commit -m "y the file was added"<br>
git push   <br>

</div>
 <div id="copyright" style='position: fixed;  bottom: 45px; right: 20px;  margin: auto;  font-size: 8pt;  color: #c0c0c0;  opacity: 0.5;'>            
            Copyright 2016 <a href="https://github.com/adykn">Adykn</a>. This is Open Source. For license details and to get the code 
 </div>