<?
$MenuType = "F";
$PageName = "lecture_event";
$ReadPage = "lecture_event_read";
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

##-- 검색 등록수
$Sql = "SELECT COUNT(*)
        FROM LectureEvent a
        LEFT JOIN `Member` b ON a.ID = b.ID  $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];

mysqli_free_result($Result);

##-- 페이지 클래스 생성
include_once("./include/include_page.php");

$PAGE_CLASS   = new Page($pg,$TOT_NO,$page_size,$block_size); ##-- 페이지 클래스
$BLOCK_LIST   = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소
?>
    <div class="contentBody">
        <h2>이벤트관리</h2>
        <div class="conZone">
    		<form name="search" method="get">
                <div class="searchPan">
                	<select name="col">
    					<option value="a.ID" <?if($col=="a.ID") { echo "selected";}?>>아이디</option>
    					<option value="b.Name" <?if($col=="b.Name") { echo "selected";}?>>이름</option>
    				</select>
                    <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                    <input type="submit" name="SubmitBtn" id="SubmitBtn" value="검색" class="btn">
                </div>
			</form>
			<div class="btnAreaTr02">
			<?if($AdminWrite=="Y") {?>
				<button type="button" name="ExcelOutBtn" id="ExcelOutBtn" class="btn btn_Green line" onClick="location.href='<?=$PageName?>_excel.php?Gubun=<?=$Gubun?>&col=<?=$col?>&sw=<?=$sw?>'"><i class="fas fa-file-excel"></i> 검색항목 엑셀 출력</button>
			<?}?>
            </div>
            <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
                <colgroup>
                    <col width="80px" />
                    <col width="150px" />
                    <col width="150px" />
                    <col width="150px" />
                    <col width="150px" />
                    <col width="80px" />
                    <col width="80px" />
                </colgroup>
              	<tr>
                    <th>번호</th>
                    <th>아이디</th>
                    <th>이름</th>
                    <th>전화번호</th>
    				<th>스테이지</th>
                    <th>카운트</th>
                    <th>상태</th>
              	</tr>
				<?
				$SQL = "SELECT a.idx, a.ID , a.Stage , a.StageCount , a.Status , b.Name , AES_DECRYPT(UNHEX(b.Mobile ),'$DB_Enc_Key') AS Mobile 
                        FROM LectureEvent a
                        LEFT JOIN `Member` b ON a.ID = b.ID 
                        $where ORDER BY a.RegDate DESC
                        LIMIT $PAGE_CLASS->page_start, $page_size";
				//echo $SQL;
				$QUERY = mysqli_query($connect, $SQL);
				if($QUERY && mysqli_num_rows($QUERY)){
					while($ROW = mysqli_fetch_array($QUERY)){
						extract($ROW);
				?>
              	<tr>
    				<td><?=$PAGE_UNCOUNT--?></td>
    				<td><A HREF="Javascript:readRun('<?=$idx?>');"><?=$ID?></A></td>
    				<td><A HREF="Javascript:readRun('<?=$idx?>');"><?=$Name?></A></td>
    				<td><?=$Mobile?></td>
    				<td><?=$Stage."Days"?></td>
                    <td><?=$StageCount?></td>
                    <td><?=$CounselStatus_array[$Status]?></td>
              	</tr>
              	<?
					}
				    mysqli_free_result($QUERY);
				}else{
				?>
				<tr>
					<td height="50" class="tc" colspan="7">등록된 내용이 없습니다.</td>
				</tr>
				<? 
				}
				?>
            </table>
            
	  		<?=$BLOCK_LIST?>
  		</div>
    </div>
</div>

<!-- Footer -->
<? include "./include/include_bottom.php"; ?>