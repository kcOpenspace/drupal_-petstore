<?php

namespace Drupal\pet_store_friends\Plugin\Block;

use Drupal\Core\Block\BlockBase;

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

    $blog= $this->get_blog_data();
    // var_dump($blog);

    $blog_post = array (
      array ('id' => $blog->id),
      array ('title' => $blog->title),
      array ('body' => $blog->body)
    );

    $build['content'] = [
      '#theme' => 'friends-blog-block',
      '#title' => 'Friends Latest Post',
      '#body' => 'Hello body',
      '#markup' => $this->t('Block2 It works!'),
      '#cache' => ['max-age' => 86400]
    ];

    return $build;
  }

  //Function to fetch Latest friends blog post
  function get_blog_data(){
    //Request fetch and decode json data
    $url = 'https://jsonplaceholder.typicode.com/posts';
    $method = 'GET';
    $client = \Drupal::httpClient();
    $response = $client->request($method,$url);
    $code = $response->getStatusCode();

    if ($code === 200) {
      $data = $response->getBody()->getContents();
    }
    
    $json_reponse = json_decode($data);
    //array pop last item. for the latest blog post
    $latest_post = array_pop($json_reponse);

    return $latest_post;
  }

  

}
