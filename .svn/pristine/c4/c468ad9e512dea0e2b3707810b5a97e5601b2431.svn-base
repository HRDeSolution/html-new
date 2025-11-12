<?
//include $_SERVER['DOCUMENT_ROOT'] . "/include/include_db.php"; //DB연결
//include $_SERVER['DOCUMENT_ROOT'] . "/include/include_siteInfo.php"; //교육원고유정보 연결
include "/web/hrde/html/include/include_db.php"; //DB연결
include "/web/hrde/html/include/include_siteInfo.php"; //교육원고유정보 연결

header("content-type:text/html; charset=utf-8");
@extract($_POST);
@extract($_GET);

//ini_set('session.cache_limiter' ,'nocache, must-revalidate-revalidate');
//서브 도메인간에 세션 공유

if(empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] == "off") $Protocol_SSL = "http://";
else $Protocol_SSL = "https://";

##############################################
# SeverDomain
##############################################
$ServerDomain = $_SERVER['SERVER_NAME'];
$ServerDomain_array = explode(".",$ServerDomain);
$ServerDomain_Host = $ServerDomain_array[0];
$ServerDomain_length = strlen($ServerDomain);
$ServerDomain_Host_length = strlen($ServerDomain_Host);

$BasicServerDomain = substr($ServerDomain, $ServerDomain_Host_length, $ServerDomain_length);

//session_set_cookie_params( 0, "/", $BasicServerDomain);
//ini_set('session.cookie_domain', $BasicServerDomain);
session_set_cookie_params( 0, "/", $ServerDomain);
ini_set('session.cookie_domain', $ServerDomain);


##############################################
# Session
##############################################
// 본인인증 또는 쇼핑몰 사용시에만 secure; SameSite=None 로 설정합니다.
// Chrome 80 버전부터 아래 이슈 대응
// https://developers-kr.googleblog.com/2020/01/developers-get-ready-for-new.html?fbclid=IwAR0wnJFGd6Fg9_WIbQPK3_FxSSpFLqDCr9bjicXdzy--CCLJhJgC9pJe5ss
if(!function_exists('session_start_samesite')) {
    function session_start_samesite($options = array()){
        $res = @session_start($options);
        
        // IE 브라우저 또는 엣지브라우저 일때는 secure; SameSite=None 을 설정하지 않습니다.
        if( preg_match('/Edge/i', $_SERVER['HTTP_USER_AGENT']) || preg_match('~MSIE|Internet Explorer~i', $_SERVER['HTTP_USER_AGENT']) || preg_match('~Trident/7.0(; Touch)?; rv:11.0~',$_SERVER['HTTP_USER_AGENT']) ){
            return $res;
        }
        
        $headers = headers_list();
        krsort($headers);
        foreach ($headers as $header) {
            if (!preg_match('~^Set-Cookie: PHPSESSID=~', $header)) continue;
            $header = preg_replace('~; secure(; HttpOnly)?$~', '', $header) . '; secure; SameSite=None';
            header($header, false);
            break;
        }
        return $res;
    }
}
session_start_samesite();
//session_start();

include "/web/hrde/html/include/include_code.php"; //코드시스템 연결
include "/web/hrde/html/include/include_sms.php"; //문자시스템 연결

##############################################
# PC/Mobile 구분
##############################################
$UserIP = $_SERVER['REMOTE_ADDR'];
$ServerIP = $_SERVER['SERVER_ADDR'];

$HTTP_USER_AGENT = $_SERVER['HTTP_USER_AGENT'];

$MobileArray  = array("iphone","ipad","lgtelecom","skt","mobile","samsung","nokia","blackberry","opera Mini","android","sony","phone","windows ce");

$MobileAgent = "/(iPod|iPhone|Android|BlackBerry|SymbianOS|SCH-M\d+|Opera Mini|Windows CE|Nokia|SonyEricsson|webOS|PalmOS)/";

if(preg_match($MobileAgent, $_SERVER['HTTP_USER_AGENT'])){
    $UserDevice = "Mobile";
    $MobilecheckCount = 1;
}else{
    $UserDevice = "PC";
    $MobilecheckCount = 0;
}

$userAgent = $HTTP_USER_AGENT;

if(preg_match("/MSIE*/", $userAgent))   $browser = "Explorer"; //익스플로러
if(preg_match("/Trident*/", $userAgent) && preg_match("/rv:11.0*/", $userAgent) && preg_match("/Gecko*/", $userAgent))  $browser = "Explorer"; //IE11
if(preg_match("/Chrome*/", $userAgent)) $browser = "Chrome"; // 크롬
if(preg_match("/Edge*/", $userAgent))   $browser = "Edge"; // 엣지
if(!$browser)   $browser = "Other"; // 기타


##############################################
# 사이트 정보
##############################################
$Sql = "SELECT * FROM SiteInfomation ORDER BY RegDate DESC LIMIT 0,1";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
if($Row) {
    $SiteName = $Row['CompanyName'];
    $SiteCeo = $Row['Ceo'];
    $SiteCompanyNumber = $Row['CompanyNumber'];
    $SiteSalesReportNumber = $Row['SalesReportNumber'];
    $SitePhone = $Row['Phone'];
    $SiteFax = $Row['Fax'];
    $SiteEmail = $Row['Email'];
    $SitePersonalInformationManager = $Row['PersonalInformationManager'];
    $SiteAddress = $Row['Address'];
    $SiteCopyright = $Row['Copyright'];
    $SiteKakaoURL = $Row['KakaoURL'];
}
mysqli_free_result($Result);


##############################################
# 로그인 정보
##############################################
//echo "INCNLUDE_TOP-".	$_SESSION["LoginMemberID"]."<br>";
if(isset($_SESSION['LoginMemberID'])) {
    $LoginMemberID = $_SESSION['LoginMemberID'];
    $LoginName = $_SESSION['LoginName'];
    $LoginEduManager = $_SESSION['LoginEduManager'];
    $LoginMemberType = $_SESSION['LoginMemberType'];
    $LoginTestID = $_SESSION['LoginTestID'];
    //	echo "INCNLUDE_TOP2-".	$_SESSION["LoginMemberID"]."<br>";
    //	echo "INCNLUDE_TOP2-".	$LoginMemberID."<br>";
}


##############################################
# 페이지 이동 함수
##############################################
// 이전페이지로 가는 함수. (메시지를 인자로 전달할 경우, 메시지를 출력하고 이전 페이지로 간다.)
// go_back();
// go_back( $msg ); 메시지를 출력하고 이전 페이지로 감.
function go_back( $msg = "", $exit = 1 ) {
    echo "<script language=javascript>";
    if( $msg ) echo "alert( \" $msg \" ); ";
    echo "history.back();";
    echo "</script>";
    if( $exit ) exit;
}

