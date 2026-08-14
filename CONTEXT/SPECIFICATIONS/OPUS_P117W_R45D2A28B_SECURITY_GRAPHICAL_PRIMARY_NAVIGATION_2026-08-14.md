# OPUS P117W R45D2A28B — Security Graphical Primary Navigation

Date : 2026-08-14

## Base

OPUS publié : `f61382ea8e8c2e590176e25ef98208a7ff8ceaee` (`R45D2A28A`).

## Cause traitée

La page Security possède des routes localisées correctes, mais la navigation reste insuffisamment explicite et les sous-vues `Rôles`, `Permissions`, `Attributions` et `Ressources & ACL` sont rendues dans des `<details>` fermés. Un clic sur un maillon change donc la route sans présenter immédiatement le contenu attendu.

La chaîne fonctionnelle Security doit être visible et interactive :

`Utilisateur / Agent -> Identité -> Attribution -> Rôle -> Permission -> Ressource + Action -> décision ACL`.

## Contrat UX

1. `/sécurité` est une vraie vue d'ensemble graphique, sans formulaire métier implicite.
2. Une navigation graphique persistante représente la chaîne métier et expose explicitement :
   - Utilisateurs et agents / Identités ;
   - Attributions ;
   - Rôles ;
   - Permissions ;
   - Ressources & ACL.
3. Chaque maillon contient une icône, un libellé et un compteur contextuel.
4. Chaque maillon est un lien vers sa route publique localisée R45D2A28.
5. Le clic sur un maillon charge sa sous-vue puis la rubrique correspondante est rendue **ouverte** (`<details open>`) immédiatement sous le schéma.
6. Une seule rubrique métier détaillée est rendue à la fois ; les autres ne sont pas injectées dans la page.
7. Le maillon de la vue courante est visuellement marqué et porte `aria-current="page"`.
8. Un contrôle graphique `Vue d'ensemble` permet de revenir à `/sécurité` depuis toute sous-vue.
9. Les métriques Utilisateurs, Agents, Rôles et Ressources sont navigables vers leur rubrique correspondante ; `À classifier` navigue vers Identités sans fragment.
10. Aucune navigation normale ne génère `?view=...` ni fragment `#ow-security-unclassified`.
11. Le changement de langue conserve la vue courante et utilise la route localisée de la locale cible.
12. Les mutations et capacités existantes sont inchangées ; `viewer` reste strictement lecture seule.
13. SCORE + CSS + rendu serveur uniquement ; zéro JavaScript pour cette navigation.
14. Aucun changement REST, backend métier, ACL ou FSM.

## Règle d'ouverture

- `/fr-FR/sécurité` : vue d'ensemble, aucune rubrique métier ouverte.
- `/fr-FR/sécurité/identités` : rubrique Identités ouverte.
- `/fr-FR/sécurité/attributions` : rubrique Attributions ouverte.
- `/fr-FR/sécurité/rôles` : rubrique Rôles ouverte.
- `/fr-FR/sécurité/permissions` : rubrique Permissions ouverte.
- `/fr-FR/sécurité/ressources-et-acl` : rubrique Ressources & ACL ouverte.

L'ouverture est déterminée côté serveur par la route canonique. Elle ne dépend d'aucun état JavaScript ou fragment URL.

## Ergonomie graphique

- le schéma doit rester lisible comme une chaîne de dépendances et non comme une simple rangée de boutons ;
- flèches directionnelles entre maillons ;
- état actif contrasté ;
- hover/focus visibles ;
- responsive sans perte d'ordre métier ;
- le contenu détaillé ouvert doit apparaître immédiatement après le schéma et ne pas être visuellement confondu avec un panneau technique secondaire.

## Critères navigateur

- `/fr-FR/sécurité` affiche la vue d'ensemble et le schéma complet ;
- clic `Rôles` -> `/fr-FR/sécurité/rôles`, maillon Rôles actif, rubrique Rôles déjà dépliée ;
- clic `Attributions` -> `/fr-FR/sécurité/attributions`, maillon Attributions actif, rubrique Attributions déjà dépliée ;
- clic `Permissions` et `Ressources & ACL` : même comportement ;
- clic `Utilisateurs et agents` -> Identités ouverte ;
- `Vue d'ensemble` revient à `/fr-FR/sécurité` ;
- aucune autre rubrique détaillée n'est rendue simultanément ;
- aucun `?view=...` ni `#ow-security-unclassified` généré ;
- changement de langue depuis une sous-vue conserve cette sous-vue ;
- aucun contrôle de mutation supplémentaire pour `viewer`.

NO VIEWER MUTATION.
NO JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
