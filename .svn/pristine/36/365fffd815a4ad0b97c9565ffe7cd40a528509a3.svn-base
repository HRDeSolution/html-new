<?
$MenuType = "H";
$PageName = "after";
$ReadPage = "after_read";
?>
<? include "./include/include_top.php"; ?>
<?
##-- 검색 조건
$where = array();

if($sw){
	if($col=="") {
		$where[] = "";
	}else{
		$where[] = "$col LIKE '%$sw%'";
	}
}
$where[] = "Del='N'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

##-- 정렬조건
if($orderby=="") {
	$str_orderby = "ORDER BY RegDate DESC, idx DESC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM Review $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];

##-- 메인화면 노출 개수
$SqlA = "SELECT COUNT(*) FROM Review WHERE MainYN='Y'";
$ResultA = mysqli_query($connect, $SqlA);
$RowA = mysqli_fetch_array($ResultA);
$Main_NO = $RowA[0];

mysqli_free_result($Result);

##-- 페이지 클래스 생성
include_once("./include/include_page.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소
?>
<script type="text/javascript">
	//삭제 기능
	function DeleteOk(idx) {
    	del_confirm = confirm("현재 수강후기를 삭제하시겠습니까?");
    	if(del_confirm==true) {
    		document.DeleteForm.idx.value = idx;
    		DeleteForm.submit();
    	}
    }
</script>
    <div class="contentBody">
    	<h2>수강후기</h2>
		<form name="DeleteForm" method="post" action="after_script.php" target="ScriptFrame">
			<INPUT TYPE="hidden" name="mode" value="del">
			<INPUT TYPE="hidden" name="idx" value="">
		</form>
		<form name="MainShowForm" method="post" action="after_show_script.php" target="ScriptFrame">
			<INPUT TYPE="hidden" name="mode" value="mainShow">
			<INPUT TYPE="hidden" name="idx_value" value="">
			<INPUT TYPE="hidden" name="mainNo" id="mainNo" value="<?=$Main_NO?>">
		</form>
		<form name="MainNoShowForm" method="post" action="after_show_script.php" target="ScriptFrame">
			<INPUT TYPE="hidden" name="mode" value="mainNoShow">
			<INPUT TYPE="hidden" name="idx_value" value="">
		</form>
		<form name="ShowForm" method="post" action="after_show_script.php" target="ScriptFrame">
			<INPUT TYPE="hidden" name="mode" value="show">
			<INPUT TYPE="hidden" name="idx_value" value="">
		</form>
		<form name="NoShowForm" method="post" action="after_show_script.php" target="ScriptFrame">
			<INPUT TYPE="hidden" name="mode" value="noShow">
			<INPUT TYPE="hidden" name="idx_value" value="">
		</form>
		
      	<div class="conZone">
            <!-- 검색 -->
			<form name="search" method="get">
            	<div class="searchPan">
                	<select name="col">
						<option value="ContentsName" <?if($col=="ContentsName") { echo "selected";}?>>과정명</option>
						<option value="ID" <?if($col=="ID") { echo "selected";}?>>아이디</option>
						<option value="Name" <?if($col=="Name") { echo "selected";}?>>이름</option>
						<option value="Title" <?if($col=="Title") { echo "selected";}?>>제목</option>
					</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
                </div>
			</form>
			<!-- //검색 -->
			
			<!-- 버튼 -->
			<div class="btnAreaTr02">
				<?if($AdminWrite=="Y") {?>
				<input type="button" name="BtnA" id="BtnA" value="메인화면 노출" class="btn_inputBlue01" onclick="MainShow()">
				<input type="button" name="BtnB" id="BtnB" value="메인화면 미노출" class="btn_inputBlue01" onclick="MainNoShow()">
				<input type="button" name="BtnC" id="BtnC" value="홈페이지 노출" class="btn_inputBlue01" onclick="SiteShow()">
				<input type="button" name="BtnD" id="BtnD" value="홈페이지 미노출" class="btn_inputBlue01" onclick="SiteNoShow()">
				<?}?>
          	</div>
          	<!-- //버튼 -->
				
			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
				<colgroup>
                	<col width="40px" />
                	<col width="40px" />
                    <col width="300px" />
                    <col width="120px" />
                    <col width="80px" />
                    <col width="" />
					<col width="150px" />
					<col width="180px" />
					<col width="80px" />
					<col width="150px" />
					<col width="50px" />
				</colgroup>
				<tr>
					<th><input type="checkbox" name="AllCheck" id="AllCheck" value="Y" onclick="CheckBox_AllSelect('check_idx')" class="checkbox" /></th>
                	<th>번호</th>
					<th>과정명</th>
					<th>별점</th>
					<th>아이디<br>(이름)</th>
					<th>제목</th>
					<th>등록 IP</th>
					<th>등록일</th>
					<th>답변상태</th>
					<th>노출여부</th>
					<th>삭제</th>
				</tr>
				<!-- 메인화면 노출인 수강후기 상단으로 -->
				<?
				$SQL = "SELECT * FROM Review $where AND MainYN = 'Y' $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
				//echo $SQL;
				$QUERY = mysqli_query($connect, $SQL);
				if($QUERY && mysqli_num_rows($QUERY)){
                    while($ROW = mysqli_fetch_array($QUERY)){
						extract($ROW);
						$Star = StarPointView($StarPoint);
				?>
				<tr>
					<td align="center"><input type="checkbox" name="check_idx" id="check_idx" value="<?=$idx?>" class="checkbox" /></td>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td style="text-align:left"><a href="Javascript:readRun('<?=$idx?>');"><?=$ContentsName?></a></td>
					<td><?=$Star?></td>
					<td><?=$ID?><br>(<?=$Name?>)</td>
					<td style="text-align:left"><a href="Javascript:readRun('<?=$idx?>');"><?=$Title?></a></td>
					<td><?=$IP?></td>
					<td><?=$RegDate?></td>
					<td><?if($Status == "A") echo "답변 대기"; else echo "답변 완료";?></td>
					<td>
						<?if($UseYN == "Y") echo "노출"; else echo "미노출";?>
						<?if($MainYN == "Y"){?><br><font color='red'>(메인화면 노출)</font> <?}else{?><br>(메인화면 미노출)<?}?>
					</td>
					<td><?if($AdminWrite=="Y") {?><input type="button"  value="삭제" class="btn_inputSm01" onclick="DeleteOk(<?=$idx?>);"><a href="Javascript:DeleteOk(<?=$idx?>);"><?}?></td>
				</tr>
                <?
					}
					mysqli_free_result($QUERY);
				}
			    ?>
			    <!-- //메인화면 노출인 수강후기 상단으로 -->
			    
				<?
				$SQL = "SELECT * FROM Review $where AND MainYN = 'N' $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
				//echo $SQL;
				$QUERY = mysqli_query($connect, $SQL);
				if($QUERY && mysqli_num_rows($QUERY)){
                    while($ROW = mysqli_fetch_array($QUERY)){
						extract($ROW);
						$Star = StarPointView($StarPoint);
				?>
				<tr>
					<td align="center"><input type="checkbox" name="check_idx" id="check_idx" value="<?=$idx?>" class="checkbox" /></td>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td style="text-align:left"><a href="Javascript:readRun('<?=$idx?>');"><?=$ContentsName?></a></td>
					<td><?=$Star?></td>
					<td><?=$ID?><br>(<?=$Name?>)</td>
					<td style="text-align:left"><a href="Javascript:readRun('<?=$idx?>');"><?=$Title?></a></td>
					<td><?=$IP?></td>
					<td><?=$RegDate?></td>
					<td><?if($Status == "A") echo "답변 대기"; else echo "답변 완료";?></td>
					<td>
						<?if($UseYN == "Y") echo "노출"; else echo "미노출";?>
						<?if($MainYN == "Y"){?><br><font color='red'>(메인화면 노출)</font> <?}else{?><br>(메인화면 미노출)<?}?>
					</td>
					<td><?if($AdminWrite=="Y") {?><input type="button"  value="삭제" class="btn_inputSm01" onclick="DeleteOk(<?=$idx?>);"><a href="Javascript:DeleteOk(<?=$idx?>);"><?}?></td>
				</tr>
                <?
					}
					mysqli_free_result($QUERY);
				}else{
				?>
				<tr><td height="50" class="tc" colspan="10">등록된 수강후기가 없습니다.</td></tr>
				<? 
				}
			    ?>
			</table>
            <!--페이지-->
   		  	<?=$BLOCK_LIST?>
   		  	<!--//페이지-->
      	</div>
    </div>
</div>
<!-- Content // -->
<? include "./include/include_bottom.php"; ?>