// 현재 페이지를 $url 로 대체 (현재 페이지는 history 상에 남지 않음)
// go_url( $url, $msg ); $msg를 경고메시지로 출력하고 이동.
// go_url( $url, $msg, $target ); $msg 를 경고 메시지로 출력하고 $target의 프레임을 이동
function go_url( $url, $msg = "", $target = "" ) {
    echo "<script language=javascript>\n";
    if( $msg ) echo "alert( \" $msg \" );\n";
    
    if( $target ) echo $target . ".";
    echo "location.replace('" . $url . "');\n";
    
    echo "</script>\n";
    exit;
}

function HistoryBack( $alert = "", $exit = 1 ){
    echo "<script language=javascript>\n";
    if( $alert ){
        $alert=AddSlashes($alert);
        echo "alert('".stripslashes($alert)."');\n";
    }
    echo "history.back();\n";
    echo "</script>";
    if( $exit ) exit;
}


##############################################
# SELECT 의 옵션을 출력해주는 함수
##############################################
// $data 는 키배열이다.
function select_option_key( $data, $sel = "" ) {
    while( list( $key, $value ) = each( $data ) ) {
        if( $key == $sel ) echo "<option value=\"$key\" SELECTED> $value </option>";
        else echo "<option value=\"$key\"> $value </option>";
    }
}

// $data 는 일반배열이다.
function select_option_value( $data, $sel = "" ) {
    while( list( $key, $value ) = each( $data ) ) {
        if( $value == $sel ) echo "<option value=\"$value\" SELECTED> $value </option>";
        else echo "<option value=\"$value\"> $value </option>";
    }
}


##############################################
# 시간/날짜 관련 함수
##############################################
// 숫자를 넣으면 날짜,시간,분,초 로 돌려준다.
function get_num_to_date( $number ){
    $pDate = floor($number / 86400); //--남은 날짜
    $pHour = floor( ($number - ($pDate * 86400) ) / 3600);//-- 시간
    $pMin = floor( ($number - ($pDate * 86400) - ($pHour * 3600) ) / 60);
    $pSec = $number - ($pDate * 86400) - ($pHour *  3600) - ($pMin * 60);
    if($pMin < 10 && $pMin) $pMin = "0" . $pMin;
    if($pSec < 10 && $pSec) $pSec = "0" . $pSec;
    $pAll = "";
    $pAll .= ($pDate) ? "{$pDate}일" : "";
    $pAll .= ($pHour) ? "{$pHour}:" : "";
    $pAll .= ($pMin) ? "{$pMin}:" : "00:";
    $pAll .= ($pSec) ? "{$pSec}" : "00";
    
    $dAll = "";
    $dAll .= ($pDate) ? " {$pDate}일" : "";
    $dAll .= ($pHour) ? " {$pHour}시간" : "";
    $dAll .= ($pMin) ? " {$pMin}분" : " 00분";
    $dAll .= ($pSec) ? " {$pSec}초" : " 00초";
    
    return array($pDate,$pHour,$pMin,$pSec,$pAll,$dAll);
}

// 날짜,시간,분,초 로 돌려준다.
function get_date_to_num( $D,$H,$M,$I ){
    $getNumD = $D * 86400;
    $getNumH = $H * 3600;
    $getNumM = $M * 60;
    $getNumI = $I;
    return $getNumD + $getNumH + $getNumM + $getNumI;
}

//매달 의 마지막날일
function get_end_day($myyear, $mymonth){
    $endday = array(31,29,31,30,31,30,31,31,30,31,30,31);
    $endday[1] = ($myyear % 4 != 0) ? 28 : ($myyear % 100 != 0) ? 29 : ($myyear % 400 != 0) ? 28 : 29;
    return $endday[$mymonth - 1];
}

function DateToStamp($NowDate="", $RtnType="DateTime"){
    if(empty($NowDate)) $NowDate = date("Y-m-d H:i:s",Mktime());
    $NowYear = date("Y",strtotime($NowDate));
    $NowMonth = date("m",strtotime($NowDate));
    $NowDay = date("d",strtotime($NowDate));
    $NowHour = date("H",strtotime($NowDate));
    $NowMinute = date("i",strtotime($NowDate));
    $NowSecond = date("s",strtotime($NowDate));
    switch($RtnType){
        Case "Date": $NowStamp = mktime(0, 0, 0, $NowMonth, $NowDay, $NowYear); Break;
        Case "Time": $NowStamp = mktime($NowHour, $NowMinute, $NowSecond, $NowMonth, $NowDay, $NowYear) - mktime(0, 0, 0, $NowMonth, $NowDay, $NowYear); Break;
        Default: $NowStamp = mktime($NowHour, $NowMinute, $NowSecond, $NowMonth, $NowDay, $NowYear); Break;
    }
    return $NowStamp;
}

function StampToDate($NowStamp="", $RtnType="DateTime"){
    if(empty($NowStamp)) $NowStamp = Mktime();
    switch($RtnType){
        Case "Date": $NowDate = date("Y-m-d",$NowStamp); Break;
        Case "Time": $NowDate = date("H:i:s",$NowStamp); Break;
        Default: $NowDate = date("Y-m-d H:i:s",$NowStamp); Break;
    }
    return $NowDate;
}

//초를 넣으면 시분초로 변환
function Sec_To_His($Sec) {
    //일단 시간부분 추출
    $Time_hour = $Sec / 3600;
    $Time_hour = floor($Time_hour);
    if(strlen($Time_hour) < 2) {
        $Time_hour = "0".$Time_hour;
    }
    //분 부분을 추출
    $Time_minute = $Sec % 3600;
    $Time_minute = $Time_minute / 60;
    $Time_minute = floor($Time_minute);
    if(strlen($Time_minute) < 2) {
        $Time_minute = "0".$Time_minute;
    }
    //초 부분을 추출
    $Time_second = $Sec - (($Time_hour * 3600) + ($Time_minute * 60));
    if(strlen($Time_second) < 2) {
        $Time_second = "0".$Time_second;
    }
    
    $Result = $Time_hour.":".$Time_minute.":".$Time_second."";
    return $Result;
}

//초를 넣으면 분으로 변환
function Sec_To_m($Sec) {
    if($Sec<60) {
        $Result = $Sec."초";
    }else{
        $Result = $Sec / 60;
        $Result = (int)$Result."분";
    }
    return $Result;
}

