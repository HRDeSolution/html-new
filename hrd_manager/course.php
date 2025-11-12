<?
$MenuType = "E";
$PageName = "course";
$ReadPage = "course_read";
?>
<? include "./include/include_top.php"; ?>
<?
// Ensure GET parameter has priority (aligned with html-solution)
if(isset($_GET['ctype']) && $_GET['ctype']) {
    $ctype = Replace_Check($_GET['ctype']);
    $_SESSION["ctype_session"] = $ctype;
} elseif($ctype) {
    $_SESSION["ctype_session"] = $ctype;
} else {
    if(isset($_SESSION['ctype_session']) && $_SESSION['ctype_session']) {
        $ctype = $_SESSION['ctype_session'];
    } else {
        $ctype = "X";
        $_SESSION["ctype_session"] = $ctype;
    }
}
if($ctype == "X") $MenuName = "이러닝";
if($ctype == "Y") $MenuName = "숏폼";
if($ctype == "Z") $MenuName = "마이크로닝";
if($ctype == "W") $MenuName = "비환급";
if($ctype == "R") $MenuName = "실시간 강의실";

// ============================================================================
// SPECIAL HANDLING FOR ctype=R (Real-time Meeting Rooms from MongoDB)
// ============================================================================
if($ctype == "R") {
    include "../include/include_mongodb.php";

    $col = Replace_Check($_GET['col'] ?? '');
    $sw = Replace_Check($_GET['sw'] ?? '');
    $statusFilter = Replace_Check($_GET['status'] ?? '');
    $tutorFilter = Replace_Check($_GET['tutor'] ?? '');

    if($LoginAdminDept == "C" && !$tutorFilter) {
        $tutorFilter = $LoginAdminID;
    }

    $filter = [];

    if($tutorFilter) {
        $filter['user_id'] = $tutorFilter;
    }

    if($statusFilter) {
        if($statusFilter == 'LIVE') {
            $filter['status'] = ['$in' => ['LIVE', 'STARTED']];
        } elseif($statusFilter == 'SCHEDULED') {
            $filter['status'] = 'SCHEDULED';
        } elseif($statusFilter == 'ENDED') {
            $filter['status'] = 'ENDED';
        }
    }

    if($sw) {
        if($col == "title") {
            $filter['title'] = ['$regex' => $sw, '$options' => 'i'];
        } elseif($col == "inviteCode") {
            $filter['inviteCode'] = ['$regex' => $sw, '$options' => 'i'];
        }
    }

    $tutorList = [];
    if($LoginAdminDept == "A") {
        $tutorPipeline = [
            ['$match' => ['user_id' => ['$exists' => true, '$ne' => '']]],
            ['$group' => [
                '_id' => '$user_id',
                'count' => ['$sum' => 1],
                'displayName' => ['$first' => '$displayName']
            ]],
            ['$sort' => ['count' => -1]],
            ['$limit' => 20]
        ];
        $tutorResult = mongoAggregate('meetings', $tutorPipeline);
        if($tutorResult['success']) {
            foreach($tutorResult['data'] as $t) {
                if(isset($t->_id) && $t->_id) {
                    $tutorList[] = [
                        'id' => $t->_id,
                        'name' => ($t->displayName ?? $t->_id) . ' (' . ($t->count ?? 0) . '개)',
                        'count' => $t->count ?? 0
                    ];
                }
            }
        }
    }

    $mongoResult = mongoFind('meetings', $filter, ['sort' => ['createdAt' => -1], 'limit' => 100]);
    $stats = getMeetingStats();

    $hostIds = [];
    if($mongoResult['success']) {
        foreach($mongoResult['data'] as $m) {
            $hostId = $m->currentHostId ?? $m->hostId ?? null;
            if($hostId) {
                $hostIds[mongoIdToString($hostId)] = $hostId;
            }
        }
    }

    $hostNames = [];
    if(count($hostIds) > 0) {
        $hostFilter = ['_id' => ['$in' => array_values($hostIds)]];
        $hostsResult = mongoFind('members', $hostFilter, ['limit' => 100]);
        if($hostsResult['success']) {
            foreach($hostsResult['data'] as $host) {
                $hostId = mongoIdToString($host->_id);
                $hostNames[$hostId] = $host->displayName ?? $host->name ?? $host->email ?? ('Host-' . substr($hostId, -6));
            }
        }
    }

    $meetings_display = array();
    if($mongoResult['success']) {
        foreach($mongoResult['data'] as $m) {
            $hostId = mongoIdToString($m->currentHostId ?? $m->hostId ?? '');
            $hostName = $hostNames[$hostId] ?? ('Host-' . substr($hostId, -6));

            $meetings_display[] = array(
                'id' => mongoIdToString($m->_id),
                'status' => $m->status ?? 'UNKNOWN',
                'title' => $m->title ?? '-',
                'inviteCode' => $m->inviteCode ?? '-',
                'host' => $hostName,
                'hostId' => $hostId,
                'participants' => $m->participantCount ?? 0,
                'scheduled' => mongoDateToString($m->createdAt ?? null, 'Y-m-d H:i'),
                'started' => mongoDateToString($m->actualStartAt ?? null, 'Y-m-d H:i'),
                'duration' => $m->durationMin ?? 0,
                'courseCode' => $m->courseCode ?? '-',
                'locked' => $m->isLocked ?? false,
                'private' => $m->isPrivate ?? false
            );
        }
    }

    $total = count($meetings_display);
    include_once("./include/include_page.php");
    $PAGE_CLASS = new Page($pg, $total, $page_size, $block_size);
    $PAGE_UNCOUNT = $PAGE_CLASS->page_uncount;
?>
<style>
.contentBody h2 {
    background: linear-gradient(135deg, #4A6CF7 0%, #8C5AEF 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 8px;
}
.modern-stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin: 30px 0;
}
.stat-card {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(100, 116, 139, 0.12);
    border: 1px solid rgba(148, 163, 184, 0.1);
    transition: all 0.3s ease;
}
.stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 8px 30px rgba(74, 108, 247, 0.2);
}
.stat-label {
    font-size: 14px;
    color: #64748b;
    font-weight: 600;
    margin-bottom: 8px;
}
.stat-value {
    font-size: 36px;
    font-weight: 800;
    background: linear-gradient(135deg, #4A6CF7 0%, #8C5AEF 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
}
.stat-card.live .stat-value { background: linear-gradient(135deg, #10b981 0%, #34d399 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.stat-card.scheduled .stat-value { background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.stat-card.ended .stat-value { background: linear-gradient(135deg, #64748b 0%, #94a3b8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
.modern-search-panel {
    background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
    border-radius: 16px;
    padding: 24px;
    box-shadow: 0 4px 20px rgba(100, 116, 139, 0.12);
    margin-bottom: 24px;
}
.modern-action-btns {
    display: flex;
    gap: 12px;
    margin: 24px 0;
}
.modern-btn {
    padding: 14px 28px;
    border-radius: 12px;
    border: none;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 16px rgba(0,0,0,0.1);
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 10px;
}
.modern-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 24px rgba(0,0,0,0.15);
}
.modern-btn-primary {
    background: linear-gradient(135deg, #4A6CF7 0%, #8C5AEF 100%);
    color: white;
}
.modern-btn-success {
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    color: white;
}
.meeting-table-wrapper {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 24px rgba(100, 116, 139, 0.12);
}
.meeting-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
}
.meeting-table thead tr {
    background: linear-gradient(135deg, #4A6CF7 0%, #8C5AEF 100%);
    color: white;
}
.meeting-table thead th {
    padding: 18px 12px;
    font-weight: 700;
    font-size: 13px;
    text-align: center;
}
.meeting-table tbody tr {
    border-bottom: 1px solid #f1f5f9;
    transition: all 0.3s ease;
    cursor: pointer;
}
.meeting-table tbody tr:hover {
    background: linear-gradient(135deg, #f0f4ff 0%, #f5f3ff 100%);
    transform: scale(1.002);
    box-shadow: 0 2px 12px rgba(74, 108, 247, 0.1);
}
.meeting-table tbody td {
    padding: 16px 12px;
    font-size: 13px;
    color: #334155;
}
.status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 11px;
    display: inline-block;
}
.status-live {
    background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
    color: white;
}
.status-scheduled {
    background: linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%);
    color: white;
}
.status-ended {
    background: linear-gradient(135deg, #94a3b8 0%, #cbd5e1 100%);
    color: white;
}
.meeting-title {
    font-weight: 600;
    color: #1e293b;
}
.invite-code {
    font-family: 'Courier New', monospace;
    background: #f1f5f9;
    padding: 4px 8px;
    border-radius: 6px;
    font-weight: 600;
    color: #475569;
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
@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<div class="contentBody">
<h2><?=$MenuName?> 관리 <span style="font-size:14px; color:#64748b; font-weight:400;">실시간 화상 강의 모니터링</span></h2>

<div class="view-toggle-container">
    <button type="button" id="viewMeetings" class="view-toggle-btn active" onclick="switchView('meetings')">
        <i class="fas fa-video"></i> 강의 목록
    </button>
    <button type="button" id="viewMembers" class="view-toggle-btn" onclick="switchView('members')">
        <i class="fas fa-users"></i> 접속 회원
    </button>
</div>

<div class="conZone">
<div id="meetingsView">
<div class="modern-stats-grid">
    <div class="stat-card total">
        <div class="stat-label">📊 전체 강의실</div>
        <div class="stat-value"><?=$stats['total']?></div>
    </div>
    <div class="stat-card live">
        <div class="stat-label">🔴 진행중</div>
        <div class="stat-value"><?=$stats['live']?></div>
    </div>
    <div class="stat-card scheduled">
        <div class="stat-label">📅 예정</div>
        <div class="stat-value"><?=$stats['scheduled']?></div>
    </div>
    <div class="stat-card ended">
        <div class="stat-label">✅ 종료</div>
        <div class="stat-value"><?=$stats['ended']?></div>
    </div>
</div>

<div class="modern-search-panel">
    <form name="search" method="GET" action="course.php">
        <input type="hidden" name="ctype" value="R">
        <div style="margin-bottom: 20px;">
            <label style="font-weight: 600; color: #475569; margin-bottom: 10px; display: block;">📌 상태 필터</label>
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                <button type="submit" name="status" value="" style="padding: 10px 20px; border-radius: 20px; border: 2px solid #e2e8f0; background: <?=!$statusFilter ? 'linear-gradient(135deg, #4A6CF7 0%, #8C5AEF 100%)' : 'white'?>; color: <?=!$statusFilter ? 'white' : '#64748b'?>; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                    <span>전체 (<?=$stats['total']?>)</span>
                </button>
                <button type="submit" name="status" value="LIVE" style="padding: 10px 20px; border-radius: 20px; border: 2px solid #e2e8f0; background: <?=$statusFilter=='LIVE' ? 'linear-gradient(135deg, #10b981 0%, #34d399 100%)' : 'white'?>; color: <?=$statusFilter=='LIVE' ? 'white' : '#64748b'?>; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                    <span>🔴 진행중 (<?=$stats['live']?>)</span>
                </button>
                <button type="submit" name="status" value="SCHEDULED" style="padding: 10px 20px; border-radius: 20px; border: 2px solid #e2e8f0; background: <?=$statusFilter=='SCHEDULED' ? 'linear-gradient(135deg, #f59e0b 0%, #fbbf24 100%)' : 'white'?>; color: <?=$statusFilter=='SCHEDULED' ? 'white' : '#64748b'?>; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                    <span>📅 예정 (<?=$stats['scheduled']?>)</span>
                </button>
                <button type="submit" name="status" value="ENDED" style="padding: 10px 20px; border-radius: 20px; border: 2px solid #e2e8f0; background: <?=$statusFilter=='ENDED' ? 'linear-gradient(135deg, #64748b 0%, #94a3b8 100%)' : 'white'?>; color: <?=$statusFilter=='ENDED' ? 'white' : '#64748b'?>; font-weight: 600; cursor: pointer; transition: all 0.3s;">
                    <span>✅ 종료 (<?=$stats['ended']?>)</span>
                </button>
            </div>
        </div>

        <?if($LoginAdminDept == "A" && count($tutorList) > 0) {?>
        <div style="margin-bottom: 20px;">
            <label style="font-weight: 600; color: #475569; margin-bottom: 10px; display: block;">👨‍🏫 강사 필터</label>
            <select name="tutor" onchange="this.form.submit()" style="width: 100%; padding: 10px 16px; border-radius: 8px; border: 1px solid #e2e8f0; font-weight: 500;">
                <option value="">전체 강사</option>
                <?foreach($tutorList as $t) {?>
                <option value="<?=$t['id']?>" <?=$tutorFilter==$t['id']?'selected':''?>><?=$t['name']?> (<?=$t['count']?>개 강의)</option>
                <?}?>
            </select>
        </div>
        <?}?>

        <div>
            <label style="font-weight: 600; color: #475569; margin-bottom: 10px; display: block;">🔍 검색</label>
            <div style="display: flex; gap: 12px; align-items: center;">
                <select name="col" style="padding: 10px 16px; border-radius: 8px; border: 1px solid #e2e8f0;">
                    <option value="title" <?=$col=='title'?'selected':''?>>강의실명</option>
                    <option value="inviteCode" <?=$col=='inviteCode'?'selected':''?>>초대 코드</option>
                </select>
                <input name="sw" type="text" value="<?=$sw?>" placeholder="검색어를 입력하세요" style="flex: 1; padding: 10px 16px; border-radius: 8px; border: 1px solid #e2e8f0;" />
                <button type="submit" style="padding: 10px 24px; background: linear-gradient(135deg, #4A6CF7 0%, #8C5AEF 100%); color: white; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-search"></i> <span>검색</span>
                </button>
                <?if($sw || $statusFilter || $tutorFilter) {?>
                <button type="button" onclick="location.href='course.php?ctype=R'" style="padding: 10px 20px; background: #f1f5f9; color: #64748b; border: none; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    <i class="fas fa-redo"></i> <span>초기화</span>
                </button>
                <?}?>
            </div>
        </div>
    </form>
</div>

<div class="modern-action-btns">
    <button type="button" class="modern-btn modern-btn-primary" onclick="window.open('https://live.hrdeedu.co.kr/instructor','_blank');">
        <i class="fas fa-video"></i> <span>실시간 강의 생성</span>
    </button>
    <button type="button" class="modern-btn modern-btn-success" onclick="window.open('https://live.hrdeedu.co.kr/instructor','_blank');">
        <i class="far fa-calendar-plus"></i> <span>예정 강의 등록</span>
    </button>
    <button type="button" class="modern-btn" onclick="exportMeetingsExcel();" style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); color: white;">
        <i class="fas fa-file-excel"></i> <span>Excel 내보내기</span>
    </button>
</div>

<div class="meeting-table-wrapper">
<table class="meeting-table">
<thead>
<tr>
<th>번호</th><th>상태</th><th>강의실명</th><th>초대코드</th><th>강사</th>
<th>생성시간</th><th>시작시간</th><th>진행시간</th><th>과정코드</th>
</tr>
</thead>
<tbody>
<?
if(count($meetings_display) > 0) {
    foreach($meetings_display as $m) {
        $statusClass = 'status-ended';
        $statusText = '종료';
        if($m['status'] == 'LIVE' || $m['status'] == 'STARTED') {
            $statusClass = 'status-live';
            $statusText = '진행중';
        } elseif($m['status'] == 'SCHEDULED') {
            $statusClass = 'status-scheduled';
            $statusText = '예정';
        }
        $durationText = ($m['duration'] >= 60) ? floor($m['duration']/60).'시간 '.($m['duration']%60).'분' : $m['duration'].'분';
?>
<tr onclick="location.href='course_read.php?idx=<?=$m['id']?>&ctype=R';">
<td style="text-align:center; font-weight:600;"><?=$PAGE_UNCOUNT--?></td>
<td style="text-align:center;"><span class="status-badge <?=$statusClass?>"><?=$statusText?></span></td>
<td class="tl" style="padding-left:16px;">
    <div class="meeting-title"><?=$m['title']?></div>
    <?if($m['private']) {?><div style="margin-top:4px;"><span style="background:#fee2e2; color:#dc2626; padding:2px 8px; border-radius:4px; font-size:11px; font-weight:600;">🔒 비공개</span></div><?}?>
</td>
<td style="text-align:center;"><span class="invite-code"><?=$m['inviteCode']?></span></td>
<td style="text-align:center; color:#64748b; font-weight:600;"><?=$m['host']?></td>
<td style="text-align:center; font-size:12px; color:#64748b;"><?=$m['scheduled']?></td>
<td style="text-align:center; font-size:12px; color:#64748b;"><?=$m['started']?></td>
<td style="text-align:center; font-weight:600; color:#4A6CF7;"><?=$durationText?></td>
<td style="text-align:center;"><span style="font-family: 'Courier New', monospace; background: #e0f2fe; color: #0369a1; padding: 4px 10px; border-radius: 6px; font-weight: 600; font-size: 11px;"><?=$m['courseCode']?></span></td>
</tr>
<? 
    }
} else {
?>
<tr>
    <td colspan="9" height="80" style="text-align:center; color:#64748b;">
        <div style="padding:20px;">
            <div style="font-size:48px; opacity:0.3;">📭</div>
            <div style="font-size:16px; font-weight:600; margin-top:8px;">등록된 강의실이 없습니다</div>
        </div>
    </td>
</tr>
<?
}
?>
</tbody>
</table>
</div>

<div style="margin-top:24px; text-align:center;">
<?=$PAGE_CLASS->blockList()?>
</div>

</div>

<div id="membersView" style="display:none;">
</div>

</div>
</div>

<script>
function switchView(viewType) {
    $(".view-toggle-btn").removeClass("active");
    if(viewType == 'meetings') {
        $("#viewMeetings").addClass("active");
        $("#meetingsView").show();
        $("#membersView").hide();
    } else {
        $("#viewMembers").addClass("active");
        $("#meetingsView").hide();
        $("#membersView").show();
        loadMembers();
    }
}
function loadMembers() {
    if($("#membersView").data('loaded')) {
        return;
    }
    $("#membersView").html('<div style="text-align:center; padding:80px 20px;"><div class="spinner" style="width:60px; height:60px; border:4px solid #e2e8f0; border-top:4px solid #4A6CF7; border-radius:50%; animation:spin 1s linear infinite; margin:0 auto;"></div><div style="margin-top:20px; color:#64748b; font-weight:600;">회원 목록을 불러오는 중...</div></div>');
    $.get('./course_members_ajax.php?ctype=R', function(data) {
        $("#membersView").html(data);
        $("#membersView").data('loaded', true);
    }).fail(function() {
        $("#membersView").html('<div style="text-align:center; padding:80px 20px; color:#dc2626; font-weight:600;">⚠️ 회원 목록을 불러오는데 실패했습니다.</div>');
    });
}
function exportMeetingsExcel() {
    var status = '<?=$statusFilter?>';
    var col = '<?=$col?>';
    var sw = '<?=$sw?>';
    var tutor = '<?=$tutorFilter?>';
    var url = 'meeting_excel_export.php?ctype=R';
    if(status) url += '&status=' + status;
    if(col) url += '&col=' + col;
    if(sw) url += '&sw=' + encodeURIComponent(sw);
    if(tutor) url += '&tutor=' + tutor;
    window.open(url, '_blank');
}
</script>
<? include "./include/include_bottom.php"; ?>
<?
exit;
}

##-- 검색 조건
$where = array();

if($sw){
	if($col=="") {
		$where[] = "";
	}else{
	    if($col=="LectureCode") $where[] = "a.LectureCode='$sw'";  else  $where[] = "a.$col LIKE '%$sw%'";
	}
}
$where[] = "a.Del='N'";
$where[] = "a.ctype='$ctype'";
$where[] = "a.PackageYN='N'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

##-- 정렬조건
if($orderby=="") $str_orderby = "ORDER BY a.RegDate DESC, a.idx DESC";  else  $str_orderby = "ORDER BY $orderby";

$JoinQuery = " Course AS a
        	LEFT OUTER JOIN CourseCategory AS b ON a.Category1=b.idx
        	LEFT OUTER JOIN CourseCategory AS c ON a.Category2=c.idx ";

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM $JoinQuery $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];
mysqli_free_result($Result);

##-- 페이지 클래스 생성
include_once("./include/include_page.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소
?>
	<div class="contentBody">
    	<h2><?=$MenuName?> 컨텐츠 관리</h2>
		<div class="conZone">
        	<form name="search" method="POST">
        		<input type="hidden" name="ctype" id="ctype" value="<?=$ctype?>">
                <div class="searchPan">
    				<select name="col">
    					<option value="ContentsName" <?if($col=="ContentsName") { echo "selected";}?>>과정명</option>
    					<option value="LectureCode" <?if($col=="LectureCode") { echo "selected";}?>>강의 코드</option>
    				</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
				</div>
			</form>
        	<div class="btnAreaTr02">
        		<button type="button" name="ExcelBtn" id="ExcelBtn" class="btn btn_Green line" style="width:200px;" onclick="CourseExcel();"><i class="fas fa-file-excel"></i> 검색 항목 엑셀 출력</button>
				<?if($AdminWrite=="Y") {?>
					<input type="button" name="Btn" id="Btn" value="신규 등록" class="btn_inputBlue01" onclick="location.href='<?=$PageName?>_write.php?mode=new'">
					<button type="button" name="ExcelBtn" id="ExcelBtn" class="btn btn_Green" onClick="location.href='<?=$PageName?>_write_excel.php'"><i class="fas fa-file-excel"></i> 엑셀로 등록</button>
				<?}?>
          	</div>
            <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
            	<colgroup>
                    <col width="40px" />
                    <col width="70px" />
                    <col width="" />
                    <col width="120px" />
                    <col width="120px" />
					<col width="150px" />
					<col width="130px" />
					<col width="100px" />
					<col width="80px" />
					<col width="80px" />
              	</colgroup>
              	<tr>
                    <th>번호</th>
					<th>등&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;급<br>과정 코드</th>
					<th>과정분류<br>과&nbsp;&nbsp;정&nbsp;&nbsp;명</th>
					<th>차시</th>
					<th>교육시간</th>
					<th>패키지콘텐츠 과정코드</th>
					<th>원격훈련 일련번호</th>
					<th>제작연도<br>&nbsp;업로드</th>
					<th>모바일</th>
					<th>사이트<br>노출</th>
              	</tr>
				<?
				$SQL = "SELECT a.*, b.CategoryName AS CategoryName1, c.CategoryName AS CategoryName2
                        FROM $JoinQuery $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
				$QUERY = mysqli_query($connect, $SQL);
				if($QUERY && mysqli_num_rows($QUERY)){
					while($ROW = mysqli_fetch_array($QUERY)){
						extract($ROW);
				?>
              	<tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td><A HREF="Javascript:readRun('<?=$idx?>');"><?=$ClassGrade_array[$ClassGrade]?><br><strong><?=$LectureCode?></strong></A></td>
					<td class="tl"><A HREF="Javascript:readRun('<?=$idx?>');"><?=$CategoryName1?>><?=$CategoryName2?><br><strong><?=$ContentsName?></strong></A></td>
					<td><?if($Chapter != "0") echo $Chapter."차시"; else  echo "없음";?></td>
					<td><?=$ContentsTime?> 분</td>
					<td><?=$PackageLectureCode?></td>
					<td><?=$HrdSeq?></td>
					<td><?=substr($ContentsStart,0,10)?><br><?=substr($UploadDate,0,10)?></td>
					<td><?=$UseYN_array[$Mobile]?></td>
					<td><?=$UseYN_array[$UseYN]?></td>
              	</tr>
              	<?
					}
				   mysqli_free_result($QUERY);
				}else{
				?>
				<tr>
					<td height="50" class="tc" colspan="20">등록된 컨텐츠가 없습니다.</td>
				</tr>
				<? 
				}
				?>
            </table>
            
		  	<?=$BLOCK_LIST?>
		</div>
	</div>
</div>
<script>
function CourseExcel() {
	Yes = confirm('현재 검색조건으로 검색된 결과를 엑셀로 출력하시겠습니까?');
	if (Yes == true) {
		document.search.action = 'course_search_excel.php';
		document.search.target = 'ScriptFrame';
		document.search.submit();
	}
}
</script>
<? include "./include/include_bottom.php"; ?>