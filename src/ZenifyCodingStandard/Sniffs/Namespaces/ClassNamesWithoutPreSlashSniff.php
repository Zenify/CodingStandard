<?php

declare(strict_types = 1);

/*
 * This file is part of Zenify
 * Copyright (c) 2012 Tomas Votruba (http://tomasvotruba.cz)
 */

namespace ZenifyCodingStandard\Sniffs\Namespaces;

use PHP_CodeSniffer_File;
use PHP_CodeSniffer_Sniff;


/**
 * Rules:
 * - Class name after new/instanceof should not start with slash
 */
final class ClassNamesWithoutPreSlashSniff implements PHP_CodeSniffer_Sniff
{

	/**
	 * @var string
	 */
	const NAME = 'ZenifyCodingStandard.Namespaces.ClassNamesWithoutPreSlash';

	/**
	 * @var string[]
	 */
	private $excludedClassNames = [
		'DateTime', 'stdClass', 'splFileInfo', 'Exception'
	];


	/**
	 * @return int[]
	 */
	public function register() : array
	{
		return [T_NEW, T_INSTANCEOF];
	}


	/**
	 * @param PHP_CodeSniffer_File $file
	 * @param int $position
	 */
	public function process(PHP_CodeSniffer_File $file, $position)
	{
		$tokens = $file->getTokens();
		$classNameStart = $tokens[$position + 2]['content'];

		if ($classNameStart === '\\') {
			if ($this->isExcludedClassName($tokens[$position + 3]['content'])) {
				return;
			}
			$file->addError('Class name after new/instanceof should not start with slash.', $position);
		}
	}


	/**
	 * @param string $className
	 * @return bool
	 */
	private function isExcludedClassName($className)
	{
		if (in_array($className, $this->excludedClassNames)) {
			return TRUE;
		}
		return FALSE;
	}

}
