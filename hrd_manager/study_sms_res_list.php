<?
$MenuType = "C";
$PageName = "study_sms_res_list";
?>
<? include "./include/include_top.php"; ?>
<?
$RegDateStart = Replace_Check($StartDate);
$RegDateEnd = Replace_Check($EndDate);

/*
if(empty($RegDateStart)) {
	$RegDateStart = date('Y-m-d', strtotime('-1 week'));
	$RegDateEnd = date('Y-m-d');
}
*/

##-- 검색 조건
$where = array();

if($RegDateStart & $RegDateEnd)     $where[] = "a.ResDate >= '$RegDateStart 00:00:00' and  a.ResDate <= '$RegDateEnd 23:59:59'";
$where[] = "a.SendYN ='N'";
if($sw){
	if($col=="")    $where[] = "";
	else            $where[] = "$col LIKE '%$sw%'";
}

$where = implode(" AND ",$where);
if($where) $where = "WHERE $where";

##-- 검색 등록수
$Sql = "SELECT COUNT(*) FROM SmsRes a
        LEFT JOIN Member b ON a.ID = b.ID
        LEFT JOIN Company c ON b.CompanyCode = c.CompanyCode 
        $where";
$Result = mysqli_query($connect, $Sql);
$Row = mysqli_fetch_array($Result);
$TOT_NO = $Row[0];
mysqli_free_result($Result);
##-- 페이지 클래스 생성
include_once("./include/include_page.php");

