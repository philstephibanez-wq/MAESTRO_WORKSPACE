# FRONT ASAP STRUCTURE AUDIT

Date: 2026-06-05 01:07:18

Objectif:
- Identifier la structure réelle de H:\MO_KB_FRONT.
- Vérifier ce qui est ASAP, Twig, Smarty, PHP direct ou hybride.
- Vérifier le lien UwAmp.
- Ne rien modifier.
- Préparer la remise en conformité avec la structure ASAP souhaitée.

Contrat:
- Aucun patch.
- Aucun fichier source modifié.
- Aucun nettoyage automatique.
- Aucun cache supprimé.

## Git status

```text
## master...origin/master
origin	https://github.com/philstephibanez-wq/Maestro_KB_Extranet.git (fetch)
origin	https://github.com/philstephibanez-wq/Maestro_KB_Extranet.git (push)
3d7cba7 (HEAD -> master, origin/master) P110B81 MO front handoff root

```

## UwAmp junction

```text
 Le volume dans le lecteur H s'appelle Matestro_KB
 Le numéro de série du volume est 7876-CB81

 Répertoire de H:\UwAmp\www

06/02/2026  23:08    <JUNCTION>     MO_KB_FRONT [H:\MO_KB_FRONT\public]
               0 fichier(s)                0 octets
               1 Rép(s)  3,988,293,406,720 octets libres


FullName : H:\UwAmp\www\MO_KB_FRONT
LinkType : Junction
Target   : {H:\MO_KB_FRONT\public}




```

## Racine front - dossiers niveau 1

```text

FullName                       
--------                       
H:\MO_KB_FRONT\.vscode         
H:\MO_KB_FRONT\app             
H:\MO_KB_FRONT\config          
H:\MO_KB_FRONT\DOC             
H:\MO_KB_FRONT\i18n            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP
H:\MO_KB_FRONT\public          
H:\MO_KB_FRONT\templates       
H:\MO_KB_FRONT\tools           
H:\MO_KB_FRONT\var             
H:\MO_KB_FRONT\vendor          



```

## Racine front - fichiers niveau 1

```text

FullName                    
--------                    
H:\MO_KB_FRONT\.gitignore   
H:\MO_KB_FRONT\bootstrap.php
H:\MO_KB_FRONT\composer.json
H:\MO_KB_FRONT\README.md    



```

## Arborescence utile limitée

