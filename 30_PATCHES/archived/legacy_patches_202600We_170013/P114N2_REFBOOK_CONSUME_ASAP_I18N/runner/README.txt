P114N2_REFBOOK_CONSUME_ASAP_I18N_WORKSPACE_APPLY

Scope:
- Source modifications only:
  - H:\ASAP_REF_BOOK\application\reference\Controller\AbstractRefBookController.php
  - H:\ASAP_REF_BOOK\application\reference\Service\ReferenceRuntimeSnapshotRepository.php
- No patch/tool/report files are written inside H:\ASAP or H:\ASAP_REF_BOOK.
- Backups and reports go under:
  H:\MAESTRO_WORKSPACE\patches\P114N2_REFBOOK_CONSUME_ASAP_I18N

Validation:
- RefBook must consume ASAP shared I18N catalog through ASAP_ROOT=H:\ASAP.
- Test visible page:
  http://127.0.0.1/ASAP_REF_BOOK/?lang=es&theme=ocean&page=domain-fsm
