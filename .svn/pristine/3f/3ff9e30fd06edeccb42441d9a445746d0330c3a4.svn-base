<?
$MenuType = "H";
$PageName = "qna";
$ReadPage = "qna_read";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);

$Sql = "SELECT *, AES_DECRYPT(UNHEX(Email),'$DB_Enc_Key') AS Email, AES_DECRYPT(UNHEX(Mobile),'$DB_Enc_Key') AS Mobile FROM Counsel WHERE idx=$idx AND Del='N'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
if($Row) {
    extract($Row);
    
	$Email = InformationProtection($Email,'Email','S');
	$Mobile = InformationProtection($Mobile,'Mobile','S');
	
	$file1 = html_quote($FileName1); //첨부파일1
	$RealFileName1 = $RealFileName1; //첨부파일1 실제파일명
	$file2 = html_quote($FileName2); //첨부파일2
	$RealFileName2 = $RealFileName2; //첨부파일2 실제파일명
	$file3 = html_quote($FileName3); //첨부파일3
	$RealFileName3 = $RealFileName3; //첨부파일3 실제파일명
	$file4 = html_quote($FileName4); //첨부파일4
	$RealFileName4 = $RealFileName4; //첨부파일4 실제파일명
	$file5 = html_quote($FileName5); //첨부파일5
	$RealFileName5 = $RealFileName5; //첨부파일5 실제파일명
}

if($file1) $file1View = "<input name='fileName1' id='fileName1' type='hidden' value='".$RealFileName1."'><A HREF='./download.php?idx=".$idx."&code=Counsel&file=1'><B>".$RealFileName1."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('file1','file1Area','/Counsel') class='btn_inputLine01'>";
if($file2) $file2View = "<input name='fileName2' id='fileName2' type='hidden' value='".$RealFileName2."'><A HREF='./download.php?idx=".$idx."&code=Counsel&file=2'><B>".$RealFileName2."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('file2','file2Area','/Counsel') class='btn_inputLine01'>";
if($file3) $file3View = "<input name='fileName3' id='fileName3' type='hidden' value='".$RealFileName3."'><A HREF='./download.php?idx=".$idx."&code=Counsel&file=3'><B>".$RealFileName3."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('file3','file3Area','/Counsel') class='btn_inputLine01'>";
if($file4) $file4View = "<input name='fileName4' id='fileName4' type='hidden' value='".$RealFileName4."'><A HREF='./download.php?idx=".$idx."&code=Counsel&file=4'><B>".$RealFileName4."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('file4','file4Area','/Counsel') class='btn_inputLine01'>";
if($file5) $file5View = "<input name='fileName5' id='fileName5' type='hidden' value='".$RealFileName5."'><A HREF='./download.php?idx=".$idx."&code=Counsel&file=5'><B>".$RealFileName5."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('file5','file5Area','/Counsel') class='btn_inputLine01'>";

