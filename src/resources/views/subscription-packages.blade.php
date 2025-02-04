<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing</title>
    <style>
        .pricing-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 20px;
        }
        .pricing-card {
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 20px;
            width: 300px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .pricing-card h2 {
            margin-top: 0;
        }
        .pricing-card p {
            margin: 10px 0;
        }
        .pricing-card .price {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
        .pricing-card .currency {
            font-size: 16px;
            color: #666;
        }
    </style>
</head>
<body>
<div class="pricing-container">
    @foreach ($pricing as $package)
    <div class="pricing-card">
        <h2>{{ $package['title'] }}</h2>
        <p>{{ $package['description'] }}</p>
        <p>Duration: {{ $package['durationDays'] }} days</p>
        <p>Status: {{ $package['status'] == 1 ? 'Active' : 'Inactive' }}</p>
        <p>Price: <span class="price">{{ $package['currentPricing']['price'] }}</span> <span class="currency">{{ $package['currentPricing']['currency'] }}</span></p>
        <p>Valid from {{ $package['currentPricing']['priceStartDate'] }} to {{ $package['currentPricing']['priceEndDate'] }}</p>
    </div>
    @endforeach
</div>
</body>
</html>