
<?php
// starting word

$word = new COM("Word.Application") or die("Unable to instantiate Word");

echo "Loaded Word, version {$word->Version}\n";



//bring it to front

$word->Visible = 1;

echo "<pre>";
print_r($word);
echo "</pre>";
 
//open an empty document

$word->Documents->Add();

echo "<pre>";
print_r($word);
echo "</pre>";

//do some weird stuff

$word->Selection->TypeText("This is a test...");
echo "<pre>";
print_r($word);
echo "</pre>";

$word->Documents[1]->SaveAs("Uselesstest.docx");
echo "<pre>";
print_r($word);
echo "</pre>";


//closing word

$word->Quit();



//free the object

$word = null;