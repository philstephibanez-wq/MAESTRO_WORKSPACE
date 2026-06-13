# P112D2 — ASAP FSM Guard + ACL Guard

## Rôle

Brancher les gardes FSM et ACL dans le pipeline PHP 8 ASAP.

## Pipeline

```text
REQUEST
-> SiteResolver
-> SiteSecurityPolicyLoader
-> FsmGuard
-> AclGuard
-> Router
-> Controller
-> Service
-> TwigTemplateRenderer
-> Response
```

## Contrat

```text
NO DOC CONTRACT, NO PATCH
NO SILENT FALLBACK
NO IMPLICIT ROUTE
NO IMPLICIT ALLOW
```

## Responsabilités

- `SiteSecurityPolicyLoader` charge la policy XML typée.
- `FsmGuard` valide exactement une transition FSM déclarée.
- `AclGuard` valide exactement une décision ACL déclarée.
- `Application` orchestre uniquement.

## Prochaine étape

P112D3 doit enrichir le Reference Book avec pages classes/API et préparer la génération documentaire automatique.
