..  include:: /Includes.rst.txt

..  _extension-configuration:

=======================
Extension configuration
=======================

#. Go to :guilabel:`Admin Tools > Settings > Extension Configuration`
#. Choose :guilabel:`typo3_environment_indicator`

The extension currently provides the following configuration options:

General
=======

..  _extconf-general.imageDriver:

..  confval:: general.imageDriver
    :type: option
    :Default: "gd"

    Intervention Image supports "GD Library", "Imagick" and "libvips" to process images internally. You may choose one of them according to your PHP configuration. Options are "gd", "imagick" and "vips".

Frontend
=======

..  _extconf-frontend.favicon:

..  confval:: frontend.favicon
    :type: boolean
    :Default: 1

    Enable the favicon generation in frontend context

..  _extconf-frontend.context:

..  confval:: frontend.context
    :type: boolean
    :Default: 1

    Enable the context frontend hint

Backend
=======

..  _extconf-backend.favicon:

..  confval:: backend.favicon
    :type: boolean
    :Default: 1

    Enable the favicon generation in backend context

..  _extconf-backend.context:

..  confval:: backend.context
    :type: boolean
    :Default: 1

    Enable the context item within the backend toolbar

..  _extconf-backend.contextProduction:

..  confval:: backend.contextProduction
    :type: boolean
    :Default: 1

    Enable the backend toolbar item / backend topbar also in production context

..  _extconf-backend.contextProductionUserGroups:

..  confval:: backend.contextProductionUserGroups
    :type: string
    :Default:

    Restrict the backend user groups that are shown the toolbar item / topbar in the production context (comma separated list of group ids)
