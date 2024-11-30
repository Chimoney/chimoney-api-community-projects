/**
 * Data transfer object for initiating a payment.
 */
export interface InitiatePaymentDto {
  redirect_url: string; // The URL to which the payment should be redirected.
  valueInUSD: number; // The payment value in USD.
  payerEmail?: string; // Optional email address of the payer.
  subAccount?: string | null; // Optional sub-account identifier (nullable).
  meta?: {
    [x: string]: string | number; // Optional metadata as key-value pairs.
  };
}

/**
 * Data transfer object for verifying a payment.
 */
export interface VerifyPaymentDto {
  id: string; // The ID of the payment to be verified.
  subAccount?: string | null; // Optional sub-account identifier (nullable).
}

/**
 * Data transfer object for simulating payment status changes.
 */
export interface SimulatePaymentStatusDto {
  issueID: string; // The issue ID associated with the payment.
  status: PaymentType; // The new status of the payment.
  subAccount?: string | null; // Optional sub-account identifier (nullable).
}

/**
 * Enum representing payment status types.
 */
export enum PaymentType {
  EXPIRED = 'expired', // Payment status: expired
  FAILED = 'failed', // Payment status: failed
  FRAUD = 'fraud', // Payment status: fraud
}
