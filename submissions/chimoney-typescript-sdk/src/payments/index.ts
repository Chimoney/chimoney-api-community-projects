import { Base } from "../base"; 
import {
  ChimoneyPayout,
  MobileMoneyPayout,
  AirtimePayout,
  BankPayout,
  GiftCardPayout,
  XRPLPayout,
} from "./types"; // Importing the types for various payout options

// Define specific endpoints for each payout type
const CHIMONEY_PAYOUT_RESOURCE = "payouts/chimoney";
const MOBILE_MONEY_PAYOUT_RESOURCE = "payouts/mobile-money";
const AIRTIME_PAYOUT_RESOURCE = "payouts/airtime";
const BANK_PAYOUT_RESOURCE = "payouts/bank";
const GIFT_CARD_PAYOUT_RESOURCE = "payouts/gift-card";
const XRPL_PAYOUT_RESOURCE = "payouts/initiate-chimoney";

/**
 * Payments class extending Base to handle various payout types
 */
export class Payments extends Base {
  /**
   * Initiates a Chimoney payout by posting payout data to the Chimoney endpoint
   * @param payout - Data for the Chimoney payout
   * @returns Promise resolving to the API response containing payout details
   */
  async createChimoneyPayout(payout: ChimoneyPayout): Promise<any> {
    return await this.paymentPost(CHIMONEY_PAYOUT_RESOURCE, payout);
  }

  /**
   * Initiates a Mobile Money payout by posting payout data to the Mobile Money endpoint
   * @param payout - Data for the Mobile Money payout
   * @returns Promise resolving to the API response containing payout details
   */
  async createMobileMoneyPayout(payout: MobileMoneyPayout): Promise<any> {
    return await this.paymentPost(MOBILE_MONEY_PAYOUT_RESOURCE, payout);
  }

  /**
   * Initiates an Airtime payout by posting payout data to the Airtime endpoint
   * @param payout - Data for the Airtime payout
   * @returns Promise resolving to the API response containing payout details
   */
  async createAirtimePayout(payout: AirtimePayout): Promise<any> {
    return await this.paymentPost(AIRTIME_PAYOUT_RESOURCE, payout);
  }

  /**
   * Initiates a Bank payout by posting payout data to the Bank endpoint
   * @param payout - Data for the Bank payout
   * @returns Promise resolving to the API response containing payout details
   */
  async createBankPayout(payout: BankPayout): Promise<any> {
    return await this.paymentPost(BANK_PAYOUT_RESOURCE, payout);
  }

  /**
   * Initiates a Gift Card payout by posting payout data to the Gift Card endpoint
   * @param payout - Data for the Gift Card payout
   * @returns Promise resolving to the API response containing payout details
   */
  async createGiftCardPayout(payout: GiftCardPayout): Promise<any> {
    return await this.paymentPost(GIFT_CARD_PAYOUT_RESOURCE, payout);
  }

  /**
   * Initiates an XRPL payout by posting payout data to the XRPL endpoint
   * @param payout - Data for the XRPL payout
   * @returns Promise resolving to the API response containing payout details
   */
  async createXRPLPayout(payout: XRPLPayout): Promise<any> {
    return await this.paymentPost(XRPL_PAYOUT_RESOURCE, payout);
  }

  /**
   * Generic method to post payout requests to specific endpoints
   * @template T - Type of data required for the payout request, supporting flexible payload structures
   * @param endpoint - API endpoint for the payout type (e.g., "payouts/chimoney")
   * @param payoutData - Data for the payout request, typed as T for flexibility
   * @returns Promise resolving to the API response or throws an error with detailed information
   */
  private async paymentPost<T>(endpoint: string, payoutData: T): Promise<any> {
    try {
      // Using post method from Base to send data to specified endpoint
      const response = await this.post(endpoint, payoutData);
      return response;
    } catch (error) {
      // Provides detailed error information for troubleshooting
      throw new Error(`Failed to process ${endpoint}: ${error.message || error}`);
    }
  }
}
