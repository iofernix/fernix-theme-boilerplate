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
```

## Installation

After run `gulp theme:build` the boilerplate is installed directly into your themes folder "as-is". You must rename it and the classes inside of it to fit your needs. For example, if your theme is named 'my-theme' then:

* rename files from `plugin-name` to `my-theme`
* change `theme_name` to `my_theme`
* change `theme-name` to `my-theme`
* change `Theme_Name` to `My_Theme`
* change `THEME_NAME_` to `MY_THEME_`

It's safe to activate the theme at this point. Because the Boilerplate has no real functionality there will be no menu items, meta boxes, or custom post types added until you write the code.

## Development

To begin working on your project run `gulp theme:build` to send the code changes to the build directory, this is a manual task and you need to run it every you do changes. Also, if you want you can run `gulp theme:watch` to watch code changes and send it to the build directory automatically every a change happens.

## Deployment

Add additional notes about how to deploy this on a live system

## Built With

* [Dropwizard](http://www.dropwizard.io/1.0.2/docs/) - The web framework used
* [Maven](https://maven.apache.org/) - Dependency Management
* [ROME](https://rometools.github.io/rome/) - Used to generate RSS Feeds

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, see the [tags on this repository](https://bitbucket.org/iofernix/fernix-theme-boilerplate/downloads/?tab=tags).

## Authors

* **Fernando Vargas** - *Initial work*

## License

The scripts and documentation in this project are released under the [MIT License](LICENSE)
