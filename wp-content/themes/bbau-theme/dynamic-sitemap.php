<?php
namespace BBAU_Theme {
/**
 * Dynamic URLs  by the Django API
 *
 * @package BBAU_Theme
 */

defined( 'ABSPATH' ) || exit;

if ( ! interface_exists( '\\RankMath\\Sitemap\\Providers\\Provider' ) ) {
	return;
}

use RankMath\Sitemap\Providers\Provider;
use RankMath\Sitemap\Router;

class Dynamic_Sitemap_Provider implements Provider {
	/**
	 * Whether this provider owns the requested sitemap type.
	 *
	 * @param string $type Sitemap type.
	 * @return bool
	 */
	public function handles_type( $type ) {
		return 'dynamic' === $type;
	}

	/**
	 * Add the dynamic sitemap to Rank Math's sitemap index.
	 *
	 * @param int $max_entries Maximum entries per sitemap.
	 * @return array
	 */
	public function get_index_links( $max_entries ) {
		$total_links = count( self::get_api_items( 'departments' ) )
			+ count( self::get_api_items( 'schools' ) )
			+ count( self::get_api_items( 'faculty' ) )
			+ 2;
		$page_count  = max( 1, (int) ceil( $total_links / max( 1, absint( $max_entries ) ) ) );
		$index_links = array();

		for ( $page = 1; $page <= $page_count; $page++ ) {
			$filename = 1 === $page ? 'dynamic-sitemap.xml' : 'dynamic-sitemap' . $page . '.xml';
			$index_links[] = array(
				'loc'     => Router::get_base_url( $filename ),
				'lastmod' => '',
			);
		}

		return $index_links;
	}

	/**
	 * Return URLs for departments, schools, faculty profiles, and centres.
	 *
	 * @param string $type         Sitemap type.
	 * @param int    $max_entries  Maximum entries per sitemap.
	 * @param int    $current_page Current sitemap page.
	 * @return array
	 */
	public function get_sitemap_links( $type, $max_entries, $current_page ) {
		$links = array();

		foreach ( self::get_api_items( 'departments' ) as $department ) {
			if ( ! empty( $department['slug'] ) ) {
				$links[] = self::make_link( '/departments/' . $department['slug'] . '/', $department );
			}
		}

		foreach ( self::get_api_items( 'schools' ) as $school ) {
			if ( ! empty( $school['slug'] ) ) {
				$links[] = self::make_link( '/schools/' . $school['slug'] . '/', $school );
			}
		}

		foreach ( self::get_api_items( 'faculty' ) as $faculty ) {
			if ( ! empty( $faculty['slug'] ) ) {
				$links[] = self::make_link( '/faculty/' . $faculty['slug'] . '/', $faculty );
			}
		}

		foreach ( array( 'centre-of-post-graduate-legal-studies', 'centre-for-the-study-of-social-inclusion-cssi' ) as $centre_slug ) {
			$links[] = self::make_link( '/centres/' . $centre_slug . '/', array() );
		}

		$links = array_values( array_unique( $links, SORT_REGULAR ) );
		$offset = max( 0, ( absint( $current_page ) - 1 ) * absint( $max_entries ) );

		return array_slice( $links, $offset, absint( $max_entries ) );
	}

	/**
	 * 
	 *
	 * @param string $resource API resource name.
	 * @return array
	 */
	private static function get_api_items( $resource ) {
		$cache_key = 'bbau_sitemap_' . $resource;
		$cached    = get_transient( $cache_key );

		if ( false !== $cached && is_array( $cached ) ) {
			return $cached;
		}

		$api_base = getenv( 'DJANGO_API_URL' );
		if ( empty( $api_base ) ) {
			return array();
		}

		$response = wp_remote_get(
			trailingslashit( $api_base ) . 'api/v1/' . $resource . '/?page_size=500',
			array( 'timeout' => 10 )
		);

		if ( is_wp_error( $response ) || 200 !== wp_remote_retrieve_response_code( $response ) ) {
			return array();
		}

		$data  = json_decode( wp_remote_retrieve_body( $response ), true );
		$items = isset( $data['results'] ) && is_array( $data['results'] ) ? $data['results'] : $data;

		if ( ! is_array( $items ) ) {
			return array();
		}

		set_transient( $cache_key, $items, 6 * HOUR_IN_SECONDS );

		return $items;
	}

	/**
	 * Build one Rank Math sitemap URL entry.
	 *
	 * @param string $path Relative public URL.
	 * @param array  $item API item.
	 * @return array
	 */
	private static function make_link( $path, $item ) {
		$link = array(
			'loc' => home_url( $path ),
		);

		foreach ( array( 'modified', 'modified_at', 'updated_at', 'last_modified' ) as $field ) {
			if ( ! empty( $item[ $field ] ) ) {
				$link['mod'] = mysql_to_rfc3339( $item[ $field ] );
				break;
			}
		}

		return $link;
	}
}

add_filter(
	'rank_math/sitemap/providers',
	function( $providers ) {
		$providers['dynamic'] = new Dynamic_Sitemap_Provider();
		return $providers;
	}
);

add_filter( 'rank_math/sitemap/enable_caching', '__return_false' );
}
