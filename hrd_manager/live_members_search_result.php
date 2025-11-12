<?
include "../include/include_function.php";
include "./include/include_admin_check.php";
include "../include/include_mongodb.php";

$isTutor = ($LoginAdminDept == "C");

if($isTutor) {
	http_response_code(403);
?>
<div class="loading-container">
	<div style="color:#dc2626; font-weight:600; font-size:16px;">⚠️ 접속 회원 목록은 관리자만 확인할 수 있습니다.</div>
	<div style="color:#64748b; margin-top:10px;">권한이 있는 계정으로 로그인해주세요.</div>
</div>
<?
	exit;
}

$SearchKeyword = Replace_Check($SearchKeyword);
$data_array = array();
$filter = [];

if($SearchKeyword) {
	$filter['$or'] = [
		['name' => ['$regex' => $SearchKeyword, '$options' => 'i']],
		['user_id' => ['$regex' => $SearchKeyword, '$options' => 'i']],
		['email' => ['$regex' => $SearchKeyword, '$options' => 'i']],
		['displayName' => ['$regex' => $SearchKeyword, '$options' => 'i']]
	];
}

$options = [
	'sort' => ['createdAt' => -1],
	'limit' => 100
];

$result = mongoFind('members', $filter, $options);

if($result['success'] && count($result['data']) > 0) {
	$idx_counter = count($result['data']);
	foreach($result['data'] as $member) {
		$userId = $member->user_id ?? '-';
		$name = $member->name ?? '-';
		$displayName = $member->displayName ?? $name;
		$email = $member->email ?? '-';
		$role = $member->role ?? 'MEMBER';
		$roleKorean = '';
		switch($role) {
			case 'ADMIN':
				$roleKorean = '관리자';
				break;
			case 'TUTOR':
				$roleKorean = '강사';
				break;
			case 'MEMBER':
			default:
				$roleKorean = '회원';
				break;
		}
		$isOnline = false;
		$lastLogin = '-';
		if(isset($member->lastLogin)) {
			$lastLogin = mongoDateToString($member->lastLogin, 'Y-m-d H:i');
			$lastLoginTime = $member->lastLogin->toDateTime()->getTimestamp();
			$currentTime = time();
			$isOnline = ($currentTime - $lastLoginTime) < 1800;
		}
		$createdAt = isset($member->createdAt) ? mongoDateToString($member->createdAt, 'Y-m-d H:i') : '-';
		$data_array[] = array(
			'idx' => $idx_counter--,
			'UserId' => $userId,
			'Name' => $name,
			'DisplayName' => $displayName,
			'Email' => $email,
			'Role' => $roleKorean,
			'IsOnline' => $isOnline,
			'LastLogin' => $lastLogin,
			'CreatedAt' => $createdAt,
			'MemberId' => mongoIdToString($member->_id)
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
.status-badge {
	padding: 6px 14px;
	border-radius: 20px;
	font-weight: 700;
	display: inline-flex;
	align-items: center;
	justify-content: center;
	gap: 6px;
	font-size: 12px;
	text-transform: uppercase;
	letter-spacing: 0.5px;
}
.status-online {
	background: linear-gradient(135deg, #10b981 0%, #34d399 100%);
	color: white;
	animation: pulse-green 2s infinite;
}
.status-offline {
	background: linear-gradient(135deg, #94a3b8 0%, #cbd5e1 100%);
	color: white;
}
@keyframes pulse-green {
	0%, 100% { box-shadow: 0 3px 12px rgba(16, 185, 129, 0.3); }
	50% { box-shadow: 0 3px 20px rgba(16, 185, 129, 0.5); }
}
.role-badge {
	padding: 6px 12px;
	border-radius: 12px;
	font-weight: 600;
	font-size: 12px;
	display: inline-block;
}
.role-admin { background: #fee2e2; color: #dc2626; }
.role-tutor { background: #dbeafe; color: #0369a1; }
.role-member { background: #f0fdf4; color: #16a34a; }
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
			<col width="120px">
			<col width="150px">
			<col width="">
			<col width="100px">
			<col width="100px">
			<col width="150px">
			<col width="150px">
		</colgroup>
		<thead>
			<tr>
				<th>번호</th>
				<th>아이디</th>
				<th>이름</th>
				<th>이메일</th>
				<th>역할</th>
				<th>상태</th>
				<th>최근접속</th>
				<th>등록일</th>
			</tr>
		</thead>
		<tbody>
<?
if($total_count > 0) {
	foreach($data_array as $row) {
		$roleClass = '';
		if($row['Role'] == '관리자') $roleClass = 'role-admin';
		else if($row['Role'] == '강사') $roleClass = 'role-tutor';
		else $roleClass = 'role-member';
?>
			<tr>
				<td><?=$row['idx']?></td>
				<td><span style="font-family: monospace; background: #f1f5f9; padding: 4px 10px; border-radius: 6px; font-weight: 600; color: #475569;"><?=$row['UserId']?></span></td>
				<td><strong><?=$row['DisplayName']?></strong></td>
				<td style="text-align:left; padding-left:10px;"><?=$row['Email']?></td>
				<td><span class="role-badge <?=$roleClass?>"><?=$row['Role']?></span></td>
				<td>
					<?if($row['IsOnline']) {?>
					<span class="status-badge status-online">🟢 접속중</span>
					<?} else {?>
					<span class="status-badge status-offline">⚫ 오프라인</span>
					<?}?>
				</td>
				<td><span style="color: #64748b; font-size: 13px;"><?=$row['LastLogin']?></span></td>
				<td><span style="color: #64748b; font-size: 13px;"><?=$row['CreatedAt']?></span></td>
			</tr>
<?
	}
} else {
?>
			<tr>
				<td colspan="8" class="empty-state">
					<div style="font-size: 72px; margin-bottom: 20px; opacity: 0.2;">👥</div>
					<strong style="font-size: 18px; color: #64748b;">등록된 회원이 없습니다</strong>
					<p style="margin-top: 10px; color: #94a3b8; font-size: 14px;">검색 조건을 변경하거나 회원이 로그인할 때까지 기다려주세요</p>
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
	<strong>👥 총 <?=$total_count?>명의 회원</strong>
	<?
	$onlineCount = 0;
	foreach($data_array as $row) {
		if($row['IsOnline']) $onlineCount++;
	}
	?>
	<span style="margin-left:15px; color:#10b981; font-weight:700; background: #d1fae5; padding: 6px 14px; border-radius: 20px; font-size: 13px;">🟢 접속중: <?=$onlineCount?>명</span>
	<span style="margin-left:10px; color:#64748b; font-weight:700; background: #f1f5f9; padding: 6px 14px; border-radius: 20px; font-size: 13px;">⚫ 오프라인: <?=($total_count - $onlineCount)?>명</span>
</div>
<?}?>

