# Juggling
This is a repository for i-be-jugglin project.

## Current features

### Tricks
- **Customizable Juggler**  loads data from CSS and from database to display any submited trick. Uses Pichał's code format. Still needs editor.
- Currently only *Tricks of the week* are avaiable to users.
They are displayed both in form of *Blog* and *Suwajka™*

### Users
- Provides `log-in` and `register` which still need improvements.
- Reaction and comments are still unavaiable

## TODO

- Trick Editor
- Blog Entry Editor
- Register restrictions, validation, and captcha
- User reactions under posts
- Blog Entry loading through Ajax, especially when there's many Entries


## Changelog

### 4-05-2019

- Cleaned most of code (JS is still to be done)
- Spit CSS files into `design` and `appearance`
- In PHP functions return value instead displaying it.
If functionality is used by Ajax there shall be separate function that displays value returned by functionality
- Began using FontAwesome icons
- Minor design changes