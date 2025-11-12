<?
$MenuType = "G";
$PageName = "course_flex";
$ReadPage = "course_flex_read";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);

$Sql = "SELECT a.*, b.CategoryName AS CategoryName1, c.CategoryName AS CategoryName2
        FROM CourseFlex AS a
    	LEFT OUTER JOIN CourseFlexCategory AS b ON a.Category1=b.idx
    	LEFT OUTER JOIN CourseFlexCategory AS c ON a.Category2=c.idx 
        WHERE a.idx=$idx AND a.Del='N'";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
    $ClassGrade = $Row['ClassGrade']; //등급
    $LectureCode = $Row['LectureCode']; //과정코드
    $UseYN = $Row['UseYN']; //사이트 노출
    $PassCode = $Row['PassCode']; //심사코드
    $HrdCode = $Row['HrdCode']; //HRD-NET 과정코드
    $CategoryName1 = $Row['CategoryName1']; //과정분류 대분류
    $CategoryName2 = $Row['CategoryName2']; //과정분류 소분류
    $ServiceType = $Row['ServiceType']; //서비스 구분
    $ContentsName = html_quote($Row['ContentsName']); //과정명
    $ContentsTime = $Row['ContentsTime']; //교육시간
    $ContentsPeriod = substr($Row['ContentsPeriod'],0,10); //컨텐츠 유효기간
    $ContentsAccredit = substr($Row['ContentsAccredit'],0,10); //인정만료일 시작일
    $ContentsExpire = substr($Row['ContentsExpire'],0,10); //인정만료일 종료일
    $Cp = html_quote($Row['Cp']); //cp사
    $Commission = $Row['Commission']; //cp 수수료
    $Mobile = $Row['Mobile']; //모바일 지원
    $BookPrice = $Row['BookPrice']; //교재비
    $BookIntro = html_quote($Row['BookIntro']); //참고도서설명
    $attachFile = html_quote($Row['attachFile']); //학습자료
    $PreviewImage = html_quote($Row['PreviewImage']); //과정 이미지
    $BookImage = html_quote($Row['BookImage']); //교재 이미지
    $Intro = nl2br($Row['Intro']); //과정소개
    $EduTarget = nl2br($Row['EduTarget']); //교육대상
    $EduGoal = nl2br($Row['EduGoal']); //교육목표
    $tok2 = $Row['tok2']; //tok2 연계여부
    $IE8Compat = $Row['IE8Compat']; //브라우저 호환성 여부
    $ContentsURLSelect = $Row['ContentsURLSelect']; //컨텐츠 URL 주경로, 예비경로 선택 여부 A:주, B:예비
    $Keyword1 = $Row['Keyword1']; //관심분야
    $Keyword2 = $Row['Keyword2']; //난이도
    $Keyword3 = $Row['Keyword3']; //근무분야
    $ContentsURL = $Row['ContentsURL']; //컨텐츠URL
    $MobileURL = $Row['MobileURL']; //모바일URL
    $Chapter = $Row['Chapter']; //차시수
}

if($attachFile) $attachFileView = "<A HREF='./direct_download.php?code=Course&file=".$attachFile."'><B>".$attachFile."</B></a>";
if($PreviewImage) $PreviewImageView = "<img src='/upload/Course/".$PreviewImage."' width='100' align='absmiddle'>";
if($BookImage) $BookImageView = "<img src='/upload/Course/".$BookImage."' height='100' align='absmiddle'>";


