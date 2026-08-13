# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-13

## Lecture obligatoire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A24_IDENTITY_LIFECYCLE_BACKEND_2026-08-13.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A25_IDENTITY_LIFECYCLE_UI_2026-08-13.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A25B_SECURITYCONTROLLER_SOURCE_CANONICALIZATION_2026-08-13.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A25C_UNCLASSIFIED_METRIC_NAVIGATION_2026-08-13.md`
8. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base OPUS publiée

`05c0075027ac5818fb6960680e390721fa028b3f` — `opus_p117w_r45d2a25c_unclassified_metric_navigation`.

R45D2A25C est publié. La métrique `À classifier` est un lien SCORE vers `#ow-security-unclassified` et le panneau correspondant est ouvert lorsqu'il existe.

## Gates acquis

- cockpit Sécurité graphique ;
- matrice ACL viewer ;
- Profiler viewer masqué et accès direct refusé ;
- page 403 ACL graphique ;
- Compte viewer ;
- routes frontend localisées avec accents ;
- backend `identity.update` / `identity.delete` avec Preview/Commit, rollback, pertes d'accès et protection de la dernière identité administrative ;
- exposition SCORE lifecycle publiée par R45D2A25A ;
- canonisation source publiée par R45D2A25B ;
- navigation `À classifier` publiée et validée par R45D2A25C ;
- suppression réelle d'une identité legacy validée de bout en bout : Preview puis Commit, compteur `À classifier` réduit de 3 à 2 ;
- classification réelle `unknown -> user` validée sur `steve` : Preview sans accès gagné/perdu, puis Commit ; le rôle `admin` est conservé ;
- état navigateur après classification : 1 Utilisateur (`steve`), 0 Agent, 1 identité restante `À classifier` (`home`).

## Gate actif

Validation finale lifecycle Security :

1. tenter uniquement la Preview de suppression de `steve` pour vérifier la protection de la dernière identité administrative ; aucun Commit ;
2. vérifier le message utilisateur de refus ;
3. reconnecter `viewer` et confirmer l'absence totale de contrôles Classifier / Modifier / Supprimer ;
4. une fois ces deux preuves acquises, fermer le gate navigateur lifecycle et ouvrir le prochain incrément.

NO VIEWER MUTATION.
NO DIRECT DELETE.
NO IDENTITY KEY RENAME.
NO ROLE MUTATION INSIDE IDENTITY UPDATE.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
