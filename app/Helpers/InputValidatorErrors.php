<?php
namespace App\Helpers;

class InputValidatorErrors
{

    public function __construct(protected Session $session)
    {
        
    }

    public function has(string $name = '')
    {
        return isset($this->session->get('errors')[$name]);
    }

    public function first(string $name = '')
    {
        
        if($this->session->has('errors'))
        {
            $message = $this->session->get('errors')[$name][0];

            unset($_SESSION['errors'][$name]);

            return $message;
        }
 
    }

    public function all()
    {
        if($this->session->has('errors'))
	{
	
	  $messages = $this->session->all()['errors'];

	  $this->session->delete('errors');
	 
	  return $messages;
}

    }

    public function notEmpty()
    {
        return !empty($this->session->all()['errors']);
    }

    public function destroy()
    {
        $this->session->delete('errors');
    }
}
