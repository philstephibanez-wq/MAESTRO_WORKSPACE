# P112D4E — ASAP Legacy Collision Reconciliation

## Rôle

Réconcilier les domaines ASAP legacy exclus du batch P112D4D SAFE parce qu’ils
entraient en collision de casse sous Windows.

## Domaines réconciliés

| Domaine ASAP historique | Cible PHP 8 Windows-safe |
| --- | --- |
| `APPLICATION` | `ASAP\Application\ApplicationFacade` |
| `ASSET` | `ASAP\Asset\Asset` |
| `MODULE` | `ASAP\Module\Module` |
| `SECURITY` | `ASAP\Security\Security` |
| `URL` | `ASAP\Url\Url` |

## Règle

On ne crée pas de dossier `APPLICATION` à côté de `Application`, ni `URL` à côté
de `Url`. Sous Windows, ces chemins entrent en collision et peuvent casser
l’autoload/runtime.

## Contrat

- Portage fidèle d’abord.
- Collision de casse = réconciliation dans le namespace canonique existant.
- Zéro fallback silencieux.
- Pas de modification du kernel Application dans ce palier.
