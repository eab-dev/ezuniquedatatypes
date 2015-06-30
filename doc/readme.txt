eZ Unique Datatypes extension for eZ Publish 4.0
version 0.5 beta

Written by Piotrek Karaś, Copyright (C) SELF s.c. & mediaSELF.pl
http://www.mediaself.pl, http://ryba.eu



What is it?
-----------

This is a collection of common datatypes whose validation has been extended
so to verify their uniqueness within given content object attribute. Otherwise,
these datatypes behave exactly as their prototypes.

Currently there are two datatypes provided:
- Unique string (based on Text line system datatype),
- Unique URL (based on URL system datatype).

Use these if you want to make sure that a given attribute of a given class
never accepts/stores two identical values.

Note: uniqueness is validated within the same attribute only, which means that
if you use the datatype in two different classes, it will become two
independent attributes resulting in two independent uniqueness sets! This may
be changed/enhanced in the future.

Note:
# Versions 0.1-0.3 (strings), 0.1-0.4 (URLs):
Uniqueness is validated globally, which means it will not skip content
objects that are drafts, in trash, or unpublished versions! However, multiple
versions of the same content object may store the same value (in fact, it would
not work otherwise).
# Versions 0.4+ (string), 0.5+ (URLs):
New feature for strings available: possible to check current versions only.
# For backward compatibility set: CurrentVersionOnly=false



License
-------

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; version 2 of the License.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA 02111-1307, USA.



Requirements
------------

- eZ Publish 4.0.0+
- eZ Publish Components: Base, File



Tested with
-----------
4.0.0



Installation
------------

1. Copy the extension to the /extension folder, so that
you have /extension/ezuniquedatatypes/* structure.

2. Enable the extension (either via administration panel or directly with
settings files):
[ExtensionSettings]
ActiveExtensions[]=ezuniquedatatypes

3. Clear cache.



Changelog
---------

# v0.5 beta, public, 2008.01.11
+ New feature: schema validation for URLs.
+ Bug fix: invalid uniqueness cheing procedure for URLs.
+ New feature: possible to check only current object versions for URLs.
+ Debug info option added for URLs.

# v0.4 beta, public, 2008.01.05
+ New feature: possible to check only current object versions for strings.
+ Debug info option added.

# v0.3 beta, public, 2007.12.13
+ Minor fixes.
+ Documentation changes.

# v0.2 beta, public, 2007.12.13
+ Multiple corrections and bugfixes.
+ Dedicated SQL queries.
+ Tests for different scenarios: published, versions, drafts, trash.

# v0.1 alpha, local, 2007.12.11
+ First almost fully working version, the basic elements and functionality
  only, with little info.

# v0.0 alpha, local, 2007.12.11
+ Start.


/+/ complete
/-/ plan or in progress
