<?php
include'../melon/core.php';

set_time_limit(0);

ini_set('display_errors',1);
if($param['type']==''){
	echo 'api key missing';
	exit;
}

$param['mode'] = 'send';
$param['type'] = 'h';

if( $param['type'] == 'h' ) {
    $emon_agentPk = "hrda1746";
    $emon_API_KEY = "RJ8dij3FDeSYjkMupuor39SiYcC+J0FhhtzvSB2PZLE=";
}
$today=date('Y-m-d');

/*
score_hist
*/
	
$requestArr = array();
$requestArr["dataList"] =[];

dbConnect();



if(!empty($data2['list'])){
	foreach($data2['list'] as $item){
		$check=getItem('TB_SCORE_HIST_V2_RESULT','SEQ='.$item['SEQ']);
		if($check){
			continue;
		}
		
		$paramArr['agentPk']=$emon_agentPk;
		$paramArr['seq']=$item['SEQ'];
		$paramArr['userAgentPk']=$item['USER_AGENT_PK'];
		$paramArr['courseAgentPk']=$item['COURSE_AGENT_PK'];
		$paramArr['classAgentPk']=$item['CLASS_AGENT_PK'];
		$paramArr['evalType'] = $item['EVAL_TYPE'];
		$paramArr['submitDate']  = $item['SUBMIT_DATE'];
		$paramArr['score'] = $item['SCORE'];
		$paramArr['accessIp'] = $item['ACCESS_IP'];
		$paramArr['submitDueDt'] = $item['SUBMIT_DUE_DT'];
		$paramArr['changeState'] = $item['CHANGE_STATE'];
		$paramArr['isCopiedAnswer'] = $item['IS_COPIED_ANSWER']; // N: 비모사답안, X:판정불가, Y:모사답안
		$paramArr['regDate'] = $item['REG_DATE'];

		$paramArr['evalCd'] =  $item['EVAL_CD'];
		//$evalTypeArray=explode('_',$item['EVAL_TYPE']);
		//$chasi = str_pad($evalTypeArray[1],2,'0',STR_PAD_LEFT);
		
		$paramArr['chasi'] = $item['CHASI'];
		if($item['CHANGE_STATE'] =="C"){
			$paramArr['startEndFlag'] ='S';	
		}else{
		
			$paramArr['startEndFlag'] ='E';	
		}
echo '[ 유저명 :  '.$paramArr['userAgentPk'].'->SEND('.$paramArr['startEndFlag'].'/'.$paramArr['changeState'].') :  '.$paramArr['evalCd'].','.$paramArr['score'].'/'.$paramArr['isCopiedAnswer'].$paramArr['evalType'].'('.$paramArr['submitDate'].'/'.$paramArr['regDate'].')] <br>';
		if($item['USER_AGENT_PK']!=''){
			array_push($requestArr["dataList"],$paramArr);
	 		insertItem('TB_SCORE_HIST_V2_RESULT',$item);
		}
	}


	if(count($requestArr["dataList"])>0){
		//배열을 JSON 데이터로 생성
		$data = jsonEncode($requestArr);

		//URL 및 헤더 설정
		$url = "https://emonapi-server.hrdkorea.or.kr/api/v2/score_hist";
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

		curl_close($ch);

		echo $response;
	}
}
