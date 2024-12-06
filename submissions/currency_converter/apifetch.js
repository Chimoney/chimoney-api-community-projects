// import  APIKEY from "./key";

const convert = () => { 
    const countrySymbol = document.getElementById('symbol').value; 
    const amountInUSD = document.getElementById('amount').value;

const options = { 
    method: 'GET',  
    headers: { 
        accept: 'application-json',
        // 'X-API-KEY': APIKEY
        'X-API-KEY' : "f53b14db7658d93aeb2f8589838b87e01d730d82b9c73e9878065452902790b7"
    }
};
    const apiUrl = 'https://api.chimoney.io/v0.2/info/usd-amount-in-local?destinationCurrency=USD&amountInUSD=1' 
    fetch(apiUrl, options) 
    .then(response => response.json())
    .then(response => { document.getElementById('result').innerText = `Result: ${JSON.stringify(response)}`; 
})
    .catch(err => console.error(err));
}