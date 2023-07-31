<?php

namespace App\Http\Controllers;

use App\Models\Proposal;
use Exception;
use Illuminate\Http\Request;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendProposalPdf;

class ProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('dashboard');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('proposal.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function show(Proposal $proposal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function edit(Proposal $proposal)
    {
        return view('proposal.edit',['proposal' => $proposal]);
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Proposal $proposal)
    {
        //
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Proposal  $proposal
     * @return \Illuminate\Http\Response
     */
    public function destroy($proposalId)
    {
        Proposal::find($proposalId)->delete();
        return redirect('dashboard');
    }
    
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
}
