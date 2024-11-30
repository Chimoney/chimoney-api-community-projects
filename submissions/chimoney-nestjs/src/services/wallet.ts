import { Inject, Injectable } from '@nestjs/common';
import { Axios } from 'axios';

import { WalletByIDDto, WalletTransferIDDto } from 'src/dto/wallet';
import { errorHandler, successHandler } from 'src/utils/errorHandler';
import { AXIOS_INSTANCE } from '../constants';

/**
 * Service responsible for handling wallet-related operations.
 */
@Injectable()
export class WalletsService {
  /**
   * Creates an instance of WalletsService.
   * @param {Axios} request - An Axios instance for making HTTP requests.
   */
  constructor(@Inject(AXIOS_INSTANCE) private readonly request: Axios) {}

  /**
   * Get a list of wallets.
   * @param {string | null} subAccount - The sub-account identifier.
   * @returns {Promise<any>} A Promise that resolves to the response data or rejects with an error.
   */
  async getWallets(subAccount: string | null): Promise<any> {
    try {
      const response = await this.request.post('wallets/list', {
        subAccount,
      });
      return successHandler(response);
    } catch (error) {
      return errorHandler(error);
    }
  }

  /**
   * Get wallet information by ID.
   * @param {WalletByIDDto} data - The data containing the wallet ID.
   * @returns {Promise<any>} A Promise that resolves to the response data or rejects with an error.
   */
  async getWallet(data: WalletByIDDto): Promise<any> {
    try {
      const response = await this.request.post('wallets/lookup', data);
      return successHandler(response);
    } catch (error) {
      return errorHandler(error);
    }
  }

  /**
   * Transfer funds between wallets.
   * @param {WalletTransferIDDto} data - The data containing the wallet transfer details.
   * @returns {Promise<any>} A Promise that resolves to the response data or rejects with an error.
   */
  async transferWallet(data: WalletTransferIDDto): Promise<any> {
    try {
      // Send a POST request to the 'wallets/transfer' endpoint with the provided data
      const response = await this.request.post('wallets/transfer', data);
      return successHandler(response);
    } catch (error) {
      // Handle any exceptions that occur during the request (e.g., network issues)
      console.error('An error occurred:', error);
      return errorHandler(error); // Pass the error to the error handler
    }
  }
}
