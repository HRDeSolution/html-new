/* 기본 세팅 START --------------------------------------------------------------------------------------- */
if (location.protocol == 'http:') {
	location.href = location.href.replace('http://', 'https://');
}

if (location.hostname == 'hrdeedu.co.kr') {
	location.href = location.href.replace(location.hostname, 'www.hrdeedu.co.kr');
}
/* 기본 세팅 END --------------------------------------------------------------------------------------- */

/* 공통 함수 START --------------------------------------------------------------------------------------- */
function MM_swapImgRestore() {
	//v3.0
	var i,
		x,
		a = document.MM_sr;
	for (i = 0; a && i < a.length && (x = a[i]) && x.oSrc; i++) x.src = x.oSrc;
}

function MM_preloadImages() {
	//v3.0
	var d = document;
	if (d.images) {
		if (!d.MM_p) d.MM_p = new Array();
		var i,
			j = d.MM_p.length,
			a = MM_preloadImages.arguments;
		for (i = 0; i < a.length; i++)
			if (a[i].indexOf('#') != 0) {
				d.MM_p[j] = new Image();
				d.MM_p[j++].src = a[i];
			}
	}
}

function MM_findObj(n, d) {
	//v4.01
	var p, i, x;
	if (!d) d = document;
	if ((p = n.indexOf('?')) > 0 && parent.frames.length) {
		d = parent.frames[n.substring(p + 1)].document;
		n = n.substring(0, p);
	}
	if (!(x = d[n]) && d.all) x = d.all[n];
	for (i = 0; !x && i < d.forms.length; i++) x = d.forms[i][n];
	for (i = 0; !x && d.layers && i < d.layers.length; i++) x = MM_findObj(n, d.layers[i].document);
	if (!x && d.getElementById) x = d.getElementById(n);
	return x;
}

function MM_swapImage() {
	//v3.0
	var i,
		j = 0,
		x,
		a = MM_swapImage.arguments;
	document.MM_sr = new Array();
	for (i = 0; i < a.length - 2; i += 3)
		if ((x = MM_findObj(a[i])) != null) {
			document.MM_sr[j++] = x;
			if (!x.oSrc) x.oSrc = x.src;
			x.src = a[i + 2];
		}
}

function MM_openBrWindow(theURL, winName, features) {
	//v2.0
	window.open(theURL, winName, features);
}

//페이지 이동 함수
function pageRun(num) {
	document.listScriptForm.pg.value = num;
	document.listScriptForm.submit();
}

//상세페이지 이동 함수
function readRun(num) {
	document.ReadScriptForm.idx.value = num;
	document.ReadScriptForm.submit();
}

//세자리마다 자릿수 찍기
function FormatNumber2(num) {
	if (isNaN(num)) {
		alert('문자는 사용할 수 없습니다.');
		return 0;
	}
	if (num == 0) return num;
	temp = new Array();
	fl = '';
	co = 3;
	if (num < 0) {
		num = num * -1;
		fl = '-';
	}
	num = new String(num);
	num_len = num.length;
	while (num_len > 0) {
		num_len = num_len - co;
		if (num_len < 0) {
			co = num_len + co;
			num_len = 0;
		}
		temp.unshift(num.substr(num_len, co));
	}
	return fl + temp.join(',');
}

//숫자 유효성 체크1
function IsNumber(num) {
	var x = num;
	var anum = /(^\d+$)|(^\d+$)/;
	if (anum.test(x)) testresult = true;
	else {
		testresult = false;
	}
	return testresult;
}

//숫자 유효성 체크2
function IsNumber2(num) {
	var x = num;
	var anum = /(^\d+$)|(^\d+\.\d+$)/;
	if (anum.test(x)) testresult = true;
	else {
		testresult = false;
	}
	return testresult;
}

//한글 유효성 체크
function hanCheck(ID) {
	var digits = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
	var temp;
	for (i = 0; i < ID.length; i++) {
		temp = ID.substring(i, i + 1);
		if (digits.indexOf(temp) == -1) {
			return false;
		}
	}
	return true;
}

//라디오 버튼 체크
function hasCheckedRadio(input) {
	if (input.length > 1) {
		for (var inx = 0; inx < input.length; inx++) {
			if (input[inx].checked) return true;
		}
	} else {
		if (input.checked) return true;
	}
	return false;
}

//주민번호 유효성 체크
function fn_jumin_validate(num1, num2) {
	//내국인인 경우
	if (num2.substring(0, 1) == '1' || num2.substring(0, 1) == '2' || num2.substring(0, 1) == '3' || num2.substring(0, 1) == '4') {
		var arrNum1 = new Array(); // 주민번호 앞자리숫자 6개를 담을 배열
		var arrNum2 = new Array(); // 주민번호 뒷자리숫자 7개를 담을 배열

		// -------------- 주민번호 -------------
		for (var i = 0; i < num1.length; i++) {
			arrNum1[i] = num1.charAt(i);
		} // 주민번호 앞자리를 배열에 순서대로 담는다.

		for (var i = 0; i < num2.length; i++) {
			arrNum2[i] = num2.charAt(i);
		} // 주민번호 뒷자리를 배열에 순서대로 담는다.

		var tempSum = 0;

		for (var i = 0; i < num1.length; i++) {
			tempSum += arrNum1[i] * (2 + i);
		} // 주민번호 검사방법을 적용하여 앞 번호를 모두 계산하여 더함

		for (var i = 0; i < num2.length - 1; i++) {
			if (i >= 2) {
				tempSum += arrNum2[i] * i;
			} else {
				tempSum += arrNum2[i] * (8 + i);
			}
		} // 같은방식으로 앞 번호 계산한것의 합에 뒷번호 계산한것을 모두 더함

		if ((11 - (tempSum % 11)) % 10 != arrNum2[6]) {
			alert('올바른 주민번호가 아닙니다.');
			return false;
		}

		//외국인인 경우
	} else {
		var fgnno = num1 + num2;
		var sum = 0;
		var odd = 0;

		buf = new Array(13);

		for (i = 0; i < 13; i++) {
			buf[i] = parseInt(fgnno.charAt(i));
		}

		odd = buf[7] * 10 + buf[8];

		if (odd % 2 != 0) {
			alert('올바른 주민번호가 아닙니다.');
			return false;
		}

		if (buf[11] != 6 && buf[11] != 7 && buf[11] != 8 && buf[11] != 9) {
			alert('올바른 주민번호가 아닙니다.');
			return false;
		}

		multipliers = [2, 3, 4, 5, 6, 7, 8, 9, 2, 3, 4, 5];

		for (i = 0, sum = 0; i < 12; i++) {
			sum += buf[i] *= multipliers[i];
		}

		sum = 11 - (sum % 11);

		if (sum >= 10) {
			sum -= 10;
		}

		sum += 2;

		if (sum >= 10) {
			sum -= 10;
		}

		if (sum != buf[12]) {
			alert('올바른 주민번호가 아닙니다.');
			return false;
		}
	}

	return true;
}

String.prototype.trim = function () {
	return this.replace(/(^\s*)|(\s*$)/g, '');
};

//과정코드 체크
function LectureCodeCheck(LectureCode) {
	var digits = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
	var temp;
	for (i = 0; i < LectureCode.length; i++) {
		temp = LectureCode.substring(i, i + 1);
		if (digits.indexOf(temp) == -1) {
			return false;
		}
	}
	return true;
}

//아이디 유효성 검사
function ID_Validity(str) {
	if (str == '') {
		alert('아이디를 입력하세요.');
		return false;
	}
	if (str.length < 4 || str.length > 20) {
		alert('아이디는 4자이상 20자 이내로 입력하세요.');
		return false;
	}
	if (hanCheck(str) == false) {
		alert('아이디는 영문/숫자만 입력 가능합니다.');
		return false;
	}
}

//회원아이디 중복체크
function MemberIDCheck() {
	var ID = $('#ID').val();

	if (ID_Validity(ID) == false) {
		return;
	}

	$("span[id='id_check_msg']").load('./member_id_check.php', { ID: ID }, function () {});
}

//아이디 중복체크
function IDCheck() {
	var ID = $('#ID').val();

	if (ID_Validity(ID) == false) {
		return;
	}

	$("span[id='id_check_msg']").load('./id_check.php', { ID: ID }, function () {});
}

//사업자번호 중복체크
function CompanyCodeCheck() {
	var CompanyCode = $('#CompanyCode').val();

	if (CompanyCode == '') {
		alert('사업자번호를 입력하세요.');
		return;
	}

	if (IsNumber(CompanyCode) == false) {
		alert('사업자번호는 숫자만 입력하세요.');
		return;
	}

	if (CompanyCode.length != 10) {
		alert('사업자번호는 10자리 숫자만 입력하세요.');
		return;
	}

	$("span[id='CompanyCode_check_msg']").load('./companycode_check.php', { CompanyCode: CompanyCode }, function () {});
}

//사업주 아이디 중복체크
function CompanyIDCheck() {
	var CompanyID = $('#CompanyID').val();

	if (ID_Validity(CompanyID) == false) {
		return;
	}

	$("span[id='CompanyID_check_msg']").load('./companyid_check.php', { CompanyID: CompanyID }, function () {});
}

//영업담당자 검색
function SalesManagerSearch() {
	var SalesName = $('#SalesName').val();
	/*
	if(SalesName=="") {
		alert("영업담당자명을 입력하세요.");
		return;
	}
	*/
	$("span[id='SalesManagerHtml']").load('./salesmanager_search.php', { SalesName: SalesName }, function () {});
}

//회원 기업정보 찾기
function MemberCompanySearch() {
	var CompanyName = $('#CompanyName').val();

	if (CompanyName == '') {
		alert('회사명을 입력하세요.');
		return;
	}

	$("span[id='company_search_result']").load('./member_company_search.php', { CompanyName: CompanyName }, function () {});
}

function ManagerCompanyRegist(ID, mode, idx) {
	var url = './member_company_write.php?ID=' + ID + '&mode=' + mode + '&idx=' + idx;
	window.open(url, 'ad', 'scrollbars=no, resizable=no, left=400, width=660, height=650');
}

//소속 회사 찾기
function MemberCompanySearchSelect() {
	var CompanyResult = $('#CompanyResult').val();

	if (CompanyResult == '') {
		alert('소속된 회사를 선택하세요.');
		return;
	}

	CompanyResult_Arrary = CompanyResult.split('|');

	$('#CompanyCode').val(CompanyResult_Arrary[0]);
	$('#CompanyName').val(CompanyResult_Arrary[1]);

	$('#company_search_result').html('');
}

//개인정보 연람 사유
function InformationProtectionUrl(TB, url, Exp, send_url, ID) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$('#DataResult2').load('./Information_protection_regist2.php', { TB: TB, url: url, Exp: Exp, send_url: send_url, ID: ID }, function () {
		//$("div[id='Roading']").hide();

		$("div[id='DataResult2']")
			.css({
				top: '250px',
				width: '700px',
				left: body_width / 2 - 400,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '10000',
			})
			.show();
	});
}

function InformationProtectionSubmitOk2() {
    let content = document.InformationProtectionForm.Content.value.trim();

    if (content === '') {
        alert('사유를 입력하세요.');
        return;
    }
	
    let allowed = /^[가-힣a-zA-Z0-9\s]+$/;
    if (!allowed.test(content)) {
        alert('사유에는 한글, 영문, 숫자, 공백만 입력 가능합니다.');
        return;
    }

    let Yes = confirm('개인정보 열람사유를 작성하시겠습니까?');
    if (Yes) {
        document.InformationProtectionForm.submit();
    }
}

//창닫기
function DataResultClose2() {
	$("div[id='DataResult2']").html('');
	$("div[id='DataResult2']").hide();
}

//강의날짜 조회
function LectureTermeSearch() {
	var SubmitFunction = $('#SubmitFunction').val();

	$("span[id='LectureTermeResult']").load(
		'./study_lectureterme.php',
		{ SearchYear: $('#SearchYear').val(), SearchMonth: $('#SearchMonth').val(), ctype: $('#ctype').val(), SubmitFunction: SubmitFunction },
		function () {
			$("#StudyPeriod").select2();
			changeSelect2Style();
		}
	);
}

