<?
include "../include/include_function.php";
include "./include/include_admin_check.php";
include "../include/include_mongodb.php";

$Status = Replace_Check($Status);
$SearchKeyword = Replace_Check($SearchKeyword);

$data_array = array();
$debugInfo = '';
$filter = [];

if($LoginAdminDept == "C") {
	$debugInfo .= "<!-- DEBUG: Tutor login (Dept=C), ID=$LoginAdminID, Name=$LoginAdminName -->\n";
	$memberFilter = ['user_id' => $LoginAdminID];
	$memberResult = mongoFind('members', $memberFilter, ['limit' => 1]);
	if($memberResult['success'] && count($memberResult['data']) > 0) {
		$tutorMember = $memberResult['data'][0];
		$tutorMongoId = $tutorMember->_id;
		$debugInfo .= "<!-- Found tutor member in MongoDB: _id=" . mongoIdToString($tutorMongoId) . " -->\n";
		$filter['$or'] = [
			['currentHostId' => $tutorMongoId],
			['hostId' => $tutorMongoId]
		];
	} else {
		$debugInfo .= "<!-- WARNING: Tutor member not found in MongoDB for user_id=$LoginAdminID -->\n";
		$filter['_id'] = new MongoDB\BSON\ObjectId('000000000000000000000000');
	}
} else {
	$debugInfo .= "<!-- DEBUG: Manager login (Dept=$LoginAdminDept), showing all meetings -->\n";
}

echo $debugInfo;

if($Status) {
	$statusMap = [
		'진행중' => ['$in' => ['LIVE', 'STARTED']],
		'예정' => 'SCHEDULED',
		'종료' => 'ENDED'
	];
	if(isset($statusMap[$Status])) {
		if(isset($filter['$or'])) {
			$tutorFilter = $filter;
			$filter = [
				'$and' => [
					$tutorFilter,
					['status' => $statusMap[$Status]]
				]
			];
		} else {
			$filter['status'] = $statusMap[$Status];
		}
	}
}

if($SearchKeyword) {
	$searchFilter = [
		'$or' => [
			['title' => ['$regex' => $SearchKeyword, '$options' => 'i']],
			['inviteCode' => ['$regex' => $SearchKeyword, '$options' => 'i']]
		]
	];
	if(!empty($filter)) {
		if(isset($filter['$and'])) {
			$filter['$and'][] = $searchFilter;
		} else {
			$filter = ['$and' => [$filter, $searchFilter]];
		}
	} else {
		$filter = $searchFilter;
	}
}

$options = [
	'sort' => ['createdAt' => -1],
	'limit' => 100
];

$result = mongoFind('meetings', $filter, $options);

$hostIds = [];
if($result['success']) {
	foreach($result['data'] as $m) {
		$hostId = $m->currentHostId ?? $m->hostId ?? null;
		if($hostId) {
			$hostIds[mongoIdToString($hostId)] = $hostId;
		}
	}
}

$hostNames = [];
if(count($hostIds) > 0) {
	$hostsResult = mongoFind('members', ['_id' => ['$in' => array_values($hostIds)]], ['limit' => 100]);
	if($hostsResult['success']) {
		foreach($hostsResult['data'] as $host) {
			$hostId = mongoIdToString($host->_id);
			$hostNames[$hostId] = $host->displayName ?? $host->name ?? $host->email ?? ('Host-' . substr($hostId, -6));
		}
	}
}

if($result['success'] && count($result['data']) > 0) {
	$idx_counter = count($result['data']);
	foreach($result['data'] as $meeting) {
		$mongoStatus = isset($meeting->status) ? $meeting->status : 'UNKNOWN';
		$statusKorean = '';
		if($mongoStatus == 'LIVE' || $mongoStatus == 'STARTED') {
			$statusKorean = '진행중';
		} else if($mongoStatus == 'SCHEDULED') {
			$statusKorean = '예정';
		} else if($mongoStatus == 'ENDED') {
			$statusKorean = '종료';
		} else {
			$statusKorean = '알 수 없음';
		}
		$hostId = mongoIdToString($meeting->currentHostId ?? $meeting->hostId ?? '');
		$instructor = $hostNames[$hostId] ?? ('Host-' . substr($hostId, -6));
		$durationMin = isset($meeting->durationMin) ? $meeting->durationMin : 0;
		$duration_str = formatDuration($durationMin);
		$scheduledTime = '-';
		if(isset($meeting->scheduledFor)) {
			$scheduledTime = mongoDateToString($meeting->scheduledFor, 'Y-m-d H:i');
		} elseif(isset($meeting->createdAt)) {
			$scheduledTime = mongoDateToString($meeting->createdAt, 'Y-m-d H:i');
		}
		$actualStartTime = isset($meeting->actualStartAt) ? mongoDateToString($meeting->actualStartAt, 'Y-m-d H:i') : '';
		$data_array[] = array(
			'idx' => $idx_counter--,
			'Status' => $statusKorean,
			'ClassName' => isset($meeting->title) ? $meeting->title : '-',
			'InviteCode' => isset($meeting->inviteCode) ? $meeting->inviteCode : '-',
			'Instructor' => $instructor,
			'Participants' => isset($meeting->participantCount) ? $meeting->participantCount : 0,
			'ScheduledTime' => $scheduledTime,
			'ActualStartTime' => $actualStartTime,
			'Duration' => $duration_str,
			'CourseCode' => isset($meeting->courseCode) && $meeting->courseCode ? $meeting->courseCode : '-',
			'IsLocked' => (isset($meeting->isLocked) && $meeting->isLocked) ? '잠김' : '',
			'MeetingId' => mongoIdToString($meeting->_id)
		);
	}
}

