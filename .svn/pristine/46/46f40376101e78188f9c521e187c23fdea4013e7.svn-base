<?
##############################################
# 코드 관리
##############################################

$Menu01ParentCategory = 1;
$Menu02ParentCategory = 3;
$Menu03ParentCategory = 4;

$pg = "";
$col = "";
$sw = "";
$StartDate = "";
$EndDate = "";
$orderby = "";
$FaqCate = "";
$Gubun = "";
$idx = "";
$ExamType = "";
$ServiceType = "";
$ParentCategory = "";
$Category = "";

//파라미터값 받기
$params = array_merge($_POST, $_GET, $_COOKIE,$_SESSION);
foreach($params as $key => $value) {
    global ${$key};
    ${$key} = $value;
}

$CategoryType_array = array(
    "A" => "사업자 과정",
    "B" => "근로자 과정"
);

//FLEX - 선택항목
$ContentsFlex_array = array(
    "1" => "관심분야",
    "2" => "직급",
    "3" => "직무분야"
);
reset($ContentsFlex_array);

//FLEX - 컨텐츠리스트
$ContentsFlex_array2 = array(
    "1" => "HRDe's PICK 추천컨텐츠",
    "2" => "오늘의 TOP10 인기컨텐츠",
    "3" => "NEW 신규컨텐츠"
);
reset($ContentsFlex_array2);

//내일배움카드 - 신청유형
$ApplyType_array = array(
    "A" => "국민내일배움카드(재직자)",
    "B" => "일반(수시)",
    "C" => "고용보험환급",
    "D" => "평생교육바우처"
);
reset($ApplyType_array);

//내일배움카드 - 지원유형
$SupportType_array = array(
    "A" => "재직자 일반"
);
reset($SupportType_array);

//내일배움카드 - 결제방법
$Payment_array = array(
    "A" => "카드",
    "B" => "무통장",
    "C" => "가상계좌"
);
reset($Payment_array);

//내일배움카드 - 컨텐츠 대분류
$ContentsCategory1_array = array(
    "1" => "국민내일배움카드",
    "2" => "평생교육바우처",
    "3" => "직무스킬업"
);
reset($ContentsCategory1_array);

//내일배움카드 - 컨텐츠 중분류
$ContentsCategory2_array = array(
    "1" => "NSC직업교육",
    "2" => "일반사무직",
    "3" => "IT∙4차산업",
    "4" => "병원"
);
reset($ContentsCategory2_array);

//내일배움카드 - 과정 대분류("직무스킬업") 세부 분류
$ContentsCategory3_array = array(
    "1" => "NSC직업교육",
    "2" => "직무핵심스킬",
    "3" => "OA달인",
    "4" => "자격증"
);
reset($ContentsCategory3_array);

//환불사유
$Cancel_array = array(
    "A" => "수강 날짜를 잘못 신청하여서",
    "B" => "과정을 잘못 신청하여서",
    "C" => "잔액이 남아 있지 않아서",
    "D" => "기타"
);
reset($Cancel_array);

$Gender_array = array(
    "M" => "남성",
    "F" => "여성"
);
reset($Gender_array);

$UseYN_array = array(
    "Y" => "사용",
    "N" => "미사용"
);
reset($UseYN_array);

$Faq_array = array(
    "A" => "국민내일배움카드",
    "B" => "평생교육바우처",
    "C" => "학습장애",
    "D" => "증명서 발급",
    "E" => "사업주훈련"
);
reset($Faq_array);

$Faq_cyber_array = array(
    "A" => "국민내일배움카드",
    "B" => "평생교육바우처",
    "C" => "학습장애",
    "D" => "증명서 발급",
    "E" => "사업주훈련"
);
reset($Faq_cyber_array);

$Inquiry_type_array = array(
    "1" => "무료체험 문의",
    "2" => "시스템 도입 문의"
);
reset($Inquiry_type_array);

$Counsel_array = array(
    "A" => "학습 내용 문의",
    "B" => "시스템 문의",
    "C" => "이의 제기",
    "D" => "수강 관련 문의",
    "E" => "결제 관련 문의"
);
reset($Counsel_array);

$CounselPhone_array = array(
    "A" => "학습 문의",
    "B" => "시스템 문의",
    "C" => "기타 문의"
);
reset($CounselPhone_array);

$CounselStatus_array = array(
    "A" => "대기",
    "B" => "완료"
);
reset($CounselStatus_array);

$CounselPhoneStatus_array = array(
    "A" => "처리중",
    "B" => "처리완료"
);
reset($CounselPhoneStatus_array);

