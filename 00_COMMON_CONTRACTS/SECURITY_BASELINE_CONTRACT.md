# SECURITY BASELINE CONTRACT

## 1. Portée et autorité

Ce contrat s'applique au framework OPUS, à toute application OPUS générée ou maintenue, et à OWASYS front/back. Il est obligatoire et s'ajoute aux contrats de développement, de livraison, de FSM, d'ACL, de SSO, de Logger et de Profiler.

Principe directeur : défense en profondeur, moindre privilège, deny-by-default, fail-closed, zéro confiance implicite. Une protection locale OWASYS ne remplace jamais une primitive générique OPUS lorsque la cause est framework.

Les contrôles sont alignés sur les pratiques OWASP ASVS / Cheat Sheets et les principes Zero Trust. La conformité est vérifiée par code, configuration, tests négatifs et preuves runtime ; aucune sécurité déclarative non exécutée n'est considérée suffisante.

## 2. NMI de sécurité et quarantaine persistante

Une violation de sécurité est une interruption non masquable de l'application :

`* --security_violation / NMI--> security_quarantine`

Règles impératives :

1. `security_quarantine` est un état de confinement, distinct d'une perte d'authentification, d'un login et d'une erreur technique.
2. L'entrée en quarantaine persiste un verrou durable avant toute reprise métier.
3. Le verrou survit au rechargement navigateur, au redémarrage PHP, serveur, processus, machine et application.
4. Au bootstrap, le verrou est vérifié avant l'initialisation ou le dispatch métier. Verrou actif, illisible, incohérent ou falsifié = refus fail-closed.
5. Tant que la quarantaine est active, aucun flux métier normal, REST métier, Composer métier, écriture source, Git, build, mutation de données ou changement de configuration n'est autorisé.
6. Seul un plan de management/recovery minimal explicitement autorisé reste disponible.
7. Aucune transition automatique ne lève la quarantaine.
8. Le déblocage est une action manuelle d'un administrateur explicitement autorisé, avec authentification renforcée/fraîche, ACL dédiée, justification, audit, Logger et Profiler.
9. Le déblocage passe par un état de récupération contrôlée (`security_recovery`) et par des contrôles d'intégrité avant retour à un état métier.
10. Une impossibilité de prouver l'intégrité maintient ou rétablit la quarantaine.
11. Le mécanisme de déblocage ne doit pas être exposé comme une action web métier ordinaire.
12. Le verrou de quarantaine et le journal d'incident sont des artefacts de sécurité : écriture atomique, permissions minimales, stockage runtime non versionné et mécanisme d'intégrité/tamper-evidence dès que la gestion de secret adaptée est disponible.

`auth_required`, expiration de session ou absence d'identité ne constituent pas à eux seuls une `security_violation` : ils suivent le FSM d'authentification normal. Une attaque détectée, une falsification, une violation ACL critique ou une compromission de frontière déclenche la NMI de sécurité.

## 3. Erreur critique distincte

Une erreur critique non qualifiée comme incident de sécurité suit un chemin séparé :

`* --critical_error / NMI--> fault`

`fault` ne lève jamais implicitement une quarantaine existante et ne doit pas être confondu avec `security_quarantine`. Une erreur critique peut être reclassée en incident de sécurité par une politique explicite.

## 4. Injections et données non fiables

Toute donnée externe est non fiable jusqu'à validation contextuelle.

Obligations :

- SQL/NoSQL/LDAP/XPath : requêtes paramétrées/préparées ; concaténation de données non fiables interdite ; identifiants dynamiques par allow-list.
- Commandes système/Composer : catalogue allow-listé, arguments typés/validés ; aucune construction shell par concaténation de données externes.
- XSS/HTML/JavaScript/CSS/URL : échappement par contexte par défaut ; sortie brute uniquement après classification explicite trusted/sanitized ; aucune interpolation directe de données non fiables dans du JavaScript.
- SCORE doit conserver l'échappement sécurisé par défaut ; toute primitive de rendu raw constitue une frontière de sécurité auditable.
- Path traversal/LFI/RFI : canonicalisation, racine autorisée, refus des sorties de racine, NUL, wrappers et chemins absolus non autorisés.
- SSRF : destinations sortantes allow-listées lorsque possible, filtrage des adresses interdites, revalidation DNS/redirections et délais/tailles bornés.
- Upload : taille/type/extension allow-listés, nom serveur, stockage hors webroot, exécution interdite, analyse complémentaire lorsque le risque le justifie.
- Mass assignment/parameter pollution : schémas de champs explicites ; champs inconnus rejetés.

