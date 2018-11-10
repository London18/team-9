<?php
class Keyword
{
	var $keywordId;
	var $word;
	var $creationTime;

	function GetKeywordId()
	{
		return $this->keywordId;
	}
	function SetKeywordId($value)
	{
		$this->keywordId = $value;
	}
	
	function GetWord()
	{
		return $this->word;
	}
	function SetWord($value)
	{
		$this->word = $value;
	}
	
	function GetCreationTime()
	{
		return $this->creationTime;
	}
	function SetCreationTime($value)
	{
		$this->creationTime = $value;
	}
	

	function Keyword($Word)
	{
		$this->keywordId = 0;
	
		$this->word = $Word;
	}

}
?>
