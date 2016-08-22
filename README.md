Shortlist Media Wordpress Advert Plugin
===============

Wordpress Plugin built for Croissant stack using [Herbert](http://getherbert.com/) plugin framework.

---

## Use within Twig

### Get advert data

```
<!-- Twig function -->
{{ get_advert_data(post, 'horizontal', [{'pos': 'top'}]) }}

<!-- Outputs -->
{
  'type': 'horizontal',
  'targetting': [{'pos': 'top'}],
  'devices': {
    'desktop': {
      'creative-sizes': [[970, 250], [728, 90]]
    }, 
    'tablet': {
      'creative-sizes': [[728, 90]]
    }, 
    'mobile': {
      'creative-sizes': [[320, 50]]
    }
  }
}
```

### Get advert HTML

```
<!-- Twig function -->
{{ get_advert_html(post, 'horizontal', [{'pos': 'top'}]) }}

<!-- Outputs -->

<div data-module='AdvertSlot' data-advert-id='a876sd7f65sd76f'>
  <script type='application/json'>
    { ...advert object } 
  </script>
</div>
```
