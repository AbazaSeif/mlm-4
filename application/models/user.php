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
}