<?
$MenuType = "J";
?>
<? include "./include/include_top.php"; ?>
    <!-- Right -->
    <div class="contentBody">
    	<!-- ########## -->
        <h2>메인 콘텐츠 관리</h2>    
        <div class="conZone">
        	<!-- ## START -->
<?
    $MenuCode = Replace_Check($MenuCode);
    
    $Sql = "SELECT idx, MenuCode , MenuName , RegDate , UseYN , MdfDate , Link FROM MainContents ";
    $Sql .= "WHERE MenuCode = '$MenuCode' ";    
    $Result = mysqli_query($connect, $Sql);
    $Row = mysqli_fetch_array($Result);
    
    if($Row) {
        $idx      = $Row['idx'];
        $MenuCode = $Row['MenuCode'];
        $MenuName = $Row['MenuName'];
        $RegDate  = $Row['RegDate'];
        $UseYN    = $Row['UseYN'];
        $MdfDate  = $Row['MdfDate'];
        $Link     = $Row['Link'];
    }
?>
<SCRIPT LANGUAGE="JavaScript">
	function DelOk() {    
    	if(confirm("해당 글을 삭제하시겠습니까?")){
			location.href="main_contents_script.php?MenuCode=<?=$MenuCode?>&mode=del";
		}else{
			return;
		}
    }
</SCRIPT>
            <div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">상세 정보</span>
			</div>
            <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01 gapT20">
              <colgroup>
                <col width="120px" />
                <col width="" />
				<col width="120px" />
                <col width="" />
              </colgroup>
              <tr>
                <th>콘텐츠분류 이름</th>
                <td><?=$MenuName?></td>
				<th>사용여부</th>
                <td><?if($UseYN == "Y"){?>사용<?}else{?>미사용<?}?></td>
              </tr>
              <tr>
                <th>등록일</th>
                <td><?=$RegDate?></td>
				<th>수정일</th>
                <td><?=$MdfDate?></td>
              </tr>
              <tr>
              	<th>바로가기 링크</th>
              	<td colspan="3"><?=$Link?></td>
              </tr>
            </table>
            <!-- 버튼 -->
			<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="gapT20">
				<tr>
					<td align="left" width="150" valign="top"><input type="button" value="삭 제" onclick="DelOk()" class="btn_inputLine01"></td>
					<td align="center" valign="top"><input type="button" value="수 정" onclick="location.href='main_contents_reg.php?MenuCode=<?=$MenuCode?>&mode=edit'" class="btn_inputBlue01"></td>
					<td align="right" width="150" valign="top"><input type="button" value="목록" onclick="location.href='main_contents_list.php?'" class="btn_inputLine01"></td>
				</tr>
			</table>
			<!-- 버튼 //-->
            
            <div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">콘텐츠 목록</span>
			</div>
			<script type="text/javascript">
    			$(document).ready(function() {
    				// Initialise the table
    				$("#table-1").tableDnD();
    			});
			</script>
			<div class="btnAreaTl02">
				<input type="button" name="Btn" id="Btn" value="정렬하기" class="btn_inputLine01" onclick="MainContentsOrderBy();">&nbsp;&nbsp;&nbsp;[각행을 상하로 드래그하여 정렬하세요.]
          	</div>
            <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
				<colgroup>
                    <col width="40px" />
                    <col width="80px" />
                    <col width="" />
            		<col width="100px" />
            		<col width="200px" />
            		<col width="200px" />
				</colgroup>
				<tr>
                    <th>번호</th>
                    <th>정렬 순서</th>
            		<th>콘텐츠 제목</th>
            		<th>사용 여부</th>
            		<th>등록일</th>
            		<th>수정일</th>
              	</tr>
              </table>
              <form name="OrderByForm" method="POST" action="main_contents_img_script.php" target="ScriptFrame">
				<input type="hidden" name="mode" id="mode" value="OrderByProc">
				<input type="hidden" name="idx_value" id="idx_value">
				<table id="table-1" width="100%" cellpadding="0" cellspacing="0" class="list_ty01">
					<colgroup>
                        <col width="40px" />
                        <col width="80px" />
                        <col width="" />
                		<col width="100px" />
                		<col width="200px" />
                		<col width="200px" />
    				</colgroup>
					<?
					##-- 정렬조건
					if($orderby=="") {
					    $str_orderby = " ORDER BY OrderByNum ASC, idx ASC";
					}else{
					    $str_orderby = " ORDER BY $orderby";
					}
					$SqlA = "SELECT * FROM MainContentsImg ";
					$SqlA .= "WHERE MenuCode = '$MenuCode'  $str_orderby ";					
					$i = 1;
					$QUERY = mysqli_query($connect, $SqlA);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);
					?>
					<tr id="<?=$i?>">
                		<td><?=$i?><input type="hidden" name="contnets_idx" id="contnets_idx" value="<?=$idx?>"></td>
                		<td><?=$OrderByNum?></td>                		
                		<td style="text-align:left"><a href="main_contents_img_read.php?idx=<?=$idx?>" onFocus="blur()"><?=$Title?></a></td>
                		<td><?if($UseYN == "Y"){?>사용<?}else{?>미사용<?}?></td>
                		<td><?=$RegDate?></td>
                		<td><?=$MdfDate?></td>
                  	</tr>
                  	<?
                            $i++;
                        }
					}else{
					?>
					<tr>
						<td height="50" class="tc" colspan="6">등록된 과정이 없습니다.</td>
					</tr>
					<? 
					}
					?>
                </table>
			</form>
            <!-- 버튼 -->
			<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="gapT20">
				<tr>
					<td align="right" width="150" valign="top"><input type="button" value="신규 등록" onclick="location.href='main_contents_img_reg.php?MenuCode=<?=$MenuCode?>&mode=new'" class="btn_inputLine01"></td>
				</tr>
			</table>
			<!-- 버튼 //-->
        	<!-- ## END -->
        </div>
        <!-- ########## // -->
    </div>
    <!-- Right // -->
</div>
<!-- Content // -->

	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>