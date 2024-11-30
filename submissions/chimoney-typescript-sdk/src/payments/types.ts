// types.ts

export declare type ChimoneyPayout = {
    subAccount?: string; // Subaccount (Wallet Account) to payout from, if any
    turnOffNotification?: boolean; // Disables email and other notifications from Chimoney
    chimoneys?: Array<{ // Made chimoneys optional
        email: string; // Recipient email address
        phone: string; // Recipient Phone Number with country code
        valueInUSD: number; // Amount in USD to send
        amount: number; // Amount in specified currency to send (Required if currency is set)
        currency: string; // ISO Currency String like CAD, USD, etc.
        narration: string; // Narration/Description of payment
        collectionPaymentIssueID?: string; // Issue ID for the payment payout initiated
        redeemData: {
            walletID: string; // Chimoney Wallet ID to deposit the value to
            interledgerWalletAddress: string; // Interledger Wallet Address to settle the Payment
        };
    }>;
};

export declare type MobileMoneyPayout = {
    subAccount?: string; // Subaccount (Wallet Account) to payout from, if any
    turnOffNotification?: boolean; // Disables email and other notifications from Chimoney
    momos: Array<{
        countryToSend: string; // Payout country
        phoneNumber: string; // Recipient phone Number
        valueInUSD: number; // Payout value in USD
        reference: string; // Transaction reference
        momoCode: string; // Mobile money code
        narration: string; // Narration/Description of payment
        collectionPaymentIssueID: string; // Issue ID for the payment payout initiated
    }>;
};

// Airtime Payout
export declare type AirtimePayout = {
    subAccount?: string; // Subaccount (Wallet Account) to payout from, if any
    turnOffNotification?: boolean; // Disables email and other notifications from Chimoney
    airtimes: Array<{
        countryToSend: string; // Country of recipient
        phoneNumber: string; // Phone number of recipient
        valueInUSD: string; // Payout value in USD
        narration: string; // Narration/Description of payment to be included in notification to user
        collectionPaymentIssueID: string; // Issue ID for the payment payout initiated
    }>;
};

// Bank Payout
export declare type BankPayout = {
    subAccount?: string; // Optional subaccount (Wallet Account) to payout from
    turnOffNotification?: boolean; // Optional, disables email and other notifications
    debitCurrency: string; // Wallet currency to debit from
    banks: Array<{
        countryToSend: string; // Required, payout country
        account_bank: string; // Required, bank code
        account_number: string; // Required, recipient account number
        valueInUSD: number; // Payout value in USD
        amount: number; // Payout amount in specified currency (defaults to valueInUSD)
        reference: string; // Transaction reference
        fullname?: string; // Required for all countries except Nigeria
        branch_code?: string; // Required for all countries except Nigeria
        narration: string; // Description of payment to be included in notification to user
        collectionPaymentIssueID?: string; // Issue ID for the payment payout initiated
    }>;
};

// Gift Card Payout
export declare type GiftCardPayout = {
    subAccount?: string; // Optional: Subaccount (Wallet Account) to payout from, if any.
    turnOffNotification?: boolean; // Optional: Disables email and other notifications from Chimoney.
    giftcards: Array<{
        email: string; // Required: Recipient email address.
        valueInUSD: number; // Required: Value in USD.
        narration: string; // Required: Narration/Description of payment to be included in notification to user.
        collectionPaymentIssueID: string; // Required: Issue ID for the payment payout initiated.
        redeemData: {
            productId: string; // Required: Product ID.
            countryCode: string; // Required: The country code.
            valueInLocalCurrency: number; // Required: The value in local currency.
        };
    }>; // Required: Giftcard payload.
};

// XRPL Payout
// types.ts

export declare type XRPLPayout = {
    subAccount?: string; // Optional: Subaccount (Wallet Account) to payout from, if any.
    turnOffNotification?: boolean; // Optional: Disables email and other notifications from Chimoney.
    redirect_url?: string; // Optional: URL to redirect to after payment is confirmed.
    debitCurrency?: string; // Optional: Wallet Currency to debit from.
    chimoneys: Array<{
        email: string; // Required: Recipient email address.
        phone: string; // Required: Recipient Phone Number with country code.
        valueInUSD: number; // Required: Value in USD. Defaults to valueInUSD and ignores amount if both set.
        amount: number; // Required: Amount in debitCurrency to send.
        currency: string; // Required: Local currency to payout to.
        narration: string; // Required: Description of payment to be included in notification to user.
        redeemData: {
            walletID: string; // Required: Chimoney Wallet ID to deposit the value to.
            interledgerWalletAddress: string; // Required: Interledger Wallet Address (Payment Pointer) to settle the Payment.
            account_bank: string; // Required: Bank code.
            account_number: string; // Required: Recipient account number.
            branch_code?: string; // Optional: Branch code from /info/bank-branches. Required for all countries except Nigeria.
            fullname: string; // Required: Full name of the receiver of the bank payout.
        };
        enableXUMMPayment?: boolean; // Optional: Generate a Xumm transaction sign link.
        enableInterledgerPayment?: boolean; // Optional: Generate an Open Payment payment request to pay with Interledger.
        cryptoPayment?: Array<{
            // Required: Crypto payload.
            // Define specific properties for the crypto payment if needed.
        }>;
    }>; // Required: Chimoneys payload.
};


