<?
##########################################################################
# 아아이브 - 진도 체크
##########################################################################
include "../m_include/include_function.php"; //DB연결 및 각종 함수 정의
include "../m_include/login_check.php";

$Chapter_Number = Replace_Check_XSS2($Chapter_Number);
$LectureCode = Replace_Check_XSS2($LectureCode);
$Chapter_Seq = Replace_Check_XSS2($Chapter_Seq);
$Contents_idx = Replace_Check_XSS2($Contents_idx);
$ContentsDetail_Seq = Replace_Check_XSS2($ContentsDetail_Seq);
$ProgressTime = Replace_Check_XSS2($ProgressTime);
$LastStudy = Replace_Check2($LastStudy);
$CompleteTime = Replace_Check_XSS2($CompleteTime);
$ProgressStep = Replace_Check_XSS2($ProgressStep);
$iframeCheckTime = Replace_Check_XSS2($iframeCheckTime);

//수강생 StudySeq 확인
$SqlA = "SELECT Seq FROM Study WHERE ID = '$LoginMemberID' ORDER BY Seq DESC LIMIT 1";
$ResultA = mysqli_query($connect, $SqlA);
$RowA = mysqli_fetch_array($ResultA);
if($RowA) {
    $Study_Seq = $RowA['Seq'];
}

//차시 진도율
$ChapterProgress = floor($ProgressTime / $CompleteTime * 100);
if($ChapterProgress>=100) $ChapterProgress = 100;

//이몬에 전송할 트리거 설정

//최초 진도 시작인 경우
if($ProgressStep=="Start") {
    if($_SESSION["EndTrigger"]=="N") $TriggerYN = "Y"; else $TriggerYN = "N";
}

//중간에 1분마다 진도체크시 진도가 100%이고 세션 EndTrigger가 N인 경우만 트리거 전송
if($ProgressStep=="Middle") {
    if($ChapterProgress == 100 && $_SESSION["EndTrigger"]=="N") {
        $TriggerYN = "Y";
        $_SESSION["EndTrigger"] = "Y";
        // Brad (2021.11.28) : IsPlaying Session 초기화
        //$_SESSION["IsPlaying"] = "N";
    }else{
        $TriggerYN = "N";
    }
}

//학습종료 클릭시 이미 트리거를 전송했으면(세션 EndTrigger가 Y인 경우는 트리거 전송하지 않고 N인 경우만 트리거 전송)
if($ProgressStep=="End") {
    if($_SESSION["EndTrigger"]=="N") {
        $TriggerYN = "Y";
        $_SESSION["EndTrigger"] = "Y";
    }else{
        $TriggerYN = "N";
    }
    // Brad (2021.11.28) : IsPlaying Session 초기화
    $_SESSION["IsPlaying"] = "N";
}

$TriggerYN = "Y";

//수강한 전체 차시의 진도율 합
$Sql = "SELECT SUM(IF(Progress>100,100,Progress)) FROM Progress WHERE ID='$LoginMemberID' AND LectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$SUM_Progress = $Row[0];

//수강한 차시수
$Sql = "SELECT COUNT(idx) FROM Progress WHERE ID='$LoginMemberID' AND LectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$ProgressCount = $Row[0];


if(!$SUM_Progress)  $SUM_Progress = 0;
if(!$ProgressCount) $ProgressCount = 0;

//전체 진도율
$Sql = "SELECT * FROM Course WHERE LectureCode='$LectureCode'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
if($Row) {
    $Chapter = $Row['Chapter']; //차시수
}
$Total_Progress = floor($SUM_Progress / ($Chapter * 100) * 100);
if($Total_Progress>=100) $Total_Progress = 100;
$Total_Progress = (int)$Total_Progress;

//수강현황 로그 작성
$Sql_log = "INSERT INTO ProgressLog(ID, LectureCode, Study_Seq, Chapter_Seq, Contents_idx, ContentsDetail_Seq, LastStudy, Progress, StudyTime, UserIP, RegDate, TriggerYN, Chapter_Number, TotalProgress, FinishTime)
            VALUES('$LoginMemberID', '$LectureCode', $Study_Seq, $Chapter_Seq, $Contents_idx, $ContentsDetail_Seq, '$LastStudy', $ChapterProgress, $ProgressTime, '$UserIP', NOW(), '$TriggerYN', '$Chapter_Number', $Total_Progress, $iframeCheckTime)";
