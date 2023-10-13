

# Chimoney Telegram Bot


The Environment variables (.env) file contains:

- `PORT`: Port on which the bot's HTTP server will run.
- `TOKEN`: Your Telegram Bot API token from BotFather.
- `BOT_URL`: Your telegram bot's URL.
- `API_KEY`: Your API key for Chimoney integration.
- `REDIRECT_URL`: Redirect URL for Chimoney transactions.
- `CHIMONEY_BASE_URL`: Base URL for Chimoney operations.
- `CHIMONEY_BASE_HOST`: Chimoney base host URL.
- `DEFAULT_EMAIL`: Default email to receive transactions updates (since telegram doesn't have emails).

## Installation

1. Clone the repo:

   ```shell
   git clone https://github.com/amosayomide05/chimoney-community-projects.git
   ```

2. Install the dependencies:

   ```shell
   cd chimoney-community-projects && cd chimoney-telegram-bot
   npm install
   ```

3. Edit the `.env` file and add the required environment variables.

4. Start the bot:

   ```shell
   node start
   ```

## Usage


### Sending Chimoney

In a group chat, use the below command to send Chimoney to a user:

```
/chimoney_pay @username amount
```

Replace `@username` with the recipient's Telegram username and `amount` with the desired amount of Chimoney.

### Receiving Chimoney

When you receive Chimoney, the bot will send recipient a mesage with a link to claim the Chimoney.