```text

FullName                                                                                                                                       
--------                                                                                                                                       
H:\MO_KB_FRONT\.gitignore                                                                                                                      
H:\MO_KB_FRONT\.vscode\extensions.json                                                                                                         
H:\MO_KB_FRONT\.vscode\settings.json                                                                                                           
H:\MO_KB_FRONT\.vscode\tasks.json                                                                                                              
H:\MO_KB_FRONT\app\Engine\ApiClient.php                                                                                                        
H:\MO_KB_FRONT\app\Engine\AppKernel.php                                                                                                        
H:\MO_KB_FRONT\app\Engine\ConfigEngine.php                                                                                                     
H:\MO_KB_FRONT\app\Engine\FsmEngine.php                                                                                                        
H:\MO_KB_FRONT\app\Engine\I18nEngine.php                                                                                                       
H:\MO_KB_FRONT\app\Engine\ModuleRegistry.php                                                                                                   
H:\MO_KB_FRONT\app\Engine\NavigationEngine.php                                                                                                 
H:\MO_KB_FRONT\app\Engine\RouterEngine.php                                                                                                     
H:\MO_KB_FRONT\app\Engine\SecurityEngine.php                                                                                                   
H:\MO_KB_FRONT\app\Engine\TemplateEngine.php                                                                                                   
H:\MO_KB_FRONT\bootstrap.php                                                                                                                   
H:\MO_KB_FRONT\composer.json                                                                                                                   
H:\MO_KB_FRONT\config\config.php                                                                                                               
H:\MO_KB_FRONT\DOC\patches\P110B62_PRO_FRONT_TWIG_ENGINES_NO_SYMFONY\CHANGELOG.md                                                              
H:\MO_KB_FRONT\DOC\patches\P110B62_PRO_FRONT_TWIG_ENGINES_NO_SYMFONY\PATCH.md                                                                  
H:\MO_KB_FRONT\DOC\patches\P110B62_PRO_FRONT_TWIG_ENGINES_NO_SYMFONY\TODO.md                                                                   
H:\MO_KB_FRONT\DOC\patches\P110B63_PRO_FRONT_WIDGET_SYNC_API_STATUS_POLISH\CHANGELOG.md                                                        
H:\MO_KB_FRONT\DOC\patches\P110B63_PRO_FRONT_WIDGET_SYNC_API_STATUS_POLISH\PATCH.md                                                            
H:\MO_KB_FRONT\DOC\patches\P110B63_PRO_FRONT_WIDGET_SYNC_API_STATUS_POLISH\TODO.md                                                             
H:\MO_KB_FRONT\DOC\patches\P110B64_PRO_DAEMON_START_WIDGET_SYNC\CHANGELOG.md                                                                   
H:\MO_KB_FRONT\DOC\patches\P110B64_PRO_DAEMON_START_WIDGET_SYNC\PATCH.md                                                                       
H:\MO_KB_FRONT\DOC\patches\P110B64_PRO_DAEMON_START_WIDGET_SYNC\TODO.md                                                                        
H:\MO_KB_FRONT\DOC\patches\P110B66_PORT80_GATEWAY_ONLY_SLAVE_REWIRE\CHANGELOG.md                                                               
H:\MO_KB_FRONT\DOC\patches\P110B66_PORT80_GATEWAY_ONLY_SLAVE_REWIRE\PATCH.md                                                                   
H:\MO_KB_FRONT\DOC\patches\P110B66_PORT80_GATEWAY_ONLY_SLAVE_REWIRE\TODO.md                                                                    
H:\MO_KB_FRONT\DOC\patches\P110B71_BACKOFFICE_HANDOFF_VISIBLE\CHANGELOG.md                                                                     
H:\MO_KB_FRONT\DOC\patches\P110B71_BACKOFFICE_HANDOFF_VISIBLE\CLEAR_FRONT_CACHE_P110B71.ps1                                                    
H:\MO_KB_FRONT\DOC\patches\P110B71_BACKOFFICE_HANDOFF_VISIBLE\PATCH.md                                                                         
H:\MO_KB_FRONT\DOC\patches\P110B71_BACKOFFICE_HANDOFF_VISIBLE\TODO.md                                                                          
H:\MO_KB_FRONT\DOC\patches\P110B72_BACKOFFICE_HANDOFF_LIVE_ROUTE\CHANGELOG.md                                                                  
H:\MO_KB_FRONT\DOC\patches\P110B72_BACKOFFICE_HANDOFF_LIVE_ROUTE\CLEAR_FRONT_CACHE_P110B72.ps1                                                 
H:\MO_KB_FRONT\DOC\patches\P110B72_BACKOFFICE_HANDOFF_LIVE_ROUTE\INSTALL.md                                                                    
H:\MO_KB_FRONT\DOC\patches\P110B72_BACKOFFICE_HANDOFF_LIVE_ROUTE\PATCH.md                                                                      
H:\MO_KB_FRONT\DOC\patches\P110B72_BACKOFFICE_HANDOFF_LIVE_ROUTE\TODO.md                                                                       
H:\MO_KB_FRONT\DOC\patches\P110B73_BACKOFFICE_HANDOFF_TO_BACKUPS\CHANGELOG.md                                                                  
H:\MO_KB_FRONT\DOC\patches\P110B73_BACKOFFICE_HANDOFF_TO_BACKUPS\CLEAR_AND_VERIFY_P110B73.ps1                                                  
H:\MO_KB_FRONT\DOC\patches\P110B73_BACKOFFICE_HANDOFF_TO_BACKUPS\PATCH.md                                                                      
H:\MO_KB_FRONT\DOC\patches\P110B73_BACKOFFICE_HANDOFF_TO_BACKUPS\TODO.md                                                                       
H:\MO_KB_FRONT\DOC\patches\P110B74_HANDOFF_VISIBLE_FEEDBACK\CHANGELOG.md                                                                       
H:\MO_KB_FRONT\DOC\patches\P110B74_HANDOFF_VISIBLE_FEEDBACK\CLEAR_AND_VERIFY_P110B74.ps1                                                       
H:\MO_KB_FRONT\DOC\patches\P110B74_HANDOFF_VISIBLE_FEEDBACK\PATCH.md                                                                           
H:\MO_KB_FRONT\DOC\patches\P110B74_HANDOFF_VISIBLE_FEEDBACK\TODO.md                                                                            
H:\MO_KB_FRONT\DOC\patches\P110B76_HANDOFF_CURRENT_ONLY_CLEANUP\CHANGELOG.md                                                                   
H:\MO_KB_FRONT\DOC\patches\P110B76_HANDOFF_CURRENT_ONLY_CLEANUP\CLEAR_AND_VERIFY_P110B76.ps1                                                   
H:\MO_KB_FRONT\DOC\patches\P110B76_HANDOFF_CURRENT_ONLY_CLEANUP\PATCH.md                                                                       
H:\MO_KB_FRONT\DOC\patches\P110B76_HANDOFF_CURRENT_ONLY_CLEANUP\TODO.md                                                                        
H:\MO_KB_FRONT\DOC\patches\P110B77_HANDOFF_CONFIRMATION_JS_FIX\CHANGELOG.md                                                                    
H:\MO_KB_FRONT\DOC\patches\P110B77_HANDOFF_CONFIRMATION_JS_FIX\CLEAR_AND_VERIFY_P110B77.ps1                                                    
H:\MO_KB_FRONT\DOC\patches\P110B77_HANDOFF_CONFIRMATION_JS_FIX\PATCH.md                                                                        
H:\MO_KB_FRONT\DOC\patches\P110B77_HANDOFF_CONFIRMATION_JS_FIX\TODO.md                                                                         
H:\MO_KB_FRONT\DOC\patches\P110B78_HANDOFF_VERIFY_SCRIPT_FIX\CHANGELOG.md                                                                      
H:\MO_KB_FRONT\DOC\patches\P110B78_HANDOFF_VERIFY_SCRIPT_FIX\CLEAR_AND_VERIFY_P110B78.ps1                                                      
H:\MO_KB_FRONT\DOC\patches\P110B78_HANDOFF_VERIFY_SCRIPT_FIX\PATCH.md                                                                          
H:\MO_KB_FRONT\DOC\patches\P110B78_HANDOFF_VERIFY_SCRIPT_FIX\TODO.md                                                                           
H:\MO_KB_FRONT\DOC\patches\P110B79_HANDOFF_INLINE_CONFIRMATION\CHANGELOG.md                                                                    
H:\MO_KB_FRONT\DOC\patches\P110B79_HANDOFF_INLINE_CONFIRMATION\CLEAR_AND_VERIFY_P110B79.ps1                                                    
H:\MO_KB_FRONT\DOC\patches\P110B79_HANDOFF_INLINE_CONFIRMATION\PATCH.md                                                                        
H:\MO_KB_FRONT\DOC\patches\P110B79_HANDOFF_INLINE_CONFIRMATION\TODO.md                                                                         
H:\MO_KB_FRONT\DOC\patches\P110B80_HANDOFF_SEPARATE_TAB\CHANGELOG.md                                                                           
H:\MO_KB_FRONT\DOC\patches\P110B80_HANDOFF_SEPARATE_TAB\CLEAR_AND_VERIFY_P110B80.ps1                                                           
H:\MO_KB_FRONT\DOC\patches\P110B80_HANDOFF_SEPARATE_TAB\PATCH.md                                                                               
H:\MO_KB_FRONT\DOC\patches\P110B80_HANDOFF_SEPARATE_TAB\TODO.md                                                                                
H:\MO_KB_FRONT\DOC\patches\P110B81_MO_HANDOFF_ROOT_AND_COVERAGE\CHANGELOG.md                                                                   
H:\MO_KB_FRONT\DOC\patches\P110B81_MO_HANDOFF_ROOT_AND_COVERAGE\CLEAR_AND_VERIFY_P110B81.ps1                                                   
H:\MO_KB_FRONT\DOC\patches\P110B81_MO_HANDOFF_ROOT_AND_COVERAGE\PATCH.md                                                                       
H:\MO_KB_FRONT\DOC\patches\P110B81_MO_HANDOFF_ROOT_AND_COVERAGE\TODO.md                                                                        
H:\MO_KB_FRONT\i18n\en.php                                                                                                                     
H:\MO_KB_FRONT\i18n\es.php                                                                                                                     
H:\MO_KB_FRONT\i18n\fr.php                                                                                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\.htaccess                                                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\api\proxy.php                                                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml                                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\maintenance.off                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\Index_controller.class.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\local\en\I18n.xml                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\local\es\I18n.xml                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\local\fr\I18n.xml                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\local\FR-fr\I18n.xml                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\templates\layout.tpl                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\templates\layout.twig                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\views\Mokb_view.class.php                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\ecoute\Index_controller.class.php                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\ecoute\javascript\index.js                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\ecoute\local\en\index.xml                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\ecoute\local\es\index.xml                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\ecoute\local\fr\index.xml                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\ecoute\templates\page.tpl                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\ecoute\templates\page.twig                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\k2000\Index_controller.class.php                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\k2000\javascript\index.js                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\k2000\local\en\index.xml                                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\k2000\local\es\index.xml                                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\k2000\local\fr\index.xml                                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\k2000\templates\page.tpl                                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\k2000\templates\page.twig                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\matiere\Index_controller.class.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\matiere\javascript\index.js                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\matiere\local\en\index.xml                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\matiere\local\es\index.xml                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\matiere\local\fr\index.xml                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\matiere\templates\page.tpl                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\matiere\templates\page.twig                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\musicien\Index_controller.class.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\musicien\javascript\index.js                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\musicien\local\en\index.xml                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\musicien\local\es\index.xml                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\musicien\local\fr\index.xml                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\musicien\templates\page.tpl                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\musicien\templates\page.twig                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\security\Index_controller.class.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\security\javascript\index.js                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\security\local\en\index.xml                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\security\local\es\index.xml                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\security\local\fr\index.xml                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\security\templates\page.tpl                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\security\templates\page.twig                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\technique\Index_controller.class.php                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\technique\javascript\index.js                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\technique\local\en\index.xml                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\technique\local\es\index.xml                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\technique\local\fr\index.xml                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\technique\templates\page.tpl                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\technique\templates\page.twig                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\assets\js\common.js                                                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\composer.json                                                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\composer.lock                                                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\config\api.php                                                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59C_ASAP_MODULES_SMARTY_I18N\CHANGELOG.md                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59C_ASAP_MODULES_SMARTY_I18N\PATCH.md                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59C_ASAP_MODULES_SMARTY_I18N\TODO.md                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59D_ASAP_SITE_ROUTES_FIX\CHANGELOG.md                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59D_ASAP_SITE_ROUTES_FIX\PATCH.md                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59D_ASAP_SITE_ROUTES_FIX\TODO.md                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59E_ASAP_MODULE_DISPATCH_FIX\CHANGELOG.md                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59E_ASAP_MODULE_DISPATCH_FIX\PATCH.md                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59E_ASAP_MODULE_DISPATCH_FIX\TODO.md                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59F_ASAP_MODULE_CONTROLLER_RESOLVE_FIX\CHANGELOG.md                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59F_ASAP_MODULE_CONTROLLER_RESOLVE_FIX\PATCH.md                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59F_ASAP_MODULE_CONTROLLER_RESOLVE_FIX\TODO.md                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59G_SMARTY_STRING_RESOURCE_FIX\CHANGELOG.md                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59G_SMARTY_STRING_RESOURCE_FIX\PATCH.md                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59G_SMARTY_STRING_RESOURCE_FIX\TODO.md                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59H_ASAP_COMPOSER_TWIG_FULL_UPDATE\CHANGELOG.md                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59H_ASAP_COMPOSER_TWIG_FULL_UPDATE\DEPENDENCY_UPGRADE_MANIFEST.json                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59H_ASAP_COMPOSER_TWIG_FULL_UPDATE\PATCH.md                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59H_ASAP_COMPOSER_TWIG_FULL_UPDATE\TODO.md                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59I_NO_SYMFONY_DIRECT_REQUIRE\CHANGELOG.md                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59I_NO_SYMFONY_DIRECT_REQUIRE\PATCH.md                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59I_NO_SYMFONY_DIRECT_REQUIRE\TODO.md                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\ACL\ASAP_Acl.class.php                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\ACL\ASAP_Acl_conditions.php                                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\ACL\ASAP_Acl_Resource.class.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\ACL\ASAP_Acl_Role.class.php                                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\ACL\ASAP_Roles.class.php                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\Application.class.php                                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\BDD\adodb5.class.php                                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\BDD\Database.class.php                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\BDD\Mysql.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\bootstrap.php                                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\ConfigLoader.class.php                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\Configuration.class.php                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\CONTROLLER\Controller.class.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\Debug.class.php                                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\Exception.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\FSM\Diagram.class.php                                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\FSM\Fsm.class.php                                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\FSM\GraphViz.class.php                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\FTP\Ftp.class.php                                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\HELPER\Helper.class.php                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\I18N\I18n.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\LINK\Link.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\MAIL\Mail.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\MAIL\PhpMailer.class.php                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\MENU\Menu.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\MODEL\Model.class.php                                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\REST\Rest.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\Router.class.php                                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\SimpleXMLElementExtended.class.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\Singleton.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\SITE\Site.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\SITE\SiteResolver.class.php                                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\SMTP\Smtp.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\TEMPLATE\Adapter.class.php                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\TEMPLATE\Smarty.class.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\TEMPLATE\Twig.class.php                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\TEMPLATE\X64.class.php                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\URL\Url.class.php                                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\Validator.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\VIEW\Html.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\autoloader.class.php                                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\autoloader_new2.class.php                                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb.inc.php                                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-active-record.inc.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-active-recordx.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-csvlib.inc.php                                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-datadict.inc.php                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-error.inc.php                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-errorhandler.inc.php                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-errorpear.inc.php                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-exceptions.inc.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-iterator.inc.php                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-lib.inc.php                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-memcache.lib.inc.php                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-pager.inc.php                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-pear.inc.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-perf.inc.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-php4.inc.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-time.inc.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-xmlschema.inc.php                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-xmlschema03.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\contrib\toxmlrpc.inc.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\cute_icons_for_site\adodb.gif                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\cute_icons_for_site\adodb2.gif                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-access.inc.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-db2.inc.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-firebird.inc.php                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-generic.inc.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-ibase.inc.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-informix.inc.php                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-mssql.inc.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-mssqlnative.inc.php                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-mysql.inc.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-oci8.inc.php                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-postgres.inc.php                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-sapdb.inc.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-sqlite.inc.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-sybase.inc.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\docs\ADOdb.Manual.chm                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\docs\docs-active-record.htm                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\docs\docs-adodb.htm                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\docs\docs-datadict.htm                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\docs\docs-oracle.htm                                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\docs\docs-perf.htm                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\docs\docs-session.htm                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\docs\docs-session.old.htm                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\docs\old-changelog.htm                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\docs\readme.htm                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\docs\tips_portable_sql.htm                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\docs\tute.htm                                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-access.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-ado.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-ado_access.inc.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-ado_mssql.inc.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-ado5.inc.php                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-ads.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-borland_ibase.inc.php                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-csv.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-db2.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-db2oci.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-db2ora.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-fbsql.inc.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-firebird.inc.php                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-ibase.inc.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-informix.inc.php                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-informix72.inc.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-ldap.inc.php                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-mssql.inc.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-mssql_n.inc.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-mssqlnative.inc.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-mssqlpo.inc.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-mysql.inc.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-mysqli.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-mysqlpo.inc.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-mysqlt.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-netezza.inc.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-oci8.inc.php                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-oci805.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-oci8po.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-odbc.inc.php                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-odbc_db2.inc.php                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-odbc_mssql.inc.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-odbc_oracle.inc.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-odbtp.inc.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-odbtp_unicode.inc.php                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-oracle.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-pdo.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-pdo_mssql.inc.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-pdo_mysql.inc.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-pdo_oci.inc.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-pdo_pgsql.inc.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-pdo_sqlite.inc.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-postgres.inc.php                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-postgres64.inc.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-postgres7.inc.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-postgres8.inc.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-proxy.inc.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-sapdb.inc.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-sqlanywhere.inc.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-sqlite.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-sqlite3.inc.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-sqlitepo.inc.php                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-sybase.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-sybase_ase.inc.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-vfp.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb_th.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-ar.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-bg.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-bgutf8.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-ca.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-cn.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-cz.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-da.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-de.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-en.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-es.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-esperanto.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-fa.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-fr.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-hu.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-it.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-nl.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-pl.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-pt-br.inc.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-ro.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-ru1251.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-sv.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-uk1251.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\license.txt                                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\pear\Auth\Container\ADOdb.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\pear\readme.Auth.txt                                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\perf\perf-db2.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\perf\perf-informix.inc.php                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\perf\perf-mssql.inc.php                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\perf\perf-mssqlnative.inc.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\perf\perf-mysql.inc.php                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\perf\perf-oci8.inc.php                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\perf\perf-postgres.inc.php                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\pivottable.inc.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\readme.txt                                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\rsfilter.inc.php                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\server.php                                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-compress-bzip2.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-compress-gzip.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-cryptsession.php                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-cryptsession2.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-encrypt-mcrypt.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-encrypt-md5.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-encrypt-secret.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-encrypt-sha1.php                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-sess.txt                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-session.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-session2.php                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-session-clob.php                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-session-clob2.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-sessions.mysql.sql                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-sessions.oracle.clob.sql                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-sessions.oracle.sql                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\crypt.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\old\adodb-cryptsession.php                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\old\adodb-session.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\old\adodb-session-clob.php                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\old\crypt.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\session_schema.xml                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\session_schema2.xml                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\benchmark.php                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\client.php                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\pdo.php                                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test.php                                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test_rs_array.php                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test2.php                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test3.php                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test4.php                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test5.php                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test-active-record.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test-active-recs2.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test-active-relations.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test-active-relationsx.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\testcache.php                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\testdatabases.inc.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test-datadict.php                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\testgenid.php                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\testmssql.php                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\testmssql.php.new                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\testoci8.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\testoci8cursor.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\testpaging.php                                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\testpear.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test-perf.php                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test-pgblob.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test-php5.php                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\testsessions.php                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test-xmlschema.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\time.php                                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\tmssql.php                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\xmlschema.xml                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\xmlschema-mssql.xml                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\toexport.inc.php                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tohtml.inc.php                                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\xmlschema.dtd                                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\xmlschema03.dtd                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\xsl\convert-0.1-0.2.xsl                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\xsl\convert-0.1-0.3.xsl                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\xsl\convert-0.2-0.1.xsl                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\xsl\convert-0.2-0.3.xsl                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\xsl\remove-0.2.xsl                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\xsl\remove-0.3.xsl                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\changelog.txt                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\class.phpmailer.php                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\class.pop3.php                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\class.smtp.php                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs.ini                                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\Callback_function_notes.txt                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\DomainKeys_notes.txt                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\extending.html                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\faq.html                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\Note_for_SMTP_debugging.txt                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\classes.svg                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\classes\PHPMailer.html                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\classes\phpmailerException.html                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\classes\POP3.html                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\classes\SMTP.html                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\css\bootstrap.css                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\css\bootstrap.min.css                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\css\bootstrap-responsive.css                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\css\bootstrap-responsive.min.css                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\css\jquery.iviewer.css                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\css\prettify.css                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\css\template.css                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\deprecated.html                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\errors.html                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\graph_class.html                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\apple-touch-icon.png                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\apple-touch-icon-114x114.png                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\apple-touch-icon-72x72.png                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\favicon.ico                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\glyphicons-halflings.png                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\glyphicons-halflings-white.png                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\arrow_down.png                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\arrow_right.png                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\class.png                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\constant.png                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\favicon.ico                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\file.gif                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\file-php.png                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\folder.gif                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\function.png                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\icon_template.svg                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\icon-folder-open-big.png                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\icon-th-big.png                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\interface.png                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\method.png                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\ok.png                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\property.png                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\search.gif                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\variable.png                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\view_source.png                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\visibility_private.png                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\visibility_protected.png                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\visibility_public.png                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\iviewer\grab.cur                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\iviewer\hand.cur                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\iviewer\iviewer.rotate_left.png                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\iviewer\iviewer.rotate_right.png                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\iviewer\iviewer.zoom_fit.png                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\iviewer\iviewer.zoom_fit2.gif                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\iviewer\iviewer.zoom_in.png                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\iviewer\iviewer.zoom_in2.gif                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\iviewer\iviewer.zoom_out.png                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\iviewer\iviewer.zoom_out2.gif                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\iviewer\iviewer.zoom_zero.png                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\iviewer\iviewer.zoom_zero2.gif                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\loader.gif                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\index.html                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\bootstrap.js                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\bootstrap.min.js                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery.cookie.js                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery.iviewer.js                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery.iviewer.min.js                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery.mousewheel.min.js                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery.panzoom.js                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery.splitter.js                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery.tools.min.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery.treeview.js                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery-1.4.2.min.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery-1.7.1.min.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery-ui-1.8.2.custom.min.js                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\menu.js                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-apollo.js                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-clj.js                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-css.js                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-go.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-hs.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-lisp.js                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-lua.js                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-ml.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-n.js                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-proto.js                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-scala.js                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-sql.js                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-tex.js                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-vb.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-vhdl.js                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-wiki.js                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-xq.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-yaml.js                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\prettify.min.js                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\sidebar.js                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\SVGPan.js                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\template.js                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\markers.html                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\namespaces\global.html                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\packages\PHPMailer.html                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\structure.xml                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\pop3_article.txt                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\use_gmail.txt                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\contents.html                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\images\phpmailer.gif                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\images\phpmailer_mini.gif                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\index.html                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_db_smtp_basic.php                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_mail_advanced.php                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_mail_basic.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_pop_before_smtp_advanced.php                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_pop_before_smtp_basic.php                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_sendmail_advanced.php                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_sendmail_basic.php                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_smtp_advanced.php                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_smtp_advanced_no_auth.php                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_smtp_basic.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_smtp_basic_no_auth.php                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_smtp_gmail_advanced.php                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_smtp_gmail_basic.php                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\extras\class.html2text.inc                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\extras\htmlfilter.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\extras\ntlm_sasl_client.php                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-ar.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-br.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-ca.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-ch.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-cz.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-de.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-dk.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-es.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-et.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-fi.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-fo.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-fr.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-hu.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-it.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-ja.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-nl.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-no.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-pl.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-ro.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-ru.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-se.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-tr.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-zh.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-zh_cn.php                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\LICENSE                                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\README                                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test\contents.html                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test\phpmailerTest.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test\test.png                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test\test_callback.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test\testemail.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\contents.html                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\images\aikido.gif                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\images\bkgrnd.gif                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\images\phpmailer.gif                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\index.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\LGPLv3.txt                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\clipboard.swf                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushBash.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushCpp.js                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushCSharp.js                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushCss.js                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushDelphi.js                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushDiff.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushGroovy.js                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushJava.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushJScript.js                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushPerl.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushPhp.js                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushPlain.js                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushPython.js                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushRuby.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushScala.js                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushSql.js                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushVb.js                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushXml.js                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shCore.js                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shLegacy.js                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\src\shCore.js                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\src\shLegacy.js                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\styles\help.png                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\styles\magnifier.png                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\styles\page_white_code.png                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\styles\page_white_copy.png                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\styles\printer.png                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\styles\shCore.css                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\styles\shThemeDefault.css                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\styles\shThemeDjango.css                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\styles\shThemeEmacs.css                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\styles\shThemeFadeToGrey.css                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\styles\shThemeMidnight.css                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\styles\shThemeRDark.css                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\styles\wrapping.png                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\test.html                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\COPYING.lib                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\cache\749422d4cfc3eb5677cf499730392b6accd4d1c7.index.tpl.php                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\configs\test.conf                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\index.php                                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\index_php_template.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates\footer.tpl                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates\header.tpl                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates\index.tpl                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates\index_view.php                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates_c\0013c647e9502d41f43f2055ab8406140c2510c6.test.conf.config.php     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates_c\10e0737838b4a574ef135d0c601e7b602cfaf37a.file.header.tpl.cache.php
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates_c\1be7ff7fdee636597edd726ee98dfef4bfd55d1f.file.footer.tpl.cache.php
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates_c\59399816f5ba59b26c7204ef6ebb1bb339774ca6.file.debug.tpl.php       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates_c\749422d4cfc3eb5677cf499730392b6accd4d1c7.file.index.tpl.cache.php 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\debug.tpl                                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\block.php.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\block.textformat.php                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.counter.php                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.cycle.php                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.fetch.php                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.html_checkboxes.php                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.html_image.php                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.html_options.php                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.html_radios.php                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.html_select_date.php                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.html_select_time.php                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.html_table.php                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.mailto.php                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.math.php                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifier.capitalize.php                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifier.date_format.php                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifier.debug_print_var.php                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifier.escape.php                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifier.regex_replace.php                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifier.replace.php                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifier.spacify.php                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifier.truncate.php                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.cat.php                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.count_characters.php                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.count_paragraphs.php                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.count_sentences.php                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.count_words.php                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.default.php                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.indent.php                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.lower.php                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.noprint.php                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.string_format.php                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.strip.php                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.strip_tags.php                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.upper.php                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.wordwrap.php                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\outputfilter.trimwhitespace.php                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\shared.escape_special_chars.php                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\shared.make_timestamp.php                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\shared.mb_str_replace.php                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\variablefilter.htmlspecialchars.php                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\Smarty.class.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_cacheresource_file.php                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_append.php                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_assign.php                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_block.php                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_break.php                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_call.php                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_capture.php                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_config_load.php                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_continue.php                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_debug.php                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_eval.php                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_extends.php                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_for.php                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_foreach.php                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_function.php                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_if.php                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_include.php                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_include_php.php                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_insert.php                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_ldelim.php                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_nocache.php                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_private_block_plugin.php                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_private_function_plugin.php                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_private_modifier.php                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_private_object_block_function.php          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_private_object_function.php                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_private_print_expression.php               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_private_registered_block.php               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_private_registered_function.php            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_private_special_variable.php               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_rdelim.php                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_section.php                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_while.php                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compilebase.php                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_config.php                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_config_file_compiler.php                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_configfilelexer.php                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_configfileparser.php                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_data.php                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_debug.php                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_filter.php                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_filter_handler.php                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_function_call_handler.php                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_get_include_path.php                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_nocache_insert.php                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_parsetree.php                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_register.php                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_resource_eval.php                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_resource_extends.php                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_resource_file.php                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_resource_php.php                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_resource_registered.php                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_resource_stream.php                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_resource_string.php                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_smartytemplatecompiler.php                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_template.php                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_templatecompilerbase.php                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_templatelexer.php                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_templateparser.php                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_utility.php                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_wrapper.php                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_write_file.php                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_security.php                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\README                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\SMARTY2_BC_NOTES                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\examples\example1.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\examples\example2.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\examples\example3.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\examples\example4.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\examples\example5.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\examples\simple_cms\config.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\examples\simple_cms\index.php                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\examples\simple_cms\pages\about.tpl                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\examples\simple_cms\pages\contact.tpl                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\examples\simple_cms\pages\home.tpl                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\examples\simple_cms\structure.php                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\examples\simple_cms\template\lipsum.tpl                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\examples\simple_cms\template\main.tpl                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\examples\simple_cms\template\menubar.tpl                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\examples\templates\example1.tpl                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\examples\templates\example2.tpl                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\examples\templates\example3.tpl                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\examples\templates\example4.tpl                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\examples\templates\example5.tpl                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\plugins\dependencies\PHP_Highlight.php                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\plugins\dependencies\T.php                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\plugins\include_plugin.php                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\plugins\PHP_code_plugin.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64\X64Template.class.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\index.php                                                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\README.md                                                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\sites\logandplay\routes.xml                                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\sites\logandplay\site.xml                                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\themes\mokb\css\00_common.css                                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\themes\mokb\css\10_musicien.css                                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\themes\mokb\css\20_matiere.css                                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\themes\mokb\css\30_ecoute.css                                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\themes\mokb\css\40_k2000.css                                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\themes\mokb\css\50_technique.css                                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\themes\mokb\css\60_security.css                                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\tools\asap_dependency_audit.php                                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\tools\ASAP_FULL_UPDATE.cmd                                                                                     
H:\MO_KB_FRONT\public\.htaccess                                                                                                                
H:\MO_KB_FRONT\public\api\.htaccess                                                                                                            
H:\MO_KB_FRONT\public\api\index.php                                                                                                            
H:\MO_KB_FRONT\public\api\proxy.php                                                                                                            
H:\MO_KB_FRONT\public\assets\css\00_common.css                                                                                                 
H:\MO_KB_FRONT\public\assets\css\ecoute.css                                                                                                    
H:\MO_KB_FRONT\public\assets\css\k2000.css                                                                                                     
H:\MO_KB_FRONT\public\assets\css\matiere.css                                                                                                   
H:\MO_KB_FRONT\public\assets\css\musicien.css                                                                                                  
H:\MO_KB_FRONT\public\assets\css\security.css                                                                                                  
H:\MO_KB_FRONT\public\assets\css\technique.css                                                                                                 
H:\MO_KB_FRONT\public\assets\js\common.js                                                                                                      
H:\MO_KB_FRONT\public\index.php                                                                                                                
H:\MO_KB_FRONT\README.md                                                                                                                       
H:\MO_KB_FRONT\templates\layout.twig                                                                                                           
H:\MO_KB_FRONT\templates\pages\ecoute.twig                                                                                                     
H:\MO_KB_FRONT\templates\pages\k2000.twig                                                                                                      
H:\MO_KB_FRONT\templates\pages\matiere.twig                                                                                                    
H:\MO_KB_FRONT\templates\pages\musicien.twig                                                                                                   
H:\MO_KB_FRONT\templates\pages\security.twig                                                                                                   
H:\MO_KB_FRONT\templates\pages\technique.twig                                                                                                  
H:\MO_KB_FRONT\tools\FRONT_SMOKE_TEST.cmd                                                                                                      
H:\MO_KB_FRONT\tools\front_smoke_test.php                                                                                                      
H:\MO_KB_FRONT\tools\LINK_UWAMP_FRONT.cmd                                                                                                      



```

