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
            <!--목록 -->
            <?
            $Sql = "SELECT COUNT(idx) FROM MainContents WHERE UseYN = 'Y' ";
            $Result = mysqli_query($connect, $Sql);
            $Row = mysqli_fetch_array($Result);
            $Tot_No = $Row[0];
            
            if($Tot_No == 2 || $Tot_No == 1 || $Tot_No == 0){
            ?>
            <div class="btnAreaTr02">
        		<input type="button" name="Btn" id="Btn" value="신규 등록" class="btn_inputBlue01" onclick="location.href='main_contents_reg.php?mode=new'">
        	</div>
            <?
            }else{
            ?>
            <span>메인 콘텐츠는 최대 3개를 올릴 수 있습니다. 메뉴의 사용여부 확인 부탁드립니다.</span>
            <?
            }
            ?>
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
            		<th>메뉴 이름</th>
            		<th>사용여부</th>
            		<th>등록일</th>
            		<th>수정일</th>
              	</tr>
			</table>
			<form name="OrderByForm" method="POST" action="main_contents_script.php" target="ScriptFrame">
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
					    $str_orderby = "ORDER BY OrderByNum ASC, idx ASC";
					}else{
					    $str_orderby = "ORDER BY $orderby";
					}
					$SQL = "SELECT * FROM MainContents $str_orderby ";
					$i = 1;
					$QUERY = mysqli_query($connect, $SQL);
					if($QUERY && mysqli_num_rows($QUERY))
					{
						while($ROW = mysqli_fetch_array($QUERY))
						{
							extract($ROW);
					?>
					<tr id="<?=$i?>">
                		<td><?=$i?><input type="hidden" name="contnets_idx" id="contnets_idx" value="<?=$idx?>"></td>
                		<td><?=$OrderByNum?></td>                		
                		<td style="text-align:left"><a href="main_contents_read.php?MenuCode=<?=$MenuCode?>" onFocus="blur()"><?=$MenuName?></a></td>
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
            <!-- ## END -->
        </div>
        <!-- ########## // -->
    </div>
    <!-- Right // -->
</div>
<!-- Content // -->

<!-- Footer -->
<? include "./include/include_bottom.php"; ?>


<DIV style='BORDER-RIGHT: #a2a2a2 1px solid; PADDING-RIGHT: 5px; BORDER-TOP: #a2a2a2 1px solid; PADDING-LEFT: 5px; FILTER: alpha(opacity=100); PADDING-BOTTOM: 5px; BORDER-LEFT: #a2a2a2 1px solid; PADDING-TOP: 5px; BORDER-BOTTOM: #a2a2a2 1px solid; POSITION: absolute; BACKGROUND-COLOR: white; left:300px; top: 90px;z-index:100; visibility: hidden;' id='popup'><table border='0' align='center' cellpadding='0' cellspacing='0' onmousedown="select('popup')"><tr><td><img src='/popup/upload_popup/' border='0' name="popupimg"></td></tr><tr><td height='24' align='center' valign='top' bgcolor='707070'><table width='98%'  border='0' cellspacing='0' cellpadding='0'><tr><td align='right'><font color='#EAEAEA'>오늘 하루 창 열지 않기&nbsp;&nbsp;&nbsp;<a href='javascript:CloseLayer()'><img src='./images/close01.gif' border='0' align='absmiddle' ></a></font></td></tr></table></td></tr></table></div>