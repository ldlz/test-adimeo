<?php

namespace Drupal\event_utils\Services;


/**
 * Class EventService
 * @package Drupal\event_utils\Services
 */
class EventService {

  
    public function sortEventsByDate($events){

      foreach ($events as $event) {
        //create an array with the event id as key and its end date as value for sorting
        $date = $event->get('field_date_end')->getValue();
        $events[$node->id()] =  strtotime($date[0]['value']);
      }
      //Sort events by date
      asort($events);
     
      foreach($events as $key =>$value){
        //Rebuild an array of event object, now sorted by date
        $sorted_events[] = \Drupal\node\Entity\Node::load($key);
      }

    }

    public function getCurrentEvent(){
      return \Drupal::routeMatch()->getParameter('node');
    }

    public function getCurrentEventType(){
        //Get the current event
        $event = $this->getCurrentEvent();
       //Get the event type field from it
         $field = $event->get('field_event_type');
         //Get the label from the taxonomy term referenced in the event type field 
         $event_type =$field->referencedEntities()[0]->label();
    
         return $event_type;
      }
    
      public function getEvents(){
        // Return the list of all event content type
        $nids = \Drupal::entityQuery('node')->condition('type','event')->execute();
        $nodes =  \Drupal\node\Entity\Node::loadMultiple($nids);
    
        foreach ($nodes as $node) {
            
          $events[] = $node;
        }
        return $events;
      }
    
      public function getEventType($event){
        //Get the event type field from the event
        $field = $event->get('field_event_type');
        //Get the label from the taxonomy term referenced in the event type field 
        $eventType =$field->referencedEntities()[0]->label();
    
        return $eventType;
      }
    

 
}