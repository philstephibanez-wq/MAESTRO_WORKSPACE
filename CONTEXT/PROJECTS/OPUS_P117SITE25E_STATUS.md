# OPUS P117SITE25E - Boundary classification tuning

Status: DELIVERED

Purpose: refine the physical OPUS FRONT / MIDDLE / BACK / COMMON classification after P117SITE25D.

Required decisions now encoded:

- Breadcrumb, Form, and Menu are FRONT components.
- Fsm engine belongs to COMMON as the shared mandatory processor.
- MIDDLE owns FSM gates and orchestration, not the common FSM engine.
- Lstsa belongs to BACK because it processes and transforms data.
- COMMON remains strict shared language and shared processor only, never a catch-all.
- Mermaid UML and FSM transition documentation are mandatory.

Delivered OPUS commits:

- 1a5cf6702e571908d210f364d710f952077bba85 - P117SITE25E_ADD_BOUNDARY_CLASSIFICATION_TUNING_RUNNER
- 138e290f5e9f3e64024c89db703e7dcba8000fc0 - P117SITE25E_ADD_BOUNDARY_CLASSIFICATION_TUNING_SMOKE
- bbec857a2eab7d41b16b9b8db696b38c252546f9 - P117SITE25E_ADD_BOUNDARY_CLASSIFICATION_TUNING_DOC

Runtime commands:

cd /d H:\OPUS
git pull --ff-only
python tools\refactor_p117site25e_boundary_classification_tuning.py --write
python tools\smoke_p117site25e_boundary_classification_tuning.py
git status --short

Expected final marker:

P117SITE25E_BOUNDARY_CLASSIFICATION_TUNING_SMOKE_OK
