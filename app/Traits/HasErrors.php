<?php namespace App\Traits;




trait HasErrors
{
    use ApiResponseInfo;


    protected $errors = [];


    public function hasErrors()
    {
        return !empty($this->errors);
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function addError(string $error, $contents = null)
    {
        if (is_null($contents)) {
            $this->errors[] = $error;
        } else {
            $this->errors[$error] = $contents;
        }

        return $this->error('Error',200,[
            $this->errors
        ]);
    }

    public function addErrors(array $errors)
    {
        foreach ($errors as $error => $contents) {
            if (is_int($error)) {
                $this->errors[] = $contents;
            } else {
                $this->errors[$error] = $contents;
            }
        }
        return $this->error('Error',200,[
            $this->errors
        ]);


    }
}
