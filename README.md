
## Proovitöö

Oma proovitöös kasutasin Laraveli frameworki. Andmete pärimiseks veebist kirjutasin commandi, mida on võimalik käivitada käsuga `php artisan schedule:run`. Seda on võimalik käima panna näiteks iga 5 minuti tagant, et vaadet värskendades ei päriks uuesti andmeid veebist.  
Veebilehe vaated cachetakse urli võtmena kasutades samuti ära, et ei päriks kogu aeg uuesti baasist.


## Install

`git clone https://github.com/Yakuzhy/News.git`  
`cd News`  
`composer update`  
### Vajalik on ka kopeerida .env file ning täita oma andmebaasi andmetega   
`copy .env.example .env`  
`php artisan key:generate`  
DB_CONNECTION=mysql  
DB_HOST=127.0.0.1  
DB_PORT=3306  
DB_DATABASE=yourdb  
DB_USERNAME=yourdbusername  
DB_PASSWORD=yourdbpassword  

Seejärel käivitada käsk `php artisan migrate`

### Andmete saamine  
Andmete saamiseks käivitada käsk `php artisan schedule:run`, lisaks taustal käima panemiseks kasutada kas Linux cron'i või Windows Task Scheduleri.

#### Lõpuks sisestada käsk `php artisan serve` ning liikuda brauseris http://127.0.0.1:8000/
