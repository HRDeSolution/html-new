<?
$MenuType = "C";
$PageName = "study_sms_log";
$ReadPage = "study_sms_log_read";
?>
<? include "./include/include_top.php"; ?>
        
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>문자발송내역</h2>
<?
//2025-06-19 jky 조회기간 추가
$RegDateStart = Replace_Check($StartDate);
$RegDateEnd = Replace_Check($EndDate);

if(empty($RegDateStart)) {
	$RegDateStart = date('Y-m-d', strtotime('-1 week'));
	$RegDateEnd = date('Y-m-d');
}

##-- 검색 조건
$where = array();

//2025-06-19 jky 조회기간 추가
$where[] = "a.RegDate >= '$RegDateStart 00:00:00' and  a.RegDate <= '$RegDateEnd 23:59:59'";

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
$Sql = "SELECT COUNT(*) FROM SmsSendLog AS a LEFT OUTER JOIN Member AS b ON a.ID=b.ID LEFT OUTER JOIN Company AS c ON b.CompanyCode=c.CompanyCode $where";
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
				
				<div class="neoSearch">
					<!-- //2025-06-19 jky 조회기간 추가 -->
    				<ul class="search">
    					<li>
    						<span class="item01"><label>조회기간</label></span>
    						<input name="StartDate" id="StartDate" type="text" size="12" value="<?=$RegDateStart?>" autocomplete='off'>  ~  <input name="EndDate" id="EndDate" type="text" size="12" value="<?=$RegDateEnd?>" autocomplete='off'>
    					</li>
    					<li>
							<div class="searchPan">
								<select name="col">
									<option value="b.Name" <?if($col=="b.Name") { echo "selected";}?>>이름</option>
									<option value="a.ID" <?if($col=="a.ID") { echo "selected";}?>>아이디</option>
									<!-- <option value="a.Mobile" <?if($col=="a.Mobile") { echo "selected";}?>>휴대폰</option> -->
									<option value="c.CompanyName" <?if($col=="b.CompanyName") { echo "selected";}?>>사업주명</option>
									<option value="a.Massage" <?if($col=="a.Massage") { echo "selected";}?>>발송내역</option>
								</select>
								<input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
								<button type="submit" name="SubmitBtn" id="SubmitBtn" class="btn btn_Blue line"><i class="fas fa-search"></i> 검색</button>
							</div>
    					</li>
    				</ul>
    			</div>
                
				</form>
            
                <!--목록 -->
				<div class="btnAreaTr02">
				<?if($AdminWrite=="Y") {?>
					<button type="button" name="Btn" id="Btn" class="btn btn_Green line" onclick="location.href='<?=$PageName?>_excel.php?col=<?=$col?>&sw=<?=$sw?>&StartDate=<?=$RegDateStart?>&EndDate=<?=$RegDateEnd?>'"><i class="fas fa-file-excel"></i> 검색항목 엑셀 출력</button>
				<?}?>
              	</div>
                <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
                  <colgroup>
                    <col width="50px" />
                    <col width="100px" />
                    <col width="100px" />
                    <col width="100px" />
					<col width="" />
					<col width="100px" />
					<col width="80px" />
					<col width="150px" />
                  </colgroup>
                  <tr>
                    <th>번호</th>
                    <th>아이디</th>
                    <th>이름</th>
                    <th>휴대폰</th>
					<th>발송내용</th>
					<th>발송일</th>
					<th>상태</th>
					<th>사업주</th>
                  </tr>
					<?
					$SQL = "SELECT a.*, b.Name, c.CompanyName, c.CompanyCode FROM SmsSendLog AS a LEFT OUTER JOIN Member AS b ON a.ID=b.ID LEFT OUTER JOIN Company AS c ON b.CompanyCode=c.CompanyCode $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);

							if(!$CompanyName) {
								$CompanyName = "일반회원";
							}

							// Brad (2021.12.02) : 핸드폰 정보 마스킹 해제
							//o $Mobile = InformationProtection($Mobile,'Mobile2','S');
					?>
                  <tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td><A HREF="Javascript:MemberInfo('<?=$ID?>');"><?=$ID?></A></td>
					<td><A HREF="Javascript:MemberInfo('<?=$ID?>');"><?=$Name?></A></td>
					<td><?=$Mobile?></td>
					<td class="tl"><?=$Massage?></td>
					<td><?=$RegDate?></td>
					<td><?=$SMS_ReturnCode_array[$Code]?></td>
					<td><a href="Javascript:CompanyInfo('<?=$CompanyCode?>');"><?=$CompanyName?></a></td>
                  </tr>
                  <?
						}
					mysqli_free_result($QUERY);
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="20">등록된 발송내역이 없습니다.</td>
					</tr>
					<? 
					}
					?>
                </table>
                
                <!--페이지-->
   		  		<?=$BLOCK_LIST?>
                <div class="btnAreaTr02">
				<?if($AdminWrite=="Y") {?>
					<button type="button" name="Btn" id="Btn" class="btn btn_Green line" onclick="location.href='<?=$PageName?>_excel.php?col=<?=$col?>&sw=<?=$sw?>&StartDate=<?=$StartDate?>&EndDate=<?=$RegDateEnd?>'"><i class="fas fa-file-excel"></i> 검색항목 엑셀 출력</button>
				<?}?>
              	</div>
            	<!-- 버튼 -->

                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->

	<!-- Footer -->
	<script type="text/javascript">
			$(document).ready(function(){
				$("#StartDate, #EndDate").datepicker({
					changeMonth: true,
					changeYear: true,
					showButtonPanel: true,
					showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
					buttonImage: "images/icn_calendar.gif", //이미지 주소
					buttonImageOnly: true //이미지만 보이기
				});
				// $("#RegDateStart, #RegDateEnd").val("");
				$("img.ui-datepicker-trigger").attr("style","margin-left:5px; vertical-align:top; cursor:pointer;"); //이미지 버튼 style적용
			});
			</script>
<? include "./include/include_bottom.php"; ?>