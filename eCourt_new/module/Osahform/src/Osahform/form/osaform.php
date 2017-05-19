<?php

namespace osaform;
use Zend\Form\Form;


class osaform extends Zend_Form
{
	public function init()
	{
		// Dojo-enable the form:
		Zend_Dojo::enableForm($this);
		 
		// ... continue form definition from here
		 
		// Dojo-enable all sub forms:
		foreach ($this->getSubForms() as $subForm) {
			Zend_Dojo::enableForm($subForm);
		}
	}
}