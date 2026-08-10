# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-11.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : 186517fd37c14047e33308500d0699b8ac36ab44
Commit : opus_p117w_r45d2a12_source_acl_ui_truth
```

## États acquis

- R45C3R1 : workflow OWASYS structuré acquis.
- R45D1 : workspace Sécurité réel acquis.
- R45D2A2 : provisioning local-password runtime acquis.
- R45D2A3 : observabilité login acquise.
- R45D2A6 : Profiler repliable validé owner.
- R45D2A7 : projection hiérarchique Profiler acquise.
- R45D2A8 : diagnostic local-password détaillé acquis.
- R45D2A9B : message utilisateur login I18n + PRG acquis.
- R45D2A10 : corrélation trace POST login à travers PRG acquise.
- R45D2A11 : reset administrateur local-password acquis ; `essai2/steve` se connecte avec succès.
- R45D2A12 : UI Sources/Git alignée sur la décision ACL `source/write`, publiée sous `186517fd...`.

## Besoin owner courant

Après connexion à `essai2`, aucune déconnexion propre n'est disponible. Le registre de routes publié ne contient que `/` et `/login`. Le runtime ne possède aucun traitement logout.

## Livrable actif — R45D2A14

```text
ZIP     : opus_p117w_r45d2a14_generated_logout.zip
SHA-256 : 2bdfb59b45b54a903722d5a2b63c5ecfc573c4eacb78049fbda3e0d4a88e0dbb
BASE    : 186517fd37c14047e33308500d0699b8ac36ab44
FILES   : 3
```

R45D2A14 supersède R45D2A13 et inclut la propagation du composant `opus-alert`.

R45D2A14 ajoute :

- `POST /logout` exclusivement ;
- CSRF `opus.generated.logout` single-use ;
- surface SCORE `Déconnexion` pour identité session/local-password authentifiée ;
- destruction complète de la session et expiration du cookie ;
- redirection 303 vers la page login localisée ;
- Logger + Profiler `security.sso.logout.succeeded` ;
- I18n UE + ukrainien ;
- migration générique de tous les sites Composer générés possédant un login ;
- aucun faux logout local pour `auth0-proxy` ; le logout upstream reste à contracter avec le bastion/proxy.

## Gate owner

1. appliquer R45D2A14 ;
2. lancer l'applicateur ;
3. lancer le smoke ;
4. lint runtime + scaffold ;
5. dump-autoload ;
6. vérifier les local changes ;
7. relancer `essai2` ;
8. connecté : action `Déconnexion` visible ;
9. activation : POST CSRF, session détruite, redirection `/fr/login` ;
10. `/fr` doit de nouveau demander une authentification ;
11. mauvais mot de passe : alerte OPUS standard incluse par R45D2A14.

NO SITE-SPECIFIC PATCH.
NO GET LOGOUT.
NO SSO/ACL RELAXATION.
NO SECRET.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
