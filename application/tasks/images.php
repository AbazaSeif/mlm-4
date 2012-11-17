<?php
class Images_Task {
	// Iterates through images, updating each one to newest settings
	public function convert() {
		$tasklist = Image::all();

		foreach ($tasklist as $image) {
			print "Parsing image {$image->id}".PHP_EOL;

			print "Removing old files".PHP_EOL;
			File::delete(path("public")."images/uploads/l/{$image->file}.{$image->ext}");
			File::delete(path("public")."images/uploads/m/{$image->file}.{$image->ext}");
			File::delete(path("public")."images/uploads/s/{$image->file}.{$image->ext}");

			$original = new upload(path("public")."images/uploads/o/{$image->file}.{$image->ext}");

			print "Generating large".PHP_EOL;
			// Large (1280x?, cropped)
			$original->file_new_name_body = $image->file;
			$original->image_resize = true;
			$original->image_ratio_y = true;
			$original->image_x = 1280;
			$original->image_convert = 'jpg';
			$original->process(path("public")."images/uploads/l/");
			if(!$original->processed) {
				Log::warn($original->log);
				print "ERROR: Check log file for details".PHP_EOL;
			}

			print "Generating medium".PHP_EOL;
			// Medium (854x480, cropped)
			$original->file_new_name_body = $image->file;
			$original->image_resize = true;
			$original->image_ratio_crop = true;
			$original->image_x = 854;
			$original->image_y = 480;
			$original->image_convert = 'jpg';
			$original->process(path("public")."images/uploads/m/");
			if(!$original->processed) {
				Log::warn($original->log);
				print "ERROR: Check log file for details".PHP_EOL;
			}

			print "Generating small".PHP_EOL;
			// Small (424x240, upto)
			$original->file_new_name_body = $image->file;
			$original->image_resize = true;
			$original->image_ratio = true;
			$original->image_x = 426;
			$original->image_y = 240;
			$original->image_convert = 'jpg';
			$original->process(path("public")."images/uploads/s/");
			if(!$original->processed) {
				Log::warn($original->log);
				print "ERROR: Check log file for details".PHP_EOL;
			}

			print "Done parsing image {$image->id}!".PHP_EOL;
		}
	}
}