const axios = require("axios");
const { updateBalance } = require("./updateBalance");
const { updateUserBalance } = require("../saver");
const fs = require("fs").promises;
require('dotenv').config({ path: '../.env' });


async function sendFund(accChiUid, amount, receiverChiUid, platform, recId, mainId) {
    const CHIMONEY_BASE_URL = process.env.CHIMONEY_BASE_URL;

    const url = `${CHIMONEY_BASE_URL}/multicurrency-wallets/transfer`;

    const payload = {
        "sender": accChiUid,
        "amountToSend": amount,
        "originCurrency": "USD",
        "destinationCurrency": "USD",
        "receiver": receiverChiUid
    }

    // console.log(payload);

    try {
        const walResponse = await axios.post(url, payload, {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-API-KEY": process.env.API_KEY,
            },
        });



        var walResData = walResponse.data.data.data;

        var id = walResData[1].id;
        var receiver = walResData[1].receiver;
        var issueID = walResData[1].issueID;
        //var amount = walResData[1].valueInUSD;


        const transactionData = {
            id,
            amount: amount,
            userId: recId,
            accChiId: receiverChiUid,
            chiIdOther: accChiUid,
            issueID,
            platform: platform,
            status: false,
            type: "sending",
            idTwo: mainId
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

        return;
    } catch (error) {
        console.error("Error occurred:", error.response ? error.response.data : error.message);
        throw error;
    }

}

module.exports = {
    sendFund,
};
