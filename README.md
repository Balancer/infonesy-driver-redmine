# Redmine driver for Infonesy

## Tests

```php
const REDMINE_RMBR_KEY = 'xxxxxxxxxxxxxxxxxxx';

require 'vendor/autoload.php';

$rm = \B2\Infonesy\Redmine::factory('http://rm.balancer.ru');

$rm->set_api_key(REDMINE_RMBR_KEY);
```
