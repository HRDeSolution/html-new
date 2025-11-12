<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$CompanyName = Replace_Check($CompanyName); //사업주명
$LectureStartA = Replace_Check($LectureStart); //수강기간 시작일자
$LectureEndA = Replace_Check($LectureEnd); //수강기간 종료일자
$ServiceType = Replace_Check($ServiceType); //환급여부
$pg = Replace_Check($pg); //페이지

##-- 페이지 조건
if(!$pg) $pg = 1;
$page_size = 10;
$block_size = 10;

##-- 검색 조건
$where = array();

if($CompanyName) {
    $where[] = "b.CompanyName LIKE '%".$CompanyName."%'";
}
if($LectureStartA) {
    $where[] = "a.LectureStart='".$LectureStartA."'";
}
if($LectureEndA) {
    $where[] = "a.LectureEnd='".$LectureEndA."'";
}
if($ServiceType) {
    $where[] = "a.ServiceType=".$ServiceType;
}else{
    $where[] = "a.ServiceType IN (1,3,5)";
}

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

$str_orderby = "ORDER BY a.LectureStart ASC, a.LectureEnd ASC";

$Colume = "DISTINCT a.LectureStart, a.LectureEnd ";

$JoinQuery = " Study AS a
			LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode ";

$JoinQuery2 = " Study AS a
				LEFT OUTER JOIN Company AS b ON a.CompanyCode=b.CompanyCode
				LEFT OUTER JOIN PaymentSheet AS c ON a.CompanyCode=c.CompanyCode AND a.LectureStart=c.LectureStart AND a.LectureEnd=c.LectureEnd
                LEFT OUTER JOIN Course d ON a.LectureCode = d.LectureCode  ";

$Sql2 = "SELECT COUNT(DISTINCT a.LectureStart, a.LectureEnd) FROM $JoinQuery $where";
$Result2 = mysqli_query($connect, $Sql2);
$Row2 = mysqli_fetch_array($Result2);
$TOT_NO = $Row2[0];
//echo $TOT_NO."<br>";

##-- 페이지 클래스 생성
$PageFun = "StudyPaymentSearch"; //페이지 호출을 위한 자바스크립트 함수

