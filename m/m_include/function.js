//공통 함수 ------------------------------------------------------------------------------------------------------

if (location.protocol == 'http:') {
	location.href = location.href.replace('http://', 'https://');
}

if (location.hostname != 'm.hrdeedu.co.kr') {
	location.href = location.href.replace(location.hostname, 'm.hrdeedu.co.kr');
}

//사이트 로딩시 실행되는 함수들--------
$(document).ready(function () {
	//상단 주메뉴---------------------------------------------------------------------------
	var gnbHr = $("div[id='TopMenu']");

	gnbHr.find('>ul>li>h2').mouseover(function () {
		$("ul[id='SiteMenu1']").show();
		$("ul[id='SiteMenu2']").show();
		$("ul[id='SiteMenu3']").show();
		$("ul[id='SiteMenu4']").show();
		$("ul[id='SiteMenu5']").show();
	});

	gnbHr
		.find('>ul>li>h2>a')
		.focus(function () {
			$(this).mouseover();
		})

		.end();

	//상단 메뉴 위치에서 이탈시 메뉴 숨기기
	$("div[id='TopMenu']").mouseleave(function () {
		$("ul[id='SiteMenu1']").hide();
		$("ul[id='SiteMenu2']").hide();
		$("ul[id='SiteMenu3']").hide();
		$("ul[id='SiteMenu4']").hide();
		$("ul[id='SiteMenu5']").hide();
	});

	//상단 주메뉴-------------------------------------------------------------------------------
});
//사이트 로딩시 실행되는 함수들--------

function SiteMenuShow() {
	$("ul[id='SiteMenu1']").toggle();
	$("ul[id='SiteMenu2']").toggle();
	$("ul[id='SiteMenu3']").toggle();
	$("ul[id='SiteMenu4']").toggle();
	$("ul[id='SiteMenu5']").toggle();
}

function isMobile() {
	var filter = 'win16|win32|win64|mac|macintel';
	if (navigator.platform) {
		if (filter.indexOf(navigator.platform.toLowerCase()) < 0) {
			return true;
		} else {
			return false;
		}
	}
}

function BrowserVersionCheck() {
	var word;
	var versionOrType = 'another';

	var agent = navigator.userAgent.toLowerCase();
	var name = navigator.appName;

	/***********************************************
	 * IE인 경우 버전 체크
	 ***********************************************/
	// IE old version ( IE 10 or Lower )
	if (name == 'Microsoft Internet Explorer') {
		word = 'msie ';
		versionOrType = 'IE';
	} else {
		// IE 11
		if (agent.search('trident') > -1) {
			word = 'trident/.*rv:';
			versionOrType = 'IE';
			// IE 12  ( Microsoft Edge )
		} else if (agent.search('edge/') > -1) {
			word = 'edge/';
			versionOrType = 'Edge';
		}
	}

	/*
	var reg = new RegExp( word + "([0-9]{1,})(\\.{0,}[0-9]{0,1})" );
	if ( reg.exec( agent ) != null )
	versionOrType = RegExp.$1 + RegExp.$2;
	*/

	/***********************************************
	 * IE가 아닌 경우 브라우저의 종류 체크
	 ***********************************************/
	if (versionOrType == 'another') {
		if (agent.indexOf('chrome') != -1) versionOrType = 'Chrome';
		else if (agent.indexOf('opera') != -1) versionOrType = 'Opera';
		else if (agent.indexOf('firefox') != -1) versionOrType = 'Firefox';
		else if (agent.indexOf('safari') != -1) versionOrType = 'Safari';
	}

	return versionOrType;
}

/* 숫자체크*/
function IsNumber(num) {
	if (typeof num === 'undefined' || num === null || num === '') {
        return false; // 빈 값이거나 정의되지 않은 경우
    }
	var x = num;
	//var anum=/(^\d+$)|(^\d+\.\d+$)/
//	var anum = /(^\d+$)|(^\d+$)/;
    var anum = /^\d+$/;
	if (anum.test(x)) testresult = true;
	else {
		testresult = false;
	}
	return testresult;
}

function isContinuedValue(str, limit) {
	var o, d, p, n = 0, l = limit == null ? 4 : limit;
    for (var i = 0; i < str.length; i++) {
        var c = str.charCodeAt(i);
        if (i > 0 && (p = o - c) > -2 && p < 2 && (n = p == d ? n + 1 : 0) > l - 3) 
            return true;
            d = p, o = c;
    }
    return false;
	
	/*var intCnt1 = 0;
	var intCnt2 = 0;
	var temp0 = '';
	var temp1 = '';
	var temp2 = '';
	var temp3 = '';

	for (var i = 0; i < value.length - 3; i++) {
		temp0 = value.charAt(i);
		temp1 = value.charAt(i + 1);
		temp2 = value.charAt(i + 2);
		temp3 = value.charAt(i + 3);

		if (temp0.charCodeAt(0) - temp1.charCodeAt(0) == 1 && temp1.charCodeAt(0) - temp2.charCodeAt(0) == 1 && temp2.charCodeAt(0) - temp3.charCodeAt(0) == 1) {
			intCnt1 = intCnt1 + 1;
		}

		if (temp0.charCodeAt(0) - temp1.charCodeAt(0) == -1 && temp1.charCodeAt(0) - temp2.charCodeAt(0) == -1 && temp2.charCodeAt(0) - temp3.charCodeAt(0) == -1) {
			intCnt2 = intCnt2 + 1;
		}
	}

	return intCnt1 > 0 || intCnt2 > 0;
	*/
}

//한글체크
function hanCheck(ID) {
	var digits = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	var temp;
	//alert(MemberID);
	for (i = 0; i < ID.length; i++) {
		temp = ID.substring(i, i + 1);
		if (digits.indexOf(temp) == -1) {
			return false;
		}
	}
	return true;
}

