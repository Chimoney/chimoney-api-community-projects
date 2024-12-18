<p align="center">
  <a href="https://laravel.com" target="_blank">
    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
  </a>
</p>

<p align="center">
  <a href="https://travis-ci.org/laravel/framework">
    <img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version">
  </a>
  <a href="https://packagist.org/packages/laravel/framework">
    <img src="https://img.shields.io/packagist/l/laravel/framework" alt="License">
  </a>
</p>

# Chimoney Laravel SDK

The **Chimoney Laravel SDK** simplifies integration with the Chimoney API, enabling Laravel developers to perform operations like payment processing, rewards handling, and more.

## Installation Instructions

### Prerequisites

- PHP 8.0 or higher
- Composer
- Laravel 8.x or higher

### Step 1: Install the SDK using Composer

```bash
composer require chimoney/chimoney-laravel-sdk
```

### Step 2: Publish Configuration File

After installation, publish the configuration file to your Laravel project:

```bash
php artisan vendor:publish --provider="Chimoney\ChimoneyServiceProvider"
```

This will create a `chimoney.php` configuration file in the config directory.

### Step 3: Add API Credentials to .env

Add the following Chimoney API credentials to your Laravel `.env` file:

```env
CHIMONEY_API_KEY=your_api_key
CHIMONEY_BASE_URL=https://api.chimoney.io
```

Make sure to replace `your_api_key` with the API key obtained from Chimoney.

### Step 4: Clear Configuration Cache (Optional)

If you have previously cached your configuration, clear the cache:

```bash
php artisan config:clear
```

## Usage Guide

### Basic Usage

Here is a step-by-step example of how to use the Chimoney Laravel SDK.

#### Step 1: Initialize the SDK

Use dependency injection or the facade to initialize the SDK in your controller or service class.

```php
use Chimoney\Chimoney;

class PaymentController extends Controller
{
    public function makePayment()
    {
        $chimoney = new Chimoney();
        
        // Example API request
        $response = $chimoney->sendPayout([
            'amount' => 100,
            'currency' => 'USD',
            'recipient' => [
                'email' => 'user@example.com'
            ],
        ]);

        if ($response['success']) {
            return response()->json(['message' => 'Payment sent successfully!']);
        }

        return response()->json(['error' => $response['error']], 400);
    }
}
```

#### Step 2: Handle Responses

The SDK will return responses in a structured format. For example:

```php
$response = $chimoney->checkBalance();

if ($response['success']) {
    return $response['data'];
} else {
    return $response['error'];
}
```

### Additional Operations

The SDK supports various operations. Examples include:

**Check Balance:**
```php
$chimoney->checkBalance();
```

**Send Payouts:**
```php
$chimoney->sendPayout([...]);
```

**Retrieve Transaction History:**
```php
$chimoney->getTransactions();
```

Refer to the Chimoney API documentation for a complete list of available endpoints and operations.

## Configuration Details

### Environment Variables

- `CHIMONEY_API_KEY`: The API key provided by Chimoney.
- `CHIMONEY_BASE_URL`: The base URL for Chimoney API. Default is https://api.chimoney.io.

Ensure these are set in your `.env` file.

### Configuration File

The `chimoney.php` file in the config directory includes customizable settings. For example:

```php
return [
    'api_key' => env('CHIMONEY_API_KEY'),
    'base_url' => env('CHIMONEY_BASE_URL', 'https://api.chimoney.io'),
];
```

## Testing Instructions

### Step 1: Verify SDK Installation

Create a simple route to ensure the SDK is installed and functioning:

```php
Route::get('/test-chimoney', function () {
    $chimoney = new \Chimoney\Chimoney();
    $response = $chimoney->checkBalance();
    
    return response()->json($response);
});
```

Visit `/test-chimoney` in your browser or use a tool like Postman to ensure the API connection is successful.

### Step 2: Run Unit Tests

If you have PHPUnit configured in your Laravel project, you can write and run tests to verify the SDK functionality. Example:

```php
public function testChimoneyBalanceCheck()
{
    $chimoney = new \Chimoney\Chimoney();
    $response = $chimoney->checkBalance();

    $this->assertTrue($response['success']);
}
```

Run tests with:

```bash
php artisan test
```

### Step 3: Debugging Tips

- Check your `.env` file for proper API key configuration
- Use `php artisan config:clear` to refresh environment variable settings
- Inspect API responses using Laravel's logging system

## Contributing

Contributions are welcome! Please read the contribution guidelines for details on how to contribute.

## License

The Chimoney Laravel SDK is open-sourced software licensed under the MIT license.
