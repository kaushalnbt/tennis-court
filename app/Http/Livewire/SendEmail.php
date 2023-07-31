<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Proposal;
use Exception;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class SendEmail extends Component
{

  public $id = "_id";

  public function sendPdfEmail($proposalId)
  {
      $proposalData = Proposal::where('_id', $proposalId)->first()->toArray();
      $pdf = $this->exportProposal($proposalId);
      $recepient = $proposalData['send_proposal_to'];
      
      Mail::send('emails.pdf', $recepient, function ($message, $recepient) use ($pdf) {
          $message->to($recepient, 'Recepient Name')
              ->subject('Your Proposal PDF')
              ->attachData($pdf, 'proposal.pdf');
      });

      return response()->json(['message' => 'Email sent successfully']);
  }

  public function exportProposal($proposalId)
    {
        $proposal = Proposal::find($proposalId);
    
    if (!$proposal) {
        return back()->with('error', 'Proposal not found');
    }
    
    // Generate a logical name for the PDF
    $pdfName = 'proposal_' . Str::slug($proposal->customer_name) . '.pdf';
    
    // Generate the PDF using the view and proposal data
    $data = Proposal::where('_id' , $proposalId)->first()->toArray();
    $pdf = PDF::loadView('proposal.pdf', compact('data'));
    
    // Optional: Add headers for PDF download
    $headers = ['Content-Type: application/pdf'];
    
    // Optional: Download the PDF directly
    return $pdf->download($pdfName, $headers);
    }

    // public function sendEmail()  {
    //     document.getElementById("send-pdf-button").addEventListener("click", function () {
  
    //         const proposalData = {
    //           $send_proposal_to
    //         };
          
    //         fetch("/send-pdf-email", {
    //           method: "POST",
    //           headers: {
    //             "Content-Type": "application/json",
    //           },
    //           body: JSON.stringify({
    //             proposalData: $send_proposal_to,
    //           }),
    //         })
    //           .then((response) => response.json())
    //           .then((data) => {
    //             console.log(data);
    //           })
    //           .catch((error) => {
    //             console.error(error);
    //           });
    //       });
    // }
    // public function render()
    // {
    //     return view('livewire.send-email');
    // }
}