//이메일 체크
function chkEmail(str) {
	var reg_email = /^([0-9a-zA-Z_\.-]+)@([0-9a-zA-Z_-]+)(\.[0-9a-zA-Z_-]+){1,2}$/;

	if (!reg_email.test(str)) {
		return false;
	}
	return true;
}

//페이지 이동 관련
function pageRun(num) {
	document.listScriptForm.pg.value = num;
	document.listScriptForm.submit();
}

function pageRun1(num) {
	document.listScriptForm1.pg1.value = num;
	document.listScriptForm1.submit();
}

function pageRun2(num) {
	document.listScriptForm2.pg2.value = num;
	document.listScriptForm2.submit();
}

function pageRun3(num) {
	document.listScriptForm3.pg3.value = num;
	document.listScriptForm3.submit();
}

function readRun(idx) {
	document.ReadScriptForm.idx.value = idx;
	document.ReadScriptForm.submit();
}

function MoveTop() {
	$('html, body').animate({ scrollTop: 0 }, 200);
}

//데이터 레이어 닫기
function DataResultClose() {
	$("div[id='Roading']").hide();
	$("div[id='DataResult']").html('');
	$("div[id='DataResult']").hide();
	$("div[id='SysBg_White']").hide();
	$("div[id='SysBg_Black']").hide();
	$('html').css('overflow', '');
}

function DataResultCloseReload() {
	location.reload();
}

//로그 아웃 시간 처리
var TimeCheckNo = 'Y';

function LogOutTimeView() {
	parselimit = 7200 - parseInt(document.TimeCheckForm.NowTime.value);

	curmin = Math.floor(parselimit / 60);
	cursec = parselimit % 60;

	if (curmin < 10) {
		curmin2 = '0' + curmin;
	} else {
		curmin2 = curmin;
	}

	if (cursec < 10) {
		cursec2 = '0' + cursec;
	} else {
		cursec2 = cursec;
	}

	if (curmin != 0) {
		curtime = curmin2 + '분 ' + cursec2 + '초';
	} else {
		curtime = '00분 ' + cursec2 + '초';
	}

	//남은시간 : 145분 30초
	console.log('curtime: ', curtime);
	// $('#LogOutRemainTime').html(curtime);
}
let isLoggingOut = false;

function LogoutTimeCheck() {
	let oldTimeValue = 0;
	if (TimeCheckNo != 'N') {
		var $timer_display = $(
			"<div id='timer_display' style='position:fixed;z-index:100000;background-color:#ffffff;border:1px solid #ccc;padding:5px;left:0;bottom:0;color:#888;'></div>"
		);
		if (!$('#timer_display').length) $('body').append($timer_display);

		var time = document.TimeCheckForm.NowTime.value;

		var hour = Math.floor(time / 3600);
		if (!hour) hour = 0;

		var min = Math.floor(time / 60) - hour * 60;
		if (!min) min = 0; // Brad (2021.12.11) : 버그 수정

		var sec = time - min * 60 - hour * 3600;
		if (!sec) sec = 0;

		if (hour < 10) hour = '0' + hour;
		if (min < 10) min = '0' + min;
		if (sec < 10) sec = '0' + sec;

		time = hour + ':' + min + ':' + sec;

		$('#timer_display').text(time);

		if (document.TimeCheckForm.NowTime.value % 600 == 0) {
			//alert(`oldTimeValue : ${oldTimeValue}`);
			//console.log('document.TimeCheckForm.NowTime.value: ', document.TimeCheckForm.NowTime.value);
		}
		oldTimeValue = document.TimeCheckForm.NowTime.value;

		if (!isLoggingOut && document.TimeCheckForm.NowTime.value > 7200) {
            isLoggingOut = true;
			alert("장시간 학습을 위한 활동이 없어 자동으로 로그아웃됩니다.");
			location.href = '/m_public/member/logout.php';
            return;
		} else {
			document.TimeCheckForm.NowTime.value = parseInt(document.TimeCheckForm.NowTime.value) + 1;
			// LogOutTimeView(); Brad : (필요 없는 부분 주석 처리)
		}
	}
}
//공통 함수 ------------------------------------------------------------------------------------------------------

function BoardSearch() {
	if ($('#sw').val() == '') {
		alert('검색어를 입력하세요.');
		$('#sw').focus();
		return;
	}

	BoardSearchForm.submit();
}

//아이디 유효성 검사
function ID_Validity(str) {
	if (str == '') {
		alert('아이디를 입력하세요.');
		return false;
	}
	if (str.length < 6 || str.length > 20) {
		alert('아이디는 6자이상 20자 이내로 입력하세요.');
		return false;
	}
	if (hanCheck(str) == false) {
		alert('아이디는 영문/숫자만 입력 가능합니다.');
		return false;
	}
}

//아이디 중복체크
function IDCheck() {
	var ID = $('#ID').val();

	if (ID_Validity(ID) == false) {
		return;
	}
	$("#id_check_msg").load('/m_public/member/id_check.php', { ID: ID }, function () {
		if ($('#ID_Check').val() == 'Y') {
			alert('사용 가능한 아이디입니다.');
		} else {
			alert('이미 사용중인 아이디입니다.');
			$('#ID').val('');
		}
	});
}

//추천인 아이디 확인
function RecomIDCheck() {
	var RecomID = $('#RecomID').val();
	
	if(RecomID == ''){
		alert('추천인 ID를 입력하세요.');
		return;
	}
	
	$("#recomid_check_msg").load('/m_public/member/recomid_check.php', { RecomID: RecomID }, function () {
		if ($('#RecomID_Check').val() == 'Y') {
			alert('입력하신 추천인 ID 확인완료되었습니다.');
		} else {
			alert('입력하신 추천인 ID가 없습니다.');
			$('#RecomID').val('');
		}
	});
}

