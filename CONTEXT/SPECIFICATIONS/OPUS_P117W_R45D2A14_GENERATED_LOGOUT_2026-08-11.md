# OPUS P117W R45D2A14 — GENERATED LOGOUT

Date : 2026-08-11
Statut : livrable owner à valider
Base OPUS : `186517fd37c14047e33308500d0699b8ac36ab44`

## Constat owner

Après connexion réussie à `essai2`, aucune action de déconnexion propre n'est disponible dans l'application générée.

Le registre `sites/essai2/config/routes.json` ne contient que `/` et `/login`. `GeneratedSiteRuntime` gère la création/lecture de session et le login local-password mais aucun logout.

## Cause

Le scaffold généré ne définit ni route `logout`, ni surface SCORE de déconnexion, ni traitement runtime de destruction de session.

## Correction contractuelle

R45D2A14 ajoute un logout générique pour les applications OPUS générées possédant une page de login :

- route `POST /logout` ;
- CSRF scoped `opus.generated.logout`, token single-use via `CsrfTokenManager` ;
- formulaire SCORE injecté dans la navigation uniquement pour une identité authentifiée et non `auth0-proxy` ;
- destruction de la session et expiration du cookie de session ;
- redirection `303` vers la page login localisée ;
- Logger + Profiler : événement réellement mesuré `security.sso.logout.succeeded` ;
- I18n `auth.logout` pour les langues UE supportées + ukrainien ;
- migration générique des sites Composer générés existants avec login ;
- correction R45D2A13 incluse : propagation du composant `opus-alert` login.

## Sécurité

- GET `/logout` ne déconnecte pas : 405, `Allow: POST` ;
- mutation protégée par CSRF ;
- aucun secret dans URL, argv, Logger ou Profiler ;
- aucune relaxation ACL/SSO ;
- le logout `auth0-proxy` n'est pas simulé localement : aucun bouton local n'est rendu pour ce provider ; le logout upstream devra être contracté séparément avec le bastion/proxy.

## Livrable

```text
ZIP     : opus_p117w_r45d2a14_generated_logout.zip
SHA-256 : 2bdfb59b45b54a903722d5a2b63c5ecfc573c4eacb78049fbda3e0d4a88e0dbb
BASE    : 186517fd37c14047e33308500d0699b8ac36ab44
FILES   : 3
```

R45D2A14 supersède R45D2A13.

## Gate owner

1. extraire le ZIP dans `H:\OPUS` ;
2. exécuter `php tools\r45d2a14_apply_generated_logout.php` ;
3. exécuter `php tools\smoke_r45d2a14_generated_logout.php` ;
4. lint `GeneratedSiteRuntime.php` et `SiteScaffoldPlan.php` ;
5. dump-autoload ;
6. relancer `essai2` ;
7. connecté : action `Déconnexion` visible ;
8. cliquer : POST CSRF, session détruite, redirection vers `/fr/login` ;
9. revenir sur `/fr` : authentification à nouveau requise ;
10. mauvais mot de passe : alerte OPUS standard R45D2A13 incluse.

NO SITE-SPECIFIC PATCH.
NO GET LOGOUT.
NO SSO/ACL RELAXATION.
NO SECRET.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
