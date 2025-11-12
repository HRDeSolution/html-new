<?
include "../include/include_function.php";
include "./include/include_admin_check.php";

$ID = Replace_Check($ID);

$Sql = "SELECT *, AES_DECRYPT(UNHEX(Email),'$DB_Enc_Key') AS Email,
                 AES_DECRYPT(UNHEX(Mobile),'$DB_Enc_Key') AS Mobile, 
                 AES_DECRYPT(UNHEX(Tel),'$DB_Enc_Key') AS Tel, 
                 AES_DECRYPT(UNHEX(BirthDay),'$DB_Enc_Key') AS BirthDay 
        FROM Member WHERE ID='$ID'";
//echo $Sql;
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
if($Row) {
	$ID = $Row['ID']; //아이디
	$Name = $Row['Name']; //이름
	$BirthDay = $Row['BirthDay']; //생년월일
	$Gender = $Row['Gender']; //성별
	$Email = $Row['Email']; //이메일
	$Tel = $Row['Tel']; //전화번호
	$Mobile = $Row['Mobile']; //휴대폰
	$Zipcode = $Row['Zipcode']; //우편번호
	$Address01 = $Row['Address01']; //주소
	$Address02 = $Row['Address02']; //상세주소
	$NameEng = $Row['NameEng']; //영문 이름
	$CompanyCode = $Row['CompanyCode']; //소속기관 사업자번호
	$Depart = $Row['Depart']; //부서
	$Position = $Row['Position']; //직위
	$Etc01 = $Row['Etc01']; //관심분야
	$Etc02 = $Row['Etc02']; //가입경로
	$Mailling = $Row['Mailling']; //메일링
	$ACS = $Row['ACS']; //ACS
	$UseYN = $Row['UseYN']; //계정 사용유무
	$RegDate = $Row['RegDate']; //가입일
	$EditDate = $Row['EditDate']; //최종 수정일
	$EduManager = $Row['EduManager']; //교육담당자 여부
	$ProtectID = $Row['ProtectID']; //대리수강 방지
	$Marketing= $Row['Marketing']; //마케팅 수신동의
	$CardName = $Row['CardName'];
	$CardNumber = $Row['CardNumber'];

	$Email = InformationProtection($Email,'Email','S');
	$Mobile = InformationProtection($Mobile,'Mobile','S');
	$Tel = InformationProtection($Tel,'Tel','S');
	$BirthDay = InformationProtection($BirthDay,'BirthDay','S');
}