//회원가입
function MemberJoin() {
	if ($('#Name').val() == '') {
		alert('이름을 입력하세요.');
		$('#Name').focus();
		return;
	}

	if ($('#Mobile01').val() == '') {
		alert('휴대전화번호를 입력하세요.');
		$('#Mobile01').focus();
		return;
	}

	if ($('#Mobile02').val() == '') {
		alert('휴대전화번호를 입력하세요.');
		$('#Mobile02').focus();
		return;
	}

	if ($('#Mobile03').val() == '') {
		alert('휴대전화번호를 입력하세요.');
		$('#Mobile03').focus();
		return;
	}

	if (IsNumber($('#Mobile01').val()) == false) {
		alert('휴대전화번호는 숫자만 입력하세요.');
		$('#Mobile01').focus();
		return;
	}

	if (IsNumber($('#Mobile02').val()) == false) {
		alert('휴대전화번호는 숫자만 입력하세요.');
		$('#Mobile02').focus();
		return;
	}

	if (IsNumber($('#Mobile03').val()) == false) {
		alert('휴대전화번호는 숫자만 입력하세요.');
		$('#Mobile03').focus();
		return;
	}
	
	if ($('#ID').val() == '') {
		alert('아이디를 입력하세요.');
		$('#ID').focus();
		return;
	}

	if ($('#ID_Check').val() == 'N') {
		alert('아이디 중복 검색을 하세요.');
		return;
	}

	if ($('#Pwd').val() == '') {
		alert('비밀번호를 입력하세요.');
		$('#Pwd').focus();
		return;
	}

	if (CheckPassword($('#Pwd').val()) == false) {
		$('#Pwd').focus();
		return;
	}

	if ($('#Pwd2').val() == '') {
		alert('비밀번호 확인을 입력하세요.');
		$('#Pwd2').focus();
		return;
	}

	if ($('#Pwd').val() !== $('#Pwd2').val()) {
		alert('비밀번호와 비밀번호 확인이 일치하지 않습니다.');
		$('#Pwd2').focus();
		return;
	}

	if ($('#Email').val() == '') {
		alert('이메일을 입력하세요.');
		$('#Email').focus();
		return;
	}

	if (chkEmail($('#Email').val()) == false) {
		alert('이메일을 정확하게 입력하세요.');
		return;
	}
	
	if ($('#RecomID').val() != '') {
		if ($('#RecomID_Check').val() == 'N') {
			alert('추천인 ID 확인을 하세요.');
			return;
		}
	}

	if ($('#SecurityCode').val() == '') {
		alert('보안코드를 입력하세요.');
		$('#SecurityCode').focus();
		return;
	}

	Yes = confirm('회원가입 하시겠습니까?');
	if (Yes == true) {
		$('#SubmitBtn').hide();
		$('#WaitMag').show();
		JoinForm.submit();
	}
}

