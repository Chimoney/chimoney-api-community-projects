# CHIMONEY DISCORD BOT

## Getting Started

The chimoney discord bot allows you to reward users on a discord server or channel
by sending them funds.

### Setup

The following environment variables need to be set for the bot to run

```.env
BOT_TOKEN = "your bot token"
CLIENTID = "your client id"
CHIMONEY_API_KEY = "your chimoney api key"
CHIMONEY_BOT_EMAIL = "a placeholder email address for initiate payout request to chimoney api"
CHIMONEY_WEBHOOK_SIGNATURE = "webhook signature from the chimoney developer dashboard"
```

## Commands

### /send_chimoney

The /send_chimoney command sends X amount of funds to Y user
**Usage:**
/send_chimoney amount:1 to:@user

## Deployment

The Chimoney bot is currently hosted on a heroku server, however this poses some issues
as heroku's web processes timeout after a few minutes of inactivity. The bot cannot be deployed on a
heroku worker as it uses a http server to listen for webhook events.

You can invite the bot to your server via this [invite-link](https://discord.com/api/oauth2/authorize?client_id=1033109520114798653&permissions=414464859200&scope=bot)

## TODO

- [ ] Add /giveaway command
- [ ] Add /sendAll command