//사업주 검색및적용
function CompanySearchAutoCompleteGo(checkType) {
	var str = $('#CompanyName').val();
	str2 = str.replace(/\s/gi, '');
	str_len = str2.length;

	if (str_len > 0) {
		$('#CompanyAutoCompleteResult').load('./study_company_search_autocomplete.php', { CompanyName: str , checkType: checkType }, function () {
			$('#CompanyAutoCompleteResult').show();
		});
	} else {
		$('#CompanyAutoCompleteResult').html('');
		$('#CompanyAutoCompleteResult').hide();
	}
}
function CompanySearchAutoCompleteApply(CompanyName, CompanyCode,checkType) {
	$('#CompanyName').val(CompanyName);
	$('#CompanyCode').val(CompanyCode);
	if(checkType == 'A'){
		CompanySearchLectureTermeSearch(CompanyCode);
		$('#CompanyTerm').show();
	}
	CompanySearchAutoCompleteClose();
}
function CompanySearchAutoCompleteClose() {
	$('#CompanyAutoCompleteResult').html('');
	$('#CompanyAutoCompleteResult').hide();
}
function CompanySearchLectureTermeSearch(CompanyCode) {
	var SubmitFunction = $('#SubmitFunction').val();
	
	if(CompanyCode == ''){
		$("span[id='CompanySearchLectureTermeResult']").html('&nbsp;&nbsp;<B>사업주를 입력하세요.</B>');
	}else{
		var currentWidth = $(window).width();
        var LocWidth = currentWidth / 2;
        var body_width = screen.width - 20;
        var body_height = $('html body').height();
        
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
            top: '350px',
            left: LocWidth,
            opacity: '1.0',
            position: 'absolute',
            'z-index': '200',
        })
        .show();
        
        $("span[id='CompanySearchLectureTermeResult']").load(
    		'./study_company_lectureterme.php',
    		{ SearchYear: $('#SearchYear2').val(), SearchMonth: $('#SearchMonth2').val(), ctype: $('#ctype').val(), CompanyCode : CompanyCode, SubmitFunction: SubmitFunction },
    		function () {
    			$("div[id='SysBg_White']").hide();
                $("div[id='Roading']").hide();
    		}
    	);
	}
}

function SearchGubunChange(str) {
	if (str == 'A') {
		$('#SearchGubunResult1').show();
		$('#SearchGubunResult2').hide();
		CompanySearchAutoCompleteClose();
		$('#CompanySearchLectureTermeResult').hide();
	}
	if (str == 'B') {
		$('#SearchGubunResult1').hide();
		$('#SearchGubunResult2').show();
		$('#CompanySearchLectureTermeResult').show();
	}
}

//수강생 상세정보 팝업
function MemberInfo(ID) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_Black_Click']")
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
			top: '450px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./member_info_pop.php', { ID: ID }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 200 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '250px',
				width: '1200px',
				left: body_width / 2 - 500,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show()
			.draggable();
	});
}

//과정 상세정보 팝업
function CourseInfo(LectureCode) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_Black_Click']")
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
			top: '450px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./course_info_pop.php', { LectureCode: LectureCode }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 200 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '250px',
				width: '1200px',
				left: body_width / 2 - 500,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

//회사 상세정보 팝업
function CompanyInfo(CompanyCode) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_Black_Click']")
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
			top: '450px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./company_info_pop.php', { CompanyCode: CompanyCode }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 200 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '250px',
				width: '1200px',
				left: body_width / 2 - 500,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

