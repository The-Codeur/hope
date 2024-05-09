<?php

namespace App\Helpers;

use App\Http\Request\Request;

class Validator
{
    protected bool $passed = false;

    protected array $errors;

    protected string $item;

    public function __construct(protected Request $request)
    {
    }

    public function check(array $items)
    {
        $request = $this->request;

        foreach ($items as $item => $rules) {
            $this->item = $item;

            if(array_key_exists($item, $request->getFiles()))
            {
    
                foreach(explode('|', $rules) as $rule)
                {
                   
                    if ($this->rulePart($rule) === 'required' && $request->fileIsEmpty($item) or empty($request->getFile($item)[0])) {
                        $this->setError("Le champs {$item} est requis");
                    } elseif ($request->hasFile($item)) {
                        switch (true) {
                            case $this->rulePart($rule, 0) === 'singleFile':
                    
                                $this->singleFile($item);
                            break;
                            case $this->rulePart($rule, 0) === 'multipleFile':
                               
                                $this->multipleFile($item);
                            break;
                            case $this->rulePart($rule, 0) === 'fileError':

                                $this->fileError($item);
                            break;
                            case $this->rulePart($rule, 0) === 'fileType':

                                $this->fileType($item, $rule);
                            break;
                            case $this->rulePart($rule, 0) === 'minFileSize':

                                $this->minFileSize($item, $rule);
                            break;
                            case $this->rulePart($rule, 0) === 'maxFileSize':

                                $this->maxFileSize($item, $rule);
                            break;
                            case $this->rulePart($rule, 0) === 'fileExtension':

                                $this->fileExtension($item, $rule);
                            break;
                        }
                    }
                }
            }

            if (array_key_exists($item, $request->getParams())) {
                foreach (explode('|', $rules) as $rule) {

                    if ($this->rulePart($rule) === 'required' && $request->paramIsEmpty($item)) {
                        $this->setError("Le champs {$item} est requis");
                    } elseif ($request->hasParam($item)) {

                        switch (true) {
                            case $this->rulePart($rule) === 'min':

                                $this->min($item, $rule);
                                break;

                            case $this->rulePart($rule) === 'max':

                                $this->max($item, $rule);
                                break;

                            case $this->rulePart($rule) === 'identical':

                                $this->identical($item, $rule);
                                break;

                            case $this->rulePart($rule) === 'email':

                                $this->email($item);
                                break;

                            case $this->rulePart($rule) === 'alpha':

                                $this->alpha($item);
                                break;

                            case $this->rulePart($rule) === 'alphaNum':

                                $this->alphaNum($item);
                                break;

                            case $this->rulePart($rule) === 'unique':

                                $this->unique($rule, $item);
                                break;

                            case $this->rulePart($rule) === 'numeric':

                                $this->numeric($item);
                                break;

                            case $this->rulePart($rule) === 'regex':

                                $this->regex($rule, $item);
                                break;

                            case $this->rulePart($rule) === 'password':

                                $this->password($rule, $item);
                                break;
                        }
                    }
                }
            }
        }

        if (empty($this->errors)) {
            unset($request->getParams()[config('guard.name')]);

            $this->passed = true;
        } else {

            $request->session('errors', $this->errors);
        }

        return $request->getParams();
    }

    public function passed()
    {
        return $this->passed;
    }

    public function failed()
    {
        return !$this->passed();
    }

    public function getErrors()
    {
        return $this->errors;
    }

    private function setError(string $message)
    {
        $this->errors[$this->item][] = $message;
    }

    private function rulePart(string $rule, int $part = 0)
    {
        $rule = trim(explode(':', $rule)[$part]);

        return $rule;
    }

    private function min(string $item, $rule)
    {
        if (mb_strlen($this->request->getParam($item)) < $this->rulePart($rule, 1)) {
            $this->setError("Le nombre des caractères minimum est de " . $this->rulePart($rule, 1));
        }
    }

    private function max(string $item, $rule)
    {
        if (mb_strlen($this->request->getParam($item)) > $this->rulePart($rule, 1)) {
            $this->setError("Le nombre des caractères maximum est de " . $this->rulePart($rule, 1));
        }
    }

    private function identical(string $item, $rule)
    {
        if ($this->request->getParam($item) != $this->request->getParam($this->rulePart($rule, 1))) {
            $this->setError("Le champs {$item} et {$this->rulePart($rule, 1)} doivent être identique");
        }
    }

    private function email(string $item)
    {
        if (!filter_var($this->request->getParam($item), FILTER_VALIDATE_EMAIL)) {
            $this->setError("Veuillez saisir une adresse email valide");
        }
    }

    private function alpha(string $item)
    {
        if (!preg_match('#^[a-zAZ]+$#', $this->request->getParam($item))) {
            $this->setError("Ce champs n'accepte que les lettres en miniscule ou majuscule");
        }
    }

