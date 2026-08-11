# OWASYS — matrice contractuelle des capacités par rôle

Date : 2026-08-11  
Statut : cible fonctionnelle obligatoire pour la suite OPUS / OWASYS

## Principe

La décision d'autorisation reste portée par ACL deny-by-default et par les permissions effectives. L'UI ne déduit jamais une capacité depuis `primary_role` seul. La hiérarchie de référence est `admin > developer > viewer`, sans fusion implicite de rôles ni bypass visuel.

## Matrice cible

| Page / action | admin | developer | viewer |
| --- | ---: | ---: | ---: |
| Applications : ouvrir | ✅ | ✅ | ✅ |
| Sélectionner une application | ✅ | ✅ | ✅ |
| Changer d'application | ✅ | ✅ | ✅ |
| Créer une application | ✅ | ✅ | ❌ bouton absent |
| Supprimer une application générée | ✅ | ✅ | ❌ bouton absent |
| Structure | ✅ | ✅ | ✅ lecture |
| Sources de données | ✅ | ✅ | ✅ lecture |
| Workflows | ✅ | ✅ | ✅ lecture |
| Sécurité | ✅ | ✅ | ✅ lecture |
| Sources et Git : ouvrir/lire fichiers | ✅ | ✅ | ✅ |
| Modifier une source | ✅ | ✅ | ❌ |
| Preview source | ✅ | ✅ | ❌ |
| Stage fichier | ✅ | ✅ | ❌ |
| Stage all | ✅ | ✅ | ❌ |
| Unstage | ✅ | ✅ | ❌ |
| Commit | ✅ | ✅ | ❌ |
| Restore | ✅ | ✅ | ❌ |
| Construction / validation | ✅ | ✅ | ✅ lecture |
| Compte : changer son mot de passe local | ✅ | ✅ | ✅ |
| Profiler | ✅ | ✅ | ❌ |

## Règles d'implémentation

1. Le backend reste l'autorité décisive ; tout bouton masqué côté UI doit correspondre à un refus réel côté backend.
2. `viewer` peut consulter les zones indiquées en lecture, mais aucune mutation associée ne doit être possible.
3. `admin` et `developer` conservent les capacités de mutation listées ci-dessus, sous réserve des gardes spécifiques de sécurité déjà contractuelles (CSRF, fresh-auth, confirmation, ETag/version, transaction, audit).
4. `Profiler` est inaccessible au viewer, y compris par URL directe.
5. Les contrôles SCORE utilisent des capacités ACL calculées, jamais `primary_role` comme source d'autorisation.
6. Toute évolution ultérieure doit ajouter un test de matrice couvrant au minimum les trois rôles et les refus attendus.
7. Aucun fallback silencieux : absence de permission ou capacité inconnue = refus explicite.
