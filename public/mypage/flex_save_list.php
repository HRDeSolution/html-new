<?
include "../../include/include_function.php"; //DB연결 및 각종 함수 정의

$pageStart = Replace_Check_XSS2($pageStart);

$where[] = "b.ID = '$LoginMemberID'";
$where[] = "a.Del='N'";
$where[] = "a.UseYN='Y'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

$SQL = "SELECT b.idx , b.LectureCode  , a.ContentsName , a.Keyword1 , a.PreviewImage
		FROM CourseFlex a
		LEFT JOIN CourseFlexLike b on a.LectureCode = b.LectureCode
		$where  ORDER BY a.RegDate DESC, a.idx DESC Limit $pageStart, 4";
//echo $SQL;
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY)){
    while($ROW = mysqli_fetch_array($QUERY)){
        extract($ROW);
        $PreviewImageView = "/upload/Course/".$PreviewImage;
        
        $Keyword1 = str_replace(' ', '', $Keyword1);
        $Keyword1_array = explode('#',$Keyword1);
        $Keyword1_arrayA = array_slice($Keyword1_array, 1, 2);
?>
<li>
    <input type="checkbox" name="chk" value="<?=$idx?>">
    <div class="left">
		<?if($Chapter == "0"){?>
        <div class="lecture_img" onclick="Javascript:ContentsPlayer('<?=$LectureCode?>');"><img src="<?=$PreviewImageView?>" alt="과정이미지"></div>
        <?}else{?>
        <div class="lecture_img" onclick="Javascript:ContentsPlayer2('<?=$LectureCode?>', '1');"><img src="<?=$PreviewImageView?>" alt="과정이미지"></div>
        <?}?>
    </div>
    <div class="right">
        <div class="top">
            <strong class="lecture_ttl"><?=$ContentsName?></strong>
            <div class="tag_box">
            	<? while (list($key,$value)=each($Keyword1_arrayA)){?>
				<span>#<?=$value?></span>
				<?}?>
            </div>
        </div>
    </div>
</li>
<?
	}
}

mysqli_close($connect);
?>