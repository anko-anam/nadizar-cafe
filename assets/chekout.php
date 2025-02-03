<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $variant = $_POST['number-guests'];
    $date = $_POST['date'];
    $area = $_POST['time'];
    $address = $_POST['message'];
    
    // Harga berdasarkan varian
    $prices = [
        "Nadizar Seblak Mini" => 10000,
        "Nadizar Seblak Telor" => 12000,
        "Nadizar Seblak Sosis + Mie + Telor" => 15000,
        "Nadizar Seblak Full Isi" => 18000,
        "Nadizar Seblak Paket Komplit" => 20000,
        "Nadizar Es Teh" => 5000,
        "Nadizar Pempek Mini" => 12000,
        "Nadizar Pempek Kapal Selam" => 18000,
        "Nadizar Pempek Paket Komplit" => 25000
    ];
    
    $price = isset($prices[$variant]) ? $prices[$variant] : 0;
    
    $receipt = "=== Struk Pembayaran ===\n";
    $receipt .= "Nama: $name\n";
    $receipt .= "Email: $email\n";
    $receipt .= "Nomor HP (WA): $phone\n";
    $receipt .= "Varian: $variant\n";
    $receipt .= "Harga: Rp " . number_format($price, 0, ',', '.') . "\n";
    $receipt .= "Tanggal: $date\n";
    $receipt .= "Area: $area\n";
    $receipt .= "Alamat: $address\n";
    $receipt .= "=======================\n";
    
    // Mengirim ke WhatsApp pelanggan
    $message = urlencode("Halo $name,\nTerima kasih telah melakukan pemesanan. Berikut detailnya:\n$receipt");
    $wa_link = "https://api.whatsapp.com/send?phone=$phone&text=$message";
    
    // Kirim notifikasi ke admin
    $admin_phone = "62xxxxxxxxxxx"; // Ganti dengan nomor admin
    $admin_message = urlencode("Notifikasi Pesanan Baru:\n$receipt");
    $admin_wa_link = "https://api.whatsapp.com/send?phone=$admin_phone&text=$admin_message";
    
    echo nl2br($receipt);
    echo "<br><a href='$wa_link' target='_blank'>Kirim ke WhatsApp</a>";
    echo "<br><a href='$admin_wa_link' target='_blank'>Notifikasi Admin</a>";
}
?>
