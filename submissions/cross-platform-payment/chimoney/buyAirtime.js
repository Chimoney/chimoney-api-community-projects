const axios = require("axios");
const { updateBalance } = require("./updateBalance");
const { updateUserBalance } = require("../saver");
const fs = require("fs").promises;
require('dotenv').config({ path: '../.env' });

async function buyAirtime(phoneNumber, amount, accChiId, userId, platform) {
    const CHIMONEY_BASE_URL = process.env.CHIMONEY_BASE_URL;

    const airtime_url = `${CHIMONEY_BASE_URL}/payouts/airtime`;

    const AIRTIME_payload = {
        "airtimes": [
            {

                "countryToSend": "Nigeria",
                "phoneNumber": phoneNumber,
                "valueInUSD": amount,
                "narration": "Airtime"
            }
        ],
        "subAccount": accChiId
    }

    console.log(AIRTIME_payload)

    const airResponse = await axios.post(airtime_url, AIRTIME_payload, {
        headers: {
            Accept: "application/json",
            "Content-Type": "application/json",
            "X-API-KEY": process.env.API_KEY,
        },
    });




    var walResData = airResponse.data.data.data;
    console.log(walResData)

    var id = walResData[0].id;
    var receiver = walResData[0].receiver;
    var issueID = walResData[0].issueID;



    const transactionData = {
        id,
        amount: amount,
        userId: userId,
        accChiId: accChiId,
        chiIdOther: accChiId,
        issueID: issueID,
        platform: platform,
        status: false,
        type: "airtime",
        idTwo: ""
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

    var bal1 = await updateBalance(accChiId);
    console.log(bal1);
    await updateUserBalance(userId, bal1);

    return;


}

module.exports = {
    buyAirtime
}