<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderItemResource;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductImage;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    public function createTransaction(Request $request)
    {
        try {
            // Konfigurasi Midtrans
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // Ambil user_id dari token
            $user = auth()->user();

            // Ambil data cart berdasarkan user_id
            $cart = Cart::where('user_id', $user->id)->get();

            // Cek jika cart kosong
            if ($cart->isEmpty()) {
                return response()->json(['message' => 'Keranjang belanja kosong'], 400);
            }

            // Hitung total berat
            $totalWeight = $cart->sum(fn($item) => $item->product->weight * $item->qty);

            // Hitung total harga
            $subtotal = $cart->sum(fn($item) => $item->product->price * $item->qty);

            // Hitung total harga setelah diskon
            $totalPrice = $subtotal - $request->discount;

            // hitung total dengan ongkir
            $totalPrice += $request->ongkir;

            // Cek apakah request memiliki voucher_id
            $voucher = null;
            if ($request->filled('voucher_id')) { // Gunakan filled() agar memastikan tidak null atau kosong
                $voucher = Voucher::find($request->voucher_id);

                if (!$voucher) {
                    return response()->json(['message' => 'Voucher tidak ditemukan'], 404);
                }

                // Jika voucher untuk ongkir
                if ($voucher->type == 'ongkir') {
                    $totalPrice -= min($voucher->amount, $request->ongkir);
                }
                // Jika voucher untuk diskon barang
                else {
                    $totalPrice -= min($voucher->amount, $subtotal);
                }

                // Cek apakah user sudah pernah menggunakan voucher ini sebelumnya
                $order = Order::where('user_id', $user->id)->where('voucher_id', $request->voucher_id)->exists();
                if ($order) {
                    return response()->json(['message' => 'Anda sudah menggunakan voucher ini sebelumnya'], 400);
                }
            }


            // Buat invoice unik dengan skala acak yang besar 
            $invoice = 'INV-CLS/' . date('Ymd') . '/' . rand(100000, 999999);

            // Simpan order dalam transaksi database
            DB::beginTransaction();

            $order = Order::create([
                'invoice' => $invoice,
                'user_id' => $user->id,
                'voucher_id' => $request->voucher_id ?? null,
                'weight' => $totalWeight,
                'courier' => $request->courier,
                'service' => $request->service,
                'service_ongkir' => $request->service_ongkir,
                'ongkir' => $request->ongkir,
                'discount' => $voucher ? $voucher->amount : 0,
                'total' => $subtotal,
                'gross_amount' => $totalPrice,
                'status' => 'Menunggu Pembayaran',
                'status_payment' => 'pending',
                'resi' => null, // Resi biasanya diberikan setelah dikirim
                'note' => $request->note ?? null
            ]);

            // Simpan detail order
            foreach ($cart as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'qty' => $item->qty,
                    'price' => $item->product->price,
                    'size' => $item->size->size ?? null,
                    'color' => $item->color->color ?? null,
                    'total' => $item->product->price * $item->qty
                ]);

                // Update stok produk dari relasi size berdasarkan product_id
                $product = $item->product;
                $size = $item->size;

                if ($size) {
                    $size->stock -= $item->qty;
                    $size->save();
                }

                // masukkan kedalam tabel transaksi log
                DB::table('historylogtransactions')->insert([
                    'invoice' => $invoice,
                    'user' => $user->name,
                    'product' => $product->name,
                    'price' => $product->price,
                    'qty' => $item->qty,
                    'size' => $size->size ?? null,
                    'color' => $item->color->color ?? null,
                    'courier' => $request->courier,
                    'service' => $request->service,
                    'service_ongkir' => $request->service_ongkir,
                    'ongkir' => $request->ongkir,
                    'discount' => $voucher ? $voucher->amount : 0,
                    'voucher' => $voucher ? $voucher->code : null,
                    'status_payment' => 'pending',
                ]);
            }

            // Hapus cart setelah transaksi dibuat
            Cart::where('user_id', $user->id)->delete();

            // Buat data transaksi Midtrans
            // Inisialisasi harga awal
            $finalOngkir = $request->ongkir; // Ongkir sebelum diskon
            $discountAmount = 0; // Default diskon barang

            // Jika ada voucher ongkir, hitung diskonnya
            if ($voucher && $voucher->type == 'ongkir') {
                $discountOngkir = min($voucher->amount, $request->ongkir); // Diskon tidak lebih dari ongkir
                $finalOngkir -= $discountOngkir; // Hitung ongkir setelah diskon
            } else {
                $discountOngkir = 0;
            }

            // Jika ada voucher diskon barang, hitung diskonnya
            if ($voucher && $voucher->type == 'barang' && $voucher->amount > 0) {
                $discountAmount = min($voucher->amount, $subtotal); // Pastikan diskon tidak melebihi subtotal
            }

            // Buat item details untuk Midtrans
            $items = [];

            // Tambahkan produk ke item Midtrans
            foreach ($cart as $item) {
                $items[] = [
                    'id' => $item->product_id,
                    'price' => $item->product->price,
                    'quantity' => $item->qty,
                    'name' => $item->product->name . ' - ' . ($item->size->size ?? 'No Size'),
                ];
            }

            // Tambahkan ongkir ke item Midtrans (tetap ditampilkan meskipun ada diskon)
            $items[] = [
                'id' => 'ONGKIR',
                'price' => $request->ongkir, // Tampilkan ongkir asli
                'quantity' => 1,
                'name' => 'Biaya Pengiriman',
            ];

            // Tambahkan diskon ongkir sebagai item terpisah (agar tetap terlihat di Midtrans)
            if ($discountOngkir > 0) {
                $items[] = [
                    'id' => 'DISCOUNT_ONGKIR',
                    'price' => -$discountOngkir, // Harga negatif untuk diskon
                    'quantity' => 1,
                    'name' => 'Diskon Ongkir',
                ];
            }

            // Tambahkan diskon barang sebagai item terpisah (agar tetap terlihat di Midtrans)
            if ($discountAmount > 0) {
                $items[] = [
                    'id' => 'DISCOUNT_BARANG',
                    'price' => -$discountAmount, // Harga negatif untuk diskon
                    'quantity' => 1,
                    'name' => 'Diskon Barang',
                ];
            }

            // Hitung total harga akhir (gross amount)
            $grossAmount = max(0, $subtotal + $finalOngkir - $discountAmount);

            // Buat transaksi Midtrans
            $transaction = [
                'transaction_details' => [
                    'order_id' => $invoice,
                    'gross_amount' => $grossAmount,
                ],
                'customer_details' => [
                    'first_name' => $user->name,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'address' => $user->address
                ],
                'item_details' => $items, // Kirim daftar item ke Midtrans
            ];


            // Buat Snap Token
            $snapToken = Snap::getSnapToken($transaction);

            // Update order dengan payment token dan URL Midtrans
            $order->update([
                'payment_token' => $snapToken,
                'payment_url' => "https://app.sandbox.midtrans.com/snap/v2/vtweb/{$snapToken}"
            ]);

            DB::commit();

            return response()->json([
                'message' => 'Transaksi berhasil dibuat',
                'snap_token' => $snapToken
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    // Fungsi untuk memperbarui status pembayaran dari callback Midtrans
    public function updatePaymentStatus(Request $request)
    {
        // Process the notification data
        $notification = $request->all();

        // Update your database based on the received notification
        if ($notification['invoice'] == 'settlement') {
            // Find the order based on the notification
            $order = Order::where('tracking_no', $notification['order_id'])->first();

            // Update order status, payment status, or any other relevant information
            if ($order) {
                $order->update([
                    'status' => 'Menunggu konfirmasi',
                    'status_payment' => 'settlement'
                ]);
            }
        } elseif ($notification['invoice'] == 'cancel') {
            // Find the order based on the notification
            $order = Order::where('tracking_no', $notification['order_id'])->first();

            // Update order status, payment status, or any other relevant information
            if ($order) {
                $order->update([
                    'status' => 'cancelled',
                    'status_payment' => 'cancelled'
                ]);
            }
        } elseif ($notification['invoice'] == 'expire') {
            // Find the order based on the notification
            $order = Order::where('tracking_no', $notification['order_id'])->first();

            // Update order status, payment status, or any other relevant information
            if ($order) {
                $order->update([
                    'status' => 'expired',
                    'status_payment' => 'expired',
                ]);
            }
        }

        // Respond to Midtrans to acknowledge receipt of the notification
        return response('Notification received', 200);
    }


    public function transactionList()
    {
        $user = auth()->user();

        $transactions = Order::where('user_id', $user->id)->get();
        $data = [];

        foreach ($transactions as $transaction) {
            $data[] = [
                'id' => $transaction->id,
                'invoice' => $transaction->invoice,
                'total' => $transaction->total,
                'status' => $transaction->status,
                'payment' => $transaction->status_payment,
                'payment_url' => $transaction->payment_url
            ];
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function transactionDetail($id)
    {
        // Ambil data order berdasarkan ID
        $order = Order::find($id);

        if (!$order) {
            return response()->json([
                'message' => 'Order not found'
            ], 404);
        }

        // Ambil order items yang terkait dengan order
        $orderitems = OrderItemResource::collection(OrderItem::where('order_id', $order->id)->get());

        // Looping untuk menambahkan gambar produk ke setiap order item
        foreach ($orderitems as $orderitem) {
            $productImage = ProductImage::where('product_id', $orderitem->product_id)->first();
            $orderitem->image = $productImage ? $productImage->image : null;
        }

        return response()->json([
            'data' => $orderitems
        ]);
    }
}
