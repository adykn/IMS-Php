<?php $pageinfo='Employees';?><?php
                $currentFile = $_SERVER['PHP_SELF'];$parts = Explode('/', $currentFile);$PageName=$parts[sizeof($parts) - 1];
                $PageInfo=array('id'=>$pageinfo,'PName'=>$PageName,'C'=>'1','R'=>'1','U'=>'1','D'=>'1','G'=>'1');
                $area='Check'; @include_once 'Commander.php';$Access= str_split($_SESSION['Access']);@include_once '_menu.php';
                Breadcrumbs($pageinfo,$currentFile);
                //var_dump($Access);?>
            <?php include_once 'Functions.php';@session_start(); ?> 

				<?php
					if (isset($_POST['Task']) && $_POST['Task']=='inline'  )
					{  	$error = false;
						$colVal = '';
						$colIndex = $rowId = 0;

						$msg = array('status' => !$error, 'msg' => 'Failed! updation in mysql');

						if(isset($_POST)){
						if(isset($_POST['val']) && !empty($_POST['val']) && !$error) {
						$colVal = $_POST['val'];
						$error = false;

						} else {
						$error = true;
						}
						if(isset($_POST['Col']) && !$error) {
						$Col = $_POST['Col'];
						$error = false;
						} else {
						$error = true;
						}
						if(isset($_POST['id']) && $_POST['id'] > 0 && !$error) {
						$rowId = $_POST['id'];
						$error = false;
						} else {
						$error = true;
						}

						if(!$error) {
						$sql = "UPDATE employees SET ".$Col." = '".$colVal."' WHERE id='".$rowId."'";
						$status = mysql_query($sql) Or die("database error: ". mysql_error($conn));
						$msg = array('error' => $error, 'msg' => 'Success! updation ');
						} else {
						$msg = array('error' => $error, 'msg' => 'Failed! updation');
						}
						}
						// send data as json format
						echo json_encode($msg);
						die();	
					}
					If (isset($_GET['Task']) && $_GET['Task']=='Delete' && isset($_GET['ref']))
					{  
						$id=deStr($_GET['ref']);
						$ql='DELETE FROM `employees` WHERE id='.$id; 
						$result=mysql_query($ql);
						if($result){ $msg='Record Removed Successfully.';$msgStyle='alert alert-success alert-dismissible fade in';$preMsg='Well done!'; 
						} else{ $msg='Records werent Removed.';$msgStyle='alert alert-success alert-dismissible fade in';$preMsg='Oh snap!';}
										
					}
					if (isset($_POST['Task']) && $_POST['Task']=='Delete' && isset($_POST['x']))
					{  	
						$x=$_POST['x'];
						$arr = explode('|', $x); 
						//var_dump($arr);die();
					for( $i = 0; $i<sizeof($arr); $i++ ) {
			
						$ql='DELETE FROM `employees` WHERE id='.deStr($arr[$i]); 
						$result=mysql_query($ql);
						if($result){$msg='Records Removed Successfully.';$msgStyle='alert alert-success alert-dismissible fade in';$preMsg='Well done!'; 
						} else{ $msg='Records werent Removed.';$msgStyle='alert alert-success alert-dismissible fade in';$preMsg='Oh snap!';}
						echo $msg.'<br>';
						}
						
						die();	
					}
						if(isset($_GET['Area']) && $_GET['Area']=='Entry'){
							$activeLi1='';  	
							$activeLi2="class='active'";
							$activeLi3=''; 
							$activetab1='';	
							$activetab2='active';	
							$activetab3=''; 
							$btn1='Cancel'; $btn2='Update';

						}else if(isset($_GET['AreaD'])){
							$activeLi1='';
							$activeLi2=''; 
							$activeLi3="class='active'";     
							$activetab1='';	
							$activetab2=''; 
							$activetab3='active'; 
							$btn1='Reset'; $btn2='Save';

						}else{
							$activeLi1="class='active'";
							$activeLi2=''; 
							$activeLi3=''; 
							$activetab1='active'; 
							$activetab2=''; 
							$activetab3='';	
							$btn1='Reset'; $btn2='Save';
						}	
				?>
