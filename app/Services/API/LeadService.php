<?php
namespace App\Services\API;

use App\Models\Product;
use App\Models\City;
use App\Models\Lead;
use App\Models\LeadFormDetail;
use App\Models\LeadsForm;

class LeadService {

    public function uploadLeads($data)
    {
        $errors = [];

        foreach ($data['leads'] as $index => $leadData) {
            try {
                Lead::create([
                    'first_name' => $leadData['first_name'],
                    'last_name' => $leadData['last_name'],
                    'email' => $leadData['email'],
                    'phone' => $leadData['phone'],
                    'alternative_number' => $leadData['alternative_number'],
                    'gender' => $leadData['gender'],
                    'dob' => $leadData['dob'],
                    'marital_status' => $leadData['marital_status'],
                    'address' => $leadData['address'],
                    'age' => $leadData['age'],
                    'company' => $leadData['company'],
                    'lead_status' => '1',
                    'title' => $leadData['title'],
                    'lead_rating' => $leadData['lead_rating'],
                    'website' => $leadData['website'],
                    'lead_owner' => $leadData['lead_owner'],
                    'industry' => $leadData['industry'],
                    'no_of_employee' => $leadData['no_of_employee'],
                    'lead_source' => $leadData['lead_source'],
                    'street' => $leadData['street'],
                    'city' => $leadData['city'],
                    'zip' => $leadData['zip'],
                    'state' => $leadData['state'],
                    'country' => $leadData['country'],
                    'lead_notes' => $leadData['lead_notes']
                ]);
            } catch (\Exception $e) {
                $errors[] = "Error on row $index: " . $e->getMessage();
            }
        }

        return ['status' => empty($errors), 'errors' => $errors];
    }

}