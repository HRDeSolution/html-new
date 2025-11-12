<?
$MenuType = "F";
$PageName = "lecture_request2";
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
$where[] = "a.Del='N'";

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

##-- 정렬조건
if($orderby=="") {
	$str_orderby = "ORDER BY a.RegDate DESC, a.idx DESC";
}else{
	$str_orderby = "ORDER BY $orderby";
}

##-- 검색 등록수
$Sql = "SELECT COUNT(a.idx) FROM LectureRequest2 AS a 
		LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
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
    	<h2>학습신청/결제관리</h2>
		<div class="conZone">
            <form name="search" method="get">
            	<div class="searchPan">
                    <select name="col">
    					<option value="b.Name" <?if($col=="b.Name") { echo "selected";}?>>이름</option>
    					<option value="a.ID" <?if($col=="a.ID") { echo "selected";}?>>아이디</option>
    				</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <button type="submit" name="SubmitBtn" id="SubmitBtn" class="btn btn_Blue line"><i class="fas fa-search"></i> 검색</button>
               	</div>
			</form>
            
            <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
	            <colgroup>
    	            <col width="80px" />
                    <col width="" />
                    <col width="" />
					<col width="" />
					<col width="300px" />
					<col width="" />
					<col width="" />
            	</colgroup>
                <tr>
                	<th>번호</th>
                    <th>아이디</th>
                    <th>이름</th>
					<th>휴대폰</th>
					<th>주문고유번호</th>
					<th>신청한 교육 과정</th>
					<th>상태</th>
				</tr>
				<?
				$SQL = "SELECT a.*, b.Name, AES_DECRYPT(UNHEX(b.Mobile),'$DB_Enc_Key') AS Mobile 
						FROM LectureRequest2 AS a 
						LEFT OUTER JOIN Member AS b ON a.ID=b.ID 
						$where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
				//echo $SQL;
				$QUERY = mysqli_query($connect, $SQL);
				if($QUERY && mysqli_num_rows($QUERY)){
				    $i;
                    while($ROW = mysqli_fetch_array($QUERY)){
                        extract($ROW);
						$Mobile = InformationProtection($Mobile,'Mobile','S');
				?>
                <tr>
					<td><?=$PAGE_UNCOUNT--?></td>
					<td><?=$ID?></td>
					<td><?=$Name?></td>
					<td><?=$Mobile?></td>
					<td align="center" bgcolor="#FFFFFF" class="text01"><a href="Javascript:LectureRequest2Info('<?=$ID?>','<?=$idx?>');"><?=$paymentId?></a></td>
					<td align="left"><?=$ContentsName?></td>
					<td>
					<?if($Status!='C'&&$Status!='D'){?>
						<select name="Status" id="Status_<?=$idx?>" style="width:100px">
						<?while (list($key,$value)=each($LectureRequestStatus_array)) {?>
							<option value="<?=$key?>" <?if($Status==$key) {?>selected<?}?>><?=$value?></option>
					<?
						}
					    reset($LectureRequestStatus_array);
				    }
				    ?>
						</select>&nbsp;
						<?if($Status!='C'&&$Status!='D'){?>
						<input type="button" value="변경" class="btn_inputSm01" onclick="LectureRequest2Status('<?=$ID?>','<?=$idx?>');">
						<?}else{?>
						<input type="button" value="결제취소 정보" class="btn_inputSm01" onclick="CancelInfo('<?=$ID?>','<?=$idx?>');" style="width:125px;">
						<?} ?>
					</td>
            	</tr>
            <?
                    $i++;
				}
	       		mysqli_free_result($QUERY);
			}else{
			?>
				<tr>
					<td height="50" class="tc" colspan="7">등록된 내역이 없습니다.</td>
				</tr>
			<? }?>
			</table>            
      		<?=$BLOCK_LIST?>
		</div>
    </div>
</div>
<!-- Content // -->

<? include "./include/include_bottom.php"; ?>