import os
from dotenv import load_dotenv

from chimoney import Chimoney


load_dotenv()

chimoney = Chimoney.set_api_key(os.getenv('CHIMONEY_API_KEY'))

chimoney.account.account_transfer()

chimoney.payouts.chimoney()

def dollar_to_naira(amount):
    return chimoney.info.usd_to_local('NGN', amount)

def wallet_details(wallet_id):
    return chimoney.wallet.detials(wallet_id)

def wallet_transfer(receiver_id: int, amount: float):
    chimoney.wallet.transfer(reciver_id=receiver_id, wallet_type='chi', amount=amount)