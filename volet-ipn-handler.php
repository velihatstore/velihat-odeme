<?php
// Volet IPN Durum Sayfası
// SCI: velihatstore | Şifre: Bossmc.35 | Para Birimi: USD

// E-posta bildirimi için
$to = "support@bossuniversalmusic.com"; //

// SCI şifresi
$secret = "Bossmc.35";

// Gelen veriler
$payment_id = $_POST['payment_id'] ?? '';
$amount = $_POST['amount'] ?? '';
$currency = $_POST['currency'] ?? '';
$sci_name = $_POST['sci_name'] ?? '';
$hash = $_POST['sign'] ?? '';

// İmza oluştur
$generated_hash = hash('sha256', 
    strtoupper($payment_id . ":" . $amount . ":" . $currency . ":" . $sci_name . ":" . $secret)
);

// İmza doğrulama
if ($generated_hash === $hash) {
    // Ödeme başarılı, bildirim gönder
    $subject = "Yeni Ödeme Alındı – Volet";
    $message = "Yeni bir ödeme alındı:\n\n".
               "Ödeme ID: $payment_id\n".
               "Tutar: $amount $currency\n".
               "SCI: $sci_name\n";

    mail($to, $subject, $message);
    
    http_response_code(200);
    echo "OK";
} else {
    // İmza geçersiz
    http_response_code(403);
    echo "Invalid Signature";
}
?>
