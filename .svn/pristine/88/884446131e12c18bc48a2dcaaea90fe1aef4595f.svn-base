<?
include "../include/include_function.php"; 
include "./include/include_admin_check.php";

$Dept = Replace_Check($Dept);
$idx = Replace_Check($idx);
$ParentCategory = Replace_Check($ParentCategory);
$Deep = Replace_Check($Deep);
$DeptString = Replace_Check($DeptString);
$mode = Replace_Check($mode);

$TopMenuGrant_array = array();
$SubMenuGrant_array = array();

if($mode=="Edit") {

$Sql = "SELECT * FROM DeptStructure WHERE idx=$idx AND Dept='$Dept'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
if($Row) {

	$Dept = $Row['Dept'];
	$ParentCategory = $Row['ParentCategory'];
	$Deep = $Row['Deep'];
	$DeptName = $Row['DeptName'];
	$DeptString = $Row['DeptString'];
	$TopMenuGrant = $Row['TopMenuGrant'];
	$TopMenuGrant_array = explode(',',$TopMenuGrant);
	$SubMenuGrant = $Row['SubMenuGrant'];
	$SubMenuGrant_array = explode(',',$SubMenuGrant);
	}
}

if($ParentCategory) {
	$Sql = "SELECT * FROM DeptStructure WHERE idx=$ParentCategory";
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);
	if($Row) {
		$Upper_DeptName = $Row['DeptName'];
	}
}else{
	$Upper_DeptName = "없음";
}

if(!$mode) {
	$mode=="New";
}

switch ($Dept) {
	case "A":
		$DeptTitle = "관리자";
	break;
	case "B":
		$DeptTitle = "영업자";
	break;
	case "C":
		$DeptTitle = "첨삭강사";
	break;
	default :
		$DeptTitle = "";
}

