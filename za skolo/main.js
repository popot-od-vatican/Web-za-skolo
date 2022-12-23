
var light_mode = true;
var light_icon = document.getElementById("icon");
var variables = document.querySelector(":root");
var table = document.getElementById('rows');
var page_id = document.getElementById('page-num');
var register_icon = document.getElementById('register-icon');
var bank_icon = document.getElementById('bank-icon');
var coin_icon = document.getElementById('coin-icon');
var start_page = 0;
var page_num = 1;
var list = -1;

function change_mode()
{
    if(light_mode)
    {
        light_icon.src = "sun.png";
        variables.style.setProperty('--primary-background-color', 'rgba(58, 58, 58, 1)');
        variables.style.setProperty('--primary-text-color', 'white');
        variables.style.setProperty('--primary-highlight-color', 'rgba(253, 184, 54, 1)');
        variables.style.setProperty('--primary-row-background-color', 'rgba(58, 58, 58, 1');
        variables.style.setProperty('--primary-page-button-background', 'rgba(24, 154, 24, 1)');
        variables.style.setProperty('--primary-page-border', '1px solid rgba(24, 154, 24, 1)');
        variables.style.setProperty('--primary-nav-border-color', 'rgba(110, 110, 110, 1)');
        register_icon.src = "white-register-icon.png";
        bank_icon.src = "white-bank-icon.png";
        coin_icon.src = "white-coin-icon.png";
    }
    else
    {
        light_icon.src = "moon.png";
        variables.style.setProperty('--primary-background-color', 'rgba(220, 220, 220, 1)');
        variables.style.setProperty('--primary-text-color', 'black');
        variables.style.setProperty('--primary-highlight-color', 'rgba(60, 60, 60, 1)');
        variables.style.setProperty('--primary-row-background-color', 'rgba(201, 201, 201, 1');
        variables.style.setProperty('--primary-page-button-background', 'rgba(220, 220, 220, 1)');
        variables.style.setProperty('--primary-page-border', '1px solid black');
        variables.style.setProperty('--primary-nav-border-color', 'rgba(255, 255, 255, 1)');
        register_icon.src = "black-register-icon.png";
        bank_icon.src = "black-bank-icon.png";
        coin_icon.src = "black-coin-icon.png";
    }

    light_mode = !light_mode;
}

function show_languages()
{
    let element = document.getElementById("drop-down");
    element.style.display = "block";
}

function previous_page()
{
    if(page_num == 1 || list == -1)
        return;

    start_page -= 18;
    page_num -= 1;
    page_id.innerHTML = page_num;
    update_table(list);
}

function next_page()
{
    if(list == -1 || (page_num * 18) >= list.length)
        return;

    start_page += 18;
    page_num += 1;
    page_id.innerHTML = page_num;
    update_table(list);
    
}

function update_table(data)
{
    table.innerHTML = '';

    for(let i = start_page; i < data.length && i < start_page + 18; ++i)
    {
        let index = document.createElement('td');
        index.innerHTML = i+1;

        let image = document.createElement('img');
        image.src = data[i]['image'];
        image.width = 22;
        image.height = 22;
        image.style.marginRight = "8px";

        let name = document.createElement('td');
        name.appendChild(image);
        name.innerHTML += data[i]['name'] + ' (<b>' + data[i]['symbol'].toUpperCase() + '</b>)';

        let price = document.createElement('td');

        if(data[i]['current_price'] <= 0.01)
            price.innerHTML = '$' + FormatNumber(data[i]['current_price'].toString());
        else if(data[i]['current_price'] % 1 == 0)
            price.innerHTML = '$' + FormatNumber(data[i]['current_price'].toString()) + '.00';
        else
            price.innerHTML = '$' + FormatNumber((data[i]['current_price']).toFixed(2).toString());

        let percent_change_24h = document.createElement('td');
        percent_change_24h.innerHTML = (Math.round(data[i]['price_change_percentage_24h'] * 100) / 100).toFixed(2) + '%';

        let volume_24h = document.createElement('td');
        volume_24h.innerHTML = '$' + FormatNumber((Math.round(data[i]['total_volume'] * 100) / 100).toString());

        let market_cap_change = document.createElement('td');
        market_cap_change.innerHTML = (Math.round(data[i]['market_cap_change_percentage_24h'] * 100) / 100).toFixed(2) + '%';

        let market_cap = document.createElement('td');
        market_cap.innerHTML = '$' + FormatNumber((Math.round(data[i]['market_cap'] * 100) / 100).toString());


        if(data[i]['price_change_percentage_24h'] < 0)
            percent_change_24h.style.color = '#FF1B1B';
        else if(percent_change_24h == '0')
            percent_change_24h.style.color = 'var(--primary-text-color)';
        else
            percent_change_24h.style.color = '#00BA00';
                
        if(data[i]['market_cap_change_percentage_24h'] < 0)
            market_cap_change.style.color = '#FF1B1B';
        else if(percent_change_24h == '0')
            market_cap_change.style.color = 'var(--primary-text-color)';
        else
            market_cap_change.style.color = '#00BA00';


        let row = document.createElement('tr');
        row.appendChild(index);
        row.appendChild(name);
        row.appendChild(price);
        row.appendChild(percent_change_24h);
        row.appendChild(volume_24h);
        row.appendChild(market_cap);
        row.appendChild(market_cap_change);

        table.appendChild(row);
    }
}

function SortByPrices(list)
{
    for(let i = 0; i < list.length; ++i)
    {
        for(let j = i+1; j < list.length; ++j)
        {
            if(list[i]['current_price'] < list[j]['current_price'])
            {
                let tmp = list[i];
                list[i] = list[j];
                list[j] = tmp;
            }
        }
    }
}

function FormatNumber(number)
{
    let result = "", ans = "", count = 0, i = 0, dc;

    for(; i < number.length; ++i)
        if(number[i] == '.')
        {
            dc = i+1;
            break;
        }

    i = i - 1;

    while(i >= 0)
    {
        if(count == 3)
        {
            result += ',' + number[i];
            count = 0;
        }
        else
            result += number[i];

        --i, ++count;
    }

    for(i = result.length-1; i >= 0; --i)
        ans += result[i];

    if(dc < number.length)
        ans += '.';

    for(i = dc; i < number.length; ++i)
        ans += number[i];


    return ans;
}

function update_prices()
{
    fetch('https://api.coingecko.com/api/v3/coins/markets?vs_currency=USD&order=market_cap_desc&per_page=250&page=1&sparkline=false').then( (res) => {

        if(res.status != 200)
        {
            console.log('Http request failed!');
            return;
        }

        res.json().then((data) => {
            list = data;
            SortByPrices(list);
            update_table(list);
        }).catch((err) => {
            console.log(err);
        });

    }).catch((err) => {
        console.log(err);
    })
}

update_prices();