if($LectureCode){
    $Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
    $Result = mysqli_query($connect, $Sql);
    $Row = mysqli_fetch_array($Result);
    if($Row) {
        $ContentsName = $Row['ContentsName'];
    }else{
        $Sql = "SELECT * FROM CourseCyber WHERE LectureCode='$LectureCode'";
        $Result = mysqli_query($connect, $Sql);
        $Row = mysqli_fetch_array($Result);
        if($Row) {
            $ContentsName = $Row['ContentsName'];
        }
    }
    
    $Sql = "SELECT * FROM Contents WHERE idx=$Contents_idx";
    $Result = mysqli_query($connect, $Sql);
    $Row = mysqli_fetch_array($Result);
    if($Row) {
        $ContentsTitle = $Row['ContentsTitle'];
    }
    if(!$Name2) $Name2 = "관리자";
}
?>
<SCRIPT LANGUAGE="JavaScript">
function DelOk() {
	del_confirm = confirm("현재 글을 삭제하시겠습니까?");
	if(del_confirm==true) {
		DeleteForm.submit();
	}
}
</SCRIPT>
	<div class="contentBody">
    	<h2>1:1 상담문의 / 학습상담</h2>
        <div class="conZone">
			<form name="DeleteForm" method="post" action="qna_script.php" enctype="multipart/form-data" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="del">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
			</form>
            <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
    	        <colgroup>
                    <col width="120px" />
                    <col width="" />
            	</colgroup>
              	<?if($ContentsName){?>
                <tr>
                	<th>과정명</th>
                    <td><?=$ContentsName?></td>
              	</tr>
    			<tr>
                   <th>차시명</th>
                   <td><?=$ContentsTitle?></td>
                </tr>
                <?}?>
			  	<tr>
                    <th>문의 제목</th>
                    <td><?=$Title?></td>
	            </tr>
              	<tr>
                    <th>이름</th>
                    <td><?=$Name?></td>
              	</tr>
              	<tr>
                    <th>아이디</th>
                    <td><?=$ID?></td>
              	</tr>
			  	<tr>
                    <th>연락처</th>
                    <td><span id="InfoProt_Mobile"><a href="Javascript:InformationProtection('Counsel','Mobile','InfoProt_Mobile','<?=$idx?>','<?=$_SERVER['PHP_SELF']?>','휴대폰');"><?=$Mobile?></a></span></td>
              	</tr>
			  	<tr>
                    <th>이메일</th>
                    <td><span id="InfoProt_Email"><a href="Javascript:InformationProtection('Counsel','Email','InfoProt_Email','<?=$idx?>','<?=$_SERVER['PHP_SELF']?>','이메일');"><?=$Email?></a></span></td>
              	</tr>
			  	<tr>
                    <th>등록일</th>
                    <td><?=$RegDate?></td>
              	</tr>
			  	<tr>
                    <th>내용</th>
                    <td>
    				<table border="0" width="970px">
    					<tr>
    						<td style="line-height:1.6em; letter-spacing:-0.02em; border:0px"><?=$Contents?></td>
    					</tr>
    				</table>
    				</td>
              	</tr>
				<?if($FileName4Student) { ?>
				<tr>
					<th>첨부된 파일</th>
					<td><A HREF="/include/download.php?idx=<?=$idx?>&code=Counsel&file=counselStudent"><?=$RealFileName4Student?></A></td>
				</tr>
				<? } ?>
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
			<form name="Form1" method="post" action="qna_script.php" enctype="multipart/form-data" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="reply">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				<INPUT TYPE="hidden" name="UserID" value="<?=$ID?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01 gapT20">
                	<colgroup>
                        <col width="120px" />
                        <col width="" />
                  	</colgroup>
                  	<tr>
                        <th>처리 상태</th>
                        <td>
    					<select name="Status" id="Status" style="width:120px">
    						<?while (list($key,$value)=each($CounselStatus_array)) {?>
    						<option value="<?=$key?>" <?if($Status==$key) {?>selected<?}?>><?=$value?></option>
    						<?}?>
    					</select>
    					</td>
                  	</tr>
                  	<tr>
                        <th>작성자</th>
                        <td><input name="Name2" type="text"  size="30" value="<?=$Name2?>"></td> 
                  	</tr>
					<tr>
    					<th>첨부파일 1</th>
    					<td>
    						<input name="file1" id="file1" type="hidden" value="<?=$file1?>">							
    							<span id="file1Area"><?=$file1View?></span>&nbsp;
    						<input type="button" value="파일 첨부" onclick="UploadFile('file1','file1Area','Counsel1');" class="btn_inputLine01" >
    					</td>
					</tr>
    				<tr>
    					<th>첨부파일 2</th>
    					<td>
    						<input name="file2" id="file2" type="hidden" value="<?=$file2?>">
    							<span id="file2Area"><?=$file2View?></span>&nbsp;
    						<input type="button" value="파일 첨부" onclick="UploadFile('file2','file2Area','Counsel2');" class="btn_inputLine01" >
    					</td>
    				</tr>				
    				<tr>
    					<th>첨부파일 3</th>
    					<td>
    						<input name="file3" id="file3" type="hidden" value="<?=$file3?>">
    							<span id="file3Area"><?=$file3View?></span>&nbsp;
    						<input type="button" value="파일 첨부" onclick="UploadFile('file3','file3Area','Counsel3');" class="btn_inputLine01" >
    					</td>
    				</tr>
    				<tr>
    					<th>첨부파일 4</th>
    					<td>
    						<input name="file4" id="file4" type="hidden" value="<?=$file4?>">
    							<span id="file4Area"><?=$file4View?></span>&nbsp;
    						<input type="button" value="파일 첨부" onclick="UploadFile('file4','file4Area','Counsel4');" class="btn_inputLine01" >
    					</td>
    				</tr>
    				<tr>
    					<th>첨부파일 5</th>
    					<td>
    						<input name="file5" id="file5" type="hidden" value="<?=$file5?>">
    							<span id="file5Area"><?=$file5View?></span>&nbsp;
    						<input type="button" value="파일 첨부" onclick="UploadFile('file5','file5Area','Counsel5');" class="btn_inputLine01" >
    					</td>
    				</tr>
    				<tr>
    					<th>답변 내용</th>
    					<td height="28"><textarea name="Contents2" id="Contents2" rows="10" cols="100" style="width:970px; height:420px; display:none;"><?=$Contents2?></textarea></td>
    				</tr>
                </table>
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
			 </form>
        </div>
    </div>
</div>
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
		alert("답변 내용을 15자 이상 입력해주세요");
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