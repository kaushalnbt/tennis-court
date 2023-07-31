<?php

namespace App\Http\Livewire;

use App\Models\Proposal;
use Livewire\Component;
use App\Mail\SendProposalPdf;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Livewire\Sortable;
use Livewire\SortableTrait;

class EditProposal extends Component
{
    public Proposal $proposal;

    use WithFileUploads;

    public $title;
    
    public $sign;
    public $heading = "Agreement";
    public $overseas_conditions_heading = "Conditions For Overseas Installations";
    public $base_heading = "Base";
    public $court_preparation_heading = "Court Preparation";
    public $surfacing_heading = "Surfacing";
    public $fence_heading = "Fence";
    public $lights_heading = "Lights";
    public $court_accessories_heading = "Court Accessories";
    public $fee_heading = "Fee";
    public $provisions_heading = "Provisions";
    public $conditions_heading = "Conditions";
    public $guarantee_heading = "Guarantee";
    public $credit_heading = "Credit";
    public $signatureData;
    public $showSuccessMessage = false;
    public $signatureDataUrl = null;
    public $show_overseas_conditions = true;
    public $show_base = true;
    public $show_court_preparation = true;
    public $show_surfacing = true;
    public $show_fence = true;
    public $show_lights = true;
    public $show_court_accessories = true;
    public $show_fee = true;
    public $show_provisions = true;
    public $show_conditions = true;
    public $show_guarantee = true;
    public $show_credit = true;
    public $work_to_be_performed;
    public $customer;
    public $customer_name;
    public $construction_of;
    public $send_proposal_to;

    protected $listeners = ['saveSignature', 'updateProposalTitle'];

    public function showEditField($field)
    {
        $this->dispatchBrowserEvent('showEditField', ['field' => $field]);
    }

    public $overseas_conditions = [
        'round_trip_airfare' => [
            'title' => 'The Customer is responsible for round trip airfare to _________________',
            'input' => true,
            'input_value' => "",
            'selected' => false,
        ],
        'freight_duty' => [
            'title' => 'The Customer is responsible for freight, duty and tax on all materials from Miami, Florida to the job site, unloaded and secured at site.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'furnish_permits' => [
            'title' => 'The Customer will furnish any necessary permits, room & board, and vehicle transport.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'taxes_due' => [
            'title' => 'The Customer is responsible for any taxes due in _________________ as a result of this work.',
            'input' => true,
            'input_value' => "",
            'selected' => false,
        ],
    ];