<meta http-equiv='X-UA-Compatible' content='IE=9' >
<meta name ='viewport' content='width=device-width, initial-scale=1'>
<meta http-equiv='X-UA-Compatible' content='IE=9' >
<link rel='stylesheet' href='assets/css/bootstrap.min.css'>
<script src='assets/js/jquery.min.js' ></script>
<script src ='assets/js/bootstrap.min.js'></script><script src='assets/js/jquery.dataTables.min.js' ></script>
<script src='assets/js/dataTables.bootstrap.min.js' ></script>
  <div class='container'>
      <div style="float:right;width:70%;"><?php  Imagechnge(CreateSmlTile($pageinfo));?></div><br><br>
      <h2><?php echo @$pageinfo;?></h2>
     
            <ul class='nav nav-tabs'>
              <li <?php echo $activeLi1?>><a data-toggle='tab' href='#tab1'>Records</a></li>
              <li <?php echo $activeLi2?>><a data-toggle='tab' href='#tab2'>New Entry</a></li>
              <li <?php echo $activeLi3?>><a data-toggle='tab' href='#tab3'>Detail</a></li>
      </ul>
      <div class='tab-content'>
              <div id='tab2' class='tab-pane fade in <?php echo $activetab2;?>'>
<?php 
if (isset($_POST['id'])){
            $id=(!empty($_POST['id']))?$_POST['id']:0;
            $ref=(!empty($_POST['ref']))?$_POST['ref']:0;
            $code=(!empty($_POST['code']))?$_POST['code']:'Unspecified';
            $name=(!empty($_POST['name']))?$_POST['name']:'Unspecified';
            $father=(!empty($_POST['father']))?$_POST['father']:'Unspecified';
            $cnic=(!empty($_POST['cnic']))?$_POST['cnic']:'Unspecified';
            
$msg='';
$msgStyle='alert alert-warning alert-dismissible fade in'; 
            //Oh snap!:alert alert-danger alert-dismissible fade in 
            //Heads up!:alert alert-info alert-dismissible fade in
            //Well done!:alert alert-success alert-dismissible fade in
$preMsg='Warning!'; 
       $f='`id`,`ref`,`code`,`name`,`father`,`cnic`';
       $v="NULL, ".$ref.", '".$code."', '".$name."', '".$father."', '".$cnic."'";
        //echo @$_SESSION['Ssid'].'-'.$_POST['Ssid'];
        If ( @$_SESSION['Ssid']!=$_POST['Ssid'])
       	GoTo h1;
        If($id!=0){
		    $arr1 = explode(',', $f); 
            $arr2 = explode(',', $v); 
		    $str=''; 
		    for( $i = 0; $i<sizeof($arr1); $i++ ) { if($arr2[$i]!='NULL'){ $str= $str.$arr1[$i].'='.$arr2[$i].',';	} }
		    if (substr($str,strlen($str)-1,1)==','){$str=substr($str,0,strlen($str)-1);}
		    $qry='Update `employees` SET '.$str.' where id='.$id;
		    $msg='Data successfully Updated';
		
		}else{
			$qry='INSERT INTO `employees`('. $f .') values ('. $v .')';
		    $msg='Data successfully Inserted';
		}
     	$result=mysql_query($qry);
		
		  if($result){ $msgStyle='alert alert-success alert-dismissible fade in';$preMsg='Well done!';@$_SESSION['Ssid'] =rand(1111111111,9999999999); 
            } else{ $msgStyle='alert alert-success alert-dismissible fade in';$preMsg='Oh snap!';}	
		 
	    }
h1:
if(isset($_GET['LstId'])){$lstid='WHERE id='.deStr($_GET['LstId']);}else{$lstid='WHERE id=0';}

