# CURRENT HANDOFF — MAESTRO WORKSPACE

Date : 2026-07-31

## Lire

```text
README-FIRST.md
CONTEXT/SPECIFICATIONS/MAESTRO_OPUS_OWASYS_GLOBAL_DEVELOPMENT_RULES_2026-07-24.md
CONTEXT/PROJECTS/OPUS/OPUS_SITE_STANDARD_CONTRACT.md
CONTEXT/SPECIFICATIONS/OPUS_OWASYS_APPLICATION_CREATION_AND_RESOURCE_SECURITY_CONTRACT_2026-07-31.md
CONTEXT/AUDITS/OPUS_P117W_R45_GENERATION_AND_RESOURCE_SECURITY_AUDIT_2026-07-31.md
CONTEXT/HANDOFFS/MAESTRO_WORKSPACE_HANDOFF_OPUS_P117W_R45A1_ACL_DENY_PRIORITY_2026-07-31.md
CONTEXT/PROJECTS/OPUS_CURRENT_STATE.md
```

## Base et état acquis

- OPUS owner audité : `7dbceea`.
- R44C est poussé et son chemin transactionnel/rendu opaque est acquis.
- `test2` est un témoin temporaire déclaré `frontend`, pas une preuve fullstack.
- `test2` ne doit jamais être corrigé localement ; il sera régénéré après correction du générateur.
- Modes exacts : `frontend`, `backend`, `fullstack`.
- `fullstack` signifie frontend SCORE + backend REST dans le même site, même déploiement et même serveur par défaut, tout en restant client-serveur via REST.
- Aucun concept, profil, dossier ou runtime `shared`.

## Résultat de l'audit R45

Le générateur actuel n'est pas conforme :

- les trois profils reçoivent presque la même arborescence de présentation ;
- `backend` déclare à tort `presentation: true` et reçoit SCORE/www/assets ;
- `frontend` n'impose pas de backend cible ;
- `fullstack` ne génère pas de corrélation REST client-serveur ;
- rôles et permissions sont des listes globales non associées ;
- aucune ressource canonique, attribution SSO scopée ou ACL par action n'est générée ;
- le moteur ACL OPUS riche existe, mais le scaffold ne le câble pas ;
- le moteur utilise actuellement la dernière règle applicable au lieu de faire prévaloir tout deny ;
- `ConfigAclPolicy` contourne File + parser structuré.

## Livraison active — R45A1

R45A1 est livré sur la base `7dbceea` : priorité absolue du deny et lecture ACL via StructuredFileLoader. Action owner : appliquer, linter et prouver que `allow -> deny` comme `deny -> allow` refusent tous deux.

Après acceptation owner, GO R45A2 :

Compléter exclusivement les contrats et le moteur générique OPUS :

1. objets contractuels typés pour identité, rôle, permission, ressource, attribution scopée et règle ACL ;
2. priorité absolue du deny, indépendamment de l'ordre ;
3. refus explicite sur ressource/action inconnue ;
4. lecture File + Json/StructuredFileLoader ;
5. interfaces homonymes étendant les quatre marqueurs pour toute classe concrète ;
6. smokes génériques prouvant RBAC scopé, CRUD/actions métier, héritage déclaré et deny.

R45B scaffold profilé, R45C wizard et R45D espace Sécurité restent bloqués jusqu'à validation owner de R45A1 puis R45A2.

## Livraison

L'assistant ne pousse pas OPUS/OWASYS. R45A sera livré en ZIP différentiel de fichiers complets, fondé sur `7dbceea`.

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
NO FALLBACK SILENCIEUX.  
FRONTEND, BACKEND OU FULLSTACK — JAMAIS SHARED.
