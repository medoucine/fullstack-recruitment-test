
<p align="center"><img src="https://www.medoucine.com/images/logos/logo.svg" width="350"></p>

## Fullstack developper test

Hi!

Great that you're interested in this exercise! Thanks a lot for making it. The exercise is about making a minimal search engine of medoucine with Laravel and VueJS.

![Image](https://github.com/medoucine/fullstack-recruitment-test/blob/master/result.gif)

### What you'll have to do:
- Allow user to search therapists by city and practice with the form
- Allow user to search therapists by clicking on links
- Cities, practices and search links have to be generated from therapists list (./database/db.json)
- **The form and the links can't lead to no result**
- Make design integration with SASS and Bootstrap 4
- Make all user interaction with VueJS (./resource/js/component/MainComponent.vue)
- Make a quick API with Laravel 5.7 (which will serve cities, practices, ..)

#### Technical expectations
**Front- JS**

At least 1 component must be tested, with at least 2 unit tests.

You'll have to explain:
- your decisions regarding HTML/CSS
- your decisions regarding component structure

**Back - PHP**

You'll have to explain:
- your PHP architecture, How did you manage service responsability ?

You'll have to unit test codes responsible for getting the search results, according to specs

**Ops - Bash (Bonus)**

Write a deployment bash script (install, test, build, serve)
It should fail if one or more commands fails.



To complete this test you need to download (NOT fork) this repo. When you're done you can push your changes to your own repo (and let us know where to find it of course).

## Prerequisites
- PHP7.x
- Node >=6
- Yarn
- PHP composer

## Installation

1. Fork and pull this repository
2. Install PHP packages
3. Install NodeJS packages

## Developpment

- Run a server with `php artisan serve`
- Run auto compilation with `npm run watch` or `npm run watch-poll` (see packages.json for full list of commands) 
- Use the json file as database located in `./database/db.json` which represent list of therapists

## Finish

Send us back your work!


![Image](https://github.com/medoucine/fullstack-recruitment-test/blob/master/result.png)