## Fichiers candidats ASAP / routes / config / templates

```text

FullName                                                                                                                                       
--------                                                                                                                                       
H:\MO_KB_FRONT\.vscode\extensions.json                                                                                                         
H:\MO_KB_FRONT\.vscode\settings.json                                                                                                           
H:\MO_KB_FRONT\.vscode\tasks.json                                                                                                              
H:\MO_KB_FRONT\app\Engine\ApiClient.php                                                                                                        
H:\MO_KB_FRONT\app\Engine\AppKernel.php                                                                                                        
H:\MO_KB_FRONT\app\Engine\ConfigEngine.php                                                                                                     
H:\MO_KB_FRONT\app\Engine\FsmEngine.php                                                                                                        
H:\MO_KB_FRONT\app\Engine\I18nEngine.php                                                                                                       
H:\MO_KB_FRONT\app\Engine\ModuleRegistry.php                                                                                                   
H:\MO_KB_FRONT\app\Engine\NavigationEngine.php                                                                                                 
H:\MO_KB_FRONT\app\Engine\RouterEngine.php                                                                                                     
H:\MO_KB_FRONT\app\Engine\SecurityEngine.php                                                                                                   
H:\MO_KB_FRONT\app\Engine\TemplateEngine.php                                                                                                   
H:\MO_KB_FRONT\bootstrap.php                                                                                                                   
H:\MO_KB_FRONT\composer.json                                                                                                                   
H:\MO_KB_FRONT\config\config.php                                                                                                               
H:\MO_KB_FRONT\i18n\en.php                                                                                                                     
H:\MO_KB_FRONT\i18n\es.php                                                                                                                     
H:\MO_KB_FRONT\i18n\fr.php                                                                                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\api\proxy.php                                                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\Index_controller.class.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\local\en\I18n.xml                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\local\es\I18n.xml                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\local\fr\I18n.xml                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\local\FR-fr\I18n.xml                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\templates\layout.tpl                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\templates\layout.twig                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\views\Mokb_view.class.php                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\ecoute\Index_controller.class.php                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\ecoute\javascript\index.js                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\ecoute\templates\page.tpl                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\ecoute\templates\page.twig                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\k2000\Index_controller.class.php                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\k2000\javascript\index.js                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\k2000\templates\page.tpl                                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\k2000\templates\page.twig                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\matiere\Index_controller.class.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\matiere\javascript\index.js                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\matiere\templates\page.tpl                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\matiere\templates\page.twig                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\musicien\Index_controller.class.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\musicien\javascript\index.js                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\musicien\templates\page.tpl                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\musicien\templates\page.twig                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\security\Index_controller.class.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\security\javascript\index.js                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\security\templates\page.tpl                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\security\templates\page.twig                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\technique\Index_controller.class.php                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\technique\javascript\index.js                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\technique\templates\page.tpl                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\technique\templates\page.twig                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\assets\js\common.js                                                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\composer.json                                                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\config\api.php                                                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59H_ASAP_COMPOSER_TWIG_FULL_UPDATE\DEPENDENCY_UPGRADE_MANIFEST.json                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\ACL\ASAP_Acl.class.php                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\ACL\ASAP_Acl_conditions.php                                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\ACL\ASAP_Acl_Resource.class.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\ACL\ASAP_Acl_Role.class.php                                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\ACL\ASAP_Roles.class.php                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\Application.class.php                                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\BDD\adodb5.class.php                                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\BDD\Database.class.php                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\BDD\Mysql.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\bootstrap.php                                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\ConfigLoader.class.php                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\Configuration.class.php                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\CONTROLLER\Controller.class.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\Debug.class.php                                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\Exception.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\FSM\Diagram.class.php                                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\FSM\Fsm.class.php                                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\FSM\GraphViz.class.php                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\FTP\Ftp.class.php                                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\HELPER\Helper.class.php                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\I18N\I18n.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\LINK\Link.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\MAIL\Mail.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\MAIL\PhpMailer.class.php                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\MENU\Menu.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\MODEL\Model.class.php                                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\REST\Rest.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\Router.class.php                                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\SimpleXMLElementExtended.class.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\Singleton.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\SITE\Site.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\SITE\SiteResolver.class.php                                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\SMTP\Smtp.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\TEMPLATE\Adapter.class.php                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\TEMPLATE\Smarty.class.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\TEMPLATE\Twig.class.php                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\TEMPLATE\X64.class.php                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\URL\Url.class.php                                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\Validator.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\VIEW\Html.class.php                                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\autoloader.class.php                                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\autoloader_new2.class.php                                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb.inc.php                                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-active-record.inc.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-active-recordx.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-csvlib.inc.php                                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-datadict.inc.php                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-error.inc.php                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-errorhandler.inc.php                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-errorpear.inc.php                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-exceptions.inc.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-iterator.inc.php                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-lib.inc.php                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-memcache.lib.inc.php                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-pager.inc.php                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-pear.inc.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-perf.inc.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-php4.inc.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-time.inc.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-xmlschema.inc.php                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\adodb-xmlschema03.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\contrib\toxmlrpc.inc.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-access.inc.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-db2.inc.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-firebird.inc.php                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-generic.inc.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-ibase.inc.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-informix.inc.php                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-mssql.inc.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-mssqlnative.inc.php                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-mysql.inc.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-oci8.inc.php                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-postgres.inc.php                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-sapdb.inc.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-sqlite.inc.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\datadict\datadict-sybase.inc.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-access.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-ado.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-ado_access.inc.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-ado_mssql.inc.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-ado5.inc.php                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-ads.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-borland_ibase.inc.php                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-csv.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-db2.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-db2oci.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-db2ora.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-fbsql.inc.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-firebird.inc.php                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-ibase.inc.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-informix.inc.php                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-informix72.inc.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-ldap.inc.php                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-mssql.inc.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-mssql_n.inc.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-mssqlnative.inc.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-mssqlpo.inc.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-mysql.inc.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-mysqli.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-mysqlpo.inc.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-mysqlt.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-netezza.inc.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-oci8.inc.php                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-oci805.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-oci8po.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-odbc.inc.php                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-odbc_db2.inc.php                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-odbc_mssql.inc.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-odbc_oracle.inc.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-odbtp.inc.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-odbtp_unicode.inc.php                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-oracle.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-pdo.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-pdo_mssql.inc.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-pdo_mysql.inc.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-pdo_oci.inc.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-pdo_pgsql.inc.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-pdo_sqlite.inc.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-postgres.inc.php                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-postgres64.inc.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-postgres7.inc.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-postgres8.inc.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-proxy.inc.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-sapdb.inc.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-sqlanywhere.inc.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-sqlite.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-sqlite3.inc.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-sqlitepo.inc.php                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-sybase.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-sybase_ase.inc.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\drivers\adodb-vfp.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb_th.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-ar.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-bg.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-bgutf8.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-ca.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-cn.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-cz.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-da.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-de.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-en.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-es.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-esperanto.inc.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-fa.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-fr.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-hu.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-it.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-nl.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-pl.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-pt-br.inc.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-ro.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-ru1251.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-sv.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\lang\adodb-uk1251.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\pear\Auth\Container\ADOdb.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\perf\perf-db2.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\perf\perf-informix.inc.php                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\perf\perf-mssql.inc.php                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\perf\perf-mssqlnative.inc.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\perf\perf-mysql.inc.php                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\perf\perf-oci8.inc.php                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\perf\perf-postgres.inc.php                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\pivottable.inc.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\rsfilter.inc.php                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\server.php                                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-compress-bzip2.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-compress-gzip.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-cryptsession.php                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-cryptsession2.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-encrypt-mcrypt.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-encrypt-md5.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-encrypt-secret.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-encrypt-sha1.php                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-session.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-session2.php                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-session-clob.php                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\adodb-session-clob2.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\crypt.inc.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\old\adodb-cryptsession.php                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\old\adodb-session.php                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\old\adodb-session-clob.php                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\session\old\crypt.inc.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\benchmark.php                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\client.php                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\pdo.php                                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test.php                                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test_rs_array.php                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test2.php                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test3.php                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test4.php                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test5.php                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test-active-record.php                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test-active-recs2.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test-active-relations.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test-active-relationsx.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\testcache.php                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\testdatabases.inc.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test-datadict.php                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\testgenid.php                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\testmssql.php                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\testoci8.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\testoci8cursor.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\testpaging.php                                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\testpear.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test-perf.php                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test-pgblob.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test-php5.php                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\testsessions.php                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\test-xmlschema.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\time.php                                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tests\tmssql.php                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\toexport.inc.php                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5\tohtml.inc.php                                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\class.phpmailer.php                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\class.pop3.php                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\class.smtp.php                                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs.ini                                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\css\bootstrap.css                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\css\bootstrap.min.css                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\css\bootstrap-responsive.css                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\css\bootstrap-responsive.min.css                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\css\jquery.iviewer.css                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\css\prettify.css                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\css\template.css                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\img\icons\icon_template.svg                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\bootstrap.js                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\bootstrap.min.js                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery.cookie.js                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery.iviewer.js                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery.iviewer.min.js                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery.mousewheel.min.js                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery.panzoom.js                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery.splitter.js                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery.tools.min.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery.treeview.js                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery-1.4.2.min.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery-1.7.1.min.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\jquery-ui-1.8.2.custom.min.js                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\menu.js                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-apollo.js                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-clj.js                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-css.js                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-go.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-hs.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-lisp.js                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-lua.js                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-ml.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-n.js                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-proto.js                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-scala.js                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-sql.js                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-tex.js                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-vb.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-vhdl.js                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-wiki.js                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-xq.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\lang-yaml.js                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\prettify\prettify.min.js                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\sidebar.js                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\SVGPan.js                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\docs\phpdoc\js\template.js                                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_db_smtp_basic.php                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_mail_advanced.php                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_mail_basic.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_pop_before_smtp_advanced.php                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_pop_before_smtp_basic.php                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_sendmail_advanced.php                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_sendmail_basic.php                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_smtp_advanced.php                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_smtp_advanced_no_auth.php                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_smtp_basic.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_smtp_basic_no_auth.php                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_smtp_gmail_advanced.php                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\examples\test_smtp_gmail_basic.php                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\extras\htmlfilter.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\extras\ntlm_sasl_client.php                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-ar.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-br.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-ca.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-ch.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-cz.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-de.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-dk.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-es.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-et.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-fi.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-fo.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-fr.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-hu.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-it.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-ja.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-nl.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-no.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-pl.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-ro.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-ru.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-se.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-tr.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-zh.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\language\phpmailer.lang-zh_cn.php                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test\phpmailerTest.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test\test_callback.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test\testemail.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\index.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushBash.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushCpp.js                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushCSharp.js                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushCss.js                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushDelphi.js                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushDiff.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushGroovy.js                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushJava.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushJScript.js                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushPerl.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushPhp.js                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushPlain.js                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushPython.js                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushRuby.js                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushScala.js                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushSql.js                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushVb.js                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shBrushXml.js                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shCore.js                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\scripts\shLegacy.js                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\src\shCore.js                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\src\shLegacy.js                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\styles\shCore.css                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\styles\shThemeDefault.css                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\styles\shThemeDjango.css                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\styles\shThemeEmacs.css                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\styles\shThemeFadeToGrey.css                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\styles\shThemeMidnight.css                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test_script\styles\shThemeRDark.css                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\cache\749422d4cfc3eb5677cf499730392b6accd4d1c7.index.tpl.php                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\index.php                                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\index_php_template.php                                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates\footer.tpl                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates\header.tpl                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates\index.tpl                                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates\index_view.php                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates_c\0013c647e9502d41f43f2055ab8406140c2510c6.test.conf.config.php     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates_c\10e0737838b4a574ef135d0c601e7b602cfaf37a.file.header.tpl.cache.php
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates_c\1be7ff7fdee636597edd726ee98dfef4bfd55d1f.file.footer.tpl.cache.php
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates_c\59399816f5ba59b26c7204ef6ebb1bb339774ca6.file.debug.tpl.php       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates_c\749422d4cfc3eb5677cf499730392b6accd4d1c7.file.index.tpl.cache.php 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\debug.tpl                                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\block.php.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\block.textformat.php                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.counter.php                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.cycle.php                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.fetch.php                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.html_checkboxes.php                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.html_image.php                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.html_options.php                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.html_radios.php                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.html_select_date.php                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.html_select_time.php                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.html_table.php                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.mailto.php                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\function.math.php                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifier.capitalize.php                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifier.date_format.php                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifier.debug_print_var.php                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifier.escape.php                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifier.regex_replace.php                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifier.replace.php                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifier.spacify.php                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifier.truncate.php                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.cat.php                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.count_characters.php                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.count_paragraphs.php                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.count_sentences.php                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.count_words.php                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.default.php                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.indent.php                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.lower.php                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.noprint.php                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.string_format.php                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.strip.php                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.strip_tags.php                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.upper.php                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\modifiercompiler.wordwrap.php                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\outputfilter.trimwhitespace.php                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\shared.escape_special_chars.php                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\shared.make_timestamp.php                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\shared.mb_str_replace.php                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\plugins\variablefilter.htmlspecialchars.php                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\Smarty.class.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_cacheresource_file.php                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_append.php                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_assign.php                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_block.php                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_break.php                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_call.php                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_capture.php                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_config_load.php                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_continue.php                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_debug.php                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_eval.php                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_extends.php                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_for.php                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_foreach.php                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_function.php                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_if.php                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_include.php                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_include_php.php                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_insert.php                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_ldelim.php                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_nocache.php                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_private_block_plugin.php                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_private_function_plugin.php                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_private_modifier.php                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_private_object_block_function.php          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_private_object_function.php                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_private_print_expression.php               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_private_registered_block.php               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_private_registered_function.php            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_private_special_variable.php               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_rdelim.php                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_section.php                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compile_while.php                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_compilebase.php                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_config.php                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_config_file_compiler.php                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_configfilelexer.php                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_configfileparser.php                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_data.php                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_debug.php                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_filter.php                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_filter_handler.php                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_function_call_handler.php                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_get_include_path.php                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_nocache_insert.php                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_parsetree.php                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_register.php                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_resource_eval.php                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_resource_extends.php                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_resource_file.php                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_resource_php.php                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_resource_registered.php                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_resource_stream.php                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\libs\sysplugins\smarty_internal_resource_string.php                                



```

