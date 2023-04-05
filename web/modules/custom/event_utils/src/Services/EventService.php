<?php

namespace Drupal\event_utils\Services;


/**
 * Class EventService
 * @package Drupal\event_utils\Services
 *
 */
class EventService {

  //Get all content of type event, ordered by starting date
  public function getEvents(){
    
    $query = \Drupal::entityQuery('node')->condition('type', 'event');
    $query->sort('field_date_start', 'ASC');
    $events_id = $query->execute();
    $events = \Drupal\node\Entity\Node::loadMultiple($events_id);

    return $events;


  }

  //Get alle content of type event with its end date not exceeded and ordered by starting date
  public function getEligibleEvents(){

    $query = \Drupal::entityQuery('node')->condition('type', 'event');
    $query->condition('field_date_end', date('Y-m-d h:i:s'),'>');
    $query->sort('field_date_start', 'ASC');
    $events_id = $query->execute();
    $events = \Drupal\node\Entity\Node::loadMultiple($events_id);

    return $events;
  }


  //Sort an array of event content type by its starting date
  public function sortEventsByDate($events){

    foreach ($events as $event) {
      //create an array with the event id as key and its end date as value for sorting
      $date = $event->get('field_date_start')->getValue();
      $events_array[$event->id()] =  strtotime($date[0]['value']);
    }
     
    //ASC Sorting by array values while keeping the same keys
    asort($events_array);
    
    foreach($events_array as $key =>$value){
      //Rebuild an array of event object, now sorted
      $sorted_events[] = \Drupal\node\Entity\Node::load($key);
    }

    return $sorted_events;
  }

  //Get current page event content type
  public function getCurrentEvent(){
    return \Drupal::routeMatch()->getParameter('node');
  }

  //Get the taxonomy term label of type field of the current event
  public function getCurrentEventType(){
    //Get the current event
    $event = $this->getCurrentEvent();
    //Get the event type field from it
    $field = $event->get('field_event_type');
    //Get the label from the taxonomy term referenced in the event type field 
    $event_type =$field->referencedEntities()[0]->label();
  
    return $event_type;
  }
    
  //Get the taxonomy term label of type field of the event passed as parameter
  public function getEventType($event){
    //Get the event type field from the event
    $field = $event->get('field_event_type');
    //Get the label from the taxonomy term referenced in the event type field 
    $eventType =$field->referencedEntities()[0]->label();
  
    return $eventType;
  }
    

 
}