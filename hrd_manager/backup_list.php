<?
$MenuType = "G";
$PageName = "backup_list";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>백업 목록</h2>
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

//echo $where;
##-- 정렬조건
if($orderby=="") {
	$str_orderby = "ORDER BY a.idx DESC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수

$Sql = "SELECT COUNT(*)FROM backup_data_list a $where";
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
            <div class="conZone">
            	<!-- ## START -->
                
                <!-- 검색 -->
				<form name="search" method="get">
                <div class="searchPan">
                	<select name="col">
						<option value="a.reg_date" <?if($col=="a.reg_date") { echo "selected";}?>>백업일자</option>
					</select>
                    <input name="sw" type="text" id="sw" class="wid300" placeholder="검색어를 입력하세요" value="<?=$sw?>" />
					<button type="submit" name="SubmitBtn" id="SubmitBtn" class="btn btn_Blue line"><i class="fas fa-search"></i> 검색</button>
                </div>
				</form>
                <br/><span>* 백업 리스트는 매일 오전 08:10 업데이트</span>
                <!--목록 -->
                <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
                  <colgroup>
                    <col width="80px" />
                    <col width="" />
                    <col width="" />
                    <col width="" />
                    <col width="" />
					<col width="" />
					<col width="" />
                    <col width="" />
                    <col width="" />
                    <col width="" />
                  </colgroup>
                  <tr>
                    <th>번호</th>
					<th>백업일자</th>
                    <th>백업수단</th>
                    <th>백업주기</th>
                    <th>보관만료일</th>
					<th>백업_WebSource</th>
                    <th>백업_WebLog</th>
					<th>백업_DB</th>
                    <th>백업_VOD</th>
                    <th>등록일</th>
                  </tr>
					<?
					$SQL = "SELECT * FROM backup_data_list a 
                            $where $str_orderby 
                            LIMIT $PAGE_CLASS->page_start, $page_size";
					// echo $SQL;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);

							$Email = InformationProtection($Email,'Email','S');
							$Mobile = InformationProtection($Mobile,'Mobile','S');
							$BirthDay = InformationProtection($BirthDay,'BirthDay','S');
					?>
                  <tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td><?=date("Y-m-d",strtotime($reg_date))?></td>
					<td><?=$backup_type?></td>
					<td><?=$backup_interval?></td>
					<td><?=date("Y-m-d",strtotime($expiry_date))?></td>
                    <td><?=$web_file_nm?></td>
                    <td><?=$weblog_file_nm?></td>
					<td><?=$db_file_nm?></td>
                    <td><?=$vod_file_nm?></td>
                    <td><?=$reg_date?></td>
                  </tr>
                  <?
						}
					mysqli_free_result($QUERY);
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="20">등록된 백업 목록이 없습니다.</td>
					</tr>
					<? 
					}
					?>
                </table>
                
                <!--페이지-->
   		  		<?=$BLOCK_LIST?>
                
            	<!-- 버튼 -->
                <div class="btnAreaTr02">
				<?if($AdminWrite=="Y") {?>
					<button type="button" name="ExcelOutBtn" id="ExcelOutBtn" class="btn btn_Green line" onclick="location.href='<?=$PageName?>_excel.php?col=<?=$col?>&sw=<?=$sw?>'"><i class="fas fa-file-excel"></i> 검색항목 엑셀 출력</button>
				<?}?>
              	</div>
                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->

<!-- Footer -->
<? include "./include/include_bottom.php"; ?>