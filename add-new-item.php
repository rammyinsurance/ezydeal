<?php
error_reporting(0);
session_start();
date_default_timezone_set('Asia/Calcutta');
require_once("inc/db_connection.php");

$ctodaydate = date("d-m-Y");
$pDate = strtotime($ctodaydate.' +7 day');

$fpDate = date('Y-m-d',$pDate);
$fctodaytime = date("H:i:s");
$fctodaydate = $fpDate.' '.$fctodaytime;

if(!isset($_SESSION['memberID'])){
	header('location:./');
	break;
}
else{
	
$act[6]='act-menu';
$memberID = $_SESSION['memberID'];
$memberEmail = $_SESSION['memberEmail'];

$memberArray = mysql_fetch_array(mysql_query("SELECT * FROM user_registration WHERE uid = '$memberID'"));
$memberFname = ucfirst($memberArray['fname']);
$memberLname = ucfirst($memberArray['lname']);
$memberUname = $memberArray['uname'];
$memberSex = $memberArray['sex'];
$memberDOB = $memberArray['dob'];
$memberMobile = $memberArray['mobile'];
$memberCity = $memberArray['city'];
$memberCountry = $memberArray['country'];
$memberZip = $memberArray['zip'];
$memberCStatus = $memberArray['status_code'];
$memberStatus = $memberArray['status'];
$memberSEmail = $memberArray['email_sent'];
$distributor = $memberArray['distributor'];


if(isset($_GET['err']) && $_GET['err']=='account-confirmation'){
	$err_msg = "<div id='err-msg' style='display:inline-block; margin:0 0 5px 17px; width:712px;'><ul class='messages'><li class='error-msg'><ul><li>ERROR: You can't repost because your email is yet not verified.</li></ul></li></ul></div>";
}

$SC = base64_encode($memberCStatus);
$todaydate = date("Y-m-d H:i:s");
}

define ("MAX_SIZE","1024");
 function getExtension($str) {
         $i = strrpos($str,".");
         if (!$i) { return ""; }
         $l = strlen($str) - $i;
         $ext = substr($str,$i+1,$l);
         return $ext;
 }