function MakeOrderNum($len=3) {
    if(!is_int($len) || ($len < 3)) {
        $len = 3;
    }
    $arr = array_merge(range(0, 9));
    
    $rand = false;
    for($i=0; $i<$len; $i++) {
        $rand .= $arr[mt_rand(0,count($arr)-1)];
    }
    return date('YmdHi').$rand;
}


##############################################
# 문자/숫자 관련 함수
##############################################
// TEXT 박스에서 value값에 "가 들어가 있으면 인식을 못하므로
// 인식할 수 있는 문자로 치환해준다.
function html_quote( $str ) {
    $str = stripslashes($str);
    return str_replace( chr(34), "&#34", $str );
}

// 한글 자르기
function cut_string( $text, $ori_length, $suffix = "...") {
    $length = $ori_length;
    while( $length > 0 && ord( $text[$length] ) > 128) $length--;
    
    if( $length <= 0 ) $length = 0;
    
    //한글이 연속해서 짤렸을때 영문부분부터 다시 처리
    if( $length < $ori_length-1 ) {
        $step = 0;
        $new_length = $length;
        while( $length < $ori_length ) {
            if( ord( $text[$length] ) > 128 ) {
                if( $step == 0 ) $step = 1; //한글시작
                else {
                    $step = 0; //한글끝
                    $new_length += 2;
                }
            } else {
                $new_length++;
                $step = 0;
            }
            $length++;
        }
        $length = $new_length;
    }
    $result = substr( $text, 0, $length);
    if( $suffix && strlen( $text ) > $length ) return $result.$suffix;
    return $result;
}

function strcut_utf8($str, $len, $checkmb=false, $tail='...') {
    /**
     * UTF-8 Format
     * 0xxxxxxx = ASCII, 110xxxxx 10xxxxxx or 1110xxxx 10xxxxxx 10xxxxxx
     * latin, greek, cyrillic, coptic, armenian, hebrew, arab characters consist of 2bytes
     * BMP(Basic Mulitilingual Plane) including Hangul, Japanese consist of 3bytes
     **/
    preg_match_all('/[\xE0-\xFF][\x80-\xFF]{2}|./', $str, $match); // target for BMP
    $m = $match[0];
    $slen = strlen($str); // length of source string
    $tlen = strlen($tail); // length of tail string
    $mlen = count($m); // length of matched characters
    if ($slen <= $len) return $str;
    if (!$checkmb && $mlen <= $len) return $str;
    $ret = array();
    $count = 0;
    for ($i=0; $i < $len; $i++) {
        $count += ($checkmb && strlen($m[$i]) > 1)?2:1;
        if ($count + $tlen > $len) break;
        $ret[] = $m[$i];
    }
    return join('', $ret).$tail;
}

//UTF 로 무조건 변환
function change_to_utf($utfStr) {
    if (iconv("UTF-8","UTF-8",$utfStr) == $utfStr) {
        return $utfStr;
    }else {
        return iconv("EUC-KR","UTF-8",$utfStr);
    }
}

//5자리 숫자난수 생성
function makeRand5($len=5) {
    if(!is_int($len) || ($len < 5)) {
        $len = 5;
    }
    $arr = array_merge(range(0, 9));
    //$arr = array_merge(range(1, 9), range('a', 'z'));
    
    $rand = false;
    for($i=0; $i<$len; $i++) {
        $rand .= $arr[mt_rand(0,count($arr)-1)];
    }
    return $rand;
}


##############################################
# 파일 관련 함수
##############################################
function FolderDetect($folder) {
    $REQUEST_URI = explode("?",$_SERVER['REQUEST_URI']);
    $PageUrl = $REQUEST_URI[0];
    
    if(strpos($PageUrl,$folder)>-1) return true;
    else return false;
}

// 파일 이름으로부터 확장자를 얻는 함수
function get_file_ext( $filename ) {
    $pos = strrchr( $filename, "." );
    
    // 파일 이름이 name.exe. 같은 거라면 확장자에 아무 것도 걸리지 않으므로 . 을 한 번 더 빼준다
    if( trim( $pos ) == "." ) $pos = strrchr( substr( $filename, 0, strlen( $filename ) -1 ), "." );
    
    return substr( $pos, 1 );
}

function get_new_file_name($file_path, $realfilename) {
    if(!$realfilename){
        return "";
    }else{
        $realfile_name = explode(".",$realfilename);
        if(count($realfile_name) > 1){
            for($i = 0; $i < count($realfile_name) - 1;$i++){
                $file_name .= $realfile_name[$i];
                if($i < count($realfile_name) - 2) $file_name .= ".";
            }
            $file_ext = $realfile_name[count($realfile_name) - 1];
        }
        else{
            $file_name = $realfilename;
            $file_ext = "";
        }
        
        $filename = "";
        $newFile = "";
        $fileExt = "";
        if ($file_ext) $fileExt = "." . $file_ext;
        $filename = $file_name . $fileExt;
        
        $bExist = true;
        $strFileName = $file_path . "/" . $filename;
        $countFileName = 0;
        $newFile = $filename;
        while ($bExist) {
            if (is_file ($strFileName) ) {
                $countFileName++;
                $newFile = $file_name . "_" . $countFileName . $fileExt;
                $strFileName = $file_path . "/" .  $newFile;
            } else {
                $bExist = false;
            }
        }
        return $newFile;
    }
}

