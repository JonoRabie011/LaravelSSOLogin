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
        <div class="flex-1 bg-gray-50 p-6 rounded-lg shadow-sm" id="package-description" style="word-wrap: break-word; overflow-wrap: break-word; white-space: normal; max-width: 450px;">
            Select a package to see the features
        </div>

        <!-- Pricing Options -->
        <div class="flex-1">
<!--            <div class="flex justify-end mb-4">-->
<!--                <button class="px-4 py-2 text-sm font-semibold bg-gray-200 rounded-l-md">Monthly</button>-->
<!--                <button class="px-4 py-2 text-sm font-semibold bg-blue-600 text-white rounded-r-md">Yearly <span class="ml-1 text-xs">Save 30%</span></button>-->
<!--            </div>-->

            <div class="space-y-4">
                @foreach ($pricing as $index => $package)
                <div class="border p-4 rounded-lg shadow-sm flex justify-between relative package-item" data-index="{{ $index }}">
                    <div>
                        <h3 class="text-lg font-bold">{{ $package['title'] }}</h3>
                    </div>
                    <p class="text-xl font-semibold">{{ $package['currentPricing']['price'] }} <span class="text-sm">/ Every {{$package['durationDays']}} Days</span></p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>

<script>
    // JavaScript to handle package selection and highlighting
    document.querySelectorAll('.package-item').forEach(item => {
        item.addEventListener('click', function() {
            // Remove highlighting from all items
            document.querySelectorAll('.package-item').forEach(i => i.classList.remove('bg-blue-100', 'border-blue-500'));

            // Add highlight to the selected package
            item.classList.add('bg-blue-100', 'border-blue-500');

            // Get the selected package's index and update the description section
            const packageIndex = item.getAttribute('data-index');
            var pricingData = @json($pricing); // Embed the PHP $pricing data into JavaScript

            // Set the description in the feature list
            document.getElementById('package-description').innerHTML = pricingData[packageIndex].description;
        });
    });
</script>
</body>
</html>
