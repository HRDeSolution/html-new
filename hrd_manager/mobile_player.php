<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$url = Replace_Check($url);
$sel = Replace_Check($sel);

if($sel=="A") {
    (strpos($url, "https://") === 0)? $MobilePath = $url : $MobilePath = $MobileServerURL.$url;
}else{
	$MobilePath = $url;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<title>:: <?=$SiteName?> ::</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" href="./css/style.css" />
<link rel="stylesheet" type="text/css" href="/include/jquery-ui.css" />
<script type="text/javascript" src="/include/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/include/jquery-ui.js"></script>
<script type="text/javascript" src="/include/jquery.ui.datepicker-ko.js"></script>
<script type="text/javascript" src="/include/function.js"></script>
</head>

<body>
<table border="0" width="800" height="600">
<tr>
	<td style="text-align:center; vertical-align:bottom;background:#fff;">
	<?if($sel=="A") {?>
	<video id="myVideo" width="800" height="600" controls autoplay>
		<source id="videoSource" src="<?=$MobilePath?>" type="video/mp4"> 
	</video>
    <div id="currentUrl" style="margin-bottom: 10px; font-weight: bold; font-size: 14px;"> URL: </div>
    <button onclick="goPrev()">◀ 이전 차시</button>
    <button onclick="goNext()">다음 차시 ▶</button>
	<?}else{?>
	<iframe src="<?=$MobilePath?>" width="800" height="600" frameborder="0" allow="autoplay; fullscreen" allowfullscreen></iframe>

	<?}?>
	</td>
</tr>
</table>
</body>
</html>


<script>
function updateUrlDisplay(url) {
    document.getElementById('currentUrl').innerText = "URL: " + url;
}

function changeVideo(toNext = true) {
    const video = document.getElementById('myVideo');
    const source = document.getElementById('videoSource');
    let currentSrc = source.src;

    let match = currentSrc.match(/(\/)(\d+)(\.mp4)$/);
    if (match) {
        let currentNum = parseInt(match[2], 10);
        let newNum = toNext ? currentNum + 1 : currentNum - 1;

        if (newNum < 1) {
            alert("이전 차시가 없습니다.");
            return;
        }

        let newNumStr = newNum.toString().padStart(2, '0');
        let newSrc = currentSrc.replace(/\/\d+\.mp4$/, '/' + newNumStr + '.mp4');

        fetch(newSrc, { method: 'HEAD' })
        .then(res => {
            if (res.ok) {
                source.src = newSrc;
                video.load();
                video.play();
                updateUrlDisplay(newSrc); 
            } else {
                alert(toNext ? "마지막 차시입니다." : "이전 차시가 없습니다.");
            }
        })
        .catch(() => {
            alert(toNext ? "마지막 차시입니다." : "이전 차시가 없습니다.");
        });
    } else {
        alert("영상 경로를 인식할 수 없습니다.");
    }
}

function goNext() {
    changeVideo(true);
}

function goPrev() {
    changeVideo(false);
}

// 페이지 처음 로드 시에도 초기 URL 반영
window.onload = function() {
    const firstSrc = document.getElementById('videoSource').src;
    updateUrlDisplay(firstSrc);
};
</script>