<?
include "../../include/include_function.php"; //DB연결 및 각종 함수 정의

$ID = $_SESSION['LoginMemberID'];

$sw  = Replace_Check_XSS2($sw);
$CategoryData  = Replace_Check_XSS2($CategoryData);
$OrderData  = Replace_Check_XSS2($OrderData);

$pageStart = Replace_Check_XSS2($pageStart);
$Keyword1  = Replace_Check_XSS2($Keyword1);
$Keyword2  = Replace_Check_XSS2($Keyword2);
$KeywordB  = Replace_Check_XSS2($KeywordB);
$KeywordE  = Replace_Check_XSS2($KeywordE);
$idxData   = Replace_Check_XSS2($idxData);
$clickNum  = Replace_Check_XSS2($clickNum);

//get study column lecturecode, seq 
$SqlM    = "SELECT LectureCode AS StudyLectureCode, Seq AS Study_Seq FROM Study WHERE ID = '$ID'";
$ResultM = mysqli_query($connect, $SqlM);
$RowM    = mysqli_fetch_assoc($ResultM);
$JoinQuery = "";
//검색조건
if($sw){
    $where = " AND a.ContentsName LIKE '%$sw%' OR a.Keyword3 like '%$sw%'";
    $where2 = "";
}else{
    $where = "";
    $where2 = " OR C.Keyword1 = '$Keyword1' AND C.Keyword2 = '$Keyword2' AND C.Keyword3 REGEXP('$KeywordB') AND C.Keyword4 REGEXP('$KeywordE') ";
}
if($CategoryData){
    $whereC = " AND a.Category1=$CategoryData";
    $where2 = "";
}
if($OrderData){
    if($OrderData == 1)			$OrderbyQuery = " ORDER BY C.RegDate DESC ";
    else if($OrderData == 2)	$OrderbyQuery = " ORDER BY C.cnt DESC ";
    else if($OrderData == 3)	$OrderbyQuery = " ORDER BY C.StarPoint DESC ";
    else if($OrderData == 4) {
        $JoinQuery = "LEFT JOIN CourseLike as cl ON cl.LectureCode = C.LectureCode";
        $where2 = "AND cl.ID='$LoginMemberID'";
        $OrderbyQuery = " ORDER BY cl.idx DESC ";
    }
    else						$OrderbyQuery = " ORDER BY RAND() ";
}else{
    $OrderbyQuery = " ORDER BY RAND() ";
}

//컨텐츠좋아요 list
$Like_list = array();
$SqlLike = "SELECT * from CourseLike WHERE ID = '$ID'";
$QueqryLike = mysqli_query($connect, $SqlLike);
if($QueqryLike && mysqli_num_rows($QueqryLike)){
    while($RowLike = mysqli_fetch_array($QueqryLike)){
        $LikeCode = $RowLike['LectureCode'];
        $Like_list[$LikeCode] = $LikeCode;
    }
}

$SqlC = "SELECT C.*
        FROM(
                SELECT a.*  , (SELECT AVG(StarPoint)  FROM Review WHERE LectureCode = a.LectureCode) AS StarPoint
                FROM Course a
                WHERE a.Del='N'  AND a.UseYN = 'Y' AND a.UseYN='Y' AND a.idx NOT IN($idxData) $where $whereC
        ) C $JoinQuery
        WHERE 1=1  AND PackageYN ='N' $where2
        $OrderbyQuery LIMIT $pageStart";
