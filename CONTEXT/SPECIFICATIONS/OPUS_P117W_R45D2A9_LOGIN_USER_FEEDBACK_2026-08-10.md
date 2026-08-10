# OPUS P117W R45D2A9 — LOGIN USER FEEDBACK

Date : 2026-08-10

## Incident confirmé

Après un POST de login refusé, le runtime réaffiche la page de connexion avec une information utilisateur trop générique et non localisée (`Authentication failed.`). Le Profiler prouve désormais la cause technique `OPUS_SSO_LOCAL_PASSWORD_INVALID`, mais cette cause ne doit pas être exposée dans l'UI car elle permettrait de distinguer un compte existant d'un compte absent.

## Contrat

1. La cause technique détaillée reste exclusivement dans Logger/Profiler.
2. L'utilisateur reçoit un message générique et non discriminant : identifiant ou mot de passe incorrect.
3. Le message est localisé pour toutes les locales OPUS supportées : langues UE + ukrainien.
4. Le POST d'authentification refusé retourne un 303 vers la route login localisée.
5. L'erreur est un flash consommé au GET suivant, et ne persiste pas après rechargement ultérieur.
6. Le rendu reste exclusivement SCORE et I18n.
7. Aucun secret, mot de passe, hash ou POST brut n'est exposé.
8. Aucun relâchement ACL/SSO.
9. Aucun correctif spécifique à `essai2` : la migration s'applique génériquement à tous les sites Composer générés conformes au contrat.

## Livrable

```text
ZIP     : opus_p117w_r45d2a9_login_user_feedback.zip
SHA-256 : 776dde0bd303d5110804a14212d31786acd945dbe9c55ddaef39dd8281eb4a0f
BASE    : 62ed6c6b7440034c5855e310899fb11d605fdf00 + R45D2A8 local
FILES   : 4
```

Le ZIP est cumulatif avec R45D2A8 et contient les trois fichiers complets R45D2A8 plus `tools/r45d2a9_apply_login_user_feedback.php`, applicateur contractuel fail-fast qui modifie le runtime/scaffold et migre les catalogues login des applications générées existantes.

## Gate

Après application, une tentative invalide doit produire :

- navigateur : message I18n générique ;
- réponse POST : 303 vers `/<locale>/login` ;
- Profiler : cause technique détaillée inchangée ;
- second GET/rechargement : flash disparu.
