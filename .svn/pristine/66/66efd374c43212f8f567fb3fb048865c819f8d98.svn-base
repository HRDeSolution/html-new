<?
##############################################
# 문자 관리
# 개발서버 - 알림톡
##############################################

// 문자메시지 발송함수
function mts_mms_send($phone, $msg, $callback, $etc1, $template_code="hrd01") {
    global $connect;
    global $auth_code;
    global $TRAN_SENDER_KEY;
    
    if ($phone)  {
        // 발신번호 /로 여러개 들어가 있는 경우 수정.
        $callback_arr = explode("/",$callback);
        $callback = trim($callback_arr[0]);
        
        $data=array(
            "auth_code"=>$auth_code,
            "sender_key"=>$TRAN_SENDER_KEY,
            "send_date"=>date("YmdHis"),
            "callback_number"=>$callback,
            "nation_phone_number"=>"82",
            "phone_number"=>$phone,
            "template_code"=>$template_code,
            "message"=>stripslashes($msg),
            "tran_type"=>"L",
            "tran_message"=>$msg,
            "add_etc1"=>$etc1
        );
        $data = json_encode($data);
        
        $url = "https://api.mtsco.co.kr";
        $url .= "/sndng/atk/sendMessage";
        
        $ch = curl_init();                                 //curl 초기화
        curl_setopt($ch,CURLOPT_URL, $url);               //URL 지정하기
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $data);       //POST data
        curl_setopt($ch,CURLOPT_POST, true);              //true시 post 전송
        curl_setopt($ch,CURLOPT_HTTPHEADER, array("Accept: application/json","Content-Type: application/json"));
        $response = curl_exec($ch);
        
        curl_close($ch);
        
        $response = json_decode($response);
        if ($response->code != "0000") $result_code = $response->code;
        
        $report_date = $response->received_at;
        $result_date = $response->received_at;
        
        $query = "INSERT INTO MTS_MMS_MSG(TRAN_PHONE,TRAN_CALLBACK,TRAN_MSG,TRAN_DATE, TRAN_TYPE, TRAN_ETC1, TRAN_REPORTDATE, TRAN_RSLTDATE, TRAN_RSLT)
                  VALUES ('$phone','$callback','$msg',now(), 4,'$etc1', '$report_date', '$result_date', '$result_code')";
        if ($response->code != "0000") $result = mysqli_query($connect, $query);
        $result = $response->code;
        
        if ($result) return "Y";
        else if ($result == "0000") return "Y";
        else return "N2";
        
    }else{
        return "N1";
    }
}

// 문자메시지 발송함수
function mts_mms_send4SimpleAsk($phone, $msg, $callback, $template_code="hrd01") {
    global $connect;
    global $auth_code;
    global $TRAN_SENDER_KEY;
    
    if ($phone)  {
        // 발신번호 /로 여러개 들어가 있는 경우 수정.
        $callback_arr = explode("/",$callback);
        $callback = trim($callback_arr[0]);
        
        $data=array(
            "auth_code"=>$auth_code,
            "sender_key"=>$TRAN_SENDER_KEY,
            "send_date"=>date("YmdHis"),
            "callback_number"=>$callback,
            "nation_phone_number"=>"82",
            "phone_number"=>$phone,
            "template_code"=>$template_code,
            "message"=>stripslashes($msg),
            "tran_type"=>"L",
            "tran_message"=>$msg,
        );
        $data = json_encode($data);
        
        $url = "https://api.mtsco.co.kr";
        $url .= "/sndng/atk/sendMessage";
        
        $ch = curl_init();                                 //curl 초기화
        curl_setopt($ch,CURLOPT_URL, $url);               //URL 지정하기
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch,CURLOPT_POSTFIELDS, $data);       //POST data
        curl_setopt($ch,CURLOPT_POST, true);              //true시 post 전송
        curl_setopt($ch,CURLOPT_HTTPHEADER, array("Accept: application/json","Content-Type: application/json"));
        $response = curl_exec($ch);
        
        curl_close($ch);
        
        $response = json_decode($response);
        if ($response->code != "0000") {
            $result_code = $response->code;
        }
        $result = $response->code;
        
        if ($result) {
            return "Y";
        } else if ($result == "0000") {
            return "Y";
        } else {
            return "N2";
        }
    }else{
        return "N1";
    }
}

