<?php namespace AgreableAdvertPlugin\Hooks;

use add_filter;
use Twig_SimpleFunction;

class TimberTwig {

  public function init() {
    add_filter('get_twig', array($this, 'add_to_twig'), 10);
  }

  public function add_to_twig($twig){
    $twig->addFunction(
      new \wig_SimpleFunction('advert_data',
        array('AgreableAdvertPlugin\Services\AdvertSlotGenerator', 'get_advert'))
    );

    return $twig;
  }
}
