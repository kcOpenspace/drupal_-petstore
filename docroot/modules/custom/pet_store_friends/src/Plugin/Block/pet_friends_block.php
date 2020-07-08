<?php

namespace Drupal\pet_store_friends\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Component\Serialization\Json;
use GuzzleHttp\Client;

/**
 * Provides an latest post friends blog block.
 *
 * @Block(
 *   id = "pet_store_friends_block",
 *   admin_label = @Translation("friends_blog"),
 *   category = @Translation("pet store friends")
 * )
 */
class Pet_Friends_Block extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function build() {

    $blog= $this->getBlogData();

    $build['content'] = [
      '#theme' => 'friends-blog-list',
      '#title' => 'Pet store friends',
      '#body' => $blog,
      '#cache' => ['max-age' => 86400]
    ];

    return $build;
  }

  //Function to fetch Latest friends blog post
  function getBlogData(){
    //Request fetch and decode json data
    $url = 'https://jsonplaceholder.typicode.com/posts';
    $method = 'GET';
    $client = new Client();
    $response = $client->request($method,$url);
    $code = $response->getStatusCode();

    if ($code === 200) {
      $data = $response->getBody()->getContents();
    }
    
    $json_reponse = Json::decode($data);
    //array pop last item. for the latest blog post
    $latest_post = array(array_pop($json_reponse));

    return $latest_post;
  }

  

}
