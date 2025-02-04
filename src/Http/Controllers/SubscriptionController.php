<?php

namespace LaravelLogin\Http\Controllers;

use Illuminate\Routing\Controller;

class SubscriptionController extends Controller
{

    public function showPricing()
    {
        $pricingData = '[{"id":"1","title":"Free","description":"Free subscription package","durationDays":30,"status":"1","protected":"1","trailLength":0,"dateCreated":"28-01-2025 17:28:03","currentPricing":{"price":"0.00","currency":"ZAR","priceStartDate":"28-01-2025","priceEndDate":"28-01-2026"},"new_price_effective_date":null,"duration_days":null,"application_id":"1","is_default":"1","trail_length":"0","date_created":"28-01-2025 17:28:03","role_id":"1"},{"id":"4","title":"Nanny Tow","description":null,"durationDays":30,"status":"1","protected":"0","trailLength":0,"dateCreated":"04-02-2025 13:20:22","currentPricing":{"price":"0.00","currency":"ZAR","priceStartDate":"04-02-2025","priceEndDate":"04-02-2026"},"new_price_effective_date":null,"duration_days":null,"application_id":"1","is_default":"0","trail_length":"0","date_created":"04-02-2025 13:20:22","role_id":"1"},{"id":"5","title":"Nanny","description":"Aaa","durationDays":"30","status":"1","protected":"0","trailLength":30,"dateCreated":"04-02-2025 13:21:02","currentPricing":{"price":"0.00","currency":"ZAR","priceStartDate":"04-02-2025","priceEndDate":"04-02-2026"},"new_price_effective_date":null,"duration_days":"30","application_id":"1","is_default":"0","trail_length":"30","date_created":"04-02-2025 13:21:02","role_id":"5"},{"id":"6","title":"Nanny","description":null,"durationDays":"30","status":"1","protected":"0","trailLength":7,"dateCreated":"04-02-2025 13:21:15","currentPricing":{"price":"0.00","currency":"ZAR","priceStartDate":"04-02-2025","priceEndDate":"04-02-2026"},"new_price_effective_date":null,"duration_days":"30","application_id":"1","is_default":"0","trail_length":"7","date_created":"04-02-2025 13:21:15","role_id":null},{"id":"7","title":"Test","description":"","durationDays":"30","status":"1","protected":"0","trailLength":7,"dateCreated":"04-02-2025 13:21:45","currentPricing":{"price":"0.00","currency":"ZAR","priceStartDate":"04-02-2025","priceEndDate":"04-02-2026"},"new_price_effective_date":null,"duration_days":"30","application_id":"1","is_default":"0","trail_length":"7","date_created":"04-02-2025 13:21:45","role_id":null},{"id":"8","title":"Test 3","description":"","durationDays":"30","status":"1","protected":"0","trailLength":7,"dateCreated":"04-02-2025 13:22:05","currentPricing":{"price":"0.00","currency":"ZAR","priceStartDate":"04-02-2025","priceEndDate":"04-02-2026"},"new_price_effective_date":null,"duration_days":"30","application_id":"1","is_default":"0","trail_length":"7","date_created":"04-02-2025 13:22:05","role_id":null},{"id":"9","title":"aaaa","description":"","durationDays":"30","status":"1","protected":"0","trailLength":7,"dateCreated":"04-02-2025 13:23:34","currentPricing":{"price":"0.00","currency":"ZAR","priceStartDate":"04-02-2025","priceEndDate":"04-02-2026"},"new_price_effective_date":null,"duration_days":"30","application_id":"1","is_default":"0","trail_length":"7","date_created":"04-02-2025 13:23:34","role_id":null},{"id":"10","title":"Candidate","description":"hsdhsadjsafadjskhfjdkhcjdhfdhfjdhfjdfhjhfdsfjdsfjdsahfjhdsajfhjdshfjdsahfkjhdsjfhjdhfdshfdjfdsjhfkjdsahfkjdskjfhdjsfhkjdshfkjdsahfkjdskjfsdajfhkjsadhf","durationDays":"30","status":"1","protected":"0","trailLength":7,"dateCreated":"04-02-2025 13:26:14","currentPricing":{"price":"0.00","currency":"ZAR","priceStartDate":"04-02-2025","priceEndDate":"04-02-2026"},"new_price_effective_date":null,"duration_days":"30","application_id":"1","is_default":"0","trail_length":"7","date_created":"04-02-2025 13:26:14","role_id":"5"}]';

        $pricing = json_decode($pricingData, true);
        return view('laravel-sso-login::subscription-packages', compact('pricing'));
    }

    public function subscribe()
    {
        // Subscribe the user
    }

}