    public $base = [
        'area' => [
            'title' => 'Area to be approximately: _____________',
            'input' => true,
            'input_value' => "",
            'selected' => true,
            'checkbox' => false,
        ],
        'provide_cleared_site' => [
            'title' => 'The Customer will provide a cleared site with proper fill.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'grade_sub_base' => [
            'title' => 'The Contractor will grade the sub-base to slope one inch in ten feet for drainage.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'limerock_base' => [
            'title' => 'The Contractor will put in a six inch compacted to four inch limerock base rolled and compressed to grade.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'asphalt_rolled' => [
            'title' => 'The Contractor will install one inch of asphalt rolled to a smooth finish to grade.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'low_spots' => [
            'title' => 'The Contractor will test for low spots and correct those deeper than one sixteenth of an inch.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'finished_asphalt' => [
            'title' => 'The Customer will furnish a finished asphalt area with proper slope and drainage.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'note' => [
            'title' => 'Note: Additional fill required will be on a time and material basis.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
    ];

    public $court_preparation = [
        'area' => [
            'title' => 'Area to be approximately: 60’ x 120’.',
            'input' => false,
            'input_value' => "",
            'selected' => true,
            'checkbox' => false,
        ],
        'clean_court' => [
            'title' => 'The Contractor will pressure clean court(s) as necessary.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'patch_puddles' => [
            'title' => 'The Contractor will patch puddles within one eighth of an inch.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'patch_cracks' => [
            'title' => 'The Contractor will patch existing cracks with highly flexible APT Qualicaulk.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'patch_root_damaged' => [
            'title' => 'The Contractor will patch root damaged asphalt (inside fence line).',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'root_pruning' => [
            'title' => 'The Contractor recommends root pruning to prevent further root damage.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
    ];

    public $surfacing = [
        'laykold_nusurf' => [
            'title' => '(___) coat(s) LAYKOLD NuSurf.',
            'input' => true,
            'input_value' => "",
            'selected' => true,
            'checkbox' => false,
        ],
        'laykold_colorflex' => [
            'title' => '(___) coat(s) LAYKOLD Colorflex (Customers choice of standard colors).',
            'input' => true,
            'input_value' => "",
            'selected' => true,
            'checkbox' => false,
        ],
        'deco_cushion' => [
            'title' => '(___) coat(s) DECO Cushion, ______ gallons.',
            'input' => true,
            'multiple_inputs' => [
                'coats' => [
                    'title' => 'coats',
                    'value' => ""
                ],
                'gallons' => [
                    'title' => 'gallons',
                    'value' => ""
                ]
            ],
            'input_value' => "",
            'selected' => true,
            'checkbox' => false,
        ],
        'two_tone_surface' => [
            'title' => 'Two-tone surface, inbound and apron, with full individual color through each color coat, is included in the fee below.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'paint_playing_lines' => [
            'title' => 'The Contractor will paint two inch white playing lines to meet U.S.T.A. specifications (three inch base lines).',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'line_for_tennis' => [
            'title' => 'The Contractor will line for tennis to meet U.S.T.A. specifications. ',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'line_for_basketball' => [
            'title' => 'The Contractor will line for basketball.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'line_for_pickleball' => [
            'title' => 'The Contractor will line for pickleball to meet U.S.A.P.A specifications.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'install_agile' => [
            'title' => "The Contractor will install the AGILE TURF Surface, green as per manufacturer's specifications, including approximately (18) tons of green sand. 
            AGILE TURF has a five year manufacturer's warranty.",
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
    ];

    public $fence = [
        'install_pipe' => [
            'title' => 'The Contractor will install heavy duty SS 40 galvanized pipe framework with 3 inch O.D. terminal posts, 2-1/2 inch O.D. line posts, 1-5/8 inch O.D. top rail, and 1-5/8 inch O.D. bottom rail.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'high_fence' => [
            'title' => 'The Contractor will install 10’ high fence; zinc coated heavy duty steel wire chain link with a green or black vinyl coating, (nine / eight / _____) gauge, 1 ¾” (OR_______) mesh, for a total of 216 (OR ________) running feet.',
            'input' => true,
            'multiple_inputs' => [
                'gauge' => [
                    'title' => 'gauge',
                    'value' => ""
                ],
                'mesh' => [
                    'title' => 'mesh',
                    'value' => ""
                ],
                'running_feet' => [
                    'title' => 'running feet',
                    'value' => ""
                ]
            ],
            'input_value' => "",
            'selected' => false,
        ],
        'fence_heavy_duty' => [
            'title' => 'All fence to be heavy duty construction.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'fence_stretch_ends' => [
            'title' => 'Fence to stretch both ends  with diagonal corners with (4) 20 ft. returns. ',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'permacoat_color' => [
            'title' => 'The AMERISTAR Permacoat Color System, black or green fence framework in lieu of galvanized framework, is included in the fee below.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
    ];

    public $lights = [
        'install_lights' => [
            'title' => 'The Contractor will furnish and install (number of lights) BLS (number of watts) watt LED fixtures, mounted on (_____) (_______) ft. high aluminum/steel light poles.',
            'input' => true,
            'multiple_inputs' => [
                'mounted_on' => [
                    'title' => 'mounted on',
                    'value' => ""
                ],
                'ft' => [
                    'title' => 'ft.',
                    'value' => ""
                ],
            ],
            'input_value' => "",
            'selected' => false,
        ],
        'install_wiring' => [
            'title' => 'The Contractor will install all necessary wiring.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'outdoor_junction' => [
            'title' => 'The Contractor will install an outdoor junction box.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'feed_to_bottom' => [
            'title' => 'The Customer is responsible for bringing the feed to the bottom of the poles.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'hookup_feed' => [
            'title' => 'The Contractor will hook-up the feed to the fixtures.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'install_anchor_bolts' => [
            'title' => "The Customer will install the Contractor's anchor bolts. ",
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'furnish_materials' => [
            'title' => 'The Contractor will furnish materials only – Customer is responsible for installation.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
    ];

    public $court_accessories = [
        'net_posts' => [
            'title' => 'The Contractor will install net posts to exceed U.S.T.A. specifications. Posts are 3 inch O.D. heavy duty galvanized steel, with green or black polyurethane powdercoat finish.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'post_sleeves' => [
            'title' => 'Net post sleeves are set in concrete.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'existing_sleeves' => [
            'title' => 'New net posts are set in existing sleeves.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'paint_net_posts' => [
            'title' => 'The Contractor will paint the existing net posts.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'install_agile_net' => [
            'title' => 'The Contractor will install (___) top quality AGILE tennis net(s) to meet U.S.T.A. specifications.',
            'input' => true,
            'input_value' => "",
            'selected' => false,
        ],
        'center_anchor' => [
            'title' => "The Contractor will install (___) center anchor(s). ",
            'input' => true,
            'input_value' => "",
            'selected' => false,
        ],
        'heavy_duty_straps' => [
            'title' => 'The Contractor will install (___) AGILE heavy-duty center strap(s).',
            'input' => true,
            'input_value' => "",
            'selected' => false,
        ],
    ];

    public $fee = [
        'agree_to_provide' => [
            'title' => 'The Contractor agrees to provide tools, materials, labor, supervision, and insurance to complete the above work for a sum of $__________________.',
            'input' => true,
            'input_value' => "",
            'selected' => false,
        ],
        'prices_in_dollars' => [
            'title' => 'All prices are in U.S. Dollars.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'cost_of_permit' => [
            'title' => 'The Customer is responsible for the cost of permit and permit processing.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'fee_to_review' => [
            'title' => 'The fee is subject to review if not accepted within (____________) days.',
            'input' => true,
            'input_value' => "",
            'selected' => false,
        ],
        'date' => [
            'title' => 'This proposal is dated _________________.',
            'input' => true,
            'input_value' => "",
            'selected' => false,
        ],
    ];

    public $provisions = [
        'first_payment' => [
            'title' => 'The Customer agrees to a first payment of $_________________ for Deposit.',
            'input' => true,
            'input_value' => "",
            'selected' => false,
        ],
        'second_payment' => [
            'title' => 'The Customer agrees to a second payment of $_________________ for Commencement of Works.',
            'input' => true,
            'input_value' => "",
            'selected' => false,
        ],
        'final_payment' => [
            'title' => 'The Customer agrees to a final payment of $_________________ within ten days after completion of above work.      ',
            'input' => true,
            'input_value' => "",
            'selected' => false,
        ],
    ];

    public $conditions = [
        'underground' => [
            'title' => 'The Contractor is not responsible for underground that is not marked.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'furnish_access' => [
            'title' => 'The Customer will furnish access to the site for equipment and materials.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'water_supply' => [
            'title' => 'The Customer agrees to provide a clean water supply and an electrical feed at job site for construction purposes.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
        'acts_by_anyone' => [
            'title' => 'The Contractor accepts no responsibility for acts by anyone at job site except for those sub-contracted or employed by Agile Courts Construction Company, Inc.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
    ];

    public $guarantee = [
        'guarantees_work' => [
            'title' => 'The Contractor guarantees all work against defects in workmanship or materials for a period of __________ years. (Contractor cannot guarantee against cracks reflecting through the new surface.)',
            'input' => true,
            'input_value' => "",
            'selected' => false,
        ],
        'no_repairs' => [
            'title' => 'The Contractor accepts no responsibility for repairs done by anyone except Agile Courts Construction Company, Inc.',
            'input' => false,
            'input_value' => "",
            'selected' => false,
        ],
    ];

    public $credit = [
        'right_to_file' => [
            'title' => 'If the Customer does not pay as agreed upon, the Contractor shall have the right to file a lien against the real estate for the amount of the work done. No further work shall be accomplished if installment payments are not made at the time specified. In the event it is necessary to employ the services of an attorney to secure payment, as per the terms of this agreement, then the Customer agrees to pay reasonable attorney fees. Interest of 1-1/2% per month will be charged on accounts past due.',
            'input' => false,
            'input_value' => "",
            'selected' => true,
            'checkbox' => false

        ],
    ];

    protected $rules = [
        'send_proposal_to' => 'required|email',
        'customer_name' => 'required',
        'construction_of' => 'required',
        'signatureData' => 'required',
    ];



    public function mount($proposal)
    {
        // $this->signatureData = $proposal->signature_data;
        $this->proposal = $proposal;
        $this->pid = $proposal->_id;
        $this->work_to_be_performed = $proposal->work_to_be_performed;
        $this->customer = $proposal->customer;
        $this->customer_name = $proposal->customer_name;
        $this->construction_of = $proposal->construction_of;
        $this->send_proposal_to = $proposal->send_proposal_to;
        $this->signatureData = $proposal->signature;
        $this->title = $proposal->title;
        // $this->initSortable();
        
        $this->setValues($proposal->overseas_conditions, "overseas_conditions");
        $this->setValues($proposal->base, "base");
        $this->setValues($proposal->court_preparation, "court_preparation");
        $this->setValues($proposal->surfacing, "surfacing");
        $this->setValues($proposal->fence, "fence");
        $this->setValues($proposal->lights, "lights");
        $this->setValues($proposal->court_accessories, "court_accessories");
        $this->setValues($proposal->fee, "fee");
        $this->setValues($proposal->provisions, "provisions");
        $this->setValues($proposal->conditions, "conditions");
        $this->setValues($proposal->guarantee, "guarantee");
        $this->setValues($proposal->credit, "credit");
    }

    public function updatedSign()
    {
        $this->validateOnly('sign');
    }
    public function clearSignature()
    {
        $this->signatureData  = null;
        $this->emit('signatureCleared');
    }
    public function saveSignature($signatureData)
    {
        $this->signatureData = $signatureData;
        // $this->proposal->signature = $signatureData;
        $this->showSuccessMessage = true;
        $this->dispatchBrowserEvent('resetSuccessMessage');
    }


    public function resetSuccessMessage()
    {
        $this->showSuccessMessage = false;
    }


    public function render()
    {
        return view('livewire.edit-proposal');
    }

    public function submit()
    {


        $this->validate();

        $proposal = Proposal::find($this->proposal->id);
        if ($proposal->signatureData || $this->signatureData) {
            // If the proposal already has a signature or the user has added a new one, proceed with updating
            $this->proposal->update();
        } else {
            // If the proposal doesn't have a signature and the user didn't provide a new one, show an error
            $this->addError('signatureData', 'The signature data field is required.');
        }
        $this->proposal->show_overseas_conditions = $this->show_overseas_conditions;
        $this->proposal->show_base = $this->show_base;
        $this->proposal->show_court_preparation = $this->show_court_preparation;
        $this->proposal->show_surfacing = $this->show_surfacing;
        $this->proposal->show_fence = $this->show_fence;
        $this->proposal->show_lights = $this->show_lights;
        $this->proposal->show_court_accessories = $this->show_court_accessories;
        $this->proposal->show_fee = $this->show_fee;
        $this->proposal->show_provisions = $this->show_provisions;
        $this->proposal->show_conditions = $this->show_conditions;
        $this->proposal->show_guarantee = $this->show_guarantee;
        $this->proposal->show_credit = $this->show_credit;
        $this->proposal->signature = $this->signatureData;

        $this->proposal->save();

        $this->proposal->update([
            'work_to_be_performed' => $this->work_to_be_performed,
            'customer' => $this->customer,
            'customer_name' => $this->customer_name,
            'construction_of' => $this->construction_of,
            'send_proposal_to' => $this->send_proposal_to,
            'overseas_conditions' => $this->overseas_conditions,
            'base' => $this->base,
            'court_preparation' => $this->court_preparation,
            'surfacing' => $this->surfacing,
            'fence' => $this->fence,
            'lights' => $this->lights,
            'court_accessories' => $this->court_accessories,
            'fee' => $this->fee,
            'provisions' => $this->provisions,
            'conditions' => $this->conditions,
            'guarantee' => $this->guarantee,
            'credit' => $this->credit,
            'signature' => $this->signatureData,
            'heading' => $this->heading,
                'overseas_conditions_heading' => $this->overseas_conditions_heading,
                'base_heading' => $this->base_heading,
                'court_preparation_heading' => $this->court_preparation_heading,
                'surfacing_heading' => $this->surfacing_heading,
                'fence_heading' => $this->fence_heading,
                'lights_heading' => $this->lights_heading,
                'court_accessories_heading' => $this->court_accessories_heading,
                'fee_heading' => $this->fee_heading,
                'provisions_heading' => $this->provisions_heading,
                'conditions_heading' => $this->conditions_heading,
                'guarantee_heading' => $this->guarantee_heading,
                'credit_heading' => $this->credit_heading,
        ]);

        DB::commit();

        $this->dispatchBrowserEvent(
            'alert',
            ['type' => 'success',  'message' => 'Proposal Updated Successfully!', 'title' => 'Success']
        );
    }

    public function setValues($array, $key_name)
    {
        foreach ($array as $key => $value) {
            $this->$key_name[$key]['selected'] = $value['selected'];
            if ($value['input']) {
                $this->$key_name[$key]['input_value'] = $value['input_value'];
            }

            if (isset($value['multiple_inputs']) && count($value['multiple_inputs']) > 0) {
                foreach ($value['multiple_inputs'] as $multi_key => $multi_input) {
                    $this->$key_name[$key]['multiple_inputs'][$multi_key]['value'] = $multi_input['value'];
                }
            }
        }
    }

    public function updateTitle()
    {
        $this->validate([
            'title' => 'required|string|max:255',
        ]);

        DB::beginTransaction();

        try {
            $this->proposal->update([
                'titles' => $this->title,
            ]);

            DB::commit();

            session()->flash('success', 'Title Updated Successfully!');
        } catch (Exception $e) {
            DB::rollBack();

            session()->flash('error', 'Error updating title: ' . $e->getMessage());
        }
    }

    public $pid; // Property to store the proposal ID
    // Method to send the PDF as an email
    public function sendPdfEmail()
    {
        // Get the proposal data based on the stored proposal ID ($pid)
        $proposalData = Proposal::find($this->pid);

        if (!$proposalData) {
            return back()->with('error', 'Proposal not found');
        }
        // Generate the PDF using the exportProposal method
        $pdf = $this->exportProposal($this->pid);
        // Extract the recipient email from the proposal data
        $recipientEmail = $proposalData->send_proposal_to;

        // Send the PDF as an email
        Mail::send('email.pdf', ['data' => $proposalData], function ($message) use ($pdf, $recipientEmail) {
            $message->to($recipientEmail, 'Recipient Name')
                ->subject('Your Proposal PDF')
                ->attachData($pdf, 'proposal.pdf');
        });

        $this->dispatchBrowserEvent(
            'alert',
            ['type' => 'success',  'message' => 'Email Sent Successfully!', 'title' => 'Success']
        );
    }

    // Method to export the proposal as a PDF

    public function exportProposal($proposalId)
    {
        $proposal = Proposal::find($proposalId);
        if (!$proposal) {
            return back()->with('error', 'Proposal not found');
        }
        // Generate a logical name for the PDF
        $pdfName = 'proposal_' . Str::slug($proposal->customer_name) . '.pdf';
        // Generate the PDF using the view and proposal data
        $data = Proposal::where('_id', $proposalId)->first();
        if (!$data) {
            return back()->with('error', 'Proposal data not available');
        }
        $imageData = $data['signature'];
        $decodedImage = base64_decode($imageData);

        // Get the data URI for the image
        $imageUri = 'data:image/png;base64,' . base64_encode($decodedImage);

        // Add the data URI to the data array
        $data['signature'] = $imageUri;

        // Load the Blade view
        $view = View::make('proposal.pdf', compact('data'));

        // Get the rendered content
        $pdfContent = $view->render();

        // Create the PDF using Dompdf or any other PDF library you are using
        $pdf = PDF::loadHtml($pdfContent);

        // Output or save the PDF as needed
        return $pdf->stream('proposal.pdf');
        // Apply the conditions for each section

        // Conditions For Overseas Installations
        if (!$data->show_overseas_conditions || $this->checkIfNoItemChecked($data->overseas_conditions)) {
            $pdfContent = $this->removeSectionFromPDF($pdfContent, 'Conditions For Overseas Installations');
        }

        // Base
        if (!$data->show_base || $this->checkIfNoItemChecked($data->base)) {

            $pdfContent = $this->removeSectionFromPDF($pdfContent, 'Base');
        }

        // Court Preparation
        if (!$data->show_court_preparation || $this->checkIfNoItemChecked($data->court_preparation)) {
            $pdfContent = $this->removeSectionFromPDF($pdfContent, 'Court Preparation');
        }

        // Surfacing
        if (!$data->show_surfacing || $this->checkIfNoItemChecked($data->surfacing)) {
            $pdfContent = $this->removeSectionFromPDF($pdfContent, 'Surfacing');
        }

        // Fence
        if (!$data->show_fence || $this->checkIfNoItemChecked($data->fence)) {

            $pdfContent = $this->removeSectionFromPDF($pdfContent, 'Fence');
        }

        // Lights
        if (!$data->show_lights || $this->checkIfNoItemChecked($data->lights)) {

            $pdfContent = $this->removeSectionFromPDF($pdfContent, 'Lights');
        }

        // Court Accessories
        if (!$data->show_court_accessories || $this->checkIfNoItemChecked($data->court_accessories)) {
            $pdfContent = $this->removeSectionFromPDF($pdfContent, 'Court Accessories');
        }

        // Fee
        if (!$data->show_fee || $this->checkIfNoItemChecked($data->fee)) {

            $pdfContent = $this->removeSectionFromPDF($pdfContent, 'Fee');
        }

        // Provisions
        if (!$data->show_provisions || $this->checkIfNoItemChecked($data->provisions)) {

            $pdfContent = $this->removeSectionFromPDF($pdfContent, 'Provisions');
        }

        // Conditions
        if (!$data->show_conditions || $this->checkIfNoItemChecked($data->conditions)) {

            $pdfContent = $this->removeSectionFromPDF($pdfContent, 'Conditions');
        }

        // Guarantee
        if (!$data->show_guarantee || $this->checkIfNoItemChecked($data->guarantee)) {

            $pdfContent = $this->removeSectionFromPDF($pdfContent, 'Guarantee');
        }

        // Credit
        if (!$data->show_credit || $this->checkIfNoItemChecked($data->credit)) {
            $pdfContent = $this->removeSectionFromPDF($pdfContent, 'Credit');
        }

        // Generate the final PDF using the modified content
        $pdf = PDF::loadHtml($pdfContent);

        // Optional: Add headers for PDF download
        $headers = ['Content-Type' => 'application/pdf'];

        // Optional: Download the PDF directly
        return $pdf->download($pdfName, $headers);
    }

    // Helper function to check if any item is checked in a section
    private function checkIfNoItemChecked($section)
    {
        // Check if the $section is an array and not empty
        if (!is_array($section) || empty($section)) {

            return true; // Return true if there are no items in the section
        }

        // Filter the items with a 'checked' key and a truthy value
        $checkedItems = array_filter($section, function ($item) {
            echo "error";
            return isset($item['checked']) && $item['checked'];
        });

        return empty($checkedItems);
    }

    // Helper function to remove a section from the PDF content
    private function removeSectionFromPDF($pdfContent, $sectionHeading)
    {
        // Remove the section heading and the list from the PDF content
        $pdfContent = preg_replace('/<h2>' . $sectionHeading . '<\/h2>[\s\S]*?<\/ul>/', '', $pdfContent);

        return $pdfContent;
    }
}
