<?
include "../include/include_function.php"; //DB연결 및 각종 함수 정의

$CompanyName = Replace_Check($CompanyName); //사업주명

//분기선택값
$Schedule = Replace_Check($Schedule);
$schedule_array = explode('|',$Schedule); //배열화
$Schedule7 = Replace_Check($Schedule7);
$Schedule8 = Replace_Check($Schedule8);

//교육일
$LectureStart1 = Replace_Check($LectureStart1); //5대법정교육 시작일
$LectureEnd1 = Replace_Check($LectureEnd1); //5대법정교육 종료일
$LectureStart2 = Replace_Check($LectureStart2); //공공기관 일반기관 필수교육 시작일
$LectureEnd2 = Replace_Check($LectureEnd2); //공공기관 일반기관 필수교육 종료일
$LectureStart3 = Replace_Check($LectureStart3); //의료기관 법정교육 시작일
$LectureEnd3 = Replace_Check($LectureEnd3); //의료기관 법정교육 종료일
$LectureStart4 = Replace_Check($LectureStart4); //의료기관 인증 필수교육 시작일
$LectureEnd4 = Replace_Check($LectureEnd4); //의료기관 인증 필수교육 종료일
$LectureStart5 = Replace_Check($LectureStart5); //요양기관 법정교육 시작일
$LectureEnd5 = Replace_Check($LectureEnd5); //요양기관 법정교육 종료일
$LectureStart6 = Replace_Check($LectureStart6); //보육기관 법정교육 시작일
$LectureEnd6 = Replace_Check($LectureEnd6); //보육기관 법정교육 종료일
$LectureStart7 = Replace_Check($LectureStart7); //직무교육1 시작일
$LectureEnd7 = Replace_Check($LectureEnd7); //직무교육1 종료일
$LectureStart8 = Replace_Check($LectureStart8); //직무교육2 시작일
$LectureEnd8 = Replace_Check($LectureEnd8); //직무교육2 종료일

//교육과정
$lecture1_value = Replace_Check($lecture1_value); //5대법정교육
$lecture2_value = Replace_Check($lecture2_value); //공공기관 일반기관 필수교육
$lecture3_value = Replace_Check($lecture3_value); //의료기관 법정교육
$lecture4_value = Replace_Check($lecture4_value); //의료기관 인증 필수교육
$lecture5_value = Replace_Check($lecture5_value); //요양기관 법정교육
$lecture6_value = Replace_Check($lecture6_value); //보육기관 법정교육
$lecture7_value = Replace_Check($lecture7_value); //직무교육1
$lecture8_value = Replace_Check($lecture8_value); //직무교육2

//교육과정 배열화
$lecture1_array = explode('|',$lecture1_value);
$lecture2_array = explode('|',$lecture2_value);
$lecture3_array = explode('|',$lecture3_value);
$lecture4_array = explode('|',$lecture4_value);
$lecture5_array = explode('|',$lecture5_value);
$lecture6_array = explode('|',$lecture6_value);

$lecture_value = $lecture2_value.'|'.$lecture3_value.'|'.$lecture4_value.'|'.$lecture5_value.'|'.$lecture6_value;

$lecture1_replace = str_replace('|','","', $lecture1_value);
$lecture1_replace = '"'.$lecture1_replace.'"';

$lecture_replace = str_replace('|','","', $lecture_value);
$lecture_replace = '"'.$lecture_replace.'"';

