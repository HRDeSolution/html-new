<?
$MenuType = "J";
?>
<? include "./include/include_top.php"; ?>    
<?
##-- 검색 조건
$where = array();
if($sw){
    if($col=="") $where[] = "";  else  $where[] = "$col LIKE '%$sw%'";
}
$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

##-- 정렬조건
if($orderby=="") {
    $str_orderby = "ORDER BY idx DESC, RegDate DESC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(idx) FROM SiteInfomation2 $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];

mysqli_free_result($Result);

##-- 페이지 클래스 생성
include_once("./include/include_page.php");
$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소
?>
	<div class="contentBody">
    	<h2>교육원 고유정보 관리</h2>
        <div class="conZone">
            <!-- 검색 -->
			<form name="search" method="get">
                <div class="searchPan">
                	<select name="col">
						<option value="InfoName" <?if($col=="InfoName") { echo "selected";}?>>정보명</option>
					</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
                </div>
			</form>
			<!-- //검색 -->
            
            <!--목록 -->
            <div class="btnAreaTr02">
				<input type="button" name="Btn" id="Btn" value="신규등록" class="btn_inputBlue01" onclick="Javascript:SiteInfo2Pop('0', 'new');">
          	</div>
            <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
            	<colgroup>
                	<col width="80px" />
                    <col width="" />
                    <col width="" />
					<col width="100px" />
                    <col width="150px" />
					<col width="200px" />
					<col width="150px" />
					<col width="200px" />
                </colgroup>
                <tr>
                    <th>번호</th>
					<th>정보명</th>
					<th>정보내용</th>
                    <th>사용여부</th>
                    <th>등록자ID</th>
					<th>등록일시</th>
					<th>수정자ID</th>
					<th>수정일시</th>
                </tr>
				<?
				$SQL = "SELECT *  FROM SiteInfomation2 $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
				//echo $SQL;
				$QUERY = mysqli_query($connect, $SQL);
				if($QUERY && mysqli_num_rows($QUERY)){
					while($ROW = mysqli_fetch_array($QUERY)){
						extract($ROW);
				?>
                <tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td align="center" bgcolor="#FFFFFF" class="text01"><a href="Javascript:SiteInfo2Pop('<?=$idx?>', 'edit');"><?=$InfoName?></a></td>
					<td align="center" bgcolor="#FFFFFF" class="text01"><a href="Javascript:SiteInfo2Pop('<?=$idx?>', 'edit');"><?=$InfoValue?></a></td>
					<td><?if($UseYN=="Y") echo "사용";  else  echo "미사용";?></td>
					<td><?=$RegID?></td>
					<td><?=$RegDate?></td>
					<td><?if($MdfID) echo $MdfID; else echo"-";?></td>
					<td><?if($MdfDate) echo $MdfDate; else echo"-";?></td>
                </tr>
                <?
					}
				   	mysqli_free_result($QUERY);
				}else{
				?>
				<tr>
					<td height="50" class="tc" colspan="8">등록된 내용이 없습니다.</td>
				</tr>
				<? }?>
            </table>
            <!--//목록 -->
                
            <!--페이지-->
   		  	<?=$BLOCK_LIST?>
			<!--//페이지-->
  		</div>
    </div>
</div>

<!-- Footer -->
<? include "./include/include_bottom.php"; ?>