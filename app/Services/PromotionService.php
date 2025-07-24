<?php

namespace App\Services;

use App\Models\Promotion;

class PromotionService
{
    public function getAllPromotion()
    {
        return Promotion::paginate(config('constants.ROW_PER_PAGE'));
    }

    public function createPromotion($data)
    {
        if (isset($data['file_location'])) {
            // handle the file upload
            $file = $data['file_location'];
            $fileNameWithExt = $file->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            // $filePath = $file->storeAs('promotions', $fileNameToStore, 'public');
            //$filePath = $file->move(public_path('uploads/files'), $fileNameToStore);
            $uploadsDir = getcwd() . '/uploads/files';
            $filePath = $file->move($uploadsDir, $fileNameToStore);
            $data['file_location'] = $fileNameToStore;
        } else {
            $data['file_location'] = '';
        }

        return Promotion::create($data);
    }

    public function getPromotionById($id)
    {
        return Promotion::findOrFail($id);
    }

    public function updatePromotion($id, $data)
    {
        $promotion = Promotion::findOrFail($id);

        if (isset($data['file_location'])) {
            //handle the file upload
            $file = $data['file_location'];
            $fileNameWithExt = $file->getClientOriginalName();
            $fileName = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $fileNameToStore = $fileName . '_' . time() . '.' . $extension;
            //$filePath = $file->move(public_path('uploads/files'), $fileNameToStore);
            // Create the uploads/files directory if it doesn't exist
            $uploadsDir = getcwd() . '/uploads/files';
            $filePath = $file->move($uploadsDir, $fileNameToStore);
            $data['file_location'] = $fileNameToStore;

            // delete the old file
            if ($promotion->file_location) {
                $oldFilePath = getcwd() . '/uploads/files/' . $promotion->file_location;
                if (file_exists($oldFilePath)) {
                    @unlink($oldFilePath);
                }
            }
        } else {
            // if no new file is uploaded
            $data['file_location'] = $promotion->file_location;
        }

        $promotion->update($data);

        return $promotion;
    }

    public function searchPromotion($request)
    {
        $searchTerm = trim($request->input('search'));

        $query = Promotion::query();
        //dd($query);die();
        $query->where(function ($q) use ($searchTerm) {
            $q->where('promotion_title', 'LIKE', '%' . $searchTerm . '%');
        });

        return $query->paginate(config('constants.ROW_PER_PAGE'));
    }


    public function deletePromotion($id)
    {
        $promotion = Promotion::findOrFail($id);
        if ($promotion->file_location) {
            $imagePath = getcwd() . '/uploads/files/' . $promotion->file_location;
            if (file_exists($imagePath)) {
                @unlink($imagePath);
            }
        }
        $promotion->delete();
    }
}