function hrdtalk($type, $phone_number, $vars, $template_code) {
    global $connect;
    
    if(empty($phone_number)) {
        return "N1";
    }
    if(empty($template_code)) {
        return "N1";
    }
    
    $sql = "SELECT Massage FROM SendMessage WHERE TemplateCode='".$template_code."' LIMIT 1";
    $result = mysqli_query($connect, $sql);
    $row = mysqli_fetch_array($result);
    
    $TRAN_ORI = $row['Massage'];
    $TRAN_MSG = $TRAN_ORI;
    $TRAN_TMPL_CD = $template_code;
    
    foreach($vars as $key => $val) {
        $TRAN_MSG = str_replace("#{".$key."}",$val, $TRAN_MSG);
    }
    
    // Brad : 알림톡 발신프로필키, 발신번호, 수신번호, MMS 문자제목, 전화타입 설정
    //$TRAN_SENDER_KEY : 교육원 고유정보 DB에 저장됨.
    //$TRAN_CALLBACK : 교육원 고유정보 DB에 저장됨.
    $TRAN_PHONE = $phone_number; //수신번호
    //$TRAN_SUBJECT  : 교육원 고유정보 DB에 저장됨.
    $TRAN_REPLACE_TYPE = "L"; //전환전송 타입 'S', 'L', 'N'  'S' : SMS 전환전송 'L' : LMS 전환전송 'N' : 전환전송 하지않음
    //-------------------------------------------------------------------------
    
    $query = "INSERT INTO MTS_ATALK_MSG (
        TRAN_SENDER_KEY,
        TRAN_TMPL_CD,
        TRAN_CALLBACK,
        TRAN_PHONE,
        TRAN_SUBJECT,
        TRAN_MSG,
        TRAN_DATE,
        TRAN_TYPE,
        TRAN_STATUS,
        TRAN_REPLACE_TYPE,
        TRAN_REPLACE_MSG
    ) VALUES (
        '$TRAN_SENDER_KEY',
        '$TRAN_TMPL_CD',
        '$TRAN_CALLBACK',
        '$TRAN_PHONE',
        '$TRAN_SUBJECT',
        '$TRAN_MSG',
         NOW(),
         5,
        '1',
        '$TRAN_REPLACE_TYPE',
        '$TRAN_ORI'
    )";
    echo $query;
    $result = mysqli_query($connect, $query);
    
    if($result) {
        return "Y";
    } else {
        return "N2";
    }
}

