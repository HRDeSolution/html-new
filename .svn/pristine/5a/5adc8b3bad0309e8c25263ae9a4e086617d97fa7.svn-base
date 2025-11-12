<?
$MenuType = "J";
?>
<? include "./include/include_top.php"; ?>
    <div class="contentBody">
    	<h2>알림톡API전송결과</h2>
<?
global $connect;
global $auth_code;
global $TRAN_SENDER_KEY;

$url = "https://api.mtsco.co.kr/rspns/atk/rspnsMessages";

$data=array(
    "auth_code"     => $auth_code,
    "sender_key"    => $TRAN_SENDER_KEY,
    "send_date"     => "202409261300",
    "page"          => 1,
    "count"         => 1
);

echo '<pre>';
ob_start();
print_r($data);
echo htmlspecialchars( ob_get_clean() );
echo '</pre>';
echo "<br><br><br>";

$data = json_encode($data);

$ch = curl_init();                                 //curl 초기화
curl_setopt($ch,CURLOPT_URL, $url);               //URL 지정하기
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);    //요청 결과를 문자열로 반환
curl_setopt($ch,CURLOPT_CONNECTTIMEOUT, 10);      //connection timeout 10초
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);   //원격 서버의 인증서가 유효한지 검사 안함
curl_setopt($ch,CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch,CURLOPT_POSTFIELDS, $data);       //POST data
curl_setopt($ch,CURLOPT_POST, true);              //true시 post 전송
curl_setopt($ch,CURLOPT_HTTPHEADER, array("Accept: application/json","Content-Type: application/json"));
$response = curl_exec($ch);

curl_close($ch);

$response = json_decode($response);


echo '<pre>';
ob_start();
print_r($response);
echo htmlspecialchars( ob_get_clean() );
echo '</pre>';
?>
	</div>
</div>
<!-- Content // -->
<? include "./include/include_bottom.php"; ?>