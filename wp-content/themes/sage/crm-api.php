<?php
class CRM_API extends WP_REST_Controller {
 
  /**
   * Register the API routes 
   **/
  public function register_routes() {
    $version = '1';
    $namespace = 'cdma-crm-api/v' . $version;
    $base = 'applications';

    register_rest_route( $namespace, '/' . $base, array(
      array(
        'methods'             => WP_REST_Server::READABLE,
        'callback'            => array( $this, 'get_applications' ),
        'permission_callback' => array( $this, 'get_applications_permissions_check' ),
        'args'                => array(),
      ),
    ));
  }

  /**
   * Get the applications to the different formations
   * 
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|WP_REST_Response
   **/
  public function get_applications( $request ) {

    $items = array(); //do a query, call another class, etc
    $data = array();

    foreach( $items as $item ) {
      $itemdata = $this->prepare_item_for_response( $item, $request );
      $data[] = $this->prepare_response_for_collection( $itemdata );
    }
    
    return new WP_REST_Response( 'Hello World!', 200 );
    return new WP_REST_Response( $data, 200 );
  }

  /**
   * Check if a given request has the right permissions
   * 
   * @param WP_REST_Request $request Full data about the request.
   * @return WP_Error|bool
   **/
  public function get_applications_permissions_check( $request ) {
    return current_user_can( 'read_crm_api' );
  }
}

add_action( 'rest_api_init', function () {
  $CRM_API = new CRM_API();
  $CRM_API->register_routes();
});
