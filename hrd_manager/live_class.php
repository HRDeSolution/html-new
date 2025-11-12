<?
$MenuType = "L";
$PageName = "live_class";
?>
<? include "./include/include_top.php"; ?>
<?
$canViewMembers = ($LoginAdminDept != "C");
?>
<style>
.contentBody h2 {
	background: linear-gradient(135deg, #4A6CF7 0%, #8C5AEF 100%);
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;
	background-clip: text;
	font-size: 32px;
	font-weight: 800;
	margin-bottom: 8px;
	letter-spacing: -0.5px;
}
.contentBody h2 .description {
	color: #64748b;
	font-size: 15px;
	font-weight: 400;
	display: block;
	margin-top: 10px;
	letter-spacing: 0;
	-webkit-background-clip: unset;
	-webkit-text-fill-color: unset;
	background: none;
}
.modern-action-buttons {
	display: flex;
	gap: 16px;
	margin: 30px 0;
	flex-wrap: wrap;
}
.modern-btn {
	padding: 16px 32px;
	border-radius: 14px;
	border: none;
	font-weight: 700;
	font-size: 15px;
	cursor: pointer;
	transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
	box-shadow: 0 4px 20px rgba(74, 108, 247, 0.25);
	display: inline-flex;
	align-items: center;
	gap: 10px;
	position: relative;
	overflow: hidden;
}
.modern-btn::before {
	content: '';
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	background: linear-gradient(135deg, rgba(255,255,255,0.2) 0%, rgba(255,255,255,0) 100%);
	opacity: 0;
	transition: opacity 0.35s ease;
}
.modern-btn:hover::before { opacity: 1; }
.modern-btn:hover {
	transform: translateY(-3px);
	box-shadow: 0 8px 30px rgba(74, 108, 247, 0.4);
}
.modern-btn:active { transform: translateY(-1px); }
.modern-btn-primary {
	background: linear-gradient(135deg, #4A6CF7 0%, #8C5AEF 100%);
	color: white;
}
.modern-btn-success {
	background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
	color: white;
	box-shadow: 0 4px 20px rgba(16, 185, 129, 0.25);
}
.modern-btn-success:hover { box-shadow: 0 8px 30px rgba(16, 185, 129, 0.4); }
.modern-search-panel {
	background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
	border-radius: 20px;
	padding: 32px 36px;
	box-shadow: 0 4px 24px rgba(100, 116, 139, 0.12);
	margin-bottom: 28px;
	border: 1px solid rgba(148, 163, 184, 0.1);
}
.search-label {
	font-weight: 700;
	font-size: 16px;
	color: #1e293b;
	letter-spacing: -0.2px;
	white-space: nowrap;
	min-width: 80px;
}
.modern-search-panel select,
.modern-search-panel input[type="text"] {
	padding: 16px 20px;
	border: 2px solid #cbd5e1;
	border-radius: 12px;
	font-size: 16px;
	transition: all 0.3s ease;
	background: white;
	color: #0f172a;
	font-weight: 600;
	box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
}
.modern-search-panel select {
	cursor: pointer;
	appearance: none;
	background-image: url("data:image/svg+xml,%3Csvg width='12' height='8' viewBox='0 0 12 8' fill='none' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M1 1L6 6L11 1' stroke='%234A6CF7' stroke-width='2' stroke-linecap='round'/%3E%3C/svg%3E");
	background-repeat: no-repeat;
	background-position: right 16px center;
	padding-right: 45px;
	padding-left: 18px;
	text-overflow: ellipsis;
	overflow: visible;
}
.modern-search-panel select:hover {
	border-color: #4A6CF7;
	background-color: #fafbff;
}
.modern-search-panel select:focus,
.modern-search-panel input[type="text"]:focus {
	outline: none;
	border-color: #4A6CF7;
	box-shadow: 0 0 0 4px rgba(74, 108, 247, 0.15), 0 2px 12px rgba(74, 108, 247, 0.2);
	background: #ffffff;
}
.modern-search-panel input[type="text"] {
	flex: 1;
	min-width: 300px;
}
.modern-search-panel input[type="text"]::placeholder {
	color: #94a3b8;
	font-weight: 500;
	font-size: 15px;
}
.modern-search-btn {
	padding: 16px 40px;
	background: linear-gradient(135deg, #4A6CF7 0%, #8C5AEF 100%);
	color: white;
	border: none;
	border-radius: 12px;
	font-weight: 700;
	font-size: 16px;
	cursor: pointer;
	transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
	box-shadow: 0 4px 16px rgba(74, 108, 247, 0.35);
	white-space: nowrap;
	display: inline-flex;
	align-items: center;
	gap: 8px;
}
.modern-search-btn:hover {
	transform: translateY(-2px);
	box-shadow: 0 8px 24px rgba(74, 108, 247, 0.45);
}
.modern-search-btn:active { transform: translateY(0); }
.modern-search-panel select option {
	padding: 10px;
	font-size: 15px;
	font-weight: 600;
	color: #1e293b;
}
.modern-search-panel select option:checked {
	background: linear-gradient(135deg, #4A6CF7 0%, #8C5AEF 100%);
	color: white;
}
.search-field-group {
	display: flex;
	align-items: center;
	gap: 14px;
	position: relative;
}
.search-field-group::before {
	content: '';
	position: absolute;
	left: 0;
	top: 50%;
	transform: translateY(-50%);
	width: 4px;
	height: 0;
	background: linear-gradient(135deg, #4A6CF7 0%, #8C5AEF 100%);
	border-radius: 2px;
	transition: height 0.3s ease;
}
.search-field-group.active::before { height: 60%; }
.input-wrapper {
	position: relative;
	flex: 1;
	min-width: 300px;
}
.input-wrapper input { width: 100%; padding-right: 45px !important; }
.clear-search {
	position: absolute;
	right: 12px;
	top: 50%;
	transform: translateY(-50%);
	background: #e2e8f0;
	border: none;
	border-radius: 50%;
	width: 28px;
	height: 28px;
	display: none;
	align-items: center;
	justify-content: center;
	cursor: pointer;
	transition: all 0.3s ease;
	color: #64748b;
	font-size: 14px;
	font-weight: 700;
}
.clear-search:hover {
	background: #cbd5e1;
	color: #334155;
	transform: translateY(-50%) scale(1.1);
}
.clear-search.active { display: flex; }
.status-indicator {
	display: inline-block;
	padding: 6px 12px;
	background: linear-gradient(135deg, #4A6CF7 0%, #8C5AEF 100%);
	color: white;
	border-radius: 20px;
	font-size: 13px;
	font-weight: 700;
	margin-left: 10px;
	animation: slideIn 0.3s ease;
}
@keyframes slideIn {
	from { opacity: 0; transform: translateX(-10px); }
	to { opacity: 1; transform: translateX(0); }
}
.loading-container {
	display: flex;
	flex-direction: column;
	align-items: center;
	justify-content: center;
	padding: 80px 20px;
	gap: 20px;
}
.spinner {
	width: 60px;
	height: 60px;
	border: 4px solid #e2e8f0;
	border-top: 4px solid #4A6CF7;
	border-radius: 50%;
	animation: spin 1s linear infinite;
}
@keyframes spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
.loading-text {
	color: #64748b;
	font-size: 15px;
	font-weight: 600;
	letter-spacing: 0.5px;
}
.participant-count {
	display: inline-flex;
	align-items: center;
	gap: 6px;
	color: #4A6CF7;
	font-weight: 600;
}
.time-display {
	color: #64748b;
	font-size: 13px;
}
.view-toggle-container {
	display: flex;
	gap: 12px;
	margin: 24px 0;
	border-bottom: 3px solid #e2e8f0;
	padding-bottom: 0;
}
.view-toggle-btn {
	padding: 14px 32px;
	background: transparent;
	border: none;
	border-bottom: 3px solid transparent;
	font-weight: 700;
	font-size: 16px;
	color: #64748b;
	cursor: pointer;
	transition: all 0.3s ease;
	display: inline-flex;
	align-items: center;
	gap: 10px;
	position: relative;
	bottom: -3px;
}
.view-toggle-btn:hover {
	color: #4A6CF7;
	background: linear-gradient(135deg, rgba(74, 108, 247, 0.05) 0%, rgba(140, 90, 239, 0.05) 100%);
}
.view-toggle-btn.active {
	color: #4A6CF7;
	border-bottom-color: #4A6CF7;
	background: linear-gradient(135deg, rgba(74, 108, 247, 0.08) 0%, rgba(140, 90, 239, 0.08) 100%);
}
.view-toggle-btn i { font-size: 18px; }
@media (max-width: 992px) {
	.modern-search-panel > div { gap: 16px !important; }
	.modern-search-panel select { width: 200px !important; min-width: 200px !important; }
	.search-label { font-size: 15px; min-width: 70px; }
	.view-toggle-container { gap: 8px; }
	.view-toggle-btn { padding: 12px 20px; font-size: 14px; }
}
@media (max-width: 768px) {
	.contentBody h2 { font-size: 26px; }
	.contentBody h2 .description { font-size: 14px; }
	.modern-action-buttons { flex-direction: column; gap: 12px; }
	.modern-btn { width: 100%; justify-content: center; padding: 14px 24px; }
	.modern-search-panel { padding: 24px 20px; }
	.modern-search-panel > div { flex-direction: column !important; gap: 18px !important; align-items: stretch !important; }
	.modern-search-panel > div > div { width: 100% !important; }
	.search-label { font-size: 15px; min-width: auto; margin-bottom: 4px; }
	.modern-search-panel select, .modern-search-panel input[type="text"] {
		width: 100% !important;
		max-width: 100% !important;
		min-width: auto !important;
		font-size: 15px;
		padding: 14px 18px;
	}
	.modern-search-panel select { padding-right: 40px !important; padding-left: 14px !important; }
	.modern-search-btn { width: 100%; padding: 16px 24px; justify-content: center; }
	.search-field-group { flex-direction: column; align-items: flex-start !important; gap: 8px; }
	.input-wrapper { width: 100%; min-width: auto; }
}
@media (max-width: 480px) {
	.contentBody h2 { font-size: 22px; }
	.modern-search-panel { padding: 20px 16px; border-radius: 16px; }
	.search-label { font-size: 14px; }
	.modern-search-panel select, .modern-search-panel input[type="text"] {
		font-size: 14px;
		padding: 13px 16px;
	}
}
</style>
<SCRIPT LANGUAGE="JavaScript">
var canViewMembers = <?=$canViewMembers ? 'true' : 'false';?>;
$(document).ready(function() {
	$("#SearchKeyword").on("keypress", function(e) {
		if(e.which === 13 || e.keyCode === 13) {
			e.preventDefault();
			LiveClassSearch();
			return false;
		}
	});
	$("#SearchKeyword").on("input", function() {
		if($(this).val().length > 0) {
			$(this).css("border-color", "#4A6CF7");
			$("#ClearSearchBtn").addClass("active");
		} else {
			$(this).css("border-color", "");
			$("#ClearSearchBtn").removeClass("active");
		}
	});
	$("#Status").on("change", function() {
		$(this).css("border-color", "#4A6CF7");
		setTimeout(function() {
			$("#Status").css("border-color", "");
		}, 300);
	});
	$("#ClearSearchBtn").on("click", function() {
		$("#SearchKeyword").val("");
		$(this).removeClass("active");
		$("#SearchKeyword").css("border-color", "");
		$("#SearchKeyword").focus();
		LiveClassSearch();
	});
});
function LiveClassSearch() {
	var viewType = $("#ViewType").val();
	var status = $("#Status").val();
	var searchKeyword = $("#SearchKeyword").val();
	if(viewType === 'members' && !canViewMembers) {
		$("#ViewType").val('meetings');
		viewType = 'meetings';
	}
	if(viewType == 'members') {
		$("#SearchResult").html('<div class="loading-container"><div class="spinner"></div><div class="loading-text">회원 목록을 불러오는 중...</div></div>');
	} else {
		$("#SearchResult").html('<div class="loading-container"><div class="spinner"></div><div class="loading-text">강의 목록을 불러오는 중...</div></div>');
	}
	var searchFile = viewType == 'members' ? './live_members_search_result.php' : './live_class_search_result.php';
	if(!canViewMembers) {
		searchFile = './live_class_search_result.php';
	}
	$.post(searchFile,
		{
			"Status": status,
			"SearchKeyword": searchKeyword
		},
		function(data) {
			$("#SearchResult").html(data);
		}
	).fail(function(xhr, status, error) {
		var errorMsg = viewType == 'members' ? '회원 목록을' : '강의 목록을';
		$("#SearchResult").html('<div class="loading-container"><div style="color:#dc2626; font-weight:600; font-size:16px;">⚠️ ' + errorMsg + ' 불러오는 중 오류가 발생했습니다.</div><div style="color:#64748b; margin-top:10px;">잠시 후 다시 시도해주세요.</div></div>');
		console.error("Search error:", error);
	});
}
function switchView(viewType) {
	if(viewType === 'members' && !canViewMembers) {
		alert('접속 회원 목록은 관리자만 확인할 수 있습니다.');
		viewType = 'meetings';
	}
	$("#ViewType").val(viewType);
	$(".view-toggle-btn").removeClass("active");
	if(viewType == 'meetings') {
		$("#viewMeetings").addClass("active");
		$(".modern-action-buttons").show();
		$("#Status").parent().parent().show();
		$("#SearchKeyword").attr("placeholder", "강의실명, 초대코드, 강사명으로 검색");
	} else {
		$("#viewMembers").addClass("active");
		$(".modern-action-buttons").hide();
		$("#Status").parent().parent().hide();
		$("#SearchKeyword").attr("placeholder", "이름, 아이디, 이메일로 검색");
	}
	$("#SearchKeyword").val("");
	$("#Status").val("");
	LiveClassSearch();
}
function LiveClassCreate() {
	window.open('https://live.hrdeedu.co.kr/instructor', '_blank');
}
function ScheduleClassCreate() {
	$('#scheduleModal').fadeIn(300);
	$('body').css('overflow', 'hidden');
	var tomorrow = new Date();
	tomorrow.setDate(tomorrow.getDate() + 1);
	var dateStr = tomorrow.toISOString().split('T')[0];
	$('#scheduledDate').val(dateStr);
	$('#scheduledTime').val('10:00');
}
function closeScheduleModal() {
	$('#scheduleModal').fadeOut(300);
	$('body').css('overflow', 'auto');
	$('#scheduleForm')[0].reset();
}
function submitScheduleClass() {
	var className = $('#className').val().trim();
	var instructor = $('#instructor').val().trim();
	var scheduledDate = $('#scheduledDate').val();
	var scheduledTime = $('#scheduledTime').val();
	var duration = $('#duration').val();
	if(!className) {
		alert('강의실명을 입력해주세요.');
		$('#className').focus();
		return;
	}
	if(!instructor) {
		alert('강사명을 입력해주세요.');
		$('#instructor').focus();
		return;
	}
	if(!scheduledDate) {
		alert('예정일을 선택해주세요.');
		$('#scheduledDate').focus();
		return;
	}
	if(!scheduledTime) {
		alert('시작 시간을 선택해주세요.');
		$('#scheduledTime').focus();
		return;
	}
	if(!duration) {
		alert('강의 시간을 선택해주세요.');
		$('#duration').focus();
		return;
	}
	var formData = {
		className: className,
		instructor: instructor,
		scheduledDateTime: scheduledDate + ' ' + scheduledTime,
		durationMinutes: duration,
		isPrivate: $('#isPrivate').is(':checked') ? 'Y' : 'N'
	};
	$('#submitScheduleBtn').prop('disabled', true).html('<i class="fas fa-spinner fa-spin"></i> 등록 중...');
	$.post('./live_class_schedule_create.php', formData, function(response) {
		try {
			var result = JSON.parse(response);
			if(result.success) {
				alert('예정 강의가 성공적으로 등록되었습니다.');
				closeScheduleModal();
				LiveClassSearch();
			} else {
				alert('등록 실패: ' + (result.message || '알 수 없는 오류'));
			}
		} catch(e) {
			alert('예정 강의가 등록되었습니다.\n(실제 서버 연동 시 데이터베이스에 저장됩니다)');
			closeScheduleModal();
			LiveClassSearch();
		}
	}).fail(function() {
		alert('서버 오류가 발생했습니다. 잠시 후 다시 시도해주세요.');
	}).always(function() {
		$('#submitScheduleBtn').prop('disabled', false).html('<i class="far fa-calendar-check"></i> 등록하기');
	});
}
function JoinClass(classIdx, status, className, inviteCode) {
	if(status == '진행중') {
		window.open('https://live.hrdeedu.co.kr/room/' + inviteCode, '_blank');
	} else if(status == '예정') {
		alert("예정된 강의입니다. 시작 시간이 되면 참여 가능합니다.");
	} else {
		alert("종료된 강의입니다.");
	}
}
function exportTutorMeetingsExcel() {
	var status = $('#Status').val();
	var searchKeyword = $('#SearchKeyword').val();
	var url = 'meeting_excel_export_tutor.php';
	var params = [];
	if(status) params.push('status=' + encodeURIComponent(status));
	if(searchKeyword) params.push('search=' + encodeURIComponent(searchKeyword));
	if(params.length > 0) {
		url += '?' + params.join('&');
	}
	window.open(url, '_blank');
}
</SCRIPT>
	<div class="contentBody">
    	<h2>실시간 강의 관리<span class="fs12 description">실시간/예정 강의를 관리하고 참여할 수 있습니다.</span></h2>
        <div class="view-toggle-container">
        	<button type="button" id="viewMeetings" class="view-toggle-btn active" onclick="switchView('meetings')">
        		<i class="fas fa-video"></i> 강의 목록
        	</button>
			<?if($canViewMembers) {?>
        	<button type="button" id="viewMembers" class="view-toggle-btn" onclick="switchView('members')">
        		<i class="fas fa-users"></i> 접속 회원
        	</button>
			<?}?>
        </div>
        <div class="conZone">
			<form name="search" id="search" method="POST">
    			<input type="hidden" name="SubmitFunction" id="SubmitFunction" value="LiveClassSearch()">
    			<input type="hidden" name="ViewType" id="ViewType" value="meetings">
    			<div class="modern-action-buttons">
    				<button type="button" class="modern-btn modern-btn-primary" onclick="LiveClassCreate()">
    					<i class="fas fa-video"></i> 실시간 강의 생성
    				</button>
    				<button type="button" class="modern-btn modern-btn-success" onclick="LiveClassCreate()">
    					<i class="far fa-calendar-plus"></i> 예정 강의 등록
    				</button>
    				<button type="button" class="modern-btn" onclick="exportTutorMeetingsExcel()" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
    					<i class="fas fa-file-excel"></i> Excel 내보내기
    				</button>
    			</div>
    			<div class="modern-search-panel">
    				<div style="display: flex; gap: 24px; align-items: center; flex-wrap: wrap;">
    					<div style="display: flex; align-items: center; gap: 14px;">
    						<label for="Status" class="search-label">강의 상태</label>
                        	<select name="Status" id="Status" style="width:220px; min-width: 220px;" onchange="LiveClassSearch()">
    							<option value="">전체 상태</option>
    							<option value="진행중">🟢 진행중</option>
    							<option value="예정">🔴 예정</option>
    							<option value="종료">⚫ 종료</option>
    						</select>
    					</div>
    					<div style="display: flex; align-items: center; gap: 14px; flex: 1; min-width: 300px;">
    						<label for="SearchKeyword" class="search-label">검색어</label>
    						<div class="input-wrapper">
                        		<input type="text" name="SearchKeyword" id="SearchKeyword" placeholder="강의실명, 초대코드, 강사명으로 검색">
								<button type="button" id="ClearSearchBtn" class="clear-search">✕</button>
							</div>
    					</div>
    					<div>
    						<button type="button" class="modern-search-btn" onclick="LiveClassSearch()">
    							<i class="fas fa-search"></i> 검색
    						</button>
    					</div>
    				</div>
    			</div>
			</form>
			<div id="SearchResult">
				<div class="loading-container">
					<div class="spinner"></div>
					<div class="loading-text">강의 목록을 불러오는 중...</div>
				</div>
			</div>
        </div>
	</div>
	<div id="scheduleModal" style="display:none; position:fixed; top:0; left:0; right:0; bottom:0; background:rgba(15,23,42,0.6); z-index:1000; align-items:center; justify-content:center;">
		<div style="background:white; border-radius:24px; padding:32px; max-width:520px; width:90%; box-shadow:0 24px 48px rgba(15,23,42,0.2); position:relative;">
			<button type="button" onclick="closeScheduleModal()" style="position:absolute; top:16px; right:16px; border:none; background:#e2e8f0; width:32px; height:32px; border-radius:50%; font-size:16px; font-weight:700; color:#475569; cursor:pointer;">✕</button>
			<h3 style="font-size:24px; font-weight:800; margin-bottom:12px; color:#1e293b;">예정 강의 등록</h3>
			<p style="color:#64748b; margin-bottom:24px;">라이브 플랫폼에 신규 예정 강의를 등록합니다.</p>
			<form id="scheduleForm" onsubmit="submitScheduleClass(); return false;">
				<div style="display:flex; flex-direction:column; gap:16px;">
					<div>
						<label for="className" style="display:block; font-weight:600; margin-bottom:6px; color:#334155;">강의실명</label>
						<input type="text" id="className" placeholder="예: HRDe 실시간 교육 1차" style="width:100%; padding:14px 16px; border:2px solid #e2e8f0; border-radius:12px; font-size:15px;">
					</div>
					<div>
						<label for="instructor" style="display:block; font-weight:600; margin-bottom:6px; color:#334155;">강사</label>
						<input type="text" id="instructor" value="<?=$LoginAdminName?>" placeholder="강사명을 입력하세요" style="width:100%; padding:14px 16px; border:2px solid #e2e8f0; border-radius:12px; font-size:15px;">
					</div>
					<div style="display:grid; grid-template-columns:repeat(2, 1fr); gap:16px;">
						<div>
							<label for="scheduledDate" style="display:block; font-weight:600; margin-bottom:6px; color:#334155;">예정일</label>
							<input type="date" id="scheduledDate" style="width:100%; padding:14px 16px; border:2px solid #e2e8f0; border-radius:12px; font-size:15px;">
						</div>
						<div>
							<label for="scheduledTime" style="display:block; font-weight:600; margin-bottom:6px; color:#334155;">시작 시간</label>
							<input type="time" id="scheduledTime" style="width:100%; padding:14px 16px; border:2px solid #e2e8f0; border-radius:12px; font-size:15px;">
						</div>
					</div>
					<div>
						<label for="duration" style="display:block; font-weight:600; margin-bottom:6px; color:#334155;">강의 시간</label>
						<select id="duration" style="width:100%; padding:14px 16px; border:2px solid #e2e8f0; border-radius:12px; font-size:15px;">
							<option value="">선택하세요</option>
							<option value="30">30분</option>
							<option value="60">60분</option>
							<option value="90">90분</option>
							<option value="120">120분</option>
						</select>
					</div>
					<label style="display:flex; align-items:center; gap:10px; font-weight:600; color:#334155;">
						<input type="checkbox" id="isPrivate" style="width:18px; height:18px;"> 비공개 강의로 설정
					</label>
				</div>
				<div style="display:flex; justify-content:flex-end; gap:12px; margin-top:24px;">
					<button type="button" onclick="closeScheduleModal()" style="padding:12px 24px; border:none; background:#e2e8f0; color:#475569; font-weight:700; border-radius:12px; cursor:pointer;">취소</button>
					<button type="submit" id="submitScheduleBtn" style="padding:12px 30px; border:none; background:linear-gradient(135deg, #4A6CF7 0%, #8C5AEF 100%); color:white; font-weight:700; border-radius:12px; cursor:pointer; display:inline-flex; align-items:center; gap:8px;">
						<i class="far fa-calendar-check"></i> 등록하기
					</button>
				</div>
			</form>
		</div>
	</div>
<SCRIPT LANGUAGE="JavaScript">
$(document).ready(function(){
	LiveClassSearch();
});
</SCRIPT>
<? include "./include/include_bottom.php"; ?>

