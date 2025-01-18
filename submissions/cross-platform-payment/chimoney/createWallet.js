const axios = require("axios");
require('dotenv').config({ path: '../.env' });


async function createWallet(user_id) {
    const CHIMONEY_BASE_URL = process.env.CHIMONEY_BASE_URL;

    const url = `${CHIMONEY_BASE_URL}/multicurrency-wallets/create`;
    const payload = { name: user_id };

    const walResponse = await axios.post(url, payload, {
        headers: {
            "Accept": "application/json",
            "Content-Type": "application/json",
            "X-API-KEY": process.env.API_KEY
        }
    });

    return walResponse.data;
}

module.exports = {
    createWallet
};
