<?
$MenuType = "G";
?>
<? include "./include/include_top.php"; ?>
<div class="contentBody">
	<h2>PICK/TOP/NEW 컨텐츠 관리</h2>
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
                    <th>컨텐츠 개수</th>
				</tr>
				<? 
				while (list($key,$value)=each($ContentsFlex_array2)){
				    $SQL = "SELECT COUNT(*) AS CNT FROM FlexContentsList WHERE gubun = $key";
				    //echo $SQL;
				    $QUERY = mysqli_query($connect, $SQL);
				    if($QUERY && mysqli_num_rows($QUERY)){
				        while($ROW = mysqli_fetch_array($QUERY)){
				            extract($ROW);
				?>
				<tr>
					<td><?=$key?></td>
					<td style="text-align:left"><A HREF="/hrd_manager/flex_contents_list.php?gubun=<?=$key?>"><?=$value?></A></td>
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