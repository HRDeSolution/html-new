<?
$MenuType = "G";
?>
<? include "./include/include_top.php"; ?>
<?
$gubun = Replace_Check($gubun); //1:PICK/2:TOP10/3:NEW

$pageName;
while (list($key,$value)=each($ContentsFlex_array2)){
    if($key == $gubun) $pageName = $value;
}

$SQLA = "SELECT COUNT(*) FROM FlexContentsList WHERE Del='N' AND gubun='$gubun'";
$ResultA = mysqli_query($connect, $SQLA);
$RowA = mysqli_fetch_array($ResultA);
$TOT_NO = $RowA[0];
mysqli_free_result($ResultA);
?>
<script type="text/javascript">
$(document).ready(function() {
	$("#LectureCode").select2();
	changeSelect2Style();
});
</script>       
	<div class="contentBody">
		<h2><?=$pageName?> 관리</h2>
		<div class="conZone">
        	<form name="DeleteForm" method="POST" action="flex_contents_script.php" target="ScriptFrame">
				<input type="hidden" name="mode" value="Delete">
				<input type="hidden" name="idx">
				<input type="hidden" name="gubun" value="<?=$gubun?>">
				<input type="hidden" name="LectureCode">
			</form>
			<form name="AddForm" method="POST" action="flex_contents_script.php" target="ScriptFrame">
				<input type="hidden" name="mode" id="mode" value="Add">
				<input type="hidden" name="gubun" value="<?=$gubun?>">
				<table border="0" width="90%">
					<tr>
						<td align="left">
						<select name="LectureCode" id="LectureCode">
							<option value="">번호 | 과정코드 |  과정명</option>
							<?
							$i = 1;
							$SQL = "SELECT * FROM CourseFlex AS a 
                                    WHERE a.Del='N' AND a.UseYN='Y' AND (SELECT COUNT(idx) FROM FlexContentsList WHERE LectureCode=a.LectureCode AND gubun='$gubun') < 1
                                    ORDER BY a.ContentsName ASC";
							$QUERY = mysqli_query($connect, $SQL);
							if($QUERY && mysqli_num_rows($QUERY)){
								while($ROW = mysqli_fetch_array($QUERY)){
							?>
							<option value="<?=$ROW['LectureCode']?>"><?=$i?> | <?=$ROW['LectureCode']?> | <?=$ROW['ContentsName']?></option>
							<?
								    $i++;
								}
							}
							?>
						</select>&nbsp;&nbsp;
						<?if($TOT_NO < 10){?>
						<input type="button" name="Addbtn" value="과정 추가하기" class="btn_inputSm01" onclick="FlexCourseAdd();">
						<?}?>
						</td>
					</tr>
				</table>
			</form>
			
            <!--목록 -->
			<script type="text/javascript">
				$(document).ready(function() {
					// Initialise the table
					$("#table-1").tableDnD();
				});
			</script>
			<div class="btnAreaTl02">
				<input type="button" name="Btn" id="Btn" value="정렬하기" class="btn_inputLine01" onclick="FlexCourseOrderBy();">&nbsp;&nbsp;&nbsp;[각행을 상하로 드래그하여 정렬하세요.]
            </div>
			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
				<colgroup>
                	<col width="40px" />
                    <col width="80px" />
                    <col width="100px" />
					<col width="" />
					<col width="100px" />
					<col width="80px" />
				</colgroup>
                <tr>
                	<th>번호</th>
					<th>정렬순서</th>
					<th>과정 코드</th>
					<th>과&nbsp;&nbsp;정&nbsp;&nbsp;명</th>
					<th>사이트 노출</th>
					<th>삭제</th>
				</tr>
			</table>
			<form name="OrderByForm" method="POST" action="flex_contents_script.php" target="ScriptFrame">
				<input type="hidden" name="mode" id="mode" value="OrderByProc">
				<input type="hidden" name="idx_value" id="idx_value">
				<input type="hidden" name="gubun" id="gubun" value="<?=$gubun?>">
				<table id="table-1" width="100%" cellpadding="0" cellspacing="0" class="list_ty01">
					<colgroup>
                        <col width="40px" />
                        <col width="80px" />
                        <col width="100px" />
    					<col width="" />
    					<col width="100px" />
    					<col width="80px" />
					</colgroup>
					<?
					##-- 검색 조건
					$where = array();

					$where[] = "b.Del='N'";
					$where[] = "a.gubun='$gubun'";
					$where = implode(" AND ",$where);
					if($where) $where = "WHERE $where";

					##-- 정렬조건
					if($orderby=="") {
						$str_orderby = "ORDER BY a.OrderByNum ASC, a.idx ASC";
					}else{
						$str_orderby = "ORDER BY $orderby";
					}

					$SQL = "SELECT a.*, b.ServiceType, b.ContentsName, b.ctype, b.Del, b.UseYN 
                            FROM FlexContentsList AS a 
							LEFT OUTER JOIN CourseFlex AS b ON a.LectureCode=b.LectureCode 
							$where $str_orderby";
					//echo $SQL;
					$i = 1;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY)){
						while($ROW = mysqli_fetch_array($QUERY)){
							extract($ROW);
					?>
                  	<tr id="<?=$i?>">
    					<td><?=$i?><input type="hidden" name="course_idx" id="course_idx" value="<?=$idx?>"></td>
    					<td><?=$OrderByNum?></td>
    					<td><strong><?=$LectureCode?></strong></td>
    					<td align="left"><?=$ContentsName?></td>
    					<td><?=$UseYN_array[$UseYN]?></td>
    					<td><input type="button" name="Deletebtn" value="삭제" class="btn_inputSm01" onclick="FlexCourseDelete('<?=$idx?>','<?=$LectureCode?>');"></td>
					</tr>
                  	<?
                            $i++;
						}
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="7">등록된 과정이 없습니다.</td>
					</tr>
					<? 
					}
					?>
                </table>
			</form>
  		</div>
    </div>
</div>

<? include "./include/include_bottom.php"; ?>


<DIV style='BORDER-RIGHT: #a2a2a2 1px solid; PADDING-RIGHT: 5px; BORDER-TOP: #a2a2a2 1px solid; PADDING-LEFT: 5px; FILTER: alpha(opacity=100); PADDING-BOTTOM: 5px; BORDER-LEFT: #a2a2a2 1px solid; PADDING-TOP: 5px; BORDER-BOTTOM: #a2a2a2 1px solid; POSITION: absolute; BACKGROUND-COLOR: white; left:300px; top: 90px;z-index:100; visibility: hidden;' id='popup'><table border='0' align='center' cellpadding='0' cellspacing='0' onmousedown="select('popup')"><tr><td><img src='/popup/upload_popup/' border='0' name="popupimg"></td></tr><tr><td height='24' align='center' valign='top' bgcolor='707070'><table width='98%'  border='0' cellspacing='0' cellpadding='0'><tr><td align='right'><font color='#EAEAEA'>오늘 하루 창 열지 않기&nbsp;&nbsp;&nbsp;<a href='javascript:CloseLayer()'><img src='./images/close01.gif' border='0' align='absmiddle' ></a></font></td></tr></table></td></tr></table></div>