## Par projektu

data-form ir risinājums XML datu augšupielādei PostgreSQL datubāzē ar funkcionalitāti jaunu datu pievienošanai un esošo datu modifikācijai.

## Funkcionalitāte
- Lapa /upload-form satur vienkāršu formu .xml faila augšupielādei datubāzē.
<br> Nospiežot Browse var izvēlēties augšupielādējamo XML failu.
<br> Nospiežot Upload var veikt izvēlētā faila augšupielādi.

- Lapa /index.php satur tabulu datubāzē esošo datu attēlošanai. 
<br>Nospiežot pogu Edit var rediģēt izvēlēto rindu.
<br>Nospiežot pogu Save var saglabāt rediģēto rindu.
<br>Nospiežot pogu New var izveidot jaunu rindu.

## Galvenie komponenti
- **/app/Http/Controllers/BookController.php**
<br> Satur funkcijas datu bāzes tabulas attēlošanai, datu atjaunošanai, ielādei datubāzē, grāmatu ID ģenerēšanai.
- **/database/migrations/2023_11_20_103200_create_books_table.php**
<br> Satur funkcijas sākotnējai migrācijai (izveido nepieciešamo tabulu) un migrācijas atcelšanai.
- **/app/Http/Controllers/BookController.php**
<br> Satur funkcijas datu bāzes tabulas attēlošanai, datu atjaunošanai, ielādei datubāzē, grāmatu ID ģenerēšanai.
- **/app/Models/Book.php**
<br> Satur datubāzes modeli.
- **/routes/web.php**
<br> Nosaka web maršrutus un saistību ar kontroleriem.
- **/resources/views/layouts/main.blade.php**
<br> Galvenais lapas izkārtojums.
- **/resources/views/index.blade.php**
<br> Galvenais skats tabulas attēlošanai.
- **/resources/views/create.blade.php**
<br> Skats XML augšupielādes formas attēlošanai.
- **/public/js/app.js**
<br> Satur izmantojamo kodu darbībām ar tabulas rindām.
- **/public/css/app.css**
<br> Satur izmantotos stilus.

Augšupielādējamā XML faila struktūra:
<pre><code>
&lt;catalog&gt;    
    &lt;book id="bknnn"&gt;, kur bk - prefikss, nnn - cipari.
        &lt;author&gt;: Grāmatas autora vārds, uzvārds.
        &lt;title&gt;: Grāmatas nosaukums.
        &lt;genre&gt;: Grāmatas žanrs.
        &lt;price&gt;: Grāmatas cena.
        &lt;publish_date&gt;: Grāmatas publikācijas datums YYYY-MM-DD.
        &lt;description&gt;: Grāmatas apraksts.
    &lt;/book&gt;
    ...
&lt;/catalog&gt;
</code></pre>

## Izmantotie rīki
- **[Laravel](https://laravel.com/)**
- **[PostgreSQL](https://www.postgresql.org/)**
- **[PHP](https://www.php.net/)**
- **HTML**
- **CSS**
- **[JavaScript](https://laravel.com/)**
- **[jQuery](https://jquery.com/)**
- **AJAX**