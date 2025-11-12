<?
$MenuType = "J";
?>
<? include "./include/include_top.php"; ?>
<?
$MenuCode = Replace_Check($MenuCode);

Switch ($mode) {
	case "new":
		$ScriptTitle = "등록";
	break;
	case "edit":
		$ScriptTitle = "수정";
	break;
	case "del":
		$ScriptTitle = "삭제";
	break;
}
?>
    <!-- Right -->
    <div class="contentBody">
    	<!-- ########## -->
        <h2>메인 콘텐츠 관리 <?=$ScriptTitle?></h2>    
        <div class="conZone">
        	<!-- ## START -->
<?
    if($mode!="new") {
        $Sql = "SELECT idx, MenuCode , MenuName , RegDate , UseYN ,MdfDate , Link ";
        $Sql .= "FROM MainContents ";
        $Sql .= "WHERE MenuCode = '$MenuCode' ";
        
    	$Result = mysqli_query($connect, $Sql);
    	$Row = mysqli_fetch_array($Result);
    	
    	$idx       = $Row['idx'];
    	$MenuCode  = $Row['MenuCode'];
    	$MenuName  = $Row['MenuName'];
    	$RegDate   = $Row['RegDate'];
    	$UseYN     = $Row['UseYN'];
    	$MdfDate   = $Row['MdfDate'];
    	$Link      = $Row['Link'];
    }
?>
<script type="text/javascript">
	function send_ok() {    
    	val = document.send;
    	if(val.MenuName.value=="") {
    		alert("메뉴이름을 입력하세요.");
    		val.MenuName.focus();
    		return;
    	}
    	val.submit();
    }
</script>
        	<!-- 입력 -->
			<form name="send" method="post" action="main_contents_script.php" enctype="multipart/form-data">
				<input TYPE="hidden" name="MenuCode" value="<?=$MenuCode?>">
				<input TYPE="hidden" name="mode" value="<?=$mode?>">
				
				<div class="btnAreaTl02">
    				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">상세 <?=$ScriptTitle?></span>
    			</div>
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
					<colgroup>
                        <col width="120px" />
                        <col width="" />
                  	</colgroup>
                    <tr>
                        <th>사용 여부</font></th>
                        <td><input name="UseYN" type="radio" value="Y" <?if(($UseYN=="Y") || ($UseYN=="")){ echo "checked";}?>>사용 &nbsp;&nbsp;&nbsp;<input name="UseYN" type="radio" value="N" <?if($UseYN=="N"){ echo "checked";}?>>미사용 &nbsp;&nbsp;&nbsp;</td>
                    </tr>
                    <tr>
                        <th>메뉴 이름</th>
                        <td><input name="MenuName" type="text" size="100" value="<?=$MenuName?>"></td>
                    </tr>
                    <tr>
                    	<th>바로가기 링크</th>
                        <td><input name="Link" type="text" size="100" value="<?=$Link?>"></td>
                    </tr>
                </table>
			</form>
            <!-- 버튼 -->
	  		<div class="btnAreaTc02" id="SubmitBtn">
            	<input type="button" name="SubmitBtn" id="SubmitBtn" value="<?=$ScriptTitle?>" class="btn_inputBlue01" onclick="send_ok()">
      			<input type="button" name="ResetBtn" id="ResetBtn" value="목록" class="btn_inputLine01" onclick="location.href='main_contents_list.php'">
            </div>                
            <!-- ## END -->
		</div>
        <!-- ########## // -->
	</div>
	<!-- Right // -->
</div>
<!-- Content // -->

<!-- Footer -->
<? include "./include/include_bottom.php"; ?>
