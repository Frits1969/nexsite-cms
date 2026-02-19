# Implementatieplan: Installatie Voltooien (v0.0.4)

Volledige installatieprocedure implementeren voor Fritsion CMS met database setup, configuratie generatie en installer lockout.

## Voorgestelde Wijzigingen

### Database Schema

#### [NEW] [schema.sql](file://qnap/Share/Mijn%20documenten/GitHub/nexsite-cms/database/schema.sql)

SQL schema met drie tabellen:
- **settings**: Site configuratie (naam, beschrijving, domein)
- **users**: Admin accounts (username, email, password hash, role)
- **sessions**: Sessie management (optioneel voor later)

---

### Installer Logic

#### [NEW] [Installer.php](file://qnap/Share/Mijn%20documenten/GitHub/nexsite-cms/app/Installer.php)

Nieuwe class met methodes:
- `createTables()`: Voer SQL schema uit
- `createAdminUser()`: Hash wachtwoord, insert admin
- `saveSettings()`: Insert site configuratie
- `generateEnvFile()`: Schrijf `.env` met database credentials
- `lockInstaller()`: Maak `install.lock` bestand
- `run()`: Orchestreer volledige installatie

---

### Application Updates

#### [MODIFY] [App.php](file://qnap/Share/Mijn%20documenten/GitHub/nexsite-cms/app/App.php)

**Wijzigingen:**
- Update `VERSION` naar `0.0.4`
- Check `install.lock` in `run()` methode
- Als lock bestaat: redirect naar admin (later te bouwen)
- POST handler voor `/install` route:
  - Valideer form data
  - Instantieer `Installer`
  - Voer installatie uit
  - Return JSON response (success/error)

---

### Language Files

#### [MODIFY] [nl.php](file://qnap/Share/Mijn%20documenten/GitHub/nexsite-cms/lang/nl.php)

Voeg toe:
- `installing`: "Bezig met installeren..."
- `install_success`: "Installatie succesvol!"
- `install_error`: "Installatie mislukt"
- `redirecting`: "Doorverwijzen naar login..."

#### [MODIFY] [en.php](file://qnap/Share/Mijn%20documenten/GitHub/nexsite-cms/lang/en.php)

Engelse vertalingen van bovenstaande keys.

---

### View Updates

#### [MODIFY] [splash.php](file://qnap/Share/Mijn%20documenten/GitHub/nexsite-cms/app/Views/splash.php)

**JavaScript wijzigingen:**
- Update form submit handler
- Toon loading state tijdens installatie
- Toon succes/error info box
- Auto-redirect na 3 seconden bij succes

---

### Configuration

#### [MODIFY] [.gitignore](file://qnap/Share/Mijn%20documenten/GitHub/nexsite-cms/.gitignore)

Voeg toe:
- `install.lock`
- `config/*.php` (voor toekomstige config bestanden)

## Verification Plan

### Manual Verification
1. Start fresh installatie
2. Vul alle stappen in
3. Test database verbinding
4. Klik "Installeren"
5. Verifieer:
   - `.env` bestand is aangemaakt
   - Database tabellen bestaan
   - Admin user is aangemaakt
   - `install.lock` bestaat
   - Kan niet opnieuw installeren