$PAGE_CLASS = new Page($pg,$TOT_NO,$page_size,$block_size); ##-- 페이지 클래스
$BLOCK_LIST = $PAGE_CLASS->blockList(); ##-- 페이지 이동관련
$PAGE_UNCOUNT = $PAGE_CLASS->page_uncount; ##-- 게시물 번호 한개씩 감소
?>
<div class="contentBody">
    <h2>예약문자발송</h2>
    <div class="conZone">
        <form name="search" method="get">        
            <div class="neoSearch">
                <ul class="search">
                    <li>
                        <span class="item01"><label>조회기간</label></span>
                        <input name="StartDate" id="StartDate" type="text" size="12" value="<?=$RegDateStart?>" autocomplete='off'>  ~  <input name="EndDate" id="EndDate" type="text" size="12" value="<?=$RegDateEnd?>" autocomplete='off'>
                    </li>
                    <li>
                        <div class="searchPan">
                            <select name="col">
                                <option value="b.Name" <?if($col=="b.Name") { echo "selected";}?>>이름</option>
                                <option value="a.ID" <?if($col=="a.ID") { echo "selected";}?>>아이디</option>
                                <option value="c.CompanyName" <?if($col=="c.CompanyName") { echo "selected";}?>>사업주명</option>
                            </select>
                            <input name="sw" type="text" id="sw" class="wid300" value="<?=$sw?>" />
                            <button type="submit" name="SubmitBtn" id="SubmitBtn" class="btn btn_Blue line"><i class="fas fa-search"></i> 검색</button>
                        </div>
                    </li>
                </ul>
            </div>        
        </form>
    
        <!--목록 -->
        <div class="mt20 tc pb5">
        <?if($AdminWrite=="Y") {?>
            <button type="button" name="Btn" id="Btn" class="btn btn_Green line" onclick="location.href='study_sms_res_excel.php?col=<?=$col?>&sw=<?=$sw?>&StartDate=<?=$RegDateStart?>&EndDate=<?=$RegDateEnd?>'"><i class="fas fa-file-excel"></i> 검색항목 엑셀 출력</button>
            <button type="button" name="SmsBtn" id="SmsBtn" class="btn btn_DGray line" style="width:200px;" onclick="StudySmsCheckedDelete()"><i class="xi-message"></i> 체크항목 삭제</button>
    
        <?}?>
        </div>
        <table width="100%" cellpadding="0" cellspacing="0" class="list_ty01 gapT20">
            <tr>
                <th><input type="checkbox" name="check_All" id="check_All" value="Y" onclick="CheckAll();" style="width:17px; height:17px; -webkit-appearance: button !important; -moz-appearance: button !important; appearance:button !important;"></th>
                <th>번호</th>
                <th>예약일자</th>
                <th>사업주</th>
                <th>회원명</th>
                <th>아이디</th>
                <th>연락처</th>
            </tr>
            <?
            $SQL = "SELECT	a.idx , a.ResDate , a.ID , a.Mobile ,
                            b.Name ,
                            c.CompanyName
                    FROM SmsRes a
                    LEFT JOIN Member b ON a.ID = b.ID
                    LEFT JOIN Company c ON b.CompanyCode = c.CompanyCode 
                    $where ORDER BY a.idx DESC
                    LIMIT $PAGE_CLASS->page_start, $page_size";
            //echo $SQL;
            $QUERY = mysqli_query($connect, $SQL);
            if($QUERY && mysqli_num_rows($QUERY)){
                while($ROW = mysqli_fetch_array($QUERY)){
                    extract($ROW);
            ?>
            <tr>
                <td><input type="checkbox" name="check_seq" id="check_seq" value="<?=$idx?>" style="width:17px; height:17px; -webkit-appearance: button !important; -moz-appearance: button !important; appearance:button !important;"></td>
                <td><?=$PAGE_UNCOUNT--?></td>
                <td><?=$ResDate?></td>
                <td><?=$CompanyName?></td>
                <td><?=$Name?></td>
                <td><?=$ID?></td>
                <td><?=$Mobile?></td>
            </tr>
            <?
                }
                mysqli_free_result($QUERY);
            }else{
            ?>
            <tr>
                <td height="50" class="tc" colspan="20">등록된 발송내역이 없습니다.</td>
            </tr>
            <? 
            }
            ?>
        </table>
        <?=$BLOCK_LIST?>
    </div>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#StartDate, #EndDate").datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            showOn: "both", //이미지로 사용 , both : 엘리먼트와 이미지 동시사용
            buttonImage: "images/icn_calendar.gif", //이미지 주소
            buttonImageOnly: true //이미지만 보이기
        });
        // $("#RegDateStart, #RegDateEnd").val("");
        $("img.ui-datepicker-trigger").attr("style","margin-left:5px; vertical-align:top; cursor:pointer;"); //이미지 버튼 style적용
    });
    
    function CheckAll() {
        totalcount = $("input[name='check_seq']").length; //전체 건수

        for(i=0;i<totalcount;i++) {
            if($("#check_All").is(":checked")==true) {
                $("input[name='check_seq']:eq("+i+")").prop('checked',true);
            }else{
                $("input[name='check_seq']:eq("+i+")").prop('checked',false);
            }
        }
    }

    function StudySmsCheckedDelete() {
        var seq_value = '';
        var checkbox_count = $("input[name='check_seq']").length;

        if (checkbox_count == 0) {
            alert('검색된 학습현황이 없습니다.');
            return;
        }

        if (checkbox_count > 1) {
            for (i = 0; i < checkbox_count; i++) {
                if ($("input:checkbox[name='check_seq']:eq(" + i + ')').is(':checked') == true) {
                    if (seq_value == '') {
                        seq_value = $("input:checkbox[name='check_seq']:eq(" + i + ')').val();
                    } else {
                        seq_value = seq_value + '|' + $("input:checkbox[name='check_seq']:eq(" + i + ')').val();
                    }
                }
            }
        } else {
            if ($("input:checkbox[name='check_seq']").is(':checked') == true) {
                seq_value = $("input:checkbox[name='check_seq']").val();
            }
        }

        if (!seq_value) {
            alert('삭제하려는 항목을 선택하세요.');
            return;
        }

        Yes = confirm('선택한 항목을 정말 삭제하시겠습니까?\n\n삭제 후에는 되돌릴 수 없습니다.');

        if (Yes == true) {
            var currentWidth = $(window).width();
            var LocWidth = currentWidth / 2;
            var body_width = screen.width - 20;
            var body_height = $('html body').height();

            $("div[id='SysBg_White']")
                .css({
                    width: body_width,
                    height: body_height,
                    opacity: '0.4',
                    position: 'absolute',
                    'z-index': '99',
                })
                .show();

            $("div[id='Roading']")
                .css({
                    top: '350px',
                    left: LocWidth,
                    opacity: '1.0',
                    position: 'absolute',
                    'z-index': '200',
                })
                .show();
                
            $.post(
                './study_sms_search_checked_delete.php',{seq_value: seq_value,},
                function (data, status) {
                    $("div[id='Roading']").hide();
                    $("div[id='SysBg_White']").hide();

                    if (data == 'Y') {
                        alert('삭제 되었습니다.');
                        location.reload();
                    } else {
                        alert('처리중 문제가 발생했습니다.');                        
                    }
                }
            );
        }
    }
</script>
<? include "./include/include_bottom.php"; ?>