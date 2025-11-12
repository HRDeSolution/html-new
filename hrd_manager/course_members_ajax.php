<?
include "../include/include_function.php";
include "./include/include_admin_check.php";
include "../include/include_mongodb.php";

$filter = [];
$options = [
	'sort' => ['createdAt' => -1],
	'limit' => 100
];

$result = mongoFind('members', $filter, $options);

$data_array = [];
if($result['success'] && count($result['data']) > 0) {
	$idx_counter = count($result['data']);
	
	foreach($result['data'] as $member) {
		$userId = $member->user_id ?? '-';
		$name = $member->name ?? '-';
		$displayName = $member->displayName ?? $name;
		$email = $member->email ?? '-';
		$memberId = $member->_id;

		$meetingFilter = [
			'$or' => [
				['currentHostId' => $memberId],
				['hostId' => $memberId],
				['participants' => ['$elemMatch' => ['memberId' => $memberId]]]
			]
		];
		$meetingCount = mongoCount('meetings', $meetingFilter);
		
		$createdAt = isset($member->createdAt) ? mongoDateToString($member->createdAt, 'Y-m-d H:i') : '-';
		
		$data_array[] = array(
			'idx' => $idx_counter--,
			'UserId' => $userId,
			'Name' => $name,
			'DisplayName' => $displayName,
			'Email' => $email,
			'MeetingCount' => $meetingCount,
			'CreatedAt' => $createdAt
		);
	}
}

$total_count = count($data_array);
?>
<style>
.members-table {
	width: 100%;
	background: white;
	border-radius: 20px;
	overflow: hidden;
	box-shadow: 0 4px 28px rgba(100, 116, 139, 0.15);
	border: 1px solid rgba(148, 163, 184, 0.1);
	margin-top: 20px;
}
.members-table table {
	width: 100%;
	border-collapse: separate;
	border-spacing: 0;
}
.members-table thead tr {
	background: linear-gradient(135deg, #4A6CF7 0%, #8C5AEF 100%);
	color: white;
}
.members-table thead th {
	padding: 20px 14px;
	font-weight: 700;
	font-size: 14px;
	text-align: center;
	letter-spacing: 0.5px;
	border: none;
}
.members-table tbody tr {
	border-bottom: 1px solid #f1f5f9;
	transition: all 0.35s ease;
	background: white;
}
.members-table tbody tr:nth-child(even) {
	background: #fafbfc;
}
.members-table tbody tr:hover {
	background: linear-gradient(135deg, #f0f4ff 0%, #f5f3ff 100%);
	transform: scale(1.002);
}
.members-table tbody td {
	padding: 18px 14px;
	text-align: center;
	font-size: 14px;
	color: #334155;
	font-weight: 500;
	border: none;
}
.meeting-count {
	font-size: 18px;
	font-weight: 700;
	color: #4A6CF7;
}
.members-summary {
	margin-top: 24px;
	padding: 20px 28px;
	background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
	border-radius: 16px;
	display: flex;
	align-items: center;
	gap: 20px;
}
</style>

<div class="members-table">
	<table>
		<colgroup>
			<col width="60px">
			<col width="120px">
			<col width="150px">
			<col width="">
			<col width="120px">
			<col width="150px">
		</colgroup>
		<thead>
			<tr>
				<th>번호</th>
				<th>아이디</th>
				<th>이름</th>
				<th style="text-align:left; padding-left:20px;">이메일</th>
				<th>참여 강의수</th>
				<th>등록일</th>
			</tr>
		</thead>
		<tbody>
<?
if($total_count > 0) {
	foreach($data_array as $row) {
?>
			<tr>
				<td><?=$row['idx']?></td>
				<td><span style="font-family: monospace; background: #f1f5f9; padding: 4px 10px; border-radius: 6px; font-weight: 600; color: #475569;"><?=$row['UserId']?></span></td>
				<td><strong style="color: #1e293b;"><?=$row['DisplayName']?></strong></td>
				<td style="text-align:left; padding-left:20px;"><span style="color: #64748b; font-size: 14px;"><?=$row['Email']?></span></td>
				<td>
					<span class="meeting-count"><?=$row['MeetingCount']?></span>
				</td>
				<td><span style="color: #94a3b8; font-size: 13px;"><?=$row['CreatedAt']?></span></td>
			</tr>
<?
	}
} else {
?>
			<tr>
				<td colspan="6" style="padding:100px 20px; text-align:center;">
					<div style="font-size: 72px; opacity: 0.2;">👥</div>
					<strong style="color: #64748b; font-size: 18px; display: block; margin-top: 10px;">등록된 회원이 없습니다</strong>
					<p style="color: #94a3b8; margin-top: 10px;">회원이 live.hrdeedu.co.kr에 로그인하면 여기에 표시됩니다</p>
				</td>
			</tr>
<?
}
?>
		</tbody>
	</table>
</div>

<?if($total_count > 0) {?>
<div class="members-summary">
	<strong style="color: #1e293b; font-size: 16px;">총 <?=$total_count?>명의 회원</strong>
	<?
	$totalMeetings = 0;
	foreach($data_array as $row) {
		$totalMeetings += $row['MeetingCount'];
	}
	?>
	<span style="color:#64748b; font-weight:600; background: #f1f5f9; padding: 6px 14px; border-radius: 12px; font-size: 13px;">총 참여 강의: <?=$totalMeetings?>개</span>
</div>
<?}?>

