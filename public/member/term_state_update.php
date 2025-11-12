<?
include $_SERVER['DOCUMENT_ROOT'] . "/include/include_function.php"; //DB연결 및 각종 함수 정의

$pwchg = Replace_Check_XSS2($pwchg); //비밀번호변경여부
$ID = $_SESSION['LoginMemberID'];
    
//필수항목에 하나라도 동의하지 않은 경우 체크하도록 안내
if($Agree01 != 'on' || $Agree02 != 'on' || $Agree03 != 'on' ){
?>
<script type="text/javascript">
	alert('필수항목에 동의해주세요');
	history.go(-1);
</script>
<?
}else{
    if($Mailling == 'on'){
        $sendingAgreed = 'Y';
    }else{
        $sendingAgreed = 'N';
    }
    
    if($Marketing=="on") {
        if($chk5Email=="on" && $chk5Sms=="on"){
            $marketingAgreed = "Y";
        }else{
            if($chk5Email=="on"){
                $marketingAgreed = "E";
            }
            if($chk5Sms=="on"){
                $marketingAgreed = "S";
            }
        }
    }else{
        $marketingAgreed = "N";
    }
    
    if (!$connect) {
        die("Connection failed: " . mysqli_connect_error());
    }
    $query4Update = "UPDATE Member SET Mandatory = 'Y', MandatoryDate = NOW(), Mailling = '$sendingAgreed', MailingDate = NOW(), 
                                       Marketing = '$marketingAgreed', MarketingDate = NOW()
                     WHERE ID = '$ID'";
    $row = mysqli_query($connect, $query4Update);
    if($row){
        //초기 비번인지 확인
        if($pwchg == 'N'){
            $url = "/public/mypage/memberinfo.html";
        }else{
            if($_SESSION['SiteCode'] == "B"){
                $url = "/cyber/main/main.html";
            }else{
                $url = "/hrdedu/main/main.html";
            }
        }
    }
}
?>
<SCRIPT LANGUAGE="JavaScript">
	top.location.href = '<?=$url?>';
</script>    

<?
mysqli_close($connect);
?>