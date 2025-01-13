import { Component, Input } from '@angular/core';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'chimoney-bank',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './bank.component.html',
  styleUrl: './bank.component.css'
})
export class BankComponent {
  // public response : any [] =[]

  @Input() subAccount: string = '';
  @Input() turnOffNotification: boolean = false;
  @Input() bankPayload: any = {
    countryToSend: '',
    account_bank: '',
    account_number: '',
    valueInUSD: '',
    narration: '',
    collectionPaymentIssueID: ''
  };

  payoutBank() {
    // chimoney.postV02PayoutsBank({
    //   subAccount: this.subAccount,
    //   turnOffNotification: this.turnOffNotification,
    //   banks: [this.bankPayload]
    // })
    // .then(({ response }) => console.log('Bank payout successful:', response))
    // .catch(err => console.error('Error:', err));
  }
}