##-- 사용법 imgThumbo(파일, 저장될이름, 가로 최대 크기,디렉토리명,세로 최대 크기,);
//function img_thumbo($filePath, $saveName, $fWidth, $saveDir = "./", $fHeight = "0")
function img_thumbo($filePath, $saveName, $fWidth, $saveDir, $fHeight){
    if (!file_exists($saveDir)){
        @mkdir($saveDir);
        @chmod($saveDir, 0777);
    }
    
    $is_changeImage = false;
    
    $sz = @getimagesize($filePath); // 이미지 사이즈구함
    $imgW = $sz[0];
    $imgH = $sz[1];
    
    ##-- 가로 크기
    if($imgW  > $fWidth){
        $per=$imgW/$fWidth;
        $imgW=ceil($imgW/$per);
        $imgH=ceil($imgH/$per);
        $is_changeImage = true;
    }
    
    ##-- 세로 크기 만약 있다면 줄인다.
    if($fHeignt > 0){
        if($imgH > $fHeight){
            $per=$imgH/$fHeight;
            $imgW=ceil($imgW/$per);
            $imgH=ceil($imgH/$per);
            $is_changeImage = true;
        }
    }
    
    ##-- 큰 이미지 일 경우에만 사이즈를 줄여서 넣는다.
    if($is_changeImage){
        switch ($sz[2]){
            case 1:
                $src_img = imagecreatefromgif($filePath);//@imagecreatefromgif($filePath);
                $dst_img = imagecreate($imgW, $imgH);
                if($src_img){
                    //$dst_img = imagecreatetruecolor($imgW, $imgH);
                    ImageCopyResized($dst_img,$src_img,0,0,0,0,$imgW,$imgH,$sz[0],$sz[1]);
                    ImageInterlace($dst_img);
                    imageGIF($dst_img, $saveDir.$saveName);
                    //ImageJPEG($dst_img, $saveDir.$saveName . ".jpg");
                }
                break;
            case 2:
                $src_img = imagecreatefromjpeg($filePath);//@imagecreatefromjpeg($filePath);
                $dst_img = imagecreatetruecolor($imgW, $imgH);
                if($src_img){
                    ImageCopyResized($dst_img,$src_img,0,0,0,0,$imgW,$imgH,$sz[0],$sz[1]);
                    ImageInterlace($dst_img);
                    ImageJPEG($dst_img, $saveDir.$saveName,90);
                }
                break;
            case 3:
                $src_img = imagecreatefrompng($filePath);//@imagecreatefrompng($filePath);
                $dst_img = imagecreatetruecolor($imgW, $imgH);
                if($src_img){
                    ImageCopyResized($dst_img,$src_img,0,0,0,0,$imgW,$imgH,$sz[0],$sz[1]);
                    ImageInterlace($dst_img);
                    ImagePNG($dst_img, $saveDir.$saveName);
                }
                break;
            default:
                return false;
                break;
        }
        ##-- 원본 삭제 한다.
        // unlink($filePath);
        
        ##-- 기준 이미지 보다 작다면 기냥 이동한다.
    }else{
        copy($filePath,$saveDir.$saveName);
    }
    
    return array($saveDir, $saveName, $imgW, $imgH);
}

##-- 사용법 imgThumbo(파일, 저장될이름, 가로 최대 크기,디렉토리명,세로 최대 크기,);
function img_user_size($fileName, $fWidth, $fHeight){
    $sz = @getimagesize($fileName); // 이미지 사이즈구함
    $imgW = $sz['0'];
    $imgH = $sz['1'];
    
    ##-- 가로 크기
    if($imgW  > $fWidth){
        $per=$imgW/$fWidth;
        $imgW=ceil($imgW/$per);
        $imgH=ceil($imgH/$per);
    }
    
    if($imgH > $fHeight){
        $per=$imgH/$fHeight;
        $imgW=ceil($imgW/$per);
        $imgH=ceil($imgH/$per);
    }
    return array($imgW, $imgH);
}

function img_user_size2($fileName){
    $sz = @getimagesize($fileName); // 이미지 사이즈구함
    $imgW = $sz[0];
    $imgH = $sz[1];
    
    return array($imgW, $imgH);
}

//파일 확장자로 이미지 가져오기
function get_ext_image($inFilename){
    $reFile_name = strtolower(substr(strrchr($inFilename, "."), 1));
    
    Switch ($reFile_name) {
        case "":
            if($inFilename) {
                $iconimage = "icon_file_etc.gif";
            }else{
                $iconimage = "none.gif";
            }
            break;
        case "zip":
            $iconimage = "icon_file_zip.gif";
            break;
        case "alz":
            $iconimage = "icon_file_zip.gif";
            break;
        case "hwp":
            $iconimage = "icon_file_hwp.gif";
            break;
        case "xls":
            $iconimage = "icon_file_excel.gif";
            break;
        case "csv":
            $iconimage = "icon_file_excel.gif";
            break;
        case "doc":
            $iconimage = "icon_file_doc.gif";
            break;
        case "txt":
            $iconimage = "icon_file_doc.gif";
            break;
        case "jpg":
            $iconimage = "icon_file_img.gif";
            break;
        case "gif":
            $iconimage = "icon_file_img.gif";
            break;
        case "bmp":
            $iconimage = "icon_file_img.gif";
            break;
        case "jpeg":
            $iconimage = "icon_file_img.gif";
            break;
        case "pdf":
            $iconimage = "icon_file_pdf.gif";
            break;
        default :
            $iconimage = "icon_file_etc.gif";
    }
    return $iconimage;
}

//업로드 파일 난수 생성
function makeRandUpload($len=8) {
    if(!is_int($len) || ($len < 8)) {
        $len = 8;
    }
    $arr = array_merge(range(1, 9));
    
    $rand = false;
    for($i=0; $i<$len; $i++) {
        $rand .= $arr[mt_rand(0,count($arr)-1)];
    }
    return $rand;
}

//난수 생성
function makeRand($len=20) {
    if(!is_int($len) || ($len < 20)) {
        $len = 20;
    }
    $arr = array_merge(range('A', 'Z'), range('z', 'a'), range(1, 9));
    
    $rand = false;
    for($i=0; $i<$len; $i++) {
        $rand .= $arr[mt_rand(0,count($arr)-1)];
    }
    return $rand;
}

function makeRandOrderNum($len=3) {
    if(!is_int($len) || ($len < 3)) {
        $len = 3;
    }
    $arr = array_merge(range(0, 9));
    
    $rand = false;
    for($i=0; $i<$len; $i++) {
        $rand .= $arr[mt_rand(0,count($arr)-1)];
    }
    return $rand;
}


##############################################
# 암호화
##############################################
function bytexor($a,$b){
    $c="";
    for($i=0;$i<16;$i++)$c.=$a{$i}^$b{$i};
    return $c;
}

function decrypt_md5($msg,$key = "GSJOI"){
    $string="";
    $buffer="";
    $key2="";
    
    $msg = base64_decode($msg);
    while($msg){
        $key2=pack("H*",md5($key.$key2.$buffer));
        $buffer=bytexor(substr($msg,0,16),$key2);
        $string.=$buffer;
        $msg=substr($msg,16);
    }
    return($string);
}

function encrypt_md5($msg,$key = "GSJOI"){
    $string="";
    $buffer="";
    $key2="";
    
    while($msg){
        $key2=pack("H*",md5($key.$key2.$buffer));
        $buffer=substr($msg,0,16);
        $string.=bytexor($buffer,$key2);
        $msg=substr($msg,16);
    }
    return(base64_encode($string) );
}

