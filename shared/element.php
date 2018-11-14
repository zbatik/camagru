<?php
	class Element
	{
        protected $_tag;
        protected $_attributes = array();
        protected $_content;
        protected $_children = array();
        protected $_has_children = 1;
        protected $_level = 0;

        public function __construct($tag, $content = null, $class = null, $id = null)
        {
            $this->_tag = $tag;
            $this->_content = $content;
            if ($class !== null)
                $this->add_attribute("class", $class);
            if ($id !== null)
                $this->add_attribute("id", $id);
        }

        public function add_attribute($atribute, $value)
        {
            $this->_attributes[$atribute] = $value;
        }

        public function add_child(Element $elem_obj)
        {
            $this->_has_children = 1;
            $elem_obj->_level += 1;
            array_push($this->_children, $elem_obj);
        }

        public function print_html()
        {
            echo str_repeat("\t", $this->_level);
            echo "<$this->_tag";
            foreach ($this->_attributes as $atribute=>$value)
            {
                echo " $atribute='$value'";
            }
            echo ">\n";
            echo str_repeat("\t", $this->_level + 1);
            echo $this->_content;
            if ($this->_has_children)
            {
                echo "\n";
                foreach ($this->_children as $elem_obj)
                {
                    $elem_obj->print_html();
                }
            }
            echo str_repeat("\t", $this->_level);
            echo "</$this->_tag>\n";
        }
    }
?>