eZ Unique Datatypes
===================

## Summary

eZ Unique Datatypes extension for eZ Publish 4.0

See http://projects.ez.no/ez_unique_datatypes

This is a collection of common datatypes whose validation has been extended
so to verify their uniqueness within given content object attribute. Otherwise,
these datatypes behave exactly as their prototypes.

Currently there are two datatypes provided:

* Unique string (based on Text line system datatype),
* Unique URL (based on URL system datatype).

[More documentation](doc/readme.txt)

## Copyright

Copyright (C) 2007 [mediaSELF.pl](http://www.mediaself.pl/)

## License

Licensed under GNU General Public License v2.0

## Requirements

Requires eZ Publish 4 or eZ Publish 5 Legacy Edition.

## Install

1. Copy the `ezuniquedatatypes` folder to the `extension` folder.

2. Edit `settings/override/site.ini.append.php` and under `[ExtensionSettings]` add:

        ActiveExtensions[]=ezuniquedatatypes

3. Update the autoloads array and clear the cache:

        bin/php/ezpgenerateautoloads.php
        bin/php/ezcache.php --clear-all

## Usage

Edit classes and add attributes using the relevant datatype.
