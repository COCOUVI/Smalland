<?php

namespace App\Mail;

use App\Models\Formation;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaiementConfirmeMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $formation;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, Formation $formation)
    {
        $this->user = $user;
        $this->formation = $formation;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Confirmation de votre inscription à la formation')
                    ->view('emails.paiement_confirme') // 👈 Vue Blade à créer
                    ->with([
                        'user' => $this->user,
                        'formation' => $this->formation,
                    ]);
    }
}
