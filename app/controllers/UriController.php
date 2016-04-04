<?php

class UriController extends BaseController {

	public function webHook()
	{
		$json = file_get_contents('php://input');
		$json = substr($json, 7);
		$json = substr($json, 0, -1);
		$action = json_decode($json);
		echo "d";

		die();
		switch ($action->type)
		{
			case 'charge.succeeded':
				
				break;
			
			default:
				# code...
				break;
		}
	}
}