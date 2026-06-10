<?php

namespace App\Mail;

use App\Models\AstrologyReport;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AstrologyReportMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @var \App\Models\User
     */
    public $member;

    /**
     * @var \App\Models\AstrologyReport
     */
    public $report;

    /**
     * @var string
     */
    protected $attachmentPath;

    /**
     * @var string
     */
    protected $attachmentName;

    /**
     * Create a new message instance.
     */
    public function __construct(User $member, AstrologyReport $report, string $attachmentPath, string $attachmentName)
    {
        $this->member = $member;
        $this->report = $report;
        $this->attachmentPath = $attachmentPath;
        $this->attachmentName = $attachmentName;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $fromAddress = config('mail.from.address') ?: env('MAIL_FROM_ADDRESS', env('MAIL_USERNAME'));
        $fromName = config('mail.from.name') ?: config('app.name', 'Life Matchings');

        $subjectLine = __('Life Matchings Astrology Report for :name', ['name' => $this->member->first_name ?? $this->member->name ?? __('Member')]);

        $email = $this->from($fromAddress, $fromName)
            ->subject($subjectLine)
            ->view('emails.astrology_report')
            ->text('emails.astrology_report_plain')
            ->with([
                'member' => $this->member,
                'report' => $this->report,
            ]);

        if (is_readable($this->attachmentPath)) {
            $email->attach($this->attachmentPath, [
                'as' => $this->attachmentName,
                'mime' => 'application/pdf',
            ]);
        }

        return $email;
    }
}