$Login_token = makeRand(); //현재 아이디로 로그인시 검증용 토큰 생성
$_SESSION["Login_token"] = $Login_token;
?>
<div class="Content">
	<div class="contentBody">
    	<!-- 수강생 상세 정보 -->
        <h2>수강생 상세 정보</h2>
        <div class="conZone">
			<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01">
	  			<colgroup>
            		<col width="9%" />
            		<col width="16%" />
            		<col width="9%" />
            		<col width="16%" />
            		<col width="9%" />
            		<col width="16%" />
            		<col width="9%" />
            		<col width="16%" />
	  			</colgroup>
        		<tr>
        			<th>아이디</th>
        			<td> <?=$ID?> <?if($UseYN=="N") {?>[미사용 계정]<?}?></td>
        			<th>이름</th>
        			<td> <?=$Name?></td>
        			<th>성별</th>
        			<td> <?=$Gender_array[$Gender]?></td>
        			<th>이메일</th>
        			<td> <span id="InfoProt_Email"><a href="Javascript:InformationProtection('Member','Email','InfoProt_Email','<?=$ID?>','<?=$_SERVER['PHP_SELF']?>','이메일');"><?=$Email?></a></span></td>
        		</tr>
        		<tr>
        			<th>전화번호</th>
        			<td> <span id="InfoProt_Tel"><a href="Javascript:InformationProtection('Member','Tel','InfoProt_Tel','<?=$ID?>','<?=$_SERVER['PHP_SELF']?>','전화번호');"><?=$Tel?></a></span></td>
        			<th>휴대폰</th>
        			<td> <span id="InfoProt_Mobile"><a href="Javascript:InformationProtection('Member','Mobile','InfoProt_Mobile','<?=$ID?>','<?=$_SERVER['PHP_SELF']?>','휴대폰');"><?=$Mobile?></a></span></td>
        			<th>영문 이름</th>
        			<td> <?=$NameEng?></td>
        			<th>주소</th>
        			<td> [<?=$Zipcode?>] <?=$Address01?> <?=$Address02?></td>
        		</tr>
        		<tr>
        			<th>부서</th>
        			<td> <?=$Depart?></td>
        			<th>직위</th>
        			<td> <?=$Position?></td>
        			<th>관심분야</th>
        			<td> <?=$Etc01?></td>
        			<th>가입경로</th>
        			<td> <?=$Etc02?></td>
        		</tr>
        		<tr>
        			<th>메일링</th>
        			<td> <?=$Mailling?></td>
        			<th>ACS</th>
        			<td> <?=$ACS?></td>
        			<th>가입일</th>
        			<td> <?=$RegDate?></td>
        			<th>교육 담당자</th>
        			<td> <?=$EduManager?></td>
        		</tr>
        		<tr>
        			<th>대리수강<br>방지</th>
        			<td> <?=$ProtectID?></td>
        			<th>마케팅<br>수신동의</th>
        			<td> <?=$CompanySMS_array[$Marketing]?></td>
        			<th>내일배움카드</th>
        			<td> <?=$Card_array[$CardName]?><br><?=$CardNumber?></td>
        			<th> </th>
        			<td>  </td>
        		</tr>
        	</table>
        	<!-- //수강생 상세 정보 -->
        	
        	<!-- 소속 정보 -->
			<?
        	if($CompanyCode) {        
            	$Sql = "SELECT *, (SELECT Name FROM Member WHERE ID=Company.EduManager) AS EduName, (SELECT Name FROM Member WHERE ID=Company.SalesManager) AS SalesName FROM Company WHERE CompanyCode='$CompanyCode' AND Del='N'";
            	//echo $Sql;
            	$Result = mysqli_query($connect, $Sql);
            	$Row = mysqli_fetch_array($Result);
            
            	if($Row) {
            		$CompanyScale = $Row['CompanyScale']; //회사규모
            		$CompanyName = $Row['CompanyName']; //회사명
            		$CompanyID = $Row['CompanyID']; //회사아이디
            		$HRD = $Row['HRD']; //HRD번호
            		$Ceo = $Row['Ceo']; //대표자명
            		$Uptae = $Row['Uptae']; //업태
            		$Upjong = $Row['Upjong']; //업종
            		$Zipcode = $Row['Zipcode']; //우편번호
            		$Address01 = $Row['Address01']; //주소
            		$Address02 = $Row['Address02']; //상세주소
            		$Tel = $Row['Tel']; //대표 연락처
            		$Tel2 = $Row['Tel2']; //고객센터 연락처
            		$Fax = $Row['Fax']; //대표 FAX
            		$Fax2 = $Row['Fax2']; //고객센터 FAX
            		$Email = $Row['Email']; //이메일
            		$BankName = $Row['BankName']; //은행명
            		$BankNumber = $Row['BankNumber']; //계좌번호
            		$CSEnabled = $Row['CSEnabled']; //고객센터 번호 사용여부
            		$CyberEnabled = $Row['CyberEnabled']; //사이버교육센터 사용여부
            		$HomePage = $Row['HomePage']; //홈페이지
            		$CyberURL = $Row['CyberURL']; //사이버교육센터 주소
            		$EduManager = $Row['EduManager']; //교육담당자 아이디
            		$SalesManager = $Row['SalesManager']; //영업담당자 아이디
            		$Remark = $Row['Remark']; //메모
            		$EduManager = $Row['EduManager']; //교육담당자명
            		$EduManagerPhone = $Row['EduManagerPhone']; //교육담당자 연락처
            		$EduManagerEmail = $Row['EduManagerEmail']; //교육담당자 이메일
            		$SalesName = $Row['SalesName']; //영업담당자 이름
            	}
        	?>
			<div class="btnAreaTl02">
				<span class="fs16b fc333B sub_title2">소속 정보</span>
			</div>
			<table width="100%" cellpadding="0" cellspacing="0" class="view_ty01 gapT20">
        		<colgroup>
        			<col width="9%" />
        			<col width="16%" />
        			<col width="9%" />
        			<col width="16%" />
        			<col width="9%" />
        			<col width="16%" />
        			<col width="9%" />
        			<col width="16%" />
        	  </colgroup>
        		<tr>
        			<th>회사 규모</th>
        			<td> <?=$CompanyScale_array[$CompanyScale]?></td>
        			<th>회사명</th>
        			<td> <?=$CompanyName?></td>
        			<th>사업자 번호</th>
        			<td> <?=$CompanyCode?></td>
        			<th>HRD 번호</th>
        			<td> <?=$HRD?></td>
        		</tr>
        		<tr>
        			<th>사업주 ID</th>
        			<td bgcolor="#FFFFFF"> <?=$CompanyID?></td>
        			<th>대표자명</th>
        			<td bgcolor="#FFFFFF"> <?=$Ceo?></td>
        			<th>대표 전화번호</th>
        			<td bgcolor="#FFFFFF"> <?=$Tel?></td>
        			<th>고객센터<br>전화번호</th>
        			<td bgcolor="#FFFFFF"> <?=$Tel2?><br><?if($CSEnabled=="Y") {?><img src="images/checked.gif" align="absmiddle"><?}else{?><img src="images/unchecked.gif" align="absmiddle"><?}?> 사용 여부</td>
        		</tr>
        		<tr>
        			<th>업태</th>
        			<td bgcolor="#FFFFFF"> <?=$Uptae?></td>
        			<th>업종</th>
        			<td bgcolor="#FFFFFF"> <?=$Upjong?></td>
        			<th>대표 팩스번호</th>
        			<td bgcolor="#FFFFFF"> <?=$Fax?></td>
        			<th>고객센터<br>팩스번호</th>
        			<td bgcolor="#FFFFFF"> <?=$Fax2?></td>
        		</tr>
        		<tr>
        			<th>주소</th>
        			<td bgcolor="#FFFFFF"> [<?=$Zipcode?>] <?=$Address01?> <?=$Address02?></td>
        			<th>계좌정보</th>
        			<td bgcolor="#FFFFFF"> <?=$Bank_array[$BankName]?> <?=$BankNumber?></td>
        			<th>이메일</th>
        			<td bgcolor="#FFFFFF"> <?=$Email?></td>
        			<th>홈페이지</th>
        			<td bgcolor="#FFFFFF"> <?=$HomePage?></td>
        		</tr>
        		<tr>
        			<th>교육담당자명</th>
        			<td bgcolor="#FFFFFF"> <?=$EduManager?> / <?=$EduManagerPhone?> / <?=$EduManagerEmail?></td>
        			<th>영업담당자명</th>
        			<td bgcolor="#FFFFFF"> <?=$SalesName?></td>
        			<th>메모</th>
        			<td bgcolor="#FFFFFF"> <?=$Remark?></td>
        			<th>사이버<br>교육센터</th>
        			<td bgcolor="#FFFFFF"> <?=$CyberURL?><br><?if($CyberEnabled=="Y") {?><img src="images/checked.gif" align="absmiddle"><?}else{?><img src="images/unchecked.gif" align="absmiddle"><?}?> 사용 여부</td>
        		</tr>
			</table>
        	<?}?>
        	<!-- //소속 정보 -->
        	
        	<!-- 로그인내역 -->
			<div class="btnAreaTl02">
				<span class="fs16b fc333B sub_title2">로그인 내역</span>
			</div>
			<div id="LoginHistory" style="left:10px; top:20px; width:100%; height:300px; z-index:1; overflow: auto; overflow-x:hidden;">
    			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
    				<colgroup>
        				<col width="100px" />
        				<col width="300px" />
        				<col width="300px" />
        				<col width="150px" />
        				<col width="" />
    			  	</colgroup>
                  	<tr>
        				<th>번호</th>
                        <th>로그인 시각</th>
                        <th>아이피</th>
                        <th>유형</th>
        				<th> </th>
                  	</tr>
        			<?
        			$Sql = "SELECT COUNT(*) FROM LoginHistory WHERE ID='$ID'";
        			$Result = mysqli_query($connect, $Sql);
        			$Row = mysqli_fetch_array($Result);
        			$TOT_NO = $Row[0];
        
        			$SQL = "SELECT ID, IP, RegDate, Device FROM LoginHistory WHERE ID='$ID' ORDER BY RegDate DESC";
        			$QUERY = mysqli_query($connect, $SQL);
        			if($QUERY && mysqli_num_rows($QUERY)){
        				while($ROW = mysqli_fetch_array($QUERY)){
        			?>
        			<tr>
                        <td><?=$TOT_NO--?></td>
        				<td><?=$ROW['RegDate']?></td>
                        <td><?=$ROW['IP']?></td>
        				<td><?=$ROW['Device']?></td>
        				<td> </td>
                      </tr>
        			<?
        				}
        			}else{
        			?>
        			<tr>
        				<td height="50" colspan="5" class="tc">로그인 내역이 없습니다.</td>
        			</tr>
        			<? } ?>
                </table>
    		</div>
    		<!-- //로그인내역 -->

			<!-- 본인인증 내역 -->
			<div class="btnAreaTl02">
				<span class="fs16b fc333B sub_title2">본인인증 내역</span>
			</div>
			<div id="LoginHistory" style="left:10px; top:20px; width:100%; height:300px; z-index:1; overflow: auto; overflow-x:hidden;">
    			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
    				<colgroup>
        				<col width="100px" />
        				<col width="300px" />
        				<col width="300px" />
        				<col width="150px" />
        				<col width="" />
    			  	</colgroup>
                  	<tr>
        				<th>번호</th>
                        <th>교육과정</th>
                        <th>인증시간</th>
        				<th> </th>
                  	</tr>
        			<?
        			$Sql = "SELECT COUNT(*) FROM UserCertOTP WHERE ID='$ID'";
        			$Result = mysqli_query($connect, $Sql);
        			$Row = mysqli_fetch_array($Result);
        			$TOT_NO = $Row[0];
        
        			$SQL = "SELECT a.*, b.ContentsName FROM UserCertOTP AS a LEFT OUTER JOIN Course AS b ON a.LectureCode=b.LectureCode WHERE a.ID='$ID' ORDER BY a.RegDate DESC";
        			$QUERY = mysqli_query($connect, $SQL);
        			if($QUERY && mysqli_num_rows($QUERY)){
        				while($ROW = mysqli_fetch_array($QUERY)){
        			?>
        			<tr>
                        <td><?=$TOT_NO--?></td>
        				<td><?=$ROW['ContentsName']?></td>
                        <td><?=$ROW['RegDate']?></td>
        				<td> </td>
                      </tr>
        			<?
        				}
        			}else{
        			?>
        			<tr>
        				<td height="50" colspan="5" class="tc">본인인증 내역이 없습니다.</td>
        			</tr>
        			<? } ?>
                </table>
			</div>
			<!-- //본인인증 내역 -->
			
			<!-- 1:1문의내역 -->
			<div class="btnAreaTl02">
				<span class="fs16b fc333B sub_title2">1:1 문의 내역</span>
			</div>
			<table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
				<colgroup>
    				<col width="100px" />
    				<col width="150px" />
    				<col width="150px" />
    				<col width="" />
    				<col width="150px" />
    				<col width="80px" />
			  	</colgroup>
              	<tr>
    				<th>번호</th>
                    <th>문의종류</th>
                    <th>이름</th>
                    <th>제목</th>
    				<th>등록일</th>
    				<th>처리상태</th>
              	</tr>
    			<?
    			$Sql = "SELECT COUNT(*) FROM Counsel WHERE ID='$ID'";
    			$Result = mysqli_query($connect, $Sql);
    			$Row = mysqli_fetch_array($Result);
    			$TOT_NO = $Row[0];
    
    			$SQL = "SELECT * FROM Counsel WHERE ID='$ID' AND Del='N' ORDER BY RegDate DESC";
    			$QUERY = mysqli_query($connect, $SQL);
    			if($QUERY && mysqli_num_rows($QUERY)){
    				while($ROW = mysqli_fetch_array($QUERY)){
    			?>
				<tr>
                    <td><?=$TOT_NO--?></td>
    				<td><?=$Counsel_array[$ROW['Category']]?></td>
                    <td><?=$ROW['Name']?></td>
    				<td style="text-align:left"><A HREF="qna_read.php?idx=<?=$ROW['idx']?>" target="_blank"><?=$ROW['Title']?></A></td>
    				<td><?=$ROW['RegDate']?></td>
    				<td><?=$CounselStatus_array[$ROW['Status']]?></td>
				</tr>
    			<?
    				}
    			}else{
    			?>
    			<tr>
    				<td height="50" colspan="6" class="tc">1:1 문의 내역이 없습니다.</td>
    			</tr>
				<? } ?>
            </table>
            <!-- //1:1문의내역 -->

			<table width="100%" border="0" cellpadding="0" cellspacing="0" class="gapT20">
        		<tr>
        			<td align="left" width="200">&nbsp;</td>
        			<td align="center"> </td>
        			<td width="200" align="right"><button type="button" onclick="DataResultClose();" class="btn btn_DGray line">닫기</button></td>
        		</tr>
			</table>
  		</div>
    </div>
</div>