switch ($mode) {
	case "New":
		$ModeScript = "등록";
	break;
	case "Edit":
		$ModeScript = "수정";
	break;
	default :
		$ModeScript = "";
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<head>
<title><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="//cdn.jsdelivr.net/npm/xeicon@2.3.3/xeicon.min.css">
<link rel="stylesheet" href="./lib/fontawesome-5.15.4/css/fontawesome.min.css">
<link rel="stylesheet" href="./lib/fontawesome-5.15.4/css/all.min.css">
<link rel="stylesheet" href="./css/style.css" type="text/css">
<link rel="stylesheet" type="text/css" href="./include/jquery-ui.css" />
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui.js"></script>
<script type="text/javascript" src="./include/jquery.ui.datepicker-ko.js"></script>
<script type="text/javascript" src="./include/function.js"></script>
<script type="text/javascript" src="./smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>

<SCRIPT LANGUAGE="JavaScript">
$(document).ready(function(){
	//권한설정 회원관리-------------------------------------------
	$("#TopMenuGrant01").click(function() {
		var SubMenuGrant_length = $("input[name='SubMenuGrant01']").length;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("#TopMenuGrant01").is(":checked")==true) {
				$("input[name='SubMenuGrant01']:eq("+i+")").prop('checked',true);
			}else{
				$("input[name='SubMenuGrant01']:eq("+i+")").prop('checked',false);
			}
		}
	});
	$("input[name='SubMenuGrant01']").click(function() {
		var SubMenuGrant_length = $("input[name='SubMenuGrant01']").length;
		var checked_value = 0;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("input[name='SubMenuGrant01']:eq("+i+")").is(":checked")==true) {
				checked_value = checked_value + 1;
			}
		}
		if(checked_value>0) {
			$("#TopMenuGrant01").prop('checked',true);
		}else{
			$("#TopMenuGrant01").prop('checked',false);
		}
	});
	//권한설정 회원관리-------------------------------------------

	//권한설정 수강관리-------------------------------------------
	$("#TopMenuGrant02").click(function() {
		var SubMenuGrant_length = $("input[name='SubMenuGrant02']").length;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("#TopMenuGrant02").is(":checked")==true) {
				$("input[name='SubMenuGrant02']:eq("+i+")").prop('checked',true);
			}else{
				$("input[name='SubMenuGrant02']:eq("+i+")").prop('checked',false);
			}
		}
	});

	$("input[name='SubMenuGrant02']").click(function() {
		var SubMenuGrant_length = $("input[name='SubMenuGrant02']").length;
		var checked_value = 0;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("input[name='SubMenuGrant02']:eq("+i+")").is(":checked")==true) {
				checked_value = checked_value + 1;
			}
		}
		if(checked_value>0) {
			$("#TopMenuGrant02").prop('checked',true);
		}else{
			$("#TopMenuGrant02").prop('checked',false);
		}
	});
	//권한설정 수강관리-------------------------------------------

	//권한설정 독려관리-------------------------------------------
	$("#TopMenuGrant03").click(function() {
		var SubMenuGrant_length = $("input[name='SubMenuGrant03']").length;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("#TopMenuGrant03").is(":checked")==true) {
				$("input[name='SubMenuGrant03']:eq("+i+")").prop('checked',true);
			}else{
				$("input[name='SubMenuGrant03']:eq("+i+")").prop('checked',false);
			}
		}
	});

	$("input[name='SubMenuGrant03']").click(function() {
		var SubMenuGrant_length = $("input[name='SubMenuGrant03']").length;
		var checked_value = 0;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("input[name='SubMenuGrant03']:eq("+i+")").is(":checked")==true) {
				checked_value = checked_value + 1;
			}
		}
		if(checked_value>0) {
			$("#TopMenuGrant03").prop('checked',true);
		}else{
			$("#TopMenuGrant03").prop('checked',false);
		}
	});
	//권한설정 독려관리-------------------------------------------

	//권한설정 컨텐츠관리-------------------------------------------
	$("#TopMenuGrant04").click(function() {
		var SubMenuGrant_length = $("input[name='SubMenuGrant04']").length;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("#TopMenuGrant04").is(":checked")==true) {
				$("input[name='SubMenuGrant04']:eq("+i+")").prop('checked',true);
			}else{
				$("input[name='SubMenuGrant04']:eq("+i+")").prop('checked',false);
			}
		}
	});

	$("input[name='SubMenuGrant04']").click(function() {
		var SubMenuGrant_length = $("input[name='SubMenuGrant04']").length;
		var checked_value = 0;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("input[name='SubMenuGrant04']:eq("+i+")").is(":checked")==true) {
				checked_value = checked_value + 1;
			}
		}
		if(checked_value>0) {
			$("#TopMenuGrant04").prop('checked',true);
		}else{
			$("#TopMenuGrant04").prop('checked',false);
		}
	});
	//권한설정 컨텐츠관리-------------------------------------------

	//권한설정 사업주훈련-------------------------------------------
	$("#TopMenuGrant05").click(function() {
		var SubMenuGrant_length = $("input[name='SubMenuGrant05']").length;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("#TopMenuGrant05").is(":checked")==true) {
				$("input[name='SubMenuGrant05']:eq("+i+")").prop('checked',true);
			}else{
				$("input[name='SubMenuGrant05']:eq("+i+")").prop('checked',false);
			}
		}
	});

	$("input[name='SubMenuGrant05']").click(function() {
		var SubMenuGrant_length = $("input[name='SubMenuGrant05']").length;
		var checked_value = 0;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("input[name='SubMenuGrant05']:eq("+i+")").is(":checked")==true) {
				checked_value = checked_value + 1;
			}
		}
		if(checked_value>0) {
			$("#TopMenuGrant05").prop('checked',true);
		}else{
			$("#TopMenuGrant05").prop('checked',false);
		}
	});
	//권한설정 사업주훈련-------------------------------------------

	//권한설정 내일배움카드-------------------------------------------
	$("#TopMenuGrant06").click(function() {
		var SubMenuGrant_length = $("input[name='SubMenuGrant06']").length;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("#TopMenuGrant06").is(":checked")==true) {
				$("input[name='SubMenuGrant06']:eq("+i+")").prop('checked',true);
			}else{
				$("input[name='SubMenuGrant06']:eq("+i+")").prop('checked',false);
			}
		}
	});

	$("input[name='SubMenuGrant06']").click(function() {
		var SubMenuGrant_length = $("input[name='SubMenuGrant06']").length;
		var checked_value = 0;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("input[name='SubMenuGrant06']:eq("+i+")").is(":checked")==true) {
				checked_value = checked_value + 1;
			}
		}
		if(checked_value>0) {
			$("#TopMenuGrant06").prop('checked',true);
		}else{
			$("#TopMenuGrant06").prop('checked',false);
		}
	});
	//권한설정 내일배움카드-------------------------------------------

	//권한설정 FLEX-------------------------------------------
	$("#TopMenuGrant07").click(function() {
		var SubMenuGrant_length = $("input[name='SubMenuGrant07']").length;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("#TopMenuGrant07").is(":checked")==true) {
				$("input[name='SubMenuGrant07']:eq("+i+")").prop('checked',true);
			}else{
				$("input[name='SubMenuGrant07']:eq("+i+")").prop('checked',false);
			}
		}
	});

	$("input[name='SubMenuGrant07']").click(function() {
		var SubMenuGrant_length = $("input[name='SubMenuGrant07']").length;
		var checked_value = 0;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("input[name='SubMenuGrant07']:eq("+i+")").is(":checked")==true) {
				checked_value = checked_value + 1;
			}
		}
		if(checked_value>0) {
			$("#TopMenuGrant07").prop('checked',true);
		}else{
			$("#TopMenuGrant07").prop('checked',false);
		}
	});
	//권한설정 FLEX-------------------------------------------

	//권한설정 커뮤니티관리-------------------------------------------
	$("#TopMenuGrant08").click(function() {
		var SubMenuGrant_length = $("input[name='SubMenuGrant08']").length;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("#TopMenuGrant08").is(":checked")==true) {
				$("input[name='SubMenuGrant08']:eq("+i+")").prop('checked',true);
			}else{
				$("input[name='SubMenuGrant08']:eq("+i+")").prop('checked',false);
			}
		}
	});

	$("input[name='SubMenuGrant08']").click(function() {
		var SubMenuGrant_length = $("input[name='SubMenuGrant08']").length;
		var checked_value = 0;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("input[name='SubMenuGrant08']:eq("+i+")").is(":checked")==true) {
				checked_value = checked_value + 1;
			}
		}
		if(checked_value>0) {
			$("#TopMenuGrant08").prop('checked',true);
		}else{
			$("#TopMenuGrant08").prop('checked',false);
		}
	});
	//권한설정 커뮤니티관리-------------------------------------------

	//권한설정 통계관리-------------------------------------------
	$("#TopMenuGrant09").click(function() {
		var SubMenuGrant_length = $("input[name='SubMenuGrant09']").length;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("#TopMenuGrant09").is(":checked")==true) {
				$("input[name='SubMenuGrant09']:eq("+i+")").prop('checked',true);
			}else{
				$("input[name='SubMenuGrant09']:eq("+i+")").prop('checked',false);
			}
		}
	});

	$("input[name='SubMenuGrant09']").click(function() {
		var SubMenuGrant_length = $("input[name='SubMenuGrant09']").length;
		var checked_value = 0;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("input[name='SubMenuGrant09']:eq("+i+")").is(":checked")==true) {
				checked_value = checked_value + 1;
			}
		}
		if(checked_value>0) {
			$("#TopMenuGrant09").prop('checked',true);
		}else{
			$("#TopMenuGrant09").prop('checked',false);
		}
	});
	//권한설정 통계관리-------------------------------------------

	//권한설정 사이트관리-------------------------------------------
	$("#TopMenuGrant10").click(function() {
		var SubMenuGrant_length = $("input[name='SubMenuGrant10']").length;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("#TopMenuGrant10").is(":checked")==true) {
				$("input[name='SubMenuGrant10']:eq("+i+")").prop('checked',true);
			}else{
				$("input[name='SubMenuGrant10']:eq("+i+")").prop('checked',false);
			}
		}
	});

	$("input[name='SubMenuGrant10']").click(function() {
		var SubMenuGrant_length = $("input[name='SubMenuGrant10']").length;
		var checked_value = 0;
		for(i=0;i<SubMenuGrant_length;i++) {
			if($("input[name='SubMenuGrant10']:eq("+i+")").is(":checked")==true) {
				checked_value = checked_value + 1;
			}
		}
		if(checked_value>0) {
			$("#TopMenuGrant10").prop('checked',true);
		}else{
			$("#TopMenuGrant10").prop('checked',false);
		}
	});
	//권한설정 사이트관리-------------------------------------------
});