function encrypt_SHA256($str) {
    $planBytes = array_slice(unpack('c*',$str), 0); // 평문을 바이트 배열로 변환
    $ret = null;
    $bszChiperText = null;
    KISA_SEED_SHA256::SHA256_Encrypt($planBytes, count($planBytes), $bszChiperText);
    $r = count($bszChiperText);
    
    foreach($bszChiperText as $encryptedString) {
        $ret .= bin2hex(chr($encryptedString)); // 암호화된 16진수 스트링 추가 저장
    }
    return $ret;
}


##############################################
# SQL INJECTION 체그 함수
##############################################
function Replace_Check($str) {
    $str = trim($str);
    $str = addslashes($str);
    //$str = trim(str_replace("'","\'",$str));
    $str = str_replace("--","",$str);
    //$str = str_replace("%","",$str);
    $str = str_replace(";","",$str);
    $str = str_replace("union","",$str);
    $str = str_replace("select","",$str);
    $str = str_replace("hex","",$str);
    $str = str_replace("unhex","",$str);
    $str = str_replace("version","",$str);
    
    return $str;
}

function Replace_Check_XSS($str) {
    $str = trim($str);
    $str = addslashes($str);
    $str = strtolower($str);
    $str = trim(str_replace("&lt;","",$str));
    $str = trim(str_replace("&gt;","",$str));
    $str = trim(str_replace("<","",$str));
    $str = trim(str_replace(">","",$str));
    $str = str_replace("--","",$str);
    $str = str_replace("%","",$str);
    $str = str_replace(";","",$str);
    //$str = str_replace("error","",$str);
    $str = str_replace("script","",$str);
    $str = str_replace("document","",$str);
    $str = str_replace("form","",$str);
    $str = str_replace("union","",$str);
    $str = str_replace("select","",$str);
    $str = str_replace("hex","",$str);
    $str = str_replace("unhex","",$str);
    $str = str_replace("version","",$str);
    
    return $str;
}

function Replace_Check_XSS2($str) {
    $str = addslashes($str);
    //$str = trim(str_replace("name","",$str));
    //$str = trim(str_replace("NAME","",$str));
    $str = trim(str_replace("<s","&lt;s",$str));
    $str = trim(str_replace("<S","&lt;S",$str));
    $str = trim(str_replace("type","",$str));
    $str = trim(str_replace("TYPE","",$str));
    $str = trim(str_replace("frame","",$str));
    $str = trim(str_replace("FRAME","",$str));
    $str = trim(str_replace("<f","&lt;f",$str));
    $str = trim(str_replace("<F","&lt;F",$str));
    $str = trim(str_replace("submit","",$str));
    $str = trim(str_replace("SUBMIT","",$str));
    $str = str_replace("--","",$str);
    $str = str_replace("error","",$str);
    $str = str_replace("script","",$str);
    $str = str_replace("SCRIPT","",$str);
    $str = str_replace("document","",$str);
    $str = str_replace("union","",$str);
    $str = str_replace("select","",$str);
    $str = str_replace("hex","",$str);
    $str = str_replace("unhex","",$str);
    $str = str_replace("version","",$str);
    
    return $str;
}

function Replace_Check2($str) {
    $str = addslashes($str);
    $str = str_replace("union","",$str);
    $str = str_replace("select","",$str);
    $str = str_replace("hex","",$str);
    $str = str_replace("unhex","",$str);
    $str = str_replace("version","",$str);
    //$str = trim(str_replace("'","''",$str));
    
    return $str;
}

function Replace_Check_sms($str) {
    $str = trim($str);
    $str = addslashes($str);
    $str = str_replace("--","",$str);
    $str = str_replace(";","",$str);
    $str = str_replace("-","",$str);
    $str = str_replace("union","",$str);
    $str = str_replace("select","",$str);
    $str = str_replace("hex","",$str);
    $str = str_replace("unhex","",$str);
    $str = str_replace("version","",$str);
    
    return $str;
}


##############################################
# 메일발송
##############################################
function nmail($fromaddress, $toaddress, $subject, $body, $fromname) {
    //$headers .= "From: <$fromname;$fromaddress>\n"; //메일 보내는 사람
    $headers .= "X-Sender: <$fromaddress>\n"; //보낸 곳
    $headers .= "X-Mailer: PHP\n"; //메일 엔진 이름
    //$headers .= "X-Priority: 1\n"; //긴급 메시지 표시
    $headers .= "Return-Path: <$fromaddress>\n"; //메일보내기 실패했을경우 메일 받을 주소
    $headers .= "Content-Type: text/html; charset=EUC-KR\n"; //HTML 메일 형태일경우에만 추가
    $headers .= "\n\n"; //★★★ 이부분은반드시 추가
    
    $fp = popen('/usr/sbin/sendmail -t -f '.$fromaddress.' '.$toaddress,"w");
    if(!$fp){
        return false;
    }else{
        fputs($fp, "From:$fromname<$fromaddress>\r\n");
        fputs($fp, "To: $toaddress\r\n");
        fputs($fp, "Subject: ".$subject."\r\n");
        fputs($fp, $headers."\r\n");
        fputs($fp, $body);
        fputs($fp, "\r\n\r\n\r\n");
        pclose($fp);
        return true;
    }
}


##############################################
# 별점표시 함수
##############################################
//나의학습실>수강후기 - 별점표시
function StarPointViewA($StarPoint) {
    $StarImgOn = "<img src='/common/img/star_fill.png' alt='' style='width: 20px;'/>";
    $StarImgOff = "<img src='/common/img/star.png' alt='' style='width: 20px;'/>";
    
    $StarPoint2 = "";
    for($i=0;$i<$StarPoint;$i++) {
        $StarPoint2 .= "@";
    }
    
    $Star = str_pad($StarPoint2,5,'*',STR_PAD_RIGHT);
    $Star = str_replace("@",$StarImgOn,$Star);
    $Star = str_replace("*",$StarImgOff,$Star);
    
    return $Star;
}

//메인화면>수강후기 - 별점표시
function StarPointViewB($StarPoint) {
    $StarImgOn = "<img src='/common/img/star_fill.png' alt='' style='width: 15px;'/>";
    $StarImgOff = "<img src='/common/img/star.png' alt='' style='width: 15px;'/>";
    
    $StarPoint2 = "";
    for($i=0;$i<$StarPoint;$i++) {
        $StarPoint2 .= "@";
    }
    
    $Star = str_pad($StarPoint2,5,'*',STR_PAD_RIGHT);
    $Star = str_replace("@",$StarImgOn,$Star);
    $Star = str_replace("*",$StarImgOff,$Star);
    
    return $Star;
}

