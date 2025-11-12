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
    $idxA = Replace_Check($idx);
    
    $Sql = "SELECT idx, MenuCode , Title , Image , Link , RegDate , UseYN , MdfDate FROM MainContentsImg ";
    $Sql .= "WHERE idx = '$idxA' ";
    $Result = mysqli_query($connect, $Sql);
    $Row = mysqli_fetch_array($Result);
    
    if($Row) {
        $idx      = $Row['idx'];
        $MenuCode = $Row['MenuCode'];
        $Title    = $Row['Title'];
        $Image    = html_quote($Row['Image']);
        $Link     = $Row['Link'];
        $RegDate  = $Row['RegDate'];
        $UseYN    = $Row['UseYN'];
        $MdfDate  = $Row['MdfDate'];
    }
    
    if($Image) {
        $ImageView = "<img src='/upload/MainContents/".$Image."' width='100' align='absmiddle'>";
    }
?>
<SCRIPT LANGUAGE="JavaScript">
	function DelOk() {    
    	if(confirm("해당 글을 삭제하시겠습니까?")){
			location.href="main_contents_img_script.php?idx=<?=$idx?>&MenuCode=<?=$MenuCode?>&mode=del";
		}else{
			return;
		}
    }
</SCRIPT>
            <div class="btnAreaTl02">
				<span class="fs16b fc333B"><img src="images/sub_title2.gif" align="absmiddle">이미지 상세 정보</span>
			</div>
            <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01 gapT20">
				<colgroup>
                    <col width="120px" />
                    <col width="" />
                    <col width="120px" />
                    <col width="" />
				</colgroup>
				<tr>
                  	<th>사용여부</th>
                    <td colspan="3"><?if($UseYN == "Y"){?>사용<?}else{?>미사용<?}?></td>
				</tr>
				<tr>				
                    <th>사진제목</th>
                    <td colspan="3"><?=$Title?></td>				
				</tr>
				<tr>
                  	<th>사진</th>
                    <td align="left" colspan="3"><?=$ImageView?></td>
				</tr>
				<tr>
                    <th>링크</th>
                    <td colspan="3"><?=$Link?></td>
				</tr>
				<tr>
                    <th>등록일</th>
                    <td><?=$RegDate?></td>
                    <th>수정일</th>
                    <td><?=$MdfDate?></td>
				</tr>
            </table>
            <!-- 버튼 -->
			<table width="100%"  border="0" cellspacing="0" cellpadding="0" class="gapT20">
				<tr>
					<td align="left" width="150" valign="top"><input type="button" value="삭 제" onclick="DelOk()" class="btn_inputBlue01"></td>
					<td align="center" valign="top"><input type="button" value="수 정" onclick="location.href='main_contents_img_reg.php?idx=<?=$idx?>&MenuCode=<?=$MenuCode?>&mode=edit'" class="btn_inputBlue01"></td>
					<td align="right" width="150" valign="top"><input type="button" value="목록" onclick="location.href='main_contents_read.php?MenuCode=<?=$MenuCode?>'" class="btn_inputLine01"></td>
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