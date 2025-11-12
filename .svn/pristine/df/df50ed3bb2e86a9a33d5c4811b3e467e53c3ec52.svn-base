<?
include "../../include/include_function.php"; //DB연결 및 각종 함수 정의

$ID = $_SESSION['LoginMemberID'];

$sw  = Replace_Check_XSS2($sw);
$CategoryData  = Replace_Check_XSS2($CategoryData);

$pageStart = Replace_Check_XSS2($pageStart);
$Category1 = Replace_Check_XSS2($Category1);
$Category2 = Replace_Check_XSS2($Category2);
$Keyword2  = Replace_Check_XSS2($Keyword2);
$KeywordB  = Replace_Check_XSS2($KeywordB);
$KeywordE  = Replace_Check_XSS2($KeywordE);
$idxData   = Replace_Check_XSS2($idxData);
$clickNum  = Replace_Check_XSS2($clickNum);

//검색조건
if($sw){
    $where = " AND ContentsName LIKE '%$sw%' OR Keyword1 like '%$sw%'";
    $where2 = "";
}else{
    $where = "";
    $where2 = "  AND A.Category1 IN ($Category1) AND A.Category2 IN ($Category2) OR A.Keyword1 REGEXP('$KeywordB') AND A.Keyword2 = '$Keyword2' AND A.Keyword3 like '$KeywordE'";
}
if($CategoryData){
    $whereC = " AND Category1=$CategoryData";
    $where2 = "";
}

//컨텐츠좋아요 list
$Like_list = array();
$SqlLike = "SELECT * from CourseFlexLike WHERE ID = '$ID'";
$QueqryLike = mysqli_query($connect, $SqlLike);
if($QueqryLike && mysqli_num_rows($QueqryLike)){
    while($RowLike = mysqli_fetch_array($QueqryLike)){
        $LikeCode = $RowLike['LectureCode'];
        $Like_list[$LikeCode] = $LikeCode;
    }
}

$SqlC = "SELECT A.*
        FROM(SELECT * FROM CourseFlex WHERE Del='N' AND UseYN='Y' AND idx NOT IN($idxData) $where $whereC ) A
        WHERE 1=1 $where2
        ORDER BY RAND() LIMIT $pageStart";
//echo $SqlC;
$QueryC = mysqli_query($connect, $SqlC);
$TotalRowC = mysqli_num_rows($QueryC);
if($QueryC && mysqli_num_rows($QueryC)){
    while($RowC = mysqli_fetch_array($QueryC)){
        $idx = $RowC['idx'];
        $PreviewImage = $RowC['PreviewImage'];
        $LectureCode = $RowC['LectureCode'];
        $Keyword1 = $RowC['Keyword1'];
        $ContentsName = $RowC['ContentsName'];
        $ContentsTime = $RowC['ContentsTime'];
        $Chapter      = $RowC['Chapter'];
        
        $PreviewImageView = "/upload/Course/".$PreviewImage;
        
        $Keyword1 = str_replace(' ', '', $Keyword1);
        $Keyword1_array = explode('#',$Keyword1);
        $Keyword1_arrayA = array_slice($Keyword1_array, 1, 2);
        
        if($idxData == ""){
            $idxData = $idx;
        }else{
            $idxData = $idxData.",".$idx;
        }
        
        $SqlCNT = "SELECT COUNT(LectureCode) AS CNT  FROM CourseFlexLike WHERE LectureCode ='$LectureCode'";
        $ResultCNT = mysqli_query($connect, $SqlCNT);
        $RowCNT = mysqli_fetch_array($ResultCNT);
        $CNT = $RowCNT[0];
?>
        <?if($Chapter == "0"){?>
		<ul class="edu_contents" onclick="Javascript:ContentsPlayer('<?=$LectureCode?>');">
		<?}else{?>
		<ul class="edu_contents" onclick="Javascript:ContentsPlayer2('<?=$LectureCode?>','1');">
		<?}?>
        	<input type="hidden" id="idxData" name="idxData" value="<?=$idxData?>">
        	<li class="img" style="background-image: url(<?=$PreviewImageView?>);"></li>
            <li class="title">
            	<? while (list($key,$value)=each($Keyword1_arrayA)){?>
        		<span class="tag">#<?=$value?></span>
        		<?}?>
                <strong><?=$ContentsName?></strong>
                <span class="lecture_save" >
                	<?if($Like_list[$LectureCode] == $LectureCode){?>
					<i class="ph-fill ph-heart" style="color:red;" onclick="CourseFlexLike(this,'<?=$LectureCode?>', '<?=$LoginMemberID?>')" name="courseLike" id="like_<?=$idx?>"></i><?=$CNT?>
					<?}else{?>
					<i class="ph-light ph-heart" onclick="CourseFlexLike(this,'<?=$LectureCode?>', '<?=$LoginMemberID?>')" name="courseLike" id="like_<?=$idx?>"></i><?=$CNT?>
					<?}?>
				</span>
                <span class="lecture_time"><i class="ph-light ph-clock"></i><?=$ContentsTime?>시간</span>
            </li>
        </ul>
<?
        }
}

