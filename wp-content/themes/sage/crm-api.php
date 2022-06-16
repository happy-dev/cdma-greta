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
    global $wpdb;

    // We first retrieve the ID of the application form
    $args = array(
      'post_type' => 'wpcf7_contact_form',
      'title' => 'Candidature',
    );
    $query = new WP_Query( $args );

    if ( $query->have_posts() ) {
      while ( $query->have_posts() ) {
        $query->the_post();
        $application_form_id = get_the_ID();
      }
    }

    wp_reset_postdata();

    $applications = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}db7_forms WHERE form_post_id={$application_form_id} AND form_date >= '2022-06-01 00:00:00' ORDER BY form_date DESC", OBJECT );
    $applications_data = array();

    foreach( $applications as $application ) {
      $applications_data[] = $this->prepare_application_for_response( $application, $request );
    }
    
    return new WP_REST_Response( $applications_data, 200 );
  }

  /**
   * Transform applications from DB to API format
   * 
   * @param Object $application Serialized object containing form's data
   * @param WP_REST_Request $request Full data about the request.
   * @return Array
   **/
  public function prepare_application_for_response( $application, $request ) {
    $application_data = unserialize( $application->form_value );

    if ($application_data) {
      unset( $application_data['cfdb7_status'] );
      unset( $application_data['privacy-agreement'] );
      unset( $application_data['cf7sr-recaptcha'] );

      $application_data['formation-title'] = $application_data['candidate-formation'];
      unset( $application_data['candidate-formation'] );

      $application_data['gender'] = $application_data['gender'][0];
      $application_data['candidate-diploma'] = $application_data['candidate-diploma'][0];
      $application_data['candidate-handicapped'] = $application_data['candidate-handicapped'][0];
      $application_data['candidate-jobsituation'] = $application_data['candidate-jobsituation'][0];
      $application_data['candidate-demarche'] = $application_data['candidate-demarche'][0];
      $application_data['info-greta'] = $application_data['info-greta'][0];
      $application_data['application-date'] = $application->form_date;
      $application_data['application-id'] = $application->form_id;
    }

    return $application_data;
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
