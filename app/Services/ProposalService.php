<?php

namespace App\Services;

use App\Models\Proposal;
use App\Models\Logs;
use App\Models\Lead;
use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProposalService
{
    public function proposalList($request)
    {
        $sql = Proposal::query();
        $data = $request->all();
        if(!empty($data["search"])) {
            $sql->where('subject','like', '%' . $data["search"] . '%');

        }
        if (isset($data['paginate']) && $data['paginate'] == false) {
            return  $sql->orderBy('id', 'DESC')->get();

        } else {
            return  $sql->orderBy('id', 'DESC')->paginate(config('constants.ROW_PER_PAGE'));

        }
    }

    public function addProposal($request)
    {
        $request->validate([
            'subject' => 'required|unique:proposal|max:250',
            'start_date' => 'required',
            'end_date' => 'required',

           
        ]);
        $data = $request->all();

        try {
            return  DB::transaction(function () use ($data) {
                $dataObj                        = new Proposal();
                $dataObj->subject               = $data['subject'];
                $dataObj->customer_id           = $data['customer_id'];
                $dataObj->start_date            = $data['start_date'];
                $dataObj->end_date              = $data['end_date'];
                $dataObj->currency_id           = $data['currency_id'];
                $dataObj->assigned_agent_id     = $data['assigned_agent_id'];
                $dataObj->send_to               = $data['send_to'];
                $dataObj->address               = $data['address'];
                $dataObj->country_id            = $data['country_id'];
                $dataObj->city                  = $data['city'];
                $dataObj->state                 = $data['state'];
                $dataObj->zip_code              = $data['zip_code'];
                $dataObj->send_to_email         = $data['send_to_email'];
                $dataObj->send_to_phone         = $data['send_to_phone'];
                $dataObj->discount              = $data['discount'];
                $dataObj->adjustment            = $data['adjustment'];
                $dataObj->sub_total             = $data['sub_total'];
                $dataObj->total                 = $data['total'];
                $dataObj->status                = $data['status'];

                $dataObj->save();
                
                return (object)[
                    'status'                 => 201,
                    'info'                   => $dataObj->id
                ];

            });


        } catch (Exception $e) {
            return (object)[
                'status'             => 424,
                'error'              => $e->getMessage()
            ];
        }
    }

    public function getLeadsData() {
        return Lead::where('lead_status', 1)->get(['id', 'first_name', 'last_name', 'email', 'phone', 'city', 'state', 'zip', 'country', 'address', 'street']);
    }

    public function save_proposal($request) {


        // handle the profile image separately
        if ($request->hasFile('upload_file')) {
            $fileNameWithExt = $request->file('upload_file')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('upload_file')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            $path = $request->file('upload_file')->move(getcwd() . '/uploads/proposals', $fileNameToStore);

            $data['upload_file'] = $fileNameToStore;
        } else {
            $data['upload_file'] = '';
        }

        $proposal = new Proposal();
        $proposal->subject = $request->subject;
        $proposal->lead_id = $request->lead_id;
        $proposal->first_name = $request->first_name;
        $proposal->company_name = $request->company_name;

        $proposal->address = $request->address;
        $proposal->city = $request->city;
        $proposal->state = $request->state;
        $proposal->country_name = $request->country_name;
        $proposal->zip_code = $request->zip_code;

        $proposal->start_date = $request->start_date;
        $proposal->end_date = $request->end_date;
        $proposal->currency = $request->currency;
        $proposal->status = $request->status;
        $proposal->send_to = $request->send_to;
        $proposal->phone = $request->phone;
        $proposal->price = $request->price;
        $proposal->offer_price = $request->offer_price;
        $proposal->item_name = $request->item_name;
        $proposal->item_description = $request->item_description;
        $proposal->proposal_file_name = $data['upload_file'];

        $proposal->discount = $request->price - $request->offer_price;
        $proposal->tax_percent = $request->tax_percent;
        $proposal->tax_amount = $request->offer_price * $request->tax_percent/100;
        $proposal->total_price = $proposal->tax_amount + $request->offer_price;
        $proposal->status = $request->status;
        $proposal->save();
        return $proposal;

    }

    public function proposal_details($id) {
        return Proposal::findOrFail($id);
    }

    public function update_proposal($request, $id) {

        if ($request->hasFile('upload_file')) {
            $fileNameWithExt = $request->file('upload_file')->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('upload_file')->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            $path = $request->file('upload_file')->move(getcwd() . '/uploads/proposals', $fileNameToStore);

            $data['upload_file'] = $fileNameToStore;
        } else {
            $data['upload_file'] = '';
        }

        $proposal = Proposal::findOrFail($id);
        $proposal->subject = $request->subject;
        $proposal->lead_id = $request->lead_id;
        $proposal->first_name = $request->first_name;
        $proposal->company_name = $request->company_name;

        $proposal->address = $request->address;
        $proposal->city = $request->city;
        $proposal->state = $request->state;
        $proposal->country_name = $request->country_name;
        $proposal->zip_code = $request->zip_code;

        $proposal->start_date = $request->start_date;
        $proposal->end_date = $request->end_date;
        $proposal->currency = $request->currency;
        $proposal->status = $request->status;
        $proposal->send_to = $request->send_to;
        $proposal->phone = $request->phone;
        $proposal->price = $request->price;
        $proposal->offer_price = $request->offer_price;
        $proposal->item_name = $request->item_name;
        $proposal->item_description = $request->item_description;
        
        if($request->upload_file) {
            $proposal->proposal_file_name = $data['upload_file'];
        }

        $proposal->discount = $request->price - $request->offer_price;
        $proposal->tax_percent = $request->tax_percent;
        $proposal->tax_amount = $request->offer_price * $request->tax_percent/100;
        $proposal->total_price = $proposal->tax_amount + $request->offer_price;
        $proposal->status = $request->status;
        $proposal->save();
        return $proposal;

    }

    public function delete_proposal($id)
    {
        $record = Proposal::where('id', $id)->first();
        if (!$record) {
            throw new \Exception('Record not found.');
        }

        $filePath = getcwd() . '/uploads/proposals/' . $record->proposal_file_name;
        if (file_exists($filePath)) {
            @unlink($filePath); //remove the file from the server
        }
        Proposal::where('id', $id)->delete();
    }

}