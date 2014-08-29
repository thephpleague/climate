<?php

namespace JoeTannenbaum\CLImate\TerminalObject;

abstract class BaseTerminalObject implements TerminalObject {

	protected $settings = [];

	public function __construct()
	{

    }

    public function settings()
    {
    	return [];
    }

    public function importSetting( $setting )
    {
		$short_name = basename( str_replace( '\\', '/', get_class( $setting ) ) );

		$method = 'importSetting' . $short_name;

		if ( method_exists( $this, $method ) )
		{
			$this->$method( $setting );
		}

    }

}