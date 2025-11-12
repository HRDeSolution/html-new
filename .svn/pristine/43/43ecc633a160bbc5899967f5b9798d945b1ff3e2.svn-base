<?
include "../../include/include_function.php"; //DB연결 및 각종 함수 정의

$step = Replace_Check_XSS2($step);

$Data1 = Replace_Check_XSS2($Data1);
$Data2 = Replace_Check_XSS2($Data2);
$Data3 = Replace_Check_XSS2($Data3);


$ID = $_SESSION['LoginMemberID'];

$cmd = false;
$chkVal;

//기존 데이터가 있는지 확인
$SqlA = "SELECT * FROM MemberContents WHERE ID='$ID'";
$ResultA = mysqli_query($connect, $SqlA);
$RowA = mysqli_fetch_array($ResultA);

if($RowA) {
    $chkVal = "Y";
}else{
    $chkVal = "N";
}

if($step == "step01"){
    //해당 아이디로 데이터가 없을 경우
    if($chkVal == "N"){
        $Sql = "INSERT INTO MemberContents (ID, Category1, Category2) VALUES ('$ID', '$Data1', '$Data2')";
        
    //해당 아이디로 데이터가 있을 경우
    }else{
        $Sql = "UPDATE MemberContents SET Category1='$Data1', Category2='$Data2' WHERE ID='$ID'";
    }    
    $Row = mysqli_query($connect, $Sql);
    $cmd = true;
}else if($step == "step02"){
    //step01에서 선택한 데이터 추출
    $SqlB = "SELECT * FROM MemberContents WHERE ID='$ID'";
    $ResultB = mysqli_query($connect, $SqlB);
    $RowB = mysqli_fetch_array($ResultB);
    $Category1 = $RowB['Category1'];
    $Category2 = $RowB['Category2'];
    
    $Cat1 = $Category1."|".$Data1;
    $Cat2 = $Category2."|".$Data2;
    
    $Sql = "UPDATE MemberContents SET Category1='$Cat1', Category2='$Cat2' WHERE ID='$ID'";
    $Row = mysqli_query($connect, $Sql);
    $cmd = true;
}else if($step == "step03"){
    $Sql = "UPDATE MemberContents SET Keyword1='$Data1', Keyword2='$Data2', Keyword3='$Data3' WHERE ID='$ID'";
    $Row = mysqli_query($connect, $Sql);
    $cmd = true;
}

if($Row && $cmd) {
    echo "Y";
}else{
    if(!$ID) echo "NoID"; else echo "N";
}

mysqli_close($connect);
?>