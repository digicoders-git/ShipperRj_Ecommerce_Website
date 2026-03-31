<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }} - Shopping Club India</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts: Outfit & Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800;900&family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        :root {
            --premium-orange: #f2701a;
            --premium-dark: #1a1a1a;
            --premium-grey: #64748b;
            --premium-light: #f8fafc;
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background: #f1f5f9; 
            color: #1e293b;
            -webkit-print-color-adjust: exact;
        }

        .outfit { font-family: 'Outfit', sans-serif; }
        
        .invoice-wrapper {
            max-width: 850px;
            margin: 40px auto;
            position: relative;
        }

        .invoice-box {
            background: #fff;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
            border-radius: 20px;
            overflow: hidden;
            position: relative;
            padding: 50px;
        }

        /* Watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 8rem;
            color: rgba(242, 112, 26, 0.03);
            font-weight: 900;
            pointer-events: none;
            z-index: 0;
            white-space: nowrap;
        }

        .header-ribbon {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: linear-gradient(90deg, var(--premium-orange), #ff9d5c);
        }

        .fw-black { font-weight: 900; }
        .text-orange { color: var(--premium-orange) !important; }
        .bg-premium-light { background-color: var(--premium-light); }
        
        .invoice-title {
            letter-spacing: -2px;
            font-size: 2.5rem;
            line-height: 1;
        }

        .badge-premium {
            background: rgba(242, 112, 26, 0.1);
            color: var(--premium-orange);
            font-weight: 800;
            border: 1px solid rgba(242, 112, 26, 0.2);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 0.7rem;
            text-transform: uppercase;
        }

        .table thead th {
            background: var(--premium-light);
            color: var(--premium-grey);
            font-weight: 800;
            text-transform: uppercase;
            font-size: 0.7rem;
            letter-spacing: 1px;
            border: none;
            padding: 15px 20px;
        }

        .table tbody td {
            padding: 20px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
        }

        .summary-box {
            background: var(--premium-light);
            border-radius: 15px;
            padding: 30px;
        }

        .qr-placeholder {
            width: 80px;
            height: 80px;
            background: #fff;
            border: 1px solid #e2e8f0;
            padding: 5px;
            border-radius: 10px;
        }

        .official-stamp {
            width: 120px;
            opacity: 0.6;
            filter: grayscale(1);
        }

        .footer-note {
            border-top: 1px solid #f1f5f9;
            padding-top: 30px;
            margin-top: 50px;
        }

        .btn-premium-action {
            background: #fff;
            border: 1px solid #e2e8f0;
            color: #1a1a1a;
            font-weight: 700;
            padding: 10px 25px;
            border-radius: 50px;
            transition: all 0.3s ease;
        }

        .btn-premium-action:hover {
            background: var(--premium-orange);
            color: #fff;
            border-color: var(--premium-orange);
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(242, 112, 26, 0.2);
        }

        @media print {
            .no-print { display: none !important; }
            body { background: #fff; padding: 0; margin: 0; }
            .invoice-wrapper { margin: 0; max-width: 100%; }
            .invoice-box { box-shadow: none; border: none; padding: 20px; width: 100%; }
        }
    </style>
</head>
<body>

<div class="no-print container py-4 d-flex justify-content-center gap-3">
    <button onclick="downloadPDF()" class="btn btn-premium-action">
        <i class="bi bi-file-earmark-pdf me-2"></i>Download PDF
    </button>
    <button onclick="downloadImage()" class="btn btn-premium-action">
        <i class="bi bi-image me-2"></i>Download Image
    </button>
    <a href="{{ url('/order-success?order_id='.$order->id) }}" class="btn btn-link text-muted fw-bold text-decoration-none py-2">
        <i class="bi bi-arrow-left me-2"></i>Back to Order
    </a>
</div>

<div class="invoice-wrapper">
    <div class="invoice-box" id="invoiceContent">
        <div class="header-ribbon"></div>
        <div class="watermark outfit">AUTHENTIC</div>

        <!-- Header Section -->
        <div class="row align-items-start mb-5 position-relative">
            <div class="col-7">
                <img src="{{ asset('assets/images/logo1.png') }}" alt="Logo" class="mb-4" style="height: 65px;">
                <div class="company-details small text-secondary">
                    <p class="mb-1 fw-bold text-dark">SHOPPING CLUB INDIA (P) LTD.</p>
                    <p class="mb-0">Avenue 7, New Delhi, India 110001</p>
                    <p class="mb-0">T: +91 8800 123 456 | E: info@shoppingclubindia.com</p>
                    <p class="mb-0 fw-medium mt-2">GSTIN: 07AAGCS1234A1Z1</p>
                </div>
            </div>
            <div class="col-5 text-end">
                <h1 class="outfit fw-black text-dark invoice-title mb-2">INVOICE</h1>
                <div class="d-flex flex-column align-items-end gap-1">
                    <span class="badge-premium mb-2">Verified Transaction</span>
                    <p class="mb-0 text-secondary fw-bold small">ID: <span class="text-dark">#{{ $order->order_number }}</span></p>
                    <p class="mb-0 text-secondary small">DATE: <span class="text-dark fw-medium">{{ $order->created_at->format('d M, Y | H:i') }}</span></p>
                </div>
            </div>
        </div>

        <!-- Billing Section -->
        <div class="row mb-5 position-relative">
            <div class="col-6">
                <div class="p-4 rounded-4 bg-premium-light border border-white h-100">
                    <h6 class="text-orange small fw-black uppercase tracking-widest mb-3">BILLED To</h6>
                    <h5 class="fw-bold text-dark mb-1 outfit">{{ $order->address->name }}</h5>
                    <p class="small text-secondary mb-3 lh-base">
                        {{ $order->address->address_line }}<br>
                        {{ $order->address->landmark ? $order->address->landmark.', ' : '' }}
                        {{ $order->address->city }}, {{ $order->address->state }} - {{ $order->address->pincode }}
                    </p>
                    <div class="d-flex align-items-center gap-2 small text-dark fw-bold">
                        <i class="bi bi-telephone text-orange"></i> {{ $order->address->mobile }}
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="p-4 rounded-4 border border-light h-100 d-flex flex-column justify-content-between">
                    <div class="row g-3">
                        <div class="col-6">
                            <p class="text-secondary small fw-bold uppercase tracking-wider mb-1">Status</p>
                            <span class="text-dark fw-black small text-uppercase">{{ $order->order_status }}</span>
                        </div>
                        <div class="col-6">
                            <p class="text-secondary small fw-bold uppercase tracking-wider mb-1">Mode</p>
                            <span class="text-dark fw-black small text-uppercase">{{ $order->payment_method }}</span>
                        </div>
                    </div>
                    <div class="mt-4 pt-3 border-top">
                        <p class="text-secondary small fw-bold uppercase tracking-wider mb-2">Authenticity QR</p>
                        <div class="d-flex align-items-center gap-3">
                            <div class="qr-placeholder d-flex align-items-center justify-content-center">
                                <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data={{ urlencode(url('/order-track?number='.$order->order_number)) }}" class="img-fluid" alt="QR">
                            </div>
                            <div class="small text-secondary opacity-75 fw-medium">Scan to verify order<br>integrity online.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <div class="table-responsive mb-5 position-relative">
            <table class="table border-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th>Product Specification</th>
                        <th class="text-center">Qty</th>
                        <th class="text-end">Unit Price</th>
                        <th class="text-end">Extended Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->orderItems as $index => $item)
                    <tr>
                        <td class="text-secondary small fw-bold">{{ $index + 1 }}</td>
                        <td>
                            <div class="fw-bold text-dark outfit mb-0">{{ $item->product->name }}</div>
                            @if($item->product->sku)
                                <div class="xx-small text-muted mt-1 opacity-75 fw-bold">SKU-ID: {{ $item->product->sku }}</div>
                            @endif
                        </td>
                        <td class="text-center fw-bold">×{{ $item->quantity }}</td>
                        <td class="text-end fw-medium">₹{{ number_format($item->price) }}</td>
                        <td class="text-end fw-black text-dark outfit x-small">₹{{ number_format($item->price * $item->quantity) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Totals & Summary -->
        <div class="row justify-content-between position-relative">
            <div class="col-md-6">
                <div class="p-4 rounded-4 bg-premium-light mt-4">
                    <h6 class="small fw-black text-dark mb-3 uppercase tracking-wider">Note to Customer:</h6>
                    <p class="small text-secondary mb-0 lh-lg" style="font-size: 0.75rem;">
                        This is an authentic tax invoice for your purchase. Please keep this for any warranty claims. 
                        In case of any discrepancy, please contact our support team within 24 hours of receiving the shipment.
                    </p>
                </div>
            </div>
            <div class="col-md-5">
                <div class="summary-box">
                    <div class="d-flex justify-content-between mb-3 align-items-center">
                        <span class="text-secondary small fw-bold">Base Subtotal</span>
                        <span class="fw-black text-dark outfit x-small">₹{{ number_format($order->total_amount - $order->shipping_amount + $order->coupon_discount) }}</span>
                    </div>
                    @if($order->shipping_amount > 0)
                    <div class="d-flex justify-content-between mb-3 align-items-center">
                        <span class="text-secondary small fw-bold">Shipping & Handling</span>
                        <span class="fw-bold text-dark">₹{{ number_format($order->shipping_amount) }}</span>
                    </div>
                    @endif
                    @if($order->coupon_discount > 0)
                    <div class="d-flex justify-content-between mb-3 align-items-center">
                        <span class="text-secondary small fw-bold">Promo Discount ({{ $order->coupon_code }})</span>
                        <span class="fw-bold text-success">-₹{{ number_format($order->coupon_discount) }}</span>
                    </div>
                    @endif
                    
                    <div class="my-3 border-top border-light opacity-50"></div>
                    
                    <div class="d-flex justify-content-between mt-4 mb-2 align-items-end">
                        <h6 class="fw-black text-dark mb-0 uppercase tracking-widest small">Total Payable</h6>
                        <h3 class="fw-black mb-0 text-orange outfit">₹{{ number_format($order->total_amount) }}</h3>
                    </div>

                    @if($order->payment_method == 'cod')
                    <div class="mt-4 pt-3 border-top border-2 border-white">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-secondary x-small fw-bold opacity-75 uppercase">Paid Online (Advance)</span>
                            <span class="fw-bold text-success x-small">+₹{{ number_format($order->prepaid_amount) }}</span>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="text-dark small fw-black uppercase tracking-tighter">Amount Due on COD</span>
                            <span class="fw-black text-orange outfit">₹{{ number_format($order->cod_amount) }}</span>
                        </div>
                    </div>
                    @else
                    <div class="mt-4 pt-3 border-top border-2 border-white d-flex align-items-center gap-2">
                        <i class="bi bi-patch-check-fill text-success"></i>
                        <span class="xx-small fw-black text-success uppercase">Paid Full Online</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="footer-note position-relative">
            <div class="row align-items-center">
                <div class="col-8">
                    <p class="xx-small text-secondary fw-bold uppercase tracking-widest mb-2 opacity-75">Thank you for choosing Shopping Club India</p>
                    <p class="xx-small text-secondary mb-0 opacity-50">This is a digitally generated invoice and does not require an ink signature. All items are subject to terms of service.</p>
                </div>
                <div class="col-4 text-end">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/e/e0/Signature_luc_remington.png" alt="Signature" class="official-stamp mb-1">
                    <p class="small text-dark fw-black mb-0 opacity-50" style="font-size: 0.6rem;">AUTHORIZED SIGNATORY</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<script>
    function downloadPDF() {
        const element = document.getElementById('invoiceContent');
        const opt = {
            margin:       0,
            filename:     'Invoice-{{ $order->order_number }}.pdf',
            image:        { type: 'jpeg', quality: 1.0 },
            html2canvas:  { scale: 3, useCORS: true, letterRendering: true },
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };
        html2pdf().set(opt).from(element).save();
    }

    function downloadImage() {
        const element = document.getElementById('invoiceContent');
        html2canvas(element, { scale: 3, useCORS: true }).then(canvas => {
            const link = document.createElement('a');
            link.download = 'Invoice-{{ $order->order_number }}.png';
            link.href = canvas.toDataURL('image/png', 1.0);
            link.click();
        });
    }
</script>

</body>
</html>
