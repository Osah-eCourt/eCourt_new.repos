<?php

require_once '../../../classes/MultiMerge.inc';

$merge = new MultiMerge();
$merge->mergeDocx('Text.docx', array('second.docx', 'SimpleExample.docx'), 'example_merge_docx.docx', array());