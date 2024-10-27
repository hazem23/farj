<?php
$botToken = '7289397205:AAFdTkZlFXN9rkh7YsvK6G7_2oobmBKIH18'; // استخدم التوكن الخاص بالبوت
$admin_id = '948859462'; // استخدم معرف حسابك الشخصي على تيليجرام

$update = json_decode(file_get_contents('php://input'), true);
file_put_contents('log.txt', print_r($update, true));

if (isset($update['message'])) {
    $chat_id = $update['message']['chat']['id'] ?? null;
    $message = $update['message']['text'] ?? '';

    if ($chat_id) {
        $notification = "رسالة جديدة من $chat_id: $message";
        sendMessage($admin_id, $notification);

        if ($message == '/start') {
            $welcomeMessage = "مرحباً بك في البوت! نحن هنا لمساعدتك. يمكنك البدء بإرسال رسالتك الآن.";
            sendMessage($chat_id, $welcomeMessage);
        } else {
            $response = handle_message($message);
            sendMessage($chat_id, $response);
        }
    }
}

function sendMessage($chat_id, $message) {
    global $botToken;
    $apiURL = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chat_id&text=" . urlencode($message);
    file_get_contents($apiURL);
}

function handle_message($message) {
    if (stripos($message, 'مرحبا') !== false) {
        return 'أهلاً وسهلاً! كيف يمكنني مساعدتك؟';
    } elseif (stripos($message, 'شكراً') !== false) {
        return 'على الرحب والسعة!';
    } elseif (stripos($message, 'كيف حالك') !== false) {
        return 'أنا روبوت، لكن شكراً لسؤالك!';
    }
    return 'لم أفهم ذلك، يمكن أن تعيد صياغة سؤالك؟';
}

$introMessage = "مرحباً! هذا البوت مصمم لمساعدتك في مختلف الأمور. أرسل رسالتك وسأكون سعيداً بمساعدتك!";
sendMessage($admin_id, $introMessage);
?>