// echo "C2"."<br>".$SqlC;
$QueryC = mysqli_query($connect, $SqlC);
$TotalRowC = mysqli_num_rows($QueryC);
if($QueryC && mysqli_num_rows($QueryC)){
    while($RowC = mysqli_fetch_array($QueryC)){
        $idx = $RowC['idx'];
        $PreviewImage = $RowC['PreviewImage'];
        $LectureCode = $RowC['LectureCode'];
        $Keyword3 = $RowC['Keyword3'];
        $ContentsName = $RowC['ContentsName'];
        $ContentsTime = $RowC['ContentsTime'];
        $ContentsStart= $RowC['ContentsStart'];
        $UploadDate   = $RowC['UploadDate'];
        $Chapter      = $RowC['Chapter'];
        $CourseCnt    = $RowC['cnt'];
        
        $PreviewImageView = "/upload/Course/".$PreviewImage;
        
        $Keyword3 = str_replace(' ', '', $Keyword3);
        $Keyword3_array = explode('#',$Keyword3);
        $Keyword3_arrayA = array_slice($Keyword3_array, 1, 2);
        
        $ContentsStart = substr($ContentsStart,0,10);
        $UploadDate = substr($UploadDate,0,10);
        
        if($idxData == ""){
            $idxData = $idx;
        }else{
            $idxData = $idxData.",".$idx;
        }
        
        $SqlCNT = "SELECT COUNT(LectureCode) AS CNT  FROM CourseLike WHERE LectureCode ='$LectureCode'";
        $ResultCNT = mysqli_query($connect, $SqlCNT);
        $RowCNT = mysqli_fetch_array($ResultCNT);
        $CNT = $RowCNT[0];
?>
        <?if($Chapter == "0"){?>
		<ul class="edu_contents" onclick="Javascript:ContentsPlayer('<?=$LectureCode?>');">
		<?}else{?>
		<ul class="edu_contents" onclick="Javascript:ContentsPlayer2('<?=$LectureCode?>','1', '<?=$RowM['Study_Seq']?>', '<?=$RowM['StudyLectureCode']?>');">
		<?}?>
        	<input type="hidden" id="idxData" name="idxData" value="<?=$idxData?>">
        	<li class="img" style="background-image: url(<?=$PreviewImageView?>);"></li>
            <li class="title">
        		<span class="tag">
                <?
                $keyword3Arr = explode(',', $Keyword3);
                $SQLKey3     = " SELECT aValue, idx AS keywordIdx FROM ArchiveQuestion WHERE aType = 'B' AND aDepth = 'step01' AND aGroup = 'A' AND aBind = 'col3' ORDER BY aOrder ASC ";
                $QUERYKey3   = mysqli_query($connect, $SQLKey3);
                if( $QUERYKey3 && mysqli_num_rows($QUERYKey3) ) {
                    while( $ROWKey3 = mysqli_fetch_array($QUERYKey3) ) {
                        extract($ROWKey3);
                        if ( in_array($keywordIdx, $keyword3Arr) ) echo "<b>#</b>".$aValue." ";
                    }
                }
                ?>
                </span>
                <strong><?=$ContentsName?></strong>
                <span class="lecture_save" >
                	<?if($Like_list[$LectureCode] == $LectureCode){?>
					<i class="ph-fill ph-heart" style="color:red;" onclick="CourseLike(this,'<?=$LectureCode?>', '<?=$LoginMemberID?>')" name="courseLike" id="like_<?=$idx?>"></i><?=$CNT?>
					<?}else{?>
					<i class="ph-light ph-heart" onclick="CourseLike(this,'<?=$LectureCode?>', '<?=$LoginMemberID?>')" name="courseLike" id="like_<?=$idx?>"></i><?=$CNT?>
					<?}?>
				</span>
                <span class="lecture_time"><i class="ph-light ph-clock"></i><?=$ContentsTime?>분</span>
                <span class="lecture_time">조회수 : <?=$CourseCnt?></span>
                <span class="lecture_time">제작연도 : <?=$ContentsStart?></span>
                <span class="lecture_time">업로드일 : <?=$UploadDate?></span>
            </li>
        </ul>
<?
        }
}

