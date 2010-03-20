<?php

/*

	phpHTMLParser
	version 0.2
	
	Bart Spaans, Dec 2007
	http://www.onderstekop.nl/
	
	very suitable for parsing non-nested html tags such as <title>, <a>, <img>

	Example #1: 
	Echoes all Tag objects as string on <a> and <title> tags

	include("phpHTMLParser.php");
	$parser = new phpHTMLParser(file_get_contents("http://www.onderstekop.nl/");
	$HTMLObject = $parser->parse();
	$HTMLObject = $parser->parse_tags(array("a", "title"));
	$HTMLObject->output();
	
	
	Example #2:
	Echoes all <a> href attributes and their description
	
	include("phpHTMLParser.php");
	$content = file_get_contents("http://www.onderstekop.nl/");
	$parser = new phpHTMLParser("$content");
	$HTMLObject = $parser->parse_tags(array("a"));
	$aTags = $HTMLObject->getTagsByName("a");
	foreach ($aTags as $a) {
		if ($a->href != "") {
			echo $a->href . "<br/>";
			echo $a->innerHTML . "<br/><br/>";
		}
	}

*/

Class Tag {

	var $innerHTML = "";
	var $innerTag = "";
	var $ID = "";
	var $href = "";
	var $src = "";
	
	function addInnerHTML($word) {
		if ($this->innerHTML == "")
			$this->innerHTML = $word;
		else
			$this->innerHTML .= " $word";
	}
	function addInnerTag($word) {
		if ($this->innerTag == "")
			$this->innerTag = $word;
		else
			$this->innerTag .= " $word";
			
		if (preg_match("/href=[\"'](.*)[\"']/i", $word)) {
			$href = substr($word, 6, strlen($word)-7);
			$this->href =$href;
		}
		elseif (preg_match("/id=[\"'](.*)[\"']/i", $word)) {
			$id = substr($word, 4, strlen($word) -5);
			$this->id = $id;
		}
		elseif (preg_match("/src=[\"'](.*)[\"']/i", $word)) {
			$src = substr($word, 5, strlen($word) -6);
			$this->src= $src;
		}
	}
	function output($name) {
		echo "<b> attributes: </b> &lt;$name " . $this->innerTag . "&gt;<br/>";
		echo "<b> ID: </b> " .$this->id . "<br/>";
		echo "<b> href: </b> " . $this->href . "<br/>";
		echo "<b> src: </b>" . htmlentities($this->src) . "</br>";
		echo "<b>innerHTML: </b>" . htmlentities($this->innerHTML) . "<br/><br/>";
	}
}

Class Tag_Set {

	var $name = "";
	var $tags = array();
	
	function Tag_Set($name) {
		$this->name = $name;
	}
	function addTag() {
		$t= new Tag();
		array_push($this->tags, $t);
		return count($this->tags);
	}
	function addInnerTag($word) {
		$t = array_pop($this->tags);
		$t->addInnerTag($word);
		array_push($this->tags, $t);
	}
	function addInnerHTML($word) {
		$t = array_pop($this->tags);
		$t->addInnerHTML($word);
		array_push($this->tags, $t);
	}
	function output() {
		echo "<h3>" . $this->name . "</h3>";
		foreach($this->tags as $t)
			$t->output($this->name);
	}
}

Class Parsed_HTML {
	
	var $tag_sets = array();
	var $tagStack = array();
	var $debug =false;
	
	function openTag($tagName) {
		if (!$t = $this->getSetByName($tagName)) {
			$newTag = new Tag_Set($tagName);
			array_push($this->tag_sets, $newTag);
			$this->debug("Creating new tag list '$tagName'");
		}
		if ($t = $this->getSetByName($tagName)) {
			 $this->debug("Adding new tag to list $tagName (entry " . $t->addTag(). ")");
		}
		$this->currentTag = $tagName;
		array_push($this->tagStack, $t);
	}
	function closeTag($tagName) {
		$this->debug("Closing tag '$tagName'");
		array_pop($this->tagStack);
	}
	function getSetByName($name) {
		foreach($this->tag_sets as $t) {
			if ($t->name == $name)
				return $t;
		}
		return false;
	}
	function addInnerTag($word, $foundNewTag = True) {
		if ($foundNewTag) {
			$this->currentTag = $word;
		}
		if ($word != "" && count($this->tagStack) != 0) {
			$addTo = array_pop($this->tagStack);
			if ($this->currentTag == $addTo->name) {
				$this->debug("Adding inner tag " . htmlentities($word). "' to tag list '" . $addTo->name . "'");
				$addTo->addInnerTag($word);
				array_push($this->tagStack, $addTo);
			}
			else {
				foreach($this->tagStack as $t) {
					$this->debug("Adding innerHTML '" . htmlentities($word) . "' to tag list '" . $t->name . "'");
					$t->addInnerHTML ($word);
				}
				array_push($this->tagStack, $addTo);
			}
		}
	}
	function addInnerHTML($word) {
		if ($word != "" && count($this->tagStack) != 0) {
			$addTo = array_pop($this->tagStack);
			if ($this->currentTag == $addTo->name) {
				$this->debug("Adding innerHTML '" . htmlentities($word) . "' to tag list '" . $addTo->name . "'");
				$addTo->addInnerHTML($word);
				array_push($this->tagStack, $addTo);
			}
			else {
				foreach ($this->tagStack as $t) {
					$this->debug("Adding innerHTML '" . htmlentities($word) . "' to tag list '" . $t->name . "'");
					$addTo->addInnerHTML($word);
				}
				array_push($this->tagStack, $addTo);
			}
		}
	}
	function debug($msg) {
		if ($this->debug) {
			echo $msg . "<br/>";
		}
	}
	function output () {
		foreach($this->tag_sets as $t) {
			$t->output();
		}
	}
	function getTagsByName($name) {
		foreach($this->tag_sets as $t) {
			if ($t->name == $name) {
				return $t->tags;
			}
		}
	}
}

Class phpHTMLParser {

	var $html = "";
	var $tag_names = array("a", "div");
	
	function phpHTMLparser($html) {
		$this->html = $html;
	}
	function parse_tags($tags) {
		$this->tag_names = $tags;
		return $this->parse();
	}
	function parse() {
		
		$parsed = new Parsed_HTML();
		for ($a = 0; $a < strlen($this->html); $a++) {
			$prevToken = $token;
			$token = $this->html{$a};
			if (!in_array($token, array("\r", "\n", " ", "\t", "<", ">"))) 
				$word .= $token;
			else {
				if ($inTag && (in_array($word, $this->tag_names))) 
					$parsed->openTag($word);
				elseif ($inTag && in_array(substr($word, 1), $this->tag_names)) {
					$parsed->closeTag(substr($word,1));
				}
				elseif ($inTag) {
					$parsed->addInnerTag($word, $justInTag);
					$word = "";
				}
				elseif (!$inTag) 		
					$parsed->addInnerHTML($word);
				$justInTag = False;
				$word = "";
			}
			switch($token):
				case "<":
					$inTag = True;
					$justInTag = True;
					break;
				case ">":
					$inTag = False;
					$justInTag = False;
					break;
			endswitch;
		}
		return $parsed;
	}
}

?>