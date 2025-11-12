<?
include "../m_include/include_function.php"; //DB연결 및 각종 함수 정의
include "../m_include/login_check.php"; //로그인 여부 체크

$LectureCode = Replace_Check_XSS2($LectureCode);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>수강후기 등록</title>
    <script type="text/javascript" src="../m_common/js/jquery-2.1.4.js"></script>
    <link rel="stylesheet" href="../m_common/css/base.css">
    <link rel="stylesheet" href="../m_public/mypage/css/player.css">
    <script src="/include/jquery-1.11.0.min.js"></script>
    <script type="text/javascript" src="../m_include/function.js?t=<?=date('YmdHis')?>"></script>
</head>
<body>
<div class="layerArea">
    <div class="top_logo"><a href="/m_archive/contents/main.html"><img src="../m_common/img/logo.png" alt="logo"></a></div>
	<div class="title">수강후기 등록</div>
	<div class="infoArea">
		<div class="comment_1">
			<ul><li>등록하신 수강후기는 <span class="fcSky01B">나의학습실 &gt; 수강후기</span>에서 확인하실 수 있습니다.</li></ul>
		</div>
		<form name="SurveyForm" method="POST" action="/m_player/survey_ok.php" target="ScriptFrame">
    		<input type="hidden" name="LectureCode" id="LectureCode" value="<?=$LectureCode?>">
    		<div class="info mt20">
    			<table cellpadding="0" class="pan_reg">
    			  <colgroup>
    				  <col width="16%" />
    				  <col width="" />
    			  </colgroup>
    			  <tr>
    				<td class="item">제목</td>
    				<td><input type="text" name="Title" id="Title" placeholder="제목 입력" class="widp100" /></td>
    			  </tr>
    			  <tr>
    				<td class="item">별점</td>
    				<td>
    					<select name="StarPoint" id="StarPoint"  class="wid400">
    						<option value="">선택하세요</option>
    					<?
                        $i = 5;
                        while ($i > 0) {
                        ?>
                            <option value="<?=$i?>"><?=$i?>점</option>
                        <?
                            $i--;
                        }
                        ?>
    					</select>
    				</td>
    			  </tr>
    			  <tr>
    				<td colspan="2"><textarea name="Contents" id="Contents" rows="14" class="widp100" placeholder="내용 입력"></textarea></td>
    			  </tr>
    			</table>
    		</div>
		</form>
		
		<!-- btn -->
		<p class="btnAreaTc02" id="SubmitBtn"><span class="btnSmSky01"><a href="Javascript:uploadSurvey();">등록하기</a></span></p>
		<p id="WaitMag" style="display:none"><br>처리중입니다. 기다려 주세요.</p>
		<!-- area // --> 
	</div>
</div>
</body>
</html>