function SubmitOk() {
    val = document.Form1;
    
    if(val.DeptName.value=="") {
    	alert("카테고리명을 등록하세요.");
    	val.DeptName.focus();
    	return;
    }    
    var TopMenuGrant = "";
    var SubMenuGrant = "";
    var SubMenuGrant01 = "";
    var SubMenuGrant02 = "";
    var SubMenuGrant03 = "";
    var SubMenuGrant04 = "";
    var SubMenuGrant05 = "";
    var SubMenuGrant06 = "";
    var SubMenuGrant07 = "";
    var SubMenuGrant08 = "";
    var SubMenuGrant09 = "";
    var SubMenuGrant10 = "";

    var TopMenuGrant01_length = $("input[name='TopMenuGrant01']").length;
    for(i=0;i<TopMenuGrant01_length;i++) {
    	if($("input[name='TopMenuGrant01']:eq("+i+")").is(":checked")==true) {
    		if(TopMenuGrant=="") {
    			TopMenuGrant = $("input[name='TopMenuGrant01']:eq("+i+")").val();
    		}else{
    			TopMenuGrant = TopMenuGrant + "," + $("input[name='TopMenuGrant01']:eq("+i+")").val();
    		}
    	}
    }
    
    $("#TopMenuGrant").val(TopMenuGrant);
    
    var SubMenuGrant01_length = $("input[name='SubMenuGrant01']").length;
    if(SubMenuGrant01_length>0) {
    	for(i=0;i<SubMenuGrant01_length;i++) {
    		if($("input[name='SubMenuGrant01']:eq("+i+")").is(":checked")==true) {
    			if(SubMenuGrant01=="") {
    				SubMenuGrant01 = $("input[name='SubMenuGrant01']:eq("+i+")").val();
    			}else{
    				SubMenuGrant01 = SubMenuGrant01 + "," + $("input[name='SubMenuGrant01']:eq("+i+")").val();
    			}
    		}
    	}
    }
    
    var SubMenuGrant02_length = $("input[name='SubMenuGrant02']").length;
    if(SubMenuGrant02_length>0) {
    	for(i=0;i<SubMenuGrant02_length;i++) {
    		if($("input[name='SubMenuGrant02']:eq("+i+")").is(":checked")==true) {
    			if(SubMenuGrant02=="") {
    				SubMenuGrant02 = $("input[name='SubMenuGrant02']:eq("+i+")").val();
    			}else{
    				SubMenuGrant02 = SubMenuGrant02 + "," + $("input[name='SubMenuGrant02']:eq("+i+")").val();
    			}
    		}
    	}
    }
    
    var SubMenuGrant03_length = $("input[name='SubMenuGrant03']").length;
    if(SubMenuGrant03_length>0) {
    	for(i=0;i<SubMenuGrant03_length;i++) {
    		if($("input[name='SubMenuGrant03']:eq("+i+")").is(":checked")==true) {
    			if(SubMenuGrant03=="") {
    				SubMenuGrant03 = $("input[name='SubMenuGrant03']:eq("+i+")").val();
    			}else{
    				SubMenuGrant03 = SubMenuGrant03 + "," + $("input[name='SubMenuGrant03']:eq("+i+")").val();
    			}
    		}
    	}
    }
    
    var SubMenuGrant04_length = $("input[name='SubMenuGrant04']").length;
    if(SubMenuGrant04_length>0) {
    	for(i=0;i<SubMenuGrant04_length;i++) {
    		if($("input[name='SubMenuGrant04']:eq("+i+")").is(":checked")==true) {
    			if(SubMenuGrant04=="") {
    				SubMenuGrant04 = $("input[name='SubMenuGrant04']:eq("+i+")").val();
    			}else{
    				SubMenuGrant04 = SubMenuGrant04 + "," + $("input[name='SubMenuGrant04']:eq("+i+")").val();
    			}
    		}
    	}
    }
    
    var SubMenuGrant05_length = $("input[name='SubMenuGrant05']").length;
    if(SubMenuGrant05_length>0) {
    	for(i=0;i<SubMenuGrant05_length;i++) {
    		if($("input[name='SubMenuGrant05']:eq("+i+")").is(":checked")==true) {
    			if(SubMenuGrant05=="") {
    				SubMenuGrant05 = $("input[name='SubMenuGrant05']:eq("+i+")").val();
    			}else{
    				SubMenuGrant05 = SubMenuGrant05 + "," + $("input[name='SubMenuGrant05']:eq("+i+")").val();
    			}
    		}
    	}
    }
    
    var SubMenuGrant06_length = $("input[name='SubMenuGrant06']").length;
    if(SubMenuGrant06_length>0) {
    	for(i=0;i<SubMenuGrant06_length;i++) {
    		if($("input[name='SubMenuGrant06']:eq("+i+")").is(":checked")==true) {
    			if(SubMenuGrant06=="") {
    				SubMenuGrant06 = $("input[name='SubMenuGrant06']:eq("+i+")").val();
    			}else{
    				SubMenuGrant06 = SubMenuGrant06 + "," + $("input[name='SubMenuGrant06']:eq("+i+")").val();
    			}
    		}
    	}
    }
    
    var SubMenuGrant07_length = $("input[name='SubMenuGrant07']").length;
    if(SubMenuGrant07_length>0) {
    	for(i=0;i<SubMenuGrant07_length;i++) {
    		if($("input[name='SubMenuGrant07']:eq("+i+")").is(":checked")==true) {
    			if(SubMenuGrant07=="") {
    				SubMenuGrant07 = $("input[name='SubMenuGrant07']:eq("+i+")").val();
    			}else{
    				SubMenuGrant07 = SubMenuGrant07 + "," + $("input[name='SubMenuGrant07']:eq("+i+")").val();
    			}
    		}
    	}
    }
    
    var SubMenuGrant08_length = $("input[name='SubMenuGrant08']").length;
    if(SubMenuGrant08_length>0) {
    	for(i=0;i<SubMenuGrant08_length;i++) {
    		if($("input[name='SubMenuGrant08']:eq("+i+")").is(":checked")==true) {
    			if(SubMenuGrant08=="") {
    				SubMenuGrant08 = $("input[name='SubMenuGrant08']:eq("+i+")").val();
    			}else{
    				SubMenuGrant08 = SubMenuGrant08 + "," + $("input[name='SubMenuGrant08']:eq("+i+")").val();
    			}
    		}
    	}
    }

    var SubMenuGrant09_length = $("input[name='SubMenuGrant09']").length;
    if(SubMenuGrant09_length>0) {
    	for(i=0;i<SubMenuGrant09_length;i++) {
    		if($("input[name='SubMenuGrant09']:eq("+i+")").is(":checked")==true) {
    			if(SubMenuGrant09=="") {
    				SubMenuGrant09 = $("input[name='SubMenuGrant09']:eq("+i+")").val();
    			}else{
    				SubMenuGrant09 = SubMenuGrant09 + "," + $("input[name='SubMenuGrant09']:eq("+i+")").val();
    			}
    		}
    	}
    }

    var SubMenuGrant10_length = $("input[name='SubMenuGrant10']").length;
    if(SubMenuGrant10_length>0) {
    	for(i=0;i<SubMenuGrant10_length;i++) {
    		if($("input[name='SubMenuGrant10']:eq("+i+")").is(":checked")==true) {
    			if(SubMenuGrant10=="") {
    				SubMenuGrant10 = $("input[name='SubMenuGrant10']:eq("+i+")").val();
    			}else{
    				SubMenuGrant10 = SubMenuGrant10 + "," + $("input[name='SubMenuGrant10']:eq("+i+")").val();
    			}
    		}
    	}
    }
    
    
    if(SubMenuGrant01!="") {
    	if(SubMenuGrant=="") {
    		SubMenuGrant = SubMenuGrant01;
    	}else{
    		SubMenuGrant = SubMenuGrant + "," + SubMenuGrant01;
    	}
    }
    
    if(SubMenuGrant02!="") {
    	if(SubMenuGrant=="") {
    		SubMenuGrant = SubMenuGrant02;
    	}else{
    		SubMenuGrant = SubMenuGrant + "," + SubMenuGrant02;
    	}
    }
    
    if(SubMenuGrant03!="") {
    	if(SubMenuGrant=="") {
    		SubMenuGrant = SubMenuGrant03;
    	}else{
    		SubMenuGrant = SubMenuGrant + "," + SubMenuGrant03;
    	}
    }
    
    if(SubMenuGrant04!="") {
    	if(SubMenuGrant=="") {
    		SubMenuGrant = SubMenuGrant04;
    	}else{
    		SubMenuGrant = SubMenuGrant + "," + SubMenuGrant04;
    	}
    }
    
    if(SubMenuGrant05!="") {
    	if(SubMenuGrant=="") {
    		SubMenuGrant = SubMenuGrant05;
    	}else{
    		SubMenuGrant = SubMenuGrant + "," + SubMenuGrant05;
    	}
    }
    
    if(SubMenuGrant06!="") {
    	if(SubMenuGrant=="") {
    		SubMenuGrant = SubMenuGrant06;
    	}else{
    		SubMenuGrant = SubMenuGrant + "," + SubMenuGrant06;
    	}
    }
    
    if(SubMenuGrant07!="") {
    	if(SubMenuGrant=="") {
    		SubMenuGrant = SubMenuGrant07;
    	}else{
    		SubMenuGrant = SubMenuGrant + "," + SubMenuGrant07;
    	}
    }
    
    if(SubMenuGrant08!="") {
    	if(SubMenuGrant=="") {
    		SubMenuGrant = SubMenuGrant08;
    	}else{
    		SubMenuGrant = SubMenuGrant + "," + SubMenuGrant08;
    	}
    }

    if(SubMenuGrant09!="") {
    	if(SubMenuGrant=="") {
    		SubMenuGrant = SubMenuGrant08SubMenuGrant09
    	}else{
    		SubMenuGrant = SubMenuGrant + "," + SubMenuGrant09;
    	}
    }

    if(SubMenuGrant10!="") {
    	if(SubMenuGrant=="") {
    		SubMenuGrant = SubMenuGrant10;
    	}else{
    		SubMenuGrant = SubMenuGrant + "," + SubMenuGrant10;
    	}
    }

	$("#SubMenuGrant").val(SubMenuGrant);


	Yes = confirm("등록 하시겠습니까?");
    if(Yes==true) {    
    	val.submit();
    }
}

