<?php

/** @var  \Herbert\Framework\Application $container */

use AgreableAdvertPlugin\Hooks\TimberTwig;
use AgreableAdvertPlugin\Hooks\SLMPluginEnqueue;
// use AgreableAdvertPlugin\Hooks\SavePost;

(new TimberTwig)->init();
(new SLMPluginEnqueue)->init();
// (new SavePost)->init();
