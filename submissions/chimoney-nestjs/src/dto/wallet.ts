/**
 * Data transfer object for retrieving a wallet by ID.
 */
export interface WalletByIDDto {
  walletID: string; // The ID of the wallet to be retrieved.
  subAccount?: string; // Optional sub-account identifier.
}

/**
 * Data transfer object for transferring funds from a wallet.
 */
export interface WalletTransferIDDto {
  receiver: string; // The recipient's identifier.
  valueInUSD: string; // The value to be transferred in USD.
  subAccount?: string; // Optional sub-account identifier.
  wallet?: TransactionType; // Optional wallet type for the transaction.
}

/**
 * Enum representing transaction types for wallet transfers.
 */
export enum TransactionType {
  CHI = 'chi', // Transaction type: CHI
  AIRTIME = 'airtime', // Transaction type: AIRTIME
  MOMO = 'momo', // Transaction type: MOMO
}
