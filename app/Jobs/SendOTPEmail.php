<?php

namespace App\Jobs;

use App\Mail\VerificationMail;
use Illuminate\Container\Attributes\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOTPEmail implements ShouldQueue
{
    use Queueable;
    
    protected $email;
    protected $otp;

    /**
     * Create a new job instance.
     */
    public function __construct($email, $otp)
    {
        //
        $this->email = $email;
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        //
        Mail::to($this->email)->send(new VerificationMail($this->otp));
    }
    public function failed(\Exception $exception)
    {
        \Log::error("Failed to send OTP email to {$this->email}: " . $exception->getMessage());
    }
}