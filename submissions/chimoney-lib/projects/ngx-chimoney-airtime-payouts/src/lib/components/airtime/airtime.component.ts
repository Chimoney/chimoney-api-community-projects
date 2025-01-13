import { Component, Input } from '@angular/core';
import { FormsModule } from '@angular/forms';

@Component({
  selector: 'chimoney-airtime',
  standalone: true,
  imports: [FormsModule],
  templateUrl: './airtime.component.html',
  styleUrl: './airtime.component.css'
})
export class AirtimeComponent {

  @Input() subAccount: string = '';
  @Input() turnOffNotification: boolean = false;
  @Input() airtimePayload: any = {
    countryToSend: '',
    phoneNumber: '',
    valueInUSD: '',
    narration: '',
    collectionPaymentsIssueID: ''
  };

  payoutAirtime() {}
  // payoutAirtime() {
  //   chimoney.postV02PayoutsAirtime({
  //     subAccount: this.subAccount,
  //     turnOffNotification: this.turnOffNotification,
  //     airtimes: [this.airtimePayload]
  //   })

  //   .then(({ data }) => console.log('Airtime payout successful:', data))
  //   .catch(err => console.error('Error', err));
  // }
}
