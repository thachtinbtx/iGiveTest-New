<?php
define('SMARTY_DIR', 'C:/xampp/htdocs/inc/smarty/');
require_once(SMARTY_DIR . 'Smarty.class.php');
require_once(SMARTY_DIR . 'Smarty_Compiler.class.php');

$compiler = new Smarty_Compiler();
$compiler->left_delimiter = '<{';
$compiler->right_delimiter = '}>';

echo "Testing tag 'php'...\n";
$tag = 'php';
// We need to access _compile_tag which is a method.
// Since it's not private (in PHP 4/5 sense, though marked private in doc), we can call it.
// But we need to set up some state first?
// _compile_tag uses _tag_stack, etc.

// Let's try to simulate what _compile_file does.
// But simpler: just call _compile_tag.

// We need to suppress syntax errors or catch them.
// Smarty_Compiler uses trigger_error.

function test_compile($compiler, $tag) {
    echo "Compiling tag: '$tag'\n";
    
    // Reconstruct the regex from _compile_tag
    $regex = '~^(?:(' . $compiler->_num_const_regexp . '|' . $compiler->_obj_call_regexp . '|' . $compiler->_var_regexp
                . '|\/?' . $compiler->_reg_obj_regexp . '|\/?' . $compiler->_func_regexp . ')(' . $compiler->_mod_regexp . '*))
                      (?:\s+(.*))?$
                    ~xs';
    echo "Regex: " . $regex . "\n";
    
    $result = $compiler->_compile_tag($tag);
    echo "Result: " . htmlspecialchars($result) . "\n";
}

test_compile($compiler, 'php');
test_compile($compiler, 'if $foo');
test_compile($compiler, '/if');

?>