## 5. HTTP, navigateur et API

Obligations minimales :

- CSRF sur toute mutation issue d'un navigateur ; jeton cryptographique et contrôle d'origine adapté.
- Cookies de session `Secure` en HTTPS, `HttpOnly`, `SameSite` adapté ; rotation d'identifiant après authentification ou élévation ; expiration et révocation.
- CSP restrictive ; `frame-ancestors` ; `X-Content-Type-Options: nosniff`; `Referrer-Policy`; `Permissions-Policy`; HSTS en production HTTPS.
- CORS fermé par défaut ; origines/méthodes/headers explicitement allow-listés ; pas de wildcard avec credentials.
- REST : méthode, Content-Type, taille, schéma, authentification, autorisation et fraîcheur/replay vérifiés avant métier.
- Nonces/replay stores obligatoirement bornés par rétention ; aucune croissance non bornée.
- Timeouts et limites de taille pour toutes les frontières réseau et processus.
- Réponses d'erreur publiques génériques avec `trace_id`; aucune stacktrace, requête SQL, secret, chemin sensible ou détail d'implémentation exposé.

## 6. Authentification, ACL et administration

- ACL serveur deny-by-default sur chaque ressource/opération ; masquer un bouton n'est jamais une autorisation.
- Principe du moindre privilège pour rôles, comptes système, base de données et opérations Composer.
- Actions administratives sensibles : authentification fraîche ; MFA/WebAuthn lorsque disponible ; audit systématique.
- Protection brute-force/credential-stuffing et rate limiting proportionné par identité, ressource et origine.
- Les comptes et sessions compromis doivent pouvoir être révoqués sans redémarrage applicatif.

## 7. Secrets et cryptographie

- Aucun secret dans Git, SCORE, JavaScript, logs, profiler ou réponse HTTP.
- Secrets runtime séparés par usage et environnement, avec rotation.
- CSPRNG obligatoire pour jetons/nonces/secrets.
- Aucun algorithme cryptographique maison.
- Mots de passe avec mécanisme PHP éprouvé et paramètres contemporains ; comparaison de secrets en temps constant lorsque applicable.
- Les secrets utilisés pour intégrité/HMAC ne doivent pas être stockés avec l'artefact qu'ils protègent.

## 8. Intégrité, journalisation et supply chain

- Fichiers/configurations critiques doivent pouvoir être contrôlés contre modification inattendue.
- Les événements sécurité sont journalisés : authentification, refus ACL sensibles, violation détectée, quarantaine, tentatives de récupération/déblocage, changement de rôles/secrets et contrôles d'intégrité.
- Logs et Profiler ne contiennent jamais mots de passe, tokens, cookies de session ou secrets.
- Dépendances verrouillées, minimales et auditées ; artefacts de livraison vérifiés par SHA-256 et provenance.
- Un échec de chargement d'une configuration de sécurité ne crée jamais de permission par défaut.

## 9. Séparation OWASYS

`owasys-front` reste une application SCORE ; `owasys-back` reste PHP/REST/Composer sans JavaScript. Les contrôles génériques sont fournis par OPUS puis consommés par les deux bastions. La séparation de serveurs ne crée aucune confiance implicite : chaque appel REST est authentifié et autorisé.

## 10. Tests et critères de conformité

Chaque évolution sécurité doit ajouter ou conserver des preuves adaptées :

- tests négatifs d'injection, XSS, CSRF, traversal, SSRF, ACL, authentification et replay selon la surface modifiée ;
- test de persistance de quarantaine après reconstruction du runtime ;
- test fail-closed sur verrou/configuration de sécurité invalide ;
- test qu'aucune route métier n'est exécutable pendant la quarantaine ;
- test qu'aucun déblocage automatique n'existe ;
- lint/analyse statique et audit de dépendances disponibles dans la recette du dépôt.

Une protection non testée à sa frontière n'est pas considérée clôturée.

## 11. Déploiement progressif

Le contrat est global mais son implémentation se fait par livrables bornés et auditables. Ordre recommandé :

1. primitive OPUS de quarantaine persistante fail-closed ;
2. enforcement bootstrap/runtime + NMI `security_violation` et état `security_quarantine` ;
3. recovery administrateur séparé et contrôle d'intégrité ;
4. frontières d'entrée/sortie et protections injection/XSS/CSRF/headers ;
5. anti-abus, SSRF/upload, intégrité renforcée et supply-chain ;
6. matrice complète de tests sécurité.

Aucune phase intermédiaire ne peut affaiblir les protections déjà en vigueur.
