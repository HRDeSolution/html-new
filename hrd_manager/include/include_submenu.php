<?
switch ($MenuType) {
    case "A" :
?>
<?if(in_array('A',$LoginAdminTopMenuGrant_array)){?>
<div class="subMenu">
	<h1><i class="xi-user"></i> 회원 관리</h1>
	<ul class="area">
		<?if(in_array('A1',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="company.php">사업주 관리</a></li>
		<?}?>
		<?if(in_array('A2',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="member.php">수강생 관리</a></li>
		<?}?>
		<?if(in_array('A3',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="lecture_reg.php">수강 등록</a></li>
		<?}?>
		<?if(in_array('A4',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="member_out.php">탈퇴회원 관리</a></li>
		<?}?>
		<?if(in_array('A5',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="dept_category.php">관리자/영업자/첨삭강사 카테고리</a></li>
		<?}?>
		<?if(in_array('A6',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="staff01.php">관리자 리스트</a></li>
		<?}?>
		<?if(in_array('A7',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="staff02.php">영업자 리스트</a></li>
		<?}?>
		<?if(in_array('A8',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="staff03.php">첨삭강사 리스트</a></li>
		<?}?>
		<?if(in_array('A9',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="read_reason.php">개인정보 열람내역</a></li> 
		<?}?>
		<li id="BottonHeight">&nbsp;</li>
	</ul>
</div>
<?}else{?>
<script type="text/javascript">
<!--
	NoPermission();
//-->
</script>
<?}?>
<?
	break;

	case "B";
?>
<?if(in_array('B',$LoginAdminTopMenuGrant_array)){?>
<div class="subMenu">
	<h1><i class="xi-document"></i> 수강 관리</h1>
	<ul class="area">
        <?if(in_array('B5',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="study.php">학습관리</a></li>
        <li><a href="study2.php">학습내역관리</a></li>
		<?}?>
		<?if(in_array('B6',$LoginAdminSubMenuGrant_array)){?>
    	<li><a href="study_end.php">수강마감</a></li>
        <?}?>
		<?if(in_array('B1',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="study_ip.php">IP모니터링</a></li>
		<?}?>
		<?if(in_array('B2',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="certification_list.php">본인인증 모니터링</a></li>
		<?}?>
		<?if(in_array('B3',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="study_time.php">일자별 학습시간 관리</a></li>
		<?}?>
		<?if(in_array('B4',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="negative_training.php">리포트 부정훈련</a></li>
		<?}?>
		<?if(in_array('B7',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="course_data.php">과정 이수데이터 관리</a></li>
		<?}?>
		<?if(in_array('B8',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="study_end2.php">과목별 이수증</a></li>
		<?}?>
		<li id="BottonHeight">&nbsp;</li>
	</ul>
</div>
<?}else{?>
<script type="text/javascript">
<!--
	NoPermission();
//-->
</script>
<?}?>
<?
	break;
	
	case "C";
?>
<?if(in_array('C',$LoginAdminTopMenuGrant_array)){?>
<div class="subMenu">
	<h1><i class="xi-mobile"></i> 독려 관리</h1>
	<ul class="area">
		<?if(in_array('C1',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="study_sms.php">학습참여독려</a></li>
		<li><a href="study_sms_res_list.php">예약문자발송</a></li>
		<?}?>
		<?if(in_array('C2',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="study_sms_log.php">문자발송내역</a></li>
		<?}?>
		<?if(in_array('C3',$LoginAdminSubMenuGrant_array)){?>		
		<li><a href="study_email_log_for_edumanager.php">메일발송내역(교육담당자)</a></li>
		<?}?>
		<?if(in_array('C4',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="study_email_log.php">메일발송내역(훈련생)</a></li>
        <?}?>
		<?if(in_array('C5',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="smsdata.php">문자/템플릿관리</a></li>
		<?}?>
		<li id="BottonHeight">&nbsp;</li>
	</ul>
</div>
<?}else{?>
<script type="text/javascript">
<!--
	NoPermission();
//-->
</script>
<?}?>
<?
	break;

	case "D";
?>
<?if(in_array('D',$LoginAdminTopMenuGrant_array)){?>
<div class="subMenu">
	<h1><i class="xi-lightbulb"></i> 컨텐츠 관리</h1>
	<ul class="area">
		<?if(in_array('D1',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="course_category.php">과정카테고리 관리</a></li>
		<?}?>
		<?if(in_array('D2',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="contents.php">기초차시 관리</a></li>
		<?}?>
		<?if(in_array('D3',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="ability_question_manager.php">역량진단 문항관리</a></li>
		<?}?>
		<?if(in_array('D4',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="ability_manager.php">역량진단관리</a></li>
		<?}?>
		<?if(in_array('D5',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="satisfaction_manager.php">만족도조사</a></li>
		<?}?>
		<?if(in_array('D6',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="course_package.php">패키지컨텐츠관리</a></li>
		<?}?>		
		<li id="BottonHeight">&nbsp;</li>
	</ul>
</div>
<?}else{?>
<script type="text/javascript">
<!--
	NoPermission();
//-->
</script>
<?}?>
<?
	break;

	case "E":
?>
<?if(in_array('E',$LoginAdminTopMenuGrant_array)){?>
<div class="subMenu">
	<h1><i class="xi-group"></i> 아카이브</h1>
	<ul class="area">
		<?if(in_array('E1',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="course.php?ctype=X">이러닝 컨텐츠 관리</a></li>
		<?}?>
		<?if(in_array('E2',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="course.php?ctype=Z">마이크로닝 컨텐츠 관리</a></li>
		<?}?>
		<?if(in_array('E3',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="course.php?ctype=Y">숏폼 컨텐츠 관리</a></li>
		<!-- <li><a href="course.php?ctype=W">비환급 컨텐츠 관리</a></li>  -->
		<?}?>
		<?if(in_array('E4',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="contents_keyword.php">컨텐츠 키워드 관리</a></li>
		<?}?>
		<?if(in_array('E5',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="main_contents.php">PICK/TOP/NEW 컨텐츠 관리</a></li>
		<?}?>
		<?if(in_array('E6',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="contents_like.php">관심강의 관리</a></li>
		<li><a href="contents_count.php">과정조회 관리</a></li>
		<?}?>
		<?if(in_array('E7',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="inquiry.php">수강신청관리</a></li>
		<?}?>

		<li id="BottonHeight">&nbsp;</li>
	</ul>
</div>
<?}else{?>
<script type="text/javascript">
<!--
	NoPermission();
//-->
</script>
<?}?>
<?
	break;

	case "F":
?>

<?if(in_array('F',$LoginAdminTopMenuGrant_array)){?>
<div class="subMenu">
	<h1><i class="xi-group"></i> 커뮤니티 관리</h1>
	<ul class="area">
		<?if(in_array('F1',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="notice.php">공지사항</a></li>
		<?}?>
		<?if(in_array('F2',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="faq.php">자주 묻는 질문</a></li>
		<?}?>
		<?if(in_array('F3',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="qna.php">1:1 상담 / 학습상담</a></li>
		<?}?>
		<?if(in_array('F4',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="survey.php">수강후기</a></li>
		<?}?>
		<?if(in_array('F5',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="archiving.php">아카아빙</a></li>
		<?}?>
		<?if(in_array('F6',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="cheating_report.php">부정제보</a></li>
		<?}?>
		<?if(in_array('F7',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="edudata.php">학습자료실</a></li>
		<li><a href="lecture_event.php">이벤트관리</a></li>
		<?}?>
		<li id="BottonHeight">&nbsp;</li>
	</ul>
</div>
<?}else{?>
<script type="text/javascript">
<!--
	NoPermission();
//-->
</script>
<?}?>
<?
	break;

	case "L":
?>
<div class="subMenu">
	<h1><i class="xi-video"></i> 실시간 강의</h1>
	<ul class="area">
		<li><a href="live_class.php">실시간 강의 관리</a></li>
		<li id="BottonHeight">&nbsp;</li>
	</ul>
</div>
<?
	break;

	case "G":
?>
<?if(in_array('G',$LoginAdminTopMenuGrant_array)){?>
<div class="subMenu">
	<h1><i class="xi-browser"></i> 사이트 관리</h1>
	<ul class="area">
		<?if(in_array('G1',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="site_info.php">사이트 정보 관리</a></li>
		<?}?>
		<?if(in_array('G2',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="popup.php">팝업 관리</a></li>
		<?}?>
		<?if(in_array('G3',$LoginAdminSubMenuGrant_array)){?>
		<li><a href="backup_list.php">백업 목록</a></li>
		<li><a href="sta.php">접속통계 관리</a></li>
		<?}?>
		<li id="BottonHeight">&nbsp;</li>
	</ul>
</div>
<?}else{?>
<script type="text/javascript">
<!--
	NoPermission();
//-->
</script>
<?}?>
<?
	break;
	
	case "Z":
?>
<div class="subMenu">
	<h1><i class="xi-profile"></i> 정보 변경</h1>
	<ul class="area">
		<li><a href="my_info.php">정보 변경</a></li>
		<li id="BottonHeight">&nbsp;</li>
	</ul>
</div>
<?
	break;

	default :
?>
<div class="subMenu">
	<h1><i class="xi-home"></i> 메인</h1>
	<ul class="area">
		<li id="BottonHeight">&nbsp;</li>
	</ul>
</div>
<?
}
?>