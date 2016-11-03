<?php
if ($_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='127.0.0.1'){
@$conn=mysql_connect("localhost","root","") or die("connection failed");
@mysql_select_db ("db1",$conn) or die("db not found");
}else{
 @$conn=mysql_connect("localhost","ideaorgp_dbadmin","myp1234!@#$") or die("Unable to Connect");
 @mysql_select_db("db1") or die("Could not open the db");
}


function getVal($table, $field, $condition){
$sql = 'SELECT '.$field.' FROM '.$table.' where '.$condition;
$result = mysql_query($sql) or die(mysql_error());
$num_rows = mysql_num_rows($result);
$row = mysql_fetch_assoc($result);
if ($num_rows!=0){
return $row[$field];	
}else{
return 0;	
}
}
function StrClean($string) {
    $string = str_replace(array('<\', \'>'), ' ', $string);
	$string = str_replace(array('[\', \']'), '', $string);
  //$string = preg_replace('/\[.*\]/U', '', $string);
  //$string = preg_replace('/&(amp;)?#?[a-z0-9]+;/i', '-', $string);
  //$string = htmlentities($string, ENT_COMPAT, 'utf-8');
  //$string = preg_replace('/&([a-z])(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig|quot|rsquo);/i', '\\1', $string );
    //$string = preg_replace(array('/[^a-z0-9]/i', '/[-]+/','/@/') , '-', $string);
	$string = trim($string, '-');
    return str_replace('-', ' ' ,$string);   
}
function deStr($u){
		return substr($u,substr($u,0,2)+3,substr($u,2,2));
	}
function enStr($n){
	 $str="";
	 $input=$n;
	 $inputLen=strlen($input);
	 $totalLen=11;
	 $startplace=rand(1,$totalLen);
	 $Randm= rand(1111111111,9999999999);
	 if (strlen($inputLen)==1){$inputLen="0".$inputLen;}
	 if (strlen($startplace)==1){$startplace="0".$startplace;}
	 	 $str=$startplace . $inputLen.substr_replace($Randm, $input, $startplace-1, 0);
	 return $str;
}

function record_count ($table, $column, $value) {
    $query = "SELECT {$column} FROM {$table} WHERE {$column} = {$value}";
    $result = mysql_query($query);
    return mysql_num_rows($result); 
     
}

function Encrypt($PassCode,$EncNum) {
  $nstring = '';
  for($i = 0; $i < strlen($PassCode); $i++) {
    $nstring .= chr(ord(substr($PassCode,$i,$i + 1)) - $EncNum);
  }
  return $nstring;
}

function Insert($Table,$Var,$Values) {
$sadfsql="INSERT INTO `".$Table."` (".$Var.") VALUES (".$Values.")";

$query=mysql_query($sadfsql);
		if($query)
		$msg="Inserted";
		else
		$msg="error inserting";
return $msg;
}
function Update($Table,$Set,$Where){
if ($Where=="")
$Where=1;

$sql="Update `".$Table."` set ".$Set." WHERE ".$Where."";
$query=mysql_query($sql);
if($query)
		$msg="Updated";
		else
		$msg="error updating";
return $msg;
}
function Delete($Table,$Where)
{
$query=mysql_query("DELETE FROM `".$Table."` WHERE ".$Where."");
if($query)
		$msg="Deleted";
		else
		$msg="error deleting";
return $msg;

}
function search($array, $key, $value)
{
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, search($subarray, $key, $value));
        }
    }

    return $results;
}
function CurrentPageUrlName()
{
	$currentFile = $_SERVER["PHP_SELF"];
	$parts = Explode('/', $currentFile);
    return $parts[sizeof($parts) - 1];
}
function encode64($input) {
 return strtr(base64_encode($input), '+/=', '-_,');
}

function decode64($input) {
 return base64_decode(strtr($input, '-_,', '+/='));
}
?>
