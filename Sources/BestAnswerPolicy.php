<?php

/**
 * @package BestAnswer
 * @author Sami "SychO" Mazouz
 * @license MIT
 */

class BestAnswerPolicy
{
	/**
	 * @var array
	 */
	protected $topicinfo;

	/**
	 * @param array $topicinfo
	 */
	public function __construct($topicinfo)
	{
		$this->topicinfo = $topicinfo;
	}

	/**
	 * @return bool
	 */
	public function canMarkBestAnswer()
	{
		global $user_info;

		if ($user_info['is_guest'])
			return false;

		if (! BestAnswerSettings::isEnabledForBoard($this->topicinfo['id_board']))
			return false;

		return
			(
				allowedTo('mark_best_answer_own') && $this->topicinfo['id_member_started'] == $user_info['id']
			)
			|| allowedTo('mark_best_answer_any');
	}

	/**
	 * @return void
	 */
	public function assertCanMarkBestAnswer()
	{
		if (! $this->canMarkBestAnswer())
			redirectexit();
	}
}
