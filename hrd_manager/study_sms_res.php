<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$seq_value = Replace_Check($seq_value);
?>
<script type="text/javascript">
    $(document).ready(function(){
        $("#SmsResDate").datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
            buttonImage: "images/icn_calendar.gif", //이미지 주소
            buttonImageOnly: true //이미지만 보이기
        });
        $("#SmsResDate").val("");
        $("img.ui-datepicker-trigger").attr("style","margin-left:5px; vertical-align:top; cursor:pointer;"); //이미지 버튼 style적용
    });

    function SmsResSubmitOk() {
        val = document.Form1;

        const today = new Date();
        const smsDate = new Date(val.SmsResDate.value);
        
        today.setHours(0, 0, 0, 0);
        smsDate.setHours(0, 0, 0, 0);

        if(val.SmsResDate.value=="") {
            alert("예약날짜를 선택하세요.");
            return;
        }else{
            if (smsDate.getTime() <= today.getTime()) {
                alert("예약날짜는 현재날짜 이후부터 가능합니다.");
                return;
            }
        }

        if(val.Massage.value=="") {
            alert("예약 메세지를 입력하세요.");
            return;
        }

        Yes = confirm("발송하시겠습니까?");
        if(Yes==true) {
            $("#SubmitBtn").hide();
            $("#Waiting").show();
            Form1.submit();
        }
    }
</script>
<div class="Content">
    <div class="contentBody">
        <h2>메시지 예약 발송</h2>        
        <div class="conZone">            
            <form name="Form1" method="post" action="study_sms_res_script.php" target="ScriptFrame">
                <INPUT TYPE="hidden" name="seq_value" id="seq_value" value="<?=$seq_value?>">
                <table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
                    <colgroup>
                        <col width="120px" />
                        <col width="" />
                    </colgroup>
                    <tr>
                        <th>예약 날짜</th>
                        <td><input name="SmsResDate" id="SmsResDate" type="text" size="12" value="" readonly></td>
                    </tr>
                    <tr>
                        <th>예약 시간</th>
                        <td>
                            <select name="SmsResTime" id="SmsResTime" style="width: 50px;">
                                <?
                                for($i=0; $i<24; $i++){
                                    if($i < 10) $i = "0".$i;
                                ?>
                                <option value="<?=$i?>"><?=$i?></option>
                                <?}?>
                            </select>
                            시
                        </td>
                    </tr>
                    <tr>
                    <th>예약 메세지</th>
                    <td><textarea name="Massage" id="Massage" style="width:400px;height:200px"></textarea></td>
                    </tr>
                </table>
            </form>

            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
                <tr>
                    <td align="left" width="200">&nbsp;</td>
                    <td align="center">
                    <span id="SubmitBtn"><button type="button" onclick="SmsResSubmitOk()" class="btn btn_Blue">발송 하기</button></span>
                    <span id="Waiting" style="display:none"><strong>처리중입니다...</strong></span>
                    </td>
                    <td width="200" align="right"><button type="button" onclick="DataResultClose();" class="btn btn_DGray line">닫기</button></td>
                </tr>
            </table>
        </div>
    </div>
</div>
<?
mysqli_close($connect);
?>