//비밀번호 유효성 체크
//비밀번호는 영문, 숫자, 특수문자 중 2개 이상의 조합으로 10자 이상 또는 3개 이상의 조합으로 8자 이상 사용해야합니다. 
function CheckPassword(str) {
	/*
	if (str.length < 8) {
		alert('비밀번호는 영문, 숫자, 특수문자 중 2개 이상의 조합으로 10자 이상 또는 3개 이상의 조합으로 8자 이상 사용하세요.');
		return false;
	}

	var chk_num = str.search(/[0-9]/g);
	var chk_eng = str.search(/[a-z]/gi);
	var chk_spc = str.search(/[~!@#$%^&*]/);

	if ( (chk_num == -1 && chk_eng == -1 && chk_spc >= 0) || (chk_num > 0 && chk_eng == -1 && chk_spc == -1) || (chk_num == -1 &&chk_eng >= 0 && chk_spc == -1)) {
        alert('영문, 숫자, 특수문자 중 2개 이상의 조합으로 10자 이상을 사용해야 합니다.');
        return false;
	} else if ( (chk_num == -1 && chk_eng > 0 && chk_spc > 0) || (chk_num > 0 && chk_eng == -1 && chk_spc > 0) || (chk_num >= 0 &&chk_eng >= 0 && chk_spc == -1)) {
        if (str.length < 10) {
    		alert('영문, 숫자, 특수문자 중 2개 이상의 조합으로 10자 이상을 사용해야 합니다..');
    		return false;
        }
    } else {
        if (chk_num < 0 || chk_eng < 0 || chk_spc < 0) {
            if (str.length <= 8) {
                alert('영문, 숫자, 특수문자 3개 이상의 조합으로 8자 이상을 사용해야 합니다.');
                return false;
            }
        }
    }
	*/
	
	if (/(\w)\1\1\1\1\1/.test(str) || isContinuedValue(str, 6)) {
		alert('비밀번호에 6자 이상의 연속 또는 반복 문자 및 숫자를 사용하실 수 없습니다.');
		return false;
	}

	var pwRule1 = /^(?=.*[a-zA-Z])(?=.*[0-9]).{10,}$/;
    var pwRule2 = /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-]).{10,}$/;
    var pwRule3 = /^(?=.*[0-9])(?=.*[!@#$%^*+=-]).{10,}$/;
    var pwRule4 = /^(?=.*[a-zA-Z])(?=.*[!@#$%^*+=-])(?=.*[0-9]).{8,}$/;
	var pwVaild = false;

	if(str.length >= 10) {
		if(pwRule1.test(str) && (str.search(/[a-z]/ig) >= 0) && (str.search(/[0-9]/g) >= 0)) {
			pwVaild = true;
		}

		if(pwRule2.test(str) && (str.search(/[a-z]/ig) >= 0) && (str.search(/[!@#$%^*+=-]/g) >= 0)) {
			pwVaild = true;
		}

		if(pwRule3.test(str) && (str.search(/[0-9]/g) >= 0) && (str.search(/[!@#$%^*+=-]/g) >= 0)) {
			pwVaild = true;
		}
	} else if(str.length >= 8) {
		if(pwRule4.test(str)) {
			if((str.search(/[a-z]/ig) >= 0) && (str.search(/[0-9]/g) >= 0) && (str.search(/[!@#$%^*+=-]/g) >= 0)) {
				pwVaild = true;
			}
		}
	}

	if(pwVaild==false){
		alert('비밀번호는 영문, 숫자, 특수문자 중 2개 이상의 조합으로 10자 이상 또는 3개 이상의 조합으로 8자 이상 사용하세요.');
		return false;
	}
	
	return true;
}


//로그인
function LoginSubmit() {
	var checked_value = $(":radio[name='MemberType1']:checked").val();

	if (checked_value == undefined) {
		checked_value = '';
	}

	if (checked_value == '') {
		alert('회원구분을 선택하세요.');
		return;
	}

	if ($('#ID1').val() == '') {
		alert('아이디를 입력하세요.');
		$('#ID1').focus();
		return;
	}

	if ($('#Pwd1').val() == '') {
		alert('비밀번호를 입력하세요.');
		$('#Pwd1').focus();
		return;
	}

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();
	var ScrollPosition = $(window).scrollTop();

	$("div[id='SysBg_White']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '380px',
			left: LocWidth,
			opacity: '0.5',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	document.LoginForm.MemberType.value = checked_value;
	document.LoginForm.action = '/m_public/member/login_ok.php';
	document.LoginForm.submit();
}

function TopLoginSubmit() {
	var checked_value = $(":radio[name='MemberType']:checked").val();

	if (checked_value == undefined) {
		checked_value = '';
	}

	if (checked_value == '') {
		alert('회원구분을 선택하세요.');
		return;
	}

	if ($('#ID_top').val() == '') {
		alert('아이디를 입력하세요.');
		$('#ID_top').focus();
		return;
	}

	if ($('#Pwd_top').val() == '') {
		alert('비밀번호를 입력하세요.');
		$('#Pwd_top').focus();
		return;
	}

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();
	var ScrollPosition = $(window).scrollTop();

	$("div[id='SysBg_White']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '100px',
			left: LocWidth,
			opacity: '0.5',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	document.TopLoginForm.action = '/m_public/member/login_ok.php';
	document.TopLoginForm.submit();
}

//수강신청
function Inquiry(){
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 500;
	var ScrollPosition = $(window).scrollTop() + 200;
	
	$("div[id='SysBg_Black']").css({
		width: body_width,
		height: body_height,
		opacity: '0.4',
		position: 'absolute',
		'z-index': '999',
	}).show();
	
	$('#DataResult').load('/m_archive/main/inquiry_pop.php', { t: '1'}, function () {
		$("div[id='DataResult']").css({
			top: ScrollPosition,
			left: body_width / 2 - 310,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '1000',
		}).show();
		$('html').css('overflow', 'hidden');
	});
}

//수강신청 등록
function InsertInquiry(){
	var form = $("form[name='InquiryForm']");
	if (form) {
		if ($("#CompanyName").val() == '') {
			alert('회사명을 입력하세요.');
			$("#CompanyName").focus();
			return;
		}
		if ($("#Name").val() == '') {
			alert('이름을 입력하세요.');
			$("#Name").focus();
			return;
		}
		if ($('#Phone01').val() == '') {
			alert('연락처를 입력하세요.');
			$('#Phone01').focus();
			return;
		}
		if ($('#Phone02').val() == '') {
			alert('연락처를 입력하세요.');
			$('#Phone02').focus();
			return;
		}
		if ($('#Phone03').val() == '') {
			alert('연락처를 입력하세요.');
			$('#Phone03').focus();
			return;
		}
		if (IsNumber($('#Phone01').val()) == false) {
			alert('연락처는 숫자만 입력하세요.');
			$('#Phone01').focus();
			return;
		}
		if (IsNumber($('#Phone02').val()) == false) {
			alert('연락처는 숫자만 입력하세요.');
			$('#Phone02').focus();
			return;
		}
		if (IsNumber($('#Phone03').val()) == false) {
			alert('연락처는 숫자만 입력하세요.');
			$('#Phone03').focus();
			return;
		}
		var Email = $("#Email").val(); 
		if (Email == '') {
			alert('이메일을 입력하세요.');
			$("#Email").focus();
			return;
		}
		var regexp = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
	  	if (!regexp.test(Email)) {
	    	alert("올바른 이메일 주소가 아닙니다.");
	    	$("#Email").focus();
	    	return;
	  	}
		if ($("#Personnel").val() == '') {
			alert('예상인원을 입력하세요.');
			$("#Personnel").focus();
			return;
		}
		if (IsNumber($('#Personnel').val()) == false) {
			alert('예상인원은 숫자만 입력하세요.');
			$('#Personnel').focus();
			return;
		}
		if ($("#Contents").val() == '') {
			alert('문의내용을 입력하세요.');
			$("#Contents").focus();
			return;
		}
		if(!$("#Agree").is(':checked')){
			alert('동의여부를 체크해주세요.');
			$('input:checkbox[id="Agree"]').focus();
			return;
		}
		
		Yes = confirm('등록하시겠습니까?');
		if (Yes == true) {
			form.submit();
		}
	}else{
		console.error('cannot find a form');
	}
}


function CounselAsk(){
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 500;
	var ScrollPosition = $(window).scrollTop() + 200;

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$('#DataResult').load('/m_public/support/counsel_ask.php', { t: '1' }, function () {
		//$('html, body').animate({ scrollTop : 0 }, 300);
		$("div[id='DataResult']")
			.css({
				top: ScrollPosition,
				left: body_width / 2 - 260,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();

		$('html').css('overflow', 'hidden');
	});
}

//1:1상담 - 등록하기
function uploadCounsel(){
	var form = $("form[name='CounselForm']");
	if (form) {
		if ($('#Title').val() == '') {
			alert('제목을 입력하세요.');
			$('#Title').focus();
			return;
		}
		if ($('#Content').val() == '') {
			alert('내용을 입력하세요.');
			$('#Content').focus();
			return;
		}
		
		if ($('#SecurityCode').val() == '') {
			alert('보안코드를 입력하세요.');
			$('#SecurityCode').focus();
			return;
		}
		
		Yes = confirm('등록하시겠습니까?');
		if (Yes == true) {
			form.submit();
			$('.modal-bg').css('display','none');
			$('#modal01').hide();
			$('#modal01').removeAttr('style');
	
			$('html').removeAttr('style');
		}
	}else{
		console.error('cannot find a form');
	}
}

//아카이브 플레이어(차시있는 컨텐츠)
function ContentsPlayer2(LectureCode, Chapter_Number, Study_Seq, StudyLectureCode) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width;
	var body_height = $('html body').height() + 500;
	var ScrollPosition = $(window).scrollTop();

	$("div[id='SysBg_Black']")
		.css({
			width:  "100%",
			height: body_height,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '100',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '400px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('/m_player/player2.php', 
			{	Chapter_Number: Chapter_Number,
				LectureCode: LectureCode, 
                Study_Seq : Study_Seq, 
                StudyLectureCode : StudyLectureCode
			},
			function () {
		$('html, body').animate({ scrollTop: ScrollPosition + 100 }, 500);

		$("div[id='DataResult']")
			.css({
				top: ScrollPosition,
				left: currentWidth / 2 - 800,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
				'overflow-y' :'auto',
				'height':'100vh'
			})
			.fadeIn();
			//.draggable();

		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: ScrollPosition }, 500);

		var CloseBtnLeft = 1200;
		CloseBtnLeft = CloseBtnLeft / 2 - 38;

		$("div[id='CloseBtn']").css({
			top: '0',
			left: '0',
			opacity: '1.0',
		});

		$('html').css('overflow', 'hidden');
	});
}

//아카이브 진도체크
/*
function StudyProgressCheck(ProgressStep, CloseYN, ContentsURLSelect) {
	var LastStudy = '';

	//현재 컨테츠의 위치 확인
	if ($('#MultiContentType').val() == 'N') {
		if ($('#ContentsType').val() == 'A') {
			//플레쉬인 경우
			var page = document.getElementById('mPlayer').contentWindow.location.pathname;
			LastStudy = page.replace('/contents', '');
		}
		if ($('#ContentsType').val() == 'B') {
			//동영상인 경우
			if (ContentsURLSelect == 'A') LastStudy = parseInt(mPlayer.currentTime); else LastStudy = 30;
		}
	} else {
		if (ProgressStep == 'Start') LastStudy = '0'; else LastStudy = $('#PlayNum').val();
	}

	var Chapter_Number = $('#Chapter_Number').val();
	var LectureCode = $('#LectureCode').val();
	var Chapter_Seq = $('#Chapter_Seq').val();
	var Contents_idx = $('#Contents_idx').val();
	var ContentsDetail_Seq = $('#ContentsDetail_Seq').val();
	var ProgressTime = $('#StartTime').val();
	var CompleteTime = $('#CompleteTime').val();

	$.post(
		'/m_player/lecture_progress.php',
		{
			Chapter_Number: Chapter_Number,
			LectureCode: LectureCode,
			Chapter_Seq: Chapter_Seq,
			Contents_idx: Contents_idx,
			ContentsDetail_Seq: ContentsDetail_Seq,
			ProgressTime: ProgressTime,
			LastStudy: LastStudy,
			CompleteTime: CompleteTime,
			ProgressStep: ProgressStep,
		},
		function (data) {
			var parseData = $.parseJSON(data);

			if (CloseYN == 'Y') {
				location.reload();
			}
		}
	);
}
*/

function StudyProgressCheck(ProgressStep, CloseYN, ContentsURLSelect) {
    var timeCheck = $('#mPlayer').contents().find('.time1 .playerText').html();
    let  time;
    let  iframeCheckTime;
    
    if (!timeCheck){
        iframeCheckTime = 0;
    }else{
        time = timeCheck;
        iframeCheckTime = timeToSeconds(time);
    }

    var LastStudy = '';

    //현재 컨테츠의 위치 확인
    if ($('#MultiContentType').val() == 'N') {
        if ($('#ContentsType').val() == 'A') {
            //플레쉬인 경우
            var page = document.getElementById('mPlayer').contentWindow.location.pathname;
            LastStudy = page.replace('/contents', '');
        }
        if ($('#ContentsType').val() == 'B') {
            //동영상인 경우
            if (ContentsURLSelect == 'A') LastStudy = parseInt(mPlayer.currentTime); else LastStudy = 30;
        }
    } else {
        if (ProgressStep == 'Start') LastStudy = '0'; else LastStudy = $('#PlayNum').val();
    }

    $.post(
        '/m_player/lecture_progress.php',
        {
            Chapter_Number: $('#Chapter_Number').val(),
            LectureCode: $('#LectureCode').val(),
            Chapter_Seq: $('#Chapter_Seq').val(),
            Contents_idx: $('#Contents_idx').val(),
            ContentsDetail_Seq: $('#ContentsDetail_Seq').val(),
            ProgressTime: $('#StartTime').val(),
            LastStudy: LastStudy,
            CompleteTime: $('#CompleteTime').val(),
            ProgressStep: ProgressStep,
            iframeCheckTime: iframeCheckTime
        },
        function (data) {
            var parseData = $.parseJSON(data);
            if (CloseYN == 'Y') location.reload();
        }
    );
}

function resizeIframe(fr) {
	
    var screenWidth = window.innerWidth;

    var mPlayer_width = "100%";
	var	mPlayer_height  = (screenWidth * 750 / 1200) + "px";
	


	$("iframe[id='mPlayer']").prop('width', mPlayer_width);
	$("iframe[id='mPlayer']").prop('height', mPlayer_height);

	var CloseBtnLeft = mPlayer_width / 2 - 38;

	$("div[id='CloseBtn']").css({
		top: '20px',
		left: CloseBtnLeft,
		opacity: '1.0',
	});
}

var PlayerFrameWidth;
var PlayerFrameHeight;

//강의창 사이즈 조절
function PlayerResize() {
	if ($('#RightWindow').css('display') == 'none') {
		PlayerWinWidth = PlayerFrameWidth + 350;
		PlayerWinHeight = PlayerFrameHeight + 60;
		resizeTo(PlayerWinWidth, PlayerWinHeight);
		$('#RightWindow').show();
		$('#PlayerResizeImg').prop('src', '../m_images/player/flash_btn_close.png');
		$('#PlayerResizeImg').prop('alt', '학습정보 닫기');
	} else {
		PlayerWinWidth = PlayerFrameWidth + 30;
		PlayerWinHeight = PlayerFrameHeight + 60;
		resizeTo(PlayerWinWidth, PlayerWinHeight);
		$('#RightWindow').hide();
		$('#PlayerResizeImg').prop('src', '../m_images/player/flash_btn_open.png');
		$('#PlayerResizeImg').prop('alt', '학습정보 보기');
	}
}

function PlayerResizeIframe(fr) {
	var mPlayer_width = document.getElementById('mPlayer').contentWindow.document.body.scrollWidth;
	var mPlayer_height = document.getElementById('mPlayer').contentWindow.document.body.scrollHeight;

	if (mPlayer_width < 900) {
		mPlayer_width = 1150;
		mPlayer_height = 660;
	}

	if (mPlayer_height < 500) {
		mPlayer_height = 660;
	}

	PlayerFrameWidth = mPlayer_width;
	PlayerFrameHeight = mPlayer_height;

	$("iframe[id='mPlayer']").prop('width', PlayerFrameWidth);
	$("iframe[id='mPlayer']").prop('height', PlayerFrameHeight);

	//PlayerWinWidth = PlayerFrameWidth + 350;
	//PlayerWinHeight = PlayerFrameHeight + 60;

	//resizeTo(PlayerWinWidth,PlayerWinHeight);
}

//초단위로 수강시간 보여주는 부분
function StudyTimeCheck() {
	var AddTime = parseInt($('#StartTime').val()) + 1;

	$('#StartTime').val(AddTime);

	StudyTimeDisplay();
}

//초단위로 수강시간 보여주는 부분
function StudyTimeCheck() {
	var AddTime = parseInt($('#StartTime').val()) + 1;

	$('#StartTime').val(AddTime);

	StudyTimeDisplay();
}

function StudyTimeDisplay() {
	var StudyTime = parseInt($('#StartTime').val());

	curmin = Math.floor(StudyTime / 60);
	cursec = StudyTime % 60;
	curhour = Math.floor(curmin / 60);
	curmin = curmin % 60;

	if (curhour < 10) {
		curhour2 = '0' + curhour;
	} else {
		curhour2 = curhour;
	}

	if (curmin < 10) {
		curmin2 = '0' + curmin;
	} else {
		curmin2 = curmin;
	}

	if (cursec < 10) {
		cursec2 = '0' + cursec;
	} else {
		cursec2 = cursec;
	}

	curtime = curhour2 + ':' + curmin2 + ':' + cursec2;

	//$("#StudyTimeNow").val(curtime);
	$('#StudyTimeNow').html(curtime);

	//if(curhour>2) { //수강 시간이 2시간을 초과하면 강의창 종료
	//	self.close();
	//}
}

function LogInCheck() {
	$.post(
		'/m_public/member/login_check.php',
		{
			t: '1',
		},
		function (data, status) {
			if (data == 'O') {
				alert('세션이 만료되어 로그아웃 처리됩니다.');
				location.href = '/m_public/member/logout.php';
			}
			if (data == 'N') {
				alert('다른 기기에서 로그인하여 로그아웃 처리됩니다.');
				location.href = '/m_public/member/logout.php';
			}
		}
	);
}

function LogInCheckStudy() {
	$.post(
		'/m_public/member/login_check.php',
		{
			t: '1',
		},
		function (data, status) {
			if (data != 'Y') {
				alert('세션이 만료되어 로그아웃 처리됩니다.');
				location.href = '/m_public/member/logout.php';
			}
		}
	);
}

function CertificatePrintMulti(CompanyCode, LectureStart, LectureEnd, LectureCode, ServiceTypeYN, CertificatePrintOK) {
	if (CertificatePrintOK == 'N') {
		alert('수강마감 이후에 수료증 출력이 가능합니다.');
		return;
	}

	var url =
		'/m_public/mypage/certificate_pdf02.php?CompanyCode=' +
		CompanyCode +
		'&LectureStart=' +
		LectureStart +
		'&LectureEnd=' +
		LectureEnd +
		'&ServiceTypeYN=' +
		ServiceTypeYN +
		'&LectureCode=' +
		LectureCode;
	window.open(url, 'certi', 'scrollbars=yes, resizable=yes, left=400, width=820, height=700');
}

//좋아요 기능
function CourseLike(data, LectureCode, ID){
	event.stopPropagation(); //상단 div의 click이벤트 막기
	
	//로그인한경우만 사용가능
	if(ID){
		var clickID = $(data).attr('id'); //클릭한 강의의 id값 구하기
		
		var clickClass = $("i[id='"+clickID+"']").attr("class");
		var classA = "ph-light ph-heart";
		var classB = "ph-fill ph-heart";
		var clickVal = "";
		
		//좋아요 완료
		if(clickClass == classA){
			$("i[id='"+clickID+"']").attr("class", classB);
			$("i[id='"+clickID+"']").css("color", "red");
			clickVal = "like";
		//좋아요 취소
		}else{
			$("i[id='"+clickID+"']").attr("class", classA);
			$("i[id='"+clickID+"']").css("color", "");
			clickVal = "unlike";
		}
		$.post('/m_archive/contents/course_like.php', { LectureCode: LectureCode, clickVal: clickVal }, function (data) {
			if (data == 'like') {
				alert('나의학습실의 관심과정 메뉴에서 확인하실수 있습니다.');
			}
		});
	}else{
		alert('관심과정은 로그인 후 이용가능합니다.');
	}
}

function ManagerCourseCheck(LectureStart, LectureEnd, LectureCode, ID, Seq) {
	var currentWidth = $(window).width();
	var currentHeight = $(window).height();

	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var url = '/m_public/mypage/manager_trainee_list.php?LectureStart=' + LectureStart + '&LectureEnd=' + LectureEnd + '&LectureCode=' + LectureCode +'&ID=' + ID +'&Seq=' + Seq;
	window.open(url, 'manager_check', 'scrollbars=yes, resizable=no, top=0, left=0, width=' + currentWidth + ', height=' + currentHeight);
}

//수료증
function CertificatePrint(LectureCode) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 2000;
	var ScrollPosition = $(window).scrollTop();

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '400px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();
		
	$('#DataResult').load('/m_public/mypage/certificate_layer.php', { LectureCode: LectureCode }, function () {
		$('html, body').animate({ scrollTop: ScrollPosition + 100 }, 300);

		$("div[id='DataResult']")
			.css({
				top: ScrollPosition + 120,
				left: body_width / 2 - 200,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.fadeIn();

		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: ScrollPosition + 30 }, 300);

		$('html').css('overflow', 'hidden');
	});
}


function PlayInfoClose() {
	$('#StudyInformation').html('');
	$("div[id='StudyInformation']").hide();
	$('html, body').animate({ scrollTop: 0 }, 500);
}

//학습내용 질문하기
function PlayStudyCounselSubmit() {
	if ($('#Category').val() == '') {
		alert('문의종류를 선택하세요.');
		$('#Category').focus();
		return;
	}
	if ($('#Title').val() == '') {
		alert('제목을 입력하세요.');
		$('#Title').focus();
		return;
	}
	if ($('#Contents').val() == '') {
		alert('내용을 입력하세요.');
		$('#Contents').focus();
		return;
	}

	Yes = confirm('등록하시겠습니까?');
	if (Yes == true) {
		$('#SubmitBtn').hide();
		$('#WaitMag').show();
		CounselForm.submit();
	}
}


function PlayStudyCounsel(LectureCode, Contents_idx) {
	// if (browser == 'Explorer') {
	// 	top_position = 900;
	// 	left_position = 100;
	// 	scrollTop_position = 850;
	// } else {
	// 	top_position = 100;
	// 	left_position = 50;
	// 	scrollTop_position = 0;
	// }

    top_position = 100;
	left_position = 50;
	scrollTop_position = 0;


	$('#StudyInformation').load('/m_player/study_counsel.php', { LectureCode: LectureCode, Contents_idx: Contents_idx }, function () {
		$("div[id='StudyInformation']")
			.css({
				top: top_position,
				left: left_position,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '2000',
			})
			.show();

		$('html, body').animate({ scrollTop: scrollTop_position }, 500);
	});
}


//아카이브 리포트
function archiveReport(CompanyCode) {
    var url =
        '/include/archive_report.html?CompanyCode=' + CompanyCode;
    window.open(url, 'certi', 'scrollbars=yes, resizable=yes, left=400, width=820, height=700');
}

//수강후기 팝업
function SurveyPop(LectureCode) {
    top_position = 100;
	left_position = 50;
	scrollTop_position = 0;


	$('#StudyInformation').load('/m_player/survey_pop.php', { LectureCode: LectureCode}, function () {
		$("div[id='StudyInformation']")
			.css({
				top: top_position,
				left: left_position,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '2000',
			})
			.show();

		$('html, body').animate({ scrollTop: scrollTop_position }, 500);
	});
}

//수강후기 작성
function uploadSurvey() {
	if ($('#Title').val() == '') {
		alert('제목을 입력하세요.');
		$('#Title').focus();
		return;
	}
	if ($('#Contents').val() == '') {
		alert('내용을 입력하세요.');
		$('#Contents').focus();
		return;
	}

	Yes = confirm('등록하시겠습니까?');
	if (Yes == true) {
		SurveyForm.submit();
	}
}

//교육담당자 수강생별 역량진단 확인
function TestResult(loginId){
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 500;
	var ScrollPosition = $(window).scrollTop() + 50;

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$('#DataResult').load('manager_test_result.php', { loginId: loginId }, function () {
		//$('html, body').animate({ scrollTop : 0 }, 300);
		$("div[id='DataResult']")
			.css({
				top: ScrollPosition,
				left: '50%',
				transform:'translateX(-50%)',
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
				background:'#fff',
				padding:50,
				'border-radius':'50px'
			})
			.show();

	});
}


//회원가입
//전체 선택
function JoinAgreeAllCheck() {
	if ($('#AllCheck').is(':checked') == true) {
		$('#Agree01').prop('checked', true);
		$('#Agree02').prop('checked', true);
		$('#Agree03').prop('checked', true);
		$('#Mailling').prop('checked', true);
		$('#Marketing').prop('checked', true);
		$('#chk5Email').prop('checked', true);
		$('#chk5Sms').prop('checked', true);
	} else {
		$('#Agree01').prop('checked', false);
		$('#Agree02').prop('checked', false);
		$('#Agree03').prop('checked', false);
		$('#Mailling').prop('checked', false);
		$('#Marketing').prop('checked', false);
		$('#chk5Email').prop('checked', false);
		$('#chk5Sms').prop('checked', false);
	}
}
//동의여부 체크
function JoinAgreeCheck() {	
	if(($('#Agree01').is(':checked') == false)||($('#Agree02').is(':checked') == false)||($('#Agree03').is(':checked') == false)||($('#Mailling').is(':checked') == false)||($('#Marketing').is(':checked') == false)){
		$('#AllCheck').prop('checked', false);
		if(($('#Marketing').is(':checked') == false)){
			$('#chk5Email').prop('checked', false);
			$('#chk5Sms').prop('checked', false);
		}
	}else{
		$('#AllCheck').prop('checked', true);
		if(($('#Marketing').is(':checked') == true)){
			$('#chk5Email').prop('checked', true);
			$('#chk5Sms').prop('checked', true);
		}
	}
}

// 동의 여부 체크 - 이메일/SMS
function JoinAgreeCheckA() {	
    if ($('#chk5Sms').is(':checked') || $('#chk5Email').is(':checked')) {
        $('#Marketing').prop('checked', true);
    } else {
        $('#Marketing').prop('checked', false);
    }

    // 필수 항목 확인
    if ($('#Agree01').is(':checked') && 
        $('#Agree02').is(':checked') && 
        $('#Agree03').is(':checked') && 
        $('#Mailling').is(':checked') && 
        $('#Marketing').is(':checked')) {
        $('#AllCheck').prop('checked', true);
    } else {
        $('#AllCheck').prop('checked', false);
    }
}

//필수동의여부 체크하지 않은경우, 동의여부 체크
function termsAgree() {
	var pwchg_value = $("#pwchg").val();
	
	if ($('#Agree01').is(':checked') == false) {
		alert('이용약관에 동의하여야 회원가입이 가능합니다.');
		return false;
	}	
	if ($('#Agree02').is(':checked') == false) {
		alert('개인정보 수집 및 이용에 동의하여야 회원가입이 가능합니다.');
		return false;
	}
	if ($('#Agree03').is(':checked') == false) {
		alert('개인정보의 제3자 제공에 동의하여야 회원가입이 가능합니다.');
		return false;
	}
	
	document.AfterAgreeForm.pwchg.value = pwchg_value;
	document.AfterAgreeForm.action = '/m_public/member/term_state_update.php';
	document.AfterAgreeForm.submit();
}


function PassFirstChange(ID) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 1000;



	$("div[id='Roading']")
		.css({
			top: '200px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '2000',
		})
		.show();

	$('#DataResult').load('/m_public/mypage/pass_first_change.php', { ID: ID }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 200 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '350px',
				left: '50%',
				'transform': 'translateX(-50%)',
				opacity: '1.0',
				position: 'absolute',
				'z-index': '2100',
			})
			.show();

		$('html').css('overflow', 'hidden');

		$("div[id='SysBg_Black']")
		.hide();

	});
}

function PassFirstChangeSubmit() {
	if ($('#PwdChange').val() == '') {
		alert('비밀번호를 입력하세요.');
		$('#PwdChange').focus();
		return;
	}

	if (CheckPassword($('#PwdChange').val()) == false) {
		return;
	}

	if ($('#PwdChange2').val() == '') {
		alert('비밀번호 확인을 입력하세요.');
		$('#PwdChange2').focus();
		return;
	}

	if ($('#PwdChange').val() !== $('#PwdChange2').val()) {
		alert('비밀번호와 비밀번호 확인이 일치하지 않습니다.');
		$('#PwdChange2').focus();
		return;
	}

	FirstPassForm.submit();
}

function PlayDenyClose() {
	$("div[id='Roading']").hide();
	$("div[id='DataResult']").html('');
	$("div[id='DataResult']").hide();
	$("div[id='SysBg_White']").hide();
	$("div[id='SysBg_Black']").hide();
	$('html').css('overflow', '');
}

function PlayStudyAuth(Chapter_Number, LectureCode, Study_Seq, StudyLectureCode) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height() + 1500;
	var ScrollPosition = $(window).scrollTop() + 500;

	$("div[id='SysBg_Black']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$('#DataResult').load(
		'/m_player/play_study_auth.php',
		{ Chapter_Number: Chapter_Number, LectureCode: LectureCode, Study_Seq : Study_Seq, StudyLectureCode : StudyLectureCode},
		function () {
			//$('html, body').animate({ scrollTop : 0 }, 300);
			$("div[id='DataResult']")
				.css({
					top: '300px',
					left: body_width / 2 - 260,
					opacity: '1.0',
					position: 'absolute',
					'z-index': '1000',
				})
				.show();

			//$('html').css("overflow","hidden");
		}
	);
}

function StudyPDS_Scrap(idx, mode) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();
	if(mode == 'Guest'){
		alert('로그인 후 이용해주세요.');
		location.href = "/m_public/member/login.html";
	}else if (mode == 'Regist') {
		msg = '현재 학습자료를 찜 하시겠습니까?';
	}else if(mode == 'Delete'){
		msg = '현재 학습자료를 찜 취소 하시겠습니까?';
	}

	Yes = confirm(msg);
	if (Yes == true) {
		$("div[id='SysBg_Black']")
			.css({
				width: body_width,
				height: body_height,
				opacity: '0.4',
				position: 'absolute',
				'z-index': '99',
			})
			.show();

		$("div[id='Roading']")
			.css({
				top: '350px',
				left: LocWidth,
				opacity: '0.6',
				position: 'absolute',
				'z-index': '200',
			})
			.show();

		$('#DataResult').load('/m_public/support/edudata_scrap.php', { idx: idx, mode: mode }, function () {
			$("div[id='Roading']").hide();

			$('html, body').animate({ scrollTop: 0 }, 500);
			$("div[id='DataResult']")
				.css({
					top: '200px',
					left: body_width / 2 - 250,
					opacity: '1.0',
					position: 'absolute',
					'z-index': '1000',
				})
				.show();

			$('html').css('overflow', 'hidden');
		});
	}
}