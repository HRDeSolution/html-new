<?
$MenuType = "E";
$PageName = "contents_keyword";
$ReadPage = "contents_keyword_read";
?>
<? include "./include/include_top.php"; ?>
<?
$key = Replace_Check($idx);

$where = array();
$where[] = "Category = $key";
$where[] = "Del = 'N'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM ContentsKeyword $where ";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];
mysqli_free_result($Result);
?>
    <div class="contentBody">
    	<h2>컨텐츠 키워드 관리</h2>
    	<div class="conZone">
    		<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
            	<colgroup>
    				<col width="120px" />
                    <col width="" />
    			</colgroup>
    			<tr>
    				<th>과정 분류</th>
    				<td>
    				<?
    				if($key == 0)   echo "전체";
    				else    echo $ContentsKeyword_array[$key];
    				?>    				
    				</td>
    			</tr>
            </table>
    		<br><br>
    		
    		<script type="text/javascript">
				$(document).ready(function() {
					$("#table-1").tableDnD();
				});
			</script>
			
			<div class="btnAreaTl02">
				<input type="button" name="Btn" id="Btn" value="정렬하기" class="btn_inputLine01" onclick="KeywordOrderBy();">&nbsp;&nbsp;&nbsp;[각행을 상하로 드래그하여 정렬하세요.]
          	</div>
    		<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
				<colgroup>
                	<col width="80px" />
                	<col width="80px" />
                    <col width="" />
                    <col width="200px" />
                    <col width="300px" />
                    <col width="300px" />
                    <col width="80px" />
				</colgroup>
				<tr>
					<th>번호</th>
					<th>정렬순서</th>
                    <th>키워드</th>
                    <th>사이트노출</th>
                    <th>등록일자</th>
                    <th>수정일자</th>
                    <th style=color:red;>idx</th>
				</tr>
			</table>
			<form name="OrderByForm" method="POST" action="contents_keyword_script.php" target="ScriptFrame">
				<input type="hidden" name="mode" id="mode" value="OrderByProc">
				<input type="hidden" name="Category" value="<?=$key?>">
				<input type="hidden" name="idx_value" id="idx_value">
				<table id="table-1" width="100%" cellpadding="0" cellspacing="0" class="list_ty01">
					<colgroup>
                        <col width="80px" />
                    	<col width="80px" />
                        <col width="" />
                        <col width="200px" />
                        <col width="300px" />
                        <col width="300px" />
                        <col width="80px" />
					</colgroup>
					<?
					$SQL = "SELECT *  FROM ContentsKeyword $where ORDER BY OrderByNum ";
					//echo $SQL;
					$i = 1;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY)){
					    while($ROW = mysqli_fetch_array($QUERY)){
					        extract($ROW);
					?>
					<tr id="<?=$i?>">
						<td><?=$i?><input type="hidden" name="keyword_idx" id="keyword_idx" value="<?=$idx?>"></td>
						<td><?=$OrderByNum?></td>
    					<td align="center" bgcolor="#FFFFFF" class="text01"><a href="Javascript:KeywordPop('<?=$key?>', '<?=$idx?>', 'edit');"><?=$Keyword?></a></td>
    					<td><?if($UseYN=="Y"){?>사용<?}else{?>미사용<?}?></td>
    					<td><?=$RegDate?></td>
    					<td><?=$MdfDate?></td>
    					<td style=color:red;><?=$idx?></td>
                  	</tr>
					<?
                            $i++;
                        }
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="6">등록된 컨텐츠 키워드가 없습니다.</td>
					</tr>
					<? 
					}
					?>
                </table>
			</form>
			<div class="btnAreaTr02">
				<input type="button" name="Btn" id="Btn" value="추가 하기" class="btn_inputBlue01" onclick="Javascript:KeywordPop('<?=$key?>', '0', 'new');">
          	</div>
        </div>
    </div>
</div>
<script>
//정렬하기
function KeywordOrderBy() {
	var idx_arrary = '';
	var idx_temp_count = $("input[id='keyword_idx']").length;

	for (i = 0; i < idx_temp_count; i++) {
		if (idx_arrary == '') {
			idx_arrary = $("input[id='keyword_idx']:eq(" + i + ')').val();
		} else {
			idx_arrary = idx_arrary + '|' + $("input[id='keyword_idx']:eq(" + i + ')').val();
		}
	}
	if (idx_arrary == '') {
		alert('등록된 컨텐츠 키워드가 없습니다.');
		return;
	}
	Yes = confirm('정렬하시겠습니까?');
	if (Yes == true) {
		$("input[id='idx_value']").val(idx_arrary);
		OrderByForm.submit();
	}
}

//추가하기
function KeywordPop(cat, idx, mode) {
	//로그아웃 시간 초기화
	$('#NowTime').val('0');

	var currentWidth = $(window).width();
	var LocWidth = currentWidth / 2;
	var body_width = screen.width - 20;
	var body_height = $('html body').height();

	$("div[id='SysBg_Black_Click']")
		.css({
			width: body_width,
			height: body_height,
			opacity: '0.4',
			position: 'absolute',
			'z-index': '99',
		})
		.show();

	$("div[id='Roading']")
		.css({
			top: '450px',
			left: LocWidth,
			opacity: '0.6',
			position: 'absolute',
			'z-index': '200',
		})
		.show();

	$('#DataResult').load('./contents_keyword_write.php', { cat: cat, idx: idx, mode: mode }, function () {
		$("div[id='Roading']").hide();

		$('html, body').animate({ scrollTop: 200 }, 500);
		$("div[id='DataResult']")
			.css({
				top: '250px',
				width: '1200px',
				left: body_width / 2 - 500,
				opacity: '1.0',
				position: 'absolute',
				'z-index': '1000',
			})
			.show()
			.draggable();
	});
}
</script>
<!-- Footer -->
<? include "./include/include_bottom.php"; ?>