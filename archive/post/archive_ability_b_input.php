<?
include "../../include/include_function.php"; //DB연결 및 각종 함수 정의

$step = Replace_Check_XSS2($step);
$type = Replace_Check_XSS2($type);

$Data1 = Replace_Check_XSS2($col1);
$Data2 = Replace_Check_XSS2($col2);
$Data3 = Replace_Check_XSS2($col3);
$Data4 = Replace_Check_XSS2($col4);


// print_r($_POST['responses']);
// $responses = json_decode($_POST['responses'], true);
// var_dump($responses);
// exit;
// if ( !isset($_POST['responses']) ) $responses = $_POST['responses'];

$ID = $_SESSION['LoginMemberID'];
// $ID = "test30";

$cmd = false;
$chkVal;

//기존 데이터가 있는지 확인
$SqlA = "SELECT * FROM ArchiveAbilityResult1 WHERE ID='$ID'";
$ResultA = mysqli_query($connect, $SqlA);
$RowA = mysqli_fetch_array($ResultA);

if($RowA) {
    $chkVal = "Y";
}else{
    $chkVal = "N";
}

if ( !empty($responses) )
{
    foreach ($responses as $res) {
        $questionIdx = mysqli_real_escape_string($connect, $res['no']);
        $aValue = mysqli_real_escape_string($connect, $res['value']);
    
        // 존재 여부 확인
        $SqlB = "SELECT 1 FROM ArchiveAbilityResult2 WHERE ID='$ID' AND question_idx='$questionIdx' LIMIT 1";
        $ResultB = mysqli_query($connect, $SqlB);
    
        if ( mysqli_num_rows($ResultB) > 0 ) {
            // 존재하면 UPDATE
            $sql = "UPDATE ArchiveAbilityResult2
                    SET aValue='$aValue', modDate=NOW() 
                    WHERE ID='$ID' AND question_idx='$questionIdx'";
        } else {
            // 존재하지 않으면 INSERT
            $sql = "INSERT INTO ArchiveAbilityResult2 (ID, question_idx, aValue) 
                    VALUES ('$ID', '$questionIdx', '$aValue')";
        }
    
        // 쿼리 실행
        if (!mysqli_query($connect, $sql)) {
            echo 'N'; // 실패 시 즉시 반환
            exit;
        }
    }

    $cmd = true;   
// Step01/02 just record answers
    if ($step == "step02") {
        // mark as successful save so client can proceed to step 3
        $Row = true;
    }
    // ✅ Final step: mark full completion & satisfaction
    else if ($step == "step03") {
        $sqlUpdate = "
            UPDATE Member
               SET SatisfactionYN='Y',
                   SatisfactionDate=NOW(),
                   AbilityAfterYN='Y',
                   AbilityAfterDate=NOW()
             WHERE ID='$ID'";
        $Row = mysqli_query($connect, $sqlUpdate);
    }

  //  if ($step == "step02") {
  //      $sqlUpdate = "UPDATE Member SET SatisfactionYN='Y', SatisfactionDate=NOW() WHERE ID='$ID' ";
  //      $Row = mysqli_query($connect, $sqlUpdate);
  //  }
  //   else if ($step == "step03") {
  //      $sqlUpdate = "UPDATE Member SET AbilityAfterYN='Y', AbilityAfterDate=NOW() WHERE ID='$ID' ";
  //      $Row = mysqli_query($connect, $sqlUpdate);
  //   }
    
}

if($Row && $cmd) {
    echo "Y";
}else{
    if(!$ID) echo "NoID"; else echo "N";
}

mysqli_close($connect);
?>
