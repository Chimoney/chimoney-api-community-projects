const axios = require("axios");
const fs = require("fs").promises;
require('dotenv').config({ path: '../.env' });


async function depositFund(accChiUid, amount) {
    const CHIMONEY_BASE_URL = process.env.CHIMONEY_BASE_URL;

    const url = `${CHIMONEY_BASE_URL}/multicurrency-wallets/transfer`;

    const payload = {
        amountToSend: amount,
        originCurrency: "USD",
        receiver: accChiUid,
        destinationCurrency: "USD"
    };
    

    try {
        await axios.post(url, payload, {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-API-KEY": process.env.API_KEY,
            },
        });

        return;
    } catch (error) {
        console.error("Error occurred:", error.response ? error.response.data : error.message);
    throw error; 
    }
}

module.exports = {
    depositFund,
};
