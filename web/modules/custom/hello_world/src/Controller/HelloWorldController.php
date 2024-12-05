<?php
namespace Drupal\hello_world\Controller;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Drupal\Core\Controller\ControllerBase;
use Drupal\hello_world\HelloWorldSalutation;

/**
 * Controller hello world
 */

class HelloWorldController extends ControllerBase {
  /**
   * The Salutation service
   * @var  HelloWorldSalutation
   */
  protected HelloWorldSalutation $salutation;

  public function __construct(HelloWorldSalutation $salutation) {
    $this->salutation = $salutation;
  }

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('hello_world.salutation')
    );
  }
  /**
   * @return array
   */
  public function HelloWorld(): array {
    return [
    '#theme' => 'hello_world_salutation',
    '#salutation' => $this->salutation->getSalutations(),
    ];
  }
}
