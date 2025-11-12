<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$error_count = 0;

$idx = Replace_Check($Seq);
$ctype = Replace_Check($ctype);

//등록된 엑셀정보 불러오기
$Sql = "SELECT * FROM CourseExcelTemp WHERE idx=$idx AND ID='$LoginAdminID' AND Ctype = '$ctype'";
//echo $Sql."<BR>";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if ($Row) {
    $idx = $Row['idx']; // 고유 증가값
    $Ctype = $Row['Ctype']; // 구분 X:이러닝 / Y:마이크로닝 / Z:숏폼
    $LectureCode = $Row['LectureCode']; // 강의 코드
    $ClassGrade = $Row['ClassGrade']; // 등급
    $UseYN = $Row['UseYN']; // 사이트 노출
    $Category1 = $Row['Category1']; // 과정분류 대분류
    $Category2 = $Row['Category2']; // 과정분류 중분류
    $Keyword1 = $Row['Keyword1']; // 난이도(직급)
    $Keyword2 = $Row['Keyword2']; // 직무분야
    $Keyword3 = $Row['Keyword3']; // 관심분야
    $Keyword4 = $Row['Keyword4']; // 역량
    $ServiceType = $Row['ServiceType']; // 서비스구분
    $ContentsName = $Row['ContentsName']; // 과정명
    $ContentsTime = $Row['ContentsTime']; // 교육시간
    $Mobile = $Row['Mobile']; // 모바일 지원
    $BookPrice = $Row['BookPrice']; // 교재비
    $PreviewImage = $Row['PreviewImage']; // 과정 이미지
    $Intro = $Row['Intro']; // 과정소개
    $EduTarget = $Row['EduTarget']; // 교육대상
    $EduGoal = $Row['EduGoal']; // 교육목표
    $ContentsURLSelect = $Row['ContentsURLSelect']; // A:컨텐츠 URL 직접입력 / B:예비경로
    $Chapter = $Row['Chapter']; // 차시수
    $ContentsStart = $Row['ContentsStart']; // 컨텐츠 유효 시작일
    $ContentsEnd = $Row['ContentsEnd']; // 컨텐츠 유효 만료일
    $UploadDate = $Row['UploadDate']; // 컨텐츠 업로드일
    $PackageLectureCode = $Row['PackageLectureCode']; //패키지콘텐츠과정코드
    $HrdSeq = $Row['HrdSeq']; //원격훈련일련번호
    $Professor = $Row['Professor']; //교강사
    $Price = $Row['Price']; //교육비용 일반
    $Price01View = $Row['Price01View']; //교육비용 우선지원
    $Price02View = $Row['Price02View']; //교육비용 대규모 1000인 미만
    $Price03View = $Row['Price03View']; //교육비용 대규모 1000인 이상
    $PassTime = $Row['PassTime']; //수료기준 시간
    $ID = $Row['ID']; // 등록자 아이디
}

// 특수문자 이스케이프 처리
$idx = addslashes($idx);
$Ctype = addslashes($Ctype);
$LectureCode = addslashes($LectureCode);
$ClassGrade = addslashes($ClassGrade);
$UseYN = addslashes($UseYN);
$Category1 = addslashes($Category1);
$Category2 = addslashes($Category2);
$Keyword1 = addslashes($Keyword1);
$Keyword2 = addslashes($Keyword2);
$Keyword3 = addslashes($Keyword3);
$Keyword4 = addslashes($Keyword4);
$ServiceType = addslashes($ServiceType);
$ContentsName = addslashes($ContentsName);
$ContentsTime = addslashes($ContentsTime);
$Mobile = addslashes($Mobile);
$BookPrice = addslashes($BookPrice);
$PreviewImage = addslashes($PreviewImage);
$Intro = addslashes($Intro);
$EduTarget = addslashes($EduTarget);
$EduGoal = addslashes($EduGoal);
$ContentsURLSelect = addslashes($ContentsURLSelect);
$Chapter = addslashes($Chapter);
$ContentsStart = addslashes($ContentsStart);
$ContentsEnd = addslashes($ContentsEnd);
$UploadDate = addslashes($UploadDate);
$PackageLectureCode = addslashes($PackageLectureCode);
$HrdSeq = addslashes($HrdSeq);
$Professor = addslashes($Professor);
$Price = addslashes($Price);
$Price01View = addslashes($Price01View);
$Price02View = addslashes($Price02View);
$Price03View = addslashes($Price03View);
$PassTime = addslashes($PassTime);
$ID = addslashes($ID);


$maxno = max_number("idx","Course");

//상위 기초차시 등록
$Sql2 = "INSERT INTO Course (
            idx, ctype, LectureCode, ClassGrade, UseYN, Category1, Category2, Keyword1, Keyword2, Keyword3, Keyword4, 
            ServiceType, ContentsName, ContentsTime,  Mobile, BookPrice, PreviewImage, Intro, EduTarget, EduGoal, 
            ContentsURLSelect, Chapter, ContentsStart, ContentsEnd, UploadDate, Del, RegDate,
            PackageLectureCode, HrdSeq, Professor, Price, Price01View, Price02View, Price03View, PassTime	
        )VALUES(
            $maxno, '$Ctype', '$LectureCode', '$ClassGrade', '$UseYN', '$Category1', '$Category2', '$Keyword1', '$Keyword2', '$Keyword3', '$Keyword4', 
            '$ServiceType', '$ContentsName', '$ContentsTime', '$Mobile', '$BookPrice', '$PreviewImage', '$Intro', '$EduTarget', '$EduGoal', 
            '$ContentsURLSelect', '$Chapter', '$ContentsStart', '$ContentsEnd', '$UploadDate', 'N', NOW(),
            '$PackageLectureCode', '$HrdSeq', '$Professor', '$Price', '$Price01View', '$Price02View', '$Price03View', '$PassTime'
        )";
$Row2 = mysqli_query($connect, $Sql2);

if(!$Row2) { //쿼리 실패시 에러카운터 증가
	$error_count++;
}

//하위 기초차시 등록
// $maxnoA = max_number("Seq","ContentsDetail");
// $Sql3 = "INSERT INTO ContentsDetail
// 				(Seq, Contents_idx, ContentsType, ContentsPage, ContentsMobilePage, ContentsURLSelect, ContentsURL, MobileURL , UseYN , OrderByNum)
// 				VALUES ($maxnoA, '$maxno', '$ContentsType', '$ContentsPage', '$ContentsMobilePage', 'A', '$ContentsURL', '$MobileURL', 'Y', 1 )";
// $Row3 = mysqli_query($connect, $Sql3);

// if(!$Row3) { //쿼리 실패시 에러카운터 증가
//     $error_count++;
// }


//등록 처리가 완료되면 엑셀 업로드 내역 삭제
if($error_count<1) {
	$Sql_d = "DELETE FROM CourseExcelTemp WHERE idx=$idx AND ID='$LoginAdminID' and Ctype = '$ctype'";
	mysqli_query($connect, $Sql_d);
}

if($error_count>0) {
	mysqli_query($connect, "ROLLBACK");
	$msg = "<font color='red'>오류</font>";
}else{
	mysqli_query($connect, "COMMIT");
	$msg = "<font color='blue'>등록</font>";
}

echo $msg;

mysqli_close($connect);
?>