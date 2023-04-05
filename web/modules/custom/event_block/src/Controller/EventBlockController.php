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

    //$Events = $this->eventService->getEvents();

   // $current_event_type = $this->eventService->getCurrentEventType();

    $current_date = strtotime(date('m/d/Y h:i:s '));
   //$current_date = '05/29/2020 05:00:51';
    $test_date = strtotime("2020-05-29T05:00:51");

    //var_dump($current_date>$test_date);
    
    //die;

    $nids = \Drupal::entityQuery('node')->condition('type','event')->execute();
    $nodes =  \Drupal\node\Entity\Node::loadMultiple($nids);

    foreach ($nodes as $node) {
      //Get the event type field from the content type
      $date = $node->get('field_date_end')->getValue();
     
      //var_dump($date[0]);die;
      $events[$node->id()] =  strtotime($date[0]['value']);
      
    }
    
    asort($events);
   
    foreach($events as $key =>$value){
      $sorted_events[] = \Drupal\node\Entity\Node::load($key);
    }
/*
    foreach ($Events as $event) {
      if ($this->eventService->getEventType($event) !== $current_event_type){
        //evn pas meme type

      }

      if(strtotime($event->get('field_date_end'))<$cuurent_date ){
        //L'evenement est pass
      }

    
    }
    
*/
    
  
    var_dump($titles);
    die;
  
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
