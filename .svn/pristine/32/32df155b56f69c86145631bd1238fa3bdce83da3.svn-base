<?
include "../include/include_function.php";
include "./include/include_admin_check.php";
?>
<script type="text/javascript" src="./include/jquery-1.11.0.min.js"></script>
<?
$Ele = Replace_Check($Ele);
$EleArea = Replace_Check($EleArea);
$FileType = Replace_Check($FileType);

if(strpos($FileType, 'Notice') ===0){ //$FileType이 Notice로 시작하면
    $Folder = "/Notice";
}elseif(strpos($FileType, 'Counsel') ===0){ //$FileType이 Counsel로 시작하면
    $Folder = "/Counsel";
}else if($FileType == "imgA"){
    $Folder = "/MainContents";
}else{
    $Folder = "/Course";
}

include "./include/include_upload_file.php";

if(!$FileName1) {
?>
<script type="text/javascript">
<!--
	alert("첨부된 파일이 없습니다.");
	top.$("#SubmitBtn2").show();
	top.$("#Waiting2").hide();
//-->
</script>
<?
exit;
}

switch ($FileType) {
	case "text" :
		$EleAreaHTML = "<A HREF='./direct_download.php?code=Course&file=".$FileName1."'><B>".$FileName1."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('".$Ele."','".$EleArea."') class='btn_inputLine01'>";
	break;
	case "Counsel" :
		$EleAreaHTML = "<A HREF='./direct_download.php?code=Counsel&file=".$FileName1."'><B>".$FileName1."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('".$Ele."','".$EleArea."') class='btn_inputLine01'>";
	break;
	case "img" :
		$EleAreaHTML = "<img src='../upload/Course/".$FileName1."' width='150' align='absmiddle'>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('".$Ele."','".$EleArea."') class='btn_inputLine01'>";
    break;
	case "imgA" :
	    $EleAreaHTML = "<img src='../upload/MainContents/".$FileName1."' width='150' align='absmiddle'>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('".$Ele."','".$EleArea."') class='btn_inputLine01'>";
    break;
    
	case "Counsel1" :
	    $EleAreaHTML = "<input name='fileName1' id='fileName1' type='hidden' value='".$RealFileName1."'><A HREF='./direct_download.php?code=Counsel&file=".$FileName1."'><B>".$RealFileName1."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('".$Ele."','".$EleArea."','".$Folder."') class='btn_inputLine01'>";
    break;
	case "Counsel2" :
	    $EleAreaHTML = "<input name='fileName2' id='fileName2' type='hidden' value='".$RealFileName1."'><A HREF='./direct_download.php?code=Counsel&file=".$FileName2."'><B>".$RealFileName1."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('".$Ele."','".$EleArea."','".$Folder."') class='btn_inputLine01'>";
    break;
	case "Counsel3" :
	    $EleAreaHTML = "<input name='fileName3' id='fileName3' type='hidden' value='".$RealFileName1."'><A HREF='./direct_download.php?code=Counsel&file=".$FileName3."'><B>".$RealFileName1."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('".$Ele."','".$EleArea."','".$Folder."') class='btn_inputLine01'>";
    break;
	case "Counsel4" :
	    $EleAreaHTML = "<input name='fileName4' id='fileName4' type='hidden' value='".$RealFileName1."'><A HREF='./direct_download.php?code=Counsel&file=".$FileName4."'><B>".$RealFileName1."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('".$Ele."','".$EleArea."','".$Folder."') class='btn_inputLine01'>";
    break;
	case "Counsel5" :
	    $EleAreaHTML = "<input name='fileName5' id='fileName5' type='hidden' value='".$RealFileName1."'><A HREF='./direct_download.php?code=Counsel&file=".$FileName5."'><B>".$RealFileName1."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('".$Ele."','".$EleArea."','".$Folder."') class='btn_inputLine01'>";
    break;
    
	case "Notice1" :
	    $EleAreaHTML = "<input name='fileName1' id='fileName1' type='hidden' value='".$RealFileName1."'><A HREF='./direct_download.php?code=Notice&file=".$FileName1."'><B>".$RealFileName1."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('".$Ele."','".$EleArea."','".$Folder."') class='btn_inputLine01'>";
    break;
	case "Notice2" :
	    $EleAreaHTML = "<input name='fileName2' id='fileName2' type='hidden' value='".$RealFileName1."'><A HREF='./direct_download.php?code=Notice&file=".$FileName2."'><B>".$RealFileName1."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('".$Ele."','".$EleArea."','".$Folder."') class='btn_inputLine01'>";
    break;
	case "Notice3" :
	    $EleAreaHTML = "<input name='fileName3' id='fileName3' type='hidden' value='".$RealFileName1."'><A HREF='./direct_download.php?code=Notice&file=".$FileName3."'><B>".$RealFileName1."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('".$Ele."','".$EleArea."','".$Folder."') class='btn_inputLine01'>";
    break;
	case "Notice4" :
	    $EleAreaHTML = "<input name='fileName4' id='fileName4' type='hidden' value='".$RealFileName1."'><A HREF='./direct_download.php?code=Notice&file=".$FileName4."'><B>".$RealFileName1."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('".$Ele."','".$EleArea."','".$Folder."') class='btn_inputLine01'>";
    break;
	case "Notice5" :
	    $EleAreaHTML = "<input name='fileName5' id='fileName5' type='hidden' value='".$RealFileName1."'><A HREF='./direct_download.php?code=Notice&file=".$FileName5."'><B>".$RealFileName1."</B></a>&nbsp;&nbsp;<input type='button' value='파일 삭제' onclick=UploadFileDelete('".$Ele."','".$EleArea."','".$Folder."') class='btn_inputLine01'>";
    break;
}

mysqli_close($connect);
?>
<SCRIPT LANGUAGE="JavaScript">
<!--
	top.$("#<?=$Ele?>").val("<?=$FileName1?>");
	top.$("#<?=$EleArea?>").html("<?=$EleAreaHTML?>");
	top.DataResultClose();
//-->
</SCRIPT>