$queryp=@mysql_query('SELECT * FROM `employees`'.$lstid) or die ('query failed');
$num_rows = mysql_num_rows($queryp);
If ($num_rows == 0) {
         $id=''; 
         $ref=''; 
         $code=''; 
         $name=''; 
         $father=''; 
         $cnic=''; 
         
          }
While ($rs=mysql_fetch_assoc($queryp)){
         $id=$rs['id']; 
         $ref=$rs['ref']; 
         $code=$rs['code']; 
         $name=$rs['name']; 
         $father=$rs['father']; 
         $cnic=$rs['cnic']; 
        
          } 
 if(!isset($_SESSION['Ssid'])) {
 @$_SESSION['Ssid'] =rand(1111111111,9999999999);
 }
 $Ssid= @$_SESSION['Ssid'];
?>
<br>
<?php if(isset($msg)){?><div Class='<?php echo @$msgStyle; ?>' id='msg2' role="alert">
<Button type = "button" Class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="True">&times;</span></button>
<strong><?php echo @$preMsg; ?></strong> <?php echo @$msg?>
</div><?php }?>
<Form Class="form-horizontal" role="form" id='theForm' action="?" method="POST" style='margin-bottom: 100px;'>
<h2> New <?php echo @$pageinfo;?> Entry </h2><hr>
<input type='text' name='Ssid' value='<?php echo $Ssid;?>'  style='float:right;text-align:center;margin:5px' readonly><br><br><input type='hidden' name='id' value='<?php echo $id;?>'>
<div Class="form-group"> 
<Label for="ref" class="col-sm-3 control-label">Ref</label>
<div Class="col-sm-9">
<Select id="ref" name="ref" Class="form-control">
       <?php
       $sql="select id as A, email as B  from a_siteaccess WHERE 1=1";
       $queryp=@mysql_query($sql) or die ('query failed');
       //$num_rows = mysql_num_rows($queryp);
       //If ($num_rows == 0) {         }
       echo "<option value='0'>Please Select</option>";
       while($rs=mysql_fetch_assoc($queryp)){  ?>
       <option value='<?php echo $rs['A'];?>' <?php if (false){echo "Selected";}?> ><?php echo $rs['B'];?></option>
       <?php }?>
</select>
</div>
</div>

<div Class="form-group">
<Label for="Code" class="col-sm-3 control-label">Code</label>
<div Class="col-sm-9">
<input type='text'  id="code"  name="code" placeholder="Code" Class="form-control required "  value="<?php echo $code;?>">
</div>
</div>

<div Class="form-group">
<Label for="Name" class="col-sm-3 control-label">Name</label>
<div Class="col-sm-9">
<input type='text'  id="name"  name="name" placeholder="Name" Class="form-control required "  value="<?php echo $name;?>">
</div>
</div>

<div Class="form-group">
<Label for="Father" class="col-sm-3 control-label">Father</label>
<div Class="col-sm-9">
<input type='text'  id="father"  name="father" placeholder="Father" Class="form-control required "  value="<?php echo $father;?>">
</div>
</div>

<div Class="form-group">
<Label for="Cnic" class="col-sm-3 control-label">Cnic</label>
<div Class="col-sm-9">
<input type='text'  id="cnic"  name="cnic" placeholder="Cnic" Class="form-control required "  value="<?php echo $cnic;?>">
</div>
</div>


<div class="form-group">
<div class="col-sm-9 col-sm-offset-3">
<button type="Reset" class="btn btn-warning btn-block" id="Reset" <?php if($btn1!='Reset'){;?> onclick="location.href='?';" <?php }?> ><?php echo $btn1;?></button>
</div>
</div>
<div class="form-group">
<div class="col-sm-9 col-sm-offset-3">
<button type="submit" class="btn btn-primary btn-block" id="submit"  ><?php echo $btn2;?></button>
</div>
</div>
</form>
              
              
              </div>
              <div id='tab1' class='tab-pane fade in <?php echo $activetab1;?>'>
