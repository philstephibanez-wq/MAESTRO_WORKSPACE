# P114Q1Q3 ASAP Repository Hygiene + Architecture Audit

Cible locale : H:\ASAP

Ce lot applique uniquement :
- normalisation de .gitignore
- conservation de var/.gitkeep
- suppression de var/.gitignore vide/redondant
- audit architecture non destructif des fichiers suivis par Git

Aucune modification n'est faite dans H:\ASAP_REF_BOOK.

Les backups et rapports sont écrits sous :

H:\MAESTRO_WORKSPACE\patches\P114Q1Q3_ASAP_REPOSITORY_HYGIENE

Le runner refuse de démarrer si le worktree ASAP n'est pas propre.

Fichiers modifiés attendus :
- .gitignore
- var/.gitignore supprimé
- var/.gitkeep conservé ou créé

Commandes après application locale :

cd /d H:\ASAP
git status --short
git diff --stat
type H:\MAESTRO_WORKSPACE\patches\P114Q1Q3_ASAP_REPOSITORY_HYGIENE\P114Q1Q3_ASAP_REPOSITORY_HYGIENE_REPORT.txt
