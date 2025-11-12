<?
$MenuType = "F";
?>
<? include "./include/include_top.php"; ?>
<?
$ctype = Replace_Check($ctype); //메뉴구분 (A: BEST컨텐츠관리 /B: NEW컨텐츠관리)
$gubun = Replace_Check($gubun); //컨텐츠구분 (0:전체 / 1: 국민내일배움카드 /2: 평생교육바우처 /3: 직무스킬업)

$pageName;
if($gubun == 0) $pageName = "전체"; else $pageName = $ContentsCategory1_array[$gubun];

if($ctype == "A"){
    $menuName = "BEST";
    $table = "BestContentsList";
}else{
    $menuName = "NEW";
    $table = "NewContentsList";
}

$SQLA = "SELECT COUNT(*)
        FROM $table AS a
		LEFT OUTER JOIN CourseCyber AS b ON a.LectureCode=b.LectureCode
        WHERE b.PackageYN='N' AND b.Del='N' AND gubun='$gubun'";
$ResultA = mysqli_query($connect, $SQLA);
$RowA = mysqli_fetch_array($ResultA);
$TOT_NO = $RowA[0];
mysqli_free_result($ResultA);
?>
<script type="text/javascript">
<!--
$(document).ready(function() {
	$("#LectureCode").select2();
	changeSelect2Style();
});
//-->
</script>       
	<div class="contentBody">
		<h2><?=$menuName?> 컨텐츠 관리 - <?=$pageName?></h2>
		<div class="conZone">
        	<form name="DeleteForm" method="POST" action="cyber_contents_script.php" target="ScriptFrame">
				<input type="hidden" name="mode" value="Delete">
				<input type="hidden" name="idx">
				<input type="hidden" name="ctype" value="<?=$ctype?>">
				<input type="hidden" name="gubun" value="<?=$gubun?>">
				<input type="hidden" name="LectureCode">
			</form>
			<form name="AddForm" method="POST" action="cyber_contents_script.php" target="ScriptFrame">
				<input type="hidden" name="mode" id="mode" value="Add">
				<input type="hidden" name="ctype" value="<?=$ctype?>">
				<input type="hidden" name="gubun" value="<?=$gubun?>">
				<table border="0" width="90%">
					<tr>
						<td align="left">
						<select name="LectureCode" id="LectureCode">
							<option value="">번호 | 과정코드 | 서비스 구분 | 과정명</option>
							<?
							$i = 1;
							$SQL = "SELECT * FROM CourseCyber AS a 
                                    WHERE a.PackageYN='N' AND a.Del='N' AND a.UseYN='Y' AND (SELECT COUNT(idx) FROM $table WHERE LectureCode=a.LectureCode AND gubun='$gubun') < 1
                                    ORDER BY a.ContentsName ASC";
							$QUERY = mysqli_query($connect, $SQL);
							if($QUERY && mysqli_num_rows($QUERY)){
								while($ROW = mysqli_fetch_array($QUERY)){
									if($ROW['ctype'] == "A") {
										$ServiceType2 = $ServiceTypeCourse_array[$ROW['ServiceType']];
									}
									if($ROW['ctype'] == "B") {
										$ServiceType2 = $ServiceTypeCourse2_array[$ROW['ServiceType']];
									}
							?>
							<option value="<?=$ROW['LectureCode']?>"><?=$i?> | <?=$ROW['LectureCode']?> | <?=$ServiceType2?> | <?=$ROW['ContentsName']?></option>
							<?
								    $i++;
								}
							}
							?>
						</select>&nbsp;&nbsp;
						<?if($gubun == 0){
						    if($TOT_NO < 4){
						?>
						<input type="button" name="Addbtn" value="과정 추가하기" class="btn_inputSm01" onclick="MainCourseAdd();">
						<?        
						    }
						}else{
						    if($TOT_NO < 10){
						?>
						<input type="button" name="Addbtn" value="과정 추가하기" class="btn_inputSm01" onclick="MainCourseAdd();">
						<?
						    }
						}?>
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
				<input type="button" name="Btn" id="Btn" value="정렬하기" class="btn_inputLine01" onclick="MainCourseOrderBy();">&nbsp;&nbsp;&nbsp;[각행을 상하로 드래그하여 정렬하세요.]
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
			<form name="OrderByForm" method="POST" action="cyber_contents_script.php" target="ScriptFrame">
				<input type="hidden" name="mode" id="mode" value="OrderByProc">
				<input type="hidden" name="idx_value" id="idx_value">
				<input type="hidden" name="ctype" id="ctype" value="<?=$ctype?>">
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

					$where[] = "b.PackageYN='N'";
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
                            FROM $table AS a 
							LEFT OUTER JOIN CourseCyber AS b ON a.LectureCode=b.LectureCode 
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
    					<td><input type="button" name="Deletebtn" value="삭제" class="btn_inputSm01" onclick="MainCourseDelete('<?=$idx?>','<?=$LectureCode?>');"></td>
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