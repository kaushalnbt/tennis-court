<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Proposal;
use Exception;
use Illuminate\Http\Request;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class SendProposalPdf extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($proposalData)
    {
        //
        $this->proposalData = $proposalData;
        $this->pdf = $pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('emails.send-proposal-pdf')
                    ->subject('Your Proposal PDF')
                    ->attachData($this->pdf, 'proposal.pdf',['mime' => 'application/pdf' ,]);
    }
    
    // private function exportProposal($proposalId)
    // {
    //     $proposal = Proposal::find($proposalId);
    
    // if (!$proposal) {
    //     return back()->with('error', 'Proposal not found');
    // }
    
    // // Generate a logical name for the PDF
    // $pdfName = 'proposal_' . Str::slug($proposal->customer_name) . '.pdf';
    
    // // Generate the PDF using the view and proposal data
    // $data = Proposal::where('_id' , $proposalId)->first()->toArray();
    // $pdf = PDF::loadView('proposal.pdf', compact('data'));
    
    // // Optional: Add headers for PDF download
    // $headers = ['Content-Type: application/pdf'];
    
    // // Optional: Download the PDF directly
    // return $pdf->download($pdfName, $headers);
    // }
}
