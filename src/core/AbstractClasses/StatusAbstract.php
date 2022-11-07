<?php
namespace Core\AbstractClasses;

require_once __DIR__.'/../Enumerations/STATUS.php';
use Core\Enumerations\STATUS;

abstract class StatusAbstract
{
    protected STATUS $status  = STATUS::UNDEFINED;
    protected int    $code    = 0;
    protected string $message = ""; 
    protected string $details = "";
    
    
    
    public function getStatus(): STATUS
    {
        return $this->status;
    }
    public function getCode(): int
    {
        return $this->code;
    }
    public function getMessage(): string
    {
        return $this->message;
    }
    public function getDetails(): string
    {
        return $this->details;
    }
    
    public function success(): bool
    {
        return ($this->status===STATUS::SUCCESS);
    }
    public function error(): bool
    {
        return ($this->status===STATUS::ERROR);
    }
    
    public function setSuccess(int $code=0, $message=""): void
    {
        $this->status=STATUS::SUCCESS;
        $this->code = $code;
        if($message!==""){
            $this->message = $message;
            $this->details .= $message."\n";
        }
    }
    public function setError(int $code, string $message, string $details=""): void
    {
        $this->status=STATUS::ERROR;
        $this->code = $code;
        $this->message = $message;
        $this->details .= $message."\n".($details?"$details\n":"");
    }
    
}
