<?php
namespace App\Support\Storage\Basket;

use App\Helpers\Session;
use App\Support\Storage\StorageInterface;

class Basket implements StorageInterface
{
    private $total = 0;

    public function __construct(private $cart = 'cart', private Session $session)
    {
        if(!$session->has($cart))
        {
            $session->put($cart, []);
        }
    }

    public function set($id, $value)
    {
       $_SESSION[$this->cart][$id] = $value;
    }

    public function update($id, int $quantity , string $ref = 'quantity')
    {

        $cart = $this->get($id);
        
        if(isset($cart[$ref]))
        {
            if( $cart[$ref] <= 0)
            {
                $this->delete($id);
            }
            
            $cart[$ref] += $quantity;

            $this->set($id, $cart);
        }
    }

    public function get($id)
    {
       if(!$this->exist($id))
       {
            return null;
       }

       return $_SESSION[$this->cart][$id];
    }

    public function all()
    {
        return $this->session->all()[$this->cart];
    }

    public function exist($id)
    {
        return isset($_SESSION[$this->cart][$id]);
    }

    public function total(string $ref = 'price', string $refQuantity = 'quantity')
    {
        if($this->session->has($this->cart))
        {
            foreach($this->all() as $id => $cart)
            {
                $this->total += ($this->get($id)[$ref] * $this->get($id)[$refQuantity]);
            }
        }

        return $this->total;
    }

    public function delete($id)
    {
        if($this->exist($id))
        {
            unset($_SESSION[$this->cart][$id]);
        }
    }

    public function clear()
    {
        unset($_SESSION[$this->cart]);
    }

    public function count()
    {
        return count($this->all());
    }
}