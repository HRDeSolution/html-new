<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$SearchYear = Replace_Check($SearchYear); //검색 년도
$SearchMonth = Replace_Check($SearchMonth); //검색 월
$ctype = Replace_Check($ctype); //사업주, 근로자 구분
$CompanyCode = Replace_Check($CompanyCode); //기업코드
$SubmitFunction = Replace_Check($SubmitFunction); //submit할 함수명

?>
&nbsp;<select name="StudyPeriod2" id="StudyPeriod2" style="width:250px" <?if($SubmitFunction) {?>onchange="<?=$SubmitFunction?>"<?}?>>
	<option value="">-- 기간 선택 --</option>
<?
	$SQL = "SELECT DISTINCT(CONCAT(a.LectureStart,'~',a.LectureEnd)) AS StudyPeriod
        	FROM LectureTerme a
        	LEFT JOIN Study b ON a.LectureCode =b.LectureCode AND a.LectureStart = b.LectureStart AND a.LectureEnd = b.LectureEnd
        	WHERE YEAR(a.LectureStart)='$SearchYear' and MONTH(a.LectureStart)='$SearchMonth'
        	AND b.CompanyCode = '$CompanyCode'
        	order by a.LectureStart , a.LectureEnd";
	$QUERY = mysqli_query($connect, $SQL);
	if($QUERY && mysqli_num_rows($QUERY)){
		$i = 1;
		while($Row = mysqli_fetch_array($QUERY)){
	?>
	<option value="<?=$Row['StudyPeriod']?>"><?=$Row['StudyPeriod']?></option>
	<?
            $i++;
		}
	}
	?>
</select>
<?
mysqli_close($connect);
?>