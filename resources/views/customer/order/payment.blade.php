<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            color: #333;
        }
        
        .payment-container {
            max-width: 650px;
            margin: 40px auto;
            background-color: white;
            border-radius: 15px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            padding: 35px;
        }
        
        .page-header {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 25px;
            position: relative;
            padding-bottom: 15px;
        }
        
        .page-header:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(to right, #6c5ce7, #a29bfe);
            border-radius: 3px;
        }
        
        .total-amount {
            background: linear-gradient(to right, #f8f9fa, #e9ecef);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
        }
        
        .total-amount .amount-value {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            display: block;
            margin-top: 5px;
        }
        
        .total-amount .amount-label {
            font-size: 16px;
            color: #6c757d;
        }
        
        .form-label {
            font-weight: 500;
            margin-bottom: 12px;
            color: #495057;
        }
        
        .payment-method-select {
            margin-bottom: 30px;
        }
        
        .method-options {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 30px;
        }
        
        .method-option {
            flex: 1 0 calc(50% - 15px);
            min-width: 200px;
        }
        
        .method-option input[type="radio"] {
            display: none;
        }
        
        .method-option label {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            border: 2px solid #dee2e6;
            border-radius: 10px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s ease;
            height: 100%;
        }
        
        .method-option input[type="radio"]:checked + label {
            border-color: #6c5ce7;
            background-color: #f0f0ff;
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.1);
        }
        
        .method-icon {
            font-size: 28px;
            margin-bottom: 10px;
            color: #6c757d;
        }
        
        .method-option input[type="radio"]:checked + label .method-icon {
            color: #6c5ce7;
        }
        
        .method-title {
            font-weight: 500;
            font-size: 16px;
        }
        
        .pay-button {
            padding: 14px;
            font-weight: 600;
            font-size: 16px;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            border-radius: 10px;
            background: linear-gradient(to right, #6c5ce7, #a29bfe);
            border: none;
        }
        
        .pay-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.4);
        }
        
        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #6c757d;
            text-decoration: none;
        }
        
        .back-link:hover {
            color: #495057;
        }
        
        .secure-payment {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #6c757d;
        }
        
        .secure-payment i {
            color: #28a745;
            margin-right: 5px;
        }
        
        @media (max-width: 576px) {
            .payment-container {
                padding: 25px 20px;
                margin: 20px auto;
                border-radius: 10px;
            }
            
            .method-option {
                flex: 1 0 100%;
            }
            
            .total-amount .amount-value {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="payment-container">
            <h2 class="page-header text-center">Pembayaran</h2>
            
            <div class="total-amount">
                <span class="amount-label">Total Pembayaran</span>
                <span class="amount-value">Rp {{ number_format($order->orderItems->sum(function($item) {
                    return $item->harga * $item->jumlah;
                }), 0, ',', '.') }}</span>
            </div>
            
            <form action="{{ route('customer.payment.process') }}" method="POST">
                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}">
                <input type="hidden" name="amount" value="{{ $order->orderItems->sum(function($item) {
                    return $item->harga * $item->jumlah;
                }) }}">
                
                <label class="form-label">Pilih Metode Pembayaran:</label>
                
                <div class="method-options">
                    <div class="method-option">
                        <input type="radio" name="payment_method" id="bank_transfer" value="bank_transfer" checked>
                        <label for="bank_transfer">
                            <i class="fas fa-university method-icon"></i>
                            <span class="method-title">Bank Transfer</span>
                        </label>
                    </div>
                    
                    <div class="method-option">
                        <input type="radio" name="payment_method" id="e_wallet" value="e_wallet">
                        <label for="e_wallet">
                            <i class="fas fa-wallet method-icon"></i>
                            <span class="method-title">E-Wallet</span>
                        </label>
                    </div>
                    
                    <div class="method-option">
                        <input type="radio" name="payment_method" id="credit_card" value="credit_card">
                        <label for="credit_card">
                            <i class="fas fa-credit-card method-icon"></i>
                            <span class="method-title">Credit Card</span>
                        </label>
                    </div>
                    
                    <div class="method-option">
                        <input type="radio" name="payment_method" id="cash" value="cash">
                        <label for="cash">
                            <i class="fas fa-money-bill-wave method-icon"></i>
                            <span class="method-title">Cash</span>
                        </label>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary w-100 pay-button">
                    <i class="fas fa-lock me-2"></i>Bayar Sekarang
                </button>
            </form>
            
            <a href="{{ route('customer.cart') }}" class="back-link">
                <i class="fas fa-arrow-left me-1"></i>Kembali ke Keranjang
            </a>
            
            <div class="secure-payment">
                <i class="fas fa-shield-alt"></i>
                Pembayaran aman dengan enkripsi SSL
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>