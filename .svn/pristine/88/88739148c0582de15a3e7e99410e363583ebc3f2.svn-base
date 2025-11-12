<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$ID = Replace_Check($ID);
$idx = Replace_Check($idx);

$Sql = "SELECT * FROM LectureCancel WHERE ID = '$ID' AND requestIdx = $idx";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
    $BankName = $Row['BankName']; //은행명
    $BankNumber = $Row['BankNumber']; //은행계좌번호
    $AcountName = $Row['AcountName']; //예금주
    $RefundType = $Row['RefundType']; //환불사유유형
    $RefundContents = nl2br(stripslashes($Row['RefundContents'])); //환불사유내용
    $Price = $Row['Price']; //판매가
    $SubPrice = $Row['SubPrice']; //정부지원금
    $PointPrice = $Row['PointPrice']; //학습포인트
    $CouponPrice = $Row['CouponPrice']; //쿠폰
    $RealPrice = $Row['RealPrice']; //자비부담금(환불금액)
    $RegDate = $Row['RegDate']; //결제취소일
}
//추가할인 금액
$SaleTotal = $PointPrice+$CouponPrice;
?>
<div class="Content">
	<div class="contentBody">
        <h2>환불 정보</h2>            
		<div class="conZone">
			<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
				<colgroup>
    				<col width="30%" />
    				<col width="70%" />
			  	</colgroup>
				<tr>
    				<th>은행명</th>
    				<td><?=$BankName?></td>
				</tr>
				<tr>
    				<th>계좌번호</th>
    				<td><?=$BankNumber?></td>
				</tr>
				<tr>
    				<th>예금주</th>
    				<td><?=$AcountName?></td>
				</tr>
				<tr>
    				<th>환불사유</th>
    				<td><?=$Cancel_array[$RefundType]?></td>
				</tr>
				<tr>
    				<th>환불사유내용</th>
    				<td><?=$RefundContents?></td>
				</tr>
				<tr>
    				<th>환불금액</th>
    				<td><?=number_format($RealPrice,0)?>원 (총판매금액 : <?=number_format($Price,0)?>원 / 정부지원금 : <?=number_format($SubPrice,0)?>원 / 추가할인 : <?=number_format($SaleTotal,0)?>원)</td>
				</tr>
			</table>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
				<tr>
					<td align="left" width="200">&nbsp;</td>
					<td align="center"> </td>
					<td width="200" align="right"><button type="button" onclick="DataResultClose();" class="btn btn_DGray line">닫기</button></td>
				</tr>
			</table>
    	</div>
	</div>
</div>
<?
mysqli_close($connect);
?>