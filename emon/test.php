<?php
include '../melon/core.php';

### attend_hist / 수강정보 ###

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

//학습종료일+1일째 되는날 환급과정 TB_ATTEND_HIST_V2에 1회 INSERT처리
//매일 00:00시 부터 1시간 간격으로 API 전송되므로, 새벽 00시 30분 이전 1회 실행
if( date("H:i:s") < "00:30:00" ) {
    $today = date("Y-m-d");
    $data  = getList("Study","ServiceType IN ('A') AND DATE_ADD(LectureEnd, INTERVAL 1 DAY) = '{$today}' AND StudyEnd ='N'");
	
    foreach( $data['list'] as $item ) {
        $afterReStudy = Array();
        $afterReStudy['USER_AGENT_PK']  = $item['ID'];
        $afterReStudy['COURSE_AGENT_PK']= $item['LectureCode'];
        $afterReStudy['CLASS_AGENT_PK'] = $item['LectureCode'] . ",". $item['LectureTerme_idx'];
		
		//REG_DATE 오늘 날짜 중복 체크
		$check = getItem('TB_ATTEND_HIST_V2',"USER_AGENT_PK='{$afterReStudy['USER_AGENT_PK']}' AND COURSE_AGENT_PK='{$afterReStudy['COURSE_AGENT_PK']}' AND CLASS_AGENT_PK='{$afterReStudy['CLASS_AGENT_PK']}' AND DATE(REG_DATE)='{$today}'");	
		if( $check ) {
			continue;
		}

        if ( $item['PassOK'] == "Y" ) { 
            $item['PASS_FLAG'] = 1; //수료
        } else {
            $item['PASS_FLAG'] = 0; //미수료
        }
        

        $item['EMP_INS_FLAG'] = 1; // 1 고정값
        $afterReStudy['PASS_FLAG']         = $item['PASS_FLAG'];
        $afterReStudy['ATTEND_VALID_FLAG'] = 1;
        $afterReStudy['CHANGE_STATE']      = "U";
        $afterReStudy['REG_DATE']          = date("Y-m-d H:i:s");
        $afterReStudy['EMP_INS_FLAG']      = $item['EMP_INS_FLAG'];	

		###################################################################
		#	전송데이터 생성시 PROGRESS_RATE 누락 (수동전송시 오류방지용)
		###################################################################

		// 진도율,총점 구하기
        $CLASS_AGENT_PK = explode(",",$item['CLASS_AGENT_PK']);
        $study = getItem('Study',"ID='".$item['ID']."' AND LectureCode='".$item['LectureCode']."'  AND LectureTerme_idx='".$item['LectureTerme_idx']."'  ");

        // 진도율 : 최종전송시 확인 후 전송됨. 
        $progressRateArr = getItem('Progress',"ID='".$item['ID']."' AND Study_Seq='".$study['Seq']."' ", "",  " FLOOR( SUM(StudyTime) / 3600) AS StudyTimeSum");

        if ( $item['CHANGE_STATE'] == "C" ) {
            $afterReStudy['PROGRESS_RATE'] = 0;
        } else {
            $afterReStudy['PROGRESS_RATE'] = $progressRateArr['StudyTimeSum'];
        }


		$SQL = "INSERT INTO TB_ATTEND_HIST_V2 (
			USER_AGENT_PK,
			COURSE_AGENT_PK,
			CLASS_AGENT_PK,
			PASS_FLAG,
			ATTEND_VALID_FLAG,
			CHANGE_STATE,
			REG_DATE,
			EMP_INS_FLAG,
            PROGRESS_RATE
			) VALUES (
			'{$afterReStudy['USER_AGENT_PK']}',
			'{$afterReStudy['COURSE_AGENT_PK']}',
			'{$afterReStudy['CLASS_AGENT_PK']}',
			{$afterReStudy['PASS_FLAG']},
			1,
			'U',
			NOW(),
			{$afterReStudy['EMP_INS_FLAG']},
            {$afterReStudy['PROGRESS_RATE']}
		)";
		
		// sqlQuery($SQL);
		###################################################################
    }
}

$requestArr = array();
$requestArr["dataList"]=[];

/*
Attend Hist
*/