    private function alphaNum(string $item)
    {
        if (!preg_match('#^[a-zAZ0-9]+$#', $this->request->getParam($item))) {
            $this->setError("Ce champs n'accepte que les lettres en miniscule, majuscule et des chiffres");
        }
    }

    private function numeric(string $item)
    {
        if (!is_numeric($this->request->getParam($item))) {
            $this->setError("Ce champs n'accepte que les valeurs numeriques");
        }
    }

    private function unique(string $rule, string $item)
    {
        if (\Illuminate\Database\Capsule\Manager::table($this->rulePart($rule, 1))->where($item, $this->request->getParam($item))->count()) {
            $this->setError("{$this->request->getParam($item)} existe déja dans la base de donnée");
        }
    }

    private function regex(string $rule, string $item)
    {
        if (!preg_match("#^" . $this->rulePart($rule, 1) . "$#i", $this->request->getParam($item))) {
            $this->setError('Le données saisies ne correspondent pas au données attendues');
        }
    }

    private function password(string $rule, string $item)
    {
        if (!preg_match("#^\S*(?=\S{" . $this->rulePart($rule, 1) . ",})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])\S*$#", $this->request->getParam($item))) {
            $this->setError($item . ' doit contenir au minimum ' . $this->rulePart($rule, 1) . ' caratères, au moins un caractère majuscule, miniscule et un chiffre');
        }
    }

    private function singleFile($item)
    {
        if ($this->request->fileIsArray($item)) {
            $this->setError("Vous ne pouvez charger qu'un seul fichier");
        }
    }

    private function multipleFile($item)
    {
        if (!$this->request->fileIsArray($item)) {
            $this->setError("Sélection multiple autorisée");
        }
    }

    private function fileError($item)
    {
        if ($this->request->fileIsArray($item)) {
            for ($i = 0; $i < count($this->request->getFileError($item)); $i++) {
                if ($this->request->getFileError($item)[$i] > 0) {
                    $this->setError("Des erreurs ont été détectées lors de chargement de(s) fichier(s)");
                }
            }
        }else{
            if ($this->request->getFileError($item) > 0) {
                $this->setError("Des erreurs ont été détectées lors de chargement de(s) fichier(s)");
            }
        }
        
    }

    private function fileType($item, $rule)
    {
        if($this->request->fileIsArray($item))
        {
            for($i = 0; $i < count($this->request->getFileType($item)); $i++)
            {
                if (in_array($this->request->getFileType($item)[$i], explode('-', $this->rulePart($rule, 1)))) {
                    $this->setError("Le type de fichier {$this->request->getFileType($item)[$i]} n'est pas autorisé");
                }
            }
        }else {
            if (!in_array($this->request->getFileType($item), explode('-', $this->rulePart($rule, 1)))) {
                $this->setError("Le type de fichier {$this->request->getFileType($item)} n'est pas autorisé");
            }
        }
       
    }

    private function minFileSize($item, $rule)
    {
        if ($this->request->fileIsArray($item)) {
            for ($i = 0; $i < count($this->request->getFileSize($item)); $i++) {
                if ($this->request->getFileSize($item)[$i] < $this->rulePart($rule, 1)) {
                    $this->setError("Le taille minimum de(s) fichier(s) doit être de {$this->rulePart($rule, 1)}");
                }
            }
        } else {
            if ($this->request->getFileSize($item) < $this->rulePart($rule, 1)) {
                $this->setError("Le taille minimum de(s) fichier(s) doit être de {$this->rulePart($rule, 1)}");
            }
        }
    }

    private function maxFileSize($item, $rule)
    {
        if ($this->request->fileIsArray($item)) {
            for ($i = 0; $i < count($this->request->getFileSize($item)); $i++) {
                if ($this->request->getFileSize($item)[$i] > $this->rulePart($rule, 1)) {
                
                    $this->setError("Le taille maximum de(s) fichier(s) doit être de {$this->rulePart($rule, 1)}");
                }
            }
        } else {
            if ($this->request->getFileSize($item) > $this->rulePart($rule, 1)) {
                $this->setError("Le taille maximum de(s) fichier(s) doit être de {$this->rulePart($rule, 1)}");
            }
        }
    }

    private function fileExtension($item, $rule)
    {
        if ($this->request->fileIsArray($item)) {

            for ($i = 0; $i < count($this->request->getFileName($item)); $i++) {
    
                if (!in_array(pathinfo($this->request->getFileName($item)[$i], PATHINFO_EXTENSION), explode('-', $this->rulePart($rule, 1)))) {
                    $this->setError("Le type de d'extension ".pathinfo($this->request->getFileName($item)[$i], PATHINFO_EXTENSION)." n'est pas autorisé");
                }
            }
        }else{
            if (!in_array(pathinfo($this->request->getFileName($item), PATHINFO_EXTENSION), explode('-', $this->rulePart($rule, 1)))) {
                $this->setError("Le type de d'extension " . pathinfo($this->request->getFileName($item), PATHINFO_EXTENSION) . " n'est pas autorisé");
            }
        }
    }
}