$SimpleAskStatus_array = array(
    "A" => "접수",
    "B" => "처리중",
    "C" => "처리완료"
);
reset($SimpleAskStatus_array);

$Edudata_array = array(
    "A" => "경영·사무",
    "B" => "보건·의료",
    "C" => "보육",
    "D" => "4차 산업",
    "E" => "법정의무·기타"
);
reset($Edudata_array);

$CompanyScale_array = array(
    "C" => "우선지원대상",
    "A" => "대규모 1000인 이상",
    "B" => "대규모 1000인 미만"
);
reset($CompanyScale_array);

$CyberEnabled_array = array(
    "Y" => "사용",
    "N" => "사용안함"
);
reset($CyberEnabled_array);

$Bank_array = array(
    "국민은행" => "국민은행",
    "농협" => "농협",
    "우리은행" => "우리은행",
    "SC은행" => "SC은행",
    "기업은행" => "기업은행",
    "하나은행" => "하나은행",
    "수협중앙회" => "수협중앙회",
    "신한은행" => "신한은행",
    "한국씨티은행" => "한국씨티은행",
    "대구은행" => "대구은행",
    "부산은행" => "부산은행",
    "광주은행" => "광주은행",
    "제주은행" => "제주은행",
    "전북은행" => "전북은행",
    "경남은행" => "경남은행",
    "우체국" => "우체국",
    "새마을금고" => "새마을금고",
    "신협" => "신협",
    "KDB산업은행" => "KDB산업은행",
    "카카오뱅크" => "카카오뱅크"
);
reset($Bank_array);

$Card_array = array(
    "11" => "국민",
    "15" => "카카오뱅크",
    "21" => "하나(외환)",
    "30" => "KDB산업체크",
    "31" => "비씨",
    "32" => "하나",
    "33" => "우리(구.평화VISA)",
    "34" => "수협",
    "35" => "전북",
    "36" => "씨티",
    "37" => "우체국체크",
    "38" => "MG새마을금고체크",
    "39" => "저축은행체크",
    "41" => "신한(구.LG카드 포함)",
    "42" => "제주",
    "46" => "광주",
    "51" => "삼성",
    "61" => "현대",
    "62" => "신협체크",
    "71" => "롯데",
    "91" => "NH",
    "3C" => "중국은련",
    "4J" => "해외JCB",
    "4V" => "해외VISA",
    "4M" => "해외MASTER",
    "6D" => "해외DINERS",
    "6I" => "해외DISCOVER"
);
reset($Card_array);

$ContentsType_array = array(
    "E" => "강의 시작",
    "F" => "강사 소개",
    "A" => "Flash 강의",
    "B" => "mp4 영상강의",
    "C" => "문제풀이 객관식",
    "D" => "문제풀이 주관식",
    "G" => "강의 종료"
);
reset($ContentsType_array);

$ExamType_array = array(
    "A" => "객관식",
    "B" => "단답형",
    "C" => "서술형"
);
reset($ExamType_array);

$PollType_array = array(
    "A" => "객관식",
    "B" => "주관식"
);
reset($PollType_array);

$ClassGrade_array = array(
    "A" => "A등급",
    "B" => "B등급",
    "C" => "C등급"
);
reset($ClassGrade_array);

$ServiceTypeCourse_array = array(
    "1" => "환급",
    "3" => "일반(비환급)",
    "4" => "근로자훈련",
    "5" => "비환급(평가있음)"
);
reset($ServiceTypeCourse_array);

$ServiceTypeCourse2_array = array(
    "4" => "근로자훈련"
);
reset($ServiceTypeCourse2_array);

$ServiceType_array = array(
    "1" => "사업주지원(환급)",
    "3" => "일반(비환급)",
    "5" => "비환급(평가있음)",
    "9" => "테스트용",
    "4" => "근로자훈련"
);
reset($ServiceType_array);

$ServiceType1_array = array(
    "1" => "사업주지원(환급)",
    "3" => "일반(비환급)",
    "5" => "비환급(평가있음)",
    "9" => "테스트용"
);
reset($ServiceType1_array);

$ServiceType2_array = array(
    "4" => "근로자훈련"
);
reset($ServiceType2_array);

//ExcelServiceType 추가
$ServiceType3_array = array(
    "1" => "사업주지원(환급)",
    "3" => "일반(비환급)",
    "5" => "비환급(평가있음)"
);
reset($ServiceType3_array);

//ExcelQuaterType 추가
$QuaterType_array = array(
    "1" => "1분기",
    "2" => "2분기",
    "3" => "3분기",
    "4" => "4분기"
);
reset($QuaterType_array);

