# P113D1 — ASAP RefBook REST API

## Objectif

Exposer côté ASAP une API REST JSON read-only destinée à ASAP_REF_BOOK.

ASAP reste la source de vérité :

- signatures techniques : PHP Reflection ;
- descriptions fonctionnelles : attributs `AsapRefBookClass` et `AsapRefBookMethod` ;
- exemples : `DOC/refbook/examples/*.php` ;
- schémas : `DOC/refbook/diagrams/*.mmd`.

ASAP_REF_BOOK devra interroger cette API au lieu de scanner directement `H:\ASAP`.

## Endpoints

- `GET /api/refbook/health`
- `GET /api/refbook/snapshot`
- `GET /api/refbook/domains`
- `GET /api/refbook/classes`
- `GET /api/refbook/classes/{fqcn}`
- `GET /api/refbook/examples/{id}`
- `GET /api/refbook/diagrams/{id}`

## Contrat

- API read-only.
- Aucun fallback silencieux vers un vieux JSON.
- Aucun rendu HTML côté ASAP.
- Aucun scan direct depuis ASAP_REF_BOOK.
- Les assets manquants renvoient une erreur JSON explicite.
