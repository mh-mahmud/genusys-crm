<?php

namespace App\Services;

use App\Models\Campaign;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\CampaignData;
use App\Models\EmailTemplate;
use App\Models\SmsTemplate;
use App\Models\EmailQueue;
use App\Models\SmsQueue;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;


class CampaignService
{
    public function getAllCampaign_backup()
    {
        return Campaign::leftJoin('promotions', 'campaigns.promotion_id', '=', 'promotions.id')
            ->select('campaigns.*', 'promotions.promotion_title')
            ->paginate(config('constants.ROW_PER_PAGE'));
    }

    public function getAllCampaign()
    {
        
        //return Campaign::paginate(config('constants.ROW_PER_PAGE'));
        if (Auth::user()->user_type !== 'admin') {
            return Campaign::where('created_by', Auth::user()->id)->orderBy('id', 'desc')->paginate(config('constants.ROW_PER_PAGE'));
            
        } else {
            return Campaign::paginate(config('constants.ROW_PER_PAGE'));
          
        }
    }



    public function createCampaign($data)
    {
        $data['created_by'] = auth()->id();
        return Campaign::create($data);
    }

    public function getCampaignById($id)
    {
        return Campaign::findOrFail($id);
    }

    public function getCampaignByPromotionName($id)
    {
        return  Campaign::leftJoin('promotions', 'campaigns.promotion_id', '=', 'promotions.id')
        ->select('campaigns.*', 'promotions.promotion_title')
        ->where('campaigns.id', $id)
            ->first();
    }

    public function getCampaignDetailsID($id)
    {
        return Campaign::where('id', $id)->first();
    }
    


    public function updateCampaign($id, $data)
    {
        $campaign = Campaign::findOrFail($id);
        $data['created_by'] = auth()->id();
        $campaign->update($data);
        return $campaign;
    }

    public function searchCampaign($request)
    {
        $searchTerm = trim($request->input('search'));

        $query = Campaign::query();
        //dd($query);die();
        $query->where(function($q) use ($searchTerm) {
            $q->where('campaign_title', 'LIKE', '%' . $searchTerm . '%');
        });

        return $query->paginate(config('constants.ROW_PER_PAGE'));
    }


    public function deleteCampaign_backup($id)
    {
        $promotion = Campaign::findOrFail($id);
        $promotion->delete();
    }

    public function deleteCampaign($id)
    {
        $campaign = Campaign::findOrFail($id);
        CampaignData::where('campaign_id', $id)->delete();
        $campaign->delete();
    }