//메인화면>수강후기 - 별점표시
function StarPointViewC($StarPoint) {
    $StarImgOn = "<img src='/common/img/star_fill.png' alt='' style='width: 25px;'/>";
    $StarImgOff = "<img src='/common/img/star.png' alt='' style='width: 25px;'/>";
    
    $StarPoint2 = "";
    for($i=0;$i<$StarPoint;$i++) {
        $StarPoint2 .= "@";
    }
    
    $Star = str_pad($StarPoint2,5,'*',STR_PAD_RIGHT);
    $Star = str_replace("@",$StarImgOn,$Star);
    $Star = str_replace("*",$StarImgOff,$Star);
    
    return $Star;
}

function StarPointView($StarPoint) {
    $StarImgOn = "<img src='/images/common/icon_review_star03.png' alt='' />";
    $StarImgOff = "<img src='/images/common/icon_review_star01.png' alt='' />";
    
    $StarPoint2 = "";
    for($i=0;$i<$StarPoint;$i++) {
        $StarPoint2 .= "@";
    }
    
    $Star = str_pad($StarPoint2,5,'*',STR_PAD_RIGHT);
    $Star = str_replace("@",$StarImgOn,$Star);
    $Star = str_replace("*",$StarImgOff,$Star);
    
    return $Star;
}

function StarPointAVG($StarPoint) {
    $StarImgOn = "<img src='/images/common/icon_review_star03.png' />";
    $StarImgHalf = "<img src='/images/common/icon_review_star02.png' />";
    $StarImgOff = "<img src='/images/common/icon_review_star01.png' />";
    
    $StarPoint2 = "";
    for($i=0;$i<(int)$StarPoint;$i++) {
        $StarPoint2 .= "@";
    }
    
    if(($StarPoint-(int)$StarPoint)>0) {
        $StarPoint2 .= "^";
    }
    
    $Star = str_pad($StarPoint2,5,'*',STR_PAD_RIGHT);
    $Star = str_replace("@",$StarImgOn,$Star);
    $Star = str_replace("^",$StarImgHalf,$Star);
    $Star = str_replace("*",$StarImgOff,$Star);
    
    return $Star;
}


##############################################
# 기타 함수
##############################################
// 단순히 띄우는 경고메시지
function alert($msg,$mode = 0) {
    echo "<script language=javascript>";
    echo "alert('$msg'); ";
    if($mode){
        echo "self.close();";
        exit;
    }
    echo "</script>";
}

//비밀번호 난수 생성
function Pwd_makeRand($len=8) {
    if(!is_int($len) || ($len < 8)) {
        $len = 8;
    }
    $arr = array_merge(range(0, 9));
    
    $rand = false;
    for($i=0; $i<$len; $i++) {
        $rand .= $arr[mt_rand(0,count($arr)-1)];
    }
    return $rand;
}

function max_number($mf,$tb){
    global $connect;
    
    $query_select = "SELECT MAX($mf) FROM $tb";
    $result_select = mysqli_query($connect, $query_select);
    $row_select = mysqli_fetch_array($result_select);
    $max_no = $row_select[0];
    
    return $max_no + 1;
}

function max_number_package(){
    global $connect;
    
    $query_select = "SELECT MAX(PackageRef) FROM Course WHERE PackageYN='Y'";
    $result_select = mysqli_query($connect, $query_select);
    $row_select = mysqli_fetch_array($result_select);
    $max_no = $row_select[0];
    
    return $max_no + 1;
}

function DeptStringNaming($DeptString) {
    global $connect;
    
    $DeptString_Array = explode("|",$DeptString);
    $DeptStringName = "";
    
    foreach($DeptString_Array as $DeptString_value) {
        $DeptString_value2 = trim($DeptString_value);
        
        if($DeptString_value2) {
            $Sql = "SELECT DeptName FROM DeptStructure WHERE idx=$DeptString_value2";
            $Result = mysqli_query($connect, $Sql);
            $Row = mysqli_fetch_array($Result);
            if($Row) {
                if(!$DeptStringName) {
                    $DeptStringName = $Row['DeptName'];
                }else{
                    $DeptStringName = $DeptStringName." > ".$Row['DeptName'];
                }
            }
        }
    }
    return $DeptStringName;
}

function PackageRefLeftString($PackageRef) {
    $Ref = str_pad($PackageRef,3,'0',STR_PAD_LEFT);
    return $Ref;
}

function ReviewIDView($ID,$len) {
    $ID = substr($ID,0,3);
    $IDView = str_pad($ID,$len,'*',STR_PAD_RIGHT);
    return $IDView;
}

//정보 마스킹 처리
function InformationProtection($str,$data_type,$view_mode) {
    if($view_mode=="S") {
        if($str) {
            switch ($data_type) {
                case "Email":
                    $Email_Array = explode("@",$str);
                    $Email01 = $Email_Array[0];
                    $Email02 = $Email_Array[1];
                    $str = "*******@".$Email02;
                    break;
                case "Mobile":
                    $Mobile_Array = explode("-",$str);
                    $Mobile01 = $Mobile_Array[0];
                    $Mobile02 = $Mobile_Array[1];
                    $Mobile03 = $Mobile_Array[2];
                    $str = $Mobile01."-****-".$Mobile03;
                    break;
                case "Mobile2":
                    $Mobile01 = substr($str, 0,3);
                    $Mobile03 = substr($str, 7,4);
                    $str = $Mobile01."-****-".$Mobile03;
                    break;
                case "BirthDay":
                    $BirthDay_Array = explode("-",$str);
                    $BirthDay01 = $BirthDay_Array[0];
                    $BirthDay02 = $BirthDay_Array[1];
                    $BirthDay03 = $BirthDay_Array[2];
                    $str = $BirthDay01."-****-".$BirthDay03;
                    break;
                case "Tel":
                    $Tel_Array = explode("-",$str);
                    $Tel01 = $Tel_Array[0];
                    $Tel02 = $Tel_Array[1];
                    $Tel03 = $Tel_Array[2];
                    $str = $Tel01."-****-".$Tel03;
                    break;
            }
        }else{
            $str = "";
        }
        return $str;
    }else{
        return $str;
    }
}

