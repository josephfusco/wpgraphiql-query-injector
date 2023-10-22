# WPGraphiQL Query Injector

## Overview

WPGraphiQL Query Injector is a WordPress plugin designed to inject custom GraphQL queries and variables into your WPGraphiQL editor. The plugin aims to provide a straightforward way to populate the WPGraphiQL editor within a [WordPress Playground](https://developer.wordpress.org/playground/) environment.

## Usage

Once the plugin is activated, it will automatically populate the WPGraphiQL editor with predefined queries and variables. You can modify these by applying WordPress filters.

### Filters

#### `wpgraphiql_query`

Filter the GraphiQL Query input.

```php
add_filter( 'wpgraphiql_query', function() {
    return <<<GRAPHQL
      query GeneralSettings {
        allSettings {
          siteTitle: generalSettingsTitle
          sideDescription: generalSettingsDescription
        }
      }
      GRAPHQL
});
```

#### `wpgraphiql_variables`

Filter the GraphiQL Variables input.

```php
add_filter( 'wpgraphiql_variables', function() {
    return <<<JSON
      {
        "id": 716
      }
      JSON;
});
```

#### `wpgraphiql_use_public_fetcher`

Filter auth vs public requests.

```php
add_filter( 'wpgraphiql_use_public_fetcher', function() {
  return 'true';
});
