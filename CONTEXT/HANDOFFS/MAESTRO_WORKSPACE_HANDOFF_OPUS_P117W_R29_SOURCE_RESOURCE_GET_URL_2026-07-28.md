# HANDOFF — OPUS P117W R29

Date : 2026-07-28

R29 remplace le formulaire `POST /<locale>/source` utilisé pour ouvrir un
fichier par une ressource adressable :

```text
GET /<locale>/source/<chemin-relatif-encodé-par-segment>
```

Le même lien fonctionne sans JavaScript. Avec JavaScript, la représentation
JSON met à jour CodeMirror sans reconstruire l'arborescence et
`history.pushState` conserve l'URL du fichier ouvert.

La lecture physique reste protégée par la chaîne OWASYS obligatoire :

```text
owasys-front -> REST sécurisé -> owasys-back -> Composer
```

Base OPUS :

```text
9416cab744c12191e4d5153b50521befb573d41f
```

Livrable :

```text
opus_p117w_r29_source_resource_get_url.zip
52d1b3cc95038702c43924b204eb21df942635d392b61d47f01943d8c52d5fe3
4 fichiers
```

Commandes de lancement contractuelles :

```text
composer opus:dev-server -- owasys-back
composer opus:dev-server -- owasys-front
```
