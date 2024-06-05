<?php
namespace FortAwesome;

class MatchResult {
	protected $match_count = 0;
	protected $matches     = array();

	public function __construct( $match_count, $matches ) {
		$this->match_count = $match_count;
		$this->matches     = $matches;
	}

	public function match_count() {
		return $this->match_count;
	}

	public function matches() {
		return $this->matches;
	}
}
