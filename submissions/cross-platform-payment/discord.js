require('dotenv').config();
const { Client, GatewayIntentBits, Partials, ActionRowBuilder, ButtonBuilder, ButtonStyle } = require('discord.js');
const express = require('express');
const fs = require("fs");
const { setUserPendingAction, updateUserBalance } = require('./saver');
const { newMessage, getUserData } = require('./main');
const { depositFund } = require('./chimoney/depositFund');
const { updateBalance } = require('./chimoney/updateBalance');

const app = express();
const PORT = 3000;

const client = new Client({
    intents: [
        GatewayIntentBits.GuildMessages,
        GatewayIntentBits.DirectMessages,
        GatewayIntentBits.MessageContent
    ],
    partials: [Partials.Channel, Partials.Message]
});

console.log("Logged in to Discord bot!");

client.once('ready', () => {
    console.log(`Bot logged in as ${client.user.tag}!`);
});

client.on('messageCreate', async (message) => {
    if (message.author.bot) return;

    const chatId = message.author.id;
    const user = getUserData(chatId);

    if (user && user.pendingAction) {
        const data = fs.readFileSync('pendingAction.json', 'utf8');
        const actionList = JSON.parse(data);

        const userNameAction = actionList.find(item => item.name === user.pendingAction);

        if (userNameAction) {
            const new_type = userNameAction.action;

            const response = await newMessage({
                type: new_type,
                chat_id: chatId,
                msgText: message.content,
                datetime: new Date(),
                msgId: message.id,
                msgFromId: message.author.id,
                msgFromFirstName: message.author.username || '',
                msgFromLastName: message.author.discriminator || '',
                msgType: message.channel.type,
                canSendImage: "true",
                canSendText: "true",
                canSendButton: "true",
                platformType: "Discord",
            });

            if (response && response.message) {
                if (response.sendButton) {
                    sendMsgButton(message.channel, response);
                } else {
                    message.channel.send(response.message);
                }
            }

        } else {
            console.log('Action not found.');
            message.channel.send("An error occurred, please try again later.");
        }
    } else {
        const messageData = {
            body: message.content,
            type: 'message',
            datetime: new Date(),
            chat_id: chatId,
            msgId: message.id,
            msgFromId: message.author.id,
            msgFromFirstName: message.author.username || '',
            msgFromLastName: message.author.discriminator || '',
            msgType: message.channel.type,
            msgText: message.content,
            canSendImage: "true",
            canSendText: "true",
            canSendButton: "true",
            platformType: "Discord",
        };

        const response = await newMessage(messageData);

        if (response && response.sendButton) {
            sendMsgButton(message.channel, response);
        } else if (response && response.message) {
            message.channel.send(response.message);
        }
    }
});

client.on('interactionCreate', async (interaction) => {
    if (!interaction.isButton()) return;

    const actionMap = {
        'accept_tos': 'accept_toc',
        'fund_wallet': 'fund_wallet',
        'pull_fund': 'pull_fund',
        'send_fund': 'send_fund',
        'buy_airtime': 'buy_airtime',
    };

    const actionType = actionMap[interaction.customId];

    if (!actionType) return;

    const messageData = {
        type: actionType,
        chat_id: interaction.author.id,
        datetime: new Date(),
        msgId: interaction.id,
        msgFromId: interaction.user.id,
        msgFromFirstName: interaction.user.username || '',
        msgFromLastName: interaction.user.discriminator || '',
        msgFromUsername: interaction.user.username || '',
        msgType: interaction.channel.type,
        canSendImage: "true",
        canSendText: "true",
        canSendButton: "true",
        platformType: "Discord",
    };

    const response = await newMessage(messageData);

    if (response && response.message) {
        if (response.sendButton) {
            sendMsgButton(interaction.channel, response);
        } else {
            await interaction.reply(response.message);
        }
    }
});

function sendMsgButton(channel, response) {
    const buttons = response.buttons.map((btn) => {
        if (btn.type === 'url') {
            return new ButtonBuilder()
                .setLabel(btn.caption)
                .setStyle(ButtonStyle.Link)
                .setURL(btn.body);
        } else if (btn.type === 'callback') {
            return new ButtonBuilder()
                .setLabel(btn.caption)
                .setStyle(ButtonStyle.Primary)
                .setCustomId(btn.action_name);
        }
        return null;
    }).filter(Boolean);

    const row = new ActionRowBuilder().addComponents(buttons);

    channel.send({
        content: response.title,
        components: [row]
    });
}

app.use(express.json());

app.post('/paymentCompleted', async (req, res) => {
    console.log('Received webhook:', req.body);
    res.status(200).send('Webhook received');

    const hookRes = req.body;

    if (hookRes.eventType === "payout.wallet.completed") {
        const issueID = hookRes.issueID;
        const data = fs.readFileSync('transaction.json', 'utf8');
        const transactions = JSON.parse(data);

        const transaction = transactions.find(tx => tx.issueID === issueID);
        if (transaction && (transaction.platform === "Discord")) {
            if (transaction && !transaction.status) {
                const { amount, accChiId, userId, type } = transaction;

                if (type !== "sending" && type !== "airtime") {
                    await depositFund(accChiId, amount);
                    const bal = await updateBalance(accChiId);
                    await updateUserBalance(userId, bal);

                    client.users.fetch(userId).then(user => {
                        user.send("hello!")
                    })
                    client.users.send(userId, `$${amount} has been deposited to your account.`);
                    
                } else if (type === "sending") {
                    const bal1 = await updateBalance(transaction.accChiId);
                    const bal2 = await updateBalance(transaction.chiIdOther);
                    await updateUserBalance(transaction.userId, bal1);
                    await updateUserBalance(transaction.idTwo, bal2);
                    client.users.send(transaction.userId, `$${transaction.amount} has been deposited to your account.`);
                } else if (type === "airtime") {
                    const bal1 = await updateBalance(transaction.accChiId);
                    await updateUserBalance(transaction.userId, bal1);
                    client.users.send(transaction.userId, `Sent $${transaction.amount} to the phone number.`);
                } else if (type === "pull") {
                    const bal1 = await updateBalance(transaction.accChiId);
                    await updateUserBalance(transaction.userId, bal1);
                    client.users.send(transaction.userId, `Withdraw $${transaction.amount} using this link ${transaction.extra}.`);
                }
            } else {
                console.log("No transaction found with this issueID");
            }
        }
    }
});

app.listen(PORT, () => {
    console.log(`Webhook server running on http://localhost:${PORT}`);
});

client.login(process.env.DISCORD_BOT_TOKEN);
