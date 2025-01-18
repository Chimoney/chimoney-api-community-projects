const axios = require("axios");
const { platform } = require("os");
const fs = require("fs").promises;
require('dotenv').config({ path: '../.env' });


async function fundWallet(accChiUid, amount, firstName, userId, platform) {
    const CHIMONEY_BASE_URL = process.env.CHIMONEY_BASE_URL;
    const CHIMONEY_REDIRECT_URL = process.env.CHIMONEY_REDIRECT_URL;
    const CHIMONEY_PAYMENT_EMAIL = process.env.CHIMONEY_PAYMENT_EMAIL;

    const url = `${CHIMONEY_BASE_URL}/payment/initiate`;

    const payload = {
        valueInUSD: amount,
        payerEmail: CHIMONEY_PAYMENT_EMAIL,
        redirect_url: CHIMONEY_REDIRECT_URL,
        walletID: accChiUid,
        narration: `Deposit of ${amount} by ${firstName}`,
        subAccount: accChiUid,
    };


    try {
        const walResponse = await axios.post(url, payload, {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-API-KEY": process.env.API_KEY,
            },
        });


        const { id, valueInUSD, redeemData, issueID } = walResponse.data.data;

        const transactionData = {
            id,
            amount: valueInUSD,
            userId,
            accChiId: accChiUid,
            issueID,
            platform: platform,
            status: false
        };

        let existingData = [];
        try {
            const data = await fs.readFile("transaction.json");
            existingData = JSON.parse(data);
        } catch (error) {
            console.log("No existing transaction data found, starting fresh.");
        }

        existingData.push(transactionData);
        await fs.writeFile("transaction.json", JSON.stringify(existingData, null, 2));

        return walResponse.data;
    } catch (error) {
        console.error("Error occurred:", error.response ? error.response.data : error.message);
        throw error;
    }
}

module.exports = {
    fundWallet,
};