if(!$sw && !$CategoryData && $TotalRowC < 12){
    $LimitRows = 12-$TotalRowC;
    
    //검색조건
    if($sw){
        $where3 = " AND ContentsName LIKE '%$sw%' OR Keyword1 like '%$sw%'";
        $where4 = "";
    }else{
        $where3 = "";
        $where4 = " OR Keyword1 REGEXP('$KeywordB') AND Keyword2 = '$Keyword2' AND Keyword3 like '$KeywordE'";
    }
    if($CategoryData){
        $whereC = " AND Category1=$CategoryData";
        $where4 = "";
    }
    
    $SqlD = "SELECT * FROM CourseFlex
            WHERE Del='N' AND UseYN='Y' AND idx NOT IN($idxData) $where3 $where4 $whereC
            ORDER BY RAND() LIMIT $LimitRows";
    //echo $SqlD;
    $QueryD = mysqli_query($connect, $SqlD);
    $TotalRowD = mysqli_num_rows($QueryD);
    if($QueryD && mysqli_num_rows($QueryD)){
        while($RowD = mysqli_fetch_array($QueryD)){
            $idx = $RowD['idx'];
            $PreviewImage = $RowD['PreviewImage'];
            $LectureCode = $RowD['LectureCode'];
            $Keyword1 = $RowD['Keyword1'];
            $ContentsName = $RowD['ContentsName'];
            $ContentsTime = $RowD['ContentsTime'];
            $Chapter      = $RowD['Chapter'];
            
            $PreviewImageView = "/upload/Course/".$PreviewImage;
            
            $Keyword1 = str_replace(' ', '', $Keyword1);
            $Keyword1_array = explode('#',$Keyword1);
            $Keyword1_arrayA = array_slice($Keyword1_array, 1, 2);
            
            if($idxData == ""){
                $idxData = $idx;
            }else{
                $idxData = $idxData.",".$idx;
            }
            $SqlCNT = "SELECT COUNT(LectureCode) AS CNT  FROM CourseFlexLike WHERE LectureCode ='$LectureCode'";
            $ResultCNT = mysqli_query($connect, $SqlCNT);
            $RowCNT = mysqli_fetch_array($ResultCNT);
            $CNT = $RowCNT[0];
?>
            <?if($Chapter == "0"){?>
			<ul class="edu_contents" onclick="Javascript:ContentsPlayer('<?=$LectureCode?>');">
			<?}else{?>
			<ul class="edu_contents" onclick="Javascript:ContentsPlayer2('<?=$LectureCode?>','1');">
			<?}?>
            	<li class="img" style="background-image: url(<?=$PreviewImageView?>);"></li>
                <li class="title">
                	<? while (list($key,$value)=each($Keyword1_arrayA)){?>
            		<span class="tag">#<?=$value?></span>
            		<?}?>
                    <strong><?=$ContentsName?></strong>
                    <span class="lecture_save" >
                    	<?if($Like_list[$LectureCode] == $LectureCode){?>
						<i class="ph-fill ph-heart" style="color:red;" onclick="CourseFlexLike(this,'<?=$LectureCode?>', '<?=$LoginMemberID?>')" name="courseLike" id="like_<?=$idx?>"></i><?=$CNT?>
						<?}else{?>
						<i class="ph-light ph-heart" onclick="CourseFlexLike(this,'<?=$LectureCode?>', '<?=$LoginMemberID?>')" name="courseLike" id="like_<?=$idx?>"></i><?=$CNT?>
						<?}?>
					</span>
                    <span class="lecture_time"><i class="ph-light ph-clock"></i><?=$ContentsTime?>시간</span>
                </li>
            </ul>
<?
		}
	}
}
?>
<input type="hidden" id="idxData<?=$clickNum?>" value="<?=$idxData?>">
<?
mysqli_close($connect);
?>