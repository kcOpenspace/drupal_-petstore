<?php

namespace Drupal\block_petstore_friends\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides a custom blog block.
 *
 * @Block(
 *   id = "petstore_friends_block",
 *   admin_label = @Translation("Friends Blog post"),
 *   category = @Translation("Petstore friends block")
 * )
 */
class FriendsBlogBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  //Builds a renderable array with cache limit of 24hrs
  public function build() {
    
    $blog= $this->get_blog_data();
    // var_dump($blog);

    $blog_post = array (
      array ('id' => $blog->id),
      array ('title' => $blog->title),
      array ('body' => $blog->body)
    );

    // var_dump($blog_post);


    $build['content'] = [
      // '#type' => 'block',
      '#theme' => 'blog_block',
      '#body' => $blog_post,
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


//commented out markup for the original build
// '#markup' => $this ->
  // t('<div class="blog-wrapper">
  //   <div class="left-div">
  //     <img src="https://images.unsplash.com/photo-1497752531616-c3afd9760a11?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80" alt="">
  //   </div>
  //   <div class="right-div">
  //     <div class="title-wrap">
  //       {%$latest_post;%}
  //       <h2 class="title-label">Pet Store Friends</h2>
  //       <p>Latest articles from our pet mates</p>
  //     </div>
  //     <div class="blog-wrap">
  //       <h3 class="blog-title">ARTICLE TITLE</h3>
  //       <p class="blog-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sit amet venenatis urna cursus eget nunc.</p>
  //     </div>
  //     <a href="#" class="read-more-btn">Read More</a>
  //   </div>
  // </div>')
