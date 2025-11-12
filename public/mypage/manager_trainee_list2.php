<?
include "../../include/include_function.php";
include "../../include/login_check.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="ko" lang="ko">
<head>
<title><?=$HTML_TITLE?><?=$SiteName?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Expires" content="-1"> 
<meta http-equiv="Pragma" content="no-cache"> 
<meta http-equiv="Cache-Control" content="No-Cache"> 
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
<meta http-equiv="imagetoolbar" content="no" />
<link rel="stylesheet" href="/common/css/base.css?ver=240418">
<link rel="stylesheet" href="css/style.css">
<link rel="stylesheet" type="text/css" href="/include/jquery-ui.css" />
<script type="text/javascript">
<!--
var browser = "<?=$browser?>";
//-->
</script>
<!-- <script type="text/javascript" src="/include/jquery-1.11.0.min.js"></script> -->
<script type="text/javascript" src="/include/jquery-3.5.1.min.js"></script>
<script type="text/javascript" src="/include/jquery-ui.js"></script>
<script type="text/javascript" src="/include/jquery.ui.datepicker-ko.js"></script>
<script type="text/javascript" src="/include/function.js?t=<?=date('YmdHis')?>"></script>
<script type="text/javascript" src="/include/jquery.bxslider.min.js"></script>
</head>
<body>
<form name="ExcelForm" method="POST" action="manager_trainee_excel.php" target="_blank">
<input type="hidden" name="col" value="<?=$col?>">
<input type="hidden" name="sw" value="<?=$sw?>">
<input type="hidden" name="orderby" value="<?=$orderby?>">
<input type="hidden" name="LectureStart" value="<?=$LectureStart?>">
<input type="hidden" name="LectureEnd" value="<?=$LectureEnd?>">
<input type="hidden" name="LectureCode" value="<?=$LectureCode?>">
<input type="hidden" name="PassOk" value="<?=$PassOk?>">
<input type="hidden" name="CompanyCode" value="<?=$CompanyCode?>">
</form>
	<div id="wrap">
    
    	<div class="popupArea">
        	<!-- close -->
            <!-- <div class="close"><a href="Javascript:self.close();"><img src="/images/common/btn_close01.png" alt="창닫기" /></a></div>  -->
       	  	<!-- title -->
            <div class="popName">수강현황</div>
            <!-- info Area -->
            <div class="infoArea">
            	
                <!-- ########## -->
            	<div class="managerTxt">
                    <p class="term">2025-01-01 ~ 2025-06-01 개강</p>
                  <p class="title"><?=$ContentsName?></p>
                </div>                
				<div class="search mt20">
                    <span>
						<select name="col" id="col" class="wid150">
                			<option value="c.Name" <?if($col=="c.Name") {?>selected<?}?>>과정명</option>
                		</select>
                	</span>
                    <span><input type="text" name="sw" id="sw" class="wid200" placeholder="검색어 입력" /></span>
                    <span class="btn"><a href="Javascript:ManagerSearchOk();">검색</a></span>
                </div>
				<!-- list -->
                <div class="mt20">
                	<table cellpadding="0" cellspacing="0" class="taList_ty01">
                	  <caption>수강현황 목록</caption>
                	  <colgroup>
                	    <col width="*" />
                	    <col width="13%" />
                        <col width="*" />
                        <col width="17%" />
                        <col width="17%" />
                        <col width="17%" />
                        <col width="8%" />
                	  </colgroup>
                	  <tr>
                	    <th>과정구분</th>
                	    <th>이름<br />아이디</th>
                	    <th>과정명</th>
                	    <th>진도율</th>
                	    <th>수강시간</th>
                	    <th>학습시작일</th>
                	    <th>학습종료일</th>
                	  </tr>
					  <tr>
                	  	<td class="tc">이러닝</td>
                	  	<td class="tc">윤희상<br>hrde01</td>
                	  	<td class="tc">2024_퇴직연금교육</td>
                	  	<td class="tc">100%</td>
                	  	<td class="tc">00:55:10</td>
                	  	<td class="tc">2025-01-02</td>
                	  	<td class="tc">2025-01-05</td>
               	      </tr>
               	      <tr>
                	  	<td class="tc">마이크로닝</td>
                	  	<td class="tc">윤희상<br>hrde01</td>
                	  	<td class="tc">2024_직장 내 성희롱 예방교육</td>
                	  	<td class="tc">50%</td>
                	  	<td class="tc">00:25:15</td>
                	  	<td class="tc">2025-01-02</td>
                	  	<td class="tc">2025-01-07</td>
               	      </tr>
               	      <tr>
                	  	<td class="tc">숏폼</td>
                	  	<td class="tc">윤희상<br>hrde01</td>
                	  	<td class="tc">스마트폰 중독 예방교육</td>
                	  	<td class="tc">100%</td>
                	  	<td class="tc">00:20:10</td>
                	  	<td class="tc">2025-01-02</td>
                	  	<td class="tc">2025-01-02</td>
               	      </tr>
               	      <tr>
                	  	<td class="tc">이러닝</td>
                	  	<td class="tc">윤희상<br>hrde01</td>
                	  	<td class="tc">어린이집_아동학대신고의무자교육_아동권리보장원</td>
                	  	<td class="tc">100%</td>
                	  	<td class="tc">00:55:10</td>
                	  	<td class="tc">2025-01-02</td>
                	  	<td class="tc">2025-01-05</td>
               	      </tr>
               	      <tr>
                	  	<th colspan="7">최종수강시간 : 2시간 35분 30초 / 수료여부 : 미수료</th>
               	      </tr>
                	</table>
                </div>
                <!-- list // -->
                
                <!-- btn -->
                <div class="btnAreaTl03">
                	<span class="btnSky01"><a href="Javascript:ManagerExcelOut();">검색항목 엑셀출력</a></span>
                </div>
                <!-- ########## // -->
                
            </div>
            <!-- info Area -->
        </div>

	</div>

</body>
</html>
