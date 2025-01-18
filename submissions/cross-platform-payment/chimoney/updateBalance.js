const axios = require("axios");
const fs = require("fs").promises;
require('dotenv').config({ path: '../.env' });

async function updateBalance(accChiUid) {
    const CHIMONEY_BASE_URL = process.env.CHIMONEY_BASE_URL;

    const url = `${CHIMONEY_BASE_URL}/multicurrency-wallets/get?id=${accChiUid}`;

    try {
        const walResponse = await axios.get(url, {
            headers: {
                Accept: "application/json",
                "Content-Type": "application/json",
                "X-API-KEY": process.env.API_KEY,
            },
        });

        const jsonData = walResponse.data;

        const chiWallet = jsonData.data.wallets.find(wallet => wallet.type === 'chi' && wallet.currency !== 'CAD');

        const chiBalance = chiWallet.balance;




        return chiBalance;
    } catch (error) {
        console.error("Error occurred:", error.response ? error.response.data : error.message);
        throw error;
    }
}

module.exports = {
    updateBalance,
};
