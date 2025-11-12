<?
$MenuType = "C";
$PageName = "study_email_log_for_edumanager";
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
$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

##-- 정렬조건
if($orderby=="") {
	$str_orderby = "ORDER BY a.RegDate DESC, a.idx DESC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(*) 
        FROM EmailSendLogForEduManager AS a 
		LEFT OUTER JOIN Company AS c ON  a.CompanyCode = c.CompanyCode  
		$where";
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
		<h2>메일발송내역 (교육담당자) </h2>
        <div class="conZone">
            <!-- 검색 -->
			<form name="search" method="get">
            	<div class="searchPan">
                	<select name="col">
						<option value="a.Name" <?if($col=="b.Name") { echo "selected";}?>>이름</option>
						<option value="a.ID" <?if($col=="a.ID") { echo "selected";}?>>아이디</option>
						<option value="c.CompanyName" <?if($col=="b.CompanyName") { echo "selected";}?>>사업주명</option>
					</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
					<button type="submit" name="SubmitBtn" id="SubmitBtn" class="btn btn_Blue line"><i class="fas fa-search"></i> 검색</button>
                </div>
			</form>
			<!-- //검색 -->
            
            <!--목록 -->
			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
            	<colgroup>
                	<col width="50px" />
					<col width="100px" />
                    <col width="100px" />
					<col width="150px" />
					<col width="" />
					<col width="100px" />
					<col width="80px" />
				</colgroup>
                <tr>
                	<th>번호</th>
					<th>교육담당자</th>
                    <th>이메일</th>
					<th>사업주</th>
					<th>발송내용</th>
					<th>발송일</th>
					<th>상태</th>
				</tr>
				<?
				$SQL = "SELECT a.*,  c.CompanyName, c.CompanyCode, c.EduManager
                        FROM EmailSendLogForEduManager AS a 
				        LEFT OUTER JOIN Company AS c ON a.CompanyCode = c.CompanyCode   
					    $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
                //echo $SQL; 
				$QUERY = mysqli_query($connect, $SQL);
				if($QUERY && mysqli_num_rows($QUERY)){
					while($ROW = mysqli_fetch_array($QUERY)){
						extract($ROW);
						if(!$CompanyName) {
							$CompanyName = "일반회원";
						}
						//$Email = InformationProtection($Email,'Email','S');
				?>
                <tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td><?=$EduManager?></td>
					<td><?=$Email?></td>
					<td><a href="Javascript:CompanyInfo('<?=$CompanyCode?>');"><?=$CompanyName?></a></td>
					<td class="tl"><?=$Massage?></td>
					<td><?=$RegDate?></td>
					<td><?=$Email_ReturnCode_array[$Code]?></td>
				</tr>
                <?
					}
					mysqli_free_result($QUERY);
				}else{
				?>
				<tr>
					<td height="50" class="tc" colspan="20">등록된 발송내역이 없습니다.</td>
				</tr>
				<? } ?>
			</table>
            <!--//목록 -->
                
            <!--페이지-->
   		  	<?=$BLOCK_LIST?>
   		  	<!--//페이지-->
		</div>
	</div>
</div>
<!-- Content // -->

	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>