function StudyProgressStatus($ServiceType,$LectureCode,$Study_Seq) {
    global $connect;
    global $LoginMemberID;
    
    $NowDate = date('Y-m-d');
    $Sql = "SELECT a.*, a.Seq AS Study_Seq, a.MidSaveTime, a.TestSaveTime, a.ReportSaveTime, a.MidIP, a.TestIP, a.ReportIP, a.TestStatus, a.Survey, a.PassOk, a.StudyEnd
                   ,b.PreviewImage, b.ContentsName, b.idx AS Course_idx, b.Mobile, b.Chapter, b.Limited, b.PassProgress, b.TotalPassMid, b.MidRate, b.TotalPassTest, b.TestRate, b.TotalPassReport, b.ReportRate, b.PassScore, b.attachFile, b.ctype, b.Professor
                   ,c.CategoryName AS Category1Name, c.idx AS Category1_idx
                   ,d.CategoryName AS Category2Name, d.idx AS Category2_idx
                   ,e.Name AS TutorName
                   ,(SELECT COUNT(idx) FROM Progress WHERE ID='$LoginMemberID' AND LectureCode=a.LectureCode AND Study_Seq=a.Seq) AS ProgressCount
                   ,(SELECT COUNT(idx) FROM PaymentSheet WHERE CompanyCode=a.CompanyCode AND LectureStart=a.LectureStart AND LectureEnd=a.LectureEnd AND PayStatus='Y') AS PaymentCount
            FROM Study AS a
            LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode
            LEFT OUTER JOIN CourseCategory AS c ON b.Category1=c.idx
            LEFT OUTER JOIN CourseCategory AS d ON b.Category2=d.idx
            LEFT OUTER JOIN StaffInfo AS e ON a.Tutor=e.ID
            WHERE a.ID='$LoginMemberID' AND a.Seq=$Study_Seq";
    $Result = mysqli_query($connect, $Sql);
    $Row = mysqli_fetch_array($Result);
    if($Row) {
        $ContentsName = $Row['ContentsName'];
        $ProgressCount = $Row['ProgressCount'];
        $Chapter = $Row['Chapter'];
        $Progress = $Row['Progress'];
        $PassProgress = $Row['PassProgress'];
        $MidStatus = $Row['MidStatus'];
        $MidSaveTime = $Row['MidSaveTime'];
        $MidScore = $Row['MidScore'];
        $MidRate = $Row['MidRate'];
        $TestStatus = $Row['TestStatus'];
        $TestScore = $Row['TestScore'];
        $TestRate = $Row['TestRate'];
        $TestSaveTime = $Row['TestSaveTime'];
        $ReportStatus = $Row['ReportStatus'];
        $ReportScore = $Row['ReportScore'];
        $ReportRate = $Row['ReportRate'];
        $ReportSaveTime = $Row['ReportSaveTime'];
        $Survey = $Row['Survey'];
        $ResultView = $Row['ResultView'];
        $PassOk = $Row['PassOk'];
        $StudyEnd = $Row['StudyEnd'];
    }
    
    $LectureStudy = "Y"; //수강가능 초기값
    $MidTestOk = "N"; //중간평가 존재여부 초기값
    $TestOk = "N"; //최종평가 존재여부 초기값
    $ReportOk = "N"; //과제 존재여부 초기값
    $SurveyView = "N"; //설문조사 노출 초기값
    $SurveyStudy = "N"; //설문조사 가능여부 초기값
    $MidTestStudy = "N";
    $TestStudy = "N";
    $ReportStudy = "N";
    
    $Status_msg01 = "";
    $Status_msg02 = "";
    $Status_msg03 = "";
    
    if($ServiceType=="3") $ServiceTypeWhere = " AND a.ChapterType='A' ";
    
    $Sql = "SELECT COUNT(*) FROM Chapter WHERE LectureCode='$LectureCode' AND ChapterType='A'";
    $Result = mysqli_query($connect, $Sql);
    $Row = mysqli_fetch_array($Result);
    $ChapterCount = $Row[0];
    
    $k = $ChapterCount;
    
    // Brad(2021.12.19) : 쿼리 수정 - ChapterType='A' OR 추가
    $SQL2 = "SELECT a.Seq AS Chapter_Seq, a.ChapterType, a.OrderByNum, a.Sub_idx
                    ,b.Gubun AS ContentGubun, b.ContentsTitle, b.idx AS Contents_idx, b.LectureTime
                    ,c.Progress AS ChapterProgress, c.UserIP AS ChapterUserIP, c.RegDate AS ChapterRegDate, c.StudyTime, c.Study_Seq
                    ,(SELECT Seq FROM Chapter WHERE LectureCode='$LectureCode' AND (ChapterType='A' OR ChapterType='C' OR ChapterType='D') ORDER BY OrderByNum DESC LIMIT 0,1) AS Max_Seq
            FROM Chapter AS a
            LEFT OUTER JOIN Contents AS b ON a.Sub_idx=b.idx
            LEFT OUTER JOIN Progress AS c ON a.Seq=c.Chapter_Seq AND b.idx=c.Contents_idx AND c.ID='$LoginMemberID' AND c.LectureCode='$LectureCode' AND c.Study_Seq=$Study_Seq
            WHERE a.LectureCode='$LectureCode' $ServiceTypeWhere
            ORDER BY a.OrderByNum DESC";
    // echo $SQL2;
    $QUERY2 = mysqli_query($connect, $SQL2);
    if($QUERY2 && mysqli_num_rows($QUERY2)){
        while($ROW2 = mysqli_fetch_array($QUERY2)){
            //강의 차시인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            if($ROW2['ChapterType']=="A") {
                if($ROW2['StudyTime']<1) $PlayMode = "S";
                else $PlayMode = "C";
                
                if($ROW2['ChapterProgress']==0) {
                    $Status_msg01 = $k."차시";
                    $Status_msg02 = "수강대기중";
                    $Status_msg03 = "A#".$k."#".$LectureCode."#".$Study_Seq."#".$ROW2['Chapter_Seq']."#".$ROW2['Contents_idx']."#".$PlayMode;
                }
                
                // Brad (2021.12.15) : 이어보기 수정
                // if (($ROW2['ChapterProgress']>0 && $ROW2['ChapterProgress']<100) || ($ROW2['LectureTime'] > $CompleteTime)) {
                if ($ROW2['ChapterProgress']>0 && $ROW2['ChapterProgress']<100) {
                    $Status_msg01 = $k."차시";
                    //$Status_msg02 = Sec_To_m($ROW2['StudyTime'])." 수강중";
                    $Status_msg02 = Sec_To_His($ROW2['StudyTime'])."<br>수강중";
                    $Status_msg03 = "A#".$k."#".$LectureCode."#".$Study_Seq."#".$ROW2['Chapter_Seq']."#".$ROW2['Contents_idx']."#".$PlayMode;
                }
                
                // 23.05.01. 차시수강시간 , 총수강시간(초)
                //echo "<!-- $Study_Seq == $ROW2[Study_Seq] , $ROW2[LectureCode] , $ROW2[StudyTime] , $ROW2[LectureTime] -->";
                if ($Status_msg04=="" && $Study_Seq == $ROW2["Study_Seq"]) {
                    $Status_msg04 = $ROW2['StudyTime'] . "," . $ROW2['LectureTime']*60;
                }
                
                $k--;
            }
            
            //중간평가인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            if($ROW2['ChapterType']=="B") {
                $MidTestOk = "Y"; //중간평가가 존재하는 경우 Y로 설정(최종평가와 과제 응시 체크를 위해)
                
                //중간평가를 볼수 있는 진도율
                if($LectureCode=="W9500") $MidTestProgress = 47; //NCS기반 병원안내 실무2 만 47%
                else $MidTestProgress = 50;
                
                if($Progress<$MidTestProgress) { //중간평가는 진도율 50%이상만 응시가능
                    $MidTest_msg = "진도부족";
                    $MidTestStudy = "N";
                    $LectureStudy = "N";
                }else{
                    switch($MidStatus) { //중간평가 상태
                        case "C": //채점 완료
                            $MidRatePercent = $MidScore * $MidRate / 100;
                            $MidTest_msg = $MidScore."점(".$MidRatePercent ."%)";
                            $MidTestStudy = "N";
                            $LectureStudy = "Y";
                            break;
                        case "N": //미응시
                            $MidTest_msg = "응시가능";
                            $MidTestStudy = "Y";
                            $LectureStudy = "N";
                            break;
                        case "Y": //응시완료
                            $MidTest_msg = "응시완료<BR>(채점중)";
                            $MidTestStudy = "N";
                            $LectureStudy = "Y";
                            break;
                    }
                }
                
                if($MidTestStudy=="Y") {
                    $Status_msg01 = "중간평가";
                    $Status_msg02 = "미응시";
                    $Status_msg03 = "B#".$Study_Seq."#".$LectureCode."#".$ROW2['Chapter_Seq'];
                }
            }
            
            //최종평가인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            if($ROW2['ChapterType']=="C") {
                $TestOk = "Y"; //최종평가가 존재하는 경우 Y로 설정(과제 응시 체크를 위해)
                
                if($Progress<$PassProgress) { //최종평가는 진도율이 수료기준 진도율 이상만 응시가능
                    $Test_msg = "진도부족";
                    $TestStudy = "N";
                    $LectureStudy = "N";
                }else{
                    if($MidTestOk == "Y" && $MidStatus=="N") { //중간평가가 있고 미응시 했다면 최종평가 불가
                        $Test_msg = "중간평가 미응시";
                        $TestStudy = "N";
                        $LectureStudy = "N";
                    }else{
                        switch($TestStatus) { //최종평가 상태
                            case "C": //채점완료
                                $TestRatePercent = $TestScore * $TestRate / 100;
                                $Test_msg = $TestScore."점(".$TestRatePercent ."%)";
                                $TestStudy = "N";
                                $LectureStudy = "Y";
                                break;
                            case "N": //미응시
                                $Test_msg = "응시가능";
                                $TestStudy = "Y";
                                $LectureStudy = "N";
                                break;
                            case "Y": //응시완료
                                $Test_msg = "응시완료<BR>(채점중)";
                                $TestStudy = "N";
                                $LectureStudy = "Y";
                                break;
                        }
                    }
                    
                    //설문을 노출시키기 위한 조건
                    if(($ROW2['Max_Seq']==$ROW2['Chapter_Seq']) && ($TestStatus=="C" || $TestStatus=="Y")) $SurveyView = "Y";
                }
                if($TestStudy=="Y") {
                    $Status_msg01 = "최종평가";
                    $Status_msg02 = "미응시";
                    $Status_msg03 = "C#".$Study_Seq."#".$LectureCode."#".$ROW2['Chapter_Seq'];
                }
            }
            
            //과제인 경우++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
            if($ROW2['ChapterType']=="D") {
                $ReportOk = "N"; //과제가 존재하는 경우 Y로 설정
                
                if($Progress<$PassProgress) { //과제는 진도율이 수료기준 진도율 이상만 응시가능
                    $Report_msg = "진도부족";
                    $ReportStudy = "N";
                    $LectureStudy = "N";
                }else{
                    if($TestOk == "Y" && $TestStatus=="N") { //최종평가가 있고 미응시 했다면 과제 불가
                        $Report_msg = "최종평가 미응시";
                        $ReportStudy = "N";
                        $LectureStudy = "N";
                    }else{
                        switch($ReportStatus) {
                            case "C":
                                $ReportRatePercent = $ReportScore * $ReportRate / 100;
                                $Report_msg = $ReportScore."점(".$ReportRatePercent ."%)";
                                $ReportStudy = "N";
                                $LectureStudy = "Y";
                                break;
                            case "N":
                                $Report_msg = "응시가능";
                                $ReportStudy = "Y";
                                $LectureStudy = "N";
                                break;
                            case "Y":
                                $Report_msg = "제출완료<BR>(채점중)";
                                $ReportStudy = "N";
                                $LectureStudy = "Y";
                                break;
                        }
                    }
                    
                    //설문을 노출시키기 위한 조건
                    if(($ROW2['Max_Seq']==$ROW2['Chapter_Seq']) && ($ReportStatus=="C" || $ReportStatus=="Y")) $SurveyView = "Y";
                }
                
                if($ReportStudy=="Y") {
                    $Status_msg01 = "과제";
                    $Status_msg02 = "미응시";
                    $Status_msg03 = "D#".$Study_Seq."#".$LectureCode."#".$ROW2['Chapter_Seq'];
                }
            }
        }
    }
    
    if($SurveyView == "Y") {
        switch($Survey) {
            case "N":
                $Survey_msg = "(미작성)";
                $SurveyStudy = "Y";
                break;
            case "Y":
                $Survey_msg = "(채점대기중)";
                $SurveyStudy = "E";
                break;
        }
        if($SurveyStudy=="Y") {
            $Status_msg01 = "설문조사";
            $Status_msg02 = $Survey_msg;
            $Status_msg03 = "E#".$Study_Seq."#".$LectureCode;
        }
        if($SurveyStudy=="E") {
            $Status_msg01 = "학습완료";
            $Status_msg02 = $Survey_msg;
            $Status_msg03 = "F#";
        }
        if($ResultView=="Y") {
            if($PassOk=="Y") {
                $Status_msg01 = "수료";
                $Status_msg02 = "";
                $Status_msg03 = "G#".$Study_Seq;
            }else{
                $Status_msg01 = "미수료";
                $Status_msg02 = "";
                $Status_msg03 = "H#";
            }
        }
    }
    return $Status_msg01."|".$Status_msg02."|".$Status_msg03."|".$Status_msg04;
}
?>