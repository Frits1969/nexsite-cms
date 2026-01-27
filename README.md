NexSite CMS
===========

NexSite CMS is een modern, lichtgewicht en modulair open‑source Content Management Systeem. 
Het is ontworpen voor Nederlandse én internationale ontwikkelaars die maximale controle willen 
over functionaliteit, structuur en uitbreidbaarheid.

NexSite CMS biedt een Nederlandstalige interface als standaard, maar ondersteunt vanaf de 
eerste release ook Engels. Extra talen kunnen eenvoudig worden toegevoegd.

Kenmerken
---------
- Standaard Nederlandstalige admin‑interface
- Engelse interface direct beschikbaar
- Volledig meertalig uitbreidbaar
- Modulair ontwerp voor uitbreidbaarheid
- Rollen & rechten (Admin, Beheerder, Betaalde gebruiker, Geregistreerde bezoeker, Gast)
- Lichtgewicht en snel
- Thema‑ en templatestructuur
- API‑first architectuur
- Open‑source onder MIT‑licentie

Taalondersteuning
-----------------
NexSite CMS is vanaf de eerste release tweetalig.

Beschikbare talen:
- Nederlands (standaard)
- Engels

Structuur:
resources/lang/nl/
resources/lang/en/

Nieuwe talen kunnen worden toegevoegd door een extra map aan te maken, bijvoorbeeld:
resources/lang/de/

Het systeem detecteert automatisch welke talen beschikbaar zijn.

Doel van het project
--------------------
NexSite CMS is ontwikkeld als een modern alternatief voor WordPress, Joomla en Drupal. 
Het richt zich op eenvoud, controle, modulariteit, meertaligheid en open‑source toegankelijkheid.

Het CMS is bedoeld voor ontwikkelaars die volledige vrijheid willen zonder afhankelijk te zijn 
van betaalde plugins of logge ecosystemen.

Installatie
-----------
(Wordt uitgebreid zodra de eerste release beschikbaar is.)

Voorlopige stappen:

git clone https://github.com/<jouw-gebruikersnaam>/nexsite-cms.git
cd nexsite-cms
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate

Rollen & Rechten
----------------
NexSite CMS ondersteunt vijf standaardrollen:

- Admin – volledige toegang
- Beheerder – beheert een deel van de site
- Betaalde gebruiker – toegang tot premiumfunctionaliteit
- Geregistreerde bezoeker – basisfunctionaliteit
- Gast – alleen openbare content

Rechten worden beheerd via configuratiebestanden en kunnen per onderdeel worden uitgebreid.

Projectstructuur
----------------
Een globale structuur van het project:

app/
modules/
public/
resources/
config/
database/
docs/
tests/

Roadmap
-------
Versie 0.1 (MVP)
- Homepage‑weergave
- Basis routing
- Admin‑login
- Rollen & rechten
- Tweetalige interface (NL + EN)

Versie 0.2
- Pagina‑beheer
- Navigatie
- Media‑beheer

Versie 0.3
- Module‑systeem
- Thema‑systeem

Versie 1.0
- Documentatie compleet
- Demo‑website
- Community‑release

Bijdragen
---------
Bijdragen zijn welkom. Zodra de basis staat, worden CONTRIBUTING‑richtlijnen toegevoegd.

Licentie
--------
NexSite CMS is open‑source software onder de MIT‑licentie.