## Marqueurs ASAP / Twig / Smarty / routes

```text

Path                                                                                                                 LineNumber Line                                                                            
----                                                                                                                 ---------- ----                                                                            
H:\MO_KB_FRONT\composer.json                                                                                                  3   "description": "MO_KB front PHP léger avec Twig, jQuery et moteurs métiers ...
H:\MO_KB_FRONT\composer.json                                                                                                 10     "twig/twig": "^3.0"                                                         
H:\MO_KB_FRONT\.vscode\settings.json                                                                                          7     "**/node_modules": true                                                     
H:\MO_KB_FRONT\app\Engine\ApiClient.php                                                                                      15         if (($endpoint['method'] ?? 'GET') === 'LOCAL') {                       
H:\MO_KB_FRONT\app\Engine\ApiClient.php                                                                                      93             'template' => class_exists('Twig\\Environment') ? 'Twig OK' : 'Tw...
H:\MO_KB_FRONT\app\Engine\ApiClient.php                                                                                      95             'engines' => ['FSM', 'I18N', 'Navigation', 'ModuleRegistry', 'Api...
H:\MO_KB_FRONT\app\Engine\AppKernel.php                                                                                       8     private I18nEngine $i18n;                                                   
H:\MO_KB_FRONT\app\Engine\AppKernel.php                                                                                       9     private ModuleRegistry $modules;                                            
H:\MO_KB_FRONT\app\Engine\AppKernel.php                                                                                      13     private TemplateEngine $templates;                                          
H:\MO_KB_FRONT\app\Engine\AppKernel.php                                                                                      19         $this->i18n = new I18nEngine($this->config);                            
H:\MO_KB_FRONT\app\Engine\AppKernel.php                                                                                      20         $this->modules = new ModuleRegistry();                                  
H:\MO_KB_FRONT\app\Engine\AppKernel.php                                                                                      21         $this->navigation = new NavigationEngine($this->modules, $this->i18n);  
H:\MO_KB_FRONT\app\Engine\AppKernel.php                                                                                      23         $this->router = new RouterEngine($this->config, $this->i18n, $this->m...
H:\MO_KB_FRONT\app\Engine\AppKernel.php                                                                                      24         $this->templates = new TemplateEngine($this->config);                   
H:\MO_KB_FRONT\app\Engine\AppKernel.php                                                                                      48         $module = $route['module'];                                             
H:\MO_KB_FRONT\app\Engine\AppKernel.php                                                                                      49         $dict = $this->i18n->dict($lang);                                       
H:\MO_KB_FRONT\app\Engine\AppKernel.php                                                                                      51         $moduleTemplate = 'pages/' . $module . '.twig';                         
H:\MO_KB_FRONT\app\Engine\AppKernel.php                                                                                      56             'module' => $module,                                                
H:\MO_KB_FRONT\app\Engine\AppKernel.php                                                                                      61             'nav' => $this->navigation->build($basePath, $lang, $module),       
H:\MO_KB_FRONT\app\Engine\AppKernel.php                                                                                      62             'languages' => $this->navigation->languages($basePath, $lang, $mo...
H:\MO_KB_FRONT\app\Engine\AppKernel.php                                                                                      63             'fsm' => $this->fsm->state($module),                                
H:\MO_KB_FRONT\app\Engine\AppKernel.php                                                                                      67         $vars['contentHtml'] = $this->templates->render($moduleTemplate, $vars);
H:\MO_KB_FRONT\app\Engine\AppKernel.php                                                                                      68         echo $this->templates->render('layout.twig', $vars);                    
H:\MO_KB_FRONT\app\Engine\FsmEngine.php                                                                                       8     public function state(string $module): array {                              
H:\MO_KB_FRONT\app\Engine\FsmEngine.php                                                                                       9         $idx = array_search($module, $this->sequence, true);                    
H:\MO_KB_FRONT\app\Engine\FsmEngine.php                                                                                      10         if ($idx === false) { $idx = 0; $module = 'musicien'; }                 
H:\MO_KB_FRONT\app\Engine\FsmEngine.php                                                                                      12             'current' => $module,                                               
H:\MO_KB_FRONT\app\Engine\I18nEngine.php                                                                                      5 final class I18nEngine {                                                        
H:\MO_KB_FRONT\app\Engine\I18nEngine.php                                                                                      7     private array $cache = [];                                                  
H:\MO_KB_FRONT\app\Engine\I18nEngine.php                                                                                     19         if (isset($this->cache[$lang])) { return $this->cache[$lang]; }         
H:\MO_KB_FRONT\app\Engine\I18nEngine.php                                                                                     20         $file = MO_KB_FRONT_ROOT . '/i18n/' . $lang . '.php';                   
H:\MO_KB_FRONT\app\Engine\I18nEngine.php                                                                                     21         if (!is_file($file)) { $file = MO_KB_FRONT_ROOT . '/i18n/fr.php'; }     
H:\MO_KB_FRONT\app\Engine\I18nEngine.php                                                                                     23         $this->cache[$lang] = is_array($dict) ? $dict : [];                     
H:\MO_KB_FRONT\app\Engine\I18nEngine.php                                                                                     24         return $this->cache[$lang];                                             
H:\MO_KB_FRONT\app\Engine\ModuleRegistry.php                                                                                  5 final class ModuleRegistry {                                                    
H:\MO_KB_FRONT\app\Engine\ModuleRegistry.php                                                                                  6     private array $modules = [                                                  
H:\MO_KB_FRONT\app\Engine\ModuleRegistry.php                                                                                 15     public function all(): array { return $this->modules; }                     
H:\MO_KB_FRONT\app\Engine\ModuleRegistry.php                                                                                 16     public function has(string $module): bool { return isset($this->modules[$...
H:\MO_KB_FRONT\app\Engine\ModuleRegistry.php                                                                                 17     public function get(string $module): array { return $this->modules[$modul...
H:\MO_KB_FRONT\app\Engine\ModuleRegistry.php                                                                                 20     public function moduleFromSlug(string $lang, string $slug): string {        
H:\MO_KB_FRONT\app\Engine\ModuleRegistry.php                                                                                 21         foreach ($this->modules as $module => $def) {                           
H:\MO_KB_FRONT\app\Engine\ModuleRegistry.php                                                                                 22             if (($def['slugs'][$lang] ?? '') === $slug) { return $module; }     
H:\MO_KB_FRONT\app\Engine\ModuleRegistry.php                                                                                 27     public function slug(string $module, string $lang): string {                
H:\MO_KB_FRONT\app\Engine\ModuleRegistry.php                                                                                 28         $def = $this->get($module);                                             
H:\MO_KB_FRONT\app\Engine\ModuleRegistry.php                                                                                 29         return (string)($def['slugs'][$lang] ?? $def['slugs']['fr'] ?? $module);
H:\MO_KB_FRONT\app\Engine\NavigationEngine.php                                                                                6     public function __construct(private ModuleRegistry $modules, private I18n...
H:\MO_KB_FRONT\app\Engine\NavigationEngine.php                                                                                8     public function build(string $basePath, string $lang, string $activeModul...
H:\MO_KB_FRONT\app\Engine\NavigationEngine.php                                                                               10         foreach ($this->modules->all() as $module => $def) {                    
H:\MO_KB_FRONT\app\Engine\NavigationEngine.php                                                                               12                 'module' => $module,                                            
H:\MO_KB_FRONT\app\Engine\NavigationEngine.php                                                                               14                 'label' => $this->i18n->t($lang, $def['label_key'], $module),   
H:\MO_KB_FRONT\app\Engine\NavigationEngine.php                                                                               15                 'url' => rtrim($basePath, '/') . '/' . $lang . '/' . $this->m...
H:\MO_KB_FRONT\app\Engine\NavigationEngine.php                                                                               16                 'active' => $module === $activeModule,                          
H:\MO_KB_FRONT\app\Engine\NavigationEngine.php                                                                               22     public function languages(string $basePath, string $activeLang, string $m...
H:\MO_KB_FRONT\app\Engine\NavigationEngine.php                                                                               28                 'url' => rtrim($basePath, '/') . '/' . $lang . '/' . $this->m...
H:\MO_KB_FRONT\app\Engine\RouterEngine.php                                                                                    6     public function __construct(private ConfigEngine $config, private I18nEng...
H:\MO_KB_FRONT\app\Engine\RouterEngine.php                                                                                   21             return ['kind' => 'api', 'basePath' => $base, 'lang' => 'fr', 'mo...
H:\MO_KB_FRONT\app\Engine\RouterEngine.php                                                                                   24         $lang = $this->i18n->normalizeLang($parts[0] ?? ($_GET['lang'] ?? nul...
H:\MO_KB_FRONT\app\Engine\RouterEngine.php                                                                                   29             $module = $legacyMap[$legacy] ?? $this->modules->default();         
H:\MO_KB_FRONT\app\Engine\RouterEngine.php                                                                                   30             $slug = $this->modules->slug($module, $lang);                       
H:\MO_KB_FRONT\app\Engine\RouterEngine.php                                                                                   32             $module = $this->modules->moduleFromSlug($lang, $slug);             
H:\MO_KB_FRONT\app\Engine\RouterEngine.php                                                                                   34         return ['kind' => 'page', 'basePath' => $base, 'lang' => $lang, 'modu...
H:\MO_KB_FRONT\app\Engine\SecurityEngine.php                                                                                 10         header('Cache-Control: no-store, max-age=0');                           
H:\MO_KB_FRONT\app\Engine\SecurityEngine.php                                                                                 17         header('Cache-Control: no-store, max-age=0');                           
H:\MO_KB_FRONT\app\Engine\TemplateEngine.php                                                                                  5 use Twig\Environment;                                                           
H:\MO_KB_FRONT\app\Engine\TemplateEngine.php                                                                                  6 use Twig\Loader\FilesystemLoader;                                               
H:\MO_KB_FRONT\app\Engine\TemplateEngine.php                                                                                  7 use Twig\Extension\DebugExtension;                                              
H:\MO_KB_FRONT\app\Engine\TemplateEngine.php                                                                                  9 final class TemplateEngine {                                                    
H:\MO_KB_FRONT\app\Engine\TemplateEngine.php                                                                                 10     private Environment $twig;                                                  
H:\MO_KB_FRONT\app\Engine\TemplateEngine.php                                                                                 13         $loader = new FilesystemLoader(MO_KB_FRONT_ROOT . '/templates');        
H:\MO_KB_FRONT\app\Engine\TemplateEngine.php                                                                                 14         $this->twig = new Environment($loader, [                                
H:\MO_KB_FRONT\app\Engine\TemplateEngine.php                                                                                 15             'cache' => MO_KB_FRONT_ROOT . '/var/cache/twig',                    
H:\MO_KB_FRONT\app\Engine\TemplateEngine.php                                                                                 16             'debug' => (bool)$config->get('twig_debug', false),                 
H:\MO_KB_FRONT\app\Engine\TemplateEngine.php                                                                                 19         if ((bool)$config->get('twig_debug', false)) {                          
H:\MO_KB_FRONT\app\Engine\TemplateEngine.php                                                                                 20             $this->twig->addExtension(new DebugExtension());                    
H:\MO_KB_FRONT\app\Engine\TemplateEngine.php                                                                                 24     public function render(string $template, array $vars): string { return $t...
H:\MO_KB_FRONT\config\config.php                                                                                             10     'twig_debug' => true,                                                       
H:\MO_KB_FRONT\config\config.php                                                                                             15         'localhost_worker' => ['method' => 'GET', 'path' => '/api/workers/loc...
H:\MO_KB_FRONT\config\config.php                                                                                             26         'front_runtime_audit' => ['method' => 'LOCAL', 'path' => 'runtime_aud...
H:\MO_KB_FRONT\i18n\en.php                                                                                                    3 'brand_subtitle'=>'Light PHP front + Twig + jQuery','nav_aria'=>'Main navigat...
H:\MO_KB_FRONT\i18n\en.php                                                                                                    4 'page_title_musicien'=>'Musician home','page_subtitle_musicien'=>'Simple entr...
H:\MO_KB_FRONT\i18n\en.php                                                                                                    6 'page_title_ecoute'=>'Listen & palette','page_subtitle_ecoute'=>'Listen, filt...
H:\MO_KB_FRONT\i18n\en.php                                                                                                    7 'page_title_k2000'=>'Private K2000','page_subtitle_k2000'=>'Kurzweil intake, ...
H:\MO_KB_FRONT\i18n\en.php                                                                                                    8 'page_title_technique'=>'Technical','page_subtitle_technique'=>'Workers, GPU/...
H:\MO_KB_FRONT\i18n\en.php                                                                                                    9 'page_title_security'=>'API / Security','page_subtitle_security'=>'Port 80/44...
H:\MO_KB_FRONT\i18n\es.php                                                                                                    3 'brand_subtitle'=>'Front PHP ligero + Twig + jQuery','nav_aria'=>'Navegación ...
H:\MO_KB_FRONT\i18n\es.php                                                                                                    6 'page_title_ecoute'=>'Escucha & paleta','page_subtitle_ecoute'=>'Escuchar, fi...
H:\MO_KB_FRONT\i18n\es.php                                                                                                    7 'page_title_k2000'=>'K2000 privado','page_subtitle_k2000'=>'Intake Kurzweil, ...
H:\MO_KB_FRONT\i18n\es.php                                                                                                    8 'page_title_technique'=>'Técnico','page_subtitle_technique'=>'Workers, sondas...
H:\MO_KB_FRONT\i18n\es.php                                                                                                    9 'page_title_security'=>'API / Seguridad','page_subtitle_security'=>'Gateway p...
H:\MO_KB_FRONT\i18n\fr.php                                                                                                    3 'brand_subtitle'=>'Front PHP léger + Twig + jQuery',                            
H:\MO_KB_FRONT\i18n\fr.php                                                                                                    6 'backend_untested'=>'API non testée','top_eyebrow'=>'Interface officielle · s...
H:\MO_KB_FRONT\i18n\fr.php                                                                                                    7 'page_title_musicien'=>'Accueil musicien','page_subtitle_musicien'=>'Entrée s...
H:\MO_KB_FRONT\i18n\fr.php                                                                                                    9 'page_title_ecoute'=>'Écoute & palette','page_subtitle_ecoute'=>'Écouter, fil...
H:\MO_KB_FRONT\i18n\fr.php                                                                                                   10 'page_title_k2000'=>'K2000 privé','page_subtitle_k2000'=>'Intake Kurzweil, ca...
H:\MO_KB_FRONT\i18n\fr.php                                                                                                   11 'page_title_technique'=>'Technique','page_subtitle_technique'=>'Workers, prob...
H:\MO_KB_FRONT\i18n\fr.php                                                                                                   12 'page_title_security'=>'API / Sécurité','page_subtitle_security'=>'Gateway po...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\.htaccess                                                                                     3 RewriteBase /MO_KB_FRONT_ASAP/                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\composer.json                                                                                 2     "name": "logandplay/mo-kb-front-asap",                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\composer.json                                                                                 3     "description": "MO_KB front PHP ASAP, Twig, REST-only client for MO_KB_DA...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\composer.json                                                                                10         "twig/twig": "^3.0",                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\composer.json                                                                                19         "asap:audit": "php tools/asap_dependency_audit.php --json",             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\composer.json                                                                                20         "asap:post-update": "php tools/asap_dependency_audit.php --json"        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\index.php                                                                                     8 define('ENV', getenv('ASAP_ENV') ?: 'dev');                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\index.php                                                                                     9 define('MO_KB_FRONT_ASAP_VERSION', 'P110B70_HANDOFF_BACKOFFICE_ONLY');          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\index.php                                                                                    11 require_once ROOT . '/framework/ASAP/bootstrap.php';                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\index.php                                                                                    14 $app = ASAP_Application::getInstance();                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\api\proxy.php                                                                                 8 header('Cache-Control: no-store, max-age=0');                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\api\proxy.php                                                                                35                 'User-Agent: MO_KB_FRONT_ASAP_HANDOFF/0.1',                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\api\proxy.php                                                                                67 if (($endpoint['method'] ?? 'GET') === 'LOCAL') {                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\api\proxy.php                                                                                68     $tool = ROOT . '/tools/asap_dependency_audit.php';                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\api\proxy.php                                                                                71         echo json_encode(array('ok' => false, 'error' => 'ASAP_LOCAL_TOOL_MIS...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\api\proxy.php                                                                                75     if (!function_exists('asap_dependency_audit')) {                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\api\proxy.php                                                                                77         echo json_encode(array('ok' => false, 'error' => 'ASAP_LOCAL_TOOL_INV...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\api\proxy.php                                                                                80     echo json_encode(array('ok' => true, 'front_proxy' => true, 'endpoint' =>...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\api\proxy.php                                                                               105             'User-Agent: MO_KB_FRONT_ASAP/0.1',                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                             2 // ASAP_CONFIG_ROOT = H:/MO_KB_FRONT_ASAP/                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                             3 class Config extends ASAP_Configuration {                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            17         $this->_configArray['environments']['dev']['rootPath'] = 'H:/MO_KB_FR...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            26         $this->_configArray['routes']['root']['target']['module'] = 'musicien'; 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            27         $this->_configArray['routes']['root']['target']['controller'] = 'index';
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            28         $this->_configArray['routes']['root']['target']['action'] = 'show';     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            33         $this->_configArray['routes']['home']['target']['module'] = 'musicien'; 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            34         $this->_configArray['routes']['home']['target']['controller'] = 'index';
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            35         $this->_configArray['routes']['home']['target']['action'] = 'show';     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            40         $this->_configArray['routes']['root_fr']['target']['module'] = 'music...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            41         $this->_configArray['routes']['root_fr']['target']['controller'] = 'i...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            42         $this->_configArray['routes']['root_fr']['target']['action'] = 'show';  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            47         $this->_configArray['routes']['fr_musicien']['target']['module'] = 'm...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            48         $this->_configArray['routes']['fr_musicien']['target']['controller'] ...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            49         $this->_configArray['routes']['fr_musicien']['target']['action'] = 's...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            54         $this->_configArray['routes']['fr_matiere']['target']['module'] = 'ma...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            55         $this->_configArray['routes']['fr_matiere']['target']['controller'] =...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            56         $this->_configArray['routes']['fr_matiere']['target']['action'] = 'sh...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            61         $this->_configArray['routes']['fr_ecoute']['target']['module'] = 'eco...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            62         $this->_configArray['routes']['fr_ecoute']['target']['controller'] = ...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            63         $this->_configArray['routes']['fr_ecoute']['target']['action'] = 'show';
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            68         $this->_configArray['routes']['fr_k2000']['target']['module'] = 'k2000';
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            69         $this->_configArray['routes']['fr_k2000']['target']['controller'] = '...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            70         $this->_configArray['routes']['fr_k2000']['target']['action'] = 'show'; 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            75         $this->_configArray['routes']['fr_technique']['target']['module'] = '...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            76         $this->_configArray['routes']['fr_technique']['target']['controller']...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            77         $this->_configArray['routes']['fr_technique']['target']['action'] = '...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            82         $this->_configArray['routes']['fr_security']['target']['module'] = 's...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            83         $this->_configArray['routes']['fr_security']['target']['controller'] ...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            84         $this->_configArray['routes']['fr_security']['target']['action'] = 's...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            89         $this->_configArray['routes']['root_en']['target']['module'] = 'music...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            90         $this->_configArray['routes']['root_en']['target']['controller'] = 'i...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            91         $this->_configArray['routes']['root_en']['target']['action'] = 'show';  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            96         $this->_configArray['routes']['en_musicien']['target']['module'] = 'm...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            97         $this->_configArray['routes']['en_musicien']['target']['controller'] ...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                            98         $this->_configArray['routes']['en_musicien']['target']['action'] = 's...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           103         $this->_configArray['routes']['en_matiere']['target']['module'] = 'ma...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           104         $this->_configArray['routes']['en_matiere']['target']['controller'] =...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           105         $this->_configArray['routes']['en_matiere']['target']['action'] = 'sh...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           110         $this->_configArray['routes']['en_ecoute']['target']['module'] = 'eco...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           111         $this->_configArray['routes']['en_ecoute']['target']['controller'] = ...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           112         $this->_configArray['routes']['en_ecoute']['target']['action'] = 'show';
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           117         $this->_configArray['routes']['en_k2000']['target']['module'] = 'k2000';
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           118         $this->_configArray['routes']['en_k2000']['target']['controller'] = '...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           119         $this->_configArray['routes']['en_k2000']['target']['action'] = 'show'; 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           124         $this->_configArray['routes']['en_technique']['target']['module'] = '...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           125         $this->_configArray['routes']['en_technique']['target']['controller']...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           126         $this->_configArray['routes']['en_technique']['target']['action'] = '...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           131         $this->_configArray['routes']['en_security']['target']['module'] = 's...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           132         $this->_configArray['routes']['en_security']['target']['controller'] ...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           133         $this->_configArray['routes']['en_security']['target']['action'] = 's...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           138         $this->_configArray['routes']['root_es']['target']['module'] = 'music...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           139         $this->_configArray['routes']['root_es']['target']['controller'] = 'i...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           140         $this->_configArray['routes']['root_es']['target']['action'] = 'show';  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           145         $this->_configArray['routes']['es_musicien']['target']['module'] = 'm...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           146         $this->_configArray['routes']['es_musicien']['target']['controller'] ...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           147         $this->_configArray['routes']['es_musicien']['target']['action'] = 's...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           152         $this->_configArray['routes']['es_matiere']['target']['module'] = 'ma...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           153         $this->_configArray['routes']['es_matiere']['target']['controller'] =...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           154         $this->_configArray['routes']['es_matiere']['target']['action'] = 'sh...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           159         $this->_configArray['routes']['es_ecoute']['target']['module'] = 'eco...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           160         $this->_configArray['routes']['es_ecoute']['target']['controller'] = ...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           161         $this->_configArray['routes']['es_ecoute']['target']['action'] = 'show';
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           166         $this->_configArray['routes']['es_k2000']['target']['module'] = 'k2000';
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           167         $this->_configArray['routes']['es_k2000']['target']['controller'] = '...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           168         $this->_configArray['routes']['es_k2000']['target']['action'] = 'show'; 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           173         $this->_configArray['routes']['es_technique']['target']['module'] = '...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           174         $this->_configArray['routes']['es_technique']['target']['controller']...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           175         $this->_configArray['routes']['es_technique']['target']['action'] = '...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           180         $this->_configArray['routes']['es_security']['target']['module'] = 's...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           181         $this->_configArray['routes']['es_security']['target']['controller'] ...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           182         $this->_configArray['routes']['es_security']['target']['action'] = 's...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           187         $this->_configArray['routes']['legacy_section']['target']['module'] =...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           188         $this->_configArray['routes']['legacy_section']['target']['controller...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\config\config.xml.php                                                           189         $this->_configArray['routes']['legacy_section']['target']['action'] =...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\Index_controller.class.php                                                8 class Index_controller extends ASAP_Controller {                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\Index_controller.class.php                                                9     public function default_action() { return $this->show_action(); }           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\Index_controller.class.php                                               10     public function show_action() {                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            14         'musicien' => array('module' => 'musicien', 'icon' => '🎼', 'slugs' =...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            15         'matiere' => array('module' => 'matiere', 'icon' => '🎧', 'slugs' => ...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            16         'ecoute' => array('module' => 'ecoute', 'icon' => '▶', 'slugs' => arr...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            17         'k2000' => array('module' => 'k2000', 'icon' => 'K2', 'slugs' => arra...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            18         'technique' => array('module' => 'technique', 'icon' => '⚙', 'slugs' ...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            19         'security' => array('module' => 'security', 'icon' => '🔐', 'slugs' =...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            22     public static function render(ASAP_Controller $controller, string $page):...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            23         $lang = self::resolveLang($controller);                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            24         $module = self::$pages[$page]['module'] ?? 'musicien';                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            25         $dict = self::dictionary($lang, $module);                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            27         $app = ASAP_Application::getInstance();                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            29         $version = defined('MO_KB_FRONT_ASAP_VERSION') ? MO_KB_FRONT_ASAP_VER...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            31         $controller->newLang($lang);                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            32         $controller->newHtmlLang($lang);                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            33         $controller->newTitle(self::t($dict, 'page_title') . ' · MO_KB');       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            34         $controller->newBodyClass('page-' . $page);                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            35         $controller->newVersion($version);                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            36         $controller->newActivePage($page);                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            37         $controller->newModuleName($module);                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            38         $controller->newT($dict);                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            39         $controller->newNav(self::nav($lang, $page, $dict));                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            40         $controller->newLanguages(self::languageSwitch($lang, $page));          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            41         $controller->newBaseUrl($baseUrl);                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            42         $controller->newApiProxyLabel((string)($apiConfig['api_proxy_label'] ...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            43         $controller->newRuntime(array(                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            44             'framework' => 'ASAP',                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            45             'template' => 'Twig via Composer',                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            46             'composer' => defined('ASAP_COMPOSER_AVAILABLE') && ASAP_COMPOSER...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            47             'mode' => 'router/controllers/views/twig/i18n/composer',            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            49             'module' => $module,                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            50             'controller' => $app->getControllerClass(),                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            53         $controller->newEndpointMap(self::endpointMap());                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            60     public static function resolveLang(ASAP_Controller $controller): string {   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            61         $lang = isset($controller->lang) ? strtolower((string)$controller->la...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                            90             'localhost_worker' => 'localhost_worker',                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                           100             'asap_runtime_audit' => 'asap_runtime_audit',                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                           136         $base = rtrim(ASAP_Application::getInstance()->getUrl(), '/');          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                           141     private static function dictionary(string $lang, string $module): array {   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                           144             ROOT . '/application/default/local/' . $lang . '/I18n.xml',         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\helpers\Mokb_helper.class.php                                           145             ROOT . '/application/' . $module . '/local/' . $lang . '/index.xml',
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\templates\layout.tpl                                                     29             <div class="asap-mini">{$t.asap_runtime|escape:'html':'UTF-8'}</div>
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\templates\layout.tpl                                                     40             <div class="top-actions">                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\templates\layout.tpl                                                     48             <span class="badge">ASAP</span>                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\templates\layout.tpl                                                     61                 <span>{$t.runtime_module|escape:'html':'UTF-8'}</span><strong...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\templates\layout.twig                                                    29             <div class="asap-mini">{{ t.asap_runtime }}</div>                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\templates\layout.twig                                                    40             <div class="top-actions">                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\templates\layout.twig                                                    48             <span class="badge">ASAP</span>                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\templates\layout.twig                                                    61                 <span>{{ t.runtime_module }}</span><strong>{{ runtime.module ...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\views\Mokb_view.class.php                                                 6 class Mokb_view extends ASAP_VIEW_Html {                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\views\Mokb_view.class.php                                                15         $moduleScript = ROOT . '/application/' . $this->_app->getModule() . '...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\views\Mokb_view.class.php                                                16         if (is_file($moduleScript)) {                                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\views\Mokb_view.class.php                                                17             $this->addModuleScript('index.js');                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\views\Mokb_view.class.php                                                20         $pageTpl = $this->_controller->getTemplateEngine('twig');               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\views\Mokb_view.class.php                                                21         $pageTpl->loadTemplate('page.twig');                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\views\Mokb_view.class.php                                                23         $this->_controller->newContentHtml($pageTpl->parse());                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\views\Mokb_view.class.php                                                25         $layout = $this->_controller->getTemplateEngine('twig');                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\default\views\Mokb_view.class.php                                                26         $layout->loadTemplate('layout.twig', 'default');                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\ecoute\Index_controller.class.php                                                 8 class Index_controller extends ASAP_Controller {                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\ecoute\Index_controller.class.php                                                 9     public function default_action() { return $this->show_action(); }           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\ecoute\Index_controller.class.php                                                10     public function show_action() {                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\ecoute\javascript\index.js                                                        4         $('body').attr('data-module-ready', 'ecoute');                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\k2000\Index_controller.class.php                                                  8 class Index_controller extends ASAP_Controller {                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\k2000\Index_controller.class.php                                                  9     public function default_action() { return $this->show_action(); }           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\k2000\Index_controller.class.php                                                 10     public function show_action() {                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\k2000\javascript\index.js                                                         4         $('body').attr('data-module-ready', 'k2000');                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\k2000\templates\page.tpl                                                          3     <div class="grid two"><article class="card"><h4>{$t.policy_title|escape:'...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\k2000\templates\page.twig                                                         3     <div class="grid two"><article class="card"><h4>{{ t.policy_title }}</h4>...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\matiere\Index_controller.class.php                                                8 class Index_controller extends ASAP_Controller {                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\matiere\Index_controller.class.php                                                9     public function default_action() { return $this->show_action(); }           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\matiere\Index_controller.class.php                                               10     public function show_action() {                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\matiere\javascript\index.js                                                       4         $('body').attr('data-module-ready', 'matiere');                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\musicien\Index_controller.class.php                                               8 class Index_controller extends ASAP_Controller {                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\musicien\Index_controller.class.php                                               9     public function default_action() { return $this->show_action(); }           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\musicien\Index_controller.class.php                                              10     public function show_action() {                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\musicien\javascript\index.js                                                      4         $('body').attr('data-module-ready', 'musicien');                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\security\Index_controller.class.php                                               8 class Index_controller extends ASAP_Controller {                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\security\Index_controller.class.php                                               9     public function default_action() { return $this->show_action(); }           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\security\Index_controller.class.php                                              10     public function show_action() {                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\security\javascript\index.js                                                      4         $('body').attr('data-module-ready', 'security');                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\security\templates\page.twig                                                      2     <div class="section-title"><div><p class="eyebrow">{{ t.section_eyebrow }...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\technique\Index_controller.class.php                                              8 class Index_controller extends ASAP_Controller {                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\technique\Index_controller.class.php                                              9     public function default_action() { return $this->show_action(); }           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\technique\Index_controller.class.php                                             10     public function show_action() {                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\technique\javascript\index.js                                                     4         $('body').attr('data-module-ready', 'technique');                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\technique\templates\page.tpl                                                      9             <button class="btn secondary" data-load="localhost_worker">{$t.bt...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\application\technique\templates\page.twig                                                     9             <button class="btn secondary" data-load="localhost_worker">{{ t.b...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\assets\js\common.js                                                                           7         localhost_worker: '#tech-output',                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\assets\js\common.js                                                                          18         asap_runtime_audit: '#api-output'                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\assets\js\common.js                                                                         129             cache: false,                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\config\api.php                                                                                3  * MO_KB_FRONT_ASAP local configuration.                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\config\api.php                                                                                4  * Front PHP/ASAP must never write directly into MO_KB_STORE or the canonical...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\config\api.php                                                                               14         'localhost_worker' => ['method' => 'GET', 'path' => '/api/workers/loc...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\config\api.php                                                                               25         'asap_runtime_audit' => ['method' => 'LOCAL', 'path' => '/tools/asap_...
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59H_ASAP_COMPOSER_TWIG_FULL_UPDATE\DEPENDENCY_UPGRADE_MANIFEST.json          2   "patch": "P110B59H_ASAP_COMPOSER_TWIG_FULL_UPDATE",                           
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59H_ASAP_COMPOSER_TWIG_FULL_UPDATE\DEPENDENCY_UPGRADE_MANIFEST.json          4   "active_template_engine": "twig/twig",                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59H_ASAP_COMPOSER_TWIG_FULL_UPDATE\DEPENDENCY_UPGRADE_MANIFEST.json          6     "twig/twig": {                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59H_ASAP_COMPOSER_TWIG_FULL_UPDATE\DEPENDENCY_UPGRADE_MANIFEST.json          8       "role": "template engine active"                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59H_ASAP_COMPOSER_TWIG_FULL_UPDATE\DEPENDENCY_UPGRADE_MANIFEST.json         12       "role": "Twig debug dump helper"                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59H_ASAP_COMPOSER_TWIG_FULL_UPDATE\DEPENDENCY_UPGRADE_MANIFEST.json         20       "role": "database abstraction modernization"                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59H_ASAP_COMPOSER_TWIG_FULL_UPDATE\DEPENDENCY_UPGRADE_MANIFEST.json         23   "asap_engines_audited": [                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59H_ASAP_COMPOSER_TWIG_FULL_UPDATE\DEPENDENCY_UPGRADE_MANIFEST.json         25     "Controller",                                                               
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59H_ASAP_COMPOSER_TWIG_FULL_UPDATE\DEPENDENCY_UPGRADE_MANIFEST.json         27     "I18N",                                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59H_ASAP_COMPOSER_TWIG_FULL_UPDATE\DEPENDENCY_UPGRADE_MANIFEST.json         34     "TemplateTwig"                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\DOC\patches\P110B59H_ASAP_COMPOSER_TWIG_FULL_UPDATE\DEPENDENCY_UPGRADE_MANIFEST.json         37     "Smarty-3.0.7",                                                             
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\autoloader.class.php                                                                2 require_once __DIR__ . '/ASAP/bootstrap.php';                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\autoloader.class.php                                                               22     private string $_cachePath = '';                                            
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\autoloader.class.php                                                               32             self::$_instance->setCachePath($pTmpPath);                          



```

## Cache / scories suivies par Git

```text
var/cache/twig/9a/9a1a5196c6f00ff2eaf4781aa551f303.php

var/cache/twig/9a/9a1a5196c6f00ff2eaf4781aa551f303.php



```

## État final Git

```text
## master...origin/master

```
