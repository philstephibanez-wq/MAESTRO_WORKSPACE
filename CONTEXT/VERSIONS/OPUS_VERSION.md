# OPUS_VERSION

## Rôle

Ce fichier est la source de vérité documentaire pour l'identité et la version du framework PHP rattaché au workspace MAESTRO.

Le framework actif est **OPUS Framework**.

`ASAP` n'est plus le nom actif du framework. Il ne doit apparaître que dans un contexte explicitement historique, legacy ou migration contrôlée.

Aucune nouvelle documentation, recette, handoff, référence de version ou cible de développement ne doit présenter `ASAP` comme framework vivant.

## Identité officielle

- Nom actif : `OPUS`
- Nom long recommandé : `OPUS Framework`
- Nom court recommandé : `OPUS`
- Ancien nom historique : `ASAP`
- Statut de `ASAP` : legacy / historique uniquement
- Dépôt cible : `philstephibanez-wq/OPUS`
- Package Composer cible : `logandplay/opus`

## Version publique cible

- Version publique : `OPUS 8.1.0 "Lysenko"`
- Variante typographique acceptée : `OPUS Framework 8.1.0 "Lysenko"`
- Nom de release : `Lysenko`
- Référence culturelle : Mykola Lysenko, compositeur ukrainien
- Rôle du nom : nom de release/version du framework OPUS, pas nom d'application

Le préfixe `8.x` indique la génération/runtime PHP ciblée et la lignée OPUS actuelle. Il ne doit pas être confondu avec la maturité fonctionnelle complète du framework.

## Contrat d'usage dans MAESTRO_WORKSPACE

1. OPUS est le framework actif.
2. ASAP est un ancien nom historique et ne doit plus être traité comme entité active.
3. Les chemins, handoffs et docs nouveaux doivent utiliser `OPUS`, `OPUS_REF_BOOK`, `OPUS Framework` et `OPUS 8.1.0 "Lysenko"`.
4. Les mentions `ASAP` restantes doivent être justifiées par un contexte legacy/migration, jamais par usage courant.
5. Aucun fallback silencieux `ASAP -> OPUS` ou `OPUS -> ASAP` n'est autorisé.
6. Toute compatibilité transitoire éventuelle doit être explicitement nommée, testée, documentée et supprimable.
7. MAESTRO_WORKSPACE ne devient pas propriétaire du code framework OPUS ; il référence et coordonne les sources de vérité.
8. ScoreTemplate reste une application/recette consommatrice d'OPUS, pas le framework lui-même.
9. OPUS_REF_BOOK documente OPUS ; il ne doit pas exposer des classes ou namespaces legacy comme API vivantes.
10. Toute montée de version doit documenter : nom, release, version Composer, commit source, date, motif, impacts et tests.

## Migration legacy à surveiller

Les traces suivantes peuvent encore exister dans des dépôts, chemins ou historiques, mais elles doivent être considérées comme migration/legacy :

- ancien dépôt ou répertoire `ASAP`,
- ancien package `logandplay/asap`,
- anciens namespaces `ASAP\\`,
- anciens chemins `ASAP_REF_BOOK`,
- anciens handoffs mentionnant ASAP avant la décision OPUS.

Ces éléments ne sont pas des cibles actives. Ils doivent être renommés ou isolés progressivement, sans fallback silencieux et sans mélange entre framework OPUS et applications métier.

## Prochaine étape documentaire

Les prochains handoffs doivent reprendre cette formulation :

```text
Framework actif : OPUS Framework
Version cible : OPUS 8.1.0 "Lysenko"
ASAP : ancien nom historique, legacy uniquement
```
