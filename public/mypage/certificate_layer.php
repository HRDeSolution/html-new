<?//학습현황 > 이수증
include "../../include/include_function.php"; //DB연결 및 각종 함수 정의

$LectureCode = Replace_Check_XSS2($LectureCode);

$Sql = "SELECT m.Name, AES_DECRYPT(UNHEX(m.BirthDay),'$DB_Enc_Key') AS BirthDay,
    	       s.LectureStart, s.LectureEnd, c.ContentsName, c2.CompanyName
        FROM Member m
        INNER JOIN Study s ON s.ID = m.ID
        INNER JOIN Course c ON c.LectureCode = '$LectureCode'
        INNER JOIN Company c2 ON c2.CompanyCode = m.CompanyCode
        WHERE m.ID = '$LoginMemberID'";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
if($Row) {
	$LectureStart = $Row['LectureStart'];
	$LectureEnd = $Row['LectureEnd'];
	$Name = $Row['Name'];
	$BirthDay = $Row['BirthDay'];
	$CompanyName = $Row['CompanyName'];
	$ContentsName = $Row['ContentsName'];

    $LectureStart_array = explode("-",$LectureStart);
	$LectureStart_Year = $LectureStart_array[0];
	$LectureStart_Month = $LectureStart_array[1];
	$LectureStart_Day = $LectureStart_array[2];
	$LectureStart_view = $LectureStart_Year."년 ".$LectureStart_Month."월 ".$LectureStart_Day."일";

	$LectureEnd_array = explode("-",$LectureEnd);
	$LectureEnd_Year = $LectureEnd_array[0];
	$LectureEnd_Month = $LectureEnd_array[1];
	$LectureEnd_Day = $LectureEnd_array[2];
	$LectureEnd_view = $LectureEnd_Year."년 ".$LectureEnd_Month."월 ".$LectureEnd_Day."일";
}
?>
<!-- layer Ask -->
<div class="layerArea wid550">
	<!-- close -->
	<div class="close"><a href="Javascript:DataResultClose();"><img src="/images/common/btn_close01.png" alt="창닫기" /></a></div>
	<!-- title -->
	<div class="title">수료증 출력</div>
	<!-- info -->
	<div class="infoArea">
		<!-- area -->
		<div class="comment_1">
			<ul>
				<li>테두리선(상장모양)의 출력을 원하시면 출력 옵션에서 배경 그래픽 출력을<br>선택해주세요.</li>
			</ul>
		</div>
		<div class="info mt20">
			<table cellpadding="0" class="pan_reg">
			  <colgroup>
				  <col width="16%" />
				  <col width="" />
			  </colgroup>
			  <tr>
				<td >성명</td>
				<td><?=$Name?></td>
			  </tr>
			  <tr>
				<td >생년월일</td>
				<td><?=$BirthDay?></td>
			  </tr>
			  <tr>
				<td >소속</td>
				<td><?=$CompanyName?></td>
			  </tr>
			  <tr>
				<td >훈련과정</td>
				<td><?=$ContentsName?></td>
			  </tr>
			  <tr>
				<td >훈련기간</td>
				<td><?=$LectureStart_view?> ~ <?=$LectureEnd_view?></td>
			  </tr>
			</table>
		</div>
		<div class="fc000B mt20 tc">위의 사항을 확인하고 수료증을 출력합니다.</div>

		<!-- btn -->
		<p class="btnAreaTc02">
			<span class="btnSmSky01"><a href="/public/mypage/certificate_pdf01.php?LectureCode=<?=$LectureCode?>" target="ScriptFrame">수료증 PDF로 출력하기</a></span>
		</p>
		<!-- area // -->
	</div>
	<!-- info // -->
</div>
<!-- layer Ask // -->
<?
mysqli_close($connect);
?>