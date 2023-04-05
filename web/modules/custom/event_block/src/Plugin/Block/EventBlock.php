<?php

namespace Drupal\event_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\event_utils\Services\EventService;
/**
 * Provides an example block.
 *
 * @Block(
 *   id = "event_block",
 *   admin_label = @Translation("EventBlock"),
 *   category = @Translation("event_block")
 * )
 */
class EventBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected $eventService;


  public function __construct(array $configuration, $plugin_id, $plugin_definition, EventService $eventService) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->eventService = $eventService;
  }

  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('event_utils.event_service')
    );
  }
 
  /**
   * {@inheritdoc}
   */
  public function build() {

    //Get all events with end date not exceeded, ordered by starting date
    $eligible_events = $this->eventService->getEligibleEvents();
    
   //Get the current event type
    $currentEventType = $this->eventService->getCurrentEventType();

    
    
    $displayable_events =array();

    //Get up to 3 events with the same type as the current one from the list fetched earlier
    foreach($eligible_events as $event){
      if($this->eventService->getEventType($event) == $currentEventType && $event->id() != $this->eventService->getCurrentEvent()->id()){
        $displayable_events[] = $event;
      }
      if(count($displayable_events)==3){
        break;
      }
    }


    //If there is less than 3 events of the same type, add other events of different type until we get 3
    if(count($displayable_events) < 3 ){

      foreach($eligible_events as $event ){
        if($this->eventService->getEventType($event) !== $currentEventType ){
          $displayable_events[] = $event;
        }

        if(count($displayable_events) == 3){
          break;
        }
      }

    //sort events by starting date (ASC) after adding the new ones
    $displayable_events = $this->eventService->sortEventsByDate($displayable_events); 
    }


    //Preparing data for twig display

    foreach($displayable_events as $event){
      $events[] = 
      [
        "nid" => $event->id(),
        "label" => $event->label(),
        "type_taxo" => $event->get('field_event_type')->first()->getValue()['target_id'],
        "type" => $this->eventService->getEventType($event),
        "start_date" => $event->get('field_date_start')->getValue()[0]['value'],
        "end_date" =>$event->get('field_date_end')->getValue()[0]['value'],
      ];
    }
       
    $renderable = [
      '#theme' => 'event_block_template',
      '#events' => $events,
    ];

    return $renderable;
  }

  public function getCacheMaxAge() {
    return 0;
  }
}