//일차별수강시간 팝업
function StudyTimeInfo(ID, today) {
	//로그아웃 시간 초기화
	console.log(ID, today);
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_Black_Click']")
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
			top: '450px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./study_time_info_pop.php', { ID: ID, today: today}, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 200 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '250px',
				width: '1000px',
				left: body_width / 2 - 500,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

//진도율 상세정보 팝업
function ProgressInfo(ID, LectureCode, Study_Seq) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_Black_Click']")
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
			top: '450px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./progress_info_pop.php', { ID: ID, LectureCode: LectureCode, Study_Seq: Study_Seq }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 200 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '250px',
				width: '1000px',
				left: body_width / 2 - 500,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

//진도율로그 상세정보 팝업
function ProgressInfoLog(i, ID, LectureCode, Study_Seq) {
	$("tr[id='ProgressDetail']:eq(" + i + ')').toggle();

	if ($("tr[id='ProgressDetail']:eq(" + i + ')').css('display') == 'none') {
	} else {
		$("div[id='Progress_log']:eq(" + i + ')').load(
			'./progress_info_pop_log.php',
			{ ID: ID, LectureCode: LectureCode, Study_Seq: Study_Seq },
			function () {}
		);
	}
}
/* 공통 함수 END --------------------------------------------------------------------------------------- */


/* 파일 업로드 START --------------------------------------------------------------------------------------- */
function UploadFile(Ele, EleArea, FileType) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./upload_file.php', { Ele: Ele, EleArea: EleArea, FileType: FileType }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '350px',
				width: '800px',
				left: body_width / 2 - 550,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

function UploadFileSubmitOk() {
	if ($('#file').val() == '') {
		alert('파일을 선택하세요.');
		$('#file').focus();
		return;
	}

	Yes = confirm('업로드 하시겠습니까?');
	if (Yes == true) {
		$('#SubmitBtn2').hide();
		$('#Waiting2').show();
		UploadForm1.submit();
	}
}

function DataResultClose() {
	$("div[id='Roading']").hide();
	$("div[id='SysBg_White']").hide();
	$("div[id='SysBg_Black']").hide();
	$("div[id='SysBg_Black_Click']").hide();
	$("div[id='DataResult']").html('');
	$("div[id='DataResult']").hide();
	$("div[id='DataResult2']").html('');
	$("div[id='DataResult2']").hide();
}

function UploadFileDelete(Ele, EleArea, Folder) {
	Yes = confirm('파일을 서버에서 삭제 하시겠습니까?');
	if (Yes == true) {
		var fakeName = $('#' + Ele).val()
		$.ajax({
	        url: "./file_delete.php",
	        method: "GET",
	        data: {
	          "fakeName": fakeName,
	          "Folder" : Folder
	        },
	        success(res) {
	          console.log(res);
	          alert('삭제되었습니다.');
	        },
	        error(err) {
	          console.log(err)
	          alert('error');
	        }
	    });
		$('#' + Ele).val('');
		$('#' + EleArea).html('');
	}
}
/* 파일 업로드 END --------------------------------------------------------------------------------------- */


/* 회원관리>수강생관리 START --------------------------------------------------------------------------------------- */
//회원관리>수강생관리 - 회원으로 로그인
function MemberLoginSubmit(ID) {
	if (confirm('[' + ID + ']로 로그인 하시겠습니까?') == true) {
		LoginForm.submit();
	}
}

//회원관리>수강생관리 - 비밀번호 초기화
function PasswordInit() {
	if (confirm('비밀번호를 1111 으로 초기화 하시겠습니까?') == true) {
		PasswordForm.submit();
	}
}

//회원관리>수강생관리 - 회원 탈퇴처리
function MemberOut() {
	if (confirm('현재회원을 탈퇴처리 하시겠습니까?') == true) {
		OutForm.submit();
	}
}

//회원관리>수강생관리 - 회원 미사용 처리
function ChangeMemberUseYN(useYn) {
	var msg = '';
	if(useYn=="Y"){
		msg = '현재회원을 미사용처리 하시겠습니까?';
	}else{
		msg = '현재회원을 사용처리 하시겠습니까?';
	}
	if (confirm(msg) == true) {
		UseYnForm.submit();
	}
}

//회원관리>수강생관리 - 회원 데이터 삭제
function deletionDetail(id){
	//로그아웃 시간 초기화
	$('#NowTime').val('0');
	
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();
	$('#DataResult').load('./deletion_detail.php', { id:id }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '150px',
				width: '850px',
				left: body_width / 2 - 420,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}
function DeleteMemberData(id){
	if (document.deletionDetailForm.reason.value == '') {
		alert('사유를 입력하세요.');
		return;
	}
	if(confirm(id+' 회원의 데이터를 삭제하시겠습니까?') == true){
		document.deletionDetailForm.submit();
	}
}

//회원관리>수강생관리 - 전화상담내역 신규작성
function CounselPhoneRegist(ID, mode, idx) {
	var url = './counsel_phone_write.php?ID=' + ID + '&mode=' + mode + '&idx=' + idx;
	window.open(url, 'ad', 'scrollbars=no, resizable=no, left=400, width=660, height=650');
}

//회원관리>수강생관리 - 전화상담내역 엑셀다운로드
function CounselPhoneExcel(id) {
	var address = './member_counselPhone_excel.php?id=' + id;
	window.location.href = address;
}
/* 회원관리>수강생관리 END --------------------------------------------------------------------------------------- */


/* 회원관리>수강등록 START --------------------------------------------------------------------------------------- */
//회원관리>수강등록 - 수강생 검색
function LectureRegIDSearch() {
	var TempSearchID = $('#TempSearchID').val();
	if(TempSearchID=="") {
		alert("수강생 아이디 또는 이름을 입력하세요.");
		return;
	}
	$("span[id='SearchIDResult']").load('./lecture_reg_id_search.php', { TempSearchID: TempSearchID }, function () {});
}

//회원관리>수강등록 - 첨삭강사 검색
function LectureRegTutorSearch() {
	var TempSearchTutor = $('#TempSearchTutor').val();
	/*
	if(TempSearchTutor=="") {
		alert("첨삭강사의 아이디 또는 이름을 입력하세요.");
		return;
	}
	*/
	$("span[id='SearchTutorResult']").load('./lecture_reg_tutor_search.php', { TempSearchTutor: TempSearchTutor }, function () {});
}

//회원관리>수강등록 - 수강등록 엑셀 list
function ExcelUploadListRoading(str) {
	$("div[id='ExcelUploadList']").html('<br><br><br><center><img src="/images/loader.gif" alt="로딩중" /></center>');

	$("div[id='ExcelUploadList']").load('./lecture_reg_list.php', { str: str }, function () {});
}

//회원관리>수강등록 - 엑셀list 변경
function LectureRegEdit(idx) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '550px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./lecture_reg_edit.php', { idx: idx }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 550 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '350px',
				width: '1200px',
				left: body_width / 2 - 750,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

//회원관리>수강등록 - 엑셀 데이터 저장
var LectureRegist_Seq_count = 0;

function LectureRegistSubmitOk() {
	LectureRegist_Seq_count = $("input[id='check_seq']").length;

	if (LectureRegist_Seq_count < 1) {
		alert('등록된 엑셀파일이 없습니다.');
	} else {
		Yes = confirm(
			'등록한 엑셀파일로 수강등록을 시작하시겠습니까?\n\n\n\n목록 우측 [상태]항목에서 수강등록 진행상황을 확인하실 수 있습니다.\n\n\n\n작업이 완료될 때까지 다른 페이지로 이동 또는 창을 닫지 마세요.'
		);
		if (Yes == true) {
			TimeCheckNo = 'N'; //로그아웃까지 남은 시간 실행 중지
			LectureRegistProcess(0);
		}
	}
}

function LectureRegistProcess(i) {
	if (i < LectureRegist_Seq_count) {
		i2 = i + 1;
		$("span[id='LectureRegResult']:eq(" + i + ')').html('처리중');
		$("span[id='LectureRegResult']:eq(" + i + ')').load('./lecture_reg_complete.php', { Seq: $("input[id='check_seq']:eq(" + i + ')').val() }, function () {
			setTimeout(function () {
				LectureRegistProcess(i2);
			}, 500);
		});
	} else {
		alert('수강등록 처리가 완료되었습니다.\n\n\n\n수강등록 중 오류가 발생한 부분은 갱신된 목록에서\n\n확인이 가능합니다.\n\n\n\n[확인]을 클릭하면 현재 목록이 갱신됩니다.');
		TimeCheckNo = 'Y'; //로그아웃까지 남은 시간 실행 다시 실행
		top.ExcelUploadListRoading('C');
	}
}
/* 회원관리>수강등록 END --------------------------------------------------------------------------------------- */


/* 회원관리>관리자/영업자/첨삭강사 카테고리 START --------------------------------------------------------------------------------------- */
//회원관리>관리자/영업자/첨삭강사 카테고리 - 하부 카테고리 추가
function DeptAdd(Dept, idx, ParentCategory, Deep, DeptString, mode) {
	var url = './dept_category_reg.php?Dept=' + Dept + '&idx=' + idx + '&ParentCategory=' + ParentCategory + '&Deep=' + Deep + '&DeptString=' + DeptString + '&mode=' + mode;
	window.open(url, 'ad', 'scrollbars=no, resizable=no, left=100, width=1300, height=700');
}

function DeptCategorySelect(Dept) {
	var url = './dept_category_select.php?Dept=' + Dept;
	window.open(url, 'ad', 'scrollbars=yes, resizable=no, left=400, width=800, height=600');
}
/* 회원관리>관리자/영업자/첨삭강사 카테고리 END --------------------------------------------------------------------------------------- */


/* 회원관리> 관리자/영업자/첨삭강사 리스트 START --------------------------------------------------------------------------------------- */
//회원관리> 관리자/영업자/첨삭강사 리스트 - 현재 아이디로 로그인
function ManagerLoginSubmit(ID) {
	if (confirm('[' + ID + ']로 로그인 하시겠습니까?') == true) {
		LoginForm.submit();
	}
}
/* 회원관리> 관리자/영업자/첨삭강사 리스트 END --------------------------------------------------------------------------------------- */


/* 독려관리>학습참여독려 START --------------------------------------------------------------------------------------- */
//독려관리>학습참여독려 - 조회
function StudySmsSearch() {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var SearchGubun = $(':radio[name="SearchGubun"]:checked').val();
	var CompanyName = $('#CompanyName').val();
	var OpenChapter = $('#OpenChapter').val();
	var SearchYear = $('#SearchYear').val();
	var SearchMonth = $('#SearchMonth').val();
	var StudyPeriod = $('#StudyPeriod').val();
	var StudyPeriod2 = $('#StudyPeriod2').val();
	var CompanyCode = $('#CompanyCode').val();
	var ID = $('#ID').val();
	var SalesID = $('#SalesID').val();
	var SalesTeam = $('#SalesTeam').val();
	var Progress1 = $('#Progress1').val();
	var Progress2 = $('#Progress2').val();
	var TutorStatus = $('#TutorStatus').val();
	var LectureCode = $('#LectureCode').val();
	var EduManager = $('#EduManager').val();
	var PassOk = $('#PassOk').val();
	var ServiceType = $('#ServiceType').val();
	var certCount = $('#certCount').val();
	var AbilityYN = $('#AbilityYN').val();
	var AbilityAfterYN = $('#AbilityAfterYN').val();
	
	var LectureStart = '';
	var LectureEnd = '';

	if (StudyPeriod == '' || StudyPeriod == undefined) {
		StudyPeriod = '';
	}
	if (StudyPeriod2 == '' || StudyPeriod2 == undefined) {
		StudyPeriod2 = '';
	}

	if (SearchGubun == 'A') {
		if (StudyPeriod != '') {
			StudyPeriod_array = StudyPeriod.split('~');
			LectureStart = StudyPeriod_array[0];
			LectureEnd = StudyPeriod_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (StudyPeriod2 != '') {
			StudyPeriod2_array = StudyPeriod2.split('~');
			LectureStart = StudyPeriod2_array[0];
			LectureEnd = StudyPeriod2_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (CompanyName == '') {
			alert('사업주명을 입력하세요.');
			return;
		}
	}
	
	if ((OpenChapter != '') && (IsNumber(OpenChapter) == false)) {
		alert('실시회차는 숫자만 입력하세요.');
		$('#OpenChapter').focus();
		return;
	}else if((OpenChapter != '') && (OpenChapter<1)){
		alert('실시회차는 1이상 숫자만 입력하세요.');
		$('#OpenChapter').focus();
		return;
	}


	if (Progress1 != '' || Progress2 != '') {
		if (IsNumber(Progress1) == false || IsNumber(Progress2) == false) {
			alert('진도율은 숫자만 입력하세요.');
			return;
		}
	}

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
			top: '350px',
			left: LocWidth,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$.post(
		'./study_sms_search_result.php',
		{
			SearchGubun: SearchGubun,
			CompanyName: CompanyName,
			OpenChapter: OpenChapter,
			SearchYear: SearchYear,
			SearchMonth: SearchMonth,
			StudyPeriod: StudyPeriod,
			CompanyCode: CompanyCode,
			ID: ID,
			SalesID: SalesID,
			SalesTeam: SalesTeam,
			Progress1: Progress1,
			Progress2: Progress2,
			TutorStatus: TutorStatus,
			LectureCode: LectureCode,
			EduManager: EduManager,
			PassOk: PassOk,
			ServiceType: ServiceType,
			certCount: certCount,
			AbilityYN: AbilityYN,
			AbilityAfterYN: AbilityAfterYN,
			LectureStart: LectureStart,
			LectureEnd: LectureEnd
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

var totalcount = 0;
var batching = false;

//독려관리>학습참여독려 - SMS/e-mail 발송
function StudySmsSend(send_mode) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	totalcount = $("input[name='check_seq']").length; //전체 건수
	var checked_value = $(':radio[name="MessageMode"]:checked').val();

	if (!checked_value) {
		alert('발송하려는 독려 내용 단계를 선택하세요.');
		return;
	}

	if (totalcount < 1) {
		alert('검색된 항목이 없습니다.');
		return;
	}

	switch (send_mode) {
		case 'sms':
			Msg = 'SMS를 발송합니다.';
			break;
		case 'email':
			Msg = '이메일을 발송합니다.';
			break;
	}

	$("div[id='SysBg_White']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$('#ProcesssRatio').show();

	Yes = confirm(
		'현재 검색 결과로 ' +
			Msg +
			'\n\n발송 작업은 처음부터 ' +
			totalcount +
			'번 항목까지 순차적으로 진행됩니다.\n\n작업이 완료 될 때 까지 기다려 주세요.\n\n\n\n작업을 진행하시려면 [확인]을 클릭하세요.'
	);
	if (Yes == true) {
		batching = true;
		StudySmsSendProcess(0, send_mode);
	} else {
		batching = false;
		$('#ProcesssRatio').hide();
		$("div[id='SysBg_White']").hide();
	}
}
function StudySmsSendProcess(i,send_mode) {
	ProcesssRatioCal = i / totalcount * 100;
	var newNum = new Number(ProcesssRatioCal);
	ProcesssRatioCal = newNum.toFixed(2);
	$("#ProcesssRatio").html("<br><br><span style='font-size:25px;'>진행률</span> "+ProcesssRatioCal+" %");

	var checked_value = $(':radio[name="MessageMode"]:checked').val();

	if(i<totalcount) {
		i2 = i + 1;

		if ($("input:checkbox[id='check_seq_"+i+"']").is(":checked") == false){
			$("div[id='status']:eq("+i+")").html('제외');
			setTimeout("StudySmsSendProcess("+i2+",'"+send_mode+"')", 200);
		}else{
			$("div[id='status']:eq("+i+")").load('./study_sms_batch_process.php',
			{ 'Seq': $("input[id='check_seq_"+i+"']").val(),
				'send_mode': send_mode,
				'MessageMode': checked_value
			});
			setTimeout(function(){
				StudySmsSendProcess(i2,send_mode);
			},200);
		}
	}else{
		batching = false;
		alert("발송처리가 완료되었습니다.");
		$("#ProcesssRatio").hide();
		$("div[id='SysBg_White']").hide();
	}


}

//독려관리>학습참여독려 - 개별 문자 발송
function StudySmsEASend(Seq, MessageMode) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();
 
	$('#DataResult').load('./study_sms_ea.php', { MessageMode: MessageMode, Seq: Seq }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '150px',
				width: '630px',
				left: body_width / 2 - 260,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}
/* 독려관리>학습참여독려 END --------------------------------------------------------------------------------------- */

//예약문자발송
function StudySmsResSend() {
    var seq_value = '';
	var checkbox_count = $("input[name='check_seq']").length;

    if (checkbox_count == 0) {
		alert('검색된 항목이 없습니다.');
		return;
	}
    
    if (checkbox_count > 1) {
		for (i = 0; i < checkbox_count; i++) {
			if ($("input:checkbox[name='check_seq']:eq(" + i + ')').is(':checked') == true) {
				if (seq_value == '') {
					seq_value = $("input:checkbox[name='check_seq']:eq(" + i + ')').val();
				} else {
					seq_value = seq_value + '|' + $("input:checkbox[name='check_seq']:eq(" + i + ')').val();
				}
			}
		}
	} else {
		if ($("input:checkbox[name='check_seq']").is(':checked') == true) {
			seq_value = $("input:checkbox[name='check_seq']").val();
		}
	}

    if (!seq_value) {
		alert('예약발송할 항목을 선택하세요.');
		return;
	}

    var currentWidth = $(window).width();
    var LocWidth = currentWidth / 2;
    var body_width = screen.width - 20;
    var body_height = $('html body').height();


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
            top: '350px',
            left: LocWidth,
            opacity: '0.6',
            position: 'absolute',
            'z-index': '200',
        })
    .show();

    $('#DataResult').load('./study_sms_res.php', { seq_value: seq_value }, function () {
        $("div[id='Roading']").hide();

        $('html, body').animate({ scrollTop: 0 }, 500);
        $("div[id='DataResult']")
            .css({
                top: '150px',
                width: '630px',
                left: body_width / 2 - 260,
                opacity: '1.0',
                position: 'absolute',
                'z-index': '1000',
            })
            .show();
    });
}

/* 수강관리>IP모니터링 START --------------------------------------------------------------------------------------- */
//수강관리>IP모니터링 - 조회
function StudyIPSearch(pg) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var SearchGubun = $(':radio[name="SearchGubun"]:checked').val();
	var CompanyName = $('#CompanyName').val();
	var SearchYear = $('#SearchYear').val();
	var SearchMonth = $('#SearchMonth').val();
	var StudyPeriod = $('#StudyPeriod').val();
	var CompanyCode = $('#CompanyCode').val();
	var ID = $('#ID').val();
	var SalesID = $('#SalesID').val();
	var SalesTeam = $('#SalesTeam').val();
	var Progress1 = $('#Progress1').val();
	var Progress2 = $('#Progress2').val();
	var TotalScore1 = $('#TotalScore1').val();
	var TotalScore2 = $('#TotalScore2').val();
	var TutorStatus = $('#TutorStatus').val();
	var LectureCode = $('#LectureCode').val();
	var PassOk = $('#PassOk').val();
	var ServiceType = $('#ServiceType').val();
	var PackageYN = $('#PackageYN').val();
	var certCount = $('#certCount').val();
	var MidStatus = $('#MidStatus').val();
	var TestStatus = $('#TestStatus').val();
	var ReportStatus = $('#ReportStatus').val();
	var TestCopy = $('#TestCopy').val();
	var ReportCopy = $('#ReportCopy').val();

	if (StudyPeriod != '') {
		StudyPeriod_array = StudyPeriod.split('~');
		var LectureStart = StudyPeriod_array[0];
		var LectureEnd = StudyPeriod_array[1];
	}

	if (SearchGubun == 'B') {
		if (CompanyName == '') {
			alert('사업주명을 입력하세요.');
			return;
		}
	}

	if (Progress1 != '' || Progress2 != '') {
		if (IsNumber(Progress1) == false || IsNumber(Progress2) == false) {
			alert('진도율은 숫자만 입력하세요.');
			return;
		}
	}
	/*
	if(TotalScore1!="" || TotalScore2!="") {
		if(IsNumber(TotalScore1)==false || IsNumber(TotalScore2)==false) {
			alert("총점은 숫자만 입력하세요.");
			return;
		}
	}
	*/

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
			top: '350px',
			left: LocWidth,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$.post(
		'./study_ip_search_result_backup.php',
		{
			SearchGubun: SearchGubun,
			CompanyName: CompanyName,
			SearchYear: SearchYear,
			SearchMonth: SearchMonth,
			StudyPeriod: StudyPeriod,
			CompanyCode: CompanyCode,
			ID: ID,
			SalesID: SalesID,
			SalesTeam: SalesTeam,
			Progress1: Progress1,
			Progress2: Progress2,
			TotalScore1: TotalScore1,
			TotalScore2: TotalScore2,
			TutorStatus: TutorStatus,
			LectureCode: LectureCode,
			PassOk: PassOk,
			ServiceType: ServiceType,
			PackageYN: PackageYN,
			certCount: certCount,
			MidStatus: MidStatus,
			TestStatus: TestStatus,
			ReportStatus: ReportStatus,
			TestCopy: TestCopy,
			ReportCopy: ReportCopy,
			LectureStart: LectureStart,
			LectureEnd: LectureEnd,
			pg: pg,
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

function StudyIPSearch2(pg) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var SearchGubun = $(':radio[name="SearchGubun"]:checked').val();
	var CompanyName = $('#CompanyName').val();
	var SearchYear = $('#SearchYear').val();
	var SearchMonth = $('#SearchMonth').val();
	var StudyPeriod = $('#StudyPeriod').val();
	var CompanyCode = $('#CompanyCode').val();
	var ID = $('#ID').val();
	var SalesID = $('#SalesID').val();
	var SalesTeam = $('#SalesTeam').val();
	var Progress1 = $('#Progress1').val();
	var Progress2 = $('#Progress2').val();
	var TotalScore1 = $('#TotalScore1').val();
	var TotalScore2 = $('#TotalScore2').val();
	var TutorStatus = $('#TutorStatus').val();
	var LectureCode = $('#LectureCode').val();
	var PassOk = $('#PassOk').val();
	var ServiceType = $('#ServiceType').val();
	var PackageYN = $('#PackageYN').val();
	var certCount = $('#certCount').val();
	var MidStatus = $('#MidStatus').val();
	var TestStatus = $('#TestStatus').val();
	var ReportStatus = $('#ReportStatus').val();
	var TestCopy = $('#TestCopy').val();
	var ReportCopy = $('#ReportCopy').val();

	var ip_addr = $('#ip_addr').val();

	if (StudyPeriod != '') {
		StudyPeriod_array = StudyPeriod.split('~');
		var LectureStart = StudyPeriod_array[0];
		var LectureEnd = StudyPeriod_array[1];
	}

	if (SearchGubun == 'B') {
		if (CompanyName == '') {
			alert('사업주명을 입력하세요.');
			return;
		}
	}

	if (Progress1 != '' || Progress2 != '') {
		if (IsNumber(Progress1) == false || IsNumber(Progress2) == false) {
			alert('진도율은 숫자만 입력하세요.');
			return;
		}
	}
	/*
	if(TotalScore1!="" || TotalScore2!="") {
		if(IsNumber(TotalScore1)==false || IsNumber(TotalScore2)==false) {
			alert("총점은 숫자만 입력하세요.");
			return;
		}
	}
	*/

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
			top: '350px',
			left: LocWidth,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$.post(
		'./study_ip_search_result.php',
		{
			SearchGubun: SearchGubun,
			CompanyName: CompanyName,
			SearchYear: SearchYear,
			SearchMonth: SearchMonth,
			StudyPeriod: StudyPeriod,
			CompanyCode: CompanyCode,
			ID: ID,
			SalesID: SalesID,
			SalesTeam: SalesTeam,
			Progress1: Progress1,
			Progress2: Progress2,
			TotalScore1: TotalScore1,
			TotalScore2: TotalScore2,
			TutorStatus: TutorStatus,
			LectureCode: LectureCode,
			PassOk: PassOk,
			ServiceType: ServiceType,
			PackageYN: PackageYN,
			certCount: certCount,
			MidStatus: MidStatus,
			TestStatus: TestStatus,
			ReportStatus: ReportStatus,
			TestCopy: TestCopy,
			ReportCopy: ReportCopy,
			LectureStart: LectureStart,
			LectureEnd: LectureEnd,
			pg: pg,
			ip_addr : ip_addr
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

function StudyIPExcel() {
	Yes = confirm('현재 검색조건으로 검색된 결과를 엑셀로 출력하시겠습니까?');
	if (Yes == true) {
		document.search.action = 'study_ip_search_excel.php';
		document.search.target = 'ScriptFrame';
		document.search.submit();
	}
}

function StudyIPExcel2() {
	Yes = confirm('현재 검색조건으로 검색된 결과를 엑셀로 출력하시겠습니까?');
	if (Yes == true) {
		document.search.action = 'study_ip_search_excel.php';
		document.search.target = 'ScriptFrame';
		document.search.submit();
	}
}

function StudyIPExcelBackUp() {
	Yes = confirm('현재 검색조건으로 검색된 결과를 엑셀로 출력하시겠습니까?');
	if (Yes == true) {
		document.search.action = 'study_ip_search_excel_backup.php';
		document.search.target = 'ScriptFrame';
		document.search.submit();
	}
}

function StudyIPExcelDetail() {
	Yes = confirm('현재 검색조건으로 검색된 결과를 엑셀로 출력하시겠습니까?');
	if (Yes == true) {
		document.search.action = 'study_ip_search_excel_detail.php';
		document.search.target = 'ScriptFrame';
		document.search.submit();
	}
}

function StudyIPExcelDetail2() {
	Yes = confirm('현재 검색조건으로 검색된 결과를 엑셀로 출력하시겠습니까?');
	if (Yes == true) {
		document.search.action = 'study_ip_search_excel_detail2.php';
		document.search.target = 'ScriptFrame';
		document.search.submit();
	}
}
/* 수강관리>IP모니터링 END --------------------------------------------------------------------------------------- */

/* 수강관리>일차별학습시간관리 START --------------------------------------------------------------------------------------- */
//수강관리>일차별학습시간관리 - 조회
function StudyTimeSearch(pg) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var StudyDate = $('#StudyDate').val();
	var ID = $('#ID').val();
	var StudyTime = $('#StudyTime').val();

	if (StudyDate == '') {
		alert('수강날짜를 입력하세요.');
		return;
	}

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
			top: '350px',
			left: LocWidth,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$.post(
		'./study_time_search_result.php',
		{
			StudyDate: StudyDate,
			ID: ID,
			StudyTime: StudyTime,
			pg: pg,
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

function StudyTime2Search (pg) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var StudyDate = $('#StudyDate').val();
	var ID = $('#ID').val();
	var StudyTime = $('#StudyTime').val();

	if (StudyDate == '') {
		alert('수강날짜를 입력하세요.');
		return;
	}

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
			top: '350px',
			left: LocWidth,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$.post(
		'./study_time2_search_result.php',
		{
			StudyDate: StudyDate,
			ID: ID,
			pg: pg,
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

//수강관리>IP일차별학습시간관리 - 검색결과 액셀출력
function StudyTimeExcel() {
	var StudyDate = $('#StudyDate').val();
	
	if (StudyDate == '') {
		alert('수강날짜를 입력하세요.');
		return;
	}
	
	Yes = confirm('현재 검색조건으로 검색된 결과를 엑셀로 출력하시겠습니까?');
	if (Yes == true) {
		document.search.action = 'study_time_search_excel.php';
		document.search.target = 'ScriptFrame';
		document.search.submit();
	}
}
/* 수강관리>일차별학습시간관리 END --------------------------------------------------------------------------------------- */


/* 컨텐츠관리>기초차시관리 START --------------------------------------------------------------------------------------- */
//컨텐츠관리>기초차시관리 - 기초차시 상세구성 list
function ContentsDetail(mode, Seq, Contents_idx) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '350px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./contents_detail.php', { mode: mode, Seq: Seq, Contents_idx: Contents_idx }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 0 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '150px',
				width: '1000px',
				left: body_width / 2 - 750,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}
//아카이브>컨텐츠관리 - 엑셀로 콘텐츠 등록
function CourseExcelUploadListRoading(str) {
	$("div[id='ContentsUploadList']").html('<br><br><br><center><img src="/images/loader.gif" alt="로딩중" /></center>');
	$("div[id='ContentsUploadList']").load('./course_excel_list.php', { str: str }, function () {});
}

var Course_Regist_Seq_count = 0;

function CourseRegistSubmitOk(ctype) { //ctype세션 중도 유실 위험으로 파라미터 값으로 고정.
	Course_Regist_Seq_count = $("input[id='check_seq']").length;
	
	const serviceTypeMap = {
	    "X": "이러닝",
	    "Y": "숏폼",
	    "Z": "마이크로닝"
	};
	
	const serviceType = serviceTypeMap[ctype] || "알 수 없음";
	
	if (Course_Regist_Seq_count < 1) {
		alert('등록된 엑셀파일이 없습니다.');
	} else {
		Yes = confirm(
			'등록한 엑셀파일로 '+serviceType+' 컨텐츠 등록을 시작하시겠습니까?\n\n\n\n목록 우측 [상태]항목에서 컨텐츠 등록 진행상황을\n\n확인하실 수 있습니다.\n\n\n\n작업이 완료될 때까지 다른 페이지로 이동 또는 창을 닫지 마세요.'
		);
		if (Yes == true) {
			TimeCheckNo = 'N'; //로그아웃까지 남은 시간 실행 중지
			CourseRegistProcess(0, ctype);
		}
	}
}

function CourseRegistProcess(i, ctype) {
	if (i < Course_Regist_Seq_count) {
		i2 = i + 1;
		$("span[id='ContentsRegResult']:eq(" + i + ')').html('처리중');
		$("span[id='ContentsRegResult']:eq(" + i + ')').load('./course_reg_complete.php', { Seq: $("input[id='check_seq']:eq(" + i + ')').val(), ctype : ctype }, function () {
			setTimeout(function () {
				CourseRegistProcess(i2, ctype);
			}, 500);
		});
	} else {
		alert('컨텐츠 등록 처리가 완료되었습니다.\n\n\n\n등록 중 오류가 발생한 부분은 갱신된 목록에서\n\n확인이 가능합니다.\n\n\n\n[확인]을 클릭하면 현재 목록이 갱신됩니다.');
		TimeCheckNo = 'Y'; //로그아웃까지 남은 시간 실행 다시 실행
		top.CourseExcelUploadListRoading('C');
	}
}

function CourseRegEdit(idx) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '550px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./course_reg_edit.php', { idx: idx }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 120 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '150px',
				width: '1100px',
				left: body_width / 2 - 600,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

//아카이브>컨텐츠관리 - 엑셀로 차시구성 등록
function ChapterExcelUploadListRoading(str) {
	$("div[id='ContentsUploadList']").html('<br><br><br><center><img src="/images/loader.gif" alt="로딩중" /></center>');
	$("div[id='ContentsUploadList']").load('./chapter_excel_list.php', { str: str }, function () {});
}

var Contents_Regist_Seq_count = 0;

function ChapterRegistSubmitOk() { //ctype세션 중도 유실 위험으로 파라미터 값으로 고정.
	Contents_Regist_Seq_count = $("input[id='check_seq']").length;
	
	if (Contents_Regist_Seq_count < 1) {
		alert('등록된 엑셀파일이 없습니다.');
	} else {
		Yes = confirm(
			'등록한 엑셀파일로 차시구성 등록을 시작하시겠습니까?\n\n\n\n목록 우측 [상태]항목에서 컨텐츠 등록 진행상황을\n\n확인하실 수 있습니다.\n\n\n\n작업이 완료될 때까지 다른 페이지로 이동 또는 창을 닫지 마세요.'
		);
		if (Yes == true) {
			TimeCheckNo = 'N'; //로그아웃까지 남은 시간 실행 중지
			ChapterRegistProcess(0);
		}
	}
}

function ChapterRegistProcess(i) {
	if (i < Contents_Regist_Seq_count) {
		i2 = i + 1;
		$("span[id='ContentsRegResult']:eq(" + i + ')').html('처리중');
		$("span[id='ContentsRegResult']:eq(" + i + ')').load('./chapter_reg_complete.php', { Seq: $("input[id='check_seq']:eq(" + i + ')').val()}, function () {
			setTimeout(function () {
				ChapterRegistProcess(i2);
			}, 500);
		});
	} else {
		alert('컨텐츠 등록 처리가 완료되었습니다.\n\n\n\n등록 중 오류가 발생한 부분은 갱신된 목록에서\n\n확인이 가능합니다.\n\n\n\n[확인]을 클릭하면 현재 목록이 갱신됩니다.');
		TimeCheckNo = 'Y'; //로그아웃까지 남은 시간 실행 다시 실행
		top.ChapterExcelUploadListRoading('C'); 
	}
}

function ChapterRegEdit(idx) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '550px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./chapter_reg_edit.php', { idx: idx }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 120 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '150px',
				width: '1100px',
				left: body_width / 2 - 600,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}

//컨텐츠관리>기초차시관리 - 엑셀로 기초차시 등록
function ContentsExcelUploadListRoading(str) {
	$("div[id='ContentsUploadList']").html('<br><br><br><center><img src="/images/loader.gif" alt="로딩중" /></center>');

	$("div[id='ContentsUploadList']").load('./contents_excel_list.php', { str: str }, function () {});
}
var Contents_Regist_Seq_count = 0;
function ContentsRegistSubmitOk() {
	Contents_Regist_Seq_count = $("input[id='check_seq']").length;

	if (Contents_Regist_Seq_count < 1) {
		alert('등록된 엑셀파일이 없습니다.');
	} else {
		Yes = confirm(
			'등록한 엑셀파일로 기초차시 등록을 시작하시겠습니까?\n\n\n\n목록 우측 [상태]항목에서 기초차시 등록 진행상황을\n\n확인하실 수 있습니다.\n\n\n\n작업이 완료될 때까지 다른 페이지로 이동 또는 창을 닫지 마세요.'
		);
		if (Yes == true) {
			TimeCheckNo = 'N'; //로그아웃까지 남은 시간 실행 중지
			ContentsRegistProcess(0);
		}
	}
}
function ContentsRegistProcess(i) {
	if (i < Contents_Regist_Seq_count) {
		i2 = i + 1;
		$("span[id='ContentsRegResult']:eq(" + i + ')').html('처리중');
		$("span[id='ContentsRegResult']:eq(" + i + ')').load('./contents_reg_complete.php', { Seq: $("input[id='check_seq']:eq(" + i + ')').val() }, function () {
			setTimeout(function () {
				ContentsRegistProcess(i2);
			}, 500);
		});
	} else {
		alert('기초차시 등록 처리가 완료되었습니다.\n\n\n\n등록 중 오류가 발생한 부분은 갱신된 목록에서\n\n확인이 가능합니다.\n\n\n\n[확인]을 클릭하면 현재 목록이 갱신됩니다.');
		TimeCheckNo = 'Y'; //로그아웃까지 남은 시간 실행 다시 실행
		top.ContentsExcelUploadListRoading('C');
	}
}
function ContentsRegEdit(idx) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

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
			top: '550px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./contents_reg_edit.php', { idx: idx }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 120 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '150px',
				width: '1100px',
				left: body_width / 2 - 600,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();
	});
}
function ContentsDetailSubmitOk() {
	val = document.Form1;

	var checked_value = $(':radio[name="ContentsType"]:checked').val();

	if (checked_value == '') {
		alert('컨텐츠 유형을 선택하세요.');
	}

	if (checked_value == 'A' || checked_value == 'B') {
		if ($('#ContentsURL').val() == '') {
			alert('컨텐츠 경로를 입력하세요.');
			$('#ContentsURL').focus();
			return;
		}
	}

	if (checked_value == 'C') {
		if ($('#Question').val() == '') {
			alert('질문 내용을 입력하세요.');
			$('#Question').focus();
			return;
		}
		if ($('#Example01').val() == '') {
			alert('보기1을 입력하세요.');
			$('#Example01').focus();
			return;
		}
		if ($('#Example02').val() == '') {
			alert('보기2를 입력하세요.');
			$('#Example02').focus();
			return;
		}
		if ($('#Example03').val() == '') {
			alert('보기3을 입력하세요.');
			$('#Example03').focus();
			return;
		}
		if ($('#Example04').val() == '') {
			alert('보기4를 입력하세요.');
			$('#Example04').focus();
			return;
		}
		/*
		if($("#Example05").val()=="") {
			alert("보기5를 입력하세요.");
			$("#Example05").focus();
			return;
		}
		*/

		if ($(':radio[name="Answer"]:checked').length < 1) {
			alert('보기중 정답을 선택하세요.');
			$(":radio[name='Answer']:eq(0)").focus();
			return;
		}
		if ($('#Comment').val() == '') {
			alert('해답 설명을 입력하세요.');
			$('#Comment').focus();
			return;
		}
	}

	if (checked_value == 'D') {
		if ($('#Question').val() == '') {
			alert('질문 내용을 입력하세요.');
			$('#Question').focus();
			return;
		}
		if ($('#Comment').val() == '') {
			alert('해답 설명을 입력하세요.');
			$('#Comment').focus();
			return;
		}
	}

	if (checked_value == 'F') {
		if ($('#Teacher').val() == '') {
			alert('강사를 선택하세요.');
			$('#Teacher').focus();
			return;
		}
	}

	if ($('#OrderByNum').val() == '') {
		alert('정렬순서를 입력하세요.');
		$('#OrderByNum').focus();
		return;
	}
	if (IsNumber($('#OrderByNum').val()) == false) {
		alert('정렬순서는 숫자만 입력하세요.');
		$('#OrderByNum').focus();
		return;
	}

	Yes = confirm('등록 하시겠습니까?');
	if (Yes == true) {
		$('#SubmitBtn').hide();
		$('#Waiting').show();
		val.submit();
	}
}
/* 컨텐츠관리>기초차시관리 END --------------------------------------------------------------------------------------- */


/* 컨텐츠관리>패키지컨텐츠관리 START --------------------------------------------------------------------------------------- */
//컨텐츠관리>패키지컨텐츠관리  - 컨텐츠 추가
function PackageSearchSelect() {
	var PackageCoursevalue = $('select[id=PackageCourse] option:selected').val();
	var PackageCourse_value_text = $('select[id=PackageCourse] option:selected').text();

	if (PackageCoursevalue == '') {
		alert('과정을 선택하세요.');
		return;
	}

	var LectureCode_value_temp_count = $('input[id=LectureCode_value_temp]').length;

	if (LectureCode_value_temp_count > 0) {
		for (i = 0; i < LectureCode_value_temp_count; i++) {
			if ($("input[id='LectureCode_value_temp']:eq(" + i + ')').val() == PackageCoursevalue) {
				alert('동일한 과정이 존재합니다.');
				return;
			}
		}
	}

	PackageCourse_value_text_array = PackageCourse_value_text.split('|');

	LectureCode_value_temp_count2 = LectureCode_value_temp_count + 1;
	var row = '<tr>';
	//row += '<td align="center">' + LectureCode_value_temp_count2 + '</td>';
	//row += '<td align="center"><input type="hidden" name="LectureCode_value_temp" id="LectureCode_value_temp" value="' + PackageCoursevalue + '">';
	//row +=
	//	'<input type="button" value="▲" onclick="PackageChapterListMoveUp(this);" style="width:30px;"> <input type="button" value="▼" onclick="PackageChapterListMoveDown(this);" style="width:30px;"></td>';
	row += '<td align="center"><input type="hidden" name="LectureCode_value_temp" id="LectureCode_value_temp" value="' + PackageCoursevalue + '">';
	row += PackageCoursevalue + '</td>';
	row += '<td align="left">' + PackageCourse_value_text_array[1].trim() + '</td>';
	row += '<td align="center">' + PackageCourse_value_text_array[2].trim() + '</td>';
	row += '<td align="center">' + PackageCourse_value_text_array[3].trim() + '</td>';
	row += '<td><input type="button" value="삭제" onclick="Javascript:PackageChapterExamDelRow(this);" class="btn_inputSm01"></td>';
	row += '</tr>';

	$(row).appendTo('#PackageCourseTable');
}

//컨텐츠관리>패키지컨텐츠관리  - 컨텐츠 삭제
function PackageChapterExamDelRow(obj) {
	if (jQuery('#PackageCourseTable tr').length < 1) {
		alert('더이상 삭제 할 수 없습니다.');
		return false;
	}

	if (confirm('선택한 과정을 삭제 하시겠습니까?')) {
		jQuery(obj).parent().parent().remove();
	}
}

//컨텐츠관리>패키지컨텐츠관리  - 정렬 위로
function PackageChapterListMoveUp(el) {
	var $tr = $(el).parent().parent(); // 클릭한 버튼이 속한 tr 요소
	$tr.prev().before($tr); // 현재 tr 의 이전 tr 앞에 선택한 tr 넣기
}

//컨텐츠관리>패키지컨텐츠관리  - 정렬 아래로
function PackageChapterListMoveDown(el) {
	var $tr = $(el).parent().parent(); // 클릭한 버튼이 속한 tr 요소
	$tr.next().after($tr); // 현재 tr 의 다음 tr 뒤에 선택한 tr 넣기
}
/* 컨텐츠관리>패키지컨텐츠관리 END --------------------------------------------------------------------------------------- */


/* 아카이브>학습관리 START --------------------------------------------------------------------------------------- */
//아카이브>학습관리 - 조회
function StudySearch(pg) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var SearchGubun = $(':radio[name="SearchGubun"]:checked').val();
	var CompanyName = $('#CompanyName').val();
	var SearchYear = $('#SearchYear').val();
	var SearchYear2 = $('#SearchYear2').val();
	var SearchMonth = $('#SearchMonth').val();
	var SearchMonth2 = $('#SearchMonth2').val();
	var StudyPeriod = $('#StudyPeriod').val();
	var StudyPeriod2 = $('#StudyPeriod2').val();
	var CompanyCode = $('#CompanyCode').val();
	var OpenChapter = $('#OpenChapter').val();
	var ServiceType = $('#ServiceType').val();
	var ID = $('#ID').val();
	var SalesID = $('#SalesID').val();
	var Progress1 = $('#Progress1').val();
	var Progress2 = $('#Progress2').val();
	var TutorStatus = $('#TutorStatus').val();
	var LectureCode = $('#LectureCode').val();
	var PassOk = $('#PassOk').val();
	var certCount = $('#certCount').val();
	var Tutor = $('#Tutor').val();
	var EduManager = $('#EduManager').val();
	var PageCount = $('#PageCount').val();
    var AbilityYN = $('#AbilityYN').val();
    var AbilityAfterYN = $('#AbilityAfterYN').val();
    
	var LectureStart = '';
	var LectureEnd = '';

	if (StudyPeriod == '' || StudyPeriod == undefined) {
		StudyPeriod = '';
	}
	if (StudyPeriod2 == '' || StudyPeriod2 == undefined) {
		StudyPeriod2 = '';
	}

	if (SearchGubun == 'A') {
		if (StudyPeriod != '') {
			StudyPeriod_array = StudyPeriod.split('~');
			LectureStart = StudyPeriod_array[0];
			LectureEnd = StudyPeriod_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (StudyPeriod2 != '') {
			StudyPeriod2_array = StudyPeriod2.split('~');
			LectureStart = StudyPeriod2_array[0];
			LectureEnd = StudyPeriod2_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (CompanyName == '') {
			alert('사업주명을 입력하세요.');
			return;
		}
	}
	
	if ((OpenChapter != '') && (IsNumber(OpenChapter) == false)) {
		alert('실시회차는 숫자만 입력하세요.');
		$('#OpenChapter').focus();
		return;
	}
	/*
	else if((OpenChapter != '') && (OpenChapter<1)){
		alert('실시회차는 1이상 숫자만 입력하세요.');
		$('#OpenChapter').focus();
		return;
	}
	*/
	
	if (Progress1 != '' || Progress2 != '') {
		if (IsNumber(Progress1) == false || IsNumber(Progress2) == false) {
			alert('진도율은 숫자만 입력하세요.');
			return;
		}
	}

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
		top: '350px',
		left: LocWidth,
		opacity: '1.0',
		position: 'absolute',
		'z-index': '200',
	})
	.show();

	$.post(
		'./study_search_result.php',
		{
			SearchGubun: SearchGubun,
			CompanyName: CompanyName,
			SearchYear: SearchYear,
			SearchYear2 : SearchYear2,
			SearchMonth: SearchMonth,
			SearchMonth2 : SearchMonth2,
			StudyPeriod: StudyPeriod,
			StudyPeriod2: StudyPeriod2,
			CompanyCode: CompanyCode,
			OpenChapter: OpenChapter,
			ServiceType: ServiceType,
			ID: ID,
			SalesID: SalesID,
			Progress1: Progress1,
			Progress2: Progress2,
			TutorStatus: TutorStatus,
			LectureCode: LectureCode,
			PassOk: PassOk,
			certCount: certCount,
            AbilityYN: AbilityYN,
            AbilityAfterYN: AbilityAfterYN,
			LectureStart: LectureStart,
			LectureEnd: LectureEnd,
			Tutor: Tutor,
			EduManager: EduManager,
			PageCount: PageCount,
			pg: pg,
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

//아카이브>학습관리 - 검색결과 엑셀출력
function StudyExcel() {
	var checkbox_count = $("input[name='check_seq']").length;

	if (checkbox_count == 0) {
		alert('검색된 학습현황이 없습니다.');
		return;
	}
	
	var SearchGubun = $(':radio[name="SearchGubun"]:checked').val();
	var StudyPeriod = $('#StudyPeriod').val();
	var StudyPeriod2 = $('#StudyPeriod2').val();
	
	var CompanyName = $('#CompanyName').val();
	var CompanyCode = $('#CompanyCode').val();
	var OpenChapter = $('#OpenChapter').val();
	var Progress1 = $('#Progress1').val();
	var Progress2 = $('#Progress2').val();

	var LectureStart = '';
	var LectureEnd = '';

	if (StudyPeriod == '' || StudyPeriod == undefined) {
		StudyPeriod = '';
	}
	if (StudyPeriod2 == '' || StudyPeriod2 == undefined) {
		StudyPeriod2 = '';
	}

	if (SearchGubun == 'A') {
		if (StudyPeriod != '') {
			StudyPeriod_array = StudyPeriod.split('~');
			LectureStart = StudyPeriod_array[0];
			LectureEnd = StudyPeriod_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (StudyPeriod2 != '') {
			StudyPeriod2_array = StudyPeriod2.split('~');
			LectureStart = StudyPeriod2_array[0];
			LectureEnd = StudyPeriod2_array[1];
		}
	}
	
	if (SearchGubun == 'B') {
		if (CompanyName == '') {
			alert('사업주명을 입력하세요.');
			return;
		}
	}
	
	if ((OpenChapter != '') && (IsNumber(OpenChapter) == false)) {
		alert('실시회차는 숫자만 입력하세요.');
		$('#OpenChapter').focus();
		return;
	}
	
	if (Progress1 != '' || Progress2 != '') {
		if (IsNumber(Progress1) == false || IsNumber(Progress2) == false) {
			alert('진도율은 숫자만 입력하세요.');
			return;
		}
	}

	Yes = confirm('현재 검색조건으로 검색된 결과를 엑셀로 출력하시겠습니까?');
	if (Yes == true) {
		document.search.action = 'study_search_excel.php';
		document.search.target = 'ScriptFrame';
		document.search.LectureStart.value = LectureStart;
		document.search.LectureEnd.value = LectureEnd;
		document.search.CompanyCodeA.value = CompanyCode;
		document.search.submit();
	}
}

//아카이브>학습관리 - 체크항목 문자보내기
function StudyCheckedKakaoTalk(mode) {
	var seq_value = '';
	var checkbox_count = $("input[name='check_seq']").length;

	if (checkbox_count == 0) {
		alert('검색된 학습현황이 없습니다.');
		return;
	}

	if (checkbox_count > 1) {
		for (i = 0; i < checkbox_count; i++) {
			if ($("input:checkbox[name='check_seq']:eq(" + i + ')').is(':checked') == true) {
				if (seq_value == '') {
					seq_value = $("input:checkbox[name='check_seq']:eq(" + i + ')').val();
				} else {
					seq_value = seq_value + '|' + $("input:checkbox[name='check_seq']:eq(" + i + ')').val();
				}
			}
		}
	} else {
		if ($("input:checkbox[name='check_seq']").is(':checked') == true) {
			seq_value = $("input:checkbox[name='check_seq']").val();
		}
	}

	if (!seq_value) {
		alert('발송하려는 항목을 선택하세요.');
		return;
	}

	switch (mode) {
		case 'Start':
			msg = '[개강1일전 문자보내기]';
			break;
		case 'Auth':
			msg = '[본인인증문자보내기]';
			break;
	}

	Yes = confirm('선택한 항목에 ' + msg + '를 실행하시겠습니까?');

	if (Yes == true) {
		var currentWidth = $(window).width();
		var LocWidth = currentWidth / 2;
		var body_width = screen.width - 20;
		var body_height = $('html body').height();

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
				top: '350px',
				left: LocWidth,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '200',
			})
			.show();

		$.post(
			'./study_search_checked_kakaotalk.php',
			{
				seq_value: seq_value,
				mode: mode,
			},
			function (data, status) {
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();

				if (!data || data == '0') {
					alert('처리중 문제가 발생했습니다.');
				} else {
					alert(data + '건의 문자 보내기가 완료되었습니다.');
				}
			}
		);
	}
}

//아카이브>학습관리 - 체크항목 교육담당자안내메일발송
function StudyCheckedEduManagerMail() {
	var seq_value = '';
	var checkbox_count = $("input[name='check_seq']").length;

	if (checkbox_count == 0) {
		alert('검색된 학습현황이 없습니다.');
		return;
	}

	if (checkbox_count > 1) {
		for (i = 0; i < checkbox_count; i++) {
			if ($("input:checkbox[name='check_seq']:eq(" + i + ')').is(':checked') == true) {
				if (seq_value == '') {
					seq_value = $("input:checkbox[name='check_seq']:eq(" + i + ')').val();
				} else {
					seq_value = seq_value + '|' + $("input:checkbox[name='check_seq']:eq(" + i + ')').val();
				}
			}
		}
	} else {
		if ($("input:checkbox[name='check_seq']").is(':checked') == true) {
			seq_value = $("input:checkbox[name='check_seq']").val();
		}
	}

	if (!seq_value) {
		alert('발송하려는 항목을 선택하세요.');
		return;
	}

	Yes = confirm('선택한 항목에 교육담당자 안내 메일 발송을 실행하시겠습니까?');

	if (Yes == true) {
		var currentWidth = $(window).width();
		var LocWidth = currentWidth / 2;
		var body_width = screen.width - 20;
		var body_height = $('html body').height();

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
				top: '350px',
				left: LocWidth,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '200',
			})
			.show();

		$.post(
			'./study_search_checked_edumanager_mail.php',
			{
				seq_value: seq_value,
			},
			function (data, status) {
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();

				if (!data || data == '0') {
					alert('처리중 문제가 발생했습니다.');
				} else {
					alert(data + '건의 메일 보내기가 완료되었습니다.');
				}
			}
		);
	}
}

//아카이브>학습관리 - 체크항목 삭제
function StudyCheckedDelete() {
	var seq_value = '';
	var checkbox_count = $("input[name='check_seq']").length;

	if (checkbox_count == 0) {
		alert('검색된 학습현황이 없습니다.');
		return;
	}

	if (checkbox_count > 1) {
		for (i = 0; i < checkbox_count; i++) {
			if ($("input:checkbox[name='check_seq']:eq(" + i + ')').is(':checked') == true) {
				if (seq_value == '') {
					seq_value = $("input:checkbox[name='check_seq']:eq(" + i + ')').val();
				} else {
					seq_value = seq_value + '|' + $("input:checkbox[name='check_seq']:eq(" + i + ')').val();
				}
			}
		}
	} else {
		if ($("input:checkbox[name='check_seq']").is(':checked') == true) {
			seq_value = $("input:checkbox[name='check_seq']").val();
		}
	}

	if (!seq_value) {
		alert('삭제하려는 항목을 선택하세요.');
		return;
	}

	Yes = confirm('선택한 항목을 정말 삭제하시겠습니까?\n\n삭제 후에는 되돌릴 수 없습니다.');

	if (Yes == true) {
		var currentWidth = $(window).width();
		var LocWidth = currentWidth / 2;
		var body_width = screen.width - 20;
		var body_height = $('html body').height();

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
				top: '350px',
				left: LocWidth,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '200',
			})
			.show();

		$.post(
			'./study_search_checked_delete.php',
			{
				seq_value: seq_value,
			},
			function (data, status) {
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();

				if (data == 'Y') {
					if ($('#ctype').val() == 'A') {
						StudySearch(1);
					}
					if ($('#ctype').val() == 'B') {
						StudySearch2(1);
					}
					alert('삭제 되었습니다.');
				} else {
					alert('처리중 문제가 발생했습니다.');
				}
			}
		);
	}
}

//학습관리 - 개설용도 변경
function StudyServiceTypeChangeBatch() {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var checkbox_count = $("input[name='check_seq']").length;
	var serviceTypeSelected = $('#ServiceType').val();
	var contentsNameSelected = $('#LectureCode').val();

	if (!serviceTypeSelected) {
		alert('개설용도를 선택하세요.');
		$('#serviceType').focus();
		return;
	}
	if (!contentsNameSelected) {
		alert('변경하려는 과정을 선택하세요.');
		$('#contentsName').focus();
		return;
	}
	if (checkbox_count == 0) {
		alert('검색된 학습현황이 없습니다.');
		return;
	}

	searchValue = $('#search').serialize();
	popupAddress = './study_servicetype_change_batch.php?' + searchValue;
	window.open(popupAddress, '일괄처리', 'left=100, width=1400, height=900, menubar=no, status=no, titlebar=no, toolbar=no, scrollbars=yes, resizeable=no', 'batchPop');
}

//아카이브>학습관리 - 현재검색조건으로 실시회차 변경
function StudyOpenChapterChangeBatch() {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var checkbox_count = $("input[name='check_seq']").length;

	if (checkbox_count == 0) {
		alert('검색된 학습현황이 없습니다.');
		return;
	}
	searchValue = $('#search').serialize();
	
	popupAddress = './study_openchapter_change_batch.php?t' + searchValue;
	window.open(popupAddress, '일괄처리', 'left=100, width=1400, height=900, menubar=no, status=no, titlebar=no, toolbar=no, scrollbars=yes, resizeable=no', 'batchPop');
} 

//아카이브>학습관리 - 현재검색조건으로 영업담당 변경
function StudySalesChangeBatch() {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var checkbox_count = $("input[name='check_seq']").length;

	if (checkbox_count == 0) {
		alert('검색된 학습현황이 없습니다.');
		return;
	}
	searchValue = $('#search').serialize();
	
	popupAddress = './study_sales_change_batch.php?' + searchValue;
	window.open(popupAddress, '일괄처리', 'left=100, width=1400, height=900, menubar=no, status=no, titlebar=no, toolbar=no, scrollbars=yes, resizeable=no', 'batchPop');
}

//아카이브>학습관리 - 수료증
function CertificatePrint(Seq) {
	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();
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

	$('#DataResult').load('./certificate_layer.php', { Seq: Seq }, function () {
		$('html, body').animate({ scrollTop: ScrollPosition + 100 }, 300);

		$("div[id='DataResult']")
			.css({
				top: ScrollPosition + 120,
				left: body_width / 2 - 300,
				width: '650px',
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show();

		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: ScrollPosition + 30 }, 300);
	});
}

//아카이브>학습관리 - 수료증 PDF 다운로드
function CertificatePrintPDF(Seq) {
	var url = '/include/certificate_pdf01.php?Seq=' + Seq;
	window.open(url, 'certi', 'scrollbars=yes, resizable=no, left=400, width=820, height=700');
}
/* 아카이브>학습관리 END --------------------------------------------------------------------------------------- */


/* 수강관리>학습내역관리 START --------------------------------------------------------------------------------------- */
//수강관리>학습내역관리 - 조회
function Study2Search(pg) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var SearchGubun = $(':radio[name="SearchGubun"]:checked').val();
	var CompanyName = $('#CompanyName').val();
	var SearchYear = $('#SearchYear').val();
	var SearchYear2 = $('#SearchYear2').val();
	var SearchMonth = $('#SearchMonth').val();
	var SearchMonth2 = $('#SearchMonth2').val();
	var StudyPeriod = $('#StudyPeriod').val();
	var StudyPeriod2 = $('#StudyPeriod2').val();
	var CompanyCode = $('#CompanyCode').val();
	var OpenChapter = $('#OpenChapter').val();
	var ServiceType = $('#ServiceType').val();
	var ID = $('#ID').val();
	var SalesID = $('#SalesID').val();
	var Progress1 = $('#Progress1').val();
	var Progress2 = $('#Progress2').val();
	var TutorStatus = $('#TutorStatus').val();
	var LectureCode = $('#LectureCode').val();
	var PassOk = $('#PassOk').val();
	var certCount = $('#certCount').val();
	var Tutor = $('#Tutor').val();
	var EduManager = $('#EduManager').val();
	var PageCount = $('#PageCount').val();
    
	var LectureStart = '';
	var LectureEnd = '';

	if (StudyPeriod == '' || StudyPeriod == undefined) {
		StudyPeriod = '';
	}
	if (StudyPeriod2 == '' || StudyPeriod2 == undefined) {
		StudyPeriod2 = '';
	}

	if (SearchGubun == 'A') {
		if (StudyPeriod != '') {
			StudyPeriod_array = StudyPeriod.split('~');
			LectureStart = StudyPeriod_array[0];
			LectureEnd = StudyPeriod_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (StudyPeriod2 != '') {
			StudyPeriod2_array = StudyPeriod2.split('~');
			LectureStart = StudyPeriod2_array[0];
			LectureEnd = StudyPeriod2_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (CompanyName == '') {
			alert('사업주명을 입력하세요.');
			return;
		}
	}
	
	if ((OpenChapter != '') && (IsNumber(OpenChapter) == false)) {
		alert('실시회차는 숫자만 입력하세요.');
		$('#OpenChapter').focus();
		return;
	}
	/*
	else if((OpenChapter != '') && (OpenChapter<1)){
		alert('실시회차는 1이상 숫자만 입력하세요.');
		$('#OpenChapter').focus();
		return;
	}
	*/
	
	if (Progress1 != '' || Progress2 != '') {
		if (IsNumber(Progress1) == false || IsNumber(Progress2) == false) {
			alert('진도율은 숫자만 입력하세요.');
			return;
		}
	}

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
		top: '350px',
		left: LocWidth,
		opacity: '1.0',
		position: 'absolute',
		'z-index': '200',
	})
	.show();

	$.post(
		'./study2_search_result.php',
		{
			SearchGubun: SearchGubun,
			CompanyName: CompanyName,
			SearchYear: SearchYear,
			SearchYear2 : SearchYear2,
			SearchMonth: SearchMonth,
			SearchMonth2 : SearchMonth2,
			StudyPeriod: StudyPeriod,
			StudyPeriod2: StudyPeriod2,
			CompanyCode: CompanyCode,
			OpenChapter: OpenChapter,
			ServiceType: ServiceType,
			ID: ID,
			SalesID: SalesID,
			Progress1: Progress1,
			Progress2: Progress2,
			TutorStatus: TutorStatus,
			LectureCode: LectureCode,
			PassOk: PassOk,
			certCount: certCount,
			LectureStart: LectureStart,
			LectureEnd: LectureEnd,
			Tutor: Tutor,
			EduManager: EduManager,
			PageCount: PageCount,
			pg: pg,
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

//수강관리>학습내역관리 - 검색결과 엑셀출력
function Study2Excel() {

    console.log("1111");

	var checkbox_count = $("input[name='check_seq']").length;

	if (checkbox_count == 0) {
		alert('검색된 학습현황이 없습니다.');
		return;
	}
	
	var SearchGubun = $(':radio[name="SearchGubun"]:checked').val();
	var StudyPeriod = $('#StudyPeriod').val();
	var StudyPeriod2 = $('#StudyPeriod2').val();
	
	var CompanyName = $('#CompanyName').val();
	var CompanyCode = $('#CompanyCode').val();
	var OpenChapter = $('#OpenChapter').val();
	var Progress1 = $('#Progress1').val();
	var Progress2 = $('#Progress2').val();

	var LectureStart = '';
	var LectureEnd = '';

	if (StudyPeriod == '' || StudyPeriod == undefined) {
		StudyPeriod = '';
	}
	if (StudyPeriod2 == '' || StudyPeriod2 == undefined) {
		StudyPeriod2 = '';
	}

	if (SearchGubun == 'A') {
		if (StudyPeriod != '') {
			StudyPeriod_array = StudyPeriod.split('~');
			LectureStart = StudyPeriod_array[0];
			LectureEnd = StudyPeriod_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (StudyPeriod2 != '') {
			StudyPeriod2_array = StudyPeriod2.split('~');
			LectureStart = StudyPeriod2_array[0];
			LectureEnd = StudyPeriod2_array[1];
		}
	}
	
	if (SearchGubun == 'B') {
		if (CompanyName == '') {
			alert('사업주명을 입력하세요.');
			return;
		}
	}
	
	if ((OpenChapter != '') && (IsNumber(OpenChapter) == false)) {
		alert('실시회차는 숫자만 입력하세요.');
		$('#OpenChapter').focus();
		return;
	}
	
	if (Progress1 != '' || Progress2 != '') {
		if (IsNumber(Progress1) == false || IsNumber(Progress2) == false) {
			alert('진도율은 숫자만 입력하세요.');
			return;
		}
	}

	Yes = confirm('현재 검색조건으로 검색된 결과를 엑셀로 출력하시겠습니까?');
	if (Yes == true) {
		document.search.action = 'study2_search_excel.php';
		document.search.target = 'ScriptFrame';
		document.search.LectureStart.value = LectureStart;
		document.search.LectureEnd.value = LectureEnd;
		document.search.CompanyCodeA.value = CompanyCode;
		document.search.submit();
	}
}
/* 수강관리>학습내역관리 END --------------------------------------------------------------------------------------- */


/* 수강관리>과목별이수증 START --------------------------------------------------------------------------------------- */
//수강관리>과목별이수증 - 조회
function StudyEnd2Search(pg) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var LectureStart = $('#LectureStart').val();
	var LectureEnd = $('#LectureEnd').val();
	var CompanyName = $('#CompanyName').val();
	var OpenChapter = $('#OpenChapter').val();
	var LectureCode = $('#LectureCode').val();
	
	if((!LectureStart)&&(!LectureEnd)&&(!CompanyName)){
		alert('검색 조건을 입력하세요.');
		return;		
	}
	
	if(!CompanyName){
		alert('사업주명을 선택하세요.');
		return;
	}

	if(LectureStart > LectureEnd){
		alert('수강종료일이 수강시작일보다 이전입니다.\n수강기간을 다시 선택하세요.');
		return;
	}
	
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
			top: '350px',
			left: LocWidth,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$.post(
		'./study_end2_search_result.php',
		{
			CompanyName: CompanyName,
			LectureStart: LectureStart,
			LectureEnd: LectureEnd,
			OpenChapter : OpenChapter,
			LectureCode: LectureCode,
			pg: pg,
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

//수강관리>과목별이수증 - 수료증출력
function StudyEnd2CertificatePrintPDF(CompanyCode, LectureStart, LectureEnd, LectureCode) {	
	var url ='/include/certificate_pdf04.php?CompanyCode=' +CompanyCode +'&LectureStart=' +LectureStart +'&LectureEnd=' +LectureEnd +'&LectureCode=' +LectureCode;
	//window.open(url, 'certi', 'scrollbars=yes, resizable=yes, left=400, width=820, height=700');
	document.getElementById("pdfFrame").src = url;
}
/* 수강관리>과목별이수증 END --------------------------------------------------------------------------------------- */


/* 아카이브>수강마감 START --------------------------------------------------------------------------------------- */
//아카이브>수강마감 - 조회
function StudyEndSearch(pg) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var LectureStart = $('#LectureStart').val();
	var LectureEnd = $('#LectureEnd').val();
	var CompanyName = $('#CompanyName').val();
	var OpenChapter = $('#OpenChapter').val();
	var PageCount = $('#PageCount').val();
	
	if((!LectureStart)&&(!LectureEnd)&&(!CompanyName)){
		alert('검색 조건을 입력하세요.');
		return;		
	}
	
	if(LectureStart){
		if(!LectureEnd){
			alert('수강종료일을 선택하세요.');
			return;
		}
	}
	
	if(LectureEnd){
		if(!LectureStart){
			alert('수강시작일을 선택하세요.');
			return;
		}
	}
	
	if(LectureStart > LectureEnd){
		alert('수강종료일이 수강시작일보다 이전입니다.\n수강기간을 다시 선택하세요.');
		return;
	}
	
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
			top: '350px',
			left: LocWidth,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$.post(
		'./study_end_search_result.php',
		{
			CompanyName: CompanyName,
			LectureStart: LectureStart,
			LectureEnd: LectureEnd,
			OpenChapter : OpenChapter,
			pg: pg,
			PageCount: PageCount,
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

//아카이브>수강마감 - 수료증다운로드
function StudyEndCertificatePrintPDF(CompanyCode, LectureStart, LectureEnd, LectureCode, ServiceTypeYN, CertificatePrintOK) {
	if (CertificatePrintOK == 'N') {
		alert('수강마감 이후에 수료증 출력이 가능합니다.');
		return;
	}
	
	var url =
		'/include/certificate_pdf02.php?CompanyCode=' +
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

//아카이브>수강마감 - 교육종료
function StudyFinish(LectureStart, LectureEnd, CompanyCode, CompanyName) {
	if(confirm("확인 전에 재수강 중인 수강생은 없나요? ")){	
		if (confirm('교육종료 하시겠습니까? 교육종료시 취소가 불가합니다.')) {
			$.post(
				'./study_finish.php',
				{
					LectureStart: LectureStart,
					LectureEnd  : LectureEnd,
					CompanyCode : CompanyCode,
					CompanyName  : CompanyName,
				},
				function (data, status) {
					if (data != 'Y') {
						alert('처리중 문제가 발생했습니다.');
					} else {
						StudyEndSearch(1);
					}
				}
			);
		}
	}
}

//아카이브>수강마감 - 마감기능
function StudyEndComplete(CompanyCode, LectureCode, LectureStart, LectureEnd) {
	if(confirm("확인 전에 재수강 중인 수강생은 없나요? ")){
		if (confirm('[마감처리] 하시겠습니까? 마감처리시 취소가 불가합니다.')) {
			$.post(
				'./study_end_complete.php',
				{
					CompanyCode: CompanyCode,
					LectureStart: LectureStart,
					LectureEnd: LectureEnd,
					LectureCode: LectureCode,
				},
				function (data, status) {
					if (data != 'Y') {
						alert('처리중 문제가 발생했습니다.');
					} else {
						StudyEndSearch(1);
					}
				}
			);
		}
	}
} 

//아카이브>수강마감 - 교육결과보고서 다운로드
function archiveReport(CompanyCode,LectureStart, LectureEnd) {
    var url =
		'/include/archive_report.html?CompanyCode=' +
		CompanyCode +
		'&LectureStart=' +
		LectureStart +
		'&LectureEnd=' +
		LectureEnd;
	window.open(url, 'certi', 'scrollbars=yes, resizable=yes, left=400, width=820, height=700');
    window.open(url, 'certi', 'scrollbars=yes, resizable=yes, left=400, width=820, height=700');
}

//아카이브>수강마감 - 훈련진행보고서 다운로드
function archiveReport02(CompanyCode,LectureStart, LectureEnd) {
    var url =
		'/include/archive_report02.html?CompanyCode=' +
		CompanyCode +
		'&LectureStart=' +
		LectureStart +
		'&LectureEnd=' +
		LectureEnd;
    window.open(url, 'certi', 'scrollbars=yes, resizable=yes, left=400, width=820, height=700');
}

//아카이브>수강마감 - 훈련진행보고서 메일발송
function StudyEndDocument02Mail(CompanyCode, LectureStart, LectureEnd) {
	if (confirm('교육진행보고서 메일 발송을 하시겠습니까?')) {
		$.post(
			'./study_end_doc02_mail.php',
			{
				CompanyCode : CompanyCode,
				LectureStart: LectureStart,
				LectureEnd  : LectureEnd,
			},
			function (data, status) {
				if (data != 'Y') {
					alert('처리중 문제가 발생했습니다.');
				} else {
					alert('메일발송이 완료되었습니다.');
					StudyEndSearch(1);
				}
			}
		);
	}
}
/* 아카이브>수강마감 END --------------------------------------------------------------------------------------- */



//수강관리>IP모니터링 - 조회
function certificationIPSearch(pg) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var SearchGubun = $(':radio[name="SearchGubun"]:checked').val();
	var CompanyName = $('#CompanyName').val();
	var SearchYear = $('#SearchYear').val();
	var SearchMonth = $('#SearchMonth').val();
	// var StudyPeriod = $('#StudyPeriod').val();
	var CompanyCode = $('#CompanyCode').val();
	var ID = $('#ID').val();
	var SalesID = $('#SalesID').val();
	var SalesTeam = $('#SalesTeam').val();
	var TutorStatus = $('#TutorStatus').val();
	var LectureCode = $('#LectureCode').val();
	var ServiceType = $('#ServiceType').val();
	var certCount = $('#certCount').val();
	
	if (SearchGubun == 'B') {
		if (CompanyName == '') {
			alert('사업주명을 입력하세요.');
			return;
		}
	}

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
			top: '350px',
			left: LocWidth,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$.post(
		'./certification_search_result.php',
		{
			SearchGubun: SearchGubun,
			CompanyName: CompanyName,
			SearchYear: SearchYear,
			SearchMonth: SearchMonth,
			// StudyPeriod: StudyPeriod,
			CompanyCode: CompanyCode,
			ID: ID,
			SalesID: SalesID,
			SalesTeam: SalesTeam,		
			TutorStatus: TutorStatus,
			LectureCode: LectureCode,
			ServiceType: ServiceType,
			certCount: certCount,
			pg: pg,
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

function FlashPlayer(url) {
	var url = './flase_player.php?url=' + url;
	window.open(url, 'player', 'scrollbars=no, resizable=no, left=100, width=1212, height=850');
}

function MoviePlayer(url, sel) {
	var url = './movie_player.php?url=' + url + '&sel=' + sel;
	window.open(url, 'player', 'scrollbars=no, resizable=no, left=100, width=800, height=600');
}

function MobilePlayer(url, sel) {
	var url = './mobile_player.php?url=' + url + '&sel=' + sel;
	window.open(url, 'player', 'scrollbars=no, resizable=no, left=100, width=800, height=700');
}

function StudyIPSearch2(pg) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var SearchGubun = $(':radio[name="SearchGubun"]:checked').val();
	var CompanyName = $('#CompanyName').val();
	var SearchYear = $('#SearchYear').val();
	var SearchMonth = $('#SearchMonth').val();
	var StudyPeriod = $('#StudyPeriod').val();
	var CompanyCode = $('#CompanyCode').val();
	var ID = $('#ID').val();
	var SalesID = $('#SalesID').val();
	var SalesTeam = $('#SalesTeam').val();
	var Progress1 = $('#Progress1').val();
	var Progress2 = $('#Progress2').val();
	var TotalScore1 = $('#TotalScore1').val();
	var TotalScore2 = $('#TotalScore2').val();
	var TutorStatus = $('#TutorStatus').val();
	var LectureCode = $('#LectureCode').val();
	var PassOk = $('#PassOk').val();
	var ServiceType = $('#ServiceType').val();
	var PackageYN = $('#PackageYN').val();
	var certCount = $('#certCount').val();
	var MidStatus = $('#MidStatus').val();
	var TestStatus = $('#TestStatus').val();
	var ReportStatus = $('#ReportStatus').val();
	var TestCopy = $('#TestCopy').val();
	var ReportCopy = $('#ReportCopy').val();

	var ip_addr = $('#ip_addr').val();

	if (StudyPeriod != '') {
		StudyPeriod_array = StudyPeriod.split('~');
		var LectureStart = StudyPeriod_array[0];
		var LectureEnd = StudyPeriod_array[1];
	}

	if (SearchGubun == 'B') {
		if (CompanyName == '') {
			alert('사업주명을 입력하세요.');
			return;
		}
	}

	if (Progress1 != '' || Progress2 != '') {
		if (IsNumber(Progress1) == false || IsNumber(Progress2) == false) {
			alert('진도율은 숫자만 입력하세요.');
			return;
		}
	}
	/*
	if(TotalScore1!="" || TotalScore2!="") {
		if(IsNumber(TotalScore1)==false || IsNumber(TotalScore2)==false) {
			alert("총점은 숫자만 입력하세요.");
			return;
		}
	}
	*/

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
			top: '350px',
			left: LocWidth,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$.post(
		'./study_ip_search_result.php',
		{
			SearchGubun: SearchGubun,
			CompanyName: CompanyName,
			SearchYear: SearchYear,
			SearchMonth: SearchMonth,
			StudyPeriod: StudyPeriod,
			CompanyCode: CompanyCode,
			ID: ID,
			SalesID: SalesID,
			SalesTeam: SalesTeam,
			Progress1: Progress1,
			Progress2: Progress2,
			TotalScore1: TotalScore1,
			TotalScore2: TotalScore2,
			TutorStatus: TutorStatus,
			LectureCode: LectureCode,
			PassOk: PassOk,
			ServiceType: ServiceType,
			PackageYN: PackageYN,
			certCount: certCount,
			MidStatus: MidStatus,
			TestStatus: TestStatus,
			ReportStatus: ReportStatus,
			TestCopy: TestCopy,
			ReportCopy: ReportCopy,
			LectureStart: LectureStart,
			LectureEnd: LectureEnd,
			pg: pg,
			ip_addr : ip_addr
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

function StudyIPExcel2() {
	Yes = confirm('현재 검색조건으로 검색된 결과를 엑셀로 출력하시겠습니까?');
	if (Yes == true) {
		document.search.action = 'study_ip_search_excel.php';
		document.search.target = 'ScriptFrame';
		document.search.submit();
	}
}

function CheckBox_AllSelect(obj) {
	if ($("input:checkbox[name='AllCheck']").is(':checked') == true) {
		$("input:checkbox[name='" + obj + "']").prop('checked', true);
	} else {
		$("input:checkbox[name='" + obj + "']").prop('checked', false);
	}
}

//수강관리>과정이수데이터관리 - 조회
function CourseDataSearch(pg) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	var SearchGubun = $(':radio[name="SearchGubun"]:checked').val();
	var CompanyName = $('#CompanyName').val();
	var SearchYear = $('#SearchYear').val();
	var SearchYear2 = $('#SearchYear2').val();
	var SearchMonth = $('#SearchMonth').val();
	var SearchMonth2 = $('#SearchMonth2').val();
	var StudyPeriod = $('#StudyPeriod').val();
	var StudyPeriod2 = $('#StudyPeriod2').val();
	var CompanyCode = $('#CompanyCode').val();
	var OpenChapter = $('#OpenChapter').val();
	
	var LectureStart = '';
	var LectureEnd = '';

	if (StudyPeriod == '' || StudyPeriod == undefined) {
		StudyPeriod = '';
	}
	if (StudyPeriod2 == '' || StudyPeriod2 == undefined) {
		StudyPeriod2 = '';
	}

	if (SearchGubun == 'A') {
		if (StudyPeriod != '') {
			StudyPeriod_array = StudyPeriod.split('~');
			LectureStart = StudyPeriod_array[0];
			LectureEnd = StudyPeriod_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (StudyPeriod2 != '') {
			StudyPeriod2_array = StudyPeriod2.split('~');
			LectureStart = StudyPeriod2_array[0];
			LectureEnd = StudyPeriod2_array[1];
		}
		
		if (CompanyName == '') {
			alert('사업주명을 입력하세요.');
			return;
		}
	}
	
	if ((OpenChapter != '') && (IsNumber(OpenChapter) == false)) {
		alert('실시회차는 숫자만 입력하세요.');
		$('#OpenChapter').focus();
		return;
	}else if((OpenChapter != '') && (OpenChapter<1)){
		alert('실시회차는 1이상 숫자만 입력하세요.');
		$('#OpenChapter').focus();
		return;
	}

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
			top: '350px',
			left: LocWidth,
			opacity: '1.0',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$.post(
		'./course_data_search_result.php',
		{
			SearchGubun: SearchGubun,
			CompanyName: CompanyName,
			SearchYear: SearchYear,
			SearchYear2 : SearchYear2,
			SearchMonth: SearchMonth,
			SearchMonth2 : SearchMonth2,
			StudyPeriod: StudyPeriod,
			StudyPeriod2: StudyPeriod2,
			CompanyCode: CompanyCode,
			OpenChapter: OpenChapter,
			LectureStart: LectureStart,
			LectureEnd: LectureEnd,
			pg: pg,
		},
		function (data, status) {
			setTimeout(function () {
				$('#SearchResult').html(data);
				$("div[id='Roading']").hide();
				$("div[id='SysBg_White']").hide();
			}, 500);
		}
	);
}

//수강관리>과정이수데이터관리 - 검색결과 엑셀출력
function CourseDataExcel() {	
	var SearchGubun = $(':radio[name="SearchGubun"]:checked').val();
	var StudyPeriod = $('#StudyPeriod').val();
	var StudyPeriod2 = $('#StudyPeriod2').val();

	var LectureStart = '';
	var LectureEnd = '';

	if (StudyPeriod == '' || StudyPeriod == undefined) {
		StudyPeriod = '';
	}
	if (StudyPeriod2 == '' || StudyPeriod2 == undefined) {
		StudyPeriod2 = '';
	}

	if (SearchGubun == 'A') {
		if (StudyPeriod != '') {
			StudyPeriod_array = StudyPeriod.split('~');
			LectureStart = StudyPeriod_array[0];
			LectureEnd = StudyPeriod_array[1];
		}
	}

	if (SearchGubun == 'B') {
		if (StudyPeriod2 != '') {
			StudyPeriod2_array = StudyPeriod2.split('~');
			LectureStart = StudyPeriod2_array[0];
			LectureEnd = StudyPeriod2_array[1];
		}
	}

	Yes = confirm('현재 검색조건으로 검색된 결과를 엑셀로 출력하시겠습니까?');
	if (Yes == true) {
		document.search.action = 'course_data_search_excel.php';
		document.search.target = 'ScriptFrame';
		document.search.LectureStart.value = LectureStart;
		document.search.LectureEnd.value = LectureEnd;
		document.search.CompanyCodeA.value = $('#CompanyCode').val();
		document.search.submit();
	}
}

function LectureCompanySearch() {
	var StudyPeriod = $('#StudyPeriod').val();
	var SubmitFunction = $('#SubmitFunction').val();

	if (StudyPeriod == '') {
		$("span[id='LectureCompanyResult']").html('&nbsp;&nbsp;<B>기간을 선택하세요.</B>');
	} else {
		var currentWidth = $(window).width();
		var LocWidth = currentWidth / 2;
		var body_width = screen.width - 20;
		var body_height = $('html body').height();

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
				top: '350px',
				left: LocWidth,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '200',
			})
			.show();

		StudyPeriod_array = StudyPeriod.split('~');
		var LectureStart = StudyPeriod_array[0];
		var LectureEnd = StudyPeriod_array[1];

		$("span[id='LectureCompanyResult']").load(
			'./study_lectureterme_company.php',
			{ LectureStart: LectureStart, LectureEnd: LectureEnd, SubmitFunction: SubmitFunction },
			function () {
				$("div[id='SysBg_White']").hide();
				$("div[id='Roading']").hide();
			}
		);
	}
}









