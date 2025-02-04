<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
<div class="max-w-4xl w-full bg-white p-8 rounded-lg shadow-lg">
    <h2 class="text-3xl font-bold">Pricing</h2>
    <p class="text-gray-600 mt-2 font-semibold">Quality is never an accident. It is always the result of intelligent effort</p>
    <p class="text-gray-500">It makes no difference what the price is, it all makes sense to us.</p>

    <div class="mt-6 flex gap-6">
        <!-- Feature List -->
        <div class="flex-1 bg-gray-50 p-6 rounded-lg shadow-sm">
            test
<!--            {{ $package['description'] }}-->
        </div>

        <!-- Pricing Options -->
        <div class="flex-1">
            <div class="flex justify-end mb-4">
                <button class="px-4 py-2 text-sm font-semibold bg-gray-200 rounded-l-md">Monthly</button>
                <button class="px-4 py-2 text-sm font-semibold bg-blue-600 text-white rounded-r-md">Yearly <span class="ml-1 text-xs">Save 30%</span></button>
            </div>

            <div class="space-y-4">
                @foreach ($pricing as $package)
                <div class="border p-4 rounded-lg shadow-sm flex justify-between {{ $package['highlighted'] ? 'bg-blue-100 border-blue-500' : '' }} relative">
                    <div>
                        <h3 class="text-lg font-bold {{ $plan['highlighted'] ? 'text-blue-600' : '' }}">{{ $package['title'] }}</h3>
<!--                        <p class="text-gray-500 text-sm">{{ $plan['services'] }} Services</p>-->
                    </div>
                    <p class="text-xl font-semibold">{{ $package['currentPricing']['price'] }} <span class="text-sm">/ Per Month</span></p>
<!--                    @if($plan['popular'])-->
<!--                    <span class="absolute top-2 right-2 bg-green-500 text-white text-xs px-2 py-1 rounded">Popular</span>-->
<!--                    @endif-->
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
</body>
</html>