mysqli_query($connect, $Sql_log);

//현재 수강중인 차시가 존재하는지 체크
$Sql = "SELECT * FROM Progress WHERE ID='$LoginMemberID' AND LectureCode='$LectureCode' AND Study_Seq=$Study_Seq AND Chapter_Seq=$Chapter_Seq AND Contents_idx=$Contents_idx";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
if($Row) {
    if($ChapterProgress>=100) {
        $Sql2 = "UPDATE Progress SET ContentsDetail_Seq=$ContentsDetail_Seq, LastStudy='$LastStudy', StudyTime=$ProgressTime, UserIP='$UserIP', Progress=$ChapterProgress, TriggerYN='$TriggerYN', Chapter_Number='$Chapter_Number' , FinishTime = $iframeCheckTime
                 WHERE ID='$LoginMemberID' AND LectureCode='$LectureCode' AND Study_Seq=$Study_Seq AND Chapter_Seq=$Chapter_Seq AND Contents_idx=$Contents_idx";
    } else {
        $Sql2 = "UPDATE Progress SET ContentsDetail_Seq=$ContentsDetail_Seq, LastStudy='$LastStudy', StudyTime=$ProgressTime, UserIP='$UserIP', RegDate=NOW(), Progress=$ChapterProgress, TriggerYN='$TriggerYN', Chapter_Number='$Chapter_Number' , FinishTime = $iframeCheckTime
                 WHERE ID='$LoginMemberID' AND LectureCode='$LectureCode' AND Study_Seq=$Study_Seq AND Chapter_Seq=$Chapter_Seq AND Contents_idx=$Contents_idx";
    }
} else {
    $Sql2 = "INSERT INTO Progress(ID, LectureCode, Study_Seq, Chapter_Seq, Contents_idx, ContentsDetail_Seq, LastStudy, Progress, StudyTime, UserIP, RegDate, TriggerYN, Chapter_Number, FinishTime)
            VALUES('$LoginMemberID', '$LectureCode', $Study_Seq, $Chapter_Seq, $Contents_idx, $ContentsDetail_Seq, '$LastStudy', $ChapterProgress, $ProgressTime, '$UserIP', NOW(), '$TriggerYN', '$Chapter_Number', $iframeCheckTime)";
}
mysqli_query($connect, $Sql2);

//전체 진도율 계산
$SqlB = "SELECT SUM(StudyTime) FROM Progress WHERE ID = '$LoginMemberID' AND Study_Seq=$Study_Seq";
$ResultB = mysqli_query($connect, $SqlB);
$RowB = mysqli_fetch_array($ResultB);
$StudyTimePercent = floor($RowB[0]/54000*100);
if($StudyTimePercent == "0") $StudyTimePercent = "1";
if($StudyTimePercent >= 100){
    $PassOK = "Y";
    $StudyTimePercent = "100";
}else{
    $PassOK = "N";
}

//최종 데이터 저장 (Study 테이블)
$SqlC = "UPDATE Study SET Progress='$StudyTimePercent', StudyIP='$UserIP', PassOK='$PassOK'
         WHERE ID='$LoginMemberID' AND Seq=$Study_Seq ";
mysqli_query($connect, $SqlC);


//포인트 적립 ########################################################################################################################
//오늘 수강시간 구하기
$today = date("Y-m-d");
$SqlD1 = "SELECT DISTINCT LectureCode, Chapter_Seq FROM ProgressLog
          WHERE ID = '$LoginMemberID' AND RegDate LIKE '%$today%'";
$QueryD1 = mysqli_query($connect, $SqlD1);
if($QueryD1 && mysqli_num_rows($QueryD1)){
    while($RowD1 = mysqli_fetch_array($QueryD1)){
        $LectureCodeD = $RowD1['LectureCode'];
        $ChapterSeqD = $RowD1['Chapter_Seq'];
        
        //[2]각 차시의 수강시간구하기
        $SqlD2 = "SELECT MAX(StudyTime) - MIN(StudyTime) FROM ProgressLog
				  WHERE ID = '$LoginMemberID' AND RegDate LIKE '%$today%' AND LectureCode = '$LectureCodeD' AND Chapter_Seq  = $ChapterSeqD";
        $ResultD2 = mysqli_query($connect, $SqlD2);
        $RowD2 = mysqli_fetch_array($ResultD2);
        $StudyTimeD2 = $RowD2[0];
        $StudyTimeSum = $StudyTimeSum + $StudyTimeD2;
    }
}
$Today_Progress_count = $StudyTimeSum;

