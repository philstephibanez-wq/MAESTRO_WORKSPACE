# P112Q2H — ASAP Database Provider Site Config Foundation

## Purpose

P112Q2H turns `Database` into the official bridge for multiple database providers selected by site configuration.

## Supported provider identifiers

- `mysql`
- `mariadb`
- `postgresql`
- `sqlite`
- `oracle`
- `odbc`
- `sqlserver`

Aliases are normalized:

- `pgsql`, `postgres` -> `postgresql`
- `sqlite3` -> `sqlite`
- `oci`, `oci8` -> `oracle`
- `sqlsrv`, `mssql` -> `sqlserver`

## Site contract

A site may declare a database config file in `site.xml`:

```xml
<site id="demo">
  <basePath>/demo</basePath>
  <routes file="routes.xml"/>
  <security file="security.xml"/>
  <database file="database.xml"/>
</site>
```

The database config file selects the provider:

```xml
<database provider="sqlite">
  <path>H:/ASAP_REF_BOOK/var/data/asap.sqlite</path>
</database>
```

## MySQL example

```xml
<database provider="mysql">
  <host>127.0.0.1</host>
  <port>3306</port>
  <database>maestro</database>
  <user>root</user>
  <password></password>
</database>
```

## PostgreSQL example

```xml
<database provider="postgresql">
  <host>127.0.0.1</host>
  <port>5432</port>
  <database>maestro</database>
  <user>postgres</user>
  <password>secret</password>
</database>
```

## Oracle example

```xml
<database provider="oracle">
  <host>127.0.0.1</host>
  <port>1521</port>
  <service>XE</service>
  <user>system</user>
  <password>secret</password>
</database>
```

## Contract

No provider fallback is allowed.

If the site selects `postgresql` and the PDO `pgsql` driver is unavailable, ASAP fails explicitly with `ASAP_DATABASE_PDO_DRIVER_UNAVAILABLE`.

## Runner

`H:\ASAP\tools\automation\p112q2h_database_provider_site_config_foundation_recipe_runner.cmd`
