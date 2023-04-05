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

  /*
  public static function create (ContainerInterface $container){
    return new static ($container->get('event_utils.event_service'));
  }*/

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
  /*
  public function __construct(EventService $eventService)
  {
    $this->eventService = $eventService;
  }
*/
 
  /**
   * {@inheritdoc}
   */
  public function build() {

    
    $eventType = $this->eventService->getCurrentEventType();
    $build['content'] = [
      '#markup' => $this->t($eventType),
    ];
    return $build;
  }

}
