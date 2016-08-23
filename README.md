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
/advert/{post_id}/{post_type}/{key_values}
/advert/2074/horizontal/pos=top,another_key=value
```

## Ad type

### Horizontal

* Billboard 970x250
* Leaderboard 728x90
* Mobile banner

```
{
  'type': 'horizontal',
  'targetting': [{'pos': 'top|2'}],
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

### Vertical

* HPU 300x600
* MPU 300x250

```
{
  'type': 'horizontal',
  'targetting': [{'pos': 'top|2'}],
  'devices': {
    'desktop': {
      'creative-sizes': [[300, 600], [300, 250]]
    }, 
    'tablet': {
      'creative-sizes': [[300, 600], [300, 250]]
    }, 
    'mobile': {
      'creative-sizes': [[300, 250]]
    }
  }
}
```

### In-Article

```
{
  'type': 'in-article (tbc)',
  'targetting': [{'pos': 'top|2'}],
  'devices': {
    'desktop': {
      'creative-sizes': [[300, 600], [300, 250]]
    }, 
    'tablet': {
      'creative-sizes': [[300, 600], [300, 250]]
    }, 
    'mobile': {
      'creative-sizes': [[300, 250]]
    }
  }
}
```

### Skin

```
{
  'type': 'skin',
  'targetting': [{'pos': 'skin', 'pos': 'l|r'}],
  'devices': {
    'desktop': {
      'creative-sizes': [[300, 900]]
    }
  }
}
```
