<?
$MenuType = "G";
$PageName = "contents_flex_keyword";
$ReadPage = "contents_flex_keyword_read";
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
				while (list($key,$value)=each($ContentsFlex_array)){
				    $SQL = "SELECT COUNT(Category) AS CNT FROM ContentsFlexKeyword WHERE Category = $key";
				    //echo $SQL;
				    $QUERY = mysqli_query($connect, $SQL);
				    if($QUERY && mysqli_num_rows($QUERY)){
				        while($ROW = mysqli_fetch_array($QUERY)){
				            extract($ROW);
				?>
				<tr>
					<td><?=$key?></td>
					<td style="text-align:left"><A HREF="Javascript:readRun('<?=$key?>');"><?=$value?></A></td>
					<td><?=$CNT?></td>
				</tr>
				<?
                        }
                        mysqli_free_result($QUERY);
                    }
				}
				?>
			</table>
		</div>
	</div>
</div>

<!-- Footer -->
<? include "./include/include_bottom.php"; ?>