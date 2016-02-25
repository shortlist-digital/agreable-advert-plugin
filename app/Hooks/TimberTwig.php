<?php namespace AgreableAdvertPlugin\Hooks;

// use AgreableAdvertPlugin\Helper;

class TimberTwig {

  public function init() {
    var_dump(874983); exit;
    \add_filter('get_twig', array($this, 'addToTwig'), 10);
  }

  public function addToTwig($twig){
    $twig->addFunction(
      new \Twig_SimpleFunction('vertical_advert', array('AgreableAdvertPlugin\Services\AdvertSlotGenerator', 'get_vertical_advert'))
    );
    return $twig;
  }
}
