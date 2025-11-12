<?php
include '../melon/core.php';

### attend_rslt_ct_hist / 성적이력 ###

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

$param['mode']="send";

// $today = date('Y-m-d');

$today = date('Y-m-d');

/*
score_hist
*/
	
//$data=getList('TB_SCORE_HIST_V2','submit_date LIKE "%'.$today.'%"',50000,'','SUBMIT_DATE ASC');
for ($z=0; $z < 6; $z++) 
{
	dbConnect();
    $page_size = 50000 * $z;
    echo $page_size . "<br><br>";
	$data = getList('TB_SCORE_HIST_V2',"",$page_size,50000,'SUBMIT_DATE ASC');
    // $data = getList('TB_SCORE_HIST_V2',"substring(submit_date,1,10)='{$today}'",$page_size,50000,'SUBMIT_DATE ASC');


	$perv_score = 0;
	$requestArr = array();
	$requestArr["dataList"] =[];

	foreach($data['list'] as $item) 
    {

		$today2 = substr($item['SUBMIT_DATE'],0,10);

		$check = getItem('TB_SCORE_HIST_V2_RESULT','SEQ='.$item['SEQ'].' AND submit_date like "%'.$today2.'%"');

		if( $check ) {
			continue;
		}

		$ITEM_EVAL_TYPE_ARRAY = explode('_',$item['EVAL_TYPE']);
		$CHAPTER_NUMBER = str_pad($ITEM_EVAL_TYPE_ARRAY[1],2,'0',STR_PAD_LEFT);
        
		// $progress = getItem('Progress',"CHAPTER_NUMBER = ".$CHAPTER_NUMBER." AND ID='".$item['USER_AGENT_PK']."' AND LectureCode='".$item['COURSE_AGENT_PK']."' AND Study_Seq = 20", '','', '',"");

        // $progress_lecture = explode(',',$item['CONTENTS_AGENT_PK']);


        // $progress = getItem('Progress',"CHAPTER_NUMBER = ".$CHAPTER_NUMBER." AND ID='".$item['USER_AGENT_PK']."' AND LectureCode='".$item['CONTENTS_AGENT_PK']."'", '','', '',"");

        $study = getItem('Study', "ID = '".$item['USER_AGENT_PK']."'", '', '', '');

		// if( $progress['Progress']==100 ) {
        if( $study['PassOK'] == "Y" ) {

			$check_chasi = getItem('TB_SCORE_HIST_V2_RESULT','EVAL_TYPE="'.$item['EVAL_TYPE'].'" AND COURSE_AGENT_PK="'.$item['COURSE_AGENT_PK'].'" AND CLASS_AGENT_PK="'.$item['CLASS_AGENT_PK'].'" AND CONTENTS_AGENT_PK="'.$item['CONTENTS_AGENT_PK'].'" AND USER_AGENT_PK="'.$item['USER_AGENT_PK'].'"');

            // RESULT INSERT
			insertItem('TB_SCORE_HIST_V2_RESULT', $item);

			if( !$check_chasi ) {//같은 차시 없을 때만 전송

                $start = getItem('TB_SCORE_HIST_V2','USER_AGENT_PK="'.$item['USER_AGENT_PK'].'" AND  EVAL_TYPE="'.$item['EVAL_TYPE'].'" AND CONTENTS_AGENT_PK="'.$item['CONTENTS_AGENT_PK'].'" ','SUBMIT_DATE ASC');
                // $start = getItem('TB_SCORE_HIST_V2', 'USER_AGENT_PK = "' . $item['USER_AGENT_PK'] . '" AND EVAL_TYPE = "' . $item['EVAL_TYPE'] . '" AND COURSE_AGENT_PK = "'. $progress['LectureCode'] . '" AND CHANGE_STATE = "C"', 'SUBMIT_DATE ASC');
                $end   = getItem('TB_SCORE_HIST_V2', 'USER_AGENT_PK = "' . $item['USER_AGENT_PK'] . '" AND EVAL_TYPE = "' . $item['EVAL_TYPE'] . '" AND CONTENTS_AGENT_PK = "'. $item['CONTENTS_AGENT_PK'] . '" ','SEQ DESC');

                $EVAL_TYPE_ARRAY = explode('_',$start['EVAL_TYPE']);
                $CHASI           = str_pad($EVAL_TYPE_ARRAY[1],2,'0',STR_PAD_LEFT);

                // $score_diff = $end['SCORE'] - $start['SCORE']; //학습시간 차액 계산
                // $min_score  = round($score_diff/60, 1); //분단위로 만들고 소수 둘째 반올림

                $min_score  = round($end['SCORE']/60, 1); //분단위로 만들고 소수 둘째 반올림
        
                $paramArr['agentPk']         = $emon_agentPk;
                $paramArr['seq']             = $item['SEQ'];
                $paramArr['userAgentPk']     = $item['USER_AGENT_PK'];
                $paramArr['classAgentPk']    = $item['CLASS_AGENT_PK'];
                $paramArr['courseAgentPk']   = $item['COURSE_AGENT_PK'];
                $paramArr['contentsAgentPk'] = $item['CONTENTS_AGENT_PK'];
                $paramArr['evalType']        = $item['EVAL_TYPE'];  //ex) 진도_3
                $paramArr['submitDate']      = $start['SUBMIT_DATE']; //학습시작 일시 2025-05-08 16:00:00
                $paramArr['score']           = $min_score; // 접속 시 학습시간 (분단위)
                $paramArr['accessIp']        = $item['ACCESS_IP'];
                $paramArr['submitDueDt']     = $item['SUBMIT_DUE_DT'];
                $paramArr['changeState']     = 'C';
                $paramArr['isCopiedAnswer']  = 'X'; // X 고정값
                $paramArr['evalCd']          = '01'; // 01 고정값
                $paramArr['chasi']           = $CHASI;
                // $paramArr['scoreTime']       = $score_diff; // 접속 시 학습시간 (초단위)
                $paramArr['scoreTime']       = $end['SCORE']; // 접속 시 학습시간 (초단위)
                $paramArr['submitDateEnd']   = $end['SUBMIT_DATE_END']; //학습시작 일시 2025-05-08 16:03:10
                // $paramArr['regDate']         = $start['REG_DATE'];
                $paramArr['regDate']         = date("Y-m-d H:i:s");

                //	$paramArr['regDate']=$item['REG_DATE'];
                array_push($requestArr["dataList"], $paramArr);

                //배열을 JSON 데이터로 생성
                echo '[ 유저명 :  '.$paramArr['userAgentPk'].'->SEND('.$paramArr['changeState'].') :  '. $item['CONTENTS_AGENT_PK'] .', '.$paramArr['evalCd'].', '.$paramArr['score'].'/'.$paramArr['isCopiedAnswer'].$paramArr['evalType'].'('.$paramArr['submitDate'].'/'.$paramArr['regDate'].')]';
                $data = jsonEncode($requestArr);
                flush();
                
                dbConnect();

                br();

            }		
		}
	}


// echo "<pre>";
// print_r($requestArr);
// echo "</pre>";

// exit;
    
	if( count($requestArr["dataList"]) > 0 ) {
		$data = jsonEncode($requestArr);

		flush();

		//URL 및 헤더 설정
		// $url = "https://emonapi-server.hrdkorea.or.kr/api/v2/score_hist";
        $url = "https://emonapi-server.hrdkorea.or.kr/api/v2/score_ct_hist";
        
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
		if( $param['mode'] == 'send' ) {
		    $response = curl_exec($ch);
		}
		curl_close($ch);

		echo $response;
		flush();

		sleep(60);
		echo "<br>";
		echo "<br>";
	}
}
