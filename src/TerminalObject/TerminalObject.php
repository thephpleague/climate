<?php

namespace JoeTannenbaum\CLImate\TerminalObject;

interface TerminalObject {

	public function result();

	public function settings();

	public function importSetting( $setting );

}