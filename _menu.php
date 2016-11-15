<?php 
/*$currentFile = $_SERVER["PHP_SELF"];$parts = Explode('/', $currentFile);$PageName=$parts[sizeof($parts) - 1];
$PageInfo=array("id"=>"AdminDashboard","PName"=>$PageName,"C"=>"0","R"=>"1","U"=>"0","D"=>"0","G"=>"0");
$area='Check'; include "Commander.php";$Access= str_split($_SESSION["Access"]);
*///var_dump($Access);
?>
<link rel='stylesheet' href='assets/css/bootstrap.min.css'>
<script src='assets/js/jquery.min.js' ></script>
<script src ='assets/js/bootstrap.min.js'></script>

<style>
nav {   margin-top: -12px; margin-left:-30px;float: left; margin-right: 10px;}
nav ul ul {             display: none; }
nav ul li:hover > ul {  background: #3e8e41;  display: block;  }
nav ul {                list-style: none;    position: relative;    display: inline-table; }
nav ul:after {          content: ""; clear: both; display: block;    }
nav ul li {             background: #3e8e41;z-index: 1000;  }
nav ul li:hover {       background: #3e8e41;  }
nav ul li:hover a {     color: #000;  background-color: #f9f9f9;    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);}
nav ul li a {           display: block; padding: 20px ;   color: #fff; text-decoration: none;  box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.1);}
nav ul ul {             background: #f7f7f7; border-radius: 0px; padding: 0; position: absolute; box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2); top: 100%;color: #c0c0c0;  margin-top: -2px; width: 200px; }
nav ul ul li {          float: none; position: relative; color: #c0c0c0;}

nav ul ul li a {        padding: 15px;color: #fff; }   
nav ul ul li a:hover {  background: #fff;}
nav ul ul ul {          position: absolute; left: 100%; top:0;  }
        
</style>


<nav>
    <ul>
        <li><a href="Menu.php">Menu</a>
                <ul>
            <?php 
            $queryp=@mysql_query('SELECT * FROM `a_accesslist` where empfid='.$_SESSION['eid']) or die ('query failed');
            While ($rs=mysql_fetch_assoc($queryp)){
                $cond='id='.$rs["pagefid"];
                $addtomenu=getVal('a_pageinfo','addtomenu',$cond);
            if($addtomenu==1){  
            $urlname=getVal('a_pageinfo','urlname',$cond);
            $pageid=getVal('a_pageinfo','pageid',$cond);
            echo "<li><a href='".$urlname."?'>".$pageid."</a>";
            //echo "<ul>";
            //echo "<li><a>asdf</a></li>"
            //echo "<li><a>asdf</a></li>"
            //echo "<li><a>asdf</a></li>"
            //echo "</ul>";
            echo "</li>";
            }
            }
            ?>
            
            <li><a href="#">Setting</a>
                     <ul>
                        <li><a href='Commander.php?s=3'>PCC</a></li> 
                        <li><a href='Commander.php?s=4'>Dir</a></li> 
                        <li><a href='Commander.php?s=2'>sign out</a></li>
                    </ul>
                </li>
            </ul>
        </li>
        
    </ul>
</nav> 



<div class="breadcrumb">
  <a class="breadcrumb-item" href="#">Home</a> /
  <a class="breadcrumb-item" href="#">Logistics</a> /
  <a class="breadcrumb-item" href="#">IT</a> /
  <span class="breadcrumb-item active">Item Card</span> /
</div>


<div class="footer navbar-fixed-bottom " style="padding:10px;background:#f7f7f7;text-align:right;">
<a href="Commander.php?s=3"  style="margin-right:25px;margin-left:25px;">PCC</a> 
<a href="Commander.php?s=2" style="margin-right:25px;margin-left:25px;" >Sign Out</a>
</div>




    