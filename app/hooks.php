<?php

/** @var  \Herbert\Framework\Application $container */

use AgreableAdvertPlugin\Hooks\TimberTwig;
use AgreableAdvertPlugin\Hooks\SLMPluginEnqueue;

(new TimberTwig)->init();
(new SLMPluginEnqueue)->init();
