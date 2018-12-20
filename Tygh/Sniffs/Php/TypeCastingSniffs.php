<?php

namespace Tygh\Sniffs\Php;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class TypeCastingSniff implements Sniff
{
    public $typeCaster = [
        'strval'   => 'string',
        'intval'   => 'int',
        'floatval' => 'float',
    ];

    public function register()
    {
        return [T_STRING];
    }

    public function process(File $phpcsFile, $stackPtr)
    {
        $tokens = $phpcsFile->getTokens();

        if (isset($this->typeCasters[$tokens[$stackPtr]['content']])) {
            $caster = $tokens[$stackPtr]['content'];
            $error = 'Type casting to %s with %s()';
            $phpcsFile->addError(
                $error,
                $stackPtr,
                'Found',
                [$this->typeCasters[$caster], $caster]
            );
        }
    }
}
