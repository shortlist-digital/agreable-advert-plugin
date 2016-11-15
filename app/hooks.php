<?php

/** @var  \Herbert\Framework\Application $container */

use AgreableAdvertPlugin\Hooks\TimberTwig;
use AgreableAdvertPlugin\Hooks\AdvertsPageSetup;

(new TimberTwig)->init();
(new AdvertsPageSetup)->init();
