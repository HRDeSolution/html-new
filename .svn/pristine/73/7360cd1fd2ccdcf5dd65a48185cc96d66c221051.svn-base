<?
$MenuType = "F";
$PageName = "contents_keyword";
$ReadPage = "contents_keyword_read";
?>
<? include "./include/include_top.php"; ?>
<div class="contentBody">
	<h2>컨텐츠 키워드 관리</h2>
		<div class="conZone">            
        	<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
				<colgroup>
                	<col width="80px" />
                    <col width="" />
                    <col width="150px" />
				</colgroup>
				<tr>
					<th>번호</th>
                    <th>과정분류</th>
                    <th>키워드개수</th>
				</tr>
				<?
				$SQLA =  "SELECT COUNT(*) FROM ContentsKeyword WHERE Category = 0 AND Del = 'N' ";
				$ResultA = mysqli_query($connect, $SQLA);
				$RowA = mysqli_fetch_array($ResultA);
				$TOT_NO = $RowA[0];
				mysqli_free_result($ResultA);
				?>
				<tr>
					<td>1</td>
					<td style="text-align:left"><A HREF="Javascript:readRun('0');">전체</A></td>
					<td><?=$TOT_NO?></td>
				</tr>
				<? 
				while (list($key,$value)=each($ContentsCategory1_array)){
				    $SQL = "SELECT COUNT(Category) AS CNT FROM ContentsKeyword WHERE Category = $key";
				    //echo $SQL;
				    $QUERY = mysqli_query($connect, $SQL);
				    if($QUERY && mysqli_num_rows($QUERY)){
				        while($ROW = mysqli_fetch_array($QUERY)){
				            extract($ROW);
				?>
				<tr>
					<td><?=$key+1?></td>
					<td style="text-align:left"><A HREF="Javascript:readRun('<?=$key?>');"><?=$value?></A></td>
					<td><?=$CNT?></td>
				</tr>
				<?
                        }
                        mysqli_free_result($QUERY);
                    }else{
				?>
				<tr>
					<td height="50" class="tc" colspan="3">등록된 컨텐츠 키워드가 없습니다.</td>
				</tr>
				<? 
					}
				}
				?>
			</table>
		</div>
	</div>
</div>

<!-- Footer -->
<? include "./include/include_bottom.php"; ?>