require('dotenv').config();
const { Telegraf, Markup } = require('telegraf');
const { setUserPendingAction, updateUserBalance } = require('./saver');
const { newMessage, getUserData } = require('./main');
const { message } = require('telegraf/filters');

const express = require('express');
const fs = require("fs");

//const { updateBalance } = require('/chimoney/updateBalance.js');
const { depositFund } = require('./chimoney/depositFund');
const { updateBalance } = require('./chimoney/updateBalance');
const app = express();
const PORT = 3001;

const bot = new Telegraf(process.env.BOT_TOKEN);
console.log("Logged in to telegram bot!")
bot.start((ctx) => ctx.reply('Welcome'));

bot.on(message('text'), async (ctx) => {
    const msg = ctx.message;
    const chatId = msg.chat.id;
    const user = getUserData(chatId);


    if (user && user.pendingAction) {

        const data = fs.readFileSync('pendingAction.json', 'utf8');

        const actionList = JSON.parse(data);
        //console.log(user.pendingAction)

        const userNameAction = actionList.find(item => item.name === user.pendingAction);

        if (userNameAction) {
            var new_type = userNameAction.action;


            const response = await newMessage({
                type: new_type,
                chat_id: chatId,
                msgText: msg.text,
                datetime: new Date(),
                msgId: msg.message_id,
                msgFromId: msg.from.id,
                msgFromFirstName: msg.from.first_name || '',
                msgFromLastName: msg.from.last_name || '',
                msgFromUsername: msg.from.username || '',
                msgType: msg.chat.type,
                canSendImage: "true",
                canSendText: "true",
                canSendButton: "true",
                platformType: "Telegram",
            });

            if (response && response.message) {
                if (response && response.sendButton) {
                    sendMsgButton(ctx, response);
                }

                else if (response && response.message) {
                    ctx.reply(response.message);
                }
            }

        } else {
            console.log('Action not found.');
            ctx.reply("An error occured pls try again later");

        }

    }
    else {

        const messageData = {
            body: msg.text,
            type: 'message',
            datetime: new Date(),
            chat_id: msg.chat.id,
            msgId: msg.message_id,
            msgFromId: msg.from.id,
            msgFromFirstName: msg.from.first_name || '',
            msgFromLastName: msg.from.last_name || '',
            msgFromUsername: msg.from.username || '',
            msgType: msg.chat.type,
            msgText: msg.text,
            canSendImage: "true",
            canSendText: "true",
            canSendButton: "true",
            platformType: "Telegram",
        };


        const response = await newMessage(messageData);

        if (response && response.sendButton) {
            sendMsgButton(ctx, response);
        }

        else if (response && response.message) {
            ctx.reply(response.message);
        }

    }
});







bot.action('accept_tos', async (ctx) => {

    const messageData = {
        type: 'accept_toc',
        chat_id: ctx.chat.id,
        datetime: new Date(),
        msgId: ctx.chat.id || '',
        msgFromId: ctx.chat.id || '',
        msgFromFirstName: ctx.chat.first_name || '',
        msgFromLastName: ctx.chat.last_name || '',
        msgFromUsername: ctx.chat.username || '',
        msgType: ctx.chat.type || '',
        canSendImage: "true",
        canSendText: "true",
        canSendButton: "true",
        platformType: "Telegram",
    };

    const response = await newMessage(messageData);

    if (response && response.message) {
        if (response && response.sendButton) {
            sendMsgButton(ctx, response);
        }

        else if (response && response.message) {
            ctx.reply(response.message);
        }
    }

});