function kakaotalk_send($msg_type,$msg_mobile,$msg_var,$send_date) {
    global $connect;
    global $kakaotalk_array;
    global $TRAN_CALLBACK2;
    
    if($msg_mobile) {
        $msg_var_arrary = explode("|",$msg_var);
        
        $kakaotalk_template = $kakaotalk_array[$msg_type];
        $kakaotalk_template_arrary = explode("|",$kakaotalk_template);
        $TRAN_TMPL_CD = $kakaotalk_template_arrary[0];
        
        switch ($msg_type) {
            case "mtm": // 1:1 문의 답변 등록 알림
                $TRAN_MSG = $kakaotalk_template_arrary[1];
                break;
            case "cronAuth": // 본인인증 알림 : 개강 다음날에 발송
                $TRAN_MSG = str_replace("#{이름}",$msg_var_arrary[0],$kakaotalk_template_arrary[1]);
                $TRAN_MSG = str_replace("#{날짜}",$msg_var_arrary[1],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{인증URL}",$msg_var_arrary[2],$TRAN_MSG);
                break;
            case "cronStart1": // 학습시작(개강알림) :비환급, 개강 당일 발송
                $TRAN_MSG = str_replace("#{회사명}",$msg_var_arrary[0],$TemplateMessage);
                $TRAN_MSG = str_replace("#{소속업체명}",$msg_var_arrary[1],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{시작일}",$msg_var_arrary[2],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{도메인}",$msg_var_arrary[3],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{아이디}",$msg_var_arrary[4],$TRAN_MSG);
                break;
            case "cronStart2": // 학습시작(개강알림) :환급, 개강 당일 발송
                $TRAN_MSG = str_replace("#{회사명}",$msg_var_arrary[0],$kakaotalk_template_arrary[1]);
                $TRAN_MSG = str_replace("#{소속업체명}",$msg_var_arrary[1],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{시작일}",$msg_var_arrary[2],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{도메인}",$msg_var_arrary[3],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{아이디}",$msg_var_arrary[4],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{날짜}",$msg_var_arrary[5],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{인증URL}",$msg_var_arrary[6],$TRAN_MSG);
                break;
        }
        
        //$TRAN_SENDER_KEY : 교육원 고유정보 DB에 저장됨.
        //$TRAN_CALLBACK2  : 교육원 고유정보 DB에 저장됨.
        $TRAN_PHONE = $msg_mobile; //수신번호
        //$TRAN_SUBJECT   : 교육원 고유정보 DB에 저장됨.
        $TRAN_REPLACE_TYPE = "L"; //전환전송 타입 'S', 'L', 'N'  'S' : SMS 전환전송 'L' : LMS 전환전송 'N' : 전환전송 하지않음
        
        $maxno = max_number("idx","SmsSendLog");
        $etc1 = $maxno;
        
        $send = mts_mms_send($TRAN_PHONE, $TRAN_MSG, $TRAN_CALLBACK2, $etc1, $TRAN_TMPL_CD);
        
        if($send=="Y") {
            $code = "0000";
            return $send;
        }else{
            $code = "0001";
            return "N2";
        }
    }else{
        return "N1";
    }
}

function kakaotalk_send_before01($msg_type,$msg_mobile,$msg_var,$send_date) {
    global $connect;
    global $kakaotalk_array;
    global $TRAN_CALLBACK2;
    
    if($msg_mobile) {
        $TRAN_TMPL_CD = $msg_type;
        $TRAN_MSG =$msg_var;
        //$TRAN_SENDER_KEY  : 교육원 고유정보 DB에 저장됨.
        //$TRAN_CALLBACK2 : 교육원 고유정보 DB에 저장됨.
        $TRAN_PHONE = $msg_mobile; //수신번호
        //$TRAN_SUBJECT : 교육원 고유정보 DB에 저장됨.
        $TRAN_REPLACE_TYPE = "L"; //전환전송 타입 'S', 'L', 'N'  'S' : SMS 전환전송 'L' : LMS 전환전송 'N' : 전환전송 하지않음
        
        $maxno = max_number("idx","SmsSendLog");
        $etc1 = $maxno;
        
        $send = mts_mms_send($TRAN_PHONE, $TRAN_MSG, $TRAN_CALLBACK2, $etc1, $TRAN_TMPL_CD);
        
        if($send=="Y") {
            $code = "0000";
            return $send;
        }else{
            $code = "0001";
            return "N2";
        }
    }else{
        return "N1";
    }
}

function kakaotalk_send2($msg_type,$msg_mobile,$msg_var,$send_date) {
    global $connect;
    global $kakaotalk_array;
    global $TRAN_SENDER_KEY;
    global $TRAN_CALLBACK2;
    global $TRAN_SUBJECT;
    
    if($msg_mobile) {
        $TRAN_TMPL_CD = $msg_type;
        $TRAN_MSG =$msg_var;
        //$TRAN_SENDER_KEY  : 교육원 고유정보 DB에 저장됨.
        //$TRAN_CALLBACK2 : 교육원 고유정보 DB에 저장됨.
        $TRAN_PHONE = $msg_mobile; //수신번호
        //$TRAN_SUBJECT : 교육원 고유정보 DB에 저장됨.
        $TRAN_REPLACE_TYPE = "L"; //전환전송 타입 'S', 'L', 'N'  'S' : SMS 전환전송 'L' : LMS 전환전송 'N' : 전환전송 하지않음
        
        $query = "INSERT INTO MTS_ATALK_MSG(TRAN_SENDER_KEY,TRAN_TMPL_CD,TRAN_CALLBACK,TRAN_PHONE,
                    TRAN_SUBJECT,TRAN_MSG,TRAN_DATE,TRAN_TYPE,TRAN_STATUS,TRAN_REPLACE_TYPE,TRAN_REPLACE_MSG) VALUES(
                    '$TRAN_SENDER_KEY',
                    '$TRAN_TMPL_CD',
                    '$TRAN_CALLBACK2',
                    '$TRAN_PHONE',
                    '$TRAN_SUBJECT',
                    '$TRAN_MSG',
                    '$send_date',
                    5,
                    '1',
                    '$TRAN_REPLACE_TYPE',
                    '$TRAN_MSG'
                    )";
        
        $result = mysqli_query($connect, $query);
        
        if($result) {
            return "Y";
        }else{
            return "N2";
        }
    }else{
        return "N1";
    }
}

function kakaotalk_send3($msg_type,$msg_mobile,$msg_var,$user_id,$input_id) {
    global $connect;
    global $kakaotalk_array;
    global $TRAN_CALLBACK2;
    
    if($msg_mobile) {
        $Sql = "SELECT * FROM SendMessage WHERE MessageMode='$msg_type'";
        $Result = mysqli_query($connect, $Sql);
        $Row = mysqli_fetch_array($Result);
        if($Row) {
            $Message = $Row['Massage'];
            $TemplateCode 	= $Row['TemplateCode'];
            $TemplateMessage 	= $Row['TemplateMessage'];
            
            $TRAN_TMPL_CD = $TemplateCode;
            $UserID = $user_id;
            $InputID = $input_id;
            $msg_var_arrary = explode("|",$msg_var);
            
            if($msg_type == 'before01'){
                $study_seq = $msg_var_arrary[0];
                $TRAN_MSG = str_replace("#{이름}",$msg_var_arrary[1],$TemplateMessage);
                $TRAN_MSG = str_replace("#{소속업체명}",$msg_var_arrary[2],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{도메인}",$msg_var_arrary[3],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{아이디}",$msg_var_arrary[4],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{과정명}",$msg_var_arrary[5],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{시작}",$msg_var_arrary[6],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{종료}",$msg_var_arrary[7],$TRAN_MSG);
                $TRAN_MSG = str_replace("#{회사명}",$SiteName,$TRAN_MSG);
            }else if($msg_type == 'find_id'){
                $TRAN_MSG = str_replace("#{이름}",$msg_var_arrary[0],$TemplateMessage);
                $TRAN_MSG = str_replace("#{아이디}",$msg_var_arrary[1],$TRAN_MSG);
            }else if($msg_type == 'new_password'){
                $TRAN_MSG = str_replace("#{이름}",$msg_var_arrary[0],$TemplateMessage);
                $TRAN_MSG = str_replace("#{임시비밀번호}",$msg_var_arrary[1],$TRAN_MSG);
            }else{
                $TRAN_MSG = $TemplateMessage;
            }
            
            //$TRAN_CALLBACK2 : 교육원 고유정보 DB에 저장됨.
            $TRAN_PHONE = $msg_mobile; //수신번호
            
            //발송 로그 기록
            $maxno = max_number("idx","SmsSendLog");
            $etc1 = $maxno;
            if($study_seq){
                $Sql = "INSERT INTO SmsSendLog(idx, ID, Study_Seq, Massage, Code, Mobile, InputID, RegDate) VALUES($maxno, '$UserID', $study_seq, '$TRAN_MSG', '', '$msg_mobile', '$InputID', NOW())";
            }else{
                $Sql = "INSERT INTO SmsSendLog(idx, ID, Study_Seq, Massage, Code, Mobile, InputID, RegDate) VALUES($maxno, '$UserID', 0, '$TRAN_MSG', '', '$msg_mobile', '$InputID', NOW())";
            }
            $Row = mysqli_query($connect, $Sql);
            $send = mts_mms_send($TRAN_PHONE, $TRAN_MSG, $TRAN_CALLBACK2, $etc1, $TRAN_TMPL_CD);
            
            if($send=="Y"){
                $code = "0000";
            }else{
                $code = "0001";
            }
            
            $Sql2 = "UPDATE SmsSendLog SET Code='$code' WHERE idx=$maxno";
            $Row2 = mysqli_query($connect, $Sql2);
            
            if($send=="Y") {
                return "Y";
            }else{
                return "N2";
            }
        }else{
            return "N3";
        }
    }else{
        return "N1";
    }
}

//근로자훈련과정 발송
function Work_kakaotalk_send($msg_type,$msg_mobile,$msg_var,$send_date) {
    global $connect;
    global $Work_kakaotalk_array;
    global $TRAN_SENDER_KEY;
    global $TRAN_CALLBACK;
    global $TRAN_SUBJECT;
    
    if($msg_mobile) {
        $msg_var_arrary = explode("|",$msg_var);
        
        $kakaotalk_template = $Work_kakaotalk_array[$msg_type];
        $kakaotalk_template_arrary = explode("|",$kakaotalk_template);
        $TRAN_TMPL_CD = $kakaotalk_template_arrary[0];
        
        switch ($msg_type) {
            case "cronStart1": // ▶ 학습시작 : 개강당일
                $TRAN_MSG = str_replace("#{회사명}",$msg_var_arrary[0],$kakaotalk_template_arrary[1]);
                $TRAN_MSG = str_replace("#{도메인}",$msg_var_arrary[1],$TRAN_MSG);
                break;
            case "cronStart2": // ▶ 학습시작 : 개강당일
                $TRAN_MSG = str_replace("#{회사명}",$msg_var_arrary[0],$kakaotalk_template_arrary[1]);
                break;
            case "cronProgress00": // ▶ 0% 미만 : 개강 후 7일차
                $TRAN_MSG = str_replace("#{회사명}",$msg_var_arrary[0],$kakaotalk_template_arrary[1]);
                $TRAN_MSG = str_replace("#{도메인}",$msg_var_arrary[1],$TRAN_MSG);
                break;
            case "cronProgress30": // ▶ 30% 미만 : 개강 후 14일차
                $TRAN_MSG = str_replace("#{회사명}",$msg_var_arrary[0],$kakaotalk_template_arrary[1]);
                break;
            case "cronProgress50": // ▶ 50% 미만 : 개강 후 28일차
                $TRAN_MSG = str_replace("#{회사명}",$msg_var_arrary[0],$kakaotalk_template_arrary[1]);
                break;
            case "cronProgress80": // ▶ 80% 미만 : 개강 후 42일차
                $TRAN_MSG = str_replace("#{회사명}",$msg_var_arrary[0],$kakaotalk_template_arrary[1]);
                break;
            case "cronProgressLast": // ▶ 최종독려 : 개강 후 43일차 80%이상 수강한 학습자에게만 발송
                $TRAN_MSG = str_replace("#{회사명}",$msg_var_arrary[0],$kakaotalk_template_arrary[1]);
                break;
            case "cronProgressEnd": // ▶ 수강종료 : 60일차 ( 종강 당일 )
                $TRAN_MSG = str_replace("#{회사명}",$msg_var_arrary[0],$kakaotalk_template_arrary[1]);
                break;
        }
        //$TRAN_SENDER_KEY : 교육원 고유정보 DB에 저장됨.
        //$TRAN_CALLBACK  : 교육원 고유정보 DB에 저장됨.
        $TRAN_PHONE = $msg_mobile; //수신번호
        //$TRAN_SUBJECT   : 교육원 고유정보 DB에 저장됨.
        $TRAN_REPLACE_TYPE = "L"; //전환전송 타입 'S', 'L', 'N'  'S' : SMS 전환전송 'L' : LMS 전환전송 'N' : 전환전송 하지않음
        
        $query = "INSERT INTO MTS_ATALK_MSG(TRAN_SENDER_KEY,TRAN_TMPL_CD,TRAN_CALLBACK,TRAN_PHONE,
                    TRAN_SUBJECT,TRAN_MSG,TRAN_DATE,TRAN_TYPE,TRAN_STATUS,TRAN_REPLACE_TYPE,TRAN_REPLACE_MSG) VALUES(
                    '$TRAN_SENDER_KEY',
                    '$TRAN_TMPL_CD',
                    '$TRAN_CALLBACK',
                    '$TRAN_PHONE',
                    '$TRAN_SUBJECT',
                    '$TRAN_MSG',
                    '$send_date',
                    5,
                    '1',
                    '$TRAN_REPLACE_TYPE',
                    '$TRAN_MSG'
                    )";
        $result = mysqli_query($connect, $query);
        
        if($result) {
            return "Y";
        }else{
            return "N2";
        }
    }else{
        return "N1";
    }
}
?>
