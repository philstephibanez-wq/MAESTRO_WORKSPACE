# HANDOFF — OPUS P117W R45D2A9 LOGIN USER FEEDBACK

Date : 2026-08-10

## Preuve owner

Le Profiler affiche désormais correctement :

```text
security.sso.authentication.failed
provider=local-password
locale=fr
error_code=OPUS_SSO_LOCAL_PASSWORD_INVALID
```

La cause technique est donc acquise : le mot de passe fourni ne correspond pas au hash runtime pour le subject résolu.

## Nouvelle exigence UX

Le navigateur ne doit pas simplement revenir sur la page login sans feedback exploitable. Le contrat utilisateur est :

```text
Identifiant ou mot de passe incorrect.
```

Ce message doit rester générique afin de ne pas permettre l'énumération des comptes. Le code technique détaillé reste réservé à Logger/Profiler.

## Livrable actif — R45D2A9

```text
ZIP     : opus_p117w_r45d2a9_login_user_feedback.zip
SHA-256 : 776dde0bd303d5110804a14212d31786acd945dbe9c55ddaef39dd8281eb4a0f
BASE    : 62ed6c6b7440034c5855e310899fb11d605fdf00 + R45D2A8 local
FILES   : 4
```

R45D2A9 est cumulatif avec R45D2A8.

Fonctions :

1. diagnostic local-password détaillé conservé ;
2. panneau Profiler hiérarchique conservé ;
3. Profiler repliable conservé ;
4. échec POST login -> 303 vers la route login localisée ;
5. erreur utilisateur stockée comme flash ;
6. flash consommé après le GET de rendu ;
7. texte `auth.error` localisé pour toutes les locales OPUS supportées ;
8. migration générique des catalogues login des applications Composer générées existantes ;
9. aucun secret ou code technique exposé dans l'UI.

## Gate owner immédiat

1. appliquer R45D2A9 ;
2. exécuter l'applicateur R45D2A9 ;
3. lint des fichiers PHP modifiés ;
4. `composer dump-autoload -o` ;
5. relancer `essai2` ;
6. tester un mot de passe faux : message utilisateur localisé attendu ;
7. vérifier dans Profiler que `OPUS_SSO_LOCAL_PASSWORD_INVALID` reste disponible ;
8. recharger la page : le message flash doit disparaître ;
9. ensuite corriger/provisionner le vrai password `steve` puis reprendre R45D2 preview/commit.

NO SITE-SPECIFIC PATCH.
NO ACL/SSO RELAXATION.
NO SECRET IN UI/LOGS/PROFILER.
NO PUSH OPUS BY ASSISTANT.
