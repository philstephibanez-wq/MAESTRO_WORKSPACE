# OPUS Manager - Create Site technical type first

Contrat : `OPUS_MANAGER_CREATE_SITE_TECH_TYPE_FIRST_CORE`

## Decision

Dans le wizard `Creer un site`, la premiere question doit etre l'architecture technique :

- Fullstack
- Frontend
- Backend

L'espace fonctionnel vient ensuite seulement :

- portail public
- frontoffice
- backoffice
- mixte
- espace admin
- espace utilisateur

## Regle

Fullstack, Frontend et Backend sont des architectures techniques.

Frontoffice, Backoffice et Portail sont des espaces fonctionnels.

Ne jamais confondre les deux axes.

## Implications

### Fullstack

Cas de reference : LogAndPlay.

- portail de contenu
- SEO
- pages publiques
- formulaires controles
- separation interne vues / services / donnees

### Frontend

- backend associe obligatoire
- API obligatoire
- ACL/RBAC consommes
- SSO ou session federée
- aucun acces direct aux donnees metier

### Backend

- API
- services metier
- donnees
- ACL/RBAC portes ici
- SSO porte ici
- ODBC/LSTSAR possibles
- health/version/logs obligatoires

## CLI et OPUS Manager

La meme decision doit exister via CLI et via OPUS Manager.

Les deux entrees doivent produire le meme plan Composer, les memes smokes, le meme Ref Book et le meme User Book.
