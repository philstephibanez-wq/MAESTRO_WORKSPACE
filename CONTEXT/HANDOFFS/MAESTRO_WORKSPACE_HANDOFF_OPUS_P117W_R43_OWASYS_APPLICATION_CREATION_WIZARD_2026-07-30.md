# MAESTRO WORKSPACE — Handoff OPUS P117W R43

Date : 2026-07-30

## Source canonique

```text
Workspace : philstephibanez-wq/MAESTRO_WORKSPACE master
OPUS      : philstephibanez-wq/OPUS master
OPUS HEAD : 98842dba015402af7e8b3421e62032236c2d8f30
```

R42 est appliqué. `sites/opus-demo` est supprimé.

## Action active

Faire évoluer OWASYS `new` en assistant transactionnel de création d’application.

Le résultat initial doit contenir une seule page d’accueil, toutes les langues UE plus l’ukrainien, et éventuellement une page de connexion si l’owner la demande dans le workflow. Aucun module ou écran technique de démonstration n’est préfabriqué.

## Décisions acquises

- correction à la source du parcours OWASYS ;
- collecte de l’authentification, login, SSO, utilisateurs initiaux, rôles, permissions et ACL ;
- résumé et confirmation avant mutation ;
- aucune donnée sensible dans le blueprint ;
- création atomique et rollback contrôlé ;
- ajout ultérieur des pages par un workflow distinct corrélant page, route, FSM, ViewModel, SCORE, navigation, ACL et I18n ;
- `php -S` et `opus:dev-server` restent strictement réservés au développement ;
- production sous Apache, Nginx ou serveur équivalent.

## Flux obligatoire

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer allow-listé
-> scaffold validé et atomique -> validation OPUS -> Registry
```

## Prochaine livraison

Relire les fichiers OWASYS et OPUS exacts au HEAD `98842dba`, définir le différentiel minimal, puis livrer R43 en ZIP de fichiers complets. Aucun push OPUS/OWASYS par l’assistant.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO PARTIAL SITE.  
NO FALLBACK SILENCIEUX.
