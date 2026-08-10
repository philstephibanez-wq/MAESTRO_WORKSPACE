# OPUS P117W R45D2A11 — LOCAL PASSWORD RESET + STANDARD ALERT

Date : 2026-08-10

## Base canonique

```text
OPUS master = 31f6c142a1b41a16d6f1cdc17cd48f3d866c3b33
commit = opus_p117w_r45d2a10_login_prg_profiler_correlation
```

## Causes traitées

1. Le provider local-password sait vérifier/changer un mot de passe mais le provisioning initial refuse d'écraser un credential existant. Il manque donc un contrat d'administration permettant de réinitialiser un password sans connaître l'ancien.
2. L'erreur login est fonctionnelle mais rendue comme un simple paragraphe ; elle doit devenir une alerte visuelle standard SCORE, accessible et réutilisable par les applications OPUS générées.

## Contrat reset

Commande :

```text
opus:local-password-reset -- <site_id> <subject>
```

Le nouveau password est lu uniquement depuis STDIN non interactif. Il n'est jamais fourni dans argv, ni écrit dans les logs, le Profiler ou une configuration versionnée.

Le reset :
- exige un site Composer conforme `generated-opus-application` ;
- exige `local-password` actif ;
- exige un store runtime `var/auth/*.json` conforme ;
- exige un subject existant ;
- conserve identité, rôles et métadonnées existantes ;
- remplace uniquement `password_hash`, `must_change_password`, `password_changed_at`, `updated_at` ;
- minimum 10 caractères ;
- aucun fallback silencieux.

## Contrat UI alert

L'erreur login reste non discriminante et I18n. Le template SCORE utilise :

```text
.opus-alert.opus-alert-error
role=alert
aria-live=assertive
```

Le style est fourni par le CSS générique généré ; les sites Composer générés existants sont migrés génériquement par l'applicateur du livrable.

## Classes concrètes

Les nouvelles classes concrètes possèdent chacune une interface homonyme étendant directement les quatre marqueurs OPUS obligatoires.

## Interdits

NO SITE-SPECIFIC PATCH.
NO PASSWORD IN ARGV.
NO SECRET IN LOGS/PROFILER/UI.
NO ACL/SSO RELAXATION.
NO MANUAL STORE EDIT.
NO PUSH OPUS BY ASSISTANT.
