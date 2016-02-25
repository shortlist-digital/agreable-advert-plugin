<?php namespace AgreableAdvertPlugin\Hooks;

class TimberTwig {

  public function init() {
    \add_filter('get_twig', array($this, 'add_to_twig'), 10);
  }

  public function add_to_twig($twig){
    $twig->addFunction(
      new \Twig_SimpleFunction('vertical_advert',
        array('AgreableAdvertPlugin\Services\AdvertSlotGenerator', 'get_vertical_advert'))
    );
    return $twig;
  }
}
