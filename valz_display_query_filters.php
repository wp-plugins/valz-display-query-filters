<?php
/*
Plugin Name: Valz Display Query Filters
Plugin URI: http://tomauger.com/valz_display_query_filters/
Description: This really simple plugin demonstrates the primary filters that are used by WordPress as it parses your queries. Note, this ain't pretty, and activating this plugin will output a LOT of extra stuff, quite possibly MANY times depending on how many widgets and whatnot you have installed. This is a learning tool and definitely NOT for production. Developed for my WordCamp Montreal 2012 talk.
Version: 0.1
Author: Tom Auger
Author URI: http://tomauger.com
License: GPL2
*/

/*  Copyright 2012  Tom Auger  (email : tomaugerdotcom@yahoo.ca)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/


class Valz_Query_Filters {
	function __construct(){
		add_filter( 'request', array( $this, 'request_filter' ) );
		add_action( 'parse_request', array( $this, 'parse_request_action' ) );
		add_filter( 'query_string', array( $this, 'query_string_filter' ) );
		add_action( 'parse_query', array( $this, 'parse_query_action' ) );
		add_filter( 'pre_get_posts', array( $this, 'pre_get_posts_action' ) );
		add_filter( 'posts_search', array( $this, 'posts_search_filter' ), 10, 2 );
		add_filter( 'posts_where', array( $this, 'posts_where_filter' ), 10, 2 );
		add_filter( 'posts_join', array( $this, 'posts_join_filter' ), 10, 2 );
		add_filter( 'posts_clauses', array( $this, 'posts_clauses_filter' ), 10, 2 );
		add_filter( 'posts_request', array( $this, 'posts_request_filter' ), 10, 2 );
		add_filter( 'posts_results', array( $this, 'posts_results_filter' ), 10, 2 );
	}


	/**
	 * Defined at the end of {@link WP->parse_request()}
	 * @used_by apply_filters( 'request' )
	 * Use this filter to modify the list of query vars that will be used to drive the main query
	 *
	 * @param array $query_vars The query_vars generated by parse_request()
	 * @return array $query_vars
	 */
	function request_filter( $query_vars ){
		echo '<h1>request</h1>';
		print_r( $query_vars );

		return $query_vars;
	}

	/**
	 * Defined at the end of {@link WP->parse_request()}, immediately following the 'request' filter
	 * @used_by do_action( 'parse_request' );
	 *
	 * @param /WP $wp The WP instance for this session
	 */
	function parse_request_action( $wp ){
		echo '<h1>parse_request</h1>';
		print_r( $wp );
	}

	/**
	 * Defined at the end of {@link WP->build_query_string()}
	 * @used_by apply_filters( 'query_string' );
	 * Use this to manipulate the query string of the main query that will be sent to WP_Query
	 *
	 * @param string $query_string The rebuilt query string (after rewrite rule expansion)
	 * @return string
	 */
	function query_string_filter( $query_string ){
		echo '<h1>query_string</h1>';
		echo '<p>', $query_string, '</p>';

		return $query_string;
	}

	/**
	 * Defined at the end of {@link WP_Query->parse_query()}
	 * @used_by apply_filters( 'parse_query' )
	 * Use this filter to manipulate the WP_Query object for all queries
	 *
	 * @param /WP_Query $wp_query_object
	 * @return /WP_Query
	 */
	function parse_query_action( $wp_query_object ){
		echo '<h1>parse_query</h1>';
		print_r( $wp_query_object );
	}

	/**
	 * Defined near the beginning of {@link WP_Query->get_posts()}
	 * @used_by do_action_ref_array( 'pre_get_posts' )
	 * Functionally the same as the 'parse_query' filter, tends to be the preferred method of manipulating the WP_Query object for all queries
	 * @param /WP_Query $wp_query_object
	 * @return /WP_Query
	 */
	function pre_get_posts_action( $wp_query_object ){
		echo '<h1>pre_get_posts</h1>';
		print_r( $wp_query_object );
	}

	/**
	 * Defined within {@link WP_Query->get_posts()}
	 * @used_by apply_filters_ref_array( 'posts_search' )
	 * Used by plugins and themes to alter the search query, and expand the fields that are searched by the generic ?s= query var
	 *
	 * @param string $search The search SQL string - eventually to be part of the where_clause
	 * @param /WP_Query $query_obj
	 * @return string
	 */
	function posts_search_filter( $search, $query_obj ){
		echo '<h1>posts_search</h1>';
		echo '<p><strong>$search: </strong>', $search, '</p>';

		return $search;
	}

	/**
	 * Defined within {@link WP_Query->get_posts()}
	 * @used_by apply_filters_ref_array( 'posts_where' );
	 * Manipulate the WHERE clause of the generated SQL prior to any paging being applied
	 *
	 * @param string $where_clause
	 * @param /WP_Query $query_obj
	 * @return string
	 */
	function posts_where_filter( $where_clause, $query_obj ){
		echo '<h1>posts_where</h1>';
		echo '<p><strong>Where Clause: </strong>', $where_clause, '</p>';

		return $where_clause;
	}

	/**
	 * Defined within {@link WP_Query->get_posts()}
	 * @used_by apply_filters_ref_array( 'posts_join' )
	 * Manipulate the JOIN clause of the generated SQL prior to any paging being applied
	 *
	 * @param string $join_clause
	 * @param /WP_Query $query_obj
	 * @return string
	 */
	function posts_join_filter( $join_clause, $query_obj ){
		echo '<h1>posts_join</h1>';
		echo '<p><strong>Join Clause: </strong>', $join_clause, '</p>';

		return $join_clause;
	}

	/**
	 * Defined within {@link WP_Query->get_posts()}
	 * @used_by apply_filters_ref_array( 'posts_clauses' )
	 * This omnibus filter allows you to manipulate each of the SQL clauses separately, post-paging. They are grouped together inside the $clauses array.
	 *
	 * @param array $clauses An array containing one key for each of the SQL clauses: 'where', 'groupby', 'join', 'orderby', 'distinct', 'fields', 'limits'
	 * @param /WP_Query $query_obj
	 * @return array
	 */
	function posts_clauses_filter( $clauses, $query_obj ){
		echo '<h1>posts_clauses</h1>';
		foreach( array_keys( $clauses ) as $clause_key ){
			echo '<p><strong>', $clause_key, ':</strong> ', $clauses[$clause_key], '</p>';
		}

		return $clauses;
	}

	/**
	 * Defined within {@link WP_Query->get_posts()}
	 * @used_by apply_filters_ref_array( 'posts_request' )
	 * This filters the assembled SQL query string that will be sent to the database.
	 * <p>Arguably, this filter is more useful in debugging than in manipulating the SQL query string, which is easier done through the individual clauses. However, if you are manipulating the SQL with the clauses, this is an excellent filter to use to simply echo out the resulting SQL, which can be copied and pasted into a mySQL client for advanced debugging.</p>
	 *
	 * @param string $request The assembled SQL query string
	 * @param /WP_Query $query_obj
	 * @return string
	 */
	function posts_request_filter( $request, $query_obj ){
		echo '<h1>posts_request</h1>';
		echo '<p><strong>SQL: </strong>', $request, '</p>';
		print_r( $query_obj );

		return $request;
	}

	/**
	 * Defined near the end of {@link WP_Query->get_posts()}
	 * @used_by apply_filters_ref_array( 'posts_results' )
	 * This gives you the entire results array from the $wpdb->get_results() call, prior to any filtering out based on post_status and capabilities checks.
	 *
	 * @param array $results Array of $post objects returned by the query
	 * @param /WP_Query $query_obj
	 * @return array
	 */
	function posts_results_filter( $results, $query_obj ){
		echo '<h1>posts_results</h1>';
		print_r( $results );

		return $results;
	}
}
new Valz_Query_Filters();