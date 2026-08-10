# OPUS CURRENT STATE

Dernière mise à jour : 2026-08-11.

## Dépôt canonique

```text
OPUS : philstephibanez-wq/OPUS
Branche : master
origin/master : 186517fd37c14047e33308500d0699b8ac36ab44
Commit : opus_p117w_r45d2a12_source_acl_ui_truth
```

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
- R45D2A11 : reset administrateur local-password acquis ; `essai2/steve` se connecte avec succès.
- R45D2A12 : UI Sources/Git alignée sur la décision ACL `source/write`, publiée sous `186517fd...`.

## Preuve owner courante

La capture OWASYS Sources/Git montre le fichier réel `application/login/templates/index.score` de `essai2` et son ancien bloc :

```score
<p role="alert">[[ i18n: auth.error ]]</p>
```

Le dépôt confirme :

- `SiteScaffoldPlan` génère toujours ce bloc legacy ;
- `sites/essai2/application/login/templates/index.score` le contient encore ;
- `sites/essai2/www/asset/css/default.css` ne contient pas de styles `opus-alert`.

## Cause courante

La standardisation visuelle annoncée avec R45D2A11 n'a pas été propagée dans le scaffold canonique ni vers les sites Composer déjà générés. R45D2A12 a ajouté une mise en forme LF au template `essai2`, ce qui impose une migration tolérant plusieurs représentations legacy connues plutôt qu'une ancre textuelle unique.

## Livrable actif — R45D2A13

```text
ZIP     : opus_p117w_r45d2a13_generated_login_alert_propagation.zip
SHA-256 : f66e6b4614f4326e8b9ba6e14ad698b6443607b253b0f21e9921ac079c96855c
BASE    : 186517fd37c14047e33308500d0699b8ac36ab44
FILES   : 2
```

R45D2A13 :

- remplace le `<p role="alert">` legacy du scaffold par un composant `opus-alert opus-alert-error` SCORE accessible ;
- ajoute le CSS canonique correspondant ;
- migre tous les sites `generated-opus-application` possédant un module login ;
- accepte les variantes legacy compacte/LF/CRLF ;
- smoke qu'aucun ancien `<p role="alert">` ne subsiste dans les sites contrôlés.

## Gate owner

1. appliquer R45D2A13 ;
2. lancer l'applicateur ;
3. lancer le smoke ;
4. lint `SiteScaffoldPlan.php` ;
5. dump-autoload ;
6. vérifier les local changes ;
7. tester `essai2` avec mauvais mot de passe : composant d'erreur standard OPUS, texte I18n non discriminant, Profiler inchangé.

NO SITE-SPECIFIC PATCH.
NO SSO/ACL RELAXATION.
NO SECRET.
NO BACKEND JAVASCRIPT.
NO PUSH OPUS/OWASYS BY ASSISTANT.
