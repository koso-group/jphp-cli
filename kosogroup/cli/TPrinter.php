<?php

namespace kosogroup\cli;


class TPrinter
{
    public $startFormatting = '[0m';
    private array $_dataSet = [];

    public static function startWith(TFormatting $formatting)
    {
        $self = new self($formatting->get());
        


        return $self;
    }

    function __construct($formatting = null)
    {
        if($formatting) $this->startFormatting = $formatting;

        $this->_dataSet[] = $this->startFormatting;
    }

    public function concat(string $string)
    {
        $this->_dataSet[] = $string;
        return $this;
    }

    public function concatWith(string $string, TFormatting $formatting)
    {
        $this->_dataSet[] = [ $formatting->get(), $string ];
        return $this;
    }

    public function clear()
    {
        $this->_dataSet = null;
        $this->_dataSet = [];

        return $this;
    }
    
    function parse($dataSet)
	{
		$formatting = array_shift($dataSet);
		$result[] = $formatting;
		foreach($dataSet as $item)
		{
			if(is_array($item))
			{
				$result[] = $this->parse($item);
				//resettting to MAIN formatting
				$result[] = $formatting; 
				continue;
			}
			
			$result[] = $item;
		}

		//clear formatting
		$result[] = TFormatting::create('_clear')->get();
		
		return implode('', $result);
	}

    function print()
    {
        return $this->parse($this->_dataSet);
    }

}