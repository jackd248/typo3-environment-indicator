..  include:: /Includes.rst.txt

..  _configuration:

=============
Configuration
=============

The extension is ready to use without any further setup.

By default the following environment are preset:

- :code:`Production/Standby`
- :code:`Production/Staging`
- :code:`Production/Stage`
- :code:`Testing*`
- :code:`Development*`

..  seealso::

    See the :ref:`example` for the complete configuration.


You can adapt the extension to your needs, switch single features on and off and influence the presentation of the indicators.

If you want to add your own indicators, you should disable the :ref:`default configuration<extconf-general.defaultConfiguration>` within the extension configuration.

..  toctree::
    :maxdepth: 3

    ExtensionConfiguration
    Handler
