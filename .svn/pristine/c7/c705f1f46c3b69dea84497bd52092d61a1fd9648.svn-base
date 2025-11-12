<?
$MenuType = "H";
$PageName = "after";
$ReadPage = "after_read";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);

$Sql = "SELECT * FROM Review WHERE idx=$idx AND Del='N'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
    extract($Row);
    
    //수강후기 정보
    $Study_Seq = $Row['Study_Seq']; //수강내역 seq
    $LectureCode = $Row['LectureCode']; //강의코드
    $ID = $Row['ID']; //아이디
    $Name = $Row['Name']; //이름
    $StarPoint = $Row['StarPoint']; //별점
    $ContentsName = $Row['ContentsName']; //과정명
    $Title = $Row['Title']; //후기 제목
    $Contents = nl2br(stripslashes($Row['Contents'])); //후기내용
    $IP = $Row['IP']; //등록IP
    $RegDate = $Row['RegDate']; //등록일자
    $MainYN = $Row['MainYN']; //메인화면 노출여부
    $UseYN = $Row['UseYN']; //홈페이지 노출여부
    $Status = $Row['Status']; //답변상태(A:대기/B:완료)
    $Del = $Row['Del']; //삭제여부
    $ViewCount = $Row['ViewCount']; //조회수
    
    //답변 정보
    $Name2 = $Row['Name2']; //답변 작성자
    $Contents2 = $Row['Contents2']; //답변 내용
    $RegDate2 = $Row['RegDate2']; //답변 등록일자
    $FileName1 = $Row['FileName1']; //첨부파일1
    $RealFileName1 = $Row['RealFileName1']; //첨부파일1 실제파일
    $FileName2 = $Row['FileName2']; //첨부파일2
    $RealFileName2 = $Row['RealFileName2']; //첨부파일2 실제파일
    $FileName3 = $Row['FileName3']; //첨부파일3
    $RealFileName3 = $Row['RealFileName3']; //첨부파일3 실제파일
    $FileName4 = $Row['FileName4']; //첨부파일4
    $RealFileName4 = $Row['RealFileName4']; //첨부파일4 실제파일
    $FileName5 = $Row['FileName5']; //첨부파일5
    $RealFileName5 = $Row['RealFileName5']; //첨부파일5 실제파일
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
        	<form name="DeleteForm" method="post" action="after_script.php" enctype="multipart/form-data" target="ScriptFrame">
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
                    <td colspan="3"><?=$Star?></td>
                </tr>
                <tr>
                    <th>메인화면 노출여부</th>
                    <td><?if($MainYN == "Y") echo "노출"; else echo"미노출";?></td>
                    <th>홈페이지 노출여부</th>
                    <td><?if($UseYN == "Y") echo "노출"; else echo"미노출";?></td>
                </tr>
                <tr>
                    <th>아이디</th>
                    <td><?=$ID?></td>
                    <th>이름</th>
                    <td><?=$Name?></td>
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

			<br><br><br>
			<div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">답변</span>
			</div>

			<form name="Form1" method="post" action="after_script.php" enctype="multipart/form-data" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="reply">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01 gapT20">
                	<colgroup>
                        <col width="120px" />
                        <col width="" />
                  	</colgroup>
                  	<tr>
                        <th>처리 상태</th>
                        <td><?if($Status=="A") echo "대기"; else echo"답변완료";?></td>
                    </tr>
                 	<tr>
                    	<th>작성자</th>
                        <td><input name="Name2" type="text"  size="30" value="<?=$Name2?>"></td>
					</tr>
                 	<tr>
    					<th>답변 내용</th>
    					<td height="28"><textarea name="Contents2" id="Contents2" rows="10" cols="100" style="width:970px; height:420px; display:none;"><?=$Contents2?></textarea></td>
                 	</tr>
				</table>
			</form>

			<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="gapT20">
				<tr>
					<td align="left" width="150" valign="top"> </td>
					<td align="center" valign="top">
					<?if($AdminWrite=="Y") {?>
						<span id="SubmitBtn"><input type="button" value="답변 하기" onclick="SubmitOk()" class="btn_inputBlue01"></span>
						<span id="Waiting" style="display:none"><strong>처리중입니다...</strong></span>
					<?}?>
					</td>
					<td width="150" align="right" valign="top"><input type="button" value="목록" onclick="location.href='<?=$PageName?>.php?pg=<?=$pg?>&sw=<?=urlencode($sw)?>&col=<?=$col?>'" class="btn_inputLine01"></td>
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