$Sql = "SELECT COUNT(*) FROM Member WHERE TestLectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TestIDCount = $Row[0];
?>
<SCRIPT LANGUAGE="JavaScript">
function DelOk() {
	del_confirm = confirm("현재 컨텐츠를 삭제하시겠습니까?");
	if(del_confirm==true) {
		DeleteForm.submit();
	}
}
</SCRIPT>
	<div class="contentBody">
    	<h2>컨텐츠 관리</h2>
        <div class="conZone">
			<input type="hidden" name="LectureCodeValue" id="LectureCodeValue" value="<?=$LectureCode?>">
			<input type="hidden" name="ChapterValue" id="ChapterValue" value="<?=$Chapter?>">
			<form name="DeleteForm" method="post" action="course_flex_script.php" target="ScriptFrame">
				<INPUT TYPE="hidden" name="mode" value="del">
				<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				<INPUT TYPE="hidden" name="LectureCode" value="<?=$LectureCode?>">
			</form>
			<form name="TestIDForm" method="post" action="course_testid_creat.php" target="ScriptFrame">
				<INPUT TYPE="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
				<INPUT TYPE="hidden" name="CreatCount" id="CreatCount" value="5">
			</form>
			<?if($AdminWrite=="Y") {?>
			<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="margin-bottom:10px;">
				<tr>
					<td align="right"><a href="Javascript:TestIDView('<?=$LectureCode?>');">[등록된 심사용 테스트 아이디 <?=$TestIDCount?>건 보기]</a>&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="심사용 테스트 아이디 생성" onclick="TestIDCreat()" class="btn_inputLine01"></td>
				</tr>
			</table>
			<?}?>
            <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
            	<colgroup>
                    <col width="130px" />
                    <col width="" />
    				<col width="130px" />
                    <col width="" />
    				<col width="130px" />
                    <col width="" />
    				<col width="140px" />
                    <col width="" />
              	</colgroup>
				<tr>
					<th>등급 / 과정코드</th>
					<td align="left"> <?=$ClassGrade_array[$ClassGrade]?>&nbsp;&nbsp;/&nbsp;&nbsp;<span class="redB"><?=$LectureCode?></span></td>
					<th>사이트노출 / <br>컨텐츠 경로</th>
					<td align="left"> 
						<?=$UseYN_array[$UseYN]?>&nbsp;&nbsp;/&nbsp;&nbsp;
						<input type="radio" name="ContentsURLSelect" id="ContentsURLSelect1" value="A" <?if($ContentsURLSelect=="A") {?>checked<?}?> disabled> <label for="ContentsURLSelect1">주 경로</label>&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="ContentsURLSelect" id="ContentsURLSelect2" value="B" <?if($ContentsURLSelect=="B") {?>checked<?}?> disabled> <label for="ContentsURLSelect2">예비 경로</label></td>
					<th>심사코드</th>
					<td align="left"> <?=$PassCode?></td>
					<th>HRD-NET 과정코드</th>
					<td align="left"> <?=$HrdCode?></td>
				</tr>
				<tr>
					<th>과정 분류</th>
					<td align="left"><?=$CategoryName1?> > <?=$CategoryName2?></td>
					<th>과정명</th>
					<td align="left" colspan="3"><?=$ContentsName?></td>
					<th>교육시간</th>
					<td align="left"><?=$ContentsTime?> 분</td>
				</tr>
				<tr>
					<th>관심분야</th>
					<td align="left" colspan="3"> <?=$Keyword1?></td>
					<th>직무분야</th>
					<td align="left" colspan="3"> <?=$Keyword3?></td>
				</tr>
				<tr>
					<th>차시수</th>
					<td align="left"><?if($Chapter != "0") echo $Chapter."차시"; else  echo "없음";?></td>
					<th>컨텐츠URL</th>
					<td align="left"><?if($Chapter != "0") echo "-"; else  echo $ContentsURL;?></td>
					<th>모바일URL</th>
					<td align="left" colspan="3"><?if($Chapter != "0") echo "-"; else  echo $MobileURL;?></td>
				</tr>
				<tr>
					<th>난이도</th>
					<td align="left">
					<?
					$SQL = "SELECT * FROM ContentsFlexKeyword WHERE Category =2 AND idx=$Keyword2";
					$Result = mysqli_query($connect, $SQL);
					$Row = mysqli_fetch_array($Result);
					echo $Row['Keyword'];
					?>
					</td>
					<th>서비스 구분</th>
					<td align="left"> <?=$ServiceTypeCourse2_array[$ServiceType]?></td>
					<th>컨텐츠 유효기간</th>
					<td align="left"> <?=$ContentsPeriod?></td>
					<th>인정만료일</th>
					<td align="left"> <?=$ContentsAccredit?>  ~ <?=$ContentsExpire?></td>
				</tr>
				<tr>
					<th>CP사</th>
					<td align="left"> <?=$Cp?></td>
					<th>CP 수수료</th>
					<td align="left"> <?=$Commission?> %</td>
					<th>모바일 지원</th>
					<td align="left"> <?=$UseYN_array[$Mobile]?></td>
					<th>교재비</th>
					<td align="left"> <?=number_format($BookPrice,0)?> 원</td>
				</tr>
				<tr>
					<th>참고도서설명</th>
					<td align="left"> <?=$BookIntro?></td>
					<th>학습자료 등록</th>
					<td align="left"><?=$attachFileView?></td>
					<th>과정 이미지</th>
					<td align="left"><?=$PreviewImageView?></td>
					<th>교재 이미지</th>
					<td align="left"><?=$BookImageView?></td>
				</tr>
				<tr>
					<th>과정소개</th>
					<td align="left" colspan="7"><?=$Intro?></td>
				</tr>
				<tr>
					<th>교육대상</th>
					<td align="left" colspan="7"><?=$EduTarget?></td>
				</tr>
				<tr>
					<th>교육목표</th>
					<td align="left" colspan="7"><?=$EduGoal?></td>
				</tr>
            </table>
            <!-- 버튼 -->
			<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="gapT20">
				<tr>
					<?if($AdminWrite=="Y") {?>
					<td align="left" width="150" valign="top"><input type="button" value="컨텐츠 삭제" onclick="DelOk()" class="btn_inputLine01"></td>
					<td align="center" valign="top">
					<input type="button" value="컨텐츠 수정" onclick="location.href='<?=$PageName?>_write.php?mode=edit&idx=<?=$idx?>&col=<?=$col?>&sw=<?=urlencode($sw)?>'" class="btn_inputBlue01"></td>
					<?}?>
					<td width="150" align="right" valign="top"><input type="button" value="목록" onclick="location.href='<?=$PageName?>.php?pg=<?=$pg?>&sw=<?=urlencode($sw)?>&col=<?=$col?>'" class="btn_inputLine01"></td>
				</tr>
			</table>
			<br><br>
			<?if($Chapter != "0"){?>
			<div id="ChapterList"><br><br><br><center><img src="/images/loader.gif" alt="로딩중" /></center></div>
			<br><br><br><br><br><br>
			<?}?>			
        </div>
    </div>
</div>
<script type="text/javascript">
$(window).load(function() {
	FlexChapterListRoading();
});
</script>
<!-- Footer -->
<? include "./include/include_bottom.php"; ?>