include_once("./include/include_page2.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size,$PageFun); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소
?>
<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
	<tr>
		<th>번호</th>
		<th>수강기간</th>
		<th>과정명</th>
		<th>수강인원</th>		
		<th width="10%">교육비</th>
		<th width="10%">납부액</th>
		<th width="10%">입금액</th>
	</tr>
	<?
	$k = 0;
	$SQL = "SELECT $Colume FROM $JoinQuery $where $str_orderby LIMIT $PAGE_CLASS->page_start, $page_size";
	//echo $SQL."<br><br>";
	$QUERY = mysqli_query($connect, $SQL);
	if($QUERY && mysqli_num_rows($QUERY)){
		while($ROW = mysqli_fetch_array($QUERY)){
			extract($ROW);	
			//첨삭완료일
			$Tutor_limit_day = strtotime("$LectureEnd +4 days");
	?>
	<tr>
		<td  height="28"><?=$PAGE_UNCOUNT--?></td>
		<td ><strong><?=$LectureStart?> ~ <?=$LectureEnd?></strong></td>
		<td  colspan="5">&nbsp;</td>
	</tr>
	<?
    		$SQL2 = "SELECT DISTINCT(a.CompanyCode), b.CompanyName, c.BankPrice, c.CardPrice, c.PayStatus, c.PaymentRemark, c.PayMethod, c.MOID, c.PayDate, c.CancelDate,  d.ContentsName ,
    					(SELECT SUM(Price) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND LectureCode=a.LectureCode AND ServiceType IN (1,3,5)) AS TotalPrice, 
    					(SELECT SUM(rPrice) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND LectureCode=a.LectureCode AND ServiceType IN (1,3,5)) AS TotalRPrice, 
    					(SELECT SUM(rPrice2) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND LectureCode=a.LectureCode AND ServiceType=1) AS rPrice2Sum, 
    					(SELECT SUM(Price) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND LectureCode=a.LectureCode AND ServiceType=1) AS TotalPrice2, 
    					(SELECT SUM(rPrice) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND LectureCode=a.LectureCode AND ServiceType=1) AS TotalRPrice2, 
    					(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND LectureCode=a.LectureCode AND ServiceType=1) AS StudyCount, 
    					(SELECT COUNT(*) FROM Study WHERE LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND CompanyCode=a.CompanyCode AND LectureCode=a.LectureCode AND ServiceType IN (3,5)) AS StudyBeCount 
    				FROM $JoinQuery2
                    $where AND a.LectureStart = '$LectureStart' AND a.LectureEnd = '$LectureEnd'
                    ORDER BY b.CompanyName ASC";
    		//echo $SQL2."<br><br>";
    		$QUERY2 = mysqli_query($connect, $SQL2);
    		if($QUERY2 && mysqli_num_rows($QUERY2)){
    			while($ROW2 = mysqli_fetch_array($QUERY2)){
    			    $CompanyCode = $ROW2['CompanyCode'];
    			    $ContentsName = $ROW2['ContentsName']; //과정명
    			    $StudyCount = $ROW2['StudyCount']; //수강인원-환급
    			    $StudyBeCount = $ROW2['StudyBeCount']; //수강인원-비환급
    			    $TotalPrice = $ROW2['TotalPrice']; //교육비    			    
    			    $PaymentRemark = $ROW2['PaymentRemark'];    
    			    $PayStatus = $ROW2['PayStatus']; //상태(N:대기/R:결제요청/S:결제대기/Y:결제완료)
    			    
    			    $NameChk1 = strpos($ContentsName, '_기업직업훈련');
    			    $NameChk2 = strpos($ContentsName, '_기업직업훈련카드');
    			    
    			    //기업직업훈련일 경우
    			    if($NameChk1 || $NameChk2){
    			        $TotalPrice2 = 0; //납부액
    			        $TotalPrice3 = $TotalPrice; //입금액
    			        
    			    //일반사업주훈련일 경우
    			    }else{
    			        $TotalPrice2 = $TotalPrice; //납부액
    			        $TotalPrice3 = $TotalPrice - ($TotalPrice*0.1); //입금액    
    			    }
	?>
	<tr>
		<td >&nbsp;</td>
		<td ><a href="Javascript:CompanyInfo('<?=$CompanyCode?>');"><?=$ROW2['CompanyName']?><br><br><?=$CompanyCode?></a></td>
		<td><?=$ContentsName?></td>
		<td >환급 : <?=$StudyCount?><br />비환급 : <?=$StudyBeCount?></td>
		<td ><?=number_format($TotalPrice,0)?></td>
		<td ><?=number_format($TotalPrice2,0)?></td>
		<td ><?=number_format($TotalPrice3,0)?></td>
		<!-- 
		  금액저장및메모기능 제외시킨 이유
		  : 사업주훈련에서는 별도로 결제데이터를 갖고있지않음.(결제시스템이 존재하지 않음.)
		    금액저장및메모기능을 사용하려면 결제데이터가 있어야하나 해당 데이터가 없어서 사용이 불가능함.
		  20240529.YEON.[담당자:김지혜주임]
		 -->
		<!-- 
		<td >
		<? if($PayStatus=='' || $PayStatus=='N') { //결제관련 등록된 사항이 없거나 금액만 저장한 경우 ?>
    		<p><button type="button" name="Btn" id="Btn" class="btn round btn_LBlue line" style="padding: 6px 10px 5px;" onclick="PaymentSave(<?=$k?>,'<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyCode?>')">금액 저장</button></p>
    		<p><button type="button" name="Btn" id="Btn" class="btn round btn_LBlue line" style="padding: 6px 10px 5px;" onclick="PayStatusSave(<?=$k?>,'<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyCode?>')">결제 요청</button></p>
    		<p><button type="button" name="Btn" id="Btn" class="btn round btn_LBlue line" style="padding: 6px 10px 5px;" onclick="PayStatusComplete(<?=$k?>,'<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyCode?>')">결제 완료</button></p>
		<?}?>
		<?if($PayStatus=='R') { //결제요청시?>
    		<span class='fcOrg01B'>[결제 요청중]</span><br>
    		<button type="button" name="Btn" id="Btn" class="btn round btn_LBlue line" style="padding: 6px 10px 5px;" onclick="PayStatusCancelSave(<?=$k?>,'<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyCode?>')">결제 요청 취소</button>
		<?}?>
		<?if($PayStatus=='Y') { //결제완료시?>
			<span class='fcOrg01B'>결제일 : <?=$PayDate?></span><br><span class='fcOrg01B'>주문번호 : <?=$MOID?></span>
		<?}?>
		</td>
		<td >
		<?if($PayStatus=='Y'){?>
    		<p>
    			<button type="button" name="Btn" id="Btn" class="btn round btn_LBlue line" style="padding: 6px 10px 5px; width:100px" onclick="PaymentCancelSave(<?=$k?>,'<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyCode?>')">결제 취소(환불)</button>
    			&nbsp;&nbsp;&nbsp;&nbsp;취소(환불) 사유를 저장후 취소 처리하세요.
    		</p>
    		<p>
    			<textarea name="PaymentRemark" id="PaymentRemark" style="width:260px; height:60px"><?=$PaymentRemark?></textarea>
    			<button type="button" name="Btn" id="Btn" class="btn btn_LBlue" style="height:60px" onclick="PaymentRemarkSave(<?=$k?>,'<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyCode?>')">메모저장</button>
    		</p>
		<?}else{?>
    		<textarea name="PaymentRemark" id="PaymentRemark" style="width:260px; height:60px"><?=$PaymentRemark?></textarea>
    		<button type="button" name="Btn" id="Btn" class="btn btn_LBlue" style="height:60px" onclick="PaymentRemarkSave(<?=$k?>,'<?=$LectureStart?>','<?=$LectureEnd?>','<?=$CompanyCode?>')">메모저장</button>
		<?}?>
		</td>
		-->
	</tr>
	<?
				    $k++;
                }
            }
        }
    }else{
	?>
	<tr><td height="28"  colspan="7">검색된 내용이 없습니다.</td></tr>
	<? } ?>
</table>

<!--페이지 버튼-->
<table width="100%"  border="0" cellspacing="0" cellpadding="0" style="margin-top:15px;">
  <tr><td align="center" valign="top"><?=$BLOCK_LIST?></td></tr>
</table>
<!--//페이지 버튼-->
<?
mysqli_close($connect);
?>