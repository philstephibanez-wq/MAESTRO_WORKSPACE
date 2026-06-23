# OPUS reborn - P4D wrapper move trajectory invalidated

Status: validated direction after user correction.

## Core correction

The user clarified a critical rule:

- No wrapper means non-existence of wrappers.
- Moving wrappers into another folder is still wrong.
- Wrappers must not be preserved, moved, or renamed as a solution.

## FSM-first contract

The mandatory OPUS rule is now:

- SANS FSM, PAS DE MOTEUR.
- SANS FSM, PAS DE PROJET OPUS VALIDE.

The FSM is the engine and must drive:

- boot;
- runtime;
- states;
- configurable transitions.

## OPUS spirit

OPUS remains ASAP: As Simple As Possible.

OPUS is a set of simple readable LEGO classes, not a black box.

## Runtime direction

The valid target is:

index.php -> autoload/bootstrap -> FSM boot -> application/site singleton -> router -> FSM validates transition -> controller/action -> view/template.

## Invalidated trajectory

The previous idea of relocating wrappers such as the following is invalid:

- Opus/Kernel/Acl.php
- Opus/Kernel/Fsm.php
- Opus/Kernel/I18n.php
- Opus/Kernel/Router.php

## Next step

The next OPUS implementation must inspect the real historical classes and reconnect runtime to the FSM-first boot path. Wrapper deletion can happen only after call sites are replaced with real classes.
