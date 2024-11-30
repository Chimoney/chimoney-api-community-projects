/**
 * Data transfer object for retrieving transactions by issue ID.
 */
export interface TransactionsByIssueIDDto {
  issueID: string; // The issue ID for which transactions are to be retrieved.
  subAccount?: string; // Optional sub-account identifier.
}

/**
 * Data transfer object for retrieving a transaction by ID.
 */
export interface TransactionByIDDto {
  transactionId: string; // The ID of the transaction to be retrieved.
  subAccount?: string; // Optional sub-account identifier.
}

/**
 * Data transfer object for performing an account transfer.
 */
export interface AccountTransferDto {
  receiver: string; // The receiver's identifier.
  valueInUSD: number; // The value to be transferred in USD.
  wallet?: string; // Optional wallet identifier.
  subAccount?: string | null; // Optional sub-account identifier (nullable).
}

/**
 * Data transfer object for deleting an unpaid transaction.
 */
export interface DeleteUnpaidTransactionDto {
  chiRef: string; // The CHI reference of the unpaid transaction to be deleted.
  subAccount?: string | null; // Optional sub-account identifier (nullable).
}
