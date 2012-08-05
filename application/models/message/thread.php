<?php
class Message_Thread extends Eloquent {

	/* Relationships */
	public function starter() {
		return $this->belongs_to("User");
	}
	public function users() {
		return $this->has_many_and_belongs_to("User", "message_users");
	}
	public function messages() {
		return $this->has_many("Message_Message");
	}
}