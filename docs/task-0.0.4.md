# Versie 0.0.4: Installatie Voltooien

## Overzicht
Implementeer de volledige installatieprocedure voor NexSite CMS.

## Taken

### 1. Versienummer updaten
- [x] Update `App::VERSION` naar `0.0.4`

### 2. Database Schema
- [x] Maak database schema bestand (`database/schema.sql`)
  - [x] Tabel: `settings` (site configuratie)
  - [x] Tabel: `users` (admin accounts)
  - [x] Tabel: `pages` (CMS pagina's - optioneel voor later)

### 3. Installer Class
- [x] Maak `app/Installer.php`
  - [x] Methode: `createTables()` - SQL schema uitvoeren
  - [x] Methode: `createAdminUser()` - Admin account aanmaken
  - [x] Methode: `saveSettings()` - Site naam/beschrijving opslaan
  - [x] Methode: `generateConfig()` - `.env` bestand genereren
  - [x] Methode: `lockInstaller()` - `install.lock` bestand aanmaken

### 4. App.php Aanpassen
- [x] Controleer op `install.lock` bij opstarten
- [x] Als lock bestaat: redirect naar admin/login
- [x] POST handler voor `/install` route
  - [x] Valideer alle form data
  - [x] Roep Installer methodes aan
  - [x] Toon succes/error feedback

### 5. Taalbestanden Updaten
- [x] `nl.php`: Voeg installatie berichten toe
- [x] `en.php`: Voeg installatie berichten toe

### 6. Splash.php Aanpassen
- [x] Voeg loading state toe tijdens installatie
- [x] Toon succes bericht na installatie
- [x] Redirect naar login na 3 seconden

### 7. Testen
- [ ] Test volledige installatie flow
- [ ] Verifieer database tabellen
- [ ] Verifieer `.env` bestand
- [ ] Verifieer `install.lock` werkt
- [ ] Test herinstallatie preventie
