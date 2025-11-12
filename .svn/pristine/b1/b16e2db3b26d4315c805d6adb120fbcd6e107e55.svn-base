<?
$MenuType = "F";
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
    				if($key == 0){
    				    echo "전체";
    				}else{
    				    echo $ContentsCategory1_array[$key];
    				}
    				?>    				
    				</td>
    			</tr>
            </table>
    		<br><br>
    		
    		<script type="text/javascript">
				$(document).ready(function() {
					// Initialise the table
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
				</colgroup>
				<tr>
					<th>번호</th>
					<th>정렬순서</th>
                    <th>키워드</th>
                    <th>사이트노출</th>
                    <th>등록일자</th>
                    <th>수정일자</th>
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
				<?
				if($AdminWrite == "Y"){				
    				if($key == 0){
    				    if($TOT_NO < 15){
				?>
				<input type="button" name="Btn" id="Btn" value="추가 하기" class="btn_inputBlue01" onclick="Javascript:KeywordPop('<?=$key?>', '0', 'new');">
				<?        
    				    }
    				}else{
    				    if($TOT_NO < 14){
				?>
				<input type="button" name="Btn" id="Btn" value="추가 하기" class="btn_inputBlue01" onclick="Javascript:KeywordPop('<?=$key?>', '0', 'new');">
				<?
				        }
				    }
				}
				?>
          	</div>
        </div>
    </div>
</div>
<!-- Footer -->
<? include "./include/include_bottom.php"; ?>