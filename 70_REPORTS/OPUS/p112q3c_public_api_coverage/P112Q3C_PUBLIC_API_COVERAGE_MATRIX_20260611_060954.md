# P112Q3C — Opus Public API Coverage Matrix

Generated at: `2026-06-11T06:09:54+00:00`

## Contract note

This report detects unit/contract/recipe **coverage candidates** from local source references.
It does not pretend that a textual reference proves behavioral assertion coverage.

## Summary

| Metric | Count |
|---|---:|
| Symbols | 206 |
| Public methods | 580 |
| Unit candidates | 215 |
| Integration only | 318 |
| Missing test reference | 47 |
| Methods with docblock | 216 |
| Methods in RefBook-tagged source | 536 |

## By domain

| Domain | UNIT_CANDIDATE | INTEGRATION_ONLY | MISSING_TEST_REFERENCE |
|---|---:|---:|---:|
| ACL | 23 | 7 | 0 |
| ACTION | 0 | 1 | 0 |
| APPLICATION | 0 | 5 | 0 |
| ASSET | 1 | 4 | 5 |
| AUTOLOAD | 0 | 6 | 0 |
| CACHE | 3 | 5 | 0 |
| COMPATIBILITY | 4 | 0 | 3 |
| CONFIG | 12 | 8 | 0 |
| CONTRACT | 1 | 0 | 0 |
| CONTROLLER | 0 | 4 | 0 |
| COOKIE | 0 | 1 | 0 |
| CORE | 8 | 1 | 0 |
| CSS | 0 | 1 | 0 |
| DATABASE | 6 | 25 | 1 |
| DATE | 0 | 2 | 0 |
| DEBUG | 6 | 0 | 0 |
| DIRECTORY | 1 | 1 | 0 |
| DOCUMENTATION | 0 | 4 | 0 |
| EVENT | 0 | 1 | 0 |
| EXCEPTION | 1 | 0 | 0 |
| FILE | 1 | 1 | 0 |
| FORM | 0 | 10 | 0 |
| FSM | 18 | 12 | 3 |
| FTP | 0 | 2 | 0 |
| HELPER | 0 | 5 | 0 |
| HTTP | 7 | 0 | 0 |
| I18N | 10 | 17 | 0 |
| JAVASCRIPT | 0 | 1 | 0 |
| JSON | 1 | 2 | 2 |
| LANGUAGE | 0 | 1 | 0 |
| LINK | 5 | 1 | 0 |
| LOG | 2 | 4 | 1 |
| LSTSA | 0 | 62 | 18 |
| MAIL | 0 | 2 | 0 |
| MENU | 0 | 6 | 0 |
| MODEL | 4 | 0 | 0 |
| MODULE | 0 | 4 | 2 |
| PACKAGE | 7 | 3 | 0 |
| REFBOOK | 23 | 17 | 4 |
| RENDERER | 1 | 5 | 0 |
| REQUEST | 1 | 1 | 0 |
| RESPONSE | 3 | 1 | 0 |
| REST | 1 | 0 | 0 |
| ROUTER | 1 | 6 | 0 |
| ROUTING | 21 | 6 | 0 |
| SECURITY | 0 | 10 | 2 |
| SESSION | 3 | 4 | 1 |
| SITE | 3 | 2 | 0 |
| SMTP | 0 | 1 | 0 |
| SUPPORT | 4 | 0 | 0 |
| TEMPLATE | 13 | 6 | 0 |
| THEME | 0 | 1 | 0 |
| URL | 11 | 5 | 2 |
| VALIDATION | 8 | 41 | 0 |
| VIEW | 1 | 3 | 1 |
| XML | 0 | 0 | 2 |

## Public method matrix

