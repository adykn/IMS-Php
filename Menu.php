<?php 

$pageinfo="Menu";$currentFile = $_SERVER["PHP_SELF"];$parts = Explode('/', $currentFile);$PageName=$parts[sizeof($parts) - 1];
$PageInfo=array("id"=>$pageinfo,"PName"=>$PageName,"C"=>"0","R"=>"1","U"=>"0","D"=>"0","G"=>"0");
$area='Check'; include_once "Commander.php";$Access= str_split($_SESSION["Access"]);include_once "_menu.php";
Breadcrumbs($pageinfo,$currentFile);
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
	border-radius: 10px;
    -moz-border-radius: 4px;
    -webkit-border-radius: 4px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.5) inset;
    border:1px solid #f7f7f7;
    box-shadow:5px 5px 10px rgba(0,0,0,0.2);
    background: rgba(255, 255, 255, .5);
}
#tiles:hover{
box-shadow:1px 1px 2px rgba(0,0,0,0.2);	
background: #ffffff;
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
 			
        function createIconLnk($submenuid=0){
           $jscript="";
           $ql='SELECT * FROM `a_pageinfo` where addtomenu=1 and submenuid='.$submenuid;
           $queryp=@mysql_query($ql) or die ('query failed');
           $rowcount=mysql_num_rows($queryp);    
       
       if ($rowcount==0) {echo 'There were no sub link found.';}else{
       
           While ($rs=mysql_fetch_assoc($queryp)){
            $pageid=$rs['pageid'];
           if($rs['urlname']=='#'){
            $urlname='?sub='.enStr($rs['id']);
           }else{
            $urlname=$rs['urlname'].'?';
           }
           $jscript=$jscript . " getImg('#T-".$rs['id']."'); ";
            echo "<a href='".$urlname."'><div id='tiles'><div class='panel-heading' id='T-".$rs['id']."' style='height:70%;'></div>".$pageid."</div></a>";
	       
            }
            
            return $jscript;
           }
        }
        if(isset($_GET['sub'])){$sub=deStr($_GET['sub']);}else{$sub=0;}
        $jscript=createIconLnk($sub);

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

 <script type="text/javascript">
    var arr = [<?php echo GetKeyWord()?>]; 
    
        var keyword = arr[Math.floor(Math.random() * (arr.length - 1))];
        
        $(document).ready(function(){
            
           <?php echo $jscript;?>
           getImg('body');
  
        });
    function getImg(id){
        if (id=="body"){keyword="Back and White";}
        $.getJSON("http://api.flickr.com/services/feeds/photos_public.gne?jsoncallback=?",
        {
            tags: keyword,
            tagmode: "any",
            format: "json"
        },
        function(data) {
 
            var rnd = Math.floor(Math.random() * data.items.length);
            var image_src = data.items[rnd]['media']['m'].replace("_m", "_b");

          $(id).css('background-image', "url('" + image_src + "') ");
          $(id).css('background-size', "cover");
         });

    }    

    </script>