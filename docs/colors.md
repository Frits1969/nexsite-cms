# Kleurendocumentatie Fritsion CMS

Dit document beschrijft het kleurenpalet dat gebruikt wordt in Fritsion CMS.
Het palet is volledig afgestemd op het logo (`logo_fritsion_cms.png`).

---

## Basis

| Rol | Kleurcode | Beschrijving |
|-----|-----------|--------------|
| **Primaire achtergrond** | `#0D0A1E` | Diep paars-zwart (afgeleid van logo-paars) |
| **Secundaire achtergrond / Sidebar** | `#1A1336` | Donker paars |
| **Tekst (hoofd)** | `#F1F5F9` | Bijna wit |
| **Tekst (subtitel / muted)** | `#A89BC2` | Licht paars-grijs |
| **Glass-achtergrond** | `rgba(26, 19, 54, 0.75)` | Semi-transparant paars |
| **Glass-rand** | `rgba(139, 92, 246, 0.15)` | Subtiele paarse rand |

---

## Accentkleuren (uit het logo)

| Naam | Kleurcode | Herkomst in logo |
|------|-----------|------------------|
| **Hot pink / magenta** | `#E8186A` | De "F" letter in het logo |
| **Donker roze** | `#C41257` | Midpoint in de gradient |
| **Oranje** | `#F0961B` | De "CMS" tekst in het logo |
| **Dieppaars** | `#3B2A8C` | De "Fritsion" tekst in het logo |
| **Licht paars (accent)** | `#8B5CF6` | Afgeleid van logo-paars |

---

## Gradient

De primaire gradient volgt de overgangen van de logo-cirkel:

```css
/* Roze → Donker roze → Oranje (gebruikt op knoppen, avatars, kaarten) */
linear-gradient(135deg, #E8186A 0%, #C41257 40%, #F0961B 100%)

/* Volledig logo-verloop (oranje → roze → paars) */
linear-gradient(135deg, #FFB347 0%, #E8186A 50%, #3B2A8C 100%)
```

---

## Installatiepagina — Puzzelstukken

| Stap | Kleur | Kleurcode |
|------|-------|-----------|
| **Stap 1** (Site info) | Oranje puzzelstuk | `#F0961B` |
| | Tip achtergrond | `#FDEBD1` |
| | Tip rand | `#A86205` |
| **Stap 2** (Beheerdersaccount) | Roze/magenta puzzelstuk | `#E8186A` |
| | Tip achtergrond | `#FCE4EF` |
| | Tip rand | `#8C0040` |
| **Stap 3** (Database) | Paars puzzelstuk | `#3B2A8C` |
| | Tip achtergrond | `#E8E0F5` |
| | Tip rand | `#1C0E5A` |

---

## Interactie

| Element | Standaard | Hover |
|---------|-----------|-------|
| **Navigatieknoppen** | `#3B2A8C` (paars) | `#E8186A` (roze) |
| **DB-test knop** | `#F0961B` (oranje) | — |
| **Input focus-rand** | `#E8186A` (roze) | — |
| **Nav-item actief/hover** | Achtergrond: `rgba(232, 24, 106, 0.1)` | Tekst: `#E8186A` |
| **Actieve sidebar-indicator** | `#F0961B` (oranje, balk onderaan) | — |

---

## Statusbadges / Meldingen

| Status | Achtergrond | Tekst |
|--------|-------------|-------|
| Gepubliceerd | `rgba(232, 24, 106, 0.1)` | `#E8186A` |
| Concept | `rgba(240, 150, 27, 0.1)` | `#F0961B` |
| Gearchiveerd | `rgba(168, 155, 194, 0.1)` | `#A89BC2` |
| Info (melding) | `#E8E0F5` | `#1C0E5A` |
| Succes (melding) | `#FCE4EF` | `#6B0030` |
| Fout (melding) | `rgba(239, 68, 68, 0.1)` | `#EF4444` |
