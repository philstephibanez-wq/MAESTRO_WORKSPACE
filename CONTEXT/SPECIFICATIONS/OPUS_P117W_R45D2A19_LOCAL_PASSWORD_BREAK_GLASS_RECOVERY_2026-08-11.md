# OPUS P117W R45D2A19 — Local-password break-glass recovery

Date : 2026-08-11
Statut : livrable actif à valider owner
Base OPUS : `6f82ea0ad46eadd11435e02bc2dd1ff703034c02`

## Contexte acquis

R45D2A18D est publié et le Preview de mutation Sécurité OWASYS aboutit : l'aperçu affiche la mutation, les fichiers affectés, le motif et demande une nouvelle fresh-auth avant Commit.

Question contractuelle ouverte : comment récupérer l'accès lorsqu'un utilisateur `local-password` a oublié son mot de passe OWASYS ?

## État existant

OPUS possède déjà `composer opus:local-password-reset`, avec mot de passe transmis uniquement sur STDIN. Le mot de passe n'est pas placé dans argv, logs, Profiler ou configuration versionnée.

Limites actuelles :

- le resetter n'accepte que les sites `generated-opus-application` créés par Composer ;
- il exige `OPUS_GENERATED_APPLICATION_SSO_V1` ;
- il exige implicitement `runtime_store` et `OPUS_LOCAL_USER_STORE_V1` ;
- `owasys-front` est une `standard-opus-application` ;
- son SSO est `OPUS_SSO_CONFIGURATION_V1`, son store est `var/auth/local-users.json` et son contrat est `OWASYS_LOCAL_USER_STORE_V1`.

## Décision

Ne pas créer de bouton navigateur « mot de passe oublié » sans canal de récupération vérifié. Pour `local-password`, la récupération est une procédure break-glass opérateur hors bande. Pour `auth0-proxy`, la récupération reste chez l'IdP/Auth0.

Le mécanisme OPUS générique `opus:local-password-reset` est étendu de façon compatible :

1. accepter `generated-opus-application` et `standard-opus-application` ;
2. accepter les contrats SSO `OPUS_GENERATED_APPLICATION_SSO_V1` et `OPUS_SSO_CONFIGURATION_V1` ;
3. résoudre le store depuis `runtime_store` ou `store` ;
4. vérifier le contrat réel du store et, lorsqu'il est configuré, exiger son égalité avec `store_contract` ;
5. trouver l'utilisateur par clé de store ou par `id` ;
6. conserver le mode reset historique par défaut ;
7. ajouter l'option `--must-change` pour le cas de récupération ;
8. avec `--must-change`, écrire `must_change_password=true` ;
9. conserver le mot de passe exclusivement sur STDIN.

## Flux recovery OWASYS

```text
accès opérateur serveur
-> opus:local-password-reset -- owasys-front <subject> --must-change
-> mot de passe temporaire via STDIN
-> hash écrit dans var/auth/local-users.json
-> must_change_password=true
-> connexion OWASYS avec mot de passe temporaire
-> FSM password_change_required
-> /account/password
-> ancien=temporaire + nouveau mot de passe
-> must_change_password=false
-> accès normal
```

La FSM OWASYS possède déjà `password_change_required -> account` et l'écran de compte vérifie le mot de passe courant avant d'accepter le nouveau.

## Sécurité

- aucun reset navigateur local sans canal de récupération ;
- aucune valeur claire dans argv ;
- aucune valeur claire dans logs/Profiler ;
- aucun changement ACL ;
- aucun bypass fresh-auth ;
- aucun reset d'un sujet inconnu ;
- store limité à `var/auth/*.json` ;
- le mot de passe temporaire doit respecter la longueur minimale du site ;
- le mode `--must-change` est obligatoire pour un cas réel de mot de passe oublié.

## Livrable

```text
ZIP     : opus_p117w_r45d2a19_local_password_break_glass_recovery.zip
SHA-256 : 59614da089f0b8736823dc1159c3f793424538de0b866c231a06168b6333ecab
BASE    : 6f82ea0ad46eadd11435e02bc2dd1ff703034c02
FILES   : 4
```

Fichiers :

- `Opus/Security/Sso/LocalPasswordCredentialResetter.php`
- `Opus/Security/Sso/LocalPasswordCredentialResetterInterface.php`
- `Opus/Composer/LocalPasswordCredentialResetterComposerCommand.php`
- `tools/smoke_r45d2a19_local_password_break_glass_recovery.php`

## Gate owner

1. extraire le ZIP ;
2. linter les trois fichiers PHP OPUS ;
3. lancer le smoke R45D2A19 ;
4. vérifier autoload/status ;
5. ne pas modifier le mot de passe courant tant qu'un test réel de recovery n'est pas souhaité ;
6. pour un test recovery, utiliser `--must-change`, se reconnecter avec le temporaire et vérifier la redirection obligatoire vers `/account/password` ;
7. après validation, revenir au gate R45D2A18D : nouvelle fresh-auth puis Commit de la mutation Sécurité en cours.

NO BROWSER RESET WITHOUT VERIFIED RECOVERY CHANNEL.
NO PASSWORD IN ARGV/LOG/PROFILER.
NO ACL BYPASS.
NO FRESH-AUTH BYPASS.
NO PUSH OPUS/OWASYS BY ASSISTANT.
