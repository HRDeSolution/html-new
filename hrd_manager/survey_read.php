<?
$MenuType = "F";
$PageName = "survey";
$ReadPage = "survey_read";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);

$Sql = "SELECT a.LectureCode , a.ID , a.StarPoint , a.RegDate , a.Title, a.Contents, a.ViewCount, a.IP, b.ContentsName
		FROM Review a
		LEFT JOIN Course b ON a.LectureCode = b.LectureCode
		WHERE a.idx=$idx AND a.Del='N'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
    $LectureCode = $Row['LectureCode'];
    $ID = $Row['ID'];
    $StarPoint = $Row['StarPoint'];
    $RegDate = $Row['RegDate'];
    $Title = $Row['Title'];
    $Contents = nl2br(stripslashes($Row['Contents']));
    $ViewCount = $Row['ViewCount'];
    $ContentsName = $Row['ContentsName'];
    $IP = $Row['IP'];
}
$Star = StarPointView($StarPoint);
?>
<SCRIPT LANGUAGE="JavaScript">
	//삭제기능
	function DelOk() {
    	del_confirm = confirm("현재 수강후기를 삭제하시겠습니까?");
    	if(del_confirm==true) {
    		DeleteForm.submit();
    	}
    }
</SCRIPT>
	<div class="contentBody">
		<h2>수강후기</h2>
        <div class="conZone">
        	<form name="DeleteForm" method="post" action="survey_script.php" enctype="multipart/form-data" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="del">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
			</form>
            <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
            	<colgroup>
                	<col width="120px" />
                    <col width="300px" />
                    <col width="120px" />
                    <col width="300px" />
            	</colgroup>
                <tr>
                	<th>과정명</th>
                    <td colspan="3"><?=$ContentsName?></td>
            	</tr>
				<tr>
                    <th>별점</th>
                    <td><?=$Star?></td>
                    <th>아이디</th>
                    <td><?=$ID?></td>
                </tr>
				<tr>
                    <th>등록IP</th>
                    <td><?=$IP?></td>
                    <th>등록일</th>
                    <td><?=$RegDate?></td>
                </tr>
                <tr>
                	<th>제목</th>
                    <td colspan="3"><?=$Title?></td>
                </tr>
				<tr>
                	<th>내용</th>
                    <td height="28" colspan="3">
						<table border="0" width="970px">
							<tr>
								<td style="border:0px"><?=$Contents?></td>
							</tr>
						</table>
					</td>
                </tr>
            </table>
            <table width="100%"  border="0" cellspacing="0" cellpadding="0" class="gapT20">
				<tr>
					<td align="left" width="150" valign="top"><input type="button" value="삭 제" onclick="DelOk()" class="btn_inputLine01"></td>
					<td align="right" valign="top"><input type="button" value="목록" onclick="location.href='<?=$PageName?>.php?pg=<?=$pg?>&sw=<?=urlencode($sw)?>&col=<?=$col?>'" class="btn_inputLine01"></td>
				</tr>
			</table>
		</div>
    </div>
</div>
<!-- Content // -->

<!-- 컨텐츠등록 Editor -->
<script type="text/javascript">
    var oEditors = [];
    // 추가 글꼴 목록
    //var aAdditionalFontSet = [["MS UI Gothic", "MS UI Gothic"], ["Comic Sans MS", "Comic Sans MS"],["TEST","TEST"]];
    nhn.husky.EZCreator.createInIFrame({
    	oAppRef: oEditors,
    	elPlaceHolder: "Contents2",
    	sSkinURI: "./smarteditor/SmartEditor2Skin.html",	
    	htParams : {
    		bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
    		bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
    		bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
    		//aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
    		fOnBeforeUnload : function(){
    			//alert("완료!");
    		}
    	}, //boolean
    	fOnAppLoad : function(){
    		//예제 코드
    		//var sHTML = "";
    		//oEditors.getById["contents"].exec("PASTE_HTML", [sHTML]);
    	},
    	fCreator: "createSEditor2"
    });
</script>

<SCRIPT LANGUAGE="JavaScript">
    function SubmitOk() {    
    	val = document.Form1;    
    	if(val.Name2.value=="") {
    		alert("작성자를 입력하세요.");
    		val.Name2.focus();
    		return;
    	}    
    	oEditors.getById["Contents2"].exec("UPDATE_CONTENTS_FIELD", []);
       	if(document.getElementById("Contents2").value.length < 15) {
    		alert("답변 내용을 입력해주세요");
    		return;
    	}    
    	Yes = confirm("등록하시겠습니까?");
    	if(Yes==true) {
    		$("#SubmitBtn").hide();
    		$("#Waiting").show();
    		val.submit();
    	}
    }
</SCRIPT>
	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>