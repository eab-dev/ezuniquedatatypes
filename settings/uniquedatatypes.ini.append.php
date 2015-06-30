<?php /* #?ini charset="utf-8"?

[UniqueStringSettings]

# Decides if uniqueness should be validated using current versions of objects
# only (new feature) or all versions that were ever published (up till v0.4
# of this extension that was the default and only option).
# If true, the string will be only validated against current versions of all
# objects except itself.
# If false, the string will be validated against all versions of all objects
# except itself.
CurrentVersionOnly=true


[UniqueURLSettings]

# Decides if uniqueness should be validated using current versions of objects
# only (new feature) or all versions that were ever published (up till v0.5
# of this extension that was the default and only option).
# If true, the URL will be only validated against current versions of all
# objects except itself.
# If false, the URL will be validated against all versions of all objects
# except itself.
CurrentVersionOnly=true

# A list of schemas that will be forced for successful validation of URLs.
# If empty, validation will not be performed!
AllowedSchemaList[]
AllowedSchemaList[]=http://
AllowedSchemaList[]=https://


/* ?>
