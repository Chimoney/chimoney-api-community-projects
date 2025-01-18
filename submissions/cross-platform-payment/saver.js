const fs = require('fs');
const filePath = './users.json';
const { realName } = require("./chimoney/realName")
const ensureFileExists = () => {
  if (!fs.existsSync(filePath)) {
    fs.writeFileSync(filePath, JSON.stringify({}, null, 2));
  }
};

const isUserNew = (chatId) => {
  ensureFileExists();
  const users = JSON.parse(fs.readFileSync(filePath, 'utf8'));
  return !users[chatId];
};

const getUserInfo = (chatId) => {
  try {
    ensureFileExists();
    const users = JSON.parse(fs.readFileSync(filePath, 'utf8'));
    if (users[chatId]) {
      const { accChiUid: accChiId, first_name } = users[chatId];
      return { accChiId, first_name };
    }
    return {};
  } catch (error) {
    console.error('Error accessing user info:', error);
    return {};
  }
};


const saveNewUser = (user) => {
  ensureFileExists();
  const users = JSON.parse(fs.readFileSync(filePath, 'utf8'));
  users[user.chat_id] = user;
  var gg = fs.writeFileSync(filePath, JSON.stringify(users, null, 2));

};

const checkUserAcceptance = (chatId) => {
  ensureFileExists();
  const users = JSON.parse(fs.readFileSync(filePath, 'utf8'));
  return users[chatId] && users[chatId].accepted_toc;
};


const updateUserAcceptance = (chatId, accepted) => {
  ensureFileExists();
  const users = JSON.parse(fs.readFileSync(filePath, 'utf8'));
  if (users[chatId]) {
    users[chatId].accepted_toc = accepted;
    fs.writeFileSync(filePath, JSON.stringify(users, null, 2));
  }
};


const updateUserBalance = (chatId, amount) => {
  ensureFileExists();
  const users = JSON.parse(fs.readFileSync(filePath, 'utf8'));
  if (users[chatId]) {
    users[chatId].balance = amount;
    fs.writeFileSync(filePath, JSON.stringify(users, null, 2));
  }
};


const updateUserName = async (chatId, uName) => {
  var [firstName, lastName] = splitName(uName);


  ensureFileExists();
  var users = JSON.parse(fs.readFileSync(filePath, 'utf8'));
  if (users[chatId]) {

    var accChiUid = users[chatId].accChiUid;
    await realName(accChiUid, firstName, lastName);

    users[chatId].first_name = firstName;
    users[chatId].last_name = lastName;
    fs.writeFileSync(filePath, JSON.stringify(users, null, 2));
  }
};

const setUserPendingAction = (chatId, action) => {
  const users = JSON.parse(fs.readFileSync(filePath, 'utf8'));
  if (users[chatId]) {
    users[chatId].pendingAction = action;
    fs.writeFileSync(filePath, JSON.stringify(users, null, 2));
  }
};


function capitalize(word) {
  return word.charAt(0).toUpperCase() + word.slice(1).toLowerCase();
}

function splitName(uName) {
  const nameParts = uName.trim().split(/\s+/);
  if (nameParts.length < 2) {
    return null;
  }
  const firstName = capitalize(nameParts[0]);
  const lastName = nameParts.slice(1).map(capitalize).join(" ");
  return [firstName, lastName];
}

const getUserDataByAccountId = (accountId) => {
  const users = JSON.parse(fs.readFileSync('users.json', 'utf8'));
  return Object.values(users).find(user => user.accNo === accountId);
};

const savePendingRecipient = (chatId, recipient) => {
  let data = fs.readFileSync('pendingRecipient.json', 'utf8');
  let pendingRecipients = JSON.parse(data);
  pendingRecipients = pendingRecipients.filter(item => item.chatId !== chatId);

  pendingRecipients.push({
    chatId: chatId,
    recipient: recipient
  });

  fs.writeFileSync('pendingRecipient.json', JSON.stringify(pendingRecipients, null, 2));
};

const savePendingPhone = (chatId, recipient) => {
  let data = fs.readFileSync('pendingAirtime.json', 'utf8');
  let pendingRecipients = JSON.parse(data);
  pendingRecipients = pendingRecipients.filter(item => item.chatId !== chatId);

  pendingRecipients.push({
    chatId: chatId,
    phoneNo: recipient
  });

  fs.writeFileSync('pendingAirtime.json', JSON.stringify(pendingRecipients, null, 2));
};


const getPendingRecipient = (chatId) => {
  const data = fs.readFileSync('pendingRecipient.json', 'utf8');
  const pendingRecipients = JSON.parse(data);

  const recipient = pendingRecipients.find(item => item.chatId === chatId);

  return recipient || null;
};


const getPendingAirtime = (chatId) => {
  const data = fs.readFileSync('pendingAirtime.json', 'utf8');
  const pendingRecipients = JSON.parse(data);

  const recipient = pendingRecipients.find(item => item.chatId === chatId);

  return recipient || null;
};


const deletePendingRecipient = async (chatId) => {
  let data = fs.readFileSync('pendingRecipient.json', 'utf8');
  let pendingRecipients = JSON.parse(data);

  pendingRecipients = pendingRecipients.filter(item => item.chatId !== chatId);

  fs.writeFileSync('pendingRecipient.json', JSON.stringify(pendingRecipients, null, 2));
};

const deletePendingAirtime = async (chatId) => {
  let data = fs.readFileSync('pendingAirtime.json', 'utf8');
  let pendingRecipients = JSON.parse(data);

  pendingRecipients = pendingRecipients.filter(item => item.chatId !== chatId);

  fs.writeFileSync('pendingAirtime.json', JSON.stringify(pendingRecipients, null, 2));
};




module.exports = {
  savePendingPhone,deletePendingAirtime, getPendingRecipient,getPendingAirtime, getUserDataByAccountId, isUserNew, savePendingRecipient, deletePendingRecipient, saveNewUser, setUserPendingAction, checkUserAcceptance, updateUserBalance, getUserInfo, updateUserAcceptance, updateUserName
};