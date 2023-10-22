<?php
/**
 * Plugin Name: WPGraphiQL Query Injector
 * Description: Inject a custom query and variables into the WPGraphiQL editor - intended to be used with WordPress Playground.
 * Version:     1.0.0
 * Author:      Joseph Fusco
 * Author URI:  https://github.com/josephfusco
 * Plugin URI:  https://github.com/josephfusco/wpgraphiql-query-injector
 */

namespace WPGraphiQLQueryInjector;

add_action( 'enqueue_graphiql_extension', __NAMESPACE__ . '\\inject_queries_and_variables' );
/**
 * Function to inject the GraphQL queries and variables into the admin footer.
 * 
 * @return void
 */
function inject_queries_and_variables(): void {
    $query = <<<GRAPHQL
      query InjectedQuery {
        allSettings {
          siteTitle: generalSettingsTitle
          sideDescription: generalSettingsDescription
        }
      }
      GRAPHQL;

    $variables = <<<JSON
      {
        "id": 716
      }
      JSON;

    $query              = apply_filters( 'wpgraphiql_query', $query );
    $variables          = apply_filters( 'wpgraphiql_variables', $variables );
    $use_public_fetcher = apply_filters( 'wpgraphiql_use_public_fetcher', 'false' );

    $json_query     = wp_json_encode( $query );
    $json_variables = wp_json_encode( $variables );

    $inline_script = <<<JS
      /**
       * WPGraphiQL Query Injector
       */
      (function() {
        localStorage.removeItem('graphiql:queries');
        localStorage.setItem('graphiql:query', $json_query);
        localStorage.setItem('graphiql:variables', $json_variables);
        localStorage.setItem('graphiql:usePublicFetcher', $use_public_fetcher);
      })();
      JS;

    wp_add_inline_script( 'wp-graphiql', $inline_script );
}
