# CHECK COMMANDS

## ASAP git state

```cmd
cd /d H:\ASAP
git status
git log --oneline -5
```

## ASAP global recipe

```cmd
cd /d H:\ASAP
tools\recipes\run_asap_global_regression_recipe.cmd
```

## Generated files must stay out of Git

```cmd
cd /d H:\ASAP
git status --ignored
```

Check manually that `var/refbook/` and `var/reports/` are not staged.
