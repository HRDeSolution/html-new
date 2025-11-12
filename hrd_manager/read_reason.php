<?
$MenuType = "A";
$PageName = "read_reason";
?>
<? include "./include/include_top.php"; ?>
<?
##-- 검색 조건
$where = array(); 
$target_col = '';

if ($sw) {
	if($col == "") {
		$where[] = "";
	} else {
		if ($col == 'ID') {
			$target_col = 'a.ID';
		} elseif ($col == 'Name') {
			$target_col = 'b.Name';
		} elseif ($col == 'AdminID') {
			$target_col = 'a.AdminID';
		}

		$where[] = "$target_col LIKE '%$sw%'";
	}
}

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";


##-- 정렬조건
if($orderby == "") {
	$str_orderby = "ORDER BY a.RegDate DESC, a.idx DESC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM InformationProtectionLog a LEFT JOIN Member b ON a.ID = b.ID $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];

##-- 페이지 클래스 생성
include_once("./include/include_page.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소
?>
    <!-- Right -->
    <div class="contentBody">
        <h2>개인정보 열람내역</h2>
        <div class="conZone">
        	<form name="search" method="get">
    			<div class="searchPan">
    				<select name="col" class="wid150">
    					<option value="Name" <?php echo $col == "Name" ? "selected" : ""; ?>>열람대상자 (이름)</option>
    					<option value="ID" <?php echo $col == "ID" ? "selected" : ""; ?>>열람대상자 (아이디)</option>
    					<option value="AdminID" <?php echo $col == "AdminID" ? "selected" : ""; ?>>열람자</option>
    				</select>
    				<input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
    				<button type="submit" name="SubmitBtn" id="SubmitBtn" class="btn btn_Blue line"><i class="fas fa-search"></i> 검색</button>
    				<button type="button" name="SubmitBtn" id="SubmitBtn" class="btn btn_LGray line" onclick="location.href='<?=$PageName?>.php';"><i class="fas fa-sync-alt"></i> 검색 초기화</button>
    			</div>
    		</form>
        	
        	<div class="btnAreaTr02">
    		<?if($AdminWrite=="Y") {?>
    			<button type="button" name="ExcelOutBtn" id="ExcelOutBtn" class="btn btn_Green line" onClick="location.href='<?=$PageName?>_excel.php?Gubun=<?=$Gubun?>&col=<?=$col?>&sw=<?=$sw?>'"><i class="fas fa-file-excel"></i> 검색항목 엑셀 출력</button>
    		<?}?>
            </div>
            
            <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
              	<colgroup>
    				<col width="80px" />
    				<col width="" />
    				<col width="" />
    				<col width="" />
    				<col width="" />
    				<col width="" />
    			</colgroup>
    			<tr>
    				<th>번호</th>
    				<th>열람대상자</th>
    				<th>열람자</th>
    				<th style="width: 30%;">열람사유</th>
    				<th style="width: 12%;">열람구분</th>
    				<th>열람일</th>
              	</tr>
    			<?
    			$SQL = "SELECT a.*, b.Name 
    				    FROM InformationProtectionLog a
                        LEFT JOIN Member b ON a.ID = b.ID 
    				    $where $str_orderby 
    				    LIMIT $PAGE_CLASS->page_start, $page_size";    
    			$QUERY = mysqli_query($connect, $SQL);    
    			if ($QUERY && mysqli_num_rows($QUERY)) {
    				while ($ROW = mysqli_fetch_array($QUERY)) {
    					extract($ROW);
    			?>
              	<tr>
    				<td><?=$PAGE_UNCOUNT--?></td>
    				<td><?=$Name?> (<?=$ID?>)</td>
    				<td><?=$AdminID?></td>
    				<td style="text-align: left;"><?=$Content?></td>
    				<td><?=$Field?></td>
    				<td><?=$RegDate?></td>
    			</tr>
              	<?
    				}    			
    				mysqli_free_result($QUERY);
    			} else {
    			?>
    			<tr>
    				<td height="50" class="tc" colspan="7">열람된 기록이 없습니다.</td>
    			</tr>
    			<? } ?>
            </table>
            
            <?=$BLOCK_LIST?>
    	</div>
    </div>
    <!-- Right // -->
</div>
<!-- Content // -->

	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>