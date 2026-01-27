# 🚀 NexSite CMS

NexSite CMS is een modern, lichtgewicht en modulair open‑source Content Management Systeem.  
Het is ontworpen voor Nederlandse én internationale ontwikkelaars die maximale controle willen over structuur, functionaliteit en uitbreidbaarheid.

🇳🇱 Standaard Nederlandstalig  
🇬🇧 Engels direct beschikbaar  
🗄️ Alle vertalingen worden opgeslagen in de database

---

## ✨ Kenmerken

- 🇳🇱 **Nederlandstalige admin‑interface (standaard)**
- 🇬🇧 **Engelse interface direct beschikbaar**
- 🌍 **Volledig meertalig via database‑gestuurde vertalingen**
- 🧩 **Modulair ontwerp** voor uitbreidbaarheid
- 🔐 **Rollen & rechten** (Admin, Beheerder, Betaalde gebruiker, Geregistreerde bezoeker, Gast)
- ⚡ **Lichtgewicht en snel**
- 🎨 **Thema‑ en templatestructuur**
- 🌐 **API‑first architectuur**
- 📦 **Open‑source onder MIT‑licentie**

---

## 🌍 Taalondersteuning (Database‑gestuurd)

NexSite CMS gebruikt **geen taalbestanden**, maar slaat alle vertalingen op in de database.

### Tabellen:

**languages**
- id  
- code (nl, en, de, fr)  
- name  
- is_default  

**translations**
- id  
- language_id  
- group (bijv. auth, dashboard, menu)  
- key (bijv. login_button, save, logout)  
- value (de vertaalde tekst)

### Voorbeeld:

| Taal | Key | Waarde |
|------|-----|--------|
| nl   | login | Inloggen |
| en   | login | Login |

### Voordelen:
- Teksten zijn aanpasbaar via de admin  
- Geen deploy nodig voor tekstwijzigingen  
- Modules kunnen automatisch vertalingen registreren  
- Nieuwe talen kunnen direct worden toegevoegd  

---

## 🎯 Doel van het project

NexSite CMS is ontwikkeld als een modern alternatief voor WordPress, Joomla en Drupal.  
De focus ligt op:

- 🧠 Eenvoud  
- 🛠️ Controle  
- 🧩 Modulariteit  
- 🌍 Meertaligheid  
- 🔓 Open‑source toegankelijkheid  

Het CMS is bedoeld voor ontwikkelaars die vrijheid willen zonder betaalde plugins of logge ecosystemen.

---

## 📦 Installatie

*(Wordt uitgebreid zodra de eerste release beschikbaar is.)*

Voorlopige stappen:

git clone https://github.com/<jouw-gebruikersnaam>/nexsite-cms.git
cd nexsite-cms
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate

---

## 🔐 Rollen & Rechten

NexSite CMS ondersteunt vijf standaardrollen:

- 👑 **Admin** – volledige toegang  
- 🧭 **Beheerder** – beheert een deel van de site  
- 💎 **Betaalde gebruiker** – toegang tot premiumfunctionaliteit  
- 🙋 **Geregistreerde bezoeker** – basisfunctionaliteit  
- 👤 **Gast** – alleen openbare content  

Rechten worden beheerd via configuratiebestanden en kunnen per onderdeel worden uitgebreid.

---

## 🏗️ Projectstructuur

app/
modules/
public/
resources/
config/
database/
docs/
tests/


Deze structuur is ontworpen voor overzicht, modulariteit en uitbreidbaarheid.

---

## 🛣️ Roadmap

### 🟢 Versie 0.1 (MVP)
- 🏠 Homepage‑weergave  
- 🛣️ Basis routing  
- 🔐 Admin‑login  
- 🧩 Rollen & rechten  
- 🌍 Tweetalige interface (NL + EN)  
- 🗄️ Database‑gestuurde vertalingen  

### 🟡 Versie 0.2
- 📄 Pagina‑beheer  
- 🧭 Navigatie  
- 🖼️ Media‑beheer  

### 🟠 Versie 0.3
- 🧩 Module‑systeem  
- 🎨 Thema‑systeem  

### 🔵 Versie 1.0
- 📚 Documentatie compleet  
- 🖥️ Demo‑website  
- 🤝 Community‑release  

---

## 🤝 Bijdragen

Bijdragen zijn welkom.  
Zodra de basis staat, worden CONTRIBUTING‑richtlijnen toegevoegd.

---

## 📜 Licentie

NexSite CMS is open‑source software onder de **MIT‑licentie**.
