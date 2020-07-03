<?php

namespace Drupal\petstore_friends_block\Plugin\Block;

use Drupal\Core\Block\BlockBase;

/**
 * Provides an example block.
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
  public function build() {
    $build['content'] = [
      '#markup' => $this ->
        t('<div class="blog-wrapper">
          <div class="left-div">
            <img src="https://images.unsplash.com/photo-1497752531616-c3afd9760a11?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=1050&q=80" alt="">
          </div>
          <div class="right-div">
            <div class="title-wrap">
              <h2 class="title-label">Pet Store Friends</h2>
              <p>Latest articles from our pet mates</p>
            </div>
            <div class="blog-wrap">
              <h3 class="blog-title">ARTICLE TITLE</h3>
              <p class="blog-body">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sit amet venenatis urna cursus eget nunc.</p>
            </div>
            <a href="" class="read-more-btn"></a>
          </div>
        </div>')
    ];
    return $build;
  }

}
