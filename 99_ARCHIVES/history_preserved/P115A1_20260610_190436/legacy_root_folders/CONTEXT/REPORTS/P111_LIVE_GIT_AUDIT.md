# P111_LIVE_GIT_AUDIT.md

Generated: `2026-06-04T23:34:04`
Workspace: `H:\MAESTRO_WORKSPACE`

## Contrat

- Audit non destructif.
- Aucun fichier source modifié.
- Aucun dépôt Git modifié.
- Aucun commit, add, checkout, reset ou clean.

## Politique active

- `MO_KB` et ses applications: **at home**, privé, non distribuable public.
- `MAESTRO` et futurs `VSTi`: **distribuables**.
- `UwAmp`: hôte web/runtime local, pas source front.
- `H:\MO_KB_FRONT`: source front candidate.

## MAESTRO_V5

- Chemin: `D:\REAPER_Roaming\REAPER\Scripts\MAESTRO_v5`
- Existe: `YES`
- Git: `YES`
- Racine Git: `D:\REAPER_Roaming\REAPER\Scripts\MAESTRO_v5`

### git branch

ExitCode: `0`

```text
master
```

### git status_short_branch

ExitCode: `0`

```text
## master...origin/master
```

### git remote_v

ExitCode: `0`

```text
origin	https://github.com/philstephibanez-wq/Maestro.git (fetch)
origin	https://github.com/philstephibanez-wq/Maestro.git (push)
```

### git log_head

ExitCode: `0`

```text
1deec4d (HEAD -> master, origin/master) mert suite
```

### git diff_stat

ExitCode: `0`

```text
(empty)
```

### git diff_name_status

ExitCode: `0`

```text
(empty)
```

### git diff_cached_stat

ExitCode: `0`

```text
(empty)
```

### git untracked

ExitCode: `0`

```text
(empty)
```

### Diff files

- Working tree diff: `H:\MAESTRO_WORKSPACE\CONTEXT\REPORTS\GIT_DIFFS\MAESTRO_V5_working_tree.diff` exit `0`
- Staged diff: `H:\MAESTRO_WORKSPACE\CONTEXT\REPORTS\GIT_DIFFS\MAESTRO_V5_staged.diff` exit `0`


## MO_KB_DAEMON

- Chemin: `H:\MO_KB_DAEMON`
- Existe: `YES`
- Git: `YES`
- Racine Git: `H:\MO_KB_DAEMON`

### git branch

ExitCode: `0`

```text
master
```

### git status_short_branch

ExitCode: `0`

```text
## master...origin/master
```

### git remote_v

ExitCode: `0`

```text
origin	https://github.com/philstephibanez-wq/Maestro_KB_Engine.git (fetch)
origin	https://github.com/philstephibanez-wq/Maestro_KB_Engine.git (push)
```

### git log_head

ExitCode: `0`

```text
06dfe9a (HEAD -> master, origin/master) P110B81 MO handoff root and coverage
```

### git diff_stat

ExitCode: `0`

```text
(empty)
```

### git diff_name_status

ExitCode: `0`

```text
(empty)
```

### git diff_cached_stat

ExitCode: `0`

```text
(empty)
```

### git untracked

ExitCode: `0`

```text
(empty)
```

### Diff files

- Working tree diff: `H:\MAESTRO_WORKSPACE\CONTEXT\REPORTS\GIT_DIFFS\MO_KB_DAEMON_working_tree.diff` exit `0`
- Staged diff: `H:\MAESTRO_WORKSPACE\CONTEXT\REPORTS\GIT_DIFFS\MO_KB_DAEMON_staged.diff` exit `0`


## MO_KB_FRONT

- Chemin: `H:\MO_KB_FRONT`
- Existe: `YES`
- Git: `YES`
- Racine Git: `H:\MO_KB_FRONT`

### git branch

ExitCode: `0`

```text
master
```

### git status_short_branch

ExitCode: `0`

```text
## master...origin/master
```

### git remote_v

ExitCode: `0`

```text
origin	https://github.com/philstephibanez-wq/Maestro_KB_Extranet.git (fetch)
origin	https://github.com/philstephibanez-wq/Maestro_KB_Extranet.git (push)
```

### git log_head

ExitCode: `0`

```text
3d7cba7 (HEAD -> master, origin/master) P110B81 MO front handoff root
```

### git diff_stat

ExitCode: `0`

```text
(empty)
```

### git diff_name_status

ExitCode: `0`

```text
(empty)
```

### git diff_cached_stat

ExitCode: `0`

```text
(empty)
```

### git untracked

ExitCode: `0`

```text
(empty)
```

### Diff files

- Working tree diff: `H:\MAESTRO_WORKSPACE\CONTEXT\REPORTS\GIT_DIFFS\MO_KB_FRONT_working_tree.diff` exit `0`
- Staged diff: `H:\MAESTRO_WORKSPACE\CONTEXT\REPORTS\GIT_DIFFS\MO_KB_FRONT_staged.diff` exit `0`


## UwAmp / Front link check

- UwAmp www: `H:\UwAmp\www`
- Existe: `YES`
- Front link attendu: `H:\UwAmp\www\MO_KB_FRONT`
- Existe: `YES`
- Résolution Python: `H:\MO_KB_FRONT\public`

### cmd /c dir /AL H:\UwAmp\www

ExitCode: `0`

```text
Le volume dans le lecteur H s'appelle Matestro_KB
 Le num�ro de s�rie du volume est 7876-CB81

 R�pertoire de H:\UwAmp\www

06/02/2026  23:08    <JUNCTION>     MO_KB_FRONT [H:\MO_KB_FRONT\public]
               0 fichier(s)                0 octets
               1 R�p(s)  3,988,295,471,104 octets libres
```

### fsutil reparsepoint query H:\UwAmp\www\MO_KB_FRONT

ExitCode: `0`

```text
Valeur de la balise d'analyse : 0xa0000003
Valeur de balise : Microsoft
Valeur de balise : Substitut de nom
Valeur de balise : Point de montage
D�calage nom substitut : 0
Longueur nom substitut : 50
D�calage nom affich� :     52
Longueur nom affich� :     42
Nom substitut :       \??\H:\MO_KB_FRONT\public
Nom affich� :            H:\MO_KB_FRONT\public

Analyser une nouvelle fois la longueur des donn�es�: 0x68      

Donn�es d'analyse :
0000:  00 00 32 00 34 00 2a 00  5c 00 3f 00 3f 00 5c 00  ..2.4.*.\.?.?.\.
0010:  48 00 3a 00 5c 00 4d 00  4f 00 5f 00 4b 00 42 00  H.:.\.M.O._.K.B.
0020:  5f 00 46 00 52 00 4f 00  4e 00 54 00 5c 00 70 00  _.F.R.O.N.T.\.p.
0030:  75 00 62 00 6c 00 69 00  63 00 00 00 48 00 3a 00  u.b.l.i.c...H.:.
0040:  5c 00 4d 00 4f 00 5f 00  4b 00 42 00 5f 00 46 00  \.M.O._.K.B._.F.
0050:  52 00 4f 00 4e 00 54 00  5c 00 70 00 75 00 62 00  R.O.N.T.\.p.u.b.
0060:  6c 00 69 00 63 00 00 00                           l.i.c...
```

## Décision attendue après lecture

Pour chaque secteur Git non clean, choisir explicitement :

1. commit propre,
2. rollback,
3. palier de stabilisation,
4. ou exclusion de la source de vérité.

