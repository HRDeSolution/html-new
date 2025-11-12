<?
include "../include/include_function.php";
$data = json_decode(file_get_contents('php://input'), true);

// 응답 초기화
$response = [];

//트랜잭션 시작
mysqli_query($connect, "SET AUTOCOMMIT=0");
mysqli_query($connect, "BEGIN");

$i = 0;
$succnt = 0;
$failcnt = 0;
if (isset($data['idx']) && is_array($data['idx'])) { //값이 존재하는지, 배열인지 확인
    foreach ($data['idx'] as $singleIdx) {
        $response['data'.$i] = $singleIdx; //이렇게 하니깐 값이 나옴.
        
        $sql = "DELETE FROM Contents where idx = $singleIdx";
        $query = mysqli_query($connect, $sql);
        if($query){
            $succnt++;
        }else{
            $failcnt++;
        }
        $i++;
    }
}

if($failcnt > 0){
    mysqli_query($connect, "ROLLBACK");
    $response['succnt'] = 0;
}else{
    mysqli_query($connect, "COMMIT");
    $response['succnt'] = $succnt;
}

// JSON 응답 전송
header('Content-Type: application/json');
echo json_encode($response);
?>