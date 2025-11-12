<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$ID = Replace_Check($ID);
$idx = Replace_Check($idx);

$Sql = "SELECT a.*, b.Name, AES_DECRYPT(UNHEX(b.Mobile),'$DB_Enc_Key') AS Mobile
		FROM LectureRequest2 AS a
		LEFT OUTER JOIN Member AS b ON a.ID=b.ID
        WHERE a.ID = '$ID' AND a.idx = $idx AND a.Del = 'N'";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
if($Row) {
	$ID = $Row['ID']; //아이디
	$Name = $Row['Name']; //이름
	$Mobile = $Row['Mobile']; //휴대폰
	$paymentId = $Row['paymentId']; //주문고유번호
	$ApplyType = $Row['ApplyType']; //신청유형(A:국민내일배움카드(재직자),B:일반(수시),C:고용보험환급,D:평생교육바우처)
	$SupportType = $Row['SupportType']; //지원유형
	$LectureCode = $Row['LectureCode']; //강의코드
	$ContentsName = $Row['ContentsName']; //과정명
	$LectureStart = $Row['LectureStart']; //시작일자
	$LectureEnd = $Row['LectureEnd']; //종료일자
	$Price = $Row['Price']; //판매가
	$SubPrice = $Row['SubPrice']; //정부지원금
	$PointPrice = $Row['PointPrice']; //학습포인트
	$CouponPrice = $Row['CouponPrice']; //쿠폰
	$RealPrice = $Row['RealPrice']; //자비부담금
	$Status = $Row['Status']; //상태(A:승인대기,B:승인완료,C:결제취소,D:환불완료)
	$Payment = $Row['Payment']; //결제방법 A:카드, B:무통장,C:가상계좌
	$RegDate = $Row['RegDate']; //등록일
}
?>
<div class="Content">
    <div class="contentBody">
        <h2>결제 상세 정보</h2>
        <div class="conZone">
			<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
        		<colgroup>
            		<col width="9%" />
            		<col width="25%" />
            		<col width="9%" />
            		<col width="15%" />
            		<col width="9%" />
            		<col width="*%" />
        	  	</colgroup>
        		<tr>
        			<th>아이디</th>
        			<td> <?=$ID?></td>
        			<th>이름</th>
        			<td> <?=$Name?></td>
        			<th>휴대폰</th>
        			<td> <span id="InfoProt_Mobile"><?=$Mobile?></td>
        		</tr>
        		<tr>
        			<th>주문고유번호</th>
        			<td><?=$paymentId?></td>
        			<th>강의코드</th>
        			<td><?=$LectureCode?></td>
        			<th>과정명</th>
        			<td><?=$ContentsName?></td>
        		</tr>
        		<tr>
        			<th>신청유형</th>
        			<td><?=$ApplyType_array[$ApplyType]?></td>
        			<th>지원유형</th>
        			<td><?=$SupportType_array[$SupportType]?></td>
        			<th>과정기간</th>
        			<td><?=$LectureStart?> ~ <?=$LectureEnd?></td>
        		</tr>
        		<tr>
        			<th>판매가</th>
        			<td><?=number_format($Price,0)?> 원</td>
        			<th>할인금액</th>
        			<td>
        				<?if($SubPrice) echo "정부지원금  : ".number_format($SubPrice,0)." 원"."<br>";?>
        				<?if($PointPrice) echo "학습포인트  :  ".number_format($PointPrice,0)." 원"."<br>"?>
        				<?if($CouponPrice) echo "쿠폰  :  ".number_format($CouponPrice,0)." 원"."<br>";?>
        			</td>
        			<th>결제금액</th>
        			<td><?=number_format($RealPrice,0)?> 원</td>
        		</tr>
        		<tr>
        			<th>상태</th>
        			<td><?=$LectureRequestStatus2_array[$Status]?></td>
        			<th>결제방법</th>
        			<td><?=$Payment_array[$Payment]?></td>
        			<th>등록일자</th>
        			<td><?=$RegDate?></td>
        		</tr>
        	</table>
			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
				<tr>
        			<td align="left" width="200">&nbsp;</td>
        			<td align="center"><button type="button" onclick="DataResultClose();" class="btn btn_DGray line">닫기</button></td>
        			<td width="200" align="right"></td>
				</tr>
			</table>
  		</div>
    </div>
</div>