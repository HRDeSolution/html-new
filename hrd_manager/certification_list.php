<?
$MenuType = "B";
$PageName = "certification_list";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>본인인증 모니터링</h2>
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
	//$str_orderby = "ORDER BY a.RegDate DESC, a.idx DESC";
	$str_orderby = "ORDER BY a.Seq DESC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수

$Sql = "SELECT COUNT(*)FROM UserCertOTP a LEFT OUTER JOIN `Member` AS b ON	a.ID = b.ID LEFT OUTER JOIN Company AS c ON	b.CompanyCode = c.CompanyCode $where";
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
						<option value="b.Name" <?if($col=="b.Name") { echo "selected";}?>>이름</option>
						<option value="a.ID" <?if($col=="a.ID") { echo "selected";}?>>아이디</option>
						<option value="c.CompanyName" <?if($col=="c.CompanyName") { echo "selected";}?>>사업주명</option>
					</select>
                    <input name="sw" type="text" id="sw" class="wid300" placeholder="검색어를 입력하세요" value="<?=$sw?>" />
					<button type="submit" name="SubmitBtn" id="SubmitBtn" class="btn btn_Blue line"><i class="fas fa-search"></i> 검색</button>
                </div>
				</form>
            
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
                  </colgroup>
                  <tr>
                    <th>번호</th>
					<th>사업주</th>
                    <th>아이디</th>
                    <th>이름</th>
                    <th>교육과정</th>
					<th>인증시간</th>
					<th>전송시간</th>
                  </tr>
					<?
					$SQL = "SELECT a.Seq, a.ID, c.CompanyName, b.Name, d.ContentsName, a.m_trnDT, a.RegDate 
                            FROM UserCertOTP a 
                            LEFT OUTER JOIN `Member` AS b ON	a.ID = b.ID
                            LEFT OUTER JOIN Company AS c ON	b.CompanyCode = c.CompanyCode
                            LEFT OUTER JOIN Course AS d ON	a.LectureCode = d.LectureCode
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
					<td><?=$CompanyName?></td>
					<td><?=$ID?></td>
					<td><?=$Name?></td>
					<td><?=$ContentsName?></td>
                    <td><?=$m_trnDT?></td>
					<td><?=$RegDate?></td>
                  </tr>
                  <?
						}
					mysqli_free_result($QUERY);
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="20">등록된 수강생 정보가 없습니다.</td>
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