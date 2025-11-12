<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$SearchGubun  = Replace_Check($SearchGubun); //기간, 사업주 검색 구분
$CompanyName  = Replace_Check($CompanyName); //사업주명
$SearchYear   = Replace_Check($SearchYear); //검색 년도
$SearchMonth  = Replace_Check($SearchMonth); //검색 월
$SearchYear2  = Replace_Check($SearchYear2); //사업주검색 년도
$SearchMonth2 = Replace_Check($SearchMonth2); //사업주검색 월
$StudyPeriod  = Replace_Check($StudyPeriod); //검색 기간1(기간검색)
$StudyPeriod2 = Replace_Check($StudyPeriod2); //검색 기간2(사업주검색)
$CompanyCode  = Replace_Check($CompanyCode); //사업자 번호
$OpenChapter  = Replace_Check($OpenChapter); //실시회차
$LectureStart = Replace_Check($LectureStart); //교육 시작일
$LectureEnd   = Replace_Check($LectureEnd); //교육 종료일
$pg           = Replace_Check($pg); //페이지

##-- 페이지 조건
if(!$pg) $pg = 1;
$page_size = 30;
$block_size = 10;

##-- 검색 조건
$where = array();

//기간검색
if($SearchGubun=="A") {
    if($SearchYear)    $where[] = "YEAR(d.LectureStart)=".$SearchYear;
    if($SearchMonth)   $where[] = "MONTH(d.LectureStart)=".$SearchMonth;
    if($CompanyCode)   $where[] = "e.CompanyCode='".$CompanyCode."'";
    if($LectureStart)  $where[] = "d.LectureStart='".$LectureStart."'";
    if($LectureEnd)    $where[] = "d.LectureEnd='".$LectureEnd."'";
}

//사업주  검색 
if($SearchGubun=="B") {
    if($SearchYear2)    $where[] = "YEAR(d.LectureStart)=".$SearchYear2;
    if($SearchMonth2)   $where[] = "MONTH(d.LectureStart)=".$SearchMonth2;
    if($CompanyName)    $where[] = "e.CompanyName LIKE '%".$CompanyName."%'";
    if($LectureStart)  $where[] = "d.LectureStart='".$LectureStart."'";
    if($LectureEnd)    $where[] = "d.LectureEnd='".$LectureEnd."'";
}

if($OpenChapter)    $where[] = "d.OpenChapter='".$OpenChapter."'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

$str_orderby = "ORDER BY a.idx DESC";

$Colume = " a.ID , a.LectureCode , a.Progress , a.StudyTime
            ,b.Name , b.CompanyCode 
            ,c.ServiceType , c.ContentsTime , c.ContentsName , c.Keyword2
            , (SELECT CategoryName FROM CourseCategory WHERE idx = c.Category1) AS Category1
            , (SELECT CategoryName FROM CourseCategory WHERE idx = c.Category2) AS Category2
            , (SELECT Keyword FROM ContentsKeyword WHERE Category =2 AND idx=c.Keyword2) AS Keyword2Name
            ,d.LectureStart , d.LectureEnd , d.OpenChapter
            ,e.CompanyName , e.CompanyCode ";

$JoinQuery = " Progress a
            LEFT JOIN `Member` b ON a.ID = b.ID
            LEFT JOIN Course c ON a.LectureCode = c.LectureCode
            LEFT JOIN Study d ON a.ID = d.ID
            LEFT JOIN Company e ON b.CompanyCode = e.CompanyCode ";

$Sql2 = "SELECT COUNT(a.idx) FROM $JoinQuery $where";
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);
$TOT_NO = $Row2[0];
//echo $TOT_NO;

##-- 페이지 클래스 생성
$PageFun = "CourseDataSearch"; //페이지 호출을 위한 자바스크립트 함수

include_once("./include/include_page2.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size,$PageFun); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소
?>
<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
	<tr>
		<th>번호</th>
		<th>훈련생명</th>
		<th>훈련생 아이디</th>
		<th>분야</th>
		<th>세부분야</th>
		<th>NCS분류</th>
		<th>과정구분</th>
		<th>훈련과정ID</th>
		<th>과정명</th>
		<th>총 훈련시간(분)</th>
		<th>이수시간(분)</th>
		<th>이수율</th>
	</tr>
	<?
	$SQL = "SELECT $Colume FROM $JoinQuery $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
	//echo $SQL;
	$QUERY = mysqli_query($connect, $SQL);
	if($QUERY && mysqli_num_rows($QUERY)){
		while($ROW = mysqli_fetch_array($QUERY)){
			extract($ROW);
			
			//최종수강시간
			if($StudyTime)   $TotalStudyTime = gmdate("i", $StudyTime);
			else             $TotalStudyTime = "0";
			
			//20250630.YEON.윤희상부장 요청으로 이수율 수정
			//이수율
			$CourseProgress = floor($TotalStudyTime/$ContentsTime * 100);
	?>
	<tr>
		<td align="center" bgcolor="#FFFFFF" class="text01"><?=$PAGE_UNCOUNT--?></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><a href="Javascript:MemberInfo('<?=$ID?>');"><?=$Name?></a></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><a href="Javascript:MemberInfo('<?=$ID?>');"><?=$ID?></a></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><?=$Category1?></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><?=$Keyword2Name?></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><?=$CourseData_array[$Keyword2]?></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><?=$ServiceType_array[$ServiceType]?></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><?=$ContentsName?></td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><?=$ContentsTime?>분</td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><?=$TotalStudyTime?>분</td>
		<td align="center" bgcolor="#FFFFFF" class="text01"><?=$CourseProgress?>%</td>
	</tr>
	<?
		}
	}else{
	?>
	<tr>
		<td height="28" align="center" bgcolor="#FFFFFF" class="text01" colspan="12">검색된 내용이 없습니다.</td>
	</tr>
	<? } ?>
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