if(!$sw && !$CategoryData && $TotalRowC > 12){
    $LimitRows = $TotalRowC - 12;
    
    //검색조건
    if($sw){
        $where3 = " AND a.ContentsName LIKE '%$sw%' OR a.Keyword3 like '%$sw%'";
        $where4 = "";
    }else{
        $where3 = "";
        $where4 = " OR a.Keyword1 = '$Keyword1' AND a.Keyword2 = '$Keyword2' AND a.Keyword3 REGEXP('$KeywordB') AND a.Keyword4 REGEXP('$KeywordE') ";
    }
    if($CategoryData){
        $whereC = " AND a.Category1=$CategoryData";
        $where4 = "";
    }    
    if($OrderData){
        if($OrderData == 1)			$OrderbyQuery = " ORDER BY a.RegDate DESC ";
        else if($OrderData == 2)	$OrderbyQuery = " ORDER BY a.cnt DESC ";
        else if($OrderData == 3)	$OrderbyQuery = " ORDER BY (SELECT AVG(StarPoint)  FROM Review WHERE LectureCode = a.LectureCode) DESC ";
        else						$OrderbyQuery = " ORDER BY RAND() ";
    }else{
        $OrderbyQuery = " ORDER BY RAND() ";
    }
    
    $SqlD = "SELECT a.*
            FROM Course a
            WHERE a.Del='N'  AND a.UseYN = 'Y' AND a.UseYN='Y' AND a.PackageYN ='N' AND a.idx NOT IN($idxData) $where3 $where4 $whereC
            $OrderbyQuery LIMIT $LimitRows";
    //echo "D2"."<br>".$SqlD;
    $QueryD = mysqli_query($connect, $SqlD);
    $TotalRowD = mysqli_num_rows($QueryD);
    if($QueryD && mysqli_num_rows($QueryD)){
        while($RowD = mysqli_fetch_array($QueryD)){
            $idx = $RowD['idx'];
            $PreviewImage = $RowD['PreviewImage'];
            $LectureCode = $RowD['LectureCode'];
            $Keyword3 = $RowD['Keyword3'];
            $ContentsName = $RowD['ContentsName'];
            $ContentsTime = $RowD['ContentsTime'];
            $ContentsStart= $RowD['ContentsStart'];
            $UploadDate   = $RowD['UploadDate'];
            $Chapter      = $RowD['Chapter'];
            $CourseCnt    = $RowD['cnt'];
            
            $PreviewImageView = "/upload/Course/".$PreviewImage;
            
            $Keyword3 = str_replace(' ', '', $Keyword3);
            $Keyword3_array = explode('#',$Keyword3);
            $Keyword3_arrayA = array_slice($$Keyword3_array, 1, 2);
            
            $ContentsStart = substr($ContentsStart,0,10);
            $UploadDate = substr($UploadDate,0,10);
            
            if($idxData == ""){
                $idxData = $idx;
            }else{
                $idxData = $idxData.",".$idx;
            }
            $SqlCNT = "SELECT COUNT(LectureCode) AS CNT  FROM CourseLike WHERE LectureCode ='$LectureCode'";
            $ResultCNT = mysqli_query($connect, $SqlCNT);
            $RowCNT = mysqli_fetch_array($ResultCNT);
            $CNT = $RowCNT[0];
?>
            <?if($Chapter == "0"){?>
			<ul class="edu_contents" onclick="Javascript:ContentsPlayer('<?=$LectureCode?>');">
			<?}else{?>
			<ul class="edu_contents" onclick="Javascript:ContentsPlayer2('<?=$LectureCode?>','1', '<?=$RowM['Study_Seq']?>', '<?=$RowM['StudyLectureCode']?>');">
			<?}?>
            	<li class="img" style="background-image: url(<?=$PreviewImageView?>);"></li>
                <li class="title">
                	<? while (list($key,$value)=each($Keyword3_arrayA)){?>
            		<span class="tag">#<?=$value?></span>
            		<?}?>
                    <strong><?=$ContentsName?></strong>
                    <span class="lecture_save" >
                    	<?if($Like_list[$LectureCode] == $LectureCode){?>
						<i class="ph-fill ph-heart" style="color:red;" onclick="CourseLike(this,'<?=$LectureCode?>', '<?=$LoginMemberID?>')" name="courseLike" id="like_<?=$idx?>"></i><?=$CNT?>
						<?}else{?>
						<i class="ph-light ph-heart" onclick="CourseLike(this,'<?=$LectureCode?>', '<?=$LoginMemberID?>')" name="courseLike" id="like_<?=$idx?>"></i><?=$CNT?>
						<?}?>
					</span>
                    <span class="lecture_time"><i class="ph-light ph-clock"></i><?=$ContentsTime?>분</span>
                    <span class="lecture_time">조회수 : <?=$CourseCnt?></span>
                    <span class="lecture_time">제작연도 : <?=$ContentsStart?></span>
                    <span class="lecture_time">업로드일 : <?=$UploadDate?></span>
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