<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$CompanyName = Replace_Check($CompanyName); //사업주명
$LectureStart = Replace_Check($LectureStart); //교육 시작일
$LectureEnd = Replace_Check($LectureEnd); //교육 종료일
$OpenChapter = Replace_Check($OpenChapter); //실시회차
$pg = Replace_Check($pg); //페이지
$PageCount    = Replace_Check($PageCount);

##-- 페이지 조건
if(!$pg) $pg = 1;
$page_size = 15;
$block_size = 10;

##-- 검색 조건
$where = array();

if($CompanyName)    $where[] = "b.CompanyName = '".$CompanyName."'";
if($LectureStart)   $where[] = "a.LectureStart='".$LectureStart."'";
if($LectureEnd)     $where[] = "a.LectureEnd='".$LectureEnd."'";
if($OpenChapter)     $where[] = "a.OpenChapter='".$OpenChapter."'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

$JoinQuery = " Study a
        LEFT JOIN Company b ON a.CompanyCode = b.CompanyCode 
        LEFT JOIN Course c ON a.LectureCode = c.LectureCode ";

$Sql2 = "SELECT COUNT(DISTINCT b.CompanyCode)
        FROM $JoinQuery $where ";
// echo $Sql2;
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);
$TOT_NO = $Row2[0];

##-- 페이지 클래스 생성
$PageFun = "StudyEndSearch"; //페이지 호출을 위한 자바스크립트 함수