bot.action('fund_wallet', async (ctx) => {
    const messageData = {
        type: 'fund_wallet',
        chat_id: ctx.chat.id,
        datetime: new Date(),
        msgId: ctx.chat.id || '',
        msgFromId: ctx.chat.id || '',
        msgFromFirstName: ctx.chat.first_name || '',
        msgFromLastName: ctx.chat.last_name || '',
        msgFromUsername: ctx.chat.username || '',
        msgType: ctx.chat.type || '',
        canSendImage: "true",
        canSendText: "true",
        canSendButton: "true",
        platformType: "Telegram",
    };

    const response = await newMessage(messageData);
    if (response && response.message) {
        if (response && response.sendButton) {
            sendMsgButton(ctx, response);
        }

        else if (response && response.message) {
            ctx.reply(response.message);
        }
    }
});


bot.action('pull_fund', async (ctx) => {
    const messageData = {
        type: 'pull_fund',
        chat_id: ctx.chat.id,
        datetime: new Date(),
        msgId: ctx.chat.id || '',
        msgFromId: ctx.chat.id || '',
        msgFromFirstName: ctx.chat.first_name || '',
        msgFromLastName: ctx.chat.last_name || '',
        msgFromUsername: ctx.chat.username || '',
        msgType: ctx.chat.type || '',
        canSendImage: "true",
        canSendText: "true",
        canSendButton: "true",
        platformType: "Telegram",
    };

    
    const response = await newMessage(messageData);
    if (response && response.message) {
        if (response && response.sendButton) {
            sendMsgButton(ctx, response);
        }

        else if (response && response.message) {
            ctx.reply(response.message);
        }
    }
});

bot.action('send_fund', async (ctx) => {
    const messageData = {
        type: 'send_fund',
        chat_id: ctx.chat.id,
        datetime: new Date(),
        msgId: ctx.chat.id || '',
        msgFromId: ctx.chat.id || '',
        msgFromFirstName: ctx.chat.first_name || '',
        msgFromLastName: ctx.chat.last_name || '',
        msgFromUsername: ctx.chat.username || '',
        msgType: ctx.chat.type || '',
        canSendImage: "true",
        canSendText: "true",
        canSendButton: "true",
        platformType: "Telegram",
    };


    const response = await newMessage(messageData);
    if (response && response.message) {
        if (response && response.sendButton) {
            sendMsgButton(ctx, response);
        }

        else if (response && response.message) {
            ctx.reply(response.message);
        }
    }
});


bot.action('buy_airtime', async (ctx) => {
    const messageData = {
        type: 'buy_airtime',
        chat_id: ctx.chat.id,
        datetime: new Date(),
        msgId: ctx.chat.id || '',
        msgFromId: ctx.chat.id || '',
        msgFromFirstName: ctx.chat.first_name || '',
        msgFromLastName: ctx.chat.last_name || '',
        msgFromUsername: ctx.chat.username || '',
        msgType: ctx.chat.type || '',
        canSendImage: "true",
        canSendText: "true",
        canSendButton: "true",
        platformType: "Telegram",
    };

    const response = await newMessage(messageData);
    if (response && response.message) {
        if (response && response.sendButton) {
            sendMsgButton(ctx, response);
        }

        else if (response && response.message) {
            ctx.reply(response.message);
        }
    }
});


function sendMsgButton(ctx, response) {
    const buttons = response.buttons.map((btn) => {
        if (btn.type === 'url') {
            return Markup.button.url(btn.caption, btn.body);
        } else if (btn.type === 'callback') {
            return Markup.button.callback(btn.caption, btn.action_name);
        }
        return null;
    }).filter(Boolean); // Filter out any null values
    
    const groupedButtons = [];
    for (let i = 0; i < buttons.length; i += 2) {
        groupedButtons.push(buttons.slice(i, i + 2)); // Group buttons into sub-arrays of 2
    }
    
    ctx.reply(
        response.title,
        Markup.inlineKeyboard(groupedButtons)
    );
    
}

app.use(express.json());