$data=getList('TB_ATTEND_HIST_V2','',5000,'','seq desc');
//$data=getList('TB_ATTEND_HIST_V2',"substring(REG_DATE,1,10) >= '2023-07-02'",50000, "",'seq asc');

foreach( $data['list'] as $item ) {

	$check = getItem('TB_ATTEND_HIST_V2_RESULT','SEQ='.$item['SEQ']);
	if( $check ) {
		continue;
	}
	
    // 진도율,총점 구하기
    $CLASS_AGENT_PK = explode(",",$item['CLASS_AGENT_PK']);
    $study = getItem('Study',"ID='".$item['USER_AGENT_PK']."' AND LectureCode='".$item['COURSE_AGENT_PK']."'  AND LectureTerme_idx='{$CLASS_AGENT_PK[1]}'  ");

    //250731 yjkwon C이거나 수강 마감시에만 보내도록 
    // if ($item['CHANGE_STATE'] != 'C' && $study['StudyEnd'] == 'N') {
    //     continue;
    // }

    //250731 yjkwon 최종진도율 변경 (훈련생의 해당 과정 학습시간, 시간 단위)
    $progressRateArr = getItem('Progress',"ID='".$item['USER_AGENT_PK']."' AND Study_Seq='".$study['Seq']."' ", "",  " FLOOR( SUM(StudyTime) / 3600) AS StudyTimeSum");

    if ( $item['CHANGE_STATE'] == "C" ) {
        $progressRate = 0;
    } else {
        $progressRate = $progressRateArr['StudyTimeSum'];
    }

    // 250731 yjkwon progressRate 의 따른 여부로 변경
    $totalScore = 100; // 100 고정값

    $paramArr['agentPk']         = $emon_agentPk;
	$paramArr['seq']             = $item['SEQ'];
	$paramArr['userAgentPk']     = $item['USER_AGENT_PK'];
	$paramArr['courseAgentPk']   = $item['COURSE_AGENT_PK'];
	$paramArr['classAgentPk']    = $item['CLASS_AGENT_PK'];
	// $paramArr['passFlag']        = $item['PASS_FLAG'];
    //250731 yjkwon 
    $paramArr['passFlag'] = ($progressRate >= 15) ? 1 : 0; // progress_rate가 15이상 1, 15미만 0
	$paramArr['attendValidFlag'] = 1;
	$paramArr['changeState']     = $item['CHANGE_STATE'];
	$paramArr['regDate']         = $item['REG_DATE'];
	$paramArr['empInsFlag']      = $item['EMP_INS_FLAG'];
	$paramArr["progressRate"]    = $progressRate;
	$paramArr["totalScore"]      = $totalScore;

	array_push($requestArr["dataList"],$paramArr);

	$item['PASS_FLAG'] = intval($item['PASS_FLAG']);
	$item['ATTEND_VALID_FLAG'] = intval($item['ATTEND_VALID_FLAG']);

	// 20251116 결과값 누락 방지
	$item['PROGRESS_RATE'] = $progressRate;


	// insertItem('TB_ATTEND_HIST_V2_RESULT',$item);
}

echo "<pre>";
print_r($item);
echo "</pre>";

if( count($requestArr["dataList"]) == 0 ) {
		echo '전송할 데이터가 없습니다.';
		exit;
	}

//배열을 JSON 데이터로 생성
$data = jsonEncode($requestArr);

echo "<pre>";
print_r($requestArr);
echo "</pre>";

exit;
//URL 및 헤더 설정
// $url = "https://emonapi-server.hrdkorea.or.kr/api/v2/attend_hist";
// $headers = array (
// "Content-Type: application/json",
// "X-TQIAPI-HEADER: ".$emon_API_KEY, "X-TQIAPI-USER: ".$emon_agentPk
// );

// $ch = curl_init();
// curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_URL, $url);
// curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
// curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
// curl_setopt($ch, CURLOPT_TIMEOUT, 10);
// $response = curl_exec($ch);

// $json_result_arr = json_decode($response, true);
// $result_code = $json_result_arr['code'];
// $result_msg  = $json_result_arr['msg'];
// $result_cnt  = $json_result_arr['data_cnt'];


if( !$result_cnt ) {
	$result_cnt = 0;
}


echo $data;

curl_close($ch);
echo $response;
