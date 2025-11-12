<?
$MenuType = "J";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);
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
        $Sql = "SELECT idx, MenuCode , Title , Image , Link , RegDate , UseYN , MdfDate FROM MainContentsImg ";
        $Sql .= "WHERE idx = '$idx' ";        
    	$Result = mysqli_query($connect, $Sql);
    	$Row = mysqli_fetch_array($Result);
    	
    	$idx      = $Row['idx'];
    	$MenuCode = $Row['MenuCode'];
    	$Title    = $Row['Title'];
    	$Image    = $Row['Image'];
    	$Link     = $Row['Link'];
    	$RegDate  = $Row['RegDate'];
    	$UseYN    = $Row['UseYN'];
    	$MdfDate  = $Row['MdfDate'];
    }
    if($Image) {
        $ImageView = "<img src='/upload/MainContents/".$Image."' width='150' align='absmiddle'>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('Image','attachFileArea') class='btn_inputLine01'>";
    }
?>
<script type="text/javascript">
	function send_ok() {    
    	val = document.send;
    	if(val.Title.value=="") {
    		alert("사진제목을 입력하세요.");
    		val.Title.focus();
    		return;
    	}
    	if(val.Image.value=="") {
    		alert("사진을 등록하세요.");
    		val.Image.focus();
    		return;
    	}else{
    		var imgVal = val.Image.value;
    		var extSplit = imgVal.split('.', 2);
    		var extChk = extSplit[1];
    		if(extChk != "jpeg" && extChk != "JPEG" && extChk != "jpg" && extChk != "JPG" && extChk != "png" && extChk != "PNG" && extChk != "gif" && extChk != "GIF" && extChk != "bmp" && extChk != "BMP"){
    			alert("이미지 파일만 등록이 가능합니다");
        		return;
    		}
    	}
    	if(val.Link.value=="") {
    		alert("링크를 입력하세요.");
    		val.Link.focus();
    		return;
    	}
    	val.submit();
    }
</script>
        	<!-- 입력 -->
			<form name="send" method="post" action="main_contents_img_script.php" enctype="multipart/form-data">
				<input TYPE="hidden" name="MenuCode" value="<?=$MenuCode?>">
				<input TYPE="hidden" name="mode" value="<?=$mode?>">
				<input TYPE="hidden" name="idx" value="<?=$idx?>">
				
				<div class="btnAreaTl02">
    				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">콘텐츠 상세 <?=$ScriptTitle?></span>
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
                        <th>콘텐츠 제목</th>
                        <td><input name="Title" type="text" size="100" value="<?=$Title?>"></td>
                    </tr>
                    <tr>
                        <th>썸네일</th>
                        <td bgcolor="#FFFFFF">
                        	<input name="Image" id="Image" type="hidden" value="<?=$Image?>">
                        	<span id="attachFileArea"><?=$ImageView?></span>&nbsp;
                        	<input type="button" value="파일 첨부" onclick="UploadFile('Image','attachFileArea','imgA');" class="btn_inputLine01" >
                        </td>					
                    </tr>
                    <tr>
                        <th>링크</th>
                        <td><input name="Link" type="text" size="100" value="<?=$Link?>"></td>
                    </tr>
                </table>
			</form>
            <!-- 버튼 -->
	  		<div class="btnAreaTc02" id="SubmitBtn">
            	<input type="button" name="SubmitBtn" id="SubmitBtn" value="<?=$ScriptTitle?>" class="btn_inputBlue01" onclick="send_ok()">
      			<input type="button" name="ResetBtn" id="ResetBtn" value="목록" class="btn_inputLine01" onclick="location.href='main_contents_read.php?MenuCode=<?=$MenuCode?>'">
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
