const axios = require("axios");
const { updateBalance } = require("./updateBalance");
const { updateUserBalance } = require("../saver");
const fs = require("fs").promises;
require('dotenv').config({ path: '../.env' });

async function pullFund(accChiId, amount, userId, platform) {
    const CHIMONEY_BASE_URL = process.env.CHIMONEY_BASE_URL;

    const url = `${CHIMONEY_BASE_URL}/payouts/chimoney`;

    const pull_payload = {
        "chimoneys": [
        {
            "email": process.env.CHIMONEY_PAYMENT_EMAIL,
            "valueInUSD": amount,
            "currency": "USD",
            "amount": amount
        }
    ],
    "subAccount": accChiId
    }

    const pullResponse = await axios.post(url, pull_payload, {
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            "X-API-KEY": process.env.API_KEY,
        },
    });


    var walResData = pullResponse.data.data.data;

    var id = walResData[0].id;
    var receiver = walResData[0].receiver;
    var issueID = walResData[0].issueID;
    var redeemLink = walResData[0].redeemLink;



    const transactionData = {
        id,
        amount: amount,
        userId: userId,
        accChiId: accChiId,
        chiIdOther: accChiId,
        issueID: issueID,
        platform: platform,
        status: false,
        type: "pull",
        idTwo: "",
        extra: redeemLink
    };

    // console.log(transactionData);

    let existingData = [];
    try {
        const data = await fs.readFile("transaction.json");
        existingData = JSON.parse(data);
    } catch (error) {
        console.log("No existing transaction data found, starting fresh.");
    }

    existingData.push(transactionData);

    await fs.writeFile("transaction.json", JSON.stringify(existingData, null, 2));

    var bal1 = await updateBalance(accChiId);
    console.log(bal1);
    await updateUserBalance(userId, bal1);

    return redeemLink;


}

module.exports = {
    pullFund
}