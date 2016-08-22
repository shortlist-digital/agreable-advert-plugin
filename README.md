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

## Use within PHP

```
$advert_data = AgreableAdvertPlugin\Services\AdvertSlotGenerator::get_advert_data($post, 'horizontal', ['pos' => 'top']);
var_dump($advert_data);
// Outputs
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

## API routes

Get a single advert, rendered as HTML, complete with container CSS and JS to load (for Instant Articles):

```
/advert/2074/horizontal/pos=top,another_key=value
```
