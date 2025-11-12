<?
$MenuType = "B";
$PageName = "negative_training";
$ReadPage = "negative_training_read";
?>
<? include "./include/include_top.php"; ?>
<?
$idx = Replace_Check($idx);
?>
        <!-- Right -->
        <div class="contentBody">
        	<!-- ########## -->
            <h2>리포트 부정훈련</h2>

            <div class="conZone">
            	<!-- ## START -->
<?

$Sql    = "SELECT  a.idx, a.Content, a.CompanyCode, b.CompanyName, a.RegDate FROM NegativeTraining a LEFT OUTER JOIN Company AS b ON a.CompanyCode = b.CompanyCode WHERE a.idx = $idx";
$Result = mysqli_query($connect, $Sql);
$Row    = mysqli_fetch_array($Result);

if($Row) {
    $CompanyName = $Row['CompanyName'];
    $CompanyCode = $Row['CompanyCode'];
	// $Content     = stripslashes($Row['Content']);
    $Content     = $Row['Content'];
	$RegDate     = $Row['RegDate'];
}
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
function DelOk() {

	del_confirm = confirm("현재 글을 삭제하시겠습니까?");
	if(del_confirm==true) {
		DeleteForm.submit();
	}
}

//-->
</SCRIPT>
                <!-- 입력 -->
				<form name="DeleteForm" method="post" action="negative_training_script.php" target="ScriptFrame">
					<INPUT TYPE="hidden" name="mode" value="del">
					<INPUT TYPE="hidden" name="idx" value="<?=$idx?>">
				</form>
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
				  <tr>
                    <th>사업주 명</th>
                    <td><?=$CompanyName?></td>
                  </tr>
				  <tr>
                    <th>사업주 ID</th>
                    <td><?=$CompanyCode?></td>
                  </tr>
				  <tr>
                    <th>등록일</th>
                    <td><?=$RegDate?></td>
                  </tr>
				  <tr>
                    <th>내용</th>
                    <td>
					<table border="0" width="970px">
						<tr>
							<td style="border:0px"><?=$Content?></td>
						</tr>
					</table>
					</td>
                  </tr>
                </table>
                <!-- 버튼 -->
				<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="gapT20">
					<tr>
						<td align="left" width="150" valign="top"><input type="button" value="삭 제" onclick="DelOk()" class="btn_inputLine01"></td>
						<td align="center" valign="top">
						<input type="button" value="정보 수정" onclick="location.href='<?=$PageName?>_write.php?mode=edit&idx=<?=$idx?>&col=<?=$col?>&sw=<?=urlencode($sw)?>'" class="btn_inputBlue01"></td>
						<td width="150" align="right" valign="top"><input type="button" value="목록" onclick="location.href='<?=$PageName?>.php?pg=<?=$pg?>&sw=<?=urlencode($sw)?>&col=<?=$col?>'" class="btn_inputLine01"></td>
					</tr>
				</table>
                
            	<!-- ## END -->
            </div>
            <!-- ########## // -->
        </div>
    	<!-- Right // -->
    </div>
    <!-- Content // -->

	<!-- Footer -->
<? include "./include/include_bottom.php"; ?>