//ExcelUptae 추가
$UptaeType_array = array(
    "A" => "기타사업분야",
    "B" => "보건업",
    "C" => "제조업",
    "D" => "서비스업",
    "E" => "유통업",
    "F" => "건설업"
);
reset($UptaeType_array);

//ExcelJobType 추가
$JobType_array = array(
    "A" => "현장직",
    "B" => "사무직",
    "C" => "관리감독자",
    "D" => "신규입사자"
);
reset($JobType_array);

$CompleteTime_array = array(
    "1" => "1분",
    "5" => "5분",
    "10" => "10분",
    "13" => "13분",
    "15" => "15분",
    "20" => "20분",
    "25" => "25분",
    "30" => "30분",
    "35" => "35분",
    "40" => "40분",
    "45" => "45분",
    "50" => "50분",
    "55" => "55분",
    "60" => "60분"
);
reset($CompleteTime_array);

$ProgressCheck_array = array(
    "timeCheck" => "시간",
    "pageCheck" => "페이지"
);
reset($ProgressCheck_array);

$ChapterType_array = array(
    "A" => "강의 차시",
    "B" => "중간평가",
    "C" => "최종평가",
    "D" => "과제",
    "E" => "토론방"
);
reset($ChapterType_array);

$LectureRequestStatus_array = array(
    "A" => "승인대기",
    "B" => "승인완료",
    //"C" => "결제취소",
    "D" => "환불완료"
);
reset($LectureRequestStatus_array);

$LectureRequestStatus2_array = array(
    "A" => "승인대기",
    "B" => "승인완료",
    "C" => "결제취소",
    "D" => "환불완료"
);
reset($LectureRequestStatus2_array);

$LectureRequestStatusA_array = array(
    "A" => "승인대기",
    "B" => "승인완료",
    "C" => "신청취소",
    "D" => "취소완료"
);
reset($LectureRequestStatusA_array);

$LectureRequestPayment_array = array(
    "A" => "카드",
    "B" => "무통장",
    "C" => "가상계좌"
);
reset($LectureRequestPayment_array);

$TRNEE_SE_array = array(
    "002" => "구직자",
    "003" => "채용예정자",
    "006" => "전직/이직예정자",
    "007" => "자사근로자",
    "008" => "타사근로자",
    "013" => "일용근로자",
    "983" => "취득예정자(일용포함)",
    "984" => "고용유지훈련",
    "985" => "적용제외근로자"
);
reset($TRNEE_SE_array);

$IRGLBR_SE_array = array(
    "000" => "비정규직해당없음",
    "012" => "파견근로자",
    "013" => "일용근로자",
    "014" => "기간제근로자",
    "020" => "단기간근로자",
    "021" => "무급휴업/휴직자",
    "022" => "임의가입자영업자",
    "987" => "분류불능"
);
reset($IRGLBR_SE_array);

$CompanySMS_array = array(
    "Y" => "수신허용",
    "N" => "수신거부"
);
reset($CompanySMS_array);

$SMS_ReturnCode_array = array(
    "0000" => "전송성공",
    "0001" => "접속에러",
    "0002" => "인증에러",
    "0003" => "잔여콜수 없음",
    "0004" => "메시지 형식에러",
    "0005" => "콜백번호 에러",
    "0006" => "수신번호 개수 에러",
    "0007" => "예약시간 에러",
    "0008" => "잔여콜수 부족",
    "0009" => "전송실패",
    "0010" => "MMS NO IMG (이미지없음)",
    "0011" => "MMS ERROR TRANSFER (이미지전송오류)",
    "0012" => "메시지 길이오류(2000바이트초과)",
    "0030" => "CALLBACK AUTH FAIL (발신번호 사전등록 미등록)",
    "0033" => "CALLBACK TYPE FAIL (발신번호 형식에러)",
    "0080" => "발송제한",
    "6666" => "일시차단",
    "9999" => "요금미납"
);
reset($SMS_ReturnCode_array);

$Email_ReturnCode_array = array(
    "Y" => "수신",
    "N" => "발송"
);
reset($Email_ReturnCode_array);

$ChapterLimit_array = array(
    "Y" => "차시제한 적용",
    "N" => "차시제한 미적용"
);
reset($ChapterLimit_array);

//tok2 연계여부
$tok2_array = array(
    "Y" => "연계",
    "N" => "미연계"
);
reset($tok2_array);

//kakaotalk 템플릿 리스트
$kakaotalk_list_array = array(
    "mtm" => "1:1문의 답변 등록",
    "cronStart1" => "개강안내 비환급",
    "cronStart2" => "개강안내 환급",
    "cronAuth" => "본인인증 안내"
);
reset($kakaotalk_list_array);

