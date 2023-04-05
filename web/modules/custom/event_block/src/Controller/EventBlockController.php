<?php

namespace Drupal\event_block\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\event_utils\Services\EventService;

/**
 * Returns responses for event_block routes.
 */
class EventBlockController extends ControllerBase {

  protected $eventService;

  public function __construct( EventService $eventService) {
   
    $this->eventService = $eventService;
  }

  public static function create(ContainerInterface $container) {
    return new static(
           $container->get('event_utils.event_service')
    );
  }
 

  public function test() {

    
      /*
   
    $currentEventType = "Salon";

    
    
    $displayable_events =array();

    foreach($eligible_events as $event){
      if($this->eventService->getEventType($event) == $currentEventType){
        $displayable_events[] = $event;
      }
      if(count($displayable_events)==3){
        break;
      }
    }



    if(count($displayable_events) < 3 ){

      foreach($eligible_events as $event ){
        if($this->eventService->getEventType($event) !== $currentEventType ){
          $displayable_events[] = $event;
        }

        if(count($displayable_events) == 3){
          break;
        }
      }
    }

    $displayable_events_sorted = $this->eventService->sortEventsByDate($displayable_events);

    foreach($displayable_events_sorted as $event){
      $test[] = $event->label()." - ".$this->eventService->getEventType($event)." - ".$event->get('field_date_start')->getValue()[0]['value'];
    }

    
    var_dump($test);die;

    */
  
  }

  /**
   * Builds the response.
   */
  public function build() {

    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('It works!'),
    ];

    return $build;
  }

}
