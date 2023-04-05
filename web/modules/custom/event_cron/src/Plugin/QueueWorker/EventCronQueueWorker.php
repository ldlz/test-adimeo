<?php

namespace Drupal\event_cron\Plugin\QueueWorker;

use Drupal\Core\Queue\QueueWorkerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\event_utils\Services\EventService;

/**
 * @QueueWorker(
 *  id = "event_cron_queueworker",
 *  title = "Event Cron QueueWorker",
 *  cron = {"time" = 60 }
 * )
 */

 class EventCronQueueWorker extends QueueWorkerBase implements ContainerFactoryPluginInterface {
    
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
   * {@inheritDoc}
   */
  public function processItem($event) {
    //Unpublish each item ( outdated event) in the queue

    if ($event && $event->status->getString() == 1) { //Check if the event is published
        $event->setUnpublished();
        $event->save();
        \Drupal::logger('event_cron')->notice("The event : ".$event->label()." has been unpublished");
      }
  }
  
 }