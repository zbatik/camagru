<?php
require_once("element.php");

# empty p tag
$p = new Element("p");
$p->print_html();

# class and id p tag
$p = new Element("p", "some text", "class_name", "id_tag");
$p->print_html();

# add some bold and italc text to above p tag
$b = new Element("b", " bold!");
$i = new Element("i", " italic");
$p->add_child($b);
$p->add_child($i);
$p->print_html();

?>