<?
include $_SERVER['DOCUMENT_ROOT'] . "/include/include_function.php"; //DB연결 및 각종 함수 정의

$idx = Replace_Check_XSS2($idx);
$mode = Replace_Check_XSS2($mode);

if($LoginMemberID) {
    
    if($mode=="Regist") {
        $Sql = "INSERT INTO StudyPDS_Scrap(idx, ID, RegDate) VALUES($idx, '$LoginMemberID', NOW())";
        $Row = mysqli_query($connect, $Sql);
    }
    
    if($mode=="Delete") {
        $Sql = "DELETE FROM StudyPDS_Scrap WHERE idx=$idx AND ID='$LoginMemberID'";
        $Row = mysqli_query($connect, $Sql);
    }
    
}
?>
 <!-- layer -->
 <div class="layerArea">
	<div id="modal01" class="modal-wrap complete_popup">
		<div class="close-btn">
			<a href="Javascript:DataResultCloseReload();">
				<i class="ph-thin ph-x"></i>
			</a>
		</div>
		<div class="complete_inner">
			<i class="ph-fill ph-check-circle"></i>
			<strong><?if($mode=="Regist") {?>학습자료 찜하기<?}else{?>학습자료 찜 취소하기<?}?></strong>
			<?if($mode=="Regist") {?>
			<p class="fc777">학습자료 찜하기가 완료되었습니니다.<br>
			온라인 학습실 &gt; 자료/상담관리에서 확인하실 수 있습니다.</p>
			<?}else{?>
				<p>학습자료 찜 취소하기가 완료되었습니다.</p>
			<?}?>
			<div class="btn"><a class="close-btn2" href="Javascript:DataResultCloseReload();">확인</a></p>
	</div>
</div>
 <!-- layer // -->