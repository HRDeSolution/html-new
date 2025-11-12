<?
include "../../include/include_function.php"; //DB연결 및 각종 함수 정의

$RecomID = Replace_Check_XSS2($RecomID);

$Sql = "SELECT * FROM Member WHERE ID='$RecomID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
?>
<input type="hidden" name="RecomID_Check" id="RecomID_Check" value="Y">
<?
}else{
?>
<input type="hidden" name="RecomID_Check" id="RecomID_Check" value="N">
<?
}

mysqli_close($connect);
?>