$errors=0;

 
if((isset($_SESSION['memberID'])) && ($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['hidfclsdate'])) && (isset($_POST['startprice'])) && (isset($_POST['itemtitle'])) && (isset($_FILES['files']))){
		
$itemtitle=mysql_real_escape_string($_POST['itemtitle']);
$itemdesc=mysql_real_escape_string($_POST['itemdesc']);
$no_of_item=$_POST['no_of_item'];
$startprice=$_POST['startprice'];
$incbidprice=$_POST['incbidprice'];
$isallow=$_POST['is_allow'];
$buynow=$_POST['buynow'];
$shallow=$_POST['sh_allow'];
$shipping=$_POST['shipping'];
$cate_charge=$_POST['cate_charge'];
$closed_dt=mysql_real_escape_string($_POST['hidclsdate']);
$closedate=mysql_real_escape_string($_POST['hidfclsdate']);
$isagree=$_POST['is_agree'];
$typeprod=$_POST['typeprod'];

$codallow=$_POST['cod_allow'];
$opallow=$_POST['op_allow'];

if(($codallow=='0') && ($opallow=='0')){	
	$opallow = 1;
}

/*$city=mysql_real_escape_string($_POST['city']);
$cnt=mysql_real_escape_string($_POST['country']);

$cntRes = mysql_fetch_array(mysql_query("SELECT * FROM country_list WHERE cnid = '$cnt'"));
$country = $cntRes['country_name'];*/

$city = 'Mumbai';
$country = 'India';

$un = $_SESSION['memberID'];
$acCnt = mysql_num_rows(mysql_query("SELECT * FROM user_registration WHERE uid = '$un' AND status = '2'"));

if($acCnt!=0){

if($incbidprice=='' || $incbidprice=='0'){
	$incbidprice = 1;
}


$startdate=date("d-M-Y");
$date_time=date("j-F-y, g:i a");

$selprod=$_POST['selprod'];
$prodconut = mysql_num_rows(mysql_query("SELECT * FROM product_category WHERE status = '1'"));

$a = 1;
$selprodQry = mysql_query("SELECT * FROM product_category WHERE status = '1' ORDER BY pcid ASC");

while($selprodRes = mysql_fetch_array($selprodQry)){
		$sr[$a] = $selprodRes['pcid'];
		$a++;
	}	

for($i=1; $i<=$prodconut; $i++){
	$selsprod2 = 'selsprod-'.$sr[$i];
	$ab = $sr[$i];
	$prdnm[$ab]= $_POST[$selsprod2];
	//$prdnm[$i]= $_POST[$selsprod2];
}

$selsprod=$prdnm[$selprod];

if($selsprod==0 || $selsprod==''){
	$prodsel2 = mysql_fetch_array(mysql_query("SELECT * FROM product_sub_category WHERE pcid = '$selprod' AND sprod_name = 'Other'"));
	$selsprod = $prodsel2['pscid'];
}


if($isallow==0 || $isallow=='')
	{$isallow=0; $buynow=''; $buychck='';}
else{$buychck='checked'; $isallow=1;}

if($shallow==0 || $shallow=='')
	{$shallow=0; $shipping=''; $shpchck='';}
else{$shpchck='checked'; $shallow=1;}

if($isagree==0 || $isagree==''){
	$isagree=0; $actchck='';}
else{$isagree=1; $actchck='checked';}

if($codallow==0 || $codallow=='')
	{$codallow=0; $pmchck1='';}
else{$pmchck1='checked'; $codallow=1;}

if($opallow==0 || $opallow=='')
	{$opallow=0; $pmchck2='';}
else{$pmchck2='checked'; $opallow=1;}


$reg = mysql_query("INSERT INTO items_selling(pcid,pscid,uid,item_title,item_start_price,buy_now_allow,buy_now_price,shipping_cost_allow,shipping_cost,ezy_fees,start_dt,closed_dt,closing_date_time,item_desc,prod_type,increase_bid_value,cod_allow,op_allow,city,country,created_date,modified_date,status,distributor,no_of_item) VALUES ('$selprod','$selsprod','$memberID','$itemtitle','$startprice','$isallow','$buynow','$shallow','$shipping','$cate_charge','$startdate','$closed_dt','$closedate','$itemdesc','$typeprod','$incbidprice','$codallow','$opallow','$city','$country','$date_time','$date_time','$isagree','$distributor','$no_of_item')");

$itemid = mysql_insert_id();


	foreach($_FILES['files']['tmp_name'] as $key => $tmp_name ){	
	
	
	$image =$_FILES["files"]["name"][$key];
	$uploadedfile = $_FILES['files']['tmp_name'][$key];
	
	$file_name = $_FILES['files']['name'][$key];
	$file_tmp =$_FILES['files']['tmp_name'][$key];
     
 
 	if ($image) 
 	{
 	
 		$filename = stripslashes($_FILES['files']['name'][$key]);
 	
  		$extension = getExtension($filename);
 		$extension = strtolower($extension);
		
		$size=filesize($_FILES['files']['tmp_name'][$key]);
		
		
 if(($extension != "jpg") && ($extension != "jpeg") && ($extension != "png") && ($extension != "gif")) 
 	{
		header('location:items-description.php?prodid='.$itemid.'&err=image-extension');
 	}
	
else if($size > MAX_SIZE*2097152)
 	{
		header('location:items-description.php?prodid='.$itemid.'&err=image-size-limit');
 	}
	
else{

if($extension=="jpg" || $extension=="jpeg" )
{
$uploadedfile = $_FILES['files']['tmp_name'][$key];
$src = imagecreatefromjpeg($uploadedfile);

}
else if($extension=="png")
{
$uploadedfile = $_FILES['files']['tmp_name'][$key];
$src = imagecreatefrompng($uploadedfile);
}
else 
{
$src = imagecreatefromgif($uploadedfile);
}

list($width,$height)=getimagesize($uploadedfile);

$newwidth1=135;
$newheight1=135;
$tmp1=imagecreatetruecolor($newwidth1,$newheight1);

$newwidth2=56;
$newheight2=56;
$tmp2=imagecreatetruecolor($newwidth2,$newheight2);


imagecopyresampled($tmp1,$src,0,0,0,0,$newwidth1,$newheight1,$width,$height);
imagecopyresampled($tmp2,$src,0,0,0,0,$newwidth2,$newheight2,$width,$height);

$tm = time();

$filename = $tm.$file_name;

$query=mysql_query("INSERT INTO items_selling_img(item_id,pic_name) VALUES('$itemid','$filename')");

move_uploaded_file($file_tmp,"catalog/product/uploads/".$filename);
$filename1 = "catalog/product/uploads/items_135x135/".$filename;
$filename2 = "catalog/product/uploads/items_small_56x56/".$filename;

imagejpeg($tmp1,$filename1,100);
imagejpeg($tmp2,$filename2,100);

imagedestroy($src);
imagedestroy($tmp1);
imagedestroy($tmp2);
  }
 }
}

if(isset($reg)){
header('location:items-description.php?prodid='.$itemid.'&msg=successfully-add'); }
/*else{
header('location:add-new-item.php?msg=error'); }*/
 }
 
 else{
	  header('location:add-new-item.php?err=account-confirmation');
	  break;
  }
}

