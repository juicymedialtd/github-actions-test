# Wordpress Starter Kit - Docker edition!

A starter kit for WordPress projects

## Kit Contents

- Docker
    - With [MailHog](https://github.com/mailhog/MailHog)
- WordPress
- Themes
    - JuicyStrap - A barebones WordPress starter theme
        - **NO LONGER includes Bootstrap!**
          - Bootstrap was great for providing a good grid system supported by all browsers, but the web has come a long way and it's now dead simple to build your own grid system. Bootstrap tended to add a lot of bloat through components and utilities which often went unused. It's time to say goodbye and get familiar with CSS Grid and Flex instead!
        - Includes:
            - Font Awesome Pro 6
            - Laravel Mix for asset compilation
            - Babel for ESNext transpilation
            - Prettier for code style consistency
            - Stylelint for stylesheet code quality
            - ESLint for JS code quality
            - EditorConfig for code style consistency
    - A WordPress default theme (useful as a fallback for debugging)
- Plugins
    - Advanced Custom Fields Pro
    - WP Media Offload Lite
    - Disable Embeds
    - EWWW Image Optimiser
    - Gravity Forms
    - WordFence
    - Yoast SEO
    - WP Mail SMTP
    - WP Super Cache

## Getting Started

1. Create a new [GitLab Project](https://juicy-media-ltd.gitlab.io/wiki/juicy/gitlab.html#setting-up-a-new-project) if one does not already exist.
2. Download an archive of this repository. Unzip it and rename it to the project name.
3. Initialise your repo
    ```shell script
    git init
    git checkout -b main
    git remote add origin git@gitlab.com:juicy-media-ltd/<PROJECT_SLUG>.git
    ```
4. In `.docker/.env.example`, change the value of the `PHP_IDE_CONFIG` server name to the name of the project.
5. Duplicate `.env.example`, renaming it to `.env`.
6. It's probably a good idea to change the ports this project is bound to, so that they don't clash with other projects you may have running. Change these in docker-compose.yml if required and update this README accordingly.
7. Open the `Dockerfile`, set the base image (`FROM wordpress:php...`) to the latest version of WordPress and PHP supported by the [WordPress Docker image](https://hub.docker.com/_/wordpress).
8. Open a terminal at the project root, run `docker-compose build` then `docker-compose up`.
9. Rename the `juicystrap` folder in `wordpress/wp-content/themes/wp-content/themes` to the theme name.
10. Run and a find and replace on the theme folder, replacing `juicystrap` with your theme name.
11. Update the theme information in `wordpress/wp-content/themes/<THEME_NAME>/style.css`.
12. Open a terminal at `wordpress/wp-content/themes/<THEME_NAME>`, run `npm install` then `npm run dev`.
13. Head to [http://localhost:32080](http://localhost:32080) in your browser, you should see the setup page.
14. Set up the WordPress site:
     - **Step 1:**
         - **Site title:** `<PROJECT_NAME>`
         - **Username:** `juicyadmin`
         - **Password:** `<RANDOM_STRONG_PASSWORD>`
         - **Email:** `admin@juicymedia.co.uk`

* Save these credentials to the Juicy Logins 1Password Vault

## Finally

1. Log into the admin panel, check everything more or less works.
2. Activate the theme.
3. Update Plugins.
4. Activate and set up the plugins as much as possible. You can skip enabling plugins that aren't needed during
   development (e.g. WordFence, WP Super Cache). Remove any that may not be applicable to the project.
    - WP Mail SMTP is set up via `wp-config.php` and `.docker/.env` to send mail on local development to MailHog. Access
      MailHog at [http://localhost:32082](http://localhost:32082).
5. At the root of the project,
   run `docker-compose exec db /usr/bin/mysqldump -u root --password=wordpress wordpress > .docker/db-entrypoint/wordpress.sql`
   . This will dump the DB so it can be committed to git and used as a starting point for developers on this project.
   **It's worth regularly updating this file as the project develops.**
6. Rename `.gitlab-ci.yml.sample` to `.gitlab-ci.yml`, configure the file with the theme name and add or remove any
   relevant jobs
7. Edit this `README.md`:
    - Remove these instructions
    - Uncomment the block below
    - Fill the `<PLACEHOLDERS>`
    - READ and review it - it has useful information that you should be aware of, and you may need to tweak or remove information that might not be applicable to your project.
8. Commit your project and push 
9. Open up your project on GitLab
10. In Deployments > Environment, add two new environments, one called `production` and the other `stage`.
11. In Settings > Repository, under Protected Tags add `v*` and only allow Maintainers to create it.
12. In Settings > CI/CD > Variables, add the following:
    * **AWS_DEFAULT_REGION:** `eu-west-2`
    * **ROLE_ARN:** `arn:aws:iam::948445212038:role/GitLab-OIDC`
    * **IMAGE_NAME:** `wordpress`
    * Once they've been set up in AWS, for each environment add:
      * **ECS_CLUSTER:** The name of the ECS cluster in AWS
      * **ECS_SERVICE:** The name of the ECS service in AWS (probably the same as the cluster name)

```shell script
git add .
git commit -m "Initial commit"
git push -u origin main
```

<!-- 
# <PROJECT NAME>
[![pipeline status](https://gitlab.com/juicy-media-ltd/<PROJECT_SLUG>/badges/develop/pipeline.svg)](https://gitlab.com/juicy-media-ltd/<PROJECT_SLUG>/commits/main)

## Getting Started

1. Clone the [repository](https://gitlab.com/juicy-media-ltd/<PROJECT_SLUG>)
2. **Windows only:** Copy the `/docker-compose.override-wsl.yml` file to `/docker-compose.override.yml`
   * The WSL override file in the project assumes the WSL OS that Docker is configured to use has a user set up and isn't using the root account. You may need to tweak your override file or not use it if you encounter file permission issues.
3. Run `docker-compose build` in the root of the project to build the docker containers
4. Run `docker-compose up` to start the docker containers
5. Open a terminal at `wordpress/wp-content/themes/<THEME_NAME>`, run `npm install` then `npm run dev`.
6. Head to [http://localhost:32080](http://localhost:32080) in your browser, you should see the website.

## Environments and important things to note
The Dockerfile you use in this project for local development is the exact same as what will be deployed to and run on AWS. The CI/CD runners will build a production file using the WordPress files committed to the repo. Because of this there's a few very important things to note.

### WP Config
There isn't a production specific wp-config.php file. Anything put in there will apply to production in the same way that it applies to development. As such, you should rely on environment variables to populate the values of any constants defined in WP Config. The .env file used for development is located in .docker/.env. Anything you add should be replicated in the .env.example file which is tracked by git (remove any secrets from the example file and store them in 1Password).

### Updating WordPress
WordPress updates must be undertaken by updating the Docker image used for this project, rather than through the WP admin panel. Core WordPress files aren't persisted outside of the Docker image, so while an update via WP admin will work initially, it will be reverted once the volume is removed.

To update WordPress, you should:
1. Stop any running containers and remove the WordPress volume (`docker-compose down -v`)
2. Open the Dockerfile, update the version of the base WordPress image (`FROM wordpress:<WORDPRESS_VERSION>-php<PHP-VERSION>`) 
3. Build the updated Dockerfile (`docker-compose build`)
4. Start the containers and verify the version in WP Admin

Note: a named volume is created for this project to allow WP CLI to work. This MUST be removed before building the Dockerfile, otherwise WordPress won't copy over the updated install to the working directory. Passing `-v` to `docker-compose down` will remove this volume.  

## WordPress Admin
Access the WordPress admin panel at [http://localhost:32080/wp-admin/](http://localhost:32080/wp-admin/). 

Check 1Password for login details.

## Mail
WP Mail SMTP is set up via `wp-config.php` and `.docker/.env` to send mail on local development to MailHog. Access MailHog at [http://localhost:32082](http://localhost:32082).

## WP CLI
A WP CLI docker container is available. Commands can be running using `docker-compose run wp-cli <command>`.

## Database
If you need to commit your local dev database to the git repo, run `docker-compose exec db /usr/bin/mysqldump -u root --password=wordpress wordpress | gzip > .docker/db-entrypoint/wordpress.sql.gz` in the root of the project and commit the change.

## Compiling assets

Use the following commands to compile assets:
- For development: `npm run dev`
- To auto-compile files when changed in development: `npm run watch`
- For production: `npm run production`

## Styling
### Stylesheets
This project uses the [7-1 architecture pattern](http://sass-guidelin.es/#architecture).

### Code Style
[Prettier](https://prettier.io) is installed and configured to enforce an opinionated code standard
for JS, CSS, JSON and Markdown files in this project. You should ensure Prettier is run before you make a commit. You can do this by running `npx run prettier . --write` in the root of the theme. Alternatively, configure your IDE to reformat using Prettier and to reformat automatically on save.

The `.editorconfig` in the root of the project contains the configuration for your IDE to enforce these styles. You may need to install an editorconfig plugin for your IDE to enable this. If the file is missing a config setting for an IDE to format stylesheets according to the stylelint rules, please add it and commit the file.

Class names should follow the [BEM Methodology](http://getbem.com/introduction/) in kebab-case. If you are styling a element from a package/library where you have no control over the class names, BEM enforcement can be disabled for the file with `/* stylelint-disable selector-class-pattern */`.

ID selectors should almost never be used to style an element. The only exception to this is to style elements from a package/library where you have no control over the classes/ids on the element. Use `/* stylelint-disable-next-line selector-max-id */` to disable stylelint for the selector in the stylesheet.

### Text sizing
Text sizes should be applied as a relative percentage of the parent element. Avoid rem units for text sizing. Elements are set up to use a fixed font size, which can be scaled accordingly for breakpoints. On iOS, the project is set up to use Dynamic Type font sizing. Using rem units ensures that your text scales properly in line with system preferences or the base font.

To meet the WCAG 2.1 level AA accessibility standard, you must make sure every feature can be used when text size is increased by 200% and that content reflows to a single column when it’s increased by 400%. Breakpoints using em values are provided to assist in this - these ensure that if the font size is increased by the user, they're served a mobile-sized layout, rather than a desktop one where large text may be stuffed into small columns.

### Font Awesome
Font Awesome 6 is included through JS and SVG. You can continue to include fonts on a page using the `<i>` tag, but you must import the icon you want to use and add it to FA's library first, do this in `juicystrap/assets/src/js/partials/fontawesome.js`. 

## Linting
Javascript and Stylesheets are linted to ensure they conform to a specified code standard. Familiarise yourself with [ESLint](https://eslint.org/) and [Stylelint](https://stylelint.io/) for more information.

Your work must pass all linters before being merged into the default branch (develop).

### Commands
Use the following commands to lint files:
- ESLint: `npm run lint:js`
- Stylelint: `npm run lint:style`

### CI/CD
Linters and Prettier are run automatically through [GitLab CI/CD](https://gitlab.com/juicy-media-ltd/<PROJECT_SLUG>/-/pipelines) on merge requests and commits to develop and main. Merge Requests will not be accepted until your work passes the lint tests.

## Deployment
This project is hosted on an AWS Fargate-based architecture. More information on this architecture can be found on the [Terraform Recipe for WordPress on AWS Fargate](https://gitlab.com/juicy-media-ltd/terraform/wordpress-fargate/-/blob/main/README.md) repo.

Deployment to it is handled by [GitLab CI/CD](https://gitlab.com/juicy-media-ltd/<PROJECT_SLUG>/-/pipelines). Commits to the main branch tagged with `v<VERSION_NUMBER>-release` (e.g. `v1.0.1-release`) will be automatically deployed to the production environment, and those tagged with `v<VERSION_NUMBER>-stage` will be automatically deployed to the staged environment.
-->
