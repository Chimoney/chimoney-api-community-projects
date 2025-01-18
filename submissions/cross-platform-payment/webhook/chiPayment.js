const express = require('express');
const fs = require("fs");
const { depositFund } = require('../chimoney/depositFund');
const { updateUserBalance } = require('../saver');
const { updateBalance } = require('../chimoney/updateBalance');
const app = express();
const PORT = 3000;

app.use(express.json());

async function chiPayment() {

  app.post('/paymentCompleted', async (req, res) => {
    console.log('Received webhook:', req.body);
    res.status(200).send('Webhook received');

    var hookRes = req.body;

    //    if (hookRes.eventType === "chimoney.payment.completed" || hookRes.eventType === "charge.card.completed") {
    if (hookRes.eventType === "charge.card.completed") {

      var issueID = hookRes.issueID;
      const data = fs.readFileSync('transaction.json', 'utf8');
      const transactions = JSON.parse(data);

      const transaction = transactions.find(tx => tx.issueID === issueID);

      if (transaction) {
        var amount = transaction.amount;
        var accChiUid = transaction.accChiId;
        var userId = transaction.userId;
        var platform = transaction.platform;




        var msg = `$${amount} have been deposited to your account`;
        console.log(msg);
        var bal = await updateBalance(accChiUid);
        await updateUserBalance(userId, bal);

        console.log("Back here");
        return [userId, msg, platform];

      } else {
        console.log("No transaction found with this issueID");
      }
    }
    else if (hookRes.eventType === "payout.wallet.completed") {
      var issueID = hookRes.issueID;
      const data = fs.readFileSync('transaction.json', 'utf8');
      const transactions = JSON.parse(data);

      const transaction = transactions.find(tx => tx.issueID === issueID);

      if (transaction) {
        var amount = transaction.amount;
        var accChiUid = transaction.accChiId;
        var userId = transaction.userId;
        var platform = transaction.platform;

        await depositFund(accChiUid, amount);


        var msg = `$${amount} have been credit to your account`;
        var bal = await updateBalance(accChiUid);

        return [userId, msg, platform];

      } else {
        console.log("No transaction found with this issueID");
      }
    }


  });

  app.listen(PORT, () => {
    console.log(`Webhook server running on http://localhost:${PORT}`);
  });

}


module.exports = {
  chiPayment,
};