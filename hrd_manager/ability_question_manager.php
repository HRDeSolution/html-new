<?
$MenuType = "D";
$PageName = "ability_question_manager";
$ReadPage = "ability_question_manager_read";
?>
<? include "./include/include_top.php"; ?>
<SCRIPT LANGUAGE="JavaScript">
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
        if ($col == "aType") $sw = array_search($sw, $abilityType_array);
		$where[] = "$col LIKE '%$sw%'";
	}
}
// if($Gubun) {
// 	$where[] = "Gubun='$Gubun'";
// }
$where[] = "Del='N'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

##-- 정렬조건
if($orderby=="") {
	$str_orderby = "ORDER BY idx ASC, aOrder ASC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM ArchiveQuestion $where";
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
        <h2>역량진단 문항관리</h2>
        <div class="conZone">
            <!-- 검색 -->
			<form name="search" method="get">
                <div class="searchPan">
					<select name="col">
						<option value="aValue" <?if($col=="aValue") { echo "selected";}?>>문항명</option>
                        <option value="aType" <?if($col=="aType") { echo "selected";}?>>역량타입</option>
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
					<!-- <input type="button" value="엑셀로 기초차시 등록" onclick="location.href='<?=$PageName?>_excel.php'" class="btn_inputGreen01"> -->
					<!-- <input type="button" value="신규 등록" onclick="location.href='<?=$PageName?>_write.php?mode=new'" class="btn_inputBlue01"> -->
           		</div>
			</div>
            <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
            	<colgroup>
					<!-- <col width="80px" /> -->
					<col width="50px" />
                    <col width="50px" />
                    <col width="50px" />
					<col width="50px" />
                    <col width="50px" />
                    <col width="" />
                    <col width="700px" />
                    <col width="150px" />
				</colgroup>
                <tr>
					<!-- <th>선택</th> -->
					<th>번호</th>
                    <th>역량타입</th>
					<th>단계</th>
                    <th>타입</th>
                    <th>순서</th>
					<th>문항</th>
                    <th>상세</th>
					<th>등록일</th>
				</tr>
				<?
				$SQL = "SELECT * FROM ArchiveQuestion $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
				// echo $SQL;
				$QUERY = mysqli_query($connect, $SQL);
				if($QUERY && mysqli_num_rows($QUERY)){
					while($ROW = mysqli_fetch_array($QUERY)){
						extract($ROW);
                ?>
                <tr data-idx = '<?=$idx?>'>
					<!-- <td class="text01"><input type="checkbox" class="chk" name="chk4delete" id="chk4delete"></td> -->
					<td class="text01"><?=$PAGE_UNCOUNT--?></td>
                    <td class="text01"><?=(is_null($aBind) || $aBind=="") ? "사후 (만족도)" : $abilityType_array[$aType];?></td>
                    <td class="text01"><?=$abilityDepth_array[$aDepth]?></td>
                    <td class="text01"><?=$abilityGroup_array[$aGroup]?></td>
                    <td class="text01"><?=$aOrder?></td>
					<td class="tl text01"><a href="#" onclick="location.href='<?=$PageName?>_write.php?mode=edit&idx=<?=$idx?>'"><?=$aValue?></a></td>
                    <td class="tl text01"><a href="#" onclick="location.href='<?=$PageName?>_write.php?mode=edit&idx=<?=$idx?>'"><?=$aValueDetail;?></a></td>
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
    
    	// if (confirm("정말로 삭제하시겠습니까?")) {
        //     $.ajax({
        //         type: "POST",
        //         url: "delete_contents.php",
        //         data: JSON.stringify({ idx: thingsToDelete }),
        //         success: function(response) {
        //         	console.log(response);
        //         	if(response.succnt > 0){
	    //                 alert("총 " + response.succnt + "건의 삭제가 완료되었습니다.");
        //         	}else{
        //         		alert("문제가 발생했습니다. 잠시 후 다시 시도해주세요.");
        //         	}
        //             location.reload();  // 페이지 새로고침
        //         },
        //         error: function() {
        //             alert("삭제 중 오류가 발생했습니다.");
        //         }
        //     });
        // }
	}
</script>
