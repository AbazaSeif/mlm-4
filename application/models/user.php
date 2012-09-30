<?php
class User extends Eloquent {
	public static $timestamps = true;
	
	public function openid() {
		return $this->has_many("openid");
	}
	public function profile() {
		return $this->has_one("profile");
	}
	public function maps() {
		return $this->has_many_and_belongs_to("Map");
	}
	public function messages() {
		return $this->has_many_and_belongs_to("Message_Thread", "message_users");
	}
	public function comments() {
		return $this->has_many("Comment");
	}
	public function matches() {
		return $this->has_many_and_belongs_to("Match")->with('teamnumber');
	}

	// Send a *system message* to the user
	public function send_message($title, $text) {
		/* Insert the thread */
		$messageThread = Message_Thread::create(array("title" => $title));
		/* Attach user */
		$messageThread->users()->attach($this->id, array("unread" => 1));
		/* Attach message */
		$message = new Message_Message();
		$message->message = $text;
		$messageThread->messages()->insert($message);
	}

	public function update_comment_count($deletion = false) {
		if ($deletion == false) {
			$this->set_attribute("comment_count", $this->comments()->count()+1);
			self::$timestamps = false; // Don't update modified time;
			$this->save();
			self::$timestamps = false;
		}
		else {
			$this->set_attribute("comment_count", $this->comments()->count()-1);
			self::$timestamps = false; // Don't update modified time;
			$this->save();
			self::$timestamps = false;
		}
	}

	public function update_winlose_count() {
		$this->set_attribute("win_count", $this->matches()->where('matches.winningteam', '=', 'match_user.teamnumber')->count()+1);
		$this->set_attribute("win_count", $this->matches()->where('matches.winningteam', '!=', 'match_user.teamnumber')->count()+1);
		self::$timestamps = false; // Don't update modified time;
		$this->save();
		self::$timestamps = false;
	}
}