async function chiPayment() {

    app.post('/paymentCompleted', async (req, res) => {
        console.log('Received webhook:', req.body);
        res.status(200).send('Webhook received');

        var hookRes = req.body;

        //    if (hookRes.eventType === "chimoney.payment.completed" || hookRes.eventType === "charge.card.completed") {


        //if (hookRes.eventType === "chimoney.payment.completed") {
        if (hookRes.eventType === "payout.wallet.completed") {

            var issueID = hookRes.issueID;
            const data = fs.readFileSync('transaction.json', 'utf8');
            const transactions = JSON.parse(data);

            const transaction = transactions.find(tx => tx.issueID === issueID);
            if (transaction && (transaction.platform === "Telegram")) {
                if (transaction && (transaction.status == false) && (transaction.type != "sending") && (transaction.type != "airtime")) {
                    var amount = transaction.amount;
                    var accChiUid = transaction.accChiId;
                    var userId = transaction.userId;
                    var platform = transaction.platform;

                    console.log("Not Sending")
                    await depositFund(accChiUid, amount);

                    //transaction.status = true;
                    //await fs.writeFile("transaction.json", JSON.stringify(transactions, null, 2));
                    var msg = `$${amount} have been deposited to your account`;
                    console.log(msg);
                    console.log("In not sending")
                    var bal = await updateBalance(accChiUid);
                    await updateUserBalance(userId, bal);

                    console.log("Back here");

                    await sendClient.sendMessage(userId, msg);



                }
                else if (transaction && (transaction.type === "sending")) {
                    console.log("Its sending");
                    console.log("Update one");

                    var bal1 = await updateBalance(transaction.accChiId);
                    var bal2 = await updateBalance(transaction.chiIdOther);


                    console.log(bal1);
                    console.log(bal2);
                    await updateUserBalance(transaction.userId, bal1);
                    await updateUserBalance(transaction.idTwo, bal2);


                    var userId = transaction.userId;
                    var msg = `$${transaction.amount} have been deposited to your account`;
                    await sendClient.sendMessage(userId, msg);

                }
                else if (transaction && (transaction.type === "airtime")) {
                    console.log("Its airtime");

                    var bal1 = await updateBalance(transaction.accChiId);
                    console.log(bal1);
                    await updateUserBalance(transaction.userId, bal1);

                    var userId = transaction.userId;
                    var msg = `Sent $${transaction.amount} to the phone number.`;
                    await sendClient.sendMessage(userId, msg);

                }
                else if (transaction && (transaction.type === "pull")) {
                    console.log("Its pull");

                    var bal1 = await updateBalance(transaction.accChiId);
                    console.log(bal1);
                    await updateUserBalance(transaction.userId, bal1);

                    var userId = transaction.userId;
                    var msg = `Withdraw $${transaction.amount} using this link ${transaction.extra}.`;
                    await sendClient.sendMessage(userId, msg);

                } else {
                    console.log("No transaction found with this issueID");
                }
            }
        }
        /*
        if (hookRes.eventType === "payout.wallet.completed") {
            var issueID = hookRes.issueID;
            const data = fs.readFileSync('transaction.json', 'utf8');
            const transactions = JSON.parse(data);

            const transaction = transactions.find(tx => tx.issueID === issueID);

            if (transaction && (transaction.status == false)) {
                var amount = transaction.amount;
                var accChiUid = transaction.accChiId;
                var userId = transaction.userId;
                var platform = transaction.platform;
                transaction.status = true;
                await fs.writeFile("transaction.json", JSON.stringify(transactions, null, 2));
                await depositFund(accChiUid, amount);


                var msg = `$${amount} have been credit to your account`;
                var bal = await updateBalance(accChiUid);

                if (platform === "Telegram") {
                    await sendClient.sendMessage(userId, msg);
                }

            } else {
                console.log("No transaction found with this issueID");
            }
        }

*/
    });

    app.listen(PORT, () => {
        console.log(`Webhook server running on http://localhost:${PORT}`);
    });

}
var sendClient = bot.telegram;
chiPayment(sendClient);
bot.launch();