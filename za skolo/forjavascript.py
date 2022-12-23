from flask import Flask, jsonify, request
import threading
import time
import requests
import json


coins_list = []
run = True


def update_price_thread():

  global coins_list, run
  
  while run:

    print('\nUpdating Prices!')
    
    response = requests.get('https://pro-api.coinmarketcap.com/v1/cryptocurrency/listings/latest?CMC_PRO_API_KEY=fd7cc863-5b4f-492c-8243-26aaef1a06c7'
                            '&limit=1500&cryptocurrency_type=coins')
    
    if response.status_code == 200:
      try:
        data = response.json()
        new_list = []
        for coin in data['data']:
          new_list.append({'name': coin['name'], 'symbol': coin['symbol'], 'price': coin['quote']['USD']['price'], 'percent_change_24h': coin['quote']['USD']['percent_change_24h'],
              'volume_change24h': coin['quote']['USD']['volume_change_24h'], 'volume_24h': coin['quote']['USD']['volume_24h'], 'market_cap': coin['quote']['USD']['market_cap'],})
      except:
        pass
    else:
      pass
    
    coins_list = list(new_list)
    time.sleep(216000)


app = Flask(__name__)


@app.route('/data', methods=['GET'])
def send_data():
  global coin
  response = jsonify(coins_list)
  response.headers.add('Access-Control-Allow-Origin', '*')
  return response


print('Setting Up Server!')
print('Price update frequency 1 HOUR!')
update_thread = threading.Thread(target=update_price_thread, daemon=True).start()
app.run(debug=True, host="0.0.0.0", port=3070)
run = False