include_once("./include/include_page2.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size,$PageFun); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소

?>
<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
    <tr>
        <th>번호</th>
        <th>수강기간</th>
        <th>사업주명</th>
        <th>과정명</th>
        <th>교육종료</th>
        <!-- <th>수강 마감</th>  -->
        <th>수납</th>
        <th>수료증 출력</th>
        <th>보고서</th
    </tr>
    <?
    $i = 1;
    $SQLA = "SELECT DISTINCT a.LectureStart , a.LectureEnd  , b.CompanyCode 
            FROM Study a
            LEFT JOIN Company b ON a.CompanyCode = b.CompanyCode 
            $where
            ORDER BY a.LectureStart , a.LectureEnd LIMIT $PAGE_CLASS->page_start, $page_size";
    //echo $SQLA."<br>";
    $QUERYA = mysqli_query($connect, $SQLA);
    if($QUERYA && mysqli_num_rows($QUERYA)){
        while($ROWA = mysqli_fetch_array($QUERYA)){
            $LectureStartA = $ROWA['LectureStart'];
            $LectureEndA   = $ROWA['LectureEnd'];
            $CompanyCodeA  = $ROWA['CompanyCode'];

            $SQL = "SELECT  a.LectureStart , a.LectureEnd , a.LectureCode , c.ContentsName , b.CompanyName , b.CompanyCode , COUNT(*) StudyCount, a.ID ,  a.StudyEnd ,
                   (SELECT CONCAT_WS('|',StudyEndInputID,StudyEndInputDate, LectureCode, ID) FROM StudyEnd WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND StudyEndInputDate IS NOT NULL AND LectureCode IS NULL) AS StudyEndString ,
		           (SELECT CONCAT_WS('|',StudyEndInputID,StudyEndInputDate, LectureCode, ID) FROM StudyEnd WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND LectureCode=a.LectureCode AND ID = a.ID) AS NewStudyEndString
            FROM $JoinQuery
            WHERE b.CompanyCode = '$CompanyCodeA' AND a.LectureStart = '$LectureStartA' AND a.LectureEnd = '$LectureEndA' ";
            //echo $SQL."<br>";
            $QUERY = mysqli_query($connect, $SQL);
            if($QUERY && mysqli_num_rows($QUERY)){
                while($ROW = mysqli_fetch_array($QUERY)){
                    $LectureStart       = $ROW['LectureStart'];
                    $StudyEndString     = $ROW['StudyEndString'];
                    $LectureEnd         = $ROW['LectureEnd'];
                    $LectureCode        = $ROW['LectureCode'];
                    $ContentsName       = $ROW['ContentsName'];
                    $CompanyName        = $ROW['CompanyName'];
                    $CompanyCode        = $ROW['CompanyCode'];
                    $ID                 = $ROW['ID'];
                    $StudyEnd           = $ROW['StudyEnd'];
                    $StudyCount         = $ROW['StudyCount'];
                    $StudyEndString     = $ROW['StudyEndString'];
                    $NewStudyEndString  = $ROW['NewStudyEndString'];
                    
                    if($StudyEndString){
                        $StudyEndString_array = explode('|',$StudyEndString);
                        $StudyEndInputID = $StudyEndString_array[0];
                        $StudyEndInputDate = $StudyEndString_array[1];
                    }else if($NewStudyEndString){
                        $NewStudyEndString_array = explode('|',$NewStudyEndString);
                        $NewStudyEndInputID = $NewStudyEndString_array[0];
                        $NewStudyEndInputDate = $NewStudyEndString_array[1];
                    }
                    
                    if($StudyEnd=='Y')		$CertificatePrintOK = 'Y';
                    else					$CertificatePrintOK = 'N';
                    
                    $LectureIsValid = false;
                    
                    $SQL3 = "SELECT * FROM Course WHERE LectureCode = '$LectureCode'";
                    $QUERY3 = mysqli_query($connect, $SQL3);
                    $Row3 = mysqli_fetch_array($QUERY3);
                    if($Row3) {
                        $LectureIsValid = true;
                    }
                    
    ?>
    <tr>
        <td><?=$PAGE_UNCOUNT--?></td>
        <td><?=$LectureStart?> ~ <?=$LectureEnd?></td>
        <td><?=$CompanyName?></td>
        <td><?=$ContentsName?></td>
		<td>
		<?if($StudyCount>0) {
    	    if($StudyEndString) {
    	        echo "처리자 : ".$StudyEndInputID."<br>";
    	        echo "처리일 : ".$StudyEndInputDate;
    	    }else if($NewStudyEndString){
    	        echo "처리자 : ".$NewStudyEndInputID."<br>";
    	        echo "처리일 : ".$NewStudyEndInputDate;
    	    }else{        
        ?>
			<button type="button" name="studyFinishBtn" id="studyFinishBtn" class="btn round btn_LGray line" onclick="StudyFinish('<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyCode?>','<?=$CompanyName?>')">교육종료</button>
		<?
              }
    	}else{
    	    echo "-";
    	}
    	?>
		</td>
		<!-- 
        <td>
    	<?if($StudyCount>0) {
    	    if($StudyEndString) {
    	        echo "처리자 : ".$StudyEndInputID."<br>";
    	        echo "처리일 : ".$StudyEndInputDate;
    	    }else if($NewStudyEndString){
    	        echo "처리자 : ".$NewStudyEndInputID."<br>";
    	        echo "처리일 : ".$NewStudyEndInputDate;
    	    }else{        
        ?>
            <button type="button" name="StudyEndBtn" id="StudyEndBtn" class="btn round btn_LGray line" onclick="StudyEndComplete('<?=$CompanyCode?>','<?=$LectureCode?>','<?=$LectureStart?>','<?=$LectureEnd?>')">마감</button>
        <?
              }
    	}else{
    	    echo "-";
    	}
    	?>
        </td>
         -->
        <td>
        <? if($LectureIsValid) {?>
            <button type="button" name="CertBtn09" id="CertBtn09" class="btn round btn_LGray line" style="margin-bottom:5px;" onclick="location.href='receipt_confirm_excel.php?CompanyCode=<?=$CompanyCode?>&LectureStart=<?=$LectureStart?>&LectureEnd=<?=$LectureEnd?>&LectureCode=<?=$LectureCode?>'">수납 확인서</button><br>
        <?}?>
        </td>
        <td>
        	<button type="button" name="CertBtn04" id="CertBtn04" class="btn round btn_LGray line" onclick="StudyEndCertificatePrintPDF('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>','<?=$LectureCode?>', 'N', '<?=$CertificatePrintOK?>')">수료증</button>
        </td>
        <td>
        <? if($LectureIsValid) {?>
        	<button type="button" name="CertBtn08" id="CertBtn08" class="btn round btn_LGray line" style="margin-bottom:5px;" onclick="archiveReport02('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>')">훈련진행보고서</button><br>
        	<button type="button" name="CertBtn08" id="CertBtn08" class="btn round btn_LGray line" style="margin-bottom:5px;" onclick="StudyEndDocument02Mail('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>')">훈련진행보고서 메일발송</button><br>
        	<button type="button" name="CertBtn08" id="CertBtn08" class="btn round btn_LGray line" style="margin-bottom:5px;" onclick="archiveReport('<?=$CompanyCode?>','<?=$LectureStart?>','<?=$LectureEnd?>')">교육결과보고서</button>
        <?}?>
        </td>
    </tr>
    <?
                    $i++;
                }
            }
        }
    }else{
    ?>
    <tr>
        <td height="28" colspan="20">검색된 내용이 없습니다.</td>
    </tr>
    <?  
    }
    ?>
</table>

<!--페이지 버튼-->
<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="margin-top:15px;">
  <tr>
    <td align="center" valign="top"><?=$BLOCK_LIST?></td>
  </tr>
</table>
<?
mysqli_close($connect);
?>