<br>
<?php if(isset($msg)){?><div Class='<?php echo @$msgStyle; ?>' id='msg1' role="alert">
<Button type = "button" Class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="True">&times;</span></button>
<strong><?php echo @$preMsg; ?></strong> <?php echo @$msg?>
</div><?php }?>
<center><div style='margin-top:50px;'><table id ='Tb1' class='table table-striped table-bordered dataTable' cellspacing='0' width='80%' role='grid' >
<thead><tr role='row'>
<th tabindex='0' aria-controls='Tb1' rowspan='1' colspan='1'><a href='#' OnClick='DelSelected();'><img src='assets/img/Del.gif'></a></th>
   <th class='sorting' tabindex='1' aria-controls='Tb1' rowspan='1' colspan='1'>Id</th>
   <th class='sorting' tabindex='2' aria-controls='Tb1' rowspan='1' colspan='1'>Ref</th>
   <th class='sorting' tabindex='3' aria-controls='Tb1' rowspan='1' colspan='1'>Code</th>
   <th class='sorting' tabindex='4' aria-controls='Tb1' rowspan='1' colspan='1'>Name</th>
   <th class='sorting' tabindex='5' aria-controls='Tb1' rowspan='1' colspan='1'>Father</th>
   <th class='sorting' tabindex='6' aria-controls='Tb1' rowspan='1' colspan='1'>Cnic</th>
   <th class='sorting' tabindex='0' aria-controls='Tb1' rowspan='1' colspan='1'>Edit</th>
</tr></thead>
 <tfoot><tr>
   <th rowspan ='1' colspan='1'><a href='#' OnClick='DelSelected();'><img src='assets/img/Del.gif'></a></th>
   <th rowspan ='1' colspan='1'>Id</th>
   <th rowspan ='1' colspan='1'>Ref</th>
   <th rowspan ='1' colspan='1'>Code</th>
   <th rowspan ='1' colspan='1'>Name</th>
   <th rowspan ='1' colspan='1'>Father</th>
   <th rowspan ='1' colspan='1'>Cnic</th>
   <th rowspan ='1' colspan='1'>Edit</th>
