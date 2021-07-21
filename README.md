Úlohou je pomocou SSE (Server Sent Events) vytvoriť generátor číselných hodnôt, ktoré sa budú dať použiť pre online vykresľovanie grafu. Hodnoty budú zodpovedať trom funkčným závislostiam:
y1 = sin2 (ax)
y2 = cos2 (ax)
y3 = sin (ax) cos (ax)
kde a je parametrom.

Vývojár, ktorý bude vytvárať klientsku aplikáciu využívajúcu generované údaje, si bude môcť zvoliť, či bude čerpať naraz údaje všetkých troch závislostí v json štruktúre alebo iba hodnoty niektorej z definovaných funkčných závislostí. Parameter a sa bude dať meniť z klientskej aplikácie aj počas generovania číselných údajov. Jeho hodnotu si je možné uložiť po spracovaní formuláru (kvôli načítaniu v SSE skripte) buď do súboru na serveri alebo do databázy (použitie cache pamäte je tiež možné).
