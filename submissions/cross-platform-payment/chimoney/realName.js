const axios = require("axios");
require('dotenv').config({ path: '../.env' });


async function realName(accChiId, firstName, lastName) {
    const CHIMONEY_BASE_URL = process.env.CHIMONEY_BASE_URL;

    const url = `${CHIMONEY_BASE_URL}/multicurrency-wallets/update`;
    const payload = {
        "meta": { "newKey": "New Value" },  //I don't know what this is, but it's required
        "id": accChiId,
        "firstName": firstName,
        "lastName": lastName
    }
    console.log(payload)

    const walResponse = await axios.post(url, payload, {
        headers: {
            "Accept": "application/json",
            "Content-Type": "application/json",
            "X-API-KEY": process.env.API_KEY
        }
    });
    console.log(walResponse.data);
    return walResponse.data;
}

module.exports = {
    realName
};