//kakaotalk 템플릿
$kakaotalk_array = array(
    "mtm" => "hrd01|[HRDe평생교육원] 1:1문의 답변이 등록되었습니다. 확인 부탁드립니다. (나의강의실-상담신청내역)", //1:1 문의 답변 등록 알림
    
    "cronAuth" => "hrd01|#{이름} 수강생님! 안녕하세요? HRDe평생교육원입니다.
                    법정의무교육 담당기관인 노동부 교육방침에 따라 본인인증 절차가 강화 되었습니다.
                    수강을 위한 필수사항이니 바쁘시더라도 #{날짜}까지 꼭 본인인증을 하셔야 합니다.
                    본인인증 방법은 아래 링크를 클릭하시면 바로 인증되며 본인인증 이후 수강 할 수 있습니다.
                    미인증시는 수강이 불가합니다.
                    #{인증URL}", //오전9시 10분 cron 자동발송 - 개강 다음날에 발송
    
    "cronStart1" => "hrd01|안녕하세요. HRDe평생교육원입니다. 신청하신 교육에 대한 개강 안내를 드립니다.
    
                    [#{회사명}] #{소속업체명} 인터넷교육이 #{시작일} 시작되었습니다!
                        
                    접속 정보 : 학습사이트:#{도메인} 아이디:#{아이디} 초기비밀번호:1111
                        
                    (본 메세지는 #{소속업체명} 사업주께서 저희 교육기관에 인터넷교육을 신청하여 안내드리는 내용입니다.)", //오전9시 10분 cron 자동발송- 비환급, 개강 당일
    
    "cronStart2" => "hrd01|안녕하세요. HRDe평생교육원입니다. 신청하신 교육에 대한 개강 안내를 드립니다.
                    [#{회사명}] #{소속업체명} 인터넷교육이 #{시작일} 시작되었습니다!
                    접속 정보 : 학습사이트:#{도메인} 아이디:#{아이디} 초기비밀번호:1111
                        
                    또한 법정의무교육 담당기관인 노동부 교육방침에 따라 본인인증 절차가 강화 되었습니다.
                    수강을 위한 필수사항이니 바쁘시더라도 #{날짜}까지 꼭 본인인증을 하셔야 합니다.
                    본인인증 방법은 아래 링크를 클릭하시면 바로 인증되며 본인인증 이후 수강 할 수 있습니다.
                    미인증시는 수강이 불가합니다.
                    #{인증URL}
                        
                    (본 메세지는 #{소속업체명} 사업주께서 저희 교육기관에 인터넷교육을 신청하여 안내드리는 내용입니다.)" //오전9시 10분 cron 자동발송- 환급, 개강 당일
);
reset($kakaotalk_array);

//근로자훈련과정 kakaotalk 템플릿
$Work_kakaotalk_array = array(
    "cronStart1" => "hrd-01|[HRDe평생교육원] 근로자 환급과정 HRD 개강시작 / 강의수강사이트 http://hrd.ek3434.com 휴대폰 본인인증 필요!!", //오전10시 근로자훈련과정 개강 당일
    
    "cronStart2" => "hrd-02|[HRDe평생교육원] 근로자 환급과정 HRD 수업시작 / 1일 최대8주차 수강가능 / 수강 시 휴대폰 본인인증 필수!!", //근로자훈련과정 개강 당일
    
    "cronProgress00" => "hrd-03|[HRDe평생교육원] HRD 0%미만 수강 중 /  http://hrd.ek3434.com 로그인 후 기간 확인하시어 수강 부탁드립니다.", //근로자훈련과정 ▶ 0% 미만 : 개강 후 7일차
    
    "cronProgress30" => "hrd-04|[HRDe평생교육원]현재 진도율 HRD 30%미만 / 기간 확인하시어 수강 부탁드립니다.", //근로자훈련과정 ▶ 30% 미만 : 개강 후 14일차
    
    "cronProgress50" => "hrd-05|[HRDe평생교육원]현재 진도율 HRD 50%미만 / 기간 확인하시어 수강 부탁드립니다. / 전체 진도율 50%이상 시 중간평가 응시 가능합니다.", //근로자훈련과정 ▶ 50% 미만 : 개강 후 28일차
    
    "cronProgress80" => "hrd-06|[HRDe평생교육원]현재 진도율 HRD 80%미만 / 수강종료일 확인하시어 수강부탁드립니다.", //근로자훈련과정 ▶ 80% 미만 : 개강 후 42일차
    
    "cronProgressLast" => "hrd-07|[HRDe평생교육원]전체 진도율 80% 이상 / 최종평가 응시가능 / 수강종료일 확인 후 최종평가 및 강의 수강 부탁드립니다.", //근로자훈련과정 ▶ 최종독려 : 개강 후 43일차 80%이상 수강한 학습자에게만 발송
    
    "cronProgressEnd" => "hrd-09|[HRDe평생교육원] 금일 근로자 환급과정 HRD 수강이 종료되었습니다. 수고많으셨습니다. 감사합니다." //근로자훈련과정 ▶ 수강종료 : 60일차 ( 종강 당일 )
    
);
reset($Work_kakaotalk_array);

//관리자 메뉴 상단 권한별 링크
$Manager_Top_Link_array = array(
    //회원관리
    "A1" => "company.php", //사업주 관리
    "A2" => "member.php", //수강생 관리
    "A3" => "lecture_reg.php", //수강 등록
    "A4" => "member_out.php", //탈퇴회원 관리
    "A5" => "dept_category.php", //관리자/영업자/첨삭강사 카테고리
    "A6" => "staff01.php", //관리자 리스트
    "A7" => "staff02.php", //영업자 리스트
    "A8" => "staff03.php", //첨삭강사 리스트
    "A9" => "blacklist.php", //블랙리스트 리스트
    
    //수강관리
    "B1" => "discussion_list.php", //토론방
    "B2" => "study_ip.php", //IP모니터링
    
    //독려관리
    "C1" => "study_sms.php", //학습참여독려
    "C2" => "study_sms_log.php", //문자발송내역
    "C3" => "study_email_log.php", //메일발송내역
    //"C4" => "study_sms_setting.php", //독려내용 관리
    "C4" => "kakaotalk.php", //알림톡 발송내역
    "C5" => "kakaotalk_replace.php", //알림톡 전환전송 내역(LMS)
    "C6" => "study_sms_setting.php", //문자/템플릿관리
    
    //컨텐츠관리
    "D1" => "teacher.php", //강사 관리
    "D2" => "exam_bank.php", //문제은행 관리
    "D3" => "discussion_topic.php", //토론주제 관리
    "D4" => "course_category.php", //과정카테고리 관리
    "D5" => "contents.php", //기초차시 관리
    "D6" => "poll_bank.php", //설문 관리
    
    //사업주훈련
    "E1" => "course.php?ctype=A", //단과컨텐츠관리
    "E2" => "course_package.php", //패키지컨텐츠관리
    "E3" => "lecture_request.php", //학습신청
    "E4" => "study.php", //학습관리
    "E5" => "study_correct.php", //첨삭관리
    "E6" => "practice.php", //실시관리
    "E7" => "study_end.php", //수강마감
    "E8" => "study_payment.php", //결제관리
    
    //내일배움카드
    "F1" => "course_cyber.php", //단과컨텐츠관리
    "F2" => "contents_keyword.php", //컨텐츠키워드관리
    "F3" => "cyber_contents.php?ctype=A", //BEST컨텐츠관리
    "F4" => "cyber_contents.php?ctype=B", //NEW컨텐츠관리
    "F5" => "lecture_request2.php", //학습신청
    "F6" => "study2.php", //학습관리
    "F7" => "study_correct2.php", //첨삭관리
    "F8" => "study_end2.php", //수강마감
    "F9" => "study2_payment.php", //결제관리
    
    //FLEX
    "G1" => "course_flex.php", //컨텐츠관리
    "G2" => "course_felx_category.php", //카테고리관리
    "G3" => "contents_flex_keyword.php", //컨텐츠키워드관리
    "G4" => "flex_contents.php", //PICK/TOP/NEW 컨텐츠 관리
    "G5" => "flex_like.php", //관심강의관리
    
    //커뮤니티관리
    "H1" => "notice.php", //공지사항
    "H2" => "faq.php", //자주묻는질문
    "H3" => "qna.php", //1:1상담/학습상담
    "H4" => "after.php", //수강후기
    "H5" => "edudata.php", //학습자료실
    "H6" => "simple_ask.php", //간편문의
    "H7" => "flex_inquiry.php", //FLEX 문의
    
    //통계관리
    "I1" => "sta.php", //접속통계관리
    "I2" => "sale_sta.php", //영업통계관리(사업주)
    
    //사이트관리
    "J1" => "popup.php", //팝업 관리
    "J2" => "main_course_list.php", //메인디자인 관리
    //"J3" => "work_request.php", //작업 요청 게시판
    "J4" => "site_info.php", //사이트 정보 관리
    
    
    "X" => "" //
);
reset($Manager_Top_Link_array);
?>
