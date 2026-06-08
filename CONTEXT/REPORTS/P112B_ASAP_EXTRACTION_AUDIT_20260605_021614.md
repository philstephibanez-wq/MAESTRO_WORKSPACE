# P112B ASAP EXTRACTION AUDIT

Date: 2026-06-05 02:16:15

Contrat:
- Aucun patch.
- Aucune copie.
- Aucune suppression.
- Audit uniquement.

Source candidate:
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP

Objectif:
- Identifier ce qui appartient au framework ASAP.
- Identifier ce qui appartient à MO_KB_FRONT.
- Identifier les scories à ne pas extraire.

## Source exists
```text
True

```

## Git status MO_KB_FRONT
```text
## master...origin/master

```

## ASAP framework candidates
```text

FullName                                                                         
--------                                                                         
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



```

## Legacy libs candidates
```text

FullName                                                   
--------                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\adodb5      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\x64         



```

## MO_KB-specific markers inside framework candidate
```text

Path                                                                       LineNumber Line                                                                                                                                                       
----                                                                       ---------- ----                                                                                                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\Application.class.php               94         // and one local folder through path prefixes (/demo, /maestro).                                                                                   
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\Validator.class.php                  8  * @author Steph. IBANEZ <support@logandplay.com>                                                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\SITE\Site.class.php                 28         $this->_pathPrefix = self::normalizePathPrefix((string)($data['pathPrefix'] ?? ($id === 'logandplay' ? '' : $id)));                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\SITE\SiteResolver.class.php          5     public static function resolve($packagesConfig, string $defaultSiteId = 'logandplay', string $basePath = '', ?array &$catalog = null): ASAP_SITE_Site {
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\SITE\SiteResolver.class.php         18         // 1) Dedicated host wins. Example: demo.logandplay.localhost must always                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\SITE\SiteResolver.class.php         27         //    /LOGANDPLAY_ASAP_LOCAL_PACKAGES/demo/...    -> demo                                                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\SITE\SiteResolver.class.php         28         //    /LOGANDPLAY_ASAP_LOCAL_PACKAGES/maestro/... -> maestro                                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\SITE\SiteResolver.class.php         57         $fallback = new ASAP_SITE_Site('logandplay', array(                                                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\SITE\SiteResolver.class.php         59             'hosts' => 'logandplay.localhost,localhost,127.0.0.1',                                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\SITE\SiteResolver.class.php         61             'theme' => 'logandplay',                                                                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\SITE\SiteResolver.class.php         68         ), $host, defined('ROOT') ? ROOT . '/sites/logandplay' : '');                                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\TEMPLATE\Smarty.class.php            9             throw new ASAP_Exception('Legacy Smarty runtime not available. Active MO_KB template engine is Twig.');                                        
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\ASAP\TEMPLATE\Twig.class.php             12                 "Twig vendor missing. Run H:\\MO_KB_FRONT_ASAP\\tools\\ASAP_FULL_UPDATE.cmd or: cd /d H:\\MO_KB_FRONT_ASAP && composer install"            



```

## Scories candidates inside ASAP source
```text

FullName                                                                                                                                       
--------                                                                                                                                       
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
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test\contents.html                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test\phpmailerTest.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test\test.png                                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test\test_callback.php                                                                
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\PHPMailer\test\testemail.php                                                                    
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\cache\749422d4cfc3eb5677cf499730392b6accd4d1c7.index.tpl.php                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates_c\0013c647e9502d41f43f2055ab8406140c2510c6.test.conf.config.php     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates_c\10e0737838b4a574ef135d0c601e7b602cfaf37a.file.header.tpl.cache.php
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates_c\1be7ff7fdee636597edd726ee98dfef4bfd55d1f.file.footer.tpl.cache.php
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates_c\59399816f5ba59b26c7204ef6ebb1bb339774ca6.file.debug.tpl.php       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\framework\libs\Smarty-3.0.7\demo\templates_c\749422d4cfc3eb5677cf499730392b6accd4d1c7.file.index.tpl.cache.php 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\vendor\twig\twig\src\Cache\CacheInterface.php                                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\vendor\twig\twig\src\Cache\ChainCache.php                                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\vendor\twig\twig\src\Cache\FilesystemCache.php                                                                 
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\vendor\twig\twig\src\Cache\NullCache.php                                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\vendor\twig\twig\src\Cache\ReadOnlyFilesystemCache.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\vendor\twig\twig\src\Cache\RemovableCacheInterface.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\vendor\twig\twig\src\Node\Expression\Test\ConstantTest.php                                                     
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\vendor\twig\twig\src\Node\Expression\Test\DefinedTest.php                                                      
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\vendor\twig\twig\src\Node\Expression\Test\DivisiblebyTest.php                                                  
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\vendor\twig\twig\src\Node\Expression\Test\EvenTest.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\vendor\twig\twig\src\Node\Expression\Test\NullTest.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\vendor\twig\twig\src\Node\Expression\Test\OddTest.php                                                          
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\vendor\twig\twig\src\Node\Expression\Test\SameasTest.php                                                       
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\vendor\twig\twig\src\Node\Expression\Test\TrueTest.php                                                         
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\vendor\twig\twig\src\Test\IntegrationTestCase.php                                                              
H:\MO_KB_FRONT\MO_KB_FRONT_ASAP\vendor\twig\twig\src\Test\NodeTestCase.php                                                                     



```

## Final Git status MO_KB_FRONT
```text
## master...origin/master

```
