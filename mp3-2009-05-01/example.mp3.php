<?php

// if you want to get more examples or the class with comments, please download this zip file:
// http://www.mfman.net/class.mp3.zip

require_once './class.mp3.php';
$mp3 = new mp3;

/*

	get the data of mp3 file:

		mp3::get_mp3($filepath, $analysis = false, $getframesindex = false)
		it will return an array or false

*/
$mp3->get_mp3('example.mp3', true, false);

/*

	set the tags of mp3 file

		set_mp3($file_input, $file_output, $id3v2 = array(), $id3v1 = array())
		it will return true or false

*/
$mp3->set_mp3('input1.mp3', 'output1.mp3', array(), array());

/*

	cut the mp3 file

		cut_mp3($file_input, $file_output, $startindex = 0, $endindex = -1, $indextype = 'frame', $cleantags = false)
		it will return true or false

*/
$mp3->cut_mp3('input1.mp3', 'output1.mp3', 0, 120, 'second', false);

?>