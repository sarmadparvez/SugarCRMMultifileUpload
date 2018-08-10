# SugarCRMMultifileUpload

This plugin adds a multifile upload field in Leads module by default and creates a relationship of Leads with Documents. Multiple files can be selected and each file is uploaded as a separate document record inside out of the box Documents module.

The code is generic, which means that the same multifile upload field can be added in other sidecar modules too. To make it work with other modules follwing needs to be done.

1. The module should have relationship with Documents and there should be a subapnel of Documents in that module.
2. The multifile upload field should be placed inside record view of that module.

Currenty Compatible with SugarCRM 7 and 8 onsite.
