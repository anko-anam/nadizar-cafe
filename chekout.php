<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $variant = $_POST['number-guests'];
    $quantity = $_POST['quantity'];
    $date = $_POST['date'];
    $area = $_POST['time'];
    $address = $_POST['message'];
    
    // Harga berdasarkan varian
    $prices = [
        "Nadizar Seblak Mini" => 5000,
        "Nadizar Seblak Telor" => 10000,
        "Nadizar Seblak Sosis + Mie + Telor" => 15000,
        "Nadizar Seblak Full Isi" => 18000,
        "Nadizar Seblak Paket Komplit" => 20000,
        "Nadizar Es Teh" => 5000,
        "Nadizar Pempek Mini" => 12000,
        "Nadizar Pempek Kapal Selam" => 18000,
        "Nadizar Pempek Paket Komplit" => 25000
    ];
    
    $price = isset($prices[$variant]) ? $prices[$variant] : 0;
    $total_price = $price * (int)$quantity;
    
    $receipt = "=== Struk Pembayaran ===\n";
    $receipt .= "Nama: $name\n";
    $receipt .= "Email: $email\n";
    $receipt .= "Nomor HP (WA): $phone\n";
    $receipt .= "Varian: $variant\n";
    $receipt .= "Jumlah Porsi: $quantity\n";
    $receipt .= "Total Harga: Rp " . number_format($total_price, 0, ',', '.') . "\n";
    $receipt .= "Tanggal: $date\n";
    $receipt .= "Area: $area\n";
    $receipt .= "Alamat: $address\n";
    $receipt .= "=======================\n";
    
    // Mengirim ke WhatsApp pelanggan
    $message = urlencode("Halo $name,\nTerima kasih telah melakukan pemesanan. Berikut detailnya:\n$receipt");
    $wa_link = "https://api.whatsapp.com/send?phone=$phone&text=$message";
    
    // Kirim notifikasi ke admin secara otomatis
    $admin_phone = "6285213041432"; // Ganti dengan nomor admin
    $admin_message = urlencode("Notifikasi Pesanan Baru:\n$receipt");
    file_get_contents("https://api.whatsapp.com/send?phone=$admin_phone&text=$admin_message");
    
    echo nl2br($receipt);
    
}
?>
