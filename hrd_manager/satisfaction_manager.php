<?
$MenuType = "D";
$PageName = "satisfaction_manager";
$ReadPage = "satisfaction_manager_read";

?>
<? include "./include/include_top.php"; ?>
<!--
$(document).ready(function() {
	$("#Gubun").select2();
	changeSelect2Style();
});
//-->
</SCRIPT>
<?
##-- 검색 조건
$where = array();

if($sw){
	if($col=="") {
		$where[] = "";
	}else{
        $where[] = ($col=="aValue") ? "aq.aValue LIKE '%$sw%'" :" $col LIKE '%$sw%'" ;
	}
}


// $where[] = "aq.idx IN (36, 37, 38, 39, 40)";
$where[] = "aq.aType = 'A' AND aq.aDepth = 'step01' AND aq.aGroup = 'A'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

##-- 정렬조건
if($orderby=="") {
	$str_orderby = "ORDER BY ar.regDate DESC, aq.aOrder ASC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM ArchiveAbilityResult2 ar 
        LEFT JOIN ArchiveQuestion aq ON aq.idx = ar.question_idx
        LEFT JOIN `Member` m ON ar.ID = m.ID 
        $where";

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
    	<!-- ########## -->
        <h2>만족도조사</h2>
        <div class="conZone">
            <!-- 검색 -->
			<form name="search" method="get">
                <div class="searchPan">
					<select name="col">
						<option value="aValue" <?if($col=="aq.aValue") { echo "selected";}?>>문항명</option>
						<option value="ID" <?if($col=="ID") { echo "selected";}?>>아이디</option>
                        <option value="Name" <?if($col=="Name") { echo "selected";}?>>이름</option>
					</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
                </div>
			</form>
			<!-- //검색 -->
            <!--목록 -->
			<div style="display:grid;grid-template-columns: 1fr 1fr;">
				<div class="btnAreaTl02">
					<!-- <input type="button" value="전체 선택" id="AllCheck">
					<input type="button" value="삭제" onclick='deleteSelected();'> -->
				</div>			
				<div class="btnAreaTr02">
                <button type="button" name="ExcelOutBtn" id="ExcelOutBtn" class="btn btn_Green line" onClick="location.href='<?=$PageName?>_excel.php?col=<?=$col?>&sw=<?=$sw?>'"><i class="fas fa-file-excel"></i> 검색항목 엑셀 출력</button>
					<!-- <input type="button" value="엑셀로 기초차시 등록" onclick="location.href='<?=$PageName?>_excel.php'" class="btn_inputGreen01"> -->
					<!-- <input type="button" value="신규 등록" onclick="location.href='<?=$PageName?>_write.php?mode=new'" class="btn_inputBlue01"> -->
           		</div>
			</div>
            <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
            	<colgroup>
					<!-- <col width="50px" /> -->
                    <col width="60px" />
					<col width="80px" />
                    <col width="80px" />
                    <col width="60px" />
                    <col width="" />
                    <col width="150px" />
                    <col width="150px" />
				</colgroup>
                <tr>
					<!-- <th>선택</th> -->
					<th>번호</th>
					<th>아이디</th>
                    <th>이름</th>
                    <th>순서</th>
					<th>문항</th>
                    <th>만족도</th>
					<th>등록일</th>
				</tr>
				<?

				$SQL = "SELECT ar.idx, ar.ID, m.Name, ar.aValue, aq.aDepth, aq.aGroup, aq.aOrder, aq.aBind, aq.aValue AS aValue2, ar.regDate FROM ArchiveAbilityResult2 ar 
                        LEFT JOIN ArchiveQuestion aq ON aq.idx = ar.question_idx 
                        LEFT JOIN `Member` m ON ar.ID = m.ID 
                        $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
				$QUERY = mysqli_query($connect, $SQL);
				if($QUERY && mysqli_num_rows($QUERY)){
					while($ROW = mysqli_fetch_array($QUERY)){
						extract($ROW);
                ?>
                <tr data-idx = '<?=$idx?>'>
					<!-- <td class="text01"><input type="checkbox" class="chk" name="chk4delete" id="chk4delete"></td> -->
					<td class="text01"><?=$PAGE_UNCOUNT--?></td>
					<td class="text01"><?=$ID;?></td>
                    <td class="text01"><?=$Name;?></td>
                    <td class="text01"><?=$aOrder;?></td>
					<td class="text01"><?=$aValue2?></a></td>
                    <td class="text01"><?=str_repeat('★ ', $aValue)?></td>
					<td class="text01"><?=$regDate?></td>
                </tr>
                <?
					}
					mysqli_free_result($QUERY);
				}else{
				?>
				<tr>
					<td height="50" class="tc" colspan="20">등록된 문항이 없습니다.</td>
				</tr>
				<? } ?>
			</table>
            
            <!--페이지-->
   		  	<?=$BLOCK_LIST?>
   		  	<!--//페이지-->
                
            <!-- 버튼 -->
			<div class="btnAreaTr02">
            <button type="button" name="ExcelOutBtn" id="ExcelOutBtn" class="btn btn_Green line" onClick="location.href='<?=$PageName?>_excel.php?col=<?=$col?>&sw=<?=$sw?>'"><i class="fas fa-file-excel"></i> 검색항목 엑셀 출력</button>
				<!-- <input type="button" value="엑셀로 기초차시 등록" onclick="location.href='<?=$PageName?>_excel.php'" class="btn_inputGreen01"> -->
				<!-- <input type="button" value="신규 등록" onclick="location.href='<?=$PageName?>_write.php?mode=new'" class="btn_inputBlue01"> -->
            </div>
            <!-- //버튼 -->
      	</div>
	</div>
</div>
<!-- Content // -->

<!-- Footer -->
<? include "./include/include_bottom.php"; ?>
<!--check all-->
<script>
	document.getElementById('AllCheck').addEventListener('click', function() {
		const checkboxes = document.querySelectorAll('.chk');
		const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
		
		checkboxes.forEach(checkbox => {
			checkbox.checked = !allChecked;
		});
	});
	
		function deleteSelected() {
		var checkedBoxes = document.querySelectorAll('input[name="chk4delete"]:checked');
		if (checkedBoxes.length === 0) {
            alert("삭제할 항목을 선택해주세요.");
            return;
        }
        var thingsToDelete = [];
        checkedBoxes.forEach(function(singleOne) {
            // 해당 체크박스의 tr 태그에서 ID값을 가져옴
            var tr = singleOne.closest('tr');
            var idx = tr.getAttribute('data-idx');
            thingsToDelete.push(idx);
            console.log(idx); //여기까지 데이터 잘 들어오는 것 확인.
        });
    
    	if (confirm("정말로 삭제하시겠습니까?")) {
            $.ajax({
                type: "POST",
                url: "",
                data: JSON.stringify({ idx: thingsToDelete }),
                success: function(response) {
                	console.log(response);
                	if(response.succnt > 0){
	                    alert("총 " + response.succnt + "건의 삭제가 완료되었습니다.");
                	}else{
                		alert("문제가 발생했습니다. 잠시 후 다시 시도해주세요.");
                	}
                    location.reload();  // 페이지 새로고침
                },
                error: function() {
                    alert("삭제 중 오류가 발생했습니다.");
                }
            });
        }

	}
</script>