$lecture_chk = str_replace('|','', $lecture_value);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko">
<HEAD>
<title><?=$SiteName?>_교육실시계획서_<?=$CompanyName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="./css/style2.css?v230918" type="text/css">
<link rel="stylesheet" type="text/css" href="./jquery-ui.css" />
<script type="text/javascript" src="./jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="./jquery-ui.js"></script>
<script> 
$(document).ready(function(){
	window.print();
});
</script>
<style>
* {font-family: sans-serif; }
@page{
  margin-top: 70px;
  margin-bottom: 70px;
}
body {-webkit-print-color-adjust: exact;}
</style>
</HEAD>
<BODY>
<div id="certi_print_wrap" class="certi_print_wrap" style="width:830px">
	<!-- 페이지 1====================================================================== -->
	<div style="page-break-after: always;">
		<div class="certi_print_info">
			<div class="infoArea">
				<div class="tableArea">
					<table>
						<tr>
    						<td width="12%">문서번호</td>
    						<td width="25%"></td>
    						<td rowspan="2" width="7%">결<br/>재</td>
    						<td width="12%">담당</td>
    						<td width="12%"></td>
    						<td width="12%"></td>
						</tr>
						<tr>
    						<td>접수일자</td>
    						<td><?=date("Y-m-d");?></td>
    						<td><?=$LoginAdminName?></td>
    						<td></td>
    						<td></td>
						</tr>
					</table>
				</div>

				<div class="tableArea" style="margin-top:50px">
					<table style="border:0px">
						<tr>
							<td style="font-size:34px; font-weight:bold; border:1px #000 dashed; border-left:0px; border-right:5px #5D5D5D solid;  border-bottom:5px #5D5D5D solid; ">교육실시계획서</td>
						</tr>
					</table>
				</div>
				<div class="tableArea mainTitle02">
					<table>
						<tr>
    						<td>고객사</td>
    						<td colspan="3"><?=$CompanyName?></td>
						</tr>
						<?
						if($lecture1_value !== '' && $lecture1_value != 'undefined') $TOT1_NO = count($lecture1_array); else $TOT1_NO=0;
						if($lecture2_value !== '' && $lecture2_value != 'undefined') $TOT2_NO = 1; else $TOT2_NO=0;
						if($lecture3_value !== '' && $lecture3_value != 'undefined') $TOT3_NO = 1; else $TOT3_NO=0;
						if($lecture4_value !== '' && $lecture4_value != 'undefined') $TOT4_NO = 1; else $TOT4_NO=0;
						if($lecture5_value !== '' && $lecture5_value != 'undefined') $TOT5_NO = 1; else $TOT5_NO=0;
						if($lecture6_value !== '' && $lecture6_value != 'undefined') $TOT6_NO = 1; else $TOT6_NO=0;
						$TOT_NO = $TOT1_NO+$TOT2_NO+$TOT3_NO+$TOT4_NO+$TOT5_NO+$TOT6_NO;
						//echo $TOT_NO;
						
						//법정교육을 선택했을 경우
						if($TOT_NO>0){
						    //5대법정교육을 선택한 경우
						    if($TOT1_NO>0){
						?>
						<tr>
							<td rowspan="<?=$TOT_NO+1?>">교육과정</td>
							<td rowspan="<?=$TOT_NO?>">법정교육</td>
						<?
    						    $i=0;
        					    $SQLA = "SELECT Category1, ContentsName FROM Course WHERE LectureCode IN ($lecture1_replace)";
        					    //echo $SQLA;
        					    $QUERYA = mysqli_query($connect, $SQLA);
        					    if($QUERYA && mysqli_num_rows($QUERYA)){
        					        while($RowA = mysqli_fetch_array($QUERYA)){
        					            $Category1 = $RowA['Category1'];
        					            $ContentsName = $RowA['ContentsName'];
        					            if($i==0){
                        ?>
                            <td><?=$ContentsName?></td>
        					<td><input type="checkbox" checked onClick="return false"></td>
						<?
                                        }else{
                        ?>
						<tr>
    						<td><?=$ContentsName?></td>
        					<td><input type="checkbox" checked onClick="return false"></td>
    					</tr>
						<?
    						            }
    						            $i++;
    						        }
    						    }
    				    ?>
    				    <!-- 5대법정교육 이외 다른 법정교육인 경우 -->
    				    <?if($TOT2_NO>0){?>
    					<tr>
    						<td>공공기관 일반기관 필수교육</td>
        					<td><input type="checkbox" checked onClick="return false"></td>
    					</tr>
    					<?}?>
						<?if($TOT3_NO>0){?>
    					<tr>
    						<td>의료기관 법정교육</td>
        					<td><input type="checkbox" checked onClick="return false"></td>
    					</tr>
    					<?}?>
    					<?if($TOT4_NO>0){?>
    					<tr>
    						<td>의료기관 인증 필수교육</td>
        					<td><input type="checkbox" checked onClick="return false"></td>
    					</tr>
    					<?}?>
    					<?if($TOT5_NO>0){?>
    					<tr>
    						<td>요양기관 법정교육</td>
        					<td><input type="checkbox" checked onClick="return false"></td>
    					</tr>
    					<?}?>
    					<?if($TOT6_NO>0){?>
    					<tr>
    						<td>보육기관 법정교육</td>
        					<td><input type="checkbox" checked onClick="return false"></td>
    					</tr>
    					<?}?>
    				    </tr>
    				    <?
    				        //5대법정교육을 선택하지 않고 이외 다른 법정교육만 선택한 경우
						    }else{
						?>
						<tr>
							<td rowspan="<?=$TOT_NO+2?>">교육과정</td>
							<td rowspan="<?=$TOT_NO+1?>">법정교육</td>
							<td>5대법정교육</td>
        					<td><input type="checkbox" onClick="return false"></td>
						</tr>
						<?if($TOT2_NO>0){?>
    					<tr>
    						<td>공공기관 일반기관 필수교육</td>
        					<td><input type="checkbox" checked onClick="return false"></td>
    					</tr>
    					<?}?>
						<?if($TOT3_NO>0){?>
    					<tr>
    						<td>의료기관 법정교육</td>
        					<td><input type="checkbox" checked onClick="return false"></td>
    					</tr>
    					<?}?>
    					<?if($TOT4_NO>0){?>
    					<tr>
    						<td>의료기관 인증 필수교육</td>
        					<td><input type="checkbox" checked onClick="return false"></td>
    					</tr>
    					<?}?>
    					<?if($TOT5_NO>0){?>
    					<tr>
    						<td>요양기관 법정교육</td>
        					<td><input type="checkbox" checked onClick="return false"></td>
    					</tr>
    					<?}?>
    					<?if($TOT6_NO>0){?>
    					<tr>
    						<td>보육기관 법정교육</td>
        					<td><input type="checkbox" checked onClick="return false"></td>
    					</tr>
    					<?}?>
						<?
						    }
						?>
						<?if($lecture7_value || $lecture8_value){?>
						<tr>
							<td colspan="2">직무능력향상교육</td>
							<td><input type="checkbox" <?if($lecture7_value || $lecture8_value){?> checked <?}?> onClick="return false"></td>
						</tr>
						<?
                            }
						
						//법정교육을 선택하지 않았을 경우
						}else{
						?>
						<?
                            if($lecture7_value || $lecture8_value){
                        ?>
						<tr>
							<td>교육과정</td>
							<td colspan="2">직무능력향상교육</td>
							<td><input type="checkbox" <?if($lecture7_value || $lecture8_value){?> checked <?}?> onClick="return false"></td>
						</tr>
						<?
                            }
						}
						?>
						<tr>
    						<td>교육기간</td>
    						<td colspan="3"><?=date("Y")?>년 연간 일정</td>
						</tr>
						<tr>
    						<td>작성자</td>
    						<td colspan=3><?=$LoginAdminDepart?> <?=$LoginAdminName?></td>
						</tr>
						<tr>
    						<td>작성일</td>
    						<td colspan=3><?=date("Y. m. d");?></td>
						</tr>
					</table>
				</div>

				<div class="tableArea" style="text-align:center; margin-top:120px">
					<table style="margin:0 auto; border:0; font-weight:bold;">
						<tr>
						<td style="border:0"></td>
						<td width="60" style="border:0"><img src="/images/logo_mark.png" align="absmiddle" width="55" height="55" /></td>
						<td style="border:0;text-align:left; width:220px;">
							<div style="font-size:19px;margin-bottom:5px;">고용노동부 인증</div>
							<div style="font-size:28px;"><?=$CertSiteName?></div>
						</td>
						<td width="96" style="border:0"><img src="/images/company_stamp.png" align="absmiddle" width="95" height="98" /></td>
						<td style="border:0"></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- 페이지 1====================================================================== -->
	
	<!-- 교육비안내 ==================================================================== -->
	<div style="page-break-after: always;">
		<div class="certi_print_info">
			<div class="infoArea">
				<div class="tableArea">
					<div style="text-align:left; font-size:20px; font-weight:bold; margin-bottom:10px;padding-bottom: 7px; border-bottom: 5px solid #0000FF;">0. 교육비 안내</div>				
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">0-1</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">교육 진행 전 사업주 계좌 등록 안내(직무교육 진행 시)</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<th width="20%">순서</th>
							<th>등록 방법</th
						</tr>
						<tr>
							<td>1</td>
							<td style="text-align: left;">
								고용 24 홈페이지 <a href="https://www.work24.go.kr" target="_blank">www.work24.go.kr</a> 접속<br>
								⇨ 기업회원으로 가입 (일반사업자 또는 사무대행기관 선택) ⇨ 로그인
							</td>
						</tr>
						<tr>
							<td>2</td>
							<td style="text-align: left;">
								<br><img src="/hrd_manager/images/image01.png"><br><br>
								상단 직업훈련 탭 클릭 후 HRD-NET 사이트로 접속
							</td>
						</tr>
						<tr>
							<td>3</td>
							<td style="text-align: left;">
								<br><img src="/hrd_manager/images/image02.png"><br><br>
								HRD-NET 홈페이지 ⇨ 사업주 훈련 ⇨ 사업주 계좌 순서로 클릭
							</td>
						</tr>
						<tr>
							<td>4</td>
							<td style="text-align: left;">
								<br><img src="/hrd_manager/images/image03.png"><br><br>
								목록에서 계좌 추가 버튼을 통해 계좌 등록<br>
								- 목록에 조회되는 계좌가 있는 경우 HRD에 기존에 등록해서 사용/확인된 계좌<br>
								- 은행명, 계좌번호, 예금주명 같은건 여러개 존재 가능(계좌식별번호 다른 경우 해당)<br>
							</td>
						</tr>
						<tr>
							<td>5</td>
							<td style="text-align: left;">
								위탁훈련비용 지급 계좌 선택<br>
								- 계좌 선택 ’Y’로 설정 후 계좌 선택 저장 (‘Y’ 설정은 한건만 가능)<br> 
                                - ‘Y’로 선택된 계좌: 위탁 훈련비 지급될 계좌								
							</td>
						</tr>
						<tr>
							<td rowspan="3">주의 사항</td>
							<td style="text-align: left;color:red;">산업인력공단에서 유효계좌 확인 후 사업장이 등록한 계좌로 비용 지급</td>
						</tr>
						<tr>
							<td style="text-align: left;color:red;">유효계좌가 아닐경우 비용지급 불가로 반려처리 가능</td>
						</tr>
						<tr>
							<td style="text-align: left;color:red;">비용신청 시 사업장의 통장사본 증빙이 필수이므로 훈련기관에 통장사본을 필히 제출하여야 함</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div style="page-break-after: always;">
		<div class="certi_print_info">
			<div class="infoArea">
				<div class="tableArea">
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">0-2</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">교육 진행 전 교육비 입금 안내</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<th width="20%">구분</th>
							<th>세부 내용</th>
						</tr>
						<tr>
							<td>입금명</td>
							<td><?=$CompanyName?></td>
						</tr>
						<tr>
							<td>입금액</td>
							<td>수료인원에 맞춰 전자계산서 발행 예정</td>
						</tr>
					</table>					
					<br>
					<span style="color:red;font-size: 13px;">*입금명은 해당 기업명과 일치해야합니다.</span><br>
                    <span style="color:red;font-size: 13px;">*교육이 끝난 후 계산서가 발행됩니다.</span><br>
                    <span style="color:red;font-size: 13px;">*계산서 확인 후 ‘주식회사 에이치알디이솔루션’ 계좌로 교육비를 송금해주시면 됩니다.</span><br>
                    <span style="color:red;font-size: 13px;">*직무교육과정을 동시에 진행하시는 경우 각 각의 금액을 따로 입금 해주셔야합니다.</span><br>
					<br>
					<table class="mb10">
						<tr>
							<th>입금계좌 안내</th>
						</tr>
						<tr>
							<td><br><img src="/hrd_manager/images/image04.png"><br><br></td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- //교육비안내 ==================================================================== -->	
	
	<!-- 교육과정및내용====================================================================== -->
	<div style="page-break-after: always;">
		<div class="certi_print_info">
			<div class="infoArea">
				<div class="tableArea">
					<div style="text-align:left; font-size:20px; font-weight:bold; margin-bottom:10px;padding-bottom: 7px; border-bottom: 5px solid #0000FF;">1. 교육과정 및 내용</div>
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">1-1</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">법정 교육</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<td rowspan="2" width="30%"><strong>개인정보보호</strong></td>
							<td>개인정보보호법 주요내용 파악 및 단계별 조치기준</td>
						</tr>
						<tr>
							<td>고객 및 근로자 개인정보처리 기준 및 개인영상정보처리기준</td>
						</tr>
						<tr>
							<td rowspan="3" width="30%"><strong>직장 내<br>성희롱예방</strong></td>
							<td>성희롱 개념 인지 및 행동 원칙 수립</td>
						</tr>
						<tr>
							<td>성희롱 관련 법령과 체계 및 성희롱 예방 관리체계 확립</td>
						</tr>
						<tr>
							<td>성희롱 예방 대응방안 수립 및 처리절차, 조치기준에 따른 대응</td>
						</tr>
						<tr>
							<td rowspan="2 width="30%""><strong>직장 내<br>장애인인식개선</strong></td>
							<td>장애 유형별 특징 및 정당한 편의제공 개념 이해</td>
						</tr>
						<tr>
							<td>장애유형별 정당한 편의제공 및 사례 예시를 통한 환경 구축</td>
						</tr>
						<tr>
							<td rowspan="2" width="30%"><strong>직장 내<br>괴롭힘 방지</strong></td>
							<td>직장 내 괴롭힘 관련 법규, 판단, 인정 사례,</td>
						</tr>
						<tr>
							<td>직장내 괴롭힘 예방 및 발생 시 처리 절차</td>
						</tr>
						<tr>
							<td rowspan="2" width="30%"><strong>퇴직연금</strong></td>
							<td>안정된 노후생활 준비 계획 및 퇴직연금제도 일반 이해</td>
						</tr>
						<tr>
							<td>근로복지공단 퇴직연금 상품 및 추가 안내사항 이해</td>
						</tr>
						<tr>
							<td width="30%"><strong>공공기관<br>일반기관<br>필수교육</strong></td>
							<td>공공기관 및 일반기관에서 이수해야 하는 필수교육</td>
						</tr>
						<tr>
							<td width="30%"><strong>의료기관<br>법정교육</strong></td>
							<td>의료기관에서 필요로 하는 법정교육</td>
						</tr>
						<tr>
							<td width="30%"><strong>장기요양기관<br>시설제공지침<br>교육</strong></td>
							<td>종사자 윤리지침을 포함한 요양기관 제공지침 교육</td>
						</tr>
						<tr>
							<td width="30%"><strong>장기요양기관<br>운영규정교육</strong></td>
							<td>장기요양기관에서 필요로 하는 운영규정 전반에 대한 교육 </td>
						</tr>
					</table>
					<?if($lecture7_value || $lecture8_value){?>
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">1-2</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">근로자 직무능력향상교육</td>
						</tr>
					</table>
					<table class="mb10">
						<?
						if($lecture7_value){
						    $SQLD1 = "SELECT Intro, ContentsName FROM Course WHERE LectureCode = '$lecture7_value'";
						    $QUERYD1 = mysqli_query($connect, $SQLD1);
						    $RowD1 = mysqli_fetch_array($QUERYD1);
						    if($RowD1) {
						        $IntroD1 = nl2br($RowD1['Intro']);
						        $ContentsNameD1 = $RowD1['ContentsName'];
						    }
						?>
						<tr>
							<td width="30%"><strong><?=$ContentsNameD1?></strong></td>
							<td style="text-align:left;"><?=$IntroD1?></td>
						</tr>
						<?}?>
						<?
						if($lecture8_value){
						    $SQLD2 = "SELECT Intro, ContentsName FROM Course WHERE LectureCode = '$lecture8_value'";
						    $QUERYD2 = mysqli_query($connect, $SQLD2);
						    $RowD2 = mysqli_fetch_array($QUERYD2);
						    if($RowD2) {
						        $IntroD2 = nl2br($RowD2['Intro']);
						        $ContentsNameD2 = $RowD2['ContentsName'];
						    }
						?>
						<tr>
							<td width="30%"><strong><?=$ContentsNameD2?></strong></td>
							<td style="text-align:left;"><?=$IntroD2?></td>
						</tr>
						<?}?>
					</table>
					<?}?>
				</div>
			</div>
		</div>
	</div>
	<!-- //교육과정및내용====================================================================== -->
	
	<!-- 교육일정계획====================================================================== -->
	<div style="page-break-after: always;">
		<div class="certi_print_info">
			<div class="infoArea">
				<div class="tableArea">
					<div style="text-align:left; font-size:20px; font-weight:bold; margin-bottom:10px;padding-bottom: 7px; border-bottom: 5px solid #0000FF;">2. 교육일정 계획</div>
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">2-1</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">교육실시 프로세스</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<td><br><img style="width: 95%;" src="/hrd_manager/images/image05.png"><br><br></td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">2-2</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">연간 교육일정</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<th>구분</th>
							<th>1분기</th>
							<th>2분기</th>
							<th>3분기</th>
							<th>4분기</th>
						</tr>
						<?
						$sch1 = in_array(1,$schedule_array);
						$sch2 = in_array(2,$schedule_array);
						$sch3 = in_array(3,$schedule_array);
						$sch4 = in_array(4,$schedule_array);
						?>						
						<?if($sch1){?>
						<tr>
							<td>
							<?
							if($schedule_array[1]==1) echo "5대 법정교육<br>";
							if($schedule_array[2]==1) echo "공공기관 일반기관 필수교육<br>";
							if($schedule_array[3]==1) echo "의료기관 법정교육<br>";
							if($schedule_array[4]==1) echo "의료기관 인증 필수교육<br>";
							if($schedule_array[5]==1) echo "요양기관 법정교육<br>";
							if($schedule_array[6]==1) echo "보육기관 법정교육";
							?>
							</td>
							<td><input type="checkbox" checked onClick="return false"></td>
							<td><input type="checkbox" onClick="return false"></td>
							<td><input type="checkbox" onClick="return false"></td>
							<td><input type="checkbox" onClick="return false"></td>
						</tr>
						<?}?>
						<?if($sch2){?>
						<tr>
							<td>
							<?
							if($schedule_array[1]==2) echo "5대 법정교육<br>";
							if($schedule_array[2]==2) echo "공공기관 일반기관 필수교육<br>";
							if($schedule_array[3]==2) echo "의료기관 법정교육<br>";
							if($schedule_array[4]==2) echo "의료기관 인증 필수교육<br>";
							if($schedule_array[5]==2) echo "요양기관 법정교육<br>";
							if($schedule_array[6]==2) echo "보육기관 법정교육";
							?>
							</td>
							<td><input type="checkbox" onClick="return false"></td>
							<td><input type="checkbox" checked onClick="return false"></td>
							<td><input type="checkbox" onClick="return false"></td>
							<td><input type="checkbox" onClick="return false"></td>
						</tr>
						<?}?>
						<?if($sch3){?>
						<tr>
							<td>
							<?
							if($schedule_array[1]==3) echo "5대 법정교육<br>";
							if($schedule_array[2]==3) echo "공공기관 일반기관 필수교육<br>";
							if($schedule_array[3]==3) echo "의료기관 법정교육<br>";
							if($schedule_array[4]==3) echo "의료기관 인증 필수교육<br>";
							if($schedule_array[5]==3) echo "요양기관 법정교육<br>";
							if($schedule_array[6]==3) echo "보육기관 법정교육";
							?>
							</td>
							<td><input type="checkbox" onClick="return false"></td>
							<td><input type="checkbox" onClick="return false"></td>
							<td><input type="checkbox" checked onClick="return false"></td>
							<td><input type="checkbox" onClick="return false"></td>
						</tr>
						<?}?>
						<?if($sch4){?>
						<tr>
							<td>
							<?
							if($schedule_array[1]==4) echo "5대 법정교육<br>";
							if($schedule_array[2]==4) echo "공공기관 일반기관 필수교육<br>";
							if($schedule_array[3]==4) echo "의료기관 법정교육<br>";
							if($schedule_array[4]==4) echo "의료기관 인증 필수교육<br>";
							if($schedule_array[5]==4) echo "요양기관 법정교육<br>";
							if($schedule_array[6]==4) echo "보육기관 법정교육";
							?>
							</td>
							<td><input type="checkbox" onClick="return false"></td>
							<td><input type="checkbox" onClick="return false"></td>
							<td><input type="checkbox" onClick="return false"></td>
							<td><input type="checkbox" checked onClick="return false"></td>
						</tr>
						<?}?>
						<?if($Schedule7){?>
						<tr>
							<td>직무교육1</td>
							<td><input type="checkbox" <?if($Schedule7==1){?> checked <?}?> onClick="return false"></td>
							<td><input type="checkbox" <?if($Schedule7==2){?> checked <?}?> onClick="return false"></td>
							<td><input type="checkbox" <?if($Schedule7==3){?> checked <?}?> onClick="return false"></td>
							<td><input type="checkbox" <?if($Schedule7==4){?> checked <?}?> onClick="return false"></td>
						</tr>
						<?}?>
						<?if($Schedule8){?>
						<tr>
							<td>직무교육2</td>
							<td><input type="checkbox" <?if($Schedule8==1){?> checked <?}?> onClick="return false"></td>
							<td><input type="checkbox" <?if($Schedule8==2){?> checked <?}?> onClick="return false"></td>
							<td><input type="checkbox" <?if($Schedule8==3){?> checked <?}?> onClick="return false"></td>
							<td><input type="checkbox" <?if($Schedule8==4){?> checked <?}?> onClick="return false"></td>
						</tr>
						<?}?>
					</table>
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">2-3</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">상세 교육일정</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<th>교육과정</th>
							<th>일정계획</th>
						</tr>
						<!-- 법정교육 -->
						<? if($lecture1_value != '' && $lecture1_value != undefined){ ?>
						<tr>
							<td>5대법정교육</td>
							<td><?=$LectureStart1?> ~ <?=$LectureEnd1?></td>
						</tr>
						<? } ?>
						<?
						if($lecture_chk){
						    $SQLA1 = "SELECT Category1, ContentsName, LectureCode FROM Course WHERE LectureCode IN ($lecture_replace)";
						    //echo $SQLA1;
						    $QUERYA1 = mysqli_query($connect, $SQLA1);
						    if($QUERYA1 && mysqli_num_rows($QUERYA1)){
						        while($RowA1 = mysqli_fetch_array($QUERYA1)){
						            $Category1 = $RowA1['Category1'];
						            $ContentsName = $RowA1['ContentsName'];
						            $LectureCode  = $RowA1['LectureCode'];
						?>
						<tr>
							<td><?=$ContentsName?></td>
							<? if(in_array($LectureCode, $lecture2_array)){?>
							<td><?=$LectureStart2?> ~ <?=$LectureEnd2?></td>
						</tr>
							<? } ?>
							<? if(in_array($LectureCode, $lecture3_array)){?>
							<td><?=$LectureStart3?> ~ <?=$LectureEnd3?></td>
						</tr>
							<? } ?>
							<? if(in_array($LectureCode, $lecture4_array)){?>
							<td><?=$LectureStart4?> ~ <?=$LectureEnd4?></td>
						</tr>
							<? } ?>
							<? if(in_array($LectureCode, $lecture5_array)){?>
							<td><?=$LectureStart5?> ~ <?=$LectureEnd5?></td>
						</tr>	
							<? } ?>
							<? if(in_array($LectureCode, $lecture6_array)){?>
							<td><?=$LectureStart6?> ~ <?=$LectureEnd6?></td>
						</tr>	
							<? } ?>
						<?            
						        }
						    }
						}						
						?>
						<!-- 직무교육 -->
						<?
						if($lecture7_value != '' && $lecture7_value != undefined){
						    $SQLF1 = "SELECT Intro, ContentsName FROM Course WHERE LectureCode = '$lecture7_value'";
						    $QUERYF1 = mysqli_query($connect, $SQLF1);
						    $RowF1 = mysqli_fetch_array($QUERYF1);
						    if($RowF1) {
						        $ContentsNameF1 = $RowF1['ContentsName'];
					        }
						?>
						<tr>
							<td><?=$ContentsNameF1?></td>
							<td><?=$LectureStart7?> ~ <?=$LectureEnd7?></td>
						</tr>
						<?}?>
						<?
						if($lecture8_value != '' && $lecture8_value != undefined){
						    $SQLF2 = "SELECT Intro, ContentsName FROM Course WHERE LectureCode = '$lecture8_value'";
						    $QUERYF2 = mysqli_query($connect, $SQLF2);
						    $RowF2 = mysqli_fetch_array($QUERYF2);
						    if($RowF2) {
						        $ContentsNameF2 = $RowF2['ContentsName'];
					        }
						?>
						<tr>
							<td><?=$ContentsNameF2?></td>
							<td><?=$LectureStart8?> ~ <?=$LectureEnd8?></td>
						</tr>
						<?}?>                 
					</table>
					<br>
					<span style="color:red; font-size:13px;text-decoration: underline;">*상세 교육일정 수정이 필요하시면 담당자 메일 또는 연락처로 문의해주십시오.</span>
				</div>
			</div>
		</div>
	</div>
	<!-- //교육일정계획====================================================================== -->
	
	<!-- 교육운영====================================================================== -->
	<div style="page-break-after: always;">
		<div class="certi_print_info">
			<div class="infoArea">
				<div class="tableArea">
					<div style="text-align:left; font-size:20px; font-weight:bold; margin-bottom:10px;padding-bottom: 7px; border-bottom: 5px solid #0000FF;">3. 교육운영</div>
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">3-1</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">교육담당자</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<th>구분</th>
							<th>교육운영</th>
						</tr>
						<?
						$SQLE = "SELECT Phone, Email, Name FROM StaffInfo WHERE ID = '$LoginAdminID'";
						$QUERYE = mysqli_query($connect, $SQLE);
						$RowE = mysqli_fetch_array($QUERYE);
						
						if($RowE) {
						    $Phone = $RowE['Phone'];
						    $Email = $RowE['Email'];
						    $Name = $RowE['Name'];
						}
						?>
						<tr>
							<td>소속</td>
							<td>(주)HRDe solution</td>
						</tr>
						<tr>
							<td>성명</td>
							<td><?=$Name?></td>
						</tr>
						<tr>
							<td>연락처</td>
							<td><?=$Phone?></td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">3-2</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">교육지원</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<th>구분</th>
							<th>세부내용</th>
						</tr>
						<tr>
							<td>오리엔테이션</td>
							<td style="text-align:left;">오리엔테이션 자료 지원</td>
						</tr>
						<tr>
							<td>개강 · 학습독려</td>
							<td style="text-align:left;">알림톡 발송 · 카카오 톡이 없는 경우 문자 발송</td>
						</tr>
						<tr>
							<td>상담</td>
							<td style="text-align:left;">전화, 비즈니스 카카오 톡, 1:1 문의, 간편 상담</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">3-3</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">진도율 관리</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<th>구분</th>
							<th>진도율(%)</th>
							<th>세부내용</th>
						</tr>
						<tr>
							<td>1주 차</td>
							<td>0 ~ 30%</td>
							<td style="text-align:left;">학습 독려 알림톡 발송</td>
						</tr>
						<tr>
							<td rowspan="2">2주 차</td>
							<td>0%</td>
							<td style="text-align:left;">교육담당자와 협의 및 개별 독려 알림톡 발송</td>
						</tr>
						<tr>
							<td>50% 미만</td>
							<td style="text-align:left;">학습 독려 알림톡 발송</td>
						</tr>
						<tr>
							<td rowspan="2">3주 차</td>
							<td>0%</td>
							<td style="text-align:left;">교육담당자 전화 협의</td>
						</tr>
						<tr>
							<td>80% 미만</td>
							<td style="text-align:left;">학습 독려 개별 알림톡 발송</td>
						</tr>
						<tr>
							<td rowspan="2">4주 차</td>
							<td>80% 미만</td>
							<td style="text-align:left;">학습 독려 개별 알림톡 발송 및 전화</td>
						</tr>
						<tr>
							<td>0 ~ 80%</td>
							<td style="text-align:left;">교육담당자와 협의하여 미수료자에 대한 대책 수립</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>					
	<div style="page-break-after: always;">
		<div class="certi_print_info">
			<div class="infoArea">
				<div class="tableArea">
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">3-4</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">평가 관리</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<th>구분</th>
							<th colspan="2">세부내용</th>
						</tr>
						<tr>
							<td rowspan="2">1주 차</td>
							<td colspan="2" style="text-align:left;">학습자료 요약집 바로보기 URL 알림톡 발송</td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:left;">수료기준 안내 알림톡 발송</td>
						</tr>
						<tr>
							<td>3주 차</td>
							<td colspan="2" style="text-align:left;">평가 미응시 학습자 평가 독려 알림톡 발송</td>
						</tr>
						<tr>
							<td rowspan="2">4주 차</td>
							<td colspan="2" style="text-align:left;">평가 미응시 학습자 개별 전화 독려</td>
						</tr>
						<tr>
							<td colspan="2" style="text-align:left;">평가 미수료 학습자 재평가 안내 알림톡 발송</td>
						</tr>
						<tr>
							<td rowspan="2">5주 차</td>
							<td>미응시</td>
							<td style="text-align:left;">수료기준 안내문자 · 평가응시 독려 전화</td>
						</tr>
						<tr>
							<td>점수미달</td>
							<td style="text-align:left;">재수강 안내 전화</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- //교육운영====================================================================== -->
	
	<!-- 소속 근로자 안내사항====================================================================== -->
	<div style="page-break-after: always;">
		<div class="certi_print_info">
			<div class="infoArea">
				<div class="tableArea">
					<div style="text-align:left; font-size:20px; font-weight:bold; margin-bottom:10px;padding-bottom: 7px; border-bottom: 5px solid #0000FF;">4. 소속 근로자님에게 다음 사항을 안내해 주십시오.</div>
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">4-1</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">부정훈련 관련 예시</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<th>교육원 담당자 해당</th>
						</tr>
						<tr>
							<td style="text-align:left;">대리수강·평가를 대신 해 주겠다는 조건으로 위탁계약을 체결한 경우</td>
						</tr>
						<tr>
							<td style="text-align:left;">대리수강·평가를 대신 해 준 경우</td>
						</tr>
						<tr>
							<td style="text-align:left;">평가 답안지를 제공한 경우</td>
						</tr>
						<tr>
							<th>고객사 교육담당자 및 학습자 해당</th>
						</tr>
						<tr>
							<td style="text-align:left;">본인이 아닌 타인이 대리수강·평가를 한 경우</td>
						</tr>
						<tr>
							<td style="text-align:left;">고객사 내부 혹은 외부로부터 평가 답안지를 제공받은 경우</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">4-2</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">부정훈련 점검</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<th>비정상 IP 패턴 분석</th>
						</tr>
						<tr>
							<td style="text-align:left;">
								□ 학습/진도/평가 후 10분 내 동일 IP에서 다른 학습자 학습 이력 한 경우<br>
                                □ 사업장 내 모든 훈련생 학습일자가 동일한 경우<br>
                                □ 동일 IP에서 타 사업장 학습자가 학습한 경우<br>
                                □ 동일 단말기에서 타 사업장 학습자가 학습한 경우<br>
							</td>
						</tr>
						<tr>
							<th>교육담당자 및 학습자 모니터링</th>
						</tr>
						<tr>
							<td style="text-align:left;">
								□ 위탁교육체결 시 서약서 징수 및 위탁계약의 적절성 등을 모니터링하고 있습니다. <br>
                                □ 교육실시 전 고객사 교육담당자에게 부정훈련에 대해 안내하고 있습니다. <br>
                                □ 교육 수료 후 전 수료 학습자에 대해 만족도조사를 실시하고 있습니다.
							</td>
						</tr>
					</table>
					<div class="tableArea" style="margin-top:90px;">
    					<table style="font-weight:bold;">
    						<tr>
    						<td style="font-size:15px; color:red;">대리수강 · 대리평가 · 답안지제공 등은 부정훈련입니다.</td>
    						</tr>
    						<tr>
    						<td style="font-size:15px; color:red;">부정훈련신고 시 소정의 사례를 드립니다.</td>
    						</tr>
    						<tr>
    						<td style="font-size:15px;">부정훈련 신고 직통전화 / 담당자 전화번호 / 1811-9530</td>
    						</tr>
    					</table>
    				</div>
				</div>
			</div>
		</div>
	</div>
	<!-- // 소속 근로자 안내사항====================================================================== -->
	
	<!-- 학습자주요질문사항 ====================================================================== -->
	<div style="page-break-after: always;">
		<div class="certi_print_info">
			<div class="infoArea">
				<div class="tableArea">
					<div style="text-align:left; font-size:20px; font-weight:bold; margin-bottom:10px;padding-bottom: 7px; border-bottom: 5px solid #0000FF;">5. 학습자 주요 질문사항</div>
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">Q</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">지금까지 모여서 교육받았는데, 꼭 원격으로 교육을 받아야 하나요?</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<th>모여서 교육받는 방법(집체교육)의 단점</th>
						</tr>
						<tr>
							<td style="text-align:left;">
							□ 전 직원을 대상으로 동시에 교육을 실시해야 하므로 업무가 중단될 수 있습니다.<br>
                            □ 전 직원이 3시간~5시간 강의를 '한 명도 빠지지 않고, 동일 시간에 수강하는 것이 불가능합니다.<br> 
                            □ 출장 등 사유로 미 이수 근로자는 보충강의 또는 야간강의를 실시해야 합니다. <br>
                            □ 교육과 관련된 스케줄 조정과 장소섭외, 교육자료 준비를 해야 합니다. <br>
                            □ 3년간 의무적으로 관리해야 하는 수료증 등과 같은 증빙자료 보관 등 업무가 과중됩니다.
							</td>
						</tr>
						<tr>
							<th>온라인 교육의 장점</th>
						</tr>
						<tr>
							<td style="text-align:left;">
							□ 시·공간을 초월하여 언제든지 PC 또는 모바일로 수강이 가능합니다.<br> 
                            □ 별도 교육 스케줄을 조정하거나 장소 섭외 또는 교육 자료가 필요하지 않습니다.<br> 
                            □ 각종 교육관련 증빙자료가 제공되므로 교육담당자 업무가 줄어듭니다. <br> 
                            □ 교육관련 각종 자료가 교육원의 서버에 보관되므로 언제든지 교육에 대한 증빙이 가능합니다.<br>  
                            □ 학습자들의 반복 학습이나 추가 학습이 가능합니다. 
							</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">Q</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">교육방법은 어떻게 되나요?</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<th>주요 안내 요청사항</th>
						</tr>
						<tr>
							<td style="text-align:left;">
							□ 모든 교육과정은 핸드폰으로 수강이 가능하지만, 평가는 PC로만 가능합니다. <br> 
                            □ 학습방법은 배포된 오리엔테이션 동영상과 e_book을 참조해주세요.<br> 
                            □ 법정 및 산업안전보건교육은 본인인증을 하지 않습니다. 다만, 직무교육은 반드시 <span style="color:blue;text-decoration: underline;">본인 인증이 필요하므로 본인 명의 휴대폰 또는 아이핀이 필요합니다.</span><br>  
                            □ 법정교육은 평가가 없습니다. 단, 산업안전보건교육과 직무교육은 평가와 재평가가 가능합니다.
							</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- //학습자주요질문사항====================================================================== -->
	
	<!-- 기타요청사항 ====================================================================== -->
	<div style="page-break-after: always;">
		<div class="certi_print_info">
			<div class="infoArea">
				<div class="tableArea">
					<div style="text-align:left; font-size:20px; font-weight:bold; margin-bottom:10px;padding-bottom: 7px; border-bottom: 5px solid #0000FF;">6. 기타 요청사항</div>
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">6-1</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">아래표와 같은 내용의 안내를 요청드립니다. </td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<th>구분</th>
							<th colspan="2">세부내용</th>
						</tr>
						<tr>
							<td>교육안내</td>
							<td colspan="2" style="color:blue;text-decoration: underline;text-align:left;">교육 필요성 및 일정을 사전에 안내해 주십시오.</td>
						</tr>
						<tr>
							<td rowspan="2">수강방법</td>
							<td colspan="2" style="text-align:left;">모든 과정은 핸드폰으로 수강이 가능합니다.</td>
						</tr>
						<tr>
							<td  colspan="2"style="text-align:left;">단, 평가는 고용노동부 규정에 의해 PC로만 가능합니다.</td>
						</tr>
						<tr>
							<td>오리엔테이션 자료</td>
							<td colspan="2">개강1일전 발송되는 교육담당자 메일을 확인해주세요.</td>
						</tr>
						<tr>
							<td rowspan="4">본인인증 절차</td>
							<td>법정교육</td>
							<td>본인인증을 하지 않습니다.<br>(비밀번호 변경시 필요)</td>
						</tr>
						<tr>
							<td>안전보건교육</td>
							<td>본인인증을 하지 않습니다.<br>(비밀번호 변경시 필요)</td>
						</tr>
						<tr>
							<td rowspan="2">직무교육</td>
							<td><span style="color:blue;text-decoration: underline;">반드시 </span> 본인 인증이 필요합니다.</td>
						</tr>
						<tr>
							<td><span style="color:blue;text-decoration: underline;">본인 명의 휴대폰 또는 아이핀이 필요합니다.</span></td>
						</tr>
						<tr>
							<td rowspan="3">평가 및 재평가</td>
							<td>법정교육</td>
							<td>평가가 없습니다.</td>
						</tr>
						<tr>
							<td>안전보건교육</td>
							<td>최종평가가 실시됩니다.(PC로만 가능)<br>수강 종료 후 1주일 제공되는 복습기간 내 재평가가 가능합니다.<br><span style="color:blue;text-decoration: underline;">(단, 3회 응시 시 미달 후 재수강)</span></td>
						</tr>
						<tr>
							<td>직무능력향상교육</td>
							<td>중간평가, 최종평가가 실시됩니다.(PC로만 가능)<br>수강 종료 후 1주일 제공되는 복습기간 내 재평가가 가능합니다.</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">6-2</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">입·퇴사자 명단을 통보해 주십시오.</td>
						</tr>
					</table>
					<br>
					<span style="font-size:13px;">□ 이 계획서에 의해 연간 법정 · 산업안전보건 · 직무능력향상교육을 실시하게 되므로 입·퇴사자가 발생한 경우 아래의 메일로 통보해 주시면 교육에 반영하도록 하겠습니다. </span>
					<br><br>
					<table class="mb10">
						<tr>
							<td>email</td>
							<td><?=$Email?></td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<td style="width:80px; font-size:22px; font-weight:bold; color:#fff; background-color:#0000FF">6-3</td>
							<td style="text-align:left; padding-left:10px; font-size:18px; font-weight:bold; ">교육진행 ·결과 보고서 제출</td>
						</tr>
					</table>
					<table class="mb10">
						<tr>
							<th>구분</th>
							<th>제출 시기</th>
							<th>제출 방법</th>
						</tr>
						<tr>
							<td>교육진행보고서</td>
							<td>교육 실시 3주 차</td>
							<td>e-mail 발송</td>
						</tr>
						<tr>
							<td>교육결과보고서</td>
							<td>교육 수료 후</td>
							<td>e-mail 발송</td>
						</tr>
					</table>
				</div>
			</div>
		</div>
	</div>
	<!-- //기타요청사항====================================================================== -->

</div>
</BODY>
</html>
<?
mysqli_close($connect);
?>