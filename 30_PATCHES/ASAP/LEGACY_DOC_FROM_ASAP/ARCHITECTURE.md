# ASAP — Architecture

## Pipeline cible

REQUEST
-> SiteResolver
-> SiteState FSM Guard
-> ACL Guard
-> Router
-> Dispatcher
-> Controller
-> Service applicatif
-> ViewModel
-> Renderer

## Principe

Chaque couche est souveraine et précise.

FSM décide l’état.
ACL décide les droits.
Router résout la route.
Controller orchestre localement.
Renderer représente.
Template rend.
