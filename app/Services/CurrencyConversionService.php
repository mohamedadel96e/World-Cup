<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Exception;

class CurrencyConversionService
{
    protected string $apiKey;
    protected string $baseUrl = 'https://v6.exchangerate-api.com/v6/';
    protected array $historicalRates;

    public function __construct()
    {
        $this->apiKey = config('services.exchange_rate.api_key');
        $this->historicalRates = config('historical_rates.rates');
    }

    public function convert(float $amount, string $fromCurrency, string $toCurrency): ?float
    {
        if ($fromCurrency === $toCurrency) {
            return $amount;
        }

        if (array_key_exists($fromCurrency, $this->historicalRates)) {
            // Step 1: Convert the historical amount to our proxy currency (USD)
            $rateToUsd = $this->historicalRates[$fromCurrency]['rate_to_usd'];
            $amountInUsd = $amount * $rateToUsd;

            // If the target is USD, we're done.
            if ($toCurrency === 'USD') {
                return $amountInUsd;
            }

            // Step 2: Now convert from USD to the final target currency using the API
            return $this->convertFromApi($amountInUsd, 'USD', $toCurrency);
        }

        // If the target is a historical currency, do the reverse
        if (array_key_exists($toCurrency, $this->historicalRates)) {
            $rateToUsd = $this->historicalRates[$toCurrency]['rate_to_usd'];
            $amountInUsd = $this->convertFromApi($amount, $fromCurrency, 'USD');

            return $amountInUsd / $rateToUsd;
        }


        // If no historical currencies are involved, use the API directly.
        return $this->convertFromApi($amount, $fromCurrency, $toCurrency);
    }

    /**
     * Performs the conversion using the external API.
     */
    protected function convertFromApi(float $amount, string $fromCurrency, string $toCurrency): ?float
    {
        try {
            $rates = $this->getExchangeRates($fromCurrency);

            if (!isset($rates[$toCurrency])) {
                return null;
            }

            return $amount * $rates[$toCurrency];

        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * Fetches exchange rates for a given base currency, using a cache.
     */
    protected function getExchangeRates(string $baseCurrency): array
    {
        $cacheKey = "currency_rates_{$baseCurrency}";
        $cacheDuration = 60 * 24; // 24 hours

        return Cache::remember($cacheKey, $cacheDuration, function () use ($baseCurrency) {
            $response = Http::get("{$this->baseUrl}{$this->apiKey}/latest/{$baseCurrency}");
            $response->throw();
            $data = $response->json();
            if ($data['result'] === 'success') {
                return $data['conversion_rates'];
            }
            throw new Exception('Failed to fetch exchange rates from API.');
        });
    }
}
