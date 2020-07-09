<?php

namespace Drupal\pet_store_friends\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Component\Serialization\Json;
use GuzzleHttp\Client;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides an latest post friends blog block.
 *
 * @Block(
 *   id = "pet_store_friends_block",
 *   admin_label = @Translation("friends_blog"),
 *   category = @Translation("pet store friends")
 * )
 */

class PetStoreFriendsBlock extends BlockBase implements ContainerFactoryPluginInterface{

  /**
   * Guzzle Http Client.
   *
   * @var GuzzleHttp\Client
   */
  protected $httpClient;

  /**
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   * @param \Drupal\Core\Session\Client $http_client
   */
  public function __construct(array $configuration, $plugin_id, $plugin_definition, Client $http_client) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
    $this->httpClient = $http_client;
  }

  /**
   * @param \Symfony\Component\DependencyInjection\ContainerInterface $container
   * @param array $configuration
   * @param string $plugin_id
   * @param mixed $plugin_definition
   *
   * @return static
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('http_client')
    );
  }

  //Request data for blog posts through the Guzzle client
  public function getBlogPosts($url, $method) {

    $response = $this->httpClient->request($method,$url);
    $code = $response->getStatusCode();

    if ($code === 200) {
      $data = $response->getBody()->getContents();
      $post_data = Json::decode($data);
    }

    return $post_data;
  }
  
  public function latestBlogPosts() {
    $url = 'https://jsonplaceholder.typicode.com/posts';
    $method = 'GET';

    $latest_post[] = array_pop($this->getBlogPosts($url, $method));

    return $latest_post;
  }

  /**
   * {@inheritdoc}
   */
  public function build() {

    $blog= $this->latestBlogPosts();

    $build['content'] = [
      '#theme' => 'friends-blog-list',
      '#title' => 'Pet store friends',
      '#body' => $blog,
      '#cache' => ['max-age' => 86400]
    ];

    return $build;
  }

  

}