else if((isset($_SESSION['memberID'])) && ($_SERVER['REQUEST_METHOD'] == 'POST') && (isset($_POST['hidfclsdate'])) && (isset($_POST['startprice'])) && (isset($_POST['itemtitle']))){
	
$itemtitle=mysql_real_escape_string($_POST['itemtitle']);
$itemdesc=mysql_real_escape_string($_POST['itemdesc']);
$no_of_item = $_POST['no_of_item'];
$startprice=$_POST['startprice'];
$incbidprice=$_POST['incbidprice'];
$isallow=$_POST['is_allow'];
$buynow=$_POST['buynow'];
$shallow=$_POST['sh_allow'];
$shipping=$_POST['shipping'];
$cate_charge=$_POST['cate_charge'];
$closed_dt=mysql_real_escape_string($_POST['hidclsdate']);
$closedate=mysql_real_escape_string($_POST['hidfclsdate']);
$isagree=$_POST['is_agree'];
$typeprod=$_POST['typeprod'];

$codallow=$_POST['cod_allow'];
$opallow=$_POST['op_allow'];

if(($codallow=='0') && ($opallow=='0')){	
	$opallow = 1;
}

/*$city=mysql_real_escape_string($_POST['city']);
$cnt=mysql_real_escape_string($_POST['country']);

$cntRes = mysql_fetch_array(mysql_query("SELECT * FROM country_list WHERE country_name = '$cnt'"));
$country = $cntRes['country'];*/

$city = 'Mumbai';
$country = 'India';

$un = $_SESSION['memberID'];
$acCnt = mysql_num_rows(mysql_query("SELECT * FROM user_registration WHERE uid = '$un' AND status = '2'"));

if($acCnt!=0){

if($incbidprice=='' || $incbidprice=='0'){
	$incbidprice = 1;
}

$startdate=date("d-M-Y");
$date_time=date("j-F-y, g:i a");

$selprod=$_POST['selprod'];
$prodconut = mysql_num_rows(mysql_query("SELECT * FROM product_category WHERE status = '1'"));

$a = 1;
$selprodQry = mysql_query("SELECT * FROM product_category WHERE status = '1' ORDER BY pcid ASC");

while($selprodRes = mysql_fetch_array($selprodQry)){
		$sr[$a] = $selprodRes['pcid'];
		$a++;
	}	

for($i=1; $i<=$prodconut; $i++){
	$selsprod2 = 'selsprod-'.$sr[$i];
	$ab = $sr[$i];
	$prdnm[$ab]= $_POST[$selsprod2];
	//$prdnm[$i]= $_POST[$selsprod2];
}

$selsprod=$prdnm[$selprod];

if($selsprod==0 || $selsprod==''){
	$prodsel2 = mysql_fetch_array(mysql_query("SELECT * FROM product_sub_category WHERE pcid = '$selprod' AND sprod_name = 'Other'"));
	$selsprod = $prodsel2['pscid'];
}

if($isallow==0 || $isallow=='')
	{$isallow=0; $buynow=''; $buychck='';}
else{$buychck='checked'; $isallow=1;}

if($shallow==0 || $shallow=='')
	{$shallow=0; $shipping=''; $shpchck='';}
else{$shpchck='checked'; $shallow=1;}

if($isagree==0 || $isagree==''){
	$isagree=0; $actchck='';}
else{$isagree=1; $actchck='checked';}

if($codallow==0 || $codallow=='')
	{$codallow=0; $pmchck1='';}
else{$pmchck1='checked'; $codallow=1;}

if($opallow==0 || $opallow=='')
	{$opallow=0; $pmchck2='';}
else{$pmchck2='checked'; $opallow=1;}


$reg = mysql_query("INSERT INTO items_selling(pcid,pscid,uid,item_title,item_start_price,buy_now_allow,buy_now_price,shipping_cost_allow,shipping_cost,ezy_fees,start_dt,closed_dt,closing_date_time,item_desc,prod_type,increase_bid_value,cod_allow,op_allow,city,country,created_date,modified_date,status,distributor,no_of_item) VALUES ('$selprod','$selsprod','$memberID','$itemtitle','$startprice','$isallow','$buynow','$shallow','$shipping','$cate_charge','$startdate','$closed_dt','$closedate','$itemdesc','$typeprod','$incbidprice','$codallow','$opallow','$city','$country','$date_time','$date_time','$isagree','$distributor','$no_of_item')");

$itemid = mysql_insert_id();

if(isset($reg)){
header('location:items-description.php?prodid='.$itemid.'&msg=successfully-add'); }
/*else{
header('location:add-new-item.php?msg=error'); }*/
 }
 else{
	  header('location:add-new-item.php?err=account-confirmation');
	  break;
  }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml" xml:lang="en" lang="en">
<head>
<title>ezydeal</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="" />
<meta name="keywords" content="" />
<?php require_once("common.php"); ?>
<!--[if lt IE 7]>
<script type="text/javascript">
//<![CDATA[
    var BLANK_URL = 'js/blank.html';
    var BLANK_IMG = 'js/spacer.gif';
//]]>
</script>
<![endif]-->
<link href="skin/frontend/default/ecom/css/styles-new.css" rel="stylesheet" type="text/css" />
<!--<script src="js/brand-scroller/jquery.js" type="text/javascript"></script>-->
<!--<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js"></script>-->

<script type="text/javascript" src="https://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js"></script>
<script type="text/javascript">
 
$(document).ready(function(){
 
    var counter = 2;
    $("#addButton").click(function () {
	if(counter>5){
         alert("You can upload only 5 images.");
         return false;
	}   
 
	var newTextBoxDiv = $(document.createElement('div'))
	     .attr("id", 'TextBoxDiv' + counter);

	newTextBoxDiv.after().html('<div class="input-box"><input type="file" name="files[]" id="img' + counter + '" value="" class="input-text required-entry required-entry-ulength validate-number" >');
 
	newTextBoxDiv.appendTo("#TextBoxesGroup");
	counter++;
     });
 
     $("#removeButton").click(function () {
	if(counter==2){
          alert("No more image box to remove.");
          return false;
       }   
 
	counter--;
 
        $("#TextBoxDiv" + counter).remove();
 
     });
 
     $("#getButtonValue").click(function () {
 
	var msg = '';
	for(i=1; i<counter; i++){
   	  msg += "\n Textbox #" + i + " : " + $('#img' + i).val();
	}
    	  alert(msg);
     });
  });
</script>

<link rel="stylesheet" type="text/css" href="css/styles04.css" />
<link rel="stylesheet" type="text/css" href="css/styles05.css" media="all" />
<link rel="stylesheet" type="text/css" href="css/styles06.css" media="print" />
<!--<script type="text/javascript" src="js/custom01-test.js"></script>-->
<!--[if lt IE 8]>
<link rel="stylesheet" type="text/css" href="css/ie.css" media="all" />
<![endif]-->
<!--[if lt IE 7]>
<script type="text/javascript" src="js/ie.js"></script>
<![endif]-->
<script language="javascript" type="text/javascript" src="js/datetimepicker2.js"></script>
<script type="text/javascript" src="js/jquery.validate.min.js"></script>
<script type="text/javascript">
(function($,W,D)
{
    var JQUERY4U = {};

    JQUERY4U.UTIL =
    {
        setupFormValidation: function()
        {
            //form validation rules
            $("#register-form").validate({
                rules: {
					itemtitle: {
                        required: true,
                        minlength: 3
                    },
					buynow: { 
						required: function (element) {
							var boxes = $('.checkbox_buynow');
							var boxes1 = $('.buynow').val();
							if ((boxes.filter(':checked').length != 0) && boxes1=='') {
								return true;
							}
							return false;
						},
						//minlength: 1 
					},
					shipping: { 
						required: function (element) {
							var shp = $('.checkbox_shipping');
							var shp1 = $('.shipping').val();
							if ((shp.filter(':checked').length != 0) && shp1=='') {
								return true;
							}
							return false;
						},
						//minlength: 1 
					},
					itemdesc: {
                        required: true,
                        minlength: 3
                    },
					no_of_item: {
                        required: true
                    },
					typeprod: {
                        required: true
                    },
                    startprice: {
                        required: true
                    },
					incbidprice: {
                        required: true
                    },
					closeday: {
                        required: true,
                    },
					selprod: {
                        required: true,
                    },
					city: {
                        required: true,
                    },
					country: {
                        required: true,
                    }
                },
                messages: {
                    itemtitle: "This is a required field.",
					buynow: "This is a required field.",
					shipping: "This is a required field.",
                    itemdesc: "This is a required field.",
					no_of_item: "This is a required field.",
					typeprod: "This is a required field.",
                    startprice: "This is a required field.",
					incbidprice: "This is a required field.",
					closeday: "This is a required field.",
					selprod: "This is a required field.",
					city: "This is a required field.",
					country: "This is a required field."
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        }
    }
    //when the dom has loaded setup form validation rules
    $(D).ready(function($) {
        JQUERY4U.UTIL.setupFormValidation();
    });

})(jQuery, window, document);
</script>
<style type="text/css">
.rscategory{display:none;}
</style>
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-52049697-1', 'ezydeal.in');
  ga('send', 'pageview');

</script>
</head>
<body class="cms-index-index cms-home">
<div class="wrapper">
  <noscript>
  <div class="noscript">
    <div class="noscript-inner">
      <p><strong>JavaScript seem to be disabled in your browser.</strong></p>
      <p>You must have JavaScript enabled in your browser to utilize the functionality of this website.</p>
    </div>
  </div>
  </noscript>
  <div class="header-container">
    <div class="page-closure">
      <div class="header">
        <div class="header-top-area">
          <div class="logo-area">
            <div class="logo"><strong>EZYDEAL</strong><a href="./" title=""><img src="skin/frontend/default/ecom/images/ezydeal.png" alt="" /></a></div>
          </div>
          <div class="header-right-area">
            <div class="clear HR-upper ">
              <div class="menu-wp">
                <?php include_once('menu-login.php'); ?>
              </div>
            </div>
            <!--<p class="tell-number">Toll Free: 1800 22 8623</p>-->
            
            <?php include_once('top_new_login.php'); ?>
          </div>
        </div>
        <div class="rounded-main">
          <div class="main-top"></div>
          <div class="main">
            <div class="red-search-area" style="height:300px;">
            <img src="catalog/product/ezydeal_banner.jpg" width="960" height="300" alt="" />
            </div>
          </div>
        </div>
      </div>
      <!--/.page-closure--></div>
  </div>
  <div class="page">
    <div class="main-container col2-left-layout">
      <div class="rounded-main">
        <div class="main-top"></div>
        <div class="main">
          <div class="showcase">
            <div class="widget widget-static-block">
              <div class="contact-option-wp">
                <div class="search-results">
                  <div class="TS-left">&nbsp;</div>
                  <div class="TS-mid"> <a href="http://ezydeal.in/" class="search-link"><b>Home</b></a> > <a href="add-new-item.php" class="search-link">Add new item</a>
                    
                    <!--<div style="float:right">Sort</div>--> 
                  </div>
                  <div class="TS-right">&nbsp;</div>
                </div>
                <div style="width:0px; height:0px; line-height:0px; padding:0px; margin:0px;" class="clear">&nbsp;</div>
              </div>
            </div>
          </div>
          <div class="col-main">
            <div class="std">
              <div class="block featured-block">
                <div class="block-title"><strong><span>Add new item<br />
                  </span></strong></div>
                  
                <div class="block-content">
                
                <?php 
				echo $err_msg;
				
				$todaydate1 = date("Y-m-d");
				$emCnt = mysql_num_rows(mysql_query("SELECT * FROM email_sent WHERE uid = '$memberID' AND email_sent_date = '$todaydate1'"));
				
				if($memberStatus==1){
                if($emCnt<3){ ?>
                <div id="email-verify-msg" style="display:inline-block; margin:0 0 5px 17px; width:712px;"><ul class='messages'><li class='error-msg'><ul><li>Your email is yet not verified. Please confirm by clicking the link sent on your email.<br />Didn't received the email, please <a href="<?php echo $SC; ?>" id="<?php echo $memberID; ?>" class="verify-email" style="outline: none;">click here</a> to resend confirmation mail.</li></ul></li></ul></div>
				
				<?php } else { ?>
                <div id="email-verify-msg" style="display:inline-block; margin:0 0 5px 17px; width:712px;"><ul class='messages'><li class='error-msg'><ul><li>Your email is yet not verified. Please confirm by clicking the link sent on your email.<br />Didn't received the email, please <a href="" class="already-sent-email" style="outline: none;">click here</a> to resend confirmation mail.</li></ul></li></ul></div>
                
                <?php }
				 } ?>
  
                  <div style="display:inline-block; padding:10px; width:691px; margin:0 0 5px 17px; border:1px solid #d7d7d7;">  
                  <form action="add-new-item.php" method="post" id="register-form" novalidate="novalidate"  enctype="multipart/form-data">
                    <div class="rounded-form">
                      <div class="content-wraper">
                        <div class="content-area">
                          <div class="fieldset">
                            <h2 class="legend">Item Information</h2>
                            <ul class="form-list">
                              <li class="fields">
                                <div class="customer-name">
                                  <div class="field name-firstname">
                                    <label for="itemtitle" class="required"><em>*</em>Title</label>
                                    <div class="input-box">
                                      <input type="text" id="itemtitle" name="itemtitle" maxlength="100" value="<?php echo $_POST['itemtitle']; ?>" title="" class="input-text required-entry required-entry-length validate-alpha">
                                    </div>
                                  </div>  
                                </div>
                              </li>
                              <li class="fields">
                                <div class="field email">
                                  <label for="itemdesc" class="required"><em>*</em>Description</label>
                                  <div class="input-box">
                                    <textarea name="itemdesc" id="itemdesc" class="input-text required-entry required-entry-ulength validate-alphanum"><?php echo $_POST['itemdesc']; ?></textarea>
                                  </div>
                                </div> 
                              </li>
                              <li class="fields">
                                <div class="customer-name">
                                  <div class="field name-firstname">
                                    <label for="typeprod" class="required"><em>*</em>Item Type</label>
                                    <div class="input-box">
                                    <select name="typeprod" id="typeprod" class="input-text validate-select">
                                    <option value="">Choose</option>
                                    <option value="NEW">New</option>
                                    <option value="USED">Used</option>
                                    </select>
                                    </div>
                                  </div>
                                </div>
                              </li>
							  <li class="fields">
                                <div class="customer-name">
                                  <div class="field name-firstname">
                                    <label for="itemtitle" class="required"><em>*</em>No of items</label>
                                    <div class="input-box">
                                      <input type="text" id="no_of_item" name="no_of_item" maxlength="100" value="<?php echo $_POST['no_of_item']; ?>" title="" class="input-text required-entry required-entry-length validate-alpha">
                                    </div>
                                  </div>  
                                </div>
                              </li>
                              <li class="fields">
                                <div class="field email">
                                  <label for="startprice" class="required"><em>*</em>Starting Price</label>
                                  <div class="input-box">
                                      <input type="text" id="startprice" name="startprice" maxlength="15" value="<?php echo $_POST['startprice']; ?>" title="" class="input-text required-entry required-entry-length validate-alpha" style="width:100px;"> INR
                                    </div>
                                </div>
                                <div class="field">
                                  <label for="startprice" class="required"><em>*</em>Increase My Offer</label>
                                  <div class="input-box">
                                      <input type="text" id="incbidprice" name="incbidprice" maxlength="15" value="<?php echo $_POST['incbidprice']; ?>" title="" class="input-text required-entry required-entry-length validate-alpha" style="width:100px;"> INR
                                    </div>
                                </div>
                              </li>
                              <li class="fields">
                                <div class="field email">
                                  <label for="buynow" class="required">Buy Now Price</label>
                                  <div class="input-box">
                                    <input type="text" id="buynow" name="buynow" value="<?php echo $_POST['buynow']; ?>" title="" class="input-text required-entry required-entry-length validate-alpha buynow" style="width:100px;"> INR
                                  </div>
                                </div>
                                <div class="field">
                                  <label for="checkbox" class="required">&nbsp;</label>
                                  <div class="input-box">                                  
								<input type="checkbox" name="is_allow" title="" value="1" id="is_allow" class="checkbox_buynow required-agree" <?php echo $buychck; ?> /> <span><b>Click to allow buy now option.</b></span>
                                 </div>
                                </div>
                              </li>
                              <li class="fields">
                                <div class="field email">
                                  <label for="buynow" class="required">Shipping Cost <span style="font-weight:normal; font-size:11px;">(Default free of cost)</span></label>
                                  <div class="input-box">
                                    <input type="text" id="shipping" name="shipping" value="<?php echo $_POST['shipping']; ?>" title="" class="input-text required-entry required-entry-length validate-alpha shipping" style="width:100px;"> INR
                                  </div>
                                </div>
                                <div class="field">
                                  <label for="checkbox" class="required">&nbsp;</label>
                                  <div class="input-box">                                  
								<input type="checkbox" name="sh_allow" title="" value="1" id="sh_allow" class="checkbox_shipping required-agree" <?php echo $shpchck; ?> /> <span><b>Allow shipping cost.</b></span>
                                 </div>
                                </div>
                              </li>
                              <li class="fields">
                                <div class="field email">
                                 <label for="closedate" class="required"><em>*</em>Closing Time Period <span style="font-weight:normal; font-size:11px;">(Default 7 days)</span></label>
                                  <div class="input-box">
                                    <input type="text" id="closeday" name="closeday" value="" title="" class="input-text required-entry required-entry-length validate-alpha" maxlength="2" style="width:100px;"> Days
                                  </div>
                                </div> 
                                <div class="field">
                                  <label for="checkbox" class="required">&nbsp;</label>
                                  <div class="input-box">                                  
								  <span><b>Closed date</b>: <span id="clsingdt" style="color:#c61111;"><?php echo date('d-M-Y',$pDate); ?></span></span><input type="hidden" id="hidclsdate" name="hidclsdate" value="<?php echo date('d-M-Y',$pDate); ?>" readonly /><input type="hidden" id="hidfclsdate" name="hidfclsdate" value="<?php echo $fctodaydate; ?>" readonly />
                                 </div>
                                </div>
                              </li>
                            </ul>
                          </div>
                          <div class="fieldset">
                            <h2 class="legend">Category</h2>
                            <ul class="form-list">
                              <li class="fields">
                                <div class="customer-name">
                                  <div class="field name-firstname">
                                  <input type="hidden" name="cate_charge" id="cate_charge" value="1" readonly />
                                    <label for="selprod" class="required"><em>*</em>Item Category</label>
                                    <div class="input-box">
                                    <select name="selprod" id="selprod" class="input-text validate-select">
                                    <option value="">Choose</option>
                             <?php
								$prodcateqry4 = mysql_query("SELECT * FROM product_category WHERE status = '1'");
								
								while($pcres4 = mysql_fetch_array($prodcateqry4)){
									$pcid4 = $pcres4['pcid'];
									$prod_name4 = $pcres4['prod_name'];
									$prod_folder4 = $pcres4['prod_folder'];
									//$ezy_fees4 = $pcres4['ezy_fees'];
									
									//echo "<option value='$pcid4' class='rsm$pcid4' id='$ezy_fees4'>$prod_name4</option>";
									echo "<option value='$pcid4'>$prod_name4</option>";
								}
							?>
                                    </select>
                                    </div>
                                  </div>
                                  <div class="field name-lastname">
                                    <label for="selsprod" class="required"><em>*</em>Item Sub Category</label>
                                    <div class="input-box">
                                    <select name="selsprod" id="selsprod0" class="input-text validate-select rscategory1">
                                    <option value="">Choose</option>
                                    </select>
                                    <?php
							$prodcateqry5 = mysql_query("SELECT * FROM product_category WHERE status = '1'");
								
								while($pcres5 = mysql_fetch_array($prodcateqry5)){
									$pcid5 = $pcres5['pcid'];
									$prod_folder5 = $pcres5['prod_folder'];
								
									echo "<select name='selsprod-$pcid5' id='selsprod$pcid5' class='input-text validate-select rscategory rohit'>
                                    <option value=''>Choose</option>";
									
								$sprodcateqry = mysql_query("SELECT * FROM product_sub_category WHERE pcid = '$pcid5' AND status = '1'");	
								while($spcres = mysql_fetch_array($sprodcateqry)){
									$spcid = $spcres['pscid'];
									$sprod_name = $spcres['sprod_name'];
									$ezy_fees4 = $spcres['ezy_fees'];
									//echo "<option value='$prod_folder5#$spcid'>$sprod_name</option>";
									echo "<option value='$spcid' class='rsm$spcid' id='$ezy_fees4'>$sprod_name</option>";
									
							    	}
									
									echo "</select>";
								}
									?>
                                    <!--</select>-->
                                    </div>
                                  </div>
                                </div>
                              </li>
                             </ul>
                          </div>
                          <div class="fieldset" style="margin-bottom:15px;">
                            <h2 class="legend">Payment method</h2>
                            
                            <?php if($distributor !=0){ ?>
								
                            <ul class="form-list">
                              <li class="control" style="margin-bottom:5px;">
                                <div class="input-box">
                                  <input type="checkbox" name="cod_allow" title="" value="1" id="cod_allow" class="required-agree" <?php echo $pmchck1; ?> />
                                </div>
                                <label for="cod_allow"><span>Cash On Delivery</span></label>
                              </li>
                              <li class="control">
                                <div class="input-box">
                                  <input type="checkbox" name="op_allow" title="" value="1" id="op_allow" class="required-agree" <?php echo $pmchck2; ?> />
                                </div>
                                <label for="op_allow"><span>Online Payment</span></label>
                              </li>
                             </ul>
                             <?php } else {
								 ?> 
                             
                              <ul class="form-list">
                              <li class="control" style="margin-bottom:5px;">
                                <div class="input-box">
                                  <input type="checkbox" name="cod_allow" title="" value="1" id="cod_allow" class="required-agree" <?php echo $pmchck1; ?> />
                                </div>
                                <label for="cod_allow"><span>Cash On Delivery</span></label>
                              </li>
                              
                             </ul>
                             <?php }?>
                          </div>
                          <div class="fieldset">
                            <h2 class="legend">Upload Image</h2>
                            <ul class="form-list">
                              <li class="fields" style="position:relative;">
                                <div class="customer-name" id="TextBoxesGroup">
                                  <div class="field name-firstname TextBoxDiv" id="TextBoxDiv1">
                                    <label for="image" class="required"><em>*</em>Image</label>
                                    <div class="input-box">
                                      <input type="file" id="img1" name="files[]" value="" title="" class="input-text required-entry required-entry-ulength validate-number"> 
                                    </div>
                                  </div>
                                </div>
                                <div class="field" style="position:absolute; right:4%; top:-1px;">
                                  <button type="button" class="chg-button" id="addButton"><span><span>+</span></span></button> <button type="button"class="chg-button" id="removeButton"><span><span>-</span></span></button>
                                </div>
                              </li>
                              
                              <li class="control">
                                <div class="input-box">
                                  <input type="checkbox" name="is_agree" title="" value="1" id="is_agree" class="required-agree" <?php echo $actchck; ?> />
                                </div>
                                <!--<span class="act_agree"><label for="is_agree"> Activate Now!</label></span>-->
                                <label for="is_agree" style="font-size:13px; color:#222;"><span class="act_agree">Activate Now! "Please note ezydeal.in will charge 1% on your final amount. Therefore your item price should be inclusive of these charges."</span></label>
                              </li>
                             </ul>
                          </div>
                          <div class="fontis-register">
                            <div class="buttons-set">
                              <p class="required"><strong>Notes -</strong><br />
                              * Required fields<br />
                              &#187; Currently shipment of all our products are limited to Mumbai area only.<br />
                              &#187; Online payment is default payment method.<br />
                              &#187; After your product is listed & if 1 offer is placed, you can't edit major fields.<br />
                              &#187; If you add extra shipping charges then shipping charges wont be displayed with the live product. It will be only shown when the winner claims this product or purchases this product.</p>
                              <?php if($memberStatus==2){?>
                              	<button type="submit" title="Submit" id="add-button" class="reg-button"><span><span>Submit</span></span></button>
                              <?php } ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    </form>
                    <?php if($memberStatus==1){?>
                    <button type="submit" title="Submit" id="err-button" class="reg-button" style="margin:0 0 10px 10px;"><span><span>Submit</span></span></button>
                    <?php } ?>
            <script type="text/javascript">
    //<![CDATA[
        var dataForm = new VarienForm('form-validate', true);
            //]]>
    </script> </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-left sidebar">
            
            <?php 

				include_once('menu-sidebar.php'); 
			 ?>
          </div>
          </div>
        </div>
        <div class="main-bottom"></div>
      </div>
    </div>
  </div>
  <?php include_once('menu-footer.php'); ?>
<script type="text/javascript" src="js/custom-validation-new.js"></script>
<script type="text/javascript" src="js/brand-scroller/all-external_v1.9.5.js"></script> 
</div>
</body>
</html>
