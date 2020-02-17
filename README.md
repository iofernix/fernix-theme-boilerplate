# Fernix Theme Boilerplate

A standardized, organized, object-oriented foundation for building high-quality WordPress Plugins.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine for development and testing purposes. See deployment for notes on how to deploy the project on a live system.

### Pre-requisites

You must have already installed `npm` and `nvm` if you haven't you can follow these links to know how to do it.

* Installing [nodejs](https://nodejs.org/en/download/package-manager/) via package manager.
* Installing & Updating [nvm](https://github.com/nvm-sh/nvm#installing-and-updating)

Once you have `npm` and `nvm` installed on your machine, do:

```
nvm use && npm install
```

Create an environment variables `.env` file in the root directory. An example is available below.

```
BUILD_PATH=./build
DIST_PATH=./dist
PHPCS_PATH=./phpcs
```

## CI/CD

We are using CircleCI as our continuous integration service and to setting up a project you need to do the following:

* Login into CircleCI Business account and go to **Add projects** page.
* Search by project repository and click **Set Up Project** and next **Start Building**.
* In a terminal, generate the key with `ssh-keygen -m PEM -t rsa -C "your_email@example.com"`.
* In the CircleCI application, go to your project’s settings by clicking the gear icon next to your project.
* In the Permissions section, click on SSH Permissions.
* Click the Add SSH Key button.
* In the Hostname field, enter the key’s associated host (for example, “github.com”). If you don’t specify a hostname, the key will be used for all hosts.
* In the Private Key field, paste the SSH key you are adding.
* Click the Add SSH Key button.
* Copy the Fingerprint and paste it on CircleCI as new environment variable with the name **FNX_REMOTE_SSH_KEY**.
* Add a new environment variable with the name **FNX_REMOTE_REPO**.

## Installation

After run `gulp theme:build` the boilerplate is installed directly into your themes folder "as-is". You must rename it and the classes inside of it to fit your needs. For example, if your theme is named 'my-theme' then:

* rename files from `theme-name` to `my-theme`
* change `theme_name` to `my_theme`
* change `theme-name` to `my-theme`
* change `Theme_Name` to `My_Theme`
* change `THEME_NAME_` to `MY_THEME_`

It's safe to activate the theme at this point. Because the Boilerplate has no real functionality there will be no menu items, meta boxes, or custom post types added until you write the code.

## Development

To begin working on your project run `gulp theme:build` to send the code changes to the build directory, this is a manual task and you need to run it every you do changes. Also, if you want you can run `gulp theme:watch` to watch code changes and send it to the build directory automatically every a change happens.

## Deployment

Before to deploy your code to the different environments you need to have the following set up:

* Add a new project subdomain in **Plesk Business Account** using the naming convention `dev-{project-name}.fernix.org`.
* Install a new empty WordPress site.
* Create a private repository in GitHub Business Account based on [fernix-template-repository](https://github.com/fernando-vargas-fernix/fernix-template-repository) with the same name as Bitbucket repository is.
* Go to the project's domain and under git section add the new repository with ssh.
* Copy and paste the ssh key provided by Plesk to **SSH and GPG keys** page on your GitHub profile.
* As a suggestion, you can use **Plesk Auto-Deploy [project-domain]** as the key title.
* If you get the key is already used error, check if the key is set globally.
* In Plesk Account change the target directory where the code will be deployed as well as the branch.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://bitbucket.org/iofernix/fernix-theme-boilerplate/downloads/?tab=tags).

## Authors

* **Fernando Vargas** - *Initial work*

## License

The scripts and documentation in this project are released under the [MIT License](LICENSE)
