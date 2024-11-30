import { Inject, Injectable } from '@nestjs/common';
import { Axios } from 'axios';
import { errorHandler, successHandler } from '../utils/errorHandler';
import {
  AccountTransferDto,
  DeleteUnpaidTransactionDto,
  TransactionByIDDto,
  TransactionsByIssueIDDto,
} from 'src/dto/account';
import { AXIOS_INSTANCE } from '../../src/constants';

/**
 * Service responsible for handling account-related operations.
 */
@Injectable()
export class AccountService {
  /**
   * Creates an instance of AccountService.
   * @param {Axios} request - An Axios instance for making HTTP requests.
   */
  constructor(@Inject(AXIOS_INSTANCE) private readonly request: Axios) {}

  /**
   * Get transactions by issue ID.
   *
   * @param {TransactionsByIssueIDDto} data - The data for retrieving transactions by issue ID.
   * @returns {Promise<any>} A Promise that resolves to the response data or rejects with an error.
   */
  async getTransactionsByIssueID({
    issueID,
    subAccount,
  }: TransactionsByIssueIDDto): Promise<any> {
    try {
      const response = await this.request.post(
        `accounts/issue-id-transactions?issueID=${issueID}`,
        { subAccount },
      );

      return successHandler(response);
    } catch (error) {
      return errorHandler(error);
    }
  }

  /**
   * Get all transactions.
   *
   * @param {string | null} subAccount - The sub-account identifier (optional).
   * @returns {Promise<any>} A Promise that resolves to the response data or rejects with an error.
   */
  async getAllTransactions(subAccount: string | null = null): Promise<any> {
    try {
      const response = await this.request.post(`accounts/transactions`, {
        subAccount,
      });

      return successHandler(response);
    } catch (error) {
      return errorHandler(error);
    }
  }

  /**
   * Get a transaction by ID.
   *
   * @param {TransactionByIDDto} data - The data for retrieving a transaction by ID.
   * @returns {Promise<any>} A Promise that resolves to the response data or rejects with an error.
   */
  async getTransactionByID({
    transactionId,
    subAccount,
  }: TransactionByIDDto): Promise<any> {
    try {
      const response = await this.request.post(
        `accounts/transaction?id=${transactionId}`,
        {
          subAccount,
        },
      );

      return successHandler(response);
    } catch (error) {
      return errorHandler(error);
    }
  }

  /**
   * Transfer funds between accounts.
   *
   * @param {AccountTransferDto} data - The data for performing an account transfer.
   * @returns {Promise<any>} A Promise that resolves to the response data or rejects with an error.
   */
  async accountTransfer(data: AccountTransferDto): Promise<any> {
    try {
      const response = await this.request.post(`accounts/transfer`, data);

      return successHandler(response);
    } catch (error) {
      return errorHandler(error);
    }
  }

  /**
   * Delete an unpaid transaction.
   *
   * @param {DeleteUnpaidTransactionDto} data - The data for deleting an unpaid transaction.
   * @returns {Promise<any>} A Promise that resolves to the response data or rejects with an error.
   */
  async deleteUnpaidTransaction(
    data: DeleteUnpaidTransactionDto,
  ): Promise<any> {
    try {
      let url = `accounts/delete-unpaid-transaction?chiRef=${data.chiRef}`;
      if (data.subAccount) {
        url = url + `&subAccount=${data.subAccount}`;
      }
      const response = await this.request.delete(url);

      return successHandler(response);
    } catch (error) {
      return errorHandler(error);
    }
  }
}
