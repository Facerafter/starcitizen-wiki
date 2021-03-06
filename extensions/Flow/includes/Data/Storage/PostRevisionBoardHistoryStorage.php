<?php

namespace Flow\Data\Storage;

use Flow\Exception\DataModelException;
use Flow\Model\UUID;

class PostRevisionBoardHistoryStorage extends BoardHistoryStorage {
	/**
	 * @param array $attributes
	 * @param array $options
	 * @return array
	 * @throws DataModelException
	 */
	public function find( array $attributes, array $options = array() ) {
		$attributes = $this->preprocessSqlArray( $attributes );

		$dbr = $this->dbFactory->getDB( DB_SLAVE );
		$res = $dbr->select(
			array( 'flow_topic_list', 'flow_tree_node', 'flow_tree_revision', 'flow_revision' ),
			array( '*' ),
			array_merge( array(
				'rev_type' => 'post',
				'topic_id = tree_ancestor_id',
				'tree_descendant_id = tree_rev_descendant_id',
				'tree_rev_id = rev_id',
			), $attributes ),
			__METHOD__,
			$options
		);

		if ( $res === false ) {
			throw new DataModelException( __METHOD__ . ': Query failed: ' . $dbr->lastError(), 'process-data' );
		}

		$retval = array();
		foreach ( $res as $row ) {
			$row = UUID::convertUUIDs( (array) $row, 'alphadecimal' );
			$retval[$row['rev_id']] = $row;
		}

		return $retval;
	}
}
