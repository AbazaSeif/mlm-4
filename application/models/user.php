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
		return $this->has_many_and_belongs_to("Match")->with('teamnumber', 'invited');
	}
	public function teams() {
		return $this->has_many_and_belongs_to("Team")->with('owner', 'invited');
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
	// Get unread messages count and store it in relations to abuse magical methods
	public function get_unread_messages() {
		return $this->relationships["unread_messages"] = $this->messages()->where_unread(1)->count();
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
		$this->set_attribute("lose_count", $this->matches()->where('matches.winningteam', '!=', 'match_user.teamnumber')->count()+1);
		self::$timestamps = false; // Don't update modified time;
		$this->save();
		self::$timestamps = false;
	}

	public function in_match($matchid) {
		$in_match = DB::table("match_user")->where_match_id($matchid)->where_user_id($this->get_key())->first();
		if($in_match) {
			return true;
		} else {
			return false;
		}
	}

	public function in_team($teamid) {
		$in_team = DB::table("team_user")->where_team_id($teamid)->where_user_id($this->get_key())->first();
		if($in_team) {
			return true;
		} else {
			return false;
		}
	}
}