# Versie 0.0.4: Installatie Voltooien

## Overzicht
Implementeer de volledige installatieprocedure voor NexSite CMS.

## Taken

### 1. Versienummer updaten
- [ ] Update `App::VERSION` naar `0.0.4`

### 2. Database Schema
- [ ] Maak database schema bestand (`database/schema.sql`)
  - [ ] Tabel: `settings` (site configuratie)
  - [ ] Tabel: `users` (admin accounts)
  - [ ] Tabel: `pages` (CMS pagina's - optioneel voor later)

### 3. Installer Class
- [ ] Maak `app/Installer.php`
  - [ ] Methode: `createTables()` - SQL schema uitvoeren
  - [ ] Methode: `createAdminUser()` - Admin account aanmaken
  - [ ] Methode: `saveSettings()` - Site naam/beschrijving opslaan
  - [ ] Methode: `generateConfig()` - `.env` bestand genereren
  - [ ] Methode: `lockInstaller()` - `install.lock` bestand aanmaken

### 4. App.php Aanpassen
- [ ] Controleer op `install.lock` bij opstarten
- [ ] Als lock bestaat: redirect naar admin/login
- [ ] POST handler voor `/install` route
  - [ ] Valideer alle form data
  - [ ] Roep Installer methodes aan
  - [ ] Toon succes/error feedback

### 5. Taalbestanden Updaten
- [ ] `nl.php`: Voeg installatie berichten toe
- [ ] `en.php`: Voeg installatie berichten toe

### 6. Splash.php Aanpassen
- [ ] Voeg loading state toe tijdens installatie
- [ ] Toon succes bericht na installatie
- [ ] Redirect naar login na 3 seconden

### 7. Testen
- [ ] Test volledige installatie flow
- [ ] Verifieer database tabellen
- [ ] Verifieer `.env` bestand
- [ ] Verifieer `install.lock` werkt
- [ ] Test herinstallatie preventie