| Status | Domain | Symbol | Method | Unit | Smoke | Recipe | File |
|---|---|---|---|---:|---:|---:|---|
| UNIT_CANDIDATE | ACL | `Opus\Acl\AccessConditionInterface` | `allows` | yes | no | no | `framework/Opus/Acl/AccessConditionInterface.php:74` |
| INTEGRATION_ONLY | ACL | `Opus\Acl\AccessContext` | `__construct` | no | no | yes | `framework/Opus/Acl/AccessContext.php:91` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\AccessContext` | `get` | yes | yes | yes | `framework/Opus/Acl/AccessContext.php:141` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\AccessContext` | `has` | yes | yes | yes | `framework/Opus/Acl/AccessContext.php:115` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\AccessContext` | `refBookDomain` | yes | no | no | `framework/Opus/Acl/AccessContext.php:69` |
| INTEGRATION_ONLY | ACL | `Opus\Acl\AccessControl` | `__construct` | no | yes | yes | `framework/Opus/Acl/AccessControl.php:113` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\AccessControl` | `decide` | yes | yes | yes | `framework/Opus/Acl/AccessControl.php:186` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\AccessControl` | `refBookDomain` | yes | yes | yes | `framework/Opus/Acl/AccessControl.php:78` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\AccessControlException` | `contract` | yes | yes | yes | `framework/Opus/Acl/AccessControlException.php:100` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\AccessControlException` | `refBookDomain` | yes | no | yes | `framework/Opus/Acl/AccessControlException.php:75` |
| INTEGRATION_ONLY | ACL | `Opus\Acl\AccessDecision` | `__construct` | no | no | yes | `framework/Opus/Acl/AccessDecision.php:92` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\AccessDecision` | `allowed` | yes | yes | yes | `framework/Opus/Acl/AccessDecision.php:115` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\AccessDecision` | `reason` | yes | no | yes | `framework/Opus/Acl/AccessDecision.php:137` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\AccessDecision` | `refBookDomain` | yes | no | no | `framework/Opus/Acl/AccessDecision.php:69` |
| INTEGRATION_ONLY | ACL | `Opus\Acl\AccessRule` | `__construct` | no | yes | yes | `framework/Opus/Acl/AccessRule.php:103` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\AccessRule` | `allows` | yes | yes | yes | `framework/Opus/Acl/AccessRule.php:159` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\AccessRule` | `condition` | yes | yes | yes | `framework/Opus/Acl/AccessRule.php:181` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\AccessRule` | `key` | yes | yes | yes | `framework/Opus/Acl/AccessRule.php:137` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\AccessRule` | `refBookDomain` | yes | yes | yes | `framework/Opus/Acl/AccessRule.php:72` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\Acl` | `canView` | yes | no | yes | `framework/Opus/Acl/Acl.php:82` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\Acl` | `refBookDomain` | yes | no | yes | `framework/Opus/Acl/Acl.php:65` |
| INTEGRATION_ONLY | ACL | `Opus\Acl\PrivilegeDefinition` | `__construct` | no | yes | yes | `framework/Opus/Acl/PrivilegeDefinition.php:92` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\PrivilegeDefinition` | `id` | yes | yes | yes | `framework/Opus/Acl/PrivilegeDefinition.php:120` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\PrivilegeDefinition` | `refBookDomain` | yes | yes | yes | `framework/Opus/Acl/PrivilegeDefinition.php:68` |
| INTEGRATION_ONLY | ACL | `Opus\Acl\ResourceDefinition` | `__construct` | no | yes | yes | `framework/Opus/Acl/ResourceDefinition.php:92` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\ResourceDefinition` | `id` | yes | yes | yes | `framework/Opus/Acl/ResourceDefinition.php:120` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\ResourceDefinition` | `refBookDomain` | yes | yes | yes | `framework/Opus/Acl/ResourceDefinition.php:68` |
| INTEGRATION_ONLY | ACL | `Opus\Acl\RoleDefinition` | `__construct` | no | yes | yes | `framework/Opus/Acl/RoleDefinition.php:92` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\RoleDefinition` | `id` | yes | yes | yes | `framework/Opus/Acl/RoleDefinition.php:120` |
| UNIT_CANDIDATE | ACL | `Opus\Acl\RoleDefinition` | `refBookDomain` | yes | yes | yes | `framework/Opus/Acl/RoleDefinition.php:68` |
| INTEGRATION_ONLY | ACTION | `Opus\Action\Action` | `__construct` | no | no | yes | `framework/Opus/Action/Action.php:25` |
| INTEGRATION_ONLY | APPLICATION | `Opus\Application\Application` | `__construct` | no | no | yes | `framework/Opus/Application/Application.php:61` |
| INTEGRATION_ONLY | APPLICATION | `Opus\Application\Application` | `run` | no | yes | yes | `framework/Opus/Application/Application.php:83` |
| INTEGRATION_ONLY | APPLICATION | `Opus\Application\ApplicationFacade` | `__construct` | no | no | yes | `framework/Opus/Application/ApplicationFacade.php:44` |
| INTEGRATION_ONLY | APPLICATION | `Opus\Application\ApplicationFacade` | `run` | no | yes | yes | `framework/Opus/Application/ApplicationFacade.php:49` |
| INTEGRATION_ONLY | APPLICATION | `Opus\Application\ApplicationPaths` | `__construct` | no | no | yes | `framework/Opus/Application/ApplicationPaths.php:47` |
| INTEGRATION_ONLY | ASSET | `Opus\Asset\Asset` | `__construct` | no | no | yes | `framework/Opus/Asset/Asset.php:44` |
| INTEGRATION_ONLY | ASSET | `Opus\Asset\Asset` | `css` | no | yes | no | `framework/Opus/Asset/Asset.php:58` |
| MISSING_TEST_REFERENCE | ASSET | `Opus\Asset\Asset` | `image` | no | no | no | `framework/Opus/Asset/Asset.php:68` |
| MISSING_TEST_REFERENCE | ASSET | `Opus\Asset\Asset` | `isCss` | no | no | no | `framework/Opus/Asset/Asset.php:73` |
| MISSING_TEST_REFERENCE | ASSET | `Opus\Asset\Asset` | `isImage` | no | no | no | `framework/Opus/Asset/Asset.php:83` |
| MISSING_TEST_REFERENCE | ASSET | `Opus\Asset\Asset` | `isJs` | no | no | no | `framework/Opus/Asset/Asset.php:78` |
| UNIT_CANDIDATE | ASSET | `Opus\Asset\Asset` | `js` | yes | yes | yes | `framework/Opus/Asset/Asset.php:63` |
| INTEGRATION_ONLY | ASSET | `Opus\Asset\AssetDefinition` | `__construct` | no | no | yes | `framework/Opus/Asset/AssetDefinition.php:37` |
| INTEGRATION_ONLY | ASSET | `Opus\Asset\AssetRegistry` | `add` | no | yes | yes | `framework/Opus/Asset/AssetRegistry.php:48` |
| MISSING_TEST_REFERENCE | ASSET | `Opus\Asset\AssetRegistry` | `byType` | no | no | no | `framework/Opus/Asset/AssetRegistry.php:60` |
| INTEGRATION_ONLY | AUTOLOAD | `Opus\Autoload\AutoloadCache` | `__construct` | no | no | yes | `framework/Opus/Autoload/AutoloadCache.php:40` |
| INTEGRATION_ONLY | AUTOLOAD | `Opus\Autoload\AutoloadCache` | `defaultCacheFile` | no | no | yes | `framework/Opus/Autoload/AutoloadCache.php:46` |
| INTEGRATION_ONLY | AUTOLOAD | `Opus\Autoload\AutoloadCache` | `load` | no | yes | yes | `framework/Opus/Autoload/AutoloadCache.php:59` |
| INTEGRATION_ONLY | AUTOLOAD | `Opus\Autoload\AutoloadCache` | `register` | no | yes | yes | `framework/Opus/Autoload/AutoloadCache.php:83` |
| INTEGRATION_ONLY | AUTOLOAD | `Opus\Autoload\ClassMapBuilder` | `build` | no | yes | yes | `framework/Opus/Autoload/ClassMapBuilder.php:49` |
| INTEGRATION_ONLY | AUTOLOAD | `Opus\Autoload\ClassMapBuilder` | `write` | no | yes | yes | `framework/Opus/Autoload/ClassMapBuilder.php:110` |
| UNIT_CANDIDATE | CACHE | `Opus\Cache\Cache` | `all` | yes | yes | yes | `framework/Opus/Cache/Cache.php:84` |
| INTEGRATION_ONLY | CACHE | `Opus\Cache\Cache` | `clear` | no | yes | yes | `framework/Opus/Cache/Cache.php:71` |
| INTEGRATION_ONLY | CACHE | `Opus\Cache\Cache` | `count` | no | yes | yes | `framework/Opus/Cache/Cache.php:76` |
| UNIT_CANDIDATE | CACHE | `Opus\Cache\Cache` | `get` | yes | yes | yes | `framework/Opus/Cache/Cache.php:47` |
| INTEGRATION_ONLY | CACHE | `Opus\Cache\Cache` | `getOrDefault` | no | no | yes | `framework/Opus/Cache/Cache.php:56` |
| INTEGRATION_ONLY | CACHE | `Opus\Cache\Cache` | `has` | no | yes | yes | `framework/Opus/Cache/Cache.php:61` |
| INTEGRATION_ONLY | CACHE | `Opus\Cache\Cache` | `remove` | no | yes | yes | `framework/Opus/Cache/Cache.php:66` |
| UNIT_CANDIDATE | CACHE | `Opus\Cache\Cache` | `set` | yes | yes | yes | `framework/Opus/Cache/Cache.php:41` |
| UNIT_CANDIDATE | COMPATIBILITY | `Opus\Compatibility\SimpleXMLElementExtended` | `getAttribute` | yes | no | no | `framework/Opus/Compatibility/SimpleXMLElementExtended.php:37` |
| UNIT_CANDIDATE | COMPATIBILITY | `Opus\Compatibility\SimpleXMLElementExtended` | `getAttributeCount` | yes | no | no | `framework/Opus/Compatibility/SimpleXMLElementExtended.php:48` |
| MISSING_TEST_REFERENCE | COMPATIBILITY | `Opus\Compatibility\SimpleXMLElementExtended` | `getAttributeNames` | no | no | no | `framework/Opus/Compatibility/SimpleXMLElementExtended.php:56` |
| MISSING_TEST_REFERENCE | COMPATIBILITY | `Opus\Compatibility\SimpleXMLElementExtended` | `getAttributesArray` | no | no | no | `framework/Opus/Compatibility/SimpleXMLElementExtended.php:64` |
| UNIT_CANDIDATE | COMPATIBILITY | `Opus\Compatibility\SimpleXMLElementExtended` | `getChildrenCount` | yes | no | no | `framework/Opus/Compatibility/SimpleXMLElementExtended.php:80` |
| MISSING_TEST_REFERENCE | COMPATIBILITY | `Opus\Compatibility\Singleton` | `__call` | no | no | no | `framework/Opus/Compatibility/Singleton.php:59` |
| UNIT_CANDIDATE | COMPATIBILITY | `Opus\Compatibility\Singleton` | `getInstance` | yes | no | no | `framework/Opus/Compatibility/Singleton.php:42` |
| INTEGRATION_ONLY | CONFIG | `Opus\Config\ConfigBag` | `__construct` | no | no | yes | `framework/Opus/Config/ConfigBag.php:41` |
| INTEGRATION_ONLY | CONFIG | `Opus\Config\ConfigBag` | `boolean` | no | no | yes | `framework/Opus/Config/ConfigBag.php:67` |
| INTEGRATION_ONLY | CONFIG | `Opus\Config\ConfigBag` | `integer` | no | no | yes | `framework/Opus/Config/ConfigBag.php:56` |
| INTEGRATION_ONLY | CONFIG | `Opus\Config\ConfigBag` | `string` | no | yes | yes | `framework/Opus/Config/ConfigBag.php:45` |
| INTEGRATION_ONLY | CONFIG | `Opus\Config\ConfigException` | `because` | no | yes | yes | `framework/Opus/Config/ConfigException.php:34` |
| INTEGRATION_ONLY | CONFIG | `Opus\Config\ConfigLoader` | `__construct` | no | no | yes | `framework/Opus/Config/ConfigLoader.php:43` |
| UNIT_CANDIDATE | CONFIG | `Opus\Config\ConfigLoader` | `getConfig` | yes | no | yes | `framework/Opus/Config/ConfigLoader.php:81` |
| UNIT_CANDIDATE | CONFIG | `Opus\Config\ConfigLoader` | `load` | yes | yes | yes | `framework/Opus/Config/ConfigLoader.php:50` |
| INTEGRATION_ONLY | CONFIG | `Opus\Config\Configuration` | `__construct` | no | no | yes | `framework/Opus/Config/Configuration.php:47` |
| UNIT_CANDIDATE | CONFIG | `Opus\Config\Configuration` | `all` | yes | yes | yes | `framework/Opus/Config/Configuration.php:116` |
| UNIT_CANDIDATE | CONFIG | `Opus\Config\Configuration` | `get` | yes | yes | yes | `framework/Opus/Config/Configuration.php:57` |
| UNIT_CANDIDATE | CONFIG | `Opus\Config\Configuration` | `getDatabase` | yes | no | no | `framework/Opus/Config/Configuration.php:75` |
| UNIT_CANDIDATE | CONFIG | `Opus\Config\Configuration` | `getEnv` | yes | no | no | `framework/Opus/Config/Configuration.php:80` |
| UNIT_CANDIDATE | CONFIG | `Opus\Config\Configuration` | `getRoutes` | yes | no | no | `framework/Opus/Config/Configuration.php:94` |
| UNIT_CANDIDATE | CONFIG | `Opus\Config\Configuration` | `get_browser` | yes | no | no | `framework/Opus/Config/Configuration.php:99` |
| UNIT_CANDIDATE | CONFIG | `Opus\Config\Configuration` | `get_os` | yes | no | no | `framework/Opus/Config/Configuration.php:106` |
| UNIT_CANDIDATE | CONFIG | `Opus\Config\Configuration` | `has` | yes | yes | yes | `framework/Opus/Config/Configuration.php:52` |
| UNIT_CANDIDATE | CONFIG | `Opus\Config\Configuration` | `set` | yes | yes | yes | `framework/Opus/Config/Configuration.php:66` |
| UNIT_CANDIDATE | CONFIG | `Opus\Config\Configuration` | `setEnv` | yes | no | no | `framework/Opus/Config/Configuration.php:85` |
| INTEGRATION_ONLY | CONFIG | `Opus\Config\XmlConfigReader` | `read` | no | yes | yes | `framework/Opus/Config/XmlConfigReader.php:40` |
| UNIT_CANDIDATE | CONTRACT | `Opus\Contract\ContractException` | `because` | yes | yes | yes | `framework/Opus/Contract/ContractException.php:48` |
| INTEGRATION_ONLY | CONTROLLER | `Opus\Controller\Controller` | `__construct` | no | no | yes | `framework/Opus/Controller/Controller.php:43` |
| INTEGRATION_ONLY | CONTROLLER | `Opus\Controller\ControllerDispatcher` | `__construct` | no | no | yes | `framework/Opus/Controller/ControllerDispatcher.php:53` |
| INTEGRATION_ONLY | CONTROLLER | `Opus\Controller\ControllerDispatcher` | `dispatch` | no | yes | yes | `framework/Opus/Controller/ControllerDispatcher.php:60` |
| INTEGRATION_ONLY | CONTROLLER | `Opus\Controller\ControllerException` | `because` | no | yes | yes | `framework/Opus/Controller/ControllerException.php:37` |
| INTEGRATION_ONLY | COOKIE | `Opus\Cookie\Cookie` | `__construct` | no | no | yes | `framework/Opus/Cookie/Cookie.php:25` |
| UNIT_CANDIDATE | CORE | `Opus\Core\Bootstrap` | `run` | yes | yes | yes | `framework/Opus/Core/Bootstrap.php:39` |
| INTEGRATION_ONLY | CORE | `Opus\Core\Kernel` | `__construct` | no | no | yes | `framework/Opus/Core/Kernel.php:35` |
| UNIT_CANDIDATE | CORE | `Opus\Core\Kernel` | `apiUrl` | yes | no | yes | `framework/Opus/Core/Kernel.php:59` |
| UNIT_CANDIDATE | CORE | `Opus\Core\Kernel` | `assetUrl` | yes | no | yes | `framework/Opus/Core/Kernel.php:64` |
| UNIT_CANDIDATE | CORE | `Opus\Core\Kernel` | `getPackage` | yes | no | yes | `framework/Opus/Core/Kernel.php:49` |
| UNIT_CANDIDATE | CORE | `Opus\Core\Kernel` | `handle` | yes | yes | yes | `framework/Opus/Core/Kernel.php:76` |
| UNIT_CANDIDATE | CORE | `Opus\Core\Kernel` | `packageUrl` | yes | no | yes | `framework/Opus/Core/Kernel.php:69` |
| UNIT_CANDIDATE | CORE | `Opus\Core\Kernel` | `pageUrl` | yes | no | yes | `framework/Opus/Core/Kernel.php:54` |
| UNIT_CANDIDATE | CORE | `Opus\Core\Kernel` | `rootDir` | yes | no | yes | `framework/Opus/Core/Kernel.php:44` |
| INTEGRATION_ONLY | CSS | `Opus\Css\Css` | `__construct` | no | no | yes | `framework/Opus/Css/Css.php:25` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\Database` | `__construct` | no | no | yes | `framework/Opus/Database/Database.php:40` |
| UNIT_CANDIDATE | DATABASE | `Opus\Database\Database` | `pdo` | yes | no | yes | `framework/Opus/Database/Database.php:44` |
| UNIT_CANDIDATE | DATABASE | `Opus\Database\DatabaseConfigLoader` | `fromXml` | yes | yes | yes | `framework/Opus/Database/DatabaseConfigLoader.php:51` |
| UNIT_CANDIDATE | DATABASE | `Opus\Database\DatabaseConfigLoader` | `loadXmlFile` | yes | no | no | `framework/Opus/Database/DatabaseConfigLoader.php:36` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\DatabaseConnectionConfig` | `__construct` | no | no | yes | `framework/Opus/Database/DatabaseConnectionConfig.php:37` |
| UNIT_CANDIDATE | DATABASE | `Opus\Database\DatabaseConnectionConfig` | `normalizedProvider` | yes | no | yes | `framework/Opus/Database/DatabaseConnectionConfig.php:52` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\DatabaseConnectionConfig` | `optionalParameter` | no | no | yes | `framework/Opus/Database/DatabaseConnectionConfig.php:72` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\DatabaseConnectionConfig` | `parameter` | no | no | yes | `framework/Opus/Database/DatabaseConnectionConfig.php:57` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\DatabaseConnectionsConfig` | `__construct` | no | no | yes | `framework/Opus/Database/DatabaseConnectionsConfig.php:38` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\DatabaseConnectionsConfig` | `all` | no | yes | yes | `framework/Opus/Database/DatabaseConnectionsConfig.php:116` |
| MISSING_TEST_REFERENCE | DATABASE | `Opus\Database\DatabaseConnectionsConfig` | `assertValidName` | no | no | no | `framework/Opus/Database/DatabaseConnectionsConfig.php:59` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\DatabaseConnectionsConfig` | `count` | no | yes | yes | `framework/Opus/Database/DatabaseConnectionsConfig.php:74` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\DatabaseConnectionsConfig` | `defaultName` | no | no | yes | `framework/Opus/Database/DatabaseConnectionsConfig.php:93` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\DatabaseConnectionsConfig` | `get` | no | yes | yes | `framework/Opus/Database/DatabaseConnectionsConfig.php:84` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\DatabaseConnectionsConfig` | `has` | no | yes | yes | `framework/Opus/Database/DatabaseConnectionsConfig.php:79` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\DatabaseConnectionsConfig` | `names` | no | no | yes | `framework/Opus/Database/DatabaseConnectionsConfig.php:69` |
| UNIT_CANDIDATE | DATABASE | `Opus\Database\DatabaseDsnFactory` | `build` | yes | yes | yes | `framework/Opus/Database/DatabaseDsnFactory.php:32` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\DatabaseException` | `because` | no | yes | yes | `framework/Opus/Database/DatabaseException.php:34` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\DatabaseMultiConfigLoader` | `fromXml` | no | yes | yes | `framework/Opus/Database/DatabaseMultiConfigLoader.php:62` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\DatabaseMultiConfigLoader` | `loadXmlFile` | no | no | yes | `framework/Opus/Database/DatabaseMultiConfigLoader.php:47` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\DatabaseProvider` | `assertSupported` | no | no | yes | `framework/Opus/Database/DatabaseProvider.php:70` |
| UNIT_CANDIDATE | DATABASE | `Opus\Database\DatabaseProvider` | `normalize` | yes | yes | yes | `framework/Opus/Database/DatabaseProvider.php:57` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\DatabaseProvider` | `pdoDriver` | no | no | yes | `framework/Opus/Database/DatabaseProvider.php:81` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\DatabaseProvider` | `supported` | no | yes | yes | `framework/Opus/Database/DatabaseProvider.php:44` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\Mysql` | `connect` | no | no | yes | `framework/Opus/Database/Mysql.php:32` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\Odbc` | `connect` | no | no | yes | `framework/Opus/Database/Odbc.php:26` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\Oracle` | `connect` | no | no | yes | `framework/Opus/Database/Oracle.php:26` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\PdoDatabaseConnector` | `__construct` | no | no | yes | `framework/Opus/Database/PdoDatabaseConnector.php:35` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\PdoDatabaseConnector` | `connect` | no | no | yes | `framework/Opus/Database/PdoDatabaseConnector.php:39` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\Postgresql` | `connect` | no | no | yes | `framework/Opus/Database/Postgresql.php:26` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\SqlServer` | `connect` | no | no | yes | `framework/Opus/Database/SqlServer.php:26` |
| INTEGRATION_ONLY | DATABASE | `Opus\Database\Sqlite` | `connect` | no | no | yes | `framework/Opus/Database/Sqlite.php:26` |
| INTEGRATION_ONLY | DATE | `Opus\Date\Date` | `now` | no | yes | yes | `framework/Opus/Date/Date.php:26` |
| INTEGRATION_ONLY | DATE | `Opus\Date\Date` | `parse` | no | no | yes | `framework/Opus/Date/Date.php:27` |
| UNIT_CANDIDATE | DEBUG | `Opus\Debug\Debug` | `add` | yes | yes | yes | `framework/Opus/Debug/Debug.php:59` |
| UNIT_CANDIDATE | DEBUG | `Opus\Debug\Debug` | `addClasses` | yes | no | no | `framework/Opus/Debug/Debug.php:74` |
| UNIT_CANDIDATE | DEBUG | `Opus\Debug\Debug` | `addDump` | yes | no | no | `framework/Opus/Debug/Debug.php:86` |
| UNIT_CANDIDATE | DEBUG | `Opus\Debug\Debug` | `dump` | yes | no | no | `framework/Opus/Debug/Debug.php:49` |
| UNIT_CANDIDATE | DEBUG | `Opus\Debug\Debug` | `get` | yes | yes | yes | `framework/Opus/Debug/Debug.php:101` |
| UNIT_CANDIDATE | DEBUG | `Opus\Debug\Debug` | `setDebug` | yes | no | no | `framework/Opus/Debug/Debug.php:54` |
| INTEGRATION_ONLY | DIRECTORY | `Opus\Directory\Directory` | `__construct` | no | no | yes | `framework/Opus/Directory/Directory.php:25` |
| UNIT_CANDIDATE | DIRECTORY | `Opus\Directory\Directory` | `files` | yes | yes | yes | `framework/Opus/Directory/Directory.php:26` |
| INTEGRATION_ONLY | DOCUMENTATION | `Opus\Documentation\MarkdownHtmlRenderer` | `render` | no | yes | yes | `framework/Opus/Documentation/MarkdownHtmlRenderer.php:45` |
| INTEGRATION_ONLY | DOCUMENTATION | `Opus\Documentation\MarkdownPage` | `__construct` | no | no | yes | `framework/Opus/Documentation/MarkdownPage.php:40` |
| INTEGRATION_ONLY | DOCUMENTATION | `Opus\Documentation\MarkdownPageRepository` | `__construct` | no | no | yes | `framework/Opus/Documentation/MarkdownPageRepository.php:40` |
| INTEGRATION_ONLY | DOCUMENTATION | `Opus\Documentation\MarkdownPageRepository` | `get` | no | yes | yes | `framework/Opus/Documentation/MarkdownPageRepository.php:54` |
| INTEGRATION_ONLY | EVENT | `Opus\Event\Event` | `__construct` | no | no | yes | `framework/Opus/Event/Event.php:25` |
| UNIT_CANDIDATE | EXCEPTION | `Opus\Exception\Exception` | `because` | yes | yes | yes | `framework/Opus/Exception/Exception.php:40` |
| INTEGRATION_ONLY | FILE | `Opus\File\File` | `__construct` | no | no | yes | `framework/Opus/File/File.php:25` |
| UNIT_CANDIDATE | FILE | `Opus\File\File` | `read` | yes | yes | yes | `framework/Opus/File/File.php:26` |
| INTEGRATION_ONLY | FORM | `Opus\Form\FormDefinition` | `__construct` | no | no | yes | `framework/Opus/Form/FormDefinition.php:41` |
| INTEGRATION_ONLY | FORM | `Opus\Form\FormDefinition` | `fields` | no | no | yes | `framework/Opus/Form/FormDefinition.php:59` |
| INTEGRATION_ONLY | FORM | `Opus\Form\FormError` | `__construct` | no | no | yes | `framework/Opus/Form/FormError.php:32` |
| INTEGRATION_ONLY | FORM | `Opus\Form\FormException` | `because` | no | yes | yes | `framework/Opus/Form/FormException.php:34` |
| INTEGRATION_ONLY | FORM | `Opus\Form\FormField` | `__construct` | no | no | yes | `framework/Opus/Form/FormField.php:35` |
| INTEGRATION_ONLY | FORM | `Opus\Form\FormValidationResult` | `__construct` | no | no | yes | `framework/Opus/Form/FormValidationResult.php:35` |
| INTEGRATION_ONLY | FORM | `Opus\Form\FormValidationResult` | `isValid` | no | no | yes | `framework/Opus/Form/FormValidationResult.php:39` |
| INTEGRATION_ONLY | FORM | `Opus\Form\FormValidator` | `validate` | no | yes | yes | `framework/Opus/Form/FormValidator.php:38` |
| INTEGRATION_ONLY | FORM | `Opus\Form\SubmittedForm` | `__construct` | no | no | yes | `framework/Opus/Form/SubmittedForm.php:38` |
| INTEGRATION_ONLY | FORM | `Opus\Form\SubmittedForm` | `value` | no | yes | yes | `framework/Opus/Form/SubmittedForm.php:44` |
| UNIT_CANDIDATE | FSM | `Opus\Fsm\Fsm` | `demoFlow` | yes | no | yes | `framework/Opus/Fsm/Fsm.php:83` |
| INTEGRATION_ONLY | FSM | `Opus\Fsm\Fsm` | `refBookDomain` | no | no | yes | `framework/Opus/Fsm/Fsm.php:62` |
| INTEGRATION_ONLY | FSM | `Opus\Fsm\SignalDefinition` | `__construct` | no | no | yes | `framework/Opus/Fsm/SignalDefinition.php:93` |
| UNIT_CANDIDATE | FSM | `Opus\Fsm\SignalDefinition` | `id` | yes | yes | yes | `framework/Opus/Fsm/SignalDefinition.php:121` |
| MISSING_TEST_REFERENCE | FSM | `Opus\Fsm\SignalDefinition` | `refBookDomain` | no | no | no | `framework/Opus/Fsm/SignalDefinition.php:66` |
| UNIT_CANDIDATE | FSM | `Opus\Fsm\StateActionInterface` | `execute` | yes | yes | yes | `framework/Opus/Fsm/StateActionInterface.php:85` |
| INTEGRATION_ONLY | FSM | `Opus\Fsm\StateDefinition` | `__construct` | no | yes | yes | `framework/Opus/Fsm/StateDefinition.php:95` |
| UNIT_CANDIDATE | FSM | `Opus\Fsm\StateDefinition` | `id` | yes | yes | yes | `framework/Opus/Fsm/StateDefinition.php:124` |
| INTEGRATION_ONLY | FSM | `Opus\Fsm\StateDefinition` | `label` | no | yes | yes | `framework/Opus/Fsm/StateDefinition.php:146` |
| INTEGRATION_ONLY | FSM | `Opus\Fsm\StateDefinition` | `refBookDomain` | no | yes | yes | `framework/Opus/Fsm/StateDefinition.php:67` |
| INTEGRATION_ONLY | FSM | `Opus\Fsm\StateMachine` | `__construct` | no | yes | yes | `framework/Opus/Fsm/StateMachine.php:108` |
| UNIT_CANDIDATE | FSM | `Opus\Fsm\StateMachine` | `apply` | yes | yes | yes | `framework/Opus/Fsm/StateMachine.php:218` |
| UNIT_CANDIDATE | FSM | `Opus\Fsm\StateMachine` | `currentState` | yes | yes | yes | `framework/Opus/Fsm/StateMachine.php:151` |
| UNIT_CANDIDATE | FSM | `Opus\Fsm\StateMachine` | `memory` | yes | yes | yes | `framework/Opus/Fsm/StateMachine.php:173` |
| INTEGRATION_ONLY | FSM | `Opus\Fsm\StateMachine` | `refBookDomain` | no | yes | yes | `framework/Opus/Fsm/StateMachine.php:74` |
| UNIT_CANDIDATE | FSM | `Opus\Fsm\StateMachineException` | `contract` | yes | yes | yes | `framework/Opus/Fsm/StateMachineException.php:111` |
| INTEGRATION_ONLY | FSM | `Opus\Fsm\StateMachineException` | `refBookDomain` | no | no | yes | `framework/Opus/Fsm/StateMachineException.php:74` |
| UNIT_CANDIDATE | FSM | `Opus\Fsm\StateMemory` | `export` | yes | no | yes | `framework/Opus/Fsm/StateMemory.php:152` |
| UNIT_CANDIDATE | FSM | `Opus\Fsm\StateMemory` | `get` | yes | yes | yes | `framework/Opus/Fsm/StateMemory.php:126` |
| MISSING_TEST_REFERENCE | FSM | `Opus\Fsm\StateMemory` | `refBookDomain` | no | no | no | `framework/Opus/Fsm/StateMemory.php:67` |
| UNIT_CANDIDATE | FSM | `Opus\Fsm\StateMemory` | `set` | yes | yes | yes | `framework/Opus/Fsm/StateMemory.php:94` |
| INTEGRATION_ONLY | FSM | `Opus\Fsm\TransitionDefinition` | `__construct` | no | yes | yes | `framework/Opus/Fsm/TransitionDefinition.php:103` |
| UNIT_CANDIDATE | FSM | `Opus\Fsm\TransitionDefinition` | `action` | yes | yes | yes | `framework/Opus/Fsm/TransitionDefinition.php:202` |
| UNIT_CANDIDATE | FSM | `Opus\Fsm\TransitionDefinition` | `fromState` | yes | yes | yes | `framework/Opus/Fsm/TransitionDefinition.php:136` |
| INTEGRATION_ONLY | FSM | `Opus\Fsm\TransitionDefinition` | `key` | no | yes | yes | `framework/Opus/Fsm/TransitionDefinition.php:224` |
| INTEGRATION_ONLY | FSM | `Opus\Fsm\TransitionDefinition` | `refBookDomain` | no | yes | yes | `framework/Opus/Fsm/TransitionDefinition.php:69` |
| UNIT_CANDIDATE | FSM | `Opus\Fsm\TransitionDefinition` | `signal` | yes | yes | yes | `framework/Opus/Fsm/TransitionDefinition.php:158` |
| UNIT_CANDIDATE | FSM | `Opus\Fsm\TransitionDefinition` | `toState` | yes | yes | yes | `framework/Opus/Fsm/TransitionDefinition.php:180` |
| INTEGRATION_ONLY | FSM | `Opus\Fsm\TransitionResult` | `__construct` | no | no | yes | `framework/Opus/Fsm/TransitionResult.php:92` |
| UNIT_CANDIDATE | FSM | `Opus\Fsm\TransitionResult` | `fromState` | yes | no | no | `framework/Opus/Fsm/TransitionResult.php:116` |
| MISSING_TEST_REFERENCE | FSM | `Opus\Fsm\TransitionResult` | `refBookDomain` | no | no | no | `framework/Opus/Fsm/TransitionResult.php:68` |
| UNIT_CANDIDATE | FSM | `Opus\Fsm\TransitionResult` | `signal` | yes | no | yes | `framework/Opus/Fsm/TransitionResult.php:138` |
| UNIT_CANDIDATE | FSM | `Opus\Fsm\TransitionResult` | `toState` | yes | no | yes | `framework/Opus/Fsm/TransitionResult.php:160` |
| INTEGRATION_ONLY | FTP | `Opus\Ftp\Ftp` | `__construct` | no | no | yes | `framework/Opus/Ftp/Ftp.php:38` |
| INTEGRATION_ONLY | FTP | `Opus\Ftp\Ftp` | `host` | no | yes | yes | `framework/Opus/Ftp/Ftp.php:45` |
| INTEGRATION_ONLY | HELPER | `Opus\Helper\Helper` | `escape` | no | yes | yes | `framework/Opus/Helper/Helper.php:38` |
| INTEGRATION_ONLY | HELPER | `Opus\Helper\Helper` | `slug` | no | no | yes | `framework/Opus/Helper/Helper.php:43` |
| INTEGRATION_ONLY | HELPER | `Opus\Helper\HtmlHelper` | `attributes` | no | no | yes | `framework/Opus/Helper/HtmlHelper.php:43` |
| INTEGRATION_ONLY | HELPER | `Opus\Helper\HtmlHelper` | `escape` | no | yes | yes | `framework/Opus/Helper/HtmlHelper.php:35` |
| INTEGRATION_ONLY | HELPER | `Opus\Helper\TextHelper` | `slug` | no | no | yes | `framework/Opus/Helper/TextHelper.php:35` |
| UNIT_CANDIDATE | HTTP | `Opus\Http\Request` | `__construct` | yes | yes | yes | `framework/Opus/Http/Request.php:72` |
| UNIT_CANDIDATE | HTTP | `Opus\Http\Request` | `fromGlobals` | yes | yes | yes | `framework/Opus/Http/Request.php:119` |
| UNIT_CANDIDATE | HTTP | `Opus\Http\Request` | `refBookDomain` | yes | yes | yes | `framework/Opus/Http/Request.php:97` |
| UNIT_CANDIDATE | HTTP | `Opus\Http\Response` | `__construct` | yes | no | yes | `framework/Opus/Http/Response.php:75` |
| UNIT_CANDIDATE | HTTP | `Opus\Http\Response` | `html` | yes | yes | yes | `framework/Opus/Http/Response.php:97` |
| UNIT_CANDIDATE | HTTP | `Opus\Http\Response` | `json` | yes | yes | yes | `framework/Opus/Http/Response.php:115` |
| UNIT_CANDIDATE | HTTP | `Opus\Http\Response` | `send` | yes | yes | yes | `framework/Opus/Http/Response.php:136` |
| INTEGRATION_ONLY | I18N | `Opus\I18n\I18n` | `__construct` | no | no | yes | `framework/Opus/I18n/I18n.php:54` |
| UNIT_CANDIDATE | I18N | `Opus\I18n\I18n` | `dictionary` | yes | no | yes | `framework/Opus/I18n/I18n.php:115` |
| UNIT_CANDIDATE | I18N | `Opus\I18n\I18n` | `getAvalaibleLanguages` | yes | no | yes | `framework/Opus/I18n/I18n.php:74` |
| INTEGRATION_ONLY | I18N | `Opus\I18n\I18n` | `getDictionary` | no | no | yes | `framework/Opus/I18n/I18n.php:121` |
| UNIT_CANDIDATE | I18N | `Opus\I18n\I18n` | `getInstance` | yes | no | yes | `framework/Opus/I18n/I18n.php:62` |
| INTEGRATION_ONLY | I18N | `Opus\I18n\I18n` | `loadDictionary` | no | no | yes | `framework/Opus/I18n/I18n.php:126` |
| INTEGRATION_ONLY | I18N | `Opus\I18n\I18n` | `plural` | no | no | yes | `framework/Opus/I18n/I18n.php:109` |
| UNIT_CANDIDATE | I18N | `Opus\I18n\I18n` | `t` | yes | yes | yes | `framework/Opus/I18n/I18n.php:101` |
| UNIT_CANDIDATE | I18N | `Opus\I18n\I18n` | `translate` | yes | yes | yes | `framework/Opus/I18n/I18n.php:93` |
| UNIT_CANDIDATE | I18N | `Opus\I18n\JsonTranslationCatalogLoader` | `load` | yes | yes | yes | `framework/Opus/I18n/JsonTranslationCatalogLoader.php:47` |
| INTEGRATION_ONLY | I18N | `Opus\I18n\LocaleCode` | `__construct` | no | no | yes | `framework/Opus/I18n/LocaleCode.php:40` |
| UNIT_CANDIDATE | I18N | `Opus\I18n\LocaleCode` | `toString` | yes | no | yes | `framework/Opus/I18n/LocaleCode.php:56` |
| INTEGRATION_ONLY | I18N | `Opus\I18n\PluralRuleInterface` | `select` | no | yes | yes | `framework/Opus/I18n/PluralRuleInterface.php:45` |
| INTEGRATION_ONLY | I18N | `Opus\I18n\Plural\EnglishPluralRule` | `select` | no | yes | yes | `framework/Opus/I18n/Plural/EnglishPluralRule.php:37` |
| INTEGRATION_ONLY | I18N | `Opus\I18n\Plural\FrenchPluralRule` | `select` | no | yes | yes | `framework/Opus/I18n/Plural/FrenchPluralRule.php:37` |
| INTEGRATION_ONLY | I18N | `Opus\I18n\Plural\RussianPluralRule` | `select` | no | yes | yes | `framework/Opus/I18n/Plural/RussianPluralRule.php:40` |
| INTEGRATION_ONLY | I18N | `Opus\I18n\Plural\SpanishPluralRule` | `select` | no | yes | yes | `framework/Opus/I18n/Plural/SpanishPluralRule.php:37` |
| INTEGRATION_ONLY | I18N | `Opus\I18n\TranslationCatalog` | `__construct` | no | no | yes | `framework/Opus/I18n/TranslationCatalog.php:42` |
| UNIT_CANDIDATE | I18N | `Opus\I18n\TranslationCatalog` | `message` | yes | yes | yes | `framework/Opus/I18n/TranslationCatalog.php:49` |
| UNIT_CANDIDATE | I18N | `Opus\I18n\TranslationCatalog` | `messages` | yes | yes | yes | `framework/Opus/I18n/TranslationCatalog.php:78` |
| INTEGRATION_ONLY | I18N | `Opus\I18n\TranslationCatalog` | `plural` | no | no | yes | `framework/Opus/I18n/TranslationCatalog.php:58` |
| INTEGRATION_ONLY | I18N | `Opus\I18n\TranslationCatalog` | `plurals` | no | no | yes | `framework/Opus/I18n/TranslationCatalog.php:84` |
| INTEGRATION_ONLY | I18N | `Opus\I18n\TranslationCatalog` | `toArray` | no | no | yes | `framework/Opus/I18n/TranslationCatalog.php:90` |
| INTEGRATION_ONLY | I18N | `Opus\I18n\TranslationException` | `because` | no | yes | yes | `framework/Opus/I18n/TranslationException.php:48` |
| INTEGRATION_ONLY | I18N | `Opus\I18n\Translator` | `__construct` | no | no | yes | `framework/Opus/I18n/Translator.php:38` |
| INTEGRATION_ONLY | I18N | `Opus\I18n\Translator` | `plural` | no | no | yes | `framework/Opus/I18n/Translator.php:66` |
| UNIT_CANDIDATE | I18N | `Opus\I18n\Translator` | `translate` | yes | yes | yes | `framework/Opus/I18n/Translator.php:52` |
| INTEGRATION_ONLY | JAVASCRIPT | `Opus\Javascript\Javascript` | `__construct` | no | no | yes | `framework/Opus/Javascript/Javascript.php:25` |
| UNIT_CANDIDATE | JSON | `Opus\Json\Json` | `decode` | yes | yes | yes | `framework/Opus/Json/Json.php:57` |
| INTEGRATION_ONLY | JSON | `Opus\Json\Json` | `encode` | no | yes | yes | `framework/Opus/Json/Json.php:41` |
| MISSING_TEST_REFERENCE | JSON | `Opus\Json\Json` | `pretty` | no | no | no | `framework/Opus/Json/Json.php:49` |
| INTEGRATION_ONLY | JSON | `Opus\Json\Json` | `readFile` | no | yes | no | `framework/Opus/Json/Json.php:71` |
| MISSING_TEST_REFERENCE | JSON | `Opus\Json\Json` | `writeFile` | no | no | no | `framework/Opus/Json/Json.php:83` |
| INTEGRATION_ONLY | LANGUAGE | `Opus\Language\Language` | `__construct` | no | no | yes | `framework/Opus/Language/Language.php:25` |
| INTEGRATION_ONLY | LINK | `Opus\Link\Link` | `__construct` | no | no | yes | `framework/Opus/Link/Link.php:45` |
| UNIT_CANDIDATE | LINK | `Opus\Link\Link` | `__toString` | yes | no | no | `framework/Opus/Link/Link.php:56` |
| UNIT_CANDIDATE | LINK | `Opus\Link\Link` | `changeClass` | yes | no | no | `framework/Opus/Link/Link.php:79` |
| UNIT_CANDIDATE | LINK | `Opus\Link\Link` | `changeId` | yes | no | no | `framework/Opus/Link/Link.php:86` |
| UNIT_CANDIDATE | LINK | `Opus\Link\Link` | `getBlock` | yes | no | no | `framework/Opus/Link/Link.php:93` |
| UNIT_CANDIDATE | LINK | `Opus\Link\Link` | `getMode` | yes | no | no | `framework/Opus/Link/Link.php:98` |
| INTEGRATION_ONLY | LOG | `Opus\Log\Log` | `add` | no | yes | yes | `framework/Opus/Log/Log.php:26` |
| UNIT_CANDIDATE | LOG | `Opus\Log\Log` | `entries` | yes | yes | yes | `framework/Opus/Log/Log.php:61` |
| INTEGRATION_ONLY | LOG | `Opus\Log\Log` | `error` | no | yes | yes | `framework/Opus/Log/Log.php:56` |
| UNIT_CANDIDATE | LOG | `Opus\Log\Log` | `info` | yes | no | no | `framework/Opus/Log/Log.php:46` |
| INTEGRATION_ONLY | LOG | `Opus\Log\Log` | `messages` | no | yes | yes | `framework/Opus/Log/Log.php:66` |
| MISSING_TEST_REFERENCE | LOG | `Opus\Log\Log` | `records` | no | no | no | `framework/Opus/Log/Log.php:71` |
| INTEGRATION_ONLY | LOG | `Opus\Log\Log` | `warning` | no | yes | yes | `framework/Opus/Log/Log.php:51` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaArchivePhase` | `execute` | no | yes | yes | `framework/Opus/Lstsa/LstsaArchivePhase.php:32` |
| MISSING_TEST_REFERENCE | LSTSA | `Opus\Lstsa\LstsaArchiveWriter` | `writeReport` | no | no | no | `framework/Opus/Lstsa/LstsaArchiveWriter.php:32` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaBatchExecutor` | `__construct` | no | no | yes | `framework/Opus/Lstsa/LstsaBatchExecutor.php:26` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaBatchExecutor` | `execute` | no | yes | yes | `framework/Opus/Lstsa/LstsaBatchExecutor.php:31` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaConfigLoader` | `fromXml` | no | yes | yes | `framework/Opus/Lstsa/LstsaConfigLoader.php:46` |
| MISSING_TEST_REFERENCE | LSTSA | `Opus\Lstsa\LstsaConfigLoader` | `loadXmlFile` | no | no | no | `framework/Opus/Lstsa/LstsaConfigLoader.php:31` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaDatabaseStagingExecutor` | `__construct` | no | no | yes | `framework/Opus/Lstsa/LstsaDatabaseStagingExecutor.php:43` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaDatabaseStagingExecutor` | `execute` | no | yes | yes | `framework/Opus/Lstsa/LstsaDatabaseStagingExecutor.php:56` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaDefinition` | `__construct` | no | no | yes | `framework/Opus/Lstsa/LstsaDefinition.php:36` |
| MISSING_TEST_REFERENCE | LSTSA | `Opus\Lstsa\LstsaDefinition` | `archiveConnection` | no | no | no | `framework/Opus/Lstsa/LstsaDefinition.php:84` |
| MISSING_TEST_REFERENCE | LSTSA | `Opus\Lstsa\LstsaDefinition` | `archiveMode` | no | no | no | `framework/Opus/Lstsa/LstsaDefinition.php:82` |
| MISSING_TEST_REFERENCE | LSTSA | `Opus\Lstsa\LstsaDefinition` | `archivePath` | no | no | no | `framework/Opus/Lstsa/LstsaDefinition.php:83` |
| MISSING_TEST_REFERENCE | LSTSA | `Opus\Lstsa\LstsaDefinition` | `archiveTable` | no | no | no | `framework/Opus/Lstsa/LstsaDefinition.php:85` |
| MISSING_TEST_REFERENCE | LSTSA | `Opus\Lstsa\LstsaDefinition` | `assertConnections` | no | no | no | `framework/Opus/Lstsa/LstsaDefinition.php:96` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaDefinition` | `id` | no | yes | yes | `framework/Opus/Lstsa/LstsaDefinition.php:75` |
| MISSING_TEST_REFERENCE | LSTSA | `Opus\Lstsa\LstsaDefinition` | `loadConnection` | no | no | no | `framework/Opus/Lstsa/LstsaDefinition.php:77` |
| MISSING_TEST_REFERENCE | LSTSA | `Opus\Lstsa\LstsaDefinition` | `loadFields` | no | no | no | `framework/Opus/Lstsa/LstsaDefinition.php:88` |
| MISSING_TEST_REFERENCE | LSTSA | `Opus\Lstsa\LstsaDefinition` | `loadTable` | no | no | no | `framework/Opus/Lstsa/LstsaDefinition.php:78` |
| MISSING_TEST_REFERENCE | LSTSA | `Opus\Lstsa\LstsaDefinition` | `mappings` | no | no | no | `framework/Opus/Lstsa/LstsaDefinition.php:91` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaDefinition` | `runtime` | no | yes | yes | `framework/Opus/Lstsa/LstsaDefinition.php:94` |
| MISSING_TEST_REFERENCE | LSTSA | `Opus\Lstsa\LstsaDefinition` | `storeConnection` | no | no | no | `framework/Opus/Lstsa/LstsaDefinition.php:79` |
| MISSING_TEST_REFERENCE | LSTSA | `Opus\Lstsa\LstsaDefinition` | `storeMode` | no | no | no | `framework/Opus/Lstsa/LstsaDefinition.php:81` |
| MISSING_TEST_REFERENCE | LSTSA | `Opus\Lstsa\LstsaDefinition` | `storeTable` | no | no | no | `framework/Opus/Lstsa/LstsaDefinition.php:80` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaDefinition` | `version` | no | yes | yes | `framework/Opus/Lstsa/LstsaDefinition.php:76` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaException` | `because` | no | yes | yes | `framework/Opus/Lstsa/LstsaException.php:31` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaFieldConstraint` | `__construct` | no | no | yes | `framework/Opus/Lstsa/LstsaFieldConstraint.php:38` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaFieldConstraint` | `fromXml` | no | yes | yes | `framework/Opus/Lstsa/LstsaFieldConstraint.php:74` |
| MISSING_TEST_REFERENCE | LSTSA | `Opus\Lstsa\LstsaFieldConstraint` | `supportedTypes` | no | no | no | `framework/Opus/Lstsa/LstsaFieldConstraint.php:69` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaFieldConstraint` | `validate` | no | yes | yes | `framework/Opus/Lstsa/LstsaFieldConstraint.php:103` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaFieldMapping` | `__construct` | no | no | yes | `framework/Opus/Lstsa/LstsaFieldMapping.php:34` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaFieldMapping` | `fromXml` | no | yes | yes | `framework/Opus/Lstsa/LstsaFieldMapping.php:55` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaFsmController` | `apply` | no | no | yes | `framework/Opus/Lstsa/LstsaFsmController.php:46` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaFsmState` | `all` | no | yes | yes | `framework/Opus/Lstsa/LstsaFsmState.php:49` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaIdentifier` | `quote` | no | no | yes | `framework/Opus/Lstsa/LstsaIdentifier.php:33` |
| MISSING_TEST_REFERENCE | LSTSA | `Opus\Lstsa\LstsaIdentifier` | `stageTable` | no | no | no | `framework/Opus/Lstsa/LstsaIdentifier.php:42` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaLoadPhase` | `execute` | no | yes | yes | `framework/Opus/Lstsa/LstsaLoadPhase.php:33` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaPhaseInterface` | `execute` | no | yes | yes | `framework/Opus/Lstsa/LstsaPhaseInterface.php:37` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaPipelineContext` | `__construct` | no | no | yes | `framework/Opus/Lstsa/LstsaPipelineContext.php:73` |
| MISSING_TEST_REFERENCE | LSTSA | `Opus\Lstsa\LstsaPipelineContext` | `reject` | no | no | no | `framework/Opus/Lstsa/LstsaPipelineContext.php:87` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaReport` | `__construct` | no | no | yes | `framework/Opus/Lstsa/LstsaReport.php:45` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaReport` | `addCounter` | no | no | yes | `framework/Opus/Lstsa/LstsaReport.php:70` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaReport` | `addMessage` | no | no | yes | `framework/Opus/Lstsa/LstsaReport.php:83` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaReport` | `create` | no | no | yes | `framework/Opus/Lstsa/LstsaReport.php:59` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaReport` | `finish` | no | no | yes | `framework/Opus/Lstsa/LstsaReport.php:91` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaReport` | `runId` | no | no | yes | `framework/Opus/Lstsa/LstsaReport.php:102` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaReport` | `toArray` | no | no | yes | `framework/Opus/Lstsa/LstsaReport.php:108` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaReport` | `toJson` | no | no | yes | `framework/Opus/Lstsa/LstsaReport.php:123` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaReport` | `toMarkdown` | no | no | yes | `framework/Opus/Lstsa/LstsaReport.php:133` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaReportCatalog` | `__construct` | no | no | yes | `framework/Opus/Lstsa/LstsaReportCatalog.php:37` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaReportCatalog` | `build` | no | yes | yes | `framework/Opus/Lstsa/LstsaReportCatalog.php:52` |
| MISSING_TEST_REFERENCE | LSTSA | `Opus\Lstsa\LstsaReportCatalog` | `writeIndex` | no | no | no | `framework/Opus/Lstsa/LstsaReportCatalog.php:97` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaReportPhase` | `execute` | no | yes | yes | `framework/Opus/Lstsa/LstsaReportPhase.php:33` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaRunStatus` | `all` | no | yes | yes | `framework/Opus/Lstsa/LstsaRunStatus.php:33` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaRunStatus` | `assertValid` | no | no | yes | `framework/Opus/Lstsa/LstsaRunStatus.php:49` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaRunStatus` | `isFinal` | no | no | yes | `framework/Opus/Lstsa/LstsaRunStatus.php:56` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaRunStore` | `__construct` | no | no | yes | `framework/Opus/Lstsa/LstsaRunStore.php:25` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaRunStore` | `acquirePendingRun` | no | no | yes | `framework/Opus/Lstsa/LstsaRunStore.php:85` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaRunStore` | `createRun` | no | no | yes | `framework/Opus/Lstsa/LstsaRunStore.php:37` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaRunStore` | `finish` | no | no | yes | `framework/Opus/Lstsa/LstsaRunStore.php:231` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaRunStore` | `heartbeat` | no | no | yes | `framework/Opus/Lstsa/LstsaRunStore.php:124` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaRunStore` | `listRunsByStatus` | no | no | yes | `framework/Opus/Lstsa/LstsaRunStore.php:268` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaRunStore` | `projectRoot` | no | no | yes | `framework/Opus/Lstsa/LstsaRunStore.php:390` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaRunStore` | `readRun` | no | no | yes | `framework/Opus/Lstsa/LstsaRunStore.php:289` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaRunStore` | `writeArchivePayload` | no | no | yes | `framework/Opus/Lstsa/LstsaRunStore.php:173` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaRunStore` | `writeCheckpoint` | no | no | yes | `framework/Opus/Lstsa/LstsaRunStore.php:149` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaRunStore` | `writeEventPayload` | no | no | yes | `framework/Opus/Lstsa/LstsaRunStore.php:212` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaRunStore` | `writeQuarantinePayload` | no | no | yes | `framework/Opus/Lstsa/LstsaRunStore.php:193` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaRunStore` | `writeReport` | no | no | yes | `framework/Opus/Lstsa/LstsaRunStore.php:322` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaRunStore` | `writeRun` | no | no | yes | `framework/Opus/Lstsa/LstsaRunStore.php:306` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaRunner` | `__construct` | no | no | yes | `framework/Opus/Lstsa/LstsaRunner.php:24` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaRunner` | `runOnce` | no | no | yes | `framework/Opus/Lstsa/LstsaRunner.php:29` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaScheduler` | `__construct` | no | no | yes | `framework/Opus/Lstsa/LstsaScheduler.php:24` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaScheduler` | `enqueue` | no | no | yes | `framework/Opus/Lstsa/LstsaScheduler.php:29` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaScheduler` | `enqueueDatabaseStagingSmokeRun` | no | no | yes | `framework/Opus/Lstsa/LstsaScheduler.php:97` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaScheduler` | `enqueueMemoryBatchSmokeRun` | no | no | yes | `framework/Opus/Lstsa/LstsaScheduler.php:58` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaScheduler` | `enqueueSmokeRun` | no | no | yes | `framework/Opus/Lstsa/LstsaScheduler.php:36` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaSecureInputPhase` | `execute` | no | yes | yes | `framework/Opus/Lstsa/LstsaSecureInputPhase.php:32` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaSecureOutputPhase` | `execute` | no | yes | yes | `framework/Opus/Lstsa/LstsaSecureOutputPhase.php:32` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaStorePhase` | `execute` | no | yes | yes | `framework/Opus/Lstsa/LstsaStorePhase.php:37` |
| INTEGRATION_ONLY | LSTSA | `Opus\Lstsa\LstsaTransformPhase` | `execute` | no | yes | yes | `framework/Opus/Lstsa/LstsaTransformPhase.php:32` |
| INTEGRATION_ONLY | MAIL | `Opus\Mail\Mail` | `__construct` | no | no | yes | `framework/Opus/Mail/Mail.php:38` |
| INTEGRATION_ONLY | MAIL | `Opus\Mail\PhpMailer` | `send` | no | yes | yes | `framework/Opus/Mail/PhpMailer.php:38` |
| INTEGRATION_ONLY | MENU | `Opus\Menu\Menu` | `add` | no | yes | yes | `framework/Opus/Menu/Menu.php:41` |
| INTEGRATION_ONLY | MENU | `Opus\Menu\Menu` | `items` | no | no | yes | `framework/Opus/Menu/Menu.php:53` |
| INTEGRATION_ONLY | MENU | `Opus\Menu\MenuException` | `because` | no | yes | yes | `framework/Opus/Menu/MenuException.php:34` |
| INTEGRATION_ONLY | MENU | `Opus\Menu\MenuItem` | `__construct` | no | no | yes | `framework/Opus/Menu/MenuItem.php:38` |
| INTEGRATION_ONLY | MENU | `Opus\Menu\MenuTree` | `__construct` | no | no | yes | `framework/Opus/Menu/MenuTree.php:38` |
| INTEGRATION_ONLY | MENU | `Opus\Menu\MenuTree` | `toArray` | no | no | yes | `framework/Opus/Menu/MenuTree.php:48` |
| UNIT_CANDIDATE | MODEL | `Opus\Model\Model` | `__construct` | yes | no | yes | `framework/Opus/Model/Model.php:44` |
| UNIT_CANDIDATE | MODEL | `Opus\Model\Model` | `all` | yes | yes | yes | `framework/Opus/Model/Model.php:70` |
| UNIT_CANDIDATE | MODEL | `Opus\Model\Model` | `get` | yes | yes | yes | `framework/Opus/Model/Model.php:49` |
| UNIT_CANDIDATE | MODEL | `Opus\Model\Model` | `set` | yes | yes | yes | `framework/Opus/Model/Model.php:58` |
| INTEGRATION_ONLY | MODULE | `Opus\Module\Module` | `__construct` | no | no | yes | `framework/Opus/Module/Module.php:47` |
| MISSING_TEST_REFERENCE | MODULE | `Opus\Module\Module` | `isEnabled` | no | no | no | `framework/Opus/Module/Module.php:62` |
| INTEGRATION_ONLY | MODULE | `Opus\Module\Module` | `option` | no | no | yes | `framework/Opus/Module/Module.php:67` |
| INTEGRATION_ONLY | MODULE | `Opus\Module\ModuleDefinition` | `__construct` | no | no | yes | `framework/Opus/Module/ModuleDefinition.php:37` |
| INTEGRATION_ONLY | MODULE | `Opus\Module\ModuleRegistry` | `__construct` | no | no | yes | `framework/Opus/Module/ModuleRegistry.php:46` |
| MISSING_TEST_REFERENCE | MODULE | `Opus\Module\ModuleRegistry` | `getEnabled` | no | no | no | `framework/Opus/Module/ModuleRegistry.php:53` |
| INTEGRATION_ONLY | PACKAGE | `Opus\Package\Package` | `__construct` | no | no | yes | `framework/Opus/Package/Package.php:40` |
| UNIT_CANDIDATE | PACKAGE | `Opus\Package\Package` | `content` | yes | yes | yes | `framework/Opus/Package/Package.php:77` |
| UNIT_CANDIDATE | PACKAGE | `Opus\Package\Package` | `hasLanguage` | yes | no | no | `framework/Opus/Package/Package.php:66` |
| UNIT_CANDIDATE | PACKAGE | `Opus\Package\Package` | `id` | yes | yes | yes | `framework/Opus/Package/Package.php:56` |
| UNIT_CANDIDATE | PACKAGE | `Opus\Package\Package` | `rootDir` | yes | no | no | `framework/Opus/Package/Package.php:61` |
| INTEGRATION_ONLY | PACKAGE | `Opus\Package\Package` | `routes` | no | yes | yes | `framework/Opus/Package/Package.php:72` |
| INTEGRATION_ONLY | PACKAGE | `Opus\Package\PackageRepository` | `__construct` | no | no | yes | `framework/Opus/Package/PackageRepository.php:39` |
| UNIT_CANDIDATE | PACKAGE | `Opus\Package\PackageRepository` | `all` | yes | yes | yes | `framework/Opus/Package/PackageRepository.php:47` |
| UNIT_CANDIDATE | PACKAGE | `Opus\Package\PackageRepository` | `get` | yes | yes | yes | `framework/Opus/Package/PackageRepository.php:52` |
| UNIT_CANDIDATE | PACKAGE | `Opus\Package\PackageRepository` | `resolve` | yes | yes | no | `framework/Opus/Package/PackageRepository.php:61` |
| INTEGRATION_ONLY | REFBOOK | `Opus\RefBook\Api\LocalizedRefBookDocumentationProvider` | `__construct` | no | yes | yes | `framework/Opus/RefBook/Api/LocalizedRefBookDocumentationProvider.php:36` |
| INTEGRATION_ONLY | REFBOOK | `Opus\RefBook\Api\LocalizedRefBookDocumentationProvider` | `localizeSnapshot` | no | yes | no | `framework/Opus/RefBook/Api/LocalizedRefBookDocumentationProvider.php:44` |
| INTEGRATION_ONLY | REFBOOK | `Opus\RefBook\Api\LocalizedRefBookDocumentationProvider` | `localizeSymbol` | no | yes | no | `framework/Opus/RefBook/Api/LocalizedRefBookDocumentationProvider.php:63` |
| INTEGRATION_ONLY | REFBOOK | `Opus\RefBook\Api\RefBookDocumentationAssetRepository` | `__construct` | no | no | yes | `framework/Opus/RefBook/Api/RefBookDocumentationAssetRepository.php:61` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\Api\RefBookDocumentationAssetRepository` | `diagram` | yes | yes | yes | `framework/Opus/RefBook/Api/RefBookDocumentationAssetRepository.php:117` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\Api\RefBookDocumentationAssetRepository` | `example` | yes | yes | yes | `framework/Opus/RefBook/Api/RefBookDocumentationAssetRepository.php:100` |
| INTEGRATION_ONLY | REFBOOK | `Opus\RefBook\Api\RefBookDocumentationAssetRepository` | `index` | no | yes | yes | `framework/Opus/RefBook/Api/RefBookDocumentationAssetRepository.php:80` |
| INTEGRATION_ONLY | REFBOOK | `Opus\RefBook\Api\RefBookDocumentationAssetRepository` | `refBookDomain` | no | no | yes | `framework/Opus/RefBook/Api/RefBookDocumentationAssetRepository.php:57` |
| INTEGRATION_ONLY | REFBOOK | `Opus\RefBook\Api\RefBookDocumentationI18nRestRouter` | `__construct` | no | yes | yes | `framework/Opus/RefBook/Api/RefBookDocumentationI18nRestRouter.php:32` |
| INTEGRATION_ONLY | REFBOOK | `Opus\RefBook\Api\RefBookDocumentationI18nRestRouter` | `handle` | no | yes | yes | `framework/Opus/RefBook/Api/RefBookDocumentationI18nRestRouter.php:44` |
| INTEGRATION_ONLY | REFBOOK | `Opus\RefBook\Api\RefBookRestApi` | `__construct` | no | no | yes | `framework/Opus/RefBook/Api/RefBookRestApi.php:59` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\Api\RefBookRestApi` | `handle` | yes | yes | yes | `framework/Opus/RefBook/Api/RefBookRestApi.php:75` |
| INTEGRATION_ONLY | REFBOOK | `Opus\RefBook\Api\RefBookRestApi` | `refBookDomain` | no | no | yes | `framework/Opus/RefBook/Api/RefBookRestApi.php:55` |
| INTEGRATION_ONLY | REFBOOK | `Opus\RefBook\Api\RefBookRestSnapshotProvider` | `__construct` | no | no | yes | `framework/Opus/RefBook/Api/RefBookRestSnapshotProvider.php:61` |
| INTEGRATION_ONLY | REFBOOK | `Opus\RefBook\Api\RefBookRestSnapshotProvider` | `endpoints` | no | no | yes | `framework/Opus/RefBook/Api/RefBookRestSnapshotProvider.php:119` |
| INTEGRATION_ONLY | REFBOOK | `Opus\RefBook\Api\RefBookRestSnapshotProvider` | `refBookDomain` | no | no | yes | `framework/Opus/RefBook/Api/RefBookRestSnapshotProvider.php:56` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\Api\RefBookRestSnapshotProvider` | `snapshot` | yes | yes | yes | `framework/Opus/RefBook/Api/RefBookRestSnapshotProvider.php:80` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\Attribute\OpusRefBookClass` | `__construct` | yes | no | yes | `framework/Opus/RefBook/Attribute/OpusRefBookClass.php:52` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\Attribute\OpusRefBookClass` | `toArray` | yes | no | yes | `framework/Opus/RefBook/Attribute/OpusRefBookClass.php:77` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\Attribute\OpusRefBookMethod` | `__construct` | yes | no | yes | `framework/Opus/RefBook/Attribute/OpusRefBookMethod.php:66` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\Attribute\OpusRefBookMethod` | `toArray` | yes | no | yes | `framework/Opus/RefBook/Attribute/OpusRefBookMethod.php:97` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\Contract\RefBookInspectableInterface` | `refBookDomain` | yes | no | no | `framework/Opus/RefBook/Contract/RefBookInspectableInterface.php:26` |
| INTEGRATION_ONLY | REFBOOK | `Opus\RefBook\I18n\RefBookDocumentationI18nCatalog` | `all` | no | yes | yes | `framework/Opus/RefBook/I18n/RefBookDocumentationI18nCatalog.php:5547` |
| INTEGRATION_ONLY | REFBOOK | `Opus\RefBook\I18n\RefBookDocumentationI18nCatalog` | `translateSourceText` | no | yes | no | `framework/Opus/RefBook/I18n/RefBookDocumentationI18nCatalog.php:5527` |
| MISSING_TEST_REFERENCE | REFBOOK | `Opus\RefBook\I18n\RefBookDocumentationLocale` | `assertSupported` | no | no | no | `framework/Opus/RefBook/I18n/RefBookDocumentationLocale.php:30` |
| INTEGRATION_ONLY | REFBOOK | `Opus\RefBook\I18n\RefBookDocumentationLocale` | `supported` | no | yes | no | `framework/Opus/RefBook/I18n/RefBookDocumentationLocale.php:25` |
| INTEGRATION_ONLY | REFBOOK | `Opus\RefBook\I18n\RefBookDocumentationTranslationMissingException` | `forSourceText` | no | yes | no | `framework/Opus/RefBook/I18n/RefBookDocumentationTranslationMissingException.php:22` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\Model\RefBookClassEntry` | `__construct` | yes | no | yes | `framework/Opus/RefBook/Model/RefBookClassEntry.php:23` |
| MISSING_TEST_REFERENCE | REFBOOK | `Opus\RefBook\Model\RefBookClassEntry` | `hasMetadata` | no | no | no | `framework/Opus/RefBook/Model/RefBookClassEntry.php:70` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\Model\RefBookClassEntry` | `methods` | yes | yes | yes | `framework/Opus/RefBook/Model/RefBookClassEntry.php:80` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\Model\RefBookClassEntry` | `name` | yes | yes | yes | `framework/Opus/RefBook/Model/RefBookClassEntry.php:62` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\Model\RefBookClassEntry` | `toArray` | yes | no | yes | `framework/Opus/RefBook/Model/RefBookClassEntry.php:90` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\Model\RefBookMethodEntry` | `__construct` | yes | no | yes | `framework/Opus/RefBook/Model/RefBookMethodEntry.php:22` |
| MISSING_TEST_REFERENCE | REFBOOK | `Opus\RefBook\Model\RefBookMethodEntry` | `hasMetadata` | no | no | no | `framework/Opus/RefBook/Model/RefBookMethodEntry.php:66` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\Model\RefBookMethodEntry` | `name` | yes | yes | yes | `framework/Opus/RefBook/Model/RefBookMethodEntry.php:58` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\Model\RefBookMethodEntry` | `toArray` | yes | no | yes | `framework/Opus/RefBook/Model/RefBookMethodEntry.php:76` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\Model\RefBookScanResult` | `__construct` | yes | no | yes | `framework/Opus/RefBook/Model/RefBookScanResult.php:23` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\Model\RefBookScanResult` | `classes` | yes | yes | yes | `framework/Opus/RefBook/Model/RefBookScanResult.php:34` |
| MISSING_TEST_REFERENCE | REFBOOK | `Opus\RefBook\Model\RefBookScanResult` | `loadErrors` | no | no | no | `framework/Opus/RefBook/Model/RefBookScanResult.php:44` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\Model\RefBookScanResult` | `summary` | yes | yes | yes | `framework/Opus/RefBook/Model/RefBookScanResult.php:54` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\Model\RefBookScanResult` | `toArray` | yes | no | yes | `framework/Opus/RefBook/Model/RefBookScanResult.php:85` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\RefBookContractValidator` | `validate` | yes | yes | yes | `framework/Opus/RefBook/RefBookContractValidator.php:25` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\RefBookReflectionScanner` | `scan` | yes | yes | yes | `framework/Opus/RefBook/RefBookReflectionScanner.php:49` |
| UNIT_CANDIDATE | REFBOOK | `Opus\RefBook\RefBookSnapshotBuilder` | `build` | yes | yes | yes | `framework/Opus/RefBook/RefBookSnapshotBuilder.php:28` |
| INTEGRATION_ONLY | RENDERER | `Opus\Renderer\HtmlRenderer` | `__construct` | no | no | yes | `framework/Opus/Renderer/HtmlRenderer.php:41` |
| INTEGRATION_ONLY | RENDERER | `Opus\Renderer\HtmlRenderer` | `render` | no | yes | yes | `framework/Opus/Renderer/HtmlRenderer.php:45` |
| INTEGRATION_ONLY | RENDERER | `Opus\Renderer\JsonRenderer` | `render` | no | yes | yes | `framework/Opus/Renderer/JsonRenderer.php:44` |
| INTEGRATION_ONLY | RENDERER | `Opus\Renderer\RenderException` | `because` | no | yes | yes | `framework/Opus/Renderer/RenderException.php:37` |
| UNIT_CANDIDATE | RENDERER | `Opus\Renderer\RendererInterface` | `render` | yes | yes | yes | `framework/Opus/Renderer/RendererInterface.php:40` |
| INTEGRATION_ONLY | RENDERER | `Opus\Renderer\ViewModel` | `__construct` | no | no | yes | `framework/Opus/Renderer/ViewModel.php:46` |
| UNIT_CANDIDATE | REQUEST | `Opus\Request\Request` | `__construct` | yes | yes | yes | `framework/Opus/Request/Request.php:21` |
| INTEGRATION_ONLY | REQUEST | `Opus\Request\Request` | `toHttpRequest` | no | yes | yes | `framework/Opus/Request/Request.php:22` |
| UNIT_CANDIDATE | RESPONSE | `Opus\Response\Response` | `__construct` | yes | no | yes | `framework/Opus/Response/Response.php:21` |
| INTEGRATION_ONLY | RESPONSE | `Opus\Response\Response` | `toHttpResponse` | no | no | yes | `framework/Opus/Response/Response.php:22` |
| UNIT_CANDIDATE | RESPONSE | `Opus\Response\ResponseFacade` | `html` | yes | yes | yes | `framework/Opus/Response/ResponseFacade.php:37` |
| UNIT_CANDIDATE | RESPONSE | `Opus\Response\ResponseFacade` | `json` | yes | yes | yes | `framework/Opus/Response/ResponseFacade.php:43` |
| UNIT_CANDIDATE | REST | `Opus\Rest\Rest` | `json` | yes | yes | yes | `framework/Opus/Rest/Rest.php:43` |
| INTEGRATION_ONLY | ROUTER | `Opus\Router\Route` | `__construct` | no | no | yes | `framework/Opus/Router/Route.php:20` |
| INTEGRATION_ONLY | ROUTER | `Opus\Router\Router` | `__construct` | no | yes | yes | `framework/Opus/Router/Router.php:47` |
| INTEGRATION_ONLY | ROUTER | `Opus\Router\Router` | `add` | no | yes | yes | `framework/Opus/Router/Router.php:54` |
| UNIT_CANDIDATE | ROUTER | `Opus\Router\Router` | `all` | yes | yes | yes | `framework/Opus/Router/Router.php:99` |
| INTEGRATION_ONLY | ROUTER | `Opus\Router\Router` | `byName` | no | yes | yes | `framework/Opus/Router/Router.php:77` |
| INTEGRATION_ONLY | ROUTER | `Opus\Router\Router` | `hasName` | no | yes | yes | `framework/Opus/Router/Router.php:91` |
| INTEGRATION_ONLY | ROUTER | `Opus\Router\Router` | `hasPath` | no | yes | yes | `framework/Opus/Router/Router.php:86` |
| INTEGRATION_ONLY | ROUTING | `Opus\Routing\AttributeRouteProvider` | `__construct` | no | no | yes | `framework/Opus/Routing/AttributeRouteProvider.php:88` |
| UNIT_CANDIDATE | ROUTING | `Opus\Routing\AttributeRouteProvider` | `refBookDomain` | yes | no | no | `framework/Opus/Routing/AttributeRouteProvider.php:71` |
| UNIT_CANDIDATE | ROUTING | `Opus\Routing\AttributeRouteProvider` | `routes` | yes | yes | yes | `framework/Opus/Routing/AttributeRouteProvider.php:105` |
| INTEGRATION_ONLY | ROUTING | `Opus\Routing\ClassIndex` | `__construct` | no | no | yes | `framework/Opus/Routing/ClassIndex.php:93` |
| UNIT_CANDIDATE | ROUTING | `Opus\Routing\ClassIndex` | `classes` | yes | yes | yes | `framework/Opus/Routing/ClassIndex.php:160` |
| UNIT_CANDIDATE | ROUTING | `Opus\Routing\ClassIndex` | `classesInNamespace` | yes | no | yes | `framework/Opus/Routing/ClassIndex.php:195` |
| UNIT_CANDIDATE | ROUTING | `Opus\Routing\ClassIndex` | `fromComposerClassMap` | yes | no | yes | `framework/Opus/Routing/ClassIndex.php:142` |
| UNIT_CANDIDATE | ROUTING | `Opus\Routing\ClassIndex` | `pathForClass` | yes | no | yes | `framework/Opus/Routing/ClassIndex.php:177` |
| UNIT_CANDIDATE | ROUTING | `Opus\Routing\ClassIndex` | `refBookDomain` | yes | no | yes | `framework/Opus/Routing/ClassIndex.php:73` |
| INTEGRATION_ONLY | ROUTING | `Opus\Routing\Route` | `__construct` | no | yes | yes | `framework/Opus/Routing/Route.php:96` |
| UNIT_CANDIDATE | ROUTING | `Opus\Routing\Route` | `normalizedMethods` | yes | yes | yes | `framework/Opus/Routing/Route.php:143` |
| UNIT_CANDIDATE | ROUTING | `Opus\Routing\Route` | `refBookDomain` | yes | yes | yes | `framework/Opus/Routing/Route.php:76` |
| UNIT_CANDIDATE | ROUTING | `Opus\Routing\RouteCompilerException` | `because` | yes | yes | yes | `framework/Opus/Routing/RouteCompilerException.php:86` |
| UNIT_CANDIDATE | ROUTING | `Opus\Routing\RouteCompilerException` | `refBookDomain` | yes | no | no | `framework/Opus/Routing/RouteCompilerException.php:69` |
| INTEGRATION_ONLY | ROUTING | `Opus\Routing\RouteDefinition` | `__construct` | no | no | yes | `framework/Opus/Routing/RouteDefinition.php:79` |
| UNIT_CANDIDATE | ROUTING | `Opus\Routing\RouteDefinition` | `normalizedMethods` | yes | yes | no | `framework/Opus/Routing/RouteDefinition.php:149` |
| UNIT_CANDIDATE | ROUTING | `Opus\Routing\RouteDefinition` | `refBookDomain` | yes | no | no | `framework/Opus/Routing/RouteDefinition.php:131` |
| UNIT_CANDIDATE | ROUTING | `Opus\Routing\RouteDefinition` | `toManifestRow` | yes | yes | no | `framework/Opus/Routing/RouteDefinition.php:173` |
| UNIT_CANDIDATE | ROUTING | `Opus\Routing\RouteManifestCompiler` | `compile` | yes | no | yes | `framework/Opus/Routing/RouteManifestCompiler.php:90` |
| UNIT_CANDIDATE | ROUTING | `Opus\Routing\RouteManifestCompiler` | `loadPhpManifest` | yes | no | yes | `framework/Opus/Routing/RouteManifestCompiler.php:184` |
| UNIT_CANDIDATE | ROUTING | `Opus\Routing\RouteManifestCompiler` | `refBookDomain` | yes | no | yes | `framework/Opus/Routing/RouteManifestCompiler.php:69` |
| UNIT_CANDIDATE | ROUTING | `Opus\Routing\RouteManifestCompiler` | `writePhpManifest` | yes | yes | yes | `framework/Opus/Routing/RouteManifestCompiler.php:152` |
| INTEGRATION_ONLY | ROUTING | `Opus\Routing\RouteMatch` | `__construct` | no | yes | yes | `framework/Opus/Routing/RouteMatch.php:84` |
| UNIT_CANDIDATE | ROUTING | `Opus\Routing\RouteMatch` | `refBookDomain` | yes | yes | no | `framework/Opus/Routing/RouteMatch.php:106` |
| INTEGRATION_ONLY | ROUTING | `Opus\Routing\Router` | `__construct` | no | yes | yes | `framework/Opus/Routing/Router.php:83` |
| UNIT_CANDIDATE | ROUTING | `Opus\Routing\Router` | `fromXml` | yes | yes | yes | `framework/Opus/Routing/Router.php:126` |
| UNIT_CANDIDATE | ROUTING | `Opus\Routing\Router` | `refBookDomain` | yes | yes | yes | `framework/Opus/Routing/Router.php:102` |
| INTEGRATION_ONLY | SECURITY | `Opus\Security\AclGuard` | `assertAllowed` | no | yes | yes | `framework/Opus/Security/AclGuard.php:53` |
| INTEGRATION_ONLY | SECURITY | `Opus\Security\FsmGuard` | `assertAllowed` | no | yes | yes | `framework/Opus/Security/FsmGuard.php:50` |
| INTEGRATION_ONLY | SECURITY | `Opus\Security\SecureDispatchDecision` | `__construct` | no | no | yes | `framework/Opus/Security/SecureDispatchDecision.php:50` |
| INTEGRATION_ONLY | SECURITY | `Opus\Security\SecureDispatchGate` | `assertAllowed` | no | yes | yes | `framework/Opus/Security/SecureDispatchGate.php:65` |
| INTEGRATION_ONLY | SECURITY | `Opus\Security\Security` | `__construct` | no | no | yes | `framework/Opus/Security/Security.php:42` |
| INTEGRATION_ONLY | SECURITY | `Opus\Security\Security` | `allow` | no | yes | yes | `framework/Opus/Security/Security.php:48` |
| INTEGRATION_ONLY | SECURITY | `Opus\Security\Security` | `assertAllowed` | no | yes | yes | `framework/Opus/Security/Security.php:72` |
| INTEGRATION_ONLY | SECURITY | `Opus\Security\Security` | `deny` | no | no | yes | `framework/Opus/Security/Security.php:53` |
| MISSING_TEST_REFERENCE | SECURITY | `Opus\Security\Security` | `isAllowed` | no | no | no | `framework/Opus/Security/Security.php:62` |
| MISSING_TEST_REFERENCE | SECURITY | `Opus\Security\Security` | `isDenied` | no | no | no | `framework/Opus/Security/Security.php:67` |
| INTEGRATION_ONLY | SECURITY | `Opus\Security\SiteSecurityPolicy` | `__construct` | no | yes | yes | `framework/Opus/Security/SiteSecurityPolicy.php:55` |
| INTEGRATION_ONLY | SECURITY | `Opus\Security\SiteSecurityPolicyLoader` | `load` | no | yes | yes | `framework/Opus/Security/SiteSecurityPolicyLoader.php:54` |
| INTEGRATION_ONLY | SESSION | `Opus\Session\Session` | `__construct` | no | no | yes | `framework/Opus/Session/Session.php:44` |
| UNIT_CANDIDATE | SESSION | `Opus\Session\Session` | `all` | yes | yes | yes | `framework/Opus/Session/Session.php:87` |
| INTEGRATION_ONLY | SESSION | `Opus\Session\Session` | `clear` | no | yes | no | `framework/Opus/Session/Session.php:79` |
| UNIT_CANDIDATE | SESSION | `Opus\Session\Session` | `get` | yes | yes | yes | `framework/Opus/Session/Session.php:49` |
| MISSING_TEST_REFERENCE | SESSION | `Opus\Session\Session` | `getOrDefault` | no | no | no | `framework/Opus/Session/Session.php:58` |
| INTEGRATION_ONLY | SESSION | `Opus\Session\Session` | `has` | no | yes | yes | `framework/Opus/Session/Session.php:69` |
| INTEGRATION_ONLY | SESSION | `Opus\Session\Session` | `remove` | no | yes | yes | `framework/Opus/Session/Session.php:74` |
| UNIT_CANDIDATE | SESSION | `Opus\Session\Session` | `set` | yes | yes | yes | `framework/Opus/Session/Session.php:63` |
| INTEGRATION_ONLY | SITE | `Opus\Site\SiteDefinition` | `__construct` | no | yes | yes | `framework/Opus/Site/SiteDefinition.php:37` |
| UNIT_CANDIDATE | SITE | `Opus\Site\SiteDefinition` | `hasDatabase` | yes | yes | yes | `framework/Opus/Site/SiteDefinition.php:65` |
| UNIT_CANDIDATE | SITE | `Opus\Site\SiteDefinition` | `requireDatabaseFile` | yes | yes | yes | `framework/Opus/Site/SiteDefinition.php:70` |
| INTEGRATION_ONLY | SITE | `Opus\Site\SiteResolver` | `__construct` | no | no | yes | `framework/Opus/Site/SiteResolver.php:39` |
| UNIT_CANDIDATE | SITE | `Opus\Site\SiteResolver` | `resolve` | yes | yes | no | `framework/Opus/Site/SiteResolver.php:46` |
| INTEGRATION_ONLY | SMTP | `Opus\Smtp\Smtp` | `__construct` | no | no | yes | `framework/Opus/Smtp/Smtp.php:38` |
| UNIT_CANDIDATE | SUPPORT | `Opus\Support\Support` | `e` | yes | yes | yes | `framework/Opus/Support/Support.php:35` |
| UNIT_CANDIDATE | SUPPORT | `Opus\Support\Support` | `normalizePath` | yes | no | no | `framework/Opus/Support/Support.php:40` |
| UNIT_CANDIDATE | SUPPORT | `Opus\Support\Support` | `startsWith` | yes | no | no | `framework/Opus/Support/Support.php:87` |
| UNIT_CANDIDATE | SUPPORT | `Opus\Support\Support` | `trimSlashes` | yes | no | no | `framework/Opus/Support/Support.php:92` |
| UNIT_CANDIDATE | TEMPLATE | `Opus\Template\Adapter` | `loadTemplate` | yes | no | yes | `framework/Opus/Template/Adapter.php:42` |
| UNIT_CANDIDATE | TEMPLATE | `Opus\Template\Adapter` | `render` | yes | yes | yes | `framework/Opus/Template/Adapter.php:47` |
| UNIT_CANDIDATE | TEMPLATE | `Opus\Template\Smarty` | `assign` | yes | no | no | `framework/Opus/Template/Smarty.php:46` |
| UNIT_CANDIDATE | TEMPLATE | `Opus\Template\Smarty` | `assignAll` | yes | no | no | `framework/Opus/Template/Smarty.php:56` |
| UNIT_CANDIDATE | TEMPLATE | `Opus\Template\Smarty` | `loadTemplate` | yes | no | no | `framework/Opus/Template/Smarty.php:68` |
| UNIT_CANDIDATE | TEMPLATE | `Opus\Template\Smarty` | `parse` | yes | no | yes | `framework/Opus/Template/Smarty.php:63` |
| UNIT_CANDIDATE | TEMPLATE | `Opus\Template\Smarty` | `render` | yes | yes | yes | `framework/Opus/Template/Smarty.php:73` |
| INTEGRATION_ONLY | TEMPLATE | `Opus\Template\TemplateException` | `because` | no | yes | yes | `framework/Opus/Template/TemplateException.php:34` |
| UNIT_CANDIDATE | TEMPLATE | `Opus\Template\TemplateRendererInterface` | `render` | yes | yes | yes | `framework/Opus/Template/TemplateRendererInterface.php:47` |
| INTEGRATION_ONLY | TEMPLATE | `Opus\Template\Twig` | `__construct` | no | no | yes | `framework/Opus/Template/Twig.php:41` |
| INTEGRATION_ONLY | TEMPLATE | `Opus\Template\Twig` | `loadTemplate` | no | no | yes | `framework/Opus/Template/Twig.php:45` |
| INTEGRATION_ONLY | TEMPLATE | `Opus\Template\Twig` | `render` | no | yes | yes | `framework/Opus/Template/Twig.php:50` |
| INTEGRATION_ONLY | TEMPLATE | `Opus\Template\TwigTemplateRenderer` | `__construct` | no | no | yes | `framework/Opus/Template/TwigTemplateRenderer.php:45` |
| INTEGRATION_ONLY | TEMPLATE | `Opus\Template\TwigTemplateRenderer` | `render` | no | yes | yes | `framework/Opus/Template/TwigTemplateRenderer.php:68` |
| UNIT_CANDIDATE | TEMPLATE | `Opus\Template\X64` | `assign` | yes | no | no | `framework/Opus/Template/X64.php:40` |
| UNIT_CANDIDATE | TEMPLATE | `Opus\Template\X64` | `assignAll` | yes | no | no | `framework/Opus/Template/X64.php:50` |
| UNIT_CANDIDATE | TEMPLATE | `Opus\Template\X64` | `loadTemplate` | yes | no | no | `framework/Opus/Template/X64.php:62` |
| UNIT_CANDIDATE | TEMPLATE | `Opus\Template\X64` | `parse` | yes | no | yes | `framework/Opus/Template/X64.php:57` |
| UNIT_CANDIDATE | TEMPLATE | `Opus\Template\X64` | `render` | yes | yes | yes | `framework/Opus/Template/X64.php:67` |
| INTEGRATION_ONLY | THEME | `Opus\Theme\ThemeDefinition` | `__construct` | no | no | yes | `framework/Opus/Theme/ThemeDefinition.php:41` |
| INTEGRATION_ONLY | URL | `Opus\Url\Url` | `__construct` | no | no | yes | `framework/Opus/Url/Url.php:53` |
| UNIT_CANDIDATE | URL | `Opus\Url\Url` | `__toString` | yes | no | no | `framework/Opus/Url/Url.php:109` |
| UNIT_CANDIDATE | URL | `Opus\Url\Url` | `asset` | yes | yes | yes | `framework/Opus/Url/Url.php:94` |
| UNIT_CANDIDATE | URL | `Opus\Url\Url` | `getAnchor` | yes | no | no | `framework/Opus/Url/Url.php:189` |
| UNIT_CANDIDATE | URL | `Opus\Url\Url` | `getArguments` | yes | no | no | `framework/Opus/Url/Url.php:176` |
| UNIT_CANDIDATE | URL | `Opus\Url\Url` | `getHost` | yes | no | no | `framework/Opus/Url/Url.php:147` |
| UNIT_CANDIDATE | URL | `Opus\Url\Url` | `getPath` | yes | yes | yes | `framework/Opus/Url/Url.php:159` |
| UNIT_CANDIDATE | URL | `Opus\Url\Url` | `getProtocol` | yes | no | no | `framework/Opus/Url/Url.php:131` |
| INTEGRATION_ONLY | URL | `Opus\Url\Url` | `route` | no | yes | yes | `framework/Opus/Url/Url.php:100` |
| UNIT_CANDIDATE | URL | `Opus\Url\Url` | `setAnchor` | yes | no | no | `framework/Opus/Url/Url.php:194` |
| UNIT_CANDIDATE | URL | `Opus\Url\Url` | `setArguments` | yes | no | no | `framework/Opus/Url/Url.php:182` |
| MISSING_TEST_REFERENCE | URL | `Opus\Url\Url` | `setHost` | no | no | no | `framework/Opus/Url/Url.php:152` |
| UNIT_CANDIDATE | URL | `Opus\Url\Url` | `setPath` | yes | no | no | `framework/Opus/Url/Url.php:164` |
| MISSING_TEST_REFERENCE | URL | `Opus\Url\Url` | `setProtocol` | no | no | no | `framework/Opus/Url/Url.php:136` |
| UNIT_CANDIDATE | URL | `Opus\Url\Url` | `to` | yes | yes | yes | `framework/Opus/Url/Url.php:78` |
| INTEGRATION_ONLY | URL | `Opus\Url\UrlException` | `because` | no | yes | yes | `framework/Opus/Url/UrlException.php:34` |
| INTEGRATION_ONLY | URL | `Opus\Url\UrlGenerator` | `__construct` | no | no | yes | `framework/Opus/Url/UrlGenerator.php:38` |
| INTEGRATION_ONLY | URL | `Opus\Url\UrlGenerator` | `path` | no | yes | yes | `framework/Opus/Url/UrlGenerator.php:45` |
| UNIT_CANDIDATE | VALIDATION | `Opus\Validation\Validator` | `__construct` | yes | no | yes | `framework/Opus/Validation/Validator.php:47` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `email` | no | yes | yes | `framework/Opus/Validation/Validator.php:62` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `getMessages` | no | no | yes | `framework/Opus/Validation/Validator.php:52` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `integer` | no | no | yes | `framework/Opus/Validation/Validator.php:67` |
| UNIT_CANDIDATE | VALIDATION | `Opus\Validation\Validator` | `isAbsoluteUrl` | yes | no | yes | `framework/Opus/Validation/Validator.php:179` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isAddress` | no | no | yes | `framework/Opus/Validation/Validator.php:281` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isBirthDate` | no | no | yes | `framework/Opus/Validation/Validator.php:155` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isBool` | no | no | yes | `framework/Opus/Validation/Validator.php:119` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isBoolean` | no | no | yes | `framework/Opus/Validation/Validator.php:124` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isCityName` | no | no | yes | `framework/Opus/Validation/Validator.php:266` |
| UNIT_CANDIDATE | VALIDATION | `Opus\Validation\Validator` | `isCleanHtml` | yes | no | yes | `framework/Opus/Validation/Validator.php:316` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isColor` | no | no | yes | `framework/Opus/Validation/Validator.php:195` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isCountryName` | no | no | yes | `framework/Opus/Validation/Validator.php:271` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isDate` | no | no | yes | `framework/Opus/Validation/Validator.php:144` |
| UNIT_CANDIDATE | VALIDATION | `Opus\Validation\Validator` | `isEan13` | yes | no | yes | `framework/Opus/Validation/Validator.php:200` |
| UNIT_CANDIDATE | VALIDATION | `Opus\Validation\Validator` | `isEmail` | yes | no | yes | `framework/Opus/Validation/Validator.php:72` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isFileName` | no | no | yes | `framework/Opus/Validation/Validator.php:222` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isFloat` | no | no | yes | `framework/Opus/Validation/Validator.php:100` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isGenderIsoCode` | no | no | yes | `framework/Opus/Validation/Validator.php:246` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isGenderName` | no | no | yes | `framework/Opus/Validation/Validator.php:251` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isGenericName` | no | no | yes | `framework/Opus/Validation/Validator.php:261` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isIcoFile` | no | no | yes | `framework/Opus/Validation/Validator.php:231` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isImgFile` | no | no | yes | `framework/Opus/Validation/Validator.php:236` |
| UNIT_CANDIDATE | VALIDATION | `Opus\Validation\Validator` | `isInt` | yes | no | yes | `framework/Opus/Validation/Validator.php:77` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isLanguageIsoCode` | no | no | yes | `framework/Opus/Validation/Validator.php:241` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isLinkRewrite` | no | no | yes | `framework/Opus/Validation/Validator.php:306` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isLoadedObject` | no | no | yes | `framework/Opus/Validation/Validator.php:323` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isMailName` | no | no | yes | `framework/Opus/Validation/Validator.php:296` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isMailSubject` | no | no | yes | `framework/Opus/Validation/Validator.php:301` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isMd5` | no | no | yes | `framework/Opus/Validation/Validator.php:164` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isName` | no | no | yes | `framework/Opus/Validation/Validator.php:256` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isNullOrUnsignedInt` | no | no | yes | `framework/Opus/Validation/Validator.php:95` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isOptFloat` | no | no | yes | `framework/Opus/Validation/Validator.php:114` |
| UNIT_CANDIDATE | VALIDATION | `Opus\Validation\Validator` | `isPasswd` | yes | no | yes | `framework/Opus/Validation/Validator.php:337` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isPhoneNumber` | no | no | yes | `framework/Opus/Validation/Validator.php:291` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isPostCode` | no | no | yes | `framework/Opus/Validation/Validator.php:286` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isProtocol` | no | no | yes | `framework/Opus/Validation/Validator.php:190` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isSha1` | no | no | yes | `framework/Opus/Validation/Validator.php:169` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isStateIsoCode` | no | no | yes | `framework/Opus/Validation/Validator.php:276` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isString` | no | no | yes | `framework/Opus/Validation/Validator.php:139` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isSubDomainName` | no | no | yes | `framework/Opus/Validation/Validator.php:311` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isUnsignedFloat` | no | no | yes | `framework/Opus/Validation/Validator.php:109` |
| UNIT_CANDIDATE | VALIDATION | `Opus\Validation\Validator` | `isUnsignedInt` | yes | no | yes | `framework/Opus/Validation/Validator.php:86` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isUrl` | no | no | yes | `framework/Opus/Validation/Validator.php:174` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isValidSearch` | no | no | yes | `framework/Opus/Validation/Validator.php:332` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `isValide` | no | no | yes | `framework/Opus/Validation/Validator.php:342` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `is_false` | no | no | yes | `framework/Opus/Validation/Validator.php:134` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `is_true` | no | no | yes | `framework/Opus/Validation/Validator.php:129` |
| INTEGRATION_ONLY | VALIDATION | `Opus\Validation\Validator` | `notEmpty` | no | no | yes | `framework/Opus/Validation/Validator.php:57` |
| INTEGRATION_ONLY | VIEW | `Opus\View\Html` | `__construct` | no | no | yes | `framework/Opus/View/Html.php:46` |
| MISSING_TEST_REFERENCE | VIEW | `Opus\View\Html` | `toResponse` | no | no | no | `framework/Opus/View/Html.php:61` |
| INTEGRATION_ONLY | VIEW | `Opus\View\View` | `__construct` | no | no | yes | `framework/Opus/View/View.php:38` |
| UNIT_CANDIDATE | VIEW | `Opus\View\View` | `render` | yes | yes | yes | `framework/Opus/View/View.php:44` |
| INTEGRATION_ONLY | VIEW | `Opus\View\ViewException` | `because` | no | yes | yes | `framework/Opus/View/ViewException.php:34` |
| MISSING_TEST_REFERENCE | XML | `Opus\Xml\Xml` | `fromFile` | no | no | no | `framework/Opus/Xml/Xml.php:22` |
| MISSING_TEST_REFERENCE | XML | `Opus\Xml\Xml` | `fromString` | no | no | no | `framework/Opus/Xml/Xml.php:21` |
