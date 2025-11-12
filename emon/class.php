<?php
include '../melon/core.php';

### class_hist / 수업정보 ###

ini_set('display_errors',1);
if( $param['type'] == '' ) {
    echo 'api key missing';
    exit;
}

$param['mode'] = 'send';
$param['type'] = 'h';

if( $param['type'] == 'h' ) {
    $emon_agentPk = "hrda1746";
    $emon_API_KEY = "RJ8dij3FDeSYjkMupuor39SiYcC+J0FhhtzvSB2PZLE=";
}

$requestArr = array();
$requestArr["dataList"]=[];

/*
Attend Hist
*/
	


$data = getList('TB_CLASS_HIST_V2','',5000,'','seq desc');

foreach( $data['list'] as $item ) {

	$check = getItem('TB_CLASS_HIST_V2_RESULT','SEQ='.$item['SEQ']);
	if( $check ) {
		continue;
	}
	
	$paramArr['agentPk']       = $emon_agentPk;
	$paramArr['seq']           = $item['SEQ'];
	$paramArr['courseAgentPk'] = $item['COURSE_AGENT_PK'];
	$paramArr['classAgentPk']  = $item['CLASS_AGENT_PK'];
	$paramArr['fullScore']     = $item['FULL_SCORE'];
	$paramArr['startDt']       = $item['START_DT'];
	$paramArr['endDt']         = $item['END_DT'];
	$paramArr['changeState']   = $item['CHANGE_STATE'];
	$paramArr['regDate']       = $item['REG_DATE'];
	$paramArr['tracseTme']     = $item['TRACSE_TME'];
 
	array_push($requestArr["dataList"],$paramArr);

	if( !$result_cnt ) {
		$result_cnt = 0;
	}

	insertItem('TB_CLASS_HIST_V2_RESULT',$item);
}


if( count($requestArr["dataList"]) == 0 ) {
		echo '전송할 데이터가 없습니다.';
		exit;
	}

//배열을 JSON 데이터로 생성
$data = jsonEncode($requestArr);


// echo "<pre>";
// print_r($requestArr);
// echo "</pre>";

// exit;

//URL 및 헤더 설정
$url = "https://emonapi-server.hrdkorea.or.kr/api/v2/class_hist";
$headers = array (
"Content-Type: application/json",
"X-TQIAPI-HEADER: ".$emon_API_KEY, "X-TQIAPI-USER: ".$emon_agentPk
);


$ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_TIMEOUT, 10);
$response = curl_exec($ch);

$json_result_arr = json_decode($response, true);
$result_code = $json_result_arr['code'];
$result_msg = $json_result_arr['msg'];
$result_cnt = $json_result_arr['data_cnt'];


if(!$result_cnt) {
	$result_cnt = 0;
}


echo $data;

curl_close($ch);
echo $response;
