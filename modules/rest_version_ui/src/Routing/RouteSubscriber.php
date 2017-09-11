<?php

namespace Drupal\rest_version_ui\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Drupal\Core\Routing\RoutingEvents;
use Symfony\Component\Routing\RouteCollection;

/**
 * Subscriber for version rest routes.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection) {

    // Overwrite the main "rest" page with a list of our versions.
    // Since all the actual resources will live one item deeper.
    $collection->get('restui.list')->setDefault('_controller', '\Drupal\rest_version_ui\Controller\RestVersionUIController::listVersions');

  }

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents() {
    $events = parent::getSubscribedEvents();
    $events[RoutingEvents::ALTER] = ['onAlterRoutes', 100];
    return $events;
  }

}
