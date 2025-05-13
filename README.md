
# Laravel Payment Gateway Integration

Integrasi gateway pembayaran **Duitku** untuk Laravel menggunakan package `sayyidazizii/payment-gateway`.

 
**Payment Gateway List**

```bash
Duitku    : ✅
Midtrans  : soon

```


## 🔧 Instalasi

1. **Install package via Composer:**

```bash
composer require sayyidazizii/payment-gateway
```

2. **Publish konfigurasi (opsional):**

```bash
php artisan vendor:publish --provider="Sayyidzaizii\Duitku\DuitkuServiceProvider"
```

3. **Set credential di `.env`:**

```env
DUITKU_MERCHANT_CODE=your_merchant_code
DUITKU_API_KEY=your_api_key
DUITKU_IS_SANDBOX=true
```

---

## 🚀 Contoh Penggunaan

### 1. Mendapatkan Metode Pembayaran

```php
use Sayyidzaizii\Duitku\Facades\Duitku;

$data = Duitku::paymentMethods(10000); // jumlah dalam rupiah
```

### 2. Membuat Invoice Pembayaran

```php
$data = Duitku::createInvoice(
    'ORDER_ID1',        // order ID
    100000,             // jumlah
    'M2',               // metode pembayaran
    'Product Name',     // nama produk
    'John Doe',         // nama customer
    'john@example.com', // email customer
    120                 // waktu kadaluarsa (menit)
);
```

**Contoh respons sukses:**

```json
{
  "success": true,
  "reference": "D7999PJ38HNY7TSKHSGX",
  "payment_url": "https://url.to.payment.example.com/",
  "va_number": "0000123123123",
  "amount": 100000,
  "message": "SUCCESS"
}
```

**Contoh respons gagal:**

```json
{
  "success": false,
  "message": "The selected payment channel not available"
}
```

### 3. Cek Status Pembayaran

```php
$data = Duitku::checkInvoiceStatus('ORDER_ID1');
```

**Contoh respons:**

```json
{
  "reference": "D7999PJ38HNY7TSKHSGX",
  "amount": 100000,
  "message": "SUCCESS",
  "code": "00" // 00 => Success, 01 => Pending, 02 => Failed/Expired
}
```

---

## 📡 Callback / Webhook Handling

### 1. Buat Controller

```php
use Sayyidzaizii\Duitku\Http\Controllers\DuitkuBaseController;

class DuitkuController extends DuitkuBaseController
{
    protected function onPaymentSuccess(
        string $orderId, string $productDetail, int $amount, string $paymentCode,
        string $shopeeUserHash, string $reference, string $additionalParam
    ): void {
        // Simpan data pembayaran sukses ke database
    }

    protected function onPaymentFailed(
        string $orderId, string $productDetail, int $amount, string $paymentCode,
        string $shopeeUserHash, string $reference, string $additionalParam
    ): void {
        // Simpan data pembayaran gagal ke database
    }
}
```

### 2. Tambahkan Route Callback

```php
Route::post('callback/payment', [\App\Http\Controllers\DuitkuController::class, 'paymentCallback']);
```

### 3. Kecualikan Route dari CSRF

Tambahkan pada file `App\Http\Middleware\VerifyCsrfToken.php`:

```php
protected $except = [
    'callback/payment',
];
```

---

## 📂 Contoh Lengkap Controller

```php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Sayyidzaizii\Duitku\Facades\Duitku;
use Sayyidzaizii\Duitku\Http\Controllers\DuitkuBaseController;

class DuitkuController extends DuitkuBaseController
{
    public function paymentMethods(Request $request)
    {
        $data = Duitku::paymentMethods(10000);
        return response()->json($data);
    }

    public function createPayment(Request $request)
    {
        $data = Duitku::createInvoice(
            'ORDER_ID1', 100000, 'M2', 'Product Name', 'John Doe', 'john@example.com', 120
        );
        return response()->json($data);
    }

    protected function onPaymentSuccess(
        string $orderId, string $productDetail, int $amount, string $paymentCode,
        string $shopeeUserHash, string $reference, string $additionalParam
    ): void {
        // Proses jika pembayaran berhasil
    }

    protected function onPaymentFailed(
        string $orderId, string $productDetail, int $amount, string $paymentCode,
        string $shopeeUserHash, string $reference, string $additionalParam
    ): void {
        // Proses jika pembayaran gagal
    }
}
```

---

## 🛣️ Contoh Route

```php
use App\Http\Controllers\DuitkuController;

Route::get('/duitku/payment-methods', [DuitkuController::class, 'paymentMethods']);
Route::post('/duitku/create-payment', [DuitkuController::class, 'createPayment']);
Route::post('/callback/payment', [DuitkuController::class, 'paymentCallback']);
```

---

## 📚 Dokumentasi Resmi

Lihat dokumentasi resmi Duitku untuk referensi API dan parameter:  
🔗 https://docs.duitku.com/api/id/
