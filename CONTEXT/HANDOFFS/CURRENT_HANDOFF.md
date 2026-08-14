# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-08-14

## Lecture obligatoire

1. `README-FIRST.md`
2. `CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md`
3. `CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md`
4. `CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md`
5. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A24_IDENTITY_LIFECYCLE_BACKEND_2026-08-13.md`
6. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A25_IDENTITY_LIFECYCLE_UI_2026-08-13.md`
7. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A25F_PRINCIPAL_COLUMN_CONSOLIDATION_2026-08-14.md`
8. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A27_ASSIGNMENT_REVOKE_UI_2026-08-14.md`
9. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A28_SECURITY_LOCALIZED_VIEW_ROUTES_2026-08-14.md`
10. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A28B_SECURITY_GRAPHICAL_PRIMARY_NAVIGATION_2026-08-14.md`
11. `CONTEXT/SPECIFICATIONS/OPUS_P117W_R45D2A29_FSM_DIAGRAM_SEMANTIC_CONFORMANCE_2026-08-14.md`
12. `CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md`

## Base OPUS publiée

`f61382ea8e8c2e590176e25ef98208a7ff8ceaee` — `opus_p117w_r45d2a28a_security_view_isolation_fragment_elimination`.

R45D2A28 et R45D2A28A sont publiés et validés navigateur.

R45D2A28B a été appliqué localement par l'owner et le premier retour navigateur est positif (« nettement mieux »), mais il n'est pas encore visible dans le HEAD GitHub publié au moment de ce handoff.

## Gates acquis — Security

- routes principales et sous-vues Security localisées ;
- français : `/sécurité/identités`, `/sécurité/rôles`, `/sécurité/permissions`, `/sécurité/attributions`, `/sécurité/ressources-et-acl` ;
- aucune query technique `?view=...` générée en navigation normale ;
- suppression du fragment historique `#ow-security-unclassified` ;
- une seule sous-vue métier rendue à la fois ;
- lifecycle Identités Preview/Commit ;
- assignment grant/revoke Preview/Commit ;
- protections dernière identité administrative et dernière attribution administrative ;
- UI mutation strictement sous `$canMutate`, viewer lecture seule ;
- zéro JavaScript Security pour le routage/navigation métier.

## Retour UX R45D2A28B

La navigation graphique Security est nettement améliorée. Le prochain alignement visuel devra utiliser le même vocabulaire rectangulaire que les diagrammes FSM OPUS, sans présenter la chaîne Security comme une machine à états.

L'audit du renderer FSM a toutefois révélé que le diagramme FSM lui-même n'est pas sémantiquement fidèle à une vraie machine à états :

- fusion de transitions distinctes partageant le même couple `from -> to` ;
- signaux concaténés ;
- actions détachées des transitions ;
- guards absents du diagramme ;
- pas de self-loop dédié ;
- wildcards OPUS insuffisamment représentés ;
- initial/final traités comme rectangles tagués ;
- placement des états selon l'ordre du tableau plutôt que la topologie.

Le `FsmProcessor` moderne supporte déjà correctement plusieurs signaux par state, guards/actions par transition, `__any__`, source globale `*` et `__default__`. Le défaut est donc dans la représentation graphique, pas dans le moteur de transition.

## Gate actif

R45D2A29 — FSM Diagram Semantic Conformance :

- correction générique `Opus/Fsm/Diagram.class.php` avant tout hack local OWASYS ;
- une arête graphique par transition réelle ;
- libellé `signal [guard] / effect` ;
- plusieurs transitions entrantes/sortantes par state ;
- transitions parallèles non fusionnées ;
- self-loops dédiés ;
- retours/cycles visibles ;
- initial marker dédié ;
- final marker dédié lorsque le contrat le déclare ;
- état courant seulement surligné ;
- `__any__`, source `*` et `__default__` explicitement représentés comme extensions OPUS ;
- layout déterministe dérivé de la topologie à partir de l'état initial ;
- compatibilité de l'API historique `OPUS_FSM_Diagram` ;
- ajout d'une entrée pour définition canonique `FsmProcessor` ;
- SVG serveur autonome, zéro GraphViz, zéro exec, zéro JavaScript.

Livrable : `opus_p117w_r45d2a29_fsm_diagram_semantic_conformance.zip`.
SHA-256 : `4c6676e316a591c0c5c006dc54112b51fc6fbf20dcb0d819c4fe26a88328f22c`.

Après validation R45D2A29, aligner le style de la chaîne Security sur les rectangles/connecteurs FSM sans copier la sémantique FSM.

NO VIEWER MUTATION.
NO JAVASCRIPT.
NO GRAPHVIZ.
NO EXEC.
NO PUSH OPUS/OWASYS BY ASSISTANT.
