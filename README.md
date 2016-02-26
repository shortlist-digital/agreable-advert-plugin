Shortlist Media Wordpress Advert Plugin
===============

Wordpress Plugin built for Croissant stack using [Herbert](http://getherbert.com/) plugin framework.

---

### Dependencies

* Croissant
* Timber
* Advanced Custom Fields

---

#### Fire plugin specific action whilst rendering (to enqueue styles/scripts within plugin)   
* `/app/hooks/SLMPluginEnqueue.php`  
Just before rendering the plugin template, the parent theme calls Wordpress `do_action('acf_{{name}}_enqueue')`. e.g. (using Timber):  
`{% do action('slm_'~widget.acf_fc_layout~'_enqueue', widget) %}`  
The hook name is constructed from the ACF Field Group 'name' in `widget-loader-acf.php`. e.g. 'agreable_advert-slot_enqueue'

#### Configurable plugin options for Wordpress installation 
* `app/panels.php`  
Adds Settings panel for installation specific configuration. Uses ACF definitions.

#### Deploy to packagist

Check the current latest tag
`git fetch && git tag`

Bump the version appropriately and tag
`git tag x.x.x`

Push to Github. Packagist will receive a hook and update the file
`git push origin master --tags`