$total_count = count($data_array);
?>
<style>
.list_area {
	background: white;
	border-radius: 20px;
	overflow: hidden;
	box-shadow: 0 4px 28px rgba(100, 116, 139, 0.15);
	border: 1px solid rgba(148, 163, 184, 0.1);
	margin-top: 20px;
}
.list_table {
	width: 100%;
	border-collapse: separate;
	border-spacing: 0;
}
.list_table thead tr {
	background: linear-gradient(135deg, #4A6CF7 0%, #8C5AEF 100%);
	color: white;
}
.list_table thead th {
	padding: 20px 14px;
	font-weight: 700;
	font-size: 14px;
	text-align: center;
	letter-spacing: 0.5px;
	text-transform: uppercase;
	border: none;
}
.list_table tbody tr {
	border-bottom: 1px solid #f1f5f9;
	transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
	background: white;
}
.list_table tbody tr:nth-child(even) { background: #fafbfc; }
.list_table tbody tr:hover {
	background: linear-gradient(135deg, #f0f4ff 0%, #f5f3ff 100%);
	transform: scale(1.005);
	box-shadow: 0 4px 20px rgba(74, 108, 247, 0.15);
	position: relative;
	z-index: 1;
}
.list_table tbody td {
	padding: 18px 14px;
	text-align: center;
	font-size: 14px;
	color: #334155;
	font-weight: 500;
	border: none;
}
.live_status_badge {
	padding: 8px 18px;
	border-radius: 24px;
	font-weight: 700;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	min-width: 80px;
	text-align: center;
	font-size: 12px;
	text-transform: uppercase;
	letter-spacing: 0.5px;
	box-shadow: 0 3px 12px rgba(0,0,0,0.15);
	position: relative;
	overflow: hidden;
}
.live_status_badge::before {
	content: '';
	position: absolute;
	top: 0;
	left: -100%;
	width: 100%;
	height: 100%;
	background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
	transition: left 0.5s ease;
}
.live_status_badge:hover::before { left: 100%; }
.status_live {
	background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
	color: white;
	animation: pulse-green 2s infinite;
}
@keyframes pulse-green {
	0%, 100% { box-shadow: 0 3px 12px rgba(16, 185, 129, 0.3); }
	50% { box-shadow: 0 3px 20px rgba(16, 185, 129, 0.5); }
}
.status_scheduled {
	background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%);
	color: white;
}
.status_ended {
	background: linear-gradient(135deg, #94a3b8 0%, #cbd5e1 100%);
	color: white;
}
.join_btn {
	padding: 12px 28px;
	border-radius: 28px;
	border: none;
	cursor: pointer;
	font-weight: 700;
	font-size: 14px;
	transition: all 0.35s cubic-bezier(0.4, 0, 0.2, 1);
	box-shadow: 0 3px 12px rgba(0,0,0,0.18);
	position: relative;
	overflow: hidden;
	white-space: nowrap;
	min-width: 140px;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	gap: 6px;
}
.join_btn::before {
	content: '';
	position: absolute;
	top: 50%;
	left: 50%;
	width: 0;
	height: 0;
	border-radius: 50%;
	background: rgba(255,255,255,0.3);
	transform: translate(-50%, -50%);
	transition: width 0.5s, height 0.5s;
}
.join_btn:hover::before { width: 300px; height: 300px; }
.join_btn:hover {
	transform: translateY(-3px);
	box-shadow: 0 6px 20px rgba(0,0,0,0.25);
}
.join_btn:active { transform: translateY(-1px); }
.join_btn_live {
	background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
	color: white;
	animation: glow-green 2s infinite;
}
@keyframes glow-green {
	0%, 100% { box-shadow: 0 3px 12px rgba(16, 185, 129, 0.3); }
	50% { box-shadow: 0 3px 20px rgba(16, 185, 129, 0.6); }
}
.join_btn_scheduled {
	background: linear-gradient(135deg, #ec4899 0%, #f472b6 100%);
	color: white;
}
.join_btn_disabled {
	background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
	color: #94a3b8;
	cursor: not-allowed;
	box-shadow: none;
}
.join_btn_disabled:hover {
	transform: none;
	box-shadow: none;
}
.empty-state {
	padding: 100px 40px !important;
	text-align: center !important;
	background: linear-gradient(135deg, #fafbfc 0%, #f8fafc 100%) !important;
}
.empty-state strong {
	color: #64748b;
	font-size: 18px;
	display: block;
	margin-top: 10px;
	font-weight: 700;
}
.modern-summary {
	margin-top: 24px;
	padding: 20px 28px;
	background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
	border-radius: 16px;
	box-shadow: 0 3px 16px rgba(100, 116, 139, 0.12);
	border: 1px solid rgba(148, 163, 184, 0.15);
	display: flex;
	align-items: center;
	gap: 20px;
}
.modern-summary strong {
	color: #1e293b;
	font-size: 16px;
	font-weight: 700;
}
</style>
<div class="list_area">
	<table cellpadding="0" cellspacing="0" class="list_table" style="width:100%">
		<colgroup>
			<col width="60px">
			<col width="100px">
			<col width="">
			<col width="120px">
			<col width="120px">
			<col width="140px">
			<col width="140px">
			<col width="120px">
		</colgroup>
		<thead>
			<tr>
				<th>번호</th>
				<th>상태</th>
				<th>강의실명</th>
				<th>초대코드</th>
				<th>강사</th>
				<th>예정 시간</th>
				<th>시작 시간</th>
				<th>참여/기간</th>
			</tr>
		</thead>
		<tbody>
<?
if($total_count > 0) {
	foreach($data_array as $row) {
		$statusClass = 'status_ended';
		if($row['Status'] == '진행중') {
			$statusClass = 'status_live';
		} else if($row['Status'] == '예정') {
			$statusClass = 'status_scheduled';
		}
		$joinClass = 'join_btn_disabled';
		if($row['Status'] == '진행중') {
			$joinClass = 'join_btn join_btn_live';
		} else if($row['Status'] == '예정') {
			$joinClass = 'join_btn join_btn_scheduled';
		} else {
			$joinClass = 'join_btn join_btn_disabled';
		}
?>
			<tr>
				<td><?=$row['idx']?></td>
				<td><span class="live_status_badge <?=$statusClass?>"><?=$row['Status']?></span></td>
				<td style="text-align:left; padding-left:16px;">
					<div style="font-weight:700; color:#1e293b;"><?=$row['ClassName']?></div>
					<div style="margin-top:6px; color:#64748b; font-size:12px;">
						<?if($row['IsLocked']) {?><span style="background:#fee2e2; color:#dc2626; padding:3px 8px; border-radius:6px; font-weight:600;">🔒 <?=$row['IsLocked']?></span><?}?>
					</div>
				</td>
				<td><span style="font-family:monospace; background:#f1f5f9; padding:6px 12px; border-radius:8px; font-weight:700;"><?=$row['InviteCode']?></span></td>
				<td><span style="color:#475569; font-weight:600;"><?=$row['Instructor']?></span></td>
				<td><div class="time-display"><?=$row['ScheduledTime']?></div></td>
				<td><div class="time-display"><?=$row['ActualStartTime']?></div></td>
				<td>
					<div class="participant-count">
						<i class="fas fa-user-friends"></i> <?=$row['Participants']?>명
					</div>
					<div style="margin-top:8px; color:#475569; font-weight:600;"><?=$row['Duration']?></div>
					<div style="margin-top:10px;">
						<button type="button" class="<?=$joinClass?>" onclick="JoinClass('<?=$row['MeetingId']?>','<?=$row['Status']?>','<?=htmlspecialchars($row['ClassName'])?>','<?=$row['InviteCode']?>')">
							<i class="fas fa-sign-in-alt"></i> 입장하기
						</button>
					</div>
				</td>
			</tr>
<?
	}
} else {
?>
			<tr>
				<td colspan="8" class="empty-state">
					<div style="font-size: 72px; margin-bottom: 20px; opacity: 0.2;">🎥</div>
					<strong>등록된 강의가 없습니다</strong>
					<p style="margin-top: 10px; color: #94a3b8; font-size: 14px;">검색 조건을 변경하거나 새로운 강의를 생성해보세요</p>
				</td>
			</tr>
<?
}
?>
		</tbody>
	</table>
</div>
<?if($total_count > 0) {?>
<div class="modern-summary">
	<strong>📊 총 <?=$total_count?>개의 강의</strong>
	<?
	$liveCount = 0;
	$scheduledCount = 0;
	foreach($data_array as $row) {
		if($row['Status'] == '진행중') $liveCount++;
		if($row['Status'] == '예정') $scheduledCount++;
	}
	?>
	<span style="margin-left:15px; color:#10b981; font-weight:700; background: #d1fae5; padding: 6px 14px; border-radius: 20px; font-size: 13px;">🟢 진행중: <?=$liveCount?>개</span>
	<span style="margin-left:10px; color:#ec4899; font-weight:700; background: #fce7f3; padding: 6px 14px; border-radius: 20px; font-size: 13px;">🔴 예정: <?=$scheduledCount?>개</span>
</div>
<?}?>

