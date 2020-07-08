<?php

namespace Drupal\pet_store_friends\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Component\Serialization\Json;
use GuzzleHttp\Client;

/**
 * Returns responses for pet store friends routes.
 */
class PetStoreFriendsController extends ControllerBase {

  /**
   * Builds the response.
   */
  public function build() {

    $blog_list = $this -> get_blog_data();

    //Get the Latest 10 posts from the array
    $latest_ten_posts = array_splice (
      $blog_list, 
      count($blog_list)-10, 
      count($blog_list), 
      true
    );

    return [
      '#theme' => 'friends-blog-list',
      '#title' => 'Pet store friends',
      '#body' => $latest_ten_posts,
      '#cache' => ['max-age' => 86400]
    ];

  }

  //Function to fetch Latest friends blog post
  function get_blog_data(){
    //Request fetch and decode json data
    $url = 'https://jsonplaceholder.typicode.com/posts';
    $method = 'GET';
    $client = new Client();
    $response = $client->request($method,$url);
    $code = $response->getStatusCode();

    if ($code === 200) {
      $json_data = $response->getBody()->getContents();
    }
    //decode json data
    $posts_data = Json::decode($json_data);
    //latest posts items. for the latest blog post
    $latest_posts = $posts_data;

    return $latest_posts;
  }

}
