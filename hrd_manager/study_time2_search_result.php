<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$StudyDate = Replace_Check($StudyDate); //수강날짜
$ID = Replace_Check($ID); //이름, 아이디
$pg = Replace_Check($pg); //페이지

##-- 페이지 조건
if(!$pg) $pg = 1;
$page_size = 30;
$block_size = 10;

if($ID){
    $where = " AND ID LIKE '%$ID%' ";
}


$Sql = "SELECT COUNT(DISTINCT ID) FROM ProgressLog WHERE RegDate LIKE '%$StudyDate%' $where ";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];
//echo $TOT_NO;

##-- 페이지 클래스 생성
$PageFun = "StudyTime2Search"; //페이지 호출을 위한 자바스크립트 함수

include_once("./include/include_page2.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size,$PageFun); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소
?>
<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
	<tr>
		<th>번호</th>
		<th>수강날짜</th>
		<th>회사명</th>
		<th>영업자ID<br>첨삭강사ID</th>
		<th>ID<br>이름</th>
		<th>수강시간</th>
	</tr>
	<?	
	//[1]해당날짜 수강한 수강생 구하기
	$Sql1 = "SELECT DISTINCT ID FROM ProgressLog WHERE RegDate LIKE '%$StudyDate%' $where ";
	//echo $Sql1;
	$Query1 = mysqli_query($connect, $Sql1);
	if($Query1 && mysqli_num_rows($Query1)){
	    while($Row1 = mysqli_fetch_array($Query1)){
	        $ID1 = $Row1['ID'];
	        
	        $StudyTimeSum = 0;
	        
	        //[2]해당날짜의 LectureCode와 Chapter_Seq 값 구하기
	        $Sql2 = "SELECT DISTINCT a.LectureCode, a.ID , a.Chapter_Seq , b.Name , c.Tutor , c.SalesID , d.CompanyName
                    FROM ProgressLog a
                    LEFT JOIN `Member` b ON a.ID = b.ID 
                    LEFT JOIN Study c ON a.ID = c.ID
                    LEFT JOIN Company d ON c.CompanyCode = d.CompanyCode 
                    WHERE a.ID = '$ID1' AND a.RegDate LIKE '%$StudyDate%'";
	        //echo $Sql2;
	        $Query2 = mysqli_query($connect, $Sql2);
	        if($Query2 && mysqli_num_rows($Query2)){
	            while($Row2 = mysqli_fetch_array($Query2)){
	                $LectureCode = $Row2['LectureCode'];
	                $Chapter_Seq = $Row2['Chapter_Seq'];
	                $ID2 = $Row2['ID'];
	                $Name = $Row2['Name'];
	                $CompanyName = $Row2['CompanyName'];
	                $Tutor = $Row2['Tutor'];
	                $SalesID = $Row2['SalesID'];
                    
	                //[3]각 차시의 수강시간구하기
	                $Sql3 = "SELECT MAX(StudyTime) - MIN(StudyTime) FROM ProgressLog
                             WHERE ID = '$ID2' AND RegDate LIKE '%$StudyDate%' AND LectureCode = '$LectureCode' AND Chapter_Seq  = $Chapter_Seq";
	                $Result3 = mysqli_query($connect, $Sql3);
	                $Row3 = mysqli_fetch_array($Result3);
	                $StudyTime = $Row3[0];
	                $StudyTimeSum = $StudyTimeSum + $StudyTime;
	                echo $Sql3."<br>";
	                echo $StudyTime."<br>";
	            }
	        }
	        
	        $StudyTimeSum = gmdate("H시간 i분 s초", $StudyTimeSum);
	?>
		<tr>
    		<td><?=$PAGE_UNCOUNT--?></td>
    		<td><?=$StudyDate?></td>
    		<td><?=$CompanyName?></td>
    		<td><?=$Tutor?><br><?=$SalesID?></td>
    		<td><?=$ID?><br><?=$Name?></td>
    		<td><?=$StudyTimeSum?></td>
    	</tr>
	<?
	    }
	}else{
    ?>
	<tr>
		<td height="28"  colspan="20">검색된 내용이 없습니다.</td>
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