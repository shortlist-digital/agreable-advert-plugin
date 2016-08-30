<?php

/** @var  \Herbert\Framework\Application $container */

use AgreableAdvertPlugin\Hooks\TimberTwig;
use AgreableAdvertPlugin\Hooks\DfpZone;

(new TimberTwig)->init();
(new DfpZone)->init();
