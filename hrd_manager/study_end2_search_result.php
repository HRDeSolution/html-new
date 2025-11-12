<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$CompanyName = Replace_Check($CompanyName); //사업주명
$LectureStart = Replace_Check($LectureStart); //교육 시작일
$LectureEnd = Replace_Check($LectureEnd); //교육 종료일
$OpenChapter = Replace_Check($OpenChapter); //실시회차
$LectureCode = Replace_Check($LectureCode); //과정코드
$pg = Replace_Check($pg); //페이지

##-- 페이지 조건
if(!$pg) $pg = 1;
$page_size = 10;
$block_size = 10;

##-- 검색 조건
$where = array();

if($CompanyName)    $where[] = "c.CompanyName = '".$CompanyName."'";
if($LectureStart)   $where[] = "b.LectureStart='".$LectureStart."'";
if($LectureEnd)     $where[] = "b.LectureEnd='".$LectureEnd."'";
if($OpenChapter)    $where[] = "b.OpenChapter='".$OpenChapter."'";
if($LectureCode)    $where[] = "a.LectureCode='".$LectureCode."'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

$Colume = " DISTINCT b.LectureStart , b.LectureEnd , c.CompanyCode ";

$JoinQuery = " Progress a
            LEFT JOIN Study b ON a.ID = b.ID AND a.Study_Seq = b.Seq AND b.ServiceType = 'W'
            LEFT JOIN Company c ON b.CompanyCode = c.CompanyCode 
            LEFT JOIN Course d ON a.LectureCode = d.LectureCode  ";

$Sql2 = "SELECT COUNT($Colume) FROM $JoinQuery $where ";
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);
$TOT_NO = $Row2[0];

##-- 페이지 클래스 생성
$PageFun = "StudyEnd2Search"; //페이지 호출을 위한 자바스크립트 함수

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
        <th>과정구분</th>
        <th>과정명</th>
        <th>수료증 출력</th>
    </tr>
    <?
    //echo $Sql2."<br>";
    $preStart='';
    $preEnd='';
    
    $SQLA = "SELECT $Colume FROM  $JoinQuery $where
             ORDER BY b.LectureStart , b.LectureEnd LIMIT $PAGE_CLASS->page_start, $page_size";
    //echo $SQLA."<br>";
    $QUERYA = mysqli_query($connect, $SQLA);
    if($QUERYA && mysqli_num_rows($QUERYA)){
        while($ROWA = mysqli_fetch_array($QUERYA)){
            $LectureStartA = $ROWA['LectureStart'];
            $LectureEndA   = $ROWA['LectureEnd'];
            $CompanyCodeA  = $ROWA['CompanyCode'];
            
            if($LectureCode)    $LectureCodeStr = "AND a.LectureCode='".$LectureCode."'";
            else                $LectureCodeStr = "";

            $SQL = "SELECT DISTINCT b.LectureStart , b.LectureEnd , b.CompanyCode , c.CompanyName , a.LectureCode , d.ContentsName , d.ctype 
                    FROM $JoinQuery
                    WHERE b.CompanyCode = '$CompanyCodeA' AND b.LectureStart = '$LectureStartA' AND b.LectureEnd = '$LectureEndA'  $LectureCodeStr
                    ORDER by. d.ContentsName ";
            //echo $SQL."<br><br>";
            $QUERY = mysqli_query($connect, $SQL);
            if($QUERY && mysqli_num_rows($QUERY)){
                while($ROW = mysqli_fetch_array($QUERY)){
                    $LectureStartB       = $ROW['LectureStart'];
                    $LectureEndB         = $ROW['LectureEnd'];
                    $CompanyNameB        = $ROW['CompanyName'];
                    $CompanyCodeB        = $ROW['CompanyCode'];
                    $LectureCodeB        = $ROW['LectureCode'];
                    $ContentsNameB       = $ROW['ContentsName'];
                    $ctypeB              = $ROW['ctype'];
    ?>
    <tr>
    	<?
    	if($preStart != $LectureStartB || $preEnd != $LectureEndB){
    	    $rowCount = mysqli_num_rows($QUERY);
	    ?>
    	<td rowspan="<?=$rowCount?>"><?=$PAGE_UNCOUNT--?></td>
        <td rowspan="<?=$rowCount?>"><?=$LectureStartB?> ~ <?=$LectureEndB?></td>
    	<?}?>
        <td><?=$CompanyNameB?></td>
        <td><?=$ServiceType_array[$ctypeB]?></td>
        <td><?=$ContentsNameB?></td>
        <td>
        	<button type="button" name="CertBtn04" id="CertBtn04" class="btn round btn_LGray line" onclick="StudyEnd2CertificatePrintPDF('<?=$CompanyCodeB?>','<?=$LectureStartB?>','<?=$LectureEndB?>','<?=$LectureCodeB?>')">수료증</button>
        </td>
    </tr>
    <?
                    $preStart = $LectureStartB;
                    $preEnd = $LectureEndB;
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