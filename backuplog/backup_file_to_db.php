<? 
##############################################
# DB Connect
##############################################
$db['host'] = "192.168.11.15";
$db['user'] = "root";
$db['pass'] = "hrdlms1234!@#$";
$db['db']   = "hrdeArchive";
$connect = mysqli_connect($db['host'], $db['user'], $db['pass'], $db['db']);
mysqli_query($connect,"SET NAMES utf8");
if (!$connect) {
    echo "<BR>Error: Unable to connect to MySQL." . PHP_EOL;
    echo "<BR>Debugging errno: " . mysqli_connect_errno() . PHP_EOL;
    echo "<BR>Debugging error: " . mysqli_connect_error() . PHP_EOL;
    exit;
}
?>
<?
$baseDir    = __DIR__."/";
$filenames  = ['web', 'db', 'vod', 'weblog1'];
$fileData   = [];

// 파일 읽기
foreach ( $filenames as $name ) {
    $filePath = $baseDir . $name;

    if ( !file_exists($filePath) ) {
        echo "[".date("Y-m-d H:i:s")."] 파일 없음 (무시): $filePath\n";
        continue;
    }

    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if ( $lines === false || count($lines) === 0 ) {
        echo "[".date("Y-m-d H:i:s")."] 파일 내용 없음 (무시): $filePath\n";
        continue;
    }

    foreach ( $lines as $line ) {
        $line = trim($line);

        if ( $name === 'weblog1' ) {
            if ( preg_match('/access\.(\d{8})\.log/', $line, $match) ) {
                $dateStr = $match[1];
                $date    = DateTime::createFromFormat('Ymd', $dateStr);
                if ( !$date ) {
                    echo "[".date("Y-m-d H:i:s")."] weblog1 날짜 파싱 실패 (무시): $line\n";
                    continue;
                }

                $fileDate   = $date->format('Y-m-d');
                $targetDate = $date->modify('+1 day')->format('Y-m-d'); // **web/db/vod에 맞춰 하루+1**

                $fileData[$targetDate]['weblog1'] = $line;
            } else {
                echo "[".date("Y-m-d H:i:s")."] weblog1 형식 불일치 (무시): $line\n";
            }
        } else {
            if ( preg_match('/\d{4}-\d{2}-\d{2}/', $line, $match) ) {
                $date = $match[0];
                $fileData[$date][$name] = $line;
            } else {
                echo "[".date("Y-m-d H:i:s")."] $name 날짜 추출 실패 (무시): $line\n";
            }
        }
    }
}

// 날짜별 저장
foreach ( $fileData as $date => $data ) {

    // web, db, vod 필수
    if ( !isset($data['web'], $data['db'], $data['vod']) ) {
        echo "[".date("Y-m-d H:i:s")."] 필수 파일 누락 (날짜: $date) - 저장 스킵\n";
        continue;
    }

    // 중복 체크
    $sqlCheck = "SELECT COUNT(*) FROM backup_data_list
                 WHERE web_file_nm LIKE '%$date%'
                    OR db_file_nm LIKE '%$date%'
                    OR vod_file_nm LIKE '%$date%'";
    $result = mysqli_query($connect, $sqlCheck);
    $row    = mysqli_fetch_array($result);

    if ( $row[0] > 0 ) {
        echo "[".date("Y-m-d H:i:s")."] 이미 저장됨 (날짜: $date)\n";
        continue;
    }

    // 저장 준비
    $expiryDate = (new DateTime($date))->modify('+5 day')->format('Y-m-d');
    $regDate    = (new DateTime())->format('Y-m-d').' 04:30:01';

    $webFile    = mysqli_real_escape_string($connect, $data['web']);
    $dbFile     = mysqli_real_escape_string($connect, $data['db']);
    $vodFile    = mysqli_real_escape_string($connect, $data['vod']);
    $weblogFile = isset($data['weblog1']) ? "'".mysqli_real_escape_string($connect, $data['weblog1'])."'" : "NULL";

    $sql = "INSERT INTO backup_data_list (web_file_nm, db_file_nm, vod_file_nm, weblog_file_nm, backup_type, backup_interval, expiry_date, reg_date) 
            VALUES ('$webFile', '$dbFile', '$vodFile', $weblogFile, 'FILE', 'Day', '$expiryDate', '$regDate')";

    $result = mysqli_query($connect, $sql);

    if ( $result ) {
        echo "[".date("Y-m-d H:i:s")."] 저장 완료 (날짜: $date)\n";
    } else {
        echo "[".date("Y-m-d H:i:s")."] 저장 실패 (날짜: $date) - " . mysqli_error($connect) . "\n";
    }
}
?>