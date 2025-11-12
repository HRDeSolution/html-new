<?
include "../../include/include_function.php"; //DB연결 및 각종 함수 정의

$ServiceType = Replace_Check_XSS2($ServiceType); //문의종류
$CompanyName = Replace_Check_XSS2($CompanyName); //회사명
$Name        = Replace_Check_XSS2($Name);        //이름
$Phone01     = Replace_Check_XSS2($Phone01);     //연락처1
$Phone02     = Replace_Check_XSS2($Phone02);     //연락처2
$Phone03     = Replace_Check_XSS2($Phone03);     //연락처3
$Email       = Replace_Check_XSS2($Email);       //이메일
$Personnel   = Replace_Check_XSS2($Personnel);   //예상인원
$Agree       = Replace_Check_XSS2($Agree);       //동의여부
$Contents    = Replace_Check_XSS2($Contents);    //내용

//필수 입력사항 체크
if(!$CompanyName || !$Name || !$Phone01 || !$Phone02 || !$Phone03 || !$Email || !$Personnel || !$Agree || !$Contents) {
?>
<script type="text/javascript">
	alert("입력하지 않은 정보가 존재합니다.");
</script>
<?
    exit;
}

$Phone = $Phone01."-".$Phone02."-".$Phone03;

$Phone_enc = "HEX(AES_ENCRYPT('$Phone','$DB_Enc_Key'))";
$Email_enc = "HEX(AES_ENCRYPT('$Email','$DB_Enc_Key'))";

$sql = "INSERT INTO FlexInquiry(ServiceType, CompanyName, Name, Phone, Email, Personnel, Contents, AgreeYN, RegDate, Del, Status)
        VALUES('$ServiceType', '$CompanyName', '$Name', $Phone_enc, $Email_enc, '$Personnel', '$Contents', 'Y', NOW(), 'N', 'A')";
$Row = mysqli_query($connect, $sql);

if($Row) {
?>
<script type="text/javascript">
	alert("등록되었습니다.");
	top.DataResultClose();
</script>
<?
}else{
?>
<script type="text/javascript">
	alert("등록중 문제가 발생했습니다.\n\n잠시후에 다시 시도하세요.");
</script>
<?
}

mysqli_close($connect);
?>