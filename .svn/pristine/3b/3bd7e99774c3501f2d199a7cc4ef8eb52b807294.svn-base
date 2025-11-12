<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$idx = Replace_Check($idx);

$Sql = "SELECT *, AES_DECRYPT(UNHEX(Phone),'$DB_Enc_Key') AS Phone, AES_DECRYPT(UNHEX(Email),'$DB_Enc_Key') AS Email FROM SimpleAsk WHERE idx=$idx";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);

if($Row) {
    $idx = $Row['idx'];
    $ID = $Row['ID'];
    $Name = $Row['Name'];
    $PurePhone = $Row['Phone'];
    $Email = $Row['Email'];
    $Contents = $Row['Contents'];
    $Status = $Row['Status'];
    $Response = $Row['Response'];
    $ResponseResult = $Row['ResponseResult'];
}

if(!$ID) {
    $ID = "비회원";
}

$Phone = InformationProtection($PurePhone,'Tel','S');
$Email = InformationProtection($Email,'Email','S');
?>
<script>
	function SubmitFormOk(){
		Yes = confirm("답변을 문자로 발송하겠습니까?");
		if(Yes==true){
			simple.submit();
		}
	}
</script>

	<div class="Content">

        <div class="contentBody">
        	<!-- ########## -->
            <h2>간편문의 상세정보</h2>
            
            <div class="conZone">
            	<!-- ## START -->
             	<form name="simple" method="post" action="simple_ask_sending_sms.php">
				<input TYPE="hidden" name="idx" id="" value="<?=$idx?>">
				<input TYPE="hidden" name="id" id="" value="<?=$ID?>">
				<input TYPE="hidden" name="name" id="" value="<?=$Name?>">
				<input TYPE="hidden" name="phone" id="" value="<?=$PurePhone?>">
				<input TYPE="hidden" name="email" id="" value="<?=$Email?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                  <colgroup>
                    <col width="120px" />
                    <col width="" />
                  </colgroup>
				  <tr>
                    <th>아이디</th>
                    <td><?=$ID?> </td>
                  </tr>
                  <tr>
                    <th>이름</th>
                    <td><?=$Name?> </td>
                  </tr>
				  <tr>
                    <th>연락처</th>
                    <td><span id="InfoProt_Phone"><a href="Javascript:InformationProtection('SimpleAsk','Phone','InfoProt_Phone','<?=$idx?>','<?=$_SERVER['PHP_SELF']?>','연락처');"><?=$Phone?></a></span></td>
                  </tr>
				   <tr>
                    <th>이메일</th>
                    <td><span id="InfoProt_Email"><a href="Javascript:InformationProtection('SimpleAsk','Email','InfoProt_Email','<?=$idx?>','<?=$_SERVER['PHP_SELF']?>','이메일');"><?=$Email?></a></span></td>
                  </tr>
				  <tr>
                    <th>상태</th>
                    <td>
					<select name="SimpleAskStatus" id="SimpleAskStatus">
						<?while (list($key,$value)=each($SimpleAskStatus_array)) {?>
						<option value="<?=$key?>" <?if($Status==$key) {?>selected<?}?>><?=$value?></option>
						<?}?>
					</select>
					<span id="SubmitBtn"><input type="button" value="상태 변경 하기" onclick="SimpleAskDetailChange(<?=$idx?>)" class="btn_inputBlue01"></span>
					</td>
                  </tr>
                  <tr>
					<th>답장여부</th>
					<td><?if($ResponseResult == 1){?>Y<?}else{?>N<?}?></td>
				  </tr>
				  <tr>
                    <th>메세지</th>
                    <td><textarea readonly name="Contents" id="Contents" style="width:650px;height:200px"><?=$Contents?></textarea></td>
                  </tr>
				  <tr>
                    <th>답변</th>
                    <td><textarea name="response" id="response" style="width:650px;height:200px"><?=$Response?></textarea></td>
                  </tr>
                </table>
				</form>

				<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
					<tr>
						<td align="left" width="200">&nbsp;</td>
						<td align="center">
						<span id="SubmitBtn"><input type="button" value="문자 전송하기" onclick="SubmitFormOk();" class="btn_inputBlue01"></span>
						<span id="Waiting" style="display:none"><strong>처리중입니다...</strong></span>
						</td>
						<td width="200" align="right"><input type="button" value="닫  기" onclick="DataResultClose();" class="btn_inputLine01"></td>
					</tr>
				</table>

                
            	<!-- ## END -->
      		</div>
            <!-- ########## // -->
        </div>

	</div>
<?
mysqli_close($connect);
?>