</tr></tfoot><tbody>
<?php   
 	$imgSrc='B-False.png'; 
 	$myqd=@mysql_query('SELECT id,ref,code,name,father,cnic FROM `employees`') or die('query failed .');	
 	While ($rs=mysql_fetch_assoc($myqd)){  
 	//If($rs['status']=='1'){$imgSrc='B-True.png';}else{$imgSrc='B-False.png';}
 	?>
<tr role ='row'>
     <td ><input type='checkbox' name='options' value='<?php echo enStr($rs['id']);?>'></td>
     <td class='sorting_1'><?php echo $rs['id'];?></td>
     <td ><?php echo getVal('a_siteaccess','email','id='.$rs['ref']);?></td>
     <td ><?php echo $rs['code'];?></td>
     <td ><?php echo $rs['name'];?></td>
     <td ><?php echo $rs['father'];?></td>
     <td ><?php echo $rs['cnic'];?></td>
<td ><center>
                 <a href='?LstId=<?php echo enStr($rs['id'])?>&Area=Entry'><img src='assets/img/Edit.png'   ></a> | 
                 <a href='?ref=<?php echo enStr($rs['id'])?>&Task=Delete'><img src='assets/img/Del.gif'     ></a> | 
	                <a href='?ref=<?php echo enStr($rs['id'])?>&&AreaD=Details'><img src='assets/img/copy.gif' ></a> </center> 
</td></tr> 
<?php }?>
</tbody></table> </div></center>
              </div>
              <div id='tab3' class='tab-pane fade in <?php echo $activetab3;?>'>

			<style>
					.current-row{background-color:#B24926;color:#FFF;}
					.current-col{background-color:#1b1b1b;color:#FFF;}
					.tbl-qa{ background-color: #f5f5f5;}
					.tbl-qa th.table-header {padding: 5px;text-align: left;padding:10px;
						background: rgb(245,245,245);
						background: -moz-linear-gradient(left,  rgba(245,245,245,1) 51%, rgba(253,253,253,1) 100%);
						background: -webkit-linear-gradient(left,  rgba(245,245,245,1) 51%,rgba(253,253,253,1) 100%);
						background: linear-gradient(to right,  rgba(245,245,245,1) 51%,rgba(253,253,253,1) 100%);
						filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#f5f5f5', endColorstr='#fdfdfd',GradientType=1 );
					}
					.tbl-qa .table-row td {padding:10px;background-color: #FDFDFD;}
					
					.table-header {
							width:30%;
							padding:10px;
							background: #ededed;
							background: -moz-linear-gradient(left, #ededed 0%, #f6f6f6 53%, #ffffff 100%);
							background: -webkit-gradient(left top, right top, color-stop(0%, #ededed), color-stop(53%, #f6f6f6), color-stop(100%, #ffffff));
							background: -webkit-linear-gradient(left, #ededed 0%, #f6f6f6 53%, #ffffff 100%);
							background: -o-linear-gradient(left, #ededed 0%, #f6f6f6 53%, #ffffff 100%);
							background: -ms-linear-gradient(left, #ededed 0%, #f6f6f6 53%, #ffffff 100%);
							background: linear-gradient(to right, #ededed 0%, #f6f6f6 53%, #ffffff 100%);
							filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#ededed', endColorstr='#ffffff', GradientType=1 );
						}
					 
					#Tb2{
						
						box-shadow:5px 5px 10px rgba(0,0,0,0.2);
						border-radius: 10px;                 
					}
					#ico{width:36px;}
					#lck{background-image: url(assets/img/icon-114-lock.png) ;background-repeat: no-repeat;}
					#edt{background-image: url(assets/img/icon-edit.png);background-repeat: no-repeat}
					.son{background-image: url(assets/img/icon_status_on.png) ;background-repeat: no-repeat;}
					.sof{background-image: url(assets/img/icon_status_off.png);background-repeat: no-repeat}
					
			</style>
			
<center><div style='margin-top:50px;'><div style='float:right;'><a href='?'>Back</a></div><table id ='Tb2' class='tbl-qa' cellspacing='0' width='80%' role='grid' >
<tbody>
<?php   
								if (isset($_GET['Task']) && $_GET['Task']=='Toggle' && isset($_GET['ref']))
									{  
										$col=decode64(@$_GET['c']);	$cv=decode64(@$_GET['cv']);
										$id=deStr(@$_GET['ref']);	$v =decode64(@$_GET['v']);
										$arr = explode(':', $v);	$key=array_search($cv,$arr);
										$nkey=($key+1>sizeof($arr)-1?0:$key+1);  $styleid=($nkey==0?'sof':'son');
										$sql = 'UPDATE employees SET '.$col.' = "'.$arr[$nkey].'" WHERE id='.$id;
										$result=mysql_query($sql);
										If ($result){ 
										//echo '<script>$("col'.$col.'").hide();</script>';
										$msg='Record Updated Successfully.';$msgStyle='alert alert-success alert-dismissible fade in';$preMsg='Well done!'; 
										} else{ $msg='Records werent Updated.';$msgStyle='alert alert-success alert-dismissible fade in';$preMsg='Oh snap!';}
										
									 }
									If (isset($_GET['ref'])){$id=deStr($_GET['ref']);}else{$id='0';}
									$sql="SELECT * FROM `employees` where id=".$id;
									$myqd=@mysql_query($sql) or die('query failed .');	
									$row=mysql_fetch_assoc($myqd);
									$column = @array_keys($row);
									if(sizeof($column)==0){echo '<tr role ="row"><th colspan=2><center>:) <br><br>Go back and click ---> <img src="assets/img/copy.gif"> <--</center></th></tr>';}else{
									$queryp=@mysql_query($sql) or die ('query failed');
									$row=mysql_fetch_assoc($queryp); ?> 
											<tr><th colspan='3' style='padding: 10px;text-align: center'>Full details of the selected items</th></tr>

								<tr role ='row' data-row-id='<?php echo $row['id']?>.' class='table-row'>
								<th class='table-header' valign='top'><?php echo ucfirst('id')?></th>

								<td id ='ico'><div id='lck'>&nbsp;</div></td>
								<td class='editable-col' contenteditable='False'
									oldVal='<?php echo $row['id']?>' Col ='id' >

								<?php echo trim($row['id']); ?></td>	
								</tr>

								<tr role ='row' data-row-id='<?php echo $row['id']?>.' class='table-row'>
								<th class='table-header' valign='top'><?php echo ucfirst('ref')?></th>

								<td id ='ico' class='tdsty'><div id='lck'>&nbsp;</div></td>
								<td class='editable-col' contenteditable='False'
									oldVal='<?php echo $row['ref']?>' Col ='ref' >

								<?php echo trim(getVal('a_siteaccess', 'email', 'id='.$row['ref']));?></td>
														</tr>

								<tr role ='row' data-row-id='<?php echo $row['id']?>.' class='table-row'>
								<th class='table-header' valign='top'><?php echo ucfirst('code')?></th>

								<td id ='ico'><div id='edt'>&nbsp;</div></td>
								<td class='editable-col' contenteditable='True'
									oldVal='<?php echo $row['code']?>' Col ='code' >

								<?php echo trim($row['code']); ?></td>	
								</tr>

								<tr role ='row' data-row-id='<?php echo $row['id']?>.' class='table-row'>
								<th class='table-header' valign='top'><?php echo ucfirst('name')?></th>

								<td id ='ico'><div id='edt'>&nbsp;</div></td>
								<td class='editable-col' contenteditable='True'
									oldVal='<?php echo $row['name']?>' Col ='name' >

								<?php echo trim($row['name']); ?></td>	
								</tr>

								<tr role ='row' data-row-id='<?php echo $row['id']?>.' class='table-row'>
								<th class='table-header' valign='top'><?php echo ucfirst('father')?></th>

								<td id ='ico'><div id='edt'>&nbsp;</div></td>
								<td class='editable-col' contenteditable='True'
									oldVal='<?php echo $row['father']?>' Col ='father' >

								<?php echo trim($row['father']); ?></td>	
								</tr>

								<tr role ='row' data-row-id='<?php echo $row['id']?>.' class='table-row'>
								<th class='table-header' valign='top'><?php echo ucfirst('cnic')?></th>

								<td id ='ico'><div id='edt'>&nbsp;</div></td>
								<td class='editable-col' contenteditable='True'
									oldVal='<?php echo $row['cnic']?>' Col ='cnic' >

								<?php echo trim($row['cnic']); ?></td>	
								</tr>

								<tr role ='row' data-row-id='<?php echo $row['id']?>.' class='table-row'>
								<th class='table-header' valign='top'><?php echo ucfirst('doj')?></th>

								<td id ='ico'><div id='edt'>&nbsp;</div></td>
								<td class='editable-col' contenteditable='True'
									oldVal='<?php echo $row['doj']?>' Col ='doj' >

								<?php echo trim($row['doj']); ?></td>	
								</tr>
<?php }?><tr><th colspan='3' style='padding: 10px;text-align: center'><a href='?'>Back</a></th></tr></tbody></table> </div></center>
              </div>
      </div>
  </div>
<script>
$(document).ready(function() {
$('#Tb1').DataTable();
$('#msg1').alert();
$('#msg1').fadeTo(2000, 500).slideUp(500, function(){
$('#msg1').slideUp(500);  });
$('#msg2').alert();
$('#msg2').fadeTo(2000, 500).slideUp(500, function(){
$('#msg2').slideUp(500);  });

                $('#msg').fadeTo(2000, 500).slideUp(500, function(){
                $('#msg').slideUp(500);  });
                    $('td.editable-col').on('focusout', function() {
                    $tdid=this;
                    $($tdid).css("background","#FDFDFD");
                    $($tdid).css("background","#FFF url(assets/img/loaderIcon.gif) no-repeat right");
                    data = {};
                    data['val'] = $(this).text().trim().replace(/^\s*/,'').replace(/\s*$/,'').replace(" \ r \ n", "\n").replace("\r", "\n").replace("\n", "\\n");
                    data['val'] =data['val'].replace(/\s*'/,'"').replace(/\s*>/,']').replace(/\s*</,'[');
                    data['id'] = $(this).parent('tr').attr('data-row-id');
                    data['index'] = $(this).attr('col-index');
                    data['Col'] = $(this).attr('Col');
                    data['Task']='inline';
                    if($(this).attr('oldVal') === data['val'])
                    {   $($tdid).css("background","#FDFDFD"); $(this).text($(this).attr('oldVal').trim());  return false;}
                    //alert(data['id']);
                    $.ajax({   
                  
                                type: 'POST',  
                                url: '?',  
                                cache:false,  
                                data: data,
                                dataType: 'json',				
                                success: function(response)  
                                {   
                                    //alert(response);
                                   $($tdid).css("background","#FDFDFD");
                                    
                                    if(!response.error) {
                                        $('#msg').removeClass('alert-danger');
                                        $('#msg').addClass('alert-success').html(response.msg);
                                    } else {
                                        $('#msg').removeClass('alert-success');
                                        $('#msg').addClass('alert-danger').html(response.msg);
                                    }
                                    $('#msg').fadeTo(2000, 500).slideUp(500, function(){
                                    $('#msg').slideUp(500);  });
                                }   
                            });
                
                    } );

            
} );

                $('#submit').click(function(e){
     
                 // Declare the function variables - parent form, form URL and the regex for checking the email
                 var $formId = $(this).parents('form');
                 var formAction = $formId.attr('action');
                 var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
 
                 // In preparation for validating the form - Remove any active default text and previous errors
     
                  $('div',$formId).removeClass('error');
                  $('span.error').remove();
 
                  // Start validation by selecting all inputs with the class required
                  $('.required',$formId).each(function(){
                      var inputVal = $(this).val();
                    var $parentTag = $(this).parent();
                    if(inputVal == ''){
                        $parentTag.addClass('error').append('<span class="Error">Required field</span>');
                    }
                  // Run the email validation using the regex for those input items also having class email
                  if($(this).hasClass('email') == true){
                  if(!emailReg.test(inputVal)){
                      $parentTag.addClass('error').append('<span class="Error">Enter a valid email address.</span>');
                  }
                    }
                 });
 
    
                if ($('span.error').length == '0') {
    
                        var form = document.getElementById('theForm');
                            form.style.display = 'none';
                        var processing = document.createElement('span');
                        processing.innerHTML = "<div class='loading'><br><br><center>Processing...!<br><img src='assets/img/loading.gif' alt='' /></center></div>";

                        Form.parentNode.insertBefore(processing, Form);
                        delay(2000);
                        document.getElementById('theForm').submit(); 
                       
                  }
                e.preventDefault();
            });
            
function DelSelected(){
            var x = '';
            var values=new Array();
  
            $.each($("input[name='options']:checked"),function(){
                    values.push($(this).val());
                    x=x + $(this).val() + '|' ;
            });	
     
            //alert(x);
            if(typeof(x) === 'undefined'){x='0 | ';}
            if(x.length == 0){x='0 | ';}
            //alert(x.substr(0, x.length - 3).trim());
            x=x.substr(0, x.length - 3).trim();
            $.ajax({type: 'POST',url: '?', data: {'x':x,'Task':'Delete'}, success: function(result){
                setTimeout(function(){location.reload(); }, 1000); 
                $('#reply').html('<center>'+result+'</center>');    }});
            }
</script>
<div id='reply'></div>