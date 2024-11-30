import { Inject, Injectable } from '@nestjs/common';
import { Config } from './config';
import { CONFIG_OPTIONS } from './constants';
import {
  AccountTransferDto,
  DeleteUnpaidTransactionDto,
  TransactionByIDDto,
  TransactionsByIssueIDDto,
} from './dto/account';
import {
  InitiatePaymentDto,
  SimulatePaymentStatusDto,
  VerifyPaymentDto,
} from './dto/payment';
import { WalletByIDDto, WalletTransferIDDto } from './dto/wallet';
import { AccountService } from './services/account';
import { PaymentsService } from './services/payment';
import { WalletsService } from './services/wallet';
@Injectable()
export class ChimoneyClientService {
  constructor(
    @Inject(CONFIG_OPTIONS) private readonly config: Config,
    private readonly transactionsServices: AccountService,
    private readonly paymentsService: PaymentsService,
    private readonly walletsService: WalletsService,
  ) {
    if (!this.config.apiKey) {
      throw new Error('Please provide api key');
    }
  }
  getTransactionsByIssueID(data: TransactionsByIssueIDDto): Promise<any> {
    return this.transactionsServices.getTransactionsByIssueID(data);
  }
  getAllTransactions(subAccount: string | null): Promise<any> {
    return this.transactionsServices.getAllTransactions(subAccount);
  }
  getTransactionByID(data: TransactionByIDDto): Promise<any> {
    return this.transactionsServices.getTransactionByID(data);
  }

  accountTransfer(data: AccountTransferDto): Promise<any> {
    return this.transactionsServices.accountTransfer(data);
  }
  deleteUnpaidTransaction(data: DeleteUnpaidTransactionDto): Promise<any> {
    return this.transactionsServices.deleteUnpaidTransaction(data);
  }

  simulateStatusChanges(data: SimulatePaymentStatusDto): Promise<any> {
    return this.paymentsService.simulateStatusChanges(data);
  }

  verifyPayment(data: VerifyPaymentDto): Promise<any> {
    return this.paymentsService.verifyPayment(data);
  }

  initiatePayment(data: InitiatePaymentDto): Promise<any> {
    return this.paymentsService.initiatePayment(data);
  }

  getWallets(subAccount: string | null): Promise<any> {
    return this.walletsService.getWallets(subAccount);
  }

  getWallet(data: WalletByIDDto): Promise<any> {
    return this.walletsService.getWallet(data);
  }

  transferWallet(data: WalletTransferIDDto): Promise<any> {
    return this.walletsService.transferWallet(data);
  }
}
