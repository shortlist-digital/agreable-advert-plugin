<?php

/** @var  \Herbert\Framework\Application $container */

use AgreableAdvertPlugin\Hooks\TimberTwig;
use AgreableAdvertPlugin\Hooks\SLMPluginEnqueue;
use AgreableAdvertPlugin\CustomFields\Category;

(new TimberTwig)->init();
(new SLMPluginEnqueue)->init();
