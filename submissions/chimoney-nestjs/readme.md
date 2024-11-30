# Chimoneyjs

Chimoneyjs is a js wrapper for <a href="https://chimoney.io"> Chimoney </a>

- [Account](#using-the-account-api)
- [Info](#using-the-info-api)
- [Payout](#using-the-payouts-api)
- [Mobile Money](#using-the-mobilemoney-api)
- [Wallet](#using-the-wallet-api)
- [Sub-Account](#using-the-subaccount-api)
- [Redeem](#using-the-redeem-api)

## Getting Started

- Register with <a href="https://chimoney.io"> Chimoney </a>
- Request for API KEY from support
- set Your "CHIMONEY_API_KEY" environment variable
  You can use a .env file as shown below to set your API key

  ```env
  CHIMONEY_API_KEY = "YOUR API KEY"
  ```

## Installing

    - npm install chimoneyjs

## Usage

#### Using chimoneyjs

There are two ways of setting your API key.

- You can export it as an environment variable as mentioned above (recommended)
- You can pass it as an argument when initialising chimoney

```js
// Initialise chimoney without api key (recommended)
const chimoney = require("chimoneyjs")();

// Initialise chimoney with api key
require("dotenv").config();
const chimoney = require("chimoneyjs")(process.env.API_KEY);
```

The issue with the latter is that you'd have to initialise your api key whenever you import the package. For this reason we recommend exporting your apiKey as an environment variables

#### Full Example

```js
const { account, wallet } = require("chimoneyjs")();

account
  .getAllTransactions()
  .then((response) => console.log(response)) // model of response {status:"success", data:...}
  .catch((err) => console.log(err));
```

## API

Every function returns the response body as received from the Chi Money API. Ideally each response is an object with **status** and **data** properties. **status** always has a value of "success". For more information about the responses visit [ChiMoneyAPI](https://chimoney.readme.io/reference/) documentation

```js
// sample response
{
  status: "success",
  data: {
        amountInUSD: "20",
        destinationCurrency: "NGN",
        amountInDestinationCurrency: 11000,
        validUntil: "2022-10-18T22:46:20.616Z"
      }
}
```

### Using the Account API

```js
const { account } = require("chimoneyjs")();
```

#### **getTransactionsByIssueID(issueID, subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-accounts-issue-id-transactions)

This function gets all transactions by IssueID

_Returns_: The response from the Chi Money API

| Param      | Type                | Default           | Description                       |
| ---------- | ------------------- | ----------------- | --------------------------------- |
| issueID    | <code>string</code> |                   | The issueID of the transaction    |
| subAccount | <code>string</code> | <code>null</code> | The subAccount of the transaction |

#### **getAllTransactions(subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-accounts-transactions)

This functions returns a list of transactions by account

_Returns_: The response from the Chi Money API

| Param      | Type                | Default           | Description                       |
| ---------- | ------------------- | ----------------- | --------------------------------- |
| subAccount | <code>string</code> | <code>null</code> | The subAccount of the transaction |

#### **accountTransfer(receiver, amount, wallet, subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-accounts-transfer)

This transaction transfers funds from wallet to receiver

_Returns_: The response from the Chi Money API

| Param      | Type                | Default           | Description                       |
| ---------- | ------------------- | ----------------- | --------------------------------- |
| receiver   | <code>string</code> |                   | The receiver of the funds         |
| amount     | <code>number</code> |                   | The amount of funds               |
| wallet     | <code>string</code> |                   | The wallet to be transfered from  |
| subAccount | <code>string</code> | <code>null</code> | The subAccount of the transaction |

#### **deleteUnpaidTransaction(chiRef, subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/delete_v0-2-accounts-delete-unpaid-transaction)

This function deletes an unpaid transaction

_Returns_: The response from the ChiMoney API

| Param      | Type                | Default           | Description                       |
| ---------- | ------------------- | ----------------- | --------------------------------- |
| chiRef     | <code>string</code> |                   | The ID of the transaction         |
| subAccount | <code>string</code> | <code>null</code> | The subAccount of the transaction |

#### **getTransactionByID(transctionId, subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-accounts-transaction)

This function gets a transaction by ID

_Returns_: The response from the Chi Money API

| Param        | Type                | Default           | Description                       |
| ------------ | ------------------- | ----------------- | --------------------------------- |
| transctionId | <code>string</code> |                   | The ID of the transaction         |
| subAccount   | <code>string</code> | <code>null</code> | The subAccount of the transaction |

### Using the Info API

```js
const { info } = require("chimoneyjs")();
```

#### **airtimeCountries()**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/get_v0-2-info-airtime-countries)

This function returns a list of countries that support airtime

_Returns_: The response from Chi Money API

#### **assets()**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/get_v0-2-info-assets)

This function returns a list of supported assets

_Returns_: The response from the Chi Money API

#### **banks(country)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/get_v0-2-info-country-banks)

_Returns_: The response from Chi Money API

| Param   | Type                | Default                     | Description                               |
| ------- | ------------------- | --------------------------- | ----------------------------------------- |
| country | <code>string</code> | <code>&quot;NG&quot;</code> | The country code, default is Nigeria(NG). |

#### **localAmountInUSD(originCurrency, amountInOriginCurrency)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/get_v0-2-info-local-amount-in-usd)

This function returns the equivalent of local currency in USD

_Returns_: The response from the Chi Money API

| Param                  | Type                | Description                       |
| ---------------------- | ------------------- | --------------------------------- |
| originCurrency         | <code>string</code> | The source currency               |
| amountInOriginCurrency | <code>number</code> | The amount in the origin currency |

#### **mobileMoneyCodes()**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/get_v0-2-info-mobile-money-codes)

This function returns a list of supported mobile money codes

_Returns_: The response from the Chi Money API

#### **usdInLocalAmount(destinationCurrency, amountInUSD)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/get_v0-2-info-usd-amount-in-local)

This function returns the equivalent of USD in the destination currency.

_Returns_: The response from the Chi Money API

| Param               | Type                | Description              |
| ------------------- | ------------------- | ------------------------ |
| destinationCurrency | <code>string</code> | The destination currency |
| amountInUSD         | <code>number</code> | The amount in USD        |

#### Using the MobileMoney API

```js
const { mobileMoney } = require("chimoneyjs")();
```

#### **getAllTransactions(subAccount**)

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-collections-mobile-money-all)

This function returns an array of all mobile money(momo) transactions

_Returns_: The response from the Chi Money API

| Param      | Type                | Default           | Description                       |
| ---------- | ------------------- | ----------------- | --------------------------------- |
| subAccount | <code>string</code> | <code>null</code> | The subAccount of the transaction |

#### **makePayment(paymentDetails, subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-collections-mobile-money-collect)

This function enables a user to make payment with mobile money (momo)

_Returns_: The response from the Chi Money API

| Param          | Type                | Default           | Description                                    |
| -------------- | ------------------- | ----------------- | ---------------------------------------------- |
| paymentDetails | <code>Object</code> |                   | An object with the appropriate payment details |
| subAccount     | <code>string</code> | <code>null</code> | The subAccount of the transaction              |

#### **verifyPayment(id, subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-collections-mobile-money-verify)

This function enables the user to verify mobile money payments

_Returns_: The response from the Chi Money API

| Param      | Type                | Default           | Description                       |
| ---------- | ------------------- | ----------------- | --------------------------------- |
| id         | <code>string</code> |                   | The transaction id                |
| subAccount | <code>string</code> | <code>null</code> | The subAccount of the transaction |

#### Using the Payouts API

```js
const { payouts } = require("chimoneyjs")();
```

#### **airtime(airtimes, subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-payouts-airtime)

This function handles the Chi Money airtime API.

_Returns_: The response from the Chi Money API

| Param      | Type                              | Default           | Description                                       |
| ---------- | --------------------------------- | ----------------- | ------------------------------------------------- |
| airtimes   | <code>Array.&lt;object&gt;</code> |                   | An array of object containing the airtime details |
| subAccount | <code>string</code>               | <code>null</code> | The subAccount of the transaction                 |

**Example**

```js
const airtimes = [
  {
    countryToSend: "Nigeria",
    phoneNumber: "+2348123456789",
    valueInUSD: 3,
  },
];
```

#### **bank(banks, subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-payouts-bank)

This function handles the bank API

_Returns_: The response from Chi Money API

| Param      | Type                              | Default           | Description                                     |
| ---------- | --------------------------------- | ----------------- | ----------------------------------------------- |
| banks      | <code>Array.&lt;object&gt;</code> |                   | An array of objects containing the bank details |
| subAccount | <code>string</code>               | <code>null</code> | The subAccount of the transaction               |

**Example**

```js
const banks = [
  {
    countryToSend: "Nigeria",
    account_bank: "044",
    account_number: "0690000031",
    valueInUSD: 1,
    reference: "1234567890",
  },
];
```

#### **chimoney(chimoneys, subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-payouts-chimoney)

This functions handles the chimoney API

_Returns_: The response from the Chi Money API

| Param      | Type                              | Default           | Description                                          |
| ---------- | --------------------------------- | ----------------- | ---------------------------------------------------- |
| chimoneys  | <code>Array.&lt;object&gt;</code> |                   | An array of objects containing the chimoney details. |
| subAccount | <code>string</code>               | <code>null</code> | The subAccount of the transaction                    |

**Example**

```js
const chimoneys = [
  {
    valueInUSD: 1,
    email: "text@example.com",
    twitter: "@tester",
  },
];
```

#### **mobileMoney(momos, subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-payouts-mobile-money)

This function handles mobile money API

_Returns_: The response from the Chi Money API

| Param      | Type                              | Default           | Description                                             |
| ---------- | --------------------------------- | ----------------- | ------------------------------------------------------- |
| momos      | <code>Array.&lt;object&gt;</code> |                   | An array of objects containing the mobile money details |
| subAccount | <code>string</code>               | <code>null</code> | The subAccount of the transaction                       |

**Example**

```js
const momos = [
  {
    countryToSend: "Nigeria",
    phoneNumber: "+2348123456789",
    valueInUSD: 1,
    reference: "1234567890",
  },
];
```

#### **giftCard(giftCards, subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-payouts-gift-card)

This function handles the gift card API

_Returns_: The response from the Chi Money API

| Param      | Type                              | Default           | Description                                          |
| ---------- | --------------------------------- | ----------------- | ---------------------------------------------------- |
| giftCards  | <code>Array.&lt;object&gt;</code> |                   | An array of objects containing the gift card details |
| subAccount | <code>string</code>               | <code>null</code> | The subAccount of the transaction                    |

**Example**

```js
const giftCards = [
  {
    email: "test@example.com",
    valueInUSD: 1,
    redeemData: {
      productId: "3",
      countryCode: "NG",
      valueInLocalCurrency: 1000,
    },
  },
];
```

#### **status(chiRef, subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-payouts-status)

This function handles the status API

_Returns_: The response from the Chi Money API

| Param      | Type                | Default           | Description                       |
| ---------- | ------------------- | ----------------- | --------------------------------- |
| chiRef     | <code>string</code> |                   | The Chi Money reference           |
| subAccount | <code>string</code> | <code>null</code> | The subAccount of the transaction |

#### **initiateChimoney(chimoneys, crypto_payments, subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-payouts-initiate-chimoney)

This function handles the initiate chimoney API

_Returns_: The response from the Chi Money API

| Param               | Type                              | Default            | Description                                                |
| ------------------- | --------------------------------- | ------------------ | ---------------------------------------------------------- |
| chimoneys           | <code>Array.&lt;object&gt;</code> |                    | An array of objects containing the chimoney details        |
| turnOffNotification | <code>boolean</code>              | <code>false</code> | If set to true turns of email notification for this payout |
| crypto_payments     | <code>Array.&lt;object&gt;</code> |                    | An array of objects containing the crypto payment details  |
| subAccount          | <code>string</code>               | <code>null</code>  | The subAccount of the transaction                          |

**Example**

```js
const chimoneys = [
  {
    valueInUSD: 1,
    email: "text@example.com",
    twitter: "@tester",
  },
];
```

**Example**

```js
const crypto_payments = [
  {
    xrpl: {
      address: "rHb9CJAWyB4rj91VRWn96DkukG4bwdtyTh",
      issuer: "rHb9CJAWyB4rj91VRWn96DkukG4bwdtyTh",
      currency: "XRP",
    },
  },
];
```

#### Using the Redeem API

```js
const { redeem } = require("chimoneyjs")();
```

#### **airtime(chiRef, phoneNumber, countryToSend, meta, subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-redeem-airtime)

This function allows you to redeem airtime transactions

_Returns_: The response from the Chi Money API

| Param         | Type                | Default           | Description                           |
| ------------- | ------------------- | ----------------- | ------------------------------------- |
| chiRef        | <code>string</code> |                   | The Chi reference                     |
| phoneNumber   | <code>string</code> |                   | Phone number                          |
| countryToSend | <code>string</code> |                   | Country to send to                    |
| meta          | <code>object</code> |                   | Any data to be sent along the request |
| subAccount    | <code>string</code> | <code>null</code> | The subAccount of the transaction     |

#### **any(chiRef, redeemData, [meta], subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-redeem-any)

This function allows you to redeem any transaction (chimoney, momo, airtime)

_Returns_: The response from the Chi Money API

| Param      | Type                              | Default           | Description                                                                              |
| ---------- | --------------------------------- | ----------------- | ---------------------------------------------------------------------------------------- |
| chiRef     | <code>string</code>               |                   | The Chi reference                                                                        |
| redeemData | <code>array.&lt;object&gt;</code> |                   | Any array of objects containing data needed to redeem the transaction. see example below |
| [meta]     | <code>object</code>               | <code>{}</code>   | Any data to be sent along with the request. defaults to an empty object                  |
| subAccount | <code>string</code>               | <code>null</code> | The subAccount of the transaction                                                        |

**Example**

```js
const redeemData = [
  {
    countryCode: "NG",
    productId: 1,
    valueInLocalCurrency: 1000,
  },
];
```

#### **chimoney(chimoneys, subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-redeem-chimoney)

This function allows you to redeem chimoney

_Returns_: The response from the Chi Money API

| Param      | Type                              | Default           | Description                                       |
| ---------- | --------------------------------- | ----------------- | ------------------------------------------------- |
| chimoneys  | <code>array.&lt;object&gt;</code> |                   | An array of objects containing the redeem details |
| subAccount | <code>string</code>               | <code>null</code> | The subAccount of the transaction                 |

**Example**

```js
const chimoneys = [
  {
    field: "data",
  },
];
```

#### **giftCard(chiRef, redeemOptions, subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-redeem-gift-card)

This function allows you to redeem giftcard

_Returns_: The response from the Chi Money API

| Param         | Type                | Default           | Description                               |
| ------------- | ------------------- | ----------------- | ----------------------------------------- |
| chiRef        | <code>string</code> |                   | The Chi reference                         |
| redeemOptions | <code>object</code> |                   | The data needed to redeem the transaction |
| subAccount    | <code>string</code> | <code>null</code> | The subAccount of the transaction         |

#### **mobileMoney(chiRef, redeemOptions, subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-redeem-mobile-money)

This function allows you to redeem mobile money (momo)

_Returns_: The response from the Chi Money API

| Param         | Type                | Default           | Description                               |
| ------------- | ------------------- | ----------------- | ----------------------------------------- |
| chiRef        | <code>string</code> |                   | The Chi reference                         |
| redeemOptions | <code>object</code> |                   | The data needed to redeem the transaction |
| subAccount    | <code>string</code> | <code>null</code> | The subAccount of the transaction         |

#### Using the SubAccount API

```js
const { subAccount } = require("chimoneyjs")();
```

#### **create(name, email)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-sub-account-create)

This function creates a new subAccount with the provided name and email

_Returns_: The response from the Chi Money API

| Param | Type                | Description                     |
| ----- | ------------------- | ------------------------------- |
| name  | <code>string</code> | Name to give the new subAccount |
| email | <code>string</code> | Email                           |

<a name="deleteAccount"></a>

#### **deleteAccount(id)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/delete_v0-2-sub-account-delete)

This function deletes the subAccount with the given id

_Returns_: The response from the Chi Money API

| Param | Type                | Description              |
| ----- | ------------------- | ------------------------ |
| id    | <code>string</code> | The id of the subAccount |

#### **getDetails(id)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/get_v0-2-sub-account-get)

This function gets the details of the subAccount with the associated id

_Returns_: The response from the Chi Money API

| Param | Type                | Description              |
| ----- | ------------------- | ------------------------ |
| id    | <code>string</code> | The id of the subAccount |

#### **getAll()**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/get_v0-2-sub-account-list)

This function returns all the subAccounts associated with a user

_Returns_: The response from the Chi Money API

#### Using the Wallet API

```js
const { wallet } = require("chimoneyjs")();
```

#### **list(subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-wallets-list)

This function gets all the wallets associated with a user

_Returns_: The response from the Chi Money API

| Param      | Type                | Default           | Description                       |
| ---------- | ------------------- | ----------------- | --------------------------------- |
| subAccount | <code>string</code> | <code>null</code> | The subAccount of the transaction |

#### **details(id, subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-wallets-lookup)

This function gets the details associated with a single user wallet

_Returns_: The response from the Chi Money API

| Param      | Type                | Default           | Description                       |
| ---------- | ------------------- | ----------------- | --------------------------------- |
| id         | <code>string</code> |                   | The wallet id                     |
| subAccount | <code>string</code> | <code>null</code> | The subAccount of the transaction |

#### **transfer(receiver, wallet, amount, subAccount)**

For more information visit [Chi Money API](https://chimoney.readme.io/reference/post_v0-2-wallets-transfer)

This function lets you transfer funds to receiver

_Returns_: The response from the Chi Money API

| Param      | Type                | Description                                      |
| ---------- | ------------------- | ------------------------------------------------ |
| receiver   | <code>string</code> | The receiver id                                  |
| wallet     | <code>string</code> | The wallet type                                  |
| amount     | <code>number</code> | The amount of funds to be transferred in dollars |
| subAccount | <code>string</code> | The subAccount of the transaction                |

### **Errors**

There are four main types of errors throw by the **chimoneyjs** package.

- **ValueError**: Missing required function parameter(s)
- **TypeError**: Parameter with a wrong type was passed into a function.
- **ChiMoneyError**: Error with the request sent to the Chi Money API. This is as a result of invalid data being sent to the Chi Money server.
- **AuthKeyError**: This occurs when the API wasn't set.
