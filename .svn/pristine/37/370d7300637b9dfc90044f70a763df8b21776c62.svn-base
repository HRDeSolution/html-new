<?
include "../include/include_function.php";
include "./include/include_admin_check.php";
?>
<div class="Content">
	<div class="contentBody">
		<h2>차시 정보 가져오기</h2>
		<div class="conZone">
			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>&nbsp;</td>
					<td height="15">&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="100" valign="top">&nbsp;</td>
					<td align="center" valign="top">&nbsp;</td>
					<td width="100" align="right" valign="top"><input type="button" value="닫기" onclick="DataResultClose();" class="btn_inputLine01"></td>
				</tr>
			</table>
			<div id="CourseList" style="left:0px; top:10px; width:100%; height:800px; z-index:1; overflow: auto; overflow-x:hidden;">
    			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
    				<colgroup>
        				<col width="60px" />
        				<col width="" />
        				<col width="80px" />
        				<col width="140px" />
        				<col width="140px" />
        				<col width="60px" />
    			  	</colgroup>
                  	<tr>
        				<th>번호</th>
        				<th>과정명</th>
        				<th>교육시간</th>
        				<th>컨텐츠URL</th>
        				<th>모바일URL</th>
        				<th>선택</th>
                  	</tr>
    				<?
        			$i = 1;
        			$SQL = "SELECT a.idx , a.ContentsTitle , a.LectureTime , b.ContentsURL , b.MobileURL 
                            FROM Contents a
                            LEFT JOIN ContentsDetail b ON a.idx = b.Contents_idx
                            WHERE a.Del = 'N'
                            ORDER BY a.ContentsTitle ";
        			$QUERY = mysqli_query($connect, $SQL);
        			if($QUERY && mysqli_num_rows($QUERY)){
        				while($ROW = mysqli_fetch_array($QUERY)){
        					extract($ROW);
        			?>
        			<tr>
        				<td align="center"  class="text01"><?=$i?></td>
        				<td align="left"><span class="sm"><?=$ContentsTitle?></td>
        				<td align="center" class="text01"><?=$LectureTime?> 시간</td>
        				<td align="left"><span class="sm"><?=$ContentsURL?></td>
        				<td align="left"><span class="sm"><?=$MobileURL?></td>
        				<td align="center" class="text01"><a href="Javascript:CourseFlexCopyApply('<?=$idx?>');"><img src="images/btn_select.gif"></a></td>
                      </tr>
        			<?
        			      $i++;
        				}
        			}else{
        			?>
        			<tr>
        				<td height="50" colspan="20" class="tc">등록된 단과 컨텐츠가 없습니다.</td>
        			</tr>
        			<? } ?>
                </table>
			</div>

			<table width="100%"  border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>&nbsp;</td>
					<td height="15">&nbsp;</td>
					<td>&nbsp;</td>
				</tr>
				<tr>
					<td width="100" valign="top">&nbsp;</td>
					<td align="center" valign="top">&nbsp;</td>
					<td width="100" align="right" valign="top"><input type="button" value="닫기" onclick="DataResultClose();" class="btn_inputLine01"></td>
				</tr>
			</table>
			<form name="CourseFlexCopyForm" action="course_flex_copy_apply.php" target="ScriptFrame">
				<input type="hidden" name="idx" id="idx">
			</form>
		</div>
	</div>
</div>
<?
mysqli_close($connect);
?>