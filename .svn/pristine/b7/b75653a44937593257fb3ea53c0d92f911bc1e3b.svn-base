<?
include "../include/include_function.php"; 
include "./include/include_admin_check.php";

$ID = Replace_Check($ID);
$mode = Replace_Check($mode);
$idx = Replace_Check($idx);

if($mode!="New") {

	$Sql = "SELECT m.*,c.CompanyName FROM MemberCompany  as m
				INNER JOIN Company as c on m.CompanyCode = c.CompanyCode WHERE m.idx=$idx";
				
	
	$Result = mysqli_query($connect, $Sql);
	$Row = mysqli_fetch_array($Result);

	if($Row) {
		$ID = $Row['ID'];		
		$CompanyCode = $Row['CompanyCode'];	
		$CompanyName = $Row['CompanyName'];		
	}
 
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<head>
<title><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="./css/style.css" type="text/css">
<link rel="stylesheet" type="text/css" href="./include/jquery-ui.css" />
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./include/jquery-ui.js"></script>
<script type="text/javascript" src="./include/jquery.ui.datepicker-ko.js"></script>
<script type="text/javascript" src="./include/function.js"></script>
<script type="text/javascript" src="./smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
<SCRIPT LANGUAGE="JavaScript">
<!--
function SubmitOk() {

	val = document.Form1;

	if(val.CompanyCode.value=="") {
		alert("회사를 선택하세요.");
		val.Category.focus();
		return;
	}

	Yes = confirm("등록 하시겠습니까?");
	if(Yes==true) {

		val.submit();
	}

}

function Delete() {

	Yes = confirm("삭제하시겠습니까?");
	if(Yes==true) {
		$("#mode").val('Delete');
		Form1.submit();
	}

}
//-->
</SCRIPT>
</head>

<body leftmargin="0" topmargin="0">

<div id="wrap">

    
    <!-- Content -->
	<div class="Content">

        <div class="contentBody">
        	<!-- ########## -->
            <h2>교육담당자 관리회사</h2>
            
            <div class="conZone">
            	<!-- ## START -->
                
				<form name="Form1" method="post" action="member_company_write_script.php">
				<INPUT TYPE="hidden" NAME="ID" id="ID" value="<?=$ID?>">
				<INPUT TYPE="hidden" NAME="mode" id="mode" value="<?=$mode?>">
				<INPUT TYPE="hidden" NAME="idx" id="idx" value="<?=$idx?>">
				<input type="hidden" name="CompanyCode" id="CompanyCode" value="<?=$CompanyCode?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>관리기업<th>
                    <td><input name="CompanyName" id="CompanyName" type="text"  size="40" value="<?=$CompanyName?>">&nbsp;
						<button type="button" onclick="MemberCompanySearch();" class="btn round btn_LBlue line"><i class="xi-search"></i> 검색</button>&nbsp;&nbsp;<span id="company_search_result"></span>
					</td>
                  </tr>
                   
                </table>
				</form>


				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
					<tr>
						<td align="left" width="200"><?if($mode!="New") {?><button type="button" onclick="Delete();" class="btn btn_DGray line">삭제</button><?}?></td>
						<td align="center"><button type="button" onclick="SubmitOk();" class="btn btn_Blue">등록 하기</button></td>
						<td width="200" align="right"><button type="button" onclick="self.close();" class="btn btn_DGray line">닫기</button></td>
					</tr>
				</table>

                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>

	</div>
    <!-- Content // -->


</div>

</body>
</html>