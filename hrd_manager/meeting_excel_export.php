<?
include "../include/include_function.php";
include "./include/include_admin_check.php";
include "../include/include_mongodb.php";

$statusFilter = Replace_Check($_GET['status'] ?? '');
$col = Replace_Check($_GET['col'] ?? '');
$sw = Replace_Check($_GET['sw'] ?? '');
$tutorFilter = Replace_Check($_GET['tutor'] ?? '');

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

$filename = "실시간강의실_" . date('Y-m-d_His') . ".xls";
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
<title>실시간 강의실 목록</title>
</head>
<body>
<table border="1">
    <thead>
        <tr style="background-color: #4A6CF7; color: white; font-weight: bold;">
            <th>번호</th>
            <th>상태</th>
            <th>강의실명</th>
            <th>초대코드</th>
            <th>강사ID</th>
            <th>참여자수</th>
            <th>생성시간</th>
            <th>시작시간</th>
            <th>종료시간</th>
            <th>진행시간(분)</th>
            <th>비공개</th>
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
        
        $title = $meeting->title ?? '-';
        $inviteCode = $meeting->inviteCode ?? '-';
        $hostId = mongoIdToString($meeting->currentHostId ?? $meeting->hostId ?? '');
        $hostName = $hostNames[$hostId] ?? ('Host-' . substr($hostId, -6));
        $participants = $meeting->participantCount ?? 0;
        $createdAt = mongoDateToString($meeting->createdAt ?? null, 'Y-m-d H:i:s');
        $startedAt = mongoDateToString($meeting->actualStartAt ?? null, 'Y-m-d H:i:s');
        $endedAt = mongoDateToString($meeting->endedAt ?? null, 'Y-m-d H:i:s');
        $duration = $meeting->durationMin ?? 0;
        $isPrivate = ($meeting->isPrivate ?? false) ? '예' : '아니오';
        $courseCode = $meeting->courseCode ?? '-';
?>
        <tr>
            <td><?=$num--?></td>
            <td><?=$statusKorean?></td>
            <td><?=$title?></td>
            <td><?=$inviteCode?></td>
            <td><?=$hostName?></td>
            <td><?=$participants?></td>
            <td><?=$createdAt?></td>
            <td><?=$startedAt?></td>
            <td><?=$endedAt?></td>
            <td><?=$duration?></td>
            <td><?=$isPrivate?></td>
            <td><?=$courseCode?></td>
        </tr>
<?
    }
} else {
?>
        <tr>
            <td colspan="12" style="text-align:center;">데이터가 없습니다.</td>
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
    <?if($tutorFilter) {?>강사 필터: <?=$tutorFilter?><br><?}?>
    <?if($sw) {?>검색어: <?=$sw?><br><?}?>
</div>

</body>
</html>

