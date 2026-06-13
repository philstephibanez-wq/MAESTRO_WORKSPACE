# ASAP ACL

## Rôle

L’ACL ASAP est le moteur d’autorisation générique du framework.

Elle décide qui peut faire quoi sur quelle ressource, dans quel contexte.

## Contrat

ACL ne gère pas l’état global du site.
ACL ne route pas.
ACL ne rend pas.
ACL ne corrige pas une requête invalide.

## Concepts racines

- role
- resource
- privilege
- allow
- deny
- condition
- isAllowed
