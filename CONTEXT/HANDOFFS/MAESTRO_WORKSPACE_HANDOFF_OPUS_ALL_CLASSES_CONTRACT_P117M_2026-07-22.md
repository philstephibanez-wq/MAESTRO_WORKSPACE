# Handoff — OPUS toutes classes contractuelles P117M

Date : 2026-07-22

## Source relue

```text
Dépôt : philstephibanez-wq/OPUS
Branche : master
Commit : 1d5c0fadf12a0a8fb8f887b32025fc53b45ca2d8
Message : p117l
```

Le registre historique `tools/reports/p7a1c_contract_map.json` n'est plus une preuve de conformité globale : il couvre 71 classes concrètes d'un ancien état du framework et référence encore l'ancien domaine `Opus/Db` supprimé par P117L.

## Décision P117M

Toute classe concrète située sous `Opus/` doit directement implémenter une interface contractuelle homonyme du même namespace.

Exemple :

```php
final class Example implements ExampleInterface
{
}
```

L'interface homonyme doit directement étendre les quatre marqueurs standards :

```text
Opus\Framework\OpusFrameworkComponentInterface
Opus\Framework\OpusExceptionAwareInterface
Opus\Framework\OpusProfilerAwareInterface
Opus\Framework\OpusSelfDocumentingInterface
```

Les interfaces fonctionnelles existantes sont conservées. L'interface homonyme peut donc étendre à la fois les contrats fonctionnels et les quatre marqueurs transverses.

Les classes abstraites, interfaces, traits, enums et classes anonymes ne sont pas des classes concrètes et ne reçoivent pas automatiquement une interface homonyme.

## Mise en œuvre

Livrable local :

```text
opus_p117m_contractualize_all.zip
```

Contenu :

```text
tools/maintenance/opus_contractualize_all.php
tools/maintenance/APPLY_OPUS_CONTRACTS_P117M.cmd
```

Le moteur utilise `token_get_all()` et parcourt récursivement la tête locale complète de `Opus/`. Il ne dépend pas de la cartographie P7A1C obsolète.

Pipeline :

```text
scan de tous les PHP sous Opus/
  -> extraction namespace/classes/interfaces
  -> exclusion abstraites/anonymes
  -> recherche interface homonyme
  -> création si absente
  -> ajout des quatre marqueurs si incomplets
  -> ajout de l'interface homonyme dans implements
  -> écritures atomiques avec rollback en cas d'échec
  -> rescan complet
  -> audit final sans écart
  -> composer dump-autoload
  -> lint de tous les PHP sous Opus/
```

Le moteur prend en charge :

- classes PSR-4 modernes ;
- anciennes classes globales dans les fichiers `.class.php` ;
- plusieurs classes nommées dans un même fichier ;
- classes ayant déjà une ou plusieurs interfaces fonctionnelles ;
- interface homonyme existante dans un autre fichier ;
- création d'une interface homonyme absente dans le même répertoire que la classe.

Le moteur refuse explicitement :

- plusieurs namespaces dans un même fichier ;
- doublons d'interfaces dans un même namespace ;
- collisions avec un fichier d'interface ne déclarant pas le symbole attendu ;
- racine ne contenant pas les quatre marqueurs OPUS ;
- écart résiduel après application.

## Validation du livrable

Validation synthétique exécutée avec succès sur :

- classe finale sans interface ;
- classe avec interface fonctionnelle existante ;
- interface homonyme existante sans marqueurs ;
- classe abstraite exemptée ;
- deux classes globales dans un même fichier ;
- classe anonyme ignorée ;
- deuxième audit idempotent ;
- lint PHP de tous les fichiers générés.

Validation complémentaire exécutée sur le différentiel P117L ODBC :

```text
PHP_FILES=38
CONCRETE_CLASSES=16
INTERFACES_FOUND=22
FILES_TO_CREATE=0
FILES_TO_MODIFY=0
OPUS_COMPONENT_CONTRACT_AUDIT_OK
```

## Politique de livraison

Aucune écriture directe n'est effectuée dans `philstephibanez-wq/OPUS`.

Le ZIP ne contient ni Markdown, ni rapport, ni smoke applicatif, ni fichier à la racine. Les seuls scripts sont placés sous `tools/maintenance/`.

OWASYS n'est pas modifié par P117M. Ses contrats FSM + ACL + SSO, SCORE exclusif et i18n canonique restent inchangés.
