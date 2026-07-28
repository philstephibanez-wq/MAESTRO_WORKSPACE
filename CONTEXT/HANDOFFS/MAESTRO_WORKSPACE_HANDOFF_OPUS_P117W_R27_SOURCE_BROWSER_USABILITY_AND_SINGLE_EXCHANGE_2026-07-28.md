# HANDOFF — OPUS P117W R27

Date : 2026-07-28

R27 agrandit les boutons de scripts, rend le fichier actif incontestable et
réduit chaque sélection de deux échanges REST/Composer à un seul échange
`source.browse`.

Le ZIP R27 est cumulatif pour :

```text
R25 : contrat total du layout SCORE
R26 : LANCER_OWASYS.cmd, LANCER_OWASYS_FRONT.cmd, LANCER_OWASYS_BACK.cmd
R27 : ergonomie du navigateur et opération source.browse
```

Base OPUS :

```text
544d512b79bac4ca7dab8ac103dd9ff2266593fd
```

Livrable :

```text
opus_p117w_r27_source_browser_usability_and_single_exchange.zip
b5d1624f5170b96a09f2866d3cbafd2fa4a6a86eba2f466d8cc8481069e234ce
12 fichiers
```

Lancement :

```text
composer opus:dev-server -- owasys-front
composer opus:dev-server -- owasys-back
```

Les options `host` et `port` ne sont pas requises.
