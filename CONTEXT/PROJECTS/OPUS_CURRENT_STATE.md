# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-10.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : 76b25c1b2bace4598f3535101a46283fa52684f5
Commit : test
```

Le commit `76b25c1b...` ne touche que `sites/essai2/config/site.json` (`site_name: OPUS essai2 -> essai2`). Le dernier livrable framework/OWASYS publié est R45D2A11 sous `509904785c8d9d4b2e6deed7314e1e690c0ee211`.

## États acquis

- R45C3R1 : workflow OWASYS structuré acquis.
- R45D1 : workspace Sécurité réel acquis.
- R45D2A2 : provisioning local-password runtime acquis.
- R45D2A3 : observabilité login acquise.
- R45D2A6 : Profiler repliable validé owner.
- R45D2A7 : projection hiérarchique Profiler acquise.
- R45D2A8 : diagnostic local-password détaillé acquis.
- R45D2A9B : message utilisateur login I18n + PRG acquis.
- R45D2A10 : corrélation trace POST login à travers PRG acquise.
- R45D2A11 : reset administrateur local-password + alerte login standardisée acquis ; `essai2/steve` se connecte avec succès.

## Preuve owner courante

Dans OWASYS Sources/Git, le compte admin + développeur peut effectivement modifier puis enregistrer `sites/essai2/config/site.json`. Le commit owner `76b25c1b...` prouve la mutation effective.

Cependant l'UI affiche simultanément `source.read_only`.

## Cause courante

Dans `OwasysSourceController`, la décision ACL réelle est `$roleCanWrite`, mais `read_only` est calculé depuis `!$editable`, où `$editable` dépend aussi de `$selectedPresent`.

Au rendu initial sans sélection, l'UI annonce donc faussement une restriction de rôle. Le chargement AJAX de la sélection active ensuite l'éditeur selon `$roleCanWrite`, ce qui produit l'incohérence observée.

## Livrable actif — R45D2A12

```text
ZIP     : opus_p117w_r45d2a12_source_acl_ui_truth.zip
SHA-256 : 98dc1db93358d5d3b6e6d9c2fda564898a9bb8979109dc4d3d1a9e9298b04be3
BASE    : 76b25c1b2bace4598f3535101a46283fa52684f5
FILES   : 2
```

R45D2A12 aligne `source.read_only` sur la décision ACL `source/write` uniquement. Il ne modifie ni le backend write guard, ni les rôles, ni les permissions.

## Gate owner

1. appliquer R45D2A12 ;
2. lancer l'applicateur ;
3. lancer le smoke ;
4. lint + dump-autoload ;
5. tester OWASYS Sources/Git avec admin + développeur : aucun bandeau lecture seule ;
6. confirmer que l'enregistrement fonctionne encore ;
7. tester ensuite une identité sans `source/write` : vraie lecture seule + refus backend.

NO SITE-SPECIFIC PATCH.
NO ACL BYPASS.
NO ROLE MERGE.
NO SECRET.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
