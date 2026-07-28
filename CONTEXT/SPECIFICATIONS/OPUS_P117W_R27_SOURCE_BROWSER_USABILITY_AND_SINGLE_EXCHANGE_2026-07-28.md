# OPUS P117W R27 — NAVIGATEUR DE SOURCES LISIBLE ET ÉCHANGE UNIQUE

Date : 2026-07-28  
Statut : spécification contractuelle et livrable différentiel à valider côté owner

## Source de vérité

```text
Dépôt OPUS : philstephibanez-wq/OPUS
Branche : master
Base exacte : 544d512b79bac4ca7dab8ac103dd9ff2266593fd
Racine owner : H:\OPUS
Pré-requis : R24 présent ; R25 et lanceurs R26 inclus au livrable R27
```

## Causes traitées

Les feuilles de l’arborescence R24 étaient des boutons trop compacts et leur
état courant utilisait presque la même couleur que le survol. En outre, chaque
sélection exécutait successivement `source.list` puis `source.read`, soit deux
échanges REST sécurisés et deux démarrages Composer.

R27 impose :

- une grande cible cliquable par fichier ;
- un fichier courant vert, encadré et marqué d’une coche ;
- un état de chargement orange immédiat ;
- l’ouverture automatique des dossiers parents du fichier courant ;
- une seule opération allow-listée `source.browse` par sélection ;
- aucune mise en cache silencieuse de l’arborescence ;
- le maintien du fallback formulaire POST et du rendu SCORE.

## Chaîne contractuelle

```text
owasys-front SCORE
-> POST source-read
-> REST sécurisé source.browse
-> owasys-back
-> Composer allow-listé owasys:source-browse
-> SiteSourceInspector list + read
-> ViewModel
-> SCORE
```

Les commandes `source.list` et `source.read` restent disponibles séparément.
`source.browse` agrège seulement leur exécution dans le même processus
Composer ; il ne contourne ni FSM, ni ACL, ni SSO, ni REST sécurisé.

## Livrable

```text
ZIP : opus_p117w_r27_source_browser_usability_and_single_exchange.zip
SHA-256 : b5d1624f5170b96a09f2866d3cbafd2fa4a6a86eba2f466d8cc8481069e234ce
Fichiers : 12
```

NO CONTRACT, NO PATCH.  
NO SOURCE OF TRUTH, NO PATCH.  
TOUJOURS TRAITER LA CAUSE.  
NO FALLBACK SILENCIEUX.  
NO DELIVERY ROOT POLLUTION.
