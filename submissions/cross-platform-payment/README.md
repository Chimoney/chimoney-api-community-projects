## Cross-Platform Chimoney Wallet

Supports Telegram and Discord, allowing users to seamlessly send and receive funds across these platforms using the Chimoney API. Based on #394

## Configuration

Before running the bot, ensure you have properly configured the following environment variables in your `.env` file.

### Required Environment Variables:

- **BOT_TOKEN**: Your telegram bot token from @BotFather.
- **TOC_URL**: URL to the Terms of Service page.
- **API_KEY**: API key from Chimoney.
- **CHIMONEY_BASE_URL**: The base URL for Chimoney API endpoints.
- **CHIMONEY_REDIRECT_URL**: Redirect URL after the Chimoney payment process.
- **CHIMONEY_PAYMENT_EMAIL**: Email used for Chimoney payment gateway.
- **CHIMONEY_TEAMID**: Your Chimoney team ID.

### Bot Tokens:

- **TELE_BOT_TOKEN**: Token for Telegram bot to authenticate with the Telegram Bot API.
- **DISCORD_BOT_TOKEN**: Token for Discord bot to authenticate with Discord API.

## Installation

1. Clone the repository:
2. Navigate to the project directory:
3. Install the required dependencies:
   ```bash
   npm install
   ```

4. Create a `.env` file in the root directory and add the required environment variables:
   ```bash
   BOT_TOKEN=<your-bot-token>
   TOC_URL=<your-toc-url>
   API_KEY=<your-api-key>
   CHIMONEY_BASE_URL=<your-chimoney-base-url>
   CHIMONEY_REDIRECT_URL=<your-chimoney-redirect-url>
   CHIMONEY_PAYMENT_EMAIL=<your-chimoney-email>
   CHIMONEY_TEAMID=<your-chimoney-team-id>
   TELE_BOT_TOKEN=<your-telegram-bot-token>
   DISCORD_BOT_TOKEN=<your-discord-bot-token>
   ```

## Usage

To start the bot, run the following command:
```bash
node discord
node telegram
```

## By Ayomide Amos
