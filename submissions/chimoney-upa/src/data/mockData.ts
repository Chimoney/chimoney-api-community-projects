const user = {
  "meta": {
    "name": "John Doe",
    "email": "john.doe@example.com",
    // ... other existing user meta data
  },
  "upa": {
    "profile": {
      "professionalTitle": "Software Developer",
      "bio": "Passionate developer with a love for open source.",
      "portfolioLink": "https://portfolio.example.com",
      "socialLinks": {
        "linkedin": "https://linkedin.com/in/johndoe",
        "github": "https://github.com/johndoe",
        "twitter": "https://twitter.com/johndoe",
        // ... other social platforms
      },
      "verificationBadge": true,
      "activityFeed": [
        {
          "type": "travel",
          "description": "Traveled to San Francisco for a tech conference.",
          "date": "2023-10-20"
        },
        // ... other activities
      ]
    },
    "payment": {
      "paymentPointer": "$wallet.example.com/johndoe",
      "bankDetails": {
        "iban": "GB33BUKB20201555555555",
        "bic": "BUKBGB22",
        "bankName": "Bank UK",
        "accountName": "John Doe",
        "accountNumber": "12345678",
        "sortCode": "20-20-15"
      },
      "mobileMoney": {
        "provider": "M-Pesa",
        "accountNumber": "0712345678"
      },
      "crypto": {
        "bitcoin": "1A1zP1eP5QGefi2DMPTfTL5SLmv7DivfNa",
        "ethereum": "0xAb5801a7D398351b8bE11C439e05C5B3259aeC9B",
        // ... other cryptocurrencies
      }
    }
  }
}

export default user;