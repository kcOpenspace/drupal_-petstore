<?php
namespace Drupal\blogapi_controller\Controller;
class BlogController {
    public function page() {

        $body = array (
            array('name' => 'Blog One'),
            array('name' => 'Blog Two'),
            array('name' => 'Blog Three')
        );
        
        return array(
            '#theme' => 'blog_list',
            '#title' => 'Friends Blog List',
            '#body' => $body
        );
    }

    public function fetchApi(){
        //Request fetch and decode json data
        $url = "https://jsonplaceholder.typicode.com/posts";
        $request = drupal_http_request($url);
        $json_reponse = drupal_json_decode($request->data);
        
        $blog = array(
            '#title' => 'title',
            '#body' => 'body'
        );
        foreach ($json_response as $data) {
            array_push($blog,$data);
        }
    }

}

?>