function DelOk() {
    Yes = confirm("삭제 하시겠습니까?");
    if(Yes==true) {
    	document.Form1.mode.value="Del";
    	document.Form1.submit();
    }
}
</SCRIPT>
</head>

<body leftmargin="0" topmargin="0">

<div id="wrap">

    
    <!-- Content -->
	<div class="Content">

        <div class="contentBody">
        	<!-- ########## -->
            <h2><?=$DeptTitle?> <?=$ModeScript?></h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
				<form name="Form1" method="post" action="dept_category_reg_script.php">
				<INPUT TYPE="hidden" NAME="idx" value="<?=$idx?>">
				<INPUT TYPE="hidden" NAME="mode" value="<?=$mode?>">
				<INPUT TYPE="hidden" NAME="Dept" value="<?=$Dept?>">
				<INPUT TYPE="hidden" NAME="ParentCategory" value="<?=$ParentCategory?>">
				<INPUT TYPE="hidden" NAME="Deep" value="<?=$Deep?>">
				<INPUT TYPE="hidden" NAME="DeptString" value="<?=$DeptString?>">
				<INPUT TYPE="hidden" NAME="TopMenuGrant" id="TopMenuGrant" value="<?=$TopMenuGrant?>">
				<INPUT TYPE="hidden" NAME="SubMenuGrant" id="SubMenuGrant" value="<?=$SubMenuGrant?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>상위 카테고리</th>
                    <td><?=$Upper_DeptName?></td>
                  </tr>
                  <tr>
                    <th>카테고리명</th>
                    <td><input type="text" name="DeptName" id="DeptName" value="<?=$DeptName?>" size="75"></td>
                  </tr>
				  <?if($Dept=="A") { //관리자일 경우 권한설정?>
                  <tr>
                    <th>권한 설정</th>
                    <td>
    					<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
    						<tr>
    							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant01" value="A" <?if(in_array('A',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant01"><strong>회원관리</strong></label></td>
    							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant02" value="B" <?if(in_array('B',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant02"><strong>수강관리</strong></label></td>
    							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant03" value="C" <?if(in_array('C',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant03"><strong>독려관리</strong></label></td>
    							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant04" value="D" <?if(in_array('D',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant04"><strong>컨텐츠관리</strong></label></td>							
    							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant05" value="E" <?if(in_array('E',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant05"><strong>사업주훈련</strong></label></td>
    						</tr>
    						<tr>
    							<td valign="top">
        							<input type="checkbox" name="SubMenuGrant01" id="SubMenuGrant01_01" value="A1" <?if(in_array('A1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant01_01">사업주관리</label><br>
        							<input type="checkbox" name="SubMenuGrant01" id="SubMenuGrant01_02" value="A2" <?if(in_array('A2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant01_02">수강생관리</label><br>
        							<input type="checkbox" name="SubMenuGrant01" id="SubMenuGrant01_03" value="A3" <?if(in_array('A3',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant01_03">수강등록</label><br>
        							<input type="checkbox" name="SubMenuGrant01" id="SubMenuGrant01_04" value="A4" <?if(in_array('A4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant01_04">탈퇴회원관리</label><br>
        							<input type="checkbox" name="SubMenuGrant01" id="SubMenuGrant01_05" value="A5" <?if(in_array('A5',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant01_05">관리자/영업자 카테고리</label><br>
        							<input type="checkbox" name="SubMenuGrant01" id="SubMenuGrant01_06" value="A6" <?if(in_array('A6',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant01_06">관리자 리스트</label><br>
        							<input type="checkbox" name="SubMenuGrant01" id="SubMenuGrant01_07" value="A7" <?if(in_array('A7',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant01_07">영업자 리스트</label><br>
        							<input type="checkbox" name="SubMenuGrant01" id="SubMenuGrant01_08" value="A8" <?if(in_array('A8',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant01_08">첨삭강사 리스트</label>
    							</td>
    							<td valign="top">
        							<input type="checkbox" name="SubMenuGrant02" id="SubMenuGrant02_01" value="B1" <?if(in_array('B1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant02_01">토론방</label><br>
        							<input type="checkbox" name="SubMenuGrant02" id="SubMenuGrant02_02" value="B2" <?if(in_array('B2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant02_02">IP모니터링</label>
    							</td>
    							<td valign="top">
        							<input type="checkbox" name="SubMenuGrant03" id="SubMenuGrant03_01" value="C1" <?if(in_array('C1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant03_01">학습참여독려</label><br>
        							<input type="checkbox" name="SubMenuGrant03" id="SubMenuGrant03_02" value="C2" <?if(in_array('C2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant03_02">문자발송내역</label><br>
        							<input type="checkbox" name="SubMenuGrant03" id="SubMenuGrant03_03" value="C3" <?if(in_array('C3',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant03_03">메일발송내역(교육담당자)</label><br>
        							<input type="checkbox" name="SubMenuGrant03" id="SubMenuGrant03_04" value="C4" <?if(in_array('C4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant03_04">메일발송내역(훈련생)</label><br>
        							<input type="checkbox" name="SubMenuGrant03" id="SubMenuGrant03_07" value="C7" <?if(in_array('C7',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant03_07">문자/템플릿관리</label>
    							</td>
    							<td valign="top">
        							<input type="checkbox" name="SubMenuGrant04" id="SubMenuGrant04_01" value="D1" <?if(in_array('D1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant04_01">강사 관리</label><br>
        							<input type="checkbox" name="SubMenuGrant04" id="SubMenuGrant04_02" value="D2" <?if(in_array('D2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant04_02">문제은행관리</label><br>
        							<input type="checkbox" name="SubMenuGrant04" id="SubMenuGrant04_03" value="D3" <?if(in_array('D3',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant04_03">토론주제관리</label><br>
        							<input type="checkbox" name="SubMenuGrant04" id="SubMenuGrant04_04" value="D4" <?if(in_array('D4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant04_04">과정카테고리관리</label><br>
        							<input type="checkbox" name="SubMenuGrant04" id="SubMenuGrant04_05" value="D5" <?if(in_array('D5',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant04_05">기초차시관리</label><br>
        							<input type="checkbox" name="SubMenuGrant04" id="SubMenuGrant04_06" value="D6" <?if(in_array('D6',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant04_06">설문관리</label>
    							</td>
    							<td valign="top">
    								<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_01" value="E1" <?if(in_array('E1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_01">단과컨텐츠관리</label><br>
        							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_02" value="E2" <?if(in_array('E2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_02">패키지컨텐츠관리</label><br>
        							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_03" value="E3" <?if(in_array('E3',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_03">학습신청관리</label><br>
        							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_04" value="E4" <?if(in_array('E4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_04">학습관리</label><br>
        							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_05" value="E5" <?if(in_array('E5',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_05">첨삭관리</label><br>
        							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_06" value="E6" <?if(in_array('E6',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_06">실시관리</label><br>
        							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_07" value="E7" <?if(in_array('E7',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_07">수강마감</label><br>
        							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_08" value="E8" <?if(in_array('E8',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_08">결제관리</label>
    							</td>
    						</tr>
    					</table>
    					<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
    						<tr>
    							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant06" value="F" <?if(in_array('F',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant06"><strong>내일배움카드</strong></label></td>
    							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant07" value="G" <?if(in_array('G',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant07"><strong>FLEX</strong></label></td>														
    							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant08" value="H" <?if(in_array('H',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant08"><strong>커뮤니티관리</strong></label></td>
    							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant09" value="I" <?if(in_array('I',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant09"><strong>통계관리</strong></label></td>
    							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant10" value="J" <?if(in_array('J',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant10"><strong>사이트관리</strong></label></td>
    						</tr>
    						<tr>
    							<td valign="top">
        							<input type="checkbox" name="SubMenuGrant06" id="SubMenuGrant06_01" value="F1" <?if(in_array('F1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant06_01">단과컨텐츠관리</label><br>
        							<input type="checkbox" name="SubMenuGrant06" id="SubMenuGrant06_02" value="F2" <?if(in_array('F2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant06_02">컨텐츠키워드관리</label><br>
        							<input type="checkbox" name="SubMenuGrant06" id="SubMenuGrant06_03" value="F3" <?if(in_array('F3',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant06_03">BEST컨텐츠관리</label><br>
        							<input type="checkbox" name="SubMenuGrant06" id="SubMenuGrant06_04" value="F4" <?if(in_array('F4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant06_04">NEW컨텐츠관리</label><br>
        							<input type="checkbox" name="SubMenuGrant06" id="SubMenuGrant06_05" value="F5" <?if(in_array('F5',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant06_05">학습신청/결제관리</label><br>
        							<input type="checkbox" name="SubMenuGrant06" id="SubMenuGrant06_06" value="F6" <?if(in_array('F6',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant06_06">학습관리</label><br>
        							<input type="checkbox" name="SubMenuGrant06" id="SubMenuGrant06_07" value="F7" <?if(in_array('F7',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant06_07">첨삭관리</label><br>
        							<input type="checkbox" name="SubMenuGrant06" id="SubMenuGrant06_08" value="F8" <?if(in_array('F8',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant06_08">수강마감</label>
    							</td>
    							<td valign="top">
    								<input type="checkbox" name="SubMenuGrant07" id="SubMenuGrant07_01" value="G1" <?if(in_array('G1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant07_01">컨텐츠관리</label><br>
        							<input type="checkbox" name="SubMenuGrant07" id="SubMenuGrant07_02" value="G2" <?if(in_array('G2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant07_02">카테고리관리</label><br>
        							<input type="checkbox" name="SubMenuGrant07" id="SubMenuGrant07_03" value="G3" <?if(in_array('G3',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant07_03">컨텐츠키워드관리</label><br>
        							<input type="checkbox" name="SubMenuGrant07" id="SubMenuGrant07_04" value="G4" <?if(in_array('G4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant07_04">PICK/TOP/NEW 컨텐츠관리</label><br>
        							<input type="checkbox" name="SubMenuGrant07" id="SubMenuGrant07_05" value="G5" <?if(in_array('G5',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant07_05">관심강의관리</label>
    							</td>
    							<td valign="top">
        							<input type="checkbox" name="SubMenuGrant08" id="SubMenuGrant08_01" value="H1" <?if(in_array('H1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant08_01">공지사항</label><br>
        							<input type="checkbox" name="SubMenuGrant08" id="SubMenuGrant08_02" value="H2" <?if(in_array('H2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant08_02">자주묻는질문</label><br>
        							<input type="checkbox" name="SubMenuGrant08" id="SubMenuGrant08_03" value="H3" <?if(in_array('H3',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant08_03">1:1상담/학습상담</label><br>
        							<input type="checkbox" name="SubMenuGrant08" id="SubMenuGrant08_04" value="H4" <?if(in_array('H4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant08_04">수강후기</label><br>
        							<input type="checkbox" name="SubMenuGrant08" id="SubMenuGrant08_05" value="H5" <?if(in_array('H5',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant08_05">학습자료실</label><br>
        							<input type="checkbox" name="SubMenuGrant08" id="SubMenuGrant08_06" value="H6" <?if(in_array('H6',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant08_06">간편문의</label><br>
        							<input type="checkbox" name="SubMenuGrant08" id="SubMenuGrant08_07" value="H7" <?if(in_array('H7',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant08_07">FLEX문의</label><br>
    							</td>
    							<td valign="top">
        							<input type="checkbox" name="SubMenuGrant09" id="SubMenuGrant09_01" value="I1" <?if(in_array('I1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant09_01">접속통계관리</label><br>
        							<input type="checkbox" name="SubMenuGrant09" id="SubMenuGrant09_02" value="I2" <?if(in_array('I2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant09_02">영업통계관리(사업주)</label>
    							</td>
    							<td valign="top">
        							<input type="checkbox" name="SubMenuGrant10" id="SubMenuGrant10_01" value="J1" <?if(in_array('J1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant10_01">팝업관리</label><br>
        							<input type="checkbox" name="SubMenuGrant10" id="SubMenuGrant10_02" value="J2" <?if(in_array('J2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant10_02">메인컨텐츠관리</label><br>
        							<input type="checkbox" name="SubMenuGrant10" id="SubMenuGrant10_03" value="J3" <?if(in_array('J3',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant10_03">작업요청게시판</label><br>
        							<input type="checkbox" name="SubMenuGrant10" id="SubMenuGrant10_04" value="J4" <?if(in_array('J4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant10_04">사이트정보관리</label><br>
        							<input type="checkbox" name="SubMenuGrant10" id="SubMenuGrant10_05" value="J4" <?if(in_array('J4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant10_05">교육원고유정보관리</label>
    							</td>
    						</tr>
    					</table>
					</td>
                  </tr>
				  <?}//관리자일 경우 권한설정?>
				  <?if($Dept=="B") { //영업자일 경우 권한설정?>
                  <tr>
                    <th>권한 설정</th>
                    <td>
						<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
    						<tr>
    							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant01" value="A" <?if(in_array('A',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant01"><strong>회원관리</strong></label></td>
    							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant03" value="C" <?if(in_array('C',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant03"><strong>독려관리</strong></label></td>    													
    							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant05" value="E" <?if(in_array('E',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant05"><strong>사업주훈련</strong></label></td>
    							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant06" value="F" <?if(in_array('F',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant06"><strong>내일배움카드</strong></label></td>
    							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant07" value="G" <?if(in_array('G',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant07"><strong>FLEX</strong></label></td>														
    							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant08" value="H" <?if(in_array('H',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant08"><strong>커뮤니티관리</strong></label></td>
    						</tr>
    						<tr>
    							<td valign="top">
        							<input type="checkbox" name="SubMenuGrant01" id="SubMenuGrant01_01" value="A1" <?if(in_array('A1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant01_01">사업주관리</label><br>
        							<input type="checkbox" name="SubMenuGrant01" id="SubMenuGrant01_02" value="A2" <?if(in_array('A2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant01_02">수강생관리</label>
    							</td>
    							<td valign="top">
        							<input type="checkbox" name="SubMenuGrant03" id="SubMenuGrant03_02" value="C2" <?if(in_array('C2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant03_02">문자발송내역</label><br>
        							<input type="checkbox" name="SubMenuGrant03" id="SubMenuGrant03_03" value="C3" <?if(in_array('C3',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant03_03">메일발송내역(교육담당자)</label><br>
        							<input type="checkbox" name="SubMenuGrant03" id="SubMenuGrant03_04" value="C4" <?if(in_array('C4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant03_04">메일발송내역(훈련생)</label>
    							</td>
    							<td valign="top">
    								<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_01" value="E1" <?if(in_array('E1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_01">단과컨텐츠관리</label><br>
        							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_02" value="E2" <?if(in_array('E2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_02">패키지컨텐츠관리</label><br>
        							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_04" value="E4" <?if(in_array('E4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_04">학습관리</label><br>
        							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_06" value="E6" <?if(in_array('E6',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_06">실시관리</label>
    							</td>
    							<td valign="top">
        							<input type="checkbox" name="SubMenuGrant06" id="SubMenuGrant06_01" value="F1" <?if(in_array('F1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant06_01">단과컨텐츠관리</label><br>
        							<input type="checkbox" name="SubMenuGrant06" id="SubMenuGrant06_06" value="F6" <?if(in_array('F6',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant06_06">학습관리</label>
    							</td>
    							<td valign="top">
    								<input type="checkbox" name="SubMenuGrant07" id="SubMenuGrant07_01" value="G1" <?if(in_array('G1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant07_01">단과컨텐츠관리</label>
    							</td>
    							<td valign="top">
        							<input type="checkbox" name="SubMenuGrant08" id="SubMenuGrant08_01" value="H1" <?if(in_array('H1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant08_01">공지사항</label><br>
        							<input type="checkbox" name="SubMenuGrant08" id="SubMenuGrant08_02" value="H2" <?if(in_array('H2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant08_02">자주묻는질문</label><br>
        							<input type="checkbox" name="SubMenuGrant08" id="SubMenuGrant08_03" value="H3" <?if(in_array('H3',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant08_03">1:1상담/학습상담</label><br>
        							<input type="checkbox" name="SubMenuGrant08" id="SubMenuGrant08_04" value="H4" <?if(in_array('H4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant08_04">수강후기</label><br>
        							<input type="checkbox" name="SubMenuGrant08" id="SubMenuGrant08_05" value="H5" <?if(in_array('H5',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant08_05">학습자료실</label><br>
        							<input type="checkbox" name="SubMenuGrant08" id="SubMenuGrant08_06" value="H6" <?if(in_array('H6',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant08_06">간편문의</label><br>
        							<input type="checkbox" name="SubMenuGrant08" id="SubMenuGrant08_07" value="H7" <?if(in_array('H7',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant08_07">FLEX문의</label>
    							</td>
    						</tr>
    					</table>
					</td>
                  </tr>
				  <?}//영업자일 경우 권한설정?>
				  <?if($Dept=="C") { //첨삭강사일 경우 권한설정?>
                  <tr>
                    <th>권한 설정</th>
                    <td>
						<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
    						<tr>
    														
    							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant05" value="E" <?if(in_array('E',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant05"><strong>사업주훈련</strong></label></td>
    							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant06" value="F" <?if(in_array('F',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant06"><strong>내일배움카드</strong></label></td>
    							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant07" value="G" <?if(in_array('G',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant07"><strong>FLEX</strong></label></td>														
    							<td><input type="checkbox" name="TopMenuGrant01" id="TopMenuGrant08" value="H" <?if(in_array('H',$TopMenuGrant_array)){?>checked<?}?>> <label for="TopMenuGrant08"><strong>커뮤니티관리</strong></label></td>
    						</tr>
    						<tr>
    							<td valign="top">
        							<input type="checkbox" name="SubMenuGrant05" id="SubMenuGrant05_05" value="E5" <?if(in_array('E5',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant05_05">첨삭관리</label>
    							</td>
    							<td valign="top">
        							<input type="checkbox" name="SubMenuGrant06" id="SubMenuGrant06_07" value="F7" <?if(in_array('F7',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant06_07">첨삭관리</label>
    							</td>
    							<td valign="top">
    							</td>
    							<td valign="top">
        							<input type="checkbox" name="SubMenuGrant08" id="SubMenuGrant08_01" value="H1" <?if(in_array('H1',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant08_01">공지사항</label><br>
        							<input type="checkbox" name="SubMenuGrant08" id="SubMenuGrant08_02" value="H2" <?if(in_array('H2',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant08_02">자주묻는질문</label><br>
        							<input type="checkbox" name="SubMenuGrant08" id="SubMenuGrant08_03" value="H3" <?if(in_array('H3',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant08_03">1:1상담/학습상담</label><br>
        							<input type="checkbox" name="SubMenuGrant08" id="SubMenuGrant08_04" value="H4" <?if(in_array('H4',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant08_04">수강후기</label><br>
        							<input type="checkbox" name="SubMenuGrant08" id="SubMenuGrant08_05" value="H5" <?if(in_array('H5',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant08_05">학습자료실</label><br>
        							<input type="checkbox" name="SubMenuGrant08" id="SubMenuGrant08_06" value="H6" <?if(in_array('H6',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant08_06">간편문의</label><br>
        							<input type="checkbox" name="SubMenuGrant08" id="SubMenuGrant08_07" value="H7" <?if(in_array('H7',$SubMenuGrant_array)){?>checked<?}?>> <label for="SubMenuGrant08_07">FLEX문의</label>
    							</td>
    						</tr>
    					</table>
					</td>
                  </tr>
				  <?}//첨삭강사일 경우 권한설정?>
                </table>
				</form>
				<div class="btnAreaTc02">
					<?if($mode=="Edit") {?><button type="button" onclick="DelOk();" class="btn btn_DGray line">삭제</button>&nbsp;&nbsp;&nbsp;<?}?>
					<button type="button" onclick="SubmitOk();" class="btn btn_Blue"><?=$ModeScript?> 하기</button>&nbsp;&nbsp;&nbsp;
					<button type="button" onclick="self.close();" class="btn btn_DGray line">닫기</button>
                </div>
                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>

	</div>
    <!-- Content // -->


</div>

</body>
</html>