    public function campaign_lead_upload_file_backup_12012024(Request $request)
    {
        // custom validation messages show
        $messages = [
            'fileUpload.required' => 'The file upload is required.',
            'fileUpload.file' => 'The uploaded file must be a valid file.',
            'fileUpload.mimes' => 'The uploaded file must be a file of type: csv',
        ];

        // Validate the request
        $validator = Validator::make($request->all(), [
            //'fileUpload' => 'required|file|mimes:csv,txt',
            'fileUpload' => 'required|file|mimes:csv,txt,xls,xlsx',
        ], $messages);

        if ($validator->fails()) {
            //validation error messages show
            $errorMessages = implode(' ', $validator->errors()->all());
            return ['error' => $errorMessages];
        }

        $dataInserted = false;

        // handle the file upload in csv
        if ($request->hasFile('fileUpload')) {
            $file = $request->file('fileUpload');
            $path = $file->getRealPath();

            // Open the file and read
            $handle = fopen($path, 'r');
            if ($handle !== false) {
                // read the 1st line (headers)
                $headers = fgetcsv($handle);

                // chk if the CSV header matches the expected values
                if (($request->template_type == 'Email' && $headers[0] !== 'Email') ||
                    ($request->template_type == 'SMS' && $headers[0] !== 'Phone')) {
                    fclose($handle);
                    return ['error' => 'File heading format is wrong.'];
                }

                $validData = [];
                $seenEmails = [];
                $seenPhones = [];
                $duplicateEmails = [];
                $duplicatePhones = [];

                while (($data = fgetcsv($handle, 1000, ',')) !== false) {
                    if ($request->template_type == 'Email' && count($data) == 1 && $headers[0] == 'Email') {
                        if (in_array($data[0], $seenEmails)) {
                            $duplicateEmails[] = $data[0];
                        } else {
                            $seenEmails[] = $data[0];
                            $validData[] = ['email' => $data[0]];
                        }
                    } elseif ($request->template_type == 'SMS' && count($data) == 1 && $headers[0] == 'Phone') {
                        $phone = '0' . $data[0];
                        if (in_array($phone, $seenPhones)) {
                            $duplicatePhones[] = $phone;
                        } else {
                            $seenPhones[] = $phone;
                            $validData[] = ['phone' => $phone];
                        }
                    }
                }
                fclose($handle);

                if (!empty($duplicateEmails) || !empty($duplicatePhones)) {
                    $duplicateMessages = [];
                    if (!empty($duplicateEmails)) {
                        $duplicateMessages[] = 'Duplicate Email: ' . implode(', ', $duplicateEmails);
                    }
                    if (!empty($duplicatePhones)) {
                        $duplicateMessages[] = 'Duplicate Phone Number: ' . implode(', ', $duplicatePhones);
                    }
                    return ['error' => implode('. ', $duplicateMessages)];
                }

                if (!empty($validData)) {
                    try{
                    foreach ($validData as $entry) {
                        $csv_id = str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT);
                        if (isset($entry['email'])) {
                            CampaignData::create([
                                'email' => $entry['email'],
                                'email_template_id' => $request->input('email_template_id'),
                                'campaign_id' => $request->input('campaign_id'),
                                'csv_id' => $csv_id,
                                'status' => config('constants.campaign_status.Pending'),
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        } elseif (isset($entry['phone'])) {
                            CampaignData::create([
                                'phone' => $entry['phone'],
                                'sms_template_id' => $request->input('sms_template_id'),
                                'campaign_id' => $request->input('campaign_id'),
                                'csv_id' => $csv_id,
                                'status' => config('constants.campaign_status.Pending'),
                                'created_at' => now(),
                                'updated_at' => now(),
                            ]);
                        }
                    }
                    $dataInserted = true;
                    }
                    catch (\Illuminate\Database\QueryException $e) {
                        //chk for duplicate entry error
                        if ($e->errorInfo[1] == 1062) {
                            $errorMessage = $e->getMessage();
                          //duplicate entry value  phone number or email from the error message
                            preg_match("/Duplicate entry '([^']+)'/", $errorMessage, $matches);
                           if (!empty($matches[1])) {
                                $duplicateValue = $matches[1];
                                //custom the error message based on the field
                                if (isset($entry['phone']) && $entry['phone'] == $duplicateValue) {
                                    return ['error' => "Duplicate phone number: $duplicateValue"];
                                } elseif (isset($entry['email']) && $entry['email'] == $duplicateValue) {
                                    return ['error' => "Duplicate email address: $duplicateValue"];
                                }
                            }
                    
                            //common duplicate entry error if value is not extracted
                            return ['error' => 'Duplicate entry detected: ' . $errorMessage];
                        }
                        //handle other database errors
                        return ['error' => 'Database error: ' . $e->getMessage()];
                    }
                }

                if (!$dataInserted) {
                    return ['error' => 'No CSV data found.'];
                }

                return ['success' => 'File uploaded and data inserted successfully.'];
            } else {
                return ['error' => 'Failed to open the uploaded file.'];
            }
        }

        return ['error' => 'No file was uploaded.'];
    }




    public function campaign_lead_upload_file(Request $request)
    {
        // validation messages
        $messages = [
            'fileUpload.required' => 'The file upload is required.',
            'fileUpload.file' => 'The uploaded file must be a valid file.',
            'fileUpload.mimes' => 'The uploaded file must be a file of type: csv',
        ];

        //validate the request
        $validator = Validator::make($request->all(), [
            //'fileUpload' => 'required|file|mimes:csv,txt,xls,xlsx',
            'fileUpload' => 'required|file|mimes:csv,txt,xls,xlsx',
        ], $messages);

        if ($validator->fails()) {
            $errorMessages = implode(' ', $validator->errors()->all());
            return ['error' => $errorMessages];
        }

        if (!$request->hasFile('fileUpload')) {
            return ['error' => 'No file was uploaded.'];
        }

        $file = $request->file('fileUpload');
        $path = $file->getRealPath();
        $handle = fopen($path, 'r');

        if ($handle === false) {
            return ['error' => 'Failed to open the uploaded file.'];
        }

        //read the first line headers
        $headers = fgetcsv($handle);

        if (($request->template_type == 'Email' && $headers[0] !== 'Email') ||
            ($request->template_type == 'SMS' && $headers[0] !== 'Phone')
        ) {
            fclose($handle);
            return ['error' => 'File heading format is wrong.'];
        }

        $validData = [];
        $duplicateEmails = [];
        $duplicatePhones = [];

        $seenEmails = [];
        $seenPhones = [];

        $campaignId = $request->input('campaign_id');

        //query existing data in the database for this campaign
        $existingEmails = CampaignData::where('campaign_id', $campaignId)->pluck('email')->toArray();
        $existingPhones = CampaignData::where('campaign_id', $campaignId)->pluck('phone')->toArray();

        while (($data = fgetcsv($handle, 1000, ',')) !== false) {
            if ($request->template_type == 'Email' && count($data) == 1 && $headers[0] == 'Email') {
                $email = $data[0];
                if (in_array($email, $seenEmails) || in_array($email, $existingEmails)) {
                    $duplicateEmails[] = $email;
                } else {
                    $seenEmails[] = $email;
                    $validData[] = ['email' => $email];
                }
            } elseif ($request->template_type == 'SMS' && count($data) == 1 && $headers[0] == 'Phone') {
                $phone = '0' . $data[0];
                if (in_array($phone, $seenPhones) || in_array($phone, $existingPhones)) {
                    $duplicatePhones[] = $phone;
                } else {
                    $seenPhones[] = $phone;
                    $validData[] = ['phone' => $phone];
                }
            }
        }

        fclose($handle);

        if (!empty($duplicateEmails) || !empty($duplicatePhones)) {
            $duplicateMessages = [];
            if (!empty($duplicateEmails)) {
                $duplicateMessages[] = 'Duplicate Emails: ' . implode(', ', $duplicateEmails);
            }
            if (!empty($duplicatePhones)) {
                $duplicateMessages[] = 'Duplicate Phone Numbers: ' . implode(', ', $duplicatePhones);
            }
            return ['error' => implode('. ', $duplicateMessages)];
        }

        if (empty($validData)) {
            return ['error' => 'No valid data found in the uploaded file.'];
        }

        foreach ($validData as $entry) {
            $csv_id = str_pad(mt_rand(1, 9999999999), 10, '0', STR_PAD_LEFT);
            if (isset($entry['email'])) {
                CampaignData::create([
                    'email' => $entry['email'],
                    'email_template_id' => $request->input('email_template_id'),
                    'campaign_id' => $campaignId,
                    'csv_id' => $csv_id,
                    'status' => config('constants.campaign_status.Pending'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            } elseif (isset($entry['phone'])) {
                CampaignData::create([
                    'phone' => $entry['phone'],
                    'sms_template_id' => $request->input('sms_template_id'),
                    'campaign_id' => $campaignId,
                    'csv_id' => $csv_id,
                    'status' => config('constants.campaign_status.Pending'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        return ['success' => 'File uploaded and data inserted successfully.'];
    }



    public function getAllCampaignData($id)
    {
        return CampaignData::join('campaigns', 'campaign_data.campaign_id', '=', 'campaigns.id')
            ->where('campaign_data.campaign_id', $id)
            ->select('campaign_data.*', 'campaigns.campaign_title as campaign_title')
            ->paginate(config('constants.ROW_PER_PAGE'));
    }


    public function startCampaign($id)
    {
        $campaign_type = Campaign::findOrFail($id);
        $campaign = CampaignData::where('campaign_id', $id)->get();
        $campaign_template_id = CampaignData::where('campaign_id', $id)->first();
        $email_template = EmailTemplate::where('id', $campaign_template_id->email_template_id)->first();
        $sms_template = SmsTemplate::where('id', $campaign_template_id->sms_template_id)->first();

        if ($campaign->isEmpty()) {
            throw new \Exception('Campaign not found.');
        }

        $emailCount = 0;
        $smsCount = 0;

        if ($campaign_type->template_type == 'Email') {
            $hasEmails = false;

            foreach ($campaign as $emails) {
                if ($emails->email) {
                    $hasEmails = true;
                    try {
                        //Mail::to($emails->email)->queue(new BulkEmail($email_template->email_subject, $email_template->email_content));
                        $dataObj                    = new EmailQueue();
                        $dataObj->email_from        = "Genuity";
                        $dataObj->campaign_id       = $id;
                        $dataObj->email_to          = $emails->email; 
                        $dataObj->csv_id            = $emails->csv_id; 
                        $dataObj->email_subject     = $email_template->email_subject;
                        $dataObj->email_content     = $email_template->email_content;
                        $dataObj->log_time          = Carbon::now();
                        $dataObj->user_id           = auth()->id();
                        //$dataObj->delivery_time     = Carbon::now();
                        $dataObj->send_status       = config('constants.campaign_status.Pending');
                        $dataObj->save();
                        $emailCount++;
                    } catch (\Exception $e) {
                        return redirect()->route('campaign-index')->with('error', 'Failed to send email: ' . $e->getMessage());
                    }
                }
            }

            if (!$hasEmails) {
                return redirect()->route('campaign-index')->with('error', 'No email addresses found for the campaign.');
            }
        } elseif ($campaign_type->template_type == 'SMS') {
            $hasPhones = false;

            foreach ($campaign as $phones) {
                if ($phones->phone) {
                    $hasPhones = true;
                    try {
                        $dataObj = new SmsQueue();
                        $dataObj->sms_from = config('constants.SMS_SEND_MOBILE_NO');
                        $dataObj->campaign_id       = $id;
                        $dataObj->sms_to = $phones->phone;
                        $dataObj->csv_id = $phones->csv_id;
                        $dataObj->sms_text = $sms_template->description;
                        $dataObj->log_time = Carbon::now();
                        $dataObj->user_id           = auth()->id();
                        //$dataObj->user_id = Auth::id();
                        $dataObj->send_status = config('constants.campaign_status.Pending');
                        $dataObj->save();
                        $smsCount++;
                    } catch (\Exception $e) {
                        return redirect()->route('campaign-index')->with('error', 'Failed to send SMS: ' . $e->getMessage());
                    }
                }
            }

            if (!$hasPhones) {
                return redirect()->route('campaign-index')->with('error', 'No phone numbers found for the campaign.');
            }
        }

        CampaignData::where('campaign_id', $id)->delete();

        $successMessage = 'Campaign completed successfully.';
        if ($emailCount > 0) {
            $successMessage .= " Sent $emailCount emails.";
        }
        if ($smsCount > 0) {
            $successMessage .= " Sent $smsCount SMS messages.";
        }

        return $successMessage;
    }

    public function stopCampaign($id)
    {
        $campaign_type = Campaign::findOrFail($id);
        $campaign_email_queue = EmailQueue::where('campaign_id', $id)->get();
        $campaign_sms_queue = SmsQueue::where('campaign_id', $id)->get();

        if ($campaign_email_queue->isEmpty() && $campaign_sms_queue->isEmpty()) {
            throw new \Exception('Campaign not found.');
        }

        $emailCount = 0;
        $smsCount = 0;
        if ($campaign_type->template_type == 'Email') {
            $hasEmails = false;

            foreach ($campaign_email_queue as $emails) {
                if ($emails->email_to) {
                    $hasEmails = true;
                    try {
                        //Mail::to($emails->email)->queue(new BulkEmail($email_template->email_subject, $email_template->email_content));
                        $dataObj                    = new CampaignData();
                        //$dataObj->email_from        = "Genuity";
                        $dataObj->campaign_id       = $id;
                        $dataObj->email             = $emails->email_to;
                        $dataObj->email_template_id = $campaign_type->email_template_id;
                        $dataObj->csv_id            = $emails->csv_id;
                        //$dataObj->email_content     = $email_template->email_content;
                        //$dataObj->log_time          = Carbon::now();
                        //$dataObj->delivery_time     = Carbon::now();
                        $dataObj->status       = config('constants.campaign_status.Pending');
                        $dataObj->save();
                        $emailCount++;
                    } catch (\Exception $e) {
                        return redirect()->route('campaign-index')->with('error', 'Failed to send email: ' . $e->getMessage());
                    }
                }
            }

            if (!$hasEmails) {
                return redirect()->route('campaign-index')->with('error', 'No email addresses found for the campaign.');
            }
        } elseif ($campaign_type->template_type == 'SMS') {
            $hasPhones = false;

            foreach ($campaign_sms_queue as $phones) {
                if ($phones->sms_to) {
                    $hasPhones = true;
                    try {
                        $dataObj = new CampaignData();
                        $dataObj->campaign_id       = $id;
                        //$dataObj->sms_from = config('constants.SMS_SEND_MOBILE_NO');
                        $dataObj->phone = $phones->sms_to;
                        $dataObj->sms_template_id = $campaign_type->sms_template_id;
                        $dataObj->csv_id            = $phones->csv_id;
                        //$dataObj->email_content     = $email_template->email_content;
                        //$dataObj->log_time          = Carbon::now();
                        //$dataObj->delivery_time     = Carbon::now();
                        $dataObj->status       = config('constants.campaign_status.Pending');
                        $dataObj->save();
                        $smsCount++;
                    } catch (\Exception $e) {
                        return redirect()->route('campaign-index')->with('error', 'Failed to send SMS: ' . $e->getMessage());
                    }
                }
            }

            if (!$hasPhones) {
                return redirect()->route('campaign-index')->with('error', 'No phone numbers found for the campaign.');
            }
        }
        if ($campaign_type->template_type == 'Email') {
            EmailQueue::where('campaign_id', $id)->delete();
        } elseif ($campaign_type->template_type == 'SMS') {
            SmsQueue::where('campaign_id', $id)->delete();
        }

        $successMessage = 'Campaign stopped successfully.';
        if ($emailCount > 0) {
            $successMessage .= " Stopped $emailCount emails.";
        }
        if ($smsCount > 0) {
            $successMessage .= " Stopped $smsCount SMS messages.";
        }

        return $successMessage;
    }



}

