import { Component, Input } from '@angular/core';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'chimoney-payouts',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './payouts.component.html',
  styleUrl: './payouts.component.css'
})
export class PayoutsComponent {

  @Input() subAccount: string = '';
  @Input() turnOffNotification: boolean = false;
  @Input() chimoneyPayload: any = {
    email: '',
    phone: '',
    valueInUSD: '',
    narration: '',
    collectionPaymentIssueID: ''
  };

  payoutChimoney() {
    // chimoney.postV02PayoutsChimoney({
    //   subAccount: this.subAccount,
    //   turnOffNotification: this.turnOffNotification,
    //   chimoneys: [this.chimoneyPayload]
    // })
    // .then(({ data }) => console.log('Chimoney payout successful:', data))
    // .catch(err => console.error('Error:', err));
  }

}
