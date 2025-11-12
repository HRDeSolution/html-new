<?
include "../include/include_function.php";


$SQL = "SELECT * FROM SmsRes
        WHERE SendYN ='N' AND ResDate <= NOW() ";
$QUERY = mysqli_query($connect, $SQL);
if($QUERY && mysqli_num_rows($QUERY)){
    while($ROW = mysqli_fetch_array($QUERY)){
        $idx        = $ROW['idx'];
        $ID 	    = $ROW['ID'];
        $Study_Seq  = $ROW['Study_Seq'];
        $Massage	= $ROW['Massage'];
        $Mobile     = $ROW['Mobile'];
        $ResDate    = $ROW['ResDate'];
        $InputID    = $ROW['InputID'];

        $phone = str_replace("-","",$Mobile);

        $maxno = max_number("idx","SmsSendLog");
        $etc1 = $maxno;
        $Sql1 = "INSERT INTO SmsSendLog(idx, ID, Study_Seq, Massage, Code, Mobile, InputID, RegDate)
                 VALUES($maxno, '$ID', $Study_Seq, '$Massage', '', '$phone', '$InputID', NOW())";
        $Row1 = mysqli_query($connect, $Sql1);

        if($mms_type == "mts"){
            $send = mts_mms_send($phone, $Massage, $TRAN_CALLBACK, $etc1, 'hrd01');
        }else if ($mms_type == "aligo"){
            $send = aligo_send($phone, $Massage, $TRAN_CALLBACK);
        }

        if($send=="Y") $code = "0000";
        else $code = "0001";

        $Sql2 = "UPDATE SmsSendLog SET Code='$code' WHERE idx=$maxno";
        $Row2 = mysqli_query($connect, $Sql2);

        $Sql3 = "UPDATE SmsRes SET SendYN='Y' WHERE idx=$idx";
        $Row3 = mysqli_query($connect, $Sql3);
    }
}
mysqli_close($connect);
?>