//오늘수강시간 > 1시간(3600초)
if($Today_Progress_count > 3600){
    //[1]해당 ID로 데이터 있는지 조회
    $SqlAl = "SELECT COUNT(*) FROM LectureEvent WHERE ID='$LoginMemberID'";
    $ResultA1 = mysqli_query($connect, $SqlAl);
    $RowA1 = mysqli_fetch_array($ResultA1);
    //[1-1]있다.
    if($RowA1[0] > 0){
        //[1-1-1]오늘날짜로 등록되어있는지 조회
        $SqlA2 = "SELECT COUNT(*) FROM LectureEvent WHERE ID='$LoginMemberID' AND DATE(RegDate)='".date('Y-m-d')."'";
        $ResultA2 = mysqli_query($connect, $SqlA2);
        $RowA2 = mysqli_fetch_array($ResultA2);
        //[1-1-2]등록된게 없을 경우 포인트 데이터 저장
        if($RowA2[0] < 1){
            //[A]카운트가 '10'이 아닌 데이터 조회
            $SqlA3 = "SELECT COUNT(*) FROM LectureEvent WHERE ID='$LoginMemberID' AND StageCount != 10";
            $ResultA3 = mysqli_query($connect, $SqlA3);
            $RowA3 = mysqli_fetch_array($ResultA3);
            //[A-1]있다.
            if($RowA3[0] > 0){
                //정보조회
                $SqlA4 = "SELECT * FROM LectureEvent WHERE ID='$LoginMemberID' AND StageCount != 10";
                $ResultA4 = mysqli_query($connect, $SqlA4);
                $RowA4 = mysqli_fetch_array($ResultA4);
                if($RowA4) {
                    $StageA4 = $RowA4['Stage'];
                    $StageCntA4 = $RowA4['StageCount'];
                }
                //update
                $SqlA5 = "UPDATE LectureEvent SET StageCount=StageCount+1 , RegDate=NOW()
                          WHERE ID='$LoginMemberID' AND Stage = $StageA4 ";
                mysqli_query($connect, $SqlA5);
                
            //[A-2]없다.
            }else{
                //정보조회
                $SqlA4 = "SELECT * FROM LectureEvent WHERE ID='$LoginMemberID' AND StageCount = 10 ORDER BY Stage DESC LIMIT 1";
                $ResultA4 = mysqli_query($connect, $SqlA4);
                $RowA4 = mysqli_fetch_array($ResultA4);
                if($RowA4) {
                    $StageA4 = $RowA4['Stage'];
                    $StageCntA4 = $RowA4['StageCount'];
                }
                $StageA5 = $StageA4+10;
                $StageCntA5 = $StageCntA4+1;
                
                //insert
                $SqlA5 = "INSERT INTO LectureEvent(ID, Stage, StageCount, RegDate)
                          VALUES('$LoginMemberID', $StageA5, $StageCntA5, NOW())";
                mysqli_query($connect, $SqlA5);
            }
        }
        
        //[1-2]없다.
    }else{
        $SqlA5 = "INSERT INTO LectureEvent(ID, RegDate) VALUES('$LoginMemberID', NOW())";
        mysqli_query($connect, $SqlA5);
    }
}
//포인트 적립 ########################################################################################################################


$studyapi = array();
if($Chapter_Number=="0") $studyapi['Chapter_Number'] = $Chapter_Number; else $studyapi['Chapter_Number'] = $Chapter_Number-1;
$studyapi['ProgressCount'] = sprintf("%02d", $ProgressCount);
$studyapi['Total_Progress'] = $Total_Progress;
$studyapi['ChapterProgress'] = $ChapterProgress;

$json_encoded = json_encode($studyapi);
print_r($json_encoded);

mysqli_close($connect);
?>