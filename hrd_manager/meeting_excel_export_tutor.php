<?
include "../include/include_function.php";
include "./include/include_admin_check.php";
include "../include/include_mongodb.php";

$statusFilter = Replace_Check($_GET['status'] ?? '');
$search = Replace_Check($_GET['search'] ?? '');

$filter = [];

if($LoginAdminDept == "C") {
	$memberResult = mongoFind('members', ['user_id' => $LoginAdminID], ['limit' => 1]);
	if($memberResult['success'] && count($memberResult['data']) > 0) {
		$tutorMongoId = $memberResult['data'][0]->_id;
		$filter['$or'] = [
			['currentHostId' => $tutorMongoId],
			['hostId' => $tutorMongoId]
		];
	} else {
		$filter['_id'] = new MongoDB\BSON\ObjectId('000000000000000000000000');
	}
}

if($statusFilter) {
	$statusMap = [
		'LIVE' => ['$in' => ['LIVE', 'STARTED']],
		'SCHEDULED' => 'SCHEDULED',
		'ENDED' => 'ENDED',
		'진행중' => ['$in' => ['LIVE', 'STARTED']],
		'예정' => 'SCHEDULED',
		'종료' => 'ENDED'
	];
	if(isset($statusMap[$statusFilter])) {
		if(isset($filter['$or'])) {
			$filter = ['$and' => [$filter, ['status' => $statusMap[$statusFilter]]]];
		} else {
			$filter['status'] = $statusMap[$statusFilter];
		}
	}
}

if($search) {
	$searchFilter = [
		'$or' => [
			['title' => ['$regex' => $search, '$options' => 'i']],
			['inviteCode' => ['$regex' => $search, '$options' => 'i']]
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

$result = mongoFind('meetings', $filter, ['sort' => ['createdAt' => -1], 'limit' => 1000]);

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

$filename = "실시간강의_튜터_" . date('Y-m-d_His') . ".xls";
header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=$filename");
header("Pragma: no-cache");
header("Expires: 0");
echo "\xEF\xBB\xBF";
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>실시간 강의 목록 (튜터)</title>
</head>
<body>
<table border="1">
    <thead>
        <tr style="background-color: #4A6CF7; color: white; font-weight: bold;">
            <th>번호</th>
            <th>상태</th>
            <th>강의실명</th>
            <th>초대코드</th>
            <th>강사</th>
            <th>참여자수</th>
            <th>예정시간</th>
            <th>시작시간</th>
            <th>종료시간</th>
            <th>진행시간(분)</th>
            <th>과정코드</th>
        </tr>
    </thead>
    <tbody>
<?
if($result['success'] && count($result['data']) > 0) {
    $num = count($result['data']);
    foreach($result['data'] as $meeting) {
        $status = $meeting->status ?? 'UNKNOWN';
        if($status == 'LIVE' || $status == 'STARTED') {
            $statusKorean = '진행중';
        } elseif($status == 'SCHEDULED') {
            $statusKorean = '예정';
        } elseif($status == 'ENDED') {
            $statusKorean = '종료';
        } else {
            $statusKorean = $status;
        }
        $hostId = mongoIdToString($meeting->currentHostId ?? $meeting->hostId ?? '');
        $hostName = $hostNames[$hostId] ?? ('Host-' . substr($hostId, -6));
        $participants = $meeting->participantCount ?? 0;
        $scheduledAt = '-';
        if(isset($meeting->scheduledFor)) {
            $scheduledAt = mongoDateToString($meeting->scheduledFor, 'Y-m-d H:i:s');
        } elseif(isset($meeting->createdAt)) {
            $scheduledAt = mongoDateToString($meeting->createdAt, 'Y-m-d H:i:s');
        }
        $startedAt = mongoDateToString($meeting->actualStartAt ?? null, 'Y-m-d H:i:s');
        $endedAt = mongoDateToString($meeting->endedAt ?? null, 'Y-m-d H:i:s');
        $duration = $meeting->durationMin ?? 0;
        $courseCode = $meeting->courseCode ?? '-';
?>
        <tr>
            <td><?=$num--?></td>
            <td><?=$statusKorean?></td>
            <td><?=isset($meeting->title) ? $meeting->title : '-'?></td>
            <td><?=isset($meeting->inviteCode) ? $meeting->inviteCode : '-'?></td>
            <td><?=$hostName?></td>
            <td><?=$participants?></td>
            <td><?=$scheduledAt?></td>
            <td><?=$startedAt?></td>
            <td><?=$endedAt?></td>
            <td><?=$duration?></td>
            <td><?=$courseCode?></td>
        </tr>
<?
    }
} else {
?>
        <tr>
            <td colspan="11" style="text-align:center;">데이터가 없습니다.</td>
        </tr>
<?
}
?>
    </tbody>
</table>
<div style="margin-top: 20px; padding: 10px; background-color: #f0f0f0;">
    <strong>내보내기 정보:</strong><br>
    생성일시: <?=date('Y-m-d H:i:s')?><br>
    총 건수: <?=count($result['data'] ?? [])?><br>
    <?if($statusFilter) {?>상태 필터: <?=$statusFilter?><br><?}?>
    <?if($search) {?>검색어: <?=$search?><br><?}?>
    <?if($LoginAdminDept == "C") {?>강사: <?=$LoginAdminID?> (<?=$LoginAdminName?>)<br><?}?>
</div>
</body>
</html>

