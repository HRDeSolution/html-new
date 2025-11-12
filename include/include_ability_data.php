<?
// 사전/사후 3단계 실무자/관리자 값 가지고 옴
$SQLGROUP   = " SELECT col1 FROM ArchiveAbilityResult1 WHERE ID = '$LoginMemberID' LIMIT 1 ";
$QUERYGROUP = mysqli_query($connect, $SQLGROUP);
$ROWGROUP   = mysqli_fetch_assoc($QUERYGROUP);

//`member`테이블 진단일 
$SQLM   = "SELECT * FROM `Member` WHERE ID = '$LoginMemberID'";
$QUERYM = mysqli_query($connect, $SQLM);
$ROWM   = mysqli_fetch_assoc($QUERYM);

//`study`테이블
$SQLS   = "SELECT * FROM `Study` WHERE StudyEnd = 'N' AND ID = '$LoginMemberID'";
$QUERYS = mysqli_query($connect, $SQLS);
$ROWS   = mysqli_fetch_assoc($QUERYS);

//사전, 사후 공통역량
$SQLC = "SELECT 
              MAX(CASE WHEN aq.aType = 'B' THEN ROUND((ar.aValue / 5.0) * 100, 2) ELSE NULL END) AS aTotalA
            , MAX(CASE WHEN aq.aType = 'A' THEN ROUND((ar.aValue / 5.0) * 100, 2) ELSE NULL END) AS aTotalB
            , aq.aValue AS aQuestion, 
            MAX(aq.aValueDetail)  AS aQuestionDetail
        FROM ArchiveAbilityResult2 ar
        LEFT JOIN ArchiveQuestion aq ON ar.question_idx = aq.idx
        WHERE ar.ID = '$LoginMemberID'
        AND aq.aDepth IN ('step02', 'step03')
        AND aq.aGroup IN ('C', '".$ROWGROUP['col1']."')
        AND aq.aBind BETWEEN 'A' AND 'E'
        GROUP BY aq.aValue
        ORDER BY aq.aType, aq.aDepth, aq.aGroup, aq.aOrder ASC ";
$QUERYC = mysqli_query($connect, $SQLC);

//사전, 사후 리더십역량
$SQLL = "SELECT 
              MAX(CASE WHEN aq.aType = 'B' THEN ROUND((ar.aValue / 5.0) * 100, 2) ELSE NULL END) AS aTotalA
            , MAX(CASE WHEN aq.aType = 'A' THEN ROUND((ar.aValue / 5.0) * 100, 2) ELSE NULL END) AS aTotalB
            , aq.aValue AS aQuestion, 
            MAX(aq.aValueDetail)  AS aQuestionDetail
        FROM ArchiveAbilityResult2 ar
        LEFT JOIN ArchiveQuestion aq ON ar.question_idx = aq.idx
        WHERE ar.ID = '$LoginMemberID'
        AND aq.aDepth IN ('step02', 'step03')
        AND aq.aGroup IN ('L', '".$ROWGROUP['col1']."')
        AND aq.aBind BETWEEN 'F' AND 'J'
        GROUP BY aq.aValue
        ORDER BY aq.aType, aq.aDepth, aq.aGroup, aq.aOrder ASC ";
$QUERYL = mysqli_query($connect, $SQLL);

//사전, 사후 직무역량
$SQLJ = "SELECT 
              MAX(CASE WHEN aq.aType = 'B' THEN ROUND((ar.aValue / 5.0) * 100, 2) ELSE NULL END) AS aTotalA
            , MAX(CASE WHEN aq.aType = 'A' THEN ROUND((ar.aValue / 5.0) * 100, 2) ELSE NULL END) AS aTotalB
            , aq.aValue AS aQuestion
            , MAX(aq.aValueDetail)  AS aQuestionDetail
        FROM ArchiveAbilityResult2 ar
        LEFT JOIN ArchiveQuestion aq ON ar.question_idx = aq.idx
        WHERE ar.ID = '$LoginMemberID'
        AND aq.aDepth IN ('step02', 'step03')
        AND aq.aGroup IN ('".$ROWGROUP['col1']."')
        AND aq.aBind BETWEEN 'K' AND 'T'
        GROUP BY aq.aValue
        ORDER BY aq.aType, aq.aDepth, aq.aGroup, aq.aOrder ASC ";
$QUERYJ = mysqli_query($connect, $SQLJ);
?>