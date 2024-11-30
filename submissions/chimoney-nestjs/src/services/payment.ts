import { Inject, Injectable } from '@nestjs/common';
import { Axios } from 'axios';
import {
  InitiatePaymentDto,
  SimulatePaymentStatusDto,
  VerifyPaymentDto,
} from 'src/dto/payment';
import { errorHandler, successHandler } from 'src/utils/errorHandler';
import { AXIOS_INSTANCE } from '../constants';

/**
 * Service responsible for handling payment-related operations.
 */
@Injectable()
export class PaymentsService {
  /**
   * Creates an instance of PaymentsService.
   * @param {Axios} request - An Axios instance for making HTTP requests.
   */
  constructor(@Inject(AXIOS_INSTANCE) private readonly request: Axios) {}

  /**
   * Initiate a payment.
   *
   * @param {InitiatePaymentDto} data - The data for initiating the payment.
   * @returns {Promise<any>} A Promise that resolves to the response data or rejects with an error.
   */
  async initiatePayment(data: InitiatePaymentDto): Promise<any> {
    try {
      const response = await this.request.post('payment/initiate', data);
      return successHandler(response);
    } catch (error) {
      return errorHandler(error);
    }
  }

  /**
   * Verify a payment.
   *
   * @param {VerifyPaymentDto} data - The data for verifying the payment.
   * @returns {Promise<any>} A Promise that resolves to the response data or rejects with an error.
   */
  async verifyPayment(data: VerifyPaymentDto): Promise<any> {
    try {
      const response = await this.request.post('payment/verify', data);
      return successHandler(response);
    } catch (error) {
      return errorHandler(error);
    }
  }

  /**
   * Simulate changes in payment status.
   *
   * @param {SimulatePaymentStatusDto} data - The data for simulating payment status changes.
   * @returns {Promise<any>} A Promise that resolves to the response data or rejects with an error.
   */
  async simulateStatusChanges(data: SimulatePaymentStatusDto): Promise<any> {
    try {
      const response = await this.request.post('payment/verify', data);
      return successHandler(response);
    } catch (error) {
      return errorHandler(error);
    }
  }
}
