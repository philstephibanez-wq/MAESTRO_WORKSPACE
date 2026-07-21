# MAESTRO_WORKSPACE — Handoff OWASYS / OPUS P117A

**Source code relue :** `philstephibanez-wq/OPUS`, `master`, commit `6e31850b9915700b93c7a7a1d29304d9a852ecc1`.

## Règles impératives

- Chaque `sites/<application>` est une application autonome dépendant du framework OPUS.
- Le document root est `sites/<application>/www`; `OPUS/www` est interdit.
- OWASYS est une application OPUS standard, pas le pilote du framework.
- Tout rendu d'interface passe par `Opus\Template\ScoreTemplateRenderer` et des fichiers `.score`.
- `application/default/views/layout.php` est interdit et doit être supprimé.
- Toute requête/action devient un événement FSM avant dispatch.
- Toute identité provient de l'abstraction SSO OPUS.
- Toute route/action privée reçoit une décision ACL serveur deny-by-default.
- Le filtrage du menu et le contrôle serveur utilisent la même politique ACL.
- Les 24 langues officielles de l'UE et l'ukrainien restent obligatoires.

## Incident login

Le runtime authentifie contre `sites/owasys/var/auth/local-users.json`. Ce fichier est runtime, non versionné et peut être absent ou incompatible après refactor. Le correctif fournit un bootstrap local SSO propre à l'application.

## Reprise

1. Préserver le store utilisateur runtime existant.
2. Extraire le ZIP à la racine de `H:\OPUS`.
3. Supprimer le layout PHP interdit.
4. Comparer puis fusionner le contrat d'intégration dans le contrôleur live; ne pas l'écraser aveuglément.
5. Créer/réparer un utilisateur avec le CLI SSO de l'application.
6. Lancer syntaxes, smoke conformité et recette HTTP.

## Sortie P117A

- SCORE uniquement pour l'UI;
- navigation/actions pilotées FSM;
- SSO obligatoire;
- ACL deny-by-default;
- login valide et invalides refusés;
- aucune vue/layout PHP d'interface;
- application OWASYS autonome et conforme OPUS.
