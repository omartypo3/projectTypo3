# Stratis Social Auth

For stable authentication workflow emails must be provided for all user records (in 'email' or 'username' fields) that are created from FE;

## General Configuration
- Create an "Authentication configuration", set all required fields;
- For providers configurations see appropriate information below;l
- Set the FE plugin to display the correct links for authentication.

### Google
<b>How to get ID / Secret :</b>
- In ["Google Developers Console"](https://console.developers.google.com/) create a new project;
- In "OAuth consent screen" set `Product name shown to users`, `Privacy policy URL` and `Terms of service URL`;
- In "API and Services" -> "Credentials" create new credentials `Oauth client ID`;
- Set "application type" to `Web application`;
- Set "Authorized redirect URIs" to `https://*website*/?type=1530541022&hauth_done=Google` (variants with `http://` and `www.` if exist should be also included);
- Use the `Client ID` and `Client secret` to configure Google Provider in BE;

- Additional info can be found in [Google Documentation for Developers](https://developers.google.com/identity/protocols/OAuth2);

<b>Provider config:</b>

Field | Take value from | Example
------------|:-------------:|-------------
Title | - | `Google`
Type | - | `Google`
ID | `Client ID` | `526819593670-e6uabcf5g3sncb1m5ji7k2sf2cushjac.apps.googleusercontent.com`
Secret | `Client secret ` | `DdOGTNUKaOy8eb5pePao5rTs`

### FranceConnect
#### V2 changes
- scope should be `openid email profile`
- endpoints:
  - `https://fcp-low.sbx.dev-franceconnect.fr/api/v2` for development
  - `https://fcp-low.integ1.dev-franceconnect.fr/api/v2` for development
  - `https://app.franceconnect.gouv.fr/api/v2` for production
- New keys need to be generated because the format has changed.
#### Additional configuration
- Need to add this configuration to sites/stratissite/config.yaml or another domain to specify the page UIDs:
 ```yaml
 franceConnect:
    success_redirect_page_uid: 93
    logout_redirect_page_uid: 303
  ```

#### V1 changes
<b>Note :</b> FranceConnect uses different configuration for development and production!

<b>How to get ID / Secret :</b>
- Register and connect here [https://www.franceconnect.gouv.fr/fournisseur-service]
- Create a new app;
- `Id` and `Secret` may be taken from "Editer le FS" tab;
- Set "URLs de callbacks" to `https://*website*/?type=1530541022&hauth_done=FranceConnect` (variants with `http://` and `www.` if exist should be also included);
- Publish the app to production and set the correct OpenID identifier inorder to use the service in production context;

<b>Authentication Context Class Values  :</b>

It allows set to FranceConnect with which level eIDAS authentication has been done, it is done through the optional parameter of the OIDC standard "acr".
- eIDAS1 : standard level (example: authentication by username / password);
- eIDAS2 : substantial level (example: two factor authentication);
- eIDAS3 : niveau fort (exemple : utilisation de certificats, lecteurs de cartes, etc.);

<b>Provider config:</b>

Field | Take value from | Example
------------|:-------------:|-------------
Title | - | `FranceConnect`
Type | - | `FranceConnect`
ID | `Identifiant client` | `dae6ba27930c611b514e9cd12312aef4d4a3a56c366e427f99d623b77ebc745f`
Secret | `Clé secrète` | `6eb84f26103a5a6408f3d9ab990eb83cf3f2dfbb312e6e4d7d59a9cf385fa3f8`
OpenID URL / OpenID identifier | `Mon projet FranceConnect` | for developers : `https://fcp.integ01.dev-franceconnect.fr/api/v1`<br> for production : `https://app.franceconnect.gouv.fr/api/v1`
Scope | [https://www.franceconnect.gouv.fr/fournisseur-service] | `openid email phone given_name family_name birthdate preferred_username address gender`
Valeurs de la classe de contexte d'authentification | - | `eIDAS1`

### Facebook
<b>Note :</b> Works only with SSL enabled!

<b>How to get ID / Secret :</b>
- Create a Facebook app;
- Add product "Facebook Login";
- Set valid domain;
- Set "Valid OAuth Redirect URIs" to `http://*website*/?type=1530541022&hauth_done=Facebook` in "Facebook Login" -> "Settings";
- Set "Privacy policy URL" and "Terms of service URL";
- Put the app into "Production" stage (there must be a toggle);
- Tested on the combination of settings ("Facebook Login" -> "Settings"):<br>

Option | Value
---|---
Client OAuth Login | `yes`
Web OAuth Login | `yes`
Enforce HTTPS | `yes`
Force Web OAuth Reauthentication | `no`
Embedded Browser OAuth Login | `yes`
Use Strict Mode for Redirect URIs | `yes`
Login from Devices | `no`

<b>Provider config:</b>

Field | Take value from | Example
------------|:-------------:|-------------
Title | - | `Facebook`
Type | - | `Facebook`
ID | "Settings" -> "Basic" `App ID` | `307982286353625`
Secret | "Settings" -> "Basic" `App Secret` | `dcb6f8bb6b9aa89f015b5e719d9a503a`
Scope | [https://developers.facebook.com/docs/facebook-login/permissions/#reference-default_fields] | email
Display | - | popup

## Tests

1) Run `composer install`
2) For analyze PHP code functionality by `PHP Stan` run `composer analyze:php`
3) For fix PHP code by `PHP CodeSniffer` run `composer fix:style`
4) For analyze PHP code style by `PHP CodeSniffer` run `composer lint:style`
5) For check for errors PHP code by `PHP Parallel Lint` run `composer lint:php`
6) For check for errors XML code by `XML Lint` run `composer lint:xml`
7) For check for errors TypoScript code by `TypoScript Lint` run `composer lint:typoscript`
8) For check for errors YAML code by `YAML Lint` run `composer lint:yaml`
9) For